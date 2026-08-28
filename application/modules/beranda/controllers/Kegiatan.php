<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([1, 2]);
  }

  public function index()
  {
    $data['kegiatan'] = $this->db->order_by('urutan', 'ASC')->get('kegiatan')->result();
    $data['jumlah_data'] = $this->db->count_all('kegiatan');

    $this->load->view("admin/master/kegiatan/v_index", $data);
  }

  public function tableKegiatan()
  {
    $data['kegiatan'] = $this->db->order_by('urutan', 'ASC')->get('kegiatan')->result();
    $data['jumlah_data'] = $this->db->count_all('kegiatan');

    $this->load->view('admin/master/kegiatan/_table', $data);
  }

  public function updateUrutan()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $id = (int)$this->input->post('id');
    $lama = (int)$this->input->post('urutan_lama');
    $baru = (int)$this->input->post('urutan_baru');
    if ($lama == $baru) {
      echo json_encode([
        'status' => true
      ]);
      return;
    }
    $this->db->trans_begin();
    if ($baru < $lama) {
      // Geser ke bawah
      $this->db->set('urutan', 'urutan+1', false);
      $this->db->where('urutan >=', $baru);
      $this->db->where('urutan <', $lama);
      $this->db->update('kegiatan');
    } else {
      // Geser ke atas
      $this->db->set('urutan', 'urutan-1', false);
      $this->db->where('urutan <=', $baru);
      $this->db->where('urutan >', $lama);
      $this->db->update('kegiatan');
    }
    $this->db->where('id', $id);
    $this->db->update('kegiatan', [
      'urutan' => $baru
    ]);
    if ($this->db->trans_status()) {
      $this->db->trans_commit();
      $this->db->order_by('urutan', 'ASC');
      $data = $this->db->select('id, urutan')->get('kegiatan')->result();
      echo json_encode([
        'status' => true,
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
    } else {
      $this->db->trans_rollback();
      echo json_encode([
        'status' => false,
        'message' => 'Gagal mengubah urutan.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
    }
  }

  public function simpanKegiatan()
  {
    $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
    $this->form_validation->set_rules('materi', 'Materi', 'required|trim');
    $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
    $this->form_validation->set_rules('metode', 'Metode', 'required|trim');
    $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
    // $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
    $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required|regex_match[/^[0-9]{2}:[0-9]{2}$/]');
    $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required|regex_match[/^[0-9]{2}:[0-9]{2}$/]');
    $this->form_validation->set_rules('status', 'Status', 'required|in_list[Draft,Pendaftaran,Segera Hadir,Akan Datang,Berlangsung,Selesai,Ditutup]');
    $this->form_validation->set_rules('unggulan', 'Unggulan', 'required|in_list[0,1]');
    $this->form_validation->set_rules('tampil_dashboard', 'Tampil Dashboard', 'required|in_list[0,1]');

    if (!empty($_FILES['flyer']['name'])) {
      $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $flyer_ext = strtolower(pathinfo($_FILES['flyer']['name'], PATHINFO_EXTENSION));

      if (!in_array($flyer_ext, $allowed_ext, true)) {
        $this->session->set_flashdata('error_validation', ['Format tidak valid, format yang diperbolehkan (jpg, jpeg, png, gif, webp).']);
        redirect($_SERVER['HTTP_REFERER']);
      }

      $size_flyer = $_FILES['flyer']['size'];
      if ($size_flyer > 2 * 1024 * 1024) { // 2MB
        $this->session->set_flashdata('error_validation', ['Ukuran file flyer terlalu besar, maksimal 2MB.']);
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    if (empty($_FILES['flyer']['name'])) {
      $this->session->set_flashdata('error_validation', ['Flyer harus diisi dengan format yang valid (jpg, jpeg, png, gif, webp).']);
      redirect($_SERVER['HTTP_REFERER']);
    }

    if ($this->form_validation->run() == FALSE) {
      $errors = $this->form_validation->error_array();
      $custom_errors = [];

      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'judul':
            $custom_errors[] = 'Judul kegiatan harus diisi.';
            break;
          case 'deskripsi':
            $custom_errors[] = 'Deskripsi harus diisi.';
            break;
          case 'materi':
            $custom_errors[] = 'Materi harus diisi.';
            break;
          case 'kategori':
            $custom_errors[] = 'Kategori harus diisi.';
            break;
          case 'metode':
            $custom_errors[] = 'Metode harus diisi.';
            break;
          case 'tanggal_mulai':
            $custom_errors[] = 'Tanggal mulai wajib diisi dengan format YYYY-MM-DD.';
            break;
          // case 'tanggal_selesai':
          //   $custom_errors[] = 'Tanggal selesai wajib diisi dengan format YYYY-MM-DD.';
          //   break;
          case 'jam_mulai':
            $custom_errors[] = 'Jam mulai wajib diisi dengan format HH:MM.';
            break;
          case 'jam_selesai':
            $custom_errors[] = 'Jam selesai wajib diisi dengan format HH:MM.';
            break;
          case 'status':
            $custom_errors[] = 'Status wajib diisi (Draft/Pendaftaran/Segera Hadir/Akan Datang/Berlangsung/Selesai/Ditutup).';
            break;
          case 'unggulan':
            $custom_errors[] = 'Nilai unggulan wajib Ya atau Tidak.';
            break;
          case 'tampil_dashboard':
            $custom_errors[] = 'Nilai tampil dashboard wajib Ya atau Tidak.';
            break;
          default:
            $custom_errors[] = $message;
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    $tanggal_mulai = $this->input->post('tanggal_mulai');
    // $tanggal_selesai = $this->input->post('tanggal_selesai');
    $tanggal_selesai = $tanggal_mulai; // Set tanggal_selesai sama dengan tanggal_mulai
    $jam_mulai = $this->input->post('jam_mulai');
    $jam_selesai = $this->input->post('jam_selesai');

    if (strtotime($tanggal_selesai) < strtotime($tanggal_mulai)) {
      $this->session->set_flashdata('error_validation', ['Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.']);
      redirect($_SERVER['HTTP_REFERER']);
    }

    if ($tanggal_mulai === $tanggal_selesai && strtotime($jam_selesai) < strtotime($jam_mulai)) {
      $this->session->set_flashdata('error_validation', ['Jam selesai tidak boleh lebih kecil dari jam mulai.']);
      redirect($_SERVER['HTTP_REFERER']);
    }

    $urutanTertinggi = $this->db->select_max('urutan')->get('kegiatan')->row()->urutan;
    $urutan = $urutanTertinggi + 1;
    $kategori = $this->input->post('kategori');
    $warna_kategori = [
      'Pelatihan' => '#007bff',
      'Workshop' => '#6610f2',
      'Bimtek' => '#17a2b8',
      'Pendampingan' => '#fd7e14',
      'Reviu' => '#28a745',
      'Forum' => '#20c997',
      'Sosialisasi' => '#ffc107',
      'Lainnya' => '#f31e57'
    ];
    $warna_label = isset($warna_kategori[$kategori]) ? $warna_kategori[$kategori] : '#6c757d';

    $data = [
      'judul' => $this->input->post('judul'),
      'deskripsi' => $this->input->post('deskripsi'),
      'materi' => $this->input->post('materi'),
      'kategori' => $kategori,
      'metode' => $this->input->post('metode'),
      'tanggal_mulai' => $tanggal_mulai,
      'tanggal_selesai' => $tanggal_selesai,
      'jam_mulai' => $jam_mulai,
      'jam_selesai' => $jam_selesai,
      'lokasi' => $this->input->post('lokasi'),
      'link_meeting' => $this->input->post('link_meeting'),
      'warna_label' => $warna_label,
      'status' => $this->input->post('status'),
      'unggulan' => $this->input->post('unggulan'),
      'tampil_dashboard' => $this->input->post('tampil_dashboard'),
      'urutan' => $urutan,
      'created_by' => $this->session->userdata('user_id'),
    ];

    // Upload flyer jika ada file yang dikirim
    if (!empty($_FILES['flyer']['name'])) {
      $file_name = $this->input->post('judul') . '_' . time() . '_' . $_FILES['flyer']['name'];
      $upload_path = FCPATH . 'uploads/flyer/';
      if (!is_dir($upload_path)) {
        mkdir($upload_path, 0755, TRUE);
      }

      $config_upload = [
        'upload_path'   => $upload_path,
        'allowed_types' => 'jpg|jpeg|png|gif|webp',
        'max_size'      => 2048,
        'encrypt_name'  => TRUE,
        'file_name'     => $file_name
      ];

      $this->load->library('upload', $config_upload);

      if ($this->upload->do_upload('flyer')) {
        $upload_data = $this->upload->data();
        $data['flyer'] = $upload_data['file_name'];
      } else {
        $this->session->set_flashdata('error_validation', [$this->upload->display_errors('', '')]);
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    $this->db->insert('kegiatan', $data);
    $this->session->set_flashdata('success', 'Data kegiatan berhasil ditambahkan.');
    redirect($_SERVER['HTTP_REFERER']);
  }

  public function updateUser()
  {
    // Validasi form
    $this->form_validation->set_rules('nama', 'Nama User', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('role_id[]', 'Role', 'required'); // role_id adalah array

    if ($this->form_validation->run() == FALSE) {
      // Jika validasi gagal
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'nama':
            $custom_errors[] = 'Nama User harus diisi.';
            break;
          case 'email':
            $custom_errors[] = 'Email harus diisi.';
            break;
          case 'role_id[]':
            $custom_errors[] = 'Role belum dipilih.';
            break;
          default:
            $custom_errors[] = $message; // default pesan
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Ambil data dari form
    $user_id = $this->input->post('id');
    $nama = $this->input->post('nama');
    $email = $this->input->post('email');
    $role_ids = $this->input->post('role_id'); // role_id yang bisa banyak
    $status = $this->input->post('status') == '1' ? 1 : 0;  // Status aktif (1) atau non-aktif (0)

    // Update data user di model
    $update_data = [
      'nama' => $nama,
      'email' => $email,
      'status' => $status
    ];

    // Update data user (nama, email, status)
    $update = $this->User_model->update_user($user_id, $update_data);

    if ($update) {
      // Hapus semua role lama user
      $this->User_model->delete_user_roles($user_id);

      // Insert role baru berdasarkan role_id yang dipilih
      foreach ($role_ids as $role_id) {
        $this->User_model->insert_user_role($user_id, $role_id);
      }

      $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data user.');
    }

    redirect('admin/data-user');  // Redirect setelah berhasil update
  }

  public function hapusUser($user_id)
  {
    if (!$user_id) {
      $this->session->set_flashdata('error', 'ID user tidak valid.');
      redirect('admin/data-user');
    }

    // Cek apakah user ada
    $user = $this->User_model->get_user_by_id($user_id);
    if (!$user) {
      $this->session->set_flashdata('error', 'User tidak ditemukan.');
      redirect('admin/data-user');
    }

    // Proses hapus user
    $delete = $this->User_model->delete_user($user_id);

    if ($delete) {
      $this->session->set_flashdata('success', 'User berhasil dihapus.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus user.');
    }

    redirect('admin/data-user');
  }

  public function resetPassword($user_id)
  {
    // Cek apakah user_id valid
    if (empty($user_id)) {
      $this->session->set_flashdata('error', 'ID user tidak valid.');
      redirect('admin/data-user');
    }

    // Load model user
    $user = $this->User_model->get_user_by_id($user_id);

    if (!$user) {
      $this->session->set_flashdata('error', 'User tidak ditemukan.');
      redirect('admin/data-user');
    }

    // Reset password (misalnya set password default)
    $new_password = 'admin123'; // atau bisa generate password baru

    // Update password user
    $update = $this->User_model->update_password($user_id, $new_password);

    if ($update) {
      $this->session->set_flashdata('success', 'Password berhasil direset.');
    } else {
      $this->session->set_flashdata('error', 'Gagal mereset password.');
    }

    redirect('admin/data-user');
  }

  public function updateStatusUser()
  {
    $user_id = $this->input->post('user_id');
    $status = $this->input->post('status');

    // Update status user di database
    $update = $this->User_model->update_status($user_id, $status);

    if ($update) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }

  public function ajaxGetDosen()
  {
    if ($this->input->is_ajax_request()) {
      $draw = $this->input->post('draw');
      $start = $this->input->post('start');
      $length = $this->input->post('length');
      $search = $this->input->post('search')['value'];
      $order_col = $this->input->post('order')[0]['column'];
      $order_dir = $this->input->post('order')[0]['dir'];

      $columns = ['nidn', 'nama', 'nm_pt'];
      $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'nidn';

      // Total record tanpa filter
      $totalRecords = $this->db->count_all('data_dosen');

      // Pencarian
      if (!empty($search)) {
        $this->db->group_start()
          ->like('nidn', $search)
          ->or_like('nama', $search)
          ->or_like('nm_pt', $search)
          ->group_end();
      }

      $filteredRecords = $this->db->count_all_results('data_dosen', false);

      // Pagination dan ordering
      $this->db->order_by($order_by, $order_dir);
      $this->db->limit($length, $start);
      $query = $this->db->get();
      $data = $query->result();

      echo json_encode([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
    } else {
      show_error('Permintaan tidak valid', 400);
    }
  }

  public function ajaxGetPT()
  {
    if ($this->input->is_ajax_request()) {
      $draw = $this->input->post('draw');
      $start = $this->input->post('start');
      $length = $this->input->post('length');
      $search = $this->input->post('search')['value'];
      $order_col = $this->input->post('order')[0]['column'];
      $order_dir = $this->input->post('order')[0]['dir'];

      $columns = ['kode_pt', 'nama_pt'];
      $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'kode_pt';

      // Total record tanpa filter
      $totalRecords = $this->db->count_all('data_pt');

      // Pencarian
      if (!empty($search)) {
        $this->db->group_start()
          ->like('kode_pt', $search)
          ->or_like('nama_pt', $search)
          ->group_end();
      }

      $filteredRecords = $this->db->count_all_results('data_pt', false);

      // Pagination dan ordering
      $this->db->order_by($order_by, $order_dir);
      $this->db->limit($length, $start);
      $query = $this->db->get();
      $data = $query->result();

      echo json_encode([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
    } else {
      show_error('Permintaan tidak valid', 400);
    }
  }

  public function getStatistikUserPt()
  {
    $pt = $this->db->select('kode_pt,nama_pt')
      ->get('data_pt')
      ->result_array();

    $total_pt = count($pt);

    $sudah_ada = 0;
    $belum_ada = 0;

    foreach ($pt as $row) {

      $username = $row['kode_pt'] . '_penjamu';

      $cek = $this->db
        ->where('username', $username)
        ->count_all_results('users');

      if ($cek > 0) {
        $sudah_ada++;
      } else {
        $belum_ada++;
      }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'total_pt' => $total_pt,
        'sudah_ada' => $sudah_ada,
        'belum_ada' => $belum_ada,
      ]));
  }

  public function generateUserPt()
  {
    if ($this->input->is_ajax_request()) {
      $pt = $this->db
        ->select('kode_pt,nama_pt')
        ->get('data_pt')
        ->result_array();

      $berhasil = 0;
      $skip = 0;

      foreach ($pt as $row) {
        $username = $row['kode_pt'] . '_penjamu';

        // cek apakah username sudah ada
        $cek = $this->db
          ->where('username', $username)
          ->get('users')
          ->row_array();

        if ($cek) {
          $skip++;
          continue;
        }

        // mulai transaction
        $this->db->trans_start();

        $insert = [
          'nama' => $row['nama_pt'],
          'username' => $username,
          'password' => password_hash('admin123', PASSWORD_DEFAULT),
          'status' => '1',
        ];

        // insert users
        $this->db->insert('users', $insert);

        // ambil id user yang baru dibuat
        $user_id = $this->db->insert_id();

        // insert role
        $this->db->insert('user_roles', [
          'user_id' => $user_id,
          'role_id' => 6
        ]);

        // selesai transaction
        $this->db->trans_complete();

        // cek berhasil/gagal
        if ($this->db->trans_status() === FALSE) {
          log_message('error', 'Gagal generate user PT: ' . $username);
          continue;
        }

        $berhasil++;
      }

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => true,
          'message' => 'Generate user selesai.',
          'berhasil' => $berhasil,
          'skip' => $skip,
        ]));
    } else {
      show_error('Permintaan tidak valid', 400);
    }
  }

  public function getDetailUserPt()
  {
    $type = $this->input->get('type');

    $pt = $this->db
      ->select('kode_pt,nama_pt')
      ->get('data_pt')
      ->result_array();

    $result = [];

    foreach ($pt as $row) {

      $username = $row['kode_pt'] . '_penjamu';

      $cek = $this->db
        ->where('username', $username)
        ->get('users')
        ->row_array();

      $exists = $cek ? true : false;

      if (
        ($type == 'sudah' && $exists) ||
        ($type == 'belum' && !$exists)
      ) {

        $result[] = [
          'kode_pt' => $row['kode_pt'],
          'nama_pt' => $row['nama_pt'],
          'username' => $username,
        ];
      }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'data' => $result
      ]));
  }
}
