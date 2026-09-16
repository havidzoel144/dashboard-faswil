<?= $this->load->view('admin/v_header') ?>

<style>
  .table tr td {
    vertical-align: middle !important;
  }

  .kegiatan-detail {
    display: flex;
    gap: 16px;
    min-width: 600px;
  }

  .kegiatan-info {
    flex: 1;
  }

  .kegiatan-flyer {
    flex: 0 0 auto;
    width: 180px;
  }

  .kegiatan-flyer img {
    max-width: 180px;
    max-height: 180px;
    cursor: pointer;
    border-radius: 6px;
  }

  .select-kegiatan {
    min-width: 120px;
  }
</style>

<?= $this->load->view('admin/v_menu') ?>

<div class="app-content content center-layout">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body">
      <div class="row mb-3">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                List Data Kegiatan
              </h4>
              <a class="heading-elements-toggle">
                <i class="la la-ellipsis-v font-medium-3"></i>
              </a>
              <div class="heading-elements btn-group">
                <button type="button" class="btn btn-dark waves-effect waves-light" id="btn-kembali" onclick="window.location.href='<?= base_url('admin/informasi-kegiatan') ?>'">
                  <i class="la la-arrow-left mr-25"></i> Kembali
                </button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="btn-tambah-data">
                  <i class="la la-plus mr-25"></i> Tambah Data
                </button>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div id="table-kegiatan-container">
                  <?= $this->load->view('admin/master/kegiatan/_table', [], true) ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================================
MODAL TAMBAH / EDIT
========================================================== -->
<div class="modal fade text-left" id="form-tambah-data" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="form-kegiatan" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title-kegiatan">
            TAMBAH KEGIATAN
          </h4>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="form-row">
            <fieldset class="form-group col-md-12">
              <label for="judul">
                Judul Kegiatan <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control square" id="judul" name="judul" placeholder="Masukkan Judul Kegiatan" required>
            </fieldset>
            <fieldset class="form-group col-md-12">
              <label for="deskripsi">
                Deskripsi <span class="text-danger">*</span>
              </label>
              <textarea class="form-control square" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </fieldset>
            <fieldset class="form-group col-md-12">
              <label for="materi">
                Materi <span class="text-danger">*</span>
              </label>
              <textarea class="form-control square" id="materi" name="materi" rows="4" required></textarea>
            </fieldset>
            <fieldset class="form-group col-md-6">
              <label for="kategori">
                Kategori <span class="text-danger">*</span>
              </label>
              <select class="form-control square" id="kategori" name="kategori" required>
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
              <label for="metode">
                Metode <span class="text-danger">*</span>
              </label>
              <select class="form-control square" id="metode" name="metode" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Daring">Daring</option>
                <option value="Luring">Luring</option>
                <option value="Hybrid">Hybrid</option>
              </select>
            </fieldset>
            <fieldset class="form-group col-md-4">
              <label for="tanggal_mulai">
                Tanggal <span class="text-danger">*</span>
              </label>
              <input type="date" class="form-control square" id="tanggal_mulai" name="tanggal_mulai" required>
            </fieldset>
            <fieldset class="form-group col-md-4">
              <label for="jam_mulai">
                Jam Mulai <span class="text-danger">*</span>
              </label>
              <input type="time" class="form-control square" id="jam_mulai" name="jam_mulai" required>
            </fieldset>
            <fieldset class="form-group col-md-4">
              <label for="jam_selesai">
                Jam Selesai <span class="text-danger">*</span>
              </label>
              <input type="time" class="form-control square" id="jam_selesai" name="jam_selesai" required>
            </fieldset>
            <fieldset class="form-group col-md-12">
              <label for="lokasi">
                Lokasi
              </label>
              <input type="text" class="form-control square" id="lokasi" name="lokasi">
            </fieldset>
            <fieldset class="form-group col-md-12">
              <label for="link_meeting">
                Link Meeting
              </label>
              <input type="url" class="form-control square" id="link_meeting" name="link_meeting" placeholder="https://...">
            </fieldset>
            <fieldset class="form-group col-md-4">
              <label for="status">
                Status <span class="text-danger">*</span>
              </label>
              <select class="form-control square" id="status" name="status" required>
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
              <label for="unggulan">
                Unggulan
              </label>
              <select class="form-control square" id="unggulan" name="unggulan">
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
              </select>
            </fieldset>
            <fieldset class="form-group col-md-4">
              <label for="tampil_dashboard">
                Tampil Dashboard
              </label>
              <select class="form-control square" id="tampil_dashboard" name="tampil_dashboard">
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
              </select>
            </fieldset>
            <fieldset class="form-group col-md-12">
              <label for="flyer">
                Flyer <span id="flyer-required" class="text-danger">*</span>
              </label>
              <input type="file" class="form-control square" id="flyer" name="flyer" accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
              <small class="text-muted">Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 2 MB.</small>
              <div id="preview-flyer" class="mt-2"></div>
            </fieldset>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btn-simpan">
            <i class="la la-save mr-25"></i> Simpan
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Tutup
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->load->view('admin/v_footer') ?>

