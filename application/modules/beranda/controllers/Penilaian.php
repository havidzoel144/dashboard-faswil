<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model(['Periode_model', 'Penilaian_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles(['4']);
  }

  public function index()
  {
    $fasilitator_id = $this->session->userdata('user_id');
    $data = [
      'penilaian' => 'active',
      'data_periode' => $this->Periode_model->get_data_periode_by_fasilitator($fasilitator_id),
    ];

    // echo json_encode($data['data_periode']);exit;

    $this->load->view("admin/master/penilaian/v_index", $data);
  }

  public function penilaian()
  {
    $fasilitator_id = $this->session->userdata('user_id');
    $data = [
      'penilaian' => 'active',
      'data_pt_binaan' => $this->Penilaian_model->get_data_penilaian_by_fasilitator($fasilitator_id),
      'data_periode' => $this->Periode_model->get_active_periode(),
    ];

    // echo json_encode($data['data_pt_binaan']);exit;

    $this->load->view("admin/master/penilaian/v_penilaian", $data);
  }

  public function inputSkor($enc_periode)
  {
    $periode        = safe_url_decrypt($enc_periode);
    $periode_dipilih = $this->Periode_model->get_periode_by_kode($periode);
    $fasilitator_id = $this->session->userdata('user_id');

    $data = [
      'penilaian' => 'active',
      'periode_dipilih' => $periode_dipilih,
      'data_pt_binaan' => $this->Penilaian_model->get_data_penilaian_by_fasilitator($fasilitator_id, $periode),
    ];

    if ($data['data_pt_binaan'] == null) {
      $this->session->set_flashdata('info', 'Tidak ada data pada periode ' . $periode . '.');
      redirect('admin/penilaian-tipologi');
    }

    $bk = $this->db->query("SELECT * FROM `buka_tutup` WHERE `id` = '1'")->row();
    $data['dabk'] = $bk;
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    // Cek tanggal dan waktu sekaligus
    if (
      ($current_date < $bk->mulai_tgl || $current_date > $bk->akhir_tgl) ||
      (
        isset($bk->mulai_jam) && isset($bk->akhir_jam) &&
        (
          ($current_date == $bk->mulai_tgl && $current_time < $bk->mulai_jam) ||
          ($current_date == $bk->akhir_tgl && $current_time > $bk->akhir_jam)
        )
      )
    ) {
      $data['buka_tutup'] = "tutup"; // Tidak dalam periode buka tutup
    }

    // echo json_encode($data['data_pt_binaan']);exit;

    $this->load->view("admin/master/penilaian/v_penilaian", $data);
  }

  public function getPenilaian()
  {
    if ($this->input->is_ajax_request()) {
      // $periode = $this->input->post('periode');
      // $kode_pt = $this->input->post('kode_pt');
      // $fasilitator_id = $this->input->post('fasilitator_id');
      $id_penilaian_tipologi = $this->input->post('id_penilaian_tipologi');

      // $hasil = $this->Penilaian_model->getPenilaian($periode, $kode_pt, $fasilitator_id);
      $hasil = $this->Penilaian_model->getPenilaian($id_penilaian_tipologi);

      if (!empty($hasil)) {
        echo json_encode([
          'success' => true,
          'data' => $hasil,
          'csrfHash' => $this->security->get_csrf_hash() // ← penting
        ]);
      } else {
        echo json_encode([
          'success' => false,
          'message' => 'Data tidak ditemukan.',
          'csrfHash' => $this->security->get_csrf_hash() // ← pastikan tetap dikirim
        ]);
      }
    } else {
      // Jika bukan AJAX, tampilkan halaman error
      show_error('Permintaan tidak valid', 400);
    }
  }

  public function simpanSkor()
  {
    // Misal data dikirim lewat POST atau JSON
    $post = $this->input->post(); // atau json_decode($this->input->raw_input_stream, true)
    // $kode_pt = $post['kode_pt'];
    $fasilitator_id = $this->session->userdata('user_id'); // Contoh ambil dari session
    // $periode = $this->Periode_model->get_active_periode(); // Contoh, bisa juga dari input
    $id_penilaian_tipologi = $post['id_penilaian_tipologi'];

    $skor_1_bobot = (($post['skor_1a'] + (2 * $post['skor_1b'])) / 3) * 2.22;
    $skor_2_bobot = $post['skor_2'] * 2.78;
    $skor_total = $skor_1_bobot + $skor_2_bobot;
    $tipologi = $this->get_tipologi($skor_total);

    // Mulai transaksi database
    $this->db->trans_start();

    // Data yang akan diupdate
    $data = [
      'id_status_penilaian' => 2,
      'skor_1a' => $post['skor_1a'],
      'catatan_1a' => $post['catatan_1a'],
      'skor_1b' => $post['skor_1b'],
      'catatan_1b' => $post['catatan_1b'],
      'skor_2' => $post['skor_2'],
      'catatan_2' => $post['catatan_2'],
      'catatan_keseluruhan' => $post['catatan_keseluruhan'],
      'skor_1_bobot' => $skor_1_bobot,
      'skor_2_bobot' => $skor_2_bobot,
      'skor_total' => $skor_total,
      'tipologi' => $tipologi,
      'updated_at' => date('Y-m-d H:i:s') // optional timestamp
    ];

    // echo gettype($id_penilaian_tipologi);exit;
    // $update = $this->Penilaian_model->update_penilaian($kode_pt, $fasilitator_id, $periode->kode, $data);
    // $$this->Penilaian_model->update_penilaian($id_penilaian_tipologi, $data);
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);

    $this->db->insert('rwy_penilaian_fasilitator', [
      'id_penilaian_tipologi' => $id_penilaian_tipologi,
      'id_status_penilaian' => 2,
      'fasilitator_id' => $fasilitator_id,
      'skor_1a' => $post['skor_1a'],
      'skor_1b' => $post['skor_1b'],
      'skor_2' => $post['skor_2'],
      'skor_1_bobot' => $skor_1_bobot,
      'skor_2_bobot' => $skor_2_bobot,
      'skor_total' => $skor_total,
      'catatan_1a' => $post['catatan_1a'],
      'catatan_1b' => $post['catatan_1b'],
      'catatan_2' => $post['catatan_2'],
      'catatan_keseluruhan' => $post['catatan_keseluruhan'],
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
      $this->session->set_flashdata('success', 'Data berhasil diperbarui');
      // redirect('admin/penilaian-tipologi');
      if (!empty($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
      } else {
        redirect('default_controller'); // fallback jika tidak ada referer
      }
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data');
    }
  }

  function get_tipologi($nilai_terbobot)
  {
    if ($nilai_terbobot > 17.5 && $nilai_terbobot <= 20) {
      return "Tipologi 1";
    } elseif ($nilai_terbobot > 15 && $nilai_terbobot <= 17.5) {
      return "Tipologi 2";
    } elseif ($nilai_terbobot >= 10 && $nilai_terbobot <= 15) {
      return "Tipologi 3";
    } elseif ($nilai_terbobot < 10) {
      return "Tipologi 4";
    } else {
      return null; // nilai tidak valid atau di luar jangkauan
    }
  }

  public function riwayatPenilaian($enc_id_penilaian_topologi)
  {
    $id_penilaian_topologi  = safe_url_decrypt($enc_id_penilaian_topologi);
    $user_id                = $this->session->userdata('user_id');
    $data['penilaian'] = 'active';

    $val = $this->db->query("SELECT
                                a.*,
                                b.`periode`,
                                b.`nama_pt`,
                                b.`kode_pt`,
                                c.`nama`,
                                d.`nm_status`
                              FROM
                                `rwy_penilaian_fasilitator` a
                                JOIN `penilaian_tipologi` b
                                  ON a.`id_penilaian_tipologi` = b.`id_penilaian_tipologi`
                                JOIN `users` c
                                  ON b.`fasilitator_id` = c.`id`
                                JOIN `status_penilaian` d
                                  ON a.`id_status_penilaian` = d.`id_status`
                              WHERE a.`id_penilaian_tipologi` = '$id_penilaian_topologi'
                                AND b.`fasilitator_id` = '$user_id'
                                ORDER BY a.`created_at` DESC");

    $data['da']   = $val->row();
    $data['val']  = $val->result();

    // echo json_encode($data);exit;

    $this->load->view("admin/master/penilaian/v_riwayat_penilaian", $data);
  }
}
