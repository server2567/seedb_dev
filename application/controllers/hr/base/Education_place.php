<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Education_place extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Education_place";
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
		$this->load->model($this->model . "m_hr_education_place");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['place_info'] = $this->m_hr_education_place->get_all_by_active()->result();
		$this->output('hr/base/v_base_education_place_show', $data);
	}
	/*
	* get_education_place_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_place_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_place_form', $data);
	}
	/*
	* get_education_place_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_place_edit($EpID =null)
	{
		$this->load->model($this->model . "m_hr_education_place");
		$this->m_hr_education_place->place_id = $EpID;
		$place_info = $this->m_hr_education_place->get_by_key()->result();
		if ($place_info != null) {
			foreach ($place_info as $item) {
				$data['place_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_place_form', $data);
	}
	/*
	* education_place_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_place_insert()
	{
		$this->load->model($this->model . "m_hr_education_place");
		$this->m_hr_education_place->place_name =  $this->input->post('place_name');
		$this->m_hr_education_place->place_name_en = $this->input->post('place_name_en');
		$this->m_hr_education_place->place_abbr = $this->input->post('place_abbr');
		$this->m_hr_education_place->place_abbr_en = $this->input->post('place_abbr_en');
		$this->m_hr_education_place->place_create_user = $this->session->userdata('us_id');
		$this->m_hr_education_place->place_update_user =  $this->session->userdata('us_id');
		$this->m_hr_education_place->place_active = "1";
		$this->m_hr_education_place->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_place';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_education_place
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_education_place($EpID = null){
		$this->load->model($this->model . "m_hr_education_place");
		$this->m_hr_education_place->place_id = $EpID;
		$this->m_hr_education_place->place_active = '2';
		$this->m_hr_education_place->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_place';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* education_place_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_place_update()
	{
		$this->load->model($this->model . "m_hr_education_place");
		$this->m_hr_education_place->place_id =  $this->input->post('place_id');
		$this->m_hr_education_place->place_name =  $this->input->post('place_name');
		$this->m_hr_education_place->place_name_en =  $this->input->post('place_name_en');
		$this->m_hr_education_place->place_abbr = $this->input->post('place_abbr');
		$this->m_hr_education_place->place_abbr_en = $this->input->post('place_abbr_en');
		$this->m_hr_education_place->place_active = $this->input->post('place_active');
		$this->m_hr_education_place->place_update_user =  $this->session->userdata('us_id');
		$this->m_hr_education_place->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_place';
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
		$this->load->model($this->model . "m_hr_education_place");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_education_place->$key = $value;
		}
		$query = $this->m_hr_education_place->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}