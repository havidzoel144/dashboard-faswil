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
      <div class="card border-0 mb-3" style="border-radius: 16px; background: linear-gradient(135deg, #ffffff 0%, #5988ff 100%); box-shadow: 0 4px 20px 0 rgba(0,0,0,0.03); overflow: hidden;">
        <div class="card-body p-3 p-md-4 position-relative">
          <div class="row align-items-center">
            <div class="col-lg-7 mb-3 mb-lg-0 zindex-2">
              <h5 class="mb-1" style="font-size: 26px; font-weight: 500;">Selamat Datang di</h5>
              <h1 class="font-weight-bold mb-2" style="color: #1a2e5a; font-size: 48px; font-family: 'Quicksand', sans-serif;">
                Pembelajaran Mandiri <br>
                <span class="font-weight-bold" style="color: #4a22cb; font-size: 48px; font-family: 'Quicksand', sans-serif; line-height: 1.2;">
                  Penjaminan Mutu
                </span>
              </h1>
              <hr style="width: 90px; height: 3px; border: 0; background-color: #4a22cb; margin: 0 0 14px 0; border-radius: 2px;">
              <p class="text-muted mb-0" style="line-height: 1.6; font-size: 16px; max-width: 540px; letter-spacing: 1.2px; color: #4e5d78;">
                Tingkatkan pemahaman dan kompetensi Anda dalam penjaminan mutu pendidikan tinggi melalui pembelajaran mandiri yang fleksibel, terstruktur, dan bersertifikat.
              </p>
            </div>

            <div class="col-lg-5 text-center position-relative">
              <img src="<?= base_url('assets/img/learning-2.svg') ?>" alt="E-Learning Illustration" class="img-fluid" style="max-height: 340px; object-fit: contain;">
            </div>
          </div>
        </div>
      </div>

      <div class="row match-height mb-2">
        <div class="col-lg-7 mb-1">
          <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-3">
              <div class="d-flex align-items-center mb-2">
                <div class="text-white rounded d-flex align-items-center justify-content-center mr-2" style="width: 42px; height: 42px; background-color: #4a22cb; border-radius: 8px !important;">
                  <i class="ft-video" style="font-size: 20px;"></i>
                </div>
                <div>
                  <h5 class="font-weight-bold mb-0" style="color: #1a2e5a; font-size: 18px;">Video Panduan</h5>
                  <small class="text-muted" style="font-size: 14px;">Cara Mengikuti Pembelajaran Mandiri Penjaminan Mutu</small>
                </div>
              </div>

              <div class="embed-responsive embed-responsive-16by9 mb-2 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/u9v215lV1LQ?si=6ILkt6t2g3FXZvAi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>

              <div class="card border-0 mb-0" style="border-radius: 10px; background-color: #eef4ff;">
                <div class="card-body p-2 d-flex align-items-center">
                  <div>
                    <i class="ft-info mr-2 mt-0" style="font-size: 18px; color: #ffffff !important; background-color: #3b82f6; padding: 6px; border-radius: 50%;"></i>
                  </div>
                  <div>
                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.5; color: #3b66bd !important;">
                      Video ini berisi panduan lengkap tentang pendaftaran, akses materi, penyelesaian modul, hingga sertifikat pembelajaran.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 mb-1">
          <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-3">
              <div class="d-flex align-items-center mb-2">
                <div class="text-white rounded d-flex align-items-center justify-content-center mr-2" style="width: 42px; height: 42px; background-color: #4a22cb; border-radius: 8px !important;">
                  <i class="ft-award" style="font-size: 20px;"></i>
                </div>
                <div>
                  <h5 class="font-weight-bold mb-0" style="color: #1a2e5a; font-size: 18px;">Akses ke SPADA Kemdiktisaintek</h5>
                  <small class="text-muted" style="font-size: 14px;">Platform Pembelajaran Daring Terintegrasi</small>
                </div>
              </div>

              <div class="p-3" style="border: 1px solid #e2e8f0; border-radius: 12px; background-color: #fafafa;">
                <div class="text-center mb-3">
                  <h3 class="font-weight-bold mb-0 text-primary" style="letter-spacing: 1px; font-size: 24px; color: #1e40af !important;">
                    SPADA
                  </h3>
                  <small class="text-muted font-weight-bold d-block" style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #94a3b8 !important;">
                    Kemdiktisaintek
                  </small>
                </div>

                <p class="text-muted text-justify" style="font-size: 12px; line-height: 1.5; color: #4e5d78;">
                  SPADA Kemdiktisaintek adalah platform pembelajaran daring resmi yang menyediakan berbagai kursus dan modul peningkatan kapasitas di bidang penjaminan mutu pendidikan tinggi.
                </p>

                <div class="mb-3" style="font-size: 12px; color: #4e5d78;">
                  <div class="d-flex align-items-center mb-2">
                    <i class="ft-check-circle text-primary mr-2" style="font-size: 15px; color: #4a22cb !important;"></i>
                    <span>Materi berkualitas dan terstruktur</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="ft-check-circle text-primary mr-2" style="font-size: 15px; color: #4a22cb !important;"></i>
                    <span>Fleksibel, belajar kapan saja di mana saja</span>
                  </div>
                  <div class="d-flex align-items-center mb-0">
                    <i class="ft-check-circle text-primary mr-2" style="font-size: 15px; color: #4a22cb !important;"></i>
                    <span>Sertifikat resmi setelah menyelesaikan modul</span>
                  </div>
                </div>

                <a href="https://spada.kemdiktisaintek.go.id/login" target="_blank" class="btn text-white btn-block py-2 mb-2 font-weight-bold" style="background-color: #4a22cb; border-radius: 8px; font-size: 13px; box-shadow: 0 4px 12px rgba(74,34,203,0.25);">
                  <i class="ft-external-link mr-1"></i> Kunjungi SPADA Kemdiktisaintek
                </a>

                <div class="text-center text-muted" style="font-size: 11px;">
                  <i class="ft-lock mr-1" style="font-size: 11px;"></i> Anda akan diarahkan ke laman SPADA Kemdiktisaintek
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>