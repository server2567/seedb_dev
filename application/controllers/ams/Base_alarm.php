<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');


class Base_alarm extends AMS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ams/base/M_ams_base_alarm');

	}

	function index(){
        
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);; // set session_mn_active_url / breadcrumb
		$data['alarm'] = $this->M_ams_base_alarm->get_all_active()->result();
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ams/base/v_base_alarm_show',$data);   
  }

  function add_form(){
	$data['status_response'] = $this->config->item('status_response_show');;
	$data['alarm'] = $this->M_ams_base_alarm->get_notify_unique()->result();
	$this->output('ams/base/v_base_alarm_add_form',$data);   
}
  function update_form($id){
	
	$data['status_response'] = $this->config->item('status_response_show');;
	$data['alarm'] = $this->M_ams_base_alarm->get_notify_unique()->result();
	$data['info'] = $this->M_ams_base_alarm->get_by_id($id)->row();
	
	$this->output('ams/base/v_base_alarm_update_form',$data);   
}

function add(){
	$input = $this->input->post();
	$this->M_ams_base_alarm->al_ntf_id = $input['al_ntf_id'];
	$this->M_ams_base_alarm->al_number = $input['al_number'];
	$this->M_ams_base_alarm->al_day = $input['al_day'];
	$this->M_ams_base_alarm->al_minute = $input['al_minute'];
	$this->M_ams_base_alarm->al_time = $input['al_time'];
	$this->M_ams_base_alarm->al_active = $this->input->post('al_active') ? 1 : 0;
	$this->M_ams_base_alarm->al_create_user = $this->session->userdata('us_id');
	$this->M_ams_base_alarm->al_create_date = date('Y-m-d H:i:s');
	$this->M_ams_base_alarm->insert();
	$data['returnUrl'] = base_url().'index.php/ams/Base_alarm';
	$data['status_response'] = $this->config->item('status_response_success');
	$result = array('data' => $data);

	echo json_encode($result);
	
}

function update($id){
	$input = $this->input->post();
	
	$this->M_ams_base_alarm->al_id = $id;
	$this->M_ams_base_alarm->al_ntf_id = $input['al_ntf_id'];
	$this->M_ams_base_alarm->al_number = $input['al_number'];
	$this->M_ams_base_alarm->al_day = $input['al_day'];
	$this->M_ams_base_alarm->al_minute = $input['al_minute'];
	$this->M_ams_base_alarm->al_time = $input['al_time'];
	$this->M_ams_base_alarm->al_active = $this->input->post('al_active') ? 1 : 0;
	$this->M_ams_base_alarm->al_update_user = $this->session->userdata('us_id');
	$this->M_ams_base_alarm->al_update_date = date('Y-m-d H:i:s');
	$this->M_ams_base_alarm->update();
	$data['returnUrl'] = base_url().'index.php/ams/Base_alarm';
	$data['status_response'] = $this->config->item('status_response_success');
	$result = array('data' => $data);

	echo json_encode($result);
	
}

  public function show_info($id)
	{   
        $data['id'] = $id;
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);;
		$this->output('que/patient/v_patient_info',$data);
	}

	public function show_patient($id)
	{
		$data['id'] = $id;
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);;
		$this->output('que/patient/v_patient_show',$data);
	}

}
?>