<?= $this->load->view('admin/v_header') ?>

<style>
  .table tr td {
    vertical-align: middle !important;
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
              <h4 class="card-title" id="heading-buttons1">List Data Kegiatan</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <div class="btn-group" role="group">
                  <a role="button" href="<?= base_url('admin/informasi-kegiatan') ?>" class="text-dark btn btn-light waves-effect waves-light" style="display: inline-flex; align-items: center;">Informasi Kegiatan</a>
                  <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-tambah-data="false" data-target="#form-tambah-data" id="btn-tambah-data">Tambah Data</button>
                </div>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-kegiatan" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Kegiatan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Unggulan</th>
                        <th class="text-center">Tampil <br> Dashboard</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($kegiatan)) { // Cek apakah array kegiatan tidak kosong
                        foreach ($kegiatan as $data) {
                      ?>
                          <tr>
                            <td class="text-center" style="width: 3%;">
                              <?php if (false) : ?>
                                <select class="form-control form-control-sm ubah-urutan" data-id="<?= $data->id ?>"
                                  data-urutan="<?= $data->urutan ?>">
                                  <?php for ($i = 1; $i <= $jumlah_data; $i++): ?>
                                    <option value="<?= $i ?>" <?= $data->urutan == $i ? 'selected' : '' ?>>
                                      <?= $i ?>
                                    </option>
                                  <?php endfor; ?>
                                </select>
                              <?php endif; ?>
                              <?= ++$i ?>
                            </td>
                            <td class="text-start" style="width: 45%;">
                              <div style="display: flex; gap: 16px;">
                                <div style="flex: 1;">
                                  <strong>Judul Kegiatan: <span style="color: <?= $data->warna_label ?>"><?= $data->judul ?></span></strong><br>
                                  <strong>Kategori: <span style="color: <?= $data->warna_label ?>"><?= $data->kategori ?></span></strong><br>
                                  <strong>Deskripsi:</strong> <?= $data->deskripsi ?><br>

                                  <strong>Metode:</strong> <?= $data->metode ?><br>
                                  <strong>Tanggal:</strong> <?= format_tanggal_indonesia($data->tanggal_mulai) ?><br>
                                  <strong>Jam:</strong> <?= date('H:i', strtotime($data->jam_mulai)) ?> s/d <?= date('H:i', strtotime($data->jam_selesai)) . ' ' . $data->zona_waktu  ?><br>
                                  <strong>Lokasi:</strong> <?= $data->lokasi ?><br>
                                  <strong>Link Meeting:</strong> <a href="<?= $data->link_meeting ?>" target="_blank"><?= $data->link_meeting ?></a>
                                </div>
                                <div style="flex: 0 0 auto;">
                                  <strong>Flyer:</strong><br>
                                  <?php if (!empty($data->flyer)) : ?>
                                    <img src="<?= base_url('uploads/flyer/' . $data->flyer) ?>" alt="Flyer" style="max-width: 200px; max-height: 200px;" data-action="zoom">
                                  <?php else : ?>
                                    <span>Tidak ada flyer</span>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-status="<?= $data->status ?>" style="width: auto;" onchange="updateStatus(this)">
                                <option value="Draft" <?= $data->status == 'Draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="Daftar Sekarang" <?= $data->status == 'Daftar Sekarang' ? 'selected' : '' ?>>Daftar Sekarang</option>
                                <option value="Segera Hadir" <?= $data->status == 'Segera Hadir' ? 'selected' : '' ?>>Segera Hadir</option>
                                <option value="Akan Datang" <?= $data->status == 'Akan Datang' ? 'selected' : '' ?>>Akan Datang</option>
                                <option value="Berlangsung" <?= $data->status == 'Berlangsung' ? 'selected' : '' ?>>Berlangsung</option>
                                <option value="Selesai" <?= $data->status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="Ditutup" <?= $data->status == 'Ditutup' ? 'selected' : '' ?>>Ditutup</option>
                              </select>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-unggulan="<?= $data->unggulan ?>" style="width: auto;" onchange="updateUnggulan(this)">
                                <option value="0" <?= $data->unggulan == '0' ? 'selected' : '' ?>>Tidak</option>
                                <option value="1" <?= $data->unggulan == '1' ? 'selected' : '' ?>>Ya</option>
                              </select>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-tampil_dashboard="<?= $data->tampil_dashboard ?>" style="width: auto;" onchange="updateTampilDashboard(this)">
                                <option value="0" <?= $data->tampil_dashboard == '0' ? 'selected' : '' ?>>Tidak</option>
                                <option value="1" <?= $data->tampil_dashboard == '1' ? 'selected' : '' ?>>Ya</option>
                              </select>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Aksi pengguna">
                                <button class="btn btn-primary waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button>
                                <button class="btn btn-danger waves-effect waves-light" type="button" onclick="confirmDelete('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
                              </div>
                            </td>

                          </tr>
                        <?php
                        }
                      } else { // Jika kegiatan kosong
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">TAMBAH KEGIATAN</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('admin/kelola-kegiatan/simpan'), array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
      <div class="modal-body">
        <div class="form-row">
          <fieldset class="form-group col-md-12">
            <label for="judul">Judul Kegiatan</label>
            <input type="text" class="form-control square" id="judul" name="judul" placeholder="Masukkan Judul Kegiatan" required>
          </fieldset>

          <fieldset class="form-group col-md-12">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control square" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi kegiatan" required></textarea>
          </fieldset>

          <fieldset class="form-group col-md-12">
            <label for="materi">Materi</label>
            <textarea class="form-control square" id="materi" name="materi" rows="4" placeholder="Masukkan materi kegiatan" required></textarea>
          </fieldset>

          <fieldset class="form-group col-md-6">
            <label for="kategori">Kategori</label>
            <select class="form-control square select2" id="kategori" name="kategori" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Pelatihan">Pelatihan</option>
              <option value="Workshop">Workshop</option>
              <option value="Bimtek">Bimtek</option>
              <option value="Pendampingan">Pendampingan</option>
              <option value="Reviu">Reviu</option>
              <option value="Forum">Forum</option>
              <option value="Sosialisasi">Sosialisasi</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </fieldset>
          <fieldset class="form-group col-md-6">
            <label for="metode">Metode</label>
            <select class="form-control square select2" id="metode" name="metode" required>
              <option value="">-- Pilih Metode --</option>
              <option value="Daring">Daring</option>
              <option value="Luring">Luring</option>
              <option value="Hybrid">Hybrid</option>
            </select>
          </fieldset>

          <fieldset class="form-group col-md-4">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" class="form-control square" id="tanggal_mulai" name="tanggal_mulai" required>
          </fieldset>
          <!-- <fieldset class="form-group col-md-6">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" class="form-control square" id="tanggal_selesai" name="tanggal_selesai" required>
          </fieldset> -->

          <fieldset class="form-group col-md-4">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" class="form-control square" id="jam_mulai" name="jam_mulai" required>
          </fieldset>
          <fieldset class="form-group col-md-4">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" class="form-control square" id="jam_selesai" name="jam_selesai" required>
          </fieldset>

          <fieldset class="form-group col-md-12">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control square" id="lokasi" name="lokasi" placeholder="Masukkan lokasi kegiatan">
          </fieldset>

          <fieldset class="form-group col-md-12">
            <label for="link_meeting">Link Meeting</label>
            <input type="url" class="form-control square" id="link_meeting" name="link_meeting" placeholder="https://...">
          </fieldset>

          <fieldset class="form-group col-md-4">
            <label for="status">Status</label>
            <select class="form-control square select2" id="status" name="status" required>
              <option value="">-- Pilih Status --</option>
              <option value="Draft">Draft</option>
              <option value="Daftar Sekarang">Daftar Sekarang</option>
              <option value="Segera Hadir">Segera Hadir</option>
              <option value="Akan Datang">Akan Datang</option>
              <option value="Berlangsung">Berlangsung</option>
              <option value="Selesai">Selesai</option>
              <option value="Ditutup">Ditutup</option>
            </select>
          </fieldset>
          <fieldset class="form-group col-md-4">
            <label for="unggulan">Unggulan</label>
            <select class="form-control square select2" id="unggulan" name="unggulan">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
          </fieldset>
          <fieldset class="form-group col-md-4">
            <label for="tampil_dashboard">Tampil Dashboard</label>
            <select class="form-control square select2" id="tampil_dashboard" name="tampil_dashboard">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
          </fieldset>

          <fieldset class="form-group col-md-12">
            <label for="flyer">Flyer</label>
            <input type="file" class="form-control square" id="flyer" name="flyer" accept="image/jpg, image/jpeg, image/png, image/gif, image/webp" required>
          </fieldset>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- MODAL TAMBAH END -->

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
    $("img").click(function() {
      this.requestFullscreen()
    })
  });

  // Tambahkan tanda * merah pada label untuk elemen yang required
  $('input[required], select[required], textarea[required]').each(function() {
    var $el = $(this);
    var $label = $('label[for="' + $el.attr('id') + '"]');

    if (!$label.length) {
      $label = $el.closest('fieldset, .form-group, .form-row, .col-md-12, .col-md-6, .col-md-4').find('label').first();
    }

    if ($label.length && $label.find('.required-asterisk').length === 0) {
      $label.append(' <span class="required-asterisk text-danger">*</span>');
    }
  });

  $(document).ready(function() {
    var tabelKegiatan = $('#tabel-kegiatan').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelKegiatan.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik
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

  $(document).on('focus', '.ubah-urutan', function() {
    // Simpan nilai sebelum diubah
    $(this).data('old-value', $(this).val());
  });

  $(document).on('change', '.ubah-urutan', function() {
    let select = $(this);
    let id = select.data('id');
    let urutanLama = parseInt(select.data('urutan'));
    let urutanBaru = parseInt(select.val());
    // Tidak berubah
    if (urutanLama === urutanBaru) {
      return;
    }
    Swal.fire({
      title: 'Ubah Urutan?',
      html: 'Urutan kegiatan akan diubah menjadi <b>' + urutanBaru + '</b>.<br>Urutan kegiatan lainnya akan menyesuaikan.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Ubah',
      cancelButtonText: 'Batal',
      allowOutsideClick: false
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseURL + 'admin/kelola-kegiatan/update-urutan',
          type: 'POST',
          dataType: 'json',
          data: {
            id: id,
            urutan_lama: urutanLama,
            urutan_baru: urutanBaru,
            [csrfName]: csrfHash // Pastikan menggunakan csrfName dan csrfHash yang benar
          },
          beforeSend: function() {
            select.prop('disabled', true);
          },
          success: function(res) {
            if (res.status) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Urutan berhasil diperbarui.',
                timer: 1500,
                showConfirmButton: false
              });
              // Update data urutan terbaru
              select.data('urutan', urutanBaru);
              // Reload agar seluruh urutan ikut berubah
              setTimeout(function() {
                location.reload();
              }, 1500);
            } else {
              select.val(urutanLama);
              Swal.fire(
                'Gagal',
                res.message,
                'error'
              );
            }
          },
          error: function() {
            select.val(urutanLama);
            Swal.fire(
              'Error',
              'Terjadi kesalahan pada server.',
              'error'
            );
          },
          complete: function() {
            select.prop('disabled', false);
          }
        });
      } else {
        // Kembalikan ke nilai sebelumnya
        select.val(urutanLama);
      }
    });
  });
</script>