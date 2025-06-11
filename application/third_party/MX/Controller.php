<?php defined('BASEPATH') or exit('No direct script access allowed');

// load the CI class for Modular Extensions
require_once __DIR__ . '/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link    http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright   Copyright (c) 2015 Wiredesignz
 * @version     5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller
{
    public $autoload = [];

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class . ' MX_Controller Initialized');
        Modules::$registry[strtolower($class)] = $this;

        // copy a loader instance and initialize
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        // autoload module items
        $this->load->_autoloader($this->autoload);
    }

    /**
     * [__get description]
     *
     * @method __get
     *
     * @param  [type] $class [description]
     *
     * @return [type]        [description]
     */
    public function __get($class)
    {
        return CI::$APP->$class;
    }

    protected function only_for_roles(array $allowed_roles)
    {
        $user_roles = $this->session->userdata('roles');

        // Jika roles tidak ada atau kosong, langsung tolak akses
        if (empty($user_roles) || !is_array($user_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            redirect($_SERVER['HTTP_REFERER'] ?? base_url());
            exit;
        }

        // Ambil role_id user dalam array
        $user_role_ids = array_map(fn ($r) => $r->role_id, $user_roles);

        // Cek intersection antara role user dan allowed_roles
        $allowed = count(array_intersect($user_role_ids, $allowed_roles)) > 0;

        if (!$allowed) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            redirect($_SERVER['HTTP_REFERER'] ?? base_url());
            exit;
        }
    }
}
