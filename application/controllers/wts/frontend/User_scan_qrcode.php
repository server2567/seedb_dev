<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");

class User_scan_qrcode extends UMS_Controller {

public function __construct() {
    parent::__construct();
    $this->load->model('ums/m_ums_patient');
    // $this->load->model('ums/m_ums_patient_logs_login');
    $this->load->model('wts/m_wts_base_disease');
}

public function index(){
  $data['disease'] = $this->m_wts_base_disease->get_all()->result_array();
    $this->output_frontend('wts/frontend/v_user_scan_qrcode',$data); 
}

// public function check_pt_id($pt_id) {
//     $data['pl'] = $this->m_ums_patient->get_patient_logs_login($pt_id)->rusult();
//     // if($ == 'เข้าสู่ระบบสำเร็จ') {

//     // }
// }
}
?>