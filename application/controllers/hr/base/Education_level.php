<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Education_level extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Education_level";
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
		$this->load->model($this->model . "m_hr_education_level");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['edulv_info'] = $this->m_hr_education_level->get_all_by_active()->result();
		$this->output('hr/base/v_base_education_level_show', $data);
	}
	/*
	* get_education_level_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_level_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_level_form', $data);
	}
	/*
	* get_education_level_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_level_edit($EvlID =null)
	{
		$this->load->model($this->model . "m_hr_education_level");
		$this->m_hr_education_level->edulv_id = $EvlID;
		$edulv_info = $this->m_hr_education_level->get_by_key()->result();
		if ($edulv_info != null) {
			foreach ($edulv_info as $item) {
				$data['edulv_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_level_form', $data);
	}
	/*
	* education_level_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_level_insert()
	{
		$this->load->model($this->model . "m_hr_education_level");
		$this->m_hr_education_level->edulv_name =  $this->input->post('edulv_name');
		$this->m_hr_education_level->edulv_name_en = $this->input->post('edulv_name_en');
		$this->m_hr_education_level->edulv_create_user = $this->session->userdata('us_id');
		$this->m_hr_education_level->edulv_update_user = $this->session->userdata('us_id');
		$this->m_hr_education_level->edulv_active = "1";
		$this->m_hr_education_level->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_level';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
    /*
	* delete_education_level
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_education_level($EvlID = null){
		$this->load->model($this->model . "m_hr_education_level");
		$this->m_hr_education_level->edulv_id = $EvlID;
		$this->m_hr_education_level->edulv_active = '2';
		$this->m_hr_education_level->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_level';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
		/*
	* education_level_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_level_update()
	{
		$this->load->model($this->model . "m_hr_education_level");
		$this->m_hr_education_level->edulv_id =  $this->input->post('edulv_id');
		$this->m_hr_education_level->edulv_name =  $this->input->post('edulv_name');
		$this->m_hr_education_level->edulv_name_en =  $this->input->post('edulv_name_en');
		$this->m_hr_education_level->edulv_active = $this->input->post('edulv_active');
		$this->m_hr_education_level->edulv_update_user = $this->session->userdata('us_id');
		$this->m_hr_education_level->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_level';
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
		$this->load->model($this->model . "m_hr_education_level");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_education_level->$key = $value;
		}
		$query = $this->m_hr_education_level->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}