<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow navbar-lldikti" data-scroll-to-active="true">
  <div class="main-menu-content navbar-lldikti pt-2">
    <ul class="navigation navigation-main navbar-lldikti" id="main-menu-navigation" data-menu="menu-navigation">

      <li class="nav-item d-flex justify-content-center align-items-center">
        <div class="d-flex align-items-center">
          <img src="<?= base_url() ?>assets/img/Logo Penjamu-02.png" alt="Logo Penjamu LLDIKTI 3" class="brand-logo logo-penjamu" style="height: 50px; visibility: hidden;">
        </div>
      </li>
      <!-- Dashboard -->
      <li class="nav-item <?= $dashboard ?>">
        <a href="<?= base_url('admin/dashboard') ?>">
          <i class="la la-home"></i>
          <span class="menu-title">Halaman Utama</span>
        </a>
      </li>

      <!-- ================= MASTER ================= -->
      <?php if (has_role([1, 2])) : ?>
        <li class="nav-item">
          <a href="#">
            <i class="la la-search"></i>
            <span class="menu-title">Data Master</span>
          </a>
          <ul class="menu-content navbar-lldikti">
            <?php if (has_role([1, 2])) : ?>
              <li class="<?= $user ?>">
                <a class="menu-item" href="<?= base_url('admin/data-user') ?>">
                  <span>User</span>
                </a>
              </li>
            <?php endif; ?>
            <?php if (has_role([2])) : ?>
              <li class="<?= $periode ?>">
                <a class="menu-item" href="<?= base_url('admin/data-periode') ?>">
                  <span>Periode</span>
                </a>
              </li>
              <li class="<?= $fasilitator ?>">
                <a class="menu-item" href="<?= base_url('admin/plotting-fasilitator') ?>">
                  <span>Plotting Fasilitator</span>
                </a>
              </li>
              <li class="<?= $progres ?>">
                <a class="menu-item" href="<?= base_url('admin/progres-penilaian') ?>">
                  <span>Progres Penilaian</span>
                </a>
              </li>
              <li class="<?= $BukaTutup ?>">
                <a class="menu-item" href="<?= base_url('admin/buka-tutup') ?>">
                  <span>Buka Tutup</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <!-- ================= VERIFIKASI DAN VALIDASI IMPLEMENTASI SPMI ================= -->
      <?php if (has_role([1, 2, 4, 6])) : ?>
        <li class="nav-item <?= $verifikasi ?>">
          <a href="<?= base_url('admin/verifikasi-dan-validasi-implementasi-spmi') ?>">
            <i class="la la-check-circle"></i>
            <span class="menu-title">Verifikasi dan Validasi Implementasi SPMI</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Review Ekstenal SPMI ================= -->
      <?php if (has_role([1, 2, 4, 5, 6])) : ?>
        <li class="nav-item">
          <a href="#">
            <i class="la la-check-square"></i>
            <span class="menu-title">Review Ekstenal SPMI</span>
          </a>
          <ul class="menu-content navbar-lldikti">
            <?php if (has_role([4])) : ?>
              <li class="<?= $penilaian ?>">
                <a class="menu-item" href="<?= base_url('admin/penilaian-tipologi') ?>">
                  <span>Penilaian Tipologi</span>
                </a>
              </li>
            <?php endif; ?>
            <?php if (has_role([5])) : ?>
              <li class="<?= $cek_penilaian ?>">
                <a class="menu-item" href="<?= base_url('admin/validator') ?>">
                  <span>Validasi Nilai</span>
                </a>
              </li>
            <?php endif; ?>
            <?php if (has_role([6])) : ?>
              <li class="<?= $pengisian_led ?>">
                <a class="menu-item" href="<?= base_url('admin/pt/pengisian-led') ?>">
                  <span>Pengisian Laporan Implementasi SPMI</span>
                </a>
              </li>
            <?php endif; ?>
            <?php if (has_role([1, 2, 6])) : ?>
              <li class="<?= $pm ?>">
                <a class="menu-item" href="<?= base_url('admin/penjaminan-mutu') ?>">
                  <span>Penilaian SPMI Terkini</span>
                </a>
              </li>
              <li class="<?= $pm_30 ?>">
                <a class="menu-item" href="<?= base_url('admin/penjaminan-mutu-30') ?>">
                  <span>Penilaian SPMI 2024 - 2025 asdasd</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <!-- ================= Peringatan Dini Akreditasi} ================= -->
      <?php if (has_role([1, 2, 6])) : ?>
        <li class="nav-item <?= $peringatan_dini ?>">
          <a href="<?= base_url('admin/peringatan-dini-akreditasi') ?>">
            <i class="la la-bell-o"></i>
            <span class="menu-title">Peringatan Dini Akreditasi</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Pantau Potensi Unggul ================= -->
      <?php if (has_role([1, 2])) : ?>
        <li class="nav-item <?= $pantau_potensi_unggul ?>">
          <a href="<?= base_url('admin/pantau-potensi-unggul') ?>">
            <i class="la la-line-chart"></i>
            <span class="menu-title">Pantau Potensi Unggul</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Pembelajaran Mandiri Penjaminan Mutu ================= -->
      <?php if (has_role([1, 2, 4, 6])) : ?>
        <li class="nav-item <?= $pembelajaran_mandiri ?>">
          <a href="<?= base_url('admin/pembelajaran-mandiri-penjaminan-mutu') ?>">
            <i class="la la-book"></i>
            <span class="menu-title">Pembelajaran Mandiri Penjaminan Mutu</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Informasi Kegiatan ================= -->
      <?php if (has_role([1, 2, 4, 6])) : ?>
        <li class="nav-item <?= $informasi_kegiatan ?>">
          <a href="<?= base_url('admin/informasi-kegiatan') ?>">
            <i class="la la-info-circle"></i>
            <span class="menu-title">Informasi Kegiatan</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Pustaka ================= -->
      <?php if (has_role([1, 2, 4, 6])) : ?>
        <li class="nav-item <?= $pustaka ?>">
          <a href="https://lldikti3.kemdiktisaintek.go.id/pustaka/" target="_blank">
            <i class="la la-book"></i>
            <span class="menu-title">Pustaka</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Jejaring dan Narahubung Penjaminan Mutu ================= -->
      <?php if (has_role([1, 2, 6])) : ?>
        <li class="nav-item <?= $jejaring_narahubung ?>">
          <a href="<?= base_url('admin/jejaring-dan-narahubung-penjaminan-mutu') ?>">
            <i class="la la-users"></i>
            <span class="menu-title">Jejaring dan Narahubung Penjaminan Mutu</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= Hubungi Kami ================= -->
      <?php if (has_role([1, 2, 4, 6])) : ?>
        <li class="nav-item <?= $hubungi_kami ?>">
          <a href="https://wa.me/6282122355330" target="_blank">
            <i class="la la-phone"></i>
            <span class="menu-title">Hubungi Kami</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= SINKRON ================= -->
      <?php if (has_role([1])) : ?>
        <li class="nav-item">
          <a href="#">
            <i class="la la-refresh"></i>
            <span class="menu-title">Sinkron</span>
          </a>
          <ul class="menu-content navbar-lldikti">
            <li class="<?= $sinkronPt ?>">
              <a class="menu-item" href="<?= base_url('sinkronPt') ?>">
                <span>Data PT</span>
              </a>
            </li>
            <li class="<?= $sinkronProdi ?>">
              <a class="menu-item" href="<?= base_url('sinkronProdi') ?>">
                <span>Data Prodi</span>
              </a>
            </li>
          </ul>
        </li>
      <?php endif; ?>

      <!-- ================= KIP ================= -->
      <?php if (has_role([1, 3])) : ?>
        <li class="nav-item <?= $kip_kuliah ?>">
          <a href="<?= base_url('admin/data-kip-kuliah') ?>">
            <i class="la la-list-alt"></i>
            <span class="menu-title">KIP Kuliah</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ================= BUTTON DASHBOARD ================= -->
      <li class="navigation-header">
        <span>Shortcut</span>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('admin/kembali-ke-ui-lama') ?>">
          <i class="la la-arrow-left"></i>
          <span class="menu-title">Kembali ke UI Lama</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="https://lldikti3.kemdiktisaintek.go.id/" target="_blank">
          <i class="la la-home"></i>
          <span class="menu-title">Halaman LLDIKTI III</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url() ?>">
          <i class="la la-dashboard"></i>
          <span class="menu-title">Dashboard Website</span>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- END: Main Menu-->

<?php if ($this->session->userdata('login_as') === TRUE): ?>
  <div class="content" style="min-height: fit-content;">
    <div class="content-wrapper">
      <div class="row justify-content-center mt-2">
        <div class="col-12">
          <div class="alert alert-warning mb-0 d-flex flex-column flex-md-row align-items-center justify-content-center text-center">
            <div class="d-flex align-items-center justify-content-center mb-2 mb-md-0">
              <i class="la la-user mr-2"></i>
              <span>
                Anda sedang login sebagai:
                <strong><?= html_escape($this->session->userdata('nama')) ?></strong>
              </span>
            </div>

            <a
              href="<?= base_url('admin/stop-login-as') ?>"
              class="btn btn-sm btn-danger ml-md-3 mt-2 mt-md-0">
              <i class="la la-sign-out"></i>
              Kembali ke Admin
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>