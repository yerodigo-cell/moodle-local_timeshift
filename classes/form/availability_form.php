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
 * TimeShift Pro (local_timeshift)
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
     * Form definition.
     */
    public function definition() {
        global $DB, $CFG;

        $mform = $this->_form;

        $cmid = $this->optional_param('cmid', 0, PARAM_INT);
        if (!$cmid) {
            $cmid = optional_param('cmid', 0, PARAM_INT);
        }

        $courseid = $this->optional_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        $mform->addElement('hidden', 'cmid', $cmid);
        $mform->setType('cmid', PARAM_INT);

        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);

        $pending = $this->optional_param('pending', null, PARAM_RAW);
        $mform->addElement('hidden', 'pending', $pending);
        $mform->setType('pending', PARAM_RAW);

        $mform->addElement(
            'textarea',
            'availabilityconditionsjson',
            '',
            ['class' => 'd-none', 'id' => 'id_availabilityconditionsjson']
        );

        global $OUTPUT;
        $loadingcontainer = $OUTPUT->container(
            $OUTPUT->render_from_template('core/loading', []),
            'd-flex justify-content-center py-5 icon-size-5',
            'availabilityconditions-loading'
        );
        $mform->addElement('html', $loadingcontainer);

        // Include Javascript for availability UI during rendering using a dummy element.
        if ($courseid && $cmid) {
            $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
            $modinfo = get_fast_modinfo($course);
            $cm = $modinfo->get_cm($cmid);

            \MoodleQuickForm::registerElementType(
                'availability_js_injector',
                __DIR__ . '/availability_js_injector.php',
                '\local_timeshift\form\availability_js_injector'
            );

            $injector = $mform->addElement('availability_js_injector', 'js_injector');
            $injector->course = $course;
            $injector->cm = $cm;
        }
    }

    /**
     * Get the context for dynamic submission.
     *
     * @return \context
     */
    public function get_context_for_dynamic_submission(): \context {
        $courseid = $this->optional_param('courseid', 0, PARAM_INT);
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
        $courseid = $this->optional_param('courseid', 0, PARAM_INT);
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
        $cmid = $this->optional_param('cmid', 0, PARAM_INT);
        $pending = $this->optional_param('pending', null, PARAM_RAW);

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
        $courseid = $this->optional_param('courseid', 0, PARAM_INT);
        if (!$courseid) {
            $courseid = optional_param('courseid', 0, PARAM_INT);
        }

        return new \moodle_url('/local/timeshift/index.php', ['courseid' => $courseid]);
    }
}
