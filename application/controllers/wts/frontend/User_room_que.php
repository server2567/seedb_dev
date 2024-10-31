<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");

class User_room_que extends UMS_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('hr/structure/m_hr_structure_detail');
    $this->load->model('ums/m_ums_patient');
    $this->load->model('wts/m_wts_queue_seq');
    $this->load->model('wts/m_wts_base_disease');
    $this->load->model('que/m_que_appointment');
    $this->load->model('ums/Genmod', 'genmod');
  }

  public function department($name = "") {
    $data['stde_name'] = urldecode($name);
    $date = date('Y-m-d');
  // $date = '2024-09-03';
    if($data['stde_name'] == 'จุดคัดกรอง') {
      $this->output_frontend_public('wts/frontend/v_user_room_que', $data);
    }else{
      $stde = $this->m_hr_structure_detail->get_stde_id_by_name($data['stde_name']);
    $data['room'] = $this->m_wts_queue_seq->get_waiting_room($date, $stde[0]['stde_id'])->result_array();

    if(!empty($data['room'])) {
      foreach ($data['room'] as $room) {
        // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
        // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
        $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
    
        // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
        // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
        // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
        //     if ($a['apm_sta_id'] == '2') {
        //         return -1; // $a ต้องมาอยู่ลำดับแรก
        //     } elseif ($b['apm_sta_id'] == '2') {
        //         return 1; // $b ต้องมาอยู่ลำดับแรก
        //     } else {
        //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
        //         return strcmp($a['qus_seq'], $b['qus_seq']);
        //     }
        // });
    }
      //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
      // if($data['pre_que'] == NULL) {
      //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
      // }
    }

    // get for show info
    $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array();

    $this->output_frontend_public('wts/frontend/v_user_room_que', $data);
    }
  }

  public function lasik() {
    $data['floor'] = 'lasik';
    $text = '';
    
      $text = "ชั้นที่ 1 ";
      $text .=  'แผนกศูนย์เคลียร์เลสิค (Lasik) ';
    
    $data['stde_name'] = $text;
    
      $date = date('Y-m-d');
      // $date = '2024-09-18';
      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_stde_id($date)->result_array();
      if(!empty($data['room'])) {
        foreach ($data['room'] as $room) {
          
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor_stde_id($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
      
          
      }
      
      }

      // die(pre($data));
      // get for show info
      $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array();
      $current_datetime = date('Y-m-d H:i:s');
      $data['news'] = $this->genmod->getAll(
        'see_umsdb',
        'ums_news',
        '*',
        array(
          'news_active !=' => 2,
          'news_type' => 2,
          // 'news_bg_id =' =>5, 
          // 'news_bg_id LIKE' => "%$rol%",
          'news_start_date <= ' => $current_datetime,
          'news_stop_date >= ' => $current_datetime
        )
      );
      
      
        $this->output_frontend_public('wts/frontend/v_user_que_announce', $data);

      
        
      
    // }
    // }
  } 

  public function den() {
    $data['floor'] = 2;
    $text = '';
    $text = "ชั้นที่ 2 ภาคทันตกรรม (DEN)";
    $data['stde_name'] = $text;
      $date = date('Y-m-d');
      // $date = '2024-09-18';
      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor($date, $data['floor'])->result_array();
      if(!empty($data['room'])) {
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
    
      }
      }

      $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array();
      $current_datetime = date('Y-m-d H:i:s');
      $data['news'] = $this->genmod->getAll(
        'see_umsdb',
        'ums_news',
        '*',
        array(
          'news_active !=' => 2,
          'news_type' => 2,
          // 'news_bg_id =' =>5, 
          // 'news_bg_id LIKE' => "%$rol%",
          'news_start_date <= ' => $current_datetime,
          'news_stop_date >= ' => $current_datetime
        )
      );
    $this->output_frontend_public('wts/frontend/v_user_que_announce', $data);
  } 

  public function finance_medicine()
  {
    $data['floor'] = 'finance_medicine';
    $text = '';

    $text = "ชั้นที่ 1 ";
    $text .=  'ห้องการเงิน และห้องจ่ายยา';

    $data['stde_name'] = $text;

    $date = date('Y-m-d');

    $data['room_que'] = $this->m_wts_queue_seq->get_waiting_que_by_finance_medicine($date)->result_array();

    $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array(); //สถานะฉุกเฉิน เฝ้าระวัง

    $this->output_frontend_public('wts/frontend/v_user_que_finance_medicine', $data);
  }


  public function floor_old($floor) {
    $data['floor'] = $floor;
    $text = '';
    if(isset($floor) && !empty($floor)) {
      $text = "ชั้นที่ ".$floor.' ';
      if($floor == 1) $text .=  'ภาคจักษุวิทยา (EYE) ';
      if($floor == 'lasik') $text .=  'ศูนย์เลสิก (Lasik) ';
    } else if(isset($stde_name) && !empty($stde_name)) 
    $text = $stde_name;
    $data['stde_name'] = $text;
      $date = date('Y-m-d');
      // $date = '2024-09-06';
      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor_old($date, $floor)->result_array();
      if(!empty($data['room'])) {
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor_old($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
      }
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }

      // die(pre($data));
      // get for show info
      $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array();
      $current_datetime = date('Y-m-d H:i:s');
      $data['news'] = $this->genmod->getAll(
        'see_umsdb',
        'ums_news',
        '*',
        array(
          'news_active !=' => 2,
          'news_type' => 1,
          // 'news_bg_id =' =>5, 
          // 'news_bg_id LIKE' => "%$rol%",
          'news_start_date <= ' => $current_datetime,
          'news_stop_date >= ' => $current_datetime
        )
      );
      
      
        
      
        $this->output_frontend_public('wts/frontend/v_user_floor_que_old', $data);
      
    // }
    // }
  }
  public function floor($floor) {
    $data['floor'] = $floor;
    $text = '';
    if(isset($floor) && !empty($floor)) {
      $text = "ชั้นที่ ".$floor.' ';
      if($floor == 1) $text .=  'ภาคจักษุวิทยา (EYE) ';
      if($floor == 'lasik') $text .=  'ศูนย์เลสิก (Lasik) ';
    } else if(isset($stde_name) && !empty($stde_name)) 
    $text = $stde_name;
    $data['stde_name'] = $text;
      $date = date('Y-m-d');
      // $date = '2024-09-18';
      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor($date, $floor)->result_array();
      if(!empty($data['room'])) {
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
      
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
      }
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }

      // die(pre($data));
      // get for show info
      $data['priorities'] = $this->m_que_appointment->get_all_priority()->result_array();
      $current_datetime = date('Y-m-d H:i:s');
      $data['news'] = $this->genmod->getAll(
        'see_umsdb',
        'ums_news',
        '*',
        array(
          'news_active !=' => 2,
          'news_type' => 1,
          // 'news_bg_id =' =>5, 
          // 'news_bg_id LIKE' => "%$rol%",
          'news_start_date <= ' => $current_datetime,
          'news_stop_date >= ' => $current_datetime
        )
      );
        
        $this->output_frontend_public('wts/frontend/v_user_floor_que', $data);
      
    // }
    // }
  }
  public function getQueueData($name = "") {
    $stde_name = urldecode($name); // Decode the URL-encoded name

		$date = date('Y-m-d');
		// $date = '2024-09-18';  // Hardcoded for testing, remove in production

    $stde = $this->m_hr_structure_detail->get_stde_id_by_name($stde_name);

    $data['room_que'] = [];

    if (!empty($stde)) {
        $data['room'] = $this->m_wts_queue_seq->get_waiting_room($date, $stde[0]['stde_id'])->result_array();
        if(!empty($data['room'])) {
          foreach ($data['room'] as $room) {
            // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
            // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
            $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
            
            // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
            // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
            // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
            //     if ($a['apm_sta_id'] == '2') {
            //         return -1; // $a ต้องมาอยู่ลำดับแรก
            //     } elseif ($b['apm_sta_id'] == '2') {
            //         return 1; // $b ต้องมาอยู่ลำดับแรก
            //     } else {
            //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
            //         return strcmp($a['qus_seq'], $b['qus_seq']);
            //     }
            // });
        }
          //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
          // if($data['pre_que'] == NULL) {
          //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
          // }
        }
        }
    // pre($data);
    header('Content-Type: application/json');
    echo json_encode($data); // Ensure this line is executed after all processing
}

