<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Leave_approve_status extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Leave_approve_status";
	}
	/*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function index()
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['controller'] = 'hr/base/';
		$data['Leave_approve_status'] = $this->M_hr_leave_approve->get_all_by_active()->result();
		foreach ($data['Leave_approve_status'] as $key => $value) {
			$value->last_id = encrypt_id($value->last_id);
		}
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('hr/base/v_base_leave_approve_status_show', $data);
	}
	public function filter_Leave_approve_status()
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$data = $this->M_hr_leave_approve->get_all_by_active()->result();
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* get_Leave_approve_status_form
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_Leave_approve_status_form($last_id = null)
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$this->M_hr_leave_approve->last_id = decrypt_id($last_id);
		$data['Leave_approve_status'] = $this->M_hr_leave_approve->get_by_id()->row();
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_leave_approve_status_form', $data);
	}
	/*
	* submit_Leave_approve_status
	* สำหรับการบันทึกข้อมูลสถานะการอนุมัติการลา*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function submit_Leave_approve_status()
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$last_id = $this->input->post('last_id');
		$this->M_hr_leave_approve->last_name = $this->input->post('last_name');
		$this->M_hr_leave_approve->last_mean = $this->input->post('last_mean');
		$this->M_hr_leave_approve->last_yes = $this->input->post('last_yes');
		$this->M_hr_leave_approve->last_no = $this->input->post('last_no');
		$this->M_hr_leave_approve->last_desc = $this->input->post('last_desc');
		$this->M_hr_leave_approve->last_active = $this->input->post('last_active');
		if ($last_id != null) {
			$this->M_hr_leave_approve->last_id = $this->input->post('last_id');
			$this->M_hr_leave_approve->last_update_user = $this->session->userdata('us_ps_id');
			$this->M_hr_leave_approve->update();
		} else {
			$this->M_hr_leave_approve->last_create_user = $this->session->userdata('us_ps_id');
			$this->M_hr_leave_approve->insert();
		}
	}
	/*
	* delete_Leave_approve_status
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_Leave_approve_status($last_id = null)
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$this->M_hr_leave_approve->last_id = decrypt_id($last_id);
		$this->M_hr_leave_approve->last_active = '2';
		$this->M_hr_leave_approve->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Leave_approve_status';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก*
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "M_hr_leave_approve");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->M_hr_leave_approve->$key = $value;
		}
		$query = $this->M_hr_leave_approve->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
