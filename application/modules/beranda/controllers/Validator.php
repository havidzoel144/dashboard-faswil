<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validator extends MX_Controller
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

    $this->only_for_roles(['5']);
  }

  public function index()
  {
    $user_id = $this->session->userdata('user_id');
    $data['cek_penilaian'] = 'active';
    $data['val'] = $this->db->query("SELECT
                                      *
                                    FROM
                                      `penilaian_tipologi`
                                    WHERE `validator_id`='$user_id'
                                    AND `id_status_penilaian` IN('2','3','4')
                                    GROUP BY `periode`
                                    ORDER BY periode DESC")->result();

    $this->load->view("admin/master/validator/index", $data);
  }

  public function daftar_fasilitator($periode_encrypt)
  {
    $periode = safe_url_decrypt($periode_encrypt);
    $user_id = $this->session->userdata('user_id');

    $data['periode']      = $periode;
    $data['validator_id'] = $user_id;
    $data['cek_penilaian'] = 'active';

    // Ambil data penilaian berdasarkan periode dan validator
    $val = $this->db->query("SELECT
                                      a.*,
                                      b.`nama`,
                                      c.`nm_status`
                                    FROM
                                      `penilaian_tipologi` a
                                      JOIN `users` b
                                        ON a.`fasilitator_id` = b.`id`
                                      JOIN `status_penilaian` c
                                        ON a.`id_status_penilaian` = c.`id_status`
                                    WHERE a.`validator_id` = '$user_id'
                                      AND a.`periode` = '$periode'
                                      AND a.`id_status_penilaian` IN('2','3','4')
                                    GROUP BY a.`fasilitator_id`
                                    ORDER BY b.`nama`")->result();

    foreach ($val as $v) {
      // Ambil jumlah data pt 
      $v->jml_pt = $this->db->query("SELECT
                                        kode_pt
                                      FROM
                                        penilaian_tipologi
                                      WHERE `fasilitator_id` = '$v->fasilitator_id' AND `validator_id` = '$user_id'
                                        AND `periode` = '$periode'
                                        AND `id_status_penilaian` IN('2','3','4')
                                      GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data valid
      $v->jml_valid = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `fasilitator_id` = '$v->fasilitator_id' AND `validator_id` = '$user_id'
                                            AND `periode` = '$periode'
                                            AND `id_status_penilaian` ='4'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data revisi
      $v->jml_revisi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `fasilitator_id` = '$v->fasilitator_id' AND `validator_id` = '$user_id'
                                            AND `periode` = '$periode'
                                            AND `id_status_penilaian` ='3'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data belum validasi
      $v->jml_blm_validasi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `fasilitator_id` = '$v->fasilitator_id' AND `validator_id` = '$user_id'
                                            AND `periode` = '$periode'
                                            AND `id_status_penilaian` ='2'
                                          GROUP BY `kode_pt`")->num_rows();
    }

    // Lempar data ke view
    $data['val'] = $val;


    $this->load->view("admin/master/validator/daftar_fasilitator", $data);
  }

  public function penilaian_validator($fasilitator_id_encrypt, $periode_encrypt)
  {
    $fasilitator_id   = safe_url_decrypt($fasilitator_id_encrypt);
    $periode          = safe_url_decrypt($periode_encrypt);
    $user_id          = $this->session->userdata('user_id');

    // die("$fasilitator_id - $periode - $user_id");

    $data['periode']        = $periode;
    $data['fasilitator_id'] = $fasilitator_id;
    $data['validator_id']   = $user_id;
    $data['cek_penilaian'] = 'active';

    $bk = $this->db->query("SELECT * FROM `buka_tutup` WHERE `id` = '2'")->row();
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

    // Query dasar
    $query = $this->db->query("SELECT
                                a.*,
                                b.`nm_status`,
                                c.`nama`
                              FROM
                                penilaian_tipologi a
                                JOIN `status_penilaian` b
                                  ON a.`id_status_penilaian` = b.`id_status`
                                JOIN `users` c
                                  ON a.`fasilitator_id` = c.`id`
                              WHERE a.`fasilitator_id` = '$fasilitator_id' AND a.`validator_id` = '$user_id'
                                AND a.`periode` = '$periode'");

    // Ambil satu baris data penilaian
    $data['fas'] = $query->row();

    // Ambil semua data penilaian
    $data['data_pt_binaan_result'] = $query->result();

    $this->load->view("admin/master/validator/v_penilaian_validator", $data);
  }

  function simpan_validasi()
  {
    $user_id                = $this->session->userdata('user_id');

    // Ambil data dari POST
    $fasilitator_id                = $this->input->post("fasilitator_id", true);
    $periode                       = $this->input->post("periode", true);
    $id_penilaian_tipologi         = $this->input->post("id_penilaian_tipologi", true);
    $cek_1a                        = $this->input->post("cek_1a", true);
    $cek_1b                        = $this->input->post("cek_1b", true);
    $cek_2                         = $this->input->post("cek_2", true);
    $catatan_1a                    = $this->input->post("catatan_1a", true);
    $catatan_1b                    = $this->input->post("catatan_1b", true);
    $catatan_2                     = $this->input->post("catatan_2", true);
    $catatan_keseluruhan           = $this->input->post("catatan_keseluruhan", true);
    $catatan_1a_validator          = $this->input->post("catatan_1a_validator", true);
    $catatan_1b_validator          = $this->input->post("catatan_1b_validator", true);
    $catatan_2_validator           = $this->input->post("catatan_2_validator", true);
    $catatan_keseluruhan_validator = $this->input->post("catatan_keseluruhan_validator", true);
    $skor_1a                       = $this->input->post("skor_1a", true);
    $skor_1b                       = $this->input->post("skor_1b", true);
    $skor_2                        = $this->input->post("skor_2", true);
    $skor_1_bobot                  = $this->input->post("skor_1_bobot", true);
    $skor_2_bobot                  = $this->input->post("skor_2_bobot", true);
    $skor_total                    = $this->input->post("skor_total", true);

    // die("$catatan_keseluruhan");

    if ($cek_1a == "" || $cek_1b == "" || $cek_2 == "") {
      $id_status_penilaian = 3; // revisi validator
    } else {
      $id_status_penilaian = 4; // valid
    }

    // Mulai transaksi database
    $this->db->trans_start();

    if ($cek_1a == "") {
      $cek_1a_ok = "0";
    } else {
      $cek_1a_ok = "1";
    }
    if ($cek_1b == "") {
      $cek_1b_ok = "0";
    } else {
      $cek_1b_ok = "1";
    }
    if ($cek_2 == "") {
      $cek_2_ok = "0";
    } else {
      $cek_2_ok = "1";
    }

    // Siapkan data untuk disimpan
    $data = [
      'cek_1a' => $cek_1a_ok,
      'cek_1b' => $cek_1b_ok,
      'cek_2' => $cek_2_ok,
      'catatan_1a_validator' => $catatan_1a_validator,
      'catatan_1b_validator' => $catatan_1b_validator,
      'catatan_2_validator' => $catatan_2_validator,
      'catatan_keseluruhan_validator' => $catatan_keseluruhan_validator,
      'id_status_penilaian' => $id_status_penilaian
    ];
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);

    $this->db->insert('rwy_penilaian_validator', [
      'cek_1a' => $cek_1a_ok,
      'cek_1b' => $cek_1b_ok,
      'cek_2' => $cek_2_ok,
      'catatan_1a' => $catatan_1a,
      'catatan_1b' => $catatan_1b,
      'catatan_2' => $catatan_2,
      'catatan_keseluruhan' => $catatan_keseluruhan,
      'id_penilaian_tipologi' => $id_penilaian_tipologi,
      'id_status_penilaian' => $id_status_penilaian,
      'validator_id' => $user_id,
      'catatan_1a_validator' => $catatan_1a_validator,
      'catatan_1b_validator' => $catatan_1b_validator,
      'catatan_2_validator' => $catatan_2_validator,
      'skor_1a' => $skor_1a,
      'skor_1b' => $skor_1b,
      'skor_2' => $skor_2,
      'skor_1_bobot' => $skor_1_bobot,
      'skor_2_bobot' => $skor_2_bobot,
      'skor_total' => $skor_total,
      'catatan_keseluruhan_validator' => $catatan_keseluruhan_validator
    ]);

    // Selesaikan transaksi database
    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
      $this->session->set_flashdata('success', 'Validasi berhasil disimpan.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menyimpan validasi.');
    }

    redirect('penilaian-validator/' . safe_url_encrypt($fasilitator_id) . '/' . safe_url_encrypt($periode));
  }

  public function rwy_validator($id_penilaian_topologi_encrypt)
  {
    $id_penilaian_topologi  = safe_url_decrypt($id_penilaian_topologi_encrypt);
    $user_id                = $this->session->userdata('user_id');
    $data['cek_penilaian'] = 'active';

    $val = $this->db->query("SELECT
                                a.*,
                                b.`periode`,
                                b.`nama_pt`,
                                b.`kode_pt`,
                                c.`nama`,
                                d.`nm_status`
                              FROM
                                `rwy_penilaian_validator` a
                                JOIN `penilaian_tipologi` b
                                  ON a.`id_penilaian_tipologi` = b.`id_penilaian_tipologi`
                                JOIN `users` c
                                  ON b.`fasilitator_id` = c.`id`
                                JOIN `status_penilaian` d
                                  ON a.`id_status_penilaian` = d.`id_status`
                              WHERE a.`id_penilaian_tipologi` = '$id_penilaian_topologi'
                                AND b.`validator_id` = '$user_id'
                                ORDER BY a.`created_at` DESC");

    $data['da']   = $val->row();
    $data['val']  = $val->result();

    $this->load->view("admin/master/validator/v_rwy_validator", $data);
  }
}
