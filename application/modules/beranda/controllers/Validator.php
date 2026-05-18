<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validator extends MX_Controller
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

    $this->only_for_roles(['5']);
  }

  public function index()
  {
    $user_id                = $this->session->userdata('user_id');
    $data['cek_penilaian']  = 'active';
    $val                    = $this->db->query("SELECT
                                                  *
                                                FROM
                                                  `penilaian_tipologi` a
                                                JOIN periode b ON a.periode = b.kode
                                                WHERE a.`validator_id`='$user_id'
                                                -- AND a.`id_status_penilaian` IN('1','2','3','4','5')
                                                GROUP BY a.`periode`
                                                ORDER BY a.periode DESC")->result();
    foreach ($val as $v) {
      // Ambil jumlah data pt 
      $v->jml_pt = $this->db->query("SELECT
                                        kode_pt
                                      FROM
                                        penilaian_tipologi
                                      WHERE `validator_id` = '$user_id'
                                        AND `periode` = '$v->periode'
                                        -- AND `id_status_penilaian` IN('1','2','3','4','5')
                                      GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data menunggu approval admin
      $v->jml_menunggu_approval_admin = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='6'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data draft validator
      $v->jml_draft = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='5'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data valid
      $v->jml_valid = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='4'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data revisi
      $v->jml_revisi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='3'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data belum validasi
      $v->jml_blm_validasi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='2'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah input faswil
      $v->jml_input_faswil = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='1'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah faswil belum input
      $v->jml_faswil_belum_input = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` IS NULL
                                          GROUP BY `kode_pt`")->num_rows();
    }

    // Lempar data ke view
    $data['val'] = $val;

    $this->load->view("admin/master/validator/index", $data);
  }

  public function penilaian_validator($periode_encrypt)
  {
    $periode          = safe_url_decrypt($periode_encrypt);
    $user_id          = $this->session->userdata('user_id');

    $data['periode']        = $periode;
    $data['validator_id']   = $user_id;
    $data['cek_penilaian']  = 'active';

    $bk           = $this->db->query("SELECT * FROM `buka_tutup` WHERE `id` = '2'")->row();
    $data['dabk'] = $bk;
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    $data['bt']   = $bk;

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
                                c.`nama`,
                                d.keterangan
                              FROM
                                penilaian_tipologi a
                                LEFT JOIN `status_penilaian` b
                                  ON a.`id_status_penilaian` = b.`id_status`
                                JOIN `users` c
                                  ON a.`fasilitator_id` = c.`id`
                                JOIN `periode` d
                                  ON a.`periode` = d.`kode`
                              WHERE a.`validator_id` = '$user_id'
                                AND a.`periode` = '$periode' 
                                -- AND a.`id_status_penilaian` IN('2','3','4','5')
                                ORDER BY a.`id_penilaian_tipologi` ASC");

    // Ambil satu baris data penilaian
    $data['fas'] = $query->row();

    // Ambil semua data penilaian
    $data['data_pt_binaan_result'] = $query->result();

    $this->load->view("admin/master/validator/v_penilaian_validator", $data);
  }

  function simpan_validasi()
  {
    $user_id                = $this->session->userdata('user_id');
    $periode                = $this->input->post('periode');

    // Ambil data dari POST
    $id_penilaian_tipologi         = $this->input->post("id_penilaian_tipologi", true);
    $cek_1                         = $this->input->post("cek_1", true);
    $cek_2                         = $this->input->post("cek_2", true);
    $cek_3                         = $this->input->post("cek_3", true);
    $cek_4                         = $this->input->post("cek_4", true);
    $catatan_1_validator           = $this->input->post("catatan_1_validator", true);
    $catatan_2_validator           = $this->input->post("catatan_2_validator", true);
    $catatan_3_validator           = $this->input->post("catatan_3_validator", true);
    $catatan_4_validator           = $this->input->post("catatan_4_validator", true);
    $catatan_keseluruhan_validator = $this->input->post("catatan_keseluruhan_validator", true);
    $id_status_penilaian           = 5; // default draft validator

    // Mulai transaksi database
    $this->db->trans_start();

    // Siapkan data untuk disimpan
    $data = [
      'cek_1' => $cek_1,
      'cek_2' => $cek_2,
      'cek_3' => $cek_3,
      'cek_4' => $cek_4,
      'catatan_1_validator' => $catatan_1_validator,
      'catatan_2_validator' => $catatan_2_validator,
      'catatan_3_validator' => $catatan_3_validator,
      'catatan_4_validator' => $catatan_4_validator,
      'catatan_keseluruhan_validator' => $catatan_keseluruhan_validator,
      'id_status_penilaian' => $id_status_penilaian,
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);

    $data_penilaian = $this->db->get_where('penilaian_tipologi', ['id_penilaian_tipologi' => $id_penilaian_tipologi])->row();

    $this->db->insert('rwy_penilaian_validator', [
      'cek_1' => $data_penilaian->cek_1,
      'cek_2' => $data_penilaian->cek_2,
      'cek_3' => $data_penilaian->cek_3,
      'cek_4' => $data_penilaian->cek_4,
      'catatan_1' => $data_penilaian->catatan_1,
      'catatan_2' => $data_penilaian->catatan_2,
      'catatan_3' => $data_penilaian->catatan_3,
      'catatan_4' => $data_penilaian->catatan_4,
      'catatan_keseluruhan' => $data_penilaian->catatan_keseluruhan,
      'id_penilaian_tipologi' => $data_penilaian->id_penilaian_tipologi,
      'id_status_penilaian' => $data_penilaian->id_status_penilaian,
      'validator_id' => $user_id,
      'catatan_1_validator' => $data_penilaian->catatan_1_validator,
      'catatan_2_validator' => $data_penilaian->catatan_2_validator,
      'catatan_3_validator' => $data_penilaian->catatan_3_validator,
      'catatan_4_validator' => $data_penilaian->catatan_4_validator,
      'catatan_keseluruhan_validator' => $data_penilaian->catatan_keseluruhan_validator,
      'skor_1' => $data_penilaian->skor_1,
      'skor_2' => $data_penilaian->skor_2,
      'skor_3' => $data_penilaian->skor_3,
      'skor_4' => $data_penilaian->skor_4,
      'skor_total' => $data_penilaian->skor_total
    ]);

    // Selesaikan transaksi database
    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
      $this->session->set_flashdata('success', 'Validasi berhasil disimpan.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menyimpan validasi.');
    }

    redirect('penilaian-validator/' . safe_url_encrypt($periode));
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

    // echo json_encode($data);exit;

    $this->load->view("admin/master/validator/v_rwy_validator", $data);
  }

  public function kirim_nilai($enc_periode, $enc_id = 'semua')
  {
    $periode = safe_url_decrypt($enc_periode);
    $id_penilaian = safe_url_decrypt($enc_id);
    $validator_id = $this->session->userdata('user_id');

    $kirim_nilai = $this->Penilaian_model->prosesNilai($periode, $id_penilaian, $validator_id);

    if ($kirim_nilai) {
      $this->session->set_flashdata('success', 'Data berhasil diproses');
    } else {
      $this->session->set_flashdata('error', 'Gagal memproses nilai');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function ubah_status_penilaian($enc_id_penilaian)
  {
    $id_penilaian = safe_url_decrypt($enc_id_penilaian);
    $ubah_status_penilaian = $this->Penilaian_model->ubahStatusPenilaian($id_penilaian, 'valid');

    if ($ubah_status_penilaian) {
      $this->session->set_flashdata('success', 'Proses berhasil, menunggu approval dari admin');
    } else {
      $this->session->set_flashdata('error', 'Proses gagal');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function getDataPenilaian($enc_id_penilaian)
  {
    $id_penilaian = safe_url_decrypt($enc_id_penilaian);
    $penilaian = $this->Penilaian_model->get_data_penilaian_by_id($id_penilaian);

    if ($penilaian) {
      echo json_encode(['status' => 'success', 'data' => $penilaian]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Data penilaian tidak ditemukan']);
    }
  }
}
