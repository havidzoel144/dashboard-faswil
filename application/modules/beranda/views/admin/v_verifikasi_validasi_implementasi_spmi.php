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
      <div class="card border-0 mb-2" style="border-radius: 16px; background: linear-gradient(135deg, #f2f6fc 0%, #edf3fe 100%); box-shadow: 0 4px 20px 0 rgba(0,0,0,0.03);">
        <div class="card-body p-3 p-md-4">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-3 mb-lg-0">
              <div class="d-flex align-items-center mb-2">
                <div class="text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 76px; height: 76px; min-width: 76px; background-color: #1e3a8a;">
                  <i class="ft-shield" style="font-size: 38px;"></i>
                </div>
              
                <h1 class="h3 font-weight-bolder mb-0" style="color: #1e3a8a; font-family: 'Quicksand', 'Montserrat', sans-serif; font-size: 36px; line-height: 1.2;">
                  Verifikasi dan Validasi<br>Implementasi SPMI
                </h1>
              </div>

              <p class="text-justify mb-2" style="line-height: 1.6; font-size: 1rem; color: #000000;">
                Pelaksanaan verifikasi dan validasi implementasi Sistem Penjaminan Mutu Internal (SPMI) melalui spmi.kemdiktisaintek.go.id merupakan pelaksanaan amanat Permendiktisaintek Nomor 39 Tahun 2025 tentang Penjaminan Mutu Pendidikan Tinggi, yang menetapkan Lembaga Layanan Pendidikan Tinggi (LLDikti) memiliki tugas sebagai verifikator, validator, pengembang, dan evaluator implementasi SPMI pada perguruan tinggi.
              </p>
              <p class="text-justify mb-2" style="line-height: 1.6; font-size: 1rem; color: #000000;">
                Dalam melaksanakan tugas tersebut, LLDikti menyelenggarakan pembinaan penjaminan mutu yang berorientasi pada pemenuhan butir-butir akreditasi sesuai Standar Akreditasi Nasional Pendidikan Tinggi (SAN Dikti) Tahun 2025, sehingga penguatan implementasi SPMI dapat berjalan selaras dengan peningkatan mutu dan kesiapan perguruan tinggi dalam menghadapi proses akreditasi.
              </p>
              <p class="text-justify mb-0" style="line-height: 1.6; font-size: 1rem; color: #000000;">
                Hasil verifikasi dan validasi yang dilaksanakan oleh Fasilitator Wilayah SPMI menjadi dokumen sumber yang menggambarkan tingkat implementasi SPMI pada perguruan tinggi dan dapat dimanfaatkan sebagai salah satu dokumen pendukung dalam proses akreditasi, sekaligus sebagai dasar bagi LLDikti dalam melaksanakan pembinaan, pendampingan, dan evaluasi peningkatan mutu pendidikan tinggi secara berkelanjutan.
              </p>
            </div>

            <div class="col-lg-6 text-center">
              <img src="<?php echo base_url('assets/img/verifikasi_dan_validasi_implementasi_spmi.png'); ?>" alt="SPMI Illustration" class="img-fluid" style="max-height: 750px;">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-3 col-md-6 mb-2">
          <div class="card h-100 border-0" style="border-radius: 12px; box-shadow: 0 4px 15px 0 rgba(0,0,0,0.02); background-color: #ffffff;">
            <div class="card-body p-2 d-flex align-items-center">
              <div class="d-flex align-items-start align-items-center">
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center mr-2" style="width: 46px; height: 46px; min-width: 46px; background-color: #eff3f9;">
                  <i class="ft-search text-primary" style="font-size: 50px;"></i>
                </div>
                <div>
                  <h6 class="font-weight-bold mb-1" style="color: #1e293b; font-size: 18px;">Verifikasi</h6>
                  <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.4;">Pemeriksaan kesesuaian data dan dokumen implementasi SPMI oleh Fasilitator Wilayah.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
          <div class="card h-100 border-0" style="border-radius: 12px; box-shadow: 0 4px 15px 0 rgba(0,0,0,0.02); background-color: #ffffff;">
            <div class="card-body p-2 d-flex align-items-center">
              <div class="d-flex align-items-start align-items-center">
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center mr-2" style="width: 46px; height: 46px; min-width: 46px; background-color: #eff3f9;">
                  <i class="ft-check-square text-primary" style="font-size: 50px;"></i>
                </div>
                <div>
                  <h6 class="font-weight-bold mb-1" style="color: #1e293b; font-size: 18px;">Validasi</h6>
                  <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.4;">Penilaian kelayakan dan efektivitas implementasi SPMI berdasarkan standar dan ketentuan yang berlaku.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
          <div class="card h-100 border-0" style="border-radius: 12px; box-shadow: 0 4px 15px 0 rgba(0,0,0,0.02); background-color: #ffffff;">
            <div class="card-body p-2 d-flex align-items-center">
              <div class="d-flex align-items-start align-items-center">
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center mr-2" style="width: 46px; height: 46px; min-width: 46px; background-color: #eff3f9;">
                  <i class="ft-trending-up text-primary" style="font-size: 50px;"></i>
                </div>
                <div>
                  <h6 class="font-weight-bold mb-1" style="color: #1e293b; font-size: 18px;">Pembinaan & Pendampingan</h6>
                  <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.4;">LLDikti melakukan pembinaan berkelanjutan untuk peningkatan mutu perguruan tinggi secara terarah.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
          <div class="card h-100 border-0" style="border-radius: 12px; box-shadow: 0 4px 15px 0 rgba(0,0,0,0.02); background-color: #ffffff;">
            <div class="card-body p-2 d-flex align-items-center">
              <div class="d-flex align-items-start align-items-center">
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center mr-2" style="width: 46px; height: 46px; min-width: 46px; background-color: #eff3f9;">
                  <i class="ft-file-text text-primary" style="font-size: 50px;"></i>
                </div>
                <div>
                  <h6 class="font-weight-bold mb-1" style="color: #1e293b; font-size: 18px;">Dokumen Sumber Akreditasi</h6>
                  <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.4;">Hasil verifikasi dan validasi menjadi dokumen pendukung dalam proses akreditasi perguruan tinggi.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card border-0 mb-5" style="border-radius: 12px; box-shadow: 0 4px 15px 0 rgba(0,0,0,0.02); background-color: #ffffff;">
        <div class="card-body p-2 d-flex align-items-center">
          <div class="row align-items-center justify-content-between">
            <div class="col-md-8 d-flex align-items-center mb-2 mb-md-0">
              <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 46px; height: 46px; min-width: 46px; background-color: #eff3f9;">
                <i class="ft-globe text-primary" style="font-size: 50px;"></i>
              </div>
              <div>
                <h6 class="font-weight-bold mb-0" style="color: #1e293b; font-size: 18px;">Akses Portal SPMI</h6>
                <small class="text-muted" style="font-size: 14px;">Kunjungi portal SPMI Kemdiktisaintek untuk melakukan pengajuan, unggah dokumen, dan memantau proses verifikasi.</small>
              </div>
            </div>
            <div class="col-md-4 text-md-right">
              <a href="https://spmi.kemdiktisaintek.go.id/auth/login" target="_blank" class="btn text-white px-3 py-1" style="border-radius: 8px; background-color: #4a22cb; font-size: 13.5px; font-weight: 500; box-shadow: 0 4px 12px rgba(74,34,203,0.2);">
                Kunjungi spmi.kemdiktisaintek.go.id <i class="ft-external-link ml-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>