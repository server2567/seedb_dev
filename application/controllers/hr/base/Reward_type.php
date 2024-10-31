<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class reward_type extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/reward_type";
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
		$this->load->model($this->model . "m_hr_reward_type");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['rwt_info'] = $this->m_hr_reward_type->get_all_by_active()->result();
		$this->output('hr/base/v_base_reward_type_show', $data);
	}

	/*
    * get_reward_type_add
    * สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
	public function get_reward_type_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output('hr/base/v_base_reward_type_form', $data);
	}

	/*
    * get_reward_type_edit
    * สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
	public function get_reward_type_edit($HtID = null)
	{
		$this->load->model($this->model . "m_hr_reward_type");
		$this->m_hr_reward_type->rwt_id = $HtID;
		$rwt_info = $this->m_hr_reward_type->get_by_key()->result();
		if ($rwt_info != null) {
			foreach ($rwt_info as $item) {
				$data['rwt_info'] = $item;
			}
		}
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['controller']  = $this->controller;
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_reward_type_form', $data);
	}

	/*
    * reward_type_insert
    * สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
	public function reward_type_insert()
	{
		$this->load->model($this->model . "m_hr_reward_type");
		$this->m_hr_reward_type->rwt_name =  $this->input->post('rwt_name');
		$this->m_hr_reward_type->rwt_name_en = $this->input->post('rwt_name_en');
		$this->m_hr_reward_type->rwt_create_user = $this->session->userdata('us_id');
		$this->m_hr_reward_type->rwt_update_user = $this->session->userdata('us_id');
		$this->m_hr_reward_type->rwt_active = "1";
		$this->m_hr_reward_type->insert();
		$this->M_hr_logs->insert_log("เพิ่มข้อมูลด้านรางวัล ". $this->m_hr_reward_type->rwt_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/reward_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
    * delete_reward_type
    * สำหรับการ ลบ ข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
	public function delete_reward_type($RwtID = null)
	{
		$this->load->model($this->model . "m_hr_reward_type");
		$this->m_hr_reward_type->rwt_id = $RwtID;
		$this->m_hr_reward_type->rwt_active = '2';
		$this->m_hr_reward_type->rwt_update_user = $this->session->userdata('us_id');
		$this->m_hr_reward_type->disabled();
		$this->M_hr_logs->insert_log("ลบข้อมูลด้านรางวัล ". $this->m_hr_reward_type->rwt_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/reward_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
    * reward_type_update
    * สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
	public function reward_type_update()
	{
		$this->load->model($this->model . "m_hr_reward_type");
		$this->m_hr_reward_type->rwt_id =  $this->input->post('rwt_id');
		$this->m_hr_reward_type->rwt_name =  $this->input->post('rwt_name');
		$this->m_hr_reward_type->rwt_name_en = $this->input->post('rwt_name_en');
		$this->m_hr_reward_type->rwt_update_user = $this->session->userdata('us_id');
		$this->m_hr_reward_type->rwt_active = $this->input->post('rwt_active');
		$this->m_hr_reward_type->update();
		$this->M_hr_logs->insert_log("แก้ไขข้อมูลด้านรางวัล ". $this->m_hr_reward_type->rwt_name);	//insert hr logs
		$data['returnUrl'] = base_url() . 'index.php/hr/base/reward_type';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* checkValue
	* สำหรับการตรวจสอบค่าซ้ำกันในฐานข้อมูล
	* $input -
	* $output -
	* @Create Date 30/05/2024
	*/
	public function checkValue()
	{
		$this->load->model($this->model . "m_hr_reward_type");
		$formdata = $this->input->post();
		foreach ($formdata as $key => $value) {
			$this->m_hr_reward_type->$key = $value;
		}
		$query = $this->m_hr_reward_type->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
}
