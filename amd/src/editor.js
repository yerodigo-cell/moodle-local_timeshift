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
 * @copyright   2026 EduPlugins Studio
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/config', 'core/notification', 'core/str', 'core/ajax'], function($, config, Notification, str, Ajax) {

    var init = function(courseid) {
        var strSingular = '';
        var strPlural = '';
        var strSaving = 'Saving...';
        var strError = 'Error';
        var strErrorUpdate = 'Error updating database records.';
        var strConfirmDiscard = 'Confirm discard';
        var strDiscardWarning = 'Are you sure you want to discard all unsaved changes?';
        var strDiscard = 'Discard';
        var strCancel = 'Cancel';
        var strOk = 'OK';
        var hasUnsavedChanges = false;

        // Fetch strings for the UI
        str.get_strings([
            {key: 'activitiesselected_singular', component: 'local_timeshift'},
            {key: 'activitiesselected_plural', component: 'local_timeshift'},
            {key: 'saving', component: 'local_timeshift'},
            {key: 'error', component: 'local_timeshift'},
            {key: 'errorupdate', component: 'local_timeshift'},
            {key: 'confirmdiscard', component: 'local_timeshift'},
            {key: 'discardchangeswarning', component: 'local_timeshift'},
            {key: 'discard', component: 'local_timeshift'},
            {key: 'cancel', component: 'local_timeshift'},
            {key: 'ok', component: 'moodle'}
        ]).done(function(strings) {
            strSingular = strings[0];
            strPlural = strings[1];
            strSaving = strings[2];
            strError = strings[3];
            strErrorUpdate = strings[4];
            strConfirmDiscard = strings[5];
            strDiscardWarning = strings[6];
            strDiscard = strings[7];
            strCancel = strings[8];
            strOk = strings[9];
        });

        // Warn user before leaving page if there are unsaved changes
        $(window).on('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = ''; // Required for some browsers
            }
        });

        /**
         * Mark field as modified
         *
         * @param {HTMLElement} field
         */
        function markFieldAsModified(field) {
            if (!field) {
                return;
            }
            var td = $(field).closest('td');
            if (td.length) {
                td.addClass('td-modified');
            }
            hasUnsavedChanges = true;
            $('#floating-save-container').show();
        }

        // Attach listener to all editable fields
        $('.field-name, .field-status, .field-allowfrom, .field-duedate, .field-cutoffdate').on('change input', function() {
            markFieldAsModified(this);
        });

        // Filtering logic

        /**
         * Apply filters
         */
        function applyFilters() {
            var nameQuery = $('#filter-name').val() ? $('#filter-name').val().toLowerCase() : '';
            var typeQuery = $('#filter-type').length ? $('#filter-type').val().toLowerCase() : '';
            var activityRows = $('#timeshift-table tbody tr.timeshift-activity-row');

            if (nameQuery !== '' || typeQuery !== '') {
                $('#btn-clear-filters').css('display', 'flex');
            } else {
                $('#btn-clear-filters').hide();
            }

            var visibleCount = 0;

            activityRows.each(function() {
                var row = $(this);
                var modname = row.data('modname') || '';
                modname = modname.toLowerCase();
                var name = row.find('.field-name').val() ? row.find('.field-name').val().toLowerCase() : '';

                var matchName = name.indexOf(nameQuery) > -1;
                var matchType = typeQuery === '' || modname === typeQuery;

                if (matchName && matchType) {
                    row.show();
                    visibleCount++;
                } else {
                    row.hide();
                }
            });

            $('#total-activities-count').text(visibleCount);
            updateSelectionState();
        }

        $('#filter-name').on('input', applyFilters);
        $('#filter-type').on('change', applyFilters);

        $('#btn-clear-filters').on('click', function() {
            $('#filter-name').val('');
            if ($('#filter-type').length) {
                $('#filter-type').val('');
            }
            applyFilters();
        });

        // Checkbox and Bulk Actions Toolbar Logic

        /**
         * Update selection state
         */
        function updateSelectionState() {
            var selectedCount = 0;
            var visibleCount = 0;
            var visibleSelectedCount = 0;

            $('.row-checkbox').each(function() {
                var cb = $(this);
                var row = cb.closest('tr');
                if (row.css('display') !== 'none') {
                    visibleCount++;
                    if (cb.prop('checked')) {
                        selectedCount++;
                        visibleSelectedCount++;
                    }
                } else {
                    if (cb.prop('checked')) {
                        selectedCount++;
                    }
                }
            });

            var selectAll = $('#select-all-checkbox');
            if (selectAll.length) {
                selectAll.prop('checked', (visibleCount > 0 && visibleSelectedCount === visibleCount));
                selectAll.prop('indeterminate', (visibleSelectedCount > 0 && visibleSelectedCount < visibleCount));
            }

            if (selectedCount > 0) {
                $('#bulk-actions-toolbar').css('display', 'flex');
                var text = selectedCount === 1 ? strSingular : strPlural;
                $('#selected-count').text(selectedCount + text);
            } else {
                $('#bulk-actions-toolbar').hide();
            }
        }

        $('#select-all-checkbox').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.row-checkbox').each(function() {
                var cb = $(this);
                var row = cb.closest('tr');
                if (row.css('display') !== 'none') {
                    cb.prop('checked', isChecked);
                }
            });
            updateSelectionState();
        });

        $('.row-checkbox').on('change', updateSelectionState);

        $('#btn-clear-selection').on('click', function() {
            $('.row-checkbox').prop('checked', false);
            updateSelectionState();
        });

        // Discard Changes Handler
        $('.btn-action-discard').on('click', function() {
            Notification.confirm(
                strConfirmDiscard,
                strDiscardWarning,
                strDiscard,
                strCancel,
                function() {
                    hasUnsavedChanges = false;
                    window.location.reload();
                }
            );
        });

        // Save Changes Handler
        $('.btn-action-save').on('click', function() {
            var btnSaveNodes = $('.btn-action-save');
            btnSaveNodes.prop('disabled', true);
            var originalText = btnSaveNodes.first().text();

            btnSaveNodes.text(strSaving);

            var updates = [];

            $('#timeshift-table tbody tr.timeshift-activity-row').each(function() {
                var row = $(this);
                var cmid = row.data('cmid');

                var newname = row.find('.field-name').val() || '';

                var allowfromInput = row.find('.field-allowfrom').val();
                var duedateInput = row.find('.field-duedate').val();
                var cutoffdateInput = row.find('.field-cutoffdate').val();

                var allowfrom = allowfromInput ? Math.floor(new Date(allowfromInput).getTime() / 1000) : 0;
                var duedate = duedateInput ? Math.floor(new Date(duedateInput).getTime() / 1000) : 0;
                var cutoffdate = cutoffdateInput ? Math.floor(new Date(cutoffdateInput).getTime() / 1000) : 0;

                updates.push({
                    cmid: cmid,
                    newname: newname,
                    allowfromdate: allowfrom,
                    duedate: duedate,
                    cutoffdate: cutoffdate
                });
            });

            var promises = Ajax.call([{
                methodname: 'local_timeshift_update_activities',
                args: {
                    courseid: courseid,
                    updates: updates
                }
            }]);

            promises[0].done(function(response) {
                if (response && response.success) {
                    hasUnsavedChanges = false;
                    window.location.reload();
                } else {
                    var msg = (response && response.message) ? response.message : strErrorUpdate;
                    btnSaveNodes.prop('disabled', false).text(originalText);
                    if (Notification && Notification.alert) {
                        Notification.alert(strError, msg, strOk);
                    } else {
                        window.alert(strError + ": " + msg);
                    }
                }
            }).fail(function(ex) {
                btnSaveNodes.prop('disabled', false).text(originalText);
                if (Notification && Notification.exception) {
                    try {
                        Notification.exception(ex);
                    } catch (e) {
                        window.alert("Exception: " + (ex.message || ex));
                    }
                } else {
                    window.alert("Exception: " + (ex.message || ex));
                }
            });
        });

        // Find & Replace Handler
        $('#btn-apply-findreplace').on('click', function() {
            var findText = $('#fr-find-input').val();
            var replaceText = $('#fr-replace-input').val();

            if (findText === '') {
                closeModal('#findReplaceModal');
                return;
            }

            var regex = new RegExp(findText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
            var madeChanges = false;

            $('#timeshift-table tbody tr.timeshift-activity-row').each(function() {
                var row = $(this);
                var cb = row.find('.row-checkbox');
                if (cb.length && cb.prop('checked')) {
                    var nameInput = row.find('.field-name');
                    if (nameInput.length) {
                        var oldVal = nameInput.val();
                        var newVal = oldVal.replace(regex, replaceText);
                        nameInput.val(newVal);
                        if (oldVal !== newVal) {
                            markFieldAsModified(nameInput[0]);
                            madeChanges = true;
                        }
                    }
                }
            });

            if (madeChanges) {
                hasUnsavedChanges = true;
            }

            closeModal('#findReplaceModal');
        });

        // Bulk Shift Dates Handler (from previous editor.js)
        $('#btn-apply-shift').on('click', function() {
            var days = parseInt($('#shift-days-input').val(), 10);
            if (isNaN(days) || days === 0) {
                closeModal('#shiftDatesModal');
                return;
            }

            var msShift = days * 24 * 60 * 60 * 1000;
            var madeChanges = false;

            $('#timeshift-table tbody tr.timeshift-activity-row').each(function() {
                var row = $(this);
                var cb = row.find('.row-checkbox');

                // If it's a bulk action, typically it applies to selected rows
                if (cb.length && !cb.prop('checked')) {
                    return; // Skip if not checked
                }

                var allowField = row.find('.field-allowfrom');
                var dueField = row.find('.field-duedate');
                var cutoffField = row.find('.field-cutoffdate');

                if (!allowField.prop('disabled') && allowField.val()) {
                    var d1 = new Date(allowField.val());
                    d1.setTime(d1.getTime() + msShift);
                    allowField.val(formatDateForInput(d1));
                    markFieldAsModified(allowField[0]);
                    madeChanges = true;
                }

                if (!dueField.prop('disabled') && dueField.val()) {
                    var d2 = new Date(dueField.val());
                    d2.setTime(d2.getTime() + msShift);
                    dueField.val(formatDateForInput(d2));
                    markFieldAsModified(dueField[0]);
                    madeChanges = true;
                }

                if (cutoffField.length && !cutoffField.prop('disabled') && cutoffField.val()) {
                    var d3 = new Date(cutoffField.val());
                    d3.setTime(d3.getTime() + msShift);
                    cutoffField.val(formatDateForInput(d3));
                    markFieldAsModified(cutoffField[0]);
                    madeChanges = true;
                }
            });

            if (madeChanges) {
                hasUnsavedChanges = true;
            }

            closeModal('#shiftDatesModal');
        });

        /**
         * Close modal by selector
         *
         * @param {String} selector
         */
        function closeModal(selector) {
            var modalSelector = selector || '.modal';
            var closeBtns = $(modalSelector + ' [data-dismiss="modal"], ' + modalSelector + ' [data-bs-dismiss="modal"]');
            if (closeBtns.length > 0) {
                closeBtns.first().trigger('click');
            } else {
                $(modalSelector).modal('hide');
            }
        }

        /**
         * Format date for input
         *
         * @param {Date} dateObj
         * @returns {String}
         */
        function formatDateForInput(dateObj) {
            var tzoffset = (new Date()).getTimezoneOffset() * 60000; // Offset in milliseconds
            var localISOTime = (new Date(dateObj - tzoffset)).toISOString().slice(0, 16);
            return localISOTime;
        }
    };

    return {
        init: init
    };
});
