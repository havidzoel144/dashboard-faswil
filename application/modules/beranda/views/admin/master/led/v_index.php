<?= $this->load->view('admin/v_header') ?>

<style>
  .alert-periode-custom {
    background: linear-gradient(135deg, #eef2ff 0%, #dbeafe 100%);
    border: 1px solid #93c5fd;
    border-left: 4px solid #3b82f6;
    color: #1e3a8a;
    border-radius: 0.6rem;
  }

  .alert-periode-custom small {
    color: #334155 !important;
  }

  #label-file-led {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-right: 6rem;
  }

  #label-file-logo {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-right: 6rem;
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
      <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12 mx-auto">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title" id="heading-buttons1"><?= $judul ?></h4>
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-upload-logo">
                <i class="fa fa-upload"></i> Upload Logo PT
              </button>
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
                          $warna_baris = $data['status'] == '1' ? 'table-success' : '';
                      ?>
                          <tr class="<?= $warna_baris ?>">
                            <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                            <td class="text-center" style="width: 10%;"><?= $data['kode'] ?></td>
                            <td class="text-center" style="width: 20%;"><?= $data['keterangan'] ?></td>
                            <td class="text-center" style="width: 10%;">
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
                            <td class="text-center" style="width: 15%;">
                              <?php
                              $disabled = '';
                              $notAllowed = '';
                              if ($data['kode_pt'] == null) {
                                $warna_btn = 'btn-danger';
                                $tooltip_text = 'Belum plotting fasilitator untuk periode ' . $data['kode'];
                                $icon_btn = 'la la-times';
                                $label_btn = 'Belum Plotting';
                                $disabled = 'disabled';
                                $notAllowed = "style='cursor: not-allowed;'";
                              } else if ($data['kode_pt'] != null && ($data['status_led'] == '0' || $data['status_led'] == null)) {
                                $warna_btn = 'btn-primary';
                                $tooltip_text = 'Silakan isi LED untuk periode ' . $data['kode'];
                                $icon_btn = 'la la-edit';
                                $label_btn = 'Pengisian LED';
                              } else if ($data['kode_pt'] != null && $data['status_led'] == '1') {
                                $warna_btn = 'btn-warning';
                                $warna_btn = 'btn-success';
                                $tooltip_text = 'LED sudah simpan permanen untuk periode ' . $data['kode'];
                                $icon_btn = 'la la-check';
                                $label_btn = 'LED Terisi';
                              }
                              ?>
                              <div class="btn-group" role="group" aria-label="Aksi LED">
                                <a href="<?= base_url('admin/pt/form-pengisian-led/' . safe_url_encrypt($data['kode'])) ?>">
                                  <button
                                    class="btn <?= $warna_btn ?> btn-sm"
                                    type="button"
                                    data-toggle="tooltip"
                                    title="<?= $tooltip_text ?>"
                                    <?= $disabled . ' ' . $notAllowed ?>>
                                    <i class="<?= $icon_btn ?>"></i>
                                    <?= $label_btn ?>
                                  </button>
                                </a>
                                <?php if ($data['status_led'] == '1'): ?>
                                  <a href="<?= base_url('admin/pt/unduh-laporan-led/' . safe_url_encrypt($data['id_penilaian_tipologi'])) ?>">
                                    <button
                                      class="btn btn-dark btn-sm"
                                      type="button"
                                      data-toggle="tooltip"
                                      title="Unduh Laporan LED untuk periode <?= $data['kode'] ?>"
                                      <?= $disabled . ' ' . $notAllowed ?>>
                                      <i class="la la-file"></i>
                                    </button>
                                  </a>
                                <?php endif; ?>
                                <?php if ($data['periode_dpm'] != null): ?>
                                  <a href="<?= base_url('admin/pt/unduh-sertifikat/' . safe_url_encrypt($data['kode'])) ?>">
                                    <button
                                      class="btn btn-info btn-sm"
                                      type="button"
                                      data-toggle="tooltip"
                                      title="Unduh Sertifikat LED untuk periode <?= $data['kode'] ?>"
                                      <?= $disabled . ' ' . $notAllowed ?>>
                                      <i class="la la-download"></i>
                                    </button>
                                  </a>
                                <?php endif; ?>
                              </div>
                            </td>
                          </tr>
                        <?php
                        }
                      } else { // Jika data_pt_binaan kosong
                        ?>
                        <tr>
                          <td colspan="4" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
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

<!-- Modal Upload Logo PT -->
<div class="modal fade" id="modal-upload-logo" tabindex="-1" role="dialog" aria-labelledby="modalUploadLogoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalUploadLogoLabel">Upload Logo PT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $logo_pt_existing = '';
        if (!empty($logo_pt)) {
          $logo_pt_existing = $logo_pt;
        }

        if (!empty($logo_pt_existing)) {
          $logo_src = base_url('admin/pt/logo/' . urlencode(safe_url_encrypt($logo_pt_existing['nama_logo'])));
        }
        ?>

        <?php if (!empty($logo_pt_existing)): ?>
          <div class="mb-2 text-center">
            <small class="d-block text-muted mb-1">Logo PT saat ini</small>
            <img src="<?= $logo_src ?>" alt="Logo PT" class="img-fluid rounded border" style="max-height: 140px;">
          </div>
        <?php endif; ?>

        <?= form_open_multipart('admin/pt/upload-logo', ['id' => 'form-upload-logo']) ?>
        <label for="file-logo">Pilih file logo</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="file-logo" name="file_logo" accept=".png, .jpg, .jpeg, .svg" required>
          <label class="custom-file-label" for="file-logo" id="label-file-logo">Pilih file...</label>
        </div>
        <small class="form-text text-muted">Format yang diizinkan: .png, .jpg, .jpeg, .svg (maksimal 2MB)</small>

        <div class="d-flex justify-content-end mt-2">
          <div class="btn-group" role="group" aria-label="Aksi Upload Logo">
            <button type="submit" class="btn btn-primary">
              <i class="la la-upload"></i> Upload
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload LED -->
<div class="modal fade" id="modal-upload-led" tabindex="-1" role="dialog" aria-labelledby="modalUploadLedLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalUploadLedLabel">Upload File LED</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-periode-custom">
          <strong>Periode:</strong> <span id="modal-label-periode">-</span><br>
          <small id="modal-label-keterangan" class="text-muted"></small>
        </div>

        <!-- STATE 1: Belum ada file / bisa upload -->
        <div id="section-upload">
          <?= form_open_multipart('admin/pt/upload-led/simpan', ['id' => 'form-upload-led']) ?>
          <input type="hidden" name="kode_periode" id="modal-kode-periode">
          <label for="file-led">Pilih file LED</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="file-led" name="file_led" accept=".doc, .docx, .pdf" required>
            <label class="custom-file-label" for="file-led" id="label-file-led">Pilih file...</label>
          </div>
          <small class="form-text text-muted">Format yang diizinkan: .doc, .docx, .pdf (maksimal 2MB)</small>
          <div class="d-flex justify-content-end mt-1">
            <div class="btn-group" role="group" aria-label="Aksi Upload LED">
              <button type="submit" class="btn btn-primary">
                <i class="la la-upload"></i> Upload
              </button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
          <?= form_close() ?>
        </div>

        <!-- STATE 2: File ada tapi belum simpan permanen (tgl_upload_led null) -->
        <div id="section-pending" style="display:none;">
          <div class="alert alert-warning shadow-sm" role="alert" style="background:#fff8e1; border: 1px solid #ffc107;">
            <div class="d-flex align-items-center">
              <span class="badge badge-warning mr-2" style="font-size:1rem; line-height:1;">
                <i class="la la-exclamation-triangle text-white"></i>
              </span>
              <div>
                <h6 class="mb-1 font-weight-bold text-dark">Status: Menunggu Konfirmasi Permanen</h6>
                <p class="mb-0 text-muted text-justify" style="font-size:0.9em;">
                  File telah diunggah, namun belum dikirim sebagai dokumen permanen.
                  Anda dapat menghapus file ini atau melanjutkan proses <strong>Kirim Permanen</strong>.
                  Setelah dikirim permanen, file tidak dapat diubah kembali.
                </p>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center border rounded px-3 py-2" style="border: 2px solid #90caf9 !important; border-style: dashed !important; background: #f0f7ff;">
            <i class="la la-file-text mr-2 text-primary" style="font-size:1.3em;"></i>
            <a id="section-pending-filename" class="font-weight-bold text-truncate" style="max-width:300px;" href="#" target="_blank"></a>
          </div>
          <div class="d-flex justify-content-end mt-1">
            <div class="btn-group btn-group-sm">
              <a href="#" id="btn-hapus-led" class="btn btn-danger">
                <i class="la la-trash"></i> Hapus File
              </a>
              <a href="#" id="btn-kirim-permanen" class="btn btn-success">
                <i class="la la-check-circle"></i> Kirim Permanen
              </a>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>

        <!-- STATE 3: File ada dan sudah permanen (tgl_upload_led tidak null) -->
        <div id="section-final" style="display:none;">
          <div class="alert shadow-sm" role="alert" style="background:#f1f8f4; border:1px solid #b7dfc8; color:#1f5e3b;">
            <i class="la la-check-circle" style="color:#2e7d4f;"></i>
            <strong style="color:#1f5e3b;">File LED sudah dikirim secara permanen.</strong><br>
            <span style="color:#2f6f4b;">File tidak dapat diubah atau dihapus lagi.</span>
          </div>
          <div class="d-flex align-items-center border rounded px-3 py-2" style="background:#f8fffb; border:1px solid #c8e6c9 !important;">
            <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width:32px; height:32px; border-radius:8px; background:#e8f5e9;">
              <i class="la la-file-text text-success" style="font-size:1.15em;"></i>
            </span>
            <div class="d-flex flex-column" style="min-width:0;">
              <small class="text-muted" style="line-height:1;">File LED Final</small>
              <a id="section-final-filename" class="font-weight-bold text-success text-truncate" style="max-width:320px;" href="#" target="_blank"></a>
            </div>
          </div>
          <div class="d-flex justify-content-end mt-1">
            <div class="btn-group btn-group-sm">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
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
    var tabelPenilaian = $('#tabel-periode').DataTable();

    function formatFileLabel(fileName, maxLength) {
      maxLength = maxLength || 35;

      if (!fileName || fileName.length <= maxLength) {
        return fileName || 'Pilih file...';
      }

      var extIndex = fileName.lastIndexOf('.');
      var extension = extIndex !== -1 ? fileName.substring(extIndex) : '';
      var baseName = extIndex !== -1 ? fileName.substring(0, extIndex) : fileName;
      var availableLength = Math.max(maxLength - extension.length - 3, 8);

      return baseName.substring(0, availableLength) + '...' + extension;
    }

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelPenilaian.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik

    // Klik tombol upload LED -> buka modal dan isi data periode
    $(document).on('click', '.btn-upload-led', function() {
      var kode = $(this).data('kode') || '';
      var kode_pt = $(this).data('kode-pt') || '';
      var keterangan = $(this).data('keterangan') || '';
      var file_led = $(this).data('file-led') || '';
      var uploaded = $(this).data('uploaded') || '';

      var hasFile = String(file_led).trim() !== '';
      var isPermanent = String(uploaded).trim() !== '';

      // reset semua section setiap modal dibuka
      $('#section-upload, #section-pending, #section-final').hide();

      $('#modal-kode-periode').val(kode);
      $('#modal-label-periode').text(kode || '-');
      $('#modal-label-keterangan').text(keterangan || '');

      // reset file input setiap modal dibuka
      $('#file-led').val('');
      $('#label-file-led').text('Pilih file...').attr('title', 'Pilih file...');

      // Default title modal
      $('#modalUploadLedLabel').text('Upload File LED');

      // State 1: belum ada file -> boleh upload
      if (!hasFile) {
        $('#section-upload').show();
        $('#file-led').prop('required', true);
      }
      // State 2: file ada, tapi belum permanen (tgl_upload_led null)
      else if (hasFile && !isPermanent) {
        $('#section-pending').show();
        $('#file-led').prop('required', false);

        $('#modalUploadLedLabel').text('File LED Belum Permanen');
        $('#section-pending-filename')
          .text(formatFileLabel(file_led, 50))
          .attr('title', file_led)
          .attr('href', '<?= base_url('admin/pt/lihat-file-led/') ?>' + encodeURIComponent(kode_pt) + '/' + encodeURIComponent(kode))
          .attr('target', '_blank');

        // Opsi aksi pending
        $('#btn-hapus-led').attr('href', '<?= base_url('admin/pt/upload-led/hapus') ?>?kode_pt=' + encodeURIComponent(kode_pt) + '&periode=' + encodeURIComponent(kode));
        $('#btn-kirim-permanen').attr('href', '<?= base_url('admin/pt/upload-led/kirim-permanen') ?>?kode_pt=' + encodeURIComponent(kode_pt) + '&periode=' + encodeURIComponent(kode));
      }
      // State 3: file ada dan sudah permanen (tgl_upload_led ada)
      else {
        $('#section-final').show();
        $('#file-led').prop('required', false);

        $('#modalUploadLedLabel').text('File LED Sudah Permanen');
        $('#section-final-filename')
          .text(formatFileLabel(file_led, 50))
          .attr('title', file_led)
          .attr('href', '<?= base_url('admin/pt/lihat-file-led/') ?>' + encodeURIComponent(kode_pt) + '/' + encodeURIComponent(kode))
          .attr('target', '_blank');

        // Hanya lihat/download
        $('#btn-download-led').attr('href', '<?= base_url('uploads/led/') ?>' + encodeURIComponent(file_led));
      }

      $('#modal-upload-led').modal('show');
    });

    $('#btn-hapus-led').on('click', function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      Swal.fire({
        title: 'Hapus File LED?',
        text: 'Apakah Anda yakin ingin menghapus file LED ini? Tindakan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });

    // Tampilkan nama file yang dipilih
    $('#file-led').on('change', function() {
      var fileName = this.files && this.files.length ? this.files[0].name : 'Pilih file...';
      $('#label-file-led')
        .text(formatFileLabel(fileName))
        .attr('title', fileName);
    });

    // Tampilkan nama file logo yang dipilih
    $('#file-logo').on('change', function() {
      var fileName = this.files && this.files.length ? this.files[0].name : 'Pilih file...';
      $('#label-file-logo')
        .text(formatFileLabel(fileName))
        .attr('title', fileName);
    });

    // Validasi sederhana upload logo
    $('#form-upload-logo').on('submit', function(e) {
      var fileInput = $('#file-logo')[0];
      if (!fileInput.files || !fileInput.files.length) {
        e.preventDefault();
        alert('Silakan pilih file logo terlebih dahulu.');
        return false;
      }
    });

    // Validasi sederhana sebelum submit
    $('#form-upload-led').on('submit', function(e) {
      var fileInput = $('#file-led')[0];
      if (!fileInput.files || !fileInput.files.length) {
        e.preventDefault();
        alert('Silakan pilih file LED terlebih dahulu.');
        return false;
      }
    });
  });
</script>