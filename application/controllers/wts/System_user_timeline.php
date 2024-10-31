<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../ums/UMS_Controller.php");

class System_user_timeline extends UMS_Controller
{
	private $mn_active_id = 600001;
	public function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data['session_mn_active_id'] = $this->mn_active_id; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/system/v_system_user_timeline',$data);
  	}
	
}
?>