<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script>
  // let csrfName = '<?= $this->security->get_csrf_token_name() ?>';
  // let csrfHash = '<?= $this->security->get_csrf_hash() ?>';

  let tabelKegiatan = null;
  const baseURL = '<?= base_url() ?>';

  $(document).ready(function() {
    initDataTable();
    /*
     * ======================================================
     * TAMBAH
     * ======================================================
     */
    $('#btn-tambah-data').on('click', function() {
      resetFormKegiatan();
      $('#modal-title-kegiatan')
        .text('TAMBAH KEGIATAN');
      $('#flyer-required')
        .show();
      $('#form-tambah-data')
        .modal('show');
    });

    /*
     * ======================================================
     * SUBMIT FORM
     * ======================================================
     */
    $('#form-kegiatan').on('submit', function(e) {
      e.preventDefault();
      let form = this;
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      let id = $('#id').val();
      let isEdit = id !== '';

      let url = isEdit ?
        baseURL + 'admin/kelola-kegiatan/ubah' :
        baseURL + 'admin/kelola-kegiatan/simpan';

      let formData = new FormData(form);

      formData.append(
        csrfName,
        csrfHash
      );

      Swal.fire({
        title: isEdit ? 'Update Data?' : 'Simpan Data?',
        text: isEdit ? 'Data kegiatan akan diperbarui.' : 'Data kegiatan akan disimpan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: isEdit ? 'Ya, Update' : 'Ya, Simpan',
        cancelButtonText: 'Batal',
        allowOutsideClick: false
      }).then(function(result) {
        if (!result.isConfirmed) {
          return;
        }

        $('#btn-simpan').prop('disabled', true).html('<i class="la la-spinner spinner"></i> Menyimpan...');
        $.ajax({
          url: url,
          type: 'POST',
          data: formData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function(res) {
            if (res.csrfHash) {
              csrfHash = res.csrfHash;
            }

            if (!res.status) {
              Swal.fire('Gagal', res.message, 'error');
              return;
            }

            $('#form-tambah-data').modal('hide');

            resetFormKegiatan();
            tabelKegiatan.ajax.reload(null, false);
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message,
              timer: 1500,
              showConfirmButton: false
            });
          },
          error: function(xhr) {
            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
            console.log(xhr.responseText);
          },
          complete: function() {
            $('#btn-simpan').prop('disabled', false).html('<i class="la la-save mr-25"></i> Simpan');
          }
        });
      });
    });

    /*
     * ======================================================
     * PREVIEW FLYER
     * ======================================================
     */
    $(document).on('change', '#flyer', function() {
      let file = this.files[0];

      if (!file) {
        $('#preview-flyer').html('');
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        Swal.fire('File terlalu besar', 'Ukuran flyer maksimal 2 MB.', 'error');
        $(this).val('');
        return;
      }

      let reader = new FileReader();

      reader.onload = function(e) {
        $('#preview-flyer').html(`
              <img src="${e.target.result}" style="max-width:180px; max-height:180px; border-radius:6px;">
          `);
      };
      reader.readAsDataURL(file);
    });

    /*
     * ======================================================
     * CLICK IMAGE FULLSCREEN
     * ======================================================
     */
    $(document).on('click', '.flyer-preview', function() {
      if (this.requestFullscreen) {
        this.requestFullscreen();
      }
    });
  });

  /*
   * ==========================================================
   * DATATABLE SERVER SIDE
   * ==========================================================
   */
  function initDataTable() {
    tabelKegiatan = $('#tabel-kegiatan').DataTable({
      processing: true,
      serverSide: true,
      responsive: false,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100],
        [10, 25, 50, 100]
      ],
      searching: true,
      ordering: false,
      ajax: {
        url: baseURL + 'admin/kelola-kegiatan/table',
        type: 'POST',
        data: function(d) {
          d[csrfName] = csrfHash;
        },
        dataSrc: function(json) {
          if (json.csrfHash) {
            csrfHash = json.csrfHash;
          }
          return json.data;
        }
      },
      columns: [{
          data: 'no',
          className: 'text-center'
        },
        {
          data: null,
          render: function(data, type, row) {
            let flyer = '';
            if (row.flyer) {
              flyer = `
                  <div class="kegiatan-flyer">
                      <strong>Flyer:</strong><br>
                      <img src="${baseURL}uploads/flyer/${escapeHtml(row.flyer)}" class="flyer-preview" alt="Flyer" style="max-width:180px; max-height:180px; cursor:pointer;">
                  </div>
              `;
            } else {
              flyer = `
                  <div class="kegiatan-flyer">
                      <strong>Flyer:</strong><br>
                      <span class="text-muted">
                          Tidak ada flyer
                      </span>
                  </div>
              `;
            }

            let meeting = '';

            if (row.link_meeting) {
              meeting = `
                  <strong>Link Meeting:</strong>
                  <a href="${escapeHtml(row.link_meeting)}" target="_blank" rel="noopener">
                      ${escapeHtml(row.link_meeting)}
                  </a>
              `;
            }

            return `
                <div class="kegiatan-detail">
                    <div class="kegiatan-info">
                        <strong>
                            Judul Kegiatan:
                            <span style="color:${escapeHtml(row.warna_label)}">
                                ${escapeHtml(row.judul)}
                            </span>
                        </strong>
                        <br>
                        <strong
                            >Kategori:
                            <span style=" color:${escapeHtml(row.warna_label)}">
                                ${escapeHtml(row.kategori)}
                            </span>
                        </strong>
                        <br>
                        <strong>Deskripsi:</strong> ${escapeHtml(row.deskripsi)}<br>
                        <strong>Materi:</strong> ${escapeHtml(row.materi)}<br>
                        <strong>Metode:</strong> ${escapeHtml(row.metode)}<br>
                        <strong>Tanggal:</strong> ${formatTanggal(row.tanggal_mulai)}<br>
                        <strong>Jam:</strong> ${formatJam(row.jam_mulai)} s/d ${formatJam(row.jam_selesai)} ${row.zona_waktu ? escapeHtml(row.zona_waktu) : ''}<br>
                        <strong>Lokasi:</strong> ${escapeHtml(row.lokasi || '-')}<br>
                        ${meeting}
                    </div>
                    ${flyer}
                </div>
            `;
          }
        },

        {
          data: 'status',
          className: 'text-center',
          render: function(data, type, row) {
            let statuses = [
              'Draft',
              'Daftar Sekarang',
              'Segera Hadir',
              'Akan Datang',
              'Berlangsung',
              'Selesai',
              'Ditutup'
            ];

            let html = `
                <select class="form-control form-control-sm select-kegiatan" onchange="updateStatus(this)" data-id="${row.id}" data-old-value="${escapeHtml(data)}">
            `;

            $.each(
              statuses,
              function(index, status) {
                html += `
                    <option value="${escapeHtml(status)}"${status === data ? 'selected': ''}>
                        ${escapeHtml(status)}
                    </option>
                `;
              }
            );

            html += `
                </select>
            `;
            return html;
          }
        },

        {
          data: 'unggulan',
          className: 'text-center',
          render: function(data, type, row) {
            return `
                <select class="form-control form-control-sm" onchange="updateUnggulan(this)" data-id="${row.id}" data-old-value="${escapeHtml(data)}">
                    <option value="0" ${data == '0' ? 'selected': ''}>Tidak</option>
                    <option value="1" ${data == '1' ? 'selected' : ''}>Ya</option>
                </select>
            `;
          }
        },

        {
          data: 'tampil_dashboard',
          className: 'text-center',
          render: function(data, type, row) {
            return `
                <select class="form-control form-control-sm" onchange="updateTampilDashboard(this)" data-id="${row.id}" data-old-value="${escapeHtml(data)}">
                    <option value="0" ${data == '0' ? 'selected' : ''}>Tidak</option>
                    <option value="1" ${data == '1' ? 'selected' : ''}>Ya</option>
                </select>
            `;
          }
        },

        {
          data: null,
          className: 'text-center',
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            return `
                <div class="btn-group-vertical btn-group-sm">
                    <button type="button" class="btn btn-primary" onclick="editKegiatan(${row.id})" data-toggle="tooltip" title="Ubah Data">
                        <i class="la la-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="deleteKegiatan(${row.id})" data-toggle="tooltip" title="Hapus Data">
                        <i class="la la-trash"></i>
                    </button>
                </div>
            `;
          }
        }
      ],
      drawCallback: function() {
        $('[data-toggle="tooltip"]').tooltip();
      },
      language: {
        processing: 'Memuat data...',
        search: 'Cari:',
        lengthMenu: 'Tampilkan _MENU_ data',
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
        infoEmpty: 'Tidak ada data',
        zeroRecords: 'Data tidak ditemukan',
        paginate: {
          first: 'Pertama',
          last: 'Terakhir',
          next: '›',
          previous: '‹'
        }
      }
    });
  }

  /*
   * ==========================================================
   * EDIT
   * ==========================================================
   */
  function editKegiatan(id) {
    $.ajax({
      url: baseURL + 'admin/kelola-kegiatan/get/' + id,
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        if (res.csrfHash) {
          csrfHash = res.csrfHash;
        }

        if (!res.status) {
          Swal.fire('Gagal', res.message, 'error');
          return;
        }

        let data = res.data;
        $('#id').val(data.id);
        $('#judul').val(data.judul);
        $('#deskripsi').val(data.deskripsi);
        $('#materi').val(data.materi);
        $('#kategori').val(data.kategori);
        $('#metode').val(data.metode);
        $('#tanggal_mulai').val(data.tanggal_mulai);
        $('#jam_mulai').val(data.jam_mulai ? data.jam_mulai.substring(0, 5) : '');
        $('#jam_selesai').val(data.jam_selesai ? data.jam_selesai.substring(0, 5) : '');
        $('#lokasi').val(data.lokasi);
        $('#link_meeting').val(data.link_meeting);
        $('#status').val(data.status);
        $('#unggulan').val(data.unggulan);
        $('#tampil_dashboard').val(data.tampil_dashboard);
        $('#flyer').val('');
        $('#flyer-required').hide();

        if (data.flyer) {
          $('#preview-flyer').html(`
              <div>
                  <small class="text-muted">Flyer saat ini:</small>
                  <br>
                  <img src="${baseURL}uploads/flyer/${escapeHtml(data.flyer)}" style=" max-width:180px; max-height:180px; cursor:pointer;border-radius:6px;" class="flyer-preview">
              </div>
          `);
        } else {
          $('#preview-flyer').html('');
        }
        $('#modal-title-kegiatan').text('UBAH KEGIATAN');
        $('#btn-simpan').html('<i class="la la-save mr-25"></i> Update');
        $('#form-tambah-data').modal('show');
      },
      error: function() {
        Swal.fire('Error', 'Gagal mengambil data kegiatan.', 'error');
      }
    });
  }

  /*
   * ==========================================================
   * DELETE
   * ==========================================================
   */
  function deleteKegiatan(id) {
    Swal.fire({
      title: 'Hapus Data?',
      text: 'Data kegiatan dan flyer akan dihapus.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal',
      allowOutsideClick: false
    }).then(function(result) {
      if (!result.isConfirmed) {
        return;
      }
      $.ajax({
        url: baseURL + 'admin/kelola-kegiatan/hapus',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          [csrfName]: csrfHash
        },
        success: function(res) {
          if (res.csrfHash) {
            csrfHash = res.csrfHash;
          }

          if (!res.status) {
            Swal.fire('Gagal', res.message, 'error');
            return;
          }

          tabelKegiatan.ajax.reload(null, false);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: res.message,
            timer: 1200,
            showConfirmButton: false
          });
        },
        error: function() {
          Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        }
      });
    });
  }

  /*
   * ==========================================================
   * UPDATE STATUS
   * ==========================================================
   */
  function updateStatus(element) {
    let select = $(element);
    let id = select.data('id');
    let value = select.val();
    let oldValue = select.data('old-value');
    console.log('oldValue:', oldValue, 'value:', value);

    if (oldValue === undefined) {
      oldValue = value;
    }

    Swal.fire({
      title: 'Ubah Status?',
      html: 'Status akan diubah menjadi <b>' + escapeHtml(value) + '</b>.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Ubah',
      cancelButtonText: 'Batal',
      allowOutsideClick: false
    }).then(function(result) {
      if (!result.isConfirmed) {
        /*
         * Kembalikan pilihan
         */
        select.val(oldValue);
        return;
      }

      select.prop('disabled', true);
      $.ajax({
        url: baseURL + 'admin/kelola-kegiatan/update-status',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          status: value,
          [csrfName]: csrfHash
        },
        success: function(res) {
          if (res.csrfHash) {
            csrfHash = res.csrfHash;
          }

          if (!res.status) {
            select.val(oldValue);
            Swal.fire('Gagal', res.message, 'error');
            return;
          }

          select.data('old-value', value);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Status berhasil diubah menjadi ' + value,
            timer: 1200,
            showConfirmButton: false
          });
        },
        error: function() {
          select.val(oldValue);
          Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        },
        complete: function() {
          select.prop('disabled', false);
        }
      });
    });
  }

  /*
   * ==========================================================
   * UPDATE UNGGULAN
   * ==========================================================
   */
  function updateUnggulan(element) {
    let select = $(element);
    let id = select.data('id');
    let value = select.val();
    let oldValue = select.data('old-value');
    console.log('oldValue:', oldValue, 'value:', value);

    if (oldValue === undefined) {
      oldValue = value;
    }

    let text = value == '1' ? 'Ya' : 'Tidak';

    Swal.fire({
      title: 'Ubah Unggulan?',
      html: 'Unggulan akan diubah menjadi <b>' + text + '</b>.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Ubah',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (!result.isConfirmed) {
        select.val(oldValue);
        return;
      }

      select.prop('disabled', true);

      $.ajax({
        url: baseURL + 'admin/kelola-kegiatan/update-unggulan',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          unggulan: value,
          [csrfName]: csrfHash
        },
        success: function(res) {
          if (res.csrfHash) {
            csrfHash = res.csrfHash;
          }

          if (!res.status) {
            select.val(oldValue);
            Swal.fire('Gagal', res.message, 'error');
            return;
          }

          select.data('old-value', value);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data unggulan berhasil diperbarui.',
            timer: 1000,
            showConfirmButton: false
          });
        },
        error: function() {
          select.val(oldValue);
          Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        },
        complete: function() {
          select.prop('disabled', false);
        }
      });
    });
  }

  /*
   * ==========================================================
   * UPDATE TAMPIL DASHBOARD
   * ==========================================================
   */
  function updateTampilDashboard(element) {
    let select = $(element);
    let id = select.data('id');
    let value = select.val();
    let oldValue = select.data('old-value');
    console.log('oldValue:', oldValue, 'value:', value);

    if (oldValue === undefined) {
      oldValue = value;
    }

    let text = value == '1' ? 'Ya' : 'Tidak';

    Swal.fire({
      title: 'Ubah Tampil Dashboard?',
      html: 'Tampil dashboard akan diubah menjadi <b>' + text + '</b>.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Ubah',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (!result.isConfirmed) {
        select.val(oldValue);
        return;
      }

      select.prop('disabled', true);

      $.ajax({
        url: baseURL + 'admin/kelola-kegiatan/update-dashboard',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          tampil_dashboard: value,
          [csrfName]: csrfHash
        },
        success: function(res) {
          if (res.csrfHash) {
            csrfHash = res.csrfHash;
          }

          if (!res.status) {
            select.val(oldValue);
            Swal.fire('Gagal', res.message, 'error');
            return;
          }

          select.data('old-value', value);

          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Pengaturan dashboard berhasil diperbarui.',
            timer: 1000,
            showConfirmButton: false
          });
        },
        error: function() {
          select.val(oldValue);
          Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        },
        complete: function() {
          select.prop('disabled', false);
        }
      });
    });
  }

  /*
   * ==========================================================
   * RESET FORM
   * ==========================================================
   */
  function resetFormKegiatan() {
    $('#form-kegiatan')[0].reset();
    $('#id').val('');
    $('#preview-flyer').html('');
    $('#flyer-required').show();
    $('#modal-title-kegiatan').text('TAMBAH KEGIATAN');
    $('#btn-simpan').html('<i class="la la-save mr-25"></i> Simpan');
    $('#unggulan').val('0');
    $('#tampil_dashboard').val('0');
  }

  /*
   * ==========================================================
   * MODAL CLOSED
   * ==========================================================
   */
  $('#form-tambah-data').on('hidden.bs.modal',
    function() {
      resetFormKegiatan();
    }
  );

  /*
   * ==========================================================
   * FORMAT TANGGAL
   * ==========================================================
   */
  function formatTanggal(tanggal) {
    if (!tanggal) {
      return '-';
    }

    let parts = tanggal.split('-');

    if (parts.length !== 3) {
      return tanggal;
    }

    return parts[2] + '-' + parts[1] + '-' + parts[0];
  }

  /*
   * ==========================================================
   * FORMAT JAM
   * ==========================================================
   */
  function formatJam(jam) {
    if (!jam) {
      return '-';
    }

    return jam.substring(0, 5);
  }

  /*
   * ==========================================================
   * ESCAPE HTML
   * ==========================================================
   */
  function escapeHtml(value) {
    if (value === null ||
      value === undefined) {
      return '';
    }

    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }
</script>