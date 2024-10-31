<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class District extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/District";
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
		$this->load->model($this->model . "m_hr_district");
		$this->load->model($this->model . "m_hr_province");
		$data['dt_info'] =  $this->m_hr_district->get_all_by_active()->result();
		$data['pv_info'] =  $this->m_hr_province->get_all_by_active()->result();
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_district', $data);
	}
	/*
	* get_country_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_district_add()
	{
		$this->load->model($this->model . "m_hr_district");
		$this->load->model($this->model . "m_hr_amphur");
		$this->load->model($this->model . "m_hr_province");
		$data['pv_info'] = $this->m_hr_province->get_all_by_active()->result();
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['controller']  = $this->controller;
		$this->output($this->view . 'v_base_district_form', $data);
	}
	/*
	* get_country_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_district_edit($DtID = null)
	{
		$this->load->model($this->model . "m_hr_district");
		$this->load->model($this->model . "m_hr_amphur");
		$this->load->model($this->model . "m_hr_province");
		$data['pv_info'] = $this->m_hr_province->get_all_by_active()->result();
		$this->m_hr_district->dist_id = $DtID;
		$dt_info = $this->m_hr_district->get_by_key()->result();
		if ($dt_info != null) {
			foreach ($dt_info as $item) {
				$data['dt_info'] = $item;
			}
		}
		$data['controller']  = $this->controller;
		$data['ap_info'] = $this->m_hr_amphur->get_amphur_by_provice($data['dt_info']->dist_pv_id)->result();
		$data['dt_info']->dt_id = $DtID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_district_form', $data);
	}
	/*
	* get_amphur
	* ดึงข้อมูล option สำหรับอำเภอ*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function get_amphur()
	{
		$this->load->model($this->model . "m_hr_amphur");
		$ap_info = $this->m_hr_amphur->get_amphur_by_provice($this->input->post('pv_id'))->result();
		echo json_encode($ap_info);
	}
	public function filter_districts() {
		$this->load->model($this->model . "m_hr_district");
		$result = $this->m_hr_district->filter_district($this->input->post('province_id'),$this->input->post('amphur_id'))->result();
		echo json_encode($result);
	}
	/*
	* district_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function district_insert()
	{
		$this->load->model($this->model . "m_hr_district");
		$this->m_hr_district->dist_name =  $this->input->post('dist_name');
		$this->m_hr_district->dist_name_en = $this->input->post('dist_name_en');
		$this->m_hr_district->dist_pv_id = $this->input->post('dist_pv_id');
		$this->m_hr_district->dist_amph_id = $this->input->post('dist_amph_id');
		$this->m_hr_district->dist_pos_code = $this->input->post('dist_pos_code');
		$this->m_hr_district->dist_create_user = $this->session->userdata('us_id');
		$this->m_hr_district->dist_update_user = $this->session->userdata('us_id');
		$this->m_hr_district->dist_active = "1";
		$this->m_hr_district->insert();
		$data['returnUrl'] = base_url() . 'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* district_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function district_update()
	{
		$this->load->model($this->model . "m_hr_district");
		$this->m_hr_district->dist_id =  $this->input->post('dist_id');
		$this->m_hr_district->dist_name =  $this->input->post('dist_name');
		$this->m_hr_district->dist_name_en = $this->input->post('dist_name_en');
		$this->m_hr_district->dist_pv_id = $this->input->post('dist_pv_id');
		$this->m_hr_district->dist_amph_id = $this->input->post('dist_amph_id');
		$this->m_hr_district->dist_pos_code = $this->input->post('dist_pos_code');
		$this->m_hr_district->dist_update_user = $this->session->userdata('us_id');
		$this->m_hr_district->dist_active = $this->input->post('dist_active');
		$this->m_hr_district->update();
	}
	/*
	* district_delete
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
	public function district_delete($DtID)
	{
		$this->load->model($this->model . "m_hr_district");
		$this->m_hr_district->dist_id = $DtID;
		$this->m_hr_district->dist_active = '2';
		$this->m_hr_district->disabled();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/District';
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
		$this->load->model($this->model . "m_hr_district");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_district->$key = $value;
		}
		$query = $this->m_hr_district->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
	public function re_id_dis(){
		$sql = '';
		$query = $this->hr->query($sql);
		return $query;
	}
}
