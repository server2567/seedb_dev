<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_QUE_Controller.php");
class Que_dashboard extends SEEDB_QUE_Controller
{
  public $que;
  public $que_db;
  public function __construct()
  {
    parent::__construct();
    // load model
    $this->load->model($this->config->item('hr_dir') . 'M_hr_person');
    $this->load->model($this->model . 'Que_dashboard_model');
    $this->que = $this->load->database('que', true);
    $this->que_db = $this->que->database;
  }

  public function index()
  {
    $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');;
    $data['view_dir'] = $this->view;
    $data['controller_dir'] = $this->controller;
    $data['ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
    $activities = $this->Que_dashboard_model->get_last_activity(8)->result_array();
    // Loop through the activity data and calculate the time difference
    foreach ($activities as &$activity) {
      if (!empty($activity['ntdp_time_start'])) {
        $ntdp_time_start = new DateTime($activity['ntdp_time_start']);
        $current_time = new DateTime();
        $interval = $current_time->diff($ntdp_time_start);

        // Calculate total minutes and hours
        $total_minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        $total_hours = floor($total_minutes / 60);

        // Determine how to display the time difference
        if ($total_hours >= 1) {
          $activity['time_difference'] = $total_hours . ' ชั่วโมง';
        } else {
          $activity['time_difference'] = $total_minutes . ' นาที';
        }
      } else {
        $activity['time_difference'] = 'No Start Time';
      }
    }
    

    // Assign the modified activities to the data array
    $data['activity'] = $activities;
    $currentYear = date("Y");
    $adjustedYears = [];
    for ($i = 0; $i <= 4; $i++) {
      $adjustedYear = ($currentYear - $i) + 543;
      $adjustedYears[] = $adjustedYear;
    }
    $data['default_year_list'] = $adjustedYears;
    $this->output($this->view . 'v_seedb_que', $data);
  }



  public function fetch_data()
  {
    $type = $this->input->get('type');
    $value = $this->input->get('value');
    $department = $this->input->get('department');

    // Initialize response data
    $response = [
      'que_c1' => ['total' => 0, 'new' => 0, 'old' => 0],
      'que_c2' => ['total' => 0, 'new' => 0, 'old' => 0],
      'que_c3' => ['total' => 0, 'new' => 0, 'old' => 0],
    ];

    if ($type === 'day') {
      $date = $value; // The selected date

      // [QUE-C1] ลงทะเบียนผู้ป่วย
      $subquery = $this->que->select('
                COUNT(*) as total,
                SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
                SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
            ')
      ->from('que_appointment')
      ->where('DATE(apm_date)', $date)
      ->where('apm_dp_id' , $department)
        ->group_by('apm_visit')
        ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
      ->from("($subquery) as subquery")
      ->get();
      // echo $this->que->last_query();
      $result = $query->row_array();

      if ($result) {
        $response['que_c1']['total'] = $result['total'] ?? 0;
        $response['que_c1']['new'] = $result['new_count'] ?? 0;
        $response['que_c1']['old'] = $result['old_count'] ?? 0;
      }

      // Repeat similar logic for [QUE-C2] and [QUE-C3]...

      // [QUE-C2] แบบ Walk In
      $subquery = $this->que->select('
                COUNT(*) as total,
                SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
                SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
            ')
      ->from('que_appointment')
      ->where('apm_app_walk', 'W') // Assuming 'W' is for Walk-In
      ->where('DATE(apm_date)', $date)
      ->where('apm_dp_id' , $department)
        ->group_by('apm_visit')
        ->get_compiled_select();

      $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
      ->from("($subquery) as subquery")
      ->get();

      $result = $query->row_array();

      if ($result) {
        $response['que_c2']['total'] = $result['total'] ?? 0;
        $response['que_c2']['new'] = $result['new_count'] ?? 0;
        $response['que_c2']['old'] = $result['old_count'] ?? 0;
      }

      // [QUE-C3] แบบนัดล่วงหน้า
      $subquery = $this->que->select('
                COUNT(*) as total,
                SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
                SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
            ')
      ->from('que_appointment')
      ->where('apm_app_walk', 'A') // Assuming 'A' is for Appointment
      ->where('DATE(apm_date)', $date)
      ->where('apm_dp_id' , $department)
        ->group_by('apm_visit')
        ->get_compiled_select();

      $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
      ->from("($subquery) as subquery")
      ->get();

      $result = $query->row_array();

      if ($result) {
        $response['que_c3']['total'] = $result['total'] ?? 0;
        $response['que_c3']['new'] = $result['new_count'] ?? 0;
        $response['que_c3']['old'] = $result['old_count'] ?? 0;
      }
      $query = $this->db->query("
        SELECT 
            ps_id,
            ps_name,
            IFNULL(ps_id_count_old, 0) as ps_id_count_old,
            IFNULL(ps_id_count_new, 0) as ps_id_count_new,
            CAST((IFNULL(ps_id_count_old, 0) + IFNULL(ps_id_count_new, 0)) AS UNSIGNED) as total_count
        FROM (
            SELECT 
                hr_person.ps_id,
                CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name,
                COUNT(CASE WHEN que_appointment.apm_patient_type = 'old' THEN que_appointment.apm_ps_id END) AS ps_id_count_old,
                COUNT(CASE WHEN que_appointment.apm_patient_type = 'new' THEN que_appointment.apm_ps_id END) AS ps_id_count_new
            FROM 
                hr_person
            LEFT JOIN 
                see_hrdb.hr_base_prefix 
                ON hr_person.ps_pf_id = hr_base_prefix.pf_id
            LEFT JOIN 
                see_quedb.que_appointment 
                ON que_appointment.apm_ps_id = hr_person.ps_id
            WHERE 
                DATE(que_appointment.apm_date) = '$date' AND que_appointment.apm_dp_id = '$department'
            GROUP BY 
                hr_person.ps_id, ps_name
        ) as subquery
        ORDER BY total_count DESC
      ");
      $result = $query->result_array();
      if ($result) {
        $total_old = 0;
        $total_new = 0;
          foreach ($result as $row) {
              $response['person'][$row['ps_id']] = [
                  'ps_name' => $row['ps_name'],
                  'count_old' => (int) $row['ps_id_count_old'], // Ensure numeric type
                  'count_new' => (int) $row['ps_id_count_new'], // Ensure numeric type
                  'total_count' => (int) $row['total_count'] 
              ];
              $total_old += (int) $row['ps_id_count_old'];
              $total_new += (int) $row['ps_id_count_new'];
          }
          $response['total_old'] = $total_old;
          $response['total_new'] = $total_new;
      } else {
          $response['person'][0] = ['ps_name' => "ไม่พบข้อมูลการนัดพบแพทย์", 'count_old' => 0,'count_new' => 0, 'total_count' => 0];
          $response['total_old'] = 0;
          $response['total_new'] = 0;
      }
      $query = $this->db->query("
          SELECT 
              hr_structure_detail.stde_name_th,
              COUNT(*) AS total_count
          FROM 
              see_quedb.que_appointment
          LEFT JOIN 
              see_hrdb.hr_structure_detail 
          ON 
              que_appointment.apm_stde_id = hr_structure_detail.stde_id
          WHERE 
              que_appointment.apm_date = '$date' AND que_appointment.apm_dp_id = '$department'
          GROUP BY 
              hr_structure_detail.stde_name_th  
          ORDER BY `total_count` DESC
      ");
      $result = $query->result_array();
      
      if ($result) {
        
          foreach ($result as $row) {
              $response['stde'][$row['stde_name_th']] = [
                  'stde_name_th' => $row['stde_name_th'] ? $row['stde_name_th'] : 'ไม่พบรายการแผนก',
                  'total_count' => (int) $row['total_count']
              ];
              
          }
         
      } else {
          $response['stde']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
          
      }
      $query = $this->db->query("SELECT 
            time_ranges.time_range,
            COALESCE(SUM(CASE WHEN que_appointment.apm_time IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_count,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'old' THEN 1 ELSE 0 END), 0) AS total_count_old,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'new' THEN 1 ELSE 0 END), 0) AS total_count_new,
            COALESCE(SUM(CASE WHEN que_appointment.apm_app_walk = 'W' THEN 1 ELSE 0 END), 0) AS total_count_walk
        FROM (
            SELECT '08:00-08:59' AS time_range
            UNION ALL
            SELECT '09:00-09:59'
            UNION ALL
            SELECT '10:00-10:59'
            UNION ALL
            SELECT '11:00-11:59'
            UNION ALL
            SELECT '12:00-12:59'
            UNION ALL
            SELECT '13:00-13:59'
            UNION ALL
            SELECT '14:00-14:59'
            UNION ALL
            SELECT '15:00-15:59'
            UNION ALL
            SELECT '16:00-16:59'
            UNION ALL
            SELECT '17:00-17:59'
            UNION ALL
            SELECT '18:00-18:59'
            UNION ALL
            SELECT '19:00-20:00'
        ) AS time_ranges
        LEFT JOIN see_quedb.que_appointment
            ON (apm_time >= CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '08:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '10:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '11:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '12:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '13:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '14:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '15:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '16:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '17:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '18:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND apm_time < CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '10:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '11:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '12:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '13:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '14:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '15:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '16:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '17:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '18:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '19:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND que_appointment.apm_date = '$date'
            AND que_appointment.apm_dp_id = '$department')
        GROUP BY time_ranges.time_range  
        ORDER BY `time_ranges`.`time_range` ASC;
        ");
        $result = $query->result_array();
      
        if ($result) {
          
            foreach ($result as $row) {
                $response['time_range'][$row['time_range']] = [
                    'time_range' => $row['time_range'],
                    'total_count' => (int) $row['total_count'],
                    'total_count_old' => (int) $row['total_count_old'],
                    'total_count_new' => (int) $row['total_count_new'],
                    'total_count_walk' => (int) $row['total_count_walk']
                ];
                
            }
           
        } else {
            $response['time_range']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
            
        }
        $query = $this->db->query(
                "SELECT see_wtsdb.wts_notifications_department.*,
		            que_appointment.apm_id,
                    CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                    wts_location.loc_name 
                FROM see_wtsdb.wts_notifications_department
                LEFT JOIN see_quedb.que_appointment ON ntdp_apm_id = apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id
                LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id
                WHERE ntdp_date_start = '$date' AND que_appointment.apm_dp_id =  '$department'
                ORDER BY ntdp_id DESC
                LIMIT 8 ");
        $result = $query->result_array();
        
        if($result){
            foreach ($result as $row){
                
                $ntdp_time_start = new DateTime($row['ntdp_time_start']);
                $ntdp_date_start = new DateTime($row['ntdp_date_start']);
                $current_time = new DateTime();
            
                // Calculate the difference in days
                $date_interval = $current_time->diff($ntdp_date_start);
                $total_days = $date_interval->days;
                
                // Calculate the difference in hours
                $time_interval = $current_time->diff($ntdp_time_start);
                $total_minutes = $time_interval->days * 24 * 60 + $time_interval->h * 60 + $time_interval->i;
                $total_hours = floor($total_minutes / 60);
            
                if ($total_days >= 1) {
                    // If the difference is in days
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_days . ' วัน'
                    ];
                } elseif ($total_hours >= 1) {
                    // If the difference is in hours
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_hours . ' ชั่วโมง'
                    ];
                } else {
                    // If the difference is in minutes
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_minutes . ' นาที'
                    ];
                }
            }
        } else {
            $response['activity'][] = [
                'pt_name' => 'ไม่พบข้อมูล',
                'loc_name' => 'กิจกรรม',
                'time_difference' => ' 0นาที'
            ];
        }

    } elseif ($type === 'week') {
      // Calculate the start and end dates of the selected week
      $year = date('Y'); // Adjust if needed for a different year
      $week = intval($value);

      $dto = new DateTime();
      $dto->setISODate($year, $week);
      $startOfWeek = $dto->format('Y-m-d');
      $dto->modify('+6 days');
      $endOfWeek = $dto->format('Y-m-d');

        // [QUE-C1] ลงทะเบียนผู้ป่วย
        $subquery = $this->que->select('
              COUNT(*) as total,
              SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
              SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
          ')
          ->from('que_appointment')
          ->where('DATE(apm_date) >=', $startOfWeek)
          ->where('DATE(apm_date) <=', $endOfWeek)
          ->where('apm_dp_id' , $department)
          ->group_by('apm_visit')
          ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
            ->from("($subquery) as subquery")
            ->get();
        $result = $query->row_array();
      
      if ($result) {
          $response['que_c1']['total'] = $result['total'] ?? 0;
          $response['que_c1']['new'] = $result['new_count'] ?? 0;
          $response['que_c1']['old'] = $result['old_count'] ?? 0;
      }

      // Repeat similar queries for [QUE-C2] and [QUE-C3]...
      // Example for [QUE-C2] แบบ Walk In
      $subquery = $this->que->select('
        COUNT(*) as total,
        SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
        SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
        ')
        ->from('que_appointment')
        ->where('apm_app_walk', 'W')
        ->where('DATE(apm_date) >=', $startOfWeek)
        ->where('DATE(apm_date) <=', $endOfWeek)
        ->where('apm_dp_id' , $department)
        ->group_by('apm_visit')
        ->get_compiled_select();

      $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
        ')
        ->from("($subquery) as subquery")
        ->get();

      $result = $query->row_array();

      if ($result) {
          $response['que_c2']['total'] = $result['total'] ?? 0;
          $response['que_c2']['new'] = $result['new_count'] ?? 0;
          $response['que_c2']['old'] = $result['old_count'] ?? 0;
      }

        // Repeat similar logic for [QUE-C3] แบบนัดล่วงหน้า
        $subquery = $this->que->select('
                    COUNT(*) as total,
                    SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
                    SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
                ')
                ->from('que_appointment')
                ->where('apm_app_walk', 'A')
                ->where('DATE(apm_date) >=', $startOfWeek)
                ->where('DATE(apm_date) <=', $endOfWeek)
                ->where('apm_dp_id' , $department)
                ->group_by('apm_visit')
                ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
                ')
                ->from("($subquery) as subquery")
                ->get();

        $result = $query->row_array();

        if ($result) {
            $response['que_c3']['total'] = $result['total'] ?? 0;
            $response['que_c3']['new'] = $result['new_count'] ?? 0;
            $response['que_c3']['old'] = $result['old_count'] ?? 0;
        }
        $query = $this->db->query("
          SELECT 
              ps_id,
              ps_name,
              IFNULL(ps_id_count_old, 0) as ps_id_count_old,
              IFNULL(ps_id_count_new, 0) as ps_id_count_new,
              CAST((IFNULL(ps_id_count_old, 0) + IFNULL(ps_id_count_new, 0)) AS UNSIGNED) as total_count
          FROM (
              SELECT 
                  hr_person.ps_id,
                  CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name,
                  COUNT(CASE WHEN que_appointment.apm_patient_type = 'old' THEN que_appointment.apm_ps_id END) AS ps_id_count_old,
                  COUNT(CASE WHEN que_appointment.apm_patient_type = 'new' THEN que_appointment.apm_ps_id END) AS ps_id_count_new
              FROM 
                  hr_person
              LEFT JOIN 
                  see_hrdb.hr_base_prefix 
                  ON hr_person.ps_pf_id = hr_base_prefix.pf_id
              LEFT JOIN 
                  see_quedb.que_appointment 
                  ON que_appointment.apm_ps_id = hr_person.ps_id
              WHERE 
                  DATE(que_appointment.apm_date) >= '$startOfWeek' AND DATE(que_appointment.apm_date) <= '$endOfWeek' AND que_appointment.apm_dp_id = '$department'
              GROUP BY 
                  hr_person.ps_id, ps_name
          ) as subquery
          ORDER BY total_count DESC
      ");
      $result = $query->result_array();
      if ($result) {
        $total_old = 0;
        $total_new = 0;
          foreach ($result as $row) {
              $response['person'][$row['ps_id']] = [
                  'ps_name' => $row['ps_name'],
                  'count_old' => (int) $row['ps_id_count_old'], // Ensure numeric type
                  'count_new' => (int) $row['ps_id_count_new'], // Ensure numeric type
                  'total_count' => (int) $row['total_count'] 
              ];
              $total_old += (int) $row['ps_id_count_old'];
              $total_new += (int) $row['ps_id_count_new'];
          }
          $response['total_old'] = $total_old;
          $response['total_new'] = $total_new;
      } else {
        $response['person'][0] = ['ps_name' => "ไม่พบข้อมูลการนัดพบแพทย์", 'count_old' => 0,'count_new' => 0, 'total_count' => 0];
        $response['total_old'] = 0;
        $response['total_new'] = 0;
      }
      $query = $this->db->query("
          SELECT 
              hr_structure_detail.stde_name_th,
              COUNT(*) AS total_count
          FROM 
              see_quedb.que_appointment
          LEFT JOIN 
              see_hrdb.hr_structure_detail 
          ON 
              que_appointment.apm_stde_id = hr_structure_detail.stde_id
          WHERE 
              que_appointment.apm_date >= '$startOfWeek' AND que_appointment.apm_date <= '$endOfWeek' AND que_appointment.apm_dp_id = '$department'
          GROUP BY 
              hr_structure_detail.stde_name_th  
          ORDER BY `total_count` DESC
      ");
      $result = $query->result_array();
      
      if ($result) {
        
          foreach ($result as $row) {
              $response['stde'][$row['stde_name_th']] = [
                  'stde_name_th' => $row['stde_name_th'] ? $row['stde_name_th'] : 'ไม่พบรายการลงทะเบียนผู้ป่วย',
                  'total_count' => (int) $row['total_count']
              ];
              
          }
         
      } else {
        $response['stde']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
          
      }
      $query = $this->db->query("
        SELECT 
            time_ranges.time_range,
            COALESCE(SUM(CASE WHEN que_appointment.apm_time IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_count,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'old' THEN 1 ELSE 0 END), 0) AS total_count_old,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'new' THEN 1 ELSE 0 END), 0) AS total_count_new,
            COALESCE(SUM(CASE WHEN que_appointment.apm_app_walk = 'W' THEN 1 ELSE 0 END), 0) AS total_count_walk
        FROM (
            SELECT '08:00-08:59' AS time_range
            UNION ALL
            SELECT '09:00-09:59'
            UNION ALL
            SELECT '10:00-10:59'
            UNION ALL
            SELECT '11:00-11:59'
            UNION ALL
            SELECT '12:00-12:59'
            UNION ALL
            SELECT '13:00-13:59'
            UNION ALL
            SELECT '14:00-14:59'
            UNION ALL
            SELECT '15:00-15:59'
            UNION ALL
            SELECT '16:00-16:59'
            UNION ALL
            SELECT '17:00-17:59'
            UNION ALL
            SELECT '18:00-18:59'
            UNION ALL
            SELECT '19:00-20:00'
        ) AS time_ranges
        LEFT JOIN see_quedb.que_appointment
            ON (apm_time >= CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '08:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '10:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '11:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '12:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '13:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '14:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '15:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '16:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '17:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '18:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND apm_time < CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '10:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '11:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '12:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '13:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '14:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '15:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '16:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '17:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '18:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '19:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND que_appointment.apm_date >= '$startOfWeek' AND que_appointment.apm_date <= '$endOfWeek' AND que_appointment.apm_dp_id = '$department' )
        GROUP BY time_ranges.time_range  
        ORDER BY `time_ranges`.`time_range` ASC;
        ");
        $result = $query->result_array();
      
        if ($result) {
          
            foreach ($result as $row) {
                $response['time_range'][$row['time_range']] = [
                    'time_range' => $row['time_range'],
                    'total_count' => (int) $row['total_count'],
                    'total_count_old' => (int) $row['total_count_old'],
                    'total_count_new' => (int) $row['total_count_new'],
                    'total_count_walk' => (int) $row['total_count_walk']
                ];
                
            }
           
        } else {
            $response['time_range']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
            
        }
            $query = $this->db->query(
                "SELECT see_wtsdb.wts_notifications_department.*,
                    que_appointment.apm_id,
                    CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                    wts_location.loc_name 
                FROM see_wtsdb.wts_notifications_department
                LEFT JOIN see_quedb.que_appointment ON ntdp_apm_id = apm_id
                LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id
                LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id
                WHERE ntdp_date_start >= '$startOfWeek' AND ntdp_date_start <='$endOfWeek' AND que_appointment.apm_dp_id = '$department'
                ORDER BY ntdp_id DESC
                LIMIT 8 ");
        $result = $query->result_array();
        
        if($result){
            foreach ($result as $row){
                
                $ntdp_time_start = new DateTime($row['ntdp_time_start']);
                $ntdp_date_start = new DateTime($row['ntdp_date_start']);
                $current_time = new DateTime();
            
                // Calculate the difference in days
                $date_interval = $current_time->diff($ntdp_date_start);
                $total_days = $date_interval->days;
                
                // Calculate the difference in hours
                $time_interval = $current_time->diff($ntdp_time_start);
                $total_minutes = $time_interval->days * 24 * 60 + $time_interval->h * 60 + $time_interval->i;
                $total_hours = floor($total_minutes / 60);
            
                if ($total_days >= 1) {
                    // If the difference is in days
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_days . ' วัน'
                    ];
                } elseif ($total_hours >= 1) {
                    // If the difference is in hours
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_hours . ' ชั่วโมง'
                    ];
                } else {
                    // If the difference is in minutes
                    $response['activity'][] = [
                        'pt_name' => $row['pt_name'],
                        'loc_name' => $row['loc_name'],
                        'time_difference' => $total_minutes . ' นาที'
                    ];
                }
            }
        } else {
            $response['activity'][] = [
                'pt_name' => 'ไม่พบข้อมูล',
                'loc_name' => 'กิจกรรม',
                'time_difference' => ' 0นาที'
            ];
        }
      } elseif ($type === 'month') {
        $yearMonth = explode('-', $value);
        $year = intval($yearMonth[0]);
        $month = intval($yearMonth[1]);

        // Calculate the start and end dates of the selected month
        $startOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
        $endOfMonth = date('Y-m-t', strtotime("$year-$month-01"));

        // [QUE-C1] ลงทะเบียนผู้ป่วย
        $subquery = $this->que->select('
              COUNT(*) as total,
              SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
              SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
          ')
          ->from('que_appointment')
          ->where('DATE(apm_date) >=', $startOfMonth)
          ->where('DATE(apm_date) <=', $endOfMonth)
          ->where('apm_dp_id' , $department)
          ->group_by('apm_visit')
          ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
            ->from("($subquery) as subquery")
            ->get();
        $result = $query->row_array();

        if ($result) {
            $response['que_c1']['total'] = $result['total'] ?? 0;
            $response['que_c1']['new'] = $result['new_count'] ?? 0;
            $response['que_c1']['old'] = $result['old_count'] ?? 0;
        }

        // Repeat similar queries for [QUE-C2] and [QUE-C3]...

        // Example for [QUE-C2] แบบ Walk In
        $subquery = $this->que->select('
            COUNT(*) as total,
            SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
            SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
            ')
            ->from('que_appointment')
            ->where('apm_app_walk', 'W')
            ->where('DATE(apm_date) >=', $startOfMonth)
            ->where('DATE(apm_date) <=', $endOfMonth)
            ->where('apm_dp_id' , $department)
            ->group_by('apm_visit')
            ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
            ')
            ->from("($subquery) as subquery")
            ->get();

        $result = $query->row_array();

        if ($result) {
            $response['que_c2']['total'] = $result['total'] ?? 0;
            $response['que_c2']['new'] = $result['new_count'] ?? 0;
            $response['que_c2']['old'] = $result['old_count'] ?? 0;
        }

        // [QUE-C3] แบบนัดล่วงหน้า
        $subquery = $this->que->select('
                    COUNT(*) as total,
                    SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count,
                    SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count
                ')
                ->from('que_appointment')
                ->where('apm_app_walk', 'A')
                ->where('DATE(apm_date) >=', $startOfMonth)
                ->where('DATE(apm_date) <=', $endOfMonth)
                ->where('apm_dp_id' , $department)
                ->group_by('apm_visit')
                ->get_compiled_select();

        $query = $this->que->select('
                SUM(IFNULL(total, 0)) as total,
                SUM(IFNULL(new_count, 0)) as new_count,
                SUM(IFNULL(old_count, 0)) as old_count
                ')
                ->from("($subquery) as subquery")
                ->get();

        $result = $query->row_array();

        if ($result) {
            $response['que_c3']['total'] = $result['total'] ?? 0;
            $response['que_c3']['new'] = $result['new_count'] ?? 0;
            $response['que_c3']['old'] = $result['old_count'] ?? 0;
        }
        
        $query = $this->db->query("
          SELECT 
              ps_id,
              ps_name,
              IFNULL(ps_id_count_old, 0) as ps_id_count_old,
              IFNULL(ps_id_count_new, 0) as ps_id_count_new,
              CAST((IFNULL(ps_id_count_old, 0) + IFNULL(ps_id_count_new, 0)) AS UNSIGNED) as total_count
          FROM (
              SELECT 
                  hr_person.ps_id,
                  CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name,
                  COUNT(CASE WHEN que_appointment.apm_patient_type = 'old' THEN que_appointment.apm_ps_id END) AS ps_id_count_old,
                  COUNT(CASE WHEN que_appointment.apm_patient_type = 'new' THEN que_appointment.apm_ps_id END) AS ps_id_count_new
              FROM 
                  hr_person
              LEFT JOIN 
                  see_hrdb.hr_base_prefix 
                  ON hr_person.ps_pf_id = hr_base_prefix.pf_id
              LEFT JOIN 
                  see_quedb.que_appointment 
                  ON que_appointment.apm_ps_id = hr_person.ps_id
              WHERE 
                  DATE(que_appointment.apm_date) >= '$startOfMonth' AND DATE(que_appointment.apm_date) <= '$endOfMonth' AND que_appointment.apm_dp_id = '$department'
              GROUP BY 
                  hr_person.ps_id, ps_name
          ) as subquery
          ORDER BY total_count DESC
      ");
      $result = $query->result_array();
      if ($result) {
        $total_old = 0;
        $total_new = 0;
          foreach ($result as $row) {
              $response['person'][$row['ps_id']] = [
                  'ps_name' => $row['ps_name'],
                  'count_old' => (int) $row['ps_id_count_old'], // Ensure numeric type
                  'count_new' => (int) $row['ps_id_count_new'], // Ensure numeric type
                  'total_count' => (int) $row['total_count'] 
              ];
              $total_old += (int) $row['ps_id_count_old'];
              $total_new += (int) $row['ps_id_count_new'];
          }
          $response['total_old'] = $total_old;
          $response['total_new'] = $total_new;
      } else {
        $response['person'][0] = ['ps_name' => "ไม่พบข้อมูลการนัดพบแพทย์", 'count_old' => 0,'count_new' => 0, 'total_count' => 0];
        $response['total_old'] = 0;
        $response['total_new'] = 0;
      }
      $query = $this->db->query("
          SELECT 
              hr_structure_detail.stde_name_th,
              hr_structure_detail.stde_id,
              COUNT(*) AS total_count
          FROM 
              see_quedb.que_appointment
          LEFT JOIN 
              see_hrdb.hr_structure_detail 
          ON 
              que_appointment.apm_stde_id = hr_structure_detail.stde_id
          WHERE 
              que_appointment.apm_date >= '$startOfMonth' AND que_appointment.apm_date <= '$endOfMonth' AND que_appointment.apm_dp_id = '$department'
          GROUP BY 
              hr_structure_detail.stde_name_th  
          ORDER BY `total_count` DESC
      ");
      $result = $query->result_array();
      
      if ($result) {
        
          foreach ($result as $row) {
              $response['stde'][$row['stde_id']] = [
                  'stde_name_th' => $row['stde_name_th'] ? $row['stde_name_th'] : 'ไม่พบรายการแผนก',
                  'total_count' => (int) $row['total_count']
              ];
              
          }
         
      } else {
        $response['stde']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
          
      }
      $query = $this->db->query("
        SELECT 
            time_ranges.time_range,
            COALESCE(SUM(CASE WHEN que_appointment.apm_time IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_count,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'old' THEN 1 ELSE 0 END), 0) AS total_count_old,
            COALESCE(SUM(CASE WHEN que_appointment.apm_patient_type = 'new' THEN 1 ELSE 0 END), 0) AS total_count_new,
            COALESCE(SUM(CASE WHEN que_appointment.apm_app_walk = 'W' THEN 1 ELSE 0 END), 0) AS total_count_walk
        FROM (
            SELECT '08:00-08:59' AS time_range
            UNION ALL
            SELECT '09:00-09:59'
            UNION ALL
            SELECT '10:00-10:59'
            UNION ALL
            SELECT '11:00-11:59'
            UNION ALL
            SELECT '12:00-12:59'
            UNION ALL
            SELECT '13:00-13:59'
            UNION ALL
            SELECT '14:00-14:59'
            UNION ALL
            SELECT '15:00-15:59'
            UNION ALL
            SELECT '16:00-16:59'
            UNION ALL
            SELECT '17:00-17:59'
            UNION ALL
            SELECT '18:00-18:59'
            UNION ALL
            SELECT '19:00-20:00'
        ) AS time_ranges
        LEFT JOIN see_quedb.que_appointment
            ON (apm_time >= CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '08:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '10:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '11:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '12:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '13:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '14:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '15:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '16:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '17:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '18:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND apm_time < CASE 
                    WHEN time_ranges.time_range = '08:00-08:59' THEN '09:00' 
                    WHEN time_ranges.time_range = '09:00-09:59' THEN '10:00' 
                    WHEN time_ranges.time_range = '10:00-10:59' THEN '11:00'
                    WHEN time_ranges.time_range = '11:00-11:59' THEN '12:00'
                    WHEN time_ranges.time_range = '12:00-12:59' THEN '13:00'
                    WHEN time_ranges.time_range = '13:00-13:59' THEN '14:00'
                    WHEN time_ranges.time_range = '14:00-14:59' THEN '15:00'
                    WHEN time_ranges.time_range = '15:00-15:59' THEN '16:00'
                    WHEN time_ranges.time_range = '16:00-16:59' THEN '17:00'
                    WHEN time_ranges.time_range = '17:00-17:59' THEN '18:00'
                    WHEN time_ranges.time_range = '18:00-18:59' THEN '19:00'
                    WHEN time_ranges.time_range = '19:00-20:00' THEN '19:00'
                END
            AND que_appointment.apm_date >= '$startOfMonth' AND que_appointment.apm_date <= '$endOfMonth' AND que_appointment.apm_dp_id = '$department' )
        GROUP BY time_ranges.time_range  
        ORDER BY `time_ranges`.`time_range` ASC;
        ");
        $result = $query->result_array();
      
        if ($result) {
          
            foreach ($result as $row) {
                $response['time_range'][$row['time_range']] = [
                    'time_range' => $row['time_range'],
                    'total_count' => (int) $row['total_count'],
                    'total_count_old' => (int) $row['total_count_old'],
                    'total_count_new' => (int) $row['total_count_new'],
                    'total_count_walk' => (int) $row['total_count_walk']
                ];
                
            }
           
        } else {
            $response['time_range']['ไม่มีข้อมูลการลงทะเบียน'] = ['stde_name_th' => 'ไม่พบข้อมูลการลงทะเบียน' , 'total_count' => 0];
            
        }
        $query = $this->db->query(
            "SELECT see_wtsdb.wts_notifications_department.*,
                que_appointment.apm_id,
                CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
                wts_location.loc_name 
            FROM see_wtsdb.wts_notifications_department
            LEFT JOIN see_quedb.que_appointment ON ntdp_apm_id = apm_id
            LEFT JOIN see_umsdb.ums_patient ON see_quedb.que_appointment.apm_pt_id = ums_patient.pt_id
            LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id
            WHERE ntdp_date_start >= '$startOfMonth' AND ntdp_date_start <='$endOfMonth' AND que_appointment.apm_dp_id = '$department'
            ORDER BY ntdp_id DESC
            LIMIT 8 ");
    $result = $query->result_array();
    
    if($result){
        foreach ($result as $row){
            
            $ntdp_time_start = new DateTime($row['ntdp_time_start']);
            $ntdp_date_start = new DateTime($row['ntdp_date_start']);
            $current_time = new DateTime();
        
            // Calculate the difference in days
            $date_interval = $current_time->diff($ntdp_date_start);
            $total_days = $date_interval->days;
            
            // Calculate the difference in hours
            $time_interval = $current_time->diff($ntdp_time_start);
            $total_minutes = $time_interval->days * 24 * 60 + $time_interval->h * 60 + $time_interval->i;
            $total_hours = floor($total_minutes / 60);
        
            if ($total_days >= 1) {
                // If the difference is in days
                $response['activity'][] = [
                    'pt_name' => $row['pt_name'],
                    'loc_name' => $row['loc_name'],
                    'time_difference' => $total_days . ' วัน'
                ];
            } elseif ($total_hours >= 1) {
                // If the difference is in hours
                $response['activity'][] = [
                    'pt_name' => $row['pt_name'],
                    'loc_name' => $row['loc_name'],
                    'time_difference' => $total_hours . ' ชั่วโมง'
                ];
            } else {
                // If the difference is in minutes
                $response['activity'][] = [
                    'pt_name' => $row['pt_name'],
                    'loc_name' => $row['loc_name'],
                    'time_difference' => $total_minutes . ' นาที'
                ];
            }
        }
    } else {
        $response['activity'][] = [
            'pt_name' => 'ไม่พบข้อมูล',
            'loc_name' => 'กิจกรรม',
            'time_difference' => ' 0นาที'
        ];
    }
        
    }

    // Get the current time
    $currentTime = new DateTime();
    $currentHour = $currentTime->format('H');
    
    if ($type == 'day' && $value == $currentTime->format('Y-m-d')) {
        // Generate time_range up to the current hour
        $categories = [];
        for ($hour = 8; $hour <= $currentHour; $hour++) {
            $start = sprintf('%02d.00', $hour);
            $end = sprintf('%02d.59', $hour);
            $categories[] = "$start-$end";
        }
    } else {
        // Default time_range
        $categories = [
            '8.00-8.59', '9.00-9.59', '10.00-10.59', '11.00-11.59',
            '12.00-12.59', '13.00-13.59', '14.00-14.59', '15.00-15.59',
            '16.00-16.59', '17.00-17.59', '18.00-18.59', '19.00-20.00'
        ];
    }
    $response['categories'] = $categories;
    // Return the response as JSON
    echo json_encode($response);
  }
  public function getModal() {
    // Sample column data (you can customize this based on the table you want to show)
    $columns = [
        ['data' => 'row'],
        ['data' => 'pt_member'],
        ['data' => 'apm_visit'],
        ['data' => 'apm_ql_code'],
        ['data' => 'pt_name'],
        ['data' => 'apm_date'],
        ['data' => 'apm_time'],
        ['data' => 'stde_name_th'],
        ['data' => 'ps_name'],
    ];
    

    // Send the dynamic title, body, footer, and column structure to the view
    $json['title'] = 'รายละเอียดผู้ป่วยลงทะเบียน';
    $json['body'] =  $this->load->view($this->view .'v_seedb_que_modal', '', true);
    $json['footer'] = ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>';
    $json['columns'] = $columns;

    echo json_encode($json);
}
public function getModal_T1() {
    // Sample column data (you can customize this based on the table you want to show)
    $columns = [
        ['data' => 'row'],
        ['data' => 'pt_member'],
        ['data' => 'apm_visit'],
        ['data' => 'pt_name'],
        ['data' => 'apm_date'],
        ['data' => 'stde_name_th'],
        ['data' => 'ps_name'],
        ['data' => 'loc_name'],
    
    ];


    // Send the dynamic title, body, footer, and column structure to the view
    $json['title'] = 'รายละเอียดเส้นทางกิจกรรมผู้ป่วย';
    $json['body'] =  $this->load->view($this->view .'v_seedb_que_modal_T1', '', true);
    $json['footer'] = ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>';
    $json['columns'] = $columns;

    echo json_encode($json);
}
public function getModal_G1() {
    // Sample column data (you can customize this based on the table you want to show)
    $columns = [
        ['data' => 'row'],
        ['data' => 'pt_member'],
        ['data' => 'apm_visit'],
        ['data' => 'pt_name'],
        ['data' => 'apm_date'],
        ['data' => 'apm_time'],
        ['data' => 'stde_name_th'],
        ['data' => 'ps_name']
        
    ];


    // Send the dynamic title, body, footer, and column structure to the view
    $json['title'] = 'รายละเอียดเวลาการลงทะเบียนผู้ป่วย';
    $json['body'] =  $this->load->view($this->view .'v_seedb_que_modal_G1', '', true);
    $json['footer'] = ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>';
    $json['columns'] = $columns;

    echo json_encode($json);
}
public function getModal_G2() {
    
    // Sample column data (you can customize this based on the table you want to show)
    $columns = [
        ['data' => 'row'],
        ['data' => 'pt_member'],
        ['data' => 'apm_visit'],
        ['data' => 'pt_name'],
        ['data' => 'apm_date'],
        ['data' => 'ps_name'],
        ['data' => 'loc8_ntdp_time_start'],
        ['data' => 'loc8_ntdp_time_finish'],
        ['data' => 'loc8_ntdp_time_total']
    ];

    
    // Send the dynamic title, body, footer, and column structure to the view
    $json['title'] = 'รายละเอียดจำนวนการนัดพบแพทย์';
    $json['body'] =  $this->load->view($this->view .'v_seedb_que_modal_G2', '', true);
    $json['footer'] = ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>';
    $json['columns'] = $columns;

    echo json_encode($json);
}
public function getModal_G3() {
    // Sample column data (you can customize this based on the table you want to show)
    $columns = [
        ['data' => 'row'],
        ['data' => 'pt_member'],
        ['data' => 'apm_visit'],
        ['data' => 'pt_name'],
        ['data' => 'apm_date'],
        ['data' => 'loc6_ntdp_time_start'],
        ['data' => 'stde_name_th'],
        ['data' => 'ps_name']
        
    ];


    // Send the dynamic title, body, footer, and column structure to the view
    $json['title'] = 'รายละเอียดการลงทะเบียนผู้ป่วย จำแนกตามแผนก';
    $json['body'] =  $this->load->view($this->view .'v_seedb_que_modal_G3', '', true);
    $json['footer'] = ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>';
    $json['columns'] = $columns;

    echo json_encode($json);
}
public function get_doctors(){
    $selectedDate = $this->input->Get('dateSelect');
    $type = $this->input->get('type');
    $where = "WHERE 1 ";
    if ($type==='day'){
        $where .= " AND que_appointment.apm_date = '$selectedDate' ";
    } else if ($type==='week'){
        $year = date('Y'); // Adjust if needed for a different year
      $week = intval($selectedDate);

      $dto = new DateTime();
      $dto->setISODate($year, $week);
      $startOfWeek = $dto->format('Y-m-d');
      $dto->modify('+6 days');
      $endOfWeek = $dto->format('Y-m-d');
        $where .= " AND DATE(que_appointment.apm_date) >= '$startOfWeek' AND DATE(que_appointment.apm_date) <= '$endOfWeek'";
    } else if ($type==='month'){
        $yearMonth = explode('-', $selectedDate);
        $year = intval($yearMonth[0]);
        $month = intval($yearMonth[1]);

        // Calculate the start and end dates of the selected month
        $startOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
        $endOfMonth = date('Y-m-t', strtotime("$year-$month-01"));
        $where .= "  AND DATE(que_appointment.apm_date) >= '$startOfMonth' AND DATE(que_appointment.apm_date) <= '$endOfMonth'";
    }
    $query = $this->db->query(" SELECT apm_ps_id  ,
    CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name
    FROM see_quedb.que_appointment 
     LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
    LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
     $where 
     GROUP BY apm_ps_id ; ");
    $result = $query->result_array();
    $doctor_list = [];
    foreach ($result as $doctor) {
        $doctor_list[] = [
            'ps_id' => $doctor['apm_ps_id'],
            'ps_name' => $doctor['ps_name']
        ];
    }
    
    // Send the JSON response
    echo json_encode($doctor_list);
}
public function get_data() {
    $selectedDate = $this->input->post('dateSelect');
    $type = $this->input->post('type');
    $department = $this->input->post('department');
    $stde_id = $this->input->post('stde_id');
    $ps_id = $this->input->post('ps_id');
    $data_columns = $this->input->post('columns');
    $start_time = $this->input->post('start_time');
    $end_time = $this->input->post('end_time');
    $apm_app_walk = $this->input->post('apm_app_walk');
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $search =$this->input->post('search[value]');
    $order_index = $this->input->post('order[0][column]');
    $order_dir = $this->input->post('order[0][dir]');
    $column = [];
    foreach ($data_columns as $columns){
        $column[] = $columns['data'];
    }
    $where = "WHERE 1 ";
    $order = "ORDER BY ";
    if($order_index == '0'){
        $order .= " que_appointment.apm_id "; 
    } else if ($order_index != null){
        $order .= " $column[$order_index] ";
    } else {
        $order .= " que_appointment.apm_id "; 
    }
    
    if ($apm_app_walk != NULL){
        $where .= " AND que_appointment.apm_app_walk = '$apm_app_walk' ";
    }
    if ($department != NULL){
        $where .= " AND que_appointment.apm_dp_id = '$department' ";
    }
    if ($stde_id != NULL){
        $where .= " AND que_appointment.apm_stde_id = '$stde_id' ";
    }
    if ($ps_id != NULL){
        $where .= " AND que_appointment.apm_ps_id = '$ps_id' ";
    }
    if ($start_time != NULL){
        $where .= " AND que_appointment.apm_time >= '$start_time' AND que_appointment.apm_time <= '$end_time' ";
    }
    if ($search != NULL){
        $where .= " AND (que_appointment.apm_visit LIKE '%$search%' 
                    OR que_appointment.apm_date LIKE '%$search%' 
                    OR que_appointment.apm_time LIKE '%$search%'
                    OR CONCAT(hr_base_prefix.pf_name, '', hr_person.ps_fname, ' ', hr_person.ps_lname) LIKE '%$search%'
                    OR CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) LIKE '%$search%' 
                    OR hr_structure_detail.stde_name_th  LIKE '%$search%'
                    OR ums_patient.pt_member  LIKE '%$search%' )  ";
    }
    if ($type==='day'){
        $where .= " AND que_appointment.apm_date = '$selectedDate' ";
    } else if ($type==='week'){
        $year = date('Y'); // Adjust if needed for a different year
      $week = intval($selectedDate);

      $dto = new DateTime();
      $dto->setISODate($year, $week);
      $startOfWeek = $dto->format('Y-m-d');
      $dto->modify('+6 days');
      $endOfWeek = $dto->format('Y-m-d');
        $where .= " AND DATE(que_appointment.apm_date) >= '$startOfWeek' AND DATE(que_appointment.apm_date) <= '$endOfWeek'";
    } else if ($type==='month'){
        $yearMonth = explode('-', $selectedDate);
        $year = intval($yearMonth[0]);
        $month = intval($yearMonth[1]);

        // Calculate the start and end dates of the selected month
        $startOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
        $endOfMonth = date('Y-m-t', strtotime("$year-$month-01"));
        $where .= "  AND DATE(que_appointment.apm_date) >= '$startOfMonth' AND DATE(que_appointment.apm_date) <= '$endOfMonth'";
    }
    $query = $this->db->query("
   SELECT 
    see_quedb.que_appointment.*,
    ums_patient.*, 
    ums_patient.pt_identification,
    ums_patient.pt_passport,
    ums_patient.pt_peregrine,
    ums_patient.pt_tel,
    ums_patient.pt_email,
    latest_ntdp.ntdp_id AS ntdp_id,  -- Latest ntdp_id
    latest_ntdp.ntdp_loc_Id AS ntdp_loc_Id,  -- Location for latest ntdp_id
    loc8_ntdp.ntdp_id AS ntdp_id,  -- Last ntdp_id where loc_id = 8
    loc8_ntdp.ntdp_loc_Id AS loc8_ntdp_loc_Id,  -- Location ID where loc_id = 8
    latest_loc.loc_name AS loc_name,  -- Location name for latest ntdp_id
    loc8_loc.loc_name AS loc8_loc_name,  -- Location name for last loc_id = 8
    loc8_ntdp.ntdp_time_start AS loc8_ntdp_time_start,
     loc6_ntdp.ntdp_time_start AS loc6_ntdp_time_start,
    loc8_ntdp.ntdp_time_end AS loc8_ntdp_time_end,
    loc8_ntdp.ntdp_time_finish AS loc8_ntdp_time_finish,
    loc8_ntdp.ntdp_time_end AS loc8_ntdp_time_end,
    CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
    CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name,
    hr_person.ps_id,
    ums_department.dp_name_th, 
    hr_structure_detail.stde_name_th
FROM 
    see_quedb.que_appointment
LEFT JOIN see_hrdb.hr_structure_detail 
    ON que_appointment.apm_stde_id = hr_structure_detail.stde_id
LEFT JOIN see_umsdb.ums_patient 
    ON que_appointment.apm_pt_id = ums_patient.pt_id
LEFT JOIN see_hrdb.hr_person 
    ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
LEFT JOIN see_hrdb.hr_base_prefix 
    ON hr_person.ps_pf_id = hr_base_prefix.pf_id
LEFT JOIN see_wtsdb.wts_base_disease 
    ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
LEFT JOIN see_umsdb.ums_department 
    ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id
-- Join to get the row with the latest ntdp_id
LEFT JOIN see_wtsdb.wts_notifications_department AS latest_ntdp 
    ON see_quedb.que_appointment.apm_id = latest_ntdp.ntdp_apm_id 
    AND latest_ntdp.ntdp_id = (
        SELECT MAX(ntdp_id) 
        FROM see_wtsdb.wts_notifications_department 
        WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
    )
LEFT JOIN see_wtsdb.wts_location AS latest_loc 
    ON latest_ntdp.ntdp_loc_Id = latest_loc.loc_id
-- Join to get the last row where ntdp_loc_Id = 8
LEFT JOIN see_wtsdb.wts_notifications_department AS loc8_ntdp 
    ON see_quedb.que_appointment.apm_id = loc8_ntdp.ntdp_apm_id 
    AND loc8_ntdp.ntdp_id = (
        SELECT MAX(ntdp_id)
        FROM see_wtsdb.wts_notifications_department 
        WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
        AND ntdp_loc_Id = 8
    )
LEFT JOIN see_wtsdb.wts_location AS loc8_loc 
    ON loc8_ntdp.ntdp_loc_Id = loc8_loc.loc_id
    LEFT JOIN see_wtsdb.wts_notifications_department AS loc6_ntdp 
    ON see_quedb.que_appointment.apm_id = loc6_ntdp.ntdp_apm_id 
    AND loc6_ntdp.ntdp_id = (
        SELECT MAX(ntdp_id)
        FROM see_wtsdb.wts_notifications_department 
        WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
        AND ntdp_loc_Id = 6
    )
LEFT JOIN see_wtsdb.wts_location AS loc6_loc 
    ON loc6_ntdp.ntdp_loc_Id = loc6_loc.loc_id
          $where 
          $order $order_dir
          LIMIT $start, $length;  
      ");
      $result = $query->result_array();
    // Fetch the data
    $total_result = $this->db->query("
    SELECT 
	    COUNT(*) as total
          FROM 
              see_quedb.que_appointment
          LEFT JOIN see_hrdb.hr_structure_detail ON que_appointment.apm_stde_id = hr_structure_detail.stde_id
    LEFT JOIN see_umsdb.ums_patient ON que_appointment.apm_pt_id = ums_patient.pt_id
    LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
    LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
    LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
    LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
    LEFT JOIN see_wtsdb.wts_notifications_department ON see_quedb.que_appointment.apm_id = wts_notifications_department.ntdp_apm_id AND wts_notifications_department.ntdp_id = (
      SELECT MAX(ntdp_id) 
      FROM see_wtsdb.wts_notifications_department 
      WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
  )
    LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id 
          $where
          
              ");
    $total = $total_result->row()->total;
    
    $data = array();
    foreach ($result as $key => $apm){
        $identification = '';
        if (!empty($apm['pt_identification'])) {
            $identification = $apm['pt_identification'];
        } elseif (!empty($apm['pt_passport'])) {
            $identification = $apm['pt_passport'];
        } elseif (!empty($apm['pt_peregrine'])) {
            $identification = $apm['pt_peregrine'];
        }
        $start_time = new DateTime($apm['loc8_ntdp_time_start']);
    if (!empty($apm['loc8_ntdp_time_finish'])) {
        $finish_time = new DateTime($apm['loc8_ntdp_time_finish']);
        $interval = $start_time->diff($finish_time);
        $total_minutes = ($interval->h * 60) + $interval->i;
    } else {
        // Handle cases where the finish time is not set
        $total_minutes = 0;  // Or set this to a default value, depending on your needs
    }

    $data[] =array(
        "row" =>intval($start) + intval($key) + 1,
        "pt_identification" => $identification,
        "pt_member" => $apm['pt_member'],
        "apm_visit" => $apm['apm_visit'],
        "apm_ql_code" => $apm['apm_ql_code'],
        "pt_name" => $apm['pt_name'],
        "apm_date" => convertToThaiYear($apm['apm_date'],false ),
        "apm_time" => $apm['apm_time'],
        "stde_name_th" => $apm['stde_name_th'],
        "ps_name" => $apm['ps_name'],
        "ps_id" => encrypt_id( $apm['ps_id']),
        "loc_name" => $apm['loc_name'],
        "apm_pri_id" =>$apm['apm_pri_id'],
        "apm_app_walk" =>$apm['apm_app_walk'],
        "apm_patient_type" => $apm['apm_patient_type'],
        "apm_id" =>  $apm['apm_id'],
        "pt_id" =>  $apm['apm_pt_id'],
        "loc6_ntdp_time_start" => $apm['loc6_ntdp_time_start'],
        "loc8_ntdp_time_start" => $apm['loc8_ntdp_time_start'],
        "loc8_ntdp_time_finish" => $apm['loc8_ntdp_time_finish'],
        "loc8_ntdp_time_end" => $apm['loc8_ntdp_time_end'],
        "loc8_ntdp_time_total" => $total_minutes
    ) ; 
    }
    // Prepare response
    $response = [
        "draw" => intval($this->input->post("draw")),
        "recordsTotal" => intval($total),
        "recordsFiltered" => intval($total),
        "data" => $data
    ];

    echo json_encode($response);
}
public function get_data_activity() {
    $selectedDate = $this->input->post('selectedDate');
    $type = $this->input->post('type');
    $apm_app_walk = $this->input->post('apm_app_walk');
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
        
    $where = "WHERE 1 ";
    if ($apm_app_walk != NULL){
        $where .= " AND que_appointment.apm_app_walk = '$apm_app_walk' ";
    } 
    if ($type==='day'){
        $where .= " AND que_appointment.apm_date = '$selectedDate' ";
    } else if ($type==='week'){
        $year = date('Y'); // Adjust if needed for a different year
      $week = intval($selectedDate);

      $dto = new DateTime();
      $dto->setISODate($year, $week);
      $startOfWeek = $dto->format('Y-m-d');
      $dto->modify('+6 days');
      $endOfWeek = $dto->format('Y-m-d');
        $where .= " AND DATE(que_appointment.apm_date) >= '$startOfWeek' AND DATE(que_appointment.apm_date) <= '$endOfWeek'";
    } else if ($type==='month'){
        $yearMonth = explode('-', $selectedDate);
        $year = intval($yearMonth[0]);
        $month = intval($yearMonth[1]);

        // Calculate the start and end dates of the selected month
        $startOfMonth = date('Y-m-01', strtotime("$year-$month-01"));
        $endOfMonth = date('Y-m-t', strtotime("$year-$month-01"));
        $where .= " AND DATE(que_appointment.apm_date) >= '$startOfMonth' AND DATE(que_appointment.apm_date) <= '$endOfMonth'";
    }
    $query = $this->db->query("
    SELECT 
        see_quedb.que_appointment.*,
        ums_patient.*, 
        ums_patient.pt_identification,
        ums_patient.pt_passport,
        ums_patient.pt_peregrine,
        ums_patient.pt_tel,
        ums_patient.pt_email,
        wts_notifications_department.ntdp_id,
        wts_notifications_department.ntdp_apm_id,
        wts_notifications_department.ntdp_loc_Id,
        wts_location.loc_name,
        CONCAT(ums_patient.pt_prefix, '', ums_patient.pt_fname, ' ', ums_patient.pt_lname) AS pt_name,
        CONCAT(hr_base_prefix.pf_name_abbr, '', hr_person.ps_fname, ' ', hr_person.ps_lname) AS ps_name,
        ums_department.dp_name_th, 
        hr_structure_detail.stde_name_th 
          FROM 
              see_quedb.que_appointment
    LEFT JOIN see_hrdb.hr_structure_detail ON que_appointment.apm_stde_id = hr_structure_detail.stde_id
    LEFT JOIN see_umsdb.ums_patient ON que_appointment.apm_pt_id = ums_patient.pt_id
    LEFT JOIN see_hrdb.hr_person ON see_quedb.que_appointment.apm_ps_id = hr_person.ps_id
    LEFT JOIN see_hrdb.hr_base_prefix ON hr_person.ps_pf_id = hr_base_prefix.pf_id
    LEFT JOIN see_wtsdb.wts_base_disease ON see_quedb.que_appointment.apm_ds_id = wts_base_disease.ds_id
    LEFT JOIN see_umsdb.ums_department ON see_quedb.que_appointment.apm_dp_id = ums_department.dp_id 
    LEFT JOIN see_wtsdb.wts_notifications_department ON see_quedb.que_appointment.apm_id = wts_notifications_department.ntdp_apm_id AND wts_notifications_department.ntdp_id = (
      SELECT MAX(ntdp_id) 
      FROM see_wtsdb.wts_notifications_department 
      WHERE ntdp_apm_id = see_quedb.que_appointment.apm_id
  )
    LEFT JOIN see_wtsdb.wts_location ON see_wtsdb.wts_location.loc_id = wts_notifications_department.ntdp_loc_Id 
          $where    
          LIMIT $start, $length;  
      ");
      $result = $query->result_array();
    // Fetch the data
    $total_result = $this->db->query("
    SELECT 
	    COUNT(*) as total
          FROM 
              see_quedb.que_appointment
          LEFT JOIN 
              see_hrdb.hr_structure_detail 
          ON 
              que_appointment.apm_stde_id = hr_structure_detail.stde_id
          LEFT JOIN
          	see_umsdb.ums_patient 
            ON que_appointment.apm_pt_id = ums_patient.pt_id
          $where
          
              ");
    $total = $total_result->row()->total;
    
    $data = array();
    foreach ($result as $key => $apm){
        $identification = '';
        if (!empty($apm['pt_identification'])) {
            $identification = $apm['pt_identification'];
        } elseif (!empty($apm['pt_passport'])) {
            $identification = $apm['pt_passport'];
        } elseif (!empty($apm['pt_peregrine'])) {
            $identification = $apm['pt_peregrine'];
        }
        
    $data[] =array(
        "row" =>intval($start) + intval($key) + 1,
        "pt_identification" => $identification,
        "pt_member" => $apm['pt_member'],
        "apm_visit" => $apm['apm_visit'],
        "apm_ql_code" => $apm['apm_ql_code'],
        "pt_name" => $apm['pt_name'],
        "apm_date" => $apm['apm_date'],
        "apm_time" => $apm['apm_time'],
        "stde_name_th" => $apm['stde_name_th'],
        "ps_name" => $apm['ps_name'],
        "loc_name" => $apm['loc_name'],
        "apm_pri_id" =>$apm['apm_pri_id'],
        "apm_app_walk" =>$apm['apm_app_walk'],
        "apm_patient_type" => $apm['apm_patient_type'],
        "apm_id" =>  $apm['apm_id']
        
    ) ; 
    }
    // Prepare response
    $response = [
        "draw" => intval($this->input->post("draw")),
        "recordsTotal" => intval($total),
        "recordsFiltered" => intval($total),
        "data" => $data
    ];

    echo json_encode($response);
}



  // private function get_data_by_day($date) {
  //   // Select the total count, count of old patients, and count of new patients
  //   $this->db->select('
  //       COUNT(*) as total,
  //       SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count,
  //       SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count
  //   ');
  //   $this->db->from('que_appointment');
  //   $this->db->where('DATE(apm_date)', $date); // Filter by the specific date
  //   $this->db->group_by('apm_visit'); // Group by apm_visit
  //   $query = $this->db->get();

  //   // Return the result as an array
  //   return [
  //       'total' => $query->row()->total,
  //       'old' => $query->row()->old_count,
  //       'new' => $query->row()->new_count
  //   ];
  // }


  // private function get_data_by_week($week) {
  //   // Assuming $week is in format "2023-W36"
  //   $year = substr($week, 0, 4);
  //   $week_number = substr($week, 6);

  //   // Select the total count, count of old patients, and count of new patients
  //   $this->db->select('
  //       COUNT(*) as total,
  //       SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count,
  //       SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count
  //   ');
  //   $this->db->from('que_appointment');
  //   $this->db->where('YEARWEEK(apm_date, 1) =', $year . $week_number);
  //   $this->db->group_by('apm_visit'); // Group by apm_visit
  //   $query = $this->db->get();

  //   // Return the result as an array
  //   return [
  //       'total' => $query->row()->total,
  //       'old' => $query->row()->old_count,
  //       'new' => $query->row()->new_count
  //   ];
  // }


  // private function get_data_by_month($month) {
  //   // Assuming $month is in format "2023-09"
  //   // Select the total count, count of old patients, and count of new patients
  //   $this->db->select('
  //       COUNT(*) as total,
  //       SUM(CASE WHEN apm_patient_type = "old" THEN 1 ELSE 0 END) as old_count,
  //       SUM(CASE WHEN apm_patient_type = "new" THEN 1 ELSE 0 END) as new_count
  //   ');
  //   $this->db->from('que_appointment');
  //   $this->db->where('DATE_FORMAT(apm_date, "%Y-%m") =', $month);
  //   $this->db->group_by('apm_visit'); // Group by apm_visit
  //   $query = $this->db->get();

  //   // Return the result as an array
  //   return [
  //       'total' => $query->row()->total,
  //       'old' => $query->row()->old_count,
  //       'new' => $query->row()->new_count
  //   ];
  // }
}
