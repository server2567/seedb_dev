<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Province extends Base_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Province";
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
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $this->load->model($this->model . "m_hr_province");
        $data['pv_info'] =  $this->m_hr_province->get_all_by_active()->result();
        $this->output($this->view . 'v_base_province', $data);
    }

    /*
    * get_province_add
    * สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_province_add()
    {
        $this->load->model($this->model . "m_hr_province");
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $this->output($this->view . 'v_base_province_form', $data);
    }

    /*
    * get_province_edit
    * สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function get_province_edit($PvID = null)
    {
        $this->load->model($this->model . "m_hr_province");
        $this->m_hr_province->pv_id = $PvID;
        $pv_info = $this->m_hr_province->get_by_key()->result();
        if ($pv_info != null) {
            foreach ($pv_info as $item) {
                $data['pv_info'] = $item;
            }
        }
        $data['controller']  = $this->controller;
        $data['pv_info']->pv_id = $PvID;
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $this->output($this->view . 'v_base_province_form', $data);
    }

    /*
    * province_insert
    * สำหรับการเพิ่มข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function province_insert()
    {
        $this->load->model($this->model . "m_hr_province");
        $this->m_hr_province->pv_name =  $this->input->post('pv_name');
        $this->m_hr_province->pv_name_en = $this->input->post('pv_name_en');
        $this->m_hr_province->pv_create_user = $this->session->userdata('us_id');
        $this->m_hr_province->pv_update_user = $this->session->userdata('us_id');
        $this->m_hr_province->pv_active = "1";
        $this->m_hr_province->insert();
        $data['returnUrl'] = base_url() . 'index.php/ums/System';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * province_update
    * สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function province_update()
    {
        $this->load->model($this->model . "m_hr_province");
        $this->m_hr_province->pv_id =  $this->input->post('pv_id');
        $this->m_hr_province->pv_name =  $this->input->post('pv_name');
        $this->m_hr_province->pv_name_en = $this->input->post('pv_name_en');
        $this->m_hr_province->pv_update_user = $this->session->userdata('us_id');
        $this->m_hr_province->pv_active =  $this->input->post('pv_active');
        $this->m_hr_province->update();
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
    * province_delete
    * สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ)
    * $input -
    * $output -
    * @Create Date 30/05/2024
    */
    public function province_delete($pv_id)
    {
        $this->load->model($this->model . "m_hr_province");
        $this->m_hr_province->pv_id = $pv_id;
        $this->m_hr_province->pv_active = '2';
        $this->m_hr_province->disabled();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/province';
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
        $this->load->model($this->model . "m_hr_province");
        $formdata = $this->input->post();
        foreach ($formdata as $key => $value) {
            $this->m_hr_province->$key = $value;
        }
        $query = $this->m_hr_province->finding()->result();
        if (count($query) > 0) {
            $data['status_response'] = '1';
        } else {
            $data['status_response'] = '0';
        }
        echo json_encode($data);
    }
}
