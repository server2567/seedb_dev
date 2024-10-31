<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class vocation extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct(); 

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/vocation";
	}
	/*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
    public function index()
	{
		$this->load->model($this->model . "m_hr_vocation");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['voc_info'] = $this->m_hr_vocation->get_all_by_active()->result();
		$this->output('hr/base/v_base_vocation_show', $data);
	}
	/*
	* get_vocation_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_vocation_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_vocation_form', $data);
	}
	/*
	* get_vocation_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_vocation_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_vocation");
		$this->m_hr_vocation->voc_id = $HtID;
		$voc_info = $this->m_hr_vocation->get_by_key()->result();
		if ($voc_info != null) {
			foreach ($voc_info as $item) {
				$data['voc_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_vocation_form', $data);
	}
	/*
	* vocation_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function vocation_insert()
	{
		$this->load->model($this->model . "m_hr_vocation");
		$this->m_hr_vocation->voc_name =  $this->input->post('voc_name');
		$this->m_hr_vocation->voc_done = $this->input->post('voc_done');
		$this->m_hr_vocation->voc_create_user = $this->session->userdata('us_id');
		$this->m_hr_vocation->voc_update_user = $this->session->userdata('us_id');
		$this->m_hr_vocation->voc_active = "1";
		$this->m_hr_vocation->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/vocation';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_vocation
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function delete_vocation($SpID = null){
		$this->load->model($this->model . "m_hr_vocation");
		$this->m_hr_vocation->voc_id = $SpID;
		$this->m_hr_vocation->voc_acive = '2';
		$this->m_hr_vocation->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/vocation';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* vocation_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function vocation_update()
	{
		$this->load->model($this->model . "m_hr_vocation");
		$this->m_hr_vocation->voc_id =  $this->input->post('voc_id');
		$this->m_hr_vocation->voc_name =  $this->input->post('voc_name');
		$this->m_hr_vocation->voc_done =  $this->input->post('voc_done');
		$this->m_hr_vocation->voc_type =  $this->input->post('voc_type');
		$this->m_hr_vocation->voc_update_user = $this->session->userdata('us_id');
		$this->m_hr_vocation->voc_active = $this->input->post('voc_active');
		$this->m_hr_vocation->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/vocation';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_vocation");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_vocation->$key = $value;
		}
		$query = $this->m_hr_vocation->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}