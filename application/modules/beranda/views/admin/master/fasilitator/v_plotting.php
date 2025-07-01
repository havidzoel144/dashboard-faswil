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
      <!-- Basic Horizontal Timeline -->
      <div class="row mb-3">
        <div class="col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">Data Plotting Fasilitator | <span class="badge badge-secondary font-medium-1"><?= $periode_dipilih->keterangan ?></span></h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <a href="<?= base_url('admin/plotting-fasilitator') ?>">
                  <button type="button" class="btn btn-light waves-effect waves-light">
                    Kembali
                  </button>
                </a>
                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-plotting-fasilitator="false" data-target="#plotting-fasilitator">Plotting Fasilitator</button>
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
                        <th class="text-center">Aksi</th>
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
                            <td class="text-center" style="width: 5%;">
                              <!-- <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button> -->
                              <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="confirmDelete('<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
                            </td>

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
</script>