<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<!-- BEGIN: Content-->
<div class="app-content content center-layout">
  <!-- untuk tidak full layar -->
  <!-- <div class="app-content content center-layout"> -->
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12 mx-auto">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">Periode Penilaian Fasilitator</h4>
            </div>
            <div class="dropdown-divider"></div>
            <div class="card-content">
              <div class="card-body">

                <div class="table-responsive">
                  <table id="tabel-penilaian" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_periode)) { // Cek apakah array data_pt_binaan tidak kosong
                        foreach ($data_periode as $data) {
                          $warna_baris = $data['status'] == '1' ? 'table-success' : '';
                      ?>
                          <tr class="<?= $warna_baris ?>">
                            <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                            <td class="text-center" style="width: 7%;"><?= $data['kode'] ?></td>
                            <td class="text-center" style="width: 20%;"><?= $data['keterangan'] ?></td>
                            <td class="text-center" style="width: 7%;">
                              <div class="d-inline-block w-100 text-center" data-status="<?= $data['status'] ?>" data-kode="<?= $data['kode'] ?>">
                                <?php if ($data['status'] == '1'): ?>
                                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #28a745 0%, #218838 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                                    <i class="la la-check-circle mr-1"></i> Aktif
                                  </span>
                                <?php else: ?>
                                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #dc3545 0%, #b52a37 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                                    <i class="la la-times-circle mr-1"></i> Non Aktif
                                  </span>
                                <?php endif; ?>
                              </div>
                            </td>
                            <td class="text-center" style="width: 8%;">
                              <?php if ($data['status'] == '1') : ?>
                                <a href="<?= base_url('admin/input-skor/') . safe_url_encrypt($data['kode']) ?>">
                                  <button class="btn btn-primary btn-sm" type="button" data-toggle="tooltip" title="Nilai">
                                    <i class="la la-edit"></i> Nilai
                                  </button>
                                </a>
                              <?php else: ?>
                                <a href="<?= base_url('admin/lihat-skor/') . safe_url_encrypt($data['kode']) ?>">
                                  <button class="btn btn-dark btn-sm" type="button" data-toggle="tooltip" title="Lihat">
                                    <i class="la la-eye"></i> Lihat
                                  </button>
                                </a>
                              <?php endif; ?>
                              <!-- <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick='modalRiwayat("<?= safe_url_encrypt($data->fasilitator_id) ?>", "<?= safe_url_encrypt($data->kode_pt) ?>", "<?= safe_url_encrypt($data->periode) ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Kirim ke Validator">
                                <i class="la la-send"></i>
                              </button> -->
                            </td>
                          </tr>
                        <?php
                        }
                      } else { // Jika data_pt_binaan kosong
                        ?>
                        <tr>
                          <td colspan="5" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>


                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var tabelPenilaian = $('#tabel-penilaian').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelPenilaian.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik

    var list_pt_options = {
      valueNames: ['nama_pt', 'kode_pt']
    };

    var ListPT = new List('list-pt', list_pt_options);
  });

  // Event click
  $(document).on('click', '.list-group-item', function() {
    var nama_pt = $(this).data('nama-pt');
    var kode_pt = $(this).data('kode-pt');
    $('#nama-pt').val(nama_pt);
    $('#kode-pt').val(kode_pt);

    $('#skor-1a').focus();

    // Kirim ke backend via AJAX
    // $.ajax({
    //   url: '<?= base_url("admin/get-user-detail") ?>',
    //   method: 'POST',
    //   data: {
    //     name: name,
    //     born: born
    //   },
    //   dataType: 'json',
    //   success: function(response) {
    //     // Isi ke input
    //     $('#inputName').val(response.name);
    //     $('#inputBorn').val(response.born);
    //   },
    //   error: function(xhr) {
    //     alert('Gagal mengambil data');
    //   }
    // });
  });

  $(document).on('submit', '#form-input-skor', function(event) {
    // let nama_pt = document.getElementById('nama-pt').value;
    let kode_pt = $('#kode-pt').val();
    let nama_pt = $('#nama-pt').val();
    let skor_1a = $('#skor-1a').val();
    let skor_1b = $('#skor-1b').val();
    let skor_2 = $('#skor-2').val();

    // Cegah submit form langsung
    event.preventDefault();

    if (kode_pt == '' || nama_pt == '') {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Silakan pilih perguruan tinggi terlebih dahulu',
        confirmButtonColor: '#dc3545'
      });
    }

    if (skor_1a == '' || skor_1b == '' || skor_2 == '') {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Isi skor terlebih dahulu',
        confirmButtonColor: '#dc3545'
      });
    }

    Swal.fire({
      title: 'Simpan Skor',
      text: "Apakah anda yakin ingin menyimpan skor " + nama_pt + "?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Gunakan native submit agar event berjalan normal
        document.getElementById('form-input-skor').submit();
      }
    });
  });

  function validateSkorInput(input) {
    let val = input.value;

    // Hapus semua kecuali angka dan titik
    val = val.replace(/[^0-9.]/g, '');

    // Hanya izinkan satu titik
    const parts = val.split('.');
    if (parts.length > 2) {
      val = parts[0] + '.' + parts[1]; // buang titik kelebihan
    }

    // Optional: Batasi hanya 1 digit setelah titik
    // val = val.replace(/^(\d+)\.(\d).*$/, '$1.$2');

    input.value = val;
  }

  function validateSkorValue(input) {
    const val = parseFloat(input.value.replace(',', '.'));
    if (val > 4) {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Nilai maksimal adalah 4',
        confirmButtonColor: '#dc3545'
      }).then(() => {
        // Fokus ke input setelah Swal ditutup
        input.value = '';
      });
    }
  }

  function validateMinSkorValue(input) {
    const val = parseFloat(input.value.replace(',', '.'));
    if (val < 2) {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Nilai minimal adalah 2',
        confirmButtonColor: '#dc3545'
      }).then(() => {
        // Fokus ke input setelah Swal ditutup
        input.value = '';
      });
    }
  }

  $(document).on('click', '.list-group-item', function() {
    // Hapus kelas aktif dari item lain
    $('.list-group-item').removeClass('active-item');

    // Tambahkan ke item yang diklik
    $(this).addClass('active-item');
  });
</script>