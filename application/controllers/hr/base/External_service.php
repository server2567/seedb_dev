<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class External_service extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/external_service";
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
		$this->load->model($this->model . "m_hr_external_service");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['exts_info'] = $this->m_hr_external_service->get_all_by_active()->result();
		$this->output('hr/base/v_base_external_service_show', $data);
	}
	/*
	* get_external_service_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function get_external_service_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_external_service_form', $data);
	}
	/*
	* get_external_service_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function get_external_service_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_external_service");
		$this->m_hr_external_service->exts_id = $HtID;
		$external_service_info = $this->m_hr_external_service->get_by_key()->result();
		if ($external_service_info != null) {
			foreach ($external_service_info as $item) {
				$data['exts_info'] = $item;
			}
		} 
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_external_service_form', $data);
	}
	/*
	* external_service_type_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function external_service_type_insert()
	{
		$this->load->model($this->model . "m_hr_external_service");
		$this->m_hr_external_service->exts_name_th =  $this->input->post('exts_name_th');
		$this->m_hr_external_service->exts_name_en =  $this->input->post('exts_name_en');
		$this->m_hr_external_service->exts_create_user =  $this->session->userdata('us_id');
		$this->m_hr_external_service->exts_update_user = $this->session->userdata('us_id');
		$this->m_hr_external_service->exts_active = "1";
		$this->m_hr_external_service->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/external_service_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* delete_external_service
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function delete_external_service($HtID = null){
		$this->load->model($this->model . "m_hr_external_service");
		$this->m_hr_external_service->exts_id = $HtID;
		$this->m_hr_external_service->exts_active = '2';
		$this->m_hr_external_service->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/external_service_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* external_service_type_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 19/09/2024
	*/
	public function external_service_type_update()
	{
		$this->load->model($this->model . "m_hr_external_service");
		$this->m_hr_external_service->exts_id =  $this->input->post('exts_id');
		$this->m_hr_external_service->exts_name_th =  $this->input->post('exts_name_th');
		$this->m_hr_external_service->exts_name_en =  $this->input->post('exts_name_en');
		$this->m_hr_external_service->exts_active = $this->input->post('exts_active');
		$this->m_hr_external_service->exts_update_user = $this->session->userdata('us_id');
		$this->m_hr_external_service->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/external_service_type';
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
		$this->load->model($this->model . "m_hr_external_service");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_external_service->$key = $value;
		}
		$query = $this->m_hr_external_service->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}