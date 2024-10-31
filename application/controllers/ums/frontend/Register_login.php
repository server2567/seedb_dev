<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Register_login extends UMS_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ums/M_ums_patient');
    }

    public function login() {
      // Get the form data
      $username = trim($this->input->post('Username'));
      $password = trim($this->input->post('Password'));
  
      // Validate the login credentials
      $user = $this->M_ums_patient->validate_login($username, $password);
  
      $ip_address = $this->input->ip_address();
      $location = get_location_from_ip($ip_address);
      $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
  
      if ($user) {
          if ($this->config->item('ums_register') == 1) {
              if ($user->pt_sta_id == 4) {
                  $this->log_login_attempt($user->pt_id, 'รอการอนุมัติการลงทะเบียน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'รอการอนุมัติการลงทะเบียน');
                  $this->session->set_flashdata('message', 'กรุณารอการอนุมัติจากเจ้าหน้าที่โรงพยาบาล');
                  redirect('gear/frontend_login');
              } else if ($user->pt_sta_id == 2) {
                  $this->log_login_attempt($user->pt_id, 'ท่านถูกปิดการใช้งาน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล');
                  $this->session->set_flashdata('message', 'ท่านถูกปิดการใช้งาน');
                  redirect('gear/frontend_login');
              } else if ($user->pt_sta_id == 3) {
                  $this->log_login_attempt($user->pt_id, 'ท่านถูกแบนการใช้งาน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล');
                  $this->session->set_flashdata('message', 'ท่านถูกแบนการใช้งาน');
                  redirect('gear/frontend_login');
              }
          } else {
              // When ums_register is not 1, directly log in the user or handle other status checks
              if ($user->pt_sta_id == 4) {
                  $this->log_login_attempt($user->pt_id, 'รอการอนุมัติการลงทะเบียน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'รอการอนุมัติการลงทะเบียน');
                  $this->session->set_flashdata('message', 'กรุณารอการอนุมัติจากเจ้าหน้าที่โรงพยาบาล');
                  redirect('gear/frontend_login');
              } else if ($user->pt_sta_id == 2) {
                  $this->log_login_attempt($user->pt_id, 'ท่านถูกปิดการใช้งาน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล');
                  $this->session->set_flashdata('message', 'ท่านถูกปิดการใช้งาน');
                  redirect('gear/frontend_login');
              } else if ($user->pt_sta_id == 3) {
                  $this->log_login_attempt($user->pt_id, 'ท่านถูกแบนการใช้งาน', $ip_address, $location_str);
                  $this->session->set_flashdata('error', 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล');
                  $this->session->set_flashdata('message', 'ท่านถูกแบนการใช้งาน');
                  redirect('gear/frontend_login');
              }
          }
  
          // Set user data in session
          $this->session->set_userdata('pt_id', $user->pt_id);
          $this->session->set_userdata('pt_member', $user->pt_member);
          $this->session->set_userdata('pt_identification', $user->pt_identification);
          $this->session->set_userdata('pt_passport', $user->pt_passport);
          $this->session->set_userdata('pt_peregrine', $user->pt_peregrine);
          $this->session->set_userdata('pt_prefix', $user->pt_prefix);
          $this->session->set_userdata('pt_fname', $user->pt_fname);
          $this->session->set_userdata('pt_lname', $user->pt_lname);
  
          // Log successful login
          $this->log_login_attempt($user->pt_id, 'เข้าสู่ระบบสำเร็จ', $ip_address, $location_str);
  
          $this->session->set_flashdata('success');
          redirect('ums/frontend/Dashboard_home_patient');
      } else {
          // Log failed login attempt
          $this->log_login_attempt(null, 'เข้าสู่ระบบไม่สำเร็จ ไอดีหรือรหัสผ่านไม่ถูกต้อง', $ip_address, $location_str);
          $this->session->set_flashdata('error', 'เลขบัตรประจำตัวประชาชน / พาสปอร์ต / เลขบัตรต่างด้าว หรือรหัสผ่านไม่ถูกต้อง');
          redirect('gear/frontend_login');
      }
  }

  private function log_login_attempt($pt_id, $message, $ip_address, $location_str) {
      $log_data = array(
          'pl_pt_id' => $pt_id,
          'pl_date' => date('Y-m-d H:i:s'),
          'pl_changed' => $message,
          'pl_ip' => $ip_address . ' ' . $location_str,
          'pl_agent' => detect_device_type_ip($this->input->user_agent())
      );
      $this->M_ums_patient->log_login($log_data);
  }
  
  

    public function logout() {
        $ip_address = $this->input->ip_address();
        $location = get_location_from_ip($ip_address);
        $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
        $log_data = array(
            'pl_pt_id' => $this->session->userdata('pt_id'),
            'pl_date' => date('Y-m-d H:i:s'),
            'pl_changed' => 'ออกจากระบบสำเร็จ',
            'pl_ip' => $ip_address.' '.$location_str,
            'pl_agent' => detect_device_type_ip($this->input->user_agent())
        );
        $this->M_ums_patient->log_login($log_data);

      // Destroy all sessions
      $this->session->sess_destroy();
      // Redirect to the login page
      redirect('gear/frontend_login');
    }

    public function verify_user() {
      $id_number = $this->input->post('id_number');
      $first_name = $this->input->post('first_name');
      $last_name = $this->input->post('last_name');
      $phone = $this->input->post('phone');
      $birth_date = $this->input->post('birth_date');

      // Check the user in ums_patient and get pt_id
      $pt_id = $this->M_ums_patient->get_user_pt_id($id_number, $first_name, $last_name, $phone);

      if ($pt_id) {
          // Verify the birthdate using pt_id
          $is_birthdate_verified = $this->M_ums_patient->verify_user_birthdate($pt_id, $birth_date);

          if ($is_birthdate_verified) {
            // Store user details in session
            $this->session->set_userdata('verified_user', [
              'pt_id' => $pt_id,
              'id_number' => $id_number,
              'first_name' => $first_name,
              'last_name' => $last_name,
              'phone' => $phone,
              'birth_date' => $birth_date
          ]);

          echo json_encode(['status' => 'success', 'redirect_url' => site_url('gear/frontend_reset_password')]);
          return;

          }
      }

      echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง']);
    }

    public function change_password() {
      $this->ums = $this->load->database('ums', TRUE);
      $this->ums_db = $this->ums->database;

      $new_password = $this->input->post('new_password');
      $confirm_password = $this->input->post('confirm_password');
      $privacy = $this->input->post('privacy');
      $pt_id = $this->session->userdata('verified_user')['pt_id'];
 
      $ip_address = $this->input->ip_address();
      $location = get_location_from_ip($ip_address);
      $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';


      if ($new_password !== $confirm_password || strlen($new_password) < 8) {

        $log_data = array(
          'pl_pt_id' => $pt_id,
          'pl_date' => date('Y-m-d H:i:s'),
          'pl_changed' => 'รหัสผ่านไม่ตรงกันหรือไม่ถูกต้อง',
          'pl_ip' => $ip_address.' '.$location_str,
          'pl_agent' => detect_device_type_ip($this->input->user_agent())
        );
        $this->M_ums_patient->log_login($log_data);

        echo json_encode(['status' => 'error', 'message' => 'รหัสผ่านไม่ตรงกันหรือไม่ถูกต้อง']);
        return;
      }

      
    
      $data = array(
        'pt_password' => password_hash("O]O".$new_password."O[O", PASSWORD_BCRYPT),
        'pt_password_confirm' => password_hash("O]O".$new_password."O[O", PASSWORD_BCRYPT)
      );
    
      $this->ums->where('pt_id', $pt_id);
      $update = $this->ums->update('ums_patient', $data);
    
      if ($update) {
      $log_data = array(
          'pl_pt_id' => $pt_id,
          'pl_date' => date('Y-m-d H:i:s'),
          'pl_changed' => 'เปลี่ยนรหัสผ่านสำเร็จ',
          'pl_ip' => $ip_address.' '.$location_str,
          'pl_agent' => detect_device_type_ip($this->input->user_agent())
      );
      $this->M_ums_patient->log_login($log_data);
      } else {
        $log_data = array(
          'pl_pt_id' => $pt_id,
          'pl_date' => date('Y-m-d H:i:s'),
          'pl_changed' => 'เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน',
          'pl_ip' => $ip_address.' '.$location_str,
          'pl_agent' => detect_device_type_ip($this->input->user_agent())
      );
      $this->M_ums_patient->log_login($log_data);
      }


      if ($update) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน']);
      }
    }
    
    public function log_menu_click() {
      $this->ums = $this->load->database('ums', TRUE);
      $this->ums_db = $this->ums->database;
      $menu_name = $this->input->post('menuName');
      if($this->input->post('pt_id')){
        $user_id = $this->session->userdata('us_id');
        $timestamp = date('Y-m-d H:i:s');
        
        $data = array(
          'user_id' => $user_id,
          'menu_name' => 'เจ้าหน้าที่ '.$menu_name,
          'clicked_at' => $timestamp
        );
      } else {
        $user_id = $this->session->userdata('pt_id');
        $timestamp = date('Y-m-d H:i:s');
        
        $data = array(
          'user_id' => $user_id,
          'menu_name' => $menu_name,
          'clicked_at' => $timestamp
        );
      }

      
      $this->ums->insert('ums_patient_logs_menu', $data);
      echo json_encode(['status' => 'success']);
    }
    
  public function change_password_new() {
    $this->ums = $this->load->database('ums', TRUE);
    $this->ums_db = $this->ums->database;

    $pt_id = $this->input->post('pt_id');
    $old_password = $this->input->post('old_password');
    $new_password = $this->input->post('new_password');

    // Load model และดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $this->load->model('M_ums_patient');
    $user = $this->M_ums_patient->get_patient($pt_id);

    if ($user) {
        // ตรวจสอบรหัสผ่านเดิม
        if (password_verify("O]O".$old_password."O[O", $user->pt_password)) {
            // เปลี่ยนรหัสผ่านใหม่
            $hashed_new_password = password_hash("O]O".$new_password."O[O", PASSWORD_BCRYPT);
            $data = array(
                'pt_password' => $hashed_new_password,
                'pt_password_confirm' => $hashed_new_password
            );
            $this->ums->where('pt_id', $pt_id);
            $this->ums->update('ums_patient', $data);

            $log_data = array(
              'plr_pt_id' => $pt_id,
              'plr_date' => date('Y-m-d H:i:s'),
              'plr_changed' => 'เปลี่ยนรหัสผ่านสำเร็จ',
              'plr_ip' => $this->input->ip_address(),
              'plr_agent' => detect_device_type($this->input->user_agent())
              
            );
            $this->M_ums_patient->log_register($log_data);

            echo json_encode(array('success' => true));
        } else {
            $log_data = array(
              'plr_pt_id' => $pt_id,
              'plr_date' => date('Y-m-d H:i:s'),
              'plr_changed' => 'รหัสผ่านเดิมไม่ถูกต้อง',
              'plr_ip' => $this->input->ip_address(),
              'plr_agent' => detect_device_type($this->input->user_agent())
              
            );
            $this->M_ums_patient->log_register($log_data);

            echo json_encode(array('success' => false, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง'));
        }
    } else {
          $log_data = array(
            'plr_pt_id' => $pt_id,
            'plr_date' => date('Y-m-d H:i:s'),
            'plr_changed' => 'ไม่พบผู้ใช้',
            'plr_ip' => $this->input->ip_address(),
            'plr_agent' => detect_device_type($this->input->user_agent())
            
          );
          $this->M_ums_patient->log_register($log_data);
        echo json_encode(array('success' => false, 'message' => 'ไม่พบผู้ใช้'));
    }
  }
}
?>