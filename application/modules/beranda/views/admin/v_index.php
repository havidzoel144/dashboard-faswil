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
      <?php
      $roles = $this->session->userdata('roles'); // ambil array roles dari session

      $role_names = [];
      if (!empty($roles) && is_array($roles)) {
        foreach ($roles as $role) {
          $role_names[] = ucwords($role->nama_role);
        }
      }

      // Gabungkan nama role dengan "dan" sebelum role terakhir jika lebih dari satu
      $roles_string = '';
      $count = count($role_names);
      if ($count > 1) {
        $roles_string = implode(', ', array_slice($role_names, 0, -1));
        $roles_string .= ' dan ' . end($role_names);
      } elseif ($count === 1) {
        $roles_string = $role_names[0];
      }
      ?>

      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <div class="card shadow-lg border-0" style="background: linear-gradient(90deg, #1e3c72 0%, #2a5298 100%); color: #f8f9fa;">
            <div class="card-body py-4">
              <h1 class="display-4 font-weight-bold mb-3" style="letter-spacing: 1px; color: #fff;">
                Selamat Datang,
                <span class="badge" style="background: #f8f9fa; color: #2a5298; font-size:1.2em; box-shadow: 0 2px 8px rgba(30,60,114,0.12); white-space: normal; word-break: break-word; display: inline-block; max-width: 100%;">
                  <?= $this->session->userdata('nama') ?>
                </span>
              </h1>
              <p class="lead mb-2" style="font-size:1.3em;">
                Anda login sebagai
                <?php
                // Tampilkan badge untuk setiap role user, dipisahkan dengan koma dan 'dan' sebelum role terakhir
                if (!empty($role_names)) {
                  $count = count($role_names);
                  foreach ($role_names as $idx => $role) {
                    // Tampilkan badge nama role
                    echo '<span class="badge" style="background: #ffb347; color: #1e3c72; font-size:1em; box-shadow: 0 2px 8px rgba(255,179,71,0.12);">' . ($role == 'Penjamu' ? 'PT ' . $role : $role) . '</span>';
                    // Tambahkan pemisah jika lebih dari satu role
                    if ($count > 1 && $idx < $count - 1) {
                      // Jika sebelum role terakhir, gunakan ' dan ', selain itu gunakan koma
                      echo '<span style="color:#fff;">' . ($idx == $count - 2 ? ' dan ' : ', ') . '</span>';
                    }
                  }
                }
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>

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

        <div class="row mb-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title ml-1" id="heading-buttons1">Data Penilaian Tipologi | <span class="badge badge-secondary font-medium-1"><?= $periode_aktif->keterangan ?></span></h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
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
                              <td class="text-start" style="width: 13%;"><?= $data->keterangan ?></td>
                              <td class="text-start" style="width: 15%;">
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