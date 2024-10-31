<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Religion extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Religion";
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
		$this->load->model($this->model . "m_hr_religion");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['rl_info'] = $this->m_hr_religion->get_all_by_active()->result();
		$this->output('hr/base/v_base_religion_show', $data);
	}

	/*
	* get_religion_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_religion_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_religion_form', $data);
	}

	/*
	* get_religion_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function get_religion_edit($RlID = null)
	{
		$this->load->model($this->model . "m_hr_religion");
		$this->m_hr_religion->reli_id = $RlID;
		$rl_info = $this->m_hr_religion->get_by_key()->result();
		if ($rl_info != null) {
			foreach ($rl_info as $item) {
				$data['rl_info'] = $item;
			}
		}
		$data['controller']  = $this->controller;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_religion_form', $data);
	}

	/*
	* religion_insert
	* สำหรับการเพิ่มข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function religion_insert()
	{
		$this->load->model($this->model . "m_hr_religion");
		$this->m_hr_religion->reli_name =  $this->input->post('reli_name');
		$this->m_hr_religion->reli_name_en = $this->input->post('reli_name_en');
		$this->m_hr_religion->reli_create_user = $this->session->userdata('us_id');
		$this->m_hr_religion->reli_update_user = $this->session->userdata('us_id');
		$this->m_hr_religion->reli_active = "1";
		$this->m_hr_religion->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_religion';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* delete_religion
	* สำหรับการ ลบ ข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function delete_religion($RlID = null)
	{
		$this->load->model($this->model . "m_hr_religion");
		$this->m_hr_religion->reli_id = $RlID;
		$this->m_hr_religion->reli_active = '2';
		$this->m_hr_religion->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_religion';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* religion_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function religion_update()
	{
		$this->load->model($this->model . "m_hr_religion");
		$this->m_hr_religion->reli_id =  $this->input->post('reli_id');
		$this->m_hr_religion->reli_name =  $this->input->post('reli_name');
		$this->m_hr_religion->reli_name_en =  $this->input->post('reli_name_en');
		$this->m_hr_religion->reli_create_user = $this->session->userdata('us_id');
		$this->m_hr_religion->reli_active = $this->input->post('reli_active');
		$this->m_hr_religion->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_religion';
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
		$this->load->model($this->model . "m_hr_religion");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
            $this->m_hr_religion->$key = $value;
        }
        $query = $this->m_hr_religion->finding()->result();
        if (count($query) > 0) {
            $data['status_response'] = '1';
        } else {
            $data['status_response'] = '0';
        }
        echo json_encode($data);
    }
}