public function room_department($name = "") {
  $data['stde_name'] = urldecode($name);
  $date = date('Y-m-d');
  // $date = '2024-09-06';
  if($data['stde_name'] == 'จุดคัดกรอง') {
    $this->output_frontend_public('wts/frontend/v_user_room_que', $data);
  }else{
    $stde = $this->m_hr_structure_detail->get_stde_id_by_name($data['stde_name']);
  $data['room'] = $this->m_wts_queue_seq->get_waiting_room($date, $stde[0]['stde_id'])->result_array();

  if(!empty($data['room'])) {
    foreach ($data['room'] as $room) {
      // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
      // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
      $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
  
      // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
      // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
      // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
      //     if ($a['apm_sta_id'] == '2') {
      //         return -1; // $a ต้องมาอยู่ลำดับแรก
      //     } elseif ($b['apm_sta_id'] == '2') {
      //         return 1; // $b ต้องมาอยู่ลำดับแรก
      //     } else {
      //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
      //         return strcmp($a['qus_seq'], $b['qus_seq']);
      //     }
      // });
  }
    //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
    // if($data['pre_que'] == NULL) {
    //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
    // }
  }
  $this->output_frontend_public('wts/frontend/v_user_room_que', $data);
  }
}

public function get_room_queue($name = "") {
  $stde_name = urldecode($name); // Decode the URL-encoded name

  $date = date('Y-m-d');
  // $date = '2024-09-03';

  $stde = $this->m_hr_structure_detail->get_stde_id_by_name($stde_name);

  $data['room_que'] = [];

  if (!empty($stde)) {
      $data['room'] = $this->m_wts_queue_seq->get_waiting_room($date, $stde[0]['stde_id'])->result_array();
      if(!empty($data['room'])) {
        $map_seq_room = [];
        $index = 0;
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          
          // Check if an entry with the same 'qus_psrm_id' already exists
          $exists = false;
          foreach ($map_seq_room as $item) {
              if ($item['qus_psrm_id'] === $room['qus_psrm_id']) {
                  $exists = true;
                  break;
              }
          }
          // Add the new entry only if it does not exist
          if (!$exists) {
              $map_seq_room[] = [
                  'qus_psrm_id' => $room['qus_psrm_id'],
                  'index' => $index
              ];
              $index++;
          }
      
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
        }
        $data['map_seq_room'] = $map_seq_room;
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }
      }
  // pre($data);
  header('Content-Type: application/json');
  echo json_encode($data); // Ensure this line is executed after all processing
}

