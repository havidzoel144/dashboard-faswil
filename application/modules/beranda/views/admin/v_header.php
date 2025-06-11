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
            max-height: 500px;
            /* Atur sesuai tinggi 5 item */
            overflow-y: auto;
        }

        .list-group-item {
            cursor: pointer;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .custom-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            background-color: #f8f9fa;
            color: #212529;
        }

        /* Transisi dan kursor pointer */
        .list-group-item {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        /* Hover umum (item tanpa bg-success) */
        .list-group-item:hover {
            background-color: #f0f0f0;
        }

        /* Hover khusus jika item punya bg-success */
        .list-group-item.bg-success:hover {
            background-color: #218838 !important;
            /* hijau gelap */
            color: #fff;
        }

        /* Saat diklik (dipilih), override semua warna */
        .list-group-item.active-item {
            background-color: #007bff !important;
            /* biru */
            color: white !important;
        }

        /* Badge agar tetap terbaca di item biru */
        .list-group-item.active-item .badge {
            background-color: white;
            color: #007bff;
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
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<!-- <body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns  " data-open="click" data-menu="horizontal-menu" data-col="2-columns"> -->

<body class="horizontal-layout horizontal-menu 2-columns  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

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