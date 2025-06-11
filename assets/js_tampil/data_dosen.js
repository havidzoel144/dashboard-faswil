$(document).ready(function () {
    var dataTable = $('#dataTables').DataTable({
        dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
        processing: true,
        serverSide: true,
        searching: true,
        language: {
            search: "",
            searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
        },
        ajax: {
            // url: "https://dashboard-lldikti3.kemdikbud.go.id/beranda/beranda/data_dosen",
            url: baseURL + "beranda/beranda/data_dosen",
            type: "POST",
            data: function (d) {
                d.kode_pt = $('#kode_pt').val();
                d.nm_jabatan = getSelectedJabatan();
                d.nm_stat_aktif = getSelectedStatus();
                d[csrfName] = csrfHash; // ← Tambahkan ini
            },
            dataSrc: function (json) {
                csrfHash = json.csrfHash; // ← Token diperbarui setelah response
                return json.data; // ← Return data yang akan ditampilkan di tabel
            }
        },
        order: [
            [3, "asc"]
        ]
    });

    // Pindahkan kotak pencarian DataTables
    $("#dataTables_filter").detach().appendTo('#search-container');

    $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
    $('.dataTables_filter input[type="search"]').addClass('border-bottom');
    $('.dataTables_filter label').css({
        'width': '100%'
    });

    // Menambahkan event listener ke setiap input pencarian
    var searchInputs = $('.table-search-row input');
    var selectJafung = document.getElementById('nm_jabatan');

    $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
        dataTable.draw();
    });

    searchInputs.eq(0).on('keyup change', function () { // Pencarian untuk NAMA PT
        dataTable.column(3).search(this.value).draw(); // Angka 2 mengacu pada kolom NAMA PT (index dimulai dari 0)
    });

    // searchInputs.eq(1).on('keyup change', function() { // Pencarian untuk NAMA PRODI
    //     console.log('prodi:', this.value);
    //     dataTable.column(3).search(this.value).draw(); // Angka 3 mengacu pada kolom NAMA PRODI
    // });

    searchInputs.eq(2).on('keyup change', function () { // Pencarian untuk BIDANG ILMU
        dataTable.column(5).search(this.value).draw(); // Angka 5 mengacu pada kolom BIDANG ILMU
    });

    // searchInputs.eq(3).on('keyup change', function() { // Pencarian untuk status keaktifan
    //     dataTable.column(6).search(this.value).draw(); // Angka 6 mengacu pada kolom status keaktifan
    // });

    // selectJafung.addEventListener('change', function() {
    //     var selectedJafung = this.value; // Mendapatkan nilai yang dipilih pada elemen select
    //     dataTable.column(4).search(selectedJafung).draw();
    // });

    $('#nm_jabatan').on("change", function (e) { //Search by Akreditasi Prodi
        dataTable.draw();
    });

    function getSelectedJabatan() {
        var selectedJabatan = $('#nm_jabatan').val(); // Mendapatkan nilai yang dipilih pada elemen select
        return selectedJabatan;
    }

    $('#nm_stat_aktif').on("change", function (e) { //Search by Akreditasi Prodi
        dataTable.draw();
    });

    function getSelectedStatus() {
        var selectedStatus = $('#nm_stat_aktif').val(); // Mendapatkan nilai yang dipilih pada elemen select
        return selectedStatus;
    }

});