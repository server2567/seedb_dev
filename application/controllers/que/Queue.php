<?php

use PhpOffice\PhpWord\Shared\Validate;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Queue extends QUE_Controller {
	
    public function __construct()
    {
        parent::__construct();
        $this->load->model('que/M_que_create_queue');
        $this->load->model('que/M_que_base_department_queue');
		$this->load->model('que/M_que_base_type');
	
        $this->load->library('session');
        $this->session_ps_id = !empty($this->session->userdata('st_name_abbr_en')) && $this->session->userdata('st_name_abbr_en') == 'WTS' ? $this->session->userdata('us_ps_id') : null;
    }


    function index(){
        
		
		$data['status_response'] = $this->config->item('status_response_show');
        $data['Track'] = $this->M_que_create_queue->get_all_active()->result();
        foreach ($data['Track'] as $item){
            $item->cq_id = encrypt_id($item->cq_id);
            
        }
        $data['count'] = count($data['Track']); 
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$this->output('que/queue/v_queue_show',$data);   
  }
  
  public function add_form($id=''){
    if($id){
        $id = decrypt_id($id);
        $data['info']=$this->M_que_create_queue->get_by_id($id)->row();
        $data['info']->cq_id = encrypt_id($data['info']->cq_id);
        
    }
    $data['keyword']=$this->M_que_base_department_queue->get_all_by_active_and_person_sorted_name()->result();

    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('que/queue/v_queue_add_form',$data);

}
public function format_form($id) {
    $id = decrypt_id($id);
    $data['type'] = $this->M_que_base_type->get_all_active()->result();
    $data['info'] = $this->M_que_create_queue->get_by_id($id)->result();
    $data['info'][0]->cq_value = json_decode($data['info'][0]->cq_value);
    $data['info'][0]->cq_id = encrypt_id($data['info'][0]->cq_id);
    
    foreach ($data['type'] as $item){
        // Check if type_value is in JSON format
        $decoded_value = json_decode($item->type_value);
        if ($decoded_value !== null) {
            // If it's JSON, decode it
            $item->type_value = $decoded_value;
        } else {
            // If not, keep it as string
            $item->type_value = $item->type_value;
        }
    } 
    
    
    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('que/queue/v_queue_format_form', $data);
}

public function add($id=''){
    if($id){
        $id =decrypt_id($id);
        $input =$this->input->post();
        $this->M_que_create_queue->cq_id = $id;
        $this->M_que_create_queue->cq_name = $input['cq_name'];
        $this->M_que_create_queue->cq_dpq_id = $input['cq_dpq_id'];
        $keyword = $this->M_que_base_department_queue->get_all_by_id($input['cq_dpq_id'])->row();
        $this->M_que_create_queue->cq_keyword = $keyword->dpq_keyword;
        $this->M_que_create_queue->cq_active = $this->input->post('cq_active') ? 1 : 0;
        $this->M_que_create_queue->cq_update_user = $this->session->userdata('us_id');
        $this->M_que_create_queue->cq_update_date = date('Y-m-d H:i:s');
        $this->M_que_create_queue->update();
    } else {
        $input = $this->input->post();
        $this->M_que_create_queue->cq_name = $input['cq_name'];
        $this->M_que_create_queue->cq_dpq_id = $input['cq_dpq_id'];
        $keyword = $this->M_que_base_department_queue->get_all_by_id($input['cq_dpq_id'])->row();
        $this->M_que_create_queue->cq_keyword = $keyword->dpq_keyword;
        $this->M_que_create_queue->cq_active = $this->input->post('cq_active') ? 1 : 0;
        $this->M_que_create_queue->cq_create_user = $this->session->userdata('us_id');
        $this->M_que_create_queue->cq_create_date = date('Y-m-d H:i:s');
        $this->M_que_create_queue->insert();
        
    }
    $data['returnUrl'] = base_url().'index.php/que/Queue';
    $data['status_response'] = $this->config->item('status_response_success');
    $result = array('data' => $data);    
    $jsonResult = json_encode($result);
    echo $jsonResult;
}
public function update_format($id){
    
    $id=decrypt_id($id);
    
    $input = $this->input->post();
    $cq_value_count= $input['cq_value_count'];
    
    $value_demo = '';
    for ($i = 1; $i <= $cq_value_count; $i++) {
        if (!empty($input['ex' . $i])) {
            $value_demo .= $input['ex' . $i];
        }
    }
    
    $base_type = $this->M_que_base_type->get_all_active()->result();

    

    $type_value_array = array();
    for ($i = 1; $i <= $cq_value_count; $i++) {
        if (!empty($input['pos' . $i])) {
            foreach ($base_type as $type) {
                if ($type->type_code == "fx" && $type->type_id == $input['pos' . $i]) {
                    $type_value_array[] = [
                        "char_length" => strlen(trim($input['ex' . $i])),
                        "function" => "",
                        "char_id" => $input['pos' . $i],
                        "char_type" => "fx",
                        "char_type_value" => $input['ex' . $i]
                    ];
                }
                if ($type->type_code == "yr" && $type->type_id == $input['pos' . $i]) {
                    $type_value_array[] = [
                        "char_length" => strlen(trim($input['ex' . $i])),
                        "function" => base64_encode($type->type_func),
                        "char_id" => $input['pos' . $i],
                        "char_type" => "yr",
                        "char_type_value" => $input['ex' . $i]
                    ];
                } 
                if ($type->type_code == "rd" && $type->type_id == $input['pos' . $i]) {
                    $type_value_array[] = [
                        "char_length" => $input['length_pos' . $i],
                        "function" => base64_encode($type->type_func),
                        "char_id" => $input['pos' . $i],
                        "char_type" => "rd",
                        "char_type_value" => $input['ex' . $i]
                    ];
                }
                if ($type->type_code == "rn" && $type->type_id == $input['pos' . $i]) {
                    $type_value_array[] = [
                        "char_length" => $input['length_pos' . $i],
                        "function" => base64_encode($type->type_func),
                        "char_id" => $input['pos' . $i],
                        "char_type" => "rn",
                        "char_type_value" => $input['ex' . $i]
                    ];
                }
            }
        }
    }
    
    $this->M_que_create_queue->cq_value_demo = $value_demo;
    $info = $this->M_que_create_queue->get_by_id($id)->row();
    
    $this->M_que_create_queue->cq_dpq_id = $info->cq_dpq_id;
    $this->M_que_create_queue->cq_name = $info->cq_name;
    $keyword = $this->M_que_base_department_queue->get_all_by_id($info->cq_dpq_id)->row();
    $this->M_que_create_queue->cq_keyword = $keyword->dpq_keyword;
    $this->M_que_create_queue->cq_value = json_encode($type_value_array);
    $this->M_que_create_queue->cq_id = $id;
    $this->M_que_create_queue->cq_update_user = $this->session->userdata('us_id');
    $this->M_que_create_queue->cq_update_date = date('Y-m-d H:i:s');
    $this->M_que_create_queue->update_format();
    
    $data['returnUrl'] = base_url().'index.php/que/Queue';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);
    $jsonResult = json_encode($result);
    echo $jsonResult;
}



}