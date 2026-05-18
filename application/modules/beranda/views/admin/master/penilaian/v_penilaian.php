<?= $this->load->view('admin/v_header') ?>
<style>
  .popover {
    z-index: 1060 !important;
  }

  .popover-skor4 {
    max-width: 80vw !important;
    width: 600px;
    overflow-y: auto;
    /* muncul scroll kalau kepanjangan */
    white-space: normal;
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
      <?php if ($periode_dipilih->status == '1') : ?>
        <div class="row">
          <div class="col-12">
            <?php
            // Ambil tanggal dan waktu sekarang
            $now = new DateTime();

            // Ambil data periode dari $buka_tutup[0]
            $mulai = new DateTime($bt->mulai_tgl . ' ' . $bt->mulai_waktu);
            $akhir = new DateTime($bt->akhir_tgl . ' ' . $bt->akhir_waktu);

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
              <strong style="display: inline-block; width: 220px; border-right: 1px solid #90caf9;">Periode <?= $bt->jenis ?></strong>
              <?= $label ?>
              <span style="font-weight: 500;">
                <?= $bt->mulai_tgl . ' ' . $bt->mulai_waktu . ' s/d ' . $bt->akhir_tgl . ' ' . $bt->akhir_waktu ?>
              </span>
            </div>
          </div>
        </div>

        <div class="row match-height">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" id="list-basic">Perguruan Tinggi</h4>
              </div>
              <div class="card-body">
                <div id="list-pt">
                  <input type="text" class="search form-control round border-primary mb-1" placeholder="Cari">
                  <ul class="list-group list">
                    <?php if (!empty($data_pt_binaan)) : ?>
                      <?php foreach ($data_pt_binaan as $data) : ?>
                        <?php
                        $is_disabled = ($data->id_status_penilaian == '4' || $data->id_status_penilaian == '2' || $data->id_status_penilaian == '5' || $data->id_status_penilaian == '6');
                        $item_class = $data->id_status_penilaian == '6' ? 'bg-dark text-white' : (
                          $data->id_status_penilaian == '5' ? 'bg-primary text-white' : (
                            $data->id_status_penilaian == '4' ? 'bg-success text-white' : (
                              $data->id_status_penilaian == '3' ? 'bg-danger text-white' : (
                                $data->id_status_penilaian == '2' ? 'bg-warning text-dark' : (
                                  $data->id_status_penilaian == '1' ? 'bg-info text-white' : ''
                                )
                              )
                            )
                          )
                        );
                        ?>
                        <li class="list-group-item <?= $item_class ?><?= $is_disabled ? ' disabled-pt' : '' ?>"
                          data-nama-pt="<?= $data->nama_pt ?>"
                          data-kode-pt="<?= $data->kode_pt ?>"
                          data-id-penilaian="<?= $data->id_penilaian_tipologi ?>"
                          style="cursor:<?= $is_disabled ? 'not-allowed' : 'pointer' ?>;"
                          <?= $is_disabled ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                          <div class="d-flex justify-content-between align-items-center">
                            <div style="flex: 1 1 70%; min-width: 0;">
                              <h4 class="nama_pt" style="margin-bottom: 4px;"><?= $data->nama_pt ?></h4>
                              <hr class="border-light" style="margin: 4px 0;">
                              <p class="kode_pt" style="margin-bottom: 0;"><?= $data->kode_pt ?></p>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center" style="flex: 0 0 80px; min-width: 80px; min-height: 60px;">
                              <?php if ($data->id_status_penilaian == '6'): ?>
                                <i class="fa fa-rotate-left" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-dark text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php elseif ($data->id_status_penilaian == '5'): ?>
                                <i class="fa fa-paper-plane" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-primary text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php elseif ($data->id_status_penilaian == '4'): ?>
                                <i class="fa fa-check-circle" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-success text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php elseif ($data->id_status_penilaian == '3'): ?>
                                <i class="fa fa-times-circle" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-danger text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php elseif ($data->id_status_penilaian == '2'): ?>
                                <i class="fa fa-hourglass-half" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-warning text-dark text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php elseif ($data->id_status_penilaian == '1'): ?>
                                <i class="fa fa-spinner fa-spin" style="font-size: 3em;"></i>
                                <div>
                                  <span class="badge bg-info text-wrap" style="margin-top: 5px; font-size: 1em; white-space: wrap;"><?= $data->nm_status ?></span>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <li class="list-group-item">
                        <h3 class="nama_pt">Belum ada data</h3>
                        <p class="kode_pt">-</p>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mt-n1 mb-n1">
                  <h4 class="card-title" id="heading-buttons1">Input Skor</h4>
                  <a href="<?= base_url('admin/penilaian-tipologi') ?>">
                    <button type="button" class="btn btn-dark waves-effect waves-light">
                      Kembali
                    </button>
                  </a>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="card-content">
                <div class="card-body">

                  <div class="row">
                    <div class="col-sm-12">
                      <?php echo form_open(site_url('admin/simpan-skor'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-input-skor')); ?>

                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="kode-pt" class="label-required">Kode PT</label>
                            <input type="text" class="form-control square" id="kode-pt" name="kode_pt" required readonly>
                            <input type="hidden" class="form-control square" id="id-penilaian-tipologi" name="id_penilaian_tipologi" required readonly>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <fieldset class="form-group mb-1">
                            <label for="nama-pt" class="label-required">Nama PT</label>
                            <input type="text" class="form-control square" id="nama-pt" name="nama_pt" required readonly>
                          </fieldset>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-1" class="label-required">
                              Skor 1
                              <span class="text-danger" data-toggle="popover" data-content="0 = Tidak Memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Perguruan tinggi terbukti telah mengimplementasikan Sistem Penjaminan Mutu Internal yang  mencakup keempat aspek secara konsisten dan efektif dalam peningkatan mutu pendidikan secara berkelanjutan. <br> 1.5 = Perguruan tinggi terbukti telah mengimplementasikan Sistem Penjaminan Mutu Internal yang mencakup keempat aspek secara konsisten dan efektif dalam peningkatan mutu pendidikan secara berkelanjutan, serta telah menunjukkan adanya upaya pengembangan, namun belum sepenuhnya terbukti efektif <br> 2 = Syarat perlu status terakreditasi Unggul : Perguruan tinggi terbukti telah mengembangkan dan mengimplementasikan Sistem Penjaminan Mutu Internal yang  mencakup keempat aspek dan telah terbukti efektif dalam peningkatan mutu pendidikan secara berkelanjutan." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <select class="form-control square" id="skor-1" name="skor_1" required>
                              <option value="">-- Pilih Skor --</option>
                              <option value="0.0">0</option>
                              <option value="1.0">1</option>
                              <option value="1.5">1.5</option>
                              <option value="2.0">2</option>
                            </select>
                            <div class="mt-1 lihat-narasi-led d-none">
                              <small class="text-muted">
                                <a href="javascript:void(0)" data-indikator="1" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Narasi LED Indikator 1" class="badge badge-primary d-block w-100 text-center py-1 narasi-indikator-led">
                                  <i class="fa fa-search"></i> Narasi LED Indikator 1
                                </a>
                              </small>
                            </div>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1" class="label-required">
                                  Catatan Skor 1
                                  <span class="text-danger" data-toggle="popover" data-content="Sistem Penjaminan Mutu Internal yang dikembangkan Perguruan Tinggi, mencakup: <br> 1. Standar Pendidikan Tinggi (akademik dan non akademik) yang melampauai SN Dikti dan sesuai fokus misi PT, telah ditetapkan oleh perguruan tinggi serta telah disosialisasikan ke seluruh pemangku kepentingan. <br> 2. Sistem Tatakelola Perguruan Tinggi dalam mengimplementasikan SPMI, mencakup minimal: SOP implementasi SPMI, keberfungsian SPMI di berbagai tingkat (pelaksana dan sistem implementasi) yang akuntabel, transparan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 3. Sistem Evaluasi Pemenuhan Standar Pendidikan Tinggi yang transparan, akuntabel, mapan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 4. Sistem Peningkatan Mutu Berkelanjutan yang telah diimplementasikan secara efektif dan efisien paling sedikit selama 3 tahun." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_1" id="catatan-1" placeholder="Indikator Penilaian : Sistem Penjaminan Mutu Internal yang dikembangkan Perguruan Tinggi, mencakup: 1. Standar Pendidikan Tinggi (akademik dan non akademik) yang melampauai SN Dikti dan sesuai fokus misi PT, telah ditetapkan oleh perguruan tinggi serta telah disosialisasikan ke seluruh pemangku kepentingan. 2. Sistem Tatakelola Perguruan Tinggi dalam mengimplementasikan SPMI, mencakup minimal: SOP implementasi SPMI, keberfungsian SPMI di berbagai tingkat (pelaksana dan sistem implementasi) yang akuntabel, transparan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. 3. Sistem Evaluasi Pemenuhan Standar Pendidikan Tinggi yang transparan, akuntabel, mapan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. 4. Sistem Peningkatan Mutu Berkelanjutan yang telah diimplementasikan secara efektif dan efisien paling sedikit selama 3 tahun." required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1-validator">Catatan Skor 1 Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-1-validator" placeholder="Catatan skor 1 dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>

                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-2" class="label-required">
                              Skor 2
                              <span class="text-danger" data-toggle="popover" data-content="0 = Tidak Memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Perguruan Tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tatakelola perguruan tinggi dalam bidang akademik dan non-akademik. <br> 1.5 = Perguruan tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian, dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tata kelola perguruan tinggi dalam bidang akademik dan non-akademik, serta sudah menunjukkan adanya upaya peningkatan mutu pendidikan tinggi yang memenuhi aspek berkelanjutan, efektif, dan konsisten. <br> 2 = Syarat perlu status terakreditasi Unggul : Perguruan Tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tatakelola perguruan tinggi dalam bidang akademik dan non-akademik  untuk meningkatkan mutu pendidikan tinggi secara berkelanjutan, efektif dan konsisten. " data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <select class="form-control square" id="skor-2" name="skor_2" required>
                              <option value="">-- Pilih Skor --</option>
                              <option value="0.0">0</option>
                              <option value="1.0">1</option>
                              <option value="1.5">1.5</option>
                              <option value="2.0">2</option>
                            </select>
                            <div class="mt-1 lihat-narasi-led d-none">
                              <small class="text-muted">
                                <a href="javascript:void(0)" data-indikator="2" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Narasi LED Indikator 2" class="badge badge-primary d-block w-100 text-center py-1 narasi-indikator-led">
                                  <i class="fa fa-search"></i> Narasi LED Indikator 2
                                </a>
                              </small>
                            </div>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-2" class="label-required">
                                  Catatan Skor 2
                                  <span class="text-danger" data-toggle="popover" data-content="Implementasi siklus  penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan (PPEPP) dalam bidang akademik dan non-akademik, paling sedikit selama 3 tahun secara konsisten, berkelanjutan dan terbukti efektif, dan terdiri atas: <br> 1. Penetapan Standar Pendidikan Tinggi  yang sesuai misi perguruan tinggi, yaitu perancangan, perumusan, dan pengesahan standar PT. <br> 2. Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan standar oleh semua pihak yang bertanggungjawab agar isi standar tercapai. <br> 3. Evaluasi Pemenuhan Standar Pendidikan Tinggi, yaitu evaluasi kesesuaian pelaksanaan standar dengan standar yang telah ditetapkan dan cara pemenuhannya. <br> 4. Pengendalian Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan koreksi bila terjadi penyimpangan terhadap isi dan/atau pelaksanaan standar, mempertahan pelaksanaan yang telah memenuhi standar dan sedapat mungkin meningkatkan kualitas pelaksanaannya. <br> 5. Peningkatan Standar Pendidikan Tinggi, yaitu evaluasi isi standar dan peningkatan  mutu isi standar secara berkala dan berkelanjutan." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_2" id="catatan-2" placeholder="Indikator Penilaian : Implementasi siklus  penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan (PPEPP) dalam bidang akademik dan non-akademik, paling sedikit selama 3 tahun secara konsisten, berkelanjutan dan terbukti efektif, dan terdiri atas: 1. Penetapan Standar Pendidikan Tinggi  yang sesuai misi perguruan tinggi, yaitu perancangan, perumusan, dan pengesahan standar PT. 2. Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan standar oleh semua pihak yang bertanggungjawab agar isi standar tercapai. 3. Evaluasi Pemenuhan Standar Pendidikan Tinggi, yaitu evaluasi kesesuaian pelaksanaan standar dengan standar yang telah ditetapkan dan cara pemenuhannya. 4. Pengendalian Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan koreksi bila terjadi penyimpangan terhadap isi dan/atau pelaksanaan standar, mempertahan pelaksanaan yang telah memenuhi standar dan sedapat mungkin meningkatkan kualitas pelaksanaannya. 5. Peningkatan Standar Pendidikan Tinggi, yaitu evaluasi isi standar dan peningkatan  mutu isi standar secara berkala dan berkelanjutan." required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-2-validator">Catatan Skor 2 Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-2-validator" placeholder="Catatan skor 2 dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-3" class="label-required">
                              Skor 3
                              <span class="text-danger" data-toggle="popover" data-content="0 = Tidak memenuhi <br> 1 = Perguruan tinggi terbukti memililki laporan implementasi SPMI secara berkala dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi. <br> 1.5 = Perguruan tinggi terbukti memiliki laporan implementasi SPMI secara berkala dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi, namun belum sepenuhnya sistematis. <br> 2 = Perguruan tinggi terbukti memililki laporan implementasi SPMI secara berkala, sistematis, dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <select class="form-control square" id="skor-3" name="skor_3" required>
                              <option value="">-- Pilih Skor --</option>
                              <option value="0.0">0</option>
                              <option value="1.0">1</option>
                              <option value="1.5">1.5</option>
                              <option value="2.0">2</option>
                            </select>
                            <div class="mt-1 lihat-narasi-led d-none">
                              <small class="text-muted">
                                <a href="javascript:void(0)" data-indikator="3" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Narasi LED Indikator 3" class="badge badge-primary d-block w-100 text-center py-1 narasi-indikator-led">
                                  <i class="fa fa-search"></i> Narasi LED Indikator 3
                                </a>
                              </small>
                            </div>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-3" class="label-required">
                                  Catatan Skor 3
                                  <span class="text-danger" data-toggle="popover" data-content="Laporan implementasi SPMI dan kinerja perguruan tinggi secara berkala, sistematis,  dan pengelolaan data serta informasi terkait implementasi SPMI melalui PD Dikti, mencakup: <br> 1. Laporan semesteran/tahunan tentang implementasi SPMI dan kinerja perguruan tinggi yang menerus bertambah baik dalam bentuk digital/sistem/hardcopy paling sedikit selama 3 tahun terakhir secara sistematis. <br> 2. Keberfungsian sistem pengelolaan data dan informasi  terkait implementasi SPMI melalui PD Dikti yang transparan, akuntabel, valid dan berintegritas." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_3" id="catatan-3" placeholder="Infikator Penilaian : Laporan implementasi SPMI dan kinerja perguruan tinggi secara berkala, sistematis,  dan pengelolaan data serta informasi terkait implementasi SPMI melalui PD Dikti, mencakup: 1. Laporan semesteran/tahunan tentang implementasi SPMI dan kinerja perguruan tinggi yang menerus bertambah baik dalam bentuk digital/sistem/hardcopy paling sedikit selama 3 tahun terakhir secara sistematis. 2. Keberfungsian sistem pengelolaan data dan informasi  terkait implementasi SPMI melalui PD Dikti yang transparan, akuntabel, valid dan berintegritas." required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-3-validator">Catatan Skor 3 Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-3-validator" placeholder="Catatan skor 3 dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row mb-1">
                        <div class="col-md-3 mb-1 mb-md-0">
                          <div class="p-2 rounded" style="background:#ffffff; box-shadow:inset 0 0 0 1px #bdeed8;">
                            <small class="text-muted d-block">Total Prodi</small>
                            <div class="font-weight-bold" id="total-prodi-aktif" style="font-size:1.05rem; color:#0f766e;">-</div>
                          </div>
                        </div>
                        <div class="col-md-3 mb-1 mb-md-0">
                          <div class="p-2 rounded" style="background:#ffffff; box-shadow:inset 0 0 0 1px #bdeed8;">
                            <small class="text-muted d-block">Jumlah Prodi Terakreditasi</small>
                            <div class="font-weight-bold" id="prodi-terakreditasi" style="font-size:1.05rem; color:#0f766e;">-</div>
                          </div>
                        </div>
                        <div class="col-md-3 mb-1 mb-md-0">
                          <div class="p-2 rounded" style="background:#ffffff; box-shadow:inset 0 0 0 1px #bdeed8;">
                            <small class="text-muted d-block">Jumlah Prodi Unggul/A</small>
                            <div class="font-weight-bold" id="prodi-unggul-atau-a" style="font-size:1.05rem; color:#0f766e;">-</div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="p-2 rounded" style="background:#ffffff; box-shadow:inset 0 0 0 1px #bdeed8;">
                            <small class="text-muted d-block">Persentase Prodi Unggul/A</small>
                            <div class="font-weight-bold" id="persentase-prodi-unggul-atau-a" style="font-size:1.05rem; color:#0f766e;">-</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-4" class="label-required">
                              Skor 4
                              <span class="text-danger popover-skor4-trigger" data-toggle="popover" data-content="0 = Tidak memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Persentase PS terakreditasi 100%. <br> 1.5 = Syarat perlu status terakreditasi Unggul  (Semua Prodi Harus Terakreditasi) : <ol><li>PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A =>15% sd <20%</li><li>PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A =>10% sd <15%</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal =>40% sd <50% (PTNBH)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A =>20% sd <25%. (PTN Akademik)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal =>30% sd <40%.(PTN Vokasi)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A =>10% sd <15%.(PTS Vokasi)</li></ol> 2 = Syarat perlu status terakreditasi Unggul (Semua Prodi Harus Terakreditasi) : <ol><li>PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%.</li><li>PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%.</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 50%.(PTN BH)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 25%. (PTN Akademik)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 40%.(PTN Vokasi)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%.(PTS Vokasi)</li></ol>" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <select class="form-control square" id="skor-4" name="skor_4" required>
                              <option value="">-- Pilih Skor --</option>
                              <option value="0.0">0</option>
                              <option value="1.0">1</option>
                              <option value="1.5">1.5</option>
                              <option value="2.0">2</option>
                            </select>
                            <div class="mt-1 lihat-narasi-led d-none">
                              <small class="text-muted">
                                <a href="javascript:void(0)" data-indikator="4" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Narasi LED Indikator 4" class="badge badge-primary d-block w-100 text-center py-1 narasi-indikator-led">
                                  <i class="fa fa-search"></i> Narasi LED Indikator 4
                                </a>
                              </small>
                            </div>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-4" class="label-required">
                                  Catatan Skor 4
                                  <span class="text-danger" data-toggle="popover" data-content="Pengakuan eksternal atas capaian target-target mutu pendidikan berupa akreditasi Program Studi, yaitu: <br> 1. PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%. <br> 2. PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_4" id="catatan-4" placeholder="Indikator Penilaian : Pengakuan eksternal atas capaian target-target mutu pendidikan berupa akreditasi Program Studi, yaitu: 1. PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%. 2. PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%." required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-4-validator">Catatan Skor 4 Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-4-validator" placeholder="Catatan skor 4 dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="row">
                        <div class="col-lg-12">
                          <fieldset class="form-group mb-1">
                            <label for="skor-2" class="label-required">Link Detail Penilaian</label>
                            <input type="text" class="form-control square" id="link-detail-penilaian" name="link_detail_penilaian" placeholder="Masukkan link detail penilaian" required>
                          </fieldset>
                        </div>
                      </div> -->

                      <div class="row">
                        <div class="col-lg-12">
                          <fieldset class="form-group mb-1">
                            <label for="catatan-keseluruhan" class="label-required">
                              Rekomendasi Perbaikan
                              <span class="text-danger" data-toggle="popover" data-content="<b>Point :</b> sebutkan masalah utama secara jelas; <br> <b>Lead-in :</b> jelaskan secara singkat konteks atau urgensi masalah; <br> <b>Observation :</b> tuliskan temuan atau analisis penyebab masalah berdasarkan data atau hasil evaluasi; <br> <b>Recommendation :</b> tuliskan saran tindakan yang spesifik, aplikatif, dan terukur yang dapat  langsung diterapkan;" data-trigger="hover" data-original-title="Gunakan pendekatan PLOR dalam menyusun rekomendasi perbaikan:" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <textarea class="form-control textarea-catatan" name="catatan_keseluruhan" id="catatan-keseluruhan" placeholder="Berikan catatan keseluruhan" rows="5" required></textarea>
                          </fieldset>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <fieldset class="form-group mb-1">
                            <label for="catatan-keseluruhan-validator">Catatan Keseluruhan Validator</label>
                            <textarea class="form-control textarea-catatan" id="catatan-keseluruhan-validator" placeholder="Catatan keseluruhan dari validator" rows="5" disabled></textarea>
                          </fieldset>
                        </div>
                      </div>

                      <?php
                      if ($buka_tutup == "tutup") {
                      ?>
                        <button type="button" onclick="alert('<?= $dabk->pesan ?>')" class="btn btn-danger"><i class="la la-ban"></i> Penilaian Ditutup</button>
                      <?php } else { ?>
                        <button type="submit" class="btn btn-primary">Simpan Skor</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                      <?php } ?>

                      <?php echo form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- MODAL NARASI -->
      <div class="modal fade" id="modal-narasi-led" tabindex="-1" role="dialog" aria-labelledby="modalNarasiLedLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <h5 class="modal-title text-white" id="modalNarasiLedLabel">Narasi LED</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group mb-0">
                <label for="narasi-led-indikator">Isi Narasi LED</label>
                <textarea class="form-control textarea-catatan" id="narasi-led-indikator" rows="18" placeholder="Narasi LED Indikator 1 akan ditampilkan di sini." readonly></textarea>
              </div>
              <div class="form-group mt-2 mb-0">
                <label for="link-bukti-indikator">Link Bukti</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="link-bukti-indikator" placeholder="Link bukti indikator akan ditampilkan di sini." readonly>
                  <div class="input-group-append">
                    <a href="#" target="_blank" class="btn btn-info" id="btn-link-bukti-indikator">Buka Link</a>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
      <!-- MODAL NARASI -->

      <!-- Basic Horizontal Timeline -->
      <div class="row mb-5">
        <div class="col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="d-flex align-items-center justify-content-between ml-1 <?= $periode_dipilih->status == '0' ?  'mt-n1' : '' ?>">
                <h4 class="card-title" id="heading-buttons1">Data Penilaian Tipologi | <span class="badge badge-secondary font-medium-1"><?= $periode_dipilih->keterangan ?></span></h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                <?php if ($periode_dipilih->status == '0') : ?>
                  <a href="<?= base_url('admin/penilaian-tipologi') ?>">
                    <button type="button" class="btn btn-dark waves-effect waves-light">
                      Kembali
                    </button>
                  </a>
                <?php else : ?>

                  <?php
                  if ($buka_tutup == "tutup") {
                  ?>
                    <a href="#" class="btn btn-danger waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Sudah ditutup">
                      Penilaian sudah ditutup
                    </a>
                  <?php } else { ?>
                    <a href="<?= base_url('admin/kirim-nilai/' . safe_url_encrypt($periode_dipilih->kode) . '/' . safe_url_encrypt('semua')) ?>" class="btn btn-primary waves-effect waves-light kirim-nilai" data-toggle="tooltip" data-placement="top" title="Kirim semua nilai yang statusnya draft (penilaian fasilitator) ke validator" data-content="semua nilai">
                      Kirim Nilai ke Validator
                    </a>
                  <?php } ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-penilaian" class="table table-striped table-bordered" width="100%">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center" rowspan="2">#</th>
                        <th class="text-center" rowspan="2">Periode <span class="text-danger" data-toggle="popover" data-content="Periode 1 : Januari - Juni <br> Periode 2 : Juli - November" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center" rowspan="2">Kode PT</th>
                        <th class="text-center" rowspan="2">Nama PT</th>
                        <th class="text-center" colspan="4">Butir Penilaian</th>
                        <th class="text-center" rowspan="2">
                          Skor <br> Total <br>
                          <span class="text-danger" data-toggle="popover" data-content="Skor Total = Skor 1 + Skor 2 + Skor 3 + Skor 4" data-trigger="hover" data-original-title="Formula Perhitungan"><i class="la la-info-circle"></i></span>
                        </th>
                        <th class="text-center" rowspan="2">
                          Tipologi
                          <span class="text-danger" data-toggle="popover" data-content="Tipologi 1 : 8; <br> Tipologi 2 : 6-7,5; <br> Tipologi 3 : 4-5,5; <br> Tipologi 4 : < 4;" data-trigger="hover" data-original-title="Ketentuan Tipologi" data-html="true"><i class="la la-info-circle"></i></span>
                        </th>
                        <th class="text-center" rowspan="2">Status</th>
                        <th class="text-center" rowspan="2">Aksi</th>
                      </tr>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center text-wrap">Skor 1 <span class="text-danger" data-toggle="popover" data-content="Sistem Penjaminan Mutu Internal yang dikembangkan Perguruan Tinggi, mencakup: <br> 1. Standar Pendidikan Tinggi (akademik dan non akademik) yang melampauai SN Dikti dan sesuai fokus misi PT, telah ditetapkan oleh perguruan tinggi serta telah disosialisasikan ke seluruh pemangku kepentingan. <br> 2. Sistem Tatakelola Perguruan Tinggi dalam mengimplementasikan SPMI, mencakup minimal: SOP implementasi SPMI, keberfungsian SPMI di berbagai tingkat (pelaksana dan sistem implementasi) yang akuntabel, transparan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 3. Sistem Evaluasi Pemenuhan Standar Pendidikan Tinggi yang transparan, akuntabel, mapan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 4. Sistem Peningkatan Mutu Berkelanjutan yang telah diimplementasikan secara efektif dan efisien paling sedikit selama 3 tahun." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center text-wrap">Skor 2 <span class="text-danger" data-toggle="popover" data-content="Implementasi siklus  penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan (PPEPP) dalam bidang akademik dan non-akademik, paling sedikit selama 3 tahun secara konsisten, berkelanjutan dan terbukti efektif, dan terdiri atas: <br> 1. Penetapan Standar Pendidikan Tinggi  yang sesuai misi perguruan tinggi, yaitu perancangan, perumusan, dan pengesahan standar PT. <br> 2. Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan standar oleh semua pihak yang bertanggungjawab agar isi standar tercapai. <br> 3. Evaluasi Pemenuhan Standar Pendidikan Tinggi, yaitu evaluasi kesesuaian pelaksanaan standar dengan standar yang telah ditetapkan dan cara pemenuhannya. <br> 4. Pengendalian Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan koreksi bila terjadi penyimpangan terhadap isi dan/atau pelaksanaan standar, mempertahan pelaksanaan yang telah memenuhi standar dan sedapat mungkin meningkatkan kualitas pelaksanaannya. <br> 5. Peningkatan Standar Pendidikan Tinggi, yaitu evaluasi isi standar dan peningkatan  mutu isi standar secara berkala dan berkelanjutan." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center text-wrap">Skor 3 <span class="text-danger" data-toggle="popover" data-content="Laporan implementasi SPMI dan kinerja perguruan tinggi secara berkala, sistematis,  dan pengelolaan data serta informasi terkait implementasi SPMI melalui PD Dikti, mencakup: <br> 1. Laporan semesteran/tahunan tentang implementasi SPMI dan kinerja perguruan tinggi yang menerus bertambah baik dalam bentuk digital/sistem/hardcopy paling sedikit selama 3 tahun terakhir secara sistematis. <br> 2. Keberfungsian sistem pengelolaan data dan informasi  terkait implementasi SPMI melalui PD Dikti yang transparan, akuntabel, valid dan berintegritas." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center text-wrap">Skor 4 <span class="text-danger" data-toggle="popover" data-content="Pengakuan eksternal atas capaian target-target mutu pendidikan berupa akreditasi Program Studi, yaitu: <br> 1. PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%. <br> 2. PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_pt_binaan)) { // Cek apakah array data_pt_binaan tidak kosong
                        foreach ($data_pt_binaan as $data) {
                          if (substr($data->periode, -1, 1) == '1') {
                            $periode = substr($data->periode, 0, 4) . ' Periode 1';
                          } else {
                            $periode = substr($data->periode, 0, 4) . ' Periode 2';
                          }

                          $row_class = '';

                          if ($data->id_status_penilaian == '6') {
                            $row_class = 'table-secondary'; // abu-abu
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
                          <tr class="<?= $row_class ?> text-dark">
                            <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                            <td class="text-center" style="width: 10%;"><?= $periode ?></td>
                            <td class="text-center" style="width: 5%;"><?= $data->kode_pt ?></td>
                            <td class="text-start" style="width: 20%;"><?= $data->nama_pt ?></td>
                            <?php if (in_array($data->id_status_penilaian, ['5', '6'])) : ?>
                              <td class="text-center" colspan="6" style="width: 5%;">
                                <?php if ($data->id_status_penilaian == '5') : ?>
                                  <i class="fa fa-paper-plane" style="color: #007bff;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nilai sudah divalidasi oleh validator, tetapi belum dipublish"></i>
                                <?php elseif ($data->id_status_penilaian == '6') : ?>
                                  <i class="fa fa-gear" style="color: #ff003c;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Menunggu approval admin"></i>
                                <?php endif; ?>
                              </td>
                            <?php else : ?>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->skor_1 ?>
                                <?php
                                $warna_1 = ($data->cek_1 == '1' && $data->skor_1 !== null) ? 'text-success' : 'text-danger';
                                $iconCek_1 = ($data->cek_1 == '1' && $data->skor_1 !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_1 == '0' && $data->skor_1 !== null) ? '<i class="fa fa-times"></i>' : '');
                                ?>
                                <span class="<?= $warna_1 ?>" data-toggle="popover" data-content="<?= $data->catatan_1_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 1" style="cursor: pointer;"><?= $iconCek_1 ?></span>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->skor_2 ?>
                                <?php
                                $warna_2 = ($data->cek_2 == '1' && $data->skor_2 !== null) ? 'text-success' : 'text-danger';
                                $iconCek_2 = ($data->cek_2 == '1' && $data->skor_2 !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_2 == '0' && $data->skor_2 !== null) ? '<i class="fa fa-times"></i>' : '');
                                ?>
                                <span class="<?= $warna_2 ?>" data-toggle="popover" data-content="<?= $data->catatan_2_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 2" style="cursor: pointer;"><?= $iconCek_2 ?></span>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->skor_3 ?>
                                <?php
                                $warna_3 = ($data->cek_3 == '1' && $data->skor_3 !== null) ? 'text-success' : 'text-danger';
                                $iconCek_3 = ($data->cek_3 == '1' && $data->skor_3 !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_3 == '0' && $data->skor_3 !== null) ? '<i class="fa fa-times"></i>' : '');
                                ?>
                                <span class="<?= $warna_3 ?>" data-toggle="popover" data-content="<?= $data->catatan_3_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 3" style="cursor: pointer;"><?= $iconCek_3 ?></span>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->skor_4 ?>
                                <?php
                                $warna_4 = ($data->cek_4 == '1' && $data->skor_4 !== null) ? 'text-success' : 'text-danger';
                                $iconCek_4 = ($data->cek_4 == '1' && $data->skor_4 !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_4 == '0' && $data->skor_4 !== null) ? '<i class="fa fa-times"></i>' : '');
                                ?>
                                <span class="<?= $warna_4 ?>" data-toggle="popover" data-content="<?= $data->catatan_4_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 4" style="cursor: pointer;"><?= $iconCek_4 ?></span>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->skor_total ?>
                              </td>
                              <td class="text-center" style="width: 5%;">
                                <?= $data->tipologi ?>
                              </td>
                            <?php endif; ?>

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
                            <td class="text-center" style="width: 8%;">
                              <div class="btn-group" role="group">
                                <?php if ($data->id_status_penilaian == 1 && $periode_dipilih->status == '1') : ?>
                                  <a href="<?= base_url('admin/kirim-nilai/' . safe_url_encrypt($periode_dipilih->kode) . '/' . safe_url_encrypt($data->id_penilaian_tipologi)) ?>" class="btn btn-primary btn-sm waves-effect waves-light kirim-nilai" data-toggle="tooltip" data-placement="top" title="Kirim Nilai ke Validator" data-namapt="<?= $data->nama_pt ?>">
                                    <i class="la la-paper-plane"></i>
                                  </a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/riwayat-penilaian/' . safe_url_encrypt($data->id_penilaian_tipologi)) ?>" target="_blank">
                                  <button class="btn btn-dark btn-sm waves-effect waves-light" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Riwayat Penilaian">
                                    <i class="la la-history"></i>
                                  </button>
                                </a>
                              </div>
                            </td>
                          </tr>
                        <?php
                        }
                      } else { // Jika data_pt_binaan kosong
                        ?>
                        <tr>
                          <td colspan="12" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
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
  $('.narasi-indikator-led').on('click', function() {
    let id_penilaian_tipologi = $('#id-penilaian-tipologi').val();
    let narasi = 'narasi_' + $(this).data('indikator');
    let bukti = 'bukti_' + $(this).data('indikator');

    $.ajax({
      url: '<?= base_url("admin/get-penilaian") ?>',
      method: 'POST',
      data: {
        id_penilaian_tipologi: id_penilaian_tipologi,
        [csrfName]: csrfHash
      },
      dataType: 'json',
      success: function(response) {
        if (response.form_led == null) {
          return Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "Narasi tidak tersedia.",
            confirmButtonColor: '#dc3545'
          });
        }

        const indikator = narasi.split('_')[1];
        const indikatorMap = {
          '1': { label: 'Sasaran Mutu Masukan', narasiKey: 'sasaran_mutu_masukan', buktiKey: 'tautan_sasaran_mutu_masukan' },
          '2': { label: 'Sasaran Mutu Proses', narasiKey: 'sasaran_mutu_proses', buktiKey: 'tautan_sasaran_mutu_proses' },
          '3': { label: 'Sasaran Mutu Luaran', narasiKey: 'sasaran_mutu_luaran', buktiKey: 'tautan_sasaran_mutu_luaran' },
          '4': { label: 'Sasaran Mutu Dampak', narasiKey: 'sasaran_mutu_dampak', buktiKey: 'tautan_sasaran_mutu_dampak' }
        };

        let narasiValue = response.data[narasi] ? response.data[narasi] : '';
        let buktiValue = response.data[bukti] ? response.data[bukti] : '';

        if (indikatorMap[indikator]) {
          narasiValue = response.form_led[indikatorMap[indikator].narasiKey] ? response.form_led[indikatorMap[indikator].narasiKey] : '';
          buktiValue = response.form_led[indikatorMap[indikator].buktiKey] ? response.form_led[indikatorMap[indikator].buktiKey] : '';
        }

        $('#modalNarasiLedLabel').text((indikatorMap[indikator] ? indikatorMap[indikator].label : 'Indikator ' + indikator));
        $('#narasi-led-indikator').val(narasiValue);
        $('#link-bukti-indikator').val(buktiValue);
        $('#btn-link-bukti-indikator').attr('href', buktiValue);
        $('#modal-narasi-led').modal('show');
      },
      error: function(xhr) {
        alert('Gagal mengambil data');
      }
    });
  });

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

    var list_pt_options = {
      valueNames: ['nama_pt', 'kode_pt']
    };

    var ListPT = new List('list-pt', list_pt_options);
  });

  $('.popover-skor4-trigger').popover('dispose');
  $('.popover-skor4-trigger').popover({
    html: true,
    trigger: 'hover',
    placement: 'auto',
    template: `
        <div class="popover popover-skor4" role="tooltip">
            <div class="arrow"></div>
            <h3 class="popover-header"></h3>
            <div class="popover-body"></div>
        </div>
    `
  });

  $(document).on('submit', '#form-input-skor', function(event) {
    // let nama_pt = document.getElementById('nama-pt').value;
    let kode_pt = $('#kode-pt').val();
    let nama_pt = $('#nama-pt').val();
    let skor_1 = $('#skor-1').val();
    let skor_2 = $('#skor-2').val();
    let skor_3 = $('#skor-3').val();
    let skor_4 = $('#skor-4').val();
    let catatan_keseluruhan = $('#catatan-keseluruhan').val();

    // Cegah submit form langsung
    event.preventDefault();

    if (kode_pt == '' || nama_pt == '') {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Silakan pilih perguruan tinggi terlebih dahulu',
        confirmButtonColor: '#dc3545'
      });
    }

    if (skor_1 == '' || skor_2 == '' || skor_3 == '' || skor_4 == '') {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Isi skor terlebih dahulu',
        confirmButtonColor: '#dc3545'
      });
    }

    if (catatan_keseluruhan.length < 10) {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Catatan keseluruhan minimal 10 karakter',
        confirmButtonColor: '#dc3545'
      });
    }

    Swal.fire({
      title: 'Simpan Skor',
      text: "Apakah anda yakin ingin menyimpan skor " + nama_pt + "?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#skor-1, #skor-2, #skor-3, #skor-4').removeAttr('disabled').prop('disabled', false);
        // Gunakan native submit agar event berjalan normal
        document.getElementById('form-input-skor').submit();
      }
    });
  });

  $(document).on('click', '.list-group-item', function() {
    // Hapus kelas aktif dari item lain
    $('.list-group-item').removeClass('active-item');

    // Tambahkan ke item yang diklik
    $(this).addClass('active-item');
  });

  // Cegah klik pada item yang disabled
  $(document).off('click', '.list-group-item').on('click', '.list-group-item', function(e) {
    if ($(this).hasClass('disabled-pt')) {
      e.stopPropagation();
      e.preventDefault();
      return false;
    }
    // Hapus kelas aktif dari item lain
    $('.list-group-item').removeClass('active-item');
    // Tambahkan ke item yang diklik
    $(this).addClass('active-item');
    // Lanjutkan event click yang sudah ada
    var nama_pt = $(this).data('nama-pt');
    var kode_pt = $(this).data('kode-pt');
    var id_penilaian_tipologi = $(this).data('id-penilaian');
    // Kirim ke backend via AJAX
    $.ajax({
      url: '<?= base_url("admin/get-penilaian") ?>',
      method: 'POST',
      data: {
        id_penilaian_tipologi: id_penilaian_tipologi,
        [csrfName]: csrfHash
      },
      dataType: 'json',
      success: function(response) {
        if (response.form_led == null || response.form_led.status == '0') {
          $('.lihat-narasi-led').addClass('d-none');
          $('#total-prodi-aktif').text('-');
          $('#prodi-terakreditasi').text('-');
          $('#prodi-unggul-atau-a').text('-');
          $('#persentase-prodi-unggul-atau-a').text('-');
          return Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Melakukan Penilaian',
            text: "PT belum mengisi/simpan permanen LED.",
            confirmButtonColor: '#dc3545'
          });
        }

        function ambilNilai(data, keys, defaultValue = '') {
          for (let i = 0; i < keys.length; i++) {
            if (data && data[keys[i]] !== undefined && data[keys[i]] !== null && data[keys[i]] !== '') {
              return data[keys[i]];
            }
          }
          return defaultValue;
        }

        const totalProdi = ambilNilai(response.persentase_prodi, ['total_prodi_aktif'], '0');
        const prodiTerakreditasi = ambilNilai(response.persentase_prodi, ['prodi_terakreditasi'], '0');
        const prodiUnggulA = ambilNilai(response.persentase_prodi, ['prodi_unggul_atau_a'], '0');
        let persentaseUnggulA = ambilNilai(response.persentase_prodi, ['persentase_unggul_atau_a'], '0');

        if (persentaseUnggulA !== '' && !String(persentaseUnggulA).includes('%')) {
          const angkaPersentase = parseFloat(String(persentaseUnggulA).replace(',', '.'));
          persentaseUnggulA = isNaN(angkaPersentase) ? persentaseUnggulA + '%' : angkaPersentase.toFixed(2) + '%';
        }

        $('#total-prodi-aktif').text(totalProdi);
        $('#prodi-terakreditasi').text(prodiTerakreditasi);
        $('#prodi-unggul-atau-a').text(prodiUnggulA);
        $('#persentase-prodi-unggul-atau-a').text(persentaseUnggulA);

        $('#nama-pt').val(nama_pt);
        $('#kode-pt').val(kode_pt);
        $('#id-penilaian-tipologi').val(id_penilaian_tipologi);
        $('#skor-1').focus();
        $('#skor-1').val(response.data.skor_1);
        $('#skor-2').val(response.data.skor_2);
        $('#skor-3').val(response.data.skor_3);
        $('#skor-4').val(response.data.skor_4);
        $('#catatan-1').val(response.data.catatan_1);
        $('#catatan-2').val(response.data.catatan_2);
        $('#catatan-3').val(response.data.catatan_3);
        $('#catatan-4').val(response.data.catatan_4);
        $('#catatan-keseluruhan').val(response.data.catatan_keseluruhan);
        $('#catatan-1-validator').val(response.data.catatan_1_validator);
        $('#catatan-2-validator').val(response.data.catatan_2_validator);
        $('#catatan-3-validator').val(response.data.catatan_3_validator);
        $('#catatan-4-validator').val(response.data.catatan_4_validator);
        $('#catatan-keseluruhan-validator').val(response.data.catatan_keseluruhan_validator);
        // $('#link-detail-penilaian').val(response.data.link_detail_penilaian)

        // Enable all skor fields by default
        $('#skor-1').prop('disabled', false);
        $('#catatan-1').prop('disabled', false);
        $('#skor-2').prop('disabled', false);
        $('#catatan-2').prop('disabled', false);
        $('#skor-3').prop('disabled', false);
        $('#catatan-3').prop('disabled', false);
        $('#skor-4').prop('disabled', false);
        $('#catatan-4').prop('disabled', false);
        $('.lihat-narasi-led').removeClass('d-none');

        // Helper untuk set readonly dan style
        function setReadonly(selector, isReadonly) {
          $(selector).prop('readonly', isReadonly)
            .css({
              'box-shadow': isReadonly ? '0 0 0 1px #28a745' : '0 0 0 1px #dc3545',
              'cursor': isReadonly ? 'not-allowed' : 'pointer',
              'background-color': isReadonly ? '#b5e49fff' : '#ffd6d6'
            });
        }

        // Helper untuk set disabled dan style
        function setDisabled(selector, isDisabled) {
          $(selector).prop('disabled', isDisabled)
            .css({
              'box-shadow': isDisabled ? '0 0 0 1px #28a745' : '0 0 0 1px #dc3545',
              'cursor': isDisabled ? 'not-allowed' : 'pointer',
              'background-color': isDisabled ? '#b5e49fff' : '#ffd6d6'
            });
        }

        if (response.data.id_status_penilaian == 3 || (response.data.id_status_penilaian == 1 && (response.data.cek_1 == 1 || response.data.cek_2 == 1 || response.data.cek_3 == 1 || response.data.cek_4 == 1))) {
          setDisabled('#skor-1', response.data.cek_1 == 1);
          setReadonly('#catatan-1', response.data.cek_1 == 1);
          setDisabled('#skor-2', response.data.cek_2 == 1);
          setReadonly('#catatan-2', response.data.cek_2 == 1);
          setDisabled('#skor-3', response.data.cek_3 == 1);
          setReadonly('#catatan-3', response.data.cek_3 == 1);
          setDisabled('#skor-4', response.data.cek_4 == 1);
          setReadonly('#catatan-4', response.data.cek_4 == 1);
        } else {
          // Kembalikan ke style awal (editable, style default)
          $('#skor-1, #catatan-1, #skor-2, #catatan-2, #skor-3, #catatan-3, #skor-4, #catatan-4').prop('readonly', false)
            .css({
              'box-shadow': '',
              'cursor': '',
              'background-color': ''
            });
        }
        $('#skor-4').val(response.skoring_prodi.skor.toFixed(1));
        $('#skor-4').prop('disabled', true).css({
          'cursor': 'not-allowed',
        });
      },
      error: function(xhr) {
        alert('Gagal mengambil data');
      }
    });
  });

  $(document).on('click', '.kirim-nilai', function(event) {
    event.preventDefault(); // Cegah aksi default link
    // console.log($('#kirim-nilai').attr('href'));

    const buka_tutup = '<?= $buka_tutup ?>';
    if (buka_tutup === 'tutup') {
      return Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Penilaian sudah ditutup, tidak bisa mengirim nilai ke validator',
        confirmButtonColor: '#dc3545'
      });
    }

    if ($(this).attr('data-content') === 'semua nilai') {
      var pesan = 'Apakah anda yakin ingin mengirim semua nilai yang statusnya draft (penilaian fasilitator) ke validator?';
    } else {
      var pesan = 'Apakah anda yakin ingin mengirim nilai ' + $(this).attr('data-namapt') + ' ke validator?';
    }

    Swal.fire({
      title: 'Kirim Nilai?',
      text: pesan,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, kirim!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke URL kirim-nilai
        window.location.href = $(this).attr('href');
      }
    });
  });
</script>