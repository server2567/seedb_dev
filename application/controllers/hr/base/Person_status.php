<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Person_status extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Person_status";
	}

	/*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function index()
	{
		$this->load->model($this->model . "m_hr_person_status");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['ps_info'] = $this->m_hr_person_status->get_all_by_active()->result();
		$this->output('hr/base/v_base_person_status_show', $data);
	}

	/*
	* get_person_status_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function get_person_status_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_person_status_form', $data);
	}

	/*
	* get_person_status_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function get_person_status_edit($PssID = null)
	{
		$this->load->model($this->model . "m_hr_person_status");
		$this->m_hr_person_status->psst_id = $PssID;
		$ps_info = $this->m_hr_person_status->get_by_key()->result();
		if ($ps_info != null) {
			foreach ($ps_info as $item) {
				$data['ps_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_person_status_form', $data);
	}

	/*
	* delete_person_status
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function delete_person_status($PssID = null)
	{
		$this->load->model($this->model . "m_hr_person_status");
		$this->m_hr_person_status->psst_id = $PssID;
		$this->m_hr_person_status->psst_active = '2';
		$this->m_hr_person_status->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_person_status';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* person_status_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function person_status_insert()
	{
		$this->load->model($this->model . "m_hr_person_status");
		$this->m_hr_person_status->psst_name = $this->input->post('psst_name');
		$this->m_hr_person_status->psst_name_en = $this->input->post('psst_name_en');
		$this->m_hr_person_status->psst_create_user = $this->session->userdata('us_id');;
		$this->m_hr_person_status->psst_update_user = $this->session->userdata('us_id');;
		$this->m_hr_person_status->psst_active = "1";
		$this->m_hr_person_status->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_person_status';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* person_status_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 31/05/2024
	*/
	public function person_status_update()
	{
		$this->load->model($this->model . "m_hr_person_status");
		$this->m_hr_person_status->psst_id = $this->input->post('psst_id');
		$this->m_hr_person_status->psst_name = $this->input->post('psst_name');
		$this->m_hr_person_status->psst_name_en = $this->input->post('psst_name_en');
		$this->m_hr_person_status->psst_active = $this->input->post('psst_active');
		$this->m_hr_person_status->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_person_status';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @Create Date 31/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_person_status");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_person_status->$key = $value;
		}
		$query = $this->m_hr_person_status->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
