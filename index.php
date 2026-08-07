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

require_once('../../config.php');
// phpcs:disable moodle.Files.LineLength.TooLong
// phpcs:disable moodle.Files.LineLength.MaxExceeded
// phpcs:disable moodle.Commenting.MissingDocblock.File
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

// Preload availability JS to prevent infinite loading in Moodle 4.1 ModalForms due to YUI restrictions.
$modinfo = get_fast_modinfo($course);
$cms = $modinfo->get_cms();
$firstcm = reset($cms);
if ($firstcm) {
    \core_availability\frontend::include_all_javascript($course, $firstcm);
}

echo $OUTPUT->header();

// Start container.
echo '<div class="local-timeshift-container" style="margin: 0 auto 80px auto; max-width: 1600px;">';

$iconurl = new moodle_url('/local/timeshift/pix/icon.png');
$iconimg = '<img src="' . $iconurl . '" alt="Timeshift Lite Logo" ' .
           'style="width: 32px; height: 32px; border-radius: 6px; box-shadow: 0px 2px 4px rgba(0,0,0,0.2);">';

echo '<h3 style="display: flex; align-items: center; gap: 12px; font-weight: 800; color: #1e293b; margin-bottom: 20px;">' .
     $iconimg . ' <span>' . get_string('pagetitle', 'local_timeshift') . '</span>' .
     '<span style="display: flex; align-items: center; margin-top: 4px;">' . $OUTPUT->help_icon('pagedescription', 'local_timeshift') . '</span></h3>';

// Build a unique list of activity types for the filter dropdown.
$modtypes = [];
foreach ($activities as $act) {
    $modtypes[$act->modname] = $act->modname;
}
asort($modtypes);

// Modal, top buttons, and filters.
echo '<div id="timeshift-main-view">';
echo '<div style="margin-bottom: 20px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">';
echo '<div style="display: flex; gap: 10px; align-items: center; flex-wrap: nowrap; overflow-x: auto; max-width: 100%;">';
echo '<div style="position: relative; width: 100%; max-width: 250px; min-width: 140px;">';
echo '<input type="text" id="filter-name" class="form-control" placeholder="' .
     get_string('searchbyname', 'local_timeshift') . '" style="width: 100%; border-radius: 6px;">';
echo '</div>';



echo '<button type="button" id="btn-clear-filters" title="Clear filters" style="display: none;">';
echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' .
     '<circle cx="12" cy="12" r="12" fill="#292d32"/>' .
     '<path d="M8.5 8.5L15.5 15.5M15.5 8.5L8.5 15.5" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>' .
     '</svg>';
echo '</button>';

echo '</div>';

// Banner Upsell.
echo '<div style="display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-left: auto;">';




echo '</div>';

echo '</div>';

// Bulk Actions Toolbar (hidden by default until items are selected).
echo '<div id="bulk-actions-toolbar" style="display: none; margin-bottom: 20px; padding: 15px 20px; background: #e7f1ff; border: 1px solid #b6d4fe; border-radius: 8px; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15); align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; transition: all 0.3s ease;">';
echo '  <div style="display: flex; align-items: center; gap: 15px;">';
echo '    <span id="selected-count" style="font-weight: 700; color: #084298; font-size: 1.05em;">' . get_string('activitiesselected', 'local_timeshift', 0) . '</span>';
echo '    <div class="dropdown">';
echo '      <button class="btn btn-timeshift-action dropdown-toggle" type="button" id="bulkActionsDropdown" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 6px; font-weight: 500; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);">';
echo '        ' . get_string('actionsforselected', 'local_timeshift') . '
      </button>';
echo '      <div class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#findReplaceModal" data-bs-toggle="modal" data-bs-target="#findReplaceModal">' . get_string('action_findreplace', 'local_timeshift') . '</a>
      </div>';
echo '    </div>';
echo '  </div>';
echo '  <div>';
echo '    <button type="button" class="btn btn-timeshift-clear" id="btn-clear-selection" style="border-radius: 6px; font-weight: 500;">' . get_string('clearselection', 'local_timeshift') . ' ✕</button>';
echo '  </div>';
echo '</div>';

