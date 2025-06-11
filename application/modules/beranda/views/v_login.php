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
  <title>Login Dashboard LLDIKTI</title>
  <link rel="apple-touch-icon" href="<?= base_url() ?>app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/fonts/material-icons/material-icons.css">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/material-vendors.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/extensions/toastr.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/components.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material-extended.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/material-colors.css">
  <!-- END: Theme CSS-->

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/material-vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/pages/login-register.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/extensions/toastr.css">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
  <!-- END: Custom CSS-->

  <style>
    #flash-message {
      transition: opacity 0.5s ease;
    }

    /* Ganti warna background untuk toastr success */
    .toast-success {
      background-color: #28a745 !important;
      /* Hijau Bootstrap misalnya */
      color: #fff !important;
    }
  </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout vertical-collapsed-menu 1-column   menu-collapsed blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-header row">
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-body">
        <section class="row flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <!-- <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" id="flash-message">
                      <?= $this->session->flashdata('success'); ?>
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                  <?php endif; ?>

                  <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" id="flash-message">
                      <?= $this->session->flashdata('error'); ?>
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                  <?php endif; ?> -->

                  <div class="card-title text-center">
                    <div class="p-1">
                      <img class="brand-logo pb-1" alt="modern admin logo" src="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png" width="50px">
                      <h3 class="brand-text">Dashboard LLDIKTI III</h3>
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3"><span>Login to DASHBOARD LLDIKTI III</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <!-- <form class="form-horizontal form-simple" action="<?= base_url('postLogin') ?>" method="POST" novalidate> -->
                    <?php echo form_open(base_url('postLogin'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
                    <fieldset class="form-group position-relative has-icon-left mb-1">
                      <input type="text" class="form-control" id="user-name" name="username" placeholder="Username" required>
                      <div class="form-control-position">
                        <i class="la la-user"></i>
                      </div>
                    </fieldset>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input type="password" class="form-control" id="user-password" name="password" placeholder=" Password" required>
                      <div class="form-control-position">
                        <i class="la la-key"></i>
                      </div>
                    </fieldset>
                    <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i> Login</button>
                    <!-- </form> -->
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
  <!-- END: Content-->


  <!-- BEGIN: Vendor JS-->
  <script src="<?= base_url() ?>app-assets/vendors/js/material-vendors.min.js"></script>
  <!-- BEGIN Vendor JS-->

  <!-- BEGIN: Page Vendor JS-->
  <script src="<?= base_url() ?>app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
  <script src="<?= base_url() ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
  <script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="<?= base_url() ?>app-assets/js/core/app-menu.js"></script>
  <script src="<?= base_url() ?>app-assets/js/core/app.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="<?= base_url() ?>app-assets/js/scripts/pages/material-app.js"></script>
  <script src="<?= base_url() ?>app-assets/js/scripts/forms/form-login-register.js"></script>
  <script src="<?= base_url() ?>app-assets/js/scripts/extensions/toastr.js"></script>
  <!-- END: Page JS-->

  <script>
    $(document).ready(function() {
      toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "4000",
        "showDuration": "300",
        "hideDuration": "300"
      };

      <?php if ($this->session->flashdata('success')) : ?>
        toastr.success("<?= $this->session->flashdata('success'); ?>");
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')) : ?>
        toastr.error("<?= $this->session->flashdata('error'); ?>");
      <?php endif; ?>

      <?php if ($this->session->flashdata('warning')) : ?>
        toastr.warning("<?= $this->session->flashdata('warning'); ?>");
      <?php endif; ?>

      <?php if ($this->session->flashdata('info')) : ?>
        toastr.info("<?= $this->session->flashdata('info'); ?>");
      <?php endif; ?>

      // Sembunyikan alert flash message setelah 3 detik (3000 ms)
      setTimeout(function() {
        $('#flash-message').fadeOut('slow');
      }, 2000); // 3 detik
    });
  </script>

</body>
<!-- END: Body-->

</html>