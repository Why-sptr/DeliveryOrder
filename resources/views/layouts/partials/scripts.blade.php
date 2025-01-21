<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Pastikan jQuery dan DataTables tersedia
    if (typeof $ === 'undefined') {
        console.error('jQuery tidak tersedia');
        return;
    }

    if (!$.fn.DataTable) {
        console.error('DataTables tidak tersedia');
        return;
    }

    // Tentukan rentang tanggal default
    let defaultStartDate = moment().startOf('year');
    let defaultEndDate = moment().endOf('year');

    // Set nilai default untuk input tanggal sebelum inisialisasi DataTable
    $('#start_date').val(defaultStartDate.format('YYYY-MM-DD'));
    $('#end_date').val(defaultEndDate.format('YYYY-MM-DD'));
    $('#dateRange').val(defaultStartDate.format('YYYY-MM-DD') + ' - ' + defaultEndDate.format('YYYY-MM-DD'));

    // Load nilai tanggal dari localStorage jika tersedia
    const savedStartDate = localStorage.getItem('start_date');
    const savedEndDate = localStorage.getItem('end_date');
    if (savedStartDate && savedEndDate) {
        $('#start_date').val(savedStartDate);
        $('#end_date').val(savedEndDate);
        $('#dateRange').val(savedStartDate + ' - ' + savedEndDate);
        defaultStartDate = moment(savedStartDate);
        defaultEndDate = moment(savedEndDate);
    }

    let table = $('#reservationTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/reservation',
            type: 'GET',
            data: function (d) {
                d.start_date = $('#start_date').val() || defaultStartDate.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || defaultEndDate.format('YYYY-MM-DD');
                return d;
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'reservation_date', defaultContent: '-' },
            { data: 'no_reservation', defaultContent: '-' },
            { data: 'item', defaultContent: '-' },
            { data: 'quantity', defaultContent: '0' },
            { data: 'user.name', defaultContent: '-' },
            {
                data: 'user.id_badges',
                render: function (data) {
                    if (data && Array.isArray(data)) {
                        return data.map(badge =>
                            `<span class="badge bg-info">${badge.badge_name}</span>`
                        ).join(' ');
                    }
                    return '-';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const isOwner = row.user_id === {{ auth()->id() }};
                    const editBtn = isOwner ?
                        `<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#reservationModalEdit${row.id}">Edit</button>` :
                        `<button class="btn btn-sm btn-warning disabled">Edit</button>`;
                    const deleteBtn = isOwner ?
                        `<button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#reservationModalDelete${row.id}">Delete</button>` :
                        `<button class="btn btn-sm btn-danger disabled">Delete</button>`;

                    return editBtn + ' ' + deleteBtn;
                }
            }
        ],
        order: [[4, 'desc']],
        responsive: true,
        language: {
            emptyTable: 'No data available'
        }
    });

    // Inisialisasi Date Range Picker
    $('#dateRange').daterangepicker({
        opens: 'left',
        autoUpdateInput: true,
        startDate: defaultStartDate,
        endDate: defaultEndDate,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        },
        ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun Kemarin': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    }, function (start, end) {
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        $('#dateRange').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

        // Simpan ke localStorage
        localStorage.setItem('start_date', start.format('YYYY-MM-DD'));
        localStorage.setItem('end_date', end.format('YYYY-MM-DD'));

        table.ajax.reload();
    });

    // Handler untuk Clear Date Range
    $('#dateRange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#start_date').val(defaultStartDate.format('YYYY-MM-DD'));
        $('#end_date').val(defaultEndDate.format('YYYY-MM-DD'));

        // Hapus dari localStorage
        localStorage.removeItem('start_date');
        localStorage.removeItem('end_date');

        table.ajax.reload();
    });

    // Tombol Export All
    $('#exportAllBtn').on('click', function (e) {
        e.preventDefault();
        const startDate = localStorage.getItem('start_date') || defaultStartDate.format('YYYY-MM-DD');
        const endDate = localStorage.getItem('end_date') || defaultEndDate.format('YYYY-MM-DD');
        window.location.href = `/reservations/export/all?start_date=${startDate}&end_date=${endDate}`;
    });

    // Tombol Export User
    $('#exportUserBtn').on('click', function (e) {
        e.preventDefault();
        const startDate = localStorage.getItem('start_date') || defaultStartDate.format('YYYY-MM-DD');
        const endDate = localStorage.getItem('end_date') || defaultEndDate.format('YYYY-MM-DD');
        window.location.href = `/reservations/export/user?start_date=${startDate}&end_date=${endDate}`;
    });
});

</script>