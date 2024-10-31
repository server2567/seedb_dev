<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Dashboard_modal extends UMS_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ums/M_ums_patient');
        $this->que = $this->load->database('que', TRUE);
        $this->ams =$this->load->database('ams', TRUE);
      
        $this->que_db = 	$this->que->database;
        $this->ams_db = $this->ams->database;
    }

    public function modal_timeline($ap_id) {

      // $status_que = '1,2,4'; // จองคิวสำเร็จ
      $que = $data['que'] = $this->M_ums_patient->get_que_details($ap_id)->result_array();
      
      foreach($que as $key => $q){
        // $data['dt_que'][$q['apm_id']] = $this->M_ums_patient->get_base_disease_time($q['apm_id'],$q['apm_ds_id'])->result_array();
        $data['ntdp'][$q['apm_id']] = $this->M_ums_patient->get_notifications_department($q['apm_id'])->result_array();

      }

      // สมมติว่ามีเฉพาะหนึ่ง apm_id
      if (!empty($data['ntdp'][$que[0]['apm_id']])) {
        // เรียงข้อมูลตามที่ต้องการ (จากบนสุดไปล่างสุด)
        usort($data['ntdp'][$que[0]['apm_id']], function ($a, $b) {
            return strcmp($b['ntdp_date_start'] . $b['ntdp_time_start'], $a['ntdp_date_start'] . $a['ntdp_time_start']);
        });
        
        // หาข้อมูลลำดับบนสุดและล่างสุด
        $first = $data['ntdp'][$que[0]['apm_id']][0]; // บนสุด
        $last = end($data['ntdp'][$que[0]['apm_id']]); // ล่างสุด
        
        $start_datetime = new DateTime($last['ntdp_date_start'] . ' ' . $last['ntdp_time_start']);
        $end_datetime = new DateTime($first['ntdp_date_start'] . ' ' . $first['ntdp_time_finish']);
        
        $interval = $start_datetime->diff($end_datetime);
        $total_minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
        
        $data['total_minutes'] = $total_minutes;
      } else {
          $data['total_minutes'] = 0;
      }


      $this->load->view('ums/frontend/v_modal_timeline', $data);
    }
    
    public function modal_que($ap_id) {

      $status_que = '1,2,4'; // จองคิวสำเร็จ
      $data['que'] = $this->M_ums_patient->get_que_details_all($ap_id)->row();
      $data['can'] = $this->M_ums_patient->get_base_cancel()->result_array();

      $this->load->view('ums/frontend/v_modal_que', $data);
    }

  public function cancel_que() {
      $apc_apm_id = $this->input->post('appointment_id');
      $apc_can = $this->input->post('reason');
      $apc_details = $this->input->post('details');
      $apc_pt_id = $this->input->post('pt_id');

      // บันทึกข้อมูลการยกเลิกลงในฐานข้อมูล
      $data = array(
          'apc_pt_id' => $apc_pt_id,
          'apc_apm_id' => $apc_apm_id,
          'apc_can' => $apc_can,
          'apc_details' => $apc_details,
          'apc_create' => $apc_pt_id,
          'apc_date' => date('Y-m-d H:i:s')  // วันที่และเวลาที่ยกเลิก
      );
      $this->que->insert('que_appointment_cancel', $data);

      // อัปเดตสถานะการนัดหมายให้เป็นยกเลิก
      $this->que->where('apm_id', $apc_apm_id);
      $this->que->update('que_appointment', array('apm_sta_id' => '9'));

      // ส่งคืนคำตอบไปยัง AJAX
      echo json_encode(array('status' => 'success'));
  }


  public function modal_appointment($ap_id) {

    // $status_app = '2'; // จองคิวสำเร็จ
    $status_ntr = '4'; // จองคิวสำเร็จ
    $data['app'] = $this->M_ums_patient->get_appointment_details($ap_id)->row();
    // echo $this->db->last_query();
    // pre($data['app']); die;
    $data['can'] = $this->M_ums_patient->get_base_cancel()->result_array();
    
    $this->load->view('ums/frontend/v_modal_appointment', $data);
  }

  public function cancel_ams() {
    $apc_ap_id = $this->input->post('appointment_id');
    $apc_can = $this->input->post('reason');
    $apc_details = $this->input->post('details');
    $apc_pt_id = $this->input->post('pt_id');

    // บันทึกข้อมูลการยกเลิกลงในฐานข้อมูล
    $data = array(
        'apc_pt_id' => $apc_pt_id,
        'apc_ap_id' => $apc_ap_id,
        'apc_can' => $apc_can,
        'apc_details' => $apc_details,
        'apc_create' => $apc_pt_id,
        'apc_date' => date('Y-m-d H:i:s')  // วันที่และเวลาที่ยกเลิก
    );
    $this->ams->insert('ams_appointment_cancel', $data);

    // อัปเดตสถานะการนัดหมายให้เป็นยกเลิก
    $this->ams->where('ap_id', $apc_ap_id);
    $this->ams->update('ams_appointment', array('ap_ast_id' => '9'));

    // ส่งคืนคำตอบไปยัง AJAX
    echo json_encode(array('status' => 'success'));
  }

  public function modal_ntr($ntr_id){

    $data['ntr'] = $this->M_ums_patient->get_ntr_details($ntr_id)->row();
    $this->load->view('ums/frontend/v_modal_ntr', $data);
  }

  public function modal_logs($pt_id){

    $data['get_logs_login'] = $this->M_ums_patient->get_patient_logs_login($pt_id)->result_array();
    $this->load->view('ums/frontend/v_modal_logs', $data);
  }

  public function modal_news($news_id){

    $data['news'] = $this->M_ums_patient->get_ums_news_id($news_id)->row();
    $this->load->view('ums/frontend/v_modal_news', $data);
  }
}
?>