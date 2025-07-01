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
              <h4 class="card-title" id="heading-buttons1">List Data Periode</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <button type="button" class="btn btn-primary waves-effect waves-light mr-1" data-toggle="modal" data-tambah-data="false" data-target="#tambah-data">Tambah Data</button>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="card-content">
              <div class="card-body">

                <div class="table-responsive">
                  <table id="tabel-periode" class="table table-striped table-bordered">
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
                      ?>
                          <tr>
                            <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                            <td class="text-center" style="width: 7%;"><?= $data['kode'] ?></td>
                            <td class="text-center" style="width: 20%;"><?= $data['keterangan'] ?></td>
                            <td class="text-center" style="width: 7%;">
                              <div class="status-toggle d-inline-block w-100 text-center <?= $data['status'] == '1' ? 'disabled' : '' ?>"
                                data-status="<?= $data['status'] ?>"
                                data-kode="<?= $data['kode'] ?>"
                                style="cursor: <?= $data['status'] == '1' ? 'not-allowed' : 'pointer' ?>;"
                                <?= $data['status'] == '1' ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
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
                            <td class="text-center" style="width: 5%;">
                              <!-- <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick="openEditModal('<?= $data['kode'] ?>', '<?= $data['keterangan'] ?>', '<?= $data['status'] ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button> -->
                              <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="confirmDelete('<?= $data['kode'] ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
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

<!-- MODAL TAMBAH START -->
<div class="modal fade text-left" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">TAMBAH DATA PERIODE</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('admin/simpan-periode'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
      <div class="modal-body">
        <div class="form-group mb-2">
          <label for="kode" class="font-weight-bold">Periode</label>
          <input type="text" class="form-control square" id="kode" name="kode" placeholder="Masukkan Periode. Contoh: 20251" required>
        </div>
        <div class="form-group mb-2">
          <label for="keterangan" class="font-weight-bold">
            Keterangan <code>Otomatis muncul ketika mengisi kode dengan benar</code>
          </label>
          <input type="text" class="form-control square" id="keterangan" name="keterangan" placeholder="Otomatis muncul ketika mengisi kode dengan benar" readonly>
          <div class="mt-2">
            <div class="alert alert-info p-2 mb-1" style="font-size: 13px; background-color: #eaf4fb; color: #31708f; border-color: #bce8f1;">
              <strong>Format Kode Periode:</strong>
              <ul class="mb-0 mt-1 pl-3" style="list-style: disc;">
                <li><span class="badge" style="background-color: #d1ecf1; color: #0c5460;">2025</span> = Tahun</li>
                <li><span class="badge" style="background-color: #d4edda; color: #155724;">1</span> = Periode <b>Januari - Juni</b></li>
                <li><span class="badge" style="background-color: #fff3cd; color: #856404;">2</span> = Periode <b>Juli - November</b></li>
              </ul>
            </div>
            <div class="alert alert-light p-2" style="font-size: 13px;">
              Contoh kode: <span class="badge badge-primary">20251</span> atau <span class="badge badge-primary">20252</span>
            </div>
          </div>
        </div>
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
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">UBAH DATA PERIODE</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('admin/update-periode'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="edit-kode">Periode</label>
          <input type="text" class="form-control square" id="edit-kode" name="kode" placeholder="Masukkan Periode" readonly>
        </fieldset>
        <fieldset class="form-group">
          <label for="edit-keterangan">Keterangan | <code>Otomatis muncul ketika mengisi kode benar</code></label>
          <input type="text" class="form-control square" id="edit-keterangan" name="keterangan" placeholder="Otomatis muncul ketika mengisi kode dengan benar" readonly>
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
    var tabelPeriode = $('#tabel-periode').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelPeriode.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik
  });

  // Saat modal edit dibuka, set nilai awal
  function openEditModal(kode, keterangan, status) {
    $('#edit-kode').val(kode);
    $('#edit-keterangan').val(keterangan);

    $('#editModal').modal('show');
  }

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
        window.location.href = "<?= base_url('admin/hapus-periode/') ?>" + decodedId;
      }
    });
  }

  // Handle status toggle click
  // Hanya izinkan klik pada status-toggle jika status != '1' (tidak aktif)
  $(document).on('click', '.status-toggle', function() {
    const status = $(this).data('status');
    if (status == '1') {
      // Jika status aktif, tidak melakukan apa-apa
      return;
    }
    const kode = $(this).data('kode');
    const newStatus = status == '1' ? 'Non Aktif' : 'Aktif';

    Swal.fire({
      title: `Ubah Status ke ${newStatus}?`,
      text: "Apakah Anda yakin ingin mengubah status periode ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: "Batal",
      confirmButtonText: `Ya, ubah ke ${newStatus}!`
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= base_url('admin/update-status-periode') ?>',
          type: 'POST',
          data: {
            kode: kode,
            status: status == '1' ? '0' : '1',
            [csrfName]: csrfHash
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              Swal.fire('Berhasil!', `Status berhasil diubah menjadi ${newStatus}.`, 'success')
                .then(() => {
                  location.reload();
                });
            } else {
              Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status.', 'error');
            }
          },
          error: function() {
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghubungi server.', 'error');
          }
        });
      }
    });
  });

  let typingTimer;
  const doneTypingInterval = 1000; // 2 detik
  const $kode = $('#kode');
  const $keterangan = $('#keterangan');

  $kode.on('input', function() {
    clearTimeout(typingTimer);

    typingTimer = setTimeout(function() {
      let val = $kode.val().trim();

      if (/^\d{5}$/.test(val)) {
        let tahun = val.substring(0, 4);
        let semester = val.substring(4, 5);

        if (semester === '1') {
          $keterangan.val(`${tahun} Periode 1 (Januari - Juni)`);
        } else if (semester === '2') {
          $keterangan.val(`${tahun} Periode 2 (Juli - November)`);
        } else {
          $keterangan.val('');
          Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Format kode tidak sesuai: hanya periode 1 atau 2 yang valid.',
          })
          // alert('Format kode tidak sesuai: hanya periode 1 atau 2 yang valid.');
        }
      } else if (val !== '') {
        $keterangan.val('');
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan!',
          text: 'Format kode tidak sesuai: harus 5 digit, contoh 20251 atau 20252.',
        })
        // alert('Format kode tidak sesuai: harus 5 digit, contoh 20251 atau 20252.');
      } else {
        $keterangan.val('');
      }
    }, doneTypingInterval);
  });
</script>