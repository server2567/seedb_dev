<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Dashboard_home_patient extends UMS_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ums/M_ums_patient');
        $this->ums = $this->load->database('ums', TRUE);
        $this->hr =$this->load->database('hr', TRUE);
      
        $this->hr_db = 	$this->hr->database;
        $this->ums_db = $this->ums->database;
    }
    
    public function index(){

      //// นัดหมายแพทย์ / จองคิว
      
      $data['base_person_status'] = $this->M_ums_patient->base_person_status()->result_array();
      $data['base_blood'] = $this->M_ums_patient->base_blood()->result_array();
      $data['base_nation'] = $this->M_ums_patient->base_nation()->result_array();
      $data['base_religion'] = $this->M_ums_patient->base_religion()->result_array();
      $data['base_patient_status'] = $this->M_ums_patient->patient_status()->result_array();
      
      if ($this->input->post('pt_id') || $this->session->userdata('pt_id')) {
        $pt_id = $this->input->post('pt_id') ? $this->input->post('pt_id') : $this->session->userdata('pt_id');
        $data['user'] = $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
        $data['user_requests_1'] = $this->M_ums_patient->check_pt_id_requests_1($pt_id)->row();
        // echo $data['user_requests_1']->id;
        $data['user_requests_2'] = $this->M_ums_patient->check_pt_id_requests_2($pt_id)->row();
        // echo $data['user_requests_2']->id;
        $data['user_requests_3'] = $this->M_ums_patient->check_pt_id_requests_3($pt_id)->row();
        // pre($data['user_requests_2']); 
        // die;
        if ($user) {
            /// ตารางแสดงรายการประวัติการนัดหมายแพทย์
            // $status_que = '';
            $data['get_que'] = $this->M_ums_patient->get_que_appointment($user->pt_id)->result_array();
            $data['get_quet'] = $this->M_ums_patient->get_que_appointment_all($user->pt_id)->result_array();

            // $data['get_wts'] = $this->M_ums_patient->get_wts_notification_deparmant($user->pt_id)->result_array();

            /////ผลตรวจจากห้องปฏิบัติการ
            $status_ntr = '4'; // บันทึกผลแจ้งเตือนแล้ว
            $data['get_ntr'] = $this->M_ums_patient->get_notification_results($user->pt_id, $status_ntr)->result_array(); // ผลตรวจจากห้องปฏิบัติการ
            $data['get_ntrt'] = $this->M_ums_patient->get_notification_results_all($user->pt_id, $status_ntr)->result_array(); // ผลตรวจจากห้องปฏิบัติการ
            // ini_set('display_errors', '1');
            // ini_set('display_startup_errors', '1');
            // error_reporting(E_ALL);
            //// การนัดหมายติดตามผลจากแพทย์
            // $status_ap = '2'; // แจ้งเตือนแล้ว
            $data['get_ap'] = $this->M_ums_patient->get_ams_appointment($user->pt_id)->result_array(); //status_ap
            $data['get_apt'] = $this->M_ums_patient->get_ams_appointment_all($user->pt_id)->result_array(); //status_ap
            
            $status_group = '4';
            $status_active = '1';
            $data['get_news'] = $this->M_ums_patient->get_ums_news($status_group, $status_active)->result_array();
    
            $data['get_logs_login'] = $this->M_ums_patient->get_patient_logs_login($user->pt_id)->result_array();
    
            $date = new DateTime($user->ptd_birthdate);
            $data['day'] = $date->format('d');
            $data['month'] = $date->format('m');
            $data['year'] = $date->format('Y');
    
            if ($this->input->post('pt_id')) {
                $ip_address = $this->input->ip_address();
                $location = get_location_from_ip($ip_address);
                $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
                $log_data = array(
                    'pl_pt_id' => $user->pt_id,
                    'pl_date' => date('Y-m-d H:i:s'),
                    'pl_changed' => 'เจ้าหน้าที่ id :' . $this->session->userdata('us_id') . ' ดำเนินการเข้าแก้ไขข้อมูลผู้ป่วย',
                    'pl_ip' => $ip_address . ' ' . $location_str,
                    'pl_agent' => detect_device_type_ip($this->input->user_agent())
                );
                $this->M_ums_patient->log_login($log_data);
            }
            
            $this->output_frontend('ums/frontend/v_dashboard_home_patient', $data);
        } else {
            $this->session->set_flashdata('error', 'ไม่พบข้อมูลผู้ป่วย');
            redirect('gear/frontend_login');
        }
      } else {
          $this->session->set_flashdata('error', 'ท่านจำเป็นต้องเข้าสู่ระบบก่อนที่จะใช้งานระบบ');
          redirect('gear/frontend_login');
      }
    
    }
    
    public function delete_log() {
      $log_id = $this->input->post('log_id');
      $pt_id = $this->input->post('pt_id');
  
      // Update the database to mark the log as inactive
      $this->ums->where('pl_id', $log_id);
      $update = $this->ums->update('ums_patient_logs_login', array('pl_active' => 2));
  
      if ($update) {
          echo json_encode(['status' => 'success']);
      } else {
          echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
      }
  }


    public function get_next_log_item() {
      $pt_id = $this->input->post('pt_id');
      // pre($pt_id);
      if (empty($pt_id)) {
          echo json_encode(['status' => 'error', 'message' => 'Patient ID is required.']);
          return;
      }
  
      try {
          // Fetch the next log item for the given patient ID

          $this->ums->where('pl_active', 1);
          $this->ums->where('pl_pt_id', $pt_id);
          $this->ums->where('pl_changed', 'เข้าสู่ระบบสำเร็จ');
          $this->ums->order_by('pl_id', 'DESC'); // Adjust the ordering as needed
          $this->ums->limit(1);
          $query = $this->ums->get('ums_patient_logs_login');
          // echo $this->ums->last_query();
          if ($query->num_rows() > 0) {
              $data['log'] = $query->row();
              $html = $this->load->view('ums/frontend/v_log_item', $data, true); // Render the next log item as HTML
              echo json_encode(['status' => 'success', 'html' => $html]);
          } else {
              echo json_encode(['status' => 'error', 'message' => 'No more log items to load']);
          }
      } catch (Exception $e) {
          echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
      }
  }
  
    public function menu(){
      $data['menu'] = array();
      $this->output_frontend('ums/frontend/v_dashboard_menu',$data); 
    }

    public function personal_info(){
      $data['personal'] = array();
      $pt_id = $this->input->get('pt_id');
      $data['user'] = $this->M_ums_patient->check_pt_id($pt_id)->row();
      $data['user_requests_1'] = $this->M_ums_patient->check_pt_id_requests_1($pt_id)->row();
      $data['user_requests_2'] = $this->M_ums_patient->check_pt_id_requests_2($pt_id)->row();
      $data['user_requests_3'] = $this->M_ums_patient->check_pt_id_requests_3($pt_id)->row();
      $this->load->view('ums/frontend/v_personal_info', $data);
      // $this->output_frontend('ums/frontend/v_personal_info',$data); 
    }

    public function get_patient_status() {
      $pt_id = $this->input->post('pt_id');
      
      // Load patient status data
      $data['user']= $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
      $data['user_requests_1'] = $this->M_ums_patient->check_pt_id_requests_1($pt_id)->row();
      $data['user_requests_2'] = $this->M_ums_patient->check_pt_id_requests_2($pt_id)->row();
      $data['user_requests_3'] = $this->M_ums_patient->check_pt_id_requests_3($pt_id)->row();
      $data['session_view'] = 'backend';

      $data['base_person_status'] = $this->M_ums_patient->base_person_status()->result_array();
      $data['base_blood'] = $this->M_ums_patient->base_blood()->result_array();
      $data['base_nation'] = $this->M_ums_patient->base_nation()->result_array();
      $data['base_religion'] = $this->M_ums_patient->base_religion()->result_array();
      $data['base_patient_status'] = $this->M_ums_patient->patient_status()->result_array();

      $date = new DateTime($user->ptd_birthdate);
      $data['day'] = $date->format('d');
      $data['month'] = $date->format('m');
      $data['year'] = $date->format('Y');

      // Load the view for the patient status section and return it as a response
      $this->load->view('ums/frontend/v_personal_info', $data);
    }

    public function update_status() {
      $pt_id = $this->input->post('pt_id');
      $pt_sta_id = $this->input->post('pt_sta_id');
      $user_requests_1_id = $this->input->post('user_requests_1_id');
      $user_requests_2_id = $this->input->post('user_requests_2_id');
      $user_requests_3_id = $this->input->post('user_requests_3_id');
      
      $data = array(
        'pt_sta_id' => $pt_sta_id
      );

      // อัปเดตสถานะในตาราง ums_patient
      $this->ums->where('pt_id', $pt_id);
      $update_patient = $this->ums->update('ums_patient', $data);
    
      // อัปเดตสถานะในตาราง ums_patient_requests สำหรับ user_requests_1_id, user_requests_2_id, และ user_requests_3_id
      $this->ums->where_in('id', array($user_requests_1_id, $user_requests_2_id, $user_requests_3_id));
      $update_requests = $this->ums->update('ums_patient_requests', $data);
      // echo $this->ums->last_query(); die;
    
      if ($update_patient || $update_requests) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode(['status' => 'error', 'error' => 'ไม่สามารถเปลี่ยนแปลงสถานะได้']);
      }
    }

    public function personal_info_insert() {
      $pt_id = $this->input->post('pt_id');
      $data_changed = [];
      if($this->config->item('ums_edit_patient') == 1){
        $data_pt = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5',
          'pt_identification' => $this->input->post('pt_identification'),
          'pt_passport' => $this->input->post('pt_passport'),
          'pt_peregrine' => $this->input->post('pt_peregrine'),
          'pt_member' => $this->input->post('pt_member'),
          'pt_prefix' => $this->input->post('pt_prefix'),
          'pt_fname' => $this->input->post('pt_fname'),
          'pt_lname' => $this->input->post('pt_lname'),
          'pt_tel' => $this->input->post('pt_tel'),
          'pt_tel_2' => $this->input->post('pt_tel_2'),
          'pt_email' => $this->input->post('pt_email')
        );

        $data_pt_sta = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5'
        );

        $this->M_ums_patient->update_patient($data_pt_sta, array('pt_id' => $pt_id));
        $this->M_ums_patient->insert_patient_requests($data_pt);
        $last_insert_id = $this->db->insert_id();
        $data_ptd = array(
          'ptd_pt_id' => $pt_id,
          'ptd_req_id' => $last_insert_id,
          'ptd_seq' => '1',
          'ptd_rightname' => $this->input->post('ptd_rightname')
        );

        $this->M_ums_patient->insert_patient_detail_requests($data_ptd);

      } else {
        $data_pt = array(
          'pt_sta_id' => '1',
          'pt_prefix' => $this->input->post('pt_prefix'),
          'pt_fname' => $this->input->post('pt_fname'),
          'pt_lname' => $this->input->post('pt_lname'),
          'pt_tel' => $this->input->post('pt_tel'),
          'pt_tel_2' => $this->input->post('pt_tel_2'),
          'pt_email' => $this->input->post('pt_email')
        );
        $data_ptd = array(
          'ptd_pt_id' => $pt_id,
          'ptd_rightname' => $this->input->post('ptd_rightname')
        );
        $this->M_ums_patient->update_patient($data_pt, array('pt_id' => $pt_id));

        $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
        if($user->ptd_pt_id == $pt_id){
          $this->M_ums_patient->update_patient_detail($data_ptd, array('ptd_pt_id' => $pt_id));
        } else {
          $this->M_ums_patient->insert_patient_detail($data_ptd);
        }
      }
      echo json_encode(array('status' => 'success', 'ข้อมูลส่วนตัวถูกบันทึกเรียบร้อยแล้ว'));
    }
    
    public function get_latest_personal_info() {
      $pt_id = $this->input->post('pt_id');
      $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
      echo json_encode($user);
  }
    public function contact_info_insert() {
      $pt_id = $this->input->post('pt_id');
      $day =  $this->input->post('day');
      $month =  $this->input->post('month');
      $year =  $this->input->post('year');
      $ptd_birthdate = ($year).'-'.$month.'-'.$day;

      if($this->config->item('ums_edit_patient') == 1){

        $data_pt_sta = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5'
        );
        
        $this->M_ums_patient->update_patient($data_pt_sta, array('pt_id' => $pt_id));

        $data_pt = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5',
        );

        $this->M_ums_patient->insert_patient_requests($data_pt);
        $last_insert_id = $this->db->insert_id();
        $data_ptd = array(
          'ptd_pt_id' => $pt_id,
          'ptd_req_id' => $last_insert_id,
          'ptd_seq' => '2',
          'ptd_sex' => $this->input->post('ptd_sex'),
          'ptd_psst_id' => $this->input->post('ptd_psst_id'),
          'ptd_blood_id' => $this->input->post('ptd_blood_id'),
          'ptd_birthdate' => $ptd_birthdate,
          'ptd_nation_id' => $this->input->post('ptd_nation_id'),
          'ptd_reli_id' => $this->input->post('ptd_reli_id'),
          'ptd_occupation' => $this->input->post('ptd_occupation')
        );

        $this->M_ums_patient->insert_patient_detail_requests($data_ptd);


      } else {
        $data_ptd = array(
          'ptd_sex' => $this->input->post('ptd_sex'),
          'ptd_psst_id' => $this->input->post('ptd_psst_id'),
          'ptd_blood_id' => $this->input->post('ptd_blood_id'),
          'ptd_birthdate' => $ptd_birthdate,
          'ptd_nation_id' => $this->input->post('ptd_nation_id'),
          'ptd_reli_id' => $this->input->post('ptd_reli_id'),
          'ptd_occupation' => $this->input->post('ptd_occupation')
      );

      $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
      if($user->ptd_pt_id == $pt_id){
        $this->M_ums_patient->update_patient_detail($data_ptd, array('ptd_pt_id' => $pt_id));
      } else {
        $this->M_ums_patient->insert_patient_detail($data_ptd);
      }
      }


      echo json_encode(array('status' => 'success', 'ข้อมูลเพิ่มเติมถูกบันทึกเรียบร้อยแล้ว'));
    }

    public function address_info_insert() {
      $pt_id = $this->input->post('pt_id');
      if($this->config->item('ums_edit_patient') == 1){


        $data_pt_sta = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5'
        );
        
        $this->M_ums_patient->update_patient($data_pt_sta, array('pt_id' => $pt_id));

        $data_pt = array(
          'pt_id' => $pt_id,
          'pt_sta_id' => '5',
        );

        $this->M_ums_patient->insert_patient_requests($data_pt);
        $last_insert_id = $this->db->insert_id();

        $data_ptd = array(
          'ptd_pt_id' => $pt_id,
          'ptd_req_id' => $last_insert_id,
          'ptd_seq' => '3',
          'ptd_house_number' => $this->input->post('ptd_house_number'),
          'ptd_group' => $this->input->post('ptd_group'),
          'ptd_alley' => $this->input->post('ptd_alley'),
          'ptd_road' => $this->input->post('ptd_road'),
          'ptd_pv_id' => $this->input->post('ptd_pv_id'),
          'ptd_amph_id' => $this->input->post('ptd_amph_id'),
          'ptd_dist_id' => $this->input->post('ptd_dist_id'),
          'ptd_pos_code' => $this->input->post('ptd_pos_code')
        );

        $this->M_ums_patient->insert_patient_detail_requests($data_ptd);

      } else {
        $data_ptd = array(
          'ptd_house_number' => $this->input->post('ptd_house_number'),
          'ptd_group' => $this->input->post('ptd_group'),
          'ptd_alley' => $this->input->post('ptd_alley'),
          'ptd_road' => $this->input->post('ptd_road'),
          'ptd_pv_id' => $this->input->post('ptd_pv_id'),
          'ptd_amph_id' => $this->input->post('ptd_amph_id'),
          'ptd_dist_id' => $this->input->post('ptd_dist_id'),
          'ptd_pos_code' => $this->input->post('ptd_pos_code')
      );
      $user = $this->M_ums_patient->check_pt_id($pt_id)->row();
      if($user->ptd_pt_id == $pt_id){
        $this->M_ums_patient->update_patient_detail($data_ptd, array('ptd_pt_id' => $pt_id));
        
      } else {
        $this->M_ums_patient->insert_patient_detail($data_ptd);
      }
      }


      echo json_encode(array('status' => 'success', 'ข้อมูลเพิ่มเติมถูกบันทึกเรียบร้อยแล้ว'));
    }


    public function appointment_history(){
      $data['appointment'] = array();
      $this->output_frontend('ums/frontend/v_appointment_history',$data); 
    }

    public function lab_results(){
      $data['lab'] = array();
      $this->output_frontend('ums/frontend/v_lab_results',$data); 
    }

    public function get_provinces() {
      $southern_provinces = [
        'กระบี่', 'ชุมพร', 'ตรัง', 'นครศรีธรรมราช', 'นราธิวาส', 
        'ปัตตานี', 'พัทลุง', 'ภูเก็ต', 'ยะลา', 'ระนอง', 
        'สงขลา', 'สตูล', 'สุราษฎร์ธานี'
      ];
    
      $this->hr->select('*');
      $this->hr->from('hr_base_province');
      $this->hr->where('pv_active', 1);
      $this->hr->order_by("
        CASE 
          WHEN pv_name = 'สุราษฎร์ธานี' THEN 0
          WHEN pv_name IN ('" . implode("','", $southern_provinces) . "') THEN 1
          ELSE 2
        END, pv_name ASC"
      );
      $provinces = $this->hr->get()->result();
      echo json_encode($provinces);
    }
  
    public function get_districts() {
      $province_id = $this->input->post('province_id');
      $this->hr->where('amph_pv_id', $province_id);
      $this->hr->where('amph_active', 1);
      $this->hr->order_by('amph_id', 'ASC');
      $districts = $this->hr->get('hr_base_amphur')->result();
      echo json_encode($districts);
    }
  
    public function get_subdistricts() {
      $district_id = $this->input->post('district_id');
      $this->hr->where('dist_amph_id', $district_id);
      $this->hr->where('dist_active', 1);
      $this->hr->group_by('dist_name');
      $this->hr->order_by('dist_id', 'ASC');
      $subdistricts = $this->hr->get('hr_base_district')->result();
      echo json_encode($subdistricts);
    }
  
    public function get_postcodes() {
      $district_id = $this->input->post('district_id');
      $province_id = $this->input->post('province_id');
      $dist_name = $this->input->post('dist_name');
      $this->hr->select('dist_pos_code');  // Ensure to select distinct postcodes
      $this->hr->where('dist_amph_id', $district_id);
      $this->hr->where('dist_pv_id', $province_id);
      $this->hr->where('dist_name', $dist_name);
      $this->hr->where('dist_active', 1);
      $postcodes = $this->hr->get('hr_base_district')->result();
      echo json_encode($postcodes);
    }

    public function search_roads() {
      $term = $this->input->get('term');
    
      // Query to fetch distinct road names matching the search term
      $this->ums->select('DISTINCT(ptd_road)');
      $this->ums->like('ptd_road', $term);
      $query = $this->ums->get('ums_patient_detail');
    
      $results = [];
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          $results[] = $row->ptd_road;
        }
      }
    
      echo json_encode($results); // Return the results as JSON
    }

    public function search_occupation() {
      $term = $this->input->get('term');
    
      // Query to fetch distinct road names matching the search term
      $this->ums->select('DISTINCT(ptd_occupation)');
      $this->ums->like('ptd_occupation', $term);
      $query = $this->ums->get('ums_patient_detail');
    
      $results = [];
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          $results[] = $row->ptd_occupation;
        }
      }
    
      echo json_encode($results); // Return the results as JSON
    }

    public function search_rightname() {
      $term = $this->input->get('term');
    
      // Query to fetch distinct road names matching the search term
      $this->ums->select('DISTINCT(ptd_rightname)');
      $this->ums->like('ptd_rightname', $term);
      $query = $this->ums->get('ums_patient_detail');
    
      $results = [];
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          $results[] = $row->ptd_rightname;
        }
      }
    
      echo json_encode($results); // Return the results as JSON
    }
    public function upload_image() {
      $this->load->library('upload');
      $pt_id = $this->input->post('pt_id');
      $pt_id = complex_base64_decode($pt_id);

      $config['upload_path'] = '/var/www/uploads/ums/Patient/img/';
      $config['allowed_types'] = '*';
      $config['max_size'] = 2048; // 2MB
      $config['file_name'] = $pt_id;

      $existing_file = $config['upload_path'] . $pt_id . '.*';
      array_map('unlink', glob($existing_file)); // Remove existing files with the same name

      $this->upload->initialize($config);

      if ($this->upload->do_upload('image')) {

        $uploadData = $this->upload->data();
        $imageName = $uploadData['file_name'];
        $imageType = $uploadData['file_ext'];
        $imageSize = $uploadData['file_size'];  
        $imageCode = base64_encode(file_get_contents($uploadData['full_path']));
    
        // Update the database
        $data = array(
          'ptd_img' => $imageName,
          'ptd_img_code' => $imageCode,
          'ptd_img_type' => $imageType,
          'ptd_img_size' => $imageSize
        );
        $user = $this->M_ums_patient->check_pt_id($pt_id)->row();

        $data_ptd = array(
          'ptd_pt_id' => $pt_id,
          'ptd_img' => $imageName,
          'ptd_img_code' => $imageCode,
          'ptd_img_type' => $imageType,
          'ptd_img_size' => $imageSize
        );
        
        if($user->ptd_pt_id == $pt_id){
          $this->ums->where('ptd_pt_id', $pt_id);
          $this->ums->update('ums_patient_detail', $data);
        } else {
          $this->M_ums_patient->insert_patient_detail($data_ptd);
        }
        

        echo json_encode([
          'status' => 'success', 
          'image_url' => 'data:image/' . ltrim($imageType, '.') . ';base64,' . $imageCode
        ]);     
      } else {
        $error = $this->upload->display_errors();
        log_message('error', 'Upload error: ' . $error);
        echo json_encode(['status' => 'error', 'error' => $error]);
      }
    }

    public function delete_image() {
      $decodept_id = $this->input->post('pt_id');
      $pt_id = complex_base64_decode($decodept_id);

      // Get the image details from the database
      $this->ums->where('ptd_pt_id', $pt_id);
      $patient = $this->ums->get('ums_patient_detail')->row();
      if ($patient && $patient->ptd_img) {
          $file_path = '/var/www/uploads/ums/Patient/img/' . $patient->ptd_img;
  
          // Delete the file from the server
          if (file_exists($file_path)) {
              unlink($file_path);
          }
  
          // Update the database to remove the image details
          $data = array(
              'ptd_img' => NULL,
              'ptd_img_code' => NULL,
              'ptd_img_type' => NULL,
              'ptd_img_size' => NULL
          );
          $this->ums->where('ptd_pt_id', $pt_id);
          $this->ums->update('ums_patient_detail', $data);
  
          echo json_encode(['status' => 'success']);
      } else {
          echo json_encode(['status' => 'error', 'error' => 'ไม่พบรูปภาพที่ต้องการลบ']);
      }
    }

    public function getfile() {
      // รับพาธไฟล์จากพารามิเตอร์
      $file_path = isset($_GET['path']) ? rawurldecode($_GET['path']) : '';

      // ตรวจสอบว่าพาธไฟล์ถูกต้องและอยู่ในไดเรกทอรีที่กำหนด
      $base_dir = '/var/www/uploads/ams/';
      $full_path = realpath($base_dir . $file_path);

      if ($full_path && strpos($full_path, $base_dir) === 0 && file_exists($full_path)) {
          // โหลด Download Helper
          $this->load->helper('download');

          // ดึงข้อมูลผู้ป่วยจากฐานข้อมูล
          $patient_id = $this->input->get('patient_id');
          $this->load->model('M_ums_patient');
          $patient = $this->M_ums_patient->get_patient($patient_id);

          if ($patient) {
              // ดึงนามสกุลของไฟล์ต้นฉบับ
              $file_info = pathinfo($full_path);
              $extension = isset($file_info['extension']) ? '.' . $file_info['extension'] : '';

              // สร้างชื่อไฟล์ใหม่จากข้อมูลผู้ป่วย
              $file_name = "ผลตรวจจากห้องปฏิบัติการทางการแพทย์ของ " . $patient->pt_prefix . $patient->pt_fname . " " . $patient->pt_lname . $extension;
              $encoded_file_name = mb_convert_encoding($file_name, 'UTF-8', 'auto');

              // ใช้ฟังก์ชัน force_download เพื่อส่งไฟล์ให้ผู้ใช้
              $data = file_get_contents($full_path);
              force_download($encoded_file_name, $data);
          } else {
              show_404();
          }
      } else {
          // ถ้าไฟล์ไม่ถูกต้องหรือไม่พบไฟล์ ให้แสดงข้อผิดพลาด
          show_404();
      }
    }

    public function news_all(){
      $status_group = '4';
      $status_active = '1';
      $data['get_news'] = $this->M_ums_patient->get_ums_news($status_group, $status_active)->result_array();
      $this->output_frontend('ums/frontend/v_news_all', $data);
    }

    public function update_status_requests() {
      $user_id = $this->input->post('user_id');
      $status = $this->input->post('status');
      $reason = $this->input->post('reason');
      $new_value = $this->input->post('new_value');
      $field_name = $this->input->post('field_name');

      $response = [];

      if ($status == '1') {
          // อัปเดตข้อมูลใน ums_patient และ ums_patient_detail
          $update_data = array(
              $field_name => $new_value
          );

          if (in_array($field_name, ['pt_member', 'pt_identification', 'pt_prefix', 'pt_fname', 'pt_lname', 'pt_tel', 'pt_tel_2', 'pt_email'])) {
            $result = $this->M_ums_patient->update_patient_requests($user_id, $update_data);
            $result_detail = true; // ตั้งค่าเริ่มต้นเป็น true เพื่อผ่านการตรวจสอบ
          } else {
            $result = true;
            $result_detail = $this->M_ums_patient->update_patient_detail_requests($user_id, $update_data);
          }

          if ($result && $result_detail) {
            $response['success'] = true;
            $response['new_value'] = $new_value;
          } else {
              $response['success'] = false;
              $response['message'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล: ' . $this->db->last_query();
          }
      } else {
          // อัปเดตสถานะเป็นไม่ยืนยันและบันทึกเหตุผล
          $data = array(
              'pt_sta_id' => $status,
              'pt_comment' => $reason
          );
          $result = $this->M_ums_patient->update_status_requests($user_id, $data);
          if ($result) {
            $response['success'] = true;
            $response['reason'] = $reason;
          } else {
              $response['success'] = false;
              $response['message'] = 'เกิดข้อผิดพลาดในการอัปเดตสถานะ: ' . $this->db->last_query();
          }
      }
      echo json_encode($response);
    }

}
?>