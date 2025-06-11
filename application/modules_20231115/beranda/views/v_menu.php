 <!-- BEGIN: Main Menu-->
 <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
     <div class="navbar-container main-menu-content" data-menu="menu-container">
         <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
             <li class="nav-item <?= $pt ?>" data-menu="">
                 <a class="nav-link " href="<?= base_url() ?>" data-toggle=""><i class="la la-university"></i><span data-i18n="Dashboard">Perguruan Tinggi</span></a>
             </li>
             <li class="nav-item <?= $dosen ?>" data-menu="">
                 <a class="nav-link" href="<?= base_url() ?>dosen" data-toggle=""><i class="la la-users"></i><span data-i18n="Dashboard">Dosen</span></a>
             </li>
         </ul>
     </div>
 </div>
 <!-- END: Main Menu-->