<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/ums/UMS_Controller.php"); //Include file มาเพื่อ extend
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class Api_services extends UMS_Controller
{


  public $que;
  public $que_db;

  public $hr;
  public $hr_db;

  public $ums;
  public $ums_db;

  public $wts;
  public $wts_db;

  public $eqs;
  public $eqs_db;

  public $ams;
  public $ams_db;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('encryption');
    $this->que = $this->load->database('que', true);
    $this->hr = $this->load->database('hr', TRUE);
    $this->ums = $this->load->database('ums', TRUE);
    $this->wts = $this->load->database('wts', TRUE);
    $this->ams = $this->load->database('ams', TRUE);

    $this->que_db = $this->que->database;
    $this->hr_db =   $this->hr->database;
    $this->ums_db = $this->ums->database;
    $this->wts_db = $this->wts->database;
    $this->ams_db = $this->ams->database;
  }

  public function insert_appointment()
  {

    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {

      // ตรวจสอบว่า pt_member มีอยู่ใน ums_patient หรือไม่
      $this->ums->where('pt_member', $data['pt_hn']);
      $query = $this->ums->get('ums_patient');

      // ค้นหา ptd_psst_id โดยใช้ psst_name

      $this->hr->select('psst_id');
      $this->hr->like('psst_name', $data['ptd_psst_id'], 'both');
      $psst_query = $this->hr->get('hr_base_person_status');


      if ($psst_query->num_rows() > 0) {
        $psst_result = $psst_query->row();
        $ptd_psst_id = $psst_result->psst_id;
      } else {
        // ถ้าไม่พบชื่อที่ตรงกัน
        // $
        // $this->hr->insert('hr_base_person_status',$insert);
        $psst_insert_data = array(
          'psst_name' => $data['ptd_psst_id'],
          'psst_name_en' => '',
          'psst_active' => '1',
          'psst_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );

        $this->hr->insert('hr_base_person_status', $psst_insert_data);

        // ดึง last_insert_id ของ blood_id
        $ptd_psst_id = $this->hr->insert_id();
        if (!$ptd_psst_id) {
          $response = array('status' => 'error', 'message' => 'Person status not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return; // หยุดการทำงานและส่งผลลัพธ์กลับ
        }
      }

      // ค้นหา ptd_blood_id โดยใช้ blood_name
      $this->hr->select('blood_id');
      $this->hr->like('blood_name', $data['ptd_blood_id'], 'both');
      $blood_query = $this->hr->get('hr_base_blood');

      if ($blood_query->num_rows() > 0) {
        $blood_result = $blood_query->row();
        $ptd_blood_id = $blood_result->blood_id;
      } else {
        // ถ้าไม่พบข้อมูลให้แทรกข้อมูลใหม่ลงในตาราง hr_base_blood
        $blood_insert_data = array(
          'blood_name' => $data['ptd_blood_id'],
          'blood_name_en' => '',
          'blood_active' => '1',
          'blood_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );

        $this->hr->insert('hr_base_blood', $blood_insert_data);

        // ดึง last_insert_id ของ blood_id
        $ptd_blood_id = $this->hr->insert_id();
        if (!$ptd_blood_id) {
          $response = array('status' => 'error', 'message' => 'Blood type not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return; // หยุดการทำงานและส่งผลลัพธ์กลับ
        }
      }

      // ค้นหา ptd_nation_id โดยใช้ nation_name
      $this->hr->select('nation_id');
      $this->hr->like('nation_name', $data['ptd_nation_id'], 'both');
      $nation_query = $this->hr->get('hr_base_nation');
      if ($nation_query->num_rows() > 0) {
        $nation_result = $nation_query->row();
        $ptd_nation_id = $nation_result->nation_id;
      } else {
        $nation_insert_data = array(
          'nation_name' => $data['ptd_nation_id'],
          'nation_name_en' => '',
          'nation_active' => '1',
          'nation_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );
        $this->hr->insert('hr_base_nation', $nation_insert_data);
        // ดึง last_insert_id ของ blood_id
        $ptd_nation_id = $this->hr->insert_id();
        if (!$ptd_nation_id) {
          $response = array('status' => 'error', 'message' => 'Nation not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return;
        }
      }

      // ค้นหา ptd_reli_id โดยใช้ reli_name
      $this->hr->select('reli_id');
      $this->hr->where('reli_name', $data['ptd_reli_id']);
      $religion_query = $this->hr->get('hr_base_religion');

      if ($religion_query->num_rows() > 0) {
        $religion_result = $religion_query->row();
        $ptd_reli_id = $religion_result->reli_id;
      } else {
        $reli_insert_data = array(
          'reli_name' => $data['ptd_reli_id'],
          'reli_name_en' => '',
          'reli_active' => '1',
          'reli_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );
        $this->hr->insert('hr_base_religion', $reli_insert_data);

        if (!$reli_insert_data) {
          $response = array('status' => 'error', 'message' => 'Religion not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return;
        }
      }

      // ค้นหา ptd_pv_id โดยใช้ pv_name
      $ptd_pv_id_trimmed = trim($data['ptd_pv_id']);
      $this->hr->select('pv_id');
      $this->hr->like('pv_name', $ptd_pv_id_trimmed);
      $province_query = $this->hr->get('hr_base_province');

      if ($province_query->num_rows() > 0) {
        $province_result = $province_query->row();
        $ptd_pv_id = $province_result->pv_id;
      } else {

        $province_insert_data = array(
          'pv_name' => $ptd_pv_id_trimmed,
          'pv_name_en' => '',
          'pv_active' => '1',
          'pv_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );
        $this->hr->insert('hr_base_province', $province_insert_data);

        if (!$province_insert_data) {
          $response = array('status' => 'error', 'message' => 'Province not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return;
        }
      }

      // ตัดเว้นวรรคหน้าและหลัง $data['ptd_amph_id']
      $ptd_amph_id_trimmed = trim($data['ptd_amph_id']);
      // ค้นหา ptd_amph_id โดยใช้ amph_name และ pv_id
      $this->hr->select('amph_id');
      $this->hr->like('amph_name', $ptd_amph_id_trimmed);
      $this->hr->where('amph_pv_id', $ptd_pv_id);
      $amphur_query = $this->hr->get('hr_base_amphur');

      if ($amphur_query->num_rows() > 0) {
        $amphur_result = $amphur_query->row();
        $ptd_amph_id = $amphur_result->amph_id;
      } else {

        $amph_insert_data = array(
          'amph_name' => $ptd_amph_id_trimmed,
          'amph_name_en' => '',
          'amph_pv_id' => $ptd_pv_id,
          'amph_active' => '1',
          'amph_create_date' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );
        $this->hr->insert('hr_base_amphur', $amph_insert_data);

        if (!$amph_insert_data) {
          $response = array('status' => 'error', 'message' => 'Amphur not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return;
        }
      }
      // ตัดเว้นวรรคหน้าและหลัง $data['ptd_dist_id']
      $ptd_dist_id_trimmed = trim($data['ptd_dist_id']);

      // ค้นหา ptd_dist_id โดยใช้ dist_name, amph_id และ dist_pv_id
      $this->hr->select('dist_id');
      $this->hr->like('dist_name', $ptd_dist_id_trimmed);
      $this->hr->where('dist_amph_id', $ptd_amph_id);
      $this->hr->where('dist_pv_id', $ptd_pv_id);
      $district_query = $this->hr->get('hr_base_district');
      if ($district_query->num_rows() > 0) {
        $district_result = $district_query->row();
        $ptd_dist_id = $district_result->dist_id;
      } else {

        $district_insert_data = array(
          'dist_name' => $ptd_dist_id_trimmed,
          'dist_name_en' => '',
          'dist_amph_id' => $ptd_amph_id,
          'dist_pv_id' => $ptd_pv_id,
          'dist_pos_code' => '',
          'dist_active' => '1',
          'dist_create_user' => date('Y-m-d H:i:s') // วันที่เวลาปัจจุบัน
        );
        $this->hr->insert('hr_base_district', $district_insert_data);

        if (!$district_insert_data) {
          $response = array('status' => 'error', 'message' => 'District not found.');
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
          return;
        }
      }
      if ($query->num_rows() == 0) {
        $patient_data = array(
          'pt_sta_id' => '1',
          'pt_member' => isset($data['pt_hn']) && $data['pt_hn'] !== NULL ? $data['pt_hn'] : NULL,
          'pt_save' => 'que',
          'pt_identification' => isset($data['pt_identification']) && $data['pt_identification'] !== NULL ? $data['pt_identification'] : NULL,
          'pt_passport' => isset($data['pt_passport']) && $data['pt_passport'] !== NULL ? $data['pt_passport'] : NULL,
          'pt_peregrine' => isset($data['pt_peregrine']) && $data['pt_peregrine'] !== NULL ? $data['pt_peregrine'] : NULL,
          'pt_password' => password_hash("O]O" . $data['pt_tel'] . "O[O", PASSWORD_BCRYPT),
          'pt_password_confirm' => password_hash("O]O" . $data['pt_tel'] . "O[O", PASSWORD_BCRYPT),
          'pt_prefix' => isset($data['pt_prefix']) && $data['pt_prefix'] !== NULL ? $data['pt_prefix'] : NULL,
          'pt_fname' => isset($data['pt_fname']) && $data['pt_fname'] !== NULL ? $data['pt_fname'] : NULL,
          'pt_lname' => isset($data['pt_lname']) && $data['pt_lname'] !== NULL ? $data['pt_lname'] : NULL,
          'pt_tel' => isset($data['pt_tel']) && $data['pt_tel'] !== NULL ? $data['pt_tel'] : NULL,
          'pt_tel_2' => isset($data['pt_tel_2']) && $data['pt_tel_2'] !== NULL ? $data['pt_tel_2'] : NULL,
          'pt_email' => isset($data['pt_email']) && $data['pt_email'] !== NULL ? $data['pt_email'] : NULL,
          'pt_privacy' => 'Y',
          'pt_create_date' => date('Y-m-d H:i:s'), // วันที่เวลาปัจจุบัน
        );

        // บันทึกข้อมูลลงใน ums_patient
        $this->ums->insert('ums_patient', $patient_data);
        $patiet = $this->ums->insert_id();
        $patient_inserted = true;

        // Insert Patient Detail
        $patient_data_detail = array(
          'ptd_pt_id' => $patiet,
          'ptd_sex' => $data['ptd_sex'],
          'ptd_psst_id' => $ptd_psst_id,
          'ptd_blood_id' => $ptd_blood_id,
          'ptd_img' => $data['ptd_img'],
          'ptd_birthdate' => $data['ptd_birthdate'],
          'ptd_nation_id' => $ptd_nation_id,
          'ptd_reli_id' => $ptd_reli_id,
          'ptd_occupation' => $data['ptd_occupation'],
          'ptd_rightname' => $data['ptd_rightname'],
          'ptd_house_number' => $data['ptd_house_number'],
          'ptd_group' => $data['ptd_group'],
          'ptd_alley' => $data['ptd_alley'],
          'ptd_road' => $data['ptd_road'],
          'ptd_dist_id' => $ptd_dist_id,
          'ptd_amph_id' => $ptd_amph_id,
          'ptd_pv_id' => $ptd_pv_id,
          'ptd_pos_code' => $data['ptd_pos_code'],
          'ptd_create_user' => 0,
          'ptd_create_date' => date('Y-m-d H:i:s')
        );
        $this->ums->insert('ums_patient_detail', $patient_data_detail);
        $apm_patient_type = 'new';  // ถ้ายังไม่มีข้อมูล
      } else {
        $patiet = $query->row()->pt_id;

        $this->ums->where('pt_id', $patiet);
        $this->ums->where('DATE(pt_create_date)', date('Y-m-d')); // เช็คว่า pt_create_date ตรงกับวันที่ปัจจุบัน
        $query = $this->ums->get('ums_patient');
        // echo $this->ums->last_query(); die;
        if ($query->num_rows() > 0) {
          $apm_patient_type = 'new';  // ถ้าเป็นข้อมูลที่ถูกสร้างในวันนี้
        } else {
          $apm_patient_type = 'old';  // ถ้าไม่ใช่ข้อมูลที่ถูกสร้างในวันนี้
        }

        // เตรียมข้อมูลสำหรับการอัปเดตเหมือนการ insert
        $update_patient_data = array(
          'pt_identification' => isset($data['pt_identification']) ? $data['pt_identification'] : NULL,
          'pt_passport' => isset($data['pt_passport']) ? $data['pt_passport'] : NULL,
          'pt_peregrine' => isset($data['pt_peregrine']) ? $data['pt_peregrine'] : NULL,
          'pt_prefix' => isset($data['pt_prefix']) ? $data['pt_prefix'] : NULL,
          'pt_fname' => isset($data['pt_fname']) ? $data['pt_fname'] : NULL,
          'pt_lname' => isset($data['pt_lname']) ? $data['pt_lname'] : NULL,
          'pt_tel' => isset($data['pt_tel']) ? $data['pt_tel'] : NULL,
          'pt_tel_2' => isset($data['pt_tel_2']) ? $data['pt_tel_2'] : NULL,
          'pt_email' => isset($data['pt_email']) ? $data['pt_email'] : NULL,
          'pt_update_date' => date('Y-m-d H:i:s')  // อัปเดตวันที่ปัจจุบัน
        );

        // อัปเดตข้อมูลใน ums_patient โดยใช้ pt_id
        $this->ums->where('pt_id', $patiet);
        $this->ums->update('ums_patient', $update_patient_data);

        // อัปเดตข้อมูลใน ums_patient_detail ถ้ามีข้อมูลที่เกี่ยวข้อง
        $update_patient_detail_data = array(
          'ptd_sex' => isset($data['ptd_sex']) ? $data['ptd_sex'] : NULL,
          'ptd_psst_id' => $ptd_psst_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_blood_id' => $ptd_blood_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_img' => isset($data['ptd_img']) ? $data['ptd_img'] : NULL,
          'ptd_birthdate' => isset($data['ptd_birthdate']) ? $data['ptd_birthdate'] : NULL,
          'ptd_nation_id' => $ptd_nation_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_reli_id' => $ptd_reli_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_occupation' => isset($data['ptd_occupation']) ? $data['ptd_occupation'] : NULL,
          'ptd_rightname' => isset($data['ptd_rightname']) ? $data['ptd_rightname'] : NULL,
          'ptd_house_number' => isset($data['ptd_house_number']) ? $data['ptd_house_number'] : NULL,
          'ptd_group' => isset($data['ptd_group']) ? $data['ptd_group'] : NULL,
          'ptd_alley' => isset($data['ptd_alley']) ? $data['ptd_alley'] : NULL,
          'ptd_road' => isset($data['ptd_road']) ? $data['ptd_road'] : NULL,
          'ptd_dist_id' => $ptd_dist_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_amph_id' => $ptd_amph_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_pv_id' => $ptd_pv_id,  // ค่าที่คำนวณไว้ก่อนหน้า
          'ptd_pos_code' => isset($data['ptd_pos_code']) ? $data['ptd_pos_code'] : NULL,
          'ptd_update_user' => 0,
          'ptd_update_date' => date('Y-m-d H:i:s')  // อัปเดตวันที่ปัจจุบัน
        );

        // อัปเดตข้อมูลใน ums_patient_detail
        $this->ums->where('ptd_pt_id', $patiet);
        $this->ums->update('ums_patient_detail', $update_patient_detail_data);
      }

      // Handling multiple departments
      // pre($data['departments']);
      $departments = $data['departments'];

      // ถ้า $departments ไม่ใช่ array ให้แปลงเป็น array
      if (!is_array($departments)) {
        $departments = [$departments];
      }
      // pre($departments); die();
      foreach ($departments as $department) {
        $apm_visit = $data['apm_visit'];
        $apm_date = $data['apm_date'];
        $apm_time = date('H:i');
        $apm_ntf_id = '1';
        $apm_sta_id = '1';
        $apm_app_walk = $data['apm_app_walk'];
        $ds_stde_id = $this->get_stde_id($department['ds_stde_name']);
        $apm_ql_code = $data['apm_ql_code'];
        // $apm_pri_id = $data['apm_pri_id'];

        if ($data['apm_pri_id'] == 'ปกติ') {
          $apm_pri_id = '5';
          // $apm_app_walk = 'W';
        } else if ($data['apm_pri_id'] == 'ฉุกเฉิน') {
          $apm_pri_id = '1';
          // $apm_app_walk = 'W';
        } else if ($data['apm_pri_id'] == 'เฝ้าระวัง') {
          $apm_pri_id = '2';
          // $apm_app_walk = 'W';
        } else if ($data['apm_pri_id'] == 'บุคคลสำคัญ (Vip)') {
          $apm_pri_id = '3';
          // $apm_app_walk = 'W';
        } else if ($data['apm_pri_id'] == 'นัดหมายแพทย์') {
          $apm_pri_id = '4';
          // $apm_app_walk = 'A';
        } else {
          $apm_pri_id = '5';
          // $apm_app_walk = 'W';
        }
        $apm_dp_id = $data['apm_dp_id'] ?: '1';
        $ps_fname = $department['ps_fname'] ?: null;
        $ps_lname = $department['ps_lname'] ?: null;
        if ($ps_fname) {
          $ps_fname = explode('.', $ps_fname);
          $ps_fname_ex = trim(end($ps_fname)); // ใช้ส่วนหลังสุดของชื่อหลังจากตัดจุดออก และตัดช่องว่างข้างหน้าและข้างหลังออก
        } else {
          $ps_fname_ex = null;
        }
        $person_query = null;
        if ($ps_fname_ex && $ps_lname) {
          $person_query = $this->hr->query("SELECT * FROM hr_person WHERE ps_fname LIKE ? AND ps_lname LIKE ?", array('%' . $ps_fname_ex . '%', '%' . $ps_lname . '%'))->row();
        }

        $apm_ps_id = $person_query ? $person_query->ps_id : null; // ถ้าไม่พบหรือเป็น null ให้เป็น null

        // echo $this->hr->last_query();
        // ค้นหาการนัดหมายใน que_appointment โดยใช้ apm_visit และแผนก
        $this->que->where('apm_pt_id', $patiet);
        $this->que->group_start();
        $this->que->where('apm_visit IS NULL');
        $this->que->or_where('apm_visit', $data['apm_visit']);
        $this->que->group_end();
        $this->que->where('apm_date', $data['apm_date']);
        $this->que->where('apm_stde_id', $ds_stde_id);
        $this->que->where('apm_sta_id != 9');
        // $this->que->order_by('apm_id');
        $appointment_query = $this->que->get('que_appointment');
        // echo $this->que->last_query();
        if ($appointment_query->num_rows() > 0) {
          $apm_id = $appointment_query->row()->apm_id;

          // อัปเดตการนัดหมายที่มีอยู่แล้ว
          $update_data = array(
            'apm_ntf_id' => $apm_ntf_id,
            'apm_sta_id' => $apm_sta_id,
            'apm_visit' => $apm_visit,
            'apm_time' => $apm_time,
            'apm_patient_type' => $apm_patient_type,
            'apm_app_walk' => $apm_app_walk,
            'apm_date' => $apm_date,
            'apm_stde_id' => $ds_stde_id,
            'apm_ql_code' => $apm_ql_code,
            'apm_pri_id' => $apm_pri_id,
            'apm_dp_id' => $apm_dp_id,
            'apm_ps_id' => $apm_ps_id, // ใช้ค่า apm_ps_id ที่ได้จากการค้นหา หรือเป็น null ถ้าไม่พบ
            'apm_update_date' => date('Y-m-d H:i:s')
          );
          $this->que->where('apm_id', $apm_id);
          $this->que->update('que_appointment', $update_data);
          // echo $this->que->last_query();
          $last_appointment_id = $apm_id;
        } else {
          // สร้างการนัดหมายใหม่
          $last_appointment_id = $this->M_que_appointment->insert_appointment_api($patiet, $apm_visit, $apm_app_walk, $apm_ntf_id, $apm_date, $apm_sta_id, $apm_patient_type, $ds_stde_id, $apm_ql_code, $apm_pri_id, $apm_dp_id, $apm_ps_id, $apm_time);
          // echo $this->que->last_query();
        }

        // คิวรีหาเวลา loc_time จาก wts_location
        $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "1"');
        $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        // แปลงเวลาจาก apm_date และ ntdp_time_start
        $start_datetime = new DateTime($data['apm_date'] . ' ' . $data['ntdp_time_start']);
        // เพิ่มเวลาจาก loc_time
        $start_datetime->modify('+' . $loc_time . ' minutes');

        // คำนวณค่า ntdp_time_end และ ntdp_date_end
        $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
        $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

        if ($data['ntdp_in_out'] == 1) {
          $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
          $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        } else {
          $ntdp_loc_Id = $data['ntdp_loc_Id'];
        }

        // บันทึกข้อมูลใน wts_notifications_department
        $wts_data = array(
          'ntdp_apm_id' => $last_appointment_id,
          'ntdp_seq' => '1',
          'ntdp_date_start' => $data['apm_date'],
          'ntdp_time_start' => $data['ntdp_time_start'],
          'ntdp_date_end' => $ntdp_date_end,
          'ntdp_time_end' => $ntdp_time_end,
          'ntdp_sta_id' => $apm_sta_id,
          'ntdp_in_out' => $data['ntdp_in_out'],
          'ntdp_loc_cf_Id' => $data['ntdp_loc_cf_Id'],
          'ntdp_loc_Id' => $data['ntdp_loc_Id'],
          'ntdp_loc_ft_Id' => $data['ntdp_loc_ft_Id'],
          'ntdp_function' => 'insert_appointment'
        );
        // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
        if ($data['ntdp_in_out'] == 1) {
          $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
          $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
          $this->que->where('apm_id', $last_appointment_id);
          $this->que->update('que_appointment', array('apm_sta_id' => 15));
        }
        $this->wts->insert('wts_notifications_department', $wts_data);
        $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
                                          LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
                                          WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
        // ถ้าพบ room ข้อมูล
        if ($room_query->num_rows() > 0) {
          // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
          $this->que->where('apm_visit', $data['apm_visit']);
          $this->que->update('que_appointment', array('apm_sta_id' => 4));

          // Insert ข้อมูลใหม่สำหรับ seq 2
          $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "' . $last_appointment_id . '" ORDER BY ntdp_id DESC LIMIT 1');
          $ntdp_desc = $ntdp->row()->ntdp_apm_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
          $ntdp_desc_id = $ntdp->row()->ntdp_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
          $ntdp_desc_seq = $ntdp->row()->ntdp_seq; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที

          // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
          $ntdp_apm_id_1 = $last_appointment_id;  // ใช้ apm_id ที่ค้นพบได้
          $ntdp_seq_1 = $ntdp_desc_seq;
          $ntdp_date_end_1 = $data['ntdp_date_start'];
          $ntdp_time_end_1 = $data['ntdp_time_start'];
          $ntdp_sta_id_1 = '2';

          $wts_update_data = array(
            'ntdp_date_finish' => $ntdp_date_end_1,
            'ntdp_time_finish' => $ntdp_time_end_1,
            'ntdp_sta_id' => $ntdp_sta_id_1
          );

          // Update ข้อมูลในตาราง wts_notifications_department ที่มี seq = 1 และ apm_id ที่ตรงกัน
          $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
          $this->wts->where('ntdp_seq', $ntdp_seq_1);
          $this->wts->update('wts_notifications_department', $wts_update_data);


          $ntdp_apm_id = $ntdp_desc;  // ใช้ apm_id ที่ค้นพบได้
          $ntdp_seq = '6';
          $ntdp_date_start = $data['ntdp_date_start'];
          $ntdp_time_start = $data['ntdp_time_start'];
          $ntdp_sta_id = '2';
          $ntdp_in_out = $data['ntdp_in_out'];
          $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
          $ntdp_loc_Id = $data['ntdp_loc_Id'];
          $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

          $wts_data = array(
            'ntdp_apm_id' => $ntdp_apm_id,
            'ntdp_seq' => $ntdp_seq,
            'ntdp_date_start' => $ntdp_date_start,
            'ntdp_time_start' => $ntdp_time_start,
            'ntdp_date_end' => $ntdp_date_end,
            'ntdp_time_end' => $ntdp_time_end,
            'ntdp_sta_id' => $ntdp_sta_id,
            'ntdp_in_out' => $ntdp_in_out,
            'ntdp_loc_cf_Id' => $ntdp_loc_cf_Id,
            'ntdp_loc_Id' => $ntdp_loc_Id,
            'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
            'ntdp_function' => 'insert_appointment_room'
          );
          // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
          if ($data['ntdp_in_out'] == 1) {
            $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
            $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
            $this->que->where('apm_id', $ntdp_apm_id);
            $this->que->update('que_appointment', array('apm_sta_id' => 15));
          }
          // Insert ข้อมูลลงในตาราง wts_notifications_department
          $this->wts->insert('wts_notifications_department', $wts_data);


          if (!empty($data['apm_ps_id'])) {
            // 1 get qus_psrm_id
            $this->load->model('hr/m_hr_person_room');
            $params = ['date' => $data['apm_date'], 'ps_id' => $data['apm_ps_id'],];
            $psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();

            // 2 insert m_wts_queue_seq
            if (!empty($psrm)) {
              $this->load->model('wts/m_wts_queue_seq');
              $this->m_wts_queue_seq->qus_psrm_id = $psrm[0]['psrm_id'];
              $this->m_wts_queue_seq->qus_apm_id = $data['apm_id'];
              $this->m_wts_queue_seq->qus_app_walk = $data['apm_app_walk'];
              $this->m_wts_queue_seq->insert_seq_by_max_psrm_id();
            }
          }
        }
      }

      $ntdp_loc_Id = $data['ntdp_loc_Id'];
      $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

      // ส่งไลน์
      $line_data = array(
        "msst_id" => $this->config->item('message_que_line_id'),
        "pt_id" => $patiet,
        "apm_id" => $last_appointment_id,
        "ntdp_loc_Id" => $ntdp_loc_Id,
        "ntdp_loc_ft_Id" => $ntdp_loc_ft_Id
      );

      // echo '<pre>'; print_r($line_data); echo '</pre>';
      // die();

      $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_que_to_patient";
      get_url_line_service($url_service_line, $line_data); // Line helper

      //ส่งอีเมล
      $command = "php " . escapeshellarg(FCPATH . "index.php") . " ams/Urgent_notify send_email_update_status {$patiet} {$last_appointment_id} {$ntdp_loc_Id} {$ntdp_loc_ft_Id} > /dev/null 2>&1 &";
      exec($command, $output, $return_var);
      if ($return_var !== 0) {
        echo "Error occurred: \n";
        print_r($output);
      } else {
        echo "Command executed successfully.\n";
        print_r($output);
      }

      $response = array('status' => 'success', 'message' => 'Appointments processed successfully.');
    } else {
      $response = array('status' => 'error', 'message' => 'Invalid input data.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  public function location_step2()
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      if (isset($data['apm_visit'])) {
        // ค้นหาแถวที่มี `apm_visit` ตรงกัน
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ?", array($data['apm_visit']));

        if ($check_visit->num_rows() > 0) {
          $appointment = $check_visit->row();

          // อัปเดตข้อมูลแถวแรก
          $apm_data = array(
            'apm_ds_id' => isset($data['ds_id']) && !empty($data['ds_id']) ? $data['ds_id'] : NULL,
            'apm_sta_id' => 13
          );
          $this->que->where('apm_id', $appointment->apm_id);
          $this->que->update('que_appointment', $apm_data);

          // คิวรีหาเวลา loc_time จาก wts_location
          $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "2"');
          $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
          // แปลงเวลาจาก apm_date และ ntdp_time_start
          $start_datetime = new DateTime($appointment->apm_date . ' ' . $data['ntdp_time_start']);
          // เพิ่มเวลาจาก loc_time
          $start_datetime->modify('+' . $loc_time . ' minutes');

          // คำนวณค่า ntdp_time_end และ ntdp_date_end
          $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
          $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

          // ใช้คำสั่ง JOIN เพื่ออัปเดตตาราง wts_notifications_department
          $this->db->query(
            "UPDATE see_wtsdb.wts_notifications_department w
                JOIN (
                    SELECT ntdp_id 
                    FROM see_wtsdb.wts_notifications_department w
                    JOIN see_quedb.que_appointment q ON w.ntdp_apm_id = q.apm_id
                    WHERE q.apm_visit = ? 
                    ORDER BY w.ntdp_seq DESC 
                    LIMIT 1
                ) latest ON w.ntdp_id = latest.ntdp_id
                SET w.ntdp_date_finish = ?, 
                    w.ntdp_time_finish = ?, 
                    w.ntdp_sta_id = ?",
                array(
                  $data['apm_visit'],          // พารามิเตอร์ apm_visit
                  $data['ntdp_date_start'],    // วันที่เสร็จสิ้น (date_finish)
                  $data['ntdp_time_start'],    // เวลาเสร็จสิ้น (time_finish)
                  '2'                          // สถานะ (sta_id = 2)
              )
          );

          // echo $this->db->last_query(); die;
          // Insert ข้อมูลใหม่ใน wts_notifications_department สำหรับแถวแรก
          foreach ($check_visit->result() as $appointment) {
            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }

            $wts_data_2 = array(
              'ntdp_apm_id' => $appointment->apm_id,
              'ntdp_seq' => '2',
              'ntdp_date_start' => $data['ntdp_date_start'],
              'ntdp_time_start' => $data['ntdp_time_start'],
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => '2',
              'ntdp_in_out' => $data['ntdp_in_out'],
              'ntdp_loc_cf_Id' => $data['ntdp_loc_cf_Id'],
              'ntdp_loc_Id' => $ntdp_loc_Id,
              'ntdp_loc_ft_Id' => $data['ntdp_loc_ft_Id'],
              'ntdp_function' => 'location_step2'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data_2['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data_2['ntdp_time_finish'] = $data['ntdp_time_start'];
              $this->que->where('apm_id', $appointment->apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            $this->wts->insert('wts_notifications_department', $wts_data_2);
            // echo $this->wts->last_query();
          }
          // die;
          $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
                    LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
                    WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
          // ถ้าพบ room ข้อมูล
          if ($room_query->num_rows() > 0) {
            // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
            $this->que->where('apm_visit', $data['apm_visit']);
            $this->que->update('que_appointment', array('apm_sta_id' => 4));
            // Insert ข้อมูลใหม่สำหรับ seq 2

            $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "' . $appointment->apm_id . '" ORDER BY ntdp_id DESC LIMIT 1');
            $ntdp_desc = $ntdp->row()->ntdp_apm_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            $ntdp_desc_id = $ntdp->row()->ntdp_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            $ntdp_desc_seq = $ntdp->row()->ntdp_seq; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที

            // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
            $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq_1 = $ntdp_desc_seq;
            $ntdp_date_end_1 = $data['ntdp_date_start'];
            $ntdp_time_end_1 = $data['ntdp_time_start'];
            $ntdp_sta_id_1 = '2';

            $wts_update_data = array(
              'ntdp_date_finish' => $ntdp_date_end_1,
              'ntdp_time_finish' => $ntdp_time_end_1,
              'ntdp_sta_id' => $ntdp_sta_id_1
            );

            // Update ข้อมูลในตาราง wts_notifications_department ที่มี seq = 1 และ apm_id ที่ตรงกัน
            $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
            $this->wts->where('ntdp_seq', $ntdp_seq_1);
            $this->wts->update('wts_notifications_department', $wts_update_data);

            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }


            $ntdp_apm_id = $ntdp_desc;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq = '6';
            $ntdp_date_start = $data['ntdp_date_start'];
            $ntdp_time_start = $data['ntdp_time_start'];
            $ntdp_sta_id = '2';
            $ntdp_in_out = $data['ntdp_in_out'];
            $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
            // $ntdp_loc_Id = $data['ntdp_loc_Id'];
            $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

            $wts_data = array(
              'ntdp_apm_id' => $ntdp_apm_id,
              'ntdp_seq' => $ntdp_seq,
              'ntdp_date_start' => $ntdp_date_start,
              'ntdp_time_start' => $ntdp_time_start,
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => $ntdp_sta_id,
              'ntdp_in_out' => $ntdp_in_out,
              'ntdp_loc_cf_Id' => $ntdp_loc_Id,
              'ntdp_loc_Id' => 6,
              'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
              'ntdp_function' => 'location_step2_room'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
              $this->que->where('apm_id', $ntdp_apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            // Insert ข้อมูลลงในตาราง wts_notifications_department
            $this->wts->insert('wts_notifications_department', $wts_data);

            if (!empty($appointment->apm_ps_id)) {
              // 1 get qus_psrm_id
              $this->load->model('hr/m_hr_person_room');
              $params = ['date' => $appointment->apm_date, 'ps_id' => $appointment->apm_ps_id,];
              $psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();

              // 2 insert m_wts_queue_seq
              if (!empty($psrm)) {
                $this->load->model('wts/m_wts_queue_seq');
                $this->m_wts_queue_seq->qus_psrm_id = $psrm[0]['psrm_id'];
                $this->m_wts_queue_seq->qus_apm_id = $appointment->apm_id;
                $this->m_wts_queue_seq->qus_app_walk = $appointment->apm_app_walk;
                $this->m_wts_queue_seq->insert_seq_by_max_psrm_id();
              }
            }
          }

          $que_info = $this->que->query('SELECT * FROM que_appointment WHERE apm_visit = "' . $data['apm_visit'] . '"')->row();

          // ส่งไลน์
          $line_data = array(
            "msst_id" => $this->config->item('message_que_line_id'),
            "pt_id" => $que_info->apm_pt_id,
            "apm_id" => $que_info->apm_id,
            "ntdp_loc_Id" => $ntdp_loc_Id,
            "ntdp_loc_ft_Id" => $data['ntdp_loc_ft_Id']
          );

          $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_que_to_patient";
          get_url_line_service($url_service_line, $line_data); // Line helper

          $response = array('status' => 'success', 'message' => 'First row updated and notification recorded.');

        } else {
          // กรณีไม่พบการนัดหมายด้วย apm_visit
          $response = array('status' => 'error', 'message' => 'No appointment found for the given visit.');
        }
      } else {
        // กรณีไม่มี apm_visit
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      // กรณีไม่มีข้อมูลส่งเข้ามา
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }


  // ฟังก์ชันสำหรับดึง stde_id จากชื่อแผนก
  private function get_stde_id($ds_stde_name)
  {
    if (empty($ds_stde_name)) {
      return NULL;
    }

    $this->hr->like('stde_name_th', $ds_stde_name, 'both');
    $this->hr->where('stde_active', '1');
    // $this->hr->where('stde_is_medical', 'Y');
    $structure_query = $this->hr->get('hr_structure_detail');
    $structure_detail = $structure_query->row();

    return $structure_detail ? $structure_detail->stde_id : NULL;
  }


  public function location_step3()
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
      if (isset($data['apm_visit'])) {
        // ค้นหาทุกแถวที่มี `apm_visit` ตรงกัน
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ?", array($data['apm_visit']));

        if ($check_visit->num_rows() > 0) {
          foreach ($check_visit->result() as $appointment) {

            // อัปเดตข้อมูลแถวแรก
            $apm_data = array(
              'apm_sta_id' => 14
            );
            $this->que->where('apm_id', $appointment->apm_id);
            $this->que->update('que_appointment', $apm_data);

            // คิวรีหาเวลา loc_time จาก wts_location
            $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "3"');
            $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            // แปลงเวลาจาก apm_date และ ntdp_time_start
            $start_datetime = new DateTime($appointment->apm_date . ' ' . $data['ntdp_time_start']);
            // เพิ่มเวลาจาก loc_time
            $start_datetime->modify('+' . $loc_time . ' minutes');

            // คำนวณค่า ntdp_time_end และ ntdp_date_end
            $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
            $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

            // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
            $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq_1 = ($data['ntdp_loc_Id'] - 1);
            $ntdp_date_end_1 = $data['ntdp_date_start'];
            $ntdp_time_end_1 = $data['ntdp_time_start'];
            $ntdp_sta_id_1 = '2';

            $wts_update_data = array(
              'ntdp_date_finish' => $ntdp_date_end_1,
              'ntdp_time_finish' => $ntdp_time_end_1,
              'ntdp_sta_id' => $ntdp_sta_id_1
            );

            // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
            $this->wts->select('ntdp_seq')
              ->from('wts_notifications_department')
              ->where('ntdp_apm_id', $ntdp_apm_id_1)
              ->order_by('ntdp_id', 'DESC')
              ->limit(1);

              $query = $this->wts->get();

              if ($query->num_rows() > 0) {
                $latest_seq = $query->row()->ntdp_seq;
            
                // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
                $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
                $this->wts->where('ntdp_seq', $latest_seq);
                $this->wts->update('wts_notifications_department', $wts_update_data);
                echo "Update successful.";
              } else {
                  echo "No matching record found.";
              }

            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }

            // Insert ข้อมูลใหม่สำหรับ seq 2
            $ntdp_apm_id = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq = '3';
            $ntdp_date_start = $data['ntdp_date_start'];
            $ntdp_time_start = $data['ntdp_time_start'];
            $ntdp_sta_id = '2';
            $ntdp_in_out = $data['ntdp_in_out'];
            $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
            // $ntdp_loc_Id = $data['ntdp_loc_Id'];
            $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

            $wts_data = array(
              'ntdp_apm_id' => $ntdp_apm_id,
              'ntdp_seq' => $ntdp_seq,
              'ntdp_date_start' => $ntdp_date_start,
              'ntdp_time_start' => $ntdp_time_start,
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => $ntdp_sta_id,
              'ntdp_in_out' => $ntdp_in_out,
              'ntdp_loc_cf_Id' => $ntdp_loc_cf_Id,
              'ntdp_loc_Id' => $ntdp_loc_Id,
              'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
              'ntdp_function' => 'location_step3'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
              $this->que->where('apm_id', $ntdp_apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            // Insert ข้อมูลลงในตาราง wts_notifications_department
            $this->wts->insert('wts_notifications_department', $wts_data);

            $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
            LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
            WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
            // ถ้าพบ room ข้อมูล
            if ($room_query->num_rows() > 0) { // ถ้าเข้าแผนก
              // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
              $this->que->where('apm_visit', $data['apm_visit']);
              $this->que->update('que_appointment', array('apm_sta_id' => 4));
              // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department

              // Insert ข้อมูลใหม่สำหรับ seq 2
              $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "' . $appointment->apm_id . '" ORDER BY ntdp_id DESC LIMIT 1');
              $ntdp_desc = $ntdp->row()->ntdp_apm_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
              $ntdp_desc_id = $ntdp->row()->ntdp_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
              $ntdp_desc_seq = $ntdp->row()->ntdp_seq; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที

              // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
              $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
              $ntdp_seq_1 = $ntdp_desc_seq;
              $ntdp_date_end_1 = $data['ntdp_date_start'];
              $ntdp_time_end_1 = $data['ntdp_time_start'];
              $ntdp_sta_id_1 = '2';

              $wts_update_data = array(
                'ntdp_date_finish' => $ntdp_date_end_1,
                'ntdp_time_finish' => $ntdp_time_end_1,
                'ntdp_sta_id' => $ntdp_sta_id_1
              );

              // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
              $this->wts->select('ntdp_seq')
                ->from('wts_notifications_department')
                ->where('ntdp_apm_id', $ntdp_apm_id_1)
                ->order_by('ntdp_id', 'DESC')
                ->limit(1);

                $query = $this->wts->get();

                if ($query->num_rows() > 0) {
                  $latest_seq = $query->row()->ntdp_seq;
              
                  // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
                  $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
                  $this->wts->where('ntdp_seq', $latest_seq);
                  $this->wts->update('wts_notifications_department', $wts_update_data);
                  echo "Update successful.";
                } else {
                    echo "No matching record found.";
                }
              
              if ($data['ntdp_in_out'] == 1) {
                $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
                $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
              } else {
                $ntdp_loc_Id = $data['ntdp_loc_Id'];
              }

              $ntdp_apm_id = $ntdp_desc;  // ใช้ apm_id ที่ค้นพบได้
              $ntdp_seq = '6';
              $ntdp_date_start = $data['ntdp_date_start'];
              $ntdp_time_start = $data['ntdp_time_start'];
              $ntdp_sta_id = '2';
              $ntdp_in_out = $data['ntdp_in_out'];
              $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
              // $ntdp_loc_Id = $data['ntdp_loc_Id'];
              $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

              $wts_data = array(
                'ntdp_apm_id' => $ntdp_apm_id,
                'ntdp_seq' => $ntdp_seq,
                'ntdp_date_start' => $ntdp_date_start,
                'ntdp_time_start' => $ntdp_time_start,
                'ntdp_date_end' => $ntdp_date_end,
                'ntdp_time_end' => $ntdp_time_end,
                'ntdp_sta_id' => $ntdp_sta_id,
                'ntdp_in_out' => $ntdp_in_out,
                'ntdp_loc_cf_Id' => $ntdp_loc_Id,
                'ntdp_loc_Id' => 6,
                'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
                'ntdp_function' => 'location_step3_room'
              );
              // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
              if ($data['ntdp_in_out'] == 1) {
                $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
                $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
                $this->que->where('apm_id', $ntdp_apm_id);
                $this->que->update('que_appointment', array('apm_sta_id' => 15));
              }
              // Insert ข้อมูลลงในตาราง wts_notifications_department
              $this->wts->insert('wts_notifications_department', $wts_data);


              if (!empty($appointment->apm_ps_id)) {
                // 1 get qus_psrm_id
                $this->load->model('hr/m_hr_person_room');
                $params = ['date' => $appointment->apm_date, 'ps_id' => $appointment->apm_ps_id,];
                // pre($params);
                $psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
                // pre($psrm); die;
                // 2 insert m_wts_queue_seq
                if (!empty($psrm)) {
                  $this->load->model('wts/m_wts_queue_seq');
                  $this->m_wts_queue_seq->qus_psrm_id = $psrm[0]['psrm_id'];
                  $this->m_wts_queue_seq->qus_apm_id = $appointment->apm_id;
                  $this->m_wts_queue_seq->qus_app_walk = $appointment->apm_app_walk;
                  $this->m_wts_queue_seq->insert_seq_by_max_psrm_id();
                  // echo $this->wts->last_query();
                }
                // die;
              }
            }
          }

          $que_info = $this->que->query('SELECT * FROM que_appointment WHERE apm_visit = "' . $data['apm_visit'] . '"')->row();

          // ส่งไลน์
          $line_data = array(
            "msst_id" => $this->config->item('message_que_line_id'),
            "pt_id" => $que_info->apm_pt_id,
            "apm_id" => $que_info->apm_id,
            "ntdp_loc_Id" => $ntdp_loc_Id,
            "ntdp_loc_ft_Id" => $ntdp_loc_ft_Id
          );

          $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_que_to_patient";
          get_url_line_service($url_service_line, $line_data); // Line helper

          // ส่งผลลัพธ์กลับในรูปแบบ JSON
          $response = array('status' => 'success', 'message' => 'Location and time successfully recorded for all appointments.');

        } else {
          $response = array('status' => 'error', 'message' => 'Appointment visit not found.');
        }
      } else {
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }


  public function insert_disease() // ไม่ใช้แล้ว
  {
    // โหลดโมเดลที่จำเป็น
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา (เป็นอาร์เรย์ของออบเจ็กต์)
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีข้อมูลที่ต้องการทั้งหมดถูกส่งเข้ามาหรือไม่
    if ($data && is_array($data)) {
      $response = array();

      foreach ($data as $item) {
        if (isset($item['ds_id']) && isset($item['ds_name_th']) && isset($item['ds_name_en']) && isset($item['ds_active']) && isset($item['ds_stde_name']) && isset($item['eqs_name']) && isset($item['eqs_id']) && isset($item['rm_name'])) {

          // ตรวจสอบว่ามี ds_id อยู่ในระบบแล้วหรือไม่
          $this->wts->where('ds_id', $item['ds_id']);
          $query = $this->wts->get('wts_base_disease');

          // ค้นหาแผนกที่ตรงกับชื่อที่ส่งมา โดยใช้ LIKE
          $this->hr->like('stde_name_th', $item['ds_stde_name'], 'both');
          $this->hr->where('stde_active', '1');
          $this->hr->where('stde_is_medical', 'Y');
          $structure_query = $this->hr->get('hr_structure_detail');

          // ตรวจสอบว่าพบข้อมูลแผนกหรือไม่
          if ($structure_query->num_rows() > 0) {
            $structure_detail = $structure_query->row();
            $ds_stde_id = $structure_detail->stde_id; // ใช้ stde_id จากข้อมูลที่พบ

            // เตรียมข้อมูลสำหรับการ insert หรือ update
            $disease_data = array(
              'ds_name_disease' => $item['ds_name_th'],
              'ds_name_disease_en' => $item['ds_name_en'],
              'ds_active' => $item['ds_active'],
              'ds_stde_id' => $ds_stde_id,  // ใช้ค่า stde_id ที่ค้นพบ
              'ds_create_user' => '1',  // คุณอาจต้องการใช้ user ที่ล็อกอินในขณะนั้นแทน
              'ds_create_date' => date('Y-m-d H:i:s')  // ใช้วันที่และเวลาปัจจุบัน
            );

            if ($query->num_rows() > 0) {
              // ถ้า ds_id มีอยู่แล้วในระบบ ทำการ Update
              $this->wts->where('ds_id', $item['ds_id']);
              $this->wts->update('wts_base_disease', $disease_data);

              // ดึง ds_id ที่เพิ่งอัปเดต
              $last_disease_id = $item['ds_id'];
            } else {
              // ถ้า ds_id ยังไม่มีในระบบ ทำการ Insert
              $disease_data['ds_id'] = $item['ds_id'];
              $this->wts->insert('wts_base_disease', $disease_data);
              $last_disease_id = $this->wts->insert_id();  // ดึง last_insert_id
            }

            // ตรวจสอบห้องในตาราง eqs_room
            $this->eqs->like('rm_name', $item['rm_name'], 'both');
            $room_query = $this->eqs->get('eqs_room');

            if ($room_query->num_rows() > 0) {
              // ถ้ามีห้องอยู่แล้ว ทำการ Update
              $room_data = $room_query->row();
              $rm_id = $room_data->rm_id;
              $this->eqs->where('rm_id', $rm_id);
              $this->eqs->update('eqs_room', array(
                'rm_name' => $item['rm_name'],
              ));
            } else {
              // ถ้าไม่มีห้องอยู่ ทำการ Insert
              $room_data = array(
                'rm_name' => $item['rm_name']
              );
              $this->eqs->insert('eqs_room', $room_data);
              $rm_id = $this->eqs->insert_id();  // ดึง rm_id ของห้องใหม่ที่ถูกสร้าง
            }


            // ตรวจสอบเครื่องมือแพทย์ในตาราง eqs_equipments
            $eqs_id = null; // ตั้งค่าเริ่มต้น
            $this->eqs->like('eqs_name', $item['eqs_name'], 'both');
            $this->eqs->where('eqs_id', $item['eqs_id']);
            $this->eqs->where('eqs_active', '1');
            $eqs_query = $this->eqs->get('eqs_equipments');
            if ($eqs_query->num_rows() > 0) {
              // ถ้ามีอุปกรณ์อยู่แล้ว ทำการ Update
              $eqs_row = $eqs_query->row(); // ดึงข้อมูลแถวที่พบ
              $eqs_id = $eqs_row->eqs_id; // เก็บ eqs_id ที่พบในตัวแปร
              $this->eqs->where('eqs_id', $eqs_id);
              $this->eqs->update('eqs_equipments', array(
                'eqs_name' => $item['eqs_name'],
                'eqs_rm_id' => $rm_id,  // ใช้ค่า rm_id ของห้องที่ได้มา
                'eqs_active' => '1',
                'eqs_update_user' => '1',
                'eqs_update_date' => date('Y-m-d H:i:s')
              ));
            } else {
              // ถ้าไม่มีอุปกรณ์อยู่ ทำการ Insert

              $eqs_data = array(
                // 'eqs_id' => $item['eqs_id'],  // ควรปรับปรุงให้เป็น auto-increment หรือ dynamic
                'eqs_unit' => 1,
                'eqs_amount' => 1,
                'eqs_name' => $item['eqs_name'],
                'eqs_fmst_id' => 12,
                'eqs_fmnd_id' => 0,
                'eqs_fmrd_id' => 0,
                'eqs_code' => 'ST-001',
                'eqs_gf' => null,
                'eqs_bg_id' => 1,
                'eqs_mt_id' => 2,
                'eqs_buydate' => date('Y-m-d H:i:s'),
                'eqs_expiredate' => date('Y-m-d H:i:s', strtotime('+50 years')),
                'eqs_dp_id' => 1,
                'eqs_stde_id' => $ds_stde_id,
                'eqs_bd_id' => 1,
                'eqs_rm_id' => $rm_id,  // ใช้ค่า rm_id ของห้องที่ได้มา
                'eqs_vd_id' => 0,
                'eqs_status' => 'Y',
                'eqs_active' => '1',
                'eqs_create_user' => '1',
                'eqs_create_date' => date('Y-m-d H:i:s')
              );
              $this->eqs->insert('eqs_equipments', $eqs_data);

              // หลังจาก insert, ดึง insert_id มาเก็บในตัวแปร $eqs_id
              $eqs_id = $this->eqs->insert_id();
            }

            // ค้นหาลำดับล่าสุดของ ddt_ds_id ใน wts_department_disease_tool
            $this->wts->select_max('ddt_seq');
            $this->wts->where('ddt_ds_id', $last_disease_id);
            $seq_query = $this->wts->get('wts_department_disease_tool');

            // ตรวจสอบว่ามีข้อมูลอยู่แล้วหรือไม่
            if ($seq_query->num_rows() > 0) {
              $seq_row = $seq_query->row();
              $ddt_seq = $seq_row->ddt_seq + 1;  // เพิ่ม 1 เพื่อให้เป็นลำดับถัดไป
            } else {
              $ddt_seq = 1;  // หากไม่มีรายการในตารางนี้ ให้เริ่มต้นที่ 1
            }

            $tool_data = array(
              'ddt_stde_id' => $ds_stde_id,
              'ddt_ds_id' => $last_disease_id,
              'ddt_eqs_id' => $eqs_id,  // ใช้ $eqs_id ที่ได้จากการ insert หรือ update
              'ddt_seq' => $ddt_seq,
              'ddt_create_user' => '1',  // คุณอาจต้องการใช้ user ที่ล็อกอินในขณะนั้นแทน
              'ddt_create_date' => date('Y-m-d H:i:s')  // ใช้วันที่และเวลาปัจจุบัน
            );
            $this->wts->insert('wts_department_disease_tool', $tool_data);

            $response[] = array('ds_id' => $item['ds_id'], 'status' => 'success', 'message' => 'Disease record successfully inserted.');
          } else {
            // กรณีไม่พบแผนก
            $response[] = array('ds_id' => $item['ds_id'], 'status' => 'error', 'message' => 'Department not found.');
          }
        } else {
          // กรณีข้อมูลไม่ครบถ้วน
          $response[] = array('ds_id' => isset($item['ds_id']) ? $item['ds_id'] : null, 'status' => 'error', 'message' => 'Missing required fields.');
        }
      }

      // ส่งผลลัพธ์กลับในรูปแบบ JSON
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    } else {
      // ส่งผลลัพธ์กลับในกรณีที่ข้อมูลไม่ถูกต้อง
      $response = array('status' => 'error', 'message' => 'Invalid input data.');
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
  }

  public function location_step9() // นัดแพทย์ครั้งถัดไป
  {

    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      // ตรวจสอบว่า apm_visit ถูกส่งเข้ามาหรือไม่
      if (isset($data['apm_visit'])) {

        // ค้นหาบุคคลในตาราง hr_person โดยใช้ชื่อและนามสกุล
        // ตัดคำหน้าจุดออกจาก ps_fname และ ps_lname
        $ps_fname = isset($data['ps_fname']) ? explode('.', $data['ps_fname']) : null;
        $ps_lname = isset($data['ps_lname']) ? $data['ps_lname'] : null;

        // ถ้ามีจุดให้ใช้คำหลังจุด ถ้าไม่มีจุดให้ใช้คำเดิม
        $ps_fname_ex = isset($ps_fname[1]) ? trim($ps_fname[1]) : trim($ps_fname[0]);
        $person_query = $this->hr->query("SELECT * FROM hr_person WHERE ps_fname LIKE ? AND ps_lname LIKE ?", array('%' . $ps_fname_ex . '%', '%' . $ps_lname . '%'));
        // if ($person_query->num_rows() > 0) {
        $person = $person_query->row();
        // ค้นหาการนัดหมายใน que_appointment โดยใช้ apm_visit
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ? AND apm_ps_id = ? ", array($data['apm_visit'], $person->ps_id));
        // echo $this->que->last_query(); die;
        // pre($check_visit->result_array()); die;
        // ตรวจสอบว่าพบข้อมูลการนัดหมายหรือไม่
        if ($check_visit->num_rows() > 0) {
          $appointment = $check_visit->row();

          // ตรวจสอบว่า ap_his_id มีอยู่ในตาราง ams_appointment หรือไม่
          $appointment_query = $this->ams->query("SELECT * FROM ams_appointment 
            LEFT JOIN ams_notification_results ON ap_ntr_id = ntr_id 
            LEFT JOIN see_quedb.que_appointment ON apm_id = ntr_apm_id 
            WHERE ntr_apm_id = ? AND ap_his_id = ? AND ntr_ps_id = ?", array($appointment->apm_id, $data['ap_his_id'], $person->ps_id));
          // echo $this->ams->last_query(); die;
          if ($appointment_query->num_rows() > 0) {

            $apm_data = array(
              'apm_sta_id' => 10
            );
            $this->que->where('apm_id', $appointment->apm_id);
            $this->que->update('que_appointment', $apm_data);

            // ถ้าไม่มีข้อมูล ทำการแทรกข้อมูลใหม่
            $ntr_data = array(
              'ntr_apm_id' => $appointment->apm_id,
              'ntr_pt_id' => $appointment->apm_pt_id,
              'ntr_ps_id' => $person->ps_id,
              'ntr_ntf_id' => '1',
              'ntr_ast_id' => '8'
            );
            // $this->ams->insert('ams_notification_results', $ntr_data);
            // $last_ntr_id = $this->ams->insert_id();

            $this->ams->where('ntr_apm_id', $appointment->apm_id);
            $this->ams->update('ams_notification_results', $ntr_data);

            // ถ้ามีข้อมูลอยู่แล้ว ทำการอัปเดต
            $ap_data = array(
              'ap_date' => $data['ap_date'],
              'ap_time' => $data['ap_time'],
              'ap_visit' => $data['apm_visit'],
              'ap_detail_appointment' => $data['ap_detail_appointment'],
              'ap_detail_appointment_en' => $data['ap_detail_appointment_en'],
              'ap_detail_prepare' => $data['ap_detail_prepare'],
              'ap_detail_prepare_en' => $data['ap_detail_prepare_en'],
              'ap_report_type' => '1',
              'ap_ast_id' => '1',
              'ap_rp_date' => date('Y-m-d', strtotime($data['ap_date'] . ' -1 day')),
              'ap_rp_time' => '10:00:00',
              'ap_before_time' => 'กรุณามาลงทะเบียนก่อนเวลา '.$data['ap_before_time'],
              'ap_before_time_en' => 'Please register before '.$data['ap_before_time_en'],
              'ap_update_date' => date('Y-m-d H:i:s')
            );
            $this->ams->where('ap_his_id', $data['ap_his_id']);
            $this->ams->update('ams_appointment', $ap_data);
            // ดึงข้อมูลการนัดหมายที่เพิ่งอัปเดต
            $updated_apm = $this->ams->get_where('ams_appointment', array('ap_his_id' => $data['ap_his_id']))->row();
            if (date('Y-m-d', strtotime($data['ap_date'])) <= date('Y-m-d') || ((date('Y-m-d', strtotime($data['ap_date'] . ' -1 day')) == date('Y-m-d')) && strtotime('12:30:00') < strtotime(date('H:i:s')))) {
              $pt_info = $this->db->query("SELECT * FROM see_umsdb.ums_patient 
                           WHERE pt_id = ?", array($appointment->apm_pt_id))->row();
              $command = "php " . escapeshellarg(FCPATH . "index.php") . " ams/Urgent_notify send_email {$updated_apm->ap_id} {$pt_info->pt_member} > /dev/null 2>&1 &";
              exec($command, $output, $return_var);
              $line_data = array(
                "msst_id" => $this->config->item('message_ams_line_id'),
                "hn_id" => $pt_info->pt_member,
                "ap_id" => $updated_apm->ap_id  // ใช้ ap_id จากการ query ล่าสุด
              );

              $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_appointment_to_patient";
              get_url_line_service($url_service_line, $line_data);
            }
            $response = array('status' => 'success', 'message' => 'Appointment updated successfully.');
          } else {
            // จากนั้น Insert ข้อมูลใหม่สำหรับ seq 2
            // คิวรีหาเวลา loc_time จาก wts_location
            $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "9"');
            $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            // แปลงเวลาจาก apm_date และ ntdp_time_start
            $start_datetime = new DateTime($appointment->apm_date . ' ' . $data['ntdp_time_start']);
            // เพิ่มเวลาจาก loc_time
            $start_datetime->modify('+' . $loc_time . ' minutes');

            // คำนวณค่า ntdp_time_end และ ntdp_date_end
            $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
            $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

            // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
            $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq_1 = ($data['ntdp_loc_Id'] - 1);
            $ntdp_date_end_1 = $data['ntdp_date_start'];
            $ntdp_time_end_1 = $data['ntdp_time_start'];

            $wts_update_data = array(
              'ntdp_date_finish' => $ntdp_date_end_1,
              'ntdp_time_finish' => $ntdp_time_end_1
            );

            // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
            $this->wts->select('ntdp_seq')
              ->from('wts_notifications_department')
              ->where('ntdp_apm_id', $ntdp_apm_id_1)
              ->order_by('ntdp_id', 'DESC')
              ->limit(1);

              $query = $this->wts->get();

              if ($query->num_rows() > 0) {
                $latest_seq = $query->row()->ntdp_seq;
            
                // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
                $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
                $this->wts->where('ntdp_seq', $latest_seq);
                $this->wts->update('wts_notifications_department', $wts_update_data);
                echo "Update successful.";
              } else {
                  echo "No matching record found.";
              }

            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }

            $ntdp_apm_id = $appointment->apm_id;
            $ntdp_seq = '9';
            $ntdp_date_start = $data['ntdp_date_start'];
            $ntdp_time_start = $data['ntdp_time_start'];
            $ntdp_sta_id = '2';
            $ntdp_in_out = $data['ntdp_in_out'];
            $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
            // $ntdp_loc_Id = $data['ntdp_loc_Id'];
            $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

            $wts_data = array(
              'ntdp_apm_id' => $ntdp_apm_id,
              'ntdp_seq' => $ntdp_seq,
              'ntdp_date_start' => $ntdp_date_start,
              'ntdp_time_start' => $ntdp_time_start,
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => $ntdp_sta_id,
              'ntdp_in_out' => $ntdp_in_out,
              'ntdp_loc_cf_Id' => $ntdp_loc_cf_Id,
              'ntdp_loc_Id' => $ntdp_loc_Id,
              'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
              'ntdp_function' => 'location_step9'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
              $this->que->where('apm_id', $ntdp_apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            // Insert ข้อมูลลงในตาราง wts_notifications_department
            $this->wts->insert('wts_notifications_department', $wts_data);
            $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
                LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
                WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
            // ถ้าพบ room ข้อมูล
            if ($room_query->num_rows() > 0) {
              // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
              // $this->que->where('apm_visit', $data['apm_visit']);
              // $this->que->update('que_appointment', array('apm_sta_id' => 4));

              if (!empty($appointment->apm_ps_id)) {
                // 1 get qus_psrm_id
                $this->load->model('hr/m_hr_person_room');
                $params = ['date' => $appointment->apm_date, 'ps_id' => $appointment->apm_ps_id,];
                // pre($params);
                $psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
                // pre($psrm); die;
                // 2 insert m_wts_queue_seq
                if (!empty($psrm)) {
                  $this->load->model('wts/m_wts_queue_seq');
                  $this->m_wts_queue_seq->qus_psrm_id = $psrm[0]['psrm_id'];
                  $this->m_wts_queue_seq->qus_apm_id = $appointment->apm_id;
                  $this->m_wts_queue_seq->qus_app_walk = $appointment->apm_app_walk;
                  $this->m_wts_queue_seq->insert_seq_by_max_psrm_id();
                  // echo $this->wts->last_query();
                }
                // die;
              }
            }

            // ถ้าไม่มีข้อมูล ทำการแทรกข้อมูลใหม่
            $ntr_data = array(
              'ntr_apm_id' => $appointment->apm_id,
              'ntr_pt_id' => $appointment->apm_pt_id,
              'ntr_ps_id' => $person->ps_id,
              'ntr_ntf_id' => '1',
              'ntr_ast_id' => '8'
            );
            $this->ams->insert('ams_notification_results', $ntr_data);
            // echo $this->ams->last_query(); die;
            $last_ntr_id = $this->ams->insert_id();

            $ap_data = array(
              'ap_pt_id' => $appointment->apm_pt_id,
              'ap_ntr_id' => $last_ntr_id,
              'ap_date' => $data['ap_date'],
              'ap_time' => $data['ap_time'],
              'ap_his_id' => $data['ap_his_id'],
              'ap_visit' => $data['apm_visit'],
              'ap_detail_appointment' => $data['ap_detail_appointment'],
              'ap_detail_appointment_en' => $data['ap_detail_appointment_en'],
              'ap_detail_prepare' => $data['ap_detail_prepare'],
              'ap_detail_prepare_en' => $data['ap_detail_prepare_en'],
              'ap_report_type' => '1',
              'ap_ast_id' => '1',
              'ap_rp_date' => date('Y-m-d', strtotime($data['ap_date'] . ' -1 day')),
              'ap_rp_time' => '10:00:00',
              'ap_before_time' => 'กรุณามาลงทะเบียนก่อนเวลา '.$data['ap_before_time'],
              'ap_before_time_en' => 'Please register before '.$data['ap_before_time_en'],
              'ap_create_date' => date('Y-m-d H:i:s')
            );
            $this->ams->insert('ams_appointment', $ap_data);
            $last_ams_id = $this->ams->insert_id();
            // pre($last_ntr_id);
            // die();
            if ($last_ntr_id) {
              if (date('Y-m-d', strtotime($data['ap_date'])) <= date('Y-m-d') || ((date('Y-m-d', strtotime($data['ap_date'] . ' -1 day')) == date('Y-m-d')) && strtotime('12:30:00') < strtotime(date('H:i:s')))) {
                $pt_info = $this->db->query("SELECT * FROM see_umsdb.ums_patient 
                           WHERE pt_id = ?", array($appointment->apm_pt_id))->row();
                $command = "php " . escapeshellarg(FCPATH . "index.php") . " ams/Urgent_notify send_email {$last_ams_id} {$pt_info->pt_member} > /dev/null 2>&1 &";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                  echo "Error occurred: \n";
                  print_r($output);
                } else {
                  echo "Command executed successfully.\n";
                  print_r($output);
                }
                $line_data = array(
                  "msst_id" => $this->config->item('message_ams_line_id'),
                  "hn_id" => $pt_info->pt_member,
                  "ap_id" => $last_ams_id
                );

                $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_appointment_to_patient";
                get_url_line_service($url_service_line, $line_data);
              } else {
                echo 'ยังไม่ถึงวันแจ้งเตือน';
              }
            }

            $response = array('status' => 'success', 'message' => 'Appointment created successfully.');
          }
          // } else {
          //   // ไม่พบบุคคลตามชื่อและนามสกุล
          //   $response = array('status' => 'error', 'message' => 'Person not found.');
          // }
        } else {
          // กรณีไม่พบ apm_visit ในฐานข้อมูล
          $response = array('status' => 'error', 'message' => 'Appointment visit not found.');
        }
      } else {
        // กรณีที่ไม่มีการส่ง apm_visit เข้ามา
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      // กรณีที่ไม่มีข้อมูลส่งเข้ามา
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
  public function location_step10()
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      // ตรวจสอบว่า apm_visit ถูกส่งเข้ามาหรือไม่
      if (isset($data['apm_visit'])) {
        // ค้นหาการนัดหมายใน que_appointment โดยใช้ apm_visit
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ?", array($data['apm_visit']));

        // ตรวจสอบว่าพบข้อมูลการนัดหมายหรือไม่
        if ($check_visit->num_rows() > 0) {
          // $appointment = $check_visit->row();

          foreach ($check_visit->result() as $appointment) {

            $apm_data = array(
              'apm_sta_id' => 10
            );
            $this->que->where('apm_id', $appointment->apm_id);
            $this->que->update('que_appointment', $apm_data);

            // จากนั้น Insert ข้อมูลใหม่สำหรับ seq 2
            // คิวรีหาเวลา loc_time จาก wts_location
            $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "9"');
            $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            // แปลงเวลาจาก apm_date และ ntdp_time_start
            $start_datetime = new DateTime($appointment->apm_date . ' ' . $data['ntdp_time_start']);
            // เพิ่มเวลาจาก loc_time
            $start_datetime->modify('+' . $loc_time . ' minutes');

            // คำนวณค่า ntdp_time_end และ ntdp_date_end
            $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
            $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

            // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
            $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq_1 = ($data['ntdp_loc_Id'] - 1);
            $ntdp_date_end_1 = $data['ntdp_date_start'];
            $ntdp_time_end_1 = $data['ntdp_time_start'];
            $ntdp_sta_id_1 = '2';

            $wts_update_data = array(
              'ntdp_date_finish' => $ntdp_date_end_1,
              'ntdp_time_finish' => $ntdp_time_end_1
            );

            // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
            $this->wts->select('ntdp_seq')
              ->from('wts_notifications_department')
              ->where('ntdp_apm_id', $ntdp_apm_id_1)
              ->order_by('ntdp_id', 'DESC')
              ->limit(1);

              $query = $this->wts->get();

              if ($query->num_rows() > 0) {
                $latest_seq = $query->row()->ntdp_seq;
            
                // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
                $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
                $this->wts->where('ntdp_seq', $latest_seq);
                $this->wts->update('wts_notifications_department', $wts_update_data);
                echo "Update successful.";
              } else {
                  echo "No matching record found.";
              }

            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }

            // จากนั้น Insert ข้อมูลใหม่สำหรับ seq 2
            $ntdp_apm_id = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq = $ntdp_loc_Id;
            $ntdp_date_start = $data['ntdp_date_start'];
            $ntdp_time_start = $data['ntdp_time_start'];
            $ntdp_sta_id = '2';
            $ntdp_in_out = $data['ntdp_in_out'];
            $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
            // $ntdp_loc_Id = $data['ntdp_loc_Id'];
            $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

            $wts_data = array(
              'ntdp_apm_id' => $ntdp_apm_id,
              'ntdp_seq' => $ntdp_seq,
              'ntdp_date_start' => $ntdp_date_start,
              'ntdp_time_start' => $ntdp_time_start,
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => $ntdp_sta_id,
              'ntdp_in_out' => $ntdp_in_out,
              'ntdp_loc_cf_Id' => $ntdp_loc_cf_Id,
              'ntdp_loc_Id' => $ntdp_loc_Id,
              'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
              'ntdp_function' => 'location_step10'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];
              $this->que->where('apm_id', $ntdp_apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            // Insert ข้อมูลลงในตาราง wts_notifications_department
            $this->wts->insert('wts_notifications_department', $wts_data);
          }

          $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
            LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
            WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
          // ถ้าพบ room ข้อมูล
          if ($room_query->num_rows() > 0) {
            // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
            $this->que->where('apm_visit', $data['apm_visit']);
            $this->que->update('que_appointment', array('apm_sta_id' => 4));
          }

          $que_info = $this->que->query('SELECT * FROM que_appointment WHERE apm_visit = "' . $data['apm_visit'] . '"')->row();

          // ส่งไลน์
          $line_data = array(
            "msst_id" => $this->config->item('message_que_line_id'),
            "pt_id" => $que_info->apm_pt_id,
            "apm_id" => $que_info->apm_id,
            "ntdp_loc_Id" => $ntdp_loc_Id,
            "ntdp_loc_ft_Id" => $ntdp_loc_ft_Id
          );

          $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_que_to_patient";
          get_url_line_service($url_service_line, $line_data); // Line helper

          // ส่งผลลัพธ์กลับในรูปแบบ JSON
          $response = array('status' => 'success', 'message' => 'Location and time successfully recorded.');

        } else {
          // กรณีไม่พบ apm_visit ในฐานข้อมูล
          $response = array('status' => 'error', 'message' => 'Appointment visit not found.');
        }
      } else {
        // กรณีที่ไม่มีการส่ง apm_visit เข้ามา
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      // กรณีที่ไม่มีข้อมูลส่งเข้ามา
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function location_step11()
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      // ตรวจสอบว่า apm_visit ถูกส่งเข้ามาหรือไม่
      if (isset($data['apm_visit'])) {
        // ค้นหาการนัดหมายใน que_appointment โดยใช้ apm_visit
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ?", array($data['apm_visit']));

        // ตรวจสอบว่าพบข้อมูลการนัดหมายหรือไม่
        if ($check_visit->num_rows() > 0) {
          // $appointment = $check_visit->row();

          // จากนั้น Insert ข้อมูลใหม่สำหรับ seq 2
          foreach ($check_visit->result() as $appointment) {

            $apm_data = array(
              'apm_sta_id' => 10
            );
            $this->que->where('apm_id', $appointment->apm_id);
            $this->que->update('que_appointment', $apm_data);

            // จากนั้น Insert ข้อมูลใหม่สำหรับ seq 2
            // คิวรีหาเวลา loc_time จาก wts_location
            $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "10"');
            $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            // แปลงเวลาจาก apm_date และ ntdp_time_start
            $start_datetime = new DateTime($appointment->apm_date . ' ' . $data['ntdp_time_start']);
            // เพิ่มเวลาจาก loc_time
            $start_datetime->modify('+' . $loc_time . ' minutes');

            // คำนวณค่า ntdp_time_end และ ntdp_date_end
            $ntdp_time_end = $start_datetime->format('H:i:s'); // เวลาที่ต้องการบันทึก
            $ntdp_date_end = $start_datetime->format('Y-m-d'); // วันที่ที่ต้องการบันทึก (ซึ่งควรจะเป็นวันเดียวกันกับ apm_date)

            // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department
            $ntdp_apm_id_1 = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq_1 = ($data['ntdp_loc_Id'] - 1);
            $ntdp_date_end_1 = $data['ntdp_date_start'];
            $ntdp_time_end_1 = $data['ntdp_time_start'];
            $ntdp_sta_id_1 = '2';

            $wts_update_data = array(
              'ntdp_date_finish' => $ntdp_date_end_1,
              'ntdp_time_finish' => $ntdp_time_end_1
            );

            // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
            $this->wts->select('ntdp_seq')
              ->from('wts_notifications_department')
              ->where('ntdp_apm_id', $ntdp_apm_id_1)
              ->order_by('ntdp_id', 'DESC')
              ->limit(1);

              $query = $this->wts->get();

              if ($query->num_rows() > 0) {
                $latest_seq = $query->row()->ntdp_seq;
            
                // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
                $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
                $this->wts->where('ntdp_seq', $latest_seq);
                $this->wts->update('wts_notifications_department', $wts_update_data);
                echo "Update successful.";
              } else {
                  echo "No matching record found.";
              }

            if ($data['ntdp_in_out'] == 1) {
              $loc_out = $this->db->query('SELECT * FROM see_eqsdb.eqs_room WHERE rm_his_id = "' . $data['ntdp_loc_Id'] . '"');
              $ntdp_loc_Id = $loc_out->row()->rm_loc_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            } else {
              $ntdp_loc_Id = $data['ntdp_loc_Id'];
            }

            $ntdp_apm_id = $appointment->apm_id;  // ใช้ apm_id ที่ค้นพบได้
            $ntdp_seq = '11';
            $ntdp_date_start = $data['ntdp_date_start'];
            $ntdp_time_start = $data['ntdp_time_start'];
            $ntdp_sta_id = '2';
            $ntdp_in_out = $data['ntdp_in_out'];
            $ntdp_loc_cf_Id = $data['ntdp_loc_cf_Id'];
            // $ntdp_loc_Id = $data['ntdp_loc_Id'];
            $ntdp_loc_ft_Id = $data['ntdp_loc_ft_Id'];

            $wts_data = array(
              'ntdp_apm_id' => $ntdp_apm_id,
              'ntdp_seq' => $ntdp_seq,
              'ntdp_date_start' => $ntdp_date_start,
              'ntdp_time_start' => $ntdp_time_start,
              'ntdp_date_end' => $ntdp_date_end,
              'ntdp_time_end' => $ntdp_time_end,
              'ntdp_sta_id' => $ntdp_sta_id,
              'ntdp_in_out' => $ntdp_in_out,
              'ntdp_loc_cf_Id' => $ntdp_loc_cf_Id,
              'ntdp_loc_Id' => $ntdp_loc_Id,
              'ntdp_loc_ft_Id' => $ntdp_loc_ft_Id,
              'ntdp_function' => 'location_step11'
            );
            // ถ้า ntdp_in_out == 1 ให้เพิ่มค่า ntdp_date_finish และ ntdp_time_finish แทน
            if ($data['ntdp_in_out'] == 1) {
              $wts_data['ntdp_date_finish'] = $data['ntdp_date_start'];
              $wts_data['ntdp_time_finish'] = $data['ntdp_time_start'];

              $this->que->where('apm_id', $ntdp_apm_id);
              $this->que->update('que_appointment', array('apm_sta_id' => 15));
            }
            // Insert ข้อมูลลงในตาราง wts_notifications_department
            $this->wts->insert('wts_notifications_department', $wts_data);
          }
          $room_query = $this->db->query("SELECT * FROM see_eqsdb.eqs_room 
            LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
            WHERE rm_his_id = ? AND rm_stde_id IS NOT NULL", array($data['ntdp_loc_ft_Id']));
          // ถ้าพบ room ข้อมูล
          if ($room_query->num_rows() > 0) {
            // อัปเดต apm_sta_id เป็น 4 ในตาราง que_appointment
            $this->que->where('apm_id', $ntdp_apm_id);
            $this->que->update('que_appointment', array('apm_sta_id' => 4));
          }

          $que_info = $this->que->query('SELECT * FROM que_appointment WHERE apm_visit = "' . $data['apm_visit'] . '"')->row();

          // ส่งไลน์
          $line_data = array(
            "msst_id" => $this->config->item('message_que_line_id'),
            "pt_id" => $que_info->apm_pt_id,
            "apm_id" => $que_info->apm_id,
            "ntdp_loc_Id" => $ntdp_loc_Id,
            "ntdp_loc_ft_Id" => $ntdp_loc_ft_Id
          );

          $url_service_line = site_url() . "/" . $this->config->item('line_service_dir') . "send_message_que_to_patient";
          get_url_line_service($url_service_line, $line_data); // Line helper

          // ส่งผลลัพธ์กลับในรูปแบบ JSON
          $response = array('status' => 'success', 'message' => 'Location and time successfully recorded.');
        } else {
          // กรณีไม่พบ apm_visit ในฐานข้อมูล
          $response = array('status' => 'error', 'message' => 'Appointment visit not found.');
        }
      } else {
        // กรณีที่ไม่มีการส่ง apm_visit เข้ามา
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      // กรณีที่ไม่มีข้อมูลส่งเข้ามา
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function insert_in_out()
  { // ตอนที่ดึกแพทย์กลับมาขอใบรับรอง 
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      // ตรวจสอบว่า apm_visit ถูกส่งเข้ามาหรือไม่
      if (isset($data['apm_visit'])) {
        // ค้นหาการนัดหมายใน que_appointment โดยใช้ apm_visit
        $check_visit = $this->que->query(
          "SELECT * FROM que_appointment 
              LEFT JOIN see_hrdb.hr_structure_detail ON stde_id = apm_stde_id
              LEFT JOIN see_hrdb.hr_structure ON stuc_id = stde_stuc_id AND stuc_status = '1'
              WHERE apm_visit = ? AND stde_name_th LIKE ?",
          array($data['apm_visit'], '%' . $data['ds_stde_name'] . '%')
        );

        // ตรวจสอบว่าพบข้อมูลการนัดหมายหรือไม่
        if ($check_visit->num_rows() > 0) {
          foreach ($check_visit->result() as $appointment) {
            // อัปเดตสถานะ ntdp_in_out
            $wts_notifications_department = $this->wts->query("SELECT * FROM wts_notifications_department WHERE ntdp_apm_id = '" . $appointment->apm_id . "'");

            $wts_update_data = array(
              'ntdp_in_out' => 0
            );

            $this->wts->where('ntdp_apm_id', $appointment->apm_id);
            $this->wts->where('ntdp_apm_id', $appointment->ntdp_in_out);
            $this->wts->update('wts_notifications_department', $wts_update_data);


            $apm_update = array(
              'apm_sta_id' => 1
            );

            $this->wts->where('apm_id', $appointment->apm_id);
            $this->wts->update('que_appointment', $apm_update);
          }
          // ส่งผลลัพธ์กลับในรูปแบบ JSON
          $response = array('status' => 'success', 'message' => 'Location and time successfully recorded.');
        } else {
          // กรณีไม่พบการนัดหมายด้วย apm_visit
          $response = array('status' => 'error', 'message' => 'Appointment visit not found.');
        }
      } else {
        // กรณีที่ไม่มีการส่ง apm_visit เข้ามา
        $response = array('status' => 'error', 'message' => 'Missing apm_visit field.');
      }
    } else {
      // กรณีที่ไม่มีข้อมูลส่งเข้ามา
      $response = array('status' => 'error', 'message' => 'No data received.');
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }


  public function update_amp_pri()
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');

    // รับค่าจาก request ที่ส่งมา
    $data = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
    if ($data) {
      if (isset($data['apm_visit'])) {
        // ค้นหาแถวที่มี `apm_visit` ตรงกัน
        $check_visit = $this->que->query("SELECT * FROM que_appointment WHERE apm_visit = ?", array($data['apm_visit']));
        if ($check_visit->num_rows() > 0) {
          if ($data['apm_pri_id'] == 'ปกติ') {
            $apm_pri_id = '5';
          } else if ($data['apm_pri_id'] == 'ฉุกเฉิน') {
            $apm_pri_id = '1';
          } else if ($data['apm_pri_id'] == 'เฝ้าระวัง') {
            $apm_pri_id = '2';
          } else if ($data['apm_pri_id'] == 'บุคคลสำคัญ (Vip)') {
            $apm_pri_id = '3';
          } else if ($data['apm_pri_id'] == 'นัดหมายแพทย์') {
            $apm_pri_id = '4';
          } else {
            $apm_pri_id = '5';
          }

          // อัปเดตข้อมูลทั้งหมดที่มี `apm_visit` ตรงกัน
          $apm_data = array(
            'apm_pri_id' => $apm_pri_id
          );
          $this->que->where('apm_visit', $data['apm_visit']);
          if ($this->que->update('que_appointment', $apm_data)) {
            // แสดงข้อความเมื่ออัปเดตสำเร็จ
            echo json_encode(array('status' => 'success', 'message' => 'success update apm_pri_id'));
          } else {
            // แสดงข้อความเมื่ออัปเดตล้มเหลว
            echo json_encode(array('status' => 'error', 'message' => 'failed to update apm_pri_id'));
          }
        } else {
          // แสดงข้อความเมื่อไม่พบ `apm_visit`
          echo json_encode(array('status' => 'error', 'message' => 'apm_visit not found'));
        }
      } else {
        // แสดงข้อความเมื่อไม่ได้ส่ง `apm_visit`
        echo json_encode(array('status' => 'error', 'message' => 'apm_visit is required'));
      }
    } else {
      // แสดงข้อความเมื่อไม่ได้รับข้อมูล
      echo json_encode(array('status' => 'error', 'message' => 'no data received'));
    }
  }

  public function delete_department()
  {
      $this->load->model('que/M_que_appointment');
      $this->load->model('wts/M_wts_notifications_department');
      $this->load->model('que/M_que_code_list');
      $this->load->model('wts/M_wts_base_route_department');
  
      // รับข้อมูลจาก request
      $data = json_decode(file_get_contents('php://input'), true);
  
      if (!$data) {
          http_response_code(400);
          echo json_encode(['status' => 'error', 'message' => 'No data received']);
          return;
      }
  
      if (!isset($data['apm_visit'])) {
          http_response_code(400);
          echo json_encode(['status' => 'error', 'message' => 'apm_visit is required']);
          return;
      }
  
      // ค้นหา stde_id จากชื่อ
      $ds_stde_id = $this->get_stde_id($data['ds_stde_name']);
      if (!$ds_stde_id) {
          http_response_code(404);
          echo json_encode(['status' => 'error', 'message' => 'Invalid stde_name']);
          return;
      }
  
      // ตรวจสอบการมีอยู่ของข้อมูล que_appointment
      $check_visit = $this->que->get_where('que_appointment', [
          'apm_visit' => $data['apm_visit'],
          'apm_stde_id' => $ds_stde_id
      ]);
  
      if ($check_visit->num_rows() === 0) {
          http_response_code(404);
          echo json_encode(['status' => 'error', 'message' => 'apm_visit not found']);
          return;
      }
  
      // อัปเดตสถานะ apm_sta_id เป็น 9
      $update_data = ['apm_sta_id' => '9'];
      $this->que->where('apm_visit', $data['apm_visit']);
      $this->que->where('apm_stde_id', $ds_stde_id);
  
      if ($this->que->update('que_appointment', $update_data)) {
          http_response_code(200);
          echo json_encode(['status' => 'success', 'message' => 'success update apm_sta_id']);
      } else {
          http_response_code(500);
          echo json_encode(['status' => 'error', 'message' => 'Failed to update apm_sta_id']);
      }
  }
}

?>