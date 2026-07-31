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

require_once('../../config.php');
require_once($CFG->dirroot . '/local/timeshift/classes/manager.php');

$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('moodle/course:update', $context);

$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/local/timeshift/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pagetitle', 'local_timeshift'));
$PAGE->set_heading($course->fullname);

$activities = \local_timeshift\manager::get_course_activities($courseid);

echo $OUTPUT->header();

// Start container.
echo '<div class="local-timeshift-container" style="margin: 0 auto 80px auto; max-width: 1600px;">';

$iconurl = new moodle_url('/local/timeshift/pix/icon.jpg');
$iconimg = '<img src="' . $iconurl . '" alt="Timeshift Pro Logo" ' .
           'style="width: 32px; height: 32px; border-radius: 6px; box-shadow: 0px 2px 4px rgba(0,0,0,0.2);">';

echo '<h3 style="display: flex; align-items: center; gap: 12px; font-weight: 800; color: #1e293b;">' .
     $iconimg . ' ' . get_string('pagetitle', 'local_timeshift') . '</h3>';
echo '<p style="color: #6c757d; margin-bottom: 20px;">' . get_string('pagedescription', 'local_timeshift') . '</p>';

// Build a unique list of activity types for the filter dropdown.
$modtypes = [];
foreach ($activities as $act) {
    $modtypes[$act->modname] = $act->modname;
}
asort($modtypes);

// Modal, top buttons, and filters.
echo '<div style="margin-bottom: 20px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">';
echo '<div style="display: flex; gap: 10px; align-items: center;">';
echo '<div style="position: relative; width: 100%; max-width: 250px; min-width: 140px;">';
echo '<input type="text" id="filter-name" class="form-control" placeholder="' . 
     get_string('searchbyname', 'local_timeshift') . '" style="width: 100%; border-radius: 6px;">';
echo '</div>';
echo '<select id="filter-type" class="form-control" style="max-width: 200px; border-radius: 6px;">';
echo '<option value="">' . get_string('alltypes', 'local_timeshift') . '</option>';
foreach ($modtypes as $type) {
    echo '<option value="' . s($type) . '">' . ucfirst(s($type)) . '</option>';
}
echo '</select>';

echo '<select id="filter-status" class="form-control" style="max-width: 150px; border-radius: 6px;">';
echo '<option value="">' . get_string('allstatuses', 'local_timeshift') . '</option>';
echo '<option value="1">' . get_string('visible', 'local_timeshift') . '</option>';
echo '<option value="0">' . get_string('hidden', 'local_timeshift') . '</option>';
global $CFG;
if (!empty($CFG->allowstealth)) {
    echo '<option value="2">' . get_string('stealth', 'local_timeshift') . '</option>';
}
echo '</select>';

echo '<button type="button" id="btn-clear-filters" title="Clear filters" style="display: none;">';
echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' . 
     '<circle cx="12" cy="12" r="12" fill="#292d32"/>' . 
     '<path d="M8.5 8.5L15.5 15.5M15.5 8.5L8.5 15.5" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>' . 
     '</svg>';
echo '</button>';

echo '</div>';

// Bulk Shift All.
echo '<div style="display: flex; align-items: center; gap: 8px; margin-left: auto;">';
echo $OUTPUT->help_icon('shiftmodaltitle', 'local_timeshift');
echo '<button type="button" class="btn btn-timeshift-bulk" id="btn-shift-dates-all" data-toggle="modal" ' . 
     'data-target="#shiftDatesModal" data-bs-toggle="modal" data-bs-target="#shiftDatesModal" ' . 
     'style="border-radius: 6px; font-weight: 500;">' . get_string('bulkshiftall', 'local_timeshift') . '</button>';
echo '</div>';

echo '</div>';

// Bulk Actions Toolbar (hidden by default until items are selected)
echo '<div id="bulk-actions-toolbar" style="display: none; margin-bottom: 20px; padding: 15px 20px; background: #e7f1ff; border: 1px solid #b6d4fe; border-radius: 8px; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15); align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; transition: all 0.3s ease;">';
echo '  <div style="display: flex; align-items: center; gap: 15px;">';
echo '    <span id="selected-count" style="font-weight: 700; color: #084298; font-size: 1.05em;">' . get_string('activitiesselected', 'local_timeshift', 0) . '</span>';
echo '    <div class="dropdown">';
echo '      <button class="btn btn-primary dropdown-toggle" type="button" id="bulkActionsDropdown" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 6px; font-weight: 500; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);">';
echo '        ' . get_string('actionsforselected', 'local_timeshift') . '
      </button>';
