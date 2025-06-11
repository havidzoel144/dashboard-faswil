$(document).ready(function () {
    var dataTable = $('#beranda').DataTable({
        dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
        processing: true,
        serverSide: true,
        searching: true,
        language: {
            search: "",
            searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
        },
        ajax: {
            // url: "https://dashboard-lldikti3.kemdikbud.go.id/beranda/beranda/data_pt_ok",
            url: baseURL + "beranda/beranda/data_pt_ok",
            type: "POST",
            data: function (d) {
                d.akreditasi_pt = getSelectedAkreditasi();
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
    $("#beranda_filter").detach().appendTo('#search-container');

    $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
    $('.dataTables_filter input[type="search"]').addClass('border-bottom');
    $('.dataTables_filter label').css({
        'width': '100%'
    });

    var searchInputs = $('.table-search-row input');
    var selectedAkreditasi = document.getElementById('akreditasi_pt');

    $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
        var selectedKodePT = $(this).val(); // Mendapatkan nilai yang dipilih pada elemen select
        dataTable.column(1).search(selectedKodePT).draw();
    });

    $('#status_pt').select2().on("change", function (e) { //Search by Kode PT
        var selectedKodePT = $(this).val(); // Mendapatkan nilai yang dipilih pada elemen select
        dataTable.column(3).search(selectedKodePT).draw();
    });

    // searchInputs.eq(0).on('keyup change', function() {
    //     dataTable.column(1).search(this.value).draw();
    // });

    // searchInputs.eq(1).on('keyup change', function() {
    //     dataTable.column(2).search(this.value).draw();
    // });

    // searchInputs.eq(2).on('keyup change', function() {
    //     dataTable.column(3).search(this.value).draw();
    // });

    // $('input[name="akreditasi_pt[]"]').on('change', function() {
    //     dataTable.draw();
    // });

    // function getSelectedAkreditasi() {
    //     var selected = [];
    //     $('input[name="akreditasi_pt[]"]:checked').each(function() {
    //         selected.push($(this).val());
    //     });
    //     return selected;
    // }

    $('#akreditasi_pt').on("change", function (e) { //Search by Akreditasi Prodi
        dataTable.draw();
    });

    $('#tanggal_awal, #tanggal_akhir').change(function () {
        dataTable.draw();
    });

    function getSelectedAkreditasi() {
        var selectedAkreditasi = $('#akreditasi_pt').val(); // Mendapatkan nilai yang dipilih pada elemen select
        return selectedAkreditasi;
    }

});