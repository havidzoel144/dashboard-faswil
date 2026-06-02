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
                              <div class="btn-group btn-group-sm" role="group" aria-label="Aksi pengguna">
                                <button class="btn btn-dark waves-effect waves-light" type="button" onclick="confirmResetPassword('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Reset Password"><i class="la la-key"></i></button>
                                <button class="btn btn-primary waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button>
                                <button class="btn btn-danger waves-effect waves-light" type="button" onclick="confirmDelete('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
                              </div>
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
          <div class="btn-group w-100" role="group">
            <button type="button" class="btn btn-primary flex-fill d-flex align-items-center justify-content-center" id="btn-input-manual">
              <i class="la la-keyboard-o mr-1"></i>
              <span>Input Manual</span>
            </button>
            <button type="button" class="btn btn-info flex-fill d-flex align-items-center justify-content-center" id="btn-ambil-dosen">
              <i class="la la-user-plus mr-1"></i>
              <span>Ambil Data Dosen</span>
            </button>
            <?php if (!in_array('1', array_column($this->session->userdata('roles'), 'role_id'))): ?>
              <?php if (false): ?>
                <button type="button" class="btn btn-dark flex-fill d-flex align-items-center justify-content-center" id="btn-ambil-pt">
                  <i class="la la-building mr-1"></i>
                  <span>Ambil Data PT</span>
                </button>
              <?php endif; ?>
              <button type="button" class="btn btn-dark flex-fill d-flex align-items-center justify-content-center" id="btn-generate-pt">
                <i class="la la-building mr-1"></i>
                <span>Generate User PT</span>
              </button>
            <?php endif; ?>
          </div>
        </fieldset>
        <fieldset class="form-group">
          <label for="nama">Nama User</label>
          <input type="text" class="form-control square" id="nama" name="nama" placeholder="Masukkan Nama Lengkap User" disabled>
        </fieldset>
        <fieldset class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control square" id="username" name="username" placeholder="Masukkan Username" disabled>
          <small class="form-text" style="color: #dc3545; font-weight: 600; display: block; margin-top: 0.5rem; padding: 0.5rem; background-color: #ffe5e5; border-left: 3px solid #dc3545; border-radius: 3px;">
            <i class="la la-info-circle mr-1"></i><strong>Password default:</strong> admin123
          </small>
        </fieldset>
        <fieldset class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control square" id="email" name="email" placeholder="Masukkan Alamat Email" disabled>
        </fieldset>
        <fieldset class="form-group">
          <label for="role">Role</label>
          <select class="select2 form-control" aria-hidden="true" multiple="multiple" name="role_id[]" id="role" style="width:100%;" disabled>
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
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Data Dosen -->

<!-- Modal Data PT -->
<div class=" modal fade" id="modal-pt" tabindex="-1" role="dialog" aria-labelledby="modalPTLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPTLabel">Pilih Data PT</h5>
        <button type="button" class="close btn-close-pt" aria-label="Close" style="color: #000;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabel-pt" style="width: 100%;">
            <thead>
              <tr>
                <th class="text-center">Kode PT</th>
                <th class="text-center">Nama PT</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Data Pt -->

<!-- MODAL GENERATE USER PT START -->
<div class="modal fade" id="modalGenerateUserPt" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title text-white">
          <i class="la la-building mr-1"></i>
          Generate User PT
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-light border">
          Sistem akan membuat akun user untuk seluruh Perguruan Tinggi yang belum memiliki akun.
        </div>
        <table class="table table-bordered">
          <tr>
            <th>Total Data PT</th>
            <td id="total-pt">0</td>
          </tr>
          <tr>
            <th>User Sudah Ada</th>
            <td>
              <a href="javascript:void(0)"
                id="btn-detail-sudah-ada"
                class="font-weight-bold text-success">
                <span id="total-user-ada">0</span>
              </a>
            </td>
          </tr>

          <tr>
            <th>User Belum Ada</th>
            <td>
              <a href="javascript:void(0)"
                id="btn-detail-belum-ada"
                class="font-weight-bold text-danger">
                <span id="total-user-belum">0</span>
              </a>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button"
          class="btn btn-secondary"
          data-dismiss="modal">
          Batal
        </button>
        <button type="button"
          class="btn btn-dark"
          id="btn-proses-generate">
          <i class="la la-check"></i>
          Generate Sekarang
        </button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL GENERATE USER PT END -->

