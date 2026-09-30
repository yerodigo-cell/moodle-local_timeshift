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

namespace local_timeshift;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

/**
 * External functions for local_timeshift.
 */
class external extends \external_api {
    /**
     * Parameters for update_activities
     *
     * @return \external_function_parameters
     */
    public static function update_activities_parameters() {
        return new \external_function_parameters([
            'courseid' => new \external_value(PARAM_INT, 'The course id'),
            'updates'  => new \external_multiple_structure(
                new \external_single_structure([
                    'cmid'          => new \external_value(PARAM_INT, 'The course module id'),
                    'newname'       => new \external_value(PARAM_TEXT, 'The new name of the activity', VALUE_OPTIONAL),
                    'allowfromdate' => new \external_value(PARAM_INT, 'The allow from date', VALUE_OPTIONAL),
                    'duedate'       => new \external_value(PARAM_INT, 'The due date', VALUE_OPTIONAL),
                    'cutoffdate'    => new \external_value(PARAM_INT, 'The cutoff date', VALUE_OPTIONAL),
                ])
            ),
            'reorders' => new \external_value(PARAM_RAW, 'JSON string of reorders', VALUE_DEFAULT, ''),
        ]);
    }

    /**
     * Update activities.
     *
     * @param int $courseid
     * @param array $updates
     * @param string $reorders JSON string of reorder operations
     * @return array
     */
    public static function update_activities($courseid, $updates, $reorders = '') {
        global $DB, $CFG;

        $params = self::validate_parameters(self::update_activities_parameters(), [
            'courseid' => $courseid,
            'updates'  => $updates,
            'reorders' => $reorders,
        ]);

        $courseid = $params['courseid'];
        $updates = $params['updates'];
        $reordersarray = $params['reorders'] ? json_decode($params['reorders'], true) : [];

        $context = \context_course::instance($courseid);
        self::validate_context($context);
        require_capability('moodle/course:manageactivities', $context);

        $success = true;
        $errormsg = '';

        try {
            require_once($CFG->dirroot . '/course/lib.php');
            if (is_array($reordersarray) && !empty($reordersarray)) {
                foreach ($reordersarray as $move) {
                    $cmid = clean_param($move['cmid'], PARAM_INT);
                    if (!$cmid) {
                        continue;
                    }
                    $beforecmid = isset($move['beforecmid']) ? clean_param($move['beforecmid'], PARAM_INT) : 0;

                    $mod = get_coursemodule_from_id('', $cmid, $courseid, true, IGNORE_MISSING);
                    if (!$mod) {
                        continue;
                    }

                    if ($beforecmid) {
                        $beforemod = get_coursemodule_from_id('', $beforecmid, $courseid, true, IGNORE_MISSING);
                        if ($beforemod) {
                            $section = $DB->get_record('course_sections', ['id' => $beforemod->section], '*', IGNORE_MISSING);
                            if ($section) {
                                moveto_module($mod, $section, $beforemod);
                            }
                        }
                    } else {
                        if (isset($move['targetcmid']) && $move['targetcmid'] > 0) {
                            $targetcmid = clean_param($move['targetcmid'], PARAM_INT);
                            $targetmod = get_coursemodule_from_id('', $targetcmid, $courseid, true, IGNORE_MISSING);
                            if ($targetmod) {
                                $section = $DB->get_record('course_sections', ['id' => $targetmod->section], '*', IGNORE_MISSING);
                                if ($section) {
                                    moveto_module($mod, $section, null);
                                }
                            }
                        } else if (isset($move['targetsectionnum']) && $move['targetsectionnum'] >= 0) {
                            $targetsectionnum = clean_param($move['targetsectionnum'], PARAM_INT);
                            $section = $DB->get_record(
                                'course_sections',
                                ['course' => $courseid, 'section' => $targetsectionnum],
                                '*',
                                IGNORE_MISSING
                            );
                            if ($section) {
                                moveto_module($mod, $section, null);
                            }
                        }
                    }
                }
            }
            foreach ($updates as $update) {
                $cmid = $update['cmid'];
                $newname = isset($update['newname']) ? $update['newname'] : '';
                $allowfromdate = isset($update['allowfromdate']) ? $update['allowfromdate'] : null;
                $duedate = isset($update['duedate']) ? $update['duedate'] : null;
                $cutoffdate = isset($update['cutoffdate']) ? $update['cutoffdate'] : null;

                \local_timeshift\manager::update_activity(
                    $cmid,
                    $courseid,
                    $newname,
                    $duedate,
                    $allowfromdate,
                    $cutoffdate
                );
            }
            require_once($CFG->dirroot . '/course/lib.php');
            rebuild_course_cache($courseid, true);
        } catch (\Exception $e) {
            $success = false;
            $errormsg = $e->getMessage();
        }

        return [
            'success' => $success,
            'message' => $errormsg,
        ];
    }

    /**
     * Returns description of method result value
     *
     * @return \external_description
     */
    public static function update_activities_returns() {
        return new \external_single_structure([
            'success' => new \external_value(PARAM_BOOL, 'True if successful'),
            'message' => new \external_value(PARAM_TEXT, 'Error message if failed', VALUE_OPTIONAL),
        ]);
    }
}
