<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  /* =====================================================
  DETAIL KEGIATAN
  ===================================================== */
  .event-detail-wrapper {
    padding-bottom: 70px;
  }

  .event-breadcrumb {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 15px;
    font-size: 12px;
    color: #94a3b8;
  }

  .event-breadcrumb a {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 600;
  }

  .event-breadcrumb i {
    font-size: 12px;
  }

  /* =====================================================
  HERO DETAIL
  ===================================================== */
  .event-hero {
    position: relative;
    overflow: hidden;
    background:
      radial-gradient(circle at 90% 20%,
        rgba(255, 255, 255, .12),
        transparent 25%),
      linear-gradient(135deg,
        #3730a3 0%,
        #312e81 50%,
        #1e1b4b 100%);
    border-radius: 20px;
    padding: 30px 35px;
    color: #fff;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(49, 46, 129, .16);
  }

  .event-hero::before {
    content: "";
    position: absolute;
    width: 230px;
    height: 230px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .035);
    right: -80px;
    top: -100px;
  }

  .event-hero-content {
    position: relative;
    z-index: 2;
  }

  .event-category {
    display: inline-flex;
    align-items: center;
    padding: 6px 11px;
    border-radius: 7px;
    background: rgba(255, 255, 255, .14);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 10px;
  }

  .event-title {
    color: #fff;
    font-size: 30px;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -.4px;
    margin-bottom: 12px;
  }

  .event-description {
    color: rgba(255, 255, 255, .84);
    font-size: 13px;
    line-height: 1.7;
    max-width: 850px;
    margin-bottom: 0;
  }

  /* =====================================================
  MAIN CARD
  ===================================================== */
  .event-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 18px;
    box-shadow: 0 7px 22px rgba(15, 23, 42, .055);
    overflow: hidden;
    margin-bottom: 18px;
  }

  .event-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .event-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #eef2ff;
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .event-card-icon i {
    font-size: 17px;
  }

  .event-card-header h4 {
    margin: 0;
    color: #172554;
    font-size: 15px;
    font-weight: 700;
  }

  .event-card-body {
    padding: 20px;
  }

  /* =====================================================
  FLYER
  ===================================================== */
  .event-flyer-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 18px;
    padding: 14px;
    box-shadow: 0 7px 22px rgba(15, 23, 42, .055);
    position: sticky;
    top: 20px;
  }

  .event-flyer {
    width: 100%;
    border-radius: 12px;
    display: block;
    background: #f8fafc;
    cursor: zoom-in;
  }

  .event-no-flyer {
    height: 400px;
    border-radius: 12px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    text-align: center;
  }

  .event-no-flyer i {
    font-size: 55px;
    margin-bottom: 12px;
  }

  .event-no-flyer span {
    font-size: 12px;
  }

  /* =====================================================
  STATUS
  ===================================================== */
  .event-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 7px;
    font-size: 10px;
    font-weight: 700;
    background: <?= !empty($kegiatan->warna_label) ? $kegiatan->warna_label : '#4f46e5' ?>15;
    color: <?= !empty($kegiatan->warna_label) ? $kegiatan->warna_label : '#4f46e5' ?>;
  }

  .event-status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
  }

  /* =====================================================
  INFO GRID
  ===================================================== */
  .event-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }

  .event-info-item {
    border: 1px solid #edf0f5;
    background: #fafbfc;
    border-radius: 11px;
    padding: 13px;
  }

  .event-info-label {
    color: #94a3b8;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 5px;
  }

  .event-info-value {
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.45;
  }

  .event-info-value i {
    color: #6366f1;
    margin-right: 4px;
  }

  /* =====================================================
  DESCRIPTION
  ===================================================== */
  .event-description-content {
    color: #475569;
    font-size: 13px;
    line-height: 1.8;
  }

  .event-description-content p:last-child {
    margin-bottom: 0;
  }

  /* =====================================================
  ACTION
  ===================================================== */
  .event-action {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .event-action .btn {
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    padding: 9px 14px;
  }

  .btn-event-primary {
    background: #4f46e5 !important;
    border-color: #4f46e5 !important;
    color: #fff !important;
  }

  .btn-event-secondary {
    background: #eef2ff !important;
    border-color: #eef2ff !important;
    color: #4338ca !important;
  }

  /* =====================================================
  MATERI
  ===================================================== */
  .materi-box {
    background: #f8f7ff;
    border: 1px solid #e8e5ff;
    border-radius: 12px;
    padding: 14px;
    color: #475569;
    font-size: 12px;
    line-height: 1.7;
  }

  /* =====================================================
  RESPONSIVE
  ===================================================== */
  @media (max-width: 991px) {
    .event-flyer-card {
      position: static;
      margin-bottom: 18px;
    }

    .event-title {
      font-size: 25px;
    }

    .event-hero {
      padding: 25px;
    }
  }

  @media (max-width: 575px) {
    .event-info-grid {
      grid-template-columns: 1fr;
    }

    .event-title {
      font-size: 22px;
    }

    .event-description {
      font-size: 12px;
    }

    .event-hero {
      border-radius: 15px;
      padding: 20px;
    }
  }
</style>

<!-- =====================================================
CONTENT
===================================================== -->
<div class="app-content content center-layout">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body event-detail-wrapper">
      <!-- BREADCRUMB -->
      <div class="event-breadcrumb">
        <a href="<?= base_url('admin/dashboard') ?>">
          <i class="la la-home"></i> Dashboard
        </a>
        <i class="la la-angle-right"></i>
        <a href="<?= base_url('admin/informasi-kegiatan') ?>">Kegiatan</a>
        <i class="la la-angle-right"></i>
        <span>Detail</span>
      </div>

      <!-- HERO -->
      <div class="event-hero">
        <div class="event-hero-content">
          <div class="event-category">
            <i class="la la-tag mr-1"></i>
            <?= htmlspecialchars($kegiatan->kategori) ?>
          </div>
          <h1 class="event-title">
            <?= htmlspecialchars($kegiatan->judul) ?>
          </h1>
          <?php if (!empty($kegiatan->deskripsi)): ?>
            <p class="event-description">
              <?= htmlspecialchars($kegiatan->deskripsi) ?>
            </p>
          <?php endif; ?>
        </div>
      </div>

      <!-- MAIN -->
      <div class="row">
        <!-- =========================================
        FLYER
        ========================================== -->
        <div class="col-lg-4">
          <div class="event-flyer-card">
            <?php if (!empty($kegiatan->flyer)): ?>
              <img src="<?= base_url('uploads/flyer/' . $kegiatan->flyer) ?>" alt="<?= htmlspecialchars($kegiatan->judul) ?>" class="event-flyer" onclick="this.requestFullscreen()">
            <?php else: ?>
              <div class="event-no-flyer">
                <i class="la la-image"></i>
                <span>
                  Flyer kegiatan belum tersedia
                </span>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- =========================================
        INFORMATION
        ========================================== -->
        <div class="col-lg-8">
          <!-- STATUS -->
          <div class="event-card">
            <div class="event-card-body">
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <div class="event-info-label">
                    Status Kegiatan
                  </div>
                  <div class="event-status">
                    <span class="event-status-dot"></span>
                    <?= htmlspecialchars($kegiatan->status) ?>
                  </div>
                </div>
                <?php if ((int)$kegiatan->unggulan === 1): ?>
                  <span class="event-status" style="background:#fff7ed;color:#ea580c;">
                    <i class="la la-star"></i>
                    Kegiatan Unggulan
                  </span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- WAKTU & LOKASI -->
          <div class="event-card">
            <div class="event-card-header">
              <div class="event-card-icon">
                <i class="la la-calendar"></i>
              </div>
              <h4>Waktu & Tempat</h4>
            </div>
            <div class="event-card-body">
              <div class="event-info-grid">
                <div class="event-info-item">
                  <div class="event-info-label">
                    Tanggal
                  </div>
                  <div class="event-info-value">
                    <i class="la la-calendar"></i>
                    <?= date('d F Y', strtotime($kegiatan->tanggal_mulai)) ?>
                  </div>
                </div>
                <div class="event-info-item">
                  <div class="event-info-label">
                    Waktu
                  </div>
                  <div class="event-info-value">
                    <i class="la la-clock-o"></i>
                    <?= date('H:i', strtotime($kegiatan->jam_mulai)) ?>
                    -
                    <?= date('H:i', strtotime($kegiatan->jam_selesai)) ?>
                    <?= !empty($kegiatan->zona_waktu) ? $kegiatan->zona_waktu : 'WIB' ?>
                  </div>
                </div>
                <div class="event-info-item">
                  <div class="event-info-label">
                    Metode
                  </div>
                  <div class="event-info-value">
                    <i class="la la-laptop"></i>
                    <?= htmlspecialchars($kegiatan->metode) ?>
                  </div>
                </div>
                <div class="event-info-item">
                  <div class="event-info-label">Lokasi</div>
                  <div class="event-info-value">
                    <i class="la la-map-marker"></i>
                    <?= !empty($kegiatan->lokasi) ? htmlspecialchars($kegiatan->lokasi) : 'Belum ditentukan' ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- DESKRIPSI -->
          <div class="event-card">
            <div class="event-card-header">
              <div class="event-card-icon">
                <i class="la la-file-text-o"></i>
              </div>
              <h4>Deskripsi Kegiatan</h4>
            </div>
            <div class="event-card-body">
              <div class="event-description-content">
                <?php if (!empty($kegiatan->deskripsi)): ?>
                  <?= nl2br(htmlspecialchars($kegiatan->deskripsi)) ?>
                <?php else: ?>
                  <span class="text-muted">
                    Deskripsi kegiatan belum tersedia.
                  </span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- MATERI -->
          <?php if (!empty($kegiatan->materi)): ?>
            <div class="event-card">
              <div class="event-card-header">
                <div class="event-card-icon">
                  <i class="la la-book"></i>
                </div>
                <h4>Materi Kegiatan</h4>
              </div>
              <div class="event-card-body">
                <div class="materi-box">
                  <?= nl2br(htmlspecialchars($kegiatan->materi)) ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- ACTION -->
          <?php
          $hasMeeting = !empty($kegiatan->link_meeting);
          $hasPendaftaran = !empty($kegiatan->link_pendaftaran);
          ?>

          <?php if ($hasMeeting || $hasPendaftaran): ?>
            <div class="event-card">
              <div class="event-card-body">
                <div class="event-action">
                  <?php if ($hasPendaftaran): ?>
                    <a href="<?= htmlspecialchars($kegiatan->link_pendaftaran) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-event-primary">
                      <i class="la la-edit"></i> Daftar Sekarang
                    </a>
                  <?php endif; ?>

                  <?php if ($hasMeeting): ?>
                    <a href="<?= htmlspecialchars($kegiatan->link_meeting) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-event-secondary">
                      <i class="la la-video-camera"></i> Bergabung ke Meeting
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- BACK -->
          <div>
            <a href="<?= base_url('admin/informasi-kegiatan') ?>" class="btn btn-dark" style="border-radius:9px; font-size:11px; font-weight:600;">
              <i class="la la-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->load->view('admin/v_footer') ?>

<script>
  $(document).ready(function() {
    $('.event-flyer').on('click', function() {
      if (this.requestFullscreen) {
        this.requestFullscreen();
      }
    });
  });
</script>