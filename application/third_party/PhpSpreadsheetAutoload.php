<?php
spl_autoload_register(function ($class) {
  $prefix = 'PhpOffice\\PhpSpreadsheet\\';

  // Cek apakah kelas diawali dengan namespace yang benar
  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) {
    return;
  }

  // Ambil nama kelas relatif ke namespace PhpOffice\PhpSpreadsheet
  $relative_class = substr($class, $len);

  // Tentukan path file kelas
  $file = APPPATH . 'third_party/PhpSpreadsheet/src/PhpSpreadsheet/' . str_replace('\\', '/', $relative_class) . '.php';

  // Jika file ada, include
  if (file_exists($file)) {
    require $file;
  }
});
