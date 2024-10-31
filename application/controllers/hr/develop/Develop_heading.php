<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Develop_Controller.php");

class Develop_heading  extends Develop_Controller
{

    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/develop/Develop_heading";
        $this->load->model($this->model . 'M_hr_person');
        $this->load->model($this->model . 'M_hr_develop');
        $this->load->model($this->model . 'M_hr_develop_heading');
        $this->load->model($this->model . 'base/M_hr_develop_type');
        $this->load->model($this->model . "/base/m_hr_structure_position");
    }

    public function index()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $data['controller_dir'] = 'hr/develop/Develop_heading/';
        $devh_list = $this->M_hr_develop_heading->get_develop_list_by_ps_id()->result();
        $data['devh_heading_list'] = [];
        foreach ($devh_list as $row) {
            // Check if the group already exists in the $variable array
            if (!isset($data['devh_heading_list'][$row->devh_gp_id])) {
                // If not, create a new group entry
                $data['devh_heading_list'][$row->devh_gp_id] = [
                    'devh_g_id' => encrypt_id($row->devh_gp_id),
                    'devh_g_name' => $row->devh_group_name, // You can set the group name if needed
                    'devh_child' => []
                ];
            }

            // Add the child item to the corresponding group
            $data['devh_heading_list'][$row->devh_gp_id]['devh_child'][] = [
                'devh_id' => $row->devh_id,
                'devh_name_th' => $row->devh_name_th,
                'devh_name_en' => $row->devh_name_en,
                'devh_seq' => $row->devh_seq,
            ];
        }

        // Reset keys to re-index $variable array
        $data['devh_heading_list'] = array_values($data['devh_heading_list']);
        $this->output('hr/develop/v_Develop_heading_show', $data);
    }
    public function get_Develop_heading_form($g_id = null)
    {
        $g_id = decrypt_id($g_id);
        if (isset($g_id) || $g_id != null) {
            $this->M_hr_develop_heading->devh_gp_id = $g_id;
            $result = $this->M_hr_develop_heading->get_develop_heading_by_gp_id()->result();
            $count = count($result);
            $data['develop_heading'] = (object)[];
            $data['develop_heading']->devh_gp_id = $result[0]->devh_gp_id;
            $data['develop_heading']->devh_group_name = $result[0]->devh_group_name;
            foreach ($result as $key => $value) {
                $data['develop_heading']->devh_child[$key]['devh_id'] = $value->devh_id;
                $data['develop_heading']->devh_child[$key]['devh_name_th'] = $value->devh_name_th;
                $data['develop_heading']->devh_child[$key]['devh_name_en'] = $value->devh_name_en;
                $data['develop_heading']->devh_child[$key]['devh_seq'] = $key + 1;
            }
            $data['develop_heading']->devh_name_en = $result[0]->devh_name_en;
            $data['develop_heading']->count_round = $count;
        }
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['controller_dir'] = 'hr/develop/Develop_heading/';
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('hr/develop/v_Develop_heading_form', $data);
    }
    public function submit_develop_form()
    {
        $post_data = $this->input->post();
        $this->M_hr_develop->dev_topic = $post_data['dev_topic'];
        $this->M_hr_develop->dev_desc = $post_data['dev_desc'];
        $this->M_hr_develop->dev_start_date = $post_data['dev_start_date'];
        $this->M_hr_develop->dev_end_date = $post_data['dev_end_date'];
        $this->M_hr_develop->dev_end_time = $post_data['dev_end_time'];
        $this->M_hr_develop->dev_hour = $post_data['dev_hour'];
        $this->M_hr_develop->dev_place = $post_data['dev_place'];
        $this->M_hr_develop->dev_country_id = $post_data['dev_country_id'];
        $this->M_hr_develop->dev_pv_id = $post_data['dev_pv_id'];
        $this->M_hr_develop->dev_project = $post_data['dev_project'];
        $this->M_hr_develop->dev_budget = $post_data['dev_budget'];
        $this->M_hr_develop->dev_allowance = $post_data['dev_allowance'];
        $this->M_hr_develop->dev_accommodation = $post_data['dev_accommodation'];
        $this->M_hr_develop->dev_budget_type_other = $post_data['dev_budget_type_other'];
        $this->M_hr_develop->dev_budget_vat = $post_data['dev_budget_vat'];
        $this->M_hr_develop->dev_allowance_vat = $post_data['dev_allowance_vat'];
        $this->M_hr_develop->dev_accommodation_vat = $post_data['dev_accommodation_vat'];
        $this->M_hr_develop->dev_budget_type_other_vat = $post_data['dev_budget_type_other_vat'];
        $this->M_hr_develop->dev_objecttive = $post_data['dev_objecttive'];
        $this->M_hr_develop->dev_short_content = $post_data['dev_short_content'];
        $this->M_hr_develop->dev_benefits = $post_data['dev_benefits'];
        $this->M_hr_develop->dev_type = $post_data['dev_type'];
        $this->M_hr_develop->dev_status = 1;
        $this->M_hr_develop->dev_go_service_type = $post_data['service_type'];
        $this->M_hr_develop->dev_certificate = $post_data['dev_certi'];
        $this->M_hr_develop->dev_create_user = $this->session->userdata('us_id');
        $this->M_hr_develop->dev_organized_type = $post_data['dev_organized'];
        if ($post_data['dev_id'] != 'new') {
            $this->M_hr_develop->dev_id = $post_data['dev_id'];
            $this->M_hr_develop->update();
            foreach ($post_data['dev_person_list'] as $key => $value) {
                if ($value['check'] == 'old') {
                    $this->M_hr_develop->update_develop_person($post_data['dev_id'], $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
                } else {
                    $this->M_hr_develop->insert_develop_person($post_data['dev_id'], $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
                }
            }
        } else {
            $this->M_hr_develop->insert();
            foreach ($post_data['dev_person_list'] as $key => $value) {
                $dev_id = $this->M_hr_develop->last_insert_id;
                $this->M_hr_develop->insert_develop_person($dev_id, $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
            }
        }
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function delete_develop_form()
    {
        $this->M_hr_develop->dev_id = $this->input->post('dev_id');
        $this->M_hr_develop->dev_status = 0;
        $this->M_hr_develop->dev_update_user = $this->session->userdata('us_id');
        $this->M_hr_develop->delete_develop_by_id();
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function insert_develop_heading()
    {
        $develop_info = $this->input->post('develop_info');
        $last_gp_id = $this->M_hr_develop_heading->get_last_group_id()->row();
        foreach ($develop_info['additional_rounds'] as $key => $value) {
            $this->M_hr_develop_heading->devh_name_th = $value['devh_name_th'];
            $this->M_hr_develop_heading->devh_name_en = $value['devh_name_en'];
            $this->M_hr_develop_heading->devh_seq = $key + 1;
            $this->M_hr_develop_heading->devh_group_name = $develop_info['devh_name_th_main'];
            $this->M_hr_develop_heading->devh_gp_id = $last_gp_id->max + 1;
            $this->M_hr_develop_heading->devh_status = 1;
            $this->M_hr_develop_heading->devh_create_user = $this->session->userdata('us_id');
            $this->M_hr_develop_heading->insert();
        }
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function update_develop_heading()
    {
        $develop_info = $this->input->post('develop_info');
        $this->M_hr_develop_heading->devh_group_name = $develop_info['devh_name_th_main'];
        $this->M_hr_develop_heading->devh_update_user = $this->session->userdata('us_id');
        $result = $this->M_hr_develop_heading->get_develop_heading_by_gp_id()->result();
        // $this->M_hr_develop_heading->update();
        foreach ($develop_info['additional_rounds'] as $key => $value) {
                $this->M_hr_develop_heading->devh_name_th = $value['devh_name_th'];
                $this->M_hr_develop_heading->devh_name_en = $value['devh_name_en'];
                $this->M_hr_develop_heading->devh_seq = $key+1;
                $this->M_hr_develop_heading->devh_gp_id = $develop_info['devh_gp_id'];
                $this->M_hr_develop_heading->devh_status = 1;
                if($value['devh_id'] != null){
                    $this->M_hr_develop_heading->devh_update_user = $this->session->userdata('us_id');
                    $this->M_hr_develop_heading->devh_id =  $value['devh_id'];
                    $this->M_hr_develop_heading->update();    
                }else{
                    $this->M_hr_develop_heading->devh_create_user = $this->session->userdata('us_id');
                    $this->M_hr_develop_heading->insert();
                }
        }
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function delete_develop_heading()
    {
        $this->M_hr_develop_heading->devh_id = $this->input->post('devh_id');
        $this->M_hr_develop_heading->devh_status = 2;
        $this->M_hr_develop_heading->devh_update_user = $this->session->userdata('us_id');
        $this->M_hr_develop_heading->change_staus_to_delete();
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

}