<!-- MODAL DETAIL USER PT START -->
<div class="modal fade" id="modalDetailUserPt" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="detail-title">
          Detail PT
        </h5>
        <button type="button"
          class="close text-white"
          data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table-detail-user-pt" style="width: 100%;">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Kode PT</th>
                <th>Nama PT</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody id="detail-user-body">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DETAIL USER PT END -->


<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src=" <?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js">
</script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var tabelUser = $('#tabel-user').DataTable();
    var detailUserTable = null;

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

    // buka modal
    $('#btn-generate-pt').on('click', function() {
      $.ajax({
        url: '<?= base_url('admin/get-statistik-user-pt') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          $('#total-pt').text(res.total_pt);
          $('#total-user-ada').text(res.sudah_ada);
          $('#total-user-belum').text(res.belum_ada);
          $('#modalGenerateUserPt').modal('show');
        }
      });
    });

    // proses generate
    $('#btn-proses-generate').on('click', function() {
      Swal.fire({
        title: 'Generate User?',
        text: 'User PT yang belum ada akan dibuat otomatis.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Generate',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('admin/generate-user-pt') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
              [csrfName]: csrfHash
            },
            beforeSend: function() {
              $('#btn-proses-generate')
                .prop('disabled', true)
                .html('<i class="la la-spinner spinner"></i> Memproses...');
            },
            success: function(res) {
              $('#modalGenerateUserPt').modal('hide');
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                html: `
                <div class="text-left">
                  <p>User berhasil dibuat: <b>${res.berhasil}</b></p>
                  <p>User dilewati: <b>${res.skip}</b></p>
                </div>
              `
              });
            },
            complete: function() {
              $('#btn-proses-generate')
                .prop('disabled', false)
                .html('<i class="la la-check"></i> Generate Sekarang');
            }
          });
        }
      });
    });

    function loadDetailUser(type) {
      $.ajax({
        url: '<?= base_url('admin/detail-user-pt') ?>',
        type: 'GET',
        data: {
          type: type
        },
        dataType: 'json',
        beforeSend: function() {
          $('#detail-user-body').html(`
        <tr>
          <td colspan="4" class="text-center">
            <i class="la la-spinner spinner"></i> Loading...
          </td>
        </tr>
      `);
        },
        success: function(res) {
          let html = '';
          if (type === 'sudah') {
            $('#detail-title').text(
              'Daftar PT Yang Sudah Memiliki Akun'
            );
          } else {
            $('#detail-title').text(
              'Daftar PT Yang Belum Memiliki Akun'
            );
          }
          if (res.data.length === 0) {
            html += ``;
          } else {
            $.each(res.data, function(i, item) {
              html += `
            <tr>
              <td>${i + 1}</td>
              <td>${item.kode_pt}</td>
              <td>${item.nama_pt}</td>
              <td>${item.username}</td>
            </tr>
          `;
            });
          }
          // destroy datatable lama
          if ($.fn.DataTable.isDataTable('#table-detail-user-pt')) {
            $('#table-detail-user-pt').DataTable().destroy();
          }
          $('#detail-user-body').html(html);
          $('#modalDetailUserPt').modal('show');
          // init datatable baru
          detailUserTable = $('#table-detail-user-pt').DataTable({
            responsive: true,
            autoWidth: false,
            destroy: true,
            pageLength: 10,
            ordering: true,
            searching: true,
            lengthMenu: [
              [10, 25, 50, 100],
              [10, 25, 50, 100]
            ],
            language: {
              search: "Cari:",
              lengthMenu: "Tampilkan _MENU_ data",
              zeroRecords: "Data tidak ditemukan",
              info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
              infoEmpty: "Tidak ada data",
              paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
              }
            }
          });

          detailUserTable.on('order.dt search.dt draw.dt', function() {
            detailUserTable.column(0, {
              search: 'applied',
              order: 'applied'
            }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
            });
          }).draw();
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat mengambil data.'
          });
        }
      });
    }

    // klik sudah ada
    $(document).on('click', '#btn-detail-sudah-ada', function() {
      loadDetailUser('sudah');
    });

    // klik belum ada
    $(document).on('click', '#btn-detail-belum-ada', function() {
      loadDetailUser('belum');
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

    // Set role options berdasarkan role_id
    let roleOptions = <?= json_encode($data_role) ?>;

    $('#edit-role').empty();

    // Cek apakah roleArray mengandung id 6 atau 7
    let hasRolePT = roleArray.some(id => id == '6' || id == '7');
    let hasRoleSuperadmin = roleArray.some(id => id == '1' || id == '2' || id == '3'); // Cek role superadmin (1, 2, 3)

    if (hasRolePT) {
      // Jika ada role 6 atau 7, tampilkan hanya role 6 dan 7
      $.each(roleOptions, function(index, role) {
        if (role.id == 6 && roleArray.includes('6')) {
          $('#edit-role').append('<option value="' + role.id + '">PT ' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
        } else if (role.id == 7 && roleArray.includes('7')) {
          $('#edit-role').append('<option value="' + role.id + '">PT ' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
        }
      });
    } else if (hasRoleSuperadmin) {
      // Jika ada role 1, tampilkan hanya role 1
      $.each(roleOptions, function(index, role) {
        $('#edit-role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      });
    } else {
      // Jika tidak ada role 6 atau 7, tampilkan hanya role 4 dan 5
      $.each(roleOptions, function(index, role) {
        if (role.id == 4 || role.id == 5) {
          $('#edit-role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
        }
      });
    }

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
            Password standar adalah <b>admin123</b>`,
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
        columns: [{
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

  function initTabelPT() {
    if (!$.fn.DataTable.isDataTable('#tabel-pt')) {
      tabelPT = $('#tabel-pt').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        autoWidth: false, // tambahkan ini
        ajax: {
          url: '<?= base_url('admin/ajax-get-pt') ?>',
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
        columns: [{
            data: 'kode_pt',
            className: 'text-center',
            width: '12%'
          },
          {
            data: 'nama_pt',
            width: '50%'
          },
          {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            width: '3%',
            render: function(data, type, row) {
              return `<button type="button" class="btn btn-primary round btn-sm pilih-pt"
          data-kode-pt="${row.kode_pt ? row.kode_pt : ''}"
          data-nama-pt="${row.nama_pt ? row.nama_pt.replace(/"/g, '&quot;') : ''}"">
          Pilih
              </button>`;
            }
          }
        ],
        destroy: true,
        language: {
          emptyTable: "Data perguruan tinggi tidak tersedia"
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

  $('#btn-ambil-pt').on('click', function() {
    $('#modal-pt').modal({
      backdrop: 'static',
      keyboard: false
    }).modal('show');

    // Inisialisasi DataTable jika belum, reload jika sudah
    if (!$.fn.DataTable.isDataTable('#tabel-pt')) {
      initTabelPT();
    } else {
      tabelPT.ajax.reload(null, false);
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

    if (nidn !== '') {
      $('#username').prop('readonly', true); // Set username readonly
    } else {
      $('#username').prop('readonly', false); // Set username editable
    }

    // Hancurkan opsi role yang sudah ada, lalu isi dengan role untuk Dosen (id 4 dan 5)
    $('#role').empty();
    var data_role = <?= json_encode($data_role) ?>;
    $.each(data_role, function(index, role) {
      if (role.id == 4 || role.id == 5) {
        $('#role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      } else if (role.id == 1 || role.id == 2 || role.id == 3) {
        $('#role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      }
    });
    // Remove multiple attribute dan reinitialize select2
    $('#role').attr('name', 'role_id[]').attr('multiple', 'multiple');
    $('#role').select2({
      placeholder: "Silakan pilih role user (bisa pilih lebih dari 1)",
      allowClear: true,
      dropdownParent: $('#form-tambah-data')
    });
    $('#role').val(null).trigger('change'); // Kosongkan select2
    $('#status-switch').prop('checked', true).trigger('change'); // Set status ke Aktif
    $('#nama').focus(); // Fokus ke input nama
    $('#btn-simpan').removeClass('d-none'); // Tampilkan tombol simpan
  });

  $(document).on('click', '.pilih-pt', function() {
    var kode_pt = $(this).data('kode-pt');
    var nama_pt = $(this).data('nama-pt');
    $('#nama').val(nama_pt);
    $('#username').val(kode_pt);
    $('#email').focus();
    $('#modal-pt').modal('hide');
    $('#nama, #email, #username, #role, #status-switch').prop('disabled', false);

    if (kode_pt !== '') {
      $('#username').prop('readonly', true); // Set username readonly
    } else {
      $('#username').prop('readonly', false); // Set username editable
    }

    // Hancurkan opsi role yang sudah ada, lalu isi dengan role untuk PT (id 6 dan 7)
    $('#role').empty();
    $('#role').append('<option value="">Silakan pilih role user</option>');
    var data_role = <?= json_encode($data_role) ?>;
    var userRoles = <?= json_encode(array_column($this->session->userdata('roles'), 'role_id')) ?>;
    $.each(data_role, function(index, role) {
      if ((userRoles.includes('2') && role.id == 6) || (userRoles.includes('3') && role.id == 7)) {
        $('#role').append('<option value="' + role.id + '">PT ' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      }
    });
    // Remove multiple attribute dan reinitialize select2
    $('#role').attr('name', 'role_id[]').removeAttr('multiple');
    $('#role').select2({
      placeholder: "Silakan pilih role user",
      allowClear: true,
      dropdownParent: $('#form-tambah-data')
    });
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

  $('.btn-close-pt').on('click', function() {
    $('#modal-pt').modal('hide');
  });

  $('#btn-input-manual').on('click', function() {
    $('#nama, #username, #email, #role, #status-switch').prop('disabled', false);
    $('#nama, #username, #email').val(''); // Kosongkan input
    // Hancurkan opsi role yang sudah ada, lalu isi dengan role untuk Dosen (id 4 dan 5)
    $('#role').empty();
    var data_role = <?= json_encode($data_role) ?>;
    $.each(data_role, function(index, role) {
      if (role.id == 4 || role.id == 5) {
        $('#role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      } else if (role.id == 1 || role.id == 2 || role.id == 3) {
        $('#role').append('<option value="' + role.id + '">' + role.nama_role.charAt(0).toUpperCase() + role.nama_role.slice(1) + '</option>');
      }
    });
    // Remove multiple attribute dan reinitialize select2
    $('#role').attr('name', 'role_id[]').attr('multiple', 'multiple');
    $('#role').select2({
      placeholder: "Silakan pilih role user (bisa pilih lebih dari 1)",
      allowClear: true,
      dropdownParent: $('#form-tambah-data')
    });
    $('#role').val(null).trigger('change'); // Kosongkan select2
    $('#status-switch').prop('checked', true).trigger('change'); // Set status ke Aktif
    $('#nama').focus(); // Fokus ke input nama
    $('#btn-simpan').removeClass('d-none'); // Tampilkan tombol simpan
  });

  $('#role').on('change', function() {
    const selectedValues = $(this).val();
    const username = $('#username').val();
    const baseUsername = username.includes('_') ? username.split('_')[0] : username;
    if (selectedValues && (selectedValues.includes('6') || selectedValues.includes('7'))) {
      const data_role = <?= json_encode($data_role) ?>;
      let roleLabel = '';
      $.each(data_role, function(index, role) {
        if (role.id == 6 && selectedValues.includes('6')) {
          roleLabel = role.nama_role;
          return false; // Break loop
        } else if (role.id == 7 && selectedValues.includes('7')) {
          roleLabel = role.nama_role;
          return false; // Break loop
        }
      });
      if (roleLabel && baseUsername) {
        $('#username').val(baseUsername + '_' + roleLabel);
      }
    }
  });
</script>