<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Hire extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Hire";
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
		$this->load->model($this->model . "m_hr_hire");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['hire_info'] = $this->m_hr_hire->get_all_by_active()->result();
		$this->output('hr/base/v_base_hire_show', $data);
	}
	/*
	* get_hire_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_hire_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_hire_form', $data);
	}
	/*
	* get_hire_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_hire_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_hire");
		$this->m_hr_hire->hire_id = $HtID;
		$hire_info = $this->m_hr_hire->get_by_key()->result();
		if ($hire_info != null) {
			foreach ($hire_info as $item) {
				$data['hire_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_hire_form', $data);
	}
	/*
	* hire_type_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function hire_type_insert()
	{
		$this->load->model($this->model . "m_hr_hire");
		$this->m_hr_hire->hire_name =  $this->input->post('hire_name');
		$this->m_hr_hire->hire_abbr =  $this->input->post('hire_abbr');
		$this->m_hr_hire->hire_type =  $this->input->post('hire_type');
		$this->m_hr_hire->hire_is_medical =  $this->input->post('hire_is_medical');
		$this->m_hr_hire->hire_create_user =  $this->session->userdata('us_id');
		$this->m_hr_hire->hire_update_user = $this->session->userdata('us_id');
		$this->m_hr_hire->hire_active = "1";
		$this->m_hr_hire->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/hire_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_hire
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_hire($HtID = null){
		$this->load->model($this->model . "m_hr_hire");
		$this->m_hr_hire->hire_id = $HtID;
		$this->m_hr_hire->hire_active = '2';
		$this->m_hr_hire->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/hire_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* hire_type_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function hire_type_update()
	{
		$this->load->model($this->model . "m_hr_hire");
		$this->m_hr_hire->hire_id =  $this->input->post('hire_id');
		$this->m_hr_hire->hire_name =  $this->input->post('hire_name');
		$this->m_hr_hire->hire_abbr =  $this->input->post('hire_abbr');
		$this->m_hr_hire->hire_type =  $this->input->post('hire_type');
		$this->m_hr_hire->hire_is_medical =  $this->input->post('hire_is_medical');
		$this->m_hr_hire->hire_active = $this->input->post('hire_active');
		$this->m_hr_hire->hire_update_user = $this->session->userdata('us_id');
		$this->m_hr_hire->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/hire_type';
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
		$this->load->model($this->model . "m_hr_hire");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_hire->$key = $value;
		}
		$query = $this->m_hr_hire->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}