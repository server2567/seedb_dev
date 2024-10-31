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
		$this->output_frontend('wts/frontend/v_user_check_que.php', $data);
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
	
		$apm_ql_code = $que_check_data['que_id'];
		$qr_id = $que_check_data['qr_id'];
		$stde_id = $que_check_data['stde'];
	
		$ql_code = $apm_ql_code;
		$data['que'] = $this->m_que_appointment->get_appointment_by_code($date, $ql_code, $stde_id)->result_array();
	
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
				'returnUrl' => base_url() . 'index.php/wts/frontend/User_check_que/que_show/' . encrypt_id($stde_id) . '/' . $ql_code,
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
		$date = date('Y-m-d');
		// $date = '2024-08-09';
	
		$data['datetime'] = $this->m_que_appointment->get_datetime_by_code($apm_ql_code)->result_array();
		$data['que'] = $this->m_que_appointment->get_appointment_by_code($date, $apm_ql_code, decrypt_id($stde_id))->result_array();
		$stde = $data['que'][0]['apm_stde_id'];
		$ntdp_rdp_id = $data['que'][0]['ntdp_rdp_id'];
		$ntdp_ds_id = $data['que'][0]['ntdp_ds_id'];
		$ntdp_dst_id = $data['que'][0]['ntdp_dst_id'];
		$sta_id = $data['que'][0]['apm_sta_id'];
		$apm_ql_code = $data['que'][0]['apm_ql_code'];
		$ps_id = $data['que'][0]['apm_ps_id'];
		// pre($stde);
		// pre($ntdp_rdp_id);
		// pre($ntdp_ds_id);
		// pre($ntdp_dst_id);
		// pre($sta_id);
		// pre($apm_ql_code);
		// pre($ps_id);
		// die;

		if($sta_id <=4 && $sta_id != 3) {
			// $data['pre_que'] = $this->m_wts_notifications_department->get_present_que_by_sta_id($date, $stde, $ps_id, 2)->result_array();
			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();

		}else if($sta_id >4 && $sta_id != 9) {
			if($sta_id == 12) {
				// $data['pre_que'] = $this->m_wts_notifications_department->get_present_que_by_sta_id($date, $stde, $ps_id, 2)->result_array();
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 2)->result_array();
			}else{
				// $data['pre_que'] = $this->m_wts_notifications_department->get_present_que_by_sta_id($date, $stde, $ps_id, 11)->result_array();
				$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, 11)->result_array();
		}
	}
		// $data['pt_que'] = $this->m_wts_notifications_department->get_pt_que_by_apm_ql_code($date, $apm_ql_code, $stde)->result_array();
		$data['pt_que'] = $data['que'];
		// pre($data['pre_que']); 
		// pre($data['pt_que']); die;
		if(empty($data['pre_que'])) {
			// $data['pre_que'] = $this->m_wts_notifications_department->get_present_que_by_sta_id($date, $stde, $ps_id, $sta_id)->result_array();
			$data['pre_que'] = $this->m_que_appointment->get_appointment_by_sta($date, $sta_id)->result_array();
			// pre($data['pre_que']);
			$pre_que = $data['pre_que'][0]['apm_ql_code'];
			$pt_que = $data['pt_que'][0]['apm_ql_code'];
		}else {
			$pre_que = $data['pre_que'][0]['apm_ql_code'];
			$pt_que = $data['pt_que'][0]['apm_ql_code'];

		}
	
			$i = 0;
			foreach ($data['pt_que'] as $row) {
				// $data['time'] = $this->m_wts_notifications_department->get_ntdp_list_btw_select_ntdp($date, $pre_que, $pt_que)->result_array();
				$data['time'] = $this->m_que_appointment->get_ntdp_list_btw_select_apm($date, $pre_que, $pt_que)->result_array();
				$sum_time = 0;
				foreach ($data['time'] as $wt) {
					if(empty($wt['dst_minute'])) {
						$sum_time += 10;
					}else{
						$sum_time += $wt['dst_minute']; // เวลาของแต่ละจุด
					}
				}
				$data['pt_que'][$i]['sum_time'] = $sum_time;
				$i++;
		}

		$currentTime = time();
		$secondsToAdd = $data['pt_que'][0]['sum_time'] * 60;
		// Add the number of seconds to the current time
		$newTime = $currentTime + $secondsToAdd;
		// Format the new time as H:i:s
		$data['pt_que'][0]['que_time'] = date('H:i', $newTime);

		$data['status_response'] = $this->config->item('status_response_show');;

		
		$this->output_frontend('wts/frontend/v_user_que_show',$data);

	}

	}
?>