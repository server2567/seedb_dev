<?php 
/*
* System_log
* Controller ประวัติการใข้งานระบบ
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 11/06/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Log_Controller.php');

class System_log extends Log_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "System_log/";
		$this->load->model($this->model.'M_hr_logs');

		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index ประวัติการใข้งานระบบ
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 11/06/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['log_agent'] = $this->M_hr_logs->get_log_agent_group()->result();
		$this->output($this->view.'v_system_log_show', $data);
	}
	// index

		/*
	* get_log_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function get_log_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$log_agent = $this->input->get('log_agent');
		$log_start_date = splitDateForm1($this->input->get('log_start_date'));
        $log_end_date = splitDateForm1($this->input->get('log_end_date'));
		
		$result = $this->M_hr_logs->get_log_list_by_param($log_start_date,  $log_end_date, $log_agent)->result();

		foreach($result as $key=>$row){
			$row->log_date = abbreDate4(splitDateDb6($row->log_date));
		}

		echo json_encode($result);
	}
	// get_log_list
}
