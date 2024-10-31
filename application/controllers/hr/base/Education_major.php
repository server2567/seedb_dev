<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Education_major extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Education_major";
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
		$this->load->model($this->model . "m_hr_education_major");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['edumj_info'] = $this->m_hr_education_major->get_all_by_active()->result();
		$this->output('hr/base/v_base_education_major_show', $data);
	}
	/*
	* get_education_major_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_major_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_major_form', $data);
	}
	/*
	* get_education_major_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_education_major_edit($EvlID =null)
	{
		$this->load->model($this->model . "m_hr_education_major");
		$this->m_hr_education_major->edumj_id = $EvlID;
		$edumj_info = $this->m_hr_education_major->get_by_key()->result();
		if ($edumj_info != null) {
			foreach ($edumj_info as $item) {
				$data['edumj_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_education_major_form', $data);
	}
	/*
	* education_major_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_major_insert()
	{
		$this->load->model($this->model . "m_hr_education_major");
		$this->m_hr_education_major->edumj_name =  $this->input->post('edumj_name');
		$this->m_hr_education_major->edumj_name_en = $this->input->post('edumj_name_en');
		$this->m_hr_education_major->edumj_active = "1";
		$this->m_hr_education_major->edumj_create_user = $this->session->userdata('us_id');
		$this->m_hr_education_major->edumj_update_user = $this->session->userdata('us_id');
		$this->m_hr_education_major->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_major';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_education_major
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_education_major($EvlID = null){
		$this->load->model($this->model . "m_hr_education_major");
		$this->m_hr_education_major->edumj_id = $EvlID;
		$this->m_hr_education_major->edumj_active = '2';
		$this->m_hr_education_major->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_major';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	 /*
	* education_major_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function education_major_update()
	{
		$this->load->model($this->model . "m_hr_education_major");
		$this->m_hr_education_major->edumj_id =  $this->input->post('edumj_id');
		$this->m_hr_education_major->edumj_name =  $this->input->post('edumj_name');
		$this->m_hr_education_major->edumj_name_en =  $this->input->post('edumj_name_en');
		$this->m_hr_education_major->edumj_active = $this->input->post('edumj_active');
		$this->m_hr_education_major->edumj_create_user = $this->session->userdata('us_id');
		$this->m_hr_education_major->edumj_update_user = $this->session->userdata('us_id');
		$this->m_hr_education_major->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Education_major';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
		/*
	* country_update
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_education_major");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_education_major->$key = $value;
		}
		$query = $this->m_hr_education_major->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}