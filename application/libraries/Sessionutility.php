<?php
//require_once ('..\..\..\newevapro\application\models\modusers.php');

//namespace Library;


/**
 * @author user
 * @version 1.0
 * @created 14-Sep-2014 10:55:11 AM
 */
class SessionUtility
{

	//public $m_ModUsers;
        protected $CI;
        private $isSecure = TRUE;
        
	function __construct()
	{
            $this->CI =& get_instance();		
            // Load the Sessions class
            $this->CI->load->library('session');
            $this->CI->load->model('modusers');
            $this->CI->load->model('moduseraccess');
            $this->CI->load->model('modsysteminformation');
            $this->CI->load->model('modsystemmodule');
            $this->CI->load->model('modsubsystemmodule');
            $this->CI->load->model('modunitkerja');
          //  $this->CI->load->model('moduseractivity');
//            $state = $this->CI->session->userdata('is_loged_in');
//            if(!$state==TRUE){
//                redirect(base_url() . 'backoffice');
//            }
	}

	function __destruct()
	{
	}

        public function validateSession()
        {
            $acc = FALSE;
            $status = strtoupper($this->CI->session->userdata('is_loged_in'));
            if($status==TRUE){
                $acc = TRUE;
            }
            return $acc;
        }
        
        public function validateAccess($module)
        {
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $class = get_class($module);
            $access = new ModSubSystemModule('');
            $access->setUserId($user->getUserId());
            $subsysmodule = $access->getObjectList('', '');
            $uri = explode('/', $this->CI->uri->uri_string());            
            
            if(count($subsysmodule)>0){
                foreach ($subsysmodule->result() as $value) {    
                    $systemodule = new ModSystemModule($value->module_id);
                    if($systemodule->getModuleName() == $class){
                        if(count($uri)<=2){
                            if($value->sub_module_name=='index'){
                                $acc = TRUE;
                                break;
                            }
                        }elseif(strtolower($value->sub_module_name) == strtolower($uri[2])){
                            $acc = TRUE;
                            //$accessType = new ModAccessType($value->getAccessTypeId());
                            if($value->access_type_id == '1' || 
                                    $value->access_type_id == '3' ||
                                    $value->access_type_id == '4'){
                                
                                $userActivity = new ModUserActivity('');
                                $userActivity->m_ModUsers = new ModUsers($userid);
                                $qrystring = $this->CI->uri->uri_string();
                                $userActivity->setModuleAccessed($qrystring);
                                $userActivity->settimeAccessed(date('c'));
                                $userActivity->insert();
                            }
                            break;
                        }
                    }                
                }
            }
            if($this->isSecure){
                return $acc;
            }else{
                return TRUE;
            }
        }       

	public function isAdministrator()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'Administrator'){
                $acc = TRUE;
            }
            return $acc;
	}

	public function isEndUser()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'End User'){
                $acc = TRUE;
            }
            return $acc;
	}

	public function isSupervisor()
	{
            $userid = strtoupper($this->CI->session->userdata('userid'));
            $acc = FALSE;
            $user = new ModUsers($userid);
            $userType = new ModUserType($user->getUserType());
            if($userType->getTypeName() == 'Supervisor'){
                $acc = TRUE;
            }
            return $acc;
	}
        
        public function isLogedIn()
        {
            
        }
       
}
?>