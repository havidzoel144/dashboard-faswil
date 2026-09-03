<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  .pda-page {
    background: #f7f8fc;
    padding: 1.5rem;
    border-radius: 8px;
  }

  .pda-greeting h2 {
    font-size: 2.4rem;
    font-weight: 700;
    color: #1d2a66;
    margin-top: .75rem;
    margin-bottom: .75rem;
  }

  .pda-greeting p {
    color: #3d4771;
    margin-bottom: 0;
  }

  .pda-note {
    background: #eef3ff;
    border-radius: 10px;
    padding: 1rem 1.2rem;
    color: #26306b;
    font-size: .92rem;
    line-height: 1.45;
  }

  .pda-note .title {
    font-weight: 700;
    margin-bottom: .35rem;
    font-size: 1.1rem;
  }

  .pda-card,
  .pda-box {
    background: #fff;
    border: 1px solid #dde3f1;
    border-radius: 10px;
    box-shadow: 0 1px 2px rgba(25, 35, 82, .03);
  }

  .pda-card {
    padding: 1rem 1.1rem;
    min-height: 245px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .pda-card .title {
    color: #20295f;
    font-weight: 700;
    margin-bottom: .25rem;
  }

  .pda-muted {
    color: #525f8f;
    font-size: .96rem;
  }

  .pda-main-number {
    color: #6818e0;
    font-weight: 700;
    font-size: 2rem;
    margin: .25rem 0 .1rem;
  }

  .pda-link {
    color: #6818e0;
    font-weight: 600;
    font-size: .9rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #eceef7;
    padding-top: .8rem;
    margin-top: .8rem;
  }

  .pda-orange {
    color: #ff821d;
  }

  .pda-green {
    color: #2e7d32;
  }

  .pda-table {
    margin-bottom: 0;
  }

  .pda-table thead th {
    border-top: 0;
    border-bottom: 1px solid #e7e9f3;
    color: #677199;
    font-size: .82rem;
    font-weight: 600;
    padding: .7rem .75rem;
  }

  .pda-table td {
    color: #27306c;
    font-size: .86rem;
    vertical-align: middle;
    border-top: 1px solid #eff1f8;
    padding: .75rem;
  }

  .badge-soft {
    border-radius: 15px;
    font-size: .74rem;
    font-weight: 600;
    padding: .35rem .65rem;
    white-space: nowrap;
    display: inline-block;
  }

  .badge-source {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: .35rem 1rem;
  }

  .badge-source i {
    font-size: .9rem;
    width: 14px;
    text-align: center;
    flex-shrink: 0;
  }

  .badge-source .label {
    display: inline-block;
    text-align: center;
    line-height: 1.5;
  }

  .badge-status {
    display: block;
    text-align: center;
    padding: .35rem 1rem;
  }

  .badge-soft-green {
    color: #1e8a4c;
    background: #e8f7ee;
  }

  .badge-soft-orange {
    color: #b86b00;
    background: #fff3e1;
  }

  .badge-soft-red {
    color: #cd3b3b;
    background: #ffe8e8;
  }

  .badge-soft-purple {
    color: #6818e0;
    background: #f0edff;
  }

  .badge-soft-blue {
    color: #2370cc;
    background: #e8f2ff;
  }

  .pda-priority-item {
    border: 1px solid #eceef7;
    border-radius: 10px;
    padding: .8rem .9rem;
    margin-bottom: .6rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .7rem;
    min-height: 78px;
  }

  .pda-priority-item .icon {
    width: 28px;
    text-align: center;
    flex-shrink: 0;
    line-height: 1;
  }

  .pda-priority-item .content {
    flex: 1;
    min-width: 0;
    margin-left: 0px !important;
  }

  .pda-priority-item .badge-soft {
    margin-left: auto;
    align-self: center;
  }

  .pda-priority-item .head {
    font-weight: 700;
    color: #2a326c;
    margin-bottom: .15rem;
  }

  .pda-priority-item small {
    color: #707aa0;
    display: block;
    line-height: 1.35;
  }

  .pda-footer {
    color: #a1a8c6;
    font-size: .8rem;
    margin-top: 1rem;
    display: flex;
    justify-content: space-between;
  }

  .pda-status-legend {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem 1rem;
    margin-top: .75rem;
    color: #5b648e;
    font-size: .82rem;
  }

  .pda-status-legend .item {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
  }

  .pda-status-legend .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
  }

  .pda-modal {
    position: fixed;
    inset: 0;
    z-index: 1060;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  .pda-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
  }

  .pda-modal-dialog {
    position: relative;
    width: 100%;
    max-width: 760px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  .pda-modal-header {
    background: linear-gradient(135deg, #6818e0 0%, #3b82f6 100%);
    color: #fff;
    padding: 1rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .pda-modal-title {
    font-size: 1.05rem;
    font-weight: 700;
    margin: 0;
    color: #fff;
  }

  .pda-modal-close {
    border: 0;
    background: transparent;
    color: #fff;
    font-size: 1.2rem;
    cursor: pointer;
  }

  .pda-modal-body {
    padding: 1.25rem;
  }

  .pda-modal-label {
    color: #500096;
    font-size: .85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: .2rem;
  }

  .pda-modal-value {
    color: #111827;
    font-size: .98rem;
    margin-bottom: .85rem;
  }

  .pda-modal-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
  }

  .pda-modal-footer .btn {
    border-radius: 8px;
    padding: .5rem 1rem;
    font-weight: 600;
  }
</style>

<!-- Simulasi 5 Indikator Syarat Perlu (IAPT 4.1) -->
<?php
// SPMI yang dikembangkan oleh PT
$skor_indikaotor_1 = $penjaminan_mutu->skor_1;
$status_spmi = $skor_indikaotor_1 > 0 ? "Memenuhi" : "Tidak Memenuhi";
$badge_class_indikator_1 = $skor_indikaotor_1 > 0 ? "badge-soft-green" : "badge-soft-red";

// Implementasi SPMI melalui siklus PPEPP
$skor_indikaotor_2 = $penjaminan_mutu->skor_2;
$status_ppepp = $skor_indikaotor_2 > 0 ? "Memenuhi" : "Tidak Memenuhi";
$badge_class_indikator_2 = $skor_indikaotor_2 > 0 ? "badge-soft-green" : "badge-soft-red";

// PT memperoleh pengakuan atas mutu akademik yang dicapainya, berupa akreditasi program studi dari LAM/BAN-PT
$persentase_prodi_terakreditasi = $statistik['persentase_prodi_terakreditasi'];
$persentase_prodi_terakreditasi_tampil = ((float) $persentase_prodi_terakreditasi == floor((float) $persentase_prodi_terakreditasi))
  ? (int) $persentase_prodi_terakreditasi
  : rtrim(rtrim(number_format((float) $persentase_prodi_terakreditasi, 2, ',', '.'), '0'), ',');
$status_akre_prodi = $persentase_prodi_terakreditasi == 100 ? "Memenuhi" : "Tidak Memenuhi";
$badge_class_indikator_4 = $persentase_prodi_terakreditasi == 100 ? "badge-soft-green" : "badge-soft-red";

// Perguruan Tinggi memiliki kecukupan dosen untuk setiap program studi
$dosen_tidak_cukup = $prodi_dosen_kurang_dari_5;
$status_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Tidak Memenuhi" : "Memenuhi";
$badge_class_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "badge-soft-red" : "badge-soft-green";
$label_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Ada Prodi dengan Jumlah Dosen Kurang" : "Semua Prodi Memiliki Jumlah Dosen Cukup";

// Perguruan Tinggi memiliki dosen tetap dengan jabatan akademik
$jja_dosen = $jja_dosen->persentase_nm_jabatan_terisi ?? 0;
$bentuk_pt = $data_pt->bentuk_pt;

if ($bentuk_pt == 'Universitas' || $bentuk_pt == 'Institut') :
  $status_jja_dosen = $jja_dosen >= 60 ? "Memenuhi" : "Tidak Memenuhi";
  $badge_class_jja_dosen = $jja_dosen >= 60 ? "badge-soft-green" : "badge-soft-red";
elseif ($bentuk_pt == 'Sekolah Tinggi') :
  $status_jja_dosen = $jja_dosen >= 30 ? "Memenuhi" : "Tidak Memenuhi";
  $badge_class_jja_dosen = $jja_dosen >= 30 ? "badge-soft-green" : "badge-soft-red";
elseif ($bentuk_pt == 'Akademi' || $bentuk_pt == 'Politeknik' || $bentuk_pt == 'Akademi Komunitas') :
  $status_jja_dosen = $jja_dosen >= 45 ? "Memenuhi" : "Tidak Memenuhi";
  $badge_class_jja_dosen = $jja_dosen >= 45 ? "badge-soft-green" : "badge-soft-red";
else :
  $status_jja_dosen = "Bentuk PT tidak dikenali";
  $badge_class_jja_dosen = "badge-soft-red";
endif;

$label_jja_dosen = "Dosen dengan Jabatan Akademik: {$jja_dosen}%";

$perlu_perhatian = ($status_spmi == "Tidak Memenuhi" ? 1 : 0) + ($status_ppepp == "Tidak Memenuhi" ? 1 : 0) + ($status_akre_prodi == "Tidak Memenuhi" ? 1 : 0) + ($status_jumlah_dosen == "Tidak Memenuhi" ? 1 : 0) + (($status_jja_dosen == "Tidak Memenuhi" || $status_jja_dosen == "Bentuk PT tidak dikenali") ? 1 : 0);
?>

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
        <div class="col-12">
          <div class="alert alert-info mb-3 d-flex align-items-center" role="alert" style="border-radius:12px;padding:1.1rem 1.35rem;font-size:1.2rem;line-height:1.65;box-shadow:0 8px 20px rgba(37,99,235,.12);border-left:4px solid #2563eb;background:linear-gradient(135deg,#e0ecff 0%,#f3f8ff 55%,#ffffff 100%);">
            <i class="la la-info-circle mr-2" style="font-size:3.55rem;color:#2563eb;"></i>
            <div class="font-medium-4" style="line-height:1.45;">
              <strong>Informasi:</strong> Halaman ini masih dalam tahap pengembangan dan akan terus disempurnakan.
            </div>
          </div>
        </div>
      </div>

      <div class="pda-page">
        <div class="row mb-2 align-items-start">
          <div class="col-md-8 pda-greeting">
            <h4 class="mb-0" style="color:#23306d;font-weight:600;">Selamat Datang,</h4>
            <h2><?= $data_pt->nama_pt ?></h2>
            <p>Berikut ringkasan peringatan dini akreditasi dan simulasi pemenuhan syarat perlu institusi Anda.</p>
          </div>
          <div class="col-md-4">
            <div class="pda-note d-flex align-items-start">
              <div class="mr-1" style="width:40px;height:40px;border-radius:50%;background:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="la la-info-circle text-white" style="font-size: 2rem;"></i>
              </div>
              <div>
                <div class="title">Catatan Penting</div>
                Hasil simulasi merupakan indikasi awal berdasarkan data PDDikti dan hasil reviu eksternal SPMI oleh Faswil.
                Status yang ditampilkan bukan merupakan hasil penilaian atau keputusan akreditasi resmi BAN-PT/LAM.
              </div>
            </div>
          </div>
        </div>

        <div class="row align-items-stretch">
          <div class="col-md-4 mb-1">
            <div class="pda-card">
              <div class="d-flex align-items-start mb-2">
                <div style="width:56px;height:56px;border-radius:50%;background:#ecdfff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  <i class="la la-university" style="font-size: 2rem; color: #6818e0;"></i>
                </div>
                <div class="pl-2" style="line-height:1.35; width:100%;">
                  <div class="title">Akreditasi Institusi</div>
                  <div class="pda-muted mb-1">Masa berlaku sampai</div>
                  <div class="pda-main-number mb-1" style="font-size:1.9rem;"><?= format_tanggal_indonesia($data_pt->tgl_akhir_akred) ?></div>
                  <?php
                  $hari_ini = new DateTime(date('Y-m-d'));
                  $tgl_akhir_akred = new DateTime($data_pt->tgl_akhir_akred);

                  if ($tgl_akhir_akred >= $hari_ini) {
                    $interval = $hari_ini->diff($tgl_akhir_akred);
                    $sisa_bulan = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);
                    $teks_sisa_waktu = "Sisa waktu {$sisa_bulan} bulan";
                    $teks_sisa_waktu = $sisa_bulan <= 12 ? "<span class='text-danger'>{$teks_sisa_waktu}</span>" : $teks_sisa_waktu;
                  } else {
                    $interval = $tgl_akhir_akred->diff($hari_ini);
                    $lewat_bulan = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);
                    $teks_sisa_waktu = "Lewat {$lewat_bulan} bulan";
                    $teks_sisa_waktu = $lewat_bulan <= 12 ? "<span class='text-danger'>{$teks_sisa_waktu}</span>" : $teks_sisa_waktu;
                  }
                  ?>
                  <span class="badge-soft badge-soft-purple" style="display:inline-block; font-size: 0.85rem;"><?= $teks_sisa_waktu ?></span>
                </div>
              </div>
              <div class="pda-link pt-1" id="lihat-detail-institusi" data-kode-pt="<?= $data_pt->kode_pt ?>" role="button" tabindex="0" aria-label="Lihat detail institusi" style="cursor:pointer;">Lihat Detail <span>&rsaquo;</span></div>
            </div>
          </div>

          <div class="col-md-4 mb-1">
            <div class="pda-card">
              <div class="d-flex align-items-start mb-0">
                <div style="width:56px;height:56px;border-radius:50%;background:#fff1e6;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                  <i class="la la-graduation-cap" style="font-size: 2rem; color: #ff821d;"></i>
                </div>
                <div class="pl-2" style="line-height:1.35; width:100%;">
                  <div class="title">Peringatan Akreditasi Program Studi</div>
                  <div class="pda-main-number pda-orange mb-0" style="font-size:1.9rem;"><?= $kategori_akreditasi['kurang_dari_6_bulan'] + $kategori_akreditasi['antara_6_sampai_12_bulan'] ?> Program Studi</div>
                  <div class="pda-muted mb-1">akan berakhir dalam 12 bulan</div>
                </div>
              </div>
              <div>
                <div class="table-responsive">
                  <table class="table pda-table" style="border-collapse: separate; border-spacing: 0 8px;">
                    <thead>
                      <tr>
                        <td class="p-0 font-weight-bold" style="border:0;">Status</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;">Jumlah</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#dc3545;margin-right:6px;vertical-align:middle;"></span>&lt; 6 bulan</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><?= $kategori_akreditasi['kurang_dari_6_bulan'] ?></td>
                      </tr>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#fd7e14;margin-right:6px;vertical-align:middle;"></span>6 - 12 bulan</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><?= $kategori_akreditasi['antara_6_sampai_12_bulan'] ?></td>
                      </tr>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#28a745;margin-right:6px;vertical-align:middle;"></span>&gt; 12 bulan</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><?= $kategori_akreditasi['lebih_dari_12_bulan'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pda-link pda-orange">Lihat Daftar Program Studi <span>&rsaquo;</span></div>
            </div>
          </div>

          <div class="col-md-4 mb-1">
            <div class="pda-card">
              <div class="d-flex align-items-start">
                <div style="width:56px;height:56px;border-radius:50%;background:#e8f5e9;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                  <i class="la la-calendar-check-o" style="font-size: 2rem; color: #28a745;"></i>
                </div>
                <div class="pl-2" style="line-height:1.35; width:100%;">
                  <div class="title">Simulasi Syarat Perlu Akreditasi Institusi</div>
                  <div class="pda-muted">Berdasarkan 5 indikator (IAPT 4.1)</div>
                  <div class="mt-2" style="font-size:2rem;font-weight:700;color:#1f2a67;"><?= $perlu_perhatian ?> dari 5 indikator</div>
                  <div style="font-size:1.5rem;font-weight:700;color:#ff4c29;line-height:1;">perlu perhatian</div>
                </div>
              </div>
              <div class="pda-link pda-green">Lihat Hasil Simulasi <span>&rsaquo;</span></div>
            </div>
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-md-8 mb-1">
            <div class="pda-box p-1">
              <h5 style="color:#27306c;font-weight:700;">Simulasi 5 Indikator Syarat Perlu (IAPT 4.1)</h5>
              <div class="table-responsive">
                <table class="table pda-table">
                  <thead>
                    <tr style="background:#f7f8fc;">
                      <th style="width:45px;">No</th>
                      <th>Indikator</th>
                      <th style="width:200px;">Sumber Data</th>
                      <th style="width:160px;">Status Simulasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>SPMI yang dikembangkan oleh PT dengan menerapkan tata kelola perguruan tinggi yang baik dan diimplementasikan berdasarkan prinsip akuntabilitas, transparan, nirlaba, efektif dan efisien yang dapat menjamin dan meningkatkan mutu pendidikan tinggi secara berkelanjutan dalam bidang akademik dan non-akademik.</td>
                      <td>
                        <span class="badge-soft badge-soft-purple badge-source">
                          <i class="la la-university" style="font-size: 20px;"></i>
                          <span class="label">Reviu Eksternal <br> SPMI oleh Faswil</span>
                        </span>
                      </td>
                      <td>
                        <span class="badge-soft <?= $badge_class_indikator_1 ?> badge-status">
                          <?= $status_spmi ?>
                          <br>
                          <span class="text-dark">(Skor 1 Hasil Reviu: <?= floor($skor_indikaotor_1) == $skor_indikaotor_1 ? (int) $skor_indikaotor_1 : $skor_indikaotor_1 ?>)</span>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Implementasi SPMI melalui siklus PPEPP</td>
                      <td>
                        <span class="badge-soft badge-soft-purple badge-source">
                          <i class="la la-university" style="font-size: 20px;"></i>
                          <span class="label">Reviu Eksternal <br> SPMI oleh Faswil</span>
                        </span>
                      </td>
                      <td>
                        <span class="badge-soft <?= $badge_class_indikator_2 ?> badge-status">
                          <?= $status_ppepp ?>
                          <br>
                          <span class="text-dark">(Skor 2 Hasil Reviu: <?= floor($skor_indikaotor_2) == $skor_indikaotor_2 ? (int) $skor_indikaotor_2 : $skor_indikaotor_2 ?>)</span>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>PT memperoleh pengakuan atas mutu akademik yang dicapainya, berupa akreditasi program studi dari LAM/BAN-PT</td>
                      <td>
                        <span class="badge-soft badge-soft-purple badge-source">
                          <i class="la la-university" style="font-size: 20px;"></i>
                          <span class="label">Reviu Eksternal <br> SPMI oleh Faswil</span>
                        </span>
                      </td>
                      <td>
                        <span class="badge-soft <?= $badge_class_indikator_4 ?> badge-status">
                          <?= $status_akre_prodi ?>
                          <br>
                          <span class="text-dark">(Persentase Prodi Terakreditasi: <?= $persentase_prodi_terakreditasi_tampil ?>%)</span>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Perguruan Tinggi memiliki kecukupan dosen untuk setiap program studi</td>
                      <td>
                        <span class="badge-soft badge-soft-blue badge-source">
                          <i class="fa fa-database" style="font-size: 20px;"></i>
                          <span class="label">PDDikti</span>
                        </span>
                      </td>
                      <td>
                        <span class="badge-soft <?= $badge_class_jumlah_dosen ?> badge-status">
                          <?= $status_jumlah_dosen ?>
                          <br>
                          <span class="text-dark">(<?= $label_jumlah_dosen ?>)</span>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Perguruan Tinggi memiliki dosen tetap dengan jabatan akademik</td>
                      <td>
                        <span class="badge-soft badge-soft-blue badge-source">
                          <i class="fa fa-database" style="font-size: 20px;"></i>
                          <span class="label">PDDikti</span>
                        </span>
                      </td>
                      <td>
                        <span class="badge-soft <?= $badge_class_jja_dosen ?> badge-status">
                          <?= $status_jja_dosen ?>
                          <br>
                          <span class="text-dark">(<?= $label_jja_dosen ?>)</span>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center">
                  <div class="item font-weight-bolder mr-2">Keterangan Status Simulasi:</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center mt-1">
                  <div class="item d-flex align-items-center">
                    <span class="d-inline-flex align-items-center mr-1">
                      <i class="fa fa-check-circle" style="font-size:20px;color:#1e8a4c;"></i>
                    </span>
                    <span>
                      <strong>Terindikasi Sesuai</strong><br>
                      Indikasi awal yang baik
                    </span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center mt-1">
                  <div class="item d-flex align-items-center">
                    <span class="d-inline-flex align-items-center mr-1">
                      <i class="fa fa-exclamation-triangle" style="font-size:20px;color:#f78b00;"></i>
                    </span>
                    <span>
                      <strong>Perlu Verifikasi</strong><br>
                      Perlu verifikasi atau data pendukung tambahan
                    </span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center mt-1">
                  <div class="item d-flex align-items-center">
                    <span class="d-inline-flex align-items-center mr-1">
                      <i class="fa fa-times-circle" style="font-size:20px;color:#fd1b3b;"></i>
                    </span>
                    <span>
                      <strong>Perlu Tindak Lanjut</strong><br>
                      Perlu perbaikan atau perhatian segera
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-1">
            <div class="pda-box p-1">
              <h5 style="color:#27306c;font-weight:700;">Prioritas Tindak Lanjut</h5>

              <div class="pda-priority-item">
                <span class="icon">
                  <i class="fa fa-exclamation-triangle" style="font-size:20px;color:#fd1b3b;"></i>
                </span>
                <div class="content">
                  <div class="head">Jabatan akademik dosen</div>
                  <small>Status: <span style="color:#d34545;font-weight:600;">Perlu Tindak Lanjut</span></small>
                  <small>Indikator 5 (Data PDDikti)</small>
                </div>
                <span class="badge-soft badge-soft-red">Prioritas Tinggi</span>
              </div>

              <div class="pda-priority-item">
                <span class="icon">
                  <i class="fa fa-exclamation-circle" style="font-size:20px;color:#f78b00;"></i>
                </span>
                <div class="content">
                  <div class="head">Kecukupan dosen pada beberapa program studi</div>
                  <small>Status: <span style="color:#d38c20;font-weight:600;">Perlu Verifikasi</span></small>
                  <small>Indikator 4 (Data PDDikti)</small>
                </div>
                <span class="badge-soft badge-soft-orange">Prioritas Sedang</span>
              </div>

              <div class="pda-priority-item">
                <span class="icon">
                  <i class="fa fa-refresh" style="font-size:20px;color:#2370cc;"></i>
                </span>
                <div class="content">
                  <div class="head">Pastikan pemutakhiran data PDDikti</div>
                  <small>Data akreditasi prodi, dosen, dan jabatan akademik harus selalu diperbarui secara berkala.</small>
                </div>
              </div>

              <div class="pda-priority-item mb-0">
                <span class="icon">
                  <i class="fa fa-calendar-check-o" style="font-size:20px;color:#6818e0;"></i>
                </span>
                <div class="content">
                  <div class="head">Reviu eksternal SPMI berikutnya</div>
                  <small>Lakukan tindak lanjut hasil reviu SPMI oleh Faswil sesuai rekomendasi yang diberikan.</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="pda-footer">
          <span>&copy; 2023 LLDIKTI III</span>
          <span>by SI BTI 4.0 &#9829;</span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->

