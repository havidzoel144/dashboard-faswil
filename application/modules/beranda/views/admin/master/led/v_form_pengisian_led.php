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
      <div class="content-body">
        <div class="row">
          <div class="col-lg-10 col-md-6 col-sm-12 mx-auto">
            <div class="card" style="margin-bottom: 80px;">
              <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 6px 6px 0 0; padding: 1.25rem 1.5rem;">
                <div class="content-header-left mb-0 d-flex align-items-center justify-content-start flex-grow-1 pr-2">
                  <span class="d-inline-flex align-items-center justify-content-center mr-1" style="width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,0.2);">
                    <i class="la la-file-text-o" style="font-size:1.8em;color:#fff;"></i>
                  </span>
                  <div class="text-center">
                    <h3 class="content-header-title mb-0" style="font-size:1.4rem;color:#fff;font-weight:700;letter-spacing:0.5px;">
                      Form Pengisian Laporan Implementasi SPMI
                    </h3>
                    <small style="color:rgba(255,255,255,0.75);font-size:0.85rem;">Silakan lengkapi seluruh indikator dengan narasi dan bukti pendukung</small>
                  </div>
                </div>
                <div class="ml-auto">
                  <a href="<?= base_url('admin/pt/pengisian-led') ?>" class="d-inline-flex align-items-center justify-content-center mr-1" style="width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,0.2);" data-toggle="tooltip" data-placement="top" title="Kembali">
                    <i class="la la-arrow-left" style="font-size:1.8em;color:#fff;"></i>
                  </a>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <?= form_open('admin/pt/simpan-led', ['id' => 'form-led', 'class' => '', 'novalidate' => 'novalidate']) ?>

                  <input type="hidden" name="id_penilaian_tipologi" value="<?= safe_url_encrypt($penilaian_tipologi['id_penilaian_tipologi']) ?>">
                  <input type="hidden" name="kode_pt" value="<?= safe_url_encrypt($kode_pt) ?>">
                  <input type="hidden" name="periode" value="<?= safe_url_encrypt($periode) ?>">
                  <input type="hidden" name="is_permanen" id="is_permanen" value="<?= $form_led['status'] ?>">
                  <!-- INFO CARD -->
                  <div class="card border-0 shadow-sm mb-2" style="border-left: 4px solid #007bff !important;">
                    <div class="card-body py-2 px-3 d-flex align-items-center" style="background: linear-gradient(90deg,#eaf2ff 0%,#f8fbff 100%); border-radius: 6px;">
                      <span class="d-inline-flex align-items-center justify-content-center mr-3" style="width:44px;height:44px;border-radius:50%;background:#007bff22;">
                        <i class="la la-info-circle text-primary" style="font-size:1.7em;"></i>
                      </span>
                      <div>
                        <div class="font-weight-bold text-primary" style="font-size:1.08rem;">Petunjuk Pengisian</div>
                        <div class="text-muted" style="font-size:0.95em;">Isi setiap narasi indikator dengan lengkap dan sertakan link bukti pendukung yang dapat diakses. Semua field bertanda <span class="text-danger">*</span> wajib diisi.</div>
                      </div>
                    </div>
                  </div>

                  <?php if ($form_led['status'] === '1') : ?>
                    <div class="alert mb-2" style="background:#ecfdf5; border:1px solid #86efac; color:#166534; border-radius:8px;">
                      <i class="la la-lock mr-1"></i> Data LED sudah disimpan permanen dan tidak dapat diubah lagi.
                    </div>
                  <?php elseif ($form_led['status'] === '0'): ?>
                    <div class="alert mb-2" style="background:#fffbeb; border:1px solid #fcd34d; color:#78350f; border-radius:8px;">
                      <i class="la la-exclamation-triangle mr-1"></i> Data LED saat ini disimpan sebagai draft. Pastikan untuk menyimpan permanen agar dapat dilakukan penilaian oleh fasilitator.
                    </div>
                  <?php endif; ?>

                  <!-- TAB NAVIGATION -->
                  <ul class="nav nav-tabs mb-3" id="ledTab" role="tablist" style="border-bottom:2px solid #dee2e6;">
                    <li class="nav-item">
                      <a class="nav-link active font-weight-semibold" id="tab-identitas-tab" data-toggle="tab" href="#tab-identitas" role="tab" style="font-size:0.93rem;">
                        <i class="la la-university mr-1"></i> Identitas PT
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link font-weight-semibold" id="tab-bab1-tab" data-toggle="tab" href="#tab-bab1" role="tab" style="font-size:0.93rem;">
                        <i class="la la-book mr-1"></i> Bab 1
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link font-weight-semibold" id="tab-bab2-tab" data-toggle="tab" href="#tab-bab2" role="tab" style="font-size:0.93rem;">
                        <i class="la la-book mr-1"></i> Bab 2
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link font-weight-semibold" id="tab-bab3-tab" data-toggle="tab" href="#tab-bab3" role="tab" style="font-size:0.93rem;">
                        <i class="la la-book mr-1"></i> Bab 3
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link font-weight-semibold" id="tab-bab4-tab" data-toggle="tab" href="#tab-bab4" role="tab" style="font-size:0.93rem;">
                        <i class="la la-book mr-1"></i> Bab 4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content" id="ledTabContent">
                    <!-- ==================== TAB: IDENTITAS PT ==================== -->
                    <?php $this->load->view('_tab_identitas_pt') ?>

                    <!-- ==================== TAB: BAB 1 ==================== -->
                    <?php $this->load->view('_tab_bab1') ?>

                    <!-- ==================== TAB: BAB 2 ==================== -->
                    <?php $this->load->view('_tab_bab2') ?>

                    <!-- ==================== TAB: BAB 3 ==================== -->
                    <?php $this->load->view('_tab_bab3') ?>

                    <!-- ==================== TAB: BAB 4 ==================== -->
                    <?php $this->load->view('_tab_bab4') ?>
                  </div>

                  <!-- ACTION BUTTONS -->
                  <div class="card mb-1 border-0" style="border-radius:14px; overflow:hidden; box-shadow:0 8px 22px rgba(15,23,42,.08)!important; background:#ffffff;">
                    <div class="card-body py-2 px-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center" style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%); border-radius:14px; padding:1.1rem 1.35rem; color:#f8fafc; border:1px solid rgba(148,163,184,.25);">
                      <div class="mb-2 mb-md-0">
                        <small class="d-block" style="font-size:0.9rem; color:#cbd5e1;"><span style="color:#fda4af;">*</span> Field wajib diisi</small>
                        <small style="font-size:0.84rem; color:#e2e8f0;"><i class="la la-info-circle mr-1"></i>Pastikan data sudah benar sebelum disimpan.</small>
                      </div>
                      <?php if ($form_led['status'] === '1'): ?>
                        <div class="d-flex align-items-center px-3 py-2" style="background:rgba(16,185,129,.14); border:1px solid rgba(16,185,129,.32); border-radius:10px; color:#d1fae5; font-size:0.9rem; font-weight:600;">
                          <i class="la la-check-circle mr-2" style="font-size:1rem; color:#86efac;"></i>
                          LED sudah disimpan permanen.
                        </div>
                      <?php else: ?>
                        <div class="btn-group" role="group" aria-label="Aksi formulir LED">
                          <?php if (false): ?>
                            <button type="submit" class="btn btn-sm px-3" data-submit-type="draft" style="font-size:0.9rem; background:#22c55e; color:#ffffff; border:1px solid #16a34a; border-radius:8px 0 0 8px; box-shadow:0 4px 10px rgba(34,197,94,.28); font-weight:600;">
                              <i class="la la-save mr-1"></i> Simpan LED
                            </button>
                          <?php endif; ?>
                          <button type="submit" class="btn btn-sm px-3" id="btn-simpan-permanen" data-submit-type="permanen" style="font-size:0.9rem; background:#0f766e; color:#ffffff; border:1px solid #0f766e; border-radius:0 8px 8px 0; box-shadow:0 4px 10px rgba(15,118,110,.28); font-weight:600;">
                            <i class="la la-lock mr-1"></i> Simpan Permanen
                          </button>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <?= form_close() ?>
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

