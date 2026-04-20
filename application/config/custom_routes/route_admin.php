<?php

$route['admin/dashboard'] = 'beranda/admin/dashboard';
$route['admin/ubah-password'] = 'beranda/admin/ubahPassword';

//MANAGE BUKA TUTUP
$route['admin/buka-tutup']      = 'beranda/bukaTutup';
$route['admin-simpan-bukaTutup']    = 'beranda/bukaTutup/simpanBukaTutup';

// MANAGE USER
$route['admin/data-user'] = 'beranda/user';
$route['admin/simpan-user'] = 'beranda/user/simpanUser';
$route['admin/update-user'] = 'beranda/user/updateUser';
$route['admin/update-status-user'] = 'beranda/user/updateStatusUser';
$route['admin/hapus-user/(:num)'] = 'beranda/user/hapusUser/$1';
$route['admin/reset-password-user/(:num)'] = 'beranda/user/resetPassword/$1';
$route['admin/ajax-get-dosen'] = 'beranda/user/ajaxGetDosen';
$route['admin/ajax-get-pt'] = 'beranda/user/ajaxGetPT';

// MANAGE PERIODE
$route['admin/data-periode'] = 'beranda/periode';
$route['admin/simpan-periode'] = 'beranda/periode/simpanPeriode';
$route['admin/update-periode'] = 'beranda/periode/updatePeriode';
$route['admin/update-status-periode'] = 'beranda/periode/updateStatusPeriode';
$route['admin/hapus-periode/(:num)'] = 'beranda/periode/hapusPeriode/$1';

// MANAGE FASILITATOR
$route['admin/plotting-fasilitator'] = 'beranda/fasilitator';
$route['admin/plotting-fasilitator/(:any)'] = 'beranda/fasilitator/plottingFasilitator/$1';
$route['admin/simpan-plotting-fasilitator'] = 'beranda/fasilitator/simpanPlottingFasilitator';
$route['admin/hapus-plotting/(:any)'] = 'beranda/fasilitator/hapusPlotting/$1';

// PENILAIAN TIPOLOGI FASILITATOR
$route['admin/penilaian-tipologi'] = 'beranda/penilaian';
$route['admin/input-skor/(:any)'] = 'beranda/penilaian/inputSkor/$1';
$route['admin/lihat-skor/(:any)'] = 'beranda/penilaian/inputSkor/$1';
$route['admin/get-penilaian'] = 'beranda/penilaian/getPenilaian';
$route['admin/simpan-skor'] = 'beranda/penilaian/simpanSkor';
$route['admin/riwayat-penilaian/(:any)'] = 'beranda/penilaian/riwayatPenilaian/$1';
$route['admin/kirim-nilai/(:any)/(:any)'] = 'beranda/penilaian/kirimNilai/$1/$2';

// PENILAIAN VALIDATOR
$route['admin/validator'] = 'beranda/validator';
$route['admin/validator/kirim-nilai/(:any)/(:any)'] = 'beranda/validator/kirim_nilai/$1/$2';
$route['admin/validator/ubah-status-penilaian/(:any)'] = 'beranda/validator/ubah_status_penilaian/$1';
$route['simpan_validasi'] = 'beranda/validator/simpan_validasi';
$route['rwy-validator/(:any)'] = 'beranda/validator/rwy_validator/$1';
$route['daftar-fasilitator/(:any)'] = 'beranda/validator/daftar_fasilitator/$1';
$route['penilaian-validator/(:any)'] = 'beranda/validator/penilaian_validator/$1';

// PROGRES PENILAIAN
$route['admin/progres-penilaian'] = 'beranda/progres';
$route['admin/lihat-progres/(:any)'] = 'beranda/progres/lihatProgres/$1';
$route['admin/export-nilai-pdf/(:any)'] = 'beranda/progres/exportNilaiPdf/$1';
$route['admin/export-nilai-excel/(:any)'] = 'beranda/progres/exportNilaiExcel/$1';
$route['admin/publish-penilaian'] = 'beranda/progres/publishPenilaian';
$route['admin/publish-penilaian-pt'] = 'beranda/progres/publishPenilaianPt';
$route['admin/ubah-status-penilaian/(:any)'] = 'beranda/progres/ubahStatusPenilaian/$1';
$route['admin/get-faswil-validator'] = 'beranda/progres/getFaswilValidator';
$route['admin/update-faswil-validator'] = 'beranda/progres/updateFaswilValidator';
$route['admin/get-pt-binaan-fasilitator'] = 'beranda/progres/getPtBinaanFasilitator';
$route['admin/get-pt-binaan-validator'] = 'beranda/progres/getPtBinaanValidator';

//SINKRON UTK DATA API PDDIKTI
$route['sinkronPt']             = 'beranda/SinkronPt';
$route['sinkronProdi']          = 'beranda/SinkronProdi';
$route['belumSinkronProdi']     = 'beranda/SinkronProdi/belumSinkronProdi';
$route['prosesSinkronProdi']    = 'beranda/SinkronProdi/prosesSinkronProdi';
$route['tidakSinkronProdi']     = 'beranda/SinkronProdi/tidakSinkronProdi';
$route['import_pt_awal']        = 'beranda/Sinkronpt/import_pt_awal';

// EVALUASI 360
$route['admin/evaluasi-360'] = 'beranda/evaluasi';
$route['admin/evaluasi-360/detail/(:any)'] = 'beranda/evaluasi/detail/$1';
$route['admin/evaluasi-360/simpan'] = 'beranda/evaluasi/simpan';
