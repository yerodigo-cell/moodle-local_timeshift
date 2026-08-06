<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * TimeShift Lite (local_timeshift)
 *
 * @package     local_timeshift
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_timeshift\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * Availability form class
 */
class availability_form extends \core_form\dynamic_form {
    /**
     * Helper to get parameters from customdata (which holds the JS args in Moodle 4.1)
     * or fallback to global optional_param. This fixes the fatal error where
     * $this->optional_param() does not exist in Moodle 4.1 dynamic_form.
     *
     * @param string $name Parameter name
     * @param mixed $default Default value
     * @param string $type Moodle PARAM_ type
     * @return mixed
     */
    private function get_customdata_param(string $name, $default, string $type) {
        // In Moodle 4.1, ModalForm args are serialized and passed as ajaxformdata.
        if (property_exists($this, '_ajaxformdata') && is_array($this->_ajaxformdata) && isset($this->_ajaxformdata[$name])) {
            return clean_param($this->_ajaxformdata[$name], $type);
        }

        // In Moodle 4.2+, they might be in customdata or accessible via optional_param.
        if (method_exists($this, 'optional_param')) {
            return $this->optional_param($name, $default, $type);
        }

        if (isset($this->_customdata) && is_array($this->_customdata) && isset($this->_customdata[$name])) {
            return clean_param($this->_customdata[$name], $type);
        }

        return optional_param($name, $default, $type);
    }

    /**
     * Form definition.
     */
    public function definition() {
        global $DB, $CFG;

        $mform = $this->_form;

        $cmid = $this->get_customdata_param('cmid', 0, PARAM_INT);
        if (!$cmid) {
            $cmid = optional_param('cmid', 0, PARAM_INT);
        }

        $courseid = $this->get_customdata_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        $mform->addElement('hidden', 'cmid', $cmid);
        $mform->setType('cmid', PARAM_INT);

        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);

        $pending = $this->get_customdata_param('pending', null, PARAM_RAW);
        $mform->addElement('hidden', 'pending', $pending);
        $mform->setType('pending', PARAM_RAW);

        $mform->addElement(
            'textarea',
            'availabilityconditionsjson',
            '',
            ['style' => 'display: none;', 'id' => 'id_availabilityconditionsjson']
        );

        global $OUTPUT;
        $loadingcontainer = $OUTPUT->container(
            $OUTPUT->render_from_template('core/loading', []),
            'd-flex justify-content-center py-5 icon-size-5',
            'availabilityconditions-loading'
        );
        $mform->addElement('html', '<div style="min-height: 200px;" id="timeshift-restrictions-container">');
        $mform->addElement('html', $loadingcontainer);

