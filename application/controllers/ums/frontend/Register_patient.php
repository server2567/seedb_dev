<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Register_patient extends UMS_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ums/M_ums_patient');
    }

    public function check_id() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $type = $data['type'];
        if ($type == 'citizen') {
          $exists = $this->M_ums_patient->check_id_exists($id);
        } else if($type == 'alien') {
          $exists = $this->M_ums_patient->check_alien_id_exists($id);
        } else if($type == 'passport') {
          $exists = $this->M_ums_patient->check_passport_id_exists($id);
        } else {
          $exists = false; // หรือเช็คประเภทอื่น ๆ เช่นพาสปอร์ต
        }
        
        echo json_encode(['exists' => $exists]);
    }

    public function register() {
      $identification = trim($this->input->post('identification'));
      $passport = trim($this->input->post('passport'));
      $alien = trim($this->input->post('alien'));
      $privacy = $this->input->post('privacy') ? trim($this->input->post('privacy')) : 'Y'; // ตั้งค่าเริ่มต้นเป็น 'N' ถ้าไม่ได้ถูกส่งมา
  
      // ตรวจสอบสถานะการบันทึกข้อมูล
      if (!empty($identification)) {
        $check_insert = $this->M_ums_patient->check_insert_identification($identification)->result_array();
      } else if (!empty($passport)) {
        $check_insert = $this->M_ums_patient->check_insert_passport($passport)->result_array();
      } else if (!empty($alien)) {
        $check_insert = $this->M_ums_patient->check_insert_alien($alien)->result_array();
      } else {
        $log_data = array(
          'plr_pt_id' => '',
          'plr_date' => date('Y-m-d H:i:s'),
          'plr_changed' => 'ลงทะเบียนไม่สำเร็จ',
          'plr_ip' => $this->input->ip_address(),
          'plr_agent' => detect_device_type($this->input->user_agent())
        );

        $this->M_ums_patient->log_register($log_data);
          $this->output_frontend('gear/v_gear_frontend_register', ['success' => false, 'error' => 'กรุณากรอกข้อมูลการลงทะเบียน']);
          return;
      }
      if (!empty($check_insert)) {
          if ($check_insert[0]['pt_save'] == 'que' || $check_insert[0]['pt_save'] == 'regis') {
              $data = array(
                  'pt_save' => 'regis',
                  'pt_create_date' => date('Y-m-d H:i:s')
              );
              $this->M_ums_patient->update_patient($data, array('pt_identification' => $identification));

              $log_data = array(
                'plr_pt_id' => $check_insert[0]['pt_id'],
                'plr_date' => date('Y-m-d H:i:s'),
                'plr_changed' => 'เปลี่ยนสถานะเป็น regis สำเร็จ',
                'plr_ip' => $this->input->ip_address(),
                'plr_agent' => detect_device_type($this->input->user_agent())
              );

              $this->M_ums_patient->log_register($log_data);

          }
      } else {
          $query_pt_member = $this->M_ums_patient->check_member()->result_array();
          if($this->config->item('ums_register') == 1){
            $pt_sta_id = 4;
          } else {
            $pt_sta_id = 1;
          }
          
          $data = array(
              'pt_sta_id' => $pt_sta_id,
              'pt_member' => $query_pt_member[0]['max_pt_member'] + 1,
              'pt_save' => 'regis',
              'pt_identification' => $identification,
              'pt_passport' => $passport,
              'pt_peregrine' => $alien,
              'pt_password' => password_hash("O]O".$this->input->post('password')."O[O", PASSWORD_BCRYPT),
              'pt_password_confirm' => password_hash("O]O".$this->input->post('password')."O[O", PASSWORD_BCRYPT),
              'pt_prefix' => $this->input->post('prefix'),
              'pt_fname' => $this->input->post('fname'),
              'pt_lname' => $this->input->post('lname'),
              'pt_tel' => $this->input->post('tel'),
              'pt_tel_2' => $this->input->post('pt_tel_2'),
              'pt_email' => $this->input->post('pt_email'),
              'pt_privacy' => $privacy,
              'pt_create_date' => date('Y-m-d H:i:s'),  // ใช้ date() ในการตั้งค่าวันที่/เวลา
              'pt_create_user' => NULL
          );
          $this->M_ums_patient->insert_patient($data);

          $last_id = $this->db->insert_id();

          $day =  $this->input->post('day');
          $month =  $this->input->post('month');
          $year =  $this->input->post('year');
          $ptd_birthdate = ($year).'-'.$month.'-'.$day;

          $data_ptd = array(
            'ptd_pt_id' => $last_id,
            'ptd_birthdate' => $ptd_birthdate,
            'ptd_create_user' => 0
          );
          
          $this->M_ums_patient->insert_patient_detail($data_ptd);

          if($this->config->item('ums_register') == 1){
          $log_data = array(
            'plr_pt_id' => $last_id,
            'plr_date' => date('Y-m-d H:i:s'),
            'plr_changed' => 'รอการอนุมัติการลงทะเบียน',
            'plr_ip' => $this->input->ip_address(),
            'plr_agent' => detect_device_type($this->input->user_agent())
          );
          $this->M_ums_patient->log_register($log_data);
          } else {
            $log_data = array(
              'plr_pt_id' => $last_id,
              'plr_date' => date('Y-m-d H:i:s'),
              'plr_changed' => 'ลงทะเบียนสำเร็จ',
              'plr_ip' => $this->input->ip_address(),
              'plr_agent' => detect_device_type($this->input->user_agent())
            );
            $this->M_ums_patient->log_register($log_data);
          }
          
      }
      if($this->session->userdata('line_using_menu') == 'register'){
        redirect($this->config->item('line_dir').'Frontend/frontend_login','refresh');
      }
      else{
        $this->output_frontend('gear/v_gear_frontend_register', ['success' => true]);
      }
    }

    public function get_prefix() {
      $this->ums = $this->load->database('ums', TRUE);
      $this->ums_db = $this->ums->database;
      $term = $this->input->get('term'); // ใช้ 'term' ตามที่ jQuery UI autocomplete ส่งมา
      if (strlen($term) >= 1) {
          $query = $this->ums->query("SELECT DISTINCT pt_prefix FROM ".$this->ums_db.".ums_patient WHERE pt_prefix LIKE '%".$this->ums->escape_like_str($term)."%'");
          $result = [];
          foreach ($query->result() as $row) {
              $result[] = $row->pt_prefix;
          }

          echo json_encode($result);
      } else {
          echo json_encode([]);
      }
  }
    
}
