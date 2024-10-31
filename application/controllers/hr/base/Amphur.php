<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Amphur extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Amphur";
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
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->load->model($this->model . "m_hr_province");
		$data['pv_info'] = $this->m_hr_province->get_all_by_active()->result();
		$this->load->model($this->model . "m_hr_amphur");
		$data['ap_info'] =  $this->m_hr_amphur->get_all_by_active()->result();
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_amphur', $data);
	}
	/*
	* get_amphur_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_amphur_add()
	{
		$this->load->model($this->model . "m_hr_province");
		$data['pv_info'] = $this->m_hr_province->get_all_by_active()->result();
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_amphur_form', $data);
	}
	/*
	* get_amphur_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_amphur_edit($ApID = null)
	{
		$this->load->model($this->model . "m_hr_province");
		$this->load->model($this->model . "m_hr_amphur");
		$data['pv_info'] = $this->m_hr_province->get_all_by_active()->result();
		$this->m_hr_amphur->amph_id = $ApID;
		$data['controller']  = $this->controller;
		$ap_info = $this->m_hr_amphur->get_by_key()->result();
		if ($ap_info != null) {
			foreach ($ap_info as $item) {
				$data['ap_info'] = $item;
			}
		}
		$data['ap_info']->amph_id = $ApID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_amphur_form', $data);
	}
	/*
	* amphur_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function amphur_insert()
	{
		$this->load->model($this->model . "m_hr_amphur");
		$this->m_hr_amphur->amph_name =  $this->input->post('amph_name');
		$this->m_hr_amphur->amph_name_en = $this->input->post('amph_name_en');
		$this->m_hr_amphur->amph_pv_id = $this->input->post('amph_pv_id');
		$this->m_hr_amphur->amph_create_user = $this->session->userdata('us_id');
		$this->m_hr_amphur->amph_update_user = $this->session->userdata('us_id');
		$this->m_hr_amphur->amph_active = "1";
		$this->m_hr_amphur->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/amphur';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* amphur_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function amphur_update()
	{
		$this->load->model($this->model . "m_hr_amphur");
		$this->m_hr_amphur->amph_id =  $this->input->post('amph_id');
		$this->m_hr_amphur->amph_pv_id = $this->input->post('amph_pv_id');
		$this->m_hr_amphur->amph_name =  $this->input->post('amph_name');
		$this->m_hr_amphur->amph_name_en = $this->input->post('amph_name_en');
		$this->m_hr_amphur->amph_update_user = $this->session->userdata('us_id');
		$this->m_hr_amphur->amph_active = $this->input->post('amph_active');
		$this->m_hr_amphur->update();
	}
	/*
	* amphur_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function amphur_delete($amph_id)
	{
		$this->load->model($this->model . "m_hr_amphur");
		$this->m_hr_amphur->amph_id = $amph_id;
		$this->m_hr_amphur->amph_active = '2';
		$this->m_hr_amphur->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/amphur';
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
		$this->load->model($this->model . "m_hr_amphur");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_amphur->$key = $value;
		}
		$query = $this->m_hr_amphur->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
	public function filter_amphurs()
	{
		$this->load->model($this->model . "m_hr_amphur");
		$result = $this->m_hr_amphur->get_amphur_by_provice($this->input->post('province_id'))->result();
		echo json_encode($result);
	}
}