// Table.
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
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$activitiesbysection = [];
foreach ($activities as $act) {
    $sec = $act->sectionnum;
    if (!isset($activitiesbysection[$sec])) {
        $activitiesbysection[$sec] = [];
    }
    $activitiesbysection[$sec][] = $act;
}

foreach ($activitiesbysection as $secnum => $sectionacts) {
    if (empty($sectionacts)) {
        continue;
    }
    $secname = $sectionacts[0]->sectionname;

    echo '<tr class="table-light timeshift-section-header" data-sectionnum="' . $secnum . '" style="display: none; background-color: #f8f9fa;">';
    echo '<td colspan="6" style="font-weight: 600; color: #495057; padding-left: 20px; vertical-align: middle;">' . s($secname) . '</td>';
    echo '</tr>';

    foreach ($sectionacts as $act) {
        // Format dates for input type datetime-local (YYYY-MM-DDThh:mm).
        $allowfrom = !empty($act->allowfromdate) ? date('Y-m-d\TH:i', $act->allowfromdate) : '';
        $due = !empty($act->duedate) ? date('Y-m-d\TH:i', $act->duedate) : '';
        $cutoff = !empty($act->cutoffdate) ? date('Y-m-d\TH:i', $act->cutoffdate) : '';

        echo '<tr class="timeshift-activity-row" data-cmid="' . $act->cmid . '" data-instance="' . $act->instance . '" data-modname="' . $act->modname . '">';
        echo '<td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="row-checkbox"></td>';

        // Column 1: Type.
        echo '<td style="vertical-align: middle;">';
        echo '<div style="display: flex; align-items: center; gap: 10px;">';
        if (!empty($act->iconurl)) {
            // Determine icon color based on Moodle 4 module categories.
            $modpurposes = [
                // Assessment.
                'assign' => 'assessment', 'quiz' => 'assessment', 'workshop' => 'assessment', 'certificatebeautiful' => 'assessment', 'coursecertificate' => 'assessment',
                // Communication.
                'choice' => 'communication', 'feedback' => 'communication', 'chat' => 'communication', 'bigbluebuttonbn' => 'communication', 'zoom' => 'communication',
                // Content.
                'book' => 'content', 'folder' => 'content', 'label' => 'content', 'page' => 'content', 'qbank' => 'content', 'resource' => 'content', 'url' => 'content', 'emubook' => 'content', 'videotrack' => 'content', 'codeframe' => 'content',
                // Collaboration.
                'data' => 'collaboration', 'database' => 'collaboration', 'forum' => 'collaboration', 'glossary' => 'collaboration', 'wiki' => 'collaboration', 'diary' => 'collaboration',
                // Interactive content..
                'h5pactivity' => 'interactive_content', 'imscp' => 'interactive_content', 'lesson' => 'interactive_content', 'scorm' => 'interactive_content',
                // Administration & Other..
                'attendance' => 'administration', 'lti' => 'other',
                // Custom..
                'hvp' => 'hvp_black',
            ];
            $purposecolors = [
                'assessment' => '#fa0086',
                'communication' => '#fe5701',
                'content' => '#00a5ad',
                'collaboration' => '#6f46f7',
                'interactive_content' => '#3c73b8',
                'hvp_black' => '#212529',
                'administration' => '#5d63f6',
                'other' => '#6c757d',
                'default' => '#6c757d',
            ];
            $purpose = isset($modpurposes[$act->modname]) ? $modpurposes[$act->modname] : 'default';
            $iconbg = $purposecolors[$purpose];

            if ($act->modname === 'hvp') {
                // HVP plugin comes with its own colored square icon, so we don't wrap it or invert it.
                echo '<img src="' . $act->iconurl . '" alt="' . $act->modname . ' icon" style="width: 32px; height: 32px; border-radius: 6px;">';
            } else {
                $iconbglight = $iconbg . '26'; // 15% opacity hex alpha
                echo '<div style="background-color: ' . $iconbglight . '; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">';
                echo '<div style="background-color: ' . $iconbg . '; width: 20px; height: 20px; -webkit-mask-image: url(' . $act->iconurl . '); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; mask-image: url(' . $act->iconurl . '); mask-size: contain; mask-repeat: no-repeat;"></div>';
                echo '</div>';
            }
        }
        $displayname = isset($act->modfullname) ? $act->modfullname : ucfirst($act->modname);
        // Explicitly handle H5pactivity just in case the localized string still says H5P activity..
        if (strtolower($displayname) === 'h5pactivity' || strtolower($displayname) === 'h5p activity') {
            $displayname = 'H5p';
        }
        if ($act->modname === 'label') {
            $displayname = 'Label';
        }
        echo '<span style="font-weight: 500; color: #495057; min-width: 70px;">' . $displayname . '</span>';
        echo '</div>';
        echo '</td>';

        // Column 2: Activity..
        echo '<td style="vertical-align: middle;">';
        echo '<input type="text" class="form-control field-name" value="' . s($act->name) . '" style="width: 100%; min-width: 120px; max-width: 300px;">';
        echo '</td>';

        // Dates editable for assign/quiz/forum. Others can be extended later..
        if ($act->modname === 'assign' || $act->modname === 'quiz' || $act->modname === 'forum') {
            $allowdisabled = ($act->modname === 'forum');
            $cutoffdisabled = ($act->modname === 'quiz');

            if ($allowdisabled) {
                echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
            } else {
                echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-allowfrom" value="' . $allowfrom . '"></td>';
            }

            echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-duedate" value="' . $due . '"></td>';

            if ($cutoffdisabled) {
                echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
            } else {
                echo '<td style="vertical-align: middle;"><input type="datetime-local" class="form-control field-cutoffdate" value="' . $cutoff . '"></td>';
            }
        } else {
            echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
            echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
            echo '<td class="text-center" style="vertical-align: middle;"><strong>&mdash;</strong></td>';
        }


        echo '</tr>';
    }
} // end foreach section
echo '</tbody>';
echo '</table>';
echo '</div>';

