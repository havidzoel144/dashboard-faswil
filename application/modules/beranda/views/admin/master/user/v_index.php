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
      <!-- Basic Horizontal Timeline -->
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">List Data User</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <button type="button" class="btn btn-primary waves-effect waves-light mr-1" data-toggle="modal" data-tambah-data="false" data-target="#tambah-data">Tambah Data</button>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-user" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_user)) { // Cek apakah array data_user tidak kosong
                        foreach ($data_user as $data) {
                      ?>
                          <tr>
                            <td class="text-center" style="width: 5%;"><?= ++$i ?></td>
                            <td class="text-start" style="width: 15%;"><?= $data->nama ?></td>
                            <td class="text-start" style="width: 10%;"><?= $data->username ?></td>
                            <td class="text-start" style="width: 15%;"><?= $data->email ?></td>
                            <td class="text-start" style="width: 15%;"><?= ucwords($data->roles) ?></td>
                            <td class="text-center" style="width: 7%;">
                              <div class="status-toggle" data-status="<?= $data->status ?>" data-id="<?= $data->id ?>" style="cursor: pointer;">
                                <?= $data->status == '1'
                                  ? '<div class="badge bg-success block">Aktif</div>'
                                  : '<div class="badge bg-red block">Non Aktif</div>'
                                ?>
                              </div>
                            </td>
                            <td class="text-center" style="width: 10%;">
                              <button class="btn btn-dark btn-sm waves-effect waves-light" type="button" onclick="confirmResetPassword('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Reset Password"><i class="la la-key"></i></button>
                              <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button>
                              <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="confirmDelete('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
                            </td>

                          </tr>
                        <?php
                        }
                      } else { // Jika data_user kosong
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

<!-- MODAL TAMBAH START -->
<div class="modal fade text-left" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">TAMBAH DATA USER</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('admin/simpan-user'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="nama">Nama User</label>
          <input type="text" class="form-control square" id="nama" name="nama" placeholder="Masukkan Nama Lengkap User">
        </fieldset>
        <fieldset class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control square" id="username" name="username" placeholder="Masukkan Username">
        </fieldset>
        <fieldset class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control square" id="email" name="email" placeholder="Masukkan Alamat Email">
        </fieldset>
        <fieldset class="form-group">
          <label for="role">Role</label>
          <select class="select2 form-control" aria-hidden="true" multiple="multiple" name="role_id[]" id="role" style="width:100%;">
            <?php foreach ($data_role as $role) { ?>
              <option value="<?= $role->id ?>"><?= ucwords($role->nama_role) ?></option>
            <?php } ?>
          </select>
        </fieldset>
        <fieldset class="form-group">
          <label for="status-switch">Status</label>
          <input type="checkbox" id="status-switch" name="status" class="switchery" value="1" checked />
          <medium id="label-status" class="font-weight-bolder">Aktif</medium>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- MODAL TAMBAH END -->

<!-- MODAL UBAH START -->
<!-- Modal untuk mengubah data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">UBAH DATA USER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Form untuk memperbarui data -->
      <?php echo form_open(site_url('admin/update-user'), array('class' => 'form-horizontal', 'role' => 'form', 'id' =>  'form-update-data')); ?>
      <input type="hidden" id="edit-id" name="id"> <!-- Input tersembunyi untuk ID -->
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="edit-nama">Nama User</label>
          <input type="text" class="form-control square" id="edit-nama" name="nama" placeholder="Masukkan Nama Lengkap User">
        </fieldset>
        <fieldset class="form-group">
          <label for="edit-username">Username</label>
          <input type="text" class="form-control square" id="edit-username" name="username" placeholder="Masukkan Username" readonly>
        </fieldset>
        <fieldset class="form-group">
          <label for="edit-email">Email</label>
          <input type="email" class="form-control square" id="edit-email" name="email" placeholder="Masukkan Alamat Email">
        </fieldset>
        <fieldset class="form-group">
          <label for="edit-role">Role</label>
          <select class="select2 form-control" aria-hidden="true" multiple="multiple" name="role_id[]" id="edit-role" style="width:100%;">
            <?php foreach ($data_role as $role) { ?>
              <option value="<?= $role->id ?>"><?= ucwords($role->nama_role) ?></option>
            <?php } ?>
          </select>
        </fieldset>
        <fieldset class="form-group">
          <label for="edit-status-switch">Status</label><br>
          <input type="checkbox" id="edit-status-switch" name="status" class="switchery" value="1">
          <medium id="edit-label-status" class="font-weight-bolder">Aktif</medium>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="update-data">Update Data</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
      <!-- Form untuk memperbarui data -->
    </div>
  </div>
</div>
<!-- MODAL UBAH END -->

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
    var tabelUser = $('#tabel-user').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelUser.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik

    const switchEl = document.querySelector('#status-switch');
    const label = document.querySelector('#label-status');

    switchEl.addEventListener('change', function() {
      label.textContent = switchEl.checked ? 'Aktif' : 'Non Aktif';
    });

    if (typeof Switchery !== 'undefined') {
      document.querySelectorAll('.switchery').forEach(function(el) {
        new Switchery(el, {
          color: '#28a745',
          secondaryColor: '#ddd',
          size: 'small'
        });
      });
    } else {
      console.warn('Switchery plugin not loaded.');
    }

    const elem = document.querySelector('#edit-status-switch');

    // Event ubah label saat toggle diklik
    $('#edit-status-switch').on('change', function() {
      $('#edit-label-status').text(this.checked ? 'Aktif' : 'Non Aktif');
      this.value = this.checked ? '1' : '0';
    });
  });

  function confirmDelete(id) {
    // Decode dulu id yang sudah di urlencode
    var decodedId = decodeURIComponent(id);

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
        window.location.href = "<?= base_url('admin/hapus-user/') ?>" + decodedId;
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

  function confirmResetPassword(id) {
    Swal.fire({
      title: "Reset Password",
      text: "Apakah anda yakin ingin mereset password akun ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Tidak!",
      confirmButtonText: "Yes, reset!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= base_url('admin/reset-password-user/') ?>" + id;
      }
    });
  }

  $('#form-update-data').on('submit', function(event) {
    let username = document.getElementById('edit-username').value;

    // Cegah submit form langsung
    event.preventDefault();

    Swal.fire({
      title: 'Update Data',
      text: "Apakah anda yakin ingin mengupdate data " + username + "?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, update!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Gunakan native submit agar event berjalan normal
        document.getElementById('form-update-data').submit();
      }
    });
  });

  $('#tambah-data').on('shown.bs.modal', function() {
    $("#role").select2({
      placeholder: "Silakan pilih role user (bisa pilih lebih dari 1)",
      allowClear: true,
      dropdownParent: $('#tambah-data')
    });
  });

  // Handle status toggle click
  $('.status-toggle').on('click', function() {
    const status = $(this).data('status'); // Ambil status dari data-status
    const userId = $(this).data('id'); // Ambil ID user dari data-id

    const newStatus = status == '1' ? 'Non Aktif' : 'Aktif';

    // Menampilkan SweetAlert untuk konfirmasi
    Swal.fire({
      title: `Ubah Status ke ${newStatus}?`,
      text: "Apakah Anda yakin ingin mengubah status user ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: "Batal",
      confirmButtonText: `Ya, ubah ke ${newStatus}!`
    }).then((result) => {
      if (result.isConfirmed) {
        // Menambahkan CSRF token ke request
        $.ajax({
          url: '<?= base_url('admin/update-status-user') ?>', // Ganti dengan URL controller
          type: 'POST',
          data: {
            user_id: userId,
            status: status == '1' ? '0' : '1', // Ubah status
            [csrfName]: csrfHash // Pastikan menggunakan csrfName dan csrfHash yang benar
          },
          dataType: 'json', // Pastikan respons dikembalikan dalam format JSON
          success: function(response) {
            // Cek jika status berhasil diperbarui
            if (response.success) {
              // Update UI status
              const statusElement = $('[data-id="' + userId + '"]');
              if (status == '1') {
                statusElement.html('<div class="badge bg-red block">Non Aktif</div>');
                statusElement.data('status', '0');
              } else {
                statusElement.html('<div class="badge bg-success block">Aktif</div>');
                statusElement.data('status', '1');
              }
              Swal.fire('Berhasil!', `Status user berhasil diubah menjadi ${newStatus}.`, 'success');
            } else {
              Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status user.', 'error');
            }
          },
          error: function() {
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghubungi server.', 'error');
          }
        });
      }
    });
  });
</script>