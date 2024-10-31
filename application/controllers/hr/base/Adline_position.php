<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class adline_position extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/adline_position";
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
		$this->load->model($this->model . "m_hr_adline_position");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['adline_info'] = $this->m_hr_adline_position->get_all_by_active()->result();
		$this->output('hr/base/v_base_adline_position_show', $data);
	}
	/*
	* get_adline_position_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_adline_position_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_adline_position_form', $data);
	}
	/*
	* get_adline_position_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_adline_position_edit($HtID = null)
	{
		$this->load->model($this->model . "m_hr_adline_position");
		$this->m_hr_adline_position->alp_id = $HtID;
		$adline_info = $this->m_hr_adline_position->get_by_key()->result();
		if ($adline_info != null) {
			foreach ($adline_info as $item) {
				$data['alp_info'] = $item;
			}
		}
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_adline_position_form', $data);
	}
	/*
	* adline_position_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function adline_position_insert()
	{
		$this->load->model($this->model . "m_hr_adline_position");
		$this->m_hr_adline_position->alp_name =  $this->input->post('alp_name');
		$this->m_hr_adline_position->alp_name_en =  $this->input->post('alp_name_en');
		$this->m_hr_adline_position->alp_name_abbr =  $this->input->post('alp_name_abbr');
		$this->m_hr_adline_position->alp_name_abbr_en =  $this->input->post('alp_name_abbr_en');
		$this->m_hr_adline_position->alp_type =  $this->input->post('alp_type');
		$this->m_hr_adline_position->alp_active = "1";
		$this->m_hr_adline_position->alp_create_user = $this->session->userdata('us_id');
		$this->m_hr_adline_position->alp_update_user = $this->session->userdata('us_id');
		$this->m_hr_adline_position->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/adline_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_adline_position
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function delete_adline_position($SpID = null)
	{
		$this->load->model($this->model . "m_hr_adline_position");
		$this->m_hr_adline_position->alp_id = $SpID;
		$this->m_hr_adline_position->alp_active = "2";
		$this->m_hr_adline_position->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/adline_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* adline_position_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function adline_position_update()
	{
		$this->load->model($this->model . "m_hr_adline_position");
		$this->m_hr_adline_position->alp_id =  $this->input->post('alp_id');
		$this->m_hr_adline_position->alp_name =  $this->input->post('alp_name');
		$this->m_hr_adline_position->alp_name_en =  $this->input->post('alp_name_en');
		$this->m_hr_adline_position->alp_name_abbr =  $this->input->post('alp_name_abbr');
		$this->m_hr_adline_position->alp_name_abbr_en =  $this->input->post('alp_name_abbr_en');
		$this->m_hr_adline_position->alp_type =  $this->input->post('alp_type');
		$this->m_hr_adline_position->alp_active = $this->input->post('alp_active');
		$this->m_hr_adline_position->alp_update_user = $this->session->userdata('us_id');
		$this->m_hr_adline_position->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/adline_position';
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
		$this->load->model($this->model . "m_hr_adline_position");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_adline_position->$key = $value;
		}
		$query = $this->m_hr_adline_position->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
