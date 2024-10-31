<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_matching_code extends Timework_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ums/M_ums_department');
		$this->load->model('hr/M_hr_order_person');
		$this->load->model('hr/M_hr_matching_code');
		$this->load->model('hr/M_hr_person');
		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/timework/Timework_matching_code";
	}
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['dp_info'] = $this->M_ums_department->get_all()->result();
		$data['controller_dir'] = "hr/timework/Timework_matching_code/";
		$this->output('hr/timework/matching_code/v_timework_matching_code_show', $data);
	}
	public function get_person_list()
	{
		$dp_id = $this->input->post('dp_id');
		$pos_status = $this->input->post('pos_status');
		$person_info = $this->M_hr_order_person->get_order_person_data_by_option(1, $dp_id, 'Y', $pos_status)->result();
		foreach ($person_info as $key => $value) {
			$this->M_hr_matching_code->mc_dp_id = $dp_id;
			$this->M_hr_matching_code->mc_ps_id = $value->ps_id;
			$mc_detail = $this->M_hr_matching_code->get_person_matching_code()->row();
			if ($mc_detail) {
				$value->mc_code = $mc_detail->mc_code;
			} else {
				$value->mc_code = null;
			}
			$value->ps_id = encrypt_id($value->ps_id);
		}
		echo json_encode($person_info);
	}
	// For show page
	public function edit($ps_id = null, $dp_id = null)
	{
		$ps_id = decrypt_id($ps_id);
		$this->M_hr_person->ps_id = $ps_id;
		$data['controller_dir'] = 'hr/timework/Timework_matching_code/';
		$data['matching_detail'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['mc_code'] = $this->M_hr_person->get_matching_code($ps_id, $dp_id)->row();
		$data['dp_id'] = $dp_id;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('hr/timework/matching_code/v_timework_matching_code_form', $data);
	}
	public function check_code_already_use()
	{
		$mc_code = $this->input->post('mc_code');
		$this->M_hr_matching_code->mc_code = $mc_code;
		$check = $this->M_hr_matching_code->get_matching_code()->row();
		if ($check)  {
			$data['status_response'] = $this->config->item('status_response_error');
		} else {
			$data['status_response'] = $this->config->item('status_response_success');
		}
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function add()
	{
		//// case success
		$data['returnUrl'] = base_url() . 'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function submitMactingCode()
	{
		$mc_info = $this->input->post();
		if ($mc_info['mc_id'] == null) {
			$this->M_hr_matching_code->mc_ps_id = $mc_info['mc_ps_id'];
			$this->M_hr_matching_code->mc_code = $mc_info['mc_code'];
			$this->M_hr_matching_code->mc_dp_id = $mc_info['mc_dp_id'];
			$this->M_hr_matching_code->insert();
			$data['method'] = 1;
		} else {
			$this->M_hr_matching_code->mc_id = $mc_info['mc_id'];
			$this->M_hr_matching_code->mc_ps_id = $mc_info['mc_ps_id'];
			$this->M_hr_matching_code->mc_code = $mc_info['mc_code'];
			$this->M_hr_matching_code->mc_dp_id = $mc_info['mc_dp_id'];
			$this->M_hr_matching_code->update();
			$data['method'] = 2;
		}
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function update()
	{
		//// case success
		$data['returnUrl'] = base_url() . 'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function delete($StID)
	{
		// $data['returnUrl'] = base_url().'index.php/ums/Base_title';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
}
