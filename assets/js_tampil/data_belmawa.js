$(document).ready(function () {
    var dataTable = $('#tabel-mbkm').DataTable({
        dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
        processing: true,
        serverSide: true,
        searching: true,
        language: {
            search: "",
            searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
        },
        ajax: {
            // url: urlDataBelmawa,
            url: baseURL + "beranda/belmawa/data_belmawa",
            // url: "<?= base_url('beranda/belmawa/data_belmawa'); ?>",
            type: "POST",
            data: function (d) {
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
    $("#tabel-mbkm_filter").detach().appendTo('#search-container');

    $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
    $('.dataTables_filter input[type="search"]').addClass('border-bottom');
    $('.dataTables_filter label').css({
        'width': '100%'
    });

    $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
        var selectedKodePT = $(this).val(); // Mendapatkan nilai yang dipilih pada elemen select
        dataTable.column(1).search(selectedKodePT).draw();
    });

    var dataTable_kip = $('#tabel-kip-kuliah').DataTable({
        dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
        searching: false,
    });
});