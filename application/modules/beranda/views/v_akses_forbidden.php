<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Akses Tidak Diizinkan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background: #f8fafc;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 400px;
      margin: 80px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
      text-align: center;
      padding: 40px 30px;
    }

    .icon {
      font-size: 60px;
      color: #e74c3c;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 2rem;
      color: #333;
      margin-bottom: 10px;
    }

    p {
      color: #666;
      margin-bottom: 30px;
    }

    a {
      display: inline-block;
      padding: 10px 24px;
      background: #3498db;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.2s;
    }

    a:hover {
      background: #217dbb;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="icon">&#128274;</div>
    <h1>Akses Tidak Diizinkan</h1>
    <p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.<br>Silakan hubungi administrator jika Anda membutuhkan akses.</p>
    <a href="<?php echo base_url(); ?>">Kembali ke Beranda</a>
  </div>
</body>

</html>