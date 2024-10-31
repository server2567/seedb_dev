<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Profile extends Base_Controller
{
	private $mn_active_id = 300012; // this menu

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['session_mn_active_id'] = $this->mn_active_id; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_list_show', $data);
	}
	// Base Prefix
	public function get_occupation()
	{
		$this->load->model($this->config->item('hr_dir') . "base/m_hr_occupation");
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->load->model($this->model . "m_hr_occupation");
		$data['oc'] =  $this->m_hr_occupation->get_all_by_active()->result();
		$this->output('hr/base/v_base_occupation_show', $data);
	}
	public function get_occupation_add()
	{
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_occupation_form', $data);
	}
	public function get_occupation_edit($StID = null)
	{
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_occupation_form', $data);
	}
	public function occutation_insert($StID = null)
	{
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_pefix_form', $data);
	}
	public function get_Subdistrict()
	{
		$data['session_mn_active_id'] = 300021; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Subdistrict', $data);
	}
	public function get_Subdistrict_add()
	{
		$data['session_mn_active_id'] = 300021; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Subdistrict_form', $data);
	}
	public function get_Subdistrict_edit($StID = null)
	{
		$data['StID'] = $StID;

		$data['session_mn_active_id'] = 300021; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Subdistrict_form', $data);
	}
	public function get_District()
	{
		$data['session_mn_active_id'] = 300022; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_District', $data);
	}
	public function get_District_add()
	{
		$data['session_mn_active_id'] = 300022; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_District_form', $data);
	}
	public function get_District_edit($StID = null)
	{
		$data['StID'] = $StID;
		$data['session_mn_active_id'] = 300022; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_District_form', $data);
	}
	public function get_Province()
	{
		$data['session_mn_active_id'] = 300023; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Province', $data);
	}
	public function get_Province_add()
	{
		$data['session_mn_active_id'] = 300023; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Province_form', $data);
	}
	public function get_Province_edit($StID = null)
	{
		$data['StID'] = $StID;

		$data['session_mn_active_id'] = 300023; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_Province_form', $data);
	}
	public function get_user()
	{
		$data['session_mn_active_id'] = $this->mn_active_id; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profille_user_show', $data);
	}
	public function get_life_status()
	{
		$data['session_mn_active_id'] = 300020; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_person_status_show', $data);
	}
	public function get_life_status_form($StID = null)
	{
		$data['session_mn_active_id'] = 300020; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_person_status_form', $data);
	}
	public function get_country()
	{
		$data['session_mn_active_id'] = 300024; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_country_show', $data);
	}
	public function get_country_form()
	{
		$data['session_mn_active_id'] = 300024; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_country_form', $data);
	}
	public function get_person_holiday()
	{
		$data['session_mn_active_id'] = 300036; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_holiday', $data);
	}
	public function get_person_holiday_add()
	{
		$data['session_mn_active_id'] = 300036; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_holiday_form', $data);
	}
}