<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  (function() {
    function getMaxWords(el) {
      if (!el) {
        return 500;
      }

      if (el.classList.contains('narasi-led-200')) {
        return 200;
      }

      if (el.classList.contains('narasi-led-500')) {
        return 500;
      }

      return parseInt(el.getAttribute('data-max-words') || '500', 10);
    }

    function countWords(text) {
      return (text || '')
        .trim()
        .split(/\s+/)
        .filter(function(word) {
          return word.length > 0;
        }).length;
    }

    function updateWordState(el) {
      var maxWords = getMaxWords(el);
      var currentCount = countWords(el.value);
      var counter = document.getElementById('counter_' + el.id);
      if (counter) {
        counter.textContent = currentCount + '/' + maxWords + ' kata';
        counter.style.setProperty('color', currentCount > maxWords ? '#dc3545' : '', 'important');
        counter.style.fontWeight = currentCount > maxWords ? '600' : '';
      }

      return currentCount > maxWords;
    }

    function hasEmptyNarasi(fields) {
      var empty = false;
      fields.forEach(function(field) {
        if (!((field.value || '').trim())) {
          empty = true;
        }
      });
      return empty;
    }

    function getFieldDisplayName(field, index) {
      if (!field) {
        return 'Narasi ' + (index + 1);
      }

      if (field.id) {
        var label = document.querySelector('label[for="' + field.id + '"]');
        if (label) {
          var labelText = (label.textContent || '').trim();
          if (labelText) {
            return labelText;
          }
        }
      }

      if (field.getAttribute('placeholder')) {
        var placeholder = (field.getAttribute('placeholder') || '').trim();
        if (placeholder) {
          return placeholder;
        }
      }

      if (field.name) {
        return field.name;
      }

      return 'Narasi ' + (index + 1);
    }

    function getEmptyNarasiFields(fields) {
      var emptyFields = [];
      fields.forEach(function(field, index) {
        if (!((field.value || '').trim())) {
          emptyFields.push({
            element: field,
            name: getFieldDisplayName(field, index)
          });
        }
      });
      return emptyFields;
    }

    var narasiFields = document.querySelectorAll('.narasi-led-200, .narasi-led-500, .textarea-catatan');
    var isPermanenInput = document.getElementById('is_permanen');
    var isLocked = isPermanenInput && isPermanenInput.value === '1';

    function disableAllFormInputs() {
      var form = document.getElementById('form-led');
      if (!form) {
        return;
      }

      var fields = form.querySelectorAll('input, textarea, select, button');
      fields.forEach(function(field) {
        if (field.id === 'is_permanen') {
          return;
        }
        field.disabled = true;
        field.style.backgroundColor = '#c6c6c6';
        field.style.cursor = 'not-allowed';
      });
    }

    if (isLocked) {
      disableAllFormInputs();
    }

    narasiFields.forEach(function(field) {
      // Inisialisasi counter saat load
      updateWordState(field);
      if (!isLocked) {
        field.addEventListener('input', function() {
          var exceeded = updateWordState(field);
          if (exceeded) {
            field.style.borderColor = '#dc3545';
            field.style.backgroundColor = '#fff5f5';
          } else {
            field.style.borderColor = '';
            field.style.backgroundColor = '';
          }
        });
      }
    });

    var formLed = document.getElementById('form-led');

    function showAutoSaveNotification(message, isError) {
      var text = message || (isError ? 'Gagal menyimpan otomatis.' : 'Data sudah disimpan otomatis.');
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: isError ? 'error' : 'success',
          title: text,
          showConfirmButton: false,
          timer: isError ? 2500 : 1500,
          timerProgressBar: true
        });
      } else {
        if (isError) {
          alert(text);
        }
      }
    }

    function isUrlField(field) {
      return !!(field && field.tagName === 'INPUT' && (field.type || '').toLowerCase() === 'url');
    }

    function isValidUrlValue(value) {
      var trimmed = (value || '').trim();
      if (!trimmed) {
        return true;
      }

      var urlPattern = /^(https?:\/\/)(([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}|localhost)(:\d{1,5})?(\/[^\s]*)?$/;
      if (!urlPattern.test(trimmed)) {
        return false;
      }

      try {
        var parsed = new URL(trimmed);
        return parsed.protocol === 'http:' || parsed.protocol === 'https:';
      } catch (e) {
        return false;
      }
    }

    function autoSaveField(field) {
      if (!formLed || !field || isLocked || field.disabled || !field.name) {
        return;
      }

      if ((field.classList.contains('narasi-led-200') || field.classList.contains('narasi-led-500')) && updateWordState(field)) {
        showAutoSaveNotification('Narasi melebihi batas maksimal ' + getMaxWords(field) + ' kata. Simpan otomatis dibatalkan.', true);
        return;
      }

      if (isUrlField(field) && !isValidUrlValue(field.value)) {
        field.style.borderColor = '#dc3545';
        field.style.backgroundColor = '#fff5f5';
        showAutoSaveNotification('Input bukan format URL yang benar. Gunakan format: https://domain.com', true);
        return;
      } else if (isUrlField(field)) {
        field.style.borderColor = '';
        field.style.backgroundColor = '';
      }



      var currentValue = (field.value || '').trim();
      var lastValue = field.getAttribute('data-last-saved-value');
      if (lastValue === currentValue) {
        return;
      }

      var actionUrl = formLed.getAttribute('action');
      if (!actionUrl) {
        return;
      }

      var formData = new FormData(formLed);
      formData.append('autosave', '1');
      formData.append('changed_field', field.name);
      formData.append('changed_value', field.value || '');

      fetch(actionUrl, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(function(response) {
          // Debug raw response
          // console.log('Response object:', response);
          if (!response.ok) {
            throw new Error('Autosave failed');
          }
          return response.json();
        })
        .then(function(data) {
          // Debug data dari controller
          // console.log('Response JSON:', data);
          if (!data.status) {
            showAutoSaveNotification(data.message, true);
            return;
          }

          // Tandai value terakhir tersimpan
          field.setAttribute('data-last-saved-value', currentValue);
          showAutoSaveNotification(data.message, false);
        })
        .catch(function(error) {
          console.log('Autosave Error:', error);
          showAutoSaveNotification('Gagal menyimpan otomatis.', true);
        });

    }

    function initAutoSave() {
      if (!formLed || isLocked) {
        return;
      }

      var autoSaveFields = formLed.querySelectorAll('input:not([type="hidden"]):not([disabled]), textarea:not([disabled]), select:not([disabled])');
      autoSaveFields.forEach(function(field) {
        field.setAttribute('data-last-saved-value', (field.value || '').trim());
        var timeout = null;
        field.addEventListener('blur', function() {
          autoSaveField(field);
        });
      });
    }

    initAutoSave();

    var allInputs = formLed.querySelectorAll('input, textarea, select');
    allInputs.forEach(function(field) {
      field.addEventListener('input', function() {
        var value = (field.value || '').trim();
        if (field.type === 'url') {
          if (isValidUrlValue(value)) {
            field.classList.remove('is-invalid');
          }
        } else {
          if (value !== '') {
            field.classList.remove('is-invalid');
          }
        }
      });
    });

    if (formLed) {
      formLed.addEventListener('submit', function(e) {
        if (isLocked) {
          e.preventDefault();
          return;
        }

        var invalid = false;
        var submitter = e.submitter || document.activeElement;
        var submitType = submitter ? submitter.getAttribute('data-submit-type') : 'draft';

        narasiFields.forEach(function(field) {
          if (updateWordState(field)) {
            invalid = true;
          }
        });

        var invalidUrl = false;
        var urlFields = formLed.querySelectorAll('input[type="url"]:not([disabled])');
        urlFields.forEach(function(urlField) {
          if (!isValidUrlValue(urlField.value)) {
            invalidUrl = true;
            urlField.style.borderColor = '#dc3545';
            urlField.style.backgroundColor = '#fff5f5';
          } else {
            urlField.style.borderColor = '';
            urlField.style.backgroundColor = '';
          }
        });

        if (invalid) {
          e.preventDefault();
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'warning',
              title: 'Validasi Gagal',
              text: 'Beberapa narasi melebihi batas maksimal kata.'
            });
          } else {
            alert('Beberapa narasi melebihi batas maksimal kata.');
          }
          return;
        }

        if (invalidUrl) {
          e.preventDefault();
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'warning',
              title: 'Validasi Gagal',
              text: 'Terdapat input URL yang tidak valid. Gunakan format URL yang benar (contoh: https://domain.com).'
            });
          } else {
            alert('Terdapat input URL yang tidak valid. Gunakan format URL yang benar (contoh: https://domain.com).');
          }
          return;
        }

        if (submitType === 'permanen') {
          var emptyNarasiFields = getEmptyNarasiFields(narasiFields);
          if (emptyNarasiFields.length > 0) {
            e.preventDefault();

            emptyNarasiFields.forEach(function(item) {
              if (item.element) {
                item.element.classList.add('is-invalid');
              }
            });

            var firstEmptyField = emptyNarasiFields[0] && emptyNarasiFields[0].element ?
              emptyNarasiFields[0].element :
              null;
            if (firstEmptyField) {
              // cari tab-pane parent
              var parentTabPane = firstEmptyField.closest('.tab-pane');
              if (parentTabPane) {
                var tabPaneId = parentTabPane.getAttribute('id');
                // cari tombol/tab navigation
                var relatedTabButton = document.querySelector(
                  '[data-toggle="tab"][href="#' + tabPaneId + '"]'
                );
                if (relatedTabButton) {
                  // aktifkan tab bootstrap
                  $(relatedTabButton).tab('show');
                  // tunggu tab selesai tampil
                  setTimeout(function() {
                    firstEmptyField.scrollIntoView({
                      behavior: 'smooth',
                      block: 'center'
                    });
                    firstEmptyField.focus();
                  }, 300);
                } else {
                  // fallback
                  firstEmptyField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                  });
                  firstEmptyField.focus();
                }
              } else {
                // fallback jika tidak ada tab
                firstEmptyField.scrollIntoView({
                  behavior: 'smooth',
                  block: 'center'
                });
                firstEmptyField.focus();
              }
            }

            var emptyFieldListText = emptyNarasiFields.map(function(item, idx) {
              return (idx + 1) + '. ' + item.name;
            }).join('\n');

            var warningText = 'Simpan permanen hanya bisa dilakukan jika semua narasi indikator sudah terisi.\n\nField yang belum diisi:\n' + emptyFieldListText;
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: warningText
              });
            } else {
              alert(warningText);
            }
            return;
          }

          if (isPermanenInput) {
            isPermanenInput.value = '1';
          }

          var confirmationMessage = 'Setelah simpan permanen, data LED tidak dapat diubah lagi. Lanjutkan?';
          if (typeof Swal !== 'undefined') {
            e.preventDefault();
            Swal.fire({
              icon: 'question',
              title: 'Simpan Permanen',
              text: confirmationMessage,
              showCancelButton: true,
              confirmButtonText: 'Ya, simpan permanen',
              cancelButtonText: 'Batal'
            }).then(function(result) {
              if (result.isConfirmed) {
                formLed.setAttribute('action', '<?= base_url('admin/pt/simpan-permanen') ?>');
                formLed.submit();
              }
            });
          } else if (!window.confirm(confirmationMessage)) {
            e.preventDefault();
          }
        } else if (isPermanenInput) {
          isPermanenInput.value = '0';
        }
      });
    }
  })();
</script>