 <!-- BEGIN: Main Menu-->
 <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow navbar-lldikti" role="navigation" data-menu="menu-wrapper">
     <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
         <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
             <li class="nav-item <?= $pt ?>" data-menu="">
                 <a class="nav-link " href="<?= base_url() ?>" data-toggle=""><i class="la la-university"></i><span data-i18n="Dashboard">Perguruan Tinggi</span></a>
             </li>
             <li class="nav-item <?= $dosen ?>" data-menu="">
                 <a class="nav-link" href="<?= base_url() ?>dosen" data-toggle=""><i class="la la-users"></i><span data-i18n="Dashboard">Dosen</span></a>
             </li>
             <li class="nav-item <?= $prodi ?>" data-menu="">
                 <a class="nav-link" href="<?= base_url() ?>prodi" data-toggle=""><i class="la la-building"></i><span data-i18n="Dashboard">Program Studi</span></a>
             </li>
             <li class="nav-item <?= $belmawa ?>" data-menu="">
                 <a class="nav-link" href="<?= base_url() ?>belmawa" data-toggle=""><i class="la la-sitemap"></i><span data-i18n="Dashboard">Belmawa</span></a>
             </li>
             <li class="nav-item <?= $pm ?>" data-menu="">
                 <a class="nav-link" href="<?= base_url() ?>penjaminan_mutu" data-toggle=""><i class="la la-server"></i><span data-i18n="Dashboard">Penjaminan Mutu</span></a>
             </li>
         </ul>

         <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
             <a class="mr-1" href="https://lldikti3.kemdikbud.go.id/">
                 <button class="btn btn-warning-dashboard"><i class="la la-home"></i> Halaman Utama</button>
             </a>
             <?php if ($this->session->userdata('logged_in')): ?>
                 <a href="<?= base_url('admin/dashboard') ?>">
                     <button class="btn btn-admin-dashboard me-1"> <i class="la la-user"></i> Admin Dashboard</button>
                 </a>
             <?php else: ?>
                 <a href="<?= base_url('login') ?>">
                     <button class="btn btn-login-dashboard"> <i class="la la-sign-in"></i> Login</button>
                 </a>
             <?php endif; ?>
         </ul>
     </div>
 </div>
 <!-- END: Main Menu-->