// Table Footer Toolbar..
echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; flex-wrap: wrap; gap: 16px;">';

// Left side: Total count..
echo '<div style="color: #6c757d; font-size: 14px; font-weight: 500;">';
echo get_string('totalactivities', 'local_timeshift') . ' <span id="total-activities-count">' . count($activities) . '</span>';
echo '</div>';

// Right side: Action buttons..
echo '<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">';

// Discard Changes..
echo '<button type="button" class="btn btn-timeshift-discard btn-action-discard" style="border-radius: 6px; padding: 8px 16px; font-weight: 500;">' . get_string('discard', 'local_timeshift') . '</button>';

// Save Changes..
echo '<button type="button" class="btn btn-timeshift-save btn-action-save" style="border-radius: 6px; padding: 8px 24px; font-weight: 500;">';
echo get_string('savechanges', 'local_timeshift');
echo '</button>';

echo '</div>'; // End right side actions.
echo '</div>'; // End footer toolbar.

echo '</div>'; // End timeshift-main-view.




echo '</div>'; // End container.



// Find & Replace Modal.
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
    var btnClearFilters = document.getElementById('btn-clear-filters');

    function applyFilters() {
        var nameQuery = filterName ? filterName.value.toLowerCase() : '';
        var typeQuery = filterType ? filterType.value.toLowerCase() : '';
        var activityRows = document.querySelectorAll('#timeshift-table tbody tr.timeshift-activity-row');
        var sectionHeaders = document.querySelectorAll('#timeshift-table tbody tr.timeshift-section-header');

        if (btnClearFilters) {
            if (nameQuery !== '' || typeQuery !== '') {
                btnClearFilters.style.display = 'flex';
            } else {
                btnClearFilters.style.display = 'none';
            }
        }

        var visibleCount = 0;

        activityRows.forEach(function(row) {
            var modname = row.getAttribute('data-modname');
            if (modname) {
                modname = modname.toLowerCase();
            } else {
                modname = '';
            }
            var nameInput = row.querySelector('.field-name');
            var name = nameInput ? nameInput.value.toLowerCase() : '';

            var matchName = name.indexOf(nameQuery) > -1;
            var matchType = typeQuery === '' || modname === typeQuery;

            if (matchName && matchType) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Hide empty sections
        sectionHeaders.forEach(function(header) {
            var hasVisibleActivities = false;
            var next = header.nextElementSibling;
            while (next && !next.classList.contains('timeshift-section-header')) {
                if (next.style.display !== 'none' && next.classList.contains('timeshift-activity-row')) {
                    hasVisibleActivities = true;
                    break;
                }
                next = next.nextElementSibling;
            }
            if (hasVisibleActivities) {
                header.style.display = '';
            } else {
                header.style.display = 'none';
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

    if (btnClearFilters) {
        btnClearFilters.addEventListener('click', function() {
            if (filterName) filterName.value = '';
            if (filterType) filterType.value = '';
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

    // Discard Changes. Handler
    var btnDiscardNodes = document.querySelectorAll('.btn-action-discard');
    btnDiscardNodes.forEach(function(btnDiscard) {
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
    });

    // Save Changes. Handler
    var btnSaveNodes = document.querySelectorAll('.btn-action-save');
    btnSaveNodes.forEach(function(btnSave) {
        btnSave.addEventListener('click', function() {
            btnSaveNodes.forEach(function(btn) { btn.disabled = true; });
            var originalText = btnSave.innerText;
            btnSaveNodes.forEach(function(btn) { btn.innerText = '<?php echo get_string('saving', 'local_timeshift'); ?>'; });

            var updates = [];
            var rows = document.querySelectorAll('#timeshift-table tbody tr');

            rows.forEach(function(row) {
                var cmid = row.getAttribute('data-cmid');
                var instanceid = row.getAttribute('data-instance');
                var modname = row.getAttribute('data-modname');

                var nameInput = row.querySelector('.field-name');
                var allowfromInput = row.querySelector('.field-allowfrom');
                var duedateInput = row.querySelector('.field-duedate');
                var cutoffdateInput = row.querySelector('.field-cutoffdate');

                var newname = nameInput ? nameInput.value : '';
                var allowval = allowfromInput ? allowfromInput.value : '';
                var dueval = duedateInput ? duedateInput.value : '';
                var cutoffval = cutoffdateInput ? cutoffdateInput.value : '';

                var allowfrom = allowval ? Math.floor(new Date(allowval).getTime() / 1000) : 0;
                var duedate = dueval ? Math.floor(new Date(dueval).getTime() / 1000) : 0;
                var cutoffdate = cutoffval ? Math.floor(new Date(cutoffval).getTime() / 1000) : 0;

                updates.push({
                    cmid: cmid,
                    instanceid: instanceid,
                    modname: modname,
                    newname: newname,
                    allowfromdate: allowfrom,
                    duedate: duedate,
                    cutoffdate: cutoffdate
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
                                btnSaveNodes.forEach(function(btn) {
                                    btn.disabled = false;
                                    btn.innerText = originalText;
                                });
                            }
                        } catch (e) {
                            showMoodleAlert('Error', 'Invalid JSON response from server.');
                            btnSaveNodes.forEach(function(btn) {
                                btn.disabled = false;
                                btn.innerText = originalText;
                            });
                        }
                    } else {
                        showMoodleAlert('Error', 'AJAX HTTP Error: ' + xhr.status);
                        btnSaveNodes.forEach(function(btn) {
                            btn.disabled = false;
                            btn.innerText = originalText;
                        });
                    }
                }
            };

            var params = 'courseid=' + encodeURIComponent(courseid) +
                         '&updates=' + encodeURIComponent(JSON.stringify(updates)) +
                         '&sesskey=' + encodeURIComponent(sesskey);
            xhr.send(params);
        });
    });



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

<?php

echo $OUTPUT->footer();
