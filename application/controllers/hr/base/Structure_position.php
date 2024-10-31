<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Structure_position extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/structure_position";
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
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->load->model($this->model . "m_hr_structure_position");
		$data['stpo_info'] =  $this->m_hr_structure_position->get_all_by_active()->result();
		foreach ($data['stpo_info'] as $key => $value) {
			$value->stpo_id = encrypt_id($value->stpo_id);
		}
		$this->output($this->view . 'v_base_structure_position_show', $data);
	}
	/*
	* get_stpo_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_structure_position_add()
	{
		$this->load->model($this->model . "m_hr_structure_position");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_structure_position_form', $data);
	}
	/*
	* get_stpo_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_structure_position_edit($StID = null)
	{
		$this->load->model($this->model . "m_hr_structure_position");
		$this->m_hr_structure_position->stpo_id = decrypt_id($StID);
		$stpo_info = $this->m_hr_structure_position->get_by_key()->result();
		if ($stpo_info != null) {
			foreach ($stpo_info as $item) {
				$data['stpo_info'] = $item;
			}
		}
		$data['controller']  = $this->controller;
		$data['stpo_info']->stpo_id = $StID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_structure_position_form', $data);
	}
	/*
	* stpo_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function structure_position_insert()
	{
		$this->load->model($this->model . "m_hr_structure_position");
		$this->m_hr_structure_position->stpo_name =  $this->input->post('stpo_name');
		$this->m_hr_structure_position->stpo_name_en = $this->input->post('stpo_name_en');
		$this->m_hr_structure_position->stpo_used = $this->input->post('stpo_used');
		$this->m_hr_structure_position->stpo_display = $this->input->post('stpo_display');
		$this->m_hr_structure_position->stpo_create_user = $this->session->userdata('us_id');
		$this->m_hr_structure_position->stpo_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure_position->stpo_active = "1";
		$this->m_hr_structure_position->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/develop';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
    /*
	* stpo_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function structure_position_update()
	{
		$this->load->model($this->model . "m_hr_structure_position");
		$this->m_hr_structure_position->stpo_id =  decrypt_id($this->input->post('stpo_id'));
		$this->m_hr_structure_position->stpo_name =  $this->input->post('stpo_name');
		$this->m_hr_structure_position->stpo_used = $this->input->post('stpo_used');
		$this->m_hr_structure_position->stpo_display = $this->input->post('stpo_display');
		$this->m_hr_structure_position->stpo_name_en = $this->input->post('stpo_name_en');
		$this->m_hr_structure_position->stpo_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure_position->stpo_active = $this->input->post('stpo_active');
		$this->m_hr_structure_position->update();
	}
	/*
	* stpo_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function structure_position_delete($stpo_id)
	{
		$this->load->model($this->model . "m_hr_structure_position");
		$this->m_hr_structure_position->stpo_id = decrypt_id($stpo_id);
		$this->m_hr_structure_position->stpo_active = 2;
		$this->m_hr_structure_position->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/structure_position';
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
		$this->load->model($this->model . "m_hr_structure_position");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_structure_position->$key = $value;
		}
		$query = $this->m_hr_structure_position->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
