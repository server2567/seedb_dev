<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Country extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Country";
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
		$this->load->model($this->model . "m_hr_country");
		$data['ct_info'] =  $this->m_hr_country->get_all_by_active()->result();
		$this->output($this->view . 'v_base_country_show', $data);
	}
	/*
	* get_country_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_country_add()
	{
		$this->load->model($this->model . "m_hr_country");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_country_form', $data);
	}
	/*
	* get_country_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_country_edit($StID = null)
	{
		$this->load->model($this->model . "m_hr_country");
		$this->m_hr_country->country_id = $StID;
		$country_info = $this->m_hr_country->get_by_key()->result();
		if ($country_info != null) {
			foreach ($country_info as $item) {
				$data['ct_info'] = $item;
			}
		}
		$data['controller']  = $this->controller;
		$data['ct_info']->country_id = $StID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_country_form', $data);
	}
	/*
	* country_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function country_insert()
	{
		$this->load->model($this->model . "m_hr_country");
		$this->m_hr_country->country_name =  $this->input->post('country_name');
		$this->m_hr_country->country_name_en = $this->input->post('country_name_en');
		$this->m_hr_country->country_create_user = $this->session->userdata('us_id');
		$this->m_hr_country->country_update_user = $this->session->userdata('us_id');
		$this->m_hr_country->country_active = "1";
		$this->m_hr_country->insert();
		$data['returnUrl'] = base_url() . 'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
    /*
	* country_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function country_update()
	{
		$this->load->model($this->model . "m_hr_country");
		$this->m_hr_country->country_id =  $this->input->post('country_id');
		$this->m_hr_country->country_name =  $this->input->post('country_name');
		$this->m_hr_country->country_name_en = $this->input->post('country_name_en');
		$this->m_hr_country->country_update_user = $this->session->userdata('us_id');
		$this->m_hr_country->country_active = $this->input->post('country_active');
		$this->m_hr_country->update();
	}
	/*
	* country_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function country_delete($country_id)
	{
		$this->load->model($this->model . "m_hr_country");
		$this->m_hr_country->country_id = $country_id;
		$this->m_hr_country->country_active = 2;
		$this->m_hr_country->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/country';
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
		$this->load->model($this->model . "m_hr_country");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_country->$key = $value;
		}
		$query = $this->m_hr_country->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
