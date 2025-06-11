$(document).ready(function () {
    var dataTable = $('#tabel-prodi').DataTable({
        dom: '<"top data-dosen"li>rt<"bottom"p><"clear">',
        processing: true,
        serverSide: true,
        // searching: true,
        // language: {
        //     search: "",
        //     searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
        // },
        ajax: {
            // url: "https://dashboard-lldikti3.kemdikbud.go.id/beranda/prodi/data_prodi",
            url: baseURL + "beranda/prodi/data_prodi",
            type: "POST",
            data: function (d) {
                d.program = getSelectedProgram();
                d.akreditasi_prodi = getSelectedAkreditasi();
                d.tanggal_awal = $('#tanggal_awal').val();
                d.tanggal_akhir = $('#tanggal_akhir').val();
                d[csrfName] = csrfHash; // ← Tambahkan ini
            },
            dataSrc: function (json) {
                csrfHash = json.csrfHash; // ← Token diperbarui setelah response
                return json.data; // ← Return data yang akan ditampilkan di tabel
            }
        },
        order: [
            [2, "asc"]
        ]
    });

    // Pindahkan kotak pencarian DataTables
    // $("#tabel-prodi_filter").detach().appendTo('#search-container');

    // $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
    // $('.dataTables_filter input[type="search"]').addClass('border-bottom');
    // $('.dataTables_filter label').css({
    //     'width': '100%'
    // });

    // Menambahkan event listener ke setiap input pencarian
    var searchInputs = $('.table-search-row input');
    var selectedAkreditasi = document.getElementById('akreditasi_prodi');

    $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
        var selectedKodePT = $(this).val(); // Mendapatkan nilai yang dipilih pada elemen select
        dataTable.column(1).search(selectedKodePT).draw();
    });

    // $('#kode_prodi').select2().on("change", function(e) {
    //     var selectedKodeProdi = $(this).val(); // Mendapatkan nilai yang dipilih pada elemen select
    //     dataTable.column(3).search(selectedKodeProdi).draw();
    // });

    searchInputs.eq(0).on('keyup change', function () { //Search by Nama Prodi
        dataTable.column(4).search(this.value).draw();
    });

    $('#program').on("change", function (e) { //Search by Program
        dataTable.draw();
    });

    function getSelectedProgram() {
        var selectedProgram = $('#program').val(); // Mendapatkan nilai yang dipilih pada elemen select
        return selectedProgram;
    }

    $('#akreditasi_prodi').on("change", function (e) { //Search by Akreditasi Prodi
        dataTable.draw();
    });

    function getSelectedAkreditasi() {
        var selectedAkreditasi = $('#akreditasi_prodi').val(); // Mendapatkan nilai yang dipilih pada elemen select
        return selectedAkreditasi;
    }

    $('#tanggal_awal, #tanggal_akhir').change(function () {
        dataTable.draw();
    });
});