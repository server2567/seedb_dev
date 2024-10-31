<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Profile extends UMS_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('staff/M_staff_profile');
    $this->load->model('hr/M_hr_person_education');
    $this->load->model('hr/M_hr_person_position');
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
    } else {
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
  /*
	* view_profile
	* หน้าจอสำหรับการแสดงโปรไฟล์ของบุคลากร 
	* @input $ps_Id
	* $output v_profile
	* @author JIRADAT POMYAI
	* @Create Date 30/10/2024
	*/
  public function view_profile($ps_id)
  {
    // $ps_id = decrypt_id($id);
    $ps_id  = decrypt_id($ps_id);
    $data['ps_info'] = $this->M_staff_profile->get_medical_profile(null, $ps_id)->row();
    $this->M_hr_person_position->ps_id = $ps_id;
    $data['person_department_topic'] = $this->M_hr_person_position->get_person_ums_department_by_ps_id()->result();
    $data['ps_education'] = $this->M_hr_person_education->get_all_person_education_data($ps_id)->result();
    $result_current = [];  // เก็บข้อมูล timework ปัจจุบัน
    $result_previous = []; // เก็บข้อมูล timework ก่อนหน้า

    $hasAnyTimeworkCurrent = false; // ใช้เพื่อตรวจสอบว่ามีข้อมูลปัจจุบันในทุก dp_id หรือไม่
    $hasAnyTimeworkPrevious = false; // ใช้เพื่อตรวจสอบว่ามีข้อมูลก่อนหน้าในทุก dp_id หรือไม่

    foreach ($data['person_department_topic'] as $key => $value) {
      // ดึงข้อมูลการออกตรวจ
      $timework_current = $this->get_doctor_timework_public($ps_id, $value->dp_id, 0);
      $timework_previous = $this->get_doctor_timework_public($ps_id, $value->dp_id, 1);

      // ระบุเดือนและปี
      $currentYear = date('Y');
      $currentMonth = date('m');
      $previousYear = date('Y', strtotime('first day of 1 month'));
      $previousMonth = date('m', strtotime('first day of 1 month'));

      // จัดการข้อมูล timework_current
      if ($timework_current) {
        $hasAnyTimeworkCurrent = true; // มีข้อมูลปัจจุบันอย่างน้อยหนึ่งรายการ
        $timework_current_info = $this->group_schedule_by_week($timework_current, $currentYear, $currentMonth);

        foreach ($timework_current_info as $week_id => $days) {
          foreach ($days as $day => $info) {
            $result_current[$week_id][$day][$value->dp_id] = [
              'timework' => $info['timework'],
              'day' => $info['day'],
              'is_today' => ($info['days'][0] == date('Y-m-d')) ? '1' : '0',
              'days' => $info['days'],
              'room_name'=>$info['room_name'],
            ];
          }
        }

        $days_count_current[$value->dp_id] = $this->count_work_days($timework_current);
        $today_timework[$value->dp_id] = $this->get_today_timework($timework_current, date('Y-m-d'));
      }

      // จัดการข้อมูล timework_previous
      if ($timework_previous) {
        $hasAnyTimeworkPrevious = true; // มีข้อมูลก่อนหน้าอย่างน้อยหนึ่งรายการ
        $timework_previous_info = $this->group_schedule_by_week($timework_previous, $previousYear, $previousMonth);

        foreach ($timework_previous_info as $week_id => $days) {
          foreach ($days as $day => $info) {
            $result_previous[$week_id][$day][$value->dp_id] = [
              'timework' => $info['timework'],
              'day' => $info['day'],
              'is_today' => ($info['days'][0] == date('Y-m-d')) ? '1' : '0',
              'days' => $info['days'],
              'room_name'=>$info['room_name'],
            ];
          }
        }

        $days_count_previous[$value->dp_id] = $this->count_work_days($timework_previous);
      }

      // ถ้าไม่มีข้อมูล timework_current ให้เติมข้อมูลวันที่ว่างใน $result_current
      if (!$timework_current) {
        $daysCurrent = $this->generateAllDaysInMonth($currentYear, $currentMonth);
        $this->populateDoctorTimework($daysCurrent, $currentYear, $currentMonth, $result_current, $value->dp_id);
      }

      // ถ้าไม่มีข้อมูล timework_previous ให้เติมข้อมูลวันที่ว่างใน $result_previous
      if (!$timework_previous) {
        $daysPrevious = $this->generateAllDaysInMonth($previousYear, $previousMonth);
        $this->populateDoctorTimework($daysPrevious, $previousYear, $previousMonth, $result_previous, $value->dp_id);
      }
    }
    // ตรวจสอบว่ามีข้อมูล timework_current หรือไม่ ถ้าไม่มีทุก dp_id ให้เป็น []
    $data['doctor_timework_current'] = $hasAnyTimeworkCurrent ? $result_current : [];

    $data['days_count_current'] = $hasAnyTimeworkCurrent ? $days_count_current : [];
    $data['today_timework'] = $hasAnyTimeworkCurrent ? $today_timework : [];
    // ตรวจสอบว่ามีข้อมูล timework_previous หรือไม่ ถ้าไม่มีทุก dp_id ให้เป็น []
    $data['doctor_timework_previous'] = $hasAnyTimeworkPrevious ? $result_previous : [];
    $data['days_count_previous'] = $hasAnyTimeworkPrevious ? $days_count_previous : [];
    // ส่งข้อมูลไปยังตัวแปร $data เพื่อใช้ใน View
    $data['work_age'] = $this->get_work_age($ps_id);
    $data['ps_reward'] = $this->get_reward_list($ps_id);
    $data['ps_external'] = $this->get_external_service_list($ps_id);
    $this->output_frontend_staff('hr/frontend/v_profile', $data);
  }

  function get_doctor_timework_public($ps_id, $dp_id, $day = 0)
  {
    $query = $this->db->query("
              SELECT 
          twpp_ps_id AS doctor_id,
          twpp_id,
          twpp_dp_id,
          twpp_twac_id,
          CONCAT(
              TIME_FORMAT(twpp_start_time, '%H:%i'), 
              ' - ', 
              TIME_FORMAT(twpp_end_time, '%H:%i'), ' น.'
          ) AS timework,
          eqs.rm_name_use,
          twpp_start_date,
          twpp_end_date,
          DAY(twpp_start_date) AS day
      FROM 
          see_hrdb.hr_timework_person_plan
      LEFT JOIN see_eqsdb.eqs_room as eqs on eqs.rm_id = twpp_rm_id
      WHERE 
          twpp_start_date <= LAST_DAY(DATE_ADD(CURRENT_DATE, INTERVAL ? MONTH))
          AND twpp_end_date >= DATE_FORMAT(DATE_ADD(CURRENT_DATE, INTERVAL ? MONTH), '%Y-%m-01')
          AND twpp_status = 'S'
          AND twpp_is_public = 1
          AND twpp_ps_id = ?
          AND twpp_dp_id = ?
      ORDER BY 
          twpp_ps_id, twpp_start_date;
          ", array($day, $day, $ps_id, $dp_id));
    $data = $query->result_array();
    $result = [];
    foreach ($data as $row) {
      $dateRange = $this->generateDateRange($row['twpp_start_date'], $row['twpp_end_date']);
      foreach ($dateRange as $date) {
        $weekOfMonth = $this->getWeekOfMonth($date); // คำนวณสัปดาห์ของเดือน
        $result[] = [
          'doctor_id' => $row['doctor_id'],
          'twpp_id' => $row['twpp_id'],
          'twpp_dp_id' => $row['twpp_dp_id'],
          'twpp_twac_id' => $row['twpp_twac_id'],
          'room_name'=>$row['rm_name_use'],
          'timework' => $row['timework'],
          'work_date' => $date,
          'day' => $row['day'],
          'weekday_name' => date('l', strtotime($date)),
          'week_of_month' => $weekOfMonth // เพิ่มสัปดาห์ของเดือน
        ];
      }
    }
    return $result;
  }
  /*
    * populateDoctorTimework
    * สร้างข้อมูลการออกตรวจของแพทย์สำหรับทุกวันในเดือน
    * @param $daysArray (array) : รายการวันที่ของเดือน
    * @param $year (int) : ปีที่ต้องการ
    * @param $month (int) : เดือนที่ต้องการ
    * @param &$result (array) : ผลลัพธ์ข้อมูลที่ถูกสร้าง
    * @param $dp_id (int) : รหัสแผนกหรือแพทย์
    */
  private function populateDoctorTimework($daysArray, $year, $month, &$result, $dp_id)
  {
    foreach ($daysArray as $date) {
      $week_of_month = $this->getAdjustedWeekOfMonth($date, $year, $month);
      $weekday_name_thai = $this->translate_day_to_thai(date('l', strtotime($date)));
      // ตรวจสอบสถานะของวัน
      $dayStatus = $this->checkDateStatus($date, $month, $year);

      // ถ้าวันนี้ยังไม่มีข้อมูล ให้สร้างใหม่พร้อมสถานะ
      if (!isset($result[$week_of_month][$weekday_name_thai][$dp_id])) {
        $result[$week_of_month][$weekday_name_thai][$dp_id] = [
          'timework' => $dayStatus['timework'],
          'is_today' => ($date == date('Y-m-d')) ? '1' : '0',
          'day' => date('j', strtotime($date)),
          'days' => [$dayStatus['days']],
          'room_name'=>null
        ];
      }
    }
  }
  /*
* count_work_days
* นับจำนวนวันออกตรวจของแต่ละแพทย์ โดยป้องกันการนับวันที่ซ้ำกัน
* @input $timework_data - ข้อมูลการออกตรวจของแพทย์
* @output จำนวนวันที่ไม่ซ้ำ
* @author JIRADAT POMYAI
* @Create Date 30/10/2024
*/
  private function count_work_days($timework_data)
  {
    $days = [];

    foreach ($timework_data as $timework) {
      $work_date = $timework['work_date'];
      $days[$work_date] = true; // ใช้ key เป็นวันที่ เพื่อป้องกันการนับซ้ำ
    }

    return count($days); // คืนค่าจำนวนวันที่ไม่ซ้ำ
  }

  /*
* get_today_timework
* ดึงข้อมูลการออกตรวจสำหรับวันปัจจุบัน
* @input $timework_data - ข้อมูลการออกตรวจทั้งหมด
* @input $today - วันที่ปัจจุบัน
* @output ข้อมูลการออกตรวจของวันปัจจุบัน หรือ null ถ้าไม่มีข้อมูล
* @author JIRADAT POMYAI
* @Create Date 30/10/2024
*/
  private function get_today_timework($timework_data, $today)
  {
    $result = null;
    $timework_strings = []; // เก็บ timework ของทุกข้อมูลในวันนี้

    foreach ($timework_data as $timework) {
      if ($timework['work_date'] === $today) {
        // หากยังไม่มีผลลัพธ์ เริ่มสร้างจากข้อมูลแรกที่ตรงกับวันนี้
        if ($result === null) {
          $result = $timework; // คัดลอกข้อมูลทั้งหมดของรายการแรก
        }
        // เก็บ timework ใน array เพื่อเชื่อมต่อภายหลัง
        $timework_strings[] = $timework['timework'];
      }
    }

    if ($result !== null) {
      // เชื่อมต่อข้อมูล timework ทั้งหมดด้วย <br> และแทนที่ในตัวแปร result
      $result['timework'] = implode('<br>', $timework_strings);
    } else {
      // หากไม่มีข้อมูลในวันนี้ ให้คืนค่า week_of_month พร้อมข้อความ
      $result = [
        'work_date' => $today,
        'timework' => 'ไม่ออกตรวจ',
        'week_of_month' => $this->getWeekOfMonth($today)
      ];
    }

    return $result;
  }

  /*
  * getWeekOfMonth
  * คำนวณว่าวันที่นั้นอยู่ในสัปดาห์ที่เท่าไรของเดือน
  * @input $date - วันที่ต้องการตรวจสอบ
  * @output สัปดาห์ที่ของเดือน (1-5)
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function getWeekOfMonth($date)
  {
    $firstDayOfMonth = date('Y-m-01', strtotime($date)); // วันแรกของเดือน
    $firstMonday = date('Y-m-d', strtotime('monday this week', strtotime($firstDayOfMonth))); // วันจันทร์แรกของเดือน
    $daysDiff = (strtotime($date) - strtotime($firstMonday)) / (60 * 60 * 24); // คำนวณความต่างของวัน

    return (int) ceil(($daysDiff + 1) / 7); // หาสัปดาห์ของเดือนโดยปัดขึ้น
  }

  /*
  * getAdjustedWeekOfMonth
  * คำนวณสัปดาห์ของเดือนปัจจุบัน โดยรองรับการข้ามเดือน
  * @input $date - วันที่ต้องการตรวจสอบ
  * @input $targetYear - ปีเป้าหมาย
  * @input $targetMonth - เดือนเป้าหมาย
  * @output สัปดาห์ที่ของเดือน (1-5)
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function getAdjustedWeekOfMonth($date, $targetYear, $targetMonth)
  {
    $yearOfDate = (int) date('Y', strtotime($date));
    $monthOfDate = (int) date('m', strtotime($date));

    if ($monthOfDate < $targetMonth || $yearOfDate < $targetYear) {
      return 1; // วันของเดือนก่อนหน้า ให้อยู่ในสัปดาห์ที่ 1 ของเดือนปัจจุบัน
    }

    $totalWeeks = (int) date('W', strtotime("last day of $targetYear-$targetMonth")) -
      (int) date('W', strtotime("first day of $targetYear-$targetMonth")) + 1;

    if ($monthOfDate > $targetMonth || $yearOfDate > $targetYear) {
      return $totalWeeks; // วันของเดือนถัดไป ให้อยู่ในสัปดาห์สุดท้าย
    }

    $firstDayOfMonth = date('Y-m-01', strtotime("$targetYear-$targetMonth"));
    $weekOfFirstDay = (int) date('W', strtotime($firstDayOfMonth));
    $weekOfDate = (int) date('W', strtotime($date));

    return $weekOfDate - $weekOfFirstDay + 1;
  }

  /*
* generateDateRange
* สร้างช่วงวันที่ตามที่กำหนด
* @input $startDate - วันที่เริ่มต้น
* @input $endDate - วันที่สิ้นสุด
* @output Array ของวันที่ทั้งหมดในช่วงที่กำหนด
* @author JIRADAT POMYAI
* @Create Date 30/10/2024
*/
  private function generateDateRange($startDate, $endDate)
  {
    $dates = [];
    $currentDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    while ($currentDate <= $endDate) {
      $dates[] = date('Y-m-d', $currentDate);
      $currentDate = strtotime('+1 day', $currentDate);
    }

    return $dates;
  }

  /*
  * group_schedule_by_week
  * จัดกลุ่มข้อมูลการออกตรวจตามสัปดาห์ของเดือน
  * @input $timework_data - ข้อมูลการออกตรวจของแพทย์
  * @input $year - ปีที่ต้องการตรวจสอบ
  * @input $month - เดือนที่ต้องการตรวจสอบ
  * @output Array - ข้อมูลการออกตรวจตามสัปดาห์และวันในภาษาไทย
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function group_schedule_by_week($timework_data, $year, $month)
  {
    $result = [];
    $daysInMonth = $this->generateAllDaysInMonth($year, $month); // สร้างทุกวันในเดือน

    // เติมข้อมูลจริงจาก $data หากมี
    foreach ($timework_data as $row) {
      $week_of_month = $this->getWeekOfMonth($row['work_date']);
      $weekday_name_thai = $this->translate_day_to_thai($row['weekday_name']);
      $day_in_month = $row['work_date'];
      $room_name = $row['room_name'];

      // จัดการ timework และวันที่หากมีข้อมูลจริง
      if (!isset($result[$week_of_month][$weekday_name_thai])) {
        $result[$week_of_month][$weekday_name_thai] = [
          'timework' => '',
          'is_today' => ($day_in_month == date('Y-m-d') ? '1' : '0'),
          'day' => (int) date('d', strtotime($day_in_month)),
          'days' => [$day_in_month],
          'room_name'=>$room_name
        ];
      }

      if (!empty($result[$week_of_month][$weekday_name_thai]['timework'])) {
        $result[$week_of_month][$weekday_name_thai]['timework'] .= '<br>';
      }

      $result[$week_of_month][$weekday_name_thai]['timework'] .= $row['timework'];
    }

    // ตรวจสอบและสร้างวันที่สำหรับวันของเดือนก่อนหน้า/ถัดไป
    foreach ($daysInMonth as $date) {
      $week_of_month = $this->getAdjustedWeekOfMonth($date, $year, $month);
      $weekday_name_thai = $this->translate_day_to_thai(date('l', strtotime($date)));

      // ตรวจสอบสถานะของวัน
      $dayStatus = $this->checkDateStatus($date, $month, $year);

      // ถ้าวันนี้ยังไม่มีข้อมูล ให้สร้างใหม่พร้อมสถานะ
      if (!isset($result[$week_of_month][$weekday_name_thai])) {
        $result[$week_of_month][$weekday_name_thai] = [
          'timework' => $dayStatus['timework'],
          'is_today' => ($day_in_month == date('yyyy-mm-dd') ? '1' : '0'),
          'day' => $dayStatus['day'],
          'days' => [$dayStatus['days']],
          'room_name'=>null
        ];
      }
    }

    // เรียงลำดับวันในสัปดาห์ตามลำดับที่ถูกต้อง
    foreach ($result as $week => $days) {
      $result[$week] = $this->sortWeekDays($days);
    }
    return $result;
  }

  /*
  * sortWeekDays
  * เรียงลำดับวันในสัปดาห์ตามลำดับที่ถูกต้องในภาษาไทย
  * @input $days - ข้อมูลวันที่ที่ต้องการเรียงลำดับ
  * @output Array - ข้อมูลวันที่ที่เรียงลำดับแล้ว
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function sortWeekDays($days)
  {
    $dayOrder = [
      'จันทร์',
      'อังคาร',
      'พุธ',
      'พฤหัสบดี',
      'ศุกร์',
      'เสาร์',
      'อาทิตย์'
    ];

    uksort($days, function ($a, $b) use ($dayOrder) {
      return array_search($a, $dayOrder) - array_search($b, $dayOrder);
    });

    return $days;
  }

  /*
  * checkDateStatus
  * ตรวจสอบสถานะของวันที่ว่าเป็นของเดือนก่อนหน้า, ปัจจุบัน หรือถัดไป
  * @input $date - วันที่ต้องการตรวจสอบ
  * @input $month - เดือนปัจจุบัน
  * @input $year - ปีปัจจุบัน
  * @output Array - ข้อมูลสถานะของวันและการออกตรวจ
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function checkDateStatus($date, $month, $year)
  {
    $currentMonth = (int) $month;
    $currentYear = (int) $year + 543;

    $monthOfDate = (int) date('m', strtotime($date));
    $yearOfDate = (int) date('Y', strtotime($date)) + 543;

    $monthNames = [
      1 => 'มกราคม',
      2 => 'กุมภาพันธ์',
      3 => 'มีนาคม',
      4 => 'เมษายน',
      5 => 'พฤษภาคม',
      6 => 'มิถุนายน',
      7 => 'กรกฎาคม',
      8 => 'สิงหาคม',
      9 => 'กันยายน',
      10 => 'ตุลาคม',
      11 => 'พฤศจิกายน',
      12 => 'ธันวาคม'
    ];

    if ($monthOfDate < $currentMonth) {
      $monthName = $monthNames[$monthOfDate];
      return ['days' => "สิ้นสุดเดือน $monthName $yearOfDate", 'timework' => '0', 'day' => (int) date('d', strtotime($date))];
    } elseif ($monthOfDate > $currentMonth) {
      $monthName = $monthNames[$monthOfDate - 1];
      return ['days' => "สิ้นสุดเดือน $monthName $yearOfDate", 'timework' => '0', 'day' => (int) date('d', strtotime($date))];
    } else {
      return ['days' => date('Y-m-d', strtotime($date)), 'timework' => 'ไม่ออกตรวจ', 'day' => (int) date('d', strtotime($date))];
    }
  }

  /*
  * generateAllDaysInMonth
  * สร้างวันที่ทั้งหมดในเดือนที่กำหนด รวมถึงวันของเดือนก่อนหน้าและถัดไป
  * @input $year - ปีที่ต้องการสร้าง
  * @input $month - เดือนที่ต้องการสร้าง
  * @output Array - วันที่ทั้งหมดในเดือนนั้น
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function generateAllDaysInMonth($year, $month)
  {
    $days = [];
    $totalDays = date('t', strtotime("$year-$month-01"));

    $firstDayOfWeek = date('N', strtotime("$year-$month-01"));
    if ($firstDayOfWeek != 1) {
      $lastDayPrevMonth = date('Y-m-t', strtotime("$year-$month -1 month"));
      for ($i = $firstDayOfWeek - 2; $i >= 0; $i--) {
        $days[] = date('Y-m-d', strtotime("$lastDayPrevMonth -$i day"));
      }
    }

    for ($day = 1; $day <= $totalDays; $day++) {
      $days[] = date("Y-m-d", strtotime("$year-$month-$day"));
    }

    $lastDayOfWeek = date('N', strtotime("$year-$month-$totalDays"));
    if ($lastDayOfWeek != 7) {
      $nextMonthFirstDay = date('Y-m-01', strtotime("$year-$month +1 month"));
      for ($i = 1; $i <= 7 - $lastDayOfWeek; $i++) {
        $days[] = date('Y-m-d', strtotime("$nextMonthFirstDay +$i day - 1 day"));
      }
    }

    return $days;
  }

  /*
  * translate_day_to_thai
  * แปลงชื่อวันภาษาอังกฤษเป็นภาษาไทย
  * @input $day - ชื่อวันในภาษาอังกฤษ
  * @output ชื่อวันในภาษาไทย หรือชื่อเดิมหากไม่พบ
  * @author JIRADAT POMYAI
  * @Create Date 30/10/2024
  */
  private function translate_day_to_thai($day)
  {
    $days = [
      'Monday' => 'จันทร์',
      'Tuesday' => 'อังคาร',
      'Wednesday' => 'พุธ',
      'Thursday' => 'พฤหัสบดี',
      'Friday' => 'ศุกร์',
      'Saturday' => 'เสาร์',
      'Sunday' => 'อาทิตย์'
    ];

    return $days[$day] ?? $day;
  }
}
