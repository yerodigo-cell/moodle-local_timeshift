define(['jquery', 'core/config'], function($, config) {

    var init = function(courseid) {
        // Save Changes Handler
        $('#btn-save-changes').on('click', function() {
            var btn = $(this);
            btn.prop('disabled', true);
            var originalText = btn.text();
            btn.text('Saving...');

            var updates = [];

            $('#timeshift-table tbody tr').each(function() {
                var row = $(this);
                var cmid = row.data('cmid');
                var instanceid = row.data('instance');
                var modname = row.data('modname');

                var newname = row.find('.field-name').val();

                // Convert dates back to UNIX timestamp if applicable
                var allowfromInput = row.find('.field-allowfrom').val();
                var duedateInput = row.find('.field-duedate').val();

                var allowfrom = allowfromInput ? Math.floor(new Date(allowfromInput).getTime() / 1000) : 0;
                var duedate = duedateInput ? Math.floor(new Date(duedateInput).getTime() / 1000) : 0;

                updates.push({
                    cmid: cmid,
                    instanceid: instanceid,
                    modname: modname,
                    newname: newname,
                    allowfromdate: allowfrom,
                    duedate: duedate
                });
            });

            // Using standard jQuery ajax since we have a custom ajax.php endpoint
            $.ajax({
                url: config.wwwroot + '/local/timeshift/ajax.php',
                type: 'POST',
                data: {
                    courseid: courseid,
                    updates: JSON.stringify(updates),
                    sesskey: config.sesskey
                },
                dataType: 'json'
            }).done(function(response) {
                if (response && response.success) {
                    // eslint-disable-next-line no-console
                    console.log('Changes successfully saved.');
                    window.location.reload();
                } else {
                    // eslint-disable-next-line no-console
                    console.error((response && response.message) ? response.message : 'Error updating database records.');
                    btn.prop('disabled', false).text(originalText);
                }
            }).fail(function() {
                // eslint-disable-next-line no-console
                console.error('AJAX Error updating records.');
                btn.prop('disabled', false).text(originalText);
            });
        });

        // Bulk Shift Dates Handler
        $('#btn-apply-shift').on('click', function() {
            var days = parseInt($('#shift-days-input').val(), 10);
            if (isNaN(days) || days === 0) {
                $('#shiftDatesModal').modal('hide');
                return;
            }

            var msShift = days * 24 * 60 * 60 * 1000;

            $('#timeshift-table tbody tr').each(function() {
                var row = $(this);
                var allowField = row.find('.field-allowfrom');
                var dueField = row.find('.field-duedate');

                if (!allowField.prop('disabled') && allowField.val()) {
                    var d1 = new Date(allowField.val());
                    d1.setTime(d1.getTime() + msShift);
                    allowField.val(formatDateForInput(d1));
                }

                if (!dueField.prop('disabled') && dueField.val()) {
                    var d2 = new Date(dueField.val());
                    d2.setTime(d2.getTime() + msShift);
                    dueField.val(formatDateForInput(d2));
                }
            });

            $('#shiftDatesModal').modal('hide');
        });

        /**
         * Formats a Date object to YYYY-MM-DDThh:mm string for datetime-local input.
         *
         * @param {Date} dateObj The Date object to format.
         * @returns {string} The formatted date string.
         */
        function formatDateForInput(dateObj) {
            // Format to YYYY-MM-DDThh:mm.
            var tzoffset = (new Date()).getTimezoneOffset() * 60000; // Offset in milliseconds.
            var localISOTime = (new Date(dateObj - tzoffset)).toISOString().slice(0, 16);
            return localISOTime;
        }
    };

    return {
        init: init
    };
});
