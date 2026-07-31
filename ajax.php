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

define('AJAX_SCRIPT', true);
require_once('../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/local/timeshift/classes/manager.php');

$courseid = required_param('courseid', PARAM_INT);
$updates = required_param('updates', PARAM_RAW); // JSON string.

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('moodle/course:update', $context);
require_sesskey();

$updatesarray = json_decode($updates, true);

if (!is_array($updatesarray)) {
    echo json_encode(['error' => true, 'message' => 'Invalid data payload.']);
    die();
}

$success = true;
try {
    foreach ($updatesarray as $update) {
        $cmid = clean_param($update['cmid'], PARAM_INT);
        $modname = clean_param($update['modname'], PARAM_ALPHA);
        $instanceid = clean_param($update['instanceid'], PARAM_INT);
        $newname = clean_param($update['newname'], PARAM_TEXT);

        $duedate = null;
        if (isset($update['duedate']) && $update['duedate'] !== '') {
            $duedate = clean_param($update['duedate'], PARAM_INT);
        }

        $allowfromdate = null;
        if (isset($update['allowfromdate']) && $update['allowfromdate'] !== '') {
            $allowfromdate = clean_param($update['allowfromdate'], PARAM_INT);
        }

        $cutoffdate = null;
        if (isset($update['cutoffdate']) && $update['cutoffdate'] !== '') {
            $cutoffdate = clean_param($update['cutoffdate'], PARAM_INT);
        }

        $status = isset($update['status']) && $update['status'] !== '' ? clean_param($update['status'], PARAM_INT) : null;
        $availability = isset($update['availability']) ? $update['availability'] : null;
        $delete = isset($update['delete']) ? (bool)$update['delete'] : false;
        if ($delete) {
            course_delete_module($cmid);
        } else {
            \local_timeshift\manager::update_activity(
                $cmid,
                $modname,
                $instanceid,
                $newname,
                $duedate,
                $allowfromdate,
                $status,
                $cutoffdate,
                $availability
            );
        }
    }
    // Rebuild the course cache so that name changes and visibility reflect immediately in the UI and Calendar.
    rebuild_course_cache($courseid, true);
} catch (\Throwable $e) {
    $success = false;
    $errormsg = $e->getMessage();
}

if ($success) {
    rebuild_course_cache($courseid, true);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . (isset($errormsg) ? $errormsg : 'Unknown')]);
}
die();
