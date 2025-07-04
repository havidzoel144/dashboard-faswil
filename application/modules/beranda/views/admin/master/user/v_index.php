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
              <h4 class="card-title" id="heading-buttons1">List Data User</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <button type="button" class="btn btn-primary waves-effect waves-light mr-1" data-toggle="modal" data-tambah-data="false" data-target="#form-tambah-data" id="btn-tambah-data">Tambah Data</button>
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
                              <div class="status-toggle d-inline-block w-100 text-center" data-status="<?= $data->status ?>" data-id="<?= $data->id ?>" style="cursor: pointer;">
                                <?php if ($data->status == '1'): ?>
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
<div class="modal fade text-left" id="form-tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
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
        <fieldset class="form-group d-flex justify-content-center align-items-center mb-1">
          <div class="row w-100">
            <div class="col-6 pr-1">
                <button type="button" class="btn w-100 d-flex align-items-center justify-content-center" id="btn-input-manual"
                style="height: 40px; background: linear-gradient(135deg, #ff9800 0%, #ff5722 100%); color: #fff; border-radius: 20px; font-size: 1.2em; box-shadow: 0 2px 8px rgba(255,152,0,0.2); transition: background 0.3s;">
                <i class="la la-keyboard-o mr-1"></i>
                <span style="font-size: 1em;">Input Manual</span>
                </button>
            </div>
            <div class="col-6 pl-1">
              <button type="button" class="btn w-100 d-flex align-items-center justify-content-center" id="btn-ambil-dosen"
                style="height: 40px; background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%); color: #000; border-radius: 20px; font-size: 1.2em; box-shadow: 0 2px 8px rgba(0,201,255,0.2); transition: background 0.3s;">
                <i class="la la-user-plus mr-1"></i>
                <span style="font-size: 1em;">Ambil Data Dosen</span>
              </button>
            </div>
          </div>
        </fieldset>
        <fieldset class="form-group">
          <label for="nama">Nama User</label>
          <input type="text" class="form-control square" id="nama" name="nama" placeholder="Masukkan Nama Lengkap User" disabled>
        </fieldset>
        <fieldset class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control square" id="username" name="username" placeholder="Masukkan Username" disabled>
        </fieldset>
        <fieldset class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control square" id="email" name="email" placeholder="Masukkan Alamat Email" disabled>
        </fieldset>
        <fieldset class="form-group">
          <label for="role">Role</label>
          <select class="select2 form-control" aria-hidden="true" multiple="multiple" name="role_id[]" id="role" style="width:100%;" disabled>
            <?php foreach ($data_role as $role) : ?>
              <?php if (in_array($role->id, $allowed_ids)) : ?>
                <option value="<?= $role->id ?>"><?= ucwords($role->nama_role) ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </fieldset>
        <fieldset class="form-group">
          <label for="status-switch">Status</label>
          <input type="checkbox" id="status-switch" name="status" class="switchery" value="1" checked />
          <medium id="label-status" class="font-weight-bolder">Aktif</medium>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary d-none" id="btn-simpan">Simpan</button>
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
            <?php foreach ($data_role as $role) : ?>
              <?php if (in_array($role->id, $allowed_ids)) : ?>
                <option value="<?= $role->id ?>"><?= ucwords($role->nama_role) ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
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

