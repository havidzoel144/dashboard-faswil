<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('has_role')) {
  function has_role(array $allowed_roles)
  {
    $CI = &get_instance();
    $user_roles = $CI->session->userdata('roles');
    if (!$user_roles) return false;

    $user_role_ids = array_map(fn ($r) => $r->role_id, $user_roles);
    return count(array_intersect($user_role_ids, $allowed_roles)) > 0;
  }
}
