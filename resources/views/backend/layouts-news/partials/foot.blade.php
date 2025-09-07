<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    function toggleForm() {
        $("#inputFormSection").slideToggle(300);
    }
</script>
<script>
    $(document).ready(function() {
        const today = moment().format('DD.MM.YYYY');
        $('#rangePickerBtn').text(today + ' - ' + today);

        $('#rangePickerBtn').daterangepicker({
            opens: 'center',
            drops: 'down',
            locale: {
                format: 'DD.MM.YYYY',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                customRangeLabel: 'Custom Range'
            },
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            autoUpdateInput: false
        }, function(start, end, label) {
            $('#rangePickerBtn').text(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
            $('#startDate').val(start.format('YYYY-MM-DD'));
            $('#endDate').val(end.format('YYYY-MM-DD'));

            $('#orderTable').DataTable().ajax.reload();
            loadRekap();

        });
        $('#rangePickerBtn2').text(today + ' - ' + today);

        $('#rangePickerBtn2').daterangepicker({
            opens: 'center',
            drops: 'down',
            locale: {
                format: 'DD.MM.YYYY',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                customRangeLabel: 'Custom Range'
            },
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            autoUpdateInput: false
        }, function(start, end, label) {
            $('#rangePickerBtn2').text(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
            $('#startDate').val(start.format('YYYY-MM-DD'));
            $('#endDate').val(end.format('YYYY-MM-DD'));
            loadDataKomisi()
        });

        $('#rangePickerBtn3').text(today + ' - ' + today);

        $('#rangePickerBtn3').daterangepicker({
            opens: 'center',
            drops: 'down',
            locale: {
                format: 'DD.MM.YYYY',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                customRangeLabel: 'Custom Range'
            },
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            autoUpdateInput: false
        }, function(start, end, label) {
            $('#rangePickerBtn3').text(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
            $('#startDate').val(start.format('YYYY-MM-DD'));
            $('#endDate').val(end.format('YYYY-MM-DD'));
            loadStatistik(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });
    });
</script>