<!-- Modal Data Dosen -->
<div class="modal fade" id="modal-dosen" tabindex="-1" role="dialog" aria-labelledby="modalDosenLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDosenLabel">Pilih Data Dosen</h5>
        <button type="button" class="close btn-close-dosen" aria-label="Close" style="color: #000;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabel-dosen" style="width: 100%;">
            <thead>
              <tr>
                <th class="text-center">NIDN</th>
                <th class="text-center">Nama Dosen</th>
                <th class="text-center">Nama PT</th>
                <th class="text-center"">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Data Dosen -->

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
      // text: "Apakah anda yakin ingin mereset password akun ini?",
      html: `Apakah anda yakin ingin mereset password akun ini? <br>
            Password standar adalah <b>123456</b>`,
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

  $('#form-tambah-data').on('shown.bs.modal', function() {
    $("#role").select2({
      placeholder: "Silakan pilih role user (bisa pilih lebih dari 1)",
      allowClear: true,
      dropdownParent: $('#form-tambah-data')
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
                statusElement.html(`
                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #dc3545 0%, #b52a37 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                  <i class="la la-times-circle mr-1"></i> Non Aktif
                  </span>
                `);
                statusElement.data('status', '0');
              } else {
                statusElement.html(`
                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #28a745 0%, #218838 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                  <i class="la la-check-circle mr-1"></i> Aktif
                  </span>
                `);
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

  // Inisialisasi DataTable hanya sekali dengan server-side processing
  var tabelDosen = null;

  function initTabelDosen() {
    if (!$.fn.DataTable.isDataTable('#tabel-dosen')) {
      tabelDosen = $('#tabel-dosen').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        autoWidth: false, // tambahkan ini
        ajax: {
          url: '<?= base_url('admin/ajax-get-dosen') ?>',
          type: 'POST',
          data: function(d) {
            // Ambil token terbaru dari variabel global
            d[csrfName] = csrfHash;
          },
          dataSrc: function(json) {
            // Update token setelah respon
            csrfHash = json.csrfHash;
            return json.data; // data harus ada untuk DataTables
          }
        },
        columns: [
          {
            data: 'nidn',
            className: 'text-center',
            width: '12%'
          },
          {
            data: 'nama',
            width: '35%'
          },
          {
            data: 'nm_pt',
            width: '50%'
          },
          {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '3%',
            render: function(data, type, row) {
              return `<button type="button" class="btn btn-primary round btn-sm pilih-dosen"
          data-nidn="${row.nidn ? row.nidn : ''}"
          data-nama="${row.nama ? row.nama.replace(/"/g, '&quot;') : ''}"">
          Pilih
              </button>`;
            }
          }
        ],
        destroy: true,
        language: {
          emptyTable: "Data dosen tidak tersedia"
        }
      });
    }
  }

  $('#btn-ambil-dosen').on('click', function() {
    $('#modal-dosen').modal({
      backdrop: 'static',
      keyboard: false
    }).modal('show');

    // Inisialisasi DataTable jika belum, reload jika sudah
    if (!$.fn.DataTable.isDataTable('#tabel-dosen')) {
      initTabelDosen();
    } else {
      tabelDosen.ajax.reload(null, false);
    }
  });

  // Event delegation untuk tombol pilih pada hasil ajax
  $(document).on('click', '.pilih-dosen', function() {
    var nidn = $(this).data('nidn');
    var nama = $(this).data('nama');
    $('#nama').val(nama);
    $('#username').val(nidn);
    $('#email').focus();
    $('#modal-dosen').modal('hide');
    $('#nama, #email, #username, #role, #status-switch').prop('disabled', false);

    
    if (nidn !== ''){
      console.log('nidn:', nidn);
      $('#username').prop('readonly', true); // Set username readonly
    } else {
      $('#username').prop('readonly', false); // Set username editable
    }

    $('#role').val(null).trigger('change'); // Kosongkan select2
    $('#status-switch').prop('checked', true).trigger('change'); // Set status ke Aktif
    $('#nama').focus(); // Fokus ke input nama
    $('#btn-simpan').removeClass('d-none'); // Tampilkan tombol simpan
  });

  $(document).on('click', '#btn-tambah-data', function() {
    $('#btn-simpan').addClass('d-none'); // Sembunyikan tombol simpan saat modal dibuka
    $('#nama, #username, #email, #role, #status-switch').prop('disabled', true); // Nonaktifkan input
    $('#nama, #username, #email').val(''); // Kosongkan input
    $('#role').val(null).trigger('change'); // Kosongkan select2
  });

  $('.btn-close-dosen').on('click', function() {
    $('#modal-dosen').modal('hide');
  });
  
  $('#btn-input-manual').on('click', function() {
    $('#nama, #username, #email, #role, #status-switch').prop('disabled', false);
    $('#nama, #username, #email').val(''); // Kosongkan input
    $('#role').val(null).trigger('change'); // Kosongkan select2
    $('#status-switch').prop('checked', true).trigger('change'); // Set status ke Aktif
    $('#nama').focus(); // Fokus ke input nama
    $('#btn-simpan').removeClass('d-none'); // Tampilkan tombol simpan
  });
</script>