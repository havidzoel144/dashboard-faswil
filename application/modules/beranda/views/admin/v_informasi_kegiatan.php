<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  .hero-banner {
    background: linear-gradient(135deg, #3326d8, #1d0ea3);
    border-radius: 20px;
    padding: 40px;
    color: white;
    overflow: hidden;
    position: relative;
  }

  .hero-title {
    color: #fff;
    font-size: 50px;
    font-weight: 700;
    line-height: 1.1;
  }

  .hero-text {
    font-size: 18px;
    opacity: .9;
  }

  .hero-image {
    max-height: 260px;
  }

  .hero-dot {
    margin-top: 25px;
  }

  .hero-dot span {
    width: 10px;
    height: 10px;
    background: #fff;
    opacity: .4;
    display: inline-block;
    border-radius: 50%;
    margin-right: 8px;
  }

  .hero-dot .active {
    opacity: 1;
  }

  .dashboard-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
    padding: 20px;
    height: 100%;
  }

  .card-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .header-icon {
    border-radius: 10px;
    background: #3c32dd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    padding: 10px;
  }

  .header-icon i {
    font-size: 24px;
  }

  .schedule-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
    border: 1px solid #E5E5E5;
    padding: 10px;
    border-radius: 15px;
  }

  .schedule-date {
    width: 60px;
    height: 60px;
    background: #F5F6FD;
    border-radius: 15px;
    text-align: center;
    margin-right: 15px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .schedule-date h2 {
    margin: 0;
    color: #3c32dd;
    font-weight: bold;
    font-size: 1.6rem;
  }

  .schedule-content {
    flex: 1;
    line-height: 1.4;
  }

  .schedule-event {
    width: 120px;
    flex-shrink: 0;
    border-radius: 10px;
    text-align: center;
    padding: 10px;
  }

  .schedule-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    border-radius: 12px;
    color: #6200ff
  }

  .activity {
    display: flex;
    align-items: center;
    margin-bottom: 18px;
  }

  .activity-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #EEF2FF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3c32dd;
    margin-right: 15px;
  }

  .benefit-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
    padding: 25px;
    background-color: #f1f0ff;
  }

  .commit-card {
    background: #FFF8ED;
    border-radius: 18px;
    padding: 25px;
    height: 100%;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
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
              Kegiatan<br>
              Penjaminan Mutu
            </h1>
            <p class="hero-text">
              Dapatkan informasi terbaru seputar pembinaan,
              pelatihan, pendampingan dan kegiatan strategis
              untuk peningkatan mutu pendidikan tinggi.
            </p>
            <div class="hero-dot">
              <span class="active"></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <div class="col-lg-6 text-center">
            <img
              src="<?= base_url('assets/images/dashboard/banner.png') ?>"
              class="img-fluid hero-image">
          </div>
        </div>
      </div>

      <!-- CARD -->
      <div class="row">
        <!-- Jadwal -->
        <div class="col-lg-5">
          <div class="dashboard-card">
            <div class="card-header-custom">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div class="header-icon">
                  <i class="ft-calendar"></i>
                </div>
                <h4 style="color: #000d97b1; font-weight: 700;">Jadwal Pembinaan</h4>
              </div>
              <a href="javascript:void(0)">Lihat Semua</a>
            </div>
            <?php foreach ($kegiatan as $data): ?>
              <div class="schedule-item">
                <div class="schedule-date" style="background: <?= $data->warna_label ?>10;">
                  <h2 style="color: <?= $data->warna_label ?>; font-weight: 800;"><?= date('d', strtotime($data->tanggal_mulai)) ?></h2>
                  <span style="color: <?= $data->warna_label ?>; font-weight: 600;"><?= date('M', strtotime($data->tanggal_mulai)) ?></span>
                </div>
                <div class="schedule-content">
                  <h6 style="color: <?= $data->warna_label ?>; font-weight: bold;"><?= strtoupper($data->kategori) ?></h6>
                  <h5 style="color: rgba(0, 4, 120, 0.84); font-weight: 500;"><?= $data->judul ?></h5>
                  <p class="mb-0"><i class="ft-clock"></i> <?= date('H:i', strtotime($data->jam_mulai)) ?> - <?= date('H:i', strtotime($data->jam_selesai)) ?> WIB</p>
                  <p class="mb-0"><i class="ft-map-pin"></i> <?= $data->lokasi ?></p>
                </div>
                <div class="schedule-event" style="background: <?= $data->warna_label ?>10;">
                  <span style="color: <?= $data->warna_label ?>; font-weight: 600;"><?= $data->status ?></span>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="card-footer-custom">
              <div class="schedule-info mb-1" style="background: #f1e8ff;">
                <i class="la la-lightbulb-o" style="font-size: 2.5rem;"></i>
                <p class="mb-0">Jadwal dapat berubah sewaktu-waktu. Pantau informasi terbaru secara berkala.</p>
              </div>
              <a href="<?= base_url('admin/kelola-kegiatan') ?>" class="btn btn-primary w-100">
                <i class="la la-edit"></i> Kelola Kegiatan
              </a>
            </div>
          </div>
        </div>
        <!-- kegiatan -->
        <div class="col-lg-3">
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
            <?php for ($i = 0; $i < 5; $i++): ?>
              <div class="activity">
                <div class="activity-icon">
                  <i class="ft-calendar"></i>
                </div>
                <div>
                  <h6>Sosialisasi Instrumen Akreditasi</h6>
                  <small>25 Mei 2025 • Daring</small>
                </div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
        <!-- flyer -->
        <div class="col-lg-4">
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
                      <img
                        src="<?= base_url() . 'uploads/flyer/' . $flyer_filename ?>"
                        class="d-block w-100 img-fluid"
                        alt="<?= !empty($item->judul) ? $item->judul : 'Flyer Kegiatan Unggulan' ?>"
                        style="border-radius: 12px; max-height: 100%;" data-action="zoom">
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
        <div class="col-lg-8">
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
                <button class="btn btn-primary" style="background-color: #3c32dd !important; border-radius: 10px; color: white; font-weight: 600;">
                  Ikuti dan Sukseskan Kegiatan Bersama Kami <i class="la la-arrow-right"></i>
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
        <div class="col-lg-4">
          <div class="commit-card d-flex align-items-center gap-3">
            <i class="la la-lightbulb-o" style="font-size: 2.5rem; color: #ffb743;"></i>
            <div>
              <h4>Komitmen Kami</h4>
              <p>
                LLDIKTI Wilayah III berkomitmen untuk terus mendampingi perguruan tinggi dalam mewujudkan budaya mutu yang unggul dan berkelanjutan.
              </p>
            </div>
            <button class="btn" style="background-color: transparent !important; border-radius: 10px; color: #3c32dd; font-weight: 600;">
              Tentang Penjaminan Mutu <i class="la la-arrow-right"></i>
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