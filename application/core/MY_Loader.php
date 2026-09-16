<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH . "third_party/MX/Loader.php";

class MY_Loader extends MX_Loader
{
  public function view($view, $vars = array(), $return = FALSE)
  {
    $CI = &get_instance();

    $theme = $CI->session->userdata('ui_template');

    if ($theme == 'baru') {

      $replace = [
        'admin/v_header' => 'admin/v_header_baru',
        'admin/v_menu'   => 'admin/v_menu_baru',
        'admin/v_footer' => 'admin/v_footer_baru',
        'admin/v_header.php' => 'admin/v_header_baru',
        'admin/v_menu.php'   => 'admin/v_menu_baru',
        'admin/v_footer.php' => 'admin/v_footer_baru',
      ];

      if (isset($replace[$view])) {
        $view = $replace[$view];
      }
    }

    return parent::view($view, $vars, $return);
  }
}
