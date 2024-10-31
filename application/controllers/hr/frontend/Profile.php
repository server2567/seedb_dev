<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Profile extends UMS_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('staff/M_staff_profile');
    $this->load->model('hr/M_hr_person_education');
    $this->load->model('hr/M_hr_person_work_history');
    $this->load->model('hr/M_hr_person_reward');
    $this->load->model('hr/M_hr_person_external_service');
  }

  function personnel()
  {

    $data['ddd'] = array();
    $this->output_frontend('hr/frontend/v_profile_personnel', $data);
  }

  function index()
  {
    $data['ddd'] = array();
    $this->output('hr/frontend/v_profile', $data);
  }
  function adjustDateIfNeeded($dateStr)
  {
    $dateParts = explode('-', $dateStr);
    $year = $dateParts[0];
    $month = $dateParts[1];
    $day = isset($dateParts[2]) ? $dateParts[2] : '01'; // กำหนดเป็น '01' ถ้าไม่มีวันที่

    // ตรวจสอบว่ามีวันที่เป็น 00 หรือไม่
    if ($day === '00') {
      // สร้างวันที่เป็นวันแรกของเดือนนั้น
      $date = new DateTime("$year-$month-01");
    } else {
      // ถ้าป้อนวันที่ไม่ใช่ 00 ก็ใช้วันที่ปกติ
      $date = new DateTime($dateStr);
    }

    return $date;
  }
  function get_work_age($ps_id)
  {
    $ps_work_history = $this->M_hr_person_work_history->get_all_person_work_history_data($ps_id)->result();
    if ($ps_work_history) {
      foreach ($ps_work_history  as $key => $row) {
        if ($key == 0) {
          if ($row->wohr_end_date == '9999-12-31') {
            $end_date = date('Y-m-d');
          } else {
            $end_date = $row->wohr_end_date;
          }
        }
        if ($key == (count($ps_work_history) - 1)) {
          $start_date = $row->wohr_start_date;
        }
      }
      $date1 = $this->adjustDateIfNeeded($start_date);
      $date2 = $this->adjustDateIfNeeded($end_date);
      // คำนวณระยะห่างระหว่างวันที่
      $interval = $date1->diff($date2);
      // คำนวณจำนวนปีและเดือนรวมทั้งหมด
      $years = $interval->y;
      $months = $interval->m;
      // หากวันในวันที่สิ้นสุดก่อนวันในวันที่เริ่มต้น, ลดเดือนลง 1
      // คำนวณระยะห่างระหว่างวันที่
      $interval = $date1->diff($date2);
      $work_age['year'] = $years;
      $work_age['months'] = $months;
    }else{
      $work_age['year'] = 0;
      $work_age['months'] = 0;
    }
    return $work_age;
  }
  function get_reward_list($ps_id)
  {
    $ps_reward = $this->M_hr_person_reward->get_all_person_reward_data($ps_id)->result();
    $groupedData = [];
    if ($ps_reward) {
      foreach ($ps_reward as $item) {
        $year  = $item->rewd_year;
        if (!isset($groupedData[$year])) {
          $groupedData[$year] = [];
        }
        $groupedData[$year][] = $item;
      }
    }
    return $groupedData;
  }
  function get_external_service_list($ps_id)
  {
    $ps_external = $this->M_hr_person_external_service->get_all_external_service_data($ps_id)->result();
    $groupedData = [];
    if ($ps_external) {
      foreach ($ps_external as $item) {
        $date = new DateTime($item->pexs_date);
        $year = $date->format("Y") + 543;
        if (!isset($groupedData[$year])) {
          $groupedData[$year] = [];
        }
        // จัดกลุ่มตาม pexs_exts_id ภายในปี
        if (!isset($groupedData[$year][$item->pexs_exts_id])) {
          $groupedData[$year][$item->pexs_exts_id] = [];
        }
        $groupedData[$year][$item->pexs_exts_id][] = $item;
      }
      foreach ($groupedData as $year => &$categories) {
        foreach ($categories as $exts_id => &$items) {
          usort($items, function ($a, $b) {
            $dateA = new DateTime($a->pexs_date);
            $dateB = new DateTime($b->pexs_date);
            return $dateB <=> $dateA; // จากมากไปน้อย
          });
        }
      }
    }
    return $groupedData;
  }
  public function view_profile($ps_id)
  {
    // $ps_id = decrypt_id($id);
    $ps_id  = decrypt_id($ps_id);
    $data['ps_info'] = $this->M_staff_profile->get_medical_profile(null, $ps_id)->row();
    $data['ps_education'] = $this->M_hr_person_education->get_all_person_education_data($ps_id)->result();
    $data['work_age'] = $this->get_work_age($ps_id);
    $data['ps_reward'] = $this->get_reward_list($ps_id);
    $data['ps_external'] = $this->get_external_service_list($ps_id);
    $this->output_frontend_staff('hr/frontend/v_profile', $data);
  }
}
