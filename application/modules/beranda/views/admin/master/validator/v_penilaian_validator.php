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
            <div style="font-size: 1.1em;">
              <i class="fa fa-calendar" style="color: #fff;"></i>
              <b><?= $fas->keterangan ?></b>
            </div>
            <a class="heading-elements-toggle" style="color: #fff;"><i class="la la-ellipsis-v font-medium-3"></i></a>
          </div>

          <div style="margin-left: 20px;margin-top: 20px;">
            <a href="<?= base_url('admin/validator') ?>">
              <button class="btn btn-info btn-md" type="button">
                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Periode
              </button>
            </a>
            <?php
            if ($buka_tutup == "tutup") {
            ?>
              <a href="#" class="btn btn-danger waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Sudah ditutup">
                Penilaian sudah ditutup
              </a>
            <?php } else { ?>
              <a href="<?= base_url('admin/validator/kirim-nilai/' . safe_url_encrypt($periode) . '/' . safe_url_encrypt('semua')) ?>" class="btn btn-success waves-effect waves-light kirim-nilai" data-toggle="tooltip" data-placement="top" title="Proses semua nilai yang sudah divalidasi" data-content="semua nilai">
                Proses Nilai
              </a>
            <?php } ?>
          </div>

          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table id="tabel-penilaian" class="table table-striped table-bordered">
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
                    if (!empty($data_pt_binaan_result)) { // Cek apakah array data_pt_binaan_result tidak kosong
                      foreach ($data_pt_binaan_result as $data) {
                        if (substr($data->periode, -1, 1 == '1')) {
                          $periode_label = substr($data->periode, 0, 4) . ' Periode 1';
                        } else {
                          $periode_label = substr($data->periode, 0, 4) . ' Periode 2';
                        }
                    ?>
                        <?php
                        // Tentukan kelas warna baris berdasarkan id_status_penilaian
                        $row_class = '';
                        if ($data->id_status_penilaian == '6') {
                          $row_class = 'table-secondary'; // abu-abu
                        } elseif ($data->id_status_penilaian == '5') {
                          $row_class = 'table-primary'; // ungu
                        } elseif ($data->id_status_penilaian == '4') {
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
                          <td class="text-center" style="width: 10%;"><?= $periode_label ?></td>
                          <td class="text-center" style="width: 5%;"><?= $data->kode_pt ?></td>
                          <td class="text-start" style="width: 18%;"><?= $data->nama_pt ?></td>
                          <?php if (in_array($data->id_status_penilaian, ['1', null])) : ?>
                            <td class="text-center" colspan="6" style="width: 5%;">
                              <?php if ($data->id_status_penilaian == '1') : ?>
                                <i class="fa fa-spinner fa-spin" style="color: #007bff;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nilai sudah diinput oleh validator, tetapi belum dipublish"></i>
                              <?php elseif ($data->id_status_penilaian == null) : ?>
                                <i class="fa fa-question" style="color: #4c4e51;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Fasilitator belum input nilai"></i>
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
                              <span class="<?= $warna_3 ?>" data-toggle="popover" data-content="<?= $data->catatan_3_validator ?>" data-trigger="hover" data-original-title="Catatan Validator 3" style="cursor: pointer;"><?= $iconCek_3 ?>
                              </span>
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
                          <td class="text-center text-white" style="width: 5%;">
                            <span class="badge 
                              <?php
                              if ($data->id_status_penilaian == '6') echo 'bg-blue-grey bg-darken-4';
                              elseif ($data->id_status_penilaian == '5') echo 'badge-primary';
                              elseif ($data->id_status_penilaian == '4') echo 'badge-success';
                              elseif ($data->id_status_penilaian == '3') echo 'badge-danger';
                              elseif ($data->id_status_penilaian == '2') echo 'badge-warning';
                              elseif ($data->id_status_penilaian == '1') echo 'badge-info';
                              else echo 'badge-secondary';
                              ?>"
                              style="font-size: 1em; padding: 8px 14px; border-radius: 20px; letter-spacing: 0.5px; width: 100%;">
                              <i class="fa 
                                <?php
                                if ($data->id_status_penilaian == '6') echo 'fa-rotate-left';
                                elseif ($data->id_status_penilaian == '5') echo 'fa-paper-plane';
                                elseif ($data->id_status_penilaian == '4') echo 'fa-check-circle';
                                elseif ($data->id_status_penilaian == '3') echo 'fa-times-circle';
                                elseif ($data->id_status_penilaian == '2') echo 'fa-hourglass-half';
                                elseif ($data->id_status_penilaian == '1') echo 'fa-spinner fa-spin';
                                else echo 'fa-question-circle';
                                ?>"
                                aria-hidden="true" style="margin-right: 6px;"></i>
                              <?= $data->nm_status ?? 'Fasilitator Belum Input' ?>
                            </span>
                          </td>
                          <td class="text-center" style="width: 10%;">
                            <div class="btn-group" role="group">
                              <?php if (in_array($data->id_status_penilaian, ['2', '3', '4', '5'])) : ?>
                                <button class="btn btn-primary btn-sm waves-effect waves-light btn-validasi" data-id="<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Validasi">
                                  <i class="la la-pencil"></i>
                                </button>
                              <?php endif; ?>
                              <?php if ($data->id_status_penilaian == '5') : ?>
                                <a href="<?= base_url() ?>admin/validator/kirim-nilai/<?= safe_url_encrypt($periode) . '/' . safe_url_encrypt($data->id_penilaian_tipologi) ?>" class="btn btn-success btn-sm waves-effect waves-light kirim-nilai" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Proses Nilai yang sudah divalidasi" data-namapt="<?= $data->nama_pt ?>">
                                  <i class="la la-paper-plane"></i>
                                </a>
                              <?php endif; ?>
                              <?php if ($data->id_status_penilaian == '4') : ?>
                                <a href="<?= base_url() ?>admin/validator/ubah-status-penilaian/<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" class="btn btn-warning btn-sm waves-effect waves-light ubah-status-penilaian" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Ubah status penilaian yang sudah valid" data-namapt="<?= $data->nama_pt ?>">
                                  <i class="la la-edit"></i>
                                </a>
                              <?php endif; ?>
                              <a href="<?= base_url() ?>rwy-validator/<?= safe_url_encrypt($data->id_penilaian_tipologi) ?>" class="btn btn-dark btn-sm waves-effect waves-light" type="button" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="Riwayat Penilaian">
                                <i class="la la-history"></i>
                              </a>
                            </div>
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
<!-- END: Content-->

<!-- awal modal penilaian validator -->
<div class="modal fade text-left" id="validasiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
      <div class="modal-header border-bottom">
        <div style="font-size: 1.1em; text-align: left; width: 100%;">
          <div style="margin-bottom: 8px;">
            <span style="margin-right: 25px;">
              <i class="fa fa-calendar" style="color: #007bff;"></i>
              <b>Periode:</b> <span style="color: #343a40;" id="labelPeriode"></span>
            </span>
          </div>
          <div>
            <span style="margin-right: 25px;">
              <i class="fa fa-university" style="color: #17a2b8;"></i>
              <b>PT:</b> <span style="color: #343a40;" id="labelPT"></span>
            </span>
            <span>
              <i class="fa fa-info-circle" style="color: #ffc107;"></i>
              <b>Status:</b>
              <span id="labelStatus"></span>
            </span>
          </div>
        </div>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php echo form_open(site_url('simpan_validasi'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'validasiForm')); ?>
      <input type="hidden" name="id_penilaian_tipologi">
      <input type="hidden" name="periode">
      <div class="modal-body" style="background-color: #fdfdfd; max-height: 70vh; overflow-y: auto;">
        <div class="alert" style="background-color: #fff; font-weight: bold; font-style: italic; font-size: 1.1em; border-left: 6px solid #dc3545;">
          <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #dc3545;"></i>
          <span style="color: #dc3545;">
            Keterangan: Jika <u>salah satu</u> dari skor <b>1</b>, <b>2</b>, <b>3</b>, atau <b>4</b> dianggap <u>tidak valid</u>, maka <b>status menjadi <u>"Revisi Validator"</u></b>.
          </span>
        </div>

        <hr style="border-top: 3px solid #343a40;">

        <div class="cardshadow-sm border-0" style="border-radius: 10px; overflow: hidden;">
          <div class="card-body bg-light">
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Skor 1
                  <span class="text-danger" data-toggle="popover" data-content="0 = Tidak Memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Perguruan tinggi terbukti telah mengimplementasikan Sistem Penjaminan Mutu Internal yang  mencakup keempat aspek secara konsisten dan efektif dalam peningkatan mutu pendidikan secara berkelanjutan. <br> 1.5 = Perguruan tinggi terbukti telah mengimplementasikan Sistem Penjaminan Mutu Internal yang mencakup keempat aspek secara konsisten dan efektif dalam peningkatan mutu pendidikan secara berkelanjutan, serta telah menunjukkan adanya upaya pengembangan, namun belum sepenuhnya terbukti efektif <br> 2 = Syarat perlu status terakreditasi Unggul : Perguruan tinggi terbukti telah mengembangkan dan mengimplementasikan Sistem Penjaminan Mutu Internal yang  mencakup keempat aspek dan telah terbukti efektif dalam peningkatan mutu pendidikan secara berkelanjutan." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <input type="text" class="form-control square skor border rounded bg-white font-weight-bold text-center" style="height: 83px;" id="skor-1" readonly>
              </div>
              <div class="col-sm-10">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Catatan Fasilitator Skor 1
                  <span class="text-danger" data-toggle="popover" data-content="Sistem Penjaminan Mutu Internal yang dikembangkan Perguruan Tinggi, mencakup: <br> 1. Standar Pendidikan Tinggi (akademik dan non akademik) yang melampauai SN Dikti dan sesuai fokus misi PT, telah ditetapkan oleh perguruan tinggi serta telah disosialisasikan ke seluruh pemangku kepentingan. <br> 2. Sistem Tatakelola Perguruan Tinggi dalam mengimplementasikan SPMI, mencakup minimal: SOP implementasi SPMI, keberfungsian SPMI di berbagai tingkat (pelaksana dan sistem implementasi) yang akuntabel, transparan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 3. Sistem Evaluasi Pemenuhan Standar Pendidikan Tinggi yang transparan, akuntabel, mapan dan telah diimplementasikan secara konsisten paling sedikit selama 3 tahun. <br> 4. Sistem Peningkatan Mutu Berkelanjutan yang telah diimplementasikan secara efektif dan efisien paling sedikit selama 3 tahun." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <textarea class="form-control textarea-catatan" id="catatan-1" rows="3" readonly></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                <input required type="radio" style="transform: scale(1.3);" name="cek_1" value="1">&nbsp;Valid
                <br>
                <input required type="radio" style="transform: scale(1.3);" name="cek_1" value="0">&nbsp;Tidak Valid
              </div>
              <div class="col-sm-10">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan Validator Skor 1</label>
                <textarea class="form-control textarea-catatan" style="border-radius: 8px !important; border: 1px solid #007bff !important;" required placeholder="ketik disini..." rows="3" name="catatan_1_validator"></textarea>
              </div>
            </div>

            <hr style="border-top: 3px solid #343a40;">

            <div class=" form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Skor 2
                  <span class="text-danger" data-toggle="popover" data-content="0 = Tidak Memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Perguruan Tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tatakelola perguruan tinggi dalam bidang akademik dan non-akademik. <br> 1.5 = Perguruan tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian, dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tata kelola perguruan tinggi dalam bidang akademik dan non-akademik, serta sudah menunjukkan adanya upaya peningkatan mutu pendidikan tinggi yang memenuhi aspek berkelanjutan, efektif, dan konsisten. <br> 2 = Syarat perlu status terakreditasi Unggul : Perguruan Tinggi terbukti telah melaksanakan siklus penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan standar pendidikan tinggi yang menunjukkan keberfungsian tatakelola perguruan tinggi dalam bidang akademik dan non-akademik  untuk meningkatkan mutu pendidikan tinggi secara berkelanjutan, efektif dan konsisten. " data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <input type="text" class="form-control square skor border rounded bg-white font-weight-bold text-center" style="height: 83px;" id="skor-2" readonly>
              </div>
              <div class=" col-sm-10">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Catatan Fasilitator Skor 2
                  <span class="text-danger" data-toggle="popover" data-content="Implementasi siklus  penetapan, pelaksanaan, evaluasi, pengendalian dan peningkatan (PPEPP) dalam bidang akademik dan non-akademik, paling sedikit selama 3 tahun secara konsisten, berkelanjutan dan terbukti efektif, dan terdiri atas: <br> 1. Penetapan Standar Pendidikan Tinggi  yang sesuai misi perguruan tinggi, yaitu perancangan, perumusan, dan pengesahan standar PT. <br> 2. Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan standar oleh semua pihak yang bertanggungjawab agar isi standar tercapai. <br> 3. Evaluasi Pemenuhan Standar Pendidikan Tinggi, yaitu evaluasi kesesuaian pelaksanaan standar dengan standar yang telah ditetapkan dan cara pemenuhannya. <br> 4. Pengendalian Pelaksanaan Standar Pendidikan Tinggi, yaitu pelaksanaan koreksi bila terjadi penyimpangan terhadap isi dan/atau pelaksanaan standar, mempertahan pelaksanaan yang telah memenuhi standar dan sedapat mungkin meningkatkan kualitas pelaksanaannya. <br> 5. Peningkatan Standar Pendidikan Tinggi, yaitu evaluasi isi standar dan peningkatan  mutu isi standar secara berkala dan berkelanjutan." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <textarea class="form-control textarea-catatan" id="catatan-2" rows="3" readonly></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                <input required type="radio" style="transform: scale(1.3);" name="cek_2" value="1">&nbsp;Valid
                <br>
                <input required type="radio" style="transform: scale(1.3);" name="cek_2" value="0">&nbsp;Tidak Valid
              </div>
              <div class="col-sm-10">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan Validator Skor 2</label>
                <textarea class="form-control textarea-catatan" style="border-radius: 8px !important; border: 1px solid #007bff !important;" required placeholder="ketik disini..." rows="3" name="catatan_2_validator"></textarea>
              </div>
            </div>

            <hr style="border-top: 3px solid #343a40;">

            <div class=" form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Skor 3
                  <span class="text-danger" data-toggle="popover" data-content="0 = Tidak memenuhi <br> 1 = Perguruan tinggi terbukti memililki laporan implementasi SPMI secara berkala dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi. <br> 1.5 = Perguruan tinggi terbukti memiliki laporan implementasi SPMI secara berkala dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi, namun belum sepenuhnya sistematis. <br> 2 = Perguruan tinggi terbukti memililki laporan implementasi SPMI secara berkala, sistematis, dan lengkap yang mencakup kedua aspek, yang menunjukkan kinerja perguruan tinggi dan keberfungsian sistem pengelolaan data dan informasi." data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <input type="text" class="form-control square skor border rounded bg-white font-weight-bold text-center" style="height: 83px;" id="skor-3" readonly>
              </div>
              <div class=" col-sm-10">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Catatan Fasilitator Skor 3
                  <span class="text-danger" data-toggle="popover" data-content="Laporan implementasi SPMI dan kinerja perguruan tinggi secara berkala, sistematis,  dan pengelolaan data serta informasi terkait implementasi SPMI melalui PD Dikti, mencakup: <br> 1. Laporan semesteran/tahunan tentang implementasi SPMI dan kinerja perguruan tinggi yang menerus bertambah baik dalam bentuk digital/sistem/hardcopy paling sedikit selama 3 tahun terakhir secara sistematis. <br> 2. Keberfungsian sistem pengelolaan data dan informasi  terkait implementasi SPMI melalui PD Dikti yang transparan, akuntabel, valid dan berintegritas." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <textarea class="form-control textarea-catatan" id="catatan-3" rows="3" readonly></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                <input required type="radio" style="transform: scale(1.3);" name="cek_3" value="1">&nbsp;Valid
                <br>
                <input required type="radio" style="transform: scale(1.3);" name="cek_3" value="0">&nbsp;Tidak Valid
              </div>
              <div class="col-sm-10">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan Validator Skor 3</label>
                <textarea class="form-control textarea-catatan" style="border-radius: 8px !important; border: 1px solid #007bff !important;" required placeholder="ketik disini..." rows="3" name="catatan_3_validator"></textarea>
              </div>
            </div>

            <hr style="border-top: 3px solid #343a40;">

            <div class=" form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Skor 4
                  <span class="text-danger popover-skor4-trigger" data-toggle="popover" data-content="0 = Tidak memenuhi <br> 1 = Syarat Perlu untuk Perolehan Status Terakreditasi : Persentase PS terakreditasi 100%. <br> 1.5 = Syarat perlu status terakreditasi Unggul  (Semua Prodi Harus Terakreditasi) : <ol><li>PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A =>15% sd <20%</li><li>PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A =>10% sd <15%</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal =>40% sd <50% (PTNBH)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A =>20% sd <25%. (PTN Akademik)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal =>30% sd <40%.(PTN Vokasi)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A =>10% sd <15%.(PTS Vokasi)</li></ol> 2 = Syarat perlu status terakreditasi Unggul (Semua Prodi Harus Terakreditasi) : <ol><li>PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%.</li><li>PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%.</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 50%.(PTN BH)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 25%. (PTN Akademik)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 40%.(PTN Vokasi)</li><li>Persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%.(PTS Vokasi)</li></ol>" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <input type="text" class="form-control square skor border rounded bg-white font-weight-bold text-center" style="height: 83px;" id="skor-4" readonly>
              </div>
              <div class=" col-sm-10">
                <label class="col-form-label text-left" style="display: block; text-align: left;">
                  Catatan Fasilitator Skor 4
                  <span class="text-danger" data-toggle="popover" data-content="Pengakuan eksternal atas capaian target-target mutu pendidikan berupa akreditasi Program Studi, yaitu: <br> 1. PT dengan jumlah Prodi >= 40, atau <= 10, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 20%. <br> 2. PT dengan jumlah Prodi antara 10 s.d. 40, persentase PS Terakreditasi Unggul, dan/atau peringkat A minimal 15%." data-trigger="hover" data-original-title="Indikator Penilaian :" data-html="true"><i class="la la-info-circle"></i></span>
                </label>
                <textarea class="form-control textarea-catatan" id="catatan-4" rows="3" readonly></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;font-weight: 800;">Validasi</label>
                <input required type="radio" style="transform: scale(1.3);" name="cek_4" value="1">&nbsp;Valid
                <br>
                <input required type="radio" style="transform: scale(1.3);" name="cek_4" value="0">&nbsp;Tidak Valid
              </div>
              <div class="col-sm-10">
                <label class="col-form-label text-left label-required" style="display: block; text-align: left;">Catatan Validator Skor 4</label>
                <textarea class="form-control textarea-catatan" style="border-radius: 8px !important; border: 1px solid #007bff !important;" required placeholder="ketik disini..." rows="3" name="catatan_4_validator"></textarea>
              </div>
            </div>

            <hr style="border-top: 3px solid #343a40;">

            <fieldset class="form-group">
              <label for="current-password">Catatan Keseluruhan Fasilitator</label>
              <textarea class="form-control textarea-catatan" rows="3" id="catatan-keseluruhan" readonly></textarea>
            </fieldset>
            <fieldset class="form-group">
              <label class="label-required" for="current-password">Catatan Keseluruhan Validator</label>
              <textarea class="form-control textarea-catatan" style="border-radius: 8px !important; border: 1px solid #007bff !important;" required placeholder="ketik disini..." rows="3" name="catatan_keseluruhan_validator"></textarea>
            </fieldset>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-validasi-ditutup" class="btn btn-danger d-none"><i class="la la-ban"></i> Validasi Ditutup</button>
        <button type="submit" id="btn-simpan-validasi-draft" class="btn btn-primary d-none">Simpan Validasi sebagai Draft</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- akhir modal penilaian validator -->

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
  const BUKA_TUTUP_VALIDASI = <?= json_encode($buka_tutup) ?>;
  const PESAN_VALIDASI_DITUTUP = <?= json_encode($dabk->pesan ?? 'Validasi ditutup.') ?>;

  function renderFooterValidasi(idStatusPenilaian) {
    const $btnTutup = $('#btn-validasi-ditutup');
    const $btnDraft = $('#btn-simpan-validasi-draft');

    $btnTutup.addClass('d-none');
    $btnDraft.addClass('d-none');

    if (BUKA_TUTUP_VALIDASI === 'tutup') {
      $btnTutup.removeClass('d-none');
      return;
    }

    if (['2', '5'].includes(String(idStatusPenilaian))) {
      $btnDraft.removeClass('d-none');
    }
  }

  $('.popover-skor4-trigger').popover('dispose');
  $('.popover-skor4-trigger').popover({
    html: true,
    trigger: 'hover',
    container: '#validasiModal',
    placement: 'auto',
    template: `
        <div class="popover popover-skor4" role="tooltip">
            <div class="arrow"></div>
            <h3 class="popover-header"></h3>
            <div class="popover-body"></div>
        </div>
    `
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

    $(document).on('click', '#btn-validasi-ditutup', function() {
      alert(PESAN_VALIDASI_DITUTUP);
    });
  });

  $(document).on('click', '.btn-validasi', function() {
    let enc_id_penilaian_tipologi = $(this).data('id');

    $.ajax({
      url: '<?= base_url() ?>admin/validator/get-data-penilaian/' + enc_id_penilaian_tipologi,
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Isi data ke dalam modal
        $('#validasiModal #labelPeriode').text(response.data.keterangan);
        $('#validasiModal #labelPT').text(response.data.nama_pt + ' (' + response.data.kode_pt + ')');

        var statusColor = '#6c757d';
        if (response.data.nm_status == 'Valid') statusColor = '#28a745';
        else if (response.data.nm_status == 'Revisi Validator') statusColor = '#dc3545';
        else if (response.data.nm_status == 'Penilaian Validator') statusColor = '#ffc107';

        $('#validasiModal #labelStatus').text(response.data.nm_status).css({
          'color': statusColor,
          'font-weight': 'bold'
        });

        $('#validasiModal input[name="id_penilaian_tipologi"]').val(response.data.id_penilaian_tipologi);
        $('#validasiModal input[name="periode"]').val(response.data.periode);

        function setCekValue(fieldName, value) {
          const $radio = $('#validasiModal input[name="' + fieldName + '"]');
          $radio.prop('checked', false);

          if (value === 0 || value === 1 || value === '0' || value === '1') {
            $('#validasiModal input[name="' + fieldName + '"][value="' + value + '"]').prop('checked', true);
          }
        }

        $('#validasiModal #skor-1').val(response.data.skor_1);
        $('#validasiModal #catatan-1').val(response.data.catatan_1);
        setCekValue('cek_1', response.data.cek_1);
        $('#validasiModal textarea[name="catatan_1_validator"]').val(response.data.catatan_1_validator);

        $('#validasiModal #skor-2').val(response.data.skor_2);
        $('#validasiModal #catatan-2').val(response.data.catatan_2);
        setCekValue('cek_2', response.data.cek_2);
        $('#validasiModal textarea[name="catatan_2_validator"]').val(response.data.catatan_2_validator);

        $('#validasiModal #skor-3').val(response.data.skor_3);
        $('#validasiModal #catatan-3').val(response.data.catatan_3);
        setCekValue('cek_3', response.data.cek_3);
        $('#validasiModal textarea[name="catatan_3_validator"]').val(response.data.catatan_3_validator);

        $('#validasiModal #skor-4').val(response.data.skor_4);
        $('#validasiModal #catatan-4').val(response.data.catatan_4);
        setCekValue('cek_4', response.data.cek_4);
        $('#validasiModal textarea[name="catatan_4_validator"]').val(response.data.catatan_4_validator);

        $('#validasiModal #catatan-keseluruhan').val(response.data.catatan_keseluruhan);
        $('#validasiModal textarea[name="catatan_keseluruhan_validator"]').val(response.data.catatan_keseluruhan_validator);

        renderFooterValidasi(response.data.id_status_penilaian);
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: 'Gagal mengambil data penilaian. Silakan coba lagi.',
          confirmButtonColor: '#dc3545'
        });
      }
    });

    $('#validasiModal').modal('show');
  });


  $(document).on('submit', '#validasiForm', function(event) {
    let nama_pt = $('#labelPT').text();
    // Cegah submit form langsung
    event.preventDefault();
    Swal.fire({
      title: 'Simpan Validasi Skor',
      text: "Apakah anda yakin ingin menyimpan validasi skor " + nama_pt + "?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Gunakan native submit agar event berjalan normal
        document.getElementById('validasiForm').submit();
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
        text: 'Proses nilai sudah ditutup.',
        confirmButtonColor: '#dc3545'
      });
    }

    if ($(this).attr('data-content') === 'semua nilai') {
      var pesan = 'Apakah anda yakin ingin memproses semua nilai yang sudah divalidasi?';
    } else {
      var pesan = 'Apakah anda yakin ingin memproses nilai ' + $(this).attr('data-namapt') + '?';
    }

    Swal.fire({
      title: 'Proses Nilai?',
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
</script>