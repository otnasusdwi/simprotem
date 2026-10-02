(function ($) {
    'use strict';

    var monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $.fn.datepicker.dates.id = {
        days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        daysMin: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
        months: monthNames,
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        today: 'Hari ini',
        clear: 'Kosongkan',
        format: 'dd MM yyyy',
        titleFormat: 'MM yyyy',
        weekStart: 1
    };

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function parseIsoDate(value) {
        var match = String(value || '').match(/^(\d{4})-(\d{2})-(\d{2})$/);
        return match ? new Date(Number(match[1]), Number(match[2]) - 1, Number(match[3])) : null;
    }

    function formatDisplayDate(date) {
        return date ? pad(date.getDate()) + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear() : '';
    }

    function formatIsoDate(date) {
        return date ? date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate()) : '';
    }

    window.initializeSimprotemDatepickers = function () {
        $('.datepicker').each(function () {
            var $displayInput = $(this);

            if ($displayInput.data('simprotem-datepicker')) {
                return;
            }

            var fieldName = $displayInput.attr('name');
            var initialDate = parseIsoDate($displayInput.val());

            if (!fieldName) {
                return;
            }

            var $hiddenInput = $('<input>', {
                type: 'hidden',
                name: fieldName,
                value: formatIsoDate(initialDate)
            });

            $displayInput
                .removeAttr('name')
                .attr('data-date-field', fieldName)
                .attr('autocomplete', 'off')
                .val(formatDisplayDate(initialDate))
                .data('simprotem-datepicker', true)
                .after($hiddenInput)
                .datepicker({
                    language: 'id',
                    format: 'dd MM yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true,
                    endDate: window.simprotemDatepickerEndDate || null
                })
                .on('changeDate', function (event) {
                    $hiddenInput.val(formatIsoDate(event.date));
                })
                .on('clearDate', function () {
                    $hiddenInput.val('');
                });

            $displayInput.closest('form').on('submit', function () {
                $hiddenInput.val(formatIsoDate($displayInput.datepicker('getDate')));
            });
        });

        $('.datepicker-month').datepicker({
            language: 'id',
            format: 'mm-yyyy',
            viewMode: 'months',
            minViewMode: 'months',
            autoclose: true
        });
    };

    $(window.initializeSimprotemDatepickers);
})(jQuery);
