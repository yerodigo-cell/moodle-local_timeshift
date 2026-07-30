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

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'TimeShift Pro';
$string['pagetitle'] = 'Timeshift Pro';
$string['savechanges'] = 'Save Changes';
$string['modulename'] = 'Module';
$string['activityname'] = 'Activity Name';
$string['status'] = 'Status';
$string['visible'] = 'Visible';
$string['hidden'] = 'Hidden';
$string['stealth'] = 'Stealth';
$string['duedate'] = 'Due Date';
$string['allowfromdate'] = 'Open Date';
$string['shiftmodaltitle'] = 'Bulk Shift Dates';
$string['shiftdays'] = 'Add/Subtract Days';
$string['successsaved'] = 'Changes successfully saved.';
$string['errorupdate'] = 'Error updating database records.';
$string['searchbyname'] = 'Search by name';
$string['alltypes'] = 'All types';
$string['shiftmodaltitle_help'] = 'Use this tool to shift all activity dates forward or backward by a specific number of days. This is extremely useful when reusing a course from a previous semester or year.';
$string['pagedescription'] = 'Manage open dates, close dates, and restrictions for all course activities. Use the filters to find specific items or apply changes in bulk.';
$string['allstatuses'] = 'All statuses';
$string['bulkshiftall'] = 'Bulk Shift Dates (All)';
$string['type'] = 'Type';
$string['activity'] = 'Activity';
$string['opendate'] = 'Open Date';
$string['cutoffdate'] = 'Cut-off Date';
$string['restrictions'] = 'Restrictions';
$string['actionsforselected'] = 'Actions for selected';
$string['clearselection'] = 'Clear Selection';
$string['discard'] = 'Discard';
$string['totalactivities'] = 'Total activities:';
$string['activitiesselected_singular'] = ' activity selected';
$string['activitiesselected_plural'] = ' activities selected';
$string['action_shiftdates'] = 'Shift Dates';
$string['action_setallowfromdate'] = 'Set Open Date';
$string['action_setduedate'] = 'Set Due Date';
$string['action_setcutoffdate'] = 'Set Cut-off Date';
$string['action_findreplace'] = 'Find & Replace in Names';
$string['action_changeavailability'] = 'Change Availability';
$string['action_setrestrictions'] = 'Set Restrictions';
$string['action_deleteactivities'] = 'Delete';
$string['modal_shift_warning'] = 'This action will shift the dates for <strong>all {$a} activities</strong>.';
$string['modal_shift_selected_warning'] = 'This action will shift the dates for the <strong>{$a} selected activities</strong>.';
$string['selectwhattoshift'] = 'Select what to shift';
$string['shiftby'] = 'Shift by';
$string['days'] = 'Days';
$string['direction'] = 'Direction';
$string['addtodates'] = 'Add to dates';
$string['subtractfromdates'] = 'Subtract from dates';
$string['example'] = 'Example:';
$string['currentdate'] = 'Current Date:';
$string['newdate'] = 'New Date:';
$string['cancel'] = 'Cancel';
$string['previewchanges'] = 'Preview Changes';
$string['find'] = 'Find';
$string['texttofind'] = 'Text to find...';
$string['replacewith'] = 'Replace with';
$string['replacementtext'] = 'Replacement text...';
$string['applyreplace'] = 'Apply Replace';
$string['newavailability'] = 'New Availability';
$string['newallowfromdate'] = 'New Open Date';
$string['newduedate'] = 'New Due Date';
$string['newcutoffdate'] = 'New Cut-off Date';
$string['apply'] = 'Apply';
$string['modal_delete_title'] = 'Delete Activities';
$string['modal_delete_warning'] = 'Are you sure you want to delete the selected activities? This will permanently remove them from the course and delete all associated student grades and submissions.';
$string['modal_delete_cannot_undo'] = 'This action cannot be undone.';
$string['modal_delete_confirm'] = 'Yes, mark for deletion';
$string['pending_deletion'] = 'Pending Deletion';
$string['privacy:metadata'] = 'The TimeShift Pro plugin does not store any personal data.';
$string['saving'] = 'Saving...';
$string['success'] = 'Success';
$string['weeks'] = 'Weeks';
$string['months'] = 'Months';
$string['action_shift_dates_selected'] = 'This action will shift the dates for the selected activities.';
