<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');


class Base_prepare extends QUE_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index(){
		// $this->output('que/patient/v_patient_prepare_menu_show',$data); 

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('que/base/v_base_prepare_menu_show',$data); 
  }

  public function add_form(){
	// $this->output('que/patient/v_patient_prepare_add_form');

	$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$this->output('que/base/v_base_prepare_add_form', $data); 

  }

  public function update_form(){
	// $this->output('que/patient/v_patient_prepare_update_form');

	$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$this->output('que/base/v_base_prepare_update_form', $data); 

  }

  public function add(){
    $data['returnUrl'] = base_url().'index.php/que/Base_prepare';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);

    
	$jsonResult = json_encode($result);
    echo $jsonResult;
}

public function update(){
    $data['returnUrl'] = base_url().'index.php/que/Base_prepare';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);

    
	$jsonResult = json_encode($result);
    echo $jsonResult;
}
public function delete(){
    $data['returnUrl'] = base_url().'index.php/que/Base_prepare';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);

    
	$jsonResult = json_encode($result);
    echo $jsonResult;
}



}
?>