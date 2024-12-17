<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Manage_queue_finance_medicine extends WTS_Controller
{
  public function __construct()
  {
    parent::__construct();
    header("Access-Control-Allow-Origin: *");
  }

  public function finance()
  {
    $data['room_sta'] = 'finance';
    $data['que_finance_medicine'] = $this->db->query('SELECT * FROM see_quedb.que_appointment 
    LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
    LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
    LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
    LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
        LEFT JOIN see_wtsdb.wts_base_status wb ON wb.sta_id = qus_status
    WHERE apm_date = CURDATE() AND apm_sta_id IN (16, 18) AND apm_dp_id = "'.$this->session->userdata('us_dp_id').'"
    GROUP BY apm_id 
    ORDER BY 
        CASE 
            WHEN pri_id = 1 THEN 1
            WHEN pri_id = 6 THEN 2
            ELSE 3
        END,
        CASE 
            WHEN apm_ql_code LIKE "%I%" THEN 1
            ELSE 2
        END,
        apm_rm_time ASC,
        apm_ql_code ASC')->result_array();

    $data['que_success'] = $this->db->query('SELECT * FROM see_quedb.que_appointment 
    LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
    LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
    LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
    LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
    WHERE apm_date = CURDATE() AND apm_sta_id IN (17,19,15) AND apm_dp_id = "'.$this->session->userdata('us_dp_id').'" GROUP BY apm_id ORDER BY apm_rm_code DESC')->result_array();

    $data['que_status_1'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 1 AND sta_room = 1 ORDER BY sta_seq")->result_array();
    $data['que_status_2'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 2 AND sta_room = 1 ORDER BY sta_seq")->result_array();
    $data['que_status_3'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 3 AND sta_room = 1 ORDER BY sta_seq")->result_array();
    $data['que_status_all'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 ORDER BY sta_seq")->result_array();

    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('wts/manage/trello/v_manage_finance_medicine', $data);
  }

  public function medicine()
  {
    $data['room_sta'] = 'medicine';
    $data['que_finance_medicine'] = $this->db->query('SELECT * FROM see_quedb.que_appointment 
    LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
    LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
    LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
    LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
    LEFT JOIN see_wtsdb.wts_base_status wb ON wb.sta_id = qus_status
    WHERE apm_date = CURDATE() AND apm_sta_id IN (17,19) AND apm_dp_id = "'.$this->session->userdata('us_dp_id').'" GROUP BY apm_id ORDER BY 
        CASE 
            WHEN pri_id = 1 THEN 1
            WHEN pri_id = 6 THEN 2
            ELSE 3
        END,
        CASE 
            WHEN apm_ql_code LIKE "%I%" THEN 1
            ELSE 2
        END,
        apm_rm_time ASC,
        apm_ql_code ASC')->result_array();

    $data['que_success'] = $this->db->query('SELECT * FROM see_quedb.que_appointment 
    LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
    LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
    LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
    LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
    WHERE apm_date = CURDATE() AND apm_sta_id IN (15) AND apm_dp_id = "'.$this->session->userdata('us_dp_id').'" GROUP BY apm_id ORDER BY apm_rm_code DESC')->result_array();

    $data['que_status_1'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 1 AND sta_room = 2 ORDER BY sta_seq")->result_array();
    $data['que_status_2'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 2 AND sta_room = 2 ORDER BY sta_seq")->result_array();
    $data['que_status_3'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 3 AND sta_room = 2 ORDER BY sta_seq")->result_array();
    $data['que_status_all'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 ORDER BY sta_seq")->result_array();

    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('wts/manage/trello/v_manage_finance_medicine', $data);
  }

  public function getQueueData($room_sta)
  {
      if ($room_sta == 'finance') {
          $status_condition = 'IN (16,18)';
          $success_condition = 'IN (17,19,15)';
          $room = 1;
      } elseif ($room_sta == 'medicine') {
          $status_condition = 'IN (17,19)';
          $success_condition = 'IN (15)';
          $room = 2;
      } else {
          show_404(); // ถ้า room_sta ไม่ตรง ให้แสดง error 404
      }
  
      $data['que_finance_medicine'] = $this->db->query("SELECT * FROM see_quedb.que_appointment 
      LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
      LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
      LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
      LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
          LEFT JOIN see_wtsdb.wts_base_status wb ON wb.sta_id = qus_status
      WHERE apm_date = CURDATE() AND apm_sta_id {$status_condition} AND apm_dp_id = '".$this->session->userdata('us_dp_id')."' GROUP BY apm_id ORDER BY 
        CASE 
            WHEN pri_id = 1 THEN 1
            WHEN pri_id = 6 THEN 2
            ELSE 3
        END,
        CASE 
            WHEN apm_ql_code LIKE '%I%' THEN 1
            ELSE 2
        END,
        apm_rm_time ASC,
        apm_ql_code ASC")->result_array();
  
      $data['que_success'] = $this->db->query("SELECT * FROM see_quedb.que_appointment 
      LEFT JOIN see_umsdb.ums_patient ON apm_pt_id = pt_id 
      LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
      LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
      LEFT JOIN see_quedb.que_base_priority ON apm_pri_id = pri_id
      WHERE apm_date = CURDATE() AND apm_sta_id {$success_condition} GROUP BY apm_id ORDER BY apm_rm_code DESC")->result_array();
  
      $data['que_status_1'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 1 AND sta_room = {$room} ORDER BY sta_seq")->result_array();
      $data['que_status_2'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 2 AND sta_room = {$room} ORDER BY sta_seq")->result_array();
      $data['que_status_3'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 AND sta_section = 3 AND sta_room = {$room} ORDER BY sta_seq")->result_array();
      $data['que_status_all'] = $this->db->query("SELECT * FROM see_wtsdb.wts_base_status WHERE sta_active = 1 ORDER BY sta_seq")->result_array();
      $data['room_sta'] = $room_sta; // ส่งค่า room_sta มาด้วย

      echo json_encode($data); // ส่งข้อมูลกลับในรูปแบบ JSON
  }

  public function saveDraft() {
    // รับข้อมูลจาก AJAX Request
    $input = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบข้อมูลว่ามีค่าอะไรบ้าง
    $apm_id = $input['apm_id'];
    $status = $input['status'];
    $channel = $input['channel'];
    $call = $input['call'];
    $createdAt = date('Y-m-d H:i:s');

    // รวม channel และ call เข้าด้วยกัน
    $channel_call = $channel;
    if (!empty($call)) {
        $channel_call .= ',' . $call;
    }

    // สร้าง SQL Query สำหรับการอัปเดตข้อมูล
    $sql = "UPDATE see_wtsdb.wts_queue_seq SET qus_status = ?, qus_channel = ? WHERE qus_apm_id = ?";

    // ทำการอัปเดตข้อมูลในฐานข้อมูลโดยตรง
    $result = $this->db->query($sql, array($status, $channel_call, $apm_id));

    // ตรวจสอบผลลัพธ์และส่งกลับเป็น JSON
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
  }

  public function saveandcall(){
    // รับข้อมูลจาก AJAX Request
    $input = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบข้อมูลว่ามีค่าอะไรบ้าง
    $apm_id = $input['apm_id'];
    $room_sta = $input['room_sta'];
    $status = $input['status'];
    $channel = $input['channel'];
    $call = $input['call'];
    $createdAt = date('Y-m-d H:i:s');

    // รวม channel และ call เข้าด้วยกัน
    $channel_call = $channel;
    if (!empty($call)) {
        $channel_call .= ',' . $call;
    }

    // สร้าง SQL Query สำหรับการอัปเดตข้อมูล
    $sql = "UPDATE see_wtsdb.wts_queue_seq SET qus_status = ?, qus_channel = ? WHERE qus_apm_id = ?";

    // ทำการอัปเดตข้อมูลในฐานข้อมูลโดยตรง
    $result = $this->db->query($sql, array($status, $channel_call, $apm_id));
    if($room_sta == 'finance'){
      $sql = "UPDATE see_quedb.que_appointment SET apm_sta_id = 18 WHERE apm_id = ?";
    } else if($room_sta == 'medicine') {
      if(!$call){
        $sql = "UPDATE see_quedb.que_appointment SET apm_sta_id = 16 WHERE apm_id = ?";
      } else {
        $sql = "UPDATE see_quedb.que_appointment SET apm_sta_id = 19 WHERE apm_id = ?";
      }
    }
    $result = $this->db->query($sql, array($apm_id));
    // ตรวจสอบผลลัพธ์และส่งกลับเป็น JSON
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
  }

  public function updatePatientStatus() {
    // รับข้อมูลจาก AJAX Request
    $input = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบข้อมูลว่ามีค่าอะไรบ้าง
    $apm_id = $input['apm_id'];
    $room_sta = $input['room_sta'];
    $result = false; // ตัวแปรเพื่อใช้ตรวจสอบผลลัพธ์รวม

    if ($room_sta == 'finance') {
        $sql = "UPDATE see_quedb.que_appointment SET apm_sta_id = 17 WHERE apm_id = ?";
        $result = $this->db->query($sql, array($apm_id));

        // ตรวจสอบว่าการ query สำเร็จหรือไม่ก่อนเรียกใช้ sql_1
        if ($result) {
            $sql_1 = "UPDATE see_wtsdb.wts_queue_seq SET qus_status = 1, qus_channel = 9 WHERE qus_apm_id = ?";
            $result = $this->db->query($sql_1, array($apm_id));
        }
    } else if ($room_sta == 'medicine') {
        $sql = "UPDATE see_quedb.que_appointment SET apm_sta_id = 15 WHERE apm_id = ?";
        $result = $this->db->query($sql, array($apm_id));
    }

    // ตรวจสอบผลลัพธ์และส่งกลับเป็น JSON
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
  }


  public function getQueueStatus($apm_id) {
    // Query เพื่อดึงข้อมูลจากฐานข้อมูลตาม apm_id ที่ได้รับมา
    $query = $this->db->query("SELECT * FROM see_wtsdb.wts_queue_seq WHERE qus_apm_id = ?", array($apm_id));
    $result = $query->result_array();
    // ส่งผลลัพธ์กลับมาในรูปแบบ JSON
    echo json_encode($result);
  }
}
