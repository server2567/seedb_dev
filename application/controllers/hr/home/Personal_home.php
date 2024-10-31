<?php 
/*
* Home_user
* Controller หลักของจัดการข้อมูลส่วนตัว
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 16/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Home_Controller.php');

class Personal_home extends Home_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Personal_home/";
		$this->load->model($this->model.'M_hr_person');
		$this->load->model($this->model.'M_hr_person_detail');
		$this->load->model($this->model.'M_hr_person_position');
		$this->load->model($this->model.'m_hr_order_person');
		$this->load->model($this->model.'M_hr_person_education');
		$this->load->model($this->model.'M_hr_person_license');
		$this->load->model($this->model.'M_hr_person_work_history');
		$this->load->model($this->model.'M_hr_person_expert');
		$this->load->model($this->model.'M_hr_person_reward');
		
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของจัดการข้อมูลส่วนตัว
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;

		// pre($this->session->userdata());
		// die;

		$this->output($this->view.'v_home_main_officer', $data);
	}
	// index

	/*
	* error_page
	* หน้าจอแสดง error ระบบ
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function error_page()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;

		$this->output($this->view.'v_home_error_show', $data);
	}
	// error_page

	
}
