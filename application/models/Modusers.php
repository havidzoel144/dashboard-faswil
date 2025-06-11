<?php
require_once ('Modunitkerja.php');
require_once ('Imodel.php');
require_once ('Moduseraccess.php');
require_once ('Modusertype.php');
//require_once ('modsubsystemmodule.php');
/**
 * @author user
 * @version 1.0
 * @created 10-Sep-2014 11:12:57 AM
 */
class ModUsers extends CI_Model implements IModel
{

	private $password;
	private $userId;
	private $userName;
	private $userStatus;
	private $userType;
	public $m_ModUnitKerja;
	//public $m_ModUserAccess;
	public $m_ModUserType;
	private $email;
	//public $m_ModSubSystemModule;
	public $m_ModUserAccess;
	private $unitId;
	private $idEvaluator;
	public $m_ModSubSystemModule;
	//public $m_ModUserAccess;

	function __construct($id='')
	{
            parent::__construct();
            if($id != ''){
                
                $this->db->select('*');
                $this->db->from('sil_users');
                $this->db->where('user_id', $id);
                $result = $this->db->get('');
            	//$sql = "select * from sil_users where user_id='".$id."';";
            	//$result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result() as $value) {
                        $this->setUserId($value->user_id);
                        $this->setPassword($value->password);
                        $this->setUserName($value->user_name);
                        $this->setUserType($value->user_type);
                        $this->setUserStatus($value->user_status);
                        $this->setUnitId($value->unit_id);
                        $this->setUserType($value->user_type);
                        $this->setEmail($value->email);
                        //$this->m_ModUnitKerja = new ModUnitKerja($value->unit_id);                        
                        //$this->m_ModUserType = new ModUserType($value->user_type);
                        //$this->m_ModUserAccess = new ModUserAccess($value->user_id);
                                                
                    }
                }
                
            }
	}

	function __destruct()
	{
	}



	public function delete()
	{
            $this->db->delete('sil_users', array('user_id'=>  $this->getUserId()));
	}

	/**
	 * 
	 * @param criteria
	 * @param value
	 * @param row
	 * @param segment    segment
	 */
	public function getObjectFiltered($criteria, $value, $row, $segment)
	{
            $list = new ArrayObject();
            $this->db->select('*');
            $this->db->from('sil_users us');       
            $this->db->join('unit_kerja uk', 'us.unit_id = uk.unit_id');
            
            if($criteria=='username'){
                $this->db->like('user_name',$value,'both');
            }elseif($criteria=='usertype'){
                $this->db->like('user_type',$value,'both');
            }elseif($criteria=='unitname'){
                $this->db->like('uk.unit_name',$value,'both');
            }
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('user_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUsers($row->user_id);
                $list->append($obj);
            }
            return $list;
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function getObjectList($row, $segment)
	{
            $list = new ArrayObject();
            $this->db->select('*');
            $this->db->from('sil_users');                
            
            $result = '';
            if($row=='' && $segment==''){
                $this->db->order_by('user_id','asc');
                $result = $this->db->get('');
            }else{
                $result = $this->db->get('',$row,$segment);
            }
            foreach($result->result() as $row){
                $obj = new ModUsers($row->user_id);
                $list->append($obj);
            }
            return $list;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function getUserName()
	{
		return $this->userName;
	}

	public function getUserStatus()
	{
		return $this->userStatus;
	}

	public function getUserType()
	{
		return $this->userType;
	}

	public function insert()
	{
            $data = array('user_id'=>  $this->getUserId(),
                    'user_name'=>  $this->getUserName(),
                    'unit_id'=>  $this->m_ModUnitKerja->getUnitId(),
                    'password'=>  md5($this->getPassword()),
                    'user_type'=>  $this->m_ModUserType->getUserType(),
                    'email'=>  $this->getEmail(),
                    'user_status'=> $this->getUserStatus());
                $this->db->insert('sil_users', $data);
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
	public function setUserId($newVal)
	{
		$this->userId = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserName($newVal)
	{
		$this->userName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserStatus($newVal)
	{
		$this->userStatus = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUserType($newVal)
	{
		$this->userType = $newVal;
	}

	public function update()
	{
            $data = array('user_id'=>  $this->getUserId(),
                    'user_name'=>  $this->getUserName(),
                    'unit_id'=>  $this->m_ModUnitKerja->getUnitId(),
                    //'password'=>  $this->getPassword(),
                    'user_type'=>  $this->m_ModUserType->getUserType(),
                    'email'=>  $this->getEmail(),
                    'user_status'=> $this->getUserStatus());
            
                $this->db->where('user_id', $this->getUserId());
            $this->db->update('sil_users', $data);
	}
        
        public function updatePassword()
        {
            $data = array('password'=>  md5($this->getPassword()));
            $this->db->where('user_id', $this->getUserId());
            $this->db->update('sil_users', $data);
        }
        
        public function login()
        {
            $this->db->select('*');
            $this->db->from('sil_users');
            $this->db->where('user_id', strtoupper($this->getUserId()));
            $this->db->where('password', md5($this->getPassword()));
            $result = $this->db->get();
            if($result->num_rows()>0){        	
            	foreach ($result->result() as $value) {
                    $this->setUserId($value->user_id);
                    $this->setPassword($value->password);
                    $this->setUserName($value->user_name);
                    $this->setUserType($value->user_type);
                    $this->setUserStatus($value->user_status);
                    $this->setUnitId($value->unit_id);
                    $this->setUserType($value->user_type);
                    $this->setEmail($value->email);
                    //$this->m_ModUnitKerja = new ModUnitKerja($value->unit_id);                        
                    //$this->m_ModUserType = new ModUserType($value->user_type);
                    //$this->m_ModUserAccess = new ModUserAccess($value->user_id);

                }
        	return TRUE;
            }else{
                return FALSE;
            }
        }

	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	public function getUnitId()
	{
		return $this->unitId;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUnitId($newVal)
	{
		$this->unitId = $newVal;
	}

	public function getIdEvaluator()
	{
		return $this->idEvaluator;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdEvaluator($newVal)
	{
		$this->idEvaluator = $newVal;
	}
        
        public function isEvaluator()
        {
            $this->db->select('*');
            $this->db->from('evaluator');
            $this->db->where('kd_evaluator', $this->userId);
            $result = $this->db->get();
            if($result->num_rows()>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }

}
?>