        // Include Javascript for availability UI during rendering.
        if ($courseid && $cmid) {
            $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
            $modinfo = get_fast_modinfo($course);
            $cm = $modinfo->get_cm($cmid);

            // This loads strings and queues YUI modules (which will be stripped).
            \core_availability\frontend::include_all_javascript($course, $cm);

            // MANUALLY RECONSTRUCT COMPONENT PARAMS FOR MOODLE 4.1 YUI INIT.
            // We save this to a class property to inject it during render().
            $pluginmanager = \core_plugin_manager::instance();
            $enabled = $pluginmanager->get_enabled_plugins('availability');

            $yuimodules = ['moodle-core_availability-form'];
            $componentparams = new \stdClass();
            foreach ($enabled as $plugin => $info) {
                $class = '\availability_' . $plugin . '\frontend';
                if (class_exists($class)) {
                    $frontend = new $class();
                    $component = 'availability_' . $plugin;

                    $yuimodules[] = 'moodle-' . $component . '-form';

                    // Bypass protected access via Reflection.
                    $refallowadd = new \ReflectionMethod($class, 'allow_add');
                    $refallowadd->setAccessible(true);
                    $allowadd = $refallowadd->invoke($frontend, $course, $cm, null);

                    $refinitparams = new \ReflectionMethod($class, 'get_javascript_init_params');
                    $refinitparams->setAccessible(true);
                    $initparams = $refinitparams->invoke($frontend, $course, $cm, null);

                    $componentparams->{$plugin} = [
                        $component,
                        $allowadd,
                        $initparams,
                    ];
                }
            }
            $this->_yui_componentparams = $componentparams;
            $this->_yui_modules = $yuimodules;
        }
        $mform->addElement('html', '</div>'); // Close min-height container.
    }

    /**
     * Override render to inject JS after Moodle 4.1 starts collecting JS requirements.
     * In Moodle 4.1, dynamic_form::execute() calls start_collecting_javascript_requirements()
     * AFTER the form is instantiated (and after definition() is run).
     * Any JS added in definition() is completely lost.
     * By adding it in render(), we ensure it gets captured in the AJAX response!
     */
    public function render() {
        global $PAGE;
        if (!empty($this->_yui_componentparams)) {
            $modulesjson = json_encode($this->_yui_modules);

            // Break down strings for PHPCS max line length.
            $strerrjs = '<div class=\"alert alert-danger\" style=\"margin:20px;\">' .
                        '<strong>JS Error:</strong> \' + e.message + \'<br>Stack: \' + e.stack + \'</div>';
            $strerrmsg = '<div class=\"alert alert-danger\" style=\"margin:20px;\">\' + errmsg + \'</div>';
            $strerryuifail = '<div class=\"alert alert-danger\" style=\"margin:20px;\">' .
                             '<strong>YUI Error:</strong> The YUI modules failed to load within 5 seconds. ' .
                             'Modules requested: \' + modules.join(\', \') + \'</div>';
            $strerryui = '<div class=\"alert alert-danger\" style=\"margin:20px;\">YUI Error: \' + e.message + \'</div>';
            $strerrnoyui = '<div class=\"alert alert-danger\" style=\"margin:20px;\">YUI is not defined.</div>';

            $PAGE->requires->js_amd_inline("
                require(['jquery'], function($) {
                    setTimeout(function() {
                        if (typeof YUI !== 'undefined') {
                            var modules = " . $modulesjson . ";
                            var yuiLoaded = false;
                            modules.push(function(Y) {
                                yuiLoaded = true;
                                var M_ok = typeof M !== 'undefined' && M.core_availability &&
                                           M.core_availability.form && typeof M.core_availability.form.init === 'function';
                                if (M_ok) {
                                    try {
                                        M.core_availability.form.init(" . json_encode($this->_yui_componentparams) . ");
                                        $('#availabilityconditions-loading').remove();
                                    } catch (e) {
                                        console.error('Error initializing availability form', e);
                                        $('#timeshift-restrictions-container').html('" . $strerrjs . "');
                                    }
                                } else {
                                    var errmsg = 'M.core_availability.form.init is not available after YUI load.';
                                    console.error(errmsg);
                                    $('#timeshift-restrictions-container').html('" . $strerrmsg . "');
                                }
                            });
                            try {
                                YUI().use.apply(YUI(), modules);
                                setTimeout(function() {
                                    if (!yuiLoaded) {
                                        $('#timeshift-restrictions-container').html('" . $strerryuifail . "');
                                    }
                                }, 5000);
                            } catch(e) {
                                $('#timeshift-restrictions-container').html('" . $strerryui . "');
                            }
                        } else {
                            $('#timeshift-restrictions-container').html('" . $strerrnoyui . "');
                        }
                    }, 200);
                });
            ");
        }
        return parent::render();
    }

    /**
     * Get the context for dynamic submission.
     *
     * @return \contex
     */
    public function get_context_for_dynamic_submission(): \context {
        $courseid = $this->get_customdata_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        if (!$courseid) {
            return \context_system::instance();
        }
        return \context_course::instance($courseid);
    }

    /**
     * Check access for dynamic submission.
     *
     * @throws \moodle_exception
     */
    protected function check_access_for_dynamic_submission(): void {
        $courseid = $this->get_customdata_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        if (!$courseid) {
            throw new \moodle_exception('nopermissionform', 'core_form');
        }
        require_capability('moodle/course:update', $this->get_context_for_dynamic_submission());
    }

    /**
     * Process the dynamic submission.
     *
     * @return array
     */
    public function process_dynamic_submission() {
        global $DB;
        $data = $this->get_data();

        if ($data && isset($data->cmid)) {
            $availability = $data->availabilityconditionsjson ?? null;
            return ['availability' => $availability];
        }

        return ['availability' => null];
    }

    /**
     * Set data for dynamic submission.
     */
    public function set_data_for_dynamic_submission(): void {
        global $DB;
        $cmid = $this->get_customdata_param('cmid', 0, PARAM_INT);
        $pending = $this->get_customdata_param('pending', null, PARAM_RAW);

        if ($pending !== null && $pending !== 'null' && $pending !== '') {
            $this->set_data(['availabilityconditionsjson' => $pending]);
        } else if ($cmid) {
            $cm = $DB->get_record('course_modules', ['id' => $cmid], 'id, availability');
            if ($cm) {
                $this->set_data(['availabilityconditionsjson' => $cm->availability]);
            }
        }
    }

    /**
     * Get the page URL for dynamic submission.
     *
     * @return \moodle_url
     */
    protected function get_page_url_for_dynamic_submission(): \moodle_url {
        $courseid = $this->get_customdata_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        return new \moodle_url('/local/timeshift/index.php', ['courseid' => $courseid]);
    }
}
