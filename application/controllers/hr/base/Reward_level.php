<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class reward_level extends Base_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/reward_level";
    }

    /*
    * index
    * สำหรับการเรียกหน้า view รายการข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function index()
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['rwlv_info'] = $this->m_hr_reward_level->get_all_by_active()->result();
        $this->output('hr/base/v_base_reward_level_show', $data);
    }

    /*
    * get_reward_level_add
    * สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_reward_level_add()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $this->output('hr/base/v_base_reward_level_form', $data);
    }

    /*
    * get_reward_level_edit
    * สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_reward_level_edit($HtID = null)
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $this->m_hr_reward_level->rwlv_id = $HtID;
        $rwlv_info = $this->m_hr_reward_level->get_by_key()->result();
        if ($rwlv_info != null) {
            foreach ($rwlv_info as $item) {
                $data['rwlv_info'] = $item;
            }
        }
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $this->output('hr/base/v_base_reward_level_form', $data);
    }

    /*
    * reward_level_insert
    * สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function reward_level_insert()
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $this->m_hr_reward_level->rwlv_name =  $this->input->post('rwlv_name');
        $this->m_hr_reward_level->rwlv_name_en = $this->input->post('rwlv_name_en');
        $this->m_hr_reward_level->rwlv_active = "1";
        $this->m_hr_reward_level->insert();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/reward_level';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * delete_reward_level
    * สำหรับการ ลบ ข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function delete_reward_level($RlvID = null)
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $this->m_hr_reward_level->rwlv_id = $RlvID;
        $this->m_hr_reward_level->rwlv_active = '2';
        $this->m_hr_reward_level->disabled();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/reward_level';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * reward_level_update
    * สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function reward_level_update()
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $this->m_hr_reward_level->rwlv_id =  $this->input->post('rwlv_id');
        $this->m_hr_reward_level->rwlv_name =  $this->input->post('rwlv_name');
        $this->m_hr_reward_level->rwlv_name_en =  $this->input->post('rwlv_name_en');
        $this->m_hr_reward_level->rwlv_active = $this->input->post('rwlv_active');
        $this->m_hr_reward_level->update();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/reward_level';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * checkValue
    * สำหรับการตรวจสอบค่าข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function checkValue()
    {
        $this->load->model($this->model . "m_hr_reward_level");
        $formdata = $this->input->post();
        foreach ($formdata as $key => $value) {
            $this->m_hr_reward_level->$key = $value;
        }
        $query = $this->m_hr_reward_level->finding()->result();
        if (count($query) > 0) {
            $data['status_response'] = '1';
        } else {
            $data['status_response'] = '0';
        }
        echo json_encode($data);
    }
}