echo '      <div class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#shiftDatesModal" data-bs-toggle="modal" data-bs-target="#shiftDatesModal" id="action-shift-dates">' . get_string('action_shiftdates', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#setAllowFromModal" data-bs-toggle="modal" data-bs-target="#setAllowFromModal">' . get_string('action_setallowfromdate', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#setDueDateModal" data-bs-toggle="modal" data-bs-target="#setDueDateModal">' . get_string('action_setduedate', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#setCutoffDateModal" data-bs-toggle="modal" data-bs-target="#setCutoffDateModal">' . get_string('action_setcutoffdate', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#findReplaceModal" data-bs-toggle="modal" data-bs-target="#findReplaceModal" id="action-find-replace">' . get_string('action_findreplace', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changeAvailabilityModal" data-bs-toggle="modal" data-bs-target="#changeAvailabilityModal" id="action-change-availability">' . get_string('action_changeavailability', 'local_timeshift') . '</a>
        <a class="dropdown-item" href="#" id="action-set-restrictions">' . get_string('action_setrestrictions', 'local_timeshift') . '</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#bulkDeleteModal" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal" id="action-delete-activities"><i class="fa fa-trash"></i> ' . get_string('action_deleteactivities', 'local_timeshift') . '</a>
      </div>';
echo '    </div>';
echo '  </div>';
echo '  <div>';
echo '    <button type="button" class="btn btn-timeshift-clear" id="btn-clear-selection" style="border-radius: 6px; font-weight: 500;">' . get_string('clearselection', 'local_timeshift') . ' ✕</button>';
echo '  </div>';
echo '</div>';

// Table
echo '<div class="table-responsive timeshift-table-wrapper">';
echo '<table class="table timeshift-clean-table" id="timeshift-table">';
echo '<thead>';
echo '<tr>';
echo '<th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-checkbox"></th>';
echo '<th>' . get_string('type', 'local_timeshift') . '</th>';
echo '<th>' . get_string('activity', 'local_timeshift') . '</th>';
echo '<th style="width: 1%; white-space: nowrap;"><i class="fa fa-calendar-o" aria-hidden="true" style="margin-right:6px; color:#6c757d;"></i> ' . get_string('opendate', 'local_timeshift') . '</th>';
echo '<th style="width: 1%; white-space: nowrap;"><i class="fa fa-calendar-o" aria-hidden="true" style="margin-right:6px; color:#6c757d;"></i> ' . get_string('duedate', 'local_timeshift') . '</th>';
echo '<th style="width: 1%; white-space: nowrap;"><i class="fa fa-calendar-o" aria-hidden="true" style="margin-right:6px; color:#6c757d;"></i> ' . get_string('cutoffdate', 'local_timeshift') . '</th>';
echo '<th style="width: 1%; white-space: nowrap; text-align: center;">' . get_string('restrictions', 'local_timeshift') . '</th>';
echo '<th>' . get_string('status', 'local_timeshift') . '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($activities as $act) {
    // Format dates for input type datetime-local (YYYY-MM-DDThh:mm)
    $allowfrom = !empty($act->allowfromdate) ? date('Y-m-d\TH:i', $act->allowfromdate) : '';
    $due = !empty($act->duedate) ? date('Y-m-d\TH:i', $act->duedate) : '';
    $cutoff = !empty($act->cutoffdate) ? date('Y-m-d\TH:i', $act->cutoffdate) : '';

    echo '<tr data-cmid="'.$act->cmid.'" data-instance="'.$act->instance.'" data-modname="'.$act->modname.'">';
    echo '<td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="row-checkbox"></td>';

    // Column 1: Type
    echo '<td style="vertical-align: middle;">';
    echo '<div style="display: flex; align-items: center; gap: 10px;">';
    if (!empty($act->iconurl)) {
        // Determine icon color based on Moodle 4 module categories
        $mod_purposes = [
            // Assessment
            'assign' => 'assessment', 'quiz' => 'assessment', 'workshop' => 'assessment', 'certificatebeautiful' => 'assessment', 'coursecertificate' => 'assessment',
            // Communication
            'choice' => 'communication', 'feedback' => 'communication', 'chat' => 'communication', 'bigbluebuttonbn' => 'communication', 'zoom' => 'communication',
            // Content
            'book' => 'content', 'folder' => 'content', 'label' => 'content', 'page' => 'content', 'qbank' => 'content', 'resource' => 'content', 'url' => 'content', 'emubook' => 'content', 'videotrack' => 'content', 'codeframe' => 'content',
            // Collaboration
            'data' => 'collaboration', 'database' => 'collaboration', 'forum' => 'collaboration', 'glossary' => 'collaboration', 'wiki' => 'collaboration', 'diary' => 'collaboration',
            // Interactive content
            'h5pactivity' => 'interactive_content', 'imscp' => 'interactive_content', 'lesson' => 'interactive_content', 'scorm' => 'interactive_content',
            // Administration & Other
            'attendance' => 'administration', 'lti' => 'other',
            // Custom
            'hvp' => 'hvp_black'
        ];
        $purpose_colors = [
            'assessment' => '#fa0086',
            'communication' => '#fe5701',
            'content' => '#00a5ad',
            'collaboration' => '#6f46f7',
            'interactive_content' => '#3c73b8',
            'hvp_black' => '#212529',
            'administration' => '#5d63f6',
            'other' => '#6c757d',
            'default' => '#6c757d'
        ];
        $purpose = isset($mod_purposes[$act->modname]) ? $mod_purposes[$act->modname] : 'default';
        $icon_bg = $purpose_colors[$purpose];

        if ($act->modname === 'hvp') {
            // HVP plugin comes with its own colored square icon, so we don't wrap it or invert it.
            echo '<img src="' . $act->iconurl . '" alt="' . $act->modname . ' icon" style="width: 32px; height: 32px; border-radius: 6px;">';
        } else {
            echo '<div style="background-color: ' . $icon_bg . '; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">';
            echo '<img src="' . $act->iconurl . '" alt="' . $act->modname . ' icon" style="width: 20px; height: 20px; filter: brightness(0) invert(1);">';
            echo '</div>';
        }
    }
    $displayname = isset($act->modfullname) ? $act->modfullname : ucfirst($act->modname);
    // Explicitly handle H5pactivity just in case the localized string still says H5P activity
    if (strtolower($displayname) === 'h5pactivity' || strtolower($displayname) === 'h5p activity') {
        $displayname = 'H5p';
    }
    if ($act->modname === 'label') {
        $displayname = 'Label';
    }
    echo '<span style="font-weight: 500; color: #495057; min-width: 70px;">' . $displayname . '</span>';
    echo '</div>';
    echo '</td>';

    // Column 2: Activity
    echo '<td style="vertical-align: middle;">';
    echo '<input type="text" class="form-control field-name" value="'.s($act->name).'" style="width: 100%; min-width: 120px; max-width: 300px;">';
    echo '</td>';

    // Dates editable for assign/quiz/forum. Others can be extended later.
    if ($act->modname === 'assign' || $act->modname === 'quiz' || $act->modname === 'forum') {
        $allowDisabled = ($act->modname === 'forum');
        $cutoffDisabled = ($act->modname === 'quiz');

        if ($allowDisabled) {
            echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
        } else {
            echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-allowfrom" value="'.$allowfrom.'"></td>';
        }

        echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-duedate" value="'.$due.'"></td>';

        if ($cutoffDisabled) {
            echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
        } else {
            echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-cutoffdate" value="'.$cutoff.'"></td>';
        }
    } else {
        echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
        echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
        echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
    }

    // Restrictions Column
    echo '<td style="vertical-align: middle; text-align: center; white-space: nowrap;">';
    $has_restrictions = !empty($act->availability) && $act->availability !== '{"op":"&","c":[],"showc":[]}';
    if ($has_restrictions) {
        echo '<i class="fa fa-lock text-warning restrictions-icon" title="Has restrictions" style="margin-right: 8px; font-size: 16px;"></i>';
    } else {
        echo '<i class="fa fa-unlock-alt text-muted restrictions-icon" title="No restrictions" style="margin-right: 8px; font-size: 16px; opacity: 0.3;"></i>';
    }
    echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-edit-restrictions" data-cmid="'.$act->cmid.'" data-courseid="'.$courseid.'" title="Edit Restrictions">';
    echo '<i class="fa fa-pencil"></i>';
    echo '</button>';
    echo '</td>';

    // Status Column
    $visibleSelected = ($act->status == 1) ? 'selected' : '';
    $stealthSelected = ($act->status == 2) ? 'selected' : '';
    $hiddenSelected = ($act->status == 0) ? 'selected' : '';

    $statusColor = ($act->status == 1) ? 'background-color: #d4edda; color: #155724;' : (($act->status == 0) ? 'background-color: #e2e3e5; color: #383d41;' : 'background-color: #fff3cd; color: #856404;');

    echo '<td style="vertical-align: middle;"><select class="form-control field-status" style="'.$statusColor.' font-weight: 500;" onchange="this.style.backgroundColor = this.options[this.selectedIndex].style.backgroundColor; this.style.color = this.options[this.selectedIndex].style.color;">';
    echo '<option value="1" ' . $visibleSelected . ' style="background-color: #d4edda; color: #155724;">' . get_string('visible', 'local_timeshift') . '</option>';
    echo '<option value="0" ' . $hiddenSelected . ' style="background-color: #e2e3e5; color: #383d41;">' . get_string('hidden', 'local_timeshift') . '</option>';

    // Only show the Stealth option if allowed globally or if the activity is already stealth
    global $CFG;
    if (!empty($CFG->allowstealth) || $act->status == 2) {
        echo '<option value="2" ' . $stealthSelected . ' style="background-color: #fff3cd; color: #856404;">' . get_string('stealth', 'local_timeshift') . '</option>';
    }

    echo '</select></td>';

    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';

// Table Footer Toolbar
echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; flex-wrap: wrap; gap: 16px;">';

// Left side: Total count
echo '<div style="color: #6c757d; font-size: 14px; font-weight: 500;">';
echo get_string('totalactivities', 'local_timeshift') . ' <span id="total-activities-count">' . count($activities) . '</span>';
echo '</div>';

// Right side: Action buttons
echo '<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">';

// Discard Changes
echo '<button type="button" class="btn btn-outline-secondary" id="btn-discard-changes" style="border-radius: 6px; padding: 8px 16px; font-weight: 500;">' . get_string('discard', 'local_timeshift') . '</button>';

// Save Changes
echo '<button type="button" class="btn btn-timeshift-save" id="btn-save-changes" style="border-radius: 6px; padding: 8px 24px; font-weight: 500;">';
echo get_string('savechanges', 'local_timeshift');
echo '</button>';

echo '</div>'; // End right side actions
echo '</div>'; // End footer toolbar

echo '</div>'; // End container

// Bulk Delete Modal
echo '
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-shift-clean" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
      <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
        <h5 class="modal-title" style="color: #dc3545; font-weight: bold;">
          <i class="fa fa-exclamation-triangle"></i> ' . get_string('modal_delete_title', 'local_timeshift') . '
        </h5>
      </div>
      <div class="modal-body">
        <p>' . get_string('modal_delete_warning', 'local_timeshift') . '</p>
        <p><strong>' . get_string('modal_delete_cannot_undo', 'local_timeshift') . '</strong></p>
      </div>
      <div class="modal-footer" style="border-top: none; padding: 15px 20px;">
        <button type="button" class="btn btn-light" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 6px;">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-danger" id="btn-confirm-bulk-delete" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 6px;">' . get_string('modal_delete_confirm', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

// Shift Dates Modal
echo '
<div class="modal fade" id="shiftDatesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-shift-clean" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa fa-calendar" style="color: #1d4ed8; font-size: 20px;"></i> ' . get_string('shiftmodaltitle', 'local_timeshift') . '
        </h5>
      </div>
      <div class="modal-body">

        <div class="info-box alert alert-primary">
            <i class="fa fa-info-circle" style="margin-top: 3px; font-size: 16px;"></i>
            <span id="shift-modal-count-text">' . get_string('action_shift_dates_selected', 'local_timeshift') . '</span>
        </div>

        <div class="section-title">' . get_string('selectwhattoshift', 'local_timeshift') . '</div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="shift-opt-open" checked>
            <label class="form-check-label" for="shift-opt-open" style="font-weight: normal;">' . get_string('opendate', 'local_timeshift') . '</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="shift-opt-due" checked>
            <label class="form-check-label" for="shift-opt-due" style="font-weight: normal;">' . get_string('duedate', 'local_timeshift') . '</label>
        </div>
        <div class="form-check" style="margin-bottom: 24px;">
            <input class="form-check-input" type="checkbox" id="shift-opt-close" checked>
            <label class="form-check-label" for="shift-opt-close" style="font-weight: normal;">' . get_string('cutoffdate', 'local_timeshift') . '</label>
        </div>

        <div class="section-title">' . get_string('shiftby', 'local_timeshift') . '</div>
        <div style="display: flex; gap: 12px; margin-bottom: 24px;">
            <input type="number" class="form-control" id="shift-amount-input" value="15" min="1" style="width: 100px; border-radius: 6px;">
            <select class="form-control" id="shift-unit-input" style="flex: 1; border-radius: 6px;">
                <option value="days">' . get_string('days', 'local_timeshift') . '</option>
                <option value="weeks">' . get_string('weeks', 'local_timeshift') . '</option>
                <option value="months">' . get_string('months', 'local_timeshift') . '</option>
            </select>
        </div>

        <div class="section-title">' . get_string('direction', 'local_timeshift') . '</div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="shift-direction" id="shift-dir-add" value="add" checked>
            <label class="form-check-label" for="shift-dir-add" style="font-weight: normal;">' . get_string('addtodates', 'local_timeshift') . '</label>
        </div>
        <div class="form-check" style="margin-bottom: 24px;">
            <input class="form-check-input" type="radio" name="shift-direction" id="shift-dir-sub" value="sub">
            <label class="form-check-label" for="shift-dir-sub" style="font-weight: normal;">' . get_string('subtractfromdates', 'local_timeshift') . '</label>
        </div>

        <div class="example-box">
            <div style="font-weight: 600; margin-bottom: 8px; color: #111827;">' . get_string('example', 'local_timeshift') . '</div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span>' . get_string('currentdate', 'local_timeshift') . '</span>
                <span id="shift-ex-current">28/07/2026 08:00</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: 600;">
                <span>' . get_string('newdate', 'local_timeshift') . '</span>
                <span id="shift-ex-new">12/08/2026 08:00</span>
            </div>
        </div>

        <input type="hidden" id="shift-mode" value="all">
      </div>
      <div class="modal-footer" style="margin-top: 16px;">
        <button type="button" class="btn btn-cancel" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary btn-preview-layout" id="btn-apply-shift" data-dismiss="modal" data-bs-dismiss="modal">
            <i class="fa fa-eye"></i> ' . get_string('previewchanges', 'local_timeshift') . '
        </button>
      </div>
    </div>
  </div>
</div>
';

// Find & Replace Modal
echo '
<div class="modal fade" id="findReplaceModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">' . get_string('action_findreplace', 'local_timeshift') . '</h5>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
            <label>' . get_string('find', 'local_timeshift') . '</label>
            <input type="text" class="form-control" id="fr-find-input" placeholder="' . get_string('texttofind', 'local_timeshift') . '">
        </div>
        <div class="form-group mb-2">
            <label>' . get_string('replacewith', 'local_timeshift') . '</label>
            <input type="text" class="form-control" id="fr-replace-input" placeholder="' . get_string('replacementtext', 'local_timeshift') . '">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary" id="btn-apply-findreplace">' . get_string('applyreplace', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

// Change Availability Modal
echo '
<div class="modal fade" id="changeAvailabilityModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">' . get_string('action_changeavailability', 'local_timeshift') . '</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>' . get_string('newavailability', 'local_timeshift') . '</label>
            <select class="form-control" id="ca-status-input">
                <option value="1">' . get_string('visible', 'local_timeshift') . '</option>
                <option value="0">' . get_string('hidden', 'local_timeshift') . '</option>
                <option value="2">' . get_string('stealth', 'local_timeshift') . '</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary" id="btn-apply-availability">' . get_string('apply', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

// Set Allow From Date Modal
echo '
<div class="modal fade" id="setAllowFromModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">' . get_string('action_setallowfromdate', 'local_timeshift') . '</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>' . get_string('newallowfromdate', 'local_timeshift') . '</label>
            <input type="datetime-local" class="form-control" id="set-allowfrom-input">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary" id="btn-apply-allowfrom">' . get_string('apply', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

// Set Due Date Modal
echo '
<div class="modal fade" id="setDueDateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">' . get_string('action_setduedate', 'local_timeshift') . '</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>' . get_string('newduedate', 'local_timeshift') . '</label>
            <input type="datetime-local" class="form-control" id="set-duedate-input">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary" id="btn-apply-duedate">' . get_string('apply', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

// Set Cut-off Date Modal
echo '
<div class="modal fade" id="setCutoffDateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">' . get_string('action_setcutoffdate', 'local_timeshift') . '</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>' . get_string('newcutoffdate', 'local_timeshift') . '</label>
            <input type="datetime-local" class="form-control" id="set-cutoffdate-input">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">' . get_string('cancel', 'local_timeshift') . '</button>
        <button type="button" class="btn btn-primary" id="btn-apply-cutoffdate">' . get_string('apply', 'local_timeshift') . '</button>
      </div>
    </div>
  </div>
</div>
';

?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var strSingular = '<?php echo get_string('activitiesselected_singular', 'local_timeshift'); ?>';
    var strPlural = '<?php echo get_string('activitiesselected_plural', 'local_timeshift'); ?>';

    function showMoodleAlert(title, msg, callback) {
        if (typeof require !== 'undefined') {
            require(['core/notification'], function(Notification) {
                var promise = Notification.alert(title, msg, 'OK');
                if (callback) {
                    if (promise && promise.then) {
                        promise.then(callback).catch(callback);
                    } else {
                        setTimeout(callback, 1500); // Fallback for very old Moodle
                    }
                }
            });
        } else {
            alert(msg);
            if (callback) callback();
        }
    }

    // Filtering logic
    var filterName = document.getElementById('filter-name');
    var filterType = document.getElementById('filter-type');
    var filterStatus = document.getElementById('filter-status');
    var btnClearFilters = document.getElementById('btn-clear-filters');

    function applyFilters() {
        var nameQuery = filterName ? filterName.value.toLowerCase() : '';
        var typeQuery = filterType ? filterType.value.toLowerCase() : '';
        var statusQuery = filterStatus ? filterStatus.value : '';
        var rows = document.querySelectorAll('#timeshift-table tbody tr');

        if (btnClearFilters) {
            if (nameQuery !== '' || typeQuery !== '' || statusQuery !== '') {
                btnClearFilters.style.display = 'flex';
            } else {
                btnClearFilters.style.display = 'none';
            }
        }

        var visibleCount = 0;

        rows.forEach(function(row) {
            var modname = row.getAttribute('data-modname').toLowerCase();
            var nameInput = row.querySelector('.field-name');
            var name = nameInput ? nameInput.value.toLowerCase() : '';
            var statusSelect = row.querySelector('.field-status');
            var status = statusSelect ? statusSelect.value : '';

            var matchName = name.indexOf(nameQuery) > -1;
            var matchType = typeQuery === '' || modname === typeQuery;
            var matchStatus = statusQuery === '' || status === statusQuery;

            if (matchName && matchType && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        var totalActivitiesCount = document.getElementById('total-activities-count');
        if (totalActivitiesCount) {
            totalActivitiesCount.textContent = visibleCount;
        }

        if (typeof updateSelectionState === 'function') {
            updateSelectionState();
        }
    }

    if (filterName) filterName.addEventListener('input', applyFilters);
    if (filterType) filterType.addEventListener('change', applyFilters);
    if (filterStatus) filterStatus.addEventListener('change', applyFilters);

    if (btnClearFilters) {
        btnClearFilters.addEventListener('click', function() {
            if (filterName) filterName.value = '';
            if (filterType) filterType.value = '';
            if (filterStatus) filterStatus.value = '';
            applyFilters();
        });
    }

    // Checkbox and Bulk Actions Toolbar Logic
    var selectAllCheckbox = document.getElementById('select-all-checkbox');
    var rowCheckboxes = document.querySelectorAll('.row-checkbox');
    var bulkActionsToolbar = document.getElementById('bulk-actions-toolbar');
    var selectedCountText = document.getElementById('selected-count');
    var btnClearSelection = document.getElementById('btn-clear-selection');

    function updateSelectionState() {
        var selectedCount = 0;
        var visibleCount = 0;
        var visibleSelectedCount = 0;

        rowCheckboxes.forEach(function(cb) {
            var row = cb.closest('tr');
            if (row.style.display !== 'none') {
                visibleCount++;
                if (cb.checked) {
                    selectedCount++;
                    visibleSelectedCount++;
                }
            } else {
                if (cb.checked) {
                    selectedCount++;
                }
            }
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (visibleCount > 0 && visibleSelectedCount === visibleCount);
            selectAllCheckbox.indeterminate = (visibleSelectedCount > 0 && visibleSelectedCount < visibleCount);
        }

        if (selectedCount > 0) {
            bulkActionsToolbar.style.display = 'flex';
            if (selectedCountText) {
                var text = selectedCount === 1 ? strSingular : strPlural;
                selectedCountText.textContent = selectedCount + text;
            }
        } else {
            bulkActionsToolbar.style.display = 'none';
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            var isChecked = this.checked;
            rowCheckboxes.forEach(function(cb) {
                var row = cb.closest('tr');
                if (row.style.display !== 'none') {
                    cb.checked = isChecked;
                }
            });
            updateSelectionState();
        });
    }

    rowCheckboxes.forEach(function(cb) {
        cb.addEventListener('change', updateSelectionState);
    });

    if (btnClearSelection) {
        btnClearSelection.addEventListener('click', function() {
            rowCheckboxes.forEach(function(cb) {
                cb.checked = false;
            });
            updateSelectionState();
        });
    }

    var courseid = <?php echo json_encode($courseid); ?>;
    var sesskey = (typeof M !== 'undefined' && M.cfg && M.cfg.sesskey) ? M.cfg.sesskey : '';
    var wwwroot = (typeof M !== 'undefined' && M.cfg && M.cfg.wwwroot) ? M.cfg.wwwroot : '';

    // Flag for unsaved changes
    var hasUnsavedChanges = false;

    // Warn user before leaving page if there are unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = ''; // Required for some browsers
        }
    });

    // Helper to mark a field as modified
    function markFieldAsModified(field) {
        if (!field) return;
        var td = field.closest('td');
        if (td) {
            td.classList.add('td-modified');
        }
        hasUnsavedChanges = true;
        var floatingBtn = document.getElementById('floating-save-container');
        if (floatingBtn) floatingBtn.style.display = 'block';
    }

    // Attach listener to all editable fields
    var editableFields = document.querySelectorAll('.field-name, .field-status, .field-allowfrom, .field-duedate, .field-cutoffdate');
    editableFields.forEach(function(field) {
        field.addEventListener('change', function() { markFieldAsModified(this); });
        field.addEventListener('input', function() { markFieldAsModified(this); });
    });

    // Discard Changes Handler
    var btnDiscard = document.getElementById('btn-discard-changes');
    if (btnDiscard) {
        btnDiscard.addEventListener('click', function() {
            if (typeof require !== 'undefined') {
                require(['core/notification'], function(Notification) {
                    Notification.confirm(
                        'Confirm discard',
                        'Are you sure you want to discard all unsaved changes?',
                        'Discard',
                        'Cancel',
                        function() {
                            hasUnsavedChanges = false;
                            window.location.reload();
                        }
                    );
                });
            } else {
                if (confirm('Are you sure you want to discard all unsaved changes?')) {
                    hasUnsavedChanges = false;
                    window.location.reload();
                }
            }
        });
    }

    // Save Changes Handler
    var btnSave = document.getElementById('btn-save-changes');
    if (btnSave) {
        btnSave.addEventListener('click', function() {
            btnSave.disabled = true;
            var originalText = btnSave.innerText;
            btnSave.innerText = '<?php echo get_string('saving', 'local_timeshift'); ?>';

            var updates = [];
            var rows = document.querySelectorAll('#timeshift-table tbody tr');

            rows.forEach(function(row) {
                var cmid = row.getAttribute('data-cmid');
                var instanceid = row.getAttribute('data-instance');
                var modname = row.getAttribute('data-modname');

                var nameInput = row.querySelector('.field-name');
                var statusInput = row.querySelector('.field-status');
                var allowfromInput = row.querySelector('.field-allowfrom');
                var duedateInput = row.querySelector('.field-duedate');
                var cutoffdateInput = row.querySelector('.field-cutoffdate');

                var newname = nameInput ? nameInput.value : '';
                var statusVal = statusInput ? statusInput.value : '';
                var allowval = allowfromInput ? allowfromInput.value : '';
                var dueval = duedateInput ? duedateInput.value : '';
                var cutoffval = cutoffdateInput ? cutoffdateInput.value : '';

                var allowfrom = allowval ? Math.floor(new Date(allowval).getTime() / 1000) : 0;
                var duedate = dueval ? Math.floor(new Date(dueval).getTime() / 1000) : 0;
                var cutoffdate = cutoffval ? Math.floor(new Date(cutoffval).getTime() / 1000) : 0;

                var pendingAvailability = row.getAttribute('data-pending-availability');
                var deleteFlag = row.dataset.delete === "1" ? true : false;

                updates.push({
                    cmid: cmid,
                    instanceid: instanceid,
                    modname: modname,
                    newname: newname,
                    status: statusVal,
                    allowfromdate: allowfrom,
                    duedate: duedate,
                    cutoffdate: cutoffdate,
                    availability: pendingAvailability,
                    delete: deleteFlag
                });
            });

            var xhr = new XMLHttpRequest();
            xhr.open('POST', wwwroot + '/local/timeshift/ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response && response.success) {
                                showMoodleAlert('<?php echo get_string('success', 'local_timeshift'); ?>', '<?php echo get_string('successsaved', 'local_timeshift'); ?>', function() {
                                    hasUnsavedChanges = false;
                                    window.location.reload();
                                });
                            } else {
                                showMoodleAlert('Error', (response && response.message) ? response.message : 'Error updating database records.');
                                btnSave.disabled = false;
                                btnSave.innerText = originalText;
                            }
                        } catch (e) {
                            showMoodleAlert('Error', 'Invalid JSON response from server.');
                            btnSave.disabled = false;
                            btnSave.innerText = originalText;
                        }
                    } else {
                        showMoodleAlert('Error', 'AJAX HTTP Error: ' + xhr.status);
                        btnSave.disabled = false;
                        btnSave.innerText = originalText;
                    }
                }
            };

            var params = 'courseid=' + encodeURIComponent(courseid) +
                         '&updates=' + encodeURIComponent(JSON.stringify(updates)) +
                         '&sesskey=' + encodeURIComponent(sesskey);
            xhr.send(params);
        });
    }

    // Bulk Shift Dates Handler & Modal UI Logic
    var btnShiftDatesAll = document.getElementById('btn-shift-dates-all');
    var actionShiftDates = document.getElementById('action-shift-dates');
    var shiftModeInput = document.getElementById('shift-mode');
    var shiftModalCountText = document.getElementById('shift-modal-count-text');
    var exCurrent = document.getElementById('shift-ex-current');
    var exNew = document.getElementById('shift-ex-new');

    function getSelectedCount() {
        var count = 0;
        document.querySelectorAll('.row-checkbox').forEach(function(cb) {
            var row = cb.closest('tr');
            if (row.style.display !== 'none' && cb.checked) {
                count++;
            }
        });
        return count;
    }

    // Bulk Delete Action Logic
    var strPendingDeletion = '<?php echo get_string('pending_deletion', 'local_timeshift'); ?>';

    var btnConfirmBulkDelete = document.getElementById('btn-confirm-bulk-delete');
    if (btnConfirmBulkDelete) {
        btnConfirmBulkDelete.addEventListener('click', function() {
            var count = 0;
            document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                var row = cb.closest('tr');
                if (row.style.display !== 'none' && cb.checked) {
                    row.dataset.delete = "1";
                    row.classList.add('table-danger');
                    row.classList.add('text-decoration-line-through');

                    var badge = document.createElement('span');
                    badge.className = 'badge bg-danger ms-2';
                    badge.innerText = strPendingDeletion;

                    var nameInputContainer = row.querySelector('.field-name').parentNode;
                    // Prevent adding multiple badges if clicked multiple times
                    if (!nameInputContainer.querySelector('.badge.bg-danger')) {
                        nameInputContainer.appendChild(badge);
                        hasUnsavedChanges = true;
                    }
                    count++;
                }
            });
            if (count > 0) {
                // Ensure floating save button is visible
                var floatingBtn = document.getElementById('floating-save-container');
                if (floatingBtn && count > 0) floatingBtn.style.display = 'block';
            }
        });
    }

    function updateShiftModalUI() {
        var mode = shiftModeInput ? shiftModeInput.value : 'all';
        var count = 0;
        if (mode === 'selected') {
            count = getSelectedCount();
            if (shiftModalCountText) {
                shiftModalCountText.innerHTML = strShiftSelected.replace('{$a}', count);
            }
        } else {
            document.querySelectorAll('#timeshift-table tbody tr').forEach(function(row) {
                if (row.style.display !== 'none') count++;
            });
            if (shiftModalCountText) {
                shiftModalCountText.innerHTML = strShiftAll.replace('{$a}', count);
            }
        }
        updateLiveExample();
    }

    if (btnShiftDatesAll) {
        btnShiftDatesAll.addEventListener('click', function() {
            if (shiftModeInput) shiftModeInput.value = 'all';
            updateShiftModalUI();
        });
    }

    if (actionShiftDates) {
        actionShiftDates.addEventListener('click', function() {
            if (shiftModeInput) shiftModeInput.value = 'selected';
            updateShiftModalUI();
        });
    }

    // Live Example Updater
    var shiftAmountInput = document.getElementById('shift-amount-input');
    var shiftUnitInput = document.getElementById('shift-unit-input');
    var shiftDirAdd = document.getElementById('shift-dir-add');
    var shiftDirSub = document.getElementById('shift-dir-sub');

    function pad(n) { return n < 10 ? '0' + n : n; }
    function formatExampleDate(d) {
        return pad(d.getDate()) + '/' + pad(d.getMonth()+1) + '/' + d.getFullYear() + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    }

    function updateLiveExample() {
        if (!exCurrent || !exNew || !shiftAmountInput) return;

        var baseDate = new Date();
        // find a valid date from table if possible
        var firstValid = document.querySelector('.field-allowfrom, .field-duedate');
        if (firstValid && firstValid.value) {
            baseDate = new Date(firstValid.value);
        }

        exCurrent.innerText = formatExampleDate(baseDate);

        var amt = parseInt(shiftAmountInput.value, 10);
        if (isNaN(amt)) amt = 0;

        var unit = shiftUnitInput ? shiftUnitInput.value : 'days';
        var isSub = shiftDirSub && shiftDirSub.checked;
        if (isSub) amt = -amt;

        var newD = new Date(baseDate.getTime());
        if (unit === 'days') {
            newD.setDate(newD.getDate() + amt);
        } else if (unit === 'weeks') {
            newD.setDate(newD.getDate() + (amt * 7));
        } else if (unit === 'months') {
            newD.setMonth(newD.getMonth() + amt);
        }

        exNew.innerText = formatExampleDate(newD);
    }

    if (shiftAmountInput) shiftAmountInput.addEventListener('input', updateLiveExample);
    if (shiftUnitInput) shiftUnitInput.addEventListener('change', updateLiveExample);
    if (shiftDirAdd) shiftDirAdd.addEventListener('change', updateLiveExample);
    if (shiftDirSub) shiftDirSub.addEventListener('change', updateLiveExample);

    // Preview Changes Button logic
    var btnApply = document.getElementById('btn-apply-shift');
    if (btnApply) {
        btnApply.addEventListener('click', function() {
            var amt = parseInt(shiftAmountInput.value, 10);
            if (isNaN(amt) || amt === 0) return;

            var unit = shiftUnitInput ? shiftUnitInput.value : 'days';
            var isSub = shiftDirSub && shiftDirSub.checked;
            if (isSub) amt = -amt;

            var shiftOpen = document.getElementById('shift-opt-open').checked;
            var shiftDue = document.getElementById('shift-opt-due').checked;
            var shiftClose = document.getElementById('shift-opt-close').checked;

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            var mode = shiftModeInput ? shiftModeInput.value : 'all';

            rows.forEach(function(row) {
                if (mode === 'selected') {
                    var cb = row.querySelector('.row-checkbox');
                    if (!cb || !cb.checked) return;
                }

                var allowField = row.querySelector('.field-allowfrom');
                var dueField = row.querySelector('.field-duedate');
                var cutoffField = row.querySelector('.field-cutoffdate');

                if (shiftOpen && allowField && !allowField.disabled && allowField.value) {
                    var d1 = new Date(allowField.value);
                    if (unit === 'days') d1.setDate(d1.getDate() + amt);
                    else if (unit === 'weeks') d1.setDate(d1.getDate() + (amt * 7));
                    else if (unit === 'months') d1.setMonth(d1.getMonth() + amt);
                    allowField.value = formatDateForInput(d1);
                    markFieldAsModified(allowField);
                }

                if (shiftDue && dueField && !dueField.disabled && dueField.value) {
                    var d2 = new Date(dueField.value);
                    if (unit === 'days') d2.setDate(d2.getDate() + amt);
                    else if (unit === 'weeks') d2.setDate(d2.getDate() + (amt * 7));
                    else if (unit === 'months') d2.setMonth(d2.getMonth() + amt);
                    dueField.value = formatDateForInput(d2);
                    markFieldAsModified(dueField);
                }

                if (shiftClose && cutoffField && !cutoffField.disabled && cutoffField.value) {
                    var d3 = new Date(cutoffField.value);
                    if (unit === 'days') d3.setDate(d3.getDate() + amt);
                    else if (unit === 'weeks') d3.setDate(d3.getDate() + (amt * 7));
                    else if (unit === 'months') d3.setMonth(d3.getMonth() + amt);
                    cutoffField.value = formatDateForInput(d3);
                    markFieldAsModified(cutoffField);
                }
            });
        });
    }

    // Set Allow From Date Handler
    var btnApplyAllowFrom = document.getElementById('btn-apply-allowfrom');
    if (btnApplyAllowFrom) {
        btnApplyAllowFrom.addEventListener('click', function() {
            var newDate = document.getElementById('set-allowfrom-input').value;
            if (!newDate) {
                closeModal('#setAllowFromModal');
                return;
            }

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            rows.forEach(function(row) {
                var cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    var allowField = row.querySelector('.field-allowfrom');
                    if (allowField && !allowField.disabled) {
                        allowField.value = newDate;
                        markFieldAsModified(allowField);
                    }
                }
            });

            closeModal('#setAllowFromModal');
        });
    }

    // Set Due Date Handler
    var btnApplyDueDate = document.getElementById('btn-apply-duedate');
    if (btnApplyDueDate) {
        btnApplyDueDate.addEventListener('click', function() {
            var newDate = document.getElementById('set-duedate-input').value;
            if (!newDate) {
                closeModal('#setDueDateModal');
                return;
            }

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            rows.forEach(function(row) {
                var cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    var dueField = row.querySelector('.field-duedate');
                    if (dueField && !dueField.disabled) {
                        dueField.value = newDate;
                        markFieldAsModified(dueField);
                    }
                }
            });

            closeModal('#setDueDateModal');
        });
    }

    // Set Cut-off Date Handler
    var btnApplyCutoffDate = document.getElementById('btn-apply-cutoffdate');
    if (btnApplyCutoffDate) {
        btnApplyCutoffDate.addEventListener('click', function() {
            var newDate = document.getElementById('set-cutoffdate-input').value;
            if (!newDate) {
                closeModal('#setCutoffDateModal');
                return;
            }

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            rows.forEach(function(row) {
                var cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    var cutoffField = row.querySelector('.field-cutoffdate');
                    if (cutoffField && !cutoffField.disabled) {
                        cutoffField.value = newDate;
                        markFieldAsModified(cutoffField);
                    }
                }
            });

            closeModal('#setCutoffDateModal');
        });
    }

    // Find & Replace Handler
    var btnApplyFindReplace = document.getElementById('btn-apply-findreplace');
    if (btnApplyFindReplace) {
        btnApplyFindReplace.addEventListener('click', function() {
            var findText = document.getElementById('fr-find-input').value;
            var replaceText = document.getElementById('fr-replace-input').value;

            if (findText === '') {
                closeModal('#findReplaceModal');
                return;
            }

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            rows.forEach(function(row) {
                var cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    var nameInput = row.querySelector('.field-name');
                    if (nameInput) {
                        // Case-sensitive replace, global (if multiple occurrences)
                        var regex = new RegExp(findText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                        var oldVal = nameInput.value;
                        nameInput.value = nameInput.value.replace(regex, replaceText);
                        if (oldVal !== nameInput.value) {
                            markFieldAsModified(nameInput);
                        }
                    }
                }
            });

            closeModal('#findReplaceModal');
        });
    }

    // Change Availability Handler
    var btnApplyAvailability = document.getElementById('btn-apply-availability');
    if (btnApplyAvailability) {
        btnApplyAvailability.addEventListener('click', function() {
            var newStatus = document.getElementById('ca-status-input').value;

            var rows = document.querySelectorAll('#timeshift-table tbody tr');
            rows.forEach(function(row) {
                var cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    var statusInput = row.querySelector('.field-status');
                    if (statusInput) {
                        statusInput.value = newStatus;
                        markFieldAsModified(statusInput);
                        // Trigger change event to update the background colors
                        var event = new Event('change');
                        statusInput.dispatchEvent(event);
                    }
                }
            });

            closeModal('#changeAvailabilityModal');
        });
    }

    // ModalForm for Restrictions
    var editRestrictionsBtns = document.querySelectorAll('.btn-edit-restrictions');
    if (editRestrictionsBtns.length > 0 && typeof require !== 'undefined') {
        require(['core_form/modalform'], function(ModalForm) {
            editRestrictionsBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var cmid = parseInt(btn.getAttribute('data-cmid'), 10);
                    var courseid = parseInt(btn.getAttribute('data-courseid'), 10);

                    var pending = btn.closest('tr').getAttribute('data-pending-availability') || null;

                    var form = new ModalForm({
                        formClass: 'local_timeshift\\form\\availability_form',
                        args: { cmid: cmid, courseid: courseid, pending: pending },
                        modalConfig: { title: 'Edit Restrictions' },
                        returnFocus: btn
                    });

                    form.addEventListener(form.events.FORM_SUBMITTED, function(event) {
                        var newAvail = event.detail.availability;
                        var row = btn.closest('tr');
                        var oldAvail = row.getAttribute('data-pending-availability');
                        if (oldAvail !== newAvail) {
                            row.setAttribute('data-pending-availability', newAvail ? newAvail : '');
                            var td = btn.closest('td');
                            if (td) td.classList.add('td-modified');
                        }
                        var icon = row.querySelector('.restrictions-icon');
                        if (icon) {
                            if (newAvail && newAvail !== '{"op":"&","c":[],"showc":[]}' && newAvail !== 'null') {
                                icon.className = 'fa fa-lock text-warning restrictions-icon';
                                icon.title = 'Has pending restrictions';
                                icon.style.opacity = '1';
                            } else {
                                icon.className = 'fa fa-unlock-alt text-muted restrictions-icon';
                                icon.title = 'No restrictions';
                                icon.style.opacity = '0.3';
                            }
                        }
                    });

                    form.show();
                });
            });

            // Bulk Set Restrictions Handler
            var btnBulkRestrictions = document.getElementById('action-set-restrictions');
            if (btnBulkRestrictions) {
                btnBulkRestrictions.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Find first selected cmid to use as context
                    var rows = document.querySelectorAll('#timeshift-table tbody tr');
                    var firstSelectedCmid = null;
                    var courseid = null;

                    rows.forEach(function(row) {
                        var cb = row.querySelector('.row-checkbox');
                        if (cb && cb.checked && !firstSelectedCmid) {
                            firstSelectedCmid = parseInt(row.getAttribute('data-cmid'), 10);
                            var restrictionsBtn = row.querySelector('.btn-edit-restrictions');
                            courseid = parseInt(row.getAttribute('data-courseid') || restrictionsBtn.getAttribute('data-courseid'), 10);
                        }
                    });

                    if (!firstSelectedCmid) {
                        alert('Please select at least one activity to edit restrictions.');
                        return;
                    }

                    var pending = null;
                    var firstRow = document.querySelector('tr[data-cmid="' + firstSelectedCmid + '"]');
                    if (firstRow) pending = firstRow.getAttribute('data-pending-availability') || null;

                    var form = new ModalForm({
                        formClass: 'local_timeshift\\form\\availability_form',
                        args: { cmid: firstSelectedCmid, courseid: courseid, pending: pending },
                        modalConfig: { title: 'Set Bulk Restrictions' }
                    });

                    form.addEventListener(form.events.FORM_SUBMITTED, function(event) {
                        var newAvail = event.detail.availability;

                        rows.forEach(function(row) {
                            var cb = row.querySelector('.row-checkbox');
                            if (cb && cb.checked) {
                                var oldAvail = row.getAttribute('data-pending-availability');
                                if (oldAvail !== newAvail) {
                                    row.setAttribute('data-pending-availability', newAvail ? newAvail : '');
                                    var td = row.querySelector('.btn-edit-restrictions').closest('td');
                                    if (td) td.classList.add('td-modified');
                                }
                                var icon = row.querySelector('.restrictions-icon');
                                if (icon) {
                                    if (newAvail && newAvail !== '{"op":"&","c":[],"showc":[]}' && newAvail !== 'null') {
                                        icon.className = 'fa fa-lock text-warning restrictions-icon';
                                        icon.title = 'Has pending restrictions';
                                        icon.style.opacity = '1';
                                    } else {
                                        icon.className = 'fa fa-unlock-alt text-muted restrictions-icon';
                                        icon.title = 'No restrictions';
                                        icon.style.opacity = '0.3';
                                    }
                                }
                            }
                        });
                    });

                    form.show();
                });
            }
        });
    }

    function closeModal(selector) {
        var modalSelector = selector || '.modal';
        var closeBtns = document.querySelectorAll(modalSelector + ' [data-dismiss="modal"]');
        if (closeBtns.length > 0) {
            closeBtns[0].click();
        } else {
            // fallback if bootstrap 5
            var closeBtnsBs5 = document.querySelectorAll(modalSelector + ' [data-bs-dismiss="modal"]');
            if (closeBtnsBs5.length > 0) {
                closeBtnsBs5[0].click();
            }
        }
    }

    function formatDateForInput(dateObj) {
        var tzoffset = (new Date()).getTimezoneOffset() * 60000;
        var localISOTime = (new Date(dateObj - tzoffset)).toISOString().slice(0, 16);
        return localISOTime;
    }
});
</script>
// phpcs:disable moodle.Commenting.MissingDocblock.File
<?php

echo $OUTPUT->footer();
