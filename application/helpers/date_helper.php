<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  function gfDateStandart($tanggal) 
  {
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return substr($tanggal,8,2)." ".$bulan[substr($tanggal,5,2)+0]." ".substr($tanggal,0,4);
  }

  function gfDateStandartShort($tanggal) 
  {
    $bulan = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
    return substr($tanggal,8,2)." ".$bulan[substr($tanggal,5,2)+0]." ".substr($tanggal,0,4);
  }

  function gfDateDay($tanggal) 
  {
    $hari = array("","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Ahad");
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return $hari[date('N')].", ".substr($tanggal,8,2)." ".$bulan[substr($tanggal,5,2)+0]." ".substr($tanggal,0,4);
  }

  function gfDateDays($tanggal) 
  {
    $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
    $tgl = substr($tanggal,8,2);
    $bln = substr($tanggal,5,2);
    $thn = substr($tanggal,0,4);
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return $hari[date('w',mktime(0, 0, 0, $bln, $tgl, $thn))].", ".substr($tanggal,8,2)." ".$bulan[substr($tanggal,5,2)+0]." ".substr($tanggal,0,4);
  }

  function close_date()
  {
    //$open_month = array('January','February','March');
    //$open_month = array('May');
    $open_month = array('September','October','November',"December");
    if(in_array(date('F'), $open_month)){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function close_date_revision($id)
  {
    $ci =& get_instance();
    $ci->load->model('usulan/modgetdata');
    $jns_usulan = $ci->modgetdata->singlerow("pro_registrasi_prodi","jns_usulan","id_registrasi",$id);

    if($jns_usulan=='P11'){
      $open_month = array('July-2016','August-2016','September-2016','October-2016');
    }else{
      $open_month = array('July-2016','August-2016','September-2016','October-2016');
    }
    //$open_month = array('October','November',"December");
    //$open_month = array('July','August','September');
    if(in_array(date('F-Y'), $open_month)){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function close_date_sosialisasi()
  {
    $open_month = array('November','December');
    if(in_array(date('F'), $open_month)){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function periode($jns_usulan){
    $ci =& get_instance();
    $ci->load->model('usulan/modgetdata');
    //$periode = $ci->modgetdata->singlerow('tbl_periode','periode','status_periode','open');
    $periode = $ci->modgetdata->singlerow2criteria('periode','tbl_periode','status_periode','open','jns_usulan',$jns_usulan);
    return $periode;
  } 

  function periodeAdmin($jns_usulan){
    $ci =& get_instance();
    $query = $ci->db->query("select periode from tbl_periode where jns_usulan ilike '%".$jns_usulan."%' order by periode desc limit 1");
    if($query->num_rows()>0){
      $row = $query->row_array();
      return $row['periode'];
    }else{
      return 0;
    }    
  } 


  function pro_periode($jns_usulan){
    $ci =& get_instance();
    $ci->load->model('usulan/modgetdata');
    $periode = $ci->modgetdata->singlerow2criteria('periode','tbl_periode','status_periode','open','jns_usulan',$jns_usulan);
    return $periode;
  } 

  function pdr_periode($jns_usulan){
    $ci =& get_instance();
    $ci->load->model('usulan/modgetdata');
    $periode = $ci->modgetdata->singlerow2criteria('periode','tbl_periode','status_periode','open','jns_usulan',$jns_usulan);
    return $periode;
  } 


  function check_periode($periode){
    $ci =& get_instance();
    $ci->load->model('usulan/modgetdata');
    $status = $ci->modgetdata->singlerow('tbl_periode','status_periode','periode',$periode);
    return trim($status);
  }

  function close_date_periode()
  {
    $ci =& get_instance();
    $periode = $ci->db->query("select * from tbl_periode where status_periode='open'");
    if($periode->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function open_menu_pdr()
  {
    $ci =& get_instance();
    $now = date('Y-m-d');
    
    $sql_1 = "select * from tbl_periode where status_periode='open' and jns_usulan ilike '%PDR%'";  
    $sql_2 = "select * from tbl_pengusul_diskresi where ('".$now."'>=open_date and '".$now."'<=close_date) and email_pengusul='".$ci->session->userdata('usl_mail')."'";
    
    $periode = $ci->db->query($sql_1);
    
    
    if($periode->num_rows()>0){

      return TRUE;

    }else{
      $diskresi = $ci->db->query($sql_2);
      if($diskresi->num_rows()>0){
        return TRUE;
      }else{
        return FALSE;  
      }
      
    }
  }

  function open_menu_pro()
  {
    $ci =& get_instance();
    $periode = $ci->db->query("select * from tbl_periode where status_periode='open' and (jns_usulan ilike '%P0%' or jns_usulan ilike '%P1%')");
    if($periode->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function date_periode($jns_usulan)
  {
    $ci =& get_instance();
    $now = date('Y-m-d');
    
    $sql_1 = "select * from tbl_periode where ('".$now."'>=open_date and '".$now."'<=close_date) and status_periode='open' and jns_usulan ilike '%".$jns_usulan."%'";
    $sql_2 = "select * from tbl_pengusul_diskresi where ('".$now."'>=open_date and '".$now."'<=close_date) and email_pengusul='".$ci->session->userdata('usl_mail')."'";
    
    $periode = $ci->db->query($sql_1);
    $diskresi = $ci->db->query($sql_2);
    
    if($periode->num_rows()>0){

      return TRUE;

    }else{

      if($diskresi->num_rows()>0){
        return TRUE;
      }else{
        return FALSE;  
      }
      
    }
  }

  function list_periode($jns_usulan)
  {
    $ci =& get_instance();
    $now = date('Y-m-d');
    
    $sql_1 = "select * from tbl_periode where ('".$now."'>=open_date and '".$now."'<=close_date) and status_periode='open' and jns_usulan ilike '%".$jns_usulan."%'";    
    
    $periode = $ci->db->query($sql_1);
        
    if($periode->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;  
    }
  }

  function check_periode_perubahan($jns_usulan,$periode)
  {
    $ci =& get_instance();
    $now = date('Y-m-d');
    
    $sql_1 = "select * from tbl_periode where periode='".$periode."' and ('".$now."'>=open_date and '".$now."'<=close_date) and status_periode='open' and jns_usulan ilike '%".$jns_usulan."%'";    
    
    $periode = $ci->db->query($sql_1);
        
    if($periode->num_rows()>0){
      return "TRUE";
    }else{
      return "FALSE";  
    }
  }

  function check_periode_prodi($jns_usulan,$periode)
  {
    $ci =& get_instance();
    $now = date('Y-m-d');
    
    $sql_1 = "select * from tbl_periode where periode='".$periode."' and ('".$now."'>=open_date and '".$now."'<=close_date) and status_periode='open' and jns_usulan ilike '%".$jns_usulan."%'";    
    
    $periode = $ci->db->query($sql_1);
        
    if($periode->num_rows()>0){
      return "TRUE";
    }else{
      return "FALSE";  
    }
  }

function romanNumerals($num) 
{
    $n = intval($num);
    $res = '';
 
    /*** roman_numerals array  ***/
    $roman_numerals = array(
                'M'  => 1000,
                'CM' => 900,
                'D'  => 500,
                'CD' => 400,
                'C'  => 100,
                'XC' => 90,
                'L'  => 50,
                'XL' => 40,
                'X'  => 10,
                'IX' => 9,
                'V'  => 5,
                'IV' => 4,
                'I'  => 1);
 
    foreach ($roman_numerals as $roman => $number) 
    {
        /*** divide to get  matches ***/
        $matches = intval($n / $number);
 
        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);
 
        /*** substract from the number ***/
        $n = $n % $number;
    }
 
    /*** return the res ***/
    return $res;
}   