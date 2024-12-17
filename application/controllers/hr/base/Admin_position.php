<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class admin_position extends Base_Controller
{
	private $mn_active_id = 300012; // this menu

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct(); 
	}

    public function index()
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$data['session_mn_active_id'] = 300017; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['admin_info'] = $this->m_hr_admin_position->get_all_by_active()->result();
		$this->output('hr/base/v_base_admin_position_show', $data);
	}
	public function get_admin_position_add()
	{
		$data['session_mn_active_id'] = 300017; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_admin_position_form', $data);
	}
	public function get_admin_position_edit($HtID =null)
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->alp_id = $HtID;
		$admin_info = $this->m_hr_admin_position->get_by_key()->result();
		if ($admin_info != null) {
			foreach ($admin_info as $item) {
				$data['admin_info'] = $item;
			}
		} 
		$data['session_mn_active_id'] = 300016; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/base/v_base_admin_position_form', $data);
	}
	public function admin_position_insert()
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->alp_name =  $this->input->post('alp_name');
		$this->m_hr_admin_position->alp_name_en =  $this->input->post('alp_name_en');
		$this->m_hr_admin_position->alp_name_abbr =  $this->input->post('alp_name_abbr');
		$this->m_hr_admin_position->alp_name_abbr_en =  $this->input->post('alp_name_abbr_en');
		$this->m_hr_admin_position->alp_type =  $this->input->post('alp_type');
		$this->m_hr_admin_position->alp_active = "Y";
		$this->m_hr_admin_position->insert();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function delete_admin_position($SpID = null){
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->alp_id = $SpID;
		$this->m_hr_admin_position->delete();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function admin_position_update()
	{
		$this->load->model($this->model . "m_hr_admin_position");
		$this->m_hr_admin_position->alp_id =  $this->input->post('alp_id');
		$this->m_hr_admin_position->alp_name =  $this->input->post('alp_name');
		$this->m_hr_admin_position->alp_name_en =  $this->input->post('alp_name_en');
		$this->m_hr_admin_position->alp_name_abbr =  $this->input->post('alp_name_abbr');
		$this->m_hr_admin_position->alp_name_abbr_en =  $this->input->post('alp_name_abbr_en');
		$this->m_hr_admin_position->alp_type =  $this->input->post('alp_type');
		$this->m_hr_admin_position->alp_active = $this->input->post('alp_active');
		$this->m_hr_admin_position->update();
		$data['returnUrl'] = base_url() . 'index.php/hr/base/admin_position';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
}