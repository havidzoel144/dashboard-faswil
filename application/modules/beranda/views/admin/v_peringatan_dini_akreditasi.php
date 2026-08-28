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

  .pda-modal-dialog {
    position: relative;
    width: 100%;
    max-width: 980px;
    max-height: 100vh;
    /* maksimal 90% tinggi layar */
    background: #fff;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
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
    overflow-y: auto;
    /* scroll di body */
    flex: 1;
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

  .table-responsive {
    max-height: 70vh;
    overflow-y: auto;
  }
</style>

<!-- BEGIN: Content-->
<div class="app-content content center-layout">
  <!-- untuk tidak full layar -->
  <!-- <div class="app-content content center-layout"> -->
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <?php if (has_role([1, 2])) : ?>
        <select class="form-control select2 square kode-pt-option" id="kode-pt">
          <option value="">Pilih Perguruan Tinggi</option>
          <?php foreach ($list_pt as $pt) : ?>
            <option value="<?= $pt->kode_pt ?>"><?= $pt->nama_pt ?></option>
          <?php endforeach; ?>
        </select>
      <?php elseif (has_role([6])) : ?>
        <input type="text" class="form-control" id="kode-pt" value="<?= $kode_pt ?>" hidden>
      <?php endif; ?>

      <div class="pda-page main-content d-none">
        <div class="row mb-2 align-items-start">
          <div class="col-md-8 pda-greeting">
            <h4 class="mb-0" style="color:#23306d;font-weight:600;">Selamat Datang,</h4>
            <h2 id="nama-pt"></h2>
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
                  <div class="pda-main-number mb-1" id="tgl-akhir-akred" style="font-size:1.9rem;"></div>
                  <span class="badge-soft badge-soft-purple" id="sisa-waktu-akred" style="display:inline-block; font-size: 0.85rem;"></span>
                </div>
              </div>
              <div class="pda-link pt-1" id="lihat-detail-institusi" role="button" tabindex="0" aria-label="Lihat detail institusi" style="cursor:pointer;">Lihat Detail <span>&rsaquo;</span></div>
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
                  <div class="pda-main-number pda-orange mb-0" id="peringatan-jumlah-prodi" style="font-size:1.9rem;"></div>
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
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><span id="jumlah-kurang-6-bulan"></span></td>
                      </tr>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#fd7e14;margin-right:6px;vertical-align:middle;"></span>6 - 12 bulan</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><span id="jumlah-6-12-bulan"></span></td>
                      </tr>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#28a745;margin-right:6px;vertical-align:middle;"></span>&gt; 12 bulan</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><span id="jumlah-lebih-12-bulan"></span></td>
                      </tr>
                      <tr>
                        <td class="p-0 pda-muted" style="border:0;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#6c757d;margin-right:6px;vertical-align:middle;"></span>Tidak dikenali</td>
                        <td class="p-0 text-right font-weight-bold" style="border:0; width:48px;"><span id="jumlah-tidak-dikenali"></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pda-link pda-orange" id="lihat-daftar-prodi" role="button" tabindex="0" aria-label="Lihat daftar program studi" style="cursor:pointer;">Lihat Daftar Program Studi <span>&rsaquo;</span></div>
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
                  <div class="mt-2" id="perlu-perhatian" style="font-size:2rem;font-weight:700;color:#1f2a67;"></div>
                  <div style="font-size:1.5rem;font-weight:700;color:#ff4c29;line-height:1;">perlu perhatian</div>
                </div>
              </div>
              <div class="pda-link pda-green" id="lihat-hasil-simulasi" role="button" tabindex="0" aria-label="Lihat hasil simulasi" style="cursor:pointer;">Lihat Hasil Simulasi <span>&rsaquo;</span></div>
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
                        <span class="badge-soft badge-status" id="badge-status-spmi">
                          <span id="status-spmi"></span>
                          <br>
                          <span class="text-dark" id="label-spmi"></span>
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
                        <span class="badge-soft badge-status" id="badge-status-ppepp">
                          <span id="status-ppepp"></span>
                          <br>
                          <span class="text-dark" id="label-ppepp"></span>
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
                        <span class="badge-soft badge-status" id="badge-status-akreditasi-prodi">
                          <span id="status-akreditasi-prodi"></span>
                          <br>
                          <span class="text-dark" id="label-akreditasi-prodi"></span>
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
                        <span class="badge-soft badge-status" id="badge-status-jumlah-dosen">
                          <span id="status-jumlah-dosen"></span>
                          <br>
                          <span class="text-dark" id="label-jumlah-dosen"></span>
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
                        <span class="badge-soft badge-status" id="badge-status-jja-dosen">
                          <span id="status-jja-dosen"></span>
                          <br>
                          <span class="text-dark" id="label-jja-dosen"></span>
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
              <div class="row">
                <div class="col-12">
                  <div class="alert alert-info mb-3 d-flex align-items-center" role="alert" style="border-radius:12px;padding:1.1rem 1.35rem;font-size:1.2rem;line-height:1.65;box-shadow:0 8px 20px rgba(37,99,235,.12);border-left:4px solid #2563eb;background:linear-gradient(135deg,#e0ecff 0%,#f3f8ff 55%,#ffffff 100%);">
                    <i class="la la-info-circle mr-2" style="font-size:3.55rem;color:#2563eb;"></i>
                    <div class="font-medium-1" style="line-height:1.45;">
                      <strong>Informasi:</strong> Bagian ini masih dalam tahap pengembangan dan akan terus disempurnakan.
                    </div>
                  </div>
                </div>
              </div>
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

      <div class="pda-page information-content d-none">
        <!-- Content will be loaded here -->
        <div class="pda-empty-state" style="min-height:260px;display:flex;align-items:center;justify-content:center;">
          <div style="text-align:center;max-width:520px;padding:24px 20px;border:1px dashed #d7d7d7;border-radius:12px;background:#fafafa;">
            <i class="fa fa-university" style="font-size:40px;color:#2370cc;margin-bottom:12px;display:block;"></i>
            <div style="font-size:20px;font-weight:700;color:#2f2f2f;margin-bottom:6px;">Pilih Perguruan Tinggi Terlebih Dahulu</div>
            <small style="font-size:14px;color:#6c757d;">Silakan pilih perguruan tinggi pada filter untuk menampilkan data peringatan dini akreditasi.</small>
          </div>
        </div>
      </div>

      <div class="pda-page not-found-pt d-none">
        <div class="pda-empty-state" style="min-height:320px;display:flex;align-items:center;justify-content:center;padding:24px 16px;">
          <div style="text-align:center;max-width:560px;padding:34px 28px;border:1px solid #ffb3b3;border-radius:18px;background:linear-gradient(180deg,#ffffff 0%,#fff1f1 100%);box-shadow:0 12px 30px rgba(220,53,69,.16);position:relative;overflow:hidden;">
            <div style="position:absolute;inset:-40px auto auto -40px;width:140px;height:140px;border-radius:50%;background:radial-gradient(circle,rgba(220,53,69,.18) 0%,rgba(220,53,69,0) 70%);"></div>
            <div style="width:78px;height:78px;margin:0 auto 18px;border-radius:50%;background:rgba(220,53,69,.12);display:flex;align-items:center;justify-content:center;box-shadow:inset 0 0 0 1px rgba(220,53,69,.16);">
              <i class="fa fa-university" style="font-size:34px;color:#dc3545;"></i>
            </div>
            <div style="font-size:22px;font-weight:800;color:#dc3545;margin-bottom:8px;letter-spacing:.2px;">Perguruan Tinggi Tidak Ditemukan</div>
            <div style="width:72px;height:3px;background:linear-gradient(90deg,#dc3545,#ff4d4d);border-radius:999px;margin:0 auto 14px;"></div>
            <small style="font-size:14px;line-height:1.7;color:#a61d2d;display:block;max-width:440px;margin:0 auto;">Silakan pilih perguruan tinggi pada filter untuk menampilkan data peringatan dini akreditasi. Pastikan data yang dipilih sudah sesuai agar informasi dapat ditampilkan dengan benar.</small>
          </div>
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

<div id="modalDaftarProdi" class="pda-modal" aria-hidden="true">
  <div class="pda-modal-backdrop" data-close-modal-prodi="true"></div>
  <div class="pda-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalDaftarProdiTitle" style="max-width: 980px;">
    <div class="pda-modal-header">
      <h5 class="pda-modal-title" id="modalDaftarProdiTitle">Daftar Program Studi</h5>
      <button type="button" class="pda-modal-close" aria-label="Tutup" data-close-modal-prodi="true">&times;</button>
    </div>
    <div class="pda-modal-body">
      <div class="form-group mb-1">
        <input type="text" class="form-control" id="searchProdiModal" placeholder="Cari kode/nama jenjang/status akreditasi prodi...">
      </div>
      <div class="table-responsive">
        <table class="table pda-table" id="tableDaftarProdiModal">
          <thead>
            <tr class="text-center" style="background:#f7f8fc;">
              <th style="width: 30px;">No</th>
              <th style="width: 70px;">Kode Prodi</th>
              <th>Nama Prodi</th>
              <th style="width: 70px;">Jenjang</th>
              <th style="width: 130px;">Akreditasi</th>
              <th style="width: 100px;">Akhir Akreditasi</th>
            </tr>
          </thead>
          <tbody id="daftarProdiBody"></tbody>
        </table>
      </div>
    </div>
    <div class="pda-modal-footer">
      <button type="button" class="btn btn-secondary" data-close-modal-prodi="true">Tutup</button>
    </div>
  </div>
</div>

<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src=" <?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js">
</script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function() {
    // Initialize Select2 for the PT dropdown
    $('.kode-pt-option').select2({
      placeholder: "Pilih Perguruan Tinggi",
      width: '100%'
    });
  });

  // Calculate remaining time for accreditation
  function getTeksSisaWaktuAkreditasi(tglAkhirAkredValue) {
    const hariIni = new Date();
    const tglAkhirAkred = new Date(tglAkhirAkredValue);

    if (Number.isNaN(tglAkhirAkred.getTime())) {
      return '-';
    }

    let teksSisaWaktu = '';

    if (tglAkhirAkred >= hariIni) {
      const diffMs = tglAkhirAkred - hariIni;
      const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
      const sisaBulan = Math.ceil(diffDays / 30);
      teksSisaWaktu = `Sisa waktu <span class='font-weight-bold font-medium-1'>${sisaBulan}</span> bulan`;
      if (sisaBulan <= 12) {
        teksSisaWaktu = `<span class='text-danger'>${teksSisaWaktu}</span>`;
      }
    } else {
      const diffMs = hariIni - tglAkhirAkred;
      const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
      const lewatBulan = Math.ceil(diffDays / 30);
      teksSisaWaktu = `Lewat <span class='font-weight-bold font-medium-1'>${lewatBulan}</span> bulan`;
      if (lewatBulan <= 12) {
        teksSisaWaktu = `<span class='text-danger'>${teksSisaWaktu}</span>`;
      }
    }

    return teksSisaWaktu;
  }

  // Load dashboard data based on selected kode_pt
  function loadDashboard(kode_pt) {
    if (!kode_pt) {
      $('.main-content').addClass('d-none');
      $('.information-content').removeClass('d-none');
      return;
    }

    $.ajax({
      url: baseURL + 'admin/get-peringatan-dini-akreditasi',
      type: 'GET',
      data: {
        kode_pt: kode_pt
      },
      dataType: 'json',
      beforeSend: function() {
        // optional loading
      },
      success: function(res) {
        if (res.status == false) {
          $('.not-found-pt').removeClass('d-none');
          $('.main-content').addClass('d-none');
          $('.information-content').addClass('d-none');
          return;
        } else {
          $('.not-found-pt').addClass('d-none');
          $('.main-content').removeClass('d-none');
          $('.information-content').addClass('d-none');
        }
        $('#lihat-detail-institusi').data('pt', res.data_pt);
        $('#lihat-daftar-prodi').data('prodi', res.data_prodi);
        $('#nama-pt').text(res.data_pt.nama_pt);
        $('#tgl-akhir-akred').text(res.tgl_akhir_akred);

        const teksSisaWaktu = getTeksSisaWaktuAkreditasi(res.data_pt.tgl_akhir_akred);
        $('#sisa-waktu-akred').html(teksSisaWaktu);
        const kurang_dari_6_bulan = res.kategori_akreditasi.kurang_dari_6_bulan;
        const antara_6_sampai_12_bulan = res.kategori_akreditasi.antara_6_sampai_12_bulan;
        const peringatan_jumlah_prodi = kurang_dari_6_bulan + antara_6_sampai_12_bulan;
        $('#peringatan-jumlah-prodi').text(`${peringatan_jumlah_prodi} Program Studi`);
        $('#jumlah-kurang-6-bulan').text(kurang_dari_6_bulan);
        $('#jumlah-6-12-bulan').text(antara_6_sampai_12_bulan);
        $('#jumlah-lebih-12-bulan').text(res.kategori_akreditasi.lebih_dari_12_bulan);
        $('#jumlah-tidak-dikenali').text(res.kategori_akreditasi.tidak_dikenali);
        const perlu_perhatian = res.indikator_penjaminan_mutu.perlu_perhatian;
        $('#perlu-perhatian').text(`${perlu_perhatian} dari 5 indikator`);

        $('#badge-status-spmi').removeClass().addClass(`badge-soft ${res.indikator_penjaminan_mutu.indikator_1.badge_class} badge-status`);
        $('#status-spmi').text(res.indikator_penjaminan_mutu.indikator_1.status);
        $('#label-spmi').text(`(Skor 1 Hasil Reviu: ${res.indikator_penjaminan_mutu.indikator_1.skor})`);

        $('#badge-status-ppepp').removeClass().addClass(`badge-soft ${res.indikator_penjaminan_mutu.indikator_2.badge_class} badge-status`);
        $('#status-ppepp').text(res.indikator_penjaminan_mutu.indikator_2.status);
        $('#label-ppepp').text(`(Skor 2 Hasil Reviu: ${res.indikator_penjaminan_mutu.indikator_2.skor})`);

        $('#badge-status-akreditasi-prodi').removeClass().addClass(`badge-soft ${res.indikator_penjaminan_mutu.indikator_4.badge_class} badge-status`);
        $('#status-akreditasi-prodi').text(res.indikator_penjaminan_mutu.indikator_4.status);
        $('#label-akreditasi-prodi').text(`(Persentase Prodi Terakreditasi: ${res.indikator_penjaminan_mutu.indikator_4.persentase_prodi_terakreditasi_tampil}%)`);

        $('#badge-status-jumlah-dosen').removeClass().addClass(`badge-soft ${res.indikator_penjaminan_mutu.jumlah_dosen_per_prodi.badge_class} badge-status`);
        $('#status-jumlah-dosen').text(res.indikator_penjaminan_mutu.jumlah_dosen_per_prodi.status);
        $('#label-jumlah-dosen').text(`${res.indikator_penjaminan_mutu.jumlah_dosen_per_prodi.label}`);

        $('#badge-status-jja-dosen').removeClass().addClass(`badge-soft ${res.indikator_penjaminan_mutu.jja_dosen.badge_class} badge-status`);
        $('#status-jja-dosen').text(res.indikator_penjaminan_mutu.jja_dosen.status);
        $('#label-jja-dosen').text(`${res.indikator_penjaminan_mutu.jja_dosen.label}`);
      }
    });
  }

  // Load dashboard on page load
  $(function() {
    loadDashboard($('#kode-pt').val());
  });

  // Handle change event for kode-pt select
  $('#kode-pt').change(function() {
    const kodePt = $(this).val();

    $('body').stop(true, true).fadeTo(400, 0.5, function() {
      loadDashboard(kodePt);
      $(this).fadeTo(400, 1);
    });
  });

  // Lihat detail institusi modal
  $(function() {
    const $trigger = $('#lihat-detail-institusi');
    const $modal = $('#modalDetailInstitusi');
    const $detailBody = $('#institusiDetailBody');

    if (!$trigger.length || !$modal.length || !$detailBody.length) {
      return;
    }

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

    const renderDetail = function(dataPt) {
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
            <div class="pda-modal-label">Terakhir Diperbarui Berdasarkan Data PDDikti Per Tanggal</div>
            <div class="pda-modal-value">${formatDate(dataPt.tgl_update)}</div>
          </div>
        </div>`);
    };

    const openModal = function() {
      const dataPt = $trigger.data('pt');
      if (!dataPt) {
        return;
      }
      renderDetail(dataPt);
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

  // Lihat daftar prodi modal
  $(function() {
    const $triggerProdi = $('#lihat-daftar-prodi');
    const $modalProdi = $('#modalDaftarProdi');
    const $tbodyProdi = $('#daftarProdiBody');
    const $searchProdi = $('#searchProdiModal');
    const $tableProdi = $tbodyProdi.closest('table');
    let prodiDataTable = null;

    if (!$triggerProdi.length || !$modalProdi.length || !$tbodyProdi.length || !$searchProdi.length) {
      return;
    }

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

    const renderRows = function(items) {
      const safeItems = Array.isArray(items) ? items.slice() : [];
      const getRowClass = function(value) {
        if (value === '0000-00-00') {
          return 'table-secondary';
        }

        if (!value) {
          return '';
        }

        const endDate = new Date(value);
        if (Number.isNaN(endDate.getTime())) {
          return '';
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);

        const diffTime = endDate.getTime() - today.getTime();
        const diffDays = diffTime / (1000 * 60 * 60 * 24);

        if (diffDays < 183) {
          return 'table-danger';
        }

        if (diffDays >= 183 && diffDays <= 365) {
          return 'table-warning';
        }

        if (diffDays > 365) {
          return 'table-success';
        }

        return '';
      };

      safeItems.sort(function(a, b) {
        const dateA = a && a.tgl_akhir_akred ? new Date(a.tgl_akhir_akred) : null;
        const dateB = b && b.tgl_akhir_akred ? new Date(b.tgl_akhir_akred) : null;

        const diffA = dateA && !Number.isNaN(dateA.getTime()) ?
          dateA.setHours(0, 0, 0, 0) :
          Number.MAX_SAFE_INTEGER;
        const diffB = dateB && !Number.isNaN(dateB.getTime()) ?
          dateB.setHours(0, 0, 0, 0) :
          Number.MAX_SAFE_INTEGER;

        return diffA - diffB;
      });
      if (!prodiDataTable) {
        prodiDataTable = $tableProdi.DataTable({
          destroy: true,
          dom: 'lrtip',
          paging: true,
          ordering: true,
          searching: true,
          info: true,
          autoWidth: false,
          responsive: false,
          pageLength: 10,
          lengthMenu: [10, 25, 50, 100],
          language: {
            emptyTable: 'Data program studi tidak tersedia.',
            zeroRecords: 'Data tidak ditemukan.'
          }
        });
      }

      prodiDataTable.clear();
      safeItems.forEach(function(item, index) {
        const rowClass = getRowClass(item.tgl_akhir_akred);
        const rowApi = prodiDataTable.row.add([
          `<div style="text-align:center;">${index + 1}</div>`,
          `<div style="text-align:center;">${item.kode_prodi ?? '-'}</div>`,
          `<div style="text-align:left;">${item.nama_prodi ?? '-'}</div>`,
          `<div style="text-align:center;">${item.program ?? '-'}</div>`,
          `<div style="text-align:center;">${item.akreditasi_prodi ?? '-'}</div>`,
          `<div style="text-align:center;">${formatDate(item.tgl_akhir_akred)}</div>`
        ]);

        if (rowClass) {
          const rowNode = rowApi.node();
          $(rowNode).addClass(rowClass);
          $('td', rowNode).addClass(rowClass);
        }
      });
      prodiDataTable.draw(false);
    };

    const parseDataProdi = function(rawData) {
      if (Array.isArray(rawData)) {
        return rawData;
      }

      const extractList = function(value) {
        if (Array.isArray(value)) {
          return value;
        }

        if (value && typeof value === 'object') {
          if (Array.isArray(value.data)) {
            return value.data;
          }
          if (Array.isArray(value.data_prodi)) {
            return value.data_prodi;
          }
          if (Array.isArray(value.prodi)) {
            return value.prodi;
          }
        }

        return [];
      };

      if (typeof rawData === 'string' && rawData.trim() !== '') {
        let text = rawData.trim();

        // antisipasi JSON yang di-escape di atribut HTML
        text = text
          .replace(/&quot;/g, '"')
          .replace(/&#34;/g, '"')
          .replace(/&amp;/g, '&');

        try {
          return extractList(JSON.parse(text));
        } catch (e) {
          return [];
        }
      }

      return extractList(rawData);
    };

    const openModalProdi = function() {

      const dataProdi = $triggerProdi.attr('data-prodi') ?? $triggerProdi.data('prodi');
      const prodiItems = parseDataProdi(dataProdi);

      $searchProdi.val('');

      // tampilkan modal dulu
      $modalProdi.css('display', 'flex').attr('aria-hidden', 'false');
      $('body').css('overflow', 'hidden');

      setTimeout(function() {

        renderRows(prodiItems);

        if (prodiDataTable) {
          prodiDataTable.columns.adjust().draw(false);
        }

      }, 100);

    };

    const closeModalProdi = function() {
      $modalProdi.css('display', 'none').attr('aria-hidden', 'true');
      $('body').css('overflow', '');
    };

    $triggerProdi.on('click', openModalProdi);
    $triggerProdi.on('keydown', function(event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        openModalProdi();
      }
    });

    $modalProdi.on('click', function(event) {
      if ($(event.target).attr('data-close-modal-prodi') === 'true') {
        closeModalProdi();
      }
    });

    $(document).on('keydown', function(event) {
      if (event.key === 'Escape' && $modalProdi.attr('aria-hidden') === 'false') {
        closeModalProdi();
      }
    });

    $searchProdi.on('keyup', function() {
      const keyword = $(this).val().toLowerCase().trim();

      if (prodiDataTable) {
        prodiDataTable.search(keyword).draw();
        return;
      }

      $tbodyProdi.find('tr').each(function() {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.indexOf(keyword) > -1);
      });
    });
  });
</script>