$(document).ready(function () {
  var dataTable = $('#tabel-penjaminan-mutu').DataTable({
    dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
    processing: true,
    serverSide: true,
    searching: true,
    language: {
      search: "",
      searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
    },
    ajax: {
      url: "https://dashboard-lldikti3.kemdikbud.go.id/beranda/Penjaminan_mutu/data_penjaminan_mutu",
      type: "POST",
      data: function (d) {
        // Mendapatkan tahun saat ini
        var currentYear = new Date().getFullYear();
        // Mendapatkan bulan saat ini (0-11, Januari = 0)
        var currentMonth = new Date().getMonth() + 1; // Ditambah 1 agar Januari = 1, Desember = 12

        // Menentukan periode: 1 untuk Januari-Juni, 2 untuk Juli-November
        var periodSuffix = (currentMonth >= 1 && currentMonth <= 6) ? '1' : '2';
        d.periode = currentYear + periodSuffix;
      }
    },
    order: [
      [2, "asc"]
    ]
  });

  // RIWAYAT SPMI
  var dataTable_riwayat = $('#tabel-riwayat-penjaminan-mutu').DataTable({
    dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
    processing: true,
    serverSide: true,
    searching: true,
    language: {
      search: "",
      searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
    },
    ajax: {
      url: "https://dashboard-lldikti3.kemdikbud.go.id/beranda/Penjaminan_mutu/data_penjaminan_mutu",
      type: "POST",
    },
    order: [
      [2, "asc"]
    ]
  });

  // Pindahkan kotak pencarian DataTables
  $("#tabel-penjaminan-mutu_filter").detach().appendTo('#search-container');
  $("#tabel-riwayat-penjaminan-mutu_filter").detach().appendTo('#search-container');

  $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
  $('.dataTables_filter input[type="search"]').addClass('border-bottom');
  $('.dataTables_filter label').css({
    'width': '100%'
  });

  $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
    var selectedKodePT = $(this).val().trim(); // Mendapatkan nilai yang dipilih pada elemen select
    dataTable.column(1).search(selectedKodePT).draw();
  });

  $('#kode_pt_riwayat').select2().on("change", function (e) { //Search by Kode PT
    var selectedKodePTRiwayat = $(this).val().trim(); // Mendapatkan nilai yang dipilih pada elemen select
    dataTable_riwayat.column(1).search(selectedKodePTRiwayat).draw();
  });

  // Sembunyikan alert flash message setelah 3 detik (3000 ms)
  setTimeout(function () {
    $('#flash-message').fadeOut('slow');
  }, 2000); // 3 detik
});

function confirmDelete(id) {
  Swal.fire({
    title: "Yakin?",
    text: "Anda akan menghapus data ini!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Tidak!",
    confirmButtonText: "Yes, hapus!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Berhasil!",
        text: "Data telah dihapus.",
        icon: "success"
      }).then(() => {
        // Setelah pengguna klik tombol OK, baru proses penghapusan dilakukan
        window.location.href = "https://dashboard-lldikti3.kemdikbud.go.id/admin/hapus-kip-kuliah/" + id;
      });
    }
  });

  // if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
  // Jika konfirmasi "Ya", kirim permintaan ke server untuk menghapus data
  // window.location.href = "https://dashboard-lldikti3.kemdikbud.go.id/admin/hapus-kip-kuliah/" + id;
  // }
  // Jika user klik "No", tidak terjadi apa-apa, alert ditutup
}

function openEditModal(id, tahun, kuota_reguler, kuota_usulan) {
  // Isi form di modal dengan data yang ada menggunakan jQuery
  $('#edit_id').val(id);
  $('#edit_tahun').val(tahun);
  $('#edit_kuota_reguler').val(kuota_reguler);
  $('#edit_kuota_usulan').val(kuota_usulan);

  // Tampilkan modal menggunakan jQuery
  $('#editModal').modal('show');
}

document.getElementById('truncateButton').addEventListener('click', function () {
  // SweetAlert2 Konfirmasi
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Jika pengguna mengkonfirmasi, redirect ke controller truncate
      window.location.href = "<?php echo base_url('admin/truncate-data-penjaminan-mutu";
    }
  });
});