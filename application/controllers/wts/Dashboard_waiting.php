<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../ums/UMS_Controller.php");

class Dashboard_waiting extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/dashboard/v_dashboard_report_waiting',$data);
  	}
	
	  public function reportPatient() {
		$data['session_mn_active_url'] = uri_string(); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/dashboard/v_dashboard_report_waiting_patient.php',$data);
	}

}
?>