<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Prefix extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Prefix";
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
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->load->model($this->model . "m_hr_prefix");
		$data['pf'] =  $this->m_hr_prefix->get_all_by_active()->result();
		$this->output($this->view . 'v_base_prefix', $data);
	}

	/*
	* get_prefix_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_prefix_add()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$data['gd_info'] = $this->m_hr_prefix->get_gender()->result();
		$this->output($this->view . 'v_base_prefix_form', $data);
	}

	/*
	* get_prefix_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_prefix_edit($StID = null)
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_id = $StID;
		$pf_info = $this->m_hr_prefix->get_by_key()->result();
		$data['gd_info'] = $this->m_hr_prefix->get_gender()->result();
		if ($pf_info != null) {
			foreach ($pf_info as $item) {
				$data['pf_info'] = $item;
			}
		}
		$data['pf_info']->pf_id = $StID;
		$data['controller']  = $this->controller;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_prefix_form', $data);
	}

	/*
	* prefix_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function prefix_insert()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_name =  $this->input->post('pf_name');
		$this->m_hr_prefix->pf_name_en = $this->input->post('pf_name_en');
		$this->m_hr_prefix->pf_gd_id = $this->input->post('pf_gd_id');
		$this->m_hr_prefix->pf_name_abbr =  $this->input->post('pf_name_abbr');
		$this->m_hr_prefix->pf_name_abbr_en = $this->input->post('pf_name_abbr_en');
		$this->m_hr_prefix->pf_create_user  = $this->session->userdata('us_id');
		$this->m_hr_prefix->pf_update_user  = $this->session->userdata('us_id');
		$this->m_hr_prefix->pf_active = "1";
		$this->m_hr_prefix->insert();
		$this->M_hr_logs->insert_log("เพิ่มข้อมูลคำนำหน้าชื่อ ". $this->m_hr_prefix->pf_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/prefix';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* prefix_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function prefix_update()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_id =  $this->input->post('pf_id');
		$this->m_hr_prefix->pf_name =  $this->input->post('pf_name');
		$this->m_hr_prefix->pf_name_en = $this->input->post('pf_name_en');
		$this->m_hr_prefix->pf_name_abbr =  $this->input->post('pf_name_abbr');
		$this->m_hr_prefix->pf_name_abbr_en = $this->input->post('pf_name_abbr_en');
		$this->m_hr_prefix->pf_active = $this->input->post('pf_active');
		$this->m_hr_prefix->pf_update_user  = $this->session->userdata('us_id');
		$this->m_hr_prefix->pf_gd_id = $this->input->post('pf_gd_id');
		$this->M_hr_logs->insert_log("แก้ไขข้อมูลคำนำหน้าชื่อ ". $this->m_hr_prefix->pf_name);	//insert hr logs
		$this->m_hr_prefix->update();
	}

	/*
	* prefix_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function prefix_delete($pf_id)
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_id = $pf_id;
		$this->m_hr_prefix->get_by_key(true);
		$this->m_hr_prefix->pf_active = '2';
		$this->m_hr_prefix->disabled();
		$this->M_hr_logs->insert_log("ลบข้อมูลคำนำหน้าชื่อ ". $this->m_hr_prefix->pf_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Prefix';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบ
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_prefix->$key = $value;
		}
		$query = $this->m_hr_prefix->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
