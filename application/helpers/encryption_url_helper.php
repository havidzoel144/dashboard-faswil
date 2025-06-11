<?php
defined('BASEPATH') or exit('No direct script access allowed');

function safe_url_encrypt($data)
{
  $CI = &get_instance();
  $encrypted = $CI->encryption->encrypt($data);
  // Encode to URL-safe base64
  return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
}

function safe_url_decrypt($data)
{
  $CI = &get_instance();
  // Decode from URL-safe base64
  $decoded = base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (strlen($data) + 3) % 4));
  return $CI->encryption->decrypt($decoded);
}