public function get_room_queue_by_floor_old($floor) {
  
  $data['floor'] = $floor;

  
  $text = '';
  if(isset($floor) && !empty($floor)) {
    $text = "ชั้น ".$floor.' ';
    
    if($floor == 1) $text .=  'ภาคจักษุวิทยา (EYE) ';
    
  } else if(isset($stde_name) && !empty($stde_name)) $text = $stde_name;
  $data['stde_name'] = $text;
  $date = date('Y-m-d');
  // $date = '2024-09-18';  // Hardcoded for testing, remove in production

  $data['room_que'] = [];

  if (!empty($floor)) {

      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor_old($date, $floor)->result_array();

      if(!empty($data['room'])) {
        $map_seq_room = [];
        $index = 0;
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor_old($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          
          // Check if an entry with the same 'qus_psrm_id' already exists
          $exists = false;
          foreach ($map_seq_room as $item) {
              if ($item['qus_psrm_id'] === $room['qus_psrm_id']) {
                  $exists = true;
                  break;
              }
          }
          // Add the new entry only if it does not exist
          if (!$exists) {
              $map_seq_room[] = [
                  'qus_psrm_id' => $room['qus_psrm_id'],
                  'index' => $index
              ];
              $index++;
          }
      
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
        }
        $announce = $this->m_wts_queue_seq->get_announce_by_floor($date, $floor)->result_array();
        $data['announce'] = $announce;
        $data['map_seq_room'] = $map_seq_room;
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }
      }
  // pre($data);
  header('Content-Type: application/json');
  echo json_encode($data); // Ensure this line is executed after all processing
}
public function get_room_queue_by_floor($floor) {
  
  $data['floor'] = $floor;

  
  $text = '';
  if(isset($floor) && !empty($floor)) {
    $text = "ชั้น ".$floor.' ';
    
    if($floor == 1) $text .=  'ภาคจักษุวิทยา (EYE) ';
    
  } else if(isset($stde_name) && !empty($stde_name)) $text = $stde_name;
  $data['stde_name'] = $text;
  $date = date('Y-m-d');
  // $date = '2024-09-18';  // Hardcoded for testing, remove in production
  
  $data['room_que'] = [];

  if (!empty($floor)) {

      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor($date, $floor)->result_array();
       
      if(!empty($data['room'])) {
        $map_seq_room = [];
        $index = 0;
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          // Check if an entry with the same 'qus_psrm_id' already exists
          $exists = false;
          foreach ($map_seq_room as $item) {
              if ($item['qus_psrm_id'] === $room['qus_psrm_id']) {
                  $exists = true;
                  break;
              }
          }
          // Add the new entry only if it does not exist
          if (!$exists) {
              $map_seq_room[] = [
                  'qus_psrm_id' => $room['qus_psrm_id'],
                  'index' => $index
              ];
              $index++;
          }
      
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
        }
        $announce = $this->m_wts_queue_seq->get_announce_by_floor($date, $floor)->result_array();
        $data['announce'] = $announce;
        $data['map_seq_room'] = $map_seq_room;
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }
      }
  // pre($data);
  header('Content-Type: application/json');
  echo json_encode($data); // Ensure this line is executed after all processing
}
public function get_room_queue_by_floor_den($floor) {
  
  $data['floor'] = $floor;

  
  $text = '';
  if(isset($floor) && !empty($floor)) {
    $text = "ชั้น ".$floor.' ';
    
    if($floor == 1) $text .=  'ภาคจักษุวิทยา (EYE) ';
    
  } else if(isset($stde_name) && !empty($stde_name)) $text = $stde_name;
  $data['stde_name'] = $text;
  $date = date('Y-m-d');
  // $date = '2024-09-18';  // Hardcoded for testing, remove in production

  $data['room_que'] = [];

  if (!empty($floor)) {

      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_floor_den($date, $floor)->result_array();

      if(!empty($data['room'])) {
        $map_seq_room = [];
        $index = 0;
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor_den($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          
          // Check if an entry with the same 'qus_psrm_id' already exists
          $exists = false;
          foreach ($map_seq_room as $item) {
              if ($item['qus_psrm_id'] === $room['qus_psrm_id']) {
                  $exists = true;
                  break;
              }
          }
          // Add the new entry only if it does not exist
          if (!$exists) {
              $map_seq_room[] = [
                  'qus_psrm_id' => $room['qus_psrm_id'],
                  'index' => $index
              ];
              $index++;
          }
      
          // เรียงลำดับ array โดยให้ apm_sta_id = 2 เป็นลำดับแรก และลำดับอื่นๆ ตาม apm_time
          // 20240904 Areerat - ให้เรียงลำดับตามการจัดลำดับใน [WTS] หน้าจอจัดการคิว
          // usort($data['room_que'][$room['qus_psrm_id']], function($a, $b) {
          //     if ($a['apm_sta_id'] == '2') {
          //         return -1; // $a ต้องมาอยู่ลำดับแรก
          //     } elseif ($b['apm_sta_id'] == '2') {
          //         return 1; // $b ต้องมาอยู่ลำดับแรก
          //     } else {
          //         // หากไม่มี apm_sta_id = 2 ให้เรียงตาม apm_time
          //         return strcmp($a['qus_seq'], $b['qus_seq']);
          //     }
          // });
        }
        $announce = $this->m_wts_queue_seq->get_announce_by_floor($date, $floor)->result_array();
        $data['announce'] = $announce;
        $data['map_seq_room'] = $map_seq_room;
        //     $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
        // if($data['pre_que'] == NULL) {
        //   $data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 4)->result_array();
        // }
      }
      }
  // pre($data);
  header('Content-Type: application/json');
  echo json_encode($data); // Ensure this line is executed after all processing
}

