<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Special_position extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct(); 

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Special_position";
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
		$this->load->model($this->model . "m_hr_special_position");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['special_info'] = $this->m_hr_special_position->get_all_by_active()->result();
		$this->output('hr/base/v_base_special_position_show', $data);
	}
	/*
	* get_nation_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_special_position_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->load->model($this->model . "m_hr_hire");
		$data['hire_info'] = $this->m_hr_hire->get_all_for_option()->result();
		$this->output('hr/base/v_base_special_position_form', $data);
	}
	/*
	* get_special_position_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_special_position_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_special_position");
		$this->load->model($this->model . "m_hr_hire");
		$this->m_hr_special_position->spcl_id = $HtID;
		$special_info = $this->m_hr_special_position->get_by_key()->result();
		$data['hire_info'] = $this->m_hr_hire->get_all_for_option()->result();
		if ($special_info != null) {
			foreach ($special_info as $item) {
				$data['spcl_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_special_position_form', $data);
	}
	/*
	* special_position_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function special_position_insert()
	{
		$this->load->model($this->model . "m_hr_special_position");
		$this->m_hr_special_position->spcl_name =  $this->input->post('spcl_name');
		$this->m_hr_special_position->spcl_name_en =  $this->input->post('spcl_name_en');
		$this->m_hr_special_position->spcl_name_abbr =  $this->input->post('spcl_name_abbr');
		$this->m_hr_special_position->spcl_name_abbr_en =  $this->input->post('spcl_name_abbr_en');
		$this->m_hr_special_position->spcl_type =  $this->input->post('spcl_type');
		$this->m_hr_special_position->spcl_active = "1";
		$this->m_hr_special_position->spcl_create_user = $this->session->userdata('us_id');
		$this->m_hr_special_position->spcl_update_user = $this->session->userdata('us_id');
		$this->m_hr_special_position->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/special_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_special_position
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function delete_special_position($SpID = null){
		$this->load->model($this->model . "m_hr_special_position");
		$this->m_hr_special_position->spcl_id = $SpID;
		$this->m_hr_special_position->spcl_active = '2';
		$this->m_hr_special_position->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/special_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* special_position_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function special_position_update()
	{
		$this->load->model($this->model . "m_hr_special_position");
		$this->m_hr_special_position->spcl_id =  $this->input->post('spcl_id');
		$this->m_hr_special_position->spcl_name =  $this->input->post('spcl_name');
		$this->m_hr_special_position->spcl_name_en =  $this->input->post('spcl_name_en');
		$this->m_hr_special_position->spcl_name_abbr =  $this->input->post('spcl_name_abbr');
		$this->m_hr_special_position->spcl_name_abbr_en =  $this->input->post('spcl_name_abbr_en');
		$this->m_hr_special_position->spcl_type =  $this->input->post('spcl_type');
		$this->m_hr_special_position->spcl_update_user = $this->session->userdata('us_id');
		$this->m_hr_special_position->spcl_active = $this->input->post('spcl_active');
		$this->m_hr_special_position->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/special_position';
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
		$this->load->model($this->model . "m_hr_special_position");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_special_position->$key = $value;
		}
		$query = $this->m_hr_special_position->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}