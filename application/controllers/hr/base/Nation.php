<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Nation extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Nation";
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
		$this->load->model($this->model . "m_hr_nation");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['nt_info'] = $this->m_hr_nation->get_all_by_active()->result();
		$this->output('hr/base/v_base_nation_show', $data);
	}

	/*
	* get_nation_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_nation_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_nation_form', $data);
	}

	/*
	* get_nation_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_nation_edit($NtID = null)
	{
		$this->load->model($this->model . "m_hr_nation");
		$this->m_hr_nation->nation_id = $NtID;
		$nt_info = $this->m_hr_nation->get_by_key()->result();
		if ($nt_info != null) {
			foreach ($nt_info as $item) {
				$data['nt_info'] = $item;
			}
		} 
		$data['controller']  = $this->controller;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_nation_form', $data);
	}

	/*
	* nation_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function nation_insert()
	{
		$this->load->model($this->model . "m_hr_nation");
		$this->m_hr_nation->nation_name = $this->input->post('nation_name');
		$this->m_hr_nation->nation_name_en = $this->input->post('nation_name_en');
		$this->m_hr_nation->nation_active = "1";
		$this->m_hr_nation->nation_create_user = $this->session->userdata('us_id');
		$this->m_hr_nation->nation_update_user  = $this->session->userdata('us_id');;
		$this->m_hr_nation->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_nation';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* delete_nation
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function delete_nation($NtID = null)
	{
		$this->load->model($this->model . "m_hr_nation");
		$this->m_hr_nation->nation_id = $NtID;
		$this->m_hr_nation->nation_active = '2';
		$this->m_hr_nation->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_nation';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* nation_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function nation_update()
	{
		$this->load->model($this->model . "m_hr_nation");
		$this->m_hr_nation->nation_id = $this->input->post('nation_id');
		$this->m_hr_nation->nation_name = $this->input->post('nation_name');
		$this->m_hr_nation->nation_name_en = $this->input->post('nation_name_en');
		$this->m_hr_nation->nation_active = $this->input->post('nation_active');
		$this->m_hr_nation->nation_update_user  = $this->session->userdata('us_id');;
		$this->m_hr_nation->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_nation';
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
		$this->load->model($this->model . "m_hr_nation");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_nation->$key = $value;
		}
		$query = $this->m_hr_nation->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
