<!-- BEGIN: Main Menu-->
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow navbar-lldikti" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item <?= $dashboard ?>" data-menu="">
                <a class="nav-link " href="<?= base_url() ?>admin/dashboard" data-toggle=""><i class="la la-home"></i></a>
            </li>

            <?php if (has_role([1])) : ?>
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link <?= $master ?>" href="#" data-toggle="dropdown" aria-expanded="false"><i class="la la-angle-down"></i><span data-i18n="Templates">Data Master </span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="" class="<?= $user ?>"><a class="dropdown-item" href="<?= base_url('admin/data-user') ?>"><i class="la la-users"></i><span data-i18n="User">User</span></a></li>
                        <li data-menu="" class="<?= $fasilitator ?>"><a class="dropdown-item" href="<?= base_url('admin/plotting-fasilitator') ?>"><i class="la la-user-secret"></i><span data-i18n="Fasilitator">Plotting Fasilitator</span></a></li>
                        <li data-menu=""><a class="dropdown-item" href="<?= base_url('admin/data-validator') ?>"><span class="fonticon-wrap"><i class="icon-users"></i></span><span data-i18n="Validator">Validator</span></a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (has_role([4])) : ?>
                <li class="nav-item <?= $penilaian ?>" data-menu="">
                    <a class="nav-link" href="<?= base_url() ?>admin/penilaian-tipologi"><i class="la la-list-alt"></i><span data-i18n="KIP Kuliah">Penilaian Tipologi</span></a>
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
            <a href="https://dashboard-lldikti3.kemdikbud.go.id/">
                <button class="btn btn-warning-dashboard"><i class="la la-home"></i> Halaman Dashboard</button>
            </a>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->