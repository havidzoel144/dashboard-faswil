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
              <h4 class="card-title" id="heading-buttons1">Bukat Tutup</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-user" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Tanggal/Waktu Buka</th>
                        <th class="text-center">Tanggal/Waktu Tutup</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Pesan</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_buka_tutup)) { // Cek apakah array data_buka_tutup tidak kosong
                        foreach ($data_buka_tutup as $bt) {

                          $xjambuka   = substr($bt->mulai_waktu, 0, 2);
                          $xmenitbuka = substr($bt->mulai_waktu, 3, 2);
                          $xdetikbuka = substr($bt->mulai_waktu, 6, 2);
                          $jambuka    = $xjambuka . ':' . $xmenitbuka . ':' . $xdetikbuka;

                          $xjamtutup      = substr($bt->akhir_waktu, 0, 2);
                          $xmenittutup    = substr($bt->akhir_waktu, 3, 2);
                          $xdetiktutup    = substr($bt->akhir_waktu, 6, 2);
                          $jamtutup       = $xjambuka . ':' . $xmenitbuka . ':' . $xdetikbuka;
                      ?>
                          <tr>
                            <td class="text-center" style="width: 5%;"><?= ++$i ?></td>
                            <td class="text-center" style="width: 15%;"><?= $bt->jenis ?></td>
                            <td class="text-center" style="width: 15%;">
                              Tanggal : <b><?= $bt->mulai_tgl ?></b>
                              <br>
                              Waktu : <b><?= $bt->mulai_waktu ?></b>
                            </td>
                            <td class="text-center" style="width: 15%;">
                              Tanggal : <b><?= $bt->akhir_tgl ?></b>
                              <br>
                              Waktu : <b><?= $bt->akhir_waktu ?></b>
                            </td>
                            <td style="width: 10%;" class="text-center">
                              <?php
                              // Gabungkan tanggal dan waktu buka/tutup ke format Y-m-d H:i:s
                              $mulai_datetime = $bt->mulai_tgl . ' ' . $bt->mulai_waktu;
                              $akhir_datetime = $bt->akhir_tgl . ' ' . $bt->akhir_waktu;
                              $now = date('Y-m-d H:i:s');

                              // Status Buka/Tutup dengan style badge gradasi
                              $isOpen = ($now >= $mulai_datetime && $now <= $akhir_datetime);
                              ?>
                              <div class="d-inline-block w-100 text-center">
                                <?php if ($isOpen): ?>
                                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #28a745 0%, #218838 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                                    <i class="la la-check-circle mr-1"></i> Dibuka
                                  </span>
                                <?php else: ?>
                                  <span class="badge rounded-pill w-100" style="background: linear-gradient(90deg, #dc3545 0%, #b52a37 100%); color: #fff; font-size: 0.95em; padding: 0.5em 1em; display: block;">
                                    <i class="la la-times-circle mr-1"></i> Ditutup
                                  </span>
                                <?php endif; ?>
                              </div>
                            </td>
                            <td style="width: 30%;"><?= $bt->pesan ?></td>
                            <td class="text-center" style="width: 10%;">
                              <button type="button" class="btn btn-sm btn-primary" title="Edit" data-toggle="modal" data-target="#editBukaTutupModal<?= $bt->id ?>">
                                <i class="la la-pencil"></i>
                              </button>
                            </td>

                            <!-- Modal Edit Buka Tutup -->
                            <div class="modal fade" id="editBukaTutupModal<?= $bt->id ?>" tabindex="-1" role="dialog" aria-labelledby="editBukaTutupLabel<?= $bt->id ?>" aria-hidden="true">
                              <div class="modal-dialog" role="document">

                                <?php echo form_open(site_url('admin-simpan-bukaTutup'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
                                <input type="hidden" name="id" value="<?= $bt->id ?>">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editBukaTutupLabel<?= $bt->id ?>">Edit Buka Tutup <br><?= htmlspecialchars($bt->jenis) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">

                                    <div class="form-group">
                                      <label>Pilih Tanggal Pembukaan</label>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <input type="date" value="<?= $bt->mulai_tgl ?>" class="form-control" name="xtglmulai" required>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label>Pilih Jam Pembukaan</label>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <select class="form-control" name="xbkjam">
                                            <option value="<?= $xjambuka ?>"> <?= $xjambuka ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>

                                            <?php
                                            for ($tglb = 10; $tglb < 24; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <select class="form-control" name="xbkmenit">
                                            <option value="<?= $xmenitbuka ?>"> <?= $xmenitbuka ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <?php
                                            for ($tglb = 10; $tglb < 60; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <select class="form-control" name="xbkdetik">
                                            <option value="<?= $xdetikbuka ?>"> <?= $xdetikbuka ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <?php
                                            for ($tglb = 10; $tglb < 60; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label>Pilih Tanggal Penutup</label>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <input type="date" value="<?= $bt->akhir_tgl ?>" class="form-control" name="xtgltutup" required>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label>Pilih Jam Penutup</label>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <select class="form-control" name="xttpjam">
                                            <option value="<?= $xjamtutup ?>"> <?= $xjamtutup ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>

                                            <?php
                                            for ($tglb = 10; $tglb < 24; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <select class="form-control" name="xttpmenit">
                                            <option value="<?= $xmenittutup ?>"> <?= $xmenittutup ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <?php
                                            for ($tglb = 10; $tglb < 60; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <select class="form-control" name="xttpdetik">
                                            <option value="<?= $xdetiktutup ?>"> <?= $xdetiktutup ?></option>
                                            <option value="00">00</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <?php
                                            for ($tglb = 10; $tglb < 60; $tglb++) {
                                              echo "<option value =\"$tglb\">$tglb </option>";
                                            }
                                            ?>
                                          </select>
                                        </div>

                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label>Keterangan</label>
                                      <textarea class="form-control" name="xketerangan" rows="2"><?= htmlspecialchars($bt->pesan) ?></textarea>
                                    </div>

                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                  </div>
                                </div>
                                <?php echo form_close(); ?>

                              </div>
                            </div>
                            <!-- Modal Edit Buka Tutup -->
                          </tr>
                        <?php
                        }
                      } else { // Jika data_buka_tutup kosong
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