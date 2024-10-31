<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Tracking_manage extends QUE_Controller {
    public function __construct()
    {
        parent::__construct();
		$this->load->model('que/M_que_create_tracking');
        $this->load->model('que/M_que_base_type');
        $this->load->model('que/M_que_department');
        $this->load->model('que/M_que_code_list');

		// $this->load->library('session');
        
        // check call function from WTS or QUE
        $this->session_ps_id = !empty($this->session->userdata('st_name_abbr_en')) && $this->session->userdata('st_name_abbr_en') == 'WTS' ? $this->session->userdata('us_ps_id') : null;
	}

    function index(){
        if(!empty($this->session_ps_id))
		    $data['track'] = $this->M_que_create_tracking->get_all_by_active_and_person($this->session_ps_id)->result();
        else
		    $data['track'] = $this->M_que_create_tracking->get_all_active()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('que/tracking/v_tracking_manage_show',$data);
    }

    public function add_form(){
        if(!empty($this->session_ps_id))
            $data['keyword']=$this->M_que_department->get_all_by_active_and_person_sorted_name($this->session_ps_id)->result();
        else
            $data['keyword']=$this->M_que_department->get_all_by_active_sorted_name()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/tracking/v_tracking_manage_add_form',$data);

    }

    public function format_form($id) {
        $data['type'] = $this->M_que_base_type->get_all_active()->result();
        $data['info'] = $this->M_que_create_tracking->get_by_id($id)->result();

        $data['info'][0]->ct_value = json_decode($data['info'][0]->ct_value);
        
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
        
        $data['current_code'] = $this->M_que_code_list->Check_last_que($data['info'][0]->ct_keyword);
        
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/tracking/v_tracking_manage_format_form', $data);
    }


    public function update_form($id){
        if(!empty($this->session_ps_id))
            $data['keyword']=$this->M_que_department->get_all_by_active_and_person_sorted_name($this->session_ps_id)->result();
        else
            $data['keyword']=$this->M_que_department->get_all_by_active_sorted_name()->result();
        
        $data['info']=$this->M_que_create_tracking->get_by_id($id)->row(); 

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/tracking/v_tracking_manage_update_form',$data);
    }


    public function add(){
        $input = $this->input->post();
        
        $this->M_que_create_tracking->ct_name = $input['ct_name'];
        $this->M_que_create_tracking->ct_dpk_id = $input['ct_dpk_id'];
        $keyword = $this->M_que_department->get_all_by_id($input['ct_dpk_id'])->row();
        $this->M_que_create_tracking->ct_keyword = $keyword->dpk_keyword;
        $this->M_que_create_tracking->ct_active = $this->input->post('ct_active') ? 1 : 0;
        $this->M_que_create_tracking->ct_create_user = $this->session->userdata('us_id');
        $this->M_que_create_tracking->ct_create_date = date('Y-m-d H:i:s');
        $this->M_que_create_tracking->insert();
        $data['returnUrl'] = base_url().'index.php/que/Tracking_manage';
        $data['status_response'] = $this->config->item('status_response_success');

        $result = array('data' => $data);
        
        $jsonResult = json_encode($result);
        echo $jsonResult;
    }

    public function update($id){
        $input = $this->input->post();
        $this->M_que_create_tracking->ct_id = $id;
        $this->M_que_create_tracking->ct_name = $input['ct_name'];
        $this->M_que_create_tracking->ct_dpk_id = $input['ct_dpk_id'];
        $keyword = $this->M_que_department->get_all_by_id($input['ct_dpk_id'])->row();
        $this->M_que_create_tracking->ct_keyword = $keyword->dpk_keyword;
        $this->M_que_create_tracking->ct_active = $this->input->post('ct_active') ? 1 : 0;
        $this->M_que_create_tracking->ct_update_user = $this->session->userdata('us_id');
        $this->M_que_create_tracking->ct_update_date = date('Y-m-d H:i:s');
        $this->M_que_create_tracking->update();
        $data['returnUrl'] = base_url().'index.php/que/Tracking_manage';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        $jsonResult = json_encode($result);

        echo $jsonResult;
    }
    public function update_format($id){
        $input = $this->input->post();
        $ct_value_count= $input['ct_value_count'];
        
        $value_demo = '';
        for ($i = 1; $i <= $ct_value_count; $i++) {
            if (!empty($input['ex' . $i])) {
                $value_demo .= $input['ex' . $i];
            }
        }
        
        $base_type = $this->M_que_base_type->get_all_active()->result();

        

        $type_value_array = array();
        for ($i = 1; $i <= $ct_value_count; $i++) {
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
        
        $this->M_que_create_tracking->ct_value_demo = $value_demo;
        $info = $this->M_que_create_tracking->get_by_id($id)->row();
        $this->M_que_create_tracking->ct_dpk_id = $info->ct_dpk_id;
        $this->M_que_create_tracking->ct_name = $info->ct_name;
        $keyword = $this->M_que_department->get_all_by_id($info->ct_dpk_id)->row();
        $this->M_que_create_tracking->ct_keyword = $keyword->dpk_keyword;
        $this->M_que_create_tracking->ct_value = json_encode($type_value_array);
        $this->M_que_create_tracking->ct_id = $id;
        $this->M_que_create_tracking->ct_update_user = $this->session->userdata('us_id');
        $this->M_que_create_tracking->ct_update_date = date('Y-m-d H:i:s');
        $this->M_que_create_tracking->update_format();
        
        $data['returnUrl'] = base_url().'index.php/que/Tracking_manage';
        $data['status_response'] = $this->config->item('status_response_success');

        $result = array('data' => $data);
        $jsonResult = json_encode($result);
        echo $jsonResult;
    }

    public function delete($id){
        $current = $this->M_que_create_tracking->get_by_id($id)->row();

        if ($current->ct_active =="0"){
            $this->M_que_create_tracking->ct_id = $id;
            $this->M_que_create_tracking->ct_active = '2';
            $this->M_que_create_tracking->delete();
            $data['returnUrl'] = base_url().'index.php/que/Tracking_manage';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
        } else {
            $data['returnUrl'] = base_url().'index.php/que/Tracking_manage';
            $data['status_response'] = $this->config->item('status_response_error');
            $result = array('data' => $data);
            echo json_encode($result);
        }
    
    }
}