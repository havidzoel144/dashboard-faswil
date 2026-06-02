<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('has_role')) {
  function has_role(array $allowed_roles)
  {
    $CI = &get_instance();
    $user_roles = $CI->session->userdata('roles');
    if (!$user_roles) return false;

    $user_role_ids = array_map(fn($r) => $r->role_id, $user_roles);
    return count(array_intersect($user_role_ids, $allowed_roles)) > 0;
  }
}

if (!function_exists('get_user_logo')) {
  function get_user_logo($default = 'default.jpg')
  {
    $CI = &get_instance();
    $username = $CI->session->userdata('username');
    $username = explode('_', $username)[0];
    if (!$username) return $default;

    $CI->db->select('nama_logo');
    $CI->db->where('kode_pt', $username);
    $user = $CI->db->get('logo_pt')->row();

    if ($user && !empty($user->nama_logo)) {
      return $user->nama_logo;
    }

    return $default;
  }
}

if (!function_exists('format_tanggal_indonesia')) {
  function format_tanggal_indonesia($tgl)
  {
    if (empty($tgl) || strtotime($tgl) === false) {
      return '';
    }

    $bulanIndonesia = array(
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember'
    );

    $tanggal = date('d', strtotime($tgl));
    $bulan = $bulanIndonesia[date('m', strtotime($tgl))] ?? '';
    $tahun = date('Y', strtotime($tgl));

    return trim($tanggal . " " . $bulan . " " . $tahun);
  }
}
