<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  /* ==========================================
  KOMUNITAS PAGE
  ========================================== */
  @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap');

  body {
    background: #f7faff;
    font-family: 'Quicksand', sans-serif;
  }

  /*====================================
  HERO
  ====================================*/
  .hero-komunitas {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    border-radius: 22px;
    padding: 55px;
    margin-bottom: 35px;
    box-shadow:
      0 10px 35px rgba(15, 23, 42, .05);
  }

  .hero-pattern {
    position: absolute;
    top: -120px;
    right: -120px;
    width: 650px;
    height: 650px;
    border-radius: 50%;
    background:
      radial-gradient(circle,
        rgba(80, 130, 255, .09) 0%,
        rgba(255, 255, 255, 0) 72%);
  }

  .hero-left {
    position: relative;
    z-index: 2;
  }

  .hero-badge {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 30px;
    background: #e9f9ef;
    color: #16a34a;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 20px;
  }

  .hero-title {
    color: #182d63;
    font-size: 52px;
    line-height: 1.18;
    font-weight: 700;
    margin-bottom: 15px;
  }

  .hero-subtitle {
    color: #2563eb;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 28px;
  }

  .hero-description {
    color: #58657d;
    font-size: 17px;
    line-height: 1.8;
    max-width: 620px;
  }

  .hero-image {
    text-align: center;
    position: relative;
    z-index: 2;
  }

  .hero-image img {
    width: 100%;
    max-width: 580px;
  }

  /*====================================
  SECTION TITLE
  ====================================*/
  .section-title {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
  }

  .section-icon {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 15px;
    background: #e8f8ee;
    color: #16a34a;
    font-size: 28px;
    box-shadow:
      0 5px 15px rgba(0, 0, 0, .05);
  }

  .section-title h2 {
    margin: 0;
    font-size: 30px;
    color: #1b2f63;
    font-weight: 700;
  }

  /*====================================
  CARD
  ====================================*/
  .tujuan-card {
    height: 100%;
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    transition: .35s;
    box-shadow:
      0 10px 28px rgba(15, 23, 42, .05);
  }

  .tujuan-card:hover {
    transform: translateY(-8px);
    box-shadow:
      0 25px 45px rgba(37, 99, 235, .12);
  }

  .tujuan-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 22px;
  }

  .green {
    background: #eaf8ef;
    color: #16a34a;
  }

  .blue {
    background: #e7f3ff;
    color: #2563eb;
  }

  .purple {
    background: #f3e8ff;
    color: #7c3aed;
  }

  .tujuan-card h4 {
    font-size: 20px;
    color: #182d63;
    margin-bottom: 18px;
    font-weight: 700;
  }

  .tujuan-card p {
    font-size: 15px;
    color: #607086;
    line-height: 1.8;
  }

  /*====================================
  JOIN CARD
  ====================================*/
  .join-card {
    height: 100%;
    padding: 32px;
    border-radius: 20px;
    background:
      linear-gradient(180deg,
        #eefaf2,
        #f7fffb);
    border: 1px solid #d6efdd;
    display: flex;
    flex-direction: column;
  }

  .join-card h3 {
    color: #15803d;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 18px;
  }

  .join-card p {
    color: #57716b;
    line-height: 1.8;
    margin-bottom: 28px;
  }

  .btn-join {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: #22c55e;
    color: #fff;
    border-radius: 12px;
    padding: 18px;
    text-decoration: none;
    transition: .3s;
    font-size: 18px;
    font-weight: 700;
    box-shadow:
      0 10px 25px rgba(34, 197, 94, .35);
  }

  .btn-join:hover {
    color: #fff;
    background: #16a34a;
    transform: translateY(-3px);
    text-decoration: none;
  }

  .btn-join i {
    font-size: 32px;
    margin-right: 15px;
  }

  .btn-join small {
    display: block;
    font-size: 13px;
    margin-top: 4px;
  }

  .join-note {
    display: flex;
    margin-top: 22px;
    color: #4264ba;
    font-size: 14px;
  }

  .join-note i {
    margin-right: 10px;
    margin-top: 4px;
  }

  /*====================================
  BOTTOM
  ====================================*/
  .bottom-info {
    margin-bottom: 70px;
    background: #ffffff;
    border-radius: 22px;
    padding: 35px;
    position: relative;
    overflow: hidden;
    box-shadow:
      0 10px 35px rgba(15, 23, 42, .05);
  }

  .bottom-info::after {
    content: "";
    position: absolute;
    right: -120px;
    bottom: -120px;
    width: 380px;
    height: 380px;
    border-radius: 50%;
    background:
      radial-gradient(circle,
        rgba(59, 130, 246, .09),
        transparent 70%);
  }

  .bottom-content {
    display: flex;
    align-items: center;
  }

  .bottom-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef4ff;
    color: #2563eb;
    font-size: 38px;
    box-shadow:
      0 5px 18px rgba(0, 0, 0, .06);
  }

  .bottom-content h3 {
    color: #182d63;
    font-size: 28px;
    margin-bottom: 10px;
    font-weight: 700;
  }

  .bottom-content p {
    color: #607086;
    line-height: 1.8;
    margin: 0;
  }

  .skyline {
    text-align: right;
  }

  .skyline img {
    width: 100%;
    max-width: 240px;
    opacity: .92;
  }

  /*====================================
  RESPONSIVE
  ====================================*/
  @media(max-width:1199px) {
    .hero-title {
      font-size: 42px;
    }

    .hero-subtitle {
      font-size: 24px;
    }

    .bottom-content {
      flex-direction: column;
      align-items: flex-start;
    }

    .bottom-icon {
      margin-bottom: 20px;
    }
  }

  @media(max-width:991px) {
    .hero-komunitas {
      padding: 40px;
      text-align: center;
    }

    .hero-description {
      margin: auto;
    }

    .hero-image {
      margin-top: 40px;
    }

    .section-title {
      justify-content: center;
    }

    .bottom-info {
      text-align: center;
    }

    .bottom-content {
      align-items: center;
    }

    .skyline {
      margin-top: 30px;
      text-align: center;
    }
  }

  @media(max-width:768px) {
    .hero-title {
      font-size: 34px;
    }

    .hero-subtitle {
      font-size: 22px;
    }

    .section-title h2 {
      font-size: 24px;
    }

    .tujuan-card {
      margin-bottom: 20px;
    }

    .join-card {
      margin-top: 10px;
    }

    .bottom-content h3 {
      font-size: 22px;
    }
  }

  @media(max-width:576px) {
    .hero-komunitas {
      padding: 28px;
    }

    .hero-title {
      font-size: 30px;
    }

    .hero-description {
      font-size: 15px;
    }

    .hero-badge {
      font-size: 13px;
    }

    .btn-join {
      font-size: 16px;
      padding: 16px;
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
      <!-- HERO -->
      <section class="hero-komunitas">
        <div class="hero-pattern"></div>
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="hero-left">
                <span class="hero-badge">
                  Jejaring / Komunitas
                </span>
                <h1 class="hero-title">
                  Pengelola Penjaminan Mutu Perguruan Tinggi
                </h1>
                <h3 class="hero-subtitle">
                  LLDIKTI Wilayah III
                </h3>
                <p class="hero-description">
                  Komunitas WhatsApp Group ini menjadi wadah komunikasi,
                  kolaborasi, dan berbagi informasi bagi para Kepala atau
                  Pengelola Lembaga Penjaminan Mutu Perguruan Tinggi dan
                  Fasilitator Wilayah di lingkungan LLDIKTI Wilayah III,
                  yang terdiri dari PTS, PTN, dan PTN-BH.
                </p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="hero-image">
                <img
                  src="<?= base_url('assets/img/hero-community.svg') ?>"
                  alt="Komunitas Mutu">
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SECTION TITLE -->
      <section class="section-title">
        <div class="section-icon">
          <i class="ft-target"></i>
        </div>
        <h2>
          Tujuan Komunitas
        </h2>
      </section>

      <!-- TUJUAN -->
      <section class="tujuan-komunitas">
        <div class="row">
          <!-- CARD 1 -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="tujuan-card">
              <div class="tujuan-icon green">
                <i class="ft-volume-2"></i>
              </div>
              <h4>
                Diseminasi Informasi
              </h4>
              <p>
                Menyampaikan informasi terkini seputar
                penjaminan mutu, SPMI dan akreditasi
                dari LLDIKTI Wilayah III.
              </p>
            </div>
          </div>
          <!-- CARD 2 -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="tujuan-card">
              <div class="tujuan-icon blue">
                <i class="ft-message-circle"></i>
              </div>
              <h4>
                Pertukaran Informasi
              </h4>
              <p>
                Berbagi pengalaman, praktik baik,
                dan informasi internal kampus terkait
                penjaminan mutu.
              </p>
            </div>
          </div>
          <!-- CARD 3 -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="tujuan-card">
              <div class="tujuan-icon purple">
                <i class="ft-users"></i>
              </div>
              <h4>
                Informasi Relevan
              </h4>
              <p>
                Menyediakan ruang diskusi dan berbagi
                informasi lain yang relevan untuk
                peningkatan mutu pendidikan tinggi.
              </p>
            </div>
          </div>
          <!-- CTA -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="join-card">
              <h3>
                Bergabunglah Bersama Kami!
              </h3>
              <p>
                Mari bersama memperkuat budaya mutu
                dan membangun perguruan tinggi yang unggul,
                berdaya saing dan berkelanjutan.
              </p>
              <a href="https://chat.whatsapp.com/xxxxx"
                target="_blank"
                class="btn-join">
                <i class="la la-whatsapp" style="font-size: 60px;"></i>
                <span>
                  Bergabung & Penggantian Narahubung
                  <small>
                    (WhatsApp Group)
                  </small>
                </span>
              </a>
              <div class="join-note">
                <i class="ft-info"></i>
                <span>
                  1 perguruan tinggi dibatasi hanya
                  1 orang narahubung yang dapat
                  bergabung dalam komunitas.
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- BOTTOM INFO -->
      <section class="bottom-info">
        <div class="row align-items-center">
          <div class="col-md-8">
            <div class="bottom-content">
              <div class="bottom-icon">
                <i class="ft-shield"></i>
              </div>
              <div>
                <h3>
                  Kolaborasi untuk Mutu Pendidikan Tinggi
                </h3>
                <p>
                  Melalui jejaring ini, kita perkuat sinergi
                  dan kolaborasi untuk mewujudkan perguruan
                  tinggi yang bermutu dan berkontribusi bagi
                  kemajuan bangsa.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="skyline">
              <img
                src="<?= base_url('assets/img/skyline.svg') ?>"
                alt="Skyline">
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>