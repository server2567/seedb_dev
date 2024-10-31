<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');


class Base_notify extends AMS_Controller
{ 

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('ams/base/M_ams_base_notify');

		
	}

	function index(){
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['notify'] = $this->M_ams_base_notify->get_all_active()->result();
		$this->output('ams/base/v_base_notify_show',$data);   
  }
  function add_form(){

	$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$this->output('ams/base/v_base_notify_add_form',$data);   
}
function add(){
	$input = $this->input->post();
	
	$this->M_ams_base_notify->ntf_name = $input['ntf_name'];
	$this->M_ams_base_notify->ntf_name_en = $input['ntf_name_en'];
	$this->M_ams_base_notify->ntf_active = $this->input->post('ntf_active') ? 1 : 0;
	$this->M_ams_base_notify->ntf_create_user = $this->session->userdata('us_id');
	$this->M_ams_base_notify->ntf_create_date = date('Y-m-d H:i:s');
	$this->M_ams_base_notify->insert();
	$data['returnUrl'] = base_url().'index.php/ams/Base_notify';
	$data['status_response'] = $this->config->item('status_response_success');
	$result = array('data' => $data);

	echo json_encode($result);
	
}

function update_form($id){
	$data['info'] = $this->M_ams_base_notify->get_by_id($id)->row();
	$data['status_response'] = $this->config->item('status_response_show');;
	
	$this->output('ams/base/v_base_notify_update_form',$data);   
}
public function update($id){
    $input = $this->input->post();
    $this->M_ams_base_notify->ntf_id = $id;
    $this->M_ams_base_notify->ntf_name = $input['ntf_name'];
    $this->M_ams_base_notify->ntf_name_en = $input['ntf_name_en'];
    $this->M_ams_base_notify->ntf_active = $this->input->post('ntf_active') ? 1 : 0;
    $this->M_ams_base_notify->ntf_update_user = $this->session->userdata('us_id');
    $this->M_ams_base_notify->ntf_update_date = date('Y-m-d H:i:s');
    $this->M_ams_base_notify->update();
    $data['returnUrl'] = base_url().'index.php/ams/Base_notify';
    $data['status_response'] = $this->config->item('status_response_success');
    $result = array('data' => $data);

	echo json_encode($result);
}


public function delete($id){
	
    $current = $this->M_ams_base_notify->get_by_id($id)->row();
	
    if ($current->ntf_active =="0"){
        $this->M_ams_base_notify->ntf_id = $id;
        $this->M_ams_base_notify->ntf_active = '2';
        $this->M_ams_base_notify->delete();
        $data['returnUrl'] = base_url().'index.php/ams/Base_notify';
    $data['status_response'] = $this->config->item('status_response_success');
    $result = array('data' => $data);
	echo json_encode($result);
    } else {
        $data['returnUrl'] = base_url().'index.php/ams/Base_notify';
        $data['status_response'] = $this->config->item('status_response_error');
        $result = array('data' => $data);
	    echo json_encode($result);
    }
   
}



}
  
  
?>