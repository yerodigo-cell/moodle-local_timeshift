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
            )
        ]);
    }

    /**
     * Update activities.
     *
     * @param int $courseid
     * @param array $updates
     * @return array
     */
    public static function update_activities($courseid, $updates) {
        global $DB;

        $params = self::validate_parameters(self::update_activities_parameters(), [
            'courseid' => $courseid,
            'updates'  => $updates,
        ]);

        $courseid = $params['courseid'];
        $updates = $params['updates'];

        $context = \context_course::instance($courseid);
        self::validate_context($context);
        require_capability('moodle/course:update', $context);

        $success = true;
        $errormsg = '';

        try {
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
