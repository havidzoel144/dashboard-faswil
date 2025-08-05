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

    <div class="row">
      <div class="col-12">
        <?php
        // Ambil tanggal dan waktu sekarang
        $now2 = new DateTime();

        // Ambil data periode dari $bt
        $mulai2 = new DateTime($bt->mulai_tgl . ' ' . $bt->mulai_waktu);
        $akhir2 = new DateTime($bt->akhir_tgl . ' ' . $bt->akhir_waktu);

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
          <strong style="display: inline-block; width: 220px; border-right: 1px solid #ffd54f;">Periode <?= $bt->jenis ?></strong>
          <?= $label2 ?>
          <span style="font-weight: 500;">
            <?= $bt->mulai_tgl . ' ' . $bt->mulai_waktu . ' s/d ' . $bt->akhir_tgl . ' ' . $bt->akhir_waktu ?>
          </span>
        </div>
      </div>
    </div>

    <!-- Basic Horizontal Timeline -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card">

          <?php
          if (substr($periode, 4, 1) == "1") {
            $isi_periode = substr($periode, 0, 4) . ' Periode 1';
          } else {
            $isi_periode = substr($periode, 0, 4) . ' Periode 2';
          }
          ?>

          <div class="card-header text-center" style="background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%); color: #fff; border-radius: 10px 10px 0 0; box-shadow: 0 2px 8px rgba(86,59,255,0.08);">

            <h4 class="card-title" id="heading-buttons1" style="color: white; font-weight: bold; letter-spacing: 1px; margin-bottom: 8px;">
              <i class="fa fa-check-circle" style="color: #ffd700; margin-right: 8px;"></i>
              Validasi Penilaian Tipologi
            </h4>
            <div style="font-size: 1.1em; margin-bottom: 4px;">
              <span style="margin-right: 18px;">
                <i class="fa fa-user" style="color: #fff;"></i>
                <b>Fasilitator:</b> <span style="color: #ffd700;"><?= $fas->nama ?></span>
              </span>
            </div>
            <div style="font-size: 1.1em;">
              <i class="fa fa-calendar" style="color: #fff;"></i>
              <b><?= $isi_periode ?></b>
            </div>
            <a class="heading-elements-toggle" style="color: #fff;"><i class="la la-ellipsis-v font-medium-3"></i></a>
          </div>

          <div style="margin-left: 20px;margin-top: 20px;">
            <a href="<?= base_url('daftar-fasilitator/' . safe_url_encrypt($periode)) ?>">
              <button class="btn btn-info btn-md" type="button">
                <i class="fa fa-arrow-left"></i> Lihat Daftar Fasilitator
              </button>
            </a>
          </div>

          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table id="tabel-penilaian" class="table table-striped table-bordered">
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
                    if (!empty($data_pt_binaan_result)) { // Cek apakah array data_pt_binaan_result tidak kosong
                      foreach ($data_pt_binaan_result as $data) {
                        if (substr($data->periode, -1, 1 == '1')) {
                          $periode = substr($data->periode, 0, 4) . ' Periode 1';
                        } else {
                          $periode = substr($data->periode, 0, 4) . ' Periode 2';
                        }
                    ?>
                        <?php
                        // Tentukan kelas warna baris berdasarkan id_status_penilaian
                        $row_class = '';
                        if ($data->id_status_penilaian == '4') {
                          $row_class = 'table-success'; // hijau
                        } elseif ($data->id_status_penilaian == '3') {
                          $row_class = 'table-danger'; // merah
                        } elseif ($data->id_status_penilaian == '2') {
                          $row_class = 'table-warning'; // kuning
                        } elseif ($data->id_status_penilaian == '1') {
                          $row_class = 'table-info'; // biru
                        }
                        ?>
                        <tr class="<?= $row_class ?>">
                          <td class="text-center" style="width: 3%;"><?= ++$i ?></td>
                          <td class="text-center" style="width: 10%;"><?= $periode ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->kode_pt ?></td>
                          <td class="text-start" style="width: 18%;"><?= $data->nama_pt ?></td>
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
                          <td class="text-center text-white" style="width: 5%;">
                            <span class="badge 
                              <?php
                              if ($data->id_status_penilaian == '4') echo 'badge-success';
                              elseif ($data->id_status_penilaian == '3') echo 'badge-danger';
                              elseif ($data->id_status_penilaian == '2') echo 'badge-warning';
                              elseif ($data->id_status_penilaian == '1') echo 'badge-info';
                              else echo 'badge-secondary';
                              ?>"
                              style="font-size: 1em; padding: 8px 14px; border-radius: 20px; letter-spacing: 0.5px; width: 100%;">
                              <i class="fa 
                                <?php
                                if ($data->id_status_penilaian == '4') echo 'fa-check-circle';
                                elseif ($data->id_status_penilaian == '3') echo 'fa-times-circle';
                                elseif ($data->id_status_penilaian == '2') echo 'fa-hourglass-half';
                                elseif ($data->id_status_penilaian == '1') echo 'fa-spinner fa-spin';
                                else echo 'fa-question-circle';
                                ?>"
                                aria-hidden="true" style="margin-right: 6px;"></i>
                              <?= $data->nm_status ?>
                            </span>
                          </td>
                          <td class="text-center" style="width: 10%;">
                            <?php if ($data->id_status_penilaian != '1') : ?>
                              <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#validasiModal<?= $data->id_penilaian_tipologi ?>" title="Validasi">
                                <i class="la la-pencil"></i>
                              </button>
                            <?php endif; ?>

                            <!-- awal modal penilaian validator -->
                            <div class="modal fade text-left" id="validasiModal<?= $data->id_penilaian_tipologi ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" style="display: none;">

                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                  <div class="modal-header" style="display: flex; align-items: flex-start; justify-content: space-between;">

                                    <div style="font-size: 1.1em; text-align: left; width: 100%;">
                                      <div style="margin-bottom: 8px;">
                                        <span style="margin-right: 25px;">
                                          <i class="fa fa-calendar" style="color: #007bff;"></i>
                                          <b>Periode:</b> <span style="color: #343a40;"><?= $isi_periode ?></span>
                                        </span>
                                        <span style="margin-right: 25px;">
                                          <i class="fa fa-user" style="color: #007bff;"></i>
                                          <b>Fasilitator:</b> <span style="color: #343a40;"><?= $fas->nama ?></span>
                                        </span>
                                      </div>
                                      <div>
                                        <span style="margin-right: 25px;">
                                          <i class="fa fa-university" style="color: #17a2b8;"></i>
                                          <b>PT:</b> <span style="color: #343a40;"><?= $data->nama_pt ?> (<?= $data->kode_pt ?>)</span>
                                        </span>
                                        <span>
                                          <i class="fa fa-info-circle" style="color: #ffc107;"></i>
                                          <b>Status:</b>
                                          <?php
                                          $statusColor = '#6c757d';
                                          if ($data->nm_status == 'Valid') $statusColor = '#28a745';
                                          elseif ($data->nm_status == 'Revisi Validator') $statusColor = '#dc3545';
                                          elseif ($data->nm_status == 'Menunggu Validasi') $statusColor = '#ffc107';
                                          ?>
                                          <span style="color: <?= $statusColor ?>; font-weight: bold;"><?= $data->nm_status ?></span>
                                        </span>
                                      </div>
                                    </div>

                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>X

                                  </div>

                                  <?php echo form_open(site_url('simpan_validasi'), array('class' => 'form-horizontal', 'role' => 'form')); ?>

                                  <input type="hidden" name="id_penilaian_tipologi" value="<?= $data->id_penilaian_tipologi ?>">
                                  <input type="hidden" name="fasilitator_id" value="<?= $data->fasilitator_id ?>">
                                  <input type="hidden" name="periode" value="<?= $data->periode ?>">
                                  <input type="hidden" name="skor_1_bobot" value="<?= $data->skor_1_bobot ?>">
                                  <input type="hidden" name="skor_2_bobot" value="<?= $data->skor_2_bobot ?>">
                                  <input type="hidden" name="skor_total" value="<?= $data->skor_total ?>">

                                  <div class="modal-body">

                                    <div class="alert" style="background-color: #fff; font-weight: bold; font-style: italic; font-size: 1.1em; border-left: 6px solid #dc3545;">
                                      <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #dc3545;"></i>
                                      <span style="color: #dc3545;">
                                        Keterangan: Jika <u>salah satu</u> dari skor <b>1a</b>, <b>1b</b>, atau <b>2</b> dianggap <u>tidak valid</u>, maka <b>status menjadi "Revisi Validator"</b> dan akan <u>dikembalikan ke fasilitator</u> untuk diperbaiki.
                                      </span>
                                    </div>

                                    <hr style="border-top: 3px solid #343a40;">

                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Skor 1a</label>
                                        <input type="text" class="form-control square skor" name="skor_1a" value="<?= $data->skor_1a ?>" readonly>
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Catatan Fasilitator Skor 1a</label>
                                        <textarea class="form-control textarea-catatan" name="catatan_1a" rows="3" readonly><?= $data->catatan_1a ?></textarea>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_1a" value="1" <?= ($data->cek_1a == "1") ? 'checked' : '' ?>>&nbsp;Valid
                                        <br>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_1a" value="0" <?= ($data->cek_1a == "0") ? 'checked' : '' ?>>&nbsp;Tidak Valid
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan validator Skor 1a</label>
                                        <textarea class="form-control textarea-catatan" required placeholder="ketik disini..." rows="3" name="catatan_1a_validator"><?= $data->catatan_1a_validator ?></textarea>
                                      </div>
                                    </div>

                                    <hr style="border-top: 3px solid #343a40;">

                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Skor 1b</label>
                                        <input type="text" class="form-control square skor" name="skor_1b" value="<?= $data->skor_1b ?>" readonly>
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Catatan Fasilitator Skor 1b</label>
                                        <textarea class="form-control textarea-catatan" name="catatan_1b" rows="3" readonly><?= $data->catatan_1b ?></textarea>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_1b" value="1" <?= ($data->cek_1b == "1") ? 'checked' : '' ?>>&nbsp;Valid
                                        <br>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_1b" value="0" <?= ($data->cek_1b == "0") ? 'checked' : '' ?>>&nbsp;Tidak Valid
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan validator Skor 1b</label>
                                        <textarea class="form-control textarea-catatan" required placeholder="ketik disini..." rows="3" name="catatan_1b_validator"><?= $data->catatan_1b_validator ?></textarea>
                                      </div>
                                    </div>

                                    <hr style="border-top: 3px solid #343a40;">

                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Skor 2</label>
                                        <input type="text" class="form-control square skor" name="skor_2" value="<?= $data->skor_2 ?>" readonly>
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left" style="display: block; text-align: left;">Catatan Fasilitator Skor 2</label>
                                        <textarea class="form-control textarea-catatan" name="catatan_2" rows="3" readonly><?= $data->catatan_2 ?></textarea>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-2">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_2" value="1" <?= ($data->cek_2 == "1") ? 'checked' : '' ?>>&nbsp;Valid
                                        <br>
                                        <input required type="radio" style="transform: scale(1.3);" name="cek_2" value="0" <?= ($data->cek_2 == "0") ? 'checked' : '' ?>>&nbsp;Tidak Valid
                                      </div>
                                      <div class="col-sm-10">
                                        <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan validator Skor 2</label>
                                        <textarea class="form-control textarea-catatan" required placeholder="ketik disini..." rows="3" name="catatan_2_validator"><?= $data->catatan_2_validator ?></textarea>
                                      </div>
                                    </div>

                                    <hr style="border-top: 3px solid #343a40;">

                                    <!-- <div class="form-group row">
                                      <div class="col-lg-12">
                                        <label for="current-password">Link Detail Penilaian</label>
                                        <input type="text" class="form-control square" value="<?= $data->link_detail_penilaian ?>" required readonly>
                                      </div>
                                    </div>

                                    <hr style="border-top: 3px solid #343a40;"> -->

                                    <fieldset class="form-group">
                                      <label for="current-password">Catatan Keseluruhan Fasilitator</label>
                                      <textarea class="form-control textarea-catatan" rows="3" name="catatan_keseluruhan" readonly><?= $data->catatan_keseluruhan ?></textarea>
                                    </fieldset>
                                    <fieldset class="form-group">
                                      <label class="label-required" for="current-password">Catatan Keseluruhan Validator</label>
                                      <textarea class="form-control textarea-catatan" required placeholder="ketik disini..." rows="3" name="catatan_keseluruhan_validator"><?= $data->catatan_keseluruhan_validator ?></textarea>

                                  </div>
                                  <div class="modal-footer">

                                    <?php
                                    if ($buka_tutup == "tutup") {
                                    ?>
                                      <button type="button" onclick="alert('<?= $dabk->pesan ?>')" class="btn btn-danger"><i class="la la-ban"></i> Validasi Ditutup</button>
                                    <?php } else { ?>
                                      <button type="submit" class="btn btn-primary">Simpan Validasi</button>
                                    <?php } ?>

                                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
                                  </div>
                                  <?php echo form_close(); ?>
                                </div>
                              </div>
                            </div>
                            <!-- akhir modal penilaian validator -->

                            <a href="<?= base_url() ?>rwy-validator/<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" class="btn btn-dark btn-sm waves-effect waves-light" type="button" target="_blank" title="Riwayat Penilaian"><i class="la la-history"></i> </a>

                          </td>
                        </tr>
                      <?php
                      }
                    } else { // Jika data_pt_binaan_result kosong
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

  // Event click
  $(document).on('click', '.list-group-item', function() {
    var nama_pt = $(this).data('nama-pt');
    var kode_pt = $(this).data('kode-pt');
    $('#nama-pt').val(nama_pt);
    $('#kode-pt').val(kode_pt);

    $('#skor-1a').focus();
  });

  $(document).on('submit', '#form-input-skor', function(event) {
    // let nama_pt = document.getElementById('nama-pt').value;
    let kode_pt = $('#kode-pt').val();
    let nama_pt = $('#nama-pt').val();
    let skor_1a = $('#skor-1a').val();
    let skor_1b = $('#skor-1b').val();
    let skor_2 = $('#skor-2').val();

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
        icon: 'error',
        title: 'Gagal!',
        text: 'Nilai maksimal adalah 4',
        confirmButtonColor: '#dc3545'
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
        icon: 'error',
        title: 'Gagal!',
        text: 'Nilai minimal adalah 2',
        confirmButtonColor: '#dc3545'
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
</script>