<div id="modalDetailInstitusi" class="pda-modal" aria-hidden="true">
  <div class="pda-modal-backdrop" data-close-modal="true"></div>
  <div class="pda-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalDetailInstitusiTitle">
    <div class="pda-modal-header">
      <h5 class="pda-modal-title" id="modalDetailInstitusiTitle">Detail Institusi</h5>
      <button type="button" class="pda-modal-close" aria-label="Tutup" data-close-modal="true">&times;</button>
    </div>
    <div class="pda-modal-body" id="institusiDetailBody"></div>
    <div class="pda-modal-footer">
      <button type="button" class="btn btn-secondary" data-close-modal="true">Tutup</button>
    </div>
  </div>
</div>

<?= $this->load->view('admin/v_footer') ?>


<script>
  $(function() {
    const $trigger = $('#lihat-detail-institusi');
    const $modal = $('#modalDetailInstitusi');
    const $detailBody = $('#institusiDetailBody');

    if (!$trigger.length || !$modal.length || !$detailBody.length) {
      return;
    }

    const dataPt = {
      kode_pt: '031065',
      nama_pt: 'Universitas Bina Sarana Informatika',
      status_pt: 'A',
      akreditasi_pt: 'Unggul',
      bentuk_pt: 'Universitas',
      tgl_sk_pendirian: '2018-09-03',
      alamat_jalan: 'Kampus Kramat 98 Jl. Kramat Raya No.98, Senen, Jakarta Pusat 10450\ntlp. (021) 23231170, Fax. (021) 21236158',
      tgl_mulai_akred: '2025-06-14',
      tgl_akhir_akred: '2030-06-14',
      tgl_update: '2026-06-03'
    };

    const formatDate = function(value) {
      if (!value) {
        return '-';
      }

      const date = new Date(value);
      if (Number.isNaN(date.getTime())) {
        return value;
      }

      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
    };

    const renderDetail = function() {
      $detailBody.html(`
        <div class="row">
          <div class="col-md-6">
            <div class="pda-modal-label">Kode PT</div>
            <div class="pda-modal-value">${dataPt.kode_pt || '-'}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Nama PT</div>
            <div class="pda-modal-value">${dataPt.nama_pt || '-'}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Status PT</div>
            <div class="pda-modal-value">${dataPt.status_pt || '-'}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Akreditasi PT</div>
            <div class="pda-modal-value">${dataPt.akreditasi_pt || '-'}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Bentuk PT</div>
            <div class="pda-modal-value">${dataPt.bentuk_pt || '-'}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Tanggal SK Pendirian</div>
            <div class="pda-modal-value">${formatDate(dataPt.tgl_sk_pendirian)}</div>
          </div>
          <div class="col-12">
            <div class="pda-modal-label">Alamat</div>
            <div class="pda-modal-value">${(dataPt.alamat_jalan || '-').replace(/\n/g, '<br>')}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Tanggal Mulai Akreditasi</div>
            <div class="pda-modal-value">${formatDate(dataPt.tgl_mulai_akred)}</div>
          </div>
          <div class="col-md-6">
            <div class="pda-modal-label">Tanggal Akhir Akreditasi</div>
            <div class="pda-modal-value">${formatDate(dataPt.tgl_akhir_akred)}</div>
          </div>
          <div class="col-12">
            <div class="pda-modal-label">Terakhir Diperbarui</div>
            <div class="pda-modal-value">${formatDate(dataPt.tgl_update)}</div>
          </div>
        </div>`);
    };

    const openModal = function() {
      renderDetail();
      $modal.css('display', 'flex').attr('aria-hidden', 'false');
      $('body').css('overflow', 'hidden');
    };

    const closeModal = function() {
      $modal.css('display', 'none').attr('aria-hidden', 'true');
      $('body').css('overflow', '');
    };

    $trigger.on('click', openModal);
    $trigger.on('keydown', function(event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        openModal();
      }
    });

    $modal.on('click', function(event) {
      if ($(event.target).attr('data-close-modal') === 'true') {
        closeModal();
      }
    });

    $(document).on('keydown', function(event) {
      if (event.key === 'Escape' && $modal.attr('aria-hidden') === 'false') {
        closeModal();
      }
    });
  });
</script>