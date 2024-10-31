<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Occupartion extends Base_Controller
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
		$this->output('hr/base/v_person_list_show', $data);
	}
	// Base Prefix
	public function get_occupation()
	{
		var_dump('เข้า');
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->load->model($this->model . "m_hr_occupation");
		$data['pf'] =  $this->m_hr_prefix->get_all_by_active()->result();
		$this->output($this->view . 'v_base_occupation', $data);
	}
	public function get_prefix_add()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['gd_info'] = $this->m_hr_prefix->get_gender()->result();
		$this->output($this->view . 'v_base_prefix_form', $data);
	}
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
		$data['session_mn_active_id'] = 300014; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output($this->view . 'v_base_prefix_form', $data);
	}
	public function prefix_insert()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_name =  $this->input->post('pf_name');
		$this->m_hr_prefix->pf_name_en = $this->input->post('pf_name_en');
		$this->m_hr_prefix->pf_gd_id = $this->input->post('pf_gd_id');
		$this->m_hr_prefix->pf_name_abbr =  $this->input->post('pf_name_abbr');
		$this->m_hr_prefix->pf_name_abbr_en = $this->input->post('pf_name_abbr_en');
		$this->m_hr_prefix->pf_active = "Y";
		$this->m_hr_prefix->insert();
		$data['returnUrl'] = base_url() . 'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function prefix_update()
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_id =  $this->input->post('pf_id');
		$this->m_hr_prefix->pf_name =  $this->input->post('pf_name');
		$this->m_hr_prefix->pf_name_en = $this->input->post('pf_name_en');
		$this->m_hr_prefix->pf_name_abbr =  $this->input->post('pf_name_abbr');
		$this->m_hr_prefix->pf_name_abbr_en = $this->input->post('pf_name_abbr_en');
		$this->m_hr_prefix->pf_gd_id = $this->input->post('pf_gd_id');
		$this->m_hr_prefix->update();
	}
	public function prefix_delete($pf_id)
	{
		$this->load->model($this->model . "m_hr_prefix");
		$this->m_hr_prefix->pf_id = $pf_id;
		$this->m_hr_prefix->delete();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/Prefix';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// End Of Base Prefix
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
	public function get__user()
	{
		$data['session_mn_active_id'] = $this->mn_active_id; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profille_user_show', $data);
	}
	public function get_occupation_form($StID = null)
	{
		$data['session_mn_active_id'] = 300015; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_occupation_form', $data);
	}
	public function get_life_status()
	{
		$data['session_mn_active_id'] = 300016; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_life_status_show', $data);
	}
	public function get_life_status_form()
	{
		$data['session_mn_active_id'] = 300016; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_life_status_form', $data);
	}
	public function get_nation()
	{
		$data['session_mn_active_id'] = 300017; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_nation_show', $data);
	}
	public function get_nation_form($StID = null)
	{
		$data['session_mn_active_id'] = 300017; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_nation_form', $data);
	}
	public function get_race()
	{
		$data['session_mn_active_id'] = 300018; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_race_show', $data);
	}
	public function get_race_form($StID = null)
	{
		$data['session_mn_active_id'] = 300018; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_race_form', $data);
	}
	public function get_religion()
	{
		$data['session_mn_active_id'] = 300019; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_religion_show', $data);
	}
	public function get_religion_form($StID = null)
	{
		$data['session_mn_active_id'] = 300019; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_religion_form', $data);
	}
	public function get_person_status()
	{
		$data['session_mn_active_id'] = 300020; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_person_status_show', $data);
	}
	public function get_person_status_form($StID = null)
	{
		$data['session_mn_active_id'] = 300020; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_person_status_form', $data);
	}
	public function get_country()
	{
		$data['session_mn_active_id'] = 300024; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_Profile_country_show', $data);
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
		$this->output('hr/Profile/v_person_holiday', $data);
	}
	public function get_person_holiday_add()
	{
		$data['session_mn_active_id'] = 300036; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/Profile/v_person_holiday_form', $data);
	}
}
