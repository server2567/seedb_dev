<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Develop_type extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Develop_type";
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
		$this->load->model($this->model . "m_hr_develop_type");
		$data['devb_info'] =  $this->m_hr_develop_type->get_all_by_active()->result();
		foreach ($data['devb_info'] as $key => $value) {
			$value->devb_id = encrypt_id($value->devb_id);
		}
		$this->output($this->view . 'v_base_develop_type_show', $data);
	}
	/*
	* get_devb_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_develop_type_add()
	{
		$this->load->model($this->model . "m_hr_develop_type");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_develop_type_form', $data);
	}
	/*
	* get_devb_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_develop_type_edit($StID = null)
	{
		$this->load->model($this->model . "m_hr_develop_type");
		$this->m_hr_develop_type->devb_id = decrypt_id($StID);
		$devb_info = $this->m_hr_develop_type->get_by_key()->result();
		if ($devb_info != null) {
			foreach ($devb_info as $item) {
				$data['ct_info'] = $item;
			}
		}
		$data['controller']  = $this->controller;
		$data['ct_info']->devb_id = $StID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_develop_type_form', $data);
	}
	/*
	* devb_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function develop_type_insert()
	{
		$this->load->model($this->model . "m_hr_develop_type");
		$this->m_hr_develop_type->devb_name =  $this->input->post('devb_name');
		$this->m_hr_develop_type->devb_name_en = $this->input->post('devb_name_en');
		$this->m_hr_develop_type->devb_create_user = $this->session->userdata('us_id');
		$this->m_hr_develop_type->devb_update_user = $this->session->userdata('us_id');
		$this->m_hr_develop_type->devb_active = "1";
		$this->m_hr_develop_type->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/develop';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
    /*
	* devb_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function develop_type_update()
	{
		$this->load->model($this->model . "m_hr_develop_type");
		$this->m_hr_develop_type->devb_id =  decrypt_id($this->input->post('devb_id'));
		$this->m_hr_develop_type->devb_name =  $this->input->post('devb_name');
		$this->m_hr_develop_type->devb_name_en = $this->input->post('devb_name_en');
		$this->m_hr_develop_type->devb_update_user = $this->session->userdata('us_id');
		$this->m_hr_develop_type->devb_active = $this->input->post('devb_active');
		$this->m_hr_develop_type->update();
	}
	/*
	* devb_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function develop_type_delete($devb_id)
	{
		$this->load->model($this->model . "m_hr_develop_type");
		$this->m_hr_develop_type->devb_id = decrypt_id($devb_id);
		$this->m_hr_develop_type->devb_active = 2;
		$this->m_hr_develop_type->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/develop_type';
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
		$this->load->model($this->model . "m_hr_develop_type");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_develop_type->$key = $value;
		}
		$query = $this->m_hr_develop_type->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
