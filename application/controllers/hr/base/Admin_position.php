<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class admin_position extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct(); 

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/admin_position";
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
		$this->load->model($this->model . "m_hr_admin_position");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['admin_info'] = $this->m_hr_admin_position->get_all_by_active()->result();
		$this->output('hr/base/v_base_admin_position_show', $data);
	}
	/*
	* get_admin_position_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_admin_position_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_admin_position_form', $data);
	}
	/*
	* get_admin_position_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_admin_position_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->admin_id = $HtID;
		$admin_info = $this->m_hr_admin_position->get_by_key()->result();
		if ($admin_info != null) {
			foreach ($admin_info as $item) {
				$data['admin_info'] = $item;
			}
		} 
		$data['controller']  = $this->controller;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_admin_position_form', $data);
	}
	/*
	* admin_position_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function admin_position_insert()
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->admin_name =  $this->input->post('admin_name');
		$this->m_hr_admin_position->admin_name_en =  $this->input->post('admin_name_en');
		$this->m_hr_admin_position->admin_name_abbr =  $this->input->post('admin_name_abbr');
		$this->m_hr_admin_position->admin_name_abbr_en =  $this->input->post('admin_name_abbr_en');
		$this->m_hr_admin_position->admin_type =  $this->input->post('admin_type');
		$this->m_hr_admin_position->admin_active = "1";
		$this->m_hr_admin_position->admin_create_user = $this->session->userdata('us_id');
		$this->m_hr_admin_position->admin_update_user = $this->session->userdata('us_id');
		$this->m_hr_admin_position->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_admin_position
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_admin_position($SpID = null){
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->admin_id = $SpID;
		$this->m_hr_admin_position->admin_active = "2";
		$this->m_hr_admin_position->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* admin_position_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function admin_position_update()
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->admin_id =  $this->input->post('admin_id');
		$this->m_hr_admin_position->admin_name =  $this->input->post('admin_name');
		$this->m_hr_admin_position->admin_name_en =  $this->input->post('admin_name_en');
		$this->m_hr_admin_position->admin_name_abbr =  $this->input->post('admin_name_abbr');
		$this->m_hr_admin_position->admin_name_abbr_en =  $this->input->post('admin_name_abbr_en');
		$this->m_hr_admin_position->admin_type =  $this->input->post('admin_type');
		$this->m_hr_admin_position->admin_active = $this->input->post('admin_active');
		$this->m_hr_admin_position->admin_update_user = $this->session->userdata('us_id');
		$this->m_hr_admin_position->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
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
		$this->load->model($this->model . "m_hr_admin_position");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_admin_position->$key = $value;
		}
		$query = $this->m_hr_admin_position->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}