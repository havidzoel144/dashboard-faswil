<?= $this->load->view('admin/v_header') ?>

<style>
  @media (max-width: 575.98px) {
    .display-4 {
      font-size: 2rem;
    }

    .card-title {
      font-size: 0.95rem !important;
    }
  }

  .card .rounded-circle {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .card {
    transition: all .2s ease;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, .15);
  }

  .stat-card {
    position: relative;
    padding: 22px 24px;
    border-radius: 16px;
    color: #fff;
    display: flex;
    align-items: center;
    /* justify-content: space-between; */
    overflow: hidden;
    /* cursor: pointer; */
    transition: all .35s ease;
  }

  .stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, .18);
  }

  .stat-icon {
    font-size: 36px;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: rgba(255, 255, 255, .2);
    margin-right: 16px;
  }

  .stat-icon i {
    font-size: 2.5rem !important;
  }

  .stat-content h3 {
    font-size: 34px;
    font-weight: 700;
    margin: 0;
  }

  .stat-content p {
    margin: 0;
    opacity: .9;
    font-size: 14px;
  }

  .stat-arrow {
    font-size: 22px;
    opacity: .7;
  }

  /* Gradient Colors */

  .stat-grey {
    background: linear-gradient(135deg, #9e9e9e, #616161);
  }

  .stat-blue {
    background: linear-gradient(135deg, #42a5f5, #1e88e5);
  }

  .stat-orange {
    background: linear-gradient(135deg, #ffb74d, #fb8c00);
  }

  .stat-red {
    background: linear-gradient(135deg, #ef5350, #c62828);
  }

  .stat-purple {
    background: linear-gradient(135deg, #ab47bc, #7b1fa2);
  }

  .stat-green {
    background: linear-gradient(135deg, #66bb6a, #2e7d32);
  }

  .stat-dark {
    background: linear-gradient(135deg, #546e7a, #263238);
  }

  .role-option {
    border: 2px solid #e5e5e5;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: all .25s ease;
  }

  .role-option:hover {
    border-color: #007bff;
    transform: translateY(-2px);
  }

  .role-option.active {
    border-color: #007bff;
    background: #eef5ff;
  }

  .role-option i {
    font-size: 22px;
    display: block;
    margin-bottom: 4px;
  }

  .form-section {
    display: none;
    animation: fadeIn .3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(5px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

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
      <!-- Basic Horizontal Timeline -->
      <div class="row mb-3">
        <div class="col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="d-flex align-items-center justify-content-between">
                <h4 class="card-title ml-1" id="heading-buttons1">Data Plotting Fasilitator | <span class="badge badge-secondary font-medium-1"><?= $periode_dipilih->keterangan ?></span></h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                <div class="d-flex align-items-center">
                  <?php if ($periode_dipilih->status == '1' && substr($periode_dipilih->kode, 0, 4) == date('Y')) : ?>
                    <button class="btn btn-success btn-ganti-faswil-validator" type="button" data-toggle="tooltip" title="Ganti Faswil / Validator" data-periode="<?= safe_url_encrypt($periode_dipilih->kode) ?>" data-keterangan="<?= $periode_dipilih->keterangan ?>">
                      <i class="la la-refresh"></i> Ganti Faswil / Validator
                    </button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-plotting-fasilitator="false" data-target="#plotting-fasilitator">
                      <i class="la la-plus"></i> Plotting Fasilitator
                    </button>
                  <?php endif; ?>
                  <?php echo form_close(); ?>
                  <a href="<?= base_url('admin/plotting-fasilitator') ?>">
                    <button type="button" class="btn btn-dark waves-effect waves-light">
                      <i class="la la-arrow-left"></i> Kembali
                    </button>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-plotting-fasilitator" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Nama Fasilitator</th>
                        <th class="text-center">Perguruan Tinggi</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Nama Validator</th>
                        <?php if ($periode_dipilih->status == '1' && substr($periode_dipilih->kode, 0, 4) == date('Y')) : ?>
                          <th class="text-center">Aksi</th>
                        <?php endif; ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_plotting_fasilitator)) { // Cek apakah array data_plotting_fasilitator tidak kosong
                        foreach ($data_plotting_fasilitator as $data) {
                      ?>
                          <tr>
                            <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                            <td class="text-start" style="width: 10%;"><?= $data->nama_fasilitator ?></td>
                            <td class="text-start" style="width: 20%;"><?= $data->nama_pt ?></td>
                            <td class="text-start" style="width: 13%;"><?= $data->keterangan ?></td>
                            <td class="text-start" style="width: 10%;"><?= $data->nama_validator == NULL ? '<div class="badge badge-danger">Belum ada validator</div>' : $data->nama_validator ?></td>
                            <?php if ($periode_dipilih->status == '1' && substr($periode_dipilih->kode, 0, 4) == date('Y')) : ?>
                              <td class="text-center" style="width: 5%;">
                                <!-- <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button> -->
                                <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="confirmDelete('<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
                              </td>
                            <?php endif; ?>
                          </tr>
                        <?php
                        }
                      } else { // Jika data_plotting_fasilitator kosong
                        ?>
                        <tr>
                          <td colspan="6" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
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

<!-- MODAL PLOTTING FASILITATOR START -->
<div class="modal fade text-left" id="plotting-fasilitator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">PLOTTING FASILITATOR
          <br>
          <span class="badge badge-primary font-medium-1"><?= $periode_dipilih->keterangan ?></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('admin/simpan-plotting-fasilitator'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-simpan-plotting-fasilitator')); ?>
      <input type="hidden" name="periode" value="<?= $periode_dipilih->kode ?>">
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="id-fasilitator">Nama Fasilitator</label>
          <select class="select2 form-control" aria-hidden="true" name="id_fasilitator" id="id-fasilitator" style="width:100%;">
            <option value="">Silakan pilih Fasilitator</option>
            <?php foreach ($data_user_fasilitator as $data) { ?>
              <option value="<?= $data->id ?>" <?= $data->status == '0' ? 'disabled' : '' ?>><?= ucwords($data->nama) ?> <?= $data->status == '0' ? '(Non Aktif)' : '' ?></option>
            <?php } ?>
          </select>
        </fieldset>

        <fieldset class="form-group">
          <label for="perguruan-tinggi">Perguruan Tinggi</label>
          <select class="select2 form-control" aria-hidden="true" multiple="multiple" name="perguruan_tinggi[]" id="perguruan-tinggi" style="width:100%;">
            <?php foreach ($data_perguruan_tinggi as $data) { ?>
              <option value="<?= trim($data->kode_pt) ?>" data-nama="<?= htmlspecialchars($data->nama_pt) ?>" <?= $data->disabled ? 'disabled' : '' ?>>
                <?= ucwords($data->nama_pt) ?>
              </option>
            <?php } ?>
          </select>
        </fieldset>

        <fieldset class="form-group">
          <label for="id-validator">Nama Validator</label>
          <select class="select2 form-control" aria-hidden="true" name="id_validator" id="id-validator" style="width:100%;" required>
            <option value="">Silakan pilih validator</option>
            <?php foreach ($data_user_validator as $data) { ?>
              <option value="<?= $data->id ?>" <?= $data->status == '0' ? 'disabled' : '' ?>><?= ucwords($data->nama) ?> <?= $data->status == '0' ? '(Non Aktif)' : '' ?></option>
            <?php } ?>
          </select>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="simpan-data">Simpan</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- MODAL PLOTTING FASILITATOR END -->

<!-- Modal Ganti Faswil / Validator -->
<div class="modal fade" id="modalGantiFaswilValidator" tabindex="-1" role="dialog" aria-labelledby="modalGantiFaswilValidatorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGantiFaswilValidatorLabel">Ganti Fasilitator / Validator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGantiFaswilValidator">
          <div class="form-group">
            <label for="periodePenilaian">Periode Penilaian</label>
            <input class="form-control" type="hidden" id="periodePenilaian" name="periodePenilaian" required readonly>
            <input class="form-control" type="text" id="keterangan" name="keterangan" required readonly>
          </div>

          <div class="form-group">
            <label>Tipe Pergantian</label>
            <div class="row">
              <div class="col-6">
                <div class="role-option" data-role="fasilitator">
                  <i class="la la-users text-primary"></i>
                  <strong>Fasilitator</strong>
                  <input type="radio" name="tipePergang" value="fasilitator" hidden>
                </div>
              </div>

              <div class="col-6">
                <div class="role-option" data-role="validator">
                  <i class="la la-user-secret text-danger"></i>
                  <strong>Validator</strong>
                  <input type="radio" name="tipePergang" value="validator" hidden>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group form-section" id="grupFasilitator" style="display: none;">
            <label for="selectFasilitator">Pilih Fasilitator</label>
            <select class="form-control select2" id="selectFasilitator" name="selectFasilitator">
              <option value="">-- Pilih Fasilitator --</option>
            </select>
          </div>
          <div class="form-group form-section" id="grupPTFaswil" style="display: none;">
            <label for="selectPTFaswil">Pilih Perguruan Tinggi (jika hanya beberapa PT saja yang dialihkan)</label>
            <select class="form-control select2" id="selectPTFaswil" name="selectPTFaswil" multiple>
              <option value="">-- Pilih Perguruan Tinggi --</option>
            </select>
          </div>
          <div class="alert alert-info alert-dismissible d-none" role="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-left: 4px solid #fff; color: #fff; margin-top: 1rem; padding: 1rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);" id="catatanFaswil">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
              <i class="la la-lightbulb-o" style="font-size: 1.5rem; flex-shrink: 0; margin-top: 2px;"></i>
              <div>
                <strong style="font-size: 0.95rem; display: block; margin-bottom: 4px;">💡 Catatan Penting</strong>
                <small style="font-size: 0.85rem; line-height: 1.5; opacity: 0.95;">
                  Pilih perguruan tinggi yang sesuai dengan fasilitator terpilih untuk menjaga konsistensi data penilaian. Abaikan jika tidak ada perubahan pada perguruan tinggi.
                </small>
              </div>
            </div>
          </div>
          <div class="form-group form-section" id="grupFasilitatorPengganti" style="display: none;">
            <label for="selectFasilitatorPengganti">Pilih Fasilitator Pengganti</label>
            <select class="form-control select2" id="selectFasilitatorPengganti" name="selectFasilitatorPengganti">
              <option value="">-- Pilih Fasilitator Pengganti --</option>
            </select>
          </div>

          <div class="form-group form-section" id="grupValidator" style="display: none;">
            <label for="selectValidator">Pilih Validator</label>
            <select class="form-control select2" id="selectValidator" name="selectValidator">
              <option value="">-- Pilih Validator --</option>
            </select>
          </div>
          <div class="form-group form-section" id="grupPTValidator" style="display: none;">
            <label for="selectPTValidator">Pilih Perguruan Tinggi (jika hanya beberapa PT saja yang dialihkan)</label>
            <select class="form-control select2" id="selectPTValidator" name="selectPTValidator" multiple>
              <option value="">-- Pilih Perguruan Tinggi --</option>
            </select>
          </div>
          <div class="alert alert-info alert-dismissible d-none" role="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-left: 4px solid #fff; color: #fff; margin-top: 1rem; padding: 1rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);" id="catatanValidator">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
              <i class="la la-lightbulb-o" style="font-size: 1.5rem; flex-shrink: 0; margin-top: 2px;"></i>
              <div>
                <strong style="font-size: 0.95rem; display: block; margin-bottom: 4px;">💡 Catatan Penting</strong>
                <small style="font-size: 0.85rem; line-height: 1.5; opacity: 0.95;">
                  Pilih perguruan tinggi yang sesuai dengan validator terpilih untuk menjaga konsistensi data penilaian. Abaikan jika tidak ada perubahan pada perguruan tinggi.
                </small>
              </div>
            </div>
          </div>
          <div class="form-group form-section" id="grupValidatorPengganti" style="display: none;">
            <label for="selectValidatorPengganti">Pilih Validator Pengganti</label>
            <select class="form-control select2" id="selectValidatorPengganti" name="selectValidatorPengganti">
              <option value="">-- Pilih Validator Pengganti --</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSimpanGanti">Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

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
    var plottingFasilitator = $('#tabel-plotting-fasilitator').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    plottingFasilitator.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik

    /* select role */
    $('.role-option').click(function() {
      $('.role-option').removeClass('active');
      $(this).addClass('active');
      let role = $(this).data('role');

      $('input[name="tipePergang"][value="' + role + '"]').prop('checked', true);

      /* reset semua field */
      $('#grupFasilitator, #grupFasilitatorPengganti, #grupValidator, #grupValidatorPengganti').hide();

      $('#selectFasilitator').val('').trigger('change');
      $('#selectFasilitatorPengganti').val('').trigger('change');
      $('#selectFasilitatorPengganti').prop('disabled', true);
      $('#selectValidator').val('').trigger('change');
      $('#selectValidatorPengganti').val('').trigger('change');
      $('#selectValidatorPengganti').prop('disabled', true);

      /* tampilkan sesuai tipe */
      if (role === 'fasilitator') {
        $('#grupFasilitator').slideDown(200);
        $('#grupFasilitatorPengganti').slideDown(200);
      }

      if (role === 'validator') {
        $('#grupValidator').slideDown(200);
        $('#grupValidatorPengganti').slideDown(200);
      }
    });

    /* validasi submit */
    $('#formGantiFaswilValidator').submit(function(e) {
      let tipe = $('input[name="tipePergang"]:checked').val();
      if (!tipe) {
        alert('Silakan pilih tipe pergantian terlebih dahulu');
        e.preventDefault();
        return false;
      }
    });
  });

  function confirmDelete(id) {
    var encrypt_id = id;

    Swal.fire({
      title: "Hapus Data",
      text: "Apakah anda yakin ingin menghapus data ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Tidak!",
      confirmButtonText: "Yes, hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= base_url('admin/hapus-plotting/') ?>" + encrypt_id;
      }
    });
  }

  // Saat modal edit dibuka, set nilai awal
  function openEditModal(id, nama, username, email, role_id, status) {
    $('#edit-id').val(id);
    $('#edit-nama').val(nama);
    $('#edit-username').val(username);
    $('#edit-email').val(email);

    // role_id berupa string "1, 2, 3" -> ubah jadi array ["1","2","3"]
    let roleArray = role_id.split(',').map(function(item) {
      return item.trim(); // hapus spasi
    });

    // Set nilai select2 multiple
    $('#edit-role').val(roleArray).trigger('change');

    // Set status checkbox (dengan Switchery)
    const statusCheckbox = document.querySelector('#edit-status-switch');
    if (parseInt(status) === 1) {
      if (!statusCheckbox.checked) {
        statusCheckbox.click();
      }
      statusCheckbox.value = '1';
      $('#edit-label-status').text('Aktif');
    } else {
      if (statusCheckbox.checked) {
        statusCheckbox.click();
      }
      statusCheckbox.value = '0';
      $('#edit-label-status').text('Non Aktif');
    }

    $('#editModal').modal('show');
  }

  $('#form-simpan-plotting-fasilitator').on('submit', function(event) {
    event.preventDefault(); // Cegah submit bawaan

    Swal.fire({
      title: 'Simpan Data',
      text: "Apakah anda yakin ingin menyimpan plotting fasilitator ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        let id_fasilitator = $('#id-fasilitator').val();
        let id_validator = $('#id-validator').val();
        if (id_fasilitator === id_validator) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Fasilitator dan Validator tidak boleh sama!',
            confirmButtonText: 'OK'
          });
          return; // Hentikan eksekusi jika validasi gagal
        }
        // Ambil option yang dipilih dari select perguruan_tinggi
        let selectedOptions = $('#perguruan-tinggi option:selected');

        // Hapus input hidden nama_pt[] sebelumnya jika ada
        $('#form-simpan-plotting-fasilitator').find('input[name="nama_pt[]"]').remove();

        // Tambahkan input hidden nama_pt[] untuk setiap option yang dipilih
        selectedOptions.each(function() {
          let namaPt = $(this).data('nama');
          $('<input>').attr({
            type: 'hidden',
            name: 'nama_pt[]',
            value: namaPt
          }).appendTo('#form-simpan-plotting-fasilitator');
        });

        // Submit ulang form secara native
        document.getElementById('form-simpan-plotting-fasilitator').submit();
      }
    });
  });

  $('#plotting-fasilitator').on('shown.bs.modal', function() {
    $("#perguruan-tinggi").select2({
      placeholder: "Silakan pilih Perguruan Tinggi (bisa pilih lebih dari 1)",
      allowClear: true,
      dropdownParent: $('#plotting-fasilitator')
    });
  });

  $(document).on('click', '.btn-ganti-faswil-validator', function(event) {
    event.preventDefault();
    $('.role-option').removeClass('active');
    $('#grupFasilitator, #grupFasilitatorPengganti, #grupValidator, #grupValidatorPengganti, #grupPTFaswil').hide();
    $('#selectFasilitator').val('').trigger('change');
    $('#selectFasilitatorPengganti').val('').trigger('change');
    $('#selectValidator').val('').trigger('change');
    $('#selectValidatorPengganti').val('').trigger('change');

    const periode = $(this).data('periode');
    const keterangan = $(this).data('keterangan');

    $.ajax({
      url: '<?= site_url('admin/get-faswil-validator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectFasilitator').val('').trigger('change');
        $('#selectValidator').val('').trigger('change');
        $('#selectFasilitatorPengganti').val('').trigger('change');
        $('#selectValidatorPengganti').val('').trigger('change');

        if (response.all_fasilitators) {
          response.all_fasilitators.forEach(function(item) {
            $('#selectFasilitator').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectFasilitatorPengganti').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectFasilitatorPengganti').prop('disabled', true);
          });
        }

        if (response.all_validators) {
          response.all_validators.forEach(function(item) {
            $('#selectValidator').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectValidatorPengganti').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectValidatorPengganti').prop('disabled', true);
          });
        }

        $('#periodePenilaian').val(response.enc_periode);
        $('#keterangan').val(keterangan);
        $('#modalGantiFaswilValidator').modal('show');
      }
    });
  });

  $(document).on('change', '#selectFasilitator', function() {
    const periode = $('#periodePenilaian').val();
    const idFasilitator = $(this).val();

    // ⛔ STOP kalau kosong
    if (!idFasilitator) {
      $('#grupPTFaswil').hide();
      $('#catatanFaswil').addClass('d-none');
      return;
    }

    $.ajax({
      url: '<?= site_url('admin/get-pt-binaan-fasilitator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        idFasilitator: idFasilitator,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectPTFaswil').select2({
          width: '100%',
          placeholder: '-- Pilih Perguruan Tinggi --',
          allowClear: true
        });

        if (response.data && response.data.length > 0) {
          $('#selectPTFaswil').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          response.data.forEach(function(item) {
            $('#selectPTFaswil').append('<option value="' + item.kode_pt + '">' + item.nama_pt + '</option>');
          });
          $('#grupPTFaswil').show();
          $('#catatanFaswil').removeClass('d-none');
          $('#selectFasilitatorPengganti').prop('disabled', false);
        } else {
          Swal.fire({
            title: 'Informasi',
            text: 'Tidak ada PT binaan untuk fasilitator yang dipilih',
            icon: 'info',
            confirmButtonText: 'OK'
          });
          $('#selectPTFaswil').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          $('#grupPTFaswil').hide();
          $('#catatanFaswil').addClass('d-none');
          $('#selectFasilitatorPengganti').val('').trigger('change');
          $('#selectFasilitatorPengganti').prop('disabled', true);
        }
      }
    });
  });

  $(document).on('change', '#selectValidator', function() {
    const periode = $('#periodePenilaian').val();
    const idValidator = $(this).val();

    // ⛔ STOP kalau kosong
    if (!idValidator) {
      $('#grupPTValidator').hide();
      $('#catatanValidator').addClass('d-none');
      return;
    }

    $.ajax({
      url: '<?= site_url('admin/get-pt-binaan-validator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        idValidator: idValidator,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectPTValidator').select2({
          width: '100%',
          placeholder: '-- Pilih Perguruan Tinggi --',
          allowClear: true
        });

        if (response.data && response.data.length > 0) {
          $('#selectPTValidator').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          response.data.forEach(function(item) {
            $('#selectPTValidator').append('<option value="' + item.kode_pt + '">' + item.nama_pt + '</option>');
          });
          $('#grupPTValidator').show();
          $('#catatanValidator').removeClass('d-none');
          $('#selectValidatorPengganti').prop('disabled', false);
        } else {
          Swal.fire({
            title: 'Informasi',
            text: 'Tidak ada PT binaan untuk validator yang dipilih',
            icon: 'info',
            confirmButtonText: 'OK'
          });
          $('#selectPTValidator').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          $('#grupPTValidator').hide();
          $('#catatanValidator').addClass('d-none');
          $('#selectValidatorPengganti').val('').trigger('change');
          $('#selectValidatorPengganti').prop('disabled', true);
        }
      }
    });
  });

  $(document).on('click', '#btnSimpanGanti', function() {
    let tipe = $('input[name="tipePergang"]:checked').val();
    if (!tipe) {
      Swal.fire({
        title: 'Peringatan!',
        text: 'Silakan pilih tipe pergantian terlebih dahulu.',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return false;
    }

    let fieldName = tipe === 'fasilitator' ? 'Fasilitator' : 'Validator';
    let selected = $('#select' + fieldName).val();
    let selectedReplacement = $('#select' + fieldName + 'Pengganti').val();

    if (!selected || !selectedReplacement) {
      Swal.fire({
        title: 'Peringatan!',
        text: 'Pilih ' + fieldName.toLowerCase() + ' terlebih dahulu.',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    const data = {
      tipe: tipe,
      periode: $('#periodePenilaian').val(),
      idFasilitator: $('#selectFasilitator').val(),
      idValidator: $('#selectValidator').val(),
      idFasilitatorPengganti: $('#selectFasilitatorPengganti').val(),
      idValidatorPengganti: $('#selectValidatorPengganti').val(),
      PTFaswil: $('#selectPTFaswil').val(),
      PTValidator: $('#selectPTValidator').val(),
    };

    Swal.fire({
      title: 'Ubah ' + fieldName + '?',
      text: 'Apakah anda yakin ingin mengubah ' + fieldName.toLowerCase() + '?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('admin/update-faswil-validator') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            ...data,
            '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
          },
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Berhasil!',
                text: response.message,
                icon: 'success'
              }).then(() => {
                $('#modalGantiFaswilValidator').modal('hide');
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Gagal!',
                text: response.message || 'Terjadi kesalahan.',
                icon: 'error'
              });
            }
          },
          error: function() {
            Swal.fire({
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat mengubah data.',
              icon: 'error'
            });
          }
        });
      }
    });
  });
</script>