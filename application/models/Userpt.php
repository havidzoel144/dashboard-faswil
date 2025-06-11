<?php


//namespace Silat;


/**
 * @author LENOVO
 * @version 1.0
 * @created 28-Jun-2019 3:55:18 PM
 */
class UserPt extends CI_Model
{

	private $email;
	private $id;
	private $kodePt;
	private $name;
	private $password;
	private $rememberToken;
	private $status;
	private $tipe;
	private $userName;

	function __construct($id=NULL)
	{
            if($id!=NULL){
                $this->db->select('*');
                $this->db->from('users');
                $this->db->where('id',$id);
                $result = $this->db->get();
                if($result->num_rows() > 0){
                    $row = $result->row();
                    $this->id = $row->id;
                    $this->name = $row->name;
                    $this->email = $row->email;
                    $this->password = $row->password;
                    $this->status = $row->status;
                    $this->tipe = $row->tipe;
                    $this->kodePt = $row->kode_pt;
                    $this->rememberToken = $row->remember_token;
                }
            }
	}

	function __destruct()
	{
	}



	public function getEmail()
	{
		return $this->email;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getKodePt()
	{
		return $this->kodePt;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getRememberToken()
	{
		return $this->rememberToken;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getTipe()
	{
		return $this->tipe;
	}

	public function getUserName()
	{
		return $this->userName;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKodePt($newVal)
	{
		$this->kodePt = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setName($newVal)
	{
		$this->name = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPassword($newVal)
	{
		$this->password = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setRememberToken($newVal)
	{
		$this->rememberToken = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setStatus($newVal)
	{
		$this->status = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTipe($newVal)
	{
		$this->tipe = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserName($newVal)
	{
		$this->userName = $newVal;
	}
        
        public function login($username, $password)
        {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('username',$username);
            $this->db->where('password',md5($password));
            $result = $this->db->get();
            //print_r($result);
            if($result->num_rows()>0){
                $row = $result->row();
                $this->id = $row->id;
                $this->name = $row->name;
                $this->userName = $row->username;
                $this->email = $row->email;
                $this->password = $row->password;
                $this->status = $row->status;
                $this->tipe = $row->tipe;
                $this->kodePt = $row->kode_pt;
                $this->rememberToken = $row->remember_token;
                return TRUE;
            }else{
                return FALSE;
            }
        }

}
?>