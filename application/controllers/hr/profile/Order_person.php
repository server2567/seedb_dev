<?php
/*
* Profile_user
* Controller หลักของจัดการข้อมูลส่วนตัว
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 16/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Profile_Controller.php');

class Order_person extends Profile_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();
        $this->controller .= "Order_person/";
        $this->load->model($this->model . 'm_hr_order_person_type');
        $this->load->model($this->model . 'm_hr_order_person');
        $this->load->model($this->model . "structure/m_hr_structure");

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/profile/Order_person";
    }
    function formatDateToThaiShort($dateString)
    {
        // กำหนดชื่อย่อเดือนเป็นภาษาไทย
        $thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];

        // แปลงวันที่จากรูปแบบ YYYY-MM-DD เป็น timestamp
        $dateParts = explode("-", $dateString);
        $year = intval($dateParts[0]);
        $month = intval($dateParts[1]);
        $day = intval($dateParts[2]);

        // สร้างออบเจ็กต์ DateTime จากค่าปี เดือน วัน
        $date = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");

        // แปลงวันที่เป็นรูปแบบ วัน เดือนย่อ ปีพ.ศ.
        $thaiYear = $date->format('Y') + 543;
        $thaiMonth = $thaiMonths[$date->format('n') - 1];
        $thaiDay = $date->format('j');
        return  "$thaiDay $thaiMonth $thaiYear";
    }
    /*
	* index
	* index หลักของจัดการข้อมูลส่วนตัว
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
    public function index()
    {
        $data['session_mn_active_url'] = $this->mn_active_url;
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['view_dir'] = $this->view;
        $data['controller_dir'] = $this->controller;
        $data['dp_info'] = $this->m_hr_structure->get_department_active()->result();
        foreach ($data['dp_info'] as $key => $value) {
            $value->dp_id = encrypt_id($value->dp_id);
        }
        $data['order_data_type'] = $this->m_hr_order_person_type->get_order_person_type_active()->result();
        foreach ($data['order_data_type'] as $key => $value) {
            $value->ordt_id = encrypt_id($value->ordt_id);
            $value->ordt_dp_id = encrypt_id($value->ordt_dp_id);
            $value->ordt_update = $this->formatDateToThaiShort($value->ordt_update);
        }
        $hire_is_medical = '';
        $count = count($this->session->userdata('hr_hire_is_medical'));
        if ($count < 3) {
            $hire_is_medical = 'ของ';
            foreach ($this->session->userdata('hr_hire_is_medical') as $key => $value) {
                if ($key == $count - 1 && $count > 1) {
                    $hire_is_medical .= ' และ';
                } else {
                    if ($key != 0) {
                        $hire_is_medical .= ' ';
                    }
                }
                if ($value['type'] == 'M') {
                    $hire_is_medical .= 'แพทย์';
                }
                if ($value['type'] == 'N') {
                    $hire_is_medical .= 'พยาบาล';
                }
                if ($value['type'] == 'S') {
                    $hire_is_medical .= 'เจ้าหน้าที่สนับสนุน';
                }
            }
        }
        $data['hire_is_medical'] = $hire_is_medical;
        $this->output($this->view . 'v_profile_order_person_list', $data);
    }
    // index

    /*
	* profile_user_insert
	* หน้าจอเพิ่มบุคลากร
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
    public function order_person_insert()
    {
        $post_data = $this->input->post();
        $this->m_hr_order_person_type->ordt_name = $post_data['ordt_name'];
        $this->m_hr_order_person_type->ordt_dp_id = $post_data['ordt_dp_id'];
        $this->m_hr_order_person_type->ordt_menu_id = $post_data['ordt_menu_id'];
        $this->m_hr_order_person_type->ordt_type_year = $post_data['ordt_type_year'];
        $this->m_hr_order_person_type->ordt_year = $post_data['ordt_year'];
        $person = $post_data['person'];
        $this->m_hr_order_person_type->ordt_seq = '-';
        $this->m_hr_order_person_type->ordt_active = 1;
        $this->m_hr_order_person_type->ordt_create_user = $this->session->userdata('us_id');
        $this->m_hr_order_person_type->ordt_update_user = $this->session->userdata('us_id');
        $this->m_hr_order_person_type->insert();
        $return_id = $this->m_hr_order_person_type->last_insert_id;
        foreach ($person as $key => $value) {
            $this->m_hr_order_person->ord_ps_id = $value['ps_id'];
            $this->m_hr_order_person->ord_ordt_id = $return_id;
            $this->m_hr_order_person->ord_seq = $value['index'];
            $this->m_hr_order_person->ord_active = $value['checkboxStatus'];
            $this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
            $this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
            $this->m_hr_order_person->insert();
        }
        $this->M_hr_logs->insert_log("เพิ่มข้อมูลประเภทการจัดเรียง " . $this->m_hr_order_person->ordt_name);    //insert hr logs
        $data['controller_dir'] = $this->controller;
        $this->output($this->view . 'v_profile_user_insert_form', $data);
    }
    public function order_person_update()
    {
        $post_data = $this->input->post();
        $this->m_hr_order_person_type->ordt_name = $post_data['ordt_name'];
        $person = $post_data['person'];
        $this->m_hr_order_person_type->ordt_id = decrypt_id($post_data['ordt_id']);
        $this->m_hr_order_person_type->ordt_menu_id = $post_data['ordt_menu_id'];
        $this->m_hr_order_person_type->ordt_type_year = $post_data['ordt_type_year'];
        $this->m_hr_order_person_type->ordt_year = $post_data['ordt_year'];
        $this->m_hr_order_person_type->ordt_seq = '-';
        $this->m_hr_order_person_type->ordt_active = 1;
        $this->m_hr_order_person_type->ordt_update_user = $this->session->userdata('us_id');
        $this->m_hr_order_person_type->update();
        if ($person) {
            $this->m_hr_order_person->ord_ordt_id = decrypt_id($post_data['ordt_id']);
            $this->m_hr_order_person->delete_before_insert();
            foreach ($person as $key => $value) {
                $this->m_hr_order_person->ord_ps_id = $value['ps_id'];
                $this->m_hr_order_person->ord_seq = $value['index'];
                $this->m_hr_order_person->ord_active = $value['checkboxStatus'];
                $this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
                $this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
                $this->m_hr_order_person->insert();
            }
        }
        $this->M_hr_logs->insert_log("แก้ไขข้อมูลประเภทการจัดเรียง " . $this->m_hr_order_person->ordt_name);    //insert hr logs
    }
    // profile_user_insert

    /*
	* get_profile_user_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
    public function get_order_person_type_add($dp_id)
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $dp_id = decrypt_id($dp_id);
        $dp_name = $this->m_hr_structure->get_department_by_id($dp_id)->result();
        foreach ($dp_name as $key => $value) {
            $data['dp_name'] = $value;
        }
        $data['mn_option'] = $this->m_hr_order_person->get_menu_option()->result();
        foreach ($data['mn_option'] as $key => $mn) {
            $mn->mn_name = json_decode($mn->mn_name, true);
        }
        $data['ordt_option'] = $this->m_hr_order_person_type->get_order_person_type_option($dp_id)->result();
        foreach ($data['ordt_option'] as $key => $ordt) {
            $ordt->ordt_id = encrypt_id($ordt->ordt_id);
        }
        $data['ord_info'] = $this->m_hr_order_person_type->get_person_default($dp_id)->result();
        foreach ($data['ord_info']  as $key => $row) {
            $array_admin = array();
            $array_spcl = array();
            $admin_name = json_decode($row->admin_position, true);
            $spcl_name = json_decode($row->spcl_position, true);
            if ($admin_name) {
                foreach ($admin_name as $value3) {
                    if ($value3['admin_name']) {
                        $array_admin[] = $value3['admin_name'];
                    }
                }
                $row->admin_position = $array_admin;
            } else {
                empty($row->admin_position);
            }
            if ($spcl_name) {
                foreach ($spcl_name as $value4) {
                    if ($value4['spcl_name']) {
                        $array_spcl[] = $value4['spcl_name'];
                    }
                }
                $row->spcl_position = $array_spcl;
            } else {
                empty($row->spcl_position);
            }
        }
        $hire_is_medical = '';
        $count = count($this->session->userdata('hr_hire_is_medical'));
        if ($count < 3) {
            $hire_is_medical = 'ของ';
            foreach ($this->session->userdata('hr_hire_is_medical') as $key => $value) {
                if ($key == $count - 1 && $count > 1) {
                    $hire_is_medical .= ' และ';
                } else {
                    if ($key != 0) {
                        $hire_is_medical .= ' ';
                    }
                }
                if ($value['type'] == 'M') {
                    $hire_is_medical .= 'แพทย์';
                }
                if ($value['type'] == 'N') {
                    $hire_is_medical .= 'พยาบาล';
                }
                if ($value['type'] == 'S') {
                    $hire_is_medical .= 'เจ้าหน้าที่สนับสนุน';
                }
            }
        }
        $data['hire_is_medical'] = $hire_is_medical;
        $this->output('hr/profile/v_profile_order_person_form', $data);
    }
    public function get_order_person_type_edit($id)
    {
        $id = decrypt_id($id);
        $dp_id = null;
        $data['controller']  = $this->controller;
        $ordt_info = $this->m_hr_order_person_type->get_order_person_type_by_id($id)->result();
        $data['mn_option'] = $this->m_hr_order_person->get_menu_option()->result();
        foreach ($data['mn_option'] as $key => $mn) {
            $mn->mn_name = json_decode($mn->mn_name, true);
        }
        foreach ($ordt_info as $key => $value) {
            $data['ordt_info'][] = $value;
        }
        foreach ($data['ordt_info'] as $key => $value) {
            $dp_name = $this->m_hr_structure->get_department_by_id($value->ordt_dp_id)->result();
            $dp_id = $value->ordt_dp_id;
            foreach ($dp_name as $key => $value2) {
                $data['dp_name'] = $value2;
            }
            $person = $this->m_hr_order_person->get_order_person_data_by_type($value->ordt_id)->result();
            $index = 0;
            foreach ($person as $key => $item) {
                $ord = $this->m_hr_order_person->get_person_by_id($item->ord_ps_id, $value->ordt_dp_id, $value->ordt_id)->result();
                foreach ($ord as $key => $value2) {
                    $array_admin = array();
                    $array_spcl = array();
                    $admin_name = json_decode($value2->admin_position, true);
                    $spcl_name = json_decode($value2->spcl_position, true);
                    if ($admin_name) {
                        foreach ($admin_name as $value3) {
                            if ($value3['admin_name']) {
                                $array_admin[] = $value3['admin_name'];
                            }
                        }
                        $value2->admin_position = $array_admin;
                    } else {
                        empty($value2->admin_position);
                    }
                    if ($spcl_name) {
                        foreach ($spcl_name as $value4) {
                            if ($value4['spcl_name']) {
                                $array_spcl[] = $value4['spcl_name'];
                            }
                        }
                        $value2->spcl_position = $array_spcl;
                    } else {
                        empty($value2->spcl_position);
                    }
                    $ord_info[$index] = $value2;
                }
                $index++;
            }
            $value->ordt_id = encrypt_id($value->ordt_id);
        }
        if (isset($ord_info)) {
            foreach ($ord_info as $key => $value) {
                $data['ord_info'][] = $value;
            }
        }
        $data['ordt_option'] = $this->m_hr_order_person_type->get_order_person_type_option($dp_id, $id)->result();
        foreach ($data['ordt_option'] as $key => $value) {
            $value->ordt_id = encrypt_id($value->ordt_id);
        }
        $hire_is_medical = '';
        $count = count($this->session->userdata('hr_hire_is_medical'));
        if ($count < 3) {
            $hire_is_medical = 'ของ';
            foreach ($this->session->userdata('hr_hire_is_medical') as $key => $value) {
                if ($key == $count - 1 && $count > 1) {
                    $hire_is_medical .= ' และ';
                } else {
                    if ($key != 0) {
                        $hire_is_medical .= ' ';
                    }
                }
                if ($value['type'] == 'M') {
                    $hire_is_medical .= 'แพทย์';
                }
                if ($value['type'] == 'N') {
                    $hire_is_medical .= 'พยาบาล';
                }
                if ($value['type'] == 'S') {
                    $hire_is_medical .= 'เจ้าหน้าที่สนับสนุน';
                }
            }
        }
        $data['hire_is_medical'] = $hire_is_medical;
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $this->output('hr/profile/v_profile_order_person_form', $data);
    }
    function get_order_person_data()
    {
        if ($this->input->post('id') == '-1') {
            $dp_id = $this->input->post('dp_id');
            $data['order_person'] = $this->m_hr_order_person_type->get_person_default($dp_id)->result();
        } else {
            $ordt_id = decrypt_id($this->input->post('id'));
            $dp_id = $this->input->post('dp_id');
            $data['order_person'] = $this->m_hr_order_person->get_order_person_data_by_option($ordt_id, $dp_id)->result();
        }
        foreach ($data['order_person'] as $key => $row) {
            if (!isset($row->ord_active)) {
                $row->ord_active = 1;
            }
            $array_admin = array();
            $array_spcl = array();
            $admin_name = json_decode($row->admin_position, true);
            $spcl_name = json_decode($row->spcl_position, true);
            if ($admin_name) {
                foreach ($admin_name as $value3) {
                    if ($value3['admin_name']) {
                        $array_admin[] = $value3['admin_name'];
                    }
                }
                $row->admin_position = $array_admin;
            }
            if ($spcl_name) {
                foreach ($spcl_name as $value4) {
                    if ($value4['spcl_name']) {
                        $array_spcl[] = $value4['spcl_name'];
                    }
                }
                $row->spcl_position = $array_spcl;
            }
        }
        echo json_encode($data);
    }
    function delete_oreder_perton_type($id)
    {
        $this->m_hr_order_person_type->ordt_id = decrypt_id($id);
        $this->m_hr_order_person_type->ordt_active = '2';
        $this->m_hr_order_person_type->disabled();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/amphur';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
}
