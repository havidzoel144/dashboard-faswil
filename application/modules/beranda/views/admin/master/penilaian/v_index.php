<?= $this->load->view('admin/v_header') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

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
      <div class="row match-height">
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="list-basic">Perguruan Tinggi</h4>
            </div>
            <div class="card-body">

              <div id="list-pt">
                <input type="text" class="search form-control round border-primary mb-1" placeholder="Cari">
                <ul class="list-group list">
                  <?php if (!empty($data_pt_binaan)) : ?>
                    <?php foreach ($data_pt_binaan as $data) : ?>
                      <?php
                      $sudah_input = !is_null($data->skor_1a);
                      $item_class = $sudah_input ? 'bg-success text-white' : '';
                      ?>
                      <li class="list-group-item <?= $item_class ?>" data-nama-pt="<?= $data->nama_pt ?>" data-kode-pt="<?= $data->kode_pt ?>">

                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h3 class="nama_pt" style="margin-bottom: 0;"><?= $data->nama_pt ?></h3>
                            <p class="kode_pt" style="margin-bottom: 0;"><?= $data->kode_pt ?></p>
                          </div>
                          <?php if ($sudah_input) : ?>
                            <span class="badge badge-light custom-badge">Sudah input</span>
                          <?php endif; ?>
                        </div>

                      </li>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <li class="list-group-item">
                      <h3 class="nama_pt">Belum ada data</h3>
                      <p class="kode_pt">-</p>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-8 col-md-6 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">Input Skor</h4>
            </div>
            <div class="dropdown-divider"></div>
            <div class="card-content">
              <div class="card-body">

                <div class="row">
                  <div class="col-sm-12">
                    <?php echo form_open(site_url('admin/simpan-skor'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-input-skor')); ?>

                    <div class="row">
                      <div class="col-lg-3">
                        <fieldset class="form-group mb-1">
                          <label for="kode-pt">Kode PT</label>
                          <input type="text" class="form-control square" id="kode-pt" name="kode_pt" readonly>
                        </fieldset>
                      </div>
                      <div class="col-lg-9">
                        <fieldset class="form-group mb-1">
                          <label for="nama-pt">Nama PT</label>
                          <input type="text" class="form-control square" id="nama-pt" name="nama_pt" readonly>
                        </fieldset>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <fieldset class="form-group mb-1">
                          <label for="skor-1a">
                            Skor 1a
                            <span class="text-danger" data-toggle="popover" data-content="<b>Skor 0 :</b> PT tidak menjalankan SPMI; <br> <b>Skor 1 :</b> PT telah menjalankan SPMI namun belum mencakup seluruhnya; <br> <b>Skor 2 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek; <br> <b>Skor 3 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek dan memiliki standar yang melampaui SN Dikti; <br> <b>Skor 4 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek dan memiliki standar yang melampaui SN Dikti dan menerapkan SPMI berbasis resiko (risk based audit) atau inovasi lainnya" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                          </label>
                          <input type="text" class="form-control square skor" id="skor-1a" name="skor_1a" maxlength="4" oninput="validateSkorInput(this)" onblur="validateSkorValue(this)">
                        </fieldset>
                      </div>
                      <div class="col-lg-9">
                        <fieldset class="form-group mb-1">
                          <label for="catatan-1a">Catatan Skor 1a</label>
                          <textarea class="form-control textarea-catatan" name="catatan_1a" id="catatan-1a" placeholder="Berikan catatan untuk skor 1a"></textarea>
                        </fieldset>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <fieldset class="form-group mb-1">
                          <label for="skor-1b">
                            Skor 1b
                            <span class="text-danger" data-toggle="popover" data-content="<b>Tidak ada Skor dibawah 2;</b> <br> <b>Skor 2 :</b> PT tidak memiliki bukti sahis terkait praktik baik pengembangan buday amutu di PT melalui RTM; <br> <b>Skor 3 :</b> PT memiliki bukti sahih terkait praktik baik pengembangan budaya mutu di PT melalui RTM yang mengagendakan pembahasan sebagian dari 7 unsur; <br> <b>Skor 4 :</b> PT memiliki bukti sahih terkait praktik baik pengembangan budaya mutu di PT melalui RTM yang mengagendakan pembahasan dari 7 unsur" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                          </label>
                          <input type="text" class="form-control square skor" id="skor-1b" name="skor_1b" maxlength="4" oninput="validateSkorInput(this)" onblur="validateMinSkorValue(this)">
                        </fieldset>
                      </div>
                      <div class="col-lg-9">
                        <fieldset class="form-group mb-1">
                          <label for="catatan-1b">Catatan Skor 1b</label>
                          <textarea class="form-control textarea-catatan" name="catatan_1b" id="catatan-1b" placeholder="Berikan catatan untuk skor 1b"></textarea>
                        </fieldset>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <fieldset class="form-group mb-1">
                          <label for="skor-2">
                            Skor 2
                            <span class="text-danger" data-toggle="popover" data-content="<b>Skor 0 :</b> PT belum melaksanakan sistem penjaminan mutu; <br> <b>Skor 1 :</b> PT telah melaksanakan sistem penjaminan mutu namun belum efektif serta belum memenuhi seluruh aspek; <br> <b>Skor 2 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek; <br> <b>Skor 3 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek dan dilakukan review terhadap siklus penjamnan mutu; <br> <b>Skor 4 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek dan dilakukan review terhadap siklus penjamnan mutu dan melibatkan reviewer eksternal" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                          </label>
                          <input type="text" class="form-control square skor" id="skor-2" name="skor_2" maxlength="4" oninput="validateSkorInput(this)" onblur="validateSkorValue(this)">
                        </fieldset>
                      </div>
                      <div class="col-lg-9">
                        <fieldset class="form-group mb-1">
                          <label for="catatan-2">Catatan Skor 2</label>
                          <textarea class="form-control textarea-catatan" name="catatan_2" id="catatan-2" placeholder="Berikan catatan untuk skor 2"></textarea>
                        </fieldset>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <fieldset class="form-group mb-1">
                          <label for="catatan-keseluruhan">Catatan Keseluruhan</label>
                          <textarea class="form-control textarea-catatan" name="catatan_keseluruhan" id="catatan-keseluruhan" placeholder="Berikan catatan keseluruhan"></textarea>
                        </fieldset>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Skor</button>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Basic Horizontal Timeline -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" id="heading-buttons1">Data Penilaian Tipologi</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table id="tabel-penilaian" class="table table-striped table-bordered">
                  <thead>
                    <tr style="background-color: #563BFF; color: #ffffff">
                      <th class="text-center" rowspan="3">#</th>
                      <th class="text-center" rowspan="3">Periode <span class="text-danger" data-toggle="popover" data-content="Periode 1 : Januari - Juni <br> Periode 2 : Juli - November" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                      <th class="text-center" rowspan="3">Kode PT</th>
                      <th class="text-center" rowspan="3">Nama PT</th>
                      <th class="text-center" colspan="3">Butir Penilaian</th>
                      <th class="text-center" rowspan="3">
                        Skor <br> Total <br>
                        <span class="text-danger" data-toggle="popover" data-content="Skor Total =((Skor 1a+(2*Skor 1b))/3)x2,22)+(Skor 2 x 2,78)" data-trigger="hover" data-original-title="Formula Perhitungan"><i class="la la-info-circle"></i></span>
                      </th>
                      <th class="text-center" rowspan="3">
                        Tipologi
                        <span class="text-danger" data-toggle="popover" data-content="Tipologi 1 rentang Nilai Terbobot : 17,5 < n ≤ 20; <br> Tipologi 2 rentang Nilai Terbobot : 15 < n ≤ 17,5; <br> Tipologi 3 rentang Nilai Terbobot : 10 ≤ n ≤ 15; <br> Tipologi 4 Nilai Terbobot : < 10;" data-trigger="hover" data-original-title="Ketentuan Tipologi" data-html="true"><i class="la la-info-circle"></i></span>
                      </th>
                      <th class="text-center" rowspan="3">Status</th>
                      <th class="text-center" rowspan="3">Validator</th>
                      <th class="text-center" rowspan="3">Aksi</th>
                    </tr>
                    <tr style="background-color: #563BFF; color: #ffffff">
                      <th class="text-center" colspan="2">Butir 1 <br> (Bobot 2,22)</th>
                      <th class="text-center">Butir 2 <br> (Bobot 2,78)</th>
                    </tr>
                    <tr style="background-color: #563BFF; color: #ffffff">
                      <th class="text-center text-wrap">Skor 1a <span class="text-danger" data-toggle="popover" data-content="Ketersediaan dokumen formal SPMI yang dibuktikan dengan keberadaan 5 aspek sebagai berikut: <br> (1) organ/fungsi spmi, <br> (2) dokumen SPMI <br> (3) auditor internal <br> (4) hasil audit <br> (5) bukti tndak lanjut" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                      <th class="text-center text-wrap">Skor 1b <span class="text-danger" data-toggle="popover" data-content="Ketersediaan bukti sahih terkait praktik baik  pengembangan budaya mutu di perguruan tinggi melalui RTM yang mengagendakan unsur-unsur <br> (1) hasil audit internal <br> (2) umpan balik <br> (3) kinerja proses dan kesesuaian produk <br> (4) status tindakan pencegahan dan perbaikan <br> (5) tindak lanjut dari tinjauan sebelumnya <br> (6) perubahan yang dapat mempengaruhi sistem manajemen mutu <br> (7) rekomendasi peningkatan" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                      <th class="text-center text-wrap">Skor 2 <span class="text-danger" data-toggle="popover" data-content="Efektivitas pelaksanaan penjaminan mutu yang memenuhi 4 aspek sbb: <br> 1. keberadaan dokumen formal penetapan standar mutu <br> 2. standar mutu dilaksanakan secara konsisten <br> 3. minitoring evaluasi dan pengendalian terhadap standar mutu yang telah ditetapkan <br> 4. hasilnya ditindaklanjuti untuk perbaikan dan peningkatan mutu" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0; // Inisialisasi counter
                    if (!empty($data_pt_binaan)) { // Cek apakah array data_pt_binaan tidak kosong
                      foreach ($data_pt_binaan as $data) {
                        if (substr($data->periode, -1, 1 == '1')) {
                          $periode = substr($data->periode, 0, 4) . ' Periode 1';
                        } else {
                          $periode = substr($data->periode, 0, 4) . ' Periode 2';
                        }
                    ?>
                        <tr>
                          <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                          <td class="text-center" style="width: 10%;"><?= $periode ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->kode_pt ?></td>
                          <td class="text-start" style="width: 18%;"><?= $data->nama_pt ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->skor_1a ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->skor_1b ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->skor_2 ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->skor_total ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->tipologi ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->status ?></td>
                          <td class="text-start" style="width: 10%;"><?= $data->nama_validator == NULL ? '<div class="badge badge-danger">Belum ada validator</div>' : $data->nama_validator ?></td>
                          <td class="text-center" style="width: 8%;">
                            <a href="<?= base_url('admin/input-skor/') .
                                        safe_url_encrypt($data->fasilitator_id) . '/' .
                                        safe_url_encrypt($data->kode_pt) . '/' .
                                        safe_url_encrypt($data->periode)
                                      ?>">
                              <button class="btn btn-primary btn-sm" type="button" data-toggle="tooltip" title="Input Nilai">
                                <i class="la la-edit"></i>
                              </button>
                            </a>
                            <button class="btn btn-dark btn-sm waves-effect waves-light" type="button" onclick='modalRiwayat("<?= safe_url_encrypt($data->fasilitator_id) ?>", "<?= safe_url_encrypt($data->kode_pt) ?>", "<?= safe_url_encrypt($data->periode) ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Riwayat Penilaian">
                              <i class="la la-history"></i>
                            </button>
                          </td>
                        </tr>
                      <?php
                      }
                    } else { // Jika data_pt_binaan kosong
                      ?>
                      <tr>
                        <td colspan="7" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
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
    <!--/ Basic Horizontal Timeline -->
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