public function get_room_queue_lasik() {
  
    $floor = 1;
  
  $data['floor'] = $floor;

  
  $text = ''; 
  if(isset($floor) && !empty($floor)) {
    $text = "ชั้น ".$floor.' ';
    
    if($floor == 1) $text .=  'แผนกศูนย์เคลียร์เลสิค (Lasik) ';
    if($floor == 'lasik') $text .=  'แผนกศูนย์เคลียร์เลสิค (Lasik) ';
  } else if(isset($stde_name) && !empty($stde_name)) $text = $stde_name;
  $data['stde_name'] = $text;
  $date = date('Y-m-d');
  // $date = '2024-09-18';  // Hardcoded for testing, remove in production
  
  $data['room_que'] = [];

  
      
      $data['room'] = $this->m_wts_queue_seq->get_waiting_doctor_by_stde_id($date)->result_array();
    
      if(!empty($data['room'])) {
        $map_seq_room = [];
        $index = 0;
        foreach ($data['room'] as $room) {
          // $data['room_que'][$room['qus_psrm_id']] = $this->m_wts_queue_seq->get_waiting_que_by_room($date, $room['qus_psrm_id'], [2, 4, 11, 12])->result_array();
          // 20240905 Areerat - หากแพทย์ยังไม่เลือกห้อง จะต้องแสดงหน้าจอ frontend ด้วย
          $data['room_que'][$room['ps_id']] = $this->m_wts_queue_seq->get_waiting_que_by_doctor_stde_id($date, $room['ps_id'], [2, 4, 11, 12])->result_array();
          
          // Check if an entry with the same 'qus_psrm_id' already exists
          $exists = false;
          foreach ($map_seq_room as $item) {
              if ($item['qus_psrm_id'] === $room['qus_psrm_id']) {
                  $exists = true;
                  break;
              }
          }
          // Add the new entry only if it does not exist
          if (!$exists) {
              $map_seq_room[] = [
                  'qus_psrm_id' => $room['qus_psrm_id'],
                  'index' => $index
              ];
              $index++;
          }

        }
        $data['announce'] = $this->m_wts_queue_seq->get_announce_by_stde_id($date)->result_array();
        $data['map_seq_room'] = $map_seq_room;
       
      }
      
  // pre($data);
  header('Content-Type: application/json');
  echo json_encode($data); // Ensure this line is executed after all processing
}

function compressImage($source, $destination, $quality) {
    // Get image info
    $info = getimagesize($source);

    // Check if image is JPEG or PNG
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    // Save the image with the desired quality
    imagejpeg($image, $destination, $quality);

    // Return the compressed image path
    return $destination;
}

}
?>
