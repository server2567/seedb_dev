<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_log extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/timework/Timework_log";
	}

	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_log_show', $data);
	}
	public function get_Time__log_view()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_log_form_user', $data);
	}
	public function get_Time__log_edit_all($StID=null)
	{
		$data['StID'] = $StID;

		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_log_form_all', $data);
	}
	public function get_Time__log_edit_user($StID=null)
	{
		$data['StID'] = $StID;
		
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_log_form_user', $data);
	}
}
