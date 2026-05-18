<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login Dashboard LLDIKTI</title>

  <link rel="shortcut icon" href="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url() ?>app-assets/vendors/css/extensions/toastr.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      overflow: hidden;
    }

    /* animated background */

    .bg-shape {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: .5;
    }

    .shape1 {
      width: 400px;
      height: 400px;
      background: #6dd5ed;
      top: -100px;
      left: -100px;
    }

    .shape2 {
      width: 350px;
      height: 350px;
      background: #ff9a9e;
      bottom: -120px;
      right: -120px;
    }

    /* login card */

    .login-container {
      width: 380px;
      z-index: 2;
    }

    .login-card {
      background: rgba(255, 255, 255, .95);
      border-radius: 18px;
      padding: 35px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, .25);
      backdrop-filter: blur(10px);
      animation: fadeIn .8s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    /* logo */

    .logo {
      display: block;
      margin: auto;
      width: 70px;
      margin-bottom: 10px;
    }

    .title {
      text-align: center;
      font-weight: 600;
      font-size: 22px;
      color: #2a5298;
    }

    .subtitle {
      text-align: center;
      font-size: 13px;
      color: #777;
      margin-bottom: 25px;
    }

    /* form */

    .form-group {
      margin-bottom: 18px;
      position: relative;
    }

    .form-control {
      width: 100%;
      height: 45px;
      border-radius: 10px;
      border: 1px solid #ddd;
      padding-left: 40px;
      font-size: 14px;
    }

    .form-control:focus {
      outline: none;
      border-color: #2a5298;
      box-shadow: 0 0 0 2px rgba(42, 82, 152, .15);
    }

    .icon {
      position: absolute;
      left: 12px;
      top: 12px;
      font-size: 18px;
      color: #2a5298;
    }

    /* show password */

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 12px;
      cursor: pointer;
      color: #777;
    }

    /* button */

    .btn-login {
      width: 100%;
      height: 45px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #2a5298, #1e3c72);
      color: #fff;
      font-weight: 600;
      letter-spacing: .5px;
      cursor: pointer;
      transition: .3s;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, .25);
    }

    /* footer */

    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 12px;
      color: #999;
    }
  </style>

</head>

<body>

  <div class="bg-shape shape1"></div>
  <div class="bg-shape shape2"></div>

  <div class="login-container">

    <div class="login-card">

      <img src="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png" class="logo">

      <div class="title">Dashboard LLDIKTI III</div>
      <div class="subtitle">Sistem Penilaian Tipologi Perguruan Tinggi</div>

      <?php echo form_open(base_url('postLogin'), ['id' => 'loginForm']); ?>

      <div class="form-group">
        <i class="icon">👤</i>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
      </div>

      <div class="form-group">
        <i class="icon">🔒</i>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <span class="toggle-password">👁</span>
      </div>

      <button type="submit" class="btn-login" id="loginBtn">
        Login
      </button>

      <?php echo form_close(); ?>

      <div class="footer">
        © <?= date('Y') ?> LLDIKTI III
      </div>

    </div>

  </div>


  <script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>

  <script>
    /* show password */

    $('.toggle-password').click(function() {

      let input = $('#password');

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        $(this).text('👁‍🗨');
      } else {
        input.attr('type', 'password');
        $(this).text('👁');
      }

    });

    /* loading button */

    $('#loginForm').submit(function() {

      $('#loginBtn').text('Signing in...');
      $('#loginBtn').prop('disabled', true);

    });

    /* toastr */

    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: "4000"
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
  </script>

</body>

</html>