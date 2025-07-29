<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Dashboard LLDIKTI III</title>
    <link rel="apple-touch-icon" href="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/fonts/material-icons/material-icons.css">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/selects/select2.min.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/toggle/switchery.min.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
    <!-- Tambahkan Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/bootstrap-extended.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/colors.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/components.css">

    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material-colors.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/colors/palette-gradient.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/material-vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/colors/palette-callout.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/forms/switch.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/colors/palette-switch.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
    <!-- END: Custom CSS-->

    <script>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>'; // misal: csrf_test_name
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: red;
            color: white;
            text-align: center;
        }

        #flash-message {
            transition: opacity 0.5s ease;
        }

        /* Ganti warna background untuk toastr success */
        .toast-success {
            background-color: #28a745 !important;
            /* Hijau Bootstrap misalnya */
            color: #fff !important;
        }

        .form-group label {
            margin-left: 0px;
        }

        .select2-results__option--disabled {
            color: red !important;
        }

        .select2-container--default .select2-results__option[aria-disabled=true] {
            /* color: red; */
            background-color: antiquewhite;
            font-style: italic;
        }

        #list-pt .list {
            max-height: 1040px;
            /* Atur sesuai tinggi 5 item */
            overflow-y: auto;
        }

        /* Putihkan font untuk .kode_pt dan .nama_pt jika status bg-success, bg-danger, bg-warning, selain itu hitam */
        .kode_pt,
        .nama_pt {
            color: #212529 !important;
            /* Default: hitam */
        }

        .bg-success .kode_pt,
        .bg-success .nama_pt,
        .bg-danger .kode_pt,
        .bg-danger .nama_pt,
        .bg-warning .kode_pt,
        .bg-warning .nama_pt,
        .bg-info .kode_pt,
        .bg-info .nama_pt {
            color: #fff !important;
            /* Jika status: putih */
        }

        /* Status 4: Success */
        .list-group-item.bg-success:hover,
        .list-group-item.bg-success:focus,
        .list-group-item.bg-success:hover .badge,
        .list-group-item.bg-success:focus .badge {
            background-color: rgb(18, 109, 37) !important;
            color: #fff !important;
            transition: none;
        }

        .list-group-item.bg-success.active-item,
        .list-group-item.bg-success.active,
        .list-group-item.bg-success.active-item .badge,
        .list-group-item.bg-success.active .badge {
            background-color: #28a745 !important;
            color: #fff !important;
            transition: none;
        }

        /* Status 3: Danger */
        .list-group-item.bg-danger:hover,
        .list-group-item.bg-danger:focus,
        .list-group-item.bg-danger:hover .badge,
        .list-group-item.bg-danger:focus .badge {
            background-color: rgb(137, 5, 18) !important;
            color: #fff !important;
            transition: none;
        }

        .list-group-item.bg-danger.active-item,
        .list-group-item.bg-danger.active,
        .list-group-item.bg-danger.active-item .badge,
        .list-group-item.bg-danger.active .badge {
            background-color: rgb(193, 40, 55) !important;
            color: #fff !important;
            transition: none;
        }

        /* Status 2: Warning */
        .list-group-item.bg-warning:hover,
        .list-group-item.bg-warning:focus,
        .list-group-item.bg-warning:hover .badge,
        .list-group-item.bg-warning:focus .badge {
            background-color: rgb(150, 112, 0) !important;
            color: #fff !important;
            transition: none;
        }

        .list-group-item.bg-warning.active-item,
        .list-group-item.bg-warning.active,
        .list-group-item.bg-warning.active-item .badge,
        .list-group-item.bg-warning.active .badge {
            background-color: rgb(195, 148, 7) !important;
            color: #fff !important;
            transition: none;
        }

        /* Status 1: Info */
        .list-group-item.bg-info:hover,
        .list-group-item.bg-info:focus,
        .list-group-item.bg-info:hover .badge,
        .list-group-item.bg-info:focus .badge {
            background-color: rgb(23, 123, 251) !important;
            color: #fff !important;
            transition: none;
        }

        .list-group-item.bg-info.active-item,
        .list-group-item.bg-info.active,
        .list-group-item.bg-info.active-item .badge,
        .list-group-item.bg-info.active .badge {
            background-color: rgb(0, 104, 218) !important;
            color: #fff !important;
            transition: none;
        }

        /* Default (tanpa status) */
        .list-group-item:not(.bg-success):not(.bg-danger):not(.bg-warning):not(.bg-info):hover,
        .list-group-item:not(.bg-success):not(.bg-danger):not(.bg-warning):focus {
            background-color: #e2e6ea !important;
            color: #212529 !important;
        }

        .list-group-item:not(.bg-success):not(.bg-danger):not(.bg-warning):not(.bg-info).active-item,
        .list-group-item:not(.bg-success):not(.bg-danger):not(.bg-warning):not(.bg-info).active {
            background-color: rgba(107, 161, 214, 0.51) !important;
            color: #212529 !important;
        }

        .skor {
            height: 64px;
            font-size: xx-large;
            text-align: center;
        }

        .textarea-catatan {
            resize: none;
            border: 1px solid rgba(0, 0, 0, 0.3) !important;
        }

        .label-required::after {
            content: " *";
            color: red;
            font-weight: bold;
        }

        /* Custom style for .active menu */
        .navbar-nav .nav-item .active,
        .navbar-nav .nav-link.active,
        .navbar-nav .nav-item.active>.nav-link {
            background: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important;
            color: #fff !important;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(103, 18, 200, 0.08);
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }

        .navbar-nav .nav-item .active:hover,
        .navbar-nav .nav-link.active:hover,
        .navbar-nav .nav-item.active>.nav-link:hover {
            background: linear-gradient(90deg, #4e0fa3 28%, #1761c1 98%) !important;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            transition: background 0.2s, color 0.2s;
        }

        /* Style for active dropdown submenu */
        .navbar-nav .dropdown-menu .dropdown-item.active,
        .navbar-nav .dropdown-menu .dropdown-item:active,
        .navbar-nav .dropdown-menu li.active>.dropdown-item {
            background: linear-gradient(90deg, #2375fc 28%, #6712c8 98%) !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(35, 117, 252, 0.08);
            transition: background 0.2s, color 0.2s;
        }

        .navbar-nav .dropdown-menu .dropdown-item.active:hover,
        .navbar-nav .dropdown-menu .dropdown-item:active:hover,
        .navbar-nav .dropdown-menu li.active>.dropdown-item:hover {
            background: linear-gradient(90deg, #1761c1 28%, #4e0fa3 98%) !important;
            color: #fff !important;
        }

        .btn-dashboard {
            background-color: rgb(56, 11, 135);
            border-radius: 50px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
            color: white;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .btn-dashboard:hover {
            color: white;
            transform: scale(1.1);
        }

        .input-group-text {
            background-color: rgb(175, 146, 224);
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<!-- <body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns  " data-open="click" data-menu="horizontal-menu" data-col="2-columns"> -->

<body class="horizontal-layout horizontal-menu 2-columns" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="<?= base_url() ?>"><img class="brand-logo" alt="modern admin logo" src="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png">
                            <h3 class="brand-text">Dashboard LLDIKTI III</h3>
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container container center-layout">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    </ul>

                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link waves-effect waves-dark" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?= $this->session->userdata('nama') ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item waves-effect waves-dark d-flex align-items-center" href="#" onclick="ubahPassword('<?= $this->session->userdata('user_id') ?>')">
                                    <i class="material-icons">person_outline</i> <span>Ubah Password</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item waves-effect waves-dark d-flex align-items-center" href="<?= base_url('logout') ?>"><i class="material-icons">power_settings_new</i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->