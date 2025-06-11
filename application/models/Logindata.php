<?php

require_once ('Imodel.php');
//namespace Silat;


/**
 * @author LENOVO
 * @version 1.0
 * @created 22-Jun-2019 2:51:42 PM
 */
class LoginData extends CI_Model implements IModel
{

	private $expired;
	private $ipAddress;
	private $loginDate;
	private $sessionId;
	private $state;
	private $timeStamp;
	private $userData;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id!=NULL){
                $this->db->select('*');
                $this->db->from('sil_login_data');
                $this->db->where('session_id',  $id);
                $result = $this->db->get();
                if($result->num_rows() > 0){
                    $row = $result->row();
                    $this->sessionId = $row->session_id;
                    $this->ipAddress = $row->ip_address;
                    $this->timeStamp = $row->timestamp;
                    $this->expired = $row->expired;
                    $this->loginDate = $row->login_date;
                    $this->userData = $row->user_data;
                    $this->state = $row->state;
                }
            }
	}

	function __destruct()
	{
	}



	public function getExpired()
	{
		return $this->expired;
	}

	public function getIpAddress()
	{
		return $this->ipAddress;
	}

	public function getLoginDate()
	{
		return $this->loginDate;
	}

	public function getSessionId()
	{
		return $this->sessionId;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getTimeStamp()
	{
		return $this->timeStamp;
	}

	public function getUserData()
	{
		return $this->userData;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setExpired($newVal)
	{
		$this->expired = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIpAddress($newVal)
	{
		$this->ipAddress = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setLoginDate($newVal)
	{
		$this->loginDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSessionId($newVal)
	{
		$this->sessionId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setState($newVal)
	{
		$this->state = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTimeStamp($newVal)
	{
		$this->timeStamp = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserData($newVal)
	{
		$this->userData = $newVal;
	}

    public function delete() {
        
    }

    public function getObjectFiltered($criteria, $value, $row, $segment) {
        
    }

    public function getObjectList($row, $segment) {
        
    }

    public function insert() {
        $data = array(
            'session_id' => $this->sessionId,
            'ip_address' => $this->ipAddress,
            'timestamp' => $this->timeStamp,
            'expired' => $this->expired,
            'login_date' => $this->loginDate,
            'user_data' => $this->userData,
            'state' => $this->state
        );
        $this->db->insert('sil_login_data', $data);
    }

    public function update() {
        $data = array(
            //'session_id' => $this->sessionId,
            'ip_address' => $this->ipAddress,
            'timestamp' => $this->timeStamp,
            'expired' => $this->expired,
            'login_date' => $this->loginDate,
            'user_data' => $this->userData,
            'state' => $this->state
        );
        $this->db->update('sil_login_data', $data, array('session_id' => $this->sessionId));
    }
    
    public function isExist($session_id, $date)
    {
        $this->db->select('*');
        $this->db->from('sil_login_data');
        $this->db->where('session_id', $session_id);
        $this->db->where('login_date', $date);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}
?>