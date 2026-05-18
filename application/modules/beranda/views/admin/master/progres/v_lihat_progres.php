<?= $this->load->view('admin/v_header') ?>

<style>
  @media (max-width: 575.98px) {
    .display-4 {
      font-size: 2rem;
    }

    .card-title {
      font-size: 0.95rem !important;
    }
  }

  .card .rounded-circle {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .card {
    transition: all .2s ease;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, .15);
  }

  .stat-card {
    position: relative;
    padding: 22px 24px;
    border-radius: 16px;
    color: #fff;
    display: flex;
    align-items: center;
    /* justify-content: space-between; */
    overflow: hidden;
    /* cursor: pointer; */
    transition: all .35s ease;
  }

  .stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, .18);
  }

  .stat-icon {
    font-size: 36px;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: rgba(255, 255, 255, .2);
    margin-right: 16px;
  }

  .stat-icon i {
    font-size: 2.5rem !important;
  }

  .stat-content h3 {
    font-size: 34px;
    font-weight: 700;
    margin: 0;
  }

  .stat-content p {
    margin: 0;
    opacity: .9;
    font-size: 14px;
  }

  .stat-arrow {
    font-size: 22px;
    opacity: .7;
  }

  /* Gradient Colors */

  .stat-grey {
    background: linear-gradient(135deg, #9e9e9e, #616161);
  }

  .stat-blue {
    background: linear-gradient(135deg, #42a5f5, #1e88e5);
  }

  .stat-orange {
    background: linear-gradient(135deg, #ffb74d, #fb8c00);
  }

  .stat-red {
    background: linear-gradient(135deg, #ef5350, #c62828);
  }

  .stat-purple {
    background: linear-gradient(135deg, #ab47bc, #7b1fa2);
  }

  .stat-green {
    background: linear-gradient(135deg, #66bb6a, #2e7d32);
  }

  .stat-dark {
    background: linear-gradient(135deg, #546e7a, #263238);
  }

  .role-option {
    border: 2px solid #e5e5e5;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: all .25s ease;
  }

  .role-option:hover {
    border-color: #007bff;
    transform: translateY(-2px);
  }

  .role-option.active {
    border-color: #007bff;
    background: #eef5ff;
  }

  .role-option i {
    font-size: 22px;
    display: block;
    margin-bottom: 4px;
  }

  .form-section {
    display: none;
    animation: fadeIn .3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(5px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
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
      <?php if (has_role([2])) : ?>

        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                <div class="mb-2">
                  <span class="rounded-circle bg-info bg-gradient d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="la la-users text-white" style="font-size: 2rem;"></i>
                  </span>
                </div>
                <h6 class="card-title mb-1 text-info font-weight-bold" style="font-size: 1.05rem;">Jumlah Fasilitator</h6>
                <span class="display-4 font-weight-bold text-info counter"><?= $jumlah_fasilitator ?></span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                <div class="mb-2">
                  <span class="rounded-circle bg-secondary bg-gradient d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="la la-user-secret text-white" style="font-size: 2rem;"></i>
                  </span>
                </div>
                <h6 class="card-title mb-1 text-secondary font-weight-bold" style="font-size: 1.05rem;">Jumlah Validator</h6>
                <span class="display-4 font-weight-bold text-secondary counter"><?= $jumlah_validator ?></span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                <div class="mb-2">
                  <span class="rounded-circle bg-dark bg-gradient d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="la la-university text-white" style="font-size: 2rem;"></i>
                  </span>
                </div>
                <h6 class="card-title mb-1 text-dark font-weight-bold" style="font-size: 1.05rem;">Jumlah Perguruan Tinggi</h6>
                <span class="display-4 font-weight-bold text-dark counter"><?= $jumlah_pt ?></span>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 dashboard-stats mb-2">
          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-grey">
              <div class="stat-icon">
                <i class="la la-user-times"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_belum_input ?></h3>
                <p>Fasilitator Belum Input</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-blue">
              <div class="stat-icon">
                <i class="la la-pencil"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_draft ?></h3>
                <p>Draft Fasilitator</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-orange">
              <div class="stat-icon">
                <i class="la la-hourglass-half"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_penilaian_validator ?></h3>
                <p>Menunggu Validator</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-red">
              <div class="stat-icon">
                <i class="la la-edit"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_revisi_validator ?></h3>
                <p>Perlu Revisi Fasilitator</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-purple">
              <div class="stat-icon">
                <i class="la la-bookmark"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_draft_validator ?></h3>
                <p>Draft Validator</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-green">
              <div class="stat-icon">
                <i class="la la-check-circle"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter"><?= $jml_valid ?></h3>
                <p>Penilaian Valid</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 mb-1">
            <div class="stat-card stat-dark">
              <div class="stat-icon">
                <i class="la la-shield"></i>
              </div>

              <div class="stat-content">
                <h3 class="counter" style="color: white;"><?= $jml_menunggu_approval_admin ?></h3>
                <p>Menunggu Approval</p>
              </div>
            </div>
          </div>
        </div>

        <?php if ($periode_dipilih->status == '1' && substr($periode_dipilih->kode, 0, 4) == date('Y')) : ?>
          <div class="row">
            <div class="col-12">
              <?php
              // Ambil tanggal dan waktu sekarang
              $now = new DateTime();

              // Ambil data periode dari $buka_tutup[0]
              $mulai = new DateTime($buka_tutup[0]->mulai_tgl . ' ' . $buka_tutup[0]->mulai_waktu);
              $akhir = new DateTime($buka_tutup[0]->akhir_tgl . ' ' . $buka_tutup[0]->akhir_waktu);

              // Tentukan status periode
              if ($now < $mulai) {
                $label = '<span class="badge badge-secondary ml-2">Belum Dibuka</span>';
              } elseif ($now >= $mulai && $now <= $akhir) {
                $label = '<span class="badge badge-success ml-2">Sedang Berlangsung</span>';
              } else {
                $label = '<span class="badge badge-danger ml-2">Sudah Lewat</span>';
              }
              ?>
              <div class="alert alert-info alert-dismissible fade show" role="alert" style="background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%); color: #1565c0; border: 1px solid #90caf9;">
                <strong style="display: inline-block; width: 220px; border-right: 1px solid #90caf9;">Periode <?= $buka_tutup[0]->jenis ?></strong>
                <?= $label ?>
                <span style="font-weight: 500;">
                  <?= $buka_tutup[0]->mulai_tgl . ' ' . $buka_tutup[0]->mulai_waktu . ' s/d ' . $buka_tutup[0]->akhir_tgl . ' ' . $buka_tutup[0]->akhir_waktu ?>
                </span>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-12">
              <?php
              // Ambil tanggal dan waktu sekarang
              $now2 = new DateTime();

              // Ambil data periode dari $buka_tutup[1]
              $mulai2 = new DateTime($buka_tutup[1]->mulai_tgl . ' ' . $buka_tutup[1]->mulai_waktu);
              $akhir2 = new DateTime($buka_tutup[1]->akhir_tgl . ' ' . $buka_tutup[1]->akhir_waktu);

              // Tentukan status periode
              if ($now2 < $mulai2) {
                $label2 = '<span class="badge badge-secondary ml-2">Belum Dibuka</span>';
              } elseif ($now2 >= $mulai2 && $now2 <= $akhir2) {
                $label2 = '<span class="badge badge-success ml-2">Sedang Berlangsung</span>';
              } else {
                $label2 = '<span class="badge badge-danger ml-2">Sudah Lewat</span>';
              }
              ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background: linear-gradient(90deg, #fffde7 0%, #ffe082 100%); color: #ff9800; border: 1px solid #ffd54f;">
                <strong style="display: inline-block; width: 220px; border-right: 1px solid #ffd54f;">Periode <?= $buka_tutup[1]->jenis ?></strong>
                <?= $label2 ?>
                <span style="font-weight: 500;">
                  <?= $buka_tutup[1]->mulai_tgl . ' ' . $buka_tutup[1]->mulai_waktu . ' s/d ' . $buka_tutup[1]->akhir_tgl . ' ' . $buka_tutup[1]->akhir_waktu ?>
                </span>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="row mb-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                  <h4 class="card-title ml-1" id="heading-buttons1">Data Penilaian Tipologi | <span class="badge badge-secondary font-medium-1"><?= $periode_dipilih->keterangan ?></span></h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                  <div class="d-flex align-items-center">
                    <?php if ($periode_dipilih->status == '1' && substr($periode_dipilih->kode, 0, 4) == date('Y')) : ?>
                      <button class="btn btn-success btn-ganti-faswil-validator" type="button" data-toggle="tooltip" title="Ganti Faswil / Validator" data-periode="<?= safe_url_encrypt($periode_dipilih->kode) ?>" data-keterangan="<?= $periode_dipilih->keterangan ?>">
                        <i class="la la-refresh"></i> Ganti Faswil / Validator
                      </button>
                      <?php echo form_open(site_url('admin/publish-penilaian'), array('class' => 'form-horizontal m-0', 'role' => 'form', 'id' => 'form-publish-penilaian')); ?>
                      <input type="hidden" name="periode" value="<?= safe_url_encrypt($periode_dipilih->kode) ?>">
                      <button type="submit" class="btn btn-primary waves-effect waves-light" id="btn-publish" data-toggle="tooltip" title="Publish Semua Penilaian">
                        <i class="la la-send"></i> Publish Penilaian
                      </button>
                    <?php endif; ?>
                    <?php echo form_close(); ?>
                    <a href="<?= base_url('admin/progres-penilaian') ?>">
                      <button type="button" class="btn btn-dark waves-effect waves-light">
                        <i class="la la-arrow-left"></i> Kembali
                      </button>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabel-penilaian" class="table table-striped table-bordered">
                      <thead>
                        <tr style="background-color: #563BFF; color: #ffffff">
                          <th class="text-center">#</th>
                          <th class="text-center">Nama Fasilitator</th>
                          <th class="text-center">Perguruan Tinggi</th>
                          <th class="text-center">Periode</th>
                          <th class="text-center">Nama Validator</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0; // Inisialisasi counter
                        if (!empty($progres_penilaian)) { // Cek apakah array progres_penilaian tidak kosong
                          foreach ($progres_penilaian as $data) {
                            $row_class = '';
                            if ($data->id_status_penilaian == '6') {
                              $row_class = 'table-dark text-dark'; // abu
                            } elseif ($data->id_status_penilaian == '5') {
                              $row_class = 'table-primary'; // ungu
                            } elseif ($data->id_status_penilaian == '4') {
                              $row_class = 'table-success'; // hijau
                            } elseif ($data->id_status_penilaian == '3') {
                              $row_class = 'table-danger'; // kuning
                            } elseif ($data->id_status_penilaian == '2') {
                              $row_class = 'table-warning'; // merah
                            } elseif ($data->id_status_penilaian == '1') {
                              $row_class = 'table-info'; // biru
                            }
                        ?>
                            <tr class="<?= $row_class ?>">
                              <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                              <td class="text-start" style="width: 10%;"><?= $data->nama_fasilitator ?></td>
                              <td class="text-start" style="width: 20%;"><?= $data->nama_pt ?></td>
                              <td class="text-start" style="width: 17%;"><?= $data->keterangan ?></td>
                              <td class="text-start" style="width: 10%;">
                                <?php if ($data->nama_validator == NULL): ?>
                                  <span class="badge w-100" style="background: #ff4d4f; color: #fff; font-size: 1em; padding: 8px 14px; border-radius: 20px; letter-spacing: 0.5px;">
                                    <i class="fa fa-user-times" aria-hidden="true" style="margin-right: 6px;"></i>
                                    Belum ada validator
                                  </span>
                                <?php else: ?>
                                  <span class="badge w-100" style="background: #28a745; color: #fff; font-size: 1em; padding: 8px 14px; border-radius: 20px; letter-spacing: 0.5px;">
                                    <i class="fa fa-user" aria-hidden="true" style="margin-right: 6px;"></i>
                                    <?= $data->nama_validator ?>
                                  </span>
                                <?php endif; ?>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?php
                                $warna_badge = $data->id_status_penilaian == '4' ? 'badge-success' : (
                                  $data->id_status_penilaian == '3' ? 'badge-danger' : (
                                    $data->id_status_penilaian == '2' ? 'badge-warning' : (
                                      $data->id_status_penilaian == '1' ? 'badge-info' : (
                                        $data->id_status_penilaian == '5' ? 'badge-primary' : (
                                          $data->id_status_penilaian == '6' ? 'bg-blue-grey bg-darken-4' : 'badge-secondary'
                                        )
                                      )
                                    )
                                  )
                                );

                                $icon = $data->id_status_penilaian == '4' ? 'fa-check-circle' : (
                                  $data->id_status_penilaian == '3' ? 'fa-times-circle' : (
                                    $data->id_status_penilaian == '2' ? 'fa-hourglass-half' : (
                                      $data->id_status_penilaian == '1' ? 'fa-spinner fa-spin' : (
                                        $data->id_status_penilaian == '5' ? 'fa-paper-plane' : (
                                          $data->id_status_penilaian == '6' ? 'fa-rotate-left' : 'fa-question-circle'
                                        )
                                      )
                                    )
                                  )
                                );
                                ?>
                                <span class="badge <?= $warna_badge ?>" style="font-size: 1em; padding: 8px 14px; border-radius: 20px; letter-spacing: 0.5px; width: 100%;">
                                  <i class="fa <?= $icon ?>" aria-hidden="true" style="margin-right: 6px;"></i>
                                  <?= $data->nm_status !== null ? $data->nm_status : 'Belum input' ?>
                                </span>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <div class="d-flex justify-content-center">
                                  <?php if ($data->id_status_penilaian == '6') : ?>
                                    <a href="<?= base_url() ?>admin/ubah-status-penilaian/<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" class="btn btn-secondary btn-sm waves-effect waves-light ubah-status-penilaian" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Ubah status penilaian menjadi Draft Validator" data-namapt="<?= $data->nama_pt ?>">
                                      <i class="la la-rotate-left"></i>
                                    </a>
                                  <?php endif; ?>

                                  <?php if ($data->id_status_penilaian == '4') : ?>
                                    <?php
                                    $url = substr($periode_dipilih->kode, 0, 4) > '2025' ? 'admin/export-nilai-pdf' : 'admin/export-nilai-pdf-30';
                                    ?>
                                    <a href="<?= base_url($url) . '/' . safe_url_encrypt($data->id_penilaian_tipologi) ?>" target="_blank" style="margin-right: 1px;">
                                      <button class="btn btn-primary btn-sm" type="button" data-toggle="tooltip" title="Export PDF">
                                        <i class="la la-file-pdf-o"></i>
                                      </button>
                                    </a>
                                  <?php endif; ?>

                                  <?php $sudah_dipublikasikan = isset($penilaian_sudah_dipublikasikan) && in_array($data->kode_pt, $penilaian_sudah_dipublikasikan); ?>
                                  <?php if ($sudah_dipublikasikan) : ?>
                                    <button class="btn btn-success btn-sm" type="button" data-toggle="tooltip" title="Nilai Sudah Dipublikasikan">
                                      <i class="la la-check"></i>
                                    </button>
                                  <?php else : ?>
                                    <button class="btn btn-dark btn-sm btn-publish-nilai-pt" type="button" data-toggle="tooltip" title="Publish Nilai" data-id="<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" data-periode="<?= safe_url_encrypt($periode_dipilih->kode) ?>" data-kode="<?= safe_url_encrypt($data->kode_pt) ?>" data-nama="<?= $data->nama_pt ?>">
                                      <i class="la la-upload"></i>
                                    </button>
                                  <?php endif; ?>
                                </div>
                              </td>
                            </tr>
                          <?php
                          }
                        } else { // Jika progres_penilaian kosong
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
      <?php endif; ?>
      <!--/ Basic Horizontal Timeline -->
    </div>
  </div>
</div>
<!-- END: Content-->

<!-- Modal Ganti Faswil / Validator -->
<div class="modal fade" id="modalGantiFaswilValidator" tabindex="-1" role="dialog" aria-labelledby="modalGantiFaswilValidatorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGantiFaswilValidatorLabel">Ganti Fasilitator / Validator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGantiFaswilValidator">
          <div class="form-group">
            <label for="periodePenilaian">Periode Penilaian</label>
            <input class="form-control" type="hidden" id="periodePenilaian" name="periodePenilaian" required readonly>
            <input class="form-control" type="text" id="keterangan" name="keterangan" required readonly>
          </div>

          <div class="form-group">
            <label>Tipe Pergantian</label>
            <div class="row">
              <div class="col-6">
                <div class="role-option" data-role="fasilitator">
                  <i class="la la-users text-primary"></i>
                  <strong>Fasilitator</strong>
                  <input type="radio" name="tipePergang" value="fasilitator" hidden>
                </div>
              </div>

              <div class="col-6">
                <div class="role-option" data-role="validator">
                  <i class="la la-user-secret text-danger"></i>
                  <strong>Validator</strong>
                  <input type="radio" name="tipePergang" value="validator" hidden>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group form-section" id="grupFasilitator" style="display: none;">
            <label for="selectFasilitator">Pilih Fasilitator</label>
            <select class="form-control select2" id="selectFasilitator" name="selectFasilitator">
              <option value="">-- Pilih Fasilitator --</option>
            </select>
          </div>
          <div class="form-group form-section" id="grupPTFaswil" style="display: none;">
            <label for="selectPTFaswil">Pilih Perguruan Tinggi (jika hanya beberapa PT saja yang dialihkan)</label>
            <select class="form-control select2" id="selectPTFaswil" name="selectPTFaswil" multiple>
              <option value="">-- Pilih Perguruan Tinggi --</option>
            </select>
          </div>
          <div class="alert alert-info alert-dismissible d-none" role="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-left: 4px solid #fff; color: #fff; margin-top: 1rem; padding: 1rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);" id="catatanFaswil">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
              <i class="la la-lightbulb-o" style="font-size: 1.5rem; flex-shrink: 0; margin-top: 2px;"></i>
              <div>
                <strong style="font-size: 0.95rem; display: block; margin-bottom: 4px;">💡 Catatan Penting</strong>
                <small style="font-size: 0.85rem; line-height: 1.5; opacity: 0.95;">
                  Pilih perguruan tinggi yang sesuai dengan fasilitator terpilih untuk menjaga konsistensi data penilaian. Abaikan jika tidak ada perubahan pada perguruan tinggi.
                </small>
              </div>
            </div>
          </div>
          <div class="form-group form-section" id="grupFasilitatorPengganti" style="display: none;">
            <label for="selectFasilitatorPengganti">Pilih Fasilitator Pengganti</label>
            <select class="form-control select2" id="selectFasilitatorPengganti" name="selectFasilitatorPengganti">
              <option value="">-- Pilih Fasilitator Pengganti --</option>
            </select>
          </div>

          <div class="form-group form-section" id="grupValidator" style="display: none;">
            <label for="selectValidator">Pilih Validator</label>
            <select class="form-control select2" id="selectValidator" name="selectValidator">
              <option value="">-- Pilih Validator --</option>
            </select>
          </div>
          <div class="form-group form-section" id="grupPTValidator" style="display: none;">
            <label for="selectPTValidator">Pilih Perguruan Tinggi (jika hanya beberapa PT saja yang dialihkan)</label>
            <select class="form-control select2" id="selectPTValidator" name="selectPTValidator" multiple>
              <option value="">-- Pilih Perguruan Tinggi --</option>
            </select>
          </div>
          <div class="alert alert-info alert-dismissible d-none" role="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-left: 4px solid #fff; color: #fff; margin-top: 1rem; padding: 1rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);" id="catatanValidator">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
              <i class="la la-lightbulb-o" style="font-size: 1.5rem; flex-shrink: 0; margin-top: 2px;"></i>
              <div>
                <strong style="font-size: 0.95rem; display: block; margin-bottom: 4px;">💡 Catatan Penting</strong>
                <small style="font-size: 0.85rem; line-height: 1.5; opacity: 0.95;">
                  Pilih perguruan tinggi yang sesuai dengan validator terpilih untuk menjaga konsistensi data penilaian. Abaikan jika tidak ada perubahan pada perguruan tinggi.
                </small>
              </div>
            </div>
          </div>
          <div class="form-group form-section" id="grupValidatorPengganti" style="display: none;">
            <label for="selectValidatorPengganti">Pilih Validator Pengganti</label>
            <select class="form-control select2" id="selectValidatorPengganti" name="selectValidatorPengganti">
              <option value="">-- Pilih Validator Pengganti --</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSimpanGanti">Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
    var tabelPenilaian = $('#tabel-penilaian').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    tabelPenilaian.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik

    $(document).on('click', '#btn-publish', function(event) {
      const periode = '<?= $periode_dipilih->keterangan ?>';
      event.preventDefault();

      // Ambil tanggal dan waktu periode fasilitator & validator dari PHP
      const mulaiFasilitator = '<?= $buka_tutup[0]->mulai_tgl . ' ' . $buka_tutup[0]->mulai_waktu ?>';
      const akhirFasilitator = '<?= $buka_tutup[0]->akhir_tgl . ' ' . $buka_tutup[0]->akhir_waktu ?>';
      const mulaiValidator = '<?= $buka_tutup[1]->mulai_tgl . ' ' . $buka_tutup[1]->mulai_waktu ?>';
      const akhirValidator = '<?= $buka_tutup[1]->akhir_tgl . ' ' . $buka_tutup[1]->akhir_waktu ?>';

      const now = new Date();

      const mulaiF = new Date(mulaiFasilitator.replace(/-/g, '/'));
      const akhirF = new Date(akhirFasilitator.replace(/-/g, '/'));
      const mulaiV = new Date(mulaiValidator.replace(/-/g, '/'));
      const akhirV = new Date(akhirValidator.replace(/-/g, '/'));

      // Cek status periode
      if (now < mulaiF || now < mulaiV) {
        Swal.fire({
          title: 'Periode Belum Dibuka',
          text: 'Pengisian belum dibuka untuk fasilitator atau validator.',
          icon: 'info',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        return;
      } else if ((now >= mulaiF && now <= akhirF) || (now >= mulaiV && now <= akhirV)) {
        Swal.fire({
          title: 'Penilaian Sedang Berlangsung',
          text: 'Penilaian sedang berlangsung, tunggu hingga proses penilaian selesai.',
          icon: 'info',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        return;
      } else if (now > akhirF && now > akhirV) {
        Swal.fire({
          title: 'Publish Penilaian?',
          html: "Apakah anda yakin ingin publish penilaian <b class=\"text-primary\">" + periode + "</b>?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, publish!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            // Gunakan native submit agar event berjalan normal
            document.getElementById('form-publish-penilaian').submit();
          }
        });
      }
    });

    $(document).on('click', '.btn-publish-nilai-pt', function(event) {
      event.preventDefault();

      const periode = '<?= $periode_dipilih->keterangan ?>';
      let namaPt = $(this).data('nama');

      // Ambil tanggal dan waktu periode fasilitator & validator dari PHP
      const mulaiFasilitator = '<?= $buka_tutup[0]->mulai_tgl . ' ' . $buka_tutup[0]->mulai_waktu ?>';
      const akhirFasilitator = '<?= $buka_tutup[0]->akhir_tgl . ' ' . $buka_tutup[0]->akhir_waktu ?>';
      const mulaiValidator = '<?= $buka_tutup[1]->mulai_tgl . ' ' . $buka_tutup[1]->mulai_waktu ?>';
      const akhirValidator = '<?= $buka_tutup[1]->akhir_tgl . ' ' . $buka_tutup[1]->akhir_waktu ?>';

      const now = new Date();

      const mulaiF = new Date(mulaiFasilitator.replace(/-/g, '/'));
      const akhirF = new Date(akhirFasilitator.replace(/-/g, '/'));
      const mulaiV = new Date(mulaiValidator.replace(/-/g, '/'));
      const akhirV = new Date(akhirValidator.replace(/-/g, '/'));

      // Cek status periode
      if (now < mulaiF || now < mulaiV) {
        Swal.fire({
          title: 'Periode Belum Dibuka',
          text: 'Pengisian belum dibuka untuk fasilitator atau validator.',
          icon: 'info',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        return;
      } else if ((now >= mulaiF && now <= akhirF) || (now >= mulaiV && now <= akhirV)) {
        Swal.fire({
          title: 'Penilaian Sedang Berlangsung',
          text: 'Penilaian sedang berlangsung, tunggu hingga proses penilaian selesai.',
          icon: 'info',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        return;
      } else if (now > akhirF && now > akhirV) {
        Swal.fire({
          title: 'Publish Penilaian?',
          html: "Apakah anda yakin ingin publish penilaian <b class=\"text-primary\">" + periode + "</b> untuk <b class=\"text-danger\">" + namaPt + "</b>?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, publish!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            const idPenilaian = $(this).data('id');
            const periodeKode = $(this).data('periode');
            const kodePt = $(this).data('kode');

            // Lakukan request AJAX untuk publish nilai PT
            $.ajax({
              url: '<?= site_url('admin/publish-penilaian-pt') ?>',
              type: 'POST',
              dataType: 'json',
              data: {
                penilaian_id: idPenilaian,
                periode: periodeKode,
                kode_pt: kodePt,
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
              },
              success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                  Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success'
                  }).then(() => location.reload());
                } else {
                  Swal.fire({
                    title: 'Gagal!',
                    text: response.message || 'Terjadi kesalahan saat mempublish nilai.',
                    icon: 'error'
                  });
                }
              },
              error: function() {
                Swal.fire({
                  title: 'Gagal!',
                  text: 'Terjadi kesalahan saat mempublish nilai.',
                  icon: 'error',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                });
              }
            });
          }
        });
      }
    });

    /* select role */
    $('.role-option').click(function() {
      $('.role-option').removeClass('active');
      $(this).addClass('active');
      let role = $(this).data('role');

      $('input[name="tipePergang"][value="' + role + '"]').prop('checked', true);

      /* reset semua field */
      $('#grupFasilitator, #grupFasilitatorPengganti, #grupValidator, #grupValidatorPengganti').hide();

      $('#selectFasilitator').val('').trigger('change');
      $('#selectFasilitatorPengganti').val('').trigger('change');
      $('#selectFasilitatorPengganti').prop('disabled', true);
      $('#selectValidator').val('').trigger('change');
      $('#selectValidatorPengganti').val('').trigger('change');
      $('#selectValidatorPengganti').prop('disabled', true);

      /* tampilkan sesuai tipe */
      if (role === 'fasilitator') {
        $('#grupFasilitator').slideDown(200);
        $('#grupFasilitatorPengganti').slideDown(200);
      }

      if (role === 'validator') {
        $('#grupValidator').slideDown(200);
        $('#grupValidatorPengganti').slideDown(200);
      }
    });

    /* validasi submit */
    $('#formGantiFaswilValidator').submit(function(e) {
      let tipe = $('input[name="tipePergang"]:checked').val();
      if (!tipe) {
        alert('Silakan pilih tipe pergantian terlebih dahulu');
        e.preventDefault();
        return false;
      }
    });

    /* init select2 */
    $('.select2').select2({
      width: '100%',
      // placeholder: 'Pilih data',
      allowClear: true
    });
  });

  $(document).on('click', '.ubah-status-penilaian', function(event) {
    event.preventDefault(); // Cegah aksi default link
    let pesan = 'Apakah anda yakin ingin mengubah status nilai ' + $(this).attr('data-namapt') + '?'
    Swal.fire({
      title: 'Ubah Status Penilaian?',
      text: pesan,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, proses!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke URL kirim-nilai
        window.location.href = $(this).attr('href');
      }
    });
  });

  $(document).on('click', '.btn-ganti-faswil-validator', function(event) {
    event.preventDefault();
    $('.role-option').removeClass('active');
    $('#grupFasilitator, #grupFasilitatorPengganti, #grupValidator, #grupValidatorPengganti, #grupPTFaswil').hide();
    $('#selectFasilitator').val('').trigger('change');
    $('#selectFasilitatorPengganti').val('').trigger('change');
    $('#selectValidator').val('').trigger('change');
    $('#selectValidatorPengganti').val('').trigger('change');

    const periode = $(this).data('periode');
    const keterangan = $(this).data('keterangan');

    $.ajax({
      url: '<?= site_url('admin/get-faswil-validator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectFasilitator').val('').trigger('change');
        $('#selectValidator').val('').trigger('change');
        $('#selectFasilitatorPengganti').val('').trigger('change');
        $('#selectValidatorPengganti').val('').trigger('change');

        if (response.all_fasilitators) {
          response.all_fasilitators.forEach(function(item) {
            $('#selectFasilitator').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectFasilitatorPengganti').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectFasilitatorPengganti').prop('disabled', true);
          });
        }

        if (response.all_validators) {
          response.all_validators.forEach(function(item) {
            $('#selectValidator').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectValidatorPengganti').append('<option value="' + item.id + '">' + item.nama + '</option>');
            $('#selectValidatorPengganti').prop('disabled', true);
          });
        }

        $('#periodePenilaian').val(response.enc_periode);
        $('#keterangan').val(keterangan);
        $('#modalGantiFaswilValidator').modal('show');
      }
    });
  });

  $(document).on('change', '#selectFasilitator', function() {
    const periode = $('#periodePenilaian').val();
    const idFasilitator = $(this).val();

    // ⛔ STOP kalau kosong
    if (!idFasilitator) {
      $('#grupPTFaswil').hide();
      $('#catatanFaswil').addClass('d-none');
      return;
    }

    $.ajax({
      url: '<?= site_url('admin/get-pt-binaan-fasilitator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        idFasilitator: idFasilitator,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectPTFaswil').select2({
          width: '100%',
          placeholder: '-- Pilih Perguruan Tinggi --',
          allowClear: true
        });

        if (response.data && response.data.length > 0) {
          $('#selectPTFaswil').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          response.data.forEach(function(item) {
            $('#selectPTFaswil').append('<option value="' + item.kode_pt + '">' + item.nama_pt + '</option>');
          });
          $('#grupPTFaswil').show();
          $('#catatanFaswil').removeClass('d-none');
          $('#selectFasilitatorPengganti').prop('disabled', false);
        } else {
          Swal.fire({
            title: 'Informasi',
            text: 'Tidak ada PT binaan untuk fasilitator yang dipilih',
            icon: 'info',
            confirmButtonText: 'OK'
          });
          $('#selectPTFaswil').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          $('#grupPTFaswil').hide();
          $('#catatanFaswil').addClass('d-none');
          $('#selectFasilitatorPengganti').val('').trigger('change');
          $('#selectFasilitatorPengganti').prop('disabled', true);
        }
      }
    });
  });

  $(document).on('change', '#selectValidator', function() {
    const periode = $('#periodePenilaian').val();
    const idValidator = $(this).val();

    // ⛔ STOP kalau kosong
    if (!idValidator) {
      $('#grupPTValidator').hide();
      $('#catatanValidator').addClass('d-none');
      return;
    }

    $.ajax({
      url: '<?= site_url('admin/get-pt-binaan-validator') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        periode: periode,
        idValidator: idValidator,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(response) {
        $('#selectPTValidator').select2({
          width: '100%',
          placeholder: '-- Pilih Perguruan Tinggi --',
          allowClear: true
        });

        if (response.data && response.data.length > 0) {
          $('#selectPTValidator').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          response.data.forEach(function(item) {
            $('#selectPTValidator').append('<option value="' + item.kode_pt + '">' + item.nama_pt + '</option>');
          });
          $('#grupPTValidator').show();
          $('#catatanValidator').removeClass('d-none');
          $('#selectValidatorPengganti').prop('disabled', false);
        } else {
          Swal.fire({
            title: 'Informasi',
            text: 'Tidak ada PT binaan untuk validator yang dipilih',
            icon: 'info',
            confirmButtonText: 'OK'
          });
          $('#selectPTValidator').html('<option value="">-- Pilih Perguruan Tinggi --</option>');
          $('#grupPTValidator').hide();
          $('#catatanValidator').addClass('d-none');
          $('#selectValidatorPengganti').val('').trigger('change');
          $('#selectValidatorPengganti').prop('disabled', true);
        }
      }
    });
  });

  $(document).on('click', '#btnSimpanGanti', function() {
    let tipe = $('input[name="tipePergang"]:checked').val();
    if (!tipe) {
      Swal.fire({
        title: 'Peringatan!',
        text: 'Silakan pilih tipe pergantian terlebih dahulu.',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return false;
    }

    let fieldName = tipe === 'fasilitator' ? 'Fasilitator' : 'Validator';
    let selected = $('#select' + fieldName).val();
    let selectedReplacement = $('#select' + fieldName + 'Pengganti').val();

    if (!selected || !selectedReplacement) {
      Swal.fire({
        title: 'Peringatan!',
        text: 'Pilih ' + fieldName.toLowerCase() + ' terlebih dahulu.',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    const data = {
      tipe: tipe,
      periode: $('#periodePenilaian').val(),
      idFasilitator: $('#selectFasilitator').val(),
      idValidator: $('#selectValidator').val(),
      idFasilitatorPengganti: $('#selectFasilitatorPengganti').val(),
      idValidatorPengganti: $('#selectValidatorPengganti').val(),
      PTFaswil: $('#selectPTFaswil').val(),
      PTValidator: $('#selectPTValidator').val(),
    };

    Swal.fire({
      title: 'Ubah ' + fieldName + '?',
      text: 'Apakah anda yakin ingin mengubah ' + fieldName.toLowerCase() + '?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('admin/update-faswil-validator') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            ...data,
            '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
          },
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Berhasil!',
                text: response.message,
                icon: 'success'
              }).then(() => {
                $('#modalGantiFaswilValidator').modal('hide');
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Gagal!',
                text: response.message || 'Terjadi kesalahan.',
                icon: 'error'
              });
            }
          },
          error: function() {
            Swal.fire({
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat mengubah data.',
              icon: 'error'
            });
          }
        });
      }
    });
  });

  document.querySelectorAll('.counter').forEach(counter => {
    let target = +counter.innerText;
    let count = 0;
    let speed = target / 50;

    function update() {
      count += speed;
      if (count < target) {
        counter.innerText = Math.floor(count);
        requestAnimationFrame(update);
      } else {
        counter.innerText = target;
      }
    }
    update();
  });
</script>