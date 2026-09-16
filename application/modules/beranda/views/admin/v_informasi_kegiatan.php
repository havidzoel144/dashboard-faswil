<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  /* ========================================================= GLOBAL ========================================================= */
  .content-body {
    color: #334155;
  }

  .dashboard-card,
  .benefit-card,
  .commit-card {
    border: 1px solid rgba(226, 232, 240, .8);
    box-shadow: 0 6px 20px rgba(15, 23, 42, .06);
  }

  /* ========================================================= HERO ========================================================= */
  .hero-banner {
    background: radial-gradient(circle at 85% 20%, rgba(255, 255, 255, .12), transparent 28%), radial-gradient(circle at 70% 100%, rgba(255, 255, 255, .08), transparent 30%), linear-gradient(135deg, #3730a3 0%, #312e81 45%, #1e1b4b 100%);
    border-radius: 20px;
    padding: 34px 40px;
    color: #fff;
    overflow: hidden;
    position: relative;
    min-height: 275px;
    box-shadow: 0 12px 30px rgba(49, 46, 129, .18);
  }

  .hero-banner::before {
    content: "";
    position: absolute;
    width: 240px;
    height: 240px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .04);
    top: -100px;
    right: 20%;
  }

  .hero-banner::after {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .035);
    bottom: -100px;
    left: 30%;
  }

  .hero-banner .row {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    color: #fff;
    font-size: 42px;
    font-weight: 800;
    line-height: 1.12;
    letter-spacing: -.8px;
    margin: 12px 0 12px;
  }

  .hero-text {
    font-size: 15px;
    line-height: 1.7;
    max-width: 600px;
    color: rgba(255, 255, 255, .88);
    margin-bottom: 10px;
  }

  .hero-banner .badge {
    padding: 7px 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .4px;
    border-radius: 8px;
    text-transform: uppercase;
  }

  .hero-image {
    max-height: 235px;
    object-fit: contain;
    filter: drop-shadow(0 12px 20px rgba(0, 0, 0, .15));
  }

  .hero-dot {
    margin-top: 18px;
  }

  .hero-dot span {
    width: 7px;
    height: 7px;
    background: #fff;
    opacity: .35;
    display: inline-block;
    border-radius: 50%;
    margin-right: 6px;
    transition: .2s;
  }

  .hero-dot .active {
    width: 22px;
    border-radius: 10px;
    opacity: 1;
  }

  /* ========================================================= CARD ========================================================= */
  .dashboard-card {
    background: #fff;
    border-radius: 18px;
    padding: 18px;
    height: 100%;
  }

  .card-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 13px;
    border-bottom: 1px solid #f1f5f9;
  }

  .card-header-custom>div {
    min-width: 0;
  }

  .card-header-custom h4 {
    margin: 0;
    color: #172554 !important;
    font-size: 16px;
    font-weight: 700 !important;
    line-height: 1.3;
  }

  .card-header-custom>a {
    color: #4f46e5;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    text-decoration: none;
  }

  .card-header-custom>a:hover {
    color: #312e81;
    text-decoration: underline;
  }

  .header-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f46e5, #3730a3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    padding: 0;
    box-shadow: 0 5px 12px rgba(79, 70, 229, .18);
  }

  .header-icon i {
    font-size: 18px;
  }

  /* ========================================================= JADWAL ========================================================= */
  .schedule-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    border: 1px solid #edf0f5;
    padding: 9px;
    border-radius: 13px;
    background: #fff;
    transition: all .2s ease;
  }

  .schedule-item:hover {
    border-color: #dbe3f0;
    box-shadow: 0 5px 15px rgba(15, 23, 42, .05);
    transform: translateY(-1px);
  }

  .schedule-date {
    width: 54px;
    min-width: 54px;
    height: 54px;
    border-radius: 12px;
    text-align: center;
    margin-right: 11px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .schedule-date h2 {
    margin: 0;
    font-weight: 800;
    font-size: 21px;
    line-height: 1;
  }

  .schedule-date span {
    font-size: 10px;
    margin-top: 4px;
    text-transform: uppercase;
  }

  .schedule-content {
    flex: 1;
    min-width: 0;
    line-height: 1.35;
  }

  .schedule-content h6 {
    font-size: 9px;
    font-weight: 800 !important;
    letter-spacing: .6px;
    margin-bottom: 3px;
  }

  .schedule-content h5 {
    color: #172554 !important;
    font-size: 12px;
    font-weight: 600 !important;
    line-height: 1.35;
    margin-bottom: 5px;
    display: -webkit-box;
    /* -webkit-line-clamp: 2; */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .schedule-content p {
    color: #64748b;
    font-size: 10px;
    line-height: 1.6;
  }

  .schedule-content p i {
    width: 14px;
    color: #94a3b8;
  }

  .schedule-event {
    display: flex;
    width: auto;
    min-width: 72px;
    max-width: 90px;
    flex-shrink: 0;
    border-radius: 8px;
    text-align: center;
    padding: 6px 7px;
  }

  .schedule-event span {
    font-size: 9px;
    font-weight: 700 !important;
    line-height: 1.2;
  }

  .schedule-info {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 12px;
    border-radius: 10px;
    color: #6d28d9;
    margin-top: 10px;
  }

  .schedule-info i {
    font-size: 21px !important;
    flex-shrink: 0;
  }

  .schedule-info p {
    color: #6b21a8;
    font-size: 10px;
    line-height: 1.5;
  }

  .schedule-link {
    display: block;
    color: inherit;
    text-decoration: none !important;
  }

  .schedule-link:hover {
    color: inherit;
    text-decoration: none !important;
  }

  .schedule-link .schedule-item {
    cursor: pointer;
  }

  .card-footer-custom .btn {
    margin-top: 7px;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    padding: 9px 12px;
  }

  /* ========================================================= KEGIATAN MENDATANG ========================================================= */
  .activity {
    display: flex;
    align-items: center;
    margin-bottom: 13px;
    padding-bottom: 13px;
    border-bottom: 1px solid #f1f5f9;
  }

  .activity:last-child {
    margin-bottom: 0;
    border-bottom: 0;
  }

  .activity-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 11px;
    background: #eef2ff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4f46e5;
    margin-right: 10px;
  }

  .activity-icon i {
    font-size: 16px;
  }

  .activity h6 {
    color: #1e293b;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.35;
    margin-bottom: 3px;
  }

  .activity small {
    color: #94a3b8;
    font-size: 9px;
  }

  /* ========================================================= FLYER ========================================================= */
  #flyerUnggulanCarousel {
    width: 100%;
    min-height: 320px;
  }

  #flyerUnggulanCarousel .carousel-inner {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
  }

  #flyerUnggulanCarousel .carousel-item img {
    width: 100%;
    height: 320px;
    object-fit: contain;
    background: #f8fafc;
  }

  #flyerUnggulanCarousel .carousel-control-prev,
  #flyerUnggulanCarousel .carousel-control-next {
    width: 34px;
    height: 34px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(15, 23, 42, .55);
    border-radius: 50%;
    opacity: .8;
  }

  #flyerUnggulanCarousel .carousel-control-prev {
    left: 10px;
  }

  #flyerUnggulanCarousel .carousel-control-next {
    right: 10px;
  }

  #flyerUnggulanCarousel .carousel-indicators {
    bottom: -10px;
  }

  /* ========================================================= BENEFIT ========================================================= */
  .benefit-card {
    background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
    border-radius: 18px;
    padding: 22px;
    height: 100%;
  }

  .benefit-card h3 {
    color: #172554;
    font-size: 20px;
    font-weight: 750;
    margin-bottom: 10px;
  }

  .benefit-card ul {
    padding-left: 18px;
    margin-bottom: 15px;
  }

  .benefit-card li {
    color: #475569;
    font-size: 11px;
    line-height: 1.8;
  }

  .benefit-card .benefit-icon {
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #4f46e5;
    color: #fff;
    border-radius: 50%;
    margin: auto;
    font-size: 23px;
  }

  .benefit-card .btn {
    background: #4f46e5 !important;
    border: 0;
    border-radius: 9px;
    padding: 9px 13px;
    font-size: 10px;
    font-weight: 600;
    box-shadow: 0 5px 12px rgba(79, 70, 229, .15);
  }

  /* ========================================================= KOMITMEN ========================================================= */
  .commit-card {
    background: linear-gradient(135deg, #fffaf0 0%, #fff7e8 100%);
    border-radius: 18px;
    padding: 22px;
    height: 100%;
    display: flex;
    align-items: center !important;
  }

  .commit-card>i {
    font-size: 28px !important;
    margin-right: 12px;
    flex-shrink: 0;
  }

  .commit-card h4 {
    color: #78350f;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 7px;
  }

  .commit-card p {
    color: #92400e;
    font-size: 12px;
    line-height: 1.65;
    margin-bottom: 10px;
  }

  .commit-card .btn {
    padding: 0;
    font-size: 10px;
    font-weight: 600;
    white-space: wrap;
  }

  /* ========================================================= RESPONSIVE ========================================================= */
  @media (max-width: 1199px) {
    .hero-title {
      font-size: 36px;
    }

    .schedule-event {
      display: none;
    }

    #flyerUnggulanCarousel,
    #flyerUnggulanCarousel .carousel-item img {
      min-height: 280px;
      height: 280px;
    }
  }

  @media (max-width: 991px) {
    .hero-banner {
      padding: 28px;
    }

    .hero-title {
      font-size: 34px;
    }

    .hero-image {
      max-height: 200px;
      margin-top: 20px;
    }

    .dashboard-card {
      margin-bottom: 15px;
    }

    .benefit-card,
    .commit-card {
      margin-bottom: 15px;
    }
  }

  @media (max-width: 575px) {
    .hero-banner {
      padding: 22px;
      border-radius: 15px;
    }

    .hero-title {
      font-size: 29px;
    }

    .hero-text {
      font-size: 13px;
    }

    .schedule-item {
      padding: 8px;
    }

    .schedule-date {
      width: 48px;
      min-width: 48px;
      height: 48px;
    }

    .schedule-date h2 {
      font-size: 18px;
    }

    .schedule-content h5 {
      font-size: 11px;
    }

    .card-header-custom h4 {
      font-size: 14px;
    }

    #flyerUnggulanCarousel,
    #flyerUnggulanCarousel .carousel-item img {
      min-height: 240px;
      height: 240px;
    }
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

      <!-- HERO -->
      <div class="hero-banner mb-2">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <span class="badge badge-light mb-1">
              Informasi Terbaru
            </span>
            <h1 class="hero-title">
              Kegiatan <br>Penjaminan Mutu
            </h1>
            <p class="hero-text">
              Dapatkan informasi terbaru seputar pembinaan, pelatihan, pendampingan dan kegiatan strategis untuk peningkatan mutu pendidikan tinggi.
            </p>
            <div class="hero-dot">
              <span class="active"></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <div class="col-lg-6 text-center">
            <!-- <img src="<?= base_url('assets/images/dashboard/banner.png') ?>" class="img-fluid hero-image"> -->
          </div>
        </div>
      </div>

      <!-- CARD -->
      <div class="row">
        <!-- Jadwal -->
        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="card-header-custom">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div class="header-icon">
                  <i class="ft-calendar"></i>
                </div>
                <h4 style="color: #000d97b1; font-weight: 700;">Jadwal Pembinaan</h4>
              </div>
              <a href="<?= base_url('admin/kegiatan') ?>">Lihat Semua</a>
            </div>
            <?php foreach ($kegiatan as $data): ?>
              <a href="<?= base_url('admin/kelola-kegiatan/detail/' . safe_url_encrypt($data->id)) ?>" class="schedule-link">
                <div class="schedule-item">
                  <div class="schedule-date" style="background: <?= $data->warna_label ?>10;">
                    <h2 style="color: <?= $data->warna_label ?>; font-weight: 800;"><?= date('d', strtotime($data->tanggal_mulai)) ?></h2>
                    <span style="color: <?= $data->warna_label ?>; font-weight: 600;"><?= date('M', strtotime($data->tanggal_mulai)) ?></span>
                  </div>
                  <div class="schedule-content">
                    <h6 style="color: <?= $data->warna_label ?>; font-weight: bold;"><?= strtoupper($data->kategori) ?></h6>
                    <h5 style="color: rgba(0, 4, 120, 0.84); font-weight: 500;"><?= $data->judul ?></h5>
                    <p class="mb-0"><i class="ft-clock"></i> <?= date('H:i', strtotime($data->jam_mulai)) ?> - <?= date('H:i', strtotime($data->jam_selesai)) ?> WIB</p>
                    <p class="mb-0"><i class="ft-map-pin"></i> <?= $data->metode . ' (' . $data->lokasi . ')' ?></p>
                  </div>
                  <div class="schedule-event" style="background: <?= $data->warna_label ?>10;">
                    <span style="color: <?= $data->warna_label ?>; font-weight: 600;"><?= $data->status ?></span>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
            <div class="card-footer-custom">
              <div class="schedule-info mb-1" style="background: #f1e8ff;">
                <i class="la la-lightbulb-o" style="font-size: 2.5rem;"></i>
                <p class="mb-0">Jadwal dapat berubah sewaktu-waktu. Pantau informasi terbaru secara berkala.</p>
              </div>
              <?php if ($this->session->userdata('username') == 'admin-develop') : ?>
                <a href="<?= base_url('admin/kelola-kegiatan') ?>" class="btn btn-primary w-100">
                  <i class="la la-edit"></i> Kelola Kegiatan
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <!-- kegiatan -->
        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="card-header-custom">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div class="header-icon">
                  <i class="ft-activity"></i>
                </div>
                <h4 style="color: #000d97b1; font-weight: 700;">Kegiatan Mendatang</h4>
              </div>
              <a href="javascript:void(0)" class="text-center">Lihat Semua</a>
            </div>
            <?php if (false) : ?>
              <?php foreach ($kegiatan as $item): ?>
                <div class="activity">
                  <div class="activity-icon">
                    <i class="ft-calendar"></i>
                  </div>
                  <div>
                    <h6><?= htmlspecialchars($item->judul) ?></h6>
                    <small>
                      <?= date('d M Y', strtotime($item->tanggal_mulai)) ?>
                      •
                      <?= htmlspecialchars($item->metode) ?>
                    </small>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
            <div class="text-center d-flex align-items-center h-100"">
              Mohon maaf, fitur ini masih dalam tahap pengembangan dan akan segera hadir.
            </div>
          </div>
        </div>
        <!-- flyer -->
        <div class=" col-lg-4">
              <div class="dashboard-card">
                <div class="card-header-custom">
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="header-icon">
                      <i class="ft-calendar"></i>
                    </div>
                    <h4 style="color: #000d97b1; font-weight: 700;">Flyer Kegiatan Unggulan</h4>
                  </div>
                  <a href="javascript:void(0)" class="text-center">Lihat Semua</a>
                </div>
                <?php
                $kegiatan_unggulan = array_filter($kegiatan, function ($item) {
                  return isset($item->unggulan) && (int)$item->unggulan === 1;
                });
                ?>

                <?php if (!empty($kegiatan_unggulan)): ?>
                  <div id="flyerUnggulanCarousel" class="carousel slide d-flex align-items-center justify-content-center" data-ride="carousel">
                    <div class="carousel-inner rounded">
                      <?php $is_first = true; ?>
                      <?php foreach ($kegiatan_unggulan as $item): ?>
                        <?php
                        $flyer_filename = $item->flyer;
                        ?>
                        <div class="carousel-item <?= $is_first ? 'active' : '' ?>">
                          <img src="<?= base_url() . 'uploads/flyer/' . $flyer_filename ?>" class="d-block w-100 img-fluid" alt="<?= !empty($item->judul) ? $item->judul : 'Flyer Kegiatan Unggulan' ?>" style="border-radius: 12px; max-height: 100%; cursor: pointer;">
                        </div>
                        <?php $is_first = false; ?>
                      <?php endforeach; ?>
                    </div>
                    <?php if (count($kegiatan_unggulan) > 1): ?>
                      <a class="carousel-control-prev" href="#flyerUnggulanCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#flyerUnggulanCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php else: ?>
                  <div class="text-center d-flex align-items-center justify-content-center h-100">
                    <h1>Belum ada flyer kegiatan unggulan.</h1>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class=" row mt-2 match-height" style="margin-bottom: 70px;">
            <div class="col-lg-7">
              <div class="benefit-card">
                <div class="row align-items-center">
                  <div class="col-md-1 text-center d-flex align-items-center justify-content-center" style="font-size: 2.5rem; color: #ffffff; background-color: #3c32dd; border-radius: 50%; width: 70px; height: 70px; margin: 0 auto;">
                    <i class="fa fa-handshake-o"></i>
                  </div>
                  <div class="col-md-7">
                    <h3>Terhubung & Dapatkan Manfaatnya</h3>
                    <ul>
                      <li>Tingkatkan kapasitas dan kompetensi SDM perguruan tinggi</li>
                      <li>Perkuat sistem penjaminan mutu secara berkelanjutan</li>
                      <li>Dapatkan pendampingan langsung dari LLDIKTI III</li>
                    </ul>
                    <button class="btn btn-primary d-inline-flex align-items-center justify-content-center w-100" style="background-color: #3c32dd !important; border-radius: 10px; color: white; font-weight: 600; gap: 8px; line-height: 1.2;">
                      <span>Ikuti dan Sukseskan Kegiatan Bersama Kami</span><i class="la la-arrow-right" style="line-height: 1;"></i>
                    </button>
                  </div>
                  <div class="col-md-4 text-center">
                    <img
                      src="<?= base_url('assets/img/benefit.svg') ?>"
                      class="img-fluid" style="max-height:170px;">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="commit-card d-flex align-items-center gap-3">
                <i class="la la-lightbulb-o" style="font-size: 2.5rem; color: #ffb743;"></i>
                <div>
                  <h4>Komitmen Kami</h4>
                  <p>
                    LLDIKTI Wilayah III berkomitmen untuk terus mendampingi perguruan tinggi dalam mewujudkan budaya mutu yang unggul dan berkelanjutan.
                  </p>
                </div>
                <button class="btn d-flex align-items-center gap-2" style="background-color: transparent !important; border-radius: 10px; color: #3c32dd; font-weight: 600; min-width: 110px; margin-left: 25px;">
                  <div class="text-left">
                    <span>Tentang Penjaminan Mutu </span>
                  </div>
                  <i class="la la-arrow-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?= $this->load->view('admin/v_footer') ?>

    <script type="text/javascript">
      $(document).ready(function() {
        $("img").click(function() {
          this.requestFullscreen()
        })
      });
    </script>