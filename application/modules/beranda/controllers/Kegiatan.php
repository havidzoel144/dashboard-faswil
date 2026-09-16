<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends MX_Controller
{
  private $table = 'kegiatan';

  public function __construct()
  {
    parent::__construct();

    $this->load->library(['javascript', 'form_validation', 'upload']);
    $this->load->helper(['url', 'form', 'security']);

    date_default_timezone_set('Asia/Jakarta');

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([1, 2]);
  }

  /**
   * ============================================================
   * HALAMAN UTAMA
   * ============================================================
   */
  public function index()
  {
    $this->load->view('admin/master/kegiatan/v_index');
  }

  /**
   * ============================================================
   * DATATABLES SERVER SIDE
   * ============================================================
   */
  public function tableKegiatan()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $draw   = (int) $this->input->post('draw');
    $start  = (int) $this->input->post('start');
    $length = (int) $this->input->post('length');

    $search = $this->input->post('search');
    $searchValue = isset($search['value'])
      ? trim($search['value'])
      : '';

    /*
    * --------------------------------------------------------
    * Total semua data
    * --------------------------------------------------------
    */
    $recordsTotal = $this->db
      ->count_all($this->table);

    /*
    * --------------------------------------------------------
    * Query data
    * --------------------------------------------------------
    */
    $this->db
      ->select('
                id,
                judul,
                deskripsi,
                materi,
                kategori,
                metode,
                tanggal_mulai,
                tanggal_selesai,
                jam_mulai,
                jam_selesai,
                zona_waktu,
                lokasi,
                link_meeting,
                flyer,
                warna_label,
                status,
                unggulan,
                tampil_dashboard,
                urutan,
                created_by,
                created_at,
                updated_at
            ')
      ->from($this->table);

    /*
    * --------------------------------------------------------
    * SEARCH
    * --------------------------------------------------------
    */
    if ($searchValue !== '') {
      $this->db->group_start();
      $this->db
        ->like('judul', $searchValue)
        ->or_like('deskripsi', $searchValue)
        ->or_like('materi', $searchValue)
        ->or_like('kategori', $searchValue)
        ->or_like('metode', $searchValue)
        ->or_like('status', $searchValue)
        ->or_like('lokasi', $searchValue);
      $this->db->group_end();
    }

    /*
    * --------------------------------------------------------
    * Total data setelah filter
    * --------------------------------------------------------
    */
    $recordsFiltered = $this->db->count_all_results('', false);

    /*
    * --------------------------------------------------------
    * ORDER
    *
    * Urutan sementara tetap berdasarkan urutan ASC.
    * Fitur ubah urutan kita abaikan dulu.
    * --------------------------------------------------------
    */
    $this->db->order_by('urutan', 'ASC');
    $this->db->order_by('id', 'DESC');

    /*
    * --------------------------------------------------------
    * LIMIT
    * --------------------------------------------------------
    */
    if ($length != -1) {
      $this->db->limit($length, $start);
    }

    $query = $this->db->get();
    $data = [];
    $no = $start + 1;

    foreach ($query->result() as $row) {
      $data[] = [
        'no'               => $no++,
        'id'               => $row->id,
        'judul'            => $row->judul,
        'deskripsi'        => $row->deskripsi,
        'materi'           => $row->materi,
        'kategori'         => $row->kategori,
        'metode'            => $row->metode,
        'tanggal_mulai'    => $row->tanggal_mulai,
        'tanggal_selesai'  => $row->tanggal_selesai,
        'jam_mulai'        => $row->jam_mulai,
        'jam_selesai'      => $row->jam_selesai,
        'zona_waktu'       => $row->zona_waktu,
        'lokasi'           => $row->lokasi,
        'link_meeting'     => $row->link_meeting,
        'flyer'            => $row->flyer,
        'warna_label'      => $row->warna_label,
        'status'           => $row->status,
        'unggulan'         => $row->unggulan,
        'tampil_dashboard' => $row->tampil_dashboard,
        'urutan'           => $row->urutan
      ];
    }

    echo json_encode([
      'draw'            => $draw,
      'recordsTotal'    => $recordsTotal,
      'recordsFiltered' => $recordsFiltered,
      'data'            => $data,
      // CSRF baru
      'csrfHash'        => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * SIMPAN DATA
   * ============================================================
   */
  public function simpanKegiatan()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $this->_validationKegiatan();

    if ($this->form_validation->run() === false) {
      echo json_encode([
        'status' => false,
        'message' => validation_errors(
          '<div>• ',
          '</div>'
        ),
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Validasi flyer
    */
    if (empty($_FILES['flyer']['name'])) {
      echo json_encode([
        'status' => false,
        'message' => 'Flyer wajib diupload.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Validasi extension
    */
    $allowed_ext = [
      'jpg',
      'jpeg',
      'png',
      'gif',
      'webp'
    ];

    $flyer_ext = strtolower(
      pathinfo(
        $_FILES['flyer']['name'],
        PATHINFO_EXTENSION
      )
    );

    if (!in_array($flyer_ext, $allowed_ext, true)) {
      echo json_encode([
        'status' => false,
        'message' => 'Format flyer tidak valid. Gunakan jpg, jpeg, png, gif atau webp.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Validasi ukuran
    */
    if ($_FILES['flyer']['size'] > 2 * 1024 * 1024) {
      echo json_encode([
        'status' => false,
        'message' => 'Ukuran flyer maksimal 2 MB.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Urutan
    */
    $urutanTertinggi = $this->db
      ->select_max('urutan')
      ->get($this->table)
      ->row()
      ->urutan;
    $urutan = ((int) $urutanTertinggi) + 1;

    /*
    * Warna kategori
    */
    $kategori = $this->input->post('kategori', true);
    $warna_kategori = [
      'Pelatihan'    => '#007bff',
      'Workshop'     => '#6610f2',
      'Bimtek'       => '#17a2b8',
      'Pendampingan' => '#fd7e14',
      'Reviu'        => '#28a745',
      'Forum'        => '#20c997',
      'Sosialisasi'  => '#ffc107',
      'Lainnya'      => '#f31e57'
    ];

    $warna_label = isset($warna_kategori[$kategori])
      ? $warna_kategori[$kategori]
      : '#6c757d';

    /*
    * Data
    */
    $tanggal_mulai = $this->input->post('tanggal_mulai', true);

    $data = [
      'judul'             => $this->input->post('judul', true),
      'deskripsi'         => $this->input->post('deskripsi', true),
      'materi'            => $this->input->post('materi', true),
      'kategori'          => $kategori,
      'metode'            => $this->input->post('metode', true),
      'tanggal_mulai'     => $tanggal_mulai,
      'tanggal_selesai'   => $tanggal_mulai,
      'jam_mulai'         => $this->input->post('jam_mulai', true),
      'jam_selesai'       => $this->input->post('jam_selesai', true),
      'lokasi'            => $this->input->post('lokasi', true),
      'link_meeting'      => $this->input->post('link_meeting', true),
      'warna_label'       => $warna_label,
      'status'            => $this->input->post('status', true),
      'unggulan'          => $this->input->post('unggulan', true),
      'tampil_dashboard'  => $this->input->post('tampil_dashboard', true),
      'urutan'            => $urutan,
      'created_by'        => $this->session->userdata('user_id'),
    ];

    /*
    * Validasi jam
    */
    if (strtotime($data['jam_selesai']) < strtotime($data['jam_mulai'])) {
      echo json_encode([
        'status' => false,
        'message' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Upload flyer
    */
    $upload_path = FCPATH . 'uploads/flyer/';

    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0755, true);
    }

    $config = [
      'upload_path'   => $upload_path,
      'allowed_types' => 'jpg|jpeg|png|gif|webp',
      'max_size'      => 2048,
      'encrypt_name'  => true
    ];

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('flyer')) {
      echo json_encode([
        'status' => false,
        'message' => strip_tags($this->upload->display_errors()),
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    $upload_data = $this->upload->data();

    $data['flyer'] = $upload_data['file_name'];

    /*
    * Insert
    */
    $insert = $this->db->insert($this->table, $data);

    if (!$insert) {
      // Hapus flyer jika database gagal
      if (!empty($data['flyer'])) {
        @unlink(
          $upload_path . $data['flyer']
        );
      }

      echo json_encode([
        'status' => false,
        'message' => 'Data kegiatan gagal disimpan.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    echo json_encode([
      'status' => true,
      'message' => 'Data kegiatan berhasil ditambahkan.',
      'csrfHash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * GET DATA UNTUK EDIT
   * ============================================================
   */
  public function getKegiatan($id)
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $id = (int) $id;

    $data = $this->db
      ->where('id', $id)
      ->get($this->table)
      ->row();

    if (!$data) {
      echo json_encode([
        'status' => false,
        'message' => 'Data kegiatan tidak ditemukan.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    echo json_encode([
      'status' => true,
      'data' => $data,
      'csrfHash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * UBAH DATA
   * ============================================================
   */
  public function ubahKegiatan()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $id = (int) $this->input->post('id');

    $existing = $this->db
      ->where('id', $id)
      ->get($this->table)
      ->row();

    if (!$existing) {
      echo json_encode([
        'status' => false,
        'message' => 'Data kegiatan tidak ditemukan.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    $this->_validationKegiatan();

    if ($this->form_validation->run() === false) {
      echo json_encode([
        'status' => false,
        'message' => validation_errors(
          '<div>• ',
          '</div>'
        ),
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    $kategori = $this->input->post('kategori', true);

    $warna_kategori = [
      'Pelatihan'    => '#007bff',
      'Workshop'     => '#6610f2',
      'Bimtek'       => '#17a2b8',
      'Pendampingan' => '#fd7e14',
      'Reviu'        => '#28a745',
      'Forum'        => '#20c997',
      'Sosialisasi'  => '#ffc107',
      'Lainnya'      => '#f31e57'
    ];

    $warna_label = isset($warna_kategori[$kategori])
      ? $warna_kategori[$kategori]
      : '#6c757d';

    $data = [
      'judul'             => $this->input->post('judul', true),
      'deskripsi'         => $this->input->post('deskripsi', true),
      'materi'            => $this->input->post('materi', true),
      'kategori'          => $kategori,
      'metode'            => $this->input->post('metode', true),
      'tanggal_mulai'     => $this->input->post('tanggal_mulai', true),
      'tanggal_selesai'   => $this->input->post('tanggal_mulai', true),
      'jam_mulai'         => $this->input->post('jam_mulai', true),
      'jam_selesai'       => $this->input->post('jam_selesai', true),
      'lokasi'            => $this->input->post('lokasi', true),
      'link_meeting'      => $this->input->post('link_meeting', true),
      'warna_label'       => $warna_label,
      'status'            => $this->input->post('status', true),
      'unggulan'          => $this->input->post('unggulan', true),
      'tampil_dashboard'  => $this->input->post('tampil_dashboard', true)
    ];

    if (strtotime($data['jam_selesai']) < strtotime($data['jam_mulai'])) {
      echo json_encode([
        'status' => false,
        'message' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    /*
    * Upload flyer baru jika ada
    */
    if (!empty($_FILES['flyer']['name'])) {
      $allowed_ext = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp'
      ];

      $ext = strtolower(
        pathinfo(
          $_FILES['flyer']['name'],
          PATHINFO_EXTENSION
        )
      );

      if (!in_array($ext, $allowed_ext, true)) {
        echo json_encode([
          'status' => false,
          'message' => 'Format flyer tidak valid.',
          'csrfHash' => $this->security->get_csrf_hash()
        ]);
        return;
      }

      if ($_FILES['flyer']['size'] > 2 * 1024 * 1024) {
        echo json_encode([
          'status' => false,
          'message' => 'Ukuran flyer maksimal 2 MB.',
          'csrfHash' => $this->security->get_csrf_hash()
        ]);
        return;
      }

      $upload_path = FCPATH . 'uploads/flyer/';

      if (!is_dir($upload_path)) {
        mkdir($upload_path, 0755, true);
      }

      $config = [
        'upload_path'   => $upload_path,
        'allowed_types' => 'jpg|jpeg|png|gif|webp',
        'max_size'      => 2048,
        'encrypt_name'  => true
      ];

      $this->upload->initialize($config);

      if (!$this->upload->do_upload('flyer')) {
        echo json_encode([
          'status' => false,
          'message' => strip_tags(
            $this->upload->display_errors()
          ),
          'csrfHash' => $this->security->get_csrf_hash()
        ]);
        return;
      }

      $upload_data = $this->upload->data();

      $data['flyer'] = $upload_data['file_name'];

      /*
      * Hapus flyer lama
      */
      if (!empty($existing->flyer)) {
        $old_file = FCPATH . 'uploads/flyer/' . $existing->flyer;

        if (file_exists($old_file)) {
          @unlink($old_file);
        }
      }
    }

    $this->db
      ->where('id', $id)
      ->update($this->table, $data);

    echo json_encode([
      'status' => true,
      'message' => 'Data kegiatan berhasil diperbarui.',
      'csrfHash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * HAPUS
   * ============================================================
   */
  public function hapusKegiatan()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $id = (int) $this->input->post('id');

    $data = $this->db
      ->where('id', $id)
      ->get($this->table)
      ->row();

    if (!$data) {
      echo json_encode([
        'status' => false,
        'message' => 'Data kegiatan tidak ditemukan.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    $this->db
      ->where('id', $id)
      ->delete($this->table);

    if ($this->db->affected_rows() > 0) {
      if (!empty($data->flyer)) {
        $file = FCPATH . 'uploads/flyer/' . $data->flyer;

        if (file_exists($file)) {
          @unlink($file);
        }
      }

      echo json_encode([
        'status' => true,
        'message' => 'Data kegiatan berhasil dihapus.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    echo json_encode([
      'status' => false,
      'message' => 'Data kegiatan gagal dihapus.',
      'csrfHash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * UPDATE STATUS
   * ============================================================
   */
  public function updateStatus()
  {
    $this->_updateField('status', $this->input->post('status', true));
  }

  /**
   * ============================================================
   * UPDATE UNGGULAN
   * ============================================================
   */
  public function updateUnggulan()
  {
    $this->_updateField('unggulan', $this->input->post('unggulan', true));
  }

  /**
   * ============================================================
   * UPDATE TAMPIL DASHBOARD
   * ============================================================
   */
  public function updateTampilDashboard()
  {
    $this->_updateField('tampil_dashboard', $this->input->post('tampil_dashboard', true));
  }

  /**
   * ============================================================
   * HELPER UPDATE FIELD
   * ============================================================
   */
  private function _updateField($field, $value)
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $id = (int) $this->input->post('id');

    $allowed = [];

    if ($field === 'status') {
      $allowed = [
        'Draft',
        'Daftar Sekarang',
        'Segera Hadir',
        'Akan Datang',
        'Berlangsung',
        'Selesai',
        'Ditutup'
      ];

      if (!in_array($value, $allowed, true)) {
        echo json_encode([
          'status' => false,
          'message' => 'Status tidak valid.',
          'csrfHash' => $this->security->get_csrf_hash()
        ]);
        return;
      }
    }

    if ($field === 'unggulan' || $field === 'tampil_dashboard') {
      $allowed = ['0', '1'];

      if (!in_array((string) $value, $allowed, true)) {
        echo json_encode([
          'status' => false,
          'message' => 'Nilai tidak valid.',
          'csrfHash' => $this->security->get_csrf_hash()
        ]);
        return;
      }
    }

    $this->db->where('id', $id)->update($this->table, [$field => $value]);

    if ($this->db->affected_rows() >= 0) {
      echo json_encode([
        'status' => true,
        'message' => 'Data berhasil diperbarui.',
        'csrfHash' => $this->security->get_csrf_hash()
      ]);
      return;
    }

    echo json_encode([
      'status' => false,
      'message' => 'Data gagal diperbarui.',
      'csrfHash' => $this->security->get_csrf_hash()
    ]);
  }

  /**
   * ============================================================
   * VALIDASI
   * ============================================================
   */
  private function _validationKegiatan()
  {
    $this->form_validation->set_rules(
      'judul',
      'Judul',
      'required|trim'
    );

    $this->form_validation->set_rules(
      'deskripsi',
      'Deskripsi',
      'required|trim'
    );

    $this->form_validation->set_rules(
      'materi',
      'Materi',
      'required|trim'
    );

    $this->form_validation->set_rules(
      'kategori',
      'Kategori',
      'required|trim'
    );

    $this->form_validation->set_rules(
      'metode',
      'Metode',
      'required|trim'
    );

    $this->form_validation->set_rules(
      'tanggal_mulai',
      'Tanggal Mulai',
      'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]'
    );

    $this->form_validation->set_rules(
      'jam_mulai',
      'Jam Mulai',
      'required|regex_match[/^[0-9]{2}:[0-9]{2}$/]'
    );

    $this->form_validation->set_rules(
      'jam_selesai',
      'Jam Selesai',
      'required|regex_match[/^[0-9]{2}:[0-9]{2}$/]'
    );

    $this->form_validation->set_rules(
      'status',
      'Status',
      'required|in_list[Draft,Daftar Sekarang,Segera Hadir,Akan Datang,Berlangsung,Selesai,Ditutup]'
    );

    $this->form_validation->set_rules(
      'unggulan',
      'Unggulan',
      'required|in_list[0,1]'
    );

    $this->form_validation->set_rules(
      'tampil_dashboard',
      'Tampil Dashboard',
      'required|in_list[0,1]'
    );
  }

  public function detail($encryptID = null)
  {
    $id = safe_url_decrypt($encryptID);

    if (empty($id)) {
      show_404();
    }

    $kegiatan = $this->db->where('id', $id)->get('kegiatan')->row();

    if (!$kegiatan) {
      show_404();
    }

    $data['kegiatan'] = $kegiatan;

    $this->load->view('admin/master/kegiatan/v_detail', $data);
  }

  public function semua()
  {
    $limit = 8;

    /*
     * Hitung total data kegiatan
     */
    $this->_filterKegiatanQuery('', '', '');

    $data['total_kegiatan'] = $this->db->count_all_results();

    /*
     * Ambil hanya 8 data pertama
     */
    $this->_filterKegiatanQuery('', '', '');

    $data['kegiatan'] = $this->db
      ->order_by('tanggal_mulai', 'ASC')
      ->order_by('jam_mulai', 'ASC')
      ->limit($limit, 0)
      ->get()
      ->result();

    $this->load->view('admin/master/kegiatan/v_semua', $data);
  }


  /**
   * ============================================================
   * LAZY LOAD KEGIATAN
   * ============================================================
   */
  public function loadMore()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    /*
     * Offset data yang sudah tampil
     */
    $offset = (int) $this->input->get('offset');

    if ($offset < 0) {
      $offset = 0;
    }

    /*
     * Load pertama = 8
     * Load berikutnya = 4
     */
    $requestedLimit = (int) $this->input->get('limit');

    $limit = ($requestedLimit === 8)
      ? 8
      : 4;

    /*
     * Filter
     */
    $keyword = trim(
      (string) $this->input->get('keyword', true)
    );

    $kategori = trim(
      (string) $this->input->get('kategori', true)
    );

    $status = trim(
      (string) $this->input->get('status', true)
    );

    /*
     * ========================================================
     * HITUNG TOTAL DATA SESUAI FILTER
     * ========================================================
     */
    $this->_filterKegiatanQuery(
      $keyword,
      $kategori,
      $status
    );

    $total = $this->db->count_all_results();

    /*
     * ========================================================
     * AMBIL DATA
     * ========================================================
     */
    $this->_filterKegiatanQuery(
      $keyword,
      $kategori,
      $status
    );

    $kegiatan = $this->db
      ->order_by('tanggal_mulai', 'ASC')
      ->order_by('jam_mulai', 'ASC')
      ->limit($limit, $offset)
      ->get()
      ->result();

    /*
     * Render card
     */
    $html = $this->load->view('admin/master/kegiatan/v_card_item', ['kegiatan' => $kegiatan], true);

    $jumlahLoad = count($kegiatan);

    $hasMore = ($offset + $jumlahLoad) < $total;

    $response = [
      'status'   => true,
      'html'     => $html,
      'loaded'   => $jumlahLoad,
      'total'    => $total,
      'has_more' => $hasMore
    ];

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  /**
   * ============================================================
   * FILTER QUERY KEGIATAN
   * ============================================================
   */
  private function _filterKegiatanQuery(
    $keyword = '',
    $kategori = '',
    $status = ''
  ) {
    $this->db
      ->from($this->table)
      ->where('status !=', 'Draft');

    /*
     * Search judul
     */
    if ($keyword !== '') {
      $this->db->like(
        'judul',
        $keyword
      );
    }

    /*
     * Filter kategori
     */
    if ($kategori !== '') {
      $this->db->where(
        'kategori',
        $kategori
      );
    }

    /*
     * Filter status
     */
    if ($status !== '') {
      $this->db->where(
        'status',
        $status
      );
    }
  }
}
