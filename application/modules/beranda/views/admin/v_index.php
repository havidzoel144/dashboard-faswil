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
      <?php
      $roles = $this->session->userdata('roles'); // ambil array roles dari session

      $role_names = [];
      if (!empty($roles) && is_array($roles)) {
        foreach ($roles as $role) {
          $role_names[] = ucwords($role->nama_role); // bisa juga strtoupper($role->nama_role)
        }
      }

      $roles_string = implode(', ', $role_names);
      ?>

      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <div class="card shadow-lg border-0" style="background: linear-gradient(90deg, #1e3c72 0%, #2a5298 100%); color: #f8f9fa;">
            <div class="card-body py-4">
              <h1 class="display-4 font-weight-bold mb-3" style="letter-spacing: 1px; color: #fff;">
                Selamat Datang,
                <span class="badge" style="background: #f8f9fa; color: #2a5298; font-size:1.2em; box-shadow: 0 2px 8px rgba(30,60,114,0.12);">
                  <?= $this->session->userdata('nama') ?>
                </span>
              </h1>
              <p class="lead mb-2" style="font-size:1.3em;">
                Anda login sebagai
                <span class="badge" style="background: #ffb347; color: #1e3c72; font-size:1em; box-shadow: 0 2px 8px rgba(255,179,71,0.12);">
                  <?= $roles_string ?>
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <?php if (has_role([2])) : ?>
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
                            if ($data->id_status_penilaian == '4') {
                              $row_class = 'table-success'; // hijau
                            } elseif ($data->id_status_penilaian == '3') {
                              $row_class = 'table-danger'; // kuning
                            } elseif ($data->id_status_penilaian == '2') {
                              $row_class = 'table-warning'; // merah
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
                                    $data->id_status_penilaian == '2' ? 'badge-warning' : 'badge-secondary'
                                  )
                                );

                                $icon = $data->id_status_penilaian == '4' ? 'fa-check-circle' : (
                                  $data->id_status_penilaian == '3' ? 'fa-times-circle' : (
                                    $data->id_status_penilaian == '2' ? 'fa-hourglass-half' : 'fa-ban'
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
</script>