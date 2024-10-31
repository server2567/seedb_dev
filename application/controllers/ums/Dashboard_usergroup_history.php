<?php 
/*
* User
* Main controller of Dashboard_usergroup_history
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 17/06/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class Dashboard_usergroup_history extends UMS_Controller{

	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of Dashboard_usergroup_history
	* @input -
	* $output usergroup_history list
	* @author Areerat Pongurai
	* @Create Date 17/06/2024
	*/
	public function index() {
		// get filter from form client
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		$pos_ps_code = $this->input->post("pos_ps_code");
		$us_username = $this->input->post("us_username");
		$us_name = $this->input->post("us_name");
		
		// set filter
		$filter = [];
		if (!empty($pos_ps_code)) {
			$filter['pos_ps_code'] = $pos_ps_code;
			$data['search']['pos_ps_code'] = $pos_ps_code;
		}
		if (!empty($us_username)) {
			$filter['us_username'] = $us_username;
			$data['search']['us_username'] = $us_username;
		}
		if (!empty($us_name)) {
			$filter['us_name'] = $us_name;
			$data['search']['us_name'] = $us_name;
		}
		
		if (!empty($start_date)) {
			$start_date = explode("/",$start_date);
			$year = $start_date[count($start_date) - 1] - 543;
			$start_string = $start_date[0] . '-' . $start_date[1] . '-' . $year . ' 00:00:00';
			$start_date = (new DateTime($start_string))->format('Y-m-d H:i:s');
			$filter['start_date'] = $start_date;
			$data['search']['start_date'] = $start_date;
		} 
		
		if (!empty($end_date)) {
			$end_date = explode("/",$end_date);
			$year = $end_date[count($end_date) - 1] - 543;
			$end_string = $end_date[0] . '-' . $end_date[1] . '-' . $year . ' 23:59:59';
			$end_date = (new DateTime($end_string))->format('Y-m-d H:i:s');
			$filter['end_date'] = $end_date;
			$data['search']['end_date'] = $end_date;
		} 

		// get list
		$this->load->model('ums/m_ums_usergroup_history');
		$usergroup_histories = $this->m_ums_usergroup_history->get_all($filter)->result_array();

		// encrypt id
		$names = ['ughi_id']; // object name need to encrypt 
		$data['usergroup_histories'] = encrypt_arr_obj_id($usergroup_histories, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/dashboard/v_dashboard_usergroup_history_show',$data);
	}
}
?>
