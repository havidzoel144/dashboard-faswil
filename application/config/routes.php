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
$route['admin/login-as'] = 'beranda/auth/loginAs';
$route['admin/stop-login-as'] = 'beranda/auth/stopLoginAs';

$route['admin/data-kip-kuliah'] = 'beranda/admin/data_kip_kuliah';
$route['admin/simpan-kip-kuliah'] = 'beranda/admin/simpan_kip_kuliah';
$route['admin/hapus-kip-kuliah/(:num)'] = 'beranda/admin/hapus_kip_kuliah/$1';
$route['admin/update-kip-kuliah'] = 'beranda/admin/update_kip_kuliah';

$route['admin/penjaminan-mutu'] = 'beranda/admin/penjaminan_mutu';
$route['admin/penjaminan-mutu-30'] = 'beranda/admin/penjaminan_mutu_30';
$route['admin/import-penjaminan-mutu'] = 'beranda/admin/import_penjaminan_mutu';
$route['admin/download-template-penjaminan-mutu'] = 'beranda/admin/download_template_penjaminan_mutu';
$route['admin/hapus-data-penjaminan-mutu'] = 'beranda/admin/hapus_penjaminan_mutu';
$route['admin/get-penjaminan-mutu-pt'] = 'beranda/admin/get_penjaminan_mutu_pt';

$route['admin/verifikasi-dan-validasi-implementasi-spmi'] = 'beranda/admin/verifikasi_dan_validasi_implementasi_spmi';
$route['admin/peringatan-dini-akreditasi'] = 'beranda/admin/peringatan_dini_akreditasi';
$route['admin/get-peringatan-dini-akreditasi'] = 'beranda/admin/get_peringatan_dini_akreditasi';
$route['admin/pantau-potensi-unggul'] = 'beranda/admin/pantau_potensi_unggul';
$route['admin/get-pantau-potensi-unggul'] = 'beranda/admin/get_pantau_potensi_unggul';
$route['admin/pembelajaran-mandiri-penjaminan-mutu'] = 'beranda/admin/pembelajaran_mandiri_penjaminan_mutu';
$route['admin/informasi-kegiatan'] = 'beranda/admin/informasi_kegiatan';
$route['admin/pustaka'] = 'beranda/admin/pustaka';
$route['admin/jejaring-dan-narahubung-penjaminan-mutu'] = 'beranda/admin/jejaring_dan_narahubung_penjaminan_mutu';
$route['admin/hubungi-kami'] = 'beranda/admin/hubungi_kami';
$route['admin/coba-ui-baru'] = 'beranda/admin/coba_ui_baru';
$route['admin/kembali-ke-ui-lama'] = 'beranda/admin/kembali_ke_ui_lama';

// grafik dinamis
$route['get-data-pt'] = 'beranda/penjaminan_mutu/get_data_pt';
$route['get-data-pt-30'] = 'beranda/penjaminan_mutu_30/get_data_pt';

// Muat file route berdasarkan role
require_once 'custom_routes/route_admin.php'; // Muat file route admin
