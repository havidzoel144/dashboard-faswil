<?php

$route['admin/dashboard'] = 'beranda/admin/dashboard';
$route['admin/ubah-password'] = 'beranda/admin/ubahPassword';

// MANAGE USER
$route['admin/data-user'] = 'beranda/user';
$route['admin/simpan-user'] = 'beranda/user/simpanUser';
$route['admin/update-user'] = 'beranda/user/updateUser';
$route['admin/update-status-user'] = 'beranda/user/updateStatusUser';
$route['admin/hapus-user/(:num)'] = 'beranda/user/hapusUser/$1';
$route['admin/reset-password-user/(:num)'] = 'beranda/user/resetPassword/$1';

// MANAGE FASILITATOR
$route['admin/plotting-fasilitator'] = 'beranda/fasilitator';
$route['admin/simpan-plotting-fasilitator'] = 'beranda/fasilitator/simpanPlottingFasilitator';

// PENILAIAN TIPOLOGI
$route['admin/penilaian-tipologi'] = 'beranda/penilaian';
$route['admin/input-skor/(:any)/(:any)/(:any)'] = 'beranda/penilaian/inputSkor/$1/$2/$3';
$route['admin/simpan-skor'] = 'beranda/penilaian/simpanSkor';

