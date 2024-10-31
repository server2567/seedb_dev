<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Workforce_framework extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		$this->mn_active_url = uri_string();
	}
   /*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
    public function index()
	{
		$this->load->model($this->model . "M_hr_workforce_framework");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['bwfw_info'] = $this->M_hr_workforce_framework->get_all_by_active()->result();
		$this->output('hr/base/v_base_workforce_framework_show', $data);
	}
	
	/*
	* get_workforce_framework_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function get_workforce_framework_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_workforce_framework_form', $data);
	}
	/*
	* get_workforce_framework_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function get_workforce_framework_edit($HtID =null)
	{
		$this->load->model($this->model . "M_hr_workforce_framework");
		$this->M_hr_workforce_framework->bwfw_id = $HtID;
		$workforce_framework_info = $this->M_hr_workforce_framework->get_by_key()->result();
		if ($workforce_framework_info != null) {
			foreach ($workforce_framework_info as $item) {
				$data['bwfw_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_workforce_framework_form', $data);
	}
	/*
	* workforce_framework_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function workforce_framework_insert()
	{
		$this->load->model($this->model . "M_hr_workforce_framework");
		$this->M_hr_workforce_framework->bwfw_name_th =  $this->input->post('bwfw_name_th');
		$this->M_hr_workforce_framework->bwfw_name_en =  $this->input->post('bwfw_name_en');
		$this->M_hr_workforce_framework->bwfw_hour =  $this->input->post('bwfw_time_hour').":".$this->input->post('bwfw_time_minute');
		$this->M_hr_workforce_framework->bwfw_type =  $this->input->post('bwfw_type');
		$this->M_hr_workforce_framework->bwfw_is_medical =  $this->input->post('bwfw_is_medical');
		$this->M_hr_workforce_framework->bwfw_create_user =  $this->session->userdata('us_id');
		$this->M_hr_workforce_framework->bwfw_create_date = get_datetime_db();
		$this->M_hr_workforce_framework->bwfw_active = "1";
		$this->M_hr_workforce_framework->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/workforce_framework_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_workforce_framework
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function delete_workforce_framework($HtID = null){
		$this->load->model($this->model . "M_hr_workforce_framework");
		$this->M_hr_workforce_framework->bwfw_id = $HtID;
		$this->M_hr_workforce_framework->bwfw_active = '2';
		$this->M_hr_workforce_framework->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/workforce_framework_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* workforce_framework_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function workforce_framework_update()
	{
		$this->load->model($this->model . "M_hr_workforce_framework");
		$this->M_hr_workforce_framework->bwfw_id =  $this->input->post('bwfw_id');
		$this->M_hr_workforce_framework->bwfw_name_th =  $this->input->post('bwfw_name_th');
		$this->M_hr_workforce_framework->bwfw_name_en =  $this->input->post('bwfw_name_en');
		$this->M_hr_workforce_framework->bwfw_type =  $this->input->post('bwfw_type');
		$this->M_hr_workforce_framework->bwfw_is_medical =  $this->input->post('bwfw_is_medical');
		$this->M_hr_workforce_framework->bwfw_hour =  $this->input->post('bwfw_time_hour').":".$this->input->post('bwfw_time_minute');
		$this->M_hr_workforce_framework->bwfw_active = $this->input->post('bwfw_active');
		$this->M_hr_workforce_framework->bwfw_update_user = $this->session->userdata('us_id');
		$this->M_hr_workforce_framework->bwfw_update_date = get_datetime_db();
		$this->M_hr_workforce_framework->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/workforce_framework_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
		/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก*
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "M_hr_workforce_framework");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->M_hr_workforce_framework->$key = $value;
		}
		$query = $this->M_hr_workforce_framework->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}