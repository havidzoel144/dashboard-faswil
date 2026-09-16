<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  /* Google Font */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  .ppu-wrap {
    font-family: 'Inter', sans-serif;
  }

  /* Page Header Banner */
  .ppu-page-header {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #3b82f6 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
  }

  .ppu-page-header::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.06);
    border-radius: 50%;
  }

  .ppu-page-header::after {
    content: '';
    position: absolute;
    bottom: -60px;
    right: 80px;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.04);
    border-radius: 50%;
  }

  /* Cards */
  .ppu-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.07);
    transition: box-shadow 0.2s, transform 0.2s;
    height: 100%;
  }

  .ppu-card:hover {
    box-shadow: 0 6px 24px rgba(15, 23, 42, 0.12);
    transform: translateY(-2px);
  }

  /* Donut */
  .ppu-donut {
    position: relative;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: conic-gradient(#10b981 0% 78%, #e2e8f0 78% 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.25);
  }

  .ppu-donut-inner {
    width: 100px;
    height: 100px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  /* Progress */
  .ppu-progress {
    height: 7px;
    border-radius: 10px;
    background: #e9eef6;
    overflow: hidden;
  }

  .ppu-progress-bar {
    height: 100%;
    border-radius: 10px;
    transition: width 0.6s ease;
  }

  /* Table styles */
  .ppu-table thead th {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #f1f5f9;
    padding: 10px 12px;
    background: #f8fafc;
  }

  .ppu-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
  }

  .ppu-table tbody tr:hover {
    background-color: #f8fbff;
  }

  .ppu-table tbody tr:last-child {
    border-bottom: none;
  }

  .ppu-table tbody td {
    padding: 11px 12px;
    vertical-align: middle;
    font-size: 12.5px;
  }

  /* Badges */
  .badge-terpenuhi {
    background-color: #dcfce7;
    color: #15803d;
    font-size: 10.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .badge-perlu {
    background-color: #fff7ed;
    color: #c2410c;
    font-size: 10.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .badge-belum {
    background-color: #fef2f2;
    color: #b91c1c;
    font-size: 10.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  /* Summary badge boxes */
  .ppu-summary-box {
    border-radius: 12px;
    padding: 14px 10px;
    text-align: center;
    flex: 1;
  }

  /* Rekomendasi item */
  .ppu-rekom-item {
    display: flex;
    align-items: flex-start;
    background: #f8fafc;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    border-left: 3px solid transparent;
    transition: border-color 0.2s, background 0.2s;
  }

  .ppu-rekom-item:hover {
    background: #f0f6ff;
    border-left-color: #3b82f6;
  }

  .ppu-rekom-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 16px;
  }

  /* Filter bar */
  .ppu-filter-group label {
    font-size: 10.5px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 5px;
    display: block;
  }

  .ppu-filter-group .input-group-text {
    background: #fff;
    border-right: none;
    border-radius: 10px 0 0 10px;
    border-color: #e2e8f0;
    color: #94a3b8;
  }

  .ppu-filter-group .form-control,
  .ppu-filter-group select {
    border-left: none;
    border-radius: 0 10px 10px 0;
    border-color: #e2e8f0;
    font-size: 12.5px;
    height: 38px;
    color: #1e293b;
    font-weight: 500;
  }

  .ppu-filter-group .form-control:focus,
  .ppu-filter-group select:focus {
    box-shadow: none;
    border-color: #93c5fd;
  }

  /* MODAL */
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
</style>

<!-- BEGIN: Content-->
<div class="app-content content center-layout">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
      <div class="ppu-wrap">

        <!-- ===== PAGE HEADER BANNER ===== -->
        <div class="ppu-page-header">
          <div class="row align-items-center">
            <div class="col-lg-7 mb-3 mb-lg-0">
              <div class="d-flex align-items-center mb-2">
                <div class="mr-3" style="width:48px;height:48px;min-width:48px;min-height:48px;flex:0 0 48px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                  <i class="ft-trending-up" style="font-size:22px;line-height:1;color:#fff;"></i>
                </div>
                <div>
                  <h4 class="font-weight-bold mb-1" style="color:#fff;font-size:28px;letter-spacing:-0.3px;">
                    Pantau Potensi Perguruan Tinggi Unggul
                  </h4>
                  <p class="mb-0" style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:2px;">
                    Dashboard ini menyajikan simulasi pemenuhan indikator syarat perlu Terakreditasi Unggul berdasarkan data yang tersedia pada sistem (data simulasi, bukan hasil akreditasi).
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-flex flex-column align-items-stretch align-items-lg-end" style="gap:10px;">
                <!-- Dropdown PT (Atas) -->
                <div class="ppu-filter-group" style="min-width:320px; width:100%;">
                  <label style="color:rgba(255,255,255,0.8);">Perguruan Tinggi</label>
                  <div class="input-group">
                    <select class="form-control select2 square font-weight-bold" id="kode-pt">
                      <option value="">Pilih Perguruan Tinggi</option>
                      <?php foreach ($list_pt as $pt) : ?>
                        <option value="<?= $pt->kode_pt ?>"><?= $pt->nama_pt ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <!-- Bawah: Periode + Unduh -->
                <div class="d-flex flex-wrap align-items-end justify-content-lg-end" style="gap:12px; width:100%;">
                  <!-- Periode -->
                  <!-- <div class="ppu-filter-group" style="flex:0 0 calc(50% - 6px); max-width:calc(50% - 6px); min-width:0;">
                    <label style="color:rgba(255,255,255,0.8);">Periode</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text d-flex align-items-center justify-content-center"><i class="ft-calendar" style="font-size:13px;"></i></span>
                      </div>
                      <input type="month" class="form-control text-center" value="2026-01" style="width:140px;">
                    </div>
                  </div> -->

                  <!-- Unduh -->
                  <!-- <div style="flex:0 0 calc(50% - 6px); max-width:calc(50% - 6px); min-width:0;">
                    <button class="btn font-weight-bold d-flex align-items-center justify-content-center" style="height:38px;font-size:12px;border-radius:10px;background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);backdrop-filter:blur(4px);width:100%;">
                      <i class="ft-download mr-2"></i> Unduh Laporan
                    </button>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== ROW 1: 3 CARDS ===== -->
        <div class="row match-height mb-1">
          <!-- Card 1: Ringkasan Potensi -->
          <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="card ppu-card">
              <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-center text-center p-2 mb-2" style="background:#fff7ed;border:1px dashed #f59e0b;border-radius:12px;color:#92400e;font-size:11px;font-weight:600;letter-spacing:.2px;">
                  <i class="ft-alert-triangle mr-1"></i>
                  Bagian ini sedang dalam pengembangan
                </div>
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <h6 class="font-weight-bold mb-0" style="color:#1e293b;font-size:15.5px;">Ringkasan Potensi Terakreditasi Unggul</h6>
                </div>

                <div class="d-flex align-items-center mb-1">
                  <div class="ppu-donut mr-2">
                    <div class="ppu-donut-inner">
                      <span style="font-size:22px;font-weight:700;color:#065f46;line-height:1;">78%</span>
                      <span style="font-size:9px;color:#01124a;text-align:center;line-height:1.2;margin-top:2px;">Potensi<br>Unggul</span>
                    </div>
                  </div>
                  <div>
                    <div class="mb-2">
                      <span style="font-size:11px;color:#01124a;">Kategori Potensi</span><br>
                      <span class="badge-terpenuhi" style="font-size:12px;padding:5px 14px;">&#10003; &nbsp;BAIK</span>
                    </div>
                    <p style="font-size:11.5px;color:#01124a;line-height:1.5;margin:0;">
                      Perguruan tinggi Anda memiliki potensi baik untuk memenuhi syarat perlu Terakreditasi Unggul.
                    </p>
                  </div>
                </div>

                <div class="p-1 rounded d-flex align-items-center" style="background:#f1f5f9;gap:8px;">
                  <i class="ft-info" style="font-size:13px;color:#94a3b8;flex-shrink:0;"></i>
                  <small style="font-size:10.5px;color:#01124a;">Data bersifat simulasi dan dapat berubah sesuai pembaruan data terbaru.</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2: Masa Akreditasi PT -->
          <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="card ppu-card">
              <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <h6 class="font-weight-bold mb-0" style="color:#1e293b;font-size:15.5px;">Masa Akreditasi Perguruan Tinggi</h6>
                </div>

                <div class="d-flex align-items-center" style="gap:20px;">
                  <div style="padding:10px;background:#e6f9f0;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ft-calendar" style="font-size:27px;color:#059669;"></i>
                  </div>
                  <div>
                    <span style="font-size:11px;color:#01124a;display:block;">Berlaku hingga</span>
                    <h5 class="font-weight-bold mt-1 mb-0" style="color:#0f172a;font-size:17px;" id="tgl-akhir-akred"></h5>
                  </div>
                </div>

                <div>
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="font-size:11px;color:#01124a;">Sisa Waktu</span>
                    <span class="font-weight-bold" style="font-size:13px;color:#059669;" id="sisa-waktu-akred"></span>
                  </div>

                  <div class="ppu-progress" style="height:10px;background:linear-gradient(90deg,#e2e8f0 0%,#f1f5f9 100%);border-radius:999px;overflow:hidden;">
                    <div id="progress-akreditasi-pt"
                      class="ppu-progress-bar bg-success"
                      style="width:0%;height:100%;transition:all .5s ease;">
                    </div>
                  </div>

                  <div class="mt-50 d-flex justify-content-between small text-muted">
                    <span id="tgl-mulai-akred"></span>
                    <span id="persen-akred"></span>
                    <span id="tgl-akhir-akred-bar"></span>
                  </div>
                </div>

                <div type="button" class="btn btn-outline-success btn-block font-weight-bold" style="border-radius:10px;font-size:12px;" id="lihat-detail-institusi" role="button" tabindex="0" aria-label="Lihat detail institusi">
                  Lihat Detail Akreditasi PT &nbsp;<i class="ft-arrow-right"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3: Masa Akreditasi Prodi -->
          <div class="col-lg-4">
            <div class="card ppu-card">
              <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <h6 class="font-weight-bold mb-0" style="color:#1e293b;font-size:15.5px;">Masa Akreditasi Program Studi</h6>
                </div>

                <div class="d-flex align-items-center" style="gap:20px;">
                  <div style="padding:10px;background:#f3e8ff;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ft-calendar" style="font-size:27px;color:#7c3aed;"></i>
                  </div>
                  <div>
                    <span style="font-size:11px;color:#01124a;display:block;">Program Studi Terakreditasi</span>
                    <h5 class="font-weight-bold mb-0" style="color:#6d28d9;font-size:17px;" id="prodi-terakreditasi"></h5>
                    <br>
                    <span style="font-size:11px;color:#01124a;display:block;">Akan berakhir dalam &lt;= 12 bulan</span>
                    <h5 class="font-weight-bold mb-0" style="color:#ff780c;font-size:17px;" id="prodi-akan-berakhir"></h5>
                  </div>
                </div>

                <div class="mb-0">
                  <div class="d-flex justify-content-between mb-1">
                    <small style="font-size:11px;color:#01124a;">Persentase terakreditasi</small>
                    <small class="font-weight-bold persen-terakreditasi" style="font-size:11px;color:#f97316;"></small>
                  </div>
                  <!-- <div class="ppu-progress">
                    <div class="ppu-progress-bar" style="background:linear-gradient(90deg,#f97316,#fb923c);" id="progress-prodi"></div>
                  </div> -->
                  <div class="ppu-progress" style="height:10px;background:linear-gradient(90deg,#e2e8f0 0%,#f1f5f9 100%);border-radius:999px;overflow:hidden;">
                    <div id="progress-prodi"
                      class="ppu-progress-bar bg-success"
                      style="width:0%;height:100%;transition:all .5s ease;">
                    </div>
                  </div>
                </div>

                <div type="button" class="btn btn-outline-primary btn-block font-weight-bold" style="border-radius:10px;font-size:12px;" id="lihat-daftar-prodi" role="button" tabindex="0" aria-label="Lihat detail program studi">
                  Lihat Detail Akreditasi Prodi &nbsp;<i class="ft-arrow-right"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== ROW 2: TABEL + PANEL SAMPING ===== -->
        <div class="row">
          <!-- Tabel Indikator (Kiri) -->
          <div class="col-lg-8 mb-4">
            <div class="card ppu-card" style="height:auto;">
              <div class="card-body p-0">

                <!-- Card Header -->
                <div class="d-flex align-items-center justify-content-between px-2 py-2" style="border-bottom:1px solid #f1f5f9;">
                  <div>
                    <h6 class="font-weight-bold mb-0" style="color:#1e293b;font-size:13.5px;">Simulasi Pemenuhan Indikator Syarat Perlu Terakreditasi Unggul</h6>
                  </div>
                </div>

                <div class="mx-1 mt-1 mb-2 px-1 py-1" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;color:#334155;font-size:11px;">
                  <i class="ft-info mr-1"></i> Baris berwarna abu-abu belum dinamis.
                </div>

                <div class="table-responsive-prodi px-2 pb-0">
                  <table class="table ppu-table mb-0">
                    <thead>
                      <tr>
                        <th style="width:4%;">No.</th>
                        <th style="width:34%;">Indikator</th>
                        <th style="width:17%;">Status</th>
                        <th style="width:20%;">Capaian</th>
                        <th style="width:25%;">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Row 1 -->
                      <tr>
                        <td class="text-muted font-weight-bold">1</td>
                        <td style="color:#334155;font-weight:600;">SPMI yang dikembangkan oleh PT</td>
                        <td id="status-spmi"></td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td id="keterangan-spmi"></td>
                      </tr>
                      <!-- Row 2 -->
                      <tr>
                        <td class="text-muted font-weight-bold">2</td>
                        <td style="color:#334155;font-weight:600;">Implementasi PPEPP</td>
                        <td id="status-ppepp"></td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;" id="keterangan-ppepp"></td>
                      </tr>
                      <!-- Row 3 -->
                      <tr>
                        <td class="text-muted font-weight-bold">3</td>
                        <td style="color:#334155;font-weight:600;">Pengakuan Mutu Melalui Akreditasi Program Studi</td>
                        <td id="status-akreditasi-prodi"></td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" id="label-persen-akreditasi-prodi" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" id="bar-akreditasi-prodi" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;" id="keterangan-akreditasi-prodi"></td>
                      </tr>
                      <!-- Row 4 -->
                      <tr>
                        <td class="text-muted font-weight-bold">4</td>
                        <td style="color:#334155;font-weight:600;">Ketersediaan Dosen Berkualifikasi Doktor</td>
                        <td id="status-dosen-doktor"></td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" id="label-persen-dosen-doktor" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" id="bar-dosen-doktor" style="width:0%;">
                              </div>
                            </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;" id="keterangan-dosen-doktor">
                          <!-- 312 dari 433 dosen (72%). -->
                        </td>
                      </tr>
                      <!-- Row 5 -->
                      <tr>
                        <td class="text-muted font-weight-bold">5</td>
                        <td style="color:#334155;font-weight:600;">Ketersediaan Dosen Jenjang Lektor Kepala & Guru Besar</td>
                        <td id="status-jabatan-lk-atau-gb"></td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" id="label-persen-jabatan-lk-atau-gb" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar" id="bar-jabatan-lk-atau-gb" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;" id="keterangan-jabatan-lk-atau-gb"></td>
                      </tr>
                      <!-- Row 6 -->
                      <tr class="bg-light">
                        <td class="text-muted font-weight-bold">6</td>
                        <td style="color:#334155;font-weight:600;">Luaran Riset & Pengabdian Masyarakat (3 Tahun Terakhir)</td>
                        <td>
                          <!-- <span class="badge-belum">&#128711; Belum Terpenuhi</span> -->
                        </td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;">
                          <!-- Publikasi, HKI, dan PkM masih perlu ditingkatkan. -->
                        </td>
                      </tr>
                      <!-- Row 7 -->
                      <tr class="bg-light">
                        <td class="text-muted font-weight-bold">7</td>
                        <td style="color:#334155;font-weight:600;">Ketersediaan Diferensiasi Misi yang Jelas</td>
                        <td>
                          <!-- <span class="badge-terpenuhi">&#10003; Terpenuhi</span> -->
                        </td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;">
                          <!-- Visi, misi, dan strategi telah terdiferensiasi. -->
                        </td>
                      </tr>
                      <!-- Row 8 -->
                      <tr class="bg-light">
                        <td class="text-muted font-weight-bold">8</td>
                        <td style="color:#334155;font-weight:600;">Rekognisi Keunggulan Tridharma terkait Fokus Misi</td>
                        <td>
                          <!-- <span class="badge-perlu">&#9888; Perlu Peningkatan</span> -->
                        </td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;">
                          <!-- Rekognisi masih perlu ditingkatkan. -->
                        </td>
                      </tr>
                      <!-- Row 9 -->
                      <tr class="bg-light">
                        <td class="text-muted font-weight-bold">9</td>
                        <td style="color:#334155;font-weight:600;">Pelaksanaan Audit Keuangan</td>
                        <td>
                          <!-- <span class="badge-terpenuhi">&#10003; Terpenuhi</span> -->
                        </td>
                        <td>
                          <div class="d-flex align-items-center" style="gap:8px;">
                            <span class="font-weight-bold" style="min-width:50px;text-align:right;font-size:12px;">0%</span>
                            <div class="ppu-progress flex-grow-1">
                              <div class="ppu-progress-bar bg-success" style="width:0%;"></div>
                            </div>
                          </div>
                        </td>
                        <td style="color:#64748b;font-size:11px;">
                          <!-- Laporan audit keuangan tersedia dan sah. -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Legend -->
                <div class="px-4 pb-2 pt-0">
                  <div class="d-flex flex-wrap align-items-center pt-2" style="border-top:1px solid #f1f5f9;gap:16px;">
                    <div class="d-flex align-items-center" style="gap:6px;">
                      <span style="width:10px;height:10px;background:#10b981;display:inline-block;border-radius:3px;"></span>
                      <span style="font-size:10.5px;color:#64748b;">Terpenuhi (&ge; 70%)</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap:6px;">
                      <span style="width:10px;height:10px;background:#f97316;display:inline-block;border-radius:3px;"></span>
                      <span style="font-size:10.5px;color:#64748b;">Perlu Peningkatan (40%–69%)</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap:6px;">
                      <span style="width:10px;height:10px;background:#ef4444;display:inline-block;border-radius:3px;"></span>
                      <span style="font-size:10.5px;color:#64748b;">Belum Terpenuhi (&lt; 40%)</span>
                    </div>
                  </div>
                  <p style="font-size:11px;color:#94a3b8;margin-left:auto;margin-top:10px;">* Dan bersifat simulasi dan bukan merupakan hasil akreditasi resmi.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Panel Samping (Kanan) -->
          <div class="col-lg-4">
            <!-- Ringkasan Indikator -->
            <div class="card ppu-card mb-1" style="height:auto;">
              <div class="card-body p-2">
                <h6 class="font-weight-bold mb-1" style="color:#1e293b;font-size:13.5px;">Ringkasan Indikator</h6>
                <div class="d-flex" style="gap:10px;">
                  <div class="ppu-summary-box" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="font-weight-bold" style="font-size:26px;color:#15803d;line-height:1;" id="terpenuhi-count">0</div>
                    <small style="font-size:10.5px;color:#16a34a;font-weight:600;">Terpenuhi</small>
                  </div>
                  <div class="ppu-summary-box" style="background:#fff7ed;border:1px solid #fed7aa;">
                    <div class="font-weight-bold" style="font-size:26px;color:#ea580c;line-height:1;" id="perlu-peningkatan-count">0</div>
                    <small style="font-size:10.5px;color:#c2410c;font-weight:600;">Perlu Peningkatan</small>
                  </div>
                  <div class="ppu-summary-box" style="background:#fef2f2;border:1px solid #fecaca;">
                    <div class="font-weight-bold" style="font-size:26px;color:#b91c1c;line-height:1;" id="belum-terpenuhi-count">0</div>
                    <small style="font-size:10.5px;color:#dc2626;font-weight:600;">Belum Terpenuhi</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Rekomendasi -->
            <div class="card ppu-card mb-1" style="height:auto;">
              <div class="card-body p-2">
                <div class="alert alert-warning mb-2" role="alert" style="padding:10px 12px;border-radius:10px;border:1px solid #fcd34d;background:#fff7ed;color:#92400e;font-size:11.5px;line-height:1.5;">
                  Fitur rekomendasi tindak lanjut sedang dalam pengembangan.
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <h6 class="font-weight-bold mb-0" style="color:#1e293b;font-size:13.5px;">Rekomendasi Tindak Lanjut</h6>
                  <span style="background:#fff7ed;color:#ea580c;font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;">3 Aksi</span>
                </div>

                <div class="ppu-rekom-item">
                  <div class="ppu-rekom-icon" style="background:#e6f9f0;">
                    <i class="ft-user-check" style="color:#059669;"></i>
                  </div>
                  <small style="font-size:11.5px;color:#334155;line-height:1.5;">Tingkatkan jumlah dosen dengan jabatan <strong>Lektor Kepala</strong> dan <strong>Guru Besar</strong>.</small>
                </div>

                <div class="ppu-rekom-item">
                  <div class="ppu-rekom-icon" style="background:#eff4ff;">
                    <i class="ft-briefcase" style="color:#3b82f6;"></i>
                  </div>
                  <small style="font-size:11.5px;color:#334155;line-height:1.5;">Perkuat <strong>luaran riset</strong> dan pengabdian masyarakat berkualitas dan bereputasi.</small>
                </div>

                <div class="ppu-rekom-item" style="margin-bottom:0;">
                  <div class="ppu-rekom-icon" style="background:#fff4eb;">
                    <i class="ft-award" style="color:#f97316;"></i>
                  </div>
                  <small style="font-size:11.5px;color:#334155;line-height:1.5;">Tingkatkan <strong>rekognisi keunggulan tridharma</strong> melalui publikasi, penghargaan, dan kemitraan strategis.</small>
                </div>
              </div>
            </div>

            <!-- Keterangan Sumber Data -->
            <div class="card ppu-card" style="height:auto;background:linear-gradient(135deg,#eff6ff,#f0f9ff);">
              <div class="card-body p-2">
                <div class="d-flex align-items-start">
                  <div style="width:38px;height:38px;min-width:38px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-right:12px;">
                    <i class="ft-database" style="font-size:17px;color:#2563eb;"></i>
                  </div>
                  <div>
                    <h6 class="font-weight-bold mb-1" style="color:#1e40af;font-size:13px;">Sumber Data</h6>
                    <p class="mb-0" style="font-size:11px;color:#1e3a8a;line-height:1.5;">
                      Dashboard menggunakan data terintegrasi dari <strong>PDDikti</strong>, <strong>SISTER</strong>, <strong>BAN-PT</strong>, dan sumber lainnya per <strong>Mei 2026</strong>.
                    </p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div><!-- end ppu-wrap -->
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
    $('#kode-pt').select2({
      placeholder: "Pilih Perguruan Tinggi",
      width: '100%'
    });
  });

  // Load dashboard on page load
  $(function() {
    loadDashboard($('#kode-pt').val());
  });

  // Load dashboard data based on selected kode_pt
  function loadDashboard(kode_pt) {
    if (!kode_pt) {
      $('.main-content').addClass('d-none');
      $('.information-content').removeClass('d-none');
      return;
    }

    $.ajax({
      url: baseURL + 'admin/get-pantau-potensi-unggul',
      type: 'GET',
      data: {
        kode_pt: kode_pt
      },
      dataType: 'json',
      beforeSend: function() {
        // optional loading
      },
      success: function(res) {
        console.log(res);
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
        updateProgressAkreditasi(res.data_pt, res.tgl_mulai_akred, res.tgl_akhir_akred);
        $('#tgl-akhir-akred').text(res.tgl_akhir_akred);
        $('#prodi-terakreditasi').text(`${res.statistik.prodi_terakreditasi} dari ${res.data_prodi.length} Prodi`);
        $('#prodi-akan-berakhir').text(`${res.kategori_akreditasi.kurang_dari_6_bulan + res.kategori_akreditasi.antara_6_sampai_12_bulan} Prodi`);
        $('.persen-terakreditasi').text(`${res.indikator_penjaminan_mutu.akreditasi_prodi.persentase_prodi_terakreditasi_tampil}%`);
        const $bar = $('#progress-prodi');
        const targetWidth = parseFloat(String(res.indikator_penjaminan_mutu.akreditasi_prodi.persentase_prodi_terakreditasi_tampil).replace(',', '.'));

        $bar
          .removeClass('bg-success bg-info bg-warning bg-danger bg-primary bg-secondary')
          .css('background', 'linear-gradient(90deg,#f97316,#fb923c)')
          .css('width', '0%');

        setTimeout(function() {
          $bar.css('width', targetWidth + '%');
        }, 50);

        const teksSisaWaktu = getTeksSisaWaktuAkreditasi(res.data_pt.tgl_akhir_akred);
        $('#sisa-waktu-akred').html(teksSisaWaktu);

        // Update progress bar for SPMI
        $('#status-spmi').html(res.indikator_penjaminan_mutu.spmi.status);
        $('#keterangan-spmi').html(res.indikator_penjaminan_mutu.spmi.keterangan);
        // Update progress bar for PPEPP
        $('#status-ppepp').html(res.indikator_penjaminan_mutu.ppepp.status);
        $('#keterangan-ppepp').html(res.indikator_penjaminan_mutu.ppepp.keterangan);
        // Update progress bar for Akreditasi Prodi
        const persentaseAkreditasi = res.indikator_penjaminan_mutu.akreditasi_prodi.persentase_prodi_terakreditasi;
        const warnaAkreditasi = persentaseAkreditasi >= 70 ? {
            teks: '#059669',
            bar: 'linear-gradient(90deg,#059669,#10b981)'
          } :
          persentaseAkreditasi >= 40 ? {
            teks: '#f97316',
            bar: 'linear-gradient(90deg,#f97316,#fb923c)'
          } : {
            teks: '#dc2626',
            bar: 'linear-gradient(90deg,#ef4444,#f87171)'
          };

        $('#label-persen-akreditasi-prodi, #keterangan-akreditasi-prodi').css('color', warnaAkreditasi.teks);
        $('#bar-akreditasi-prodi').css('background', warnaAkreditasi.bar);
        $('#status-akreditasi-prodi').html(res.indikator_penjaminan_mutu.akreditasi_prodi.status);
        $('#label-persen-akreditasi-prodi').text(res.indikator_penjaminan_mutu.akreditasi_prodi.persentase_prodi_terakreditasi_tampil + '%');
        $('#bar-akreditasi-prodi').css('width', res.indikator_penjaminan_mutu.akreditasi_prodi.persentase_prodi_terakreditasi + '%');
        $('#keterangan-akreditasi-prodi').html(res.indikator_penjaminan_mutu.akreditasi_prodi.keterangan);

        const bentukPt = res.data_pt.bentuk_pt.toLowerCase();
        // Ketersediaan Dosen Berkualifikasi Doktor
        const batasDosenDoktor = {
          'universitas': 20,
          'institut': 20,
          'sekolah tinggi': 20,
          'akademi': 10,
          'politeknik': 10,
          'akademi komunitas': 10
        } [bentukPt];
        const persentaseDosenDoktor = res.indikator_penjaminan_mutu.dosen_doktor.persentase_dosen_doktor;

        if (batasDosenDoktor !== undefined) {
          const tercapai = persentaseDosenDoktor >= batasDosenDoktor;
          const warna = tercapai ? '#059669' : '#dc2626';
          const background = tercapai ?
            'linear-gradient(90deg,#059669,#10b981)' :
            'linear-gradient(90deg,#ef4444,#f87171)';

          $('#label-persen-dosen-doktor, #keterangan-dosen-doktor').css('color', warna);
          $('#bar-dosen-doktor').css('background', background);
        }

        $('#status-dosen-doktor').html(res.indikator_penjaminan_mutu.dosen_doktor.status);
        $('#label-persen-dosen-doktor').text(res.indikator_penjaminan_mutu.dosen_doktor.persentase_dosen_doktor_tampil + '%');
        $('#bar-dosen-doktor').css('width', res.indikator_penjaminan_mutu.dosen_doktor.persentase_dosen_doktor + '%');
        $('#keterangan-dosen-doktor').html(res.indikator_penjaminan_mutu.dosen_doktor.keterangan);

        // Update progress bar for jabatan-lk-atau-gb
        const batasJabatan = {
          'universitas': 10,
          'institut': 10,
          'sekolah tinggi': 10,
          'akademi': 7.5,
          'politeknik': 7.5,
          'akademi komunitas': 7.5
        } [bentukPt];
        const persentaseJabatan = res.indikator_penjaminan_mutu.jja_dosen_lk_atau_gb.persentase_jabatan_lk_atau_gb;

        if (batasJabatan !== undefined) {
          const tercapai = persentaseJabatan >= batasJabatan;
          const warna = tercapai ? '#059669' : '#dc2626';
          const background = tercapai ?
            'linear-gradient(90deg,#059669,#10b981)' :
            'linear-gradient(90deg,#ef4444,#f87171)';

          $('#label-persen-jabatan-lk-atau-gb, #keterangan-jabatan-lk-atau-gb').css('color', warna);
          $('#bar-jabatan-lk-atau-gb').css('background', background);
        }

        $('#status-jabatan-lk-atau-gb').html(res.indikator_penjaminan_mutu.jja_dosen_lk_atau_gb.status);
        $('#label-persen-jabatan-lk-atau-gb').text(res.indikator_penjaminan_mutu.jja_dosen_lk_atau_gb.persentase_jabatan_lk_atau_gb_tampil + '%');
        $('#bar-jabatan-lk-atau-gb').css('width', res.indikator_penjaminan_mutu.jja_dosen_lk_atau_gb.persentase_jabatan_lk_atau_gb + '%');
        $('#keterangan-jabatan-lk-atau-gb').html(res.indikator_penjaminan_mutu.jja_dosen_lk_atau_gb.keterangan);
    
        $('#terpenuhi-count').text(res.indikator_penjaminan_mutu.ringkasan_indikator.terpenuhi);
        $('#perlu-peningkatan-count').text(res.indikator_penjaminan_mutu.ringkasan_indikator.perlu_peningkatan);
        $('#belum-terpenuhi-count').text(res.indikator_penjaminan_mutu.ringkasan_indikator.belum_terpenuhi);
      }
    });
  }

  // Handle change event for kode-pt select
  $('#kode-pt').change(function() {
    const kodePt = $(this).val();

    $('body').stop(true, true).fadeTo(400, 0.5, function() {
      loadDashboard(kodePt);
      $(this).fadeTo(400, 1);
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
      const sisaTahun = Math.floor(sisaBulan / 12);
      const sisaBulanRemainder = sisaBulan % 12;
      teksSisaWaktu = `<span class='font-weight-bold font-medium-1'>${sisaTahun}</span> tahun <span class='font-weight-bold font-medium-1'>${sisaBulanRemainder}</span> bulan`;
      if (sisaBulan <= 12) {
        teksSisaWaktu = `<span class='text-danger'>${teksSisaWaktu}</span>`;
      }
    } else {
      const diffMs = hariIni - tglAkhirAkred;
      const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
      const lewatBulan = Math.ceil(diffDays / 30);
      const lewatTahun = Math.floor(lewatBulan / 12);
      const lewatBulanRemainder = lewatBulan % 12;
      teksSisaWaktu = `Lewat <span class='font-weight-bold font-medium-1'>${lewatTahun}</span> tahun <span class='font-weight-bold font-medium-1'>${lewatBulanRemainder}</span> bulan`;
      if (lewatBulan <= 12) {
        teksSisaWaktu = `<span class='text-danger'>${teksSisaWaktu}</span>`;
      }
    }

    return teksSisaWaktu;
  }

  // Update progress bar for accreditation based on start and end dates
  function updateProgressAkreditasi(dataPt, tglMulaiAkred, tglAkhirAkred) {
    if (!dataPt.tgl_mulai_akred || !dataPt.tgl_akhir_akred) {
      return;
    }
    const mulai = new Date(dataPt.tgl_mulai_akred);
    const akhir = new Date(dataPt.tgl_akhir_akred);
    const hariIni = new Date();
    // total masa akreditasi
    const totalHari = akhir - mulai;
    // hari yang sudah berjalan
    let hariBerjalan = hariIni - mulai;
    if (hariBerjalan < 0) hariBerjalan = 0;
    if (hariBerjalan > totalHari) hariBerjalan = totalHari;
    // persen progress
    let persen = (hariBerjalan / totalHari) * 100;
    if (!Number.isFinite(persen)) {
      persen = 0;
    }
    persen = persen.toFixed(1);

    // sisa hari
    const sisaHari = Math.ceil((akhir - hariIni) / (1000 * 60 * 60 * 24));
    const sisaBulan = sisaHari / 30;
    // warna progress berdasarkan sisa waktu
    let warna = 'bg-success';
    if (sisaBulan <= 6) {
      warna = 'bg-danger';
    } else if (sisaBulan <= 12) {
      warna = 'bg-warning';
    } else if (sisaBulan <= 24) {
      warna = 'bg-info';
    }
    const $bar = $('#progress-akreditasi-pt');
    $bar
      .removeClass('bg-success bg-info bg-warning bg-danger')
      .addClass(warna)
      .css('width', persen + '%');
    $('#persen-akred').text(persen + '%');
    $('#tgl-mulai-akred').text(tglMulaiAkred);
    $('#tgl-akhir-akred-bar').text(tglAkhirAkred);
  }

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