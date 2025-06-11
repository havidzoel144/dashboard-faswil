<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'beranda/beranda';

$route['dosen']         = 'beranda/dosen';
$route['prodi']         = 'beranda/prodi';
$route['belmawa']       = 'beranda/belmawa';
$route['data_belmawa']  = 'beranda/belmawa/data_belmawa';
$route['penjaminan_mutu'] = 'beranda/penjaminan_mutu';

$route['login'] = 'beranda/auth';
$route['postLogin'] = 'beranda/auth/postLogin';
$route['logout'] = 'beranda/auth/logout';

$route['admin/data-kip-kuliah'] = 'beranda/admin/data_kip_kuliah';
$route['admin/simpan-kip-kuliah'] = 'beranda/admin/simpan_kip_kuliah';
$route['admin/hapus-kip-kuliah/(:num)'] = 'beranda/admin/hapus_kip_kuliah/$1';
$route['admin/update-kip-kuliah'] = 'beranda/admin/update_kip_kuliah';

$route['admin/penjaminan-mutu'] = 'beranda/admin/penjaminan_mutu';
$route['admin/import-penjaminan-mutu'] = 'beranda/admin/import_penjaminan_mutu';
$route['admin/download-template-penjaminan-mutu'] = 'beranda/admin/download_template_penjaminan_mutu';
$route['admin/hapus-data-penjaminan-mutu'] = 'beranda/admin/hapus_penjaminan_mutu';

// grafik dinamis
$route['get-data-pt'] = 'beranda/penjaminan_mutu/get_data_pt';

// Muat file route berdasarkan role
require_once 'custom_routes/route_admin.php'; // Muat file route admin
