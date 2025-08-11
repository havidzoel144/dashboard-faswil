<!-- BEGIN: Main Menu-->
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow navbar-lldikti" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <span class="d-flex align-items-center" style="padding-right: 15px;">
                <img src="<?= base_url() ?>assets/img/Logo Penjamu-02.png" alt="Logo Penjamu LLDIKTI 3" class="brand-logo" style="height: 42px;">
            </span>
            <li class="nav-item <?= $dashboard ?>" data-menu="">
                <a class="nav-link " href="<?= base_url() ?>admin/dashboard" data-toggle=""><i class="la la-home"></i></a>
            </li>
            <?php if (has_role([1, 2])) : ?>
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link <?= $master ?>" href="#" data-toggle="dropdown" aria-expanded="false"><i class="la la-angle-down"></i><span data-i18n="Data Master">Data Master </span></a>
                    <ul class="dropdown-menu">
                        <?php if (has_role([1, 2])) : ?>
                            <li data-menu="" class="<?= $user ?>"><a class="dropdown-item" href="<?= base_url('admin/data-user') ?>"><i class="la la-users"></i><span data-i18n="User">User</span></a></li>
                        <?php endif; ?>
                        <?php if (has_role([2])) : ?>
                            <li data-menu="" class="<?= $periode ?>"><a class="dropdown-item" href="<?= base_url('admin/data-periode') ?>"><span class="fonticon-wrap"><i class="la la-calendar"></i></span><span data-i18n="Periode">Periode</span></a></li>

                            <li data-menu="" class="<?= $fasilitator ?>"><a class="dropdown-item" href="<?= base_url('admin/plotting-fasilitator') ?>"><i class="la la-user-secret"></i><span data-i18n="Plotting Fasilitator">Plotting Fasilitator</span></a></li>

                            <li data-menu="" class="<?= $progres ?>"><a class="dropdown-item" href="<?= base_url('admin/progres-penilaian') ?>"><i class="la la-tasks"></i><span data-i18n="Progres Penilaian">Progres Penilaian</span></a></li>

                            <li data-menu="" class="<?= $BukaTutup ?>"><a class="dropdown-item" href="<?= base_url('admin/buka-tutup') ?>"><i class="la la-toggle-on"></i><span data-i18n="BukaTutup">Buka Tutup</span></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (has_role([1])) : ?>
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link <?= $sinkron ?>" href="#" data-toggle="dropdown" aria-expanded="false"><i class="la la-angle-down"></i><span data-i18n="Data Master">Sinkron </span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="" class="<?= $sinkronPt ?>"><a class="dropdown-item" href="<?= base_url('sinkronPt') ?>"><span class="fonticon-wrap"><i class="la la-calendar"></i></span><span data-i18n="Data PT">Data PT</span></a></li>
                        <li data-menu="" class="<?= $sinkronProdi ?>"><a class="dropdown-item" href="<?= base_url('sinkronProdi') ?>"><span class="fonticon-wrap"><i class="la la-calendar"></i></span><span data-i18n="Data Prodi">Data Prodi</span></a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (has_role([5])) : ?>
                <li class="nav-item <?= $cek_penilaian ?>" data-menu="">
                    <a class="nav-link" href="<?= base_url() ?>admin/validator"><i class="la la-edit"></i><span data-i18n="Validasi Nilai">Validasi Nilai</span></a>
                </li>
            <?php endif; ?>

            <?php if (has_role([4])) : ?>
                <li class="nav-item <?= $penilaian ?>" data-menu="">
                    <a class="nav-link" href="<?= base_url() ?>admin/penilaian-tipologi"><i class="la la-pencil"></i><span data-i18n="Penilaian Tipologi">Penilaian Tipologi</span></a>
                </li>
            <?php endif; ?>

            <?php if (has_role([1, 3])) : ?>
                <li class="nav-item <?= $kip_kuliah ?>" data-menu="">
                    <a class="nav-link" href="<?= base_url() ?>admin/data-kip-kuliah"><i class="la la-list-alt"></i><span data-i18n="KIP Kuliah">KIP Kuliah</span></a>
                </li>
            <?php endif; ?>

            <?php if (has_role([1, 2])) : ?>
                <li class="nav-item <?= $pm ?>" data-menu="">
                    <a class="nav-link" href="<?= base_url() ?>admin/penjaminan-mutu"><i class="la la-th-list"></i><span data-i18n="Penjaminan Mutu">Penjaminan Mutu</span></a>
                </li>
            <?php endif; ?>

            <!-- <li class="nav-item <?= $logout ?>" data-menu="">
                <a class="nav-link" href="<?= base_url() ?>logout" data-toggle=""><i class="la la-sign-out"></i><span data-i18n="Logout">Logout</span></a>
            </li> -->
        </ul>


        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <a class="mr-1" href="https://lldikti3.kemdikbud.go.id/">
                <button class="btn btn-warning-dashboard"><i class="la la-home"></i> Halaman Utama</button>
            </a>
            <a href="<?= base_url() ?>">
                <button class="btn btn-dashboard"><i class="la la-dashboard"></i> Halaman Dashboard</button>
            </a>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->