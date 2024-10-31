<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Race extends Base_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Race";
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
        $this->load->model($this->model . "m_hr_race");
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['rc_info'] = $this->m_hr_race->get_all_by_active()->result();
        $this->output('hr/base/v_base_race_show', $data);
    }

    /*
    * get_race_add
    * สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_race_add()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $this->output('hr/base/v_base_race_form', $data);
    }

    /*
    * get_race_edit
    * สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_race_edit($RcID = null)
    {
        $this->load->model($this->model . "m_hr_race");
        $this->m_hr_race->race_id = $RcID;
        $rc_info = $this->m_hr_race->get_by_key()->result();
        if ($rc_info != null) {
            foreach ($rc_info as $item) {
                $data['rc_info'] = $item;
            }
        }
        $data['controller']  = $this->controller;
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $this->output('hr/base/v_base_race_form', $data);
    }

    /*
    * race_insert
    * สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function race_insert()
    {
        $this->load->model($this->model . "m_hr_race");
        $this->m_hr_race->race_name =  $this->input->post('race_name');
        $this->m_hr_race->race_name_en =  $this->input->post('race_name_en');
        $this->m_hr_race->race_create_user = $this->session->userdata('us_id');
        $this->m_hr_race->race_update_user = $this->session->userdata('us_id');
        $this->m_hr_race->race_active = "1";
        $this->m_hr_race->insert();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_race';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * delete_race
    * สำหรับการ ลบ ข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function delete_race($RcID = null)
    {
        $this->load->model($this->model . "m_hr_race");
        $this->m_hr_race->race_id = $RcID;
        $this->m_hr_race->race_active = '2';
        $this->m_hr_race->disabled();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_race';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * race_update
    * สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function race_update()
    {
        $this->load->model($this->model . "m_hr_race");
        $this->m_hr_race->race_id =  $this->input->post('race_id');
        $this->m_hr_race->race_name =  $this->input->post('race_name');
        $this->m_hr_race->race_name_abbr =  $this->input->post('race_name');
        $this->m_hr_race->race_update_user = $this->session->userdata('us_id');
        $this->m_hr_race->race_active = $this->input->post('race_active');
        $this->m_hr_race->update();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/Profile/get_race';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * checkValue
    * นำเข้าข้อมูลใหม่มาตรวจสอบ
    * $input ตัวแปลที่ต้องการเช็ค
    * $output ผลลัพธ์ของการตรวจสอบ
    * @Create Date 30/05/2024
    */
    public function checkValue()
    {
        $this->load->model($this->model . "m_hr_race");
        $formdata = $this->input->post();
        foreach ($formdata as $key => $value) {
            $this->m_hr_race->$key = $value;
        }
        $query = $this->m_hr_race->finding()->result();
        if (count($query) > 0) {
            $data['status_response'] = '1';
        } else {
            $data['status_response'] = '0';
        }
        echo json_encode($data);
    }
}
