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
        // Default 1 bulan (bulan ini)
        const startOfMonth = moment().startOf('month');
        const endOfMonth = moment().endOf('month');

        // Fungsi reusable untuk inisialisasi daterangepicker
        function initRangePicker(btnId, callback) {
            // Set default text + hidden input
            $(btnId).text(startOfMonth.format('DD.MM.YYYY') + ' - ' + endOfMonth.format('DD.MM.YYYY'));
            $('#startDate').val(startOfMonth.format('YYYY-MM-DD'));
            $('#endDate').val(endOfMonth.format('YYYY-MM-DD'));

            // Inisialisasi daterangepicker
            $(btnId).daterangepicker({
                startDate: startOfMonth,
                endDate: endOfMonth,
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
            }, function(start, end) {
                $(btnId).text(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
                $('#startDate').val(start.format('YYYY-MM-DD'));
                $('#endDate').val(end.format('YYYY-MM-DD'));

                // Jalankan callback spesifik untuk setiap tombol
                if (typeof callback === "function") {
                    callback(start, end);
                }
            });
        }

        // --- Panggil fungsi untuk masing-masing button ---

        // RangePickerBtn 1 → untuk orderTable
        initRangePicker('#rangePickerBtn', function(start, end) {
            $('#orderTable').DataTable().ajax.reload();
            loadRekap();
        });

        // RangePickerBtn 2 → untuk komisi
        initRangePicker('#rangePickerBtn2', function(start, end) {
            loadDataKomisi();
        });

        // RangePickerBtn 3 → untuk statistik
        initRangePicker('#rangePickerBtn3', function(start, end) {
            loadStatistik(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });
    });
</script>
