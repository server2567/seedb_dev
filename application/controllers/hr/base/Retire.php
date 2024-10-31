<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Retire extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Retire";
	}

	/*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function index()
	{
		$this->load->model($this->model . "m_hr_retire");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['re_info'] = $this->m_hr_retire->get_all_by_active()->result();
		$this->output('hr/base/v_base_retire_show', $data);
	}

	/*
	* get_retire_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_retire_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_retire_form', $data);
	}

	/*
	* get_retire_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_retire_edit($RetID = null)
	{
		$this->load->model($this->model . "m_hr_retire");
		$this->m_hr_retire->retire_id = $RetID;
		$re_info = $this->m_hr_retire->get_by_key()->result();
		if ($re_info != null) {
			foreach ($re_info as $item) {
				$data['re_info'] = $item;
			}
		}
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_retire_form', $data);
	}

	/*
	* retire_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function retire_insert()
	{
		$this->load->model($this->model . "m_hr_retire");
		$this->m_hr_retire->retire_name =  $this->input->post('retire_name');
		$this->m_hr_retire->retire_ps_status = $this->input->post('retire_ps_status');
		$this->m_hr_retire->retire_timestamp = $this->input->post('retire_timestamp');
		$this->m_hr_retire->retire_create_user = $this->session->userdata('us_id');
		$this->m_hr_retire->retire_update_user = $this->session->userdata('us_id');
		$this->m_hr_retire->retire_active = "1";
		$this->m_hr_retire->insert();
		$this->M_hr_logs->insert_log("เพิ่มข้อมูลสถานะปัจจุบัน ". $this->m_hr_retire->retire_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/retire';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* delete_retire
	* สำหรับการ ลบ ข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function delete_retire($RetID = null)
	{
		$this->load->model($this->model . "m_hr_retire");
		$this->m_hr_retire->retire_id = $RetID;
		$this->m_hr_retire->retire_active = '2';
		$this->m_hr_retire->disabled();
		$this->M_hr_logs->insert_log("ลบข้อมูลสถานะปัจจุบัน ". $this->m_hr_retire->retire_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/retire';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* retire_update
	* สำหรับการอัพเดทหรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function retire_update()
	{
		$this->load->model($this->model . "m_hr_retire");
		$this->m_hr_retire->retire_id =  $this->input->post('retire_id');
		$this->m_hr_retire->retire_name =  $this->input->post('retire_name');
		$this->m_hr_retire->retire_ps_status =  $this->input->post('retire_ps_status');
		$this->m_hr_retire->retire_timestamp = $this->input->post('retire_timestamp');
		$this->m_hr_retire->retire_update_user = $this->session->userdata('us_id');
		$this->m_hr_retire->retire_active = $this->input->post('retire_active');
		$this->m_hr_retire->update();
		$this->M_hr_logs->insert_log("แก้ไขข้อมูลสถานะปัจจุบัน ". $this->m_hr_retire->retire_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/retire';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_retire");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_retire->$key = $value;
		}
		$query = $this->m_hr_retire->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
