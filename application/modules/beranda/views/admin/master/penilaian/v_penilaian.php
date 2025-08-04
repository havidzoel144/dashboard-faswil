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
                        $is_disabled = ($data->id_status_penilaian == '4' || $data->id_status_penilaian == '2');
                        $item_class = $data->id_status_penilaian == '4' ? 'bg-success text-white' : (
                          $data->id_status_penilaian == '3' ? 'bg-danger text-white' : (
                            $data->id_status_penilaian == '2' ? 'bg-warning text-dark' : (
                              $data->id_status_penilaian == '1' ? 'bg-info text-white' : ''
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
                              <?php if ($data->id_status_penilaian == '4'): ?>
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
                            <label for="skor-1a" class="label-required">
                              Skor 1a
                              <span class="text-danger" data-toggle="popover" data-content="<b>Skor 0 :</b> PT tidak menjalankan SPMI; <br> <b>Skor 1 :</b> PT telah menjalankan SPMI namun belum mencakup seluruhnya; <br> <b>Skor 2 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek; <br> <b>Skor 3 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek dan memiliki standar yang melampaui SN Dikti; <br> <b>Skor 4 :</b> PT telah menjalankan SPMI yang dibuktikan dengan keberadaan 5 aspek dan memiliki standar yang melampaui SN Dikti dan menerapkan SPMI berbasis resiko (risk based audit) atau inovasi lainnya" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <input type="text" class="form-control square skor" id="skor-1a" name="skor_1a" maxlength="4" oninput="validateSkorInput(this)" onblur="validateSkorValue(this)" required>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1a" class="label-required">
                                  Catatan Skor 1a
                                  <span class="text-danger" data-toggle="popover" data-content="Ketersediaan dokumen formal SPMI yang dibuktikan dengan keberadaan 5 aspek sebagai berikut:<br> <b>(1) organ/fungsi spmi; <br> (2) dokumen SPMI; <br> (3) auditor internal; <br> (4) hasil audit; <br> (5) bukti tindak lanjut</b>" data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_1a" id="catatan-1a" placeholder="Indikator Penilaian : Ketersediaan dokumen formal SPMI yang dibuktikan dengan keberadaan 5 aspek sebagai berikut: (1) organ/fungsi spmi, (2) dokumen SPMI (3) auditor internal (4) hasil audit (5) bukti tindak lanjut" required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1a-validator">Catatan Skor 1a Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-1a-validator" placeholder="Catatan skor 1a dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-1b" class="label-required">
                              Skor 1b
                              <span class="text-danger" data-toggle="popover" data-content="<b>Tidak ada Skor dibawah 2;</b> <br> <b>Skor 2 :</b> PT tidak memiliki bukti sahis terkait praktik baik pengembangan buday amutu di PT melalui RTM; <br> <b>Skor 3 :</b> PT memiliki bukti sahih terkait praktik baik pengembangan budaya mutu di PT melalui RTM yang mengagendakan pembahasan sebagian dari 7 unsur; <br> <b>Skor 4 :</b> PT memiliki bukti sahih terkait praktik baik pengembangan budaya mutu di PT melalui RTM yang mengagendakan pembahasan dari 7 unsur" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <input type="text" class="form-control square skor" id="skor-1b" name="skor_1b" maxlength="4" oninput="validateSkorInput(this)" onblur="validateMinSkorValue(this)" required>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1b" class="label-required">
                                  Catatan Skor 1b
                                  <span class="text-danger" data-toggle="popover" data-content="Ketersediaan bukti sahih terkait praktik baik pengembangan budaya mutu di perguruan tinggi melalui RTM yang mengagendakan unsur-unsur: <br> <b> (1) hasil audit internal; <br> (2) umpan balik; <br> (3) kinerja proses dan kesesuaian produk; <br> (4) status tindakan pencegahan dan perbaikan; <br> (5) tindak lanjut dari tinjauan sebelumnya; <br> (6) perubahan yang dapat mempengaruhi sistem manajemen mutu; <br> (7) rekomendasi peningkatan</b>" data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_1b" id="catatan-1b" placeholder="Indikator Penilaian : Ketersediaan bukti sahih terkait praktik baik  pengembangan budaya mutu di perguruan tinggi melalui RTM yang mengagendakan unsur-unsur (1) hasil audit internal (2) umpan balik (3) kinerja proses dan kesesuaian produk (4) status tindakan pencegahan dan perbaikan (5) tindak lanjut dari tinjauan sebelumnya (6) perubahan yang dapat mempengaruhi sistem manajemen mutu (7) rekomendasi peningkatan" required></textarea>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-1b-validator">Catatan Skor 1b Validator</label>
                                <textarea class="form-control textarea-catatan" id="catatan-1b-validator" placeholder="Catatan skor 1b dari validator" disabled></textarea>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-3">
                          <fieldset class="form-group mb-1">
                            <label for="skor-2" class="label-required">
                              Skor 2
                              <span class="text-danger" data-toggle="popover" data-content="<b>Skor 0 :</b> PT belum melaksanakan sistem penjaminan mutu; <br> <b>Skor 1 :</b> PT telah melaksanakan sistem penjaminan mutu namun belum efektif serta belum memenuhi seluruh aspek; <br> <b>Skor 2 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek; <br> <b>Skor 3 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek dan dilakukan review terhadap siklus penjamnan mutu; <br> <b>Skor 4 :</b> PT telah melaksanakan sistem penjaminan mutu yang terbukti efektif memenuhi 4 aspek dan dilakukan review terhadap siklus penjamnan mutu dan melibatkan reviewer eksternal" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                            </label>
                            <input type="text" class="form-control square skor" id="skor-2" name="skor_2" maxlength="4" oninput="validateSkorInput(this)" onblur="validateSkorValue(this)" required>
                          </fieldset>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset class="form-group mb-1">
                                <label for="catatan-2" class="label-required">
                                  Catatan Skor 2
                                  <span class="text-danger" data-toggle="popover" data-content="Efektivitas pelaksanaan penjaminan mutu yang memenuhi 4 aspek sbb: <br> <b> 1. keberadaan dokumen formal penetapan standar mutu; <br> 2. standar mutu dilaksanakan secara konsisten; <br> 3. minitoring evaluasi dan pengendalian terhadap standar mutu yang telah ditetapkan <br> 4. hasilnya ditindaklanjuti untuk perbaikan dan peningkatan mutu</b>" data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                                </label>
                                <textarea class="form-control textarea-catatan" name="catatan_2" id="catatan-2" placeholder="Indikator Penilaian : Efektivitas pelaksanaan penjaminan mutu yang memenuhi 4 aspek sbb: 1. keberadaan dokumen formal penetapan standar mutu 2. standar mutu dilaksanakan secara konsisten 3. minitoring evaluasi dan pengendalian terhadap standar mutu yang telah ditetapkan 4. hasilnya ditindaklanjuti untuk perbaikan dan peningkatan mutu" required></textarea>
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

                      <div class="row">
                        <div class="col-lg-12">
                          <fieldset class="form-group mb-1">
                            <label for="skor-2" class="label-required">Link Detail Penilaian</label>
                            <input type="text" class="form-control square" id="link-detail-penilaian" name="link_detail_penilaian" placeholder="Masukkan link detail penilaian" required>
                          </fieldset>
                        </div>
                      </div>

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
                    <a href="<?= base_url('admin/kirim-nilai/' . safe_url_encrypt($periode_dipilih->kode)) ?>" class="btn btn-primary waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Kirim semua nilai yang statusnya draft ke validator" id="kirim-nilai">
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
                        <th class="text-center" rowspan="3">#</th>
                        <th class="text-center" rowspan="3">Periode <span class="text-danger" data-toggle="popover" data-content="Periode 1 : Januari - Juni <br> Periode 2 : Juli - November" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center" rowspan="3">Kode PT</th>
                        <th class="text-center" rowspan="3">Nama PT</th>
                        <th class="text-center" colspan="3">Butir Penilaian</th>
                        <th class="text-center" rowspan="3">
                          Skor <br> Total <br>
                          <span class="text-danger" data-toggle="popover" data-content="Skor Total =((Skor 1a+(2*Skor 1b))/3)x2,22)+(Skor 2 x 2,78)" data-trigger="hover" data-original-title="Formula Perhitungan"><i class="la la-info-circle"></i></span>
                        </th>
                        <th class="text-center" rowspan="3">
                          Tipologi
                          <span class="text-danger" data-toggle="popover" data-content="Tipologi 1 rentang Nilai Terbobot : 17,5 < n ≤ 20; <br> Tipologi 2 rentang Nilai Terbobot : 15 < n ≤ 17,5; <br> Tipologi 3 rentang Nilai Terbobot : 10 ≤ n ≤ 15; <br> Tipologi 4 Nilai Terbobot : < 10;" data-trigger="hover" data-original-title="Ketentuan Tipologi" data-html="true"><i class="la la-info-circle"></i></span>
                        </th>
                        <th class="text-center" rowspan="3">Status</th>
                        <th class="text-center" rowspan="3">Aksi</th>
                      </tr>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center" colspan="2">Butir 1 <br> (Bobot 2,22)</th>
                        <th class="text-center">Butir 2 <br> (Bobot 2,78)</th>
                      </tr>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center text-wrap">Skor 1a <span class="text-danger" data-toggle="popover" data-content="Ketersediaan dokumen formal SPMI yang dibuktikan dengan keberadaan 5 aspek sebagai berikut: <br> (1) organ/fungsi spmi, <br> (2) dokumen SPMI <br> (3) auditor internal <br> (4) hasil audit <br> (5) bukti tndak lanjut" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center text-wrap">Skor 1b <span class="text-danger" data-toggle="popover" data-content="Ketersediaan bukti sahih terkait praktik baik  pengembangan budaya mutu di perguruan tinggi melalui RTM yang mengagendakan unsur-unsur <br> (1) hasil audit internal <br> (2) umpan balik <br> (3) kinerja proses dan kesesuaian produk <br> (4) status tindakan pencegahan dan perbaikan <br> (5) tindak lanjut dari tinjauan sebelumnya <br> (6) perubahan yang dapat mempengaruhi sistem manajemen mutu <br> (7) rekomendasi peningkatan" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                        <th class="text-center text-wrap">Skor 2 <span class="text-danger" data-toggle="popover" data-content="Efektivitas pelaksanaan penjaminan mutu yang memenuhi 4 aspek sbb: <br> 1. keberadaan dokumen formal penetapan standar mutu <br> 2. standar mutu dilaksanakan secara konsisten <br> 3. minitoring evaluasi dan pengendalian terhadap standar mutu yang telah ditetapkan <br> 4. hasilnya ditindaklanjuti untuk perbaikan dan peningkatan mutu" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
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
                          if ($data->id_status_penilaian == '4') {
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
                            <td class="text-center" style="width: 5%;">
                              <?= $data->skor_1a ?>
                              <?php
                              $warna_1a = ($data->cek_1a == '1' && $data->skor_1a !== null) ? 'text-success' : 'text-danger';
                              $iconCek_1a = ($data->cek_1a == '1' && $data->skor_1a !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_1a == '0' && $data->skor_1a !== null) ? '<i class="fa fa-times"></i>' : '');
                              ?>
                              <span class="<?= $warna_1a ?>" data-toggle="popover" data-content="<?= $data->catatan_1a_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 1a" style="cursor: pointer;"><?= $iconCek_1a ?></span>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <?= $data->skor_1b ?>
                              <?php
                              $warna_1b = ($data->cek_1b == '1' && $data->skor_1b !== null) ? 'text-success' : 'text-danger';
                              $iconCek_1b = ($data->cek_1b == '1' && $data->skor_1b !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_1b == '0' && $data->skor_1b !== null) ? '<i class="fa fa-times"></i>' : '');
                              ?>
                              <span class="<?= $warna_1b ?>" data-toggle="popover" data-content="<?= $data->catatan_1b_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 1b" style="cursor: pointer;"><?= $iconCek_1b ?></span>
                            </td>
                            <td class="text-center" style="width: 5%;">
                              <?= $data->skor_2 ?>
                              <?php
                              $warna_2 = ($data->cek_2 == '1' && $data->skor_2 !== null) ? 'text-success' : 'text-danger';
                              $iconCek_2 = ($data->cek_2 == '1' && $data->skor_2 !== null) ? '<i class="fa fa-check"></i>' : (($data->cek_2 == '0' && $data->skor_2 !== null) ? '<i class="fa fa-times"></i>' : '');
                              ?>
                              <span class="<?= $warna_2 ?>" data-toggle="popover" data-content="<?= $data->catatan_2_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 2" style="cursor: pointer;"><?= $iconCek_2 ?></span>
                            </td>
                            <td class="text-center" style="width: 5%;"><?= $data->skor_total ?></td>
                            <td class="text-center" style="width: 5%;"><?= $data->tipologi ?></td>
                            <td class="text-center" style="width: 5%;">
                              <?php
                              $warna_badge = $data->id_status_penilaian == '4' ? 'badge-success' : (
                                $data->id_status_penilaian == '3' ? 'badge-danger' : (
                                  $data->id_status_penilaian == '2' ? 'badge-warning' : (
                                    $data->id_status_penilaian == '1' ? 'badge-info' : 'badge-secondary'
                                  )
                                )
                              );

                              $icon = $data->id_status_penilaian == '4' ? 'fa-check-circle' : (
                                $data->id_status_penilaian == '3' ? 'fa-times-circle' : (
                                  $data->id_status_penilaian == '2' ? 'fa-hourglass-half' : (
                                    $data->id_status_penilaian == '1' ? 'fa-spinner fa-spin' : 'fa-question-circle'
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
                              <a href="<?= base_url('admin/riwayat-penilaian/' . safe_url_encrypt($data->id_penilaian_tipologi)) ?>" target="_blank">
                                <button class="btn btn-dark btn-sm waves-effect waves-light" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Riwayat Penilaian">
                                  <i class="la la-history"></i>
                                </button>
                              </a>
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

  $(document).on('submit', '#form-input-skor', function(event) {
    // let nama_pt = document.getElementById('nama-pt').value;
    let kode_pt = $('#kode-pt').val();
    let nama_pt = $('#nama-pt').val();
    let skor_1a = $('#skor-1a').val();
    let skor_1b = $('#skor-1b').val();
    let skor_2 = $('#skor-2').val();
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

    if (skor_1a == '' || skor_1b == '' || skor_2 == '') {
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
        // Gunakan native submit agar event berjalan normal
        document.getElementById('form-input-skor').submit();
      }
    });
  });

  function validateSkorInput(input) {
    let val = input.value;

    // Hapus semua kecuali angka dan titik
    val = val.replace(/[^0-9.]/g, '');

    // Hanya izinkan satu titik
    const parts = val.split('.');
    if (parts.length > 2) {
      val = parts[0] + '.' + parts[1]; // buang titik kelebihan
    }

    // Optional: Batasi hanya 1 digit setelah titik
    // val = val.replace(/^(\d+)\.(\d).*$/, '$1.$2');

    input.value = val;
  }

  function validateSkorValue(input) {
    const val = parseFloat(input.value.replace(',', '.'));
    if (val > 4) {
      return Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: 'Nilai maksimal adalah 4',
        // confirmButtonColor: '#dc3545'
      }).then(() => {
        // Fokus ke input setelah Swal ditutup
        input.value = '';
      });
    }
  }

  function validateMinSkorValue(input) {
    const val = parseFloat(input.value.replace(',', '.'));
    if (val < 2) {
      return Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: 'Nilai minimal adalah 2',
        // confirmButtonColor: '#dc3545'
      }).then(() => {
        // Fokus ke input setelah Swal ditutup
        input.value = '';
      });
    } else if (val > 4) {
      return Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: 'Nilai maksimal adalah 4',
        // confirmButtonColor: '#dc3545'
      }).then(() => {
        // Fokus ke input setelah Swal ditutup
        input.value = '';
      });
    }
  }

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
    $('#nama-pt').val(nama_pt);
    $('#kode-pt').val(kode_pt);
    $('#id-penilaian-tipologi').val(id_penilaian_tipologi);
    $('#skor-1a').focus();
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
        $('#skor-1a').val(response.data.skor_1a);
        $('#skor-1b').val(response.data.skor_1b);
        $('#skor-2').val(response.data.skor_2);
        $('#catatan-1a').val(response.data.catatan_1a);
        $('#catatan-1b').val(response.data.catatan_1b);
        $('#catatan-2').val(response.data.catatan_2);
        $('#catatan-keseluruhan').val(response.data.catatan_keseluruhan);
        $('#link-detail-penilaian').val(response.data.link_detail_penilaian)
      },
      error: function(xhr) {
        alert('Gagal mengambil data');
      }
    });
  });

  $(document).on('click', '#kirim-nilai', function(event) {
    event.preventDefault(); // Cegah aksi default link
    // console.log($('#kirim-nilai').attr('href'));

    Swal.fire({
      title: 'Kirim Nilai?',
      text: "Apakah anda yakin ingin mengirim semua nilai yang statusnya draft ke validator?",
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