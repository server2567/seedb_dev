<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../WTS_Controller.php");

class User_check_que extends WTS_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ums/m_ums_patient');
		$this->load->model('que/m_que_appointment');
		$this->load->model('que/m_que_create_queue');
		$this->load->model('wts/m_wts_notifications_department');
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('wts/m_wts_base_route_department');
		$this->load->model('wts/m_wts_base_route_time');
		$this->load->model('wts/m_wts_base_qrcode');
		$this->load->model('wts/m_wts_qrcode_scan_patient');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');
		$this->load->helper('url');
	}

	function index() {
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output_frontend('wts/frontend/v_user_check_que.php', $data);
	}
	
	function que_search($qr_id, $stde_id) {
		$data['stde'] = $stde_id;
		$data['qr_id'] = $qr_id;
	
		// Uncomment and correct these lines if needed
		// $data['keyword'] = $this->m_que_create_queue->get_cq_value_by_stde_id($stde_id)->result_array();
		// $data['key'] = $data['keyword'][0]['cq_keyword'] . '-';
		// $data['qrcode'] = $this->m_wts_base_qrcode->get_qr_code_by_id($qr_id)->result_array();
	
		// Uncomment if you need to debug
		// pre($data['qrcode']); die;
		// pre($data['keyword']); die;
	
		$data['stde_name'] = $this->m_hr_structure_detail->get_name_th_by_id($data['stde'])->result();
	
		// Uncomment if you need to debug
		// pre($data['stde']);
	
		// Uncomment if you need appointment data
		// $data['appointment'] = $this->m_que_appointment->get_appointment()->result_array();
	
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output_frontend('wts/frontend/v_user_check_que', $data);
	}
		// function que_search_test($pt_id, $stde_id) {
	// 	if($pt_id != '0') {
	// 		$data['pt_que'] = $this->m_wts_notifications_department->get_pt_que_by_pt_id($pt_id)->result_array();
	// 		// pre($data['pt_que'][0]['apm_cl_code']); die;
	// 		redirect('index.php/wts/frontend/User_que_show/que_show/' . $data['pt_que'][0]['apm_ql_code']);	
	// 	}else{
	// 		$data['stde']= $stde_id;
	// 		$data['status_response'] = $this->config->item('status_response_show');;
	// 		$this->output_frontend('wts/frontend/v_user_check_que.php',$data);
	// 	}
	// 	}
  
	public function que_check() {
		$que_check_data = $this->input->post();
		$date = date('Y-m-d');
		// $date = '2024-09-18';  // Hardcoded for testing, remove in production
		$apm_ql_code = $que_check_data['que_id'];
		$qr_id = $que_check_data['qr_id'];
		$stde_id = $que_check_data['stde'];
	
		$ql_code = $apm_ql_code;
		$data['que'] = $this->m_que_appointment->get_appointment_by_code($date, $ql_code)->result_array();
	
		if (!empty($data['que'])) {
			if (empty($data['que'][0]['ntdp_dst_id'])) {
				$data['que'][0]['ntdp_dst_id'] = '1';  // Set default value if ntdp_dst_id is empty
			}
	
			// Assign values to the model
			$this->m_wts_qrcode_scan_patient->qrsp_pt_id = $data['que'][0]['pt_id'];
			$this->m_wts_qrcode_scan_patient->qrsp_qr_id = $qr_id;
			$this->m_wts_qrcode_scan_patient->qrsp_dst_id = $data['que'][0]['ntdp_dst_id'];
			$this->m_wts_qrcode_scan_patient->qrsp_date_time = date('Y-m-d H:i:s');
	
			// Insert the record
			$this->m_wts_qrcode_scan_patient->insert();
	
			// Respond with success
			$response = array(
				'status' => 'success',
				'returnUrl' => base_url() . 'index.php/wts/frontend/User_check_que/que_show_new/' . $stde_id . '/' . $ql_code,
			);
			echo json_encode($response);
		} else {
			// Respond with error if no appointment is found
			$response = array(
				'status' => 'error',
				'returnUrl' => base_url() . 'index.php/wts/frontend/User_check_que/que_search/' . $qr_id . '/' . $stde_id,
			);
			echo json_encode($response);
		}
	}
		
	public function que_show($stde_id, $apm_ql_code) {

		$date = date('Y-m-d'); // Use current date dynamically
		// $date = '2024-09-18';  // Hardcoded for testing, remove in production
	
		// Fetch queue and appointment data
		$data['datetime'] = $this->m_que_appointment->get_datetime_by_code($apm_ql_code)->result_array();
		$data['pt_que'] = $data['que'] = $this->m_que_appointment->get_appointment_by_code($date, $apm_ql_code, $stde_id)->result_array();
	
		if (empty($data['que'])) {
			// If no queue data, handle the error
			$data['status'] = 'No Queue Data Found';
			return;
		}
	
		// Extract relevant data
		$data['stde'] = $data['que'][0]['apm_stde_id'];
		$ntdp_rdp_id = $data['que'][0]['ntdp_rdp_id'];
		$ntdp_ds_id = $data['que'][0]['ntdp_ds_id'];
		$ntdp_dst_id = $data['que'][0]['ntdp_dst_id'];
		$sta_id = $data['que'][0]['apm_sta_id'];
		$apm_ql_code = $data['que'][0]['apm_ql_code'];
		$ps_id = $data['que'][0]['apm_ps_id'];
	
		// Determine the status of the queue
		if ($sta_id <= 4 && $sta_id != 3) {
			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2, $ps_id)->result_array();
		} elseif ($sta_id > 4 && $sta_id != 9) {
			if ($sta_id == 12) {
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2, $ps_id)->result_array();
			} else {
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 11, $ps_id)->result_array();
			}
		}
	
		// Handle case when pre_que is empty
		if (empty($data['pre_que'])) {
			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, $sta_id, $ps_id)->result_array();
		}
	
		// Set pre_que and pt_que codes
		$pre_que = $data['pre_que'][0]['apm_ql_code'] ?? null;
		$pt_que = $data['que'][0]['apm_ql_code'] ?? null;
		if ($pre_que && $pt_que) {
			// Calculate wait times for queues
			$i = 0;
			foreach ($data['pt_que'] as $row) {
				$data['time'] = $this->m_que_appointment->get_ntdp_list_btw_select_apm($date, $pre_que, $pt_que)->result_array();
				$sum_time = array_reduce($data['time'], function ($carry, $item) {
					return $carry + ($item['dst_minute'] ?: 10);
				}, 0);
				$data['pt_que'][$i]['sum_time'] = $sum_time;
				$i++;
			}
	
			// Calculate estimated time for the next queue
			$currentTime = time();
			$secondsToAdd = $data['pt_que'][0]['sum_time'] * 60;
			$newTime = $currentTime + $secondsToAdd;
			$data['pt_que'][0]['que_time'] = date('H:i', $newTime);
	
			// Fetch the list of queues between the pre and post queue
			$data['queue_list'] = $this->m_que_appointment->get_count_list_btw_select_apm($date, $pre_que, $pt_que)->result_array();
		}
	
		// Add status response
		$data['status_response'] = $this->config->item('status_response_show');
	
		// Load the view with the data
		$this->output_frontend('wts/frontend/v_user_que_show', $data);
	}
	
  public function que_show_new($pt_id='',$apm_ql_code=''){
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    $date = date('Y-m-d'); 
    // เช็คคิวของผูที่กรอกมา
    // $pt_id = '3388';

    $data['pt_que'] = $pt_que = $this->db->query("SELECT * FROM see_umsdb.ums_patient 
    LEFT JOIN see_quedb.que_appointment ON apm_pt_id = pt_id
    WHERE apm_date = CURDATE() AND apm_pt_id = ?", [$pt_id])->result_array();
    $data['check_que'] = $this->db->query("SELECT * FROM see_quedb.que_appointment WHERE apm_ql_code = ? AND apm_date = ? AND apm_pt_id = ?", [$pt_que[0]['apm_ql_code'], $date,$pt_id])->result_array();

    if (!empty($data['check_que'])) {
        $apm_ql_code = $pt_que[0]['apm_ql_code'];
        // เช็คคิวปัจจุบัน
        $data['que_current_stde'] = $this->db->query("SELECT * 
        FROM see_quedb.que_appointment 
        WHERE apm_ps_id = ? AND apm_date = ? AND apm_sta_id = '2'  AND apm_pri_id != '3'", [ $data['check_que'][0]['apm_ps_id'], $date])->result_array();
        // รับยา - ชำระเงิน
        $data['que_pay'] = $this->db->query("
                            SELECT 
                                wts_queue_seq.qus_id,
                                que_appointment.apm_id, que_appointment.apm_date, que_appointment.apm_sta_id, que_appointment.apm_pri_id, 
                                que_appointment.apm_ps_id, que_base_status.sta_id AS que_base_sta_id, que_base_status.sta_name AS que_base_sta_name, 
                                wts_queue_seq.qus_apm_id, wts_queue_seq.qus_status, wts_queue_seq.qus_channel, wts_queue_seq.qus_seq, 
                                status1.sta_id AS wts_status1_sta_id, status1.sta_name AS wts_status1_sta_name, status1.sta_color AS wts_status1_sta_color,
                                status2.sta_id AS wts_status2_sta_id, status2.sta_name AS wts_status2_sta_name, status2.sta_color AS wts_status2_sta_color
                            FROM see_quedb.que_appointment 
                            LEFT JOIN see_quedb.que_base_status 
                                ON que_base_status.sta_id = que_appointment.apm_sta_id
                            LEFT JOIN see_wtsdb.wts_queue_seq 
                                ON wts_queue_seq.qus_apm_id = que_appointment.apm_id
                            LEFT JOIN see_wtsdb.wts_base_status AS status1 
                                ON status1.sta_id = wts_queue_seq.qus_status
                            LEFT JOIN see_wtsdb.wts_base_status AS status2 
                                ON FIND_IN_SET(status2.sta_id, wts_queue_seq.qus_channel)
                            WHERE que_appointment.apm_date = ? AND que_appointment.apm_ql_code = ? AND que_appointment.apm_pri_id != '3' AND apm_sta_id IN (16,17,18,19)
                            GROUP BY wts_status1_sta_name,wts_status2_sta_name ", [$date,$apm_ql_code])->result_array();
    
        // echo $this->db->last_query(); die;

        // เช็คข้อมูลของคิวที่กรอก
        $data['que_person'] = $this->db->query("SELECT * 
        FROM see_quedb.que_appointment 
        LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
        LEFT JOIN see_hrdb.hr_base_prefix ON pf_id = ps_pf_id
        LEFT JOIN see_hrdb.hr_structure_detail ON stde_id = apm_stde_id
        LEFT JOIN see_hrdb.hr_person_room ON psrm_ps_id = ps_id AND DATE(psrm_date) = CURDATE()
	      LEFT JOIN see_eqsdb.eqs_room ON rm_id = psrm_rm_id 
        WHERE apm_ql_code = ? AND apm_date = ?  AND apm_pri_id != '3' ", [$apm_ql_code, $date])->result_array();
        // pre($data['que_person']); die;
        // echo $this->db->last_query(); die;

        // ดึงข้อมูลคิวทั้งหมดของคุณหมอ
        $data['que_all'] = $this->db->query("
            SELECT * 
            FROM see_quedb.que_appointment 
            LEFT JOIN see_wtsdb.wts_queue_seq ON qus_apm_id = apm_id
            LEFT JOIN see_wtsdb.wts_notifications_department ON ntdp_apm_id = apm_id AND ntdp_seq = 6
            WHERE apm_ps_id = ? 
              AND apm_date = ? 
              AND apm_sta_id IN (4) 
              AND apm_pri_id != '3' 
            GROUP BY apm_id ORDER BY apm_app_walk DESC,qus_seq DESC,apm_ql_code DESC", 
            [$data['check_que'][0]['apm_ps_id'], $date]
        )->result_array();
        // echo $this->db->last_query(); die;
        // ตรวจสอบคิวปัจจุบัน
        $current_que_index = array_search($apm_ql_code, array_column($data['que_all'], 'apm_ql_code'));

        if ($current_que_index !== false) {
            $data['remaining_que'] = count($data['que_all']) - $current_que_index - 1;
            $data['expected_time'] = date('H:i', strtotime('+1 minute', strtotime($data['que_all'][$current_que_index]['ntdp_time_end']))); // แสดงเวลาจากฐานข้อมูล
        } else {
            $data['remaining_que'] = 'ไม่มีข้อมูลคิว';
            $data['expected_time'] = 'ไม่ทราบเวลา';
        }

        $data['que_nav'] = $this->db->query("
              SELECT *  
              FROM see_wtsdb.wts_notifications_department 
              INNER JOIN see_eqsdb.eqs_room ON ntdp_loc_ft_Id = rm_his_id
              INNER JOIN see_wtsdb.wts_location ON ntdp_loc_Id = loc_id
              WHERE ntdp_apm_id = ? ORDER BY ntdp_id ASC", 
              [$data['check_que'][0]['apm_id']]
          )->result_array();
        // echo $this->db->last_query(); die;

    } else {
        $data['que_current_stde'] = [];
        $data['que_person'] = [];
        $data['que_all'] = [];
        $data['remaining_que'] = 'ไม่มีข้อมูลคิว';
        $data['expected_time'] = 'ไม่ทราบเวลา';
    }		

    $this->output_frontend('wts/frontend/v_user_que_show_new', $data);
  }
	
	public function get_patient_queue($stde_id, $apm_ql_code) {
		$date = date('Y-m-d'); // Use current date dynamically
		// $date = '2024-09-18';  // Hardcoded for testing, remove in production
	
		// Fetch queue and appointment data
		$data['datetime'] = $this->m_que_appointment->get_datetime_by_code($apm_ql_code)->result_array();
		$data['pt_que'] = $data['que'] = $this->m_que_appointment->get_appointment_by_code($date, $apm_ql_code, $stde_id)->result_array();
	
		if (empty($data['que'])) {
			// If no queue data, handle the error
			$data['status'] = 'No Queue Data Found';
			return;
		}
	
		// Extract relevant data
		$data['stde'] = $data['que'][0]['apm_stde_id'];
		$ntdp_rdp_id = $data['que'][0]['ntdp_rdp_id'];
		$ntdp_ds_id = $data['que'][0]['ntdp_ds_id'];
		$ntdp_dst_id = $data['que'][0]['ntdp_dst_id'];
		$sta_id = $data['que'][0]['apm_sta_id'];
		$apm_ql_code = $data['que'][0]['apm_ql_code'];
		$ps_id = $data['que'][0]['apm_ps_id'];
	
		// Determine the status of the queue
		if ($sta_id <= 4 && $sta_id != 3) {
			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2, $ps_id)->result_array();
		} elseif ($sta_id > 4 && $sta_id != 9) {
			if ($sta_id == 12) {
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2, $ps_id)->result_array();
			} else {
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 11, $ps_id)->result_array();

			}
		}
	
		// Handle case when pre_que is empty
		if (empty($data['pre_que'])) {

			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, $sta_id, $ps_id)->result_array();
		}
	
		// Set pre_que and pt_que codes
		$pre_que = $data['pre_que'][0]['apm_ql_code'] ?? null;

		$pt_que = $data['que'][0]['apm_ql_code'] ?? null;
		if ($pre_que && $pt_que) {
			// Calculate wait times for queues
			$i = 0;
			foreach ($data['pt_que'] as $row) {
				$data['time'] = $this->m_que_appointment->get_ntdp_list_btw_select_apm($date, $pre_que, $pt_que, $ps_id)->result_array();
				$sum_time = array_reduce($data['time'], function ($carry, $item) {
					return $carry + ($item['dst_minute'] ?: 10);
				}, 0);
				$data['pt_que'][$i]['sum_time'] = $sum_time;
				$i++;
			}
	
			// Calculate estimated time for the next queue
			$currentTime = time();
			$secondsToAdd = $data['pt_que'][0]['sum_time'] * 60;
			$newTime = $currentTime + $secondsToAdd;
			$data['pt_que'][0]['que_time'] = date('H:i', $newTime);
			// Fetch the list of queues between the pre and post queue
			$data['queue_list'] = $this->m_que_appointment->get_count_list_btw_select_apm($date, $pre_que, $pt_que, $ps_id)->result_array();
		}
	
		// Send data as JSON
		header('Content-Type: application/json');
		echo json_encode($data);
	}

  public function get_patient_queue_new($stde_id, $apm_ql_code) {
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    $date = date('Y-m-d'); 
    // เช็คคิว
    $data['check_que'] = $this->db->query("SELECT * FROM see_quedb.que_appointment WHERE apm_ql_code = '".$apm_ql_code."' AND apm_date = '".$date."'")->result_array();
    // pre($data['check_que']);
    // die;
    // หาคิวปัจจุบันของแต่ละแผนก
    $data['que_current_stde'] = $this->db->query("SELECT * FROM see_quedb.que_appointment WHERE apm_stde_id = '".$stde_id."' AND apm_ps_id = '".$data['check_que'][0]['apm_ps_id']."' AND apm_date = '".$date."' AND apm_sta_id = '2'")->result_array();
    // echo $this->db->last_query();
    // pre( $data['que_current_stde']);


    // pre($data['que_current_stde']); die;



    header('Content-Type: application/json');
		echo json_encode($data);


  }

	}
?>