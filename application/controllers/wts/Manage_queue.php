<?php 
/*
* Manage_queue
* Controller จัดการแผนกที่รับผู้ป่วย
* @input -
* $output -
* @author Dechathon Prajit
* @Create Date 02/07/2024
pro
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Manage_queue extends WTS_Controller
{
	
  public $wts;
  public $wts_db;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('que/M_que_appointment');
	}

	public function index() {
    
		$data['get_status'] = $this->M_que_appointment->get_all_status_list()->result_array();

		// condition status ddl
		foreach ($data['get_status'] as $index => $item) {
			if (isset($item['sta_id']) && $item['sta_id'] == 1) {
				unset($data['get_status'][$index]);
			}
			if (isset($item['sta_id']) && $item['sta_id'] == 4) {
				$data['get_status'][$index]['sta_name'] = "รอดำเนินการ";
			} else if (isset($item['sta_id']) && $item['sta_id'] == 2) {
				$data['get_status'][$index]['sta_name'] = "กำลังพบแพทย์";
			}
		}
		
		$data['get_doctors'] = $this->M_que_appointment->get_doctors_by_department()->result_array();
		$data['get_structure_detail'] = $this->M_que_appointment->get_structure_detail()->result_array();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/manage/v_manage_show',$data);
  	}

	/*
	* update_save
	* for insert/update notification_results
	* @input id (notification_results id): ไอดีบันทึกผลตรวจ
	* $output response
	* @author ?
	* @Create Date ?
	* @Update Date Areerat Pongurai 23/07/2024 - add condition for show row if status = 5 (ดำเนินการเสร็จสิ้น)
	*/
	  public function queue_list() {
		$draw = intval($this->input->post('draw'));
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order');
		$order_column = $order[0]['column'];
		$order_dir = $order[0]['dir'];
		$search = $this->input->post('search')['value'];
		if(empty($search)){
			$search = NULL;
		}
	
        $date = $this->input->post('date');

		// หน้าจอ sta = 1 คือรอดำเนินการ(นัดหมายสำเร็จ) แต่หน้าจอนี้ รอดำเนินการ = 4 ออกหมายเลขคิว
        $sta_id = $this->input->post('sta');
		if($sta_id == 1) $sta_id = 4;

		$params = [
			'month' => $this->input->post('month'),
			'date' => $date,
			'department' => $this->input->post('department'),
			'doctor' => $this->input->post('doctor'),
			'patientId' => $this->input->post('patientId'),
			'patientName' => $this->input->post('patientName'),
			'sta_id' => $sta_id,
			'search' => $search
		];
        // set badge text
		$badge = '';
        if (!empty($date))
            $badge = "ประจำวันที่ " . formatShortDateThai(str_replace('/', '-', $date), false);
		else {
			if (!empty($this->input->post('month')))
				$badge = "ประจำเดือน " . getLongMonthThai($this->input->post('month'));
			else 
            	$badge = "ประจำวันที่ " . formatShortDateThai((new DateTime())->format('Y-m-d 00:00:00'));
		}

		$result = $this->M_que_appointment->get_appointments_server_wts($start, $length, $order_column, $order_dir, $params);
		$total_appointments = $this->M_que_appointment->get_appointment_count_wts2($params);
	
		$data = [];
		foreach ($result as $index => $apm) {
			$encrypted_id = encrypt_id($apm['apm_id']);
			$ps_name = $apm['ps_name'] ?: '';
			$is_have_ps_id = isset($apm['apm_ps_id']) && !empty($apm['apm_ps_id']) ? true : false; 
			$status_text = "รอดำเนินการ";
			$status_class = "text-warning";
			$btn_url = site_url('wts/Manage_queue/form_info/') . '/' . $encrypted_id;
			$btn_noti_result_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
			// $btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-search"></i></button>'
			// 	 . '<button class="btn btn-warning swal-status" title="สถานะคิว" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '"><i class="bi bi-calendar2"></i></button>';
			
			// [AMS] url to next page
			$btn = '<button class="btn btn-info" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-clipboard-check"></i></button>';
			if($is_have_ps_id) {
				$btn .= '<button class="btn btn-warning ms-1" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_noti_result_url . '\')"><i class="bi-pencil-square"></i></button>'
					. '<button class="btn btn-success btn-see-doctor ms-1" title="เข้าพบแพทย์" onclick="gotoSeeDoctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>';
					// . '<button class="btn btn-warning ms-1 swal-status" title="สถานะคิว" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '"><i class="bi bi-calendar2"></i></button>';
			}
			if ($apm['apm_sta_id'] == 2) {
				$status_text = "กำลังพบแพทย์";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-warning" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
				// $btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-search"></i></button>';
			// } elseif ($apm['apm_sta_id'] == 10) {
			// 	$status_text = "พบแพทย์เสร็จแล้ว";
			// 	$status_class = "text-success";
			// 	$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
			// 	$btn = '<button class="btn btn-warning" title="เลือกจุดบริการถัดไป" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
			} elseif ($apm['apm_sta_id'] == 11) {
				$status_text = "กำลังตรวจในห้องปฏิบัติการ";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-warning" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
			} elseif ($apm['apm_sta_id'] == 12) {
				$status_text = "ตรวจในห้องปฏิบัติการเสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-warning" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>'
					 . '<button class="btn btn-success btn-see-doctor ms-1" title="เข้าพบแพทย์" onclick="gotoSeeDoctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>';
					//  . '<button class="btn btn-success btn-see-doctor ms-1" title="เข้าพบแพทย์"><i class="bi-megaphone-fill"></i></button>';
			} elseif ($apm['apm_sta_id'] == 3 ) {
				$status_text = "ไม่พบผู้ป่วย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-clipboard-check"></i></button>';
			} elseif ( $apm['apm_sta_id'] == 9 ) {
				$status_text = "ยกเลิกนัดหมาย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-clipboard-check"></i></button>';
			}

			if (in_array($apm['apm_sta_id'], [5, 10])) { // ดำเนินการเสร็จสิ้น
				if($apm['apm_sta_id'] == 5)
					$status_text = "พบแพทย์เสร็จแล้ว";
				else
					$status_text = "พบแพทย์เสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/1') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-outline-info" title="ดูรายละเอียด" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-search"></i></button>';

				$data[] = [
					'row_number' => "<div class='disabled-text text-center'>".($start + $index + 1)."</div>",
					'apm_ql_code' => "<div class='disabled-text text-center'>".$apm['apm_ql_code']."</div>",
					'pt_member' => "<div class='disabled-text text-center'>".$apm['pt_member']."</div>",
					'pt_name' => "<div class='disabled-text'>".$apm['pt_name']."</div>",
					'apm_date' => "<div class='disabled-text text-center'>".convertToThaiYear($apm['apm_date'], false)."</div>",
					'apm_time' => "<div class='disabled-text text-center'>".$apm['apm_time']."</div>",
					'ps_name' => "<div class='disabled-text'>".($ps_name)."</div>",
					'apm_pri_id' => "<div class='disabled-text text-center' data-color-pr='".$apm['pri_color']."'>".$apm['pri_name']."</div>",
					'status' => "<div class='disabled-text text-center'>".('<i class="bi-circle-fill ' . $status_class . '"></i> ' . $status_text)."</div>",
					'actions' => "<div class='text-center option'>".$btn."</div>",
				];
			} else {
				if (in_array($apm['apm_sta_id'], [1, 4])) {
					$btn_swal_text = "ระบุแพทย์";
					$btn_swal_class = "btn-info";
					if($is_have_ps_id) { 
						$btn_swal_text = "เปลี่ยนแพทย์";
						$btn_swal_class = "btn-warning";
					}

					$btn_swal = '<br><button class="btn '.$btn_swal_class.' btn-sm swal-doctor text-center" title="เลือกแพทย์" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_doctor/' . $encrypted_id . '">'.$btn_swal_text.'</button>';
				} else $btn_swal = '';

				$data[] = [
					'row_number' => "<div class='text-center'>".($start + $index + 1)."</div>",
					'apm_ql_code' => "<div class='text-center'>".$apm['apm_ql_code']."</div>",
					'pt_member' => "<div class='text-center'>".$apm['pt_member']."</div>",
					'pt_name' => $apm['pt_name'],
					'apm_date' => "<div class='text-center'>".convertToThaiYear($apm['apm_date'], false)."</div>",
					'apm_time' => "<div class='text-center'>".$apm['apm_time']."</div>",
					'ps_name' => $ps_name . $btn_swal,
					'apm_pri_id' => "<div class='text-center' data-color-pr='".$apm['pri_color']."'>".$apm['pri_name']."</div>",
					'status' => '<div class="text-center"> <i class="bi-circle-fill ' . $status_class . '"></i> ' . $status_text."</div>",
					'actions' => "<div class='text-center option'>".$btn."</div>",
				];
			}
		}
		
		$response = [
			'draw' => intval($this->input->post('draw')),
			'recordsTotal' => $total_appointments,
			'recordsFiltered' => $total_appointments,
			'data' => $data,
            'badge' => $badge
		];
		echo json_encode($response);
	}

	/*
	* get_current_que
	* get current que of today
	* @input -
	* $output ql_code
	* @author 02/08/2024
	* @Create Date Areerat Pongurai
	*/
	public function get_current_que() {
		$date = date('Y-m-d');

		// $data['que'] = $this->m_que_appointment->get_appointment_by_code($apm_ql_code)->result_array();
		if(!empty($this->session->userdata('stde_person')))
			$stde_ids = array_column($this->session->userdata('stde_person'), 'stde_id');
		else
			$stde_ids = [];
		// $stde = 21;// เดี๋ยวเอา session // $data['que'][0]['apm_stde_id'];
		// $ntdp_rdp_id = $data['que'][0]['ntdp_rdp_id'];
		// $ntdp_ds_id = $data['que'][0]['ntdp_ds_id'];
		// $ntdp_dst_id = $data['que'][0]['ntdp_dst_id'];
		$sta_id = 2; //$data['que'][0]['apm_sta_id'];
		// $apm_ql_code = $data['que'][0]['apm_ql_code'];
		// $ps_id = $data['que'][0]['apm_ps_id'];

		$data['curr_que'] = [];
		if(!empty($stde_ids)) {
			$this->load->model('wts/m_wts_temp');
			$curr_que = $this->m_wts_temp->get_current_que_by_stde($date, $sta_id, $stde_ids)->result_array();
	
			if(empty($curr_que)) {
				// เดี๋ยวเอาคิวล่าสุดที่ gen
			} else {
				$data['curr_que'] = $curr_que;
			}
		}
		
		// if(empty($data['pre_que'])) {
		// 	$data['pre_que'] = $this->m_wts_notifications_department->get_present_que_by_sta_id($date, $stde, $ntdp_rdp_id, $ntdp_ds_id, $ntdp_dst_id, $ps_id, $sta_id)->result_array();
		// 	$pre_que = $data['pre_que'][0]['apm_ql_code'];
		// 	// $pt_que = $data['pt_que'][0]['apm_ql_code'];
		// } else {
		// 	$pre_que = $data['pre_que'][0]['apm_ql_code'];
		// 	// $pt_que = $data['pt_que'][0]['apm_ql_code'];
		// }

		$response = [
			'data' => $data
		];
		echo json_encode($response);
	}

	public function queue_search() {
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);
		
		$searchParams = array(
			'date' => $data['date'] ?? '',
			'doctor' => $data['doctor'] ?? '',
			'patientId' => $data['patientId'] ?? '',
			'patientName' => $data['patientName'] ?? '',
			'sta_id' =>  $data['sta'] ?? ''
		);
		$result = $this->M_que_appointment->search_appointments($searchParams,$this->session->userdata('us_ps_id'));
		$count = count($result);
		$appointments = $result;
		foreach ($appointments as &$apm) {
			$apm['apm_id'] = encrypt_id($apm['apm_id']);
		}

		$response = [
			'status' => 'success',
			'appointments' => $appointments,
			'count' => $count
		];
		echo json_encode($response);
	}

	public function form_info($appointment_id = '') {
		$appointment_id = decrypt_id($appointment_id);
		
		if ($appointment_id) {
			$data['get_base_noti'] = $this->M_que_appointment->get_base_noti()->result_array();
			$data['get_appointment'] = $this->M_que_appointment->get_appointment_by_id($appointment_id)->row_array();
			$notificationName = '-';
			  
			  // Iterate through get_base_noti to find a matching ntf_id
			  foreach ($data['get_base_noti'] as $notification) {
				  if ($data['get_appointment']['apm_ntf_id'] == $notification['ntf_id']) {
					  $notificationName = $notification['ntf_name'];
					  break; // Exit loop once a match is found
				  }
			  }
			  $data['notification_name'] = $notificationName;
		  }
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$data['status_response'] = $this->config->item('status_response_show');
    	$this->output('wts/manage/v_manage_form_info', $data);
	}

	public function doctor_list() {
		$doctors = $this->M_que_appointment->get_doctors_by_department()->result_array();
		$response = [
			'status' => 'success',
			'appointments' => $doctors
		];
		echo json_encode($response);
	}

	public function status_list() {
		$status = $this->M_que_appointment->get_all_status_list(true)->result_array();
		$response = [
			'status' => 'success',
			'appointments' => $status
		];
		echo json_encode($response);
	}

	public function assign_doctor($apm_id) {
		$apm_id = decrypt_id($apm_id);
		$this->M_que_appointment->apm_id = $apm_id;
		$this->M_que_appointment->apm_ps_id = $this->input->post('ps_id');
		$this->M_que_appointment->update_pt_id();
		$response = [
			'status_response' => $this->config->item('status_response_success'),
			
		];
		echo json_encode($response);
	}

	// boom 18/9/2567
  public function connect_his_database()
  {
      $host = $this->config->item('his_host');
      $dbname = $this->config->item('his_dbname_tab');
      $username = $this->config->item('his_username');
      $password = $this->config->item('his_password');
      try {
          // สร้างการเชื่อมต่อฐานข้อมูลด้วย PDO
          $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
          // ตั้งค่า PDO ให้แสดงข้อผิดพลาดเป็น Exception
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $pdo;
      } catch (PDOException $e) {
          // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
          // echo "เกิดข้อผิดพลาด: " . $e->getMessage();
          return null;
      }
  }

	
	public function assign_status($apm_id) {
		$apm_id = decrypt_id($apm_id);

		$this->load->model('ams/M_ams_notification_result');
		
		$this->M_que_appointment->apm_id = $apm_id;
		$this->M_que_appointment->apm_sta_id = $this->input->post('sta_id');
		$this->M_que_appointment->update_status();

		$appointment = $this->M_que_appointment->get_appointment_by_id($apm_id)->result_array();
		if($this->input->post('sta_id')==2){ // เรียกพบแพทย์
			$apm_id_is_exists = $this->M_ams_notification_result->check_apm_id_exists($apm_id);
			if($apm_id_is_exists){
				$noti_result = $this->M_ams_notification_result->get_ntr_by_apm_id($apm_id)->row();
				if($noti_result->ntr_ast_id != 10) { // 'TS' ได้รับผลตรวจจากเครื่องมือหัตถการแล้ว
					// $this->M_ams_notification_result->ntr_id = $noti_result->ntr_id; 
					// $this->M_ams_notification_result->ntr_ast_id = 4; //รอบันทึกผล 
					// change_noti()
					
					$this->M_ams_notification_result->ntr_apm_id = $apm_id;
					$this->M_ams_notification_result->ntr_pt_id = $appointment[0]['pt_id'];
					$this->M_ams_notification_result->ntr_ps_id = $appointment[0]['ps_id'];
					$this->M_ams_notification_result->ntr_ntf_id = $appointment[0]['apm_ntf_id'];
					$this->M_ams_notification_result->ntr_ast_id = 3; //รอบันทึกผล 
					$this->M_ams_notification_result->ntr_update_user = $this->session->userdata('us_id');
					$this->M_ams_notification_result->ntr_update_date = date('Y-m-d H:i:s');
					$this->M_ams_notification_result->update_if_apm_id_exists();
				}
			}	
			else {
				$this->M_ams_notification_result->ntr_apm_id = $apm_id;
				$this->M_ams_notification_result->ntr_pt_id = $appointment[0]['pt_id'];
				$this->M_ams_notification_result->ntr_ps_id = $appointment[0]['ps_id'];
				$this->M_ams_notification_result->ntr_ntf_id = $appointment[0]['apm_ntf_id'];
				$this->M_ams_notification_result->ntr_ast_id = 3; //รอบันทึกผล 
				$this->M_ams_notification_result->ntr_create_user = $this->session->userdata('us_id');
				$this->M_ams_notification_result->ntr_create_date = date('Y-m-d H:i:s');
				$this->M_ams_notification_result->insert();
			}

			// [WTS] save insert log timeline in wts_notifications_department
            $this->load->model('wts/m_wts_notifications_department');
            $this->m_wts_notifications_department->ntdp_apm_id = $apm_id;
            $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();

			$start_date = new DateTime();
			// $start_date->modify("+1 minutes"); // ทำเพื่อไม่ให้เวลากระชั้นชิดมากเกินไป
			$ntdp_loc_id = 6; // เข้าแผนก (default)
            if(!empty($last_noti_dept)) {
				$ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id;
                $this->m_wts_notifications_department->ntdp_loc_cf_id = $ntdp_loc_cf_id; // ก่อนหน้านั้นมาจาก location ไหน

				if(!in_array($ntdp_loc_cf_id, [5, 10])) { // 5-รับหมายเลขคิว, 10-ชำระเงิน
					$ntdp_loc_id = 8; // พบแพทย์
				}
            }
      // echo $ntdp_loc_id;
			// บันทึก date/time end สำหรับแจ้งเตือนแพทย์
			if($ntdp_loc_id == 8) { // พบแพทย์
				$end_date = null;
				// get deadline for เวลาสำหรับพบผู้ป่วยของแพทย์ by wts_base_disease_time
				// if(!empty($appointment->apm_ds_id)) {
				// 	// get wts_base_disease_time data for add minutes
				// 	$this->load->model('wts/m_wts_base_disease_time');
				// 	$disease_times = $this->m_wts_base_disease_time->get_all_dst_by_ds_id($appointment->apm_ds_id)->result_array();
				// 	$doctor_seen_times = array_filter($disease_times, function($time) {
				// 		return $time['dst_is_see_doctor'] == 1;
				// 	});
				// 	if(!empty($doctor_seen_times) && !empty($doctor_seen_times[0]['dst_minute'])) {
				// 		$end_date = clone $start_date;
				// 		$end_date->modify("+$doctor_seen_times[0]['dst_minute'] minutes");
				// 	}
				// }

				// 20240916 Areerat - get deadline for เวลาสำหรับพบผู้ป่วยของแพทย์ by ums_user_config
				if(!empty($appointment[0]['ps_id'])) {
					$this->load->model('ums/m_ums_user_config');
					$this->m_ums_user_config->usc_ps_id = $appointment[0]['ps_id'];
					$user_config = $this->m_ums_user_config->get_by_ps_id()->row();

					if(!empty($user_config) && !empty($user_config->usc_ams_minute)) {
						$end_date = clone $start_date;
						$end_date->modify("+$user_config->usc_ams_minute minutes");
					}
				}
				if(empty($end_date)) { // default
					$end_date = clone $start_date;
					$end_date->modify("+15 minutes");
				}

        $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "'.$apm_id.'" ORDER BY ntdp_id DESC LIMIT 1');
        $ntdp_desc = $ntdp->row()->ntdp_apm_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        $ntdp_desc_id = $ntdp->row()->ntdp_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        $ntdp_desc_seq = $ntdp->row()->ntdp_seq; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที

        // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department 
        $ntdp_apm_id_1 = $ntdp_desc;  // ใช้ apm_id ที่ค้นพบได้
        $ntdp_seq_1 = $ntdp_desc_seq;
        $ntdp_date_end_1 = $start_date->format('Y-m-d');
        $ntdp_time_end_1 = $start_date->format('H:i:s');

        $wts_update_data = array(
          'ntdp_date_finish' => $ntdp_date_end_1,
          'ntdp_time_finish' => $ntdp_time_end_1
        );

        $this->wts = $this->load->database('wts', TRUE);
        $this->wts_db = $this->wts->database;
        
        // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
        $this->wts->select('ntdp_seq')
          ->from('wts_notifications_department')
          ->where('ntdp_apm_id', $ntdp_apm_id_1)
          ->order_by('ntdp_seq', 'DESC')
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

				$this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
				$this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:s');
			}

      
      $sql_user = $this->M_que_appointment->get_user($this->session->userdata('us_ps_id'))->result_array();
      $sql_room = $this->M_que_appointment->get_room($apm_id)->result_array();
      $appointment_dep = $this->M_que_appointment->get_appointment_by_id($apm_id)->result_array();


      $this->m_wts_notifications_department->ntdp_loc_id = $ntdp_loc_id;
      $this->m_wts_notifications_department->ntdp_seq = $ntdp_loc_id; // ตาม ntdp_loc_Id
      $this->m_wts_notifications_department->ntdp_date_start = $start_date->format('Y-m-d');
      $this->m_wts_notifications_department->ntdp_time_start = $start_date->format('H:i:s');
      $this->m_wts_notifications_department->ntdp_sta_id = 2; // รอแจ้งเตือน
      $this->m_wts_notifications_department->ntdp_in_out = 0;
      $this->m_wts_notifications_department->ntdp_loc_ft_Id = $sql_room[0]['rm_his_id'];
      $this->m_wts_notifications_department->ntdp_function = 'assign_status';
      $this->m_wts_notifications_department->insert();

      // pre($sql_room); die;
      $pdo = $this->connect_his_database();
      $sql = "INSERT INTO tabDoctorRoom (visit, sender_name, sender_last_name, sending_location_room, datetime_sent, doctor_room, location) 
      VALUES (:visit, :sender_name, :sender_last_name, :sending_location_room, :datetime_sent, :doctor_room, :location)";
      $stmt = $pdo->prepare($sql);
      // if ($pdo && !empty($sql_user) && !empty($sql_room)) { // Check if PDO and data are valid
        // Binding Parameters
        switch ($appointment_dep[0]['stde_name_th']) {
          case 'ภาคจักษุวิทยา (EYE)':
              $sending_location_room = $this->config->item('wts_room_ood');
              // $sending_location_room = 5;
              break;
          case 'ภาคโสต ศอ นาสิก (ENT)':
          // case 'แผนกผู้ป่วยนอกสูตินรีเวช':
          // case 'แผนกผู้ป่วยนอกอายุรกรรม':
          case 'จิตแพทย์':
              $sending_location_room = $this->config->item('wts_room_floor2');
              // $sending_location_room = 7;
              break;
          case 'ภาคทันตกรรม (DEN)':
              $sending_location_room = $this->config->item('wts_room_dd');
              // $sending_location_room = 10;
              break;
          case 'แผนกศูนย์เคลียร์เลสิค':
              $sending_location_room = $this->config->item('wts_room_rel');
              // $sending_location_room = 28;
              break;
          case 'ภาครังสีวิทยา (RAD)':
              $sending_location_room = '8';
              break;
          case 'แผนกเทคนิคการแพทย์':
            $sending_location_room = '14';
            break;
          default:
              $sending_location_room = '0'; // Default room, ensure you handle unexpected cases
              break;
        }
        $datetime_sent = (new DateTime())->format('Y-m-d H:i:s');
        $location = $this->session->userdata('us_dp_id');
        $stmt->bindParam(':visit', $appointment[0]['apm_visit']);
        $stmt->bindParam(':sender_name', $sql_user[0]['ps_fname']);
        $stmt->bindParam(':sender_last_name', $sql_user[0]['ps_lname']);
        $stmt->bindParam(':sending_location_room', $sending_location_room);
        $stmt->bindParam(':datetime_sent', $datetime_sent);
        $stmt->bindParam(':doctor_room', $sql_room[0]['rm_his_id']);
        $stmt->bindParam(':location', $location);

        // Execute the query
          try {
            $stmt->execute();
          } catch (PDOException $e) {
            // Handle exception if needed
            echo "Error: " . $e->getMessage();
        }
        

      // } else {
      //   echo "Error: Unable to connect to the database or fetch necessary data.";
      // }
			// // [WTS] (old) save insert log timeline in wts_notifications_department
			// $this->load->model('wts/m_wts_notifications_department');
			// $this->m_wts_notifications_department->ntdp_apm_id = $apm_id;
			// $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();

			// if(!empty($last_noti_dept)) {
			// 	// use data from last row sort by ntdp_seq DESC
			// 	$this->m_wts_notifications_department->ntdp_ds_id = $last_noti_dept->ntdp_ds_id;
			// 	$this->m_wts_notifications_department->ntdp_seq = ($last_noti_dept->ntdp_seq + 1);

			// 	if(!empty($last_noti_dept->ntdp_rdp_id)) {
			// 		$this->m_wts_notifications_department->ntdp_rdp_id = $last_noti_dept->ntdp_rdp_id;

			// 		// if เส้นทางนั้นมีจุดที่เป็นพบแพทย์ไหม
			// 		// ntdp_dst_id = $last_noti_dept->ntdp_rdp_id -> find first rt_dst_id that is_see_doctor in wts_base_route_time
			// 		$this->load->model('wts/m_wts_base_route_time');
			// 		$rt_dst_id = $this->m_wts_base_route_time->get_route_time_see_doctor_by_rdp_id($last_noti_dept->ntdp_rdp_id)->row();
			// 		if(!empty($rt_dst_id->dst_id))
			// 			$this->m_wts_notifications_department->ntdp_dst_id = $rt_dst_id->dst_id; // พบแพทย์ ของเส้นทางนั้น
			// 		else
			// 			$this->m_wts_notifications_department->ntdp_dst_id = 3; // พบแพทย์ ของ Default
			// 	}
			// } else {
			// 	$this->m_wts_notifications_department->ntdp_ds_id = $appointment[0]['apm_ds_id'];
			// 	$this->m_wts_notifications_department->ntdp_seq = 1;

			// 	// get data 
			// 	$this->load->model('wts/m_wts_base_route_department');
			// 	$this->m_wts_base_route_department->rdp_stde_id = $appointment[0]['apm_stde_id'];
			// 	$this->m_wts_base_route_department->rdp_ds_id = $appointment[0]['apm_ds_id'];
			// 	$base_route_department = $this->m_wts_base_route_department->get_by_stde_and_ds()->row();

			// 	if(!empty($base_route_department)) {
			// 		$this->m_wts_notifications_department->ntdp_rdp_id = $base_route_department->rdp_id;
					
			// 		// if เส้นทางนั้นมีจุดที่เป็นพบแพทย์ไหม
			// 		// ntdp_dst_id = 
			// 		// 1. appointment->apm_stde_id + appointment->apm_ds_id = find rdp_id (can use from $base_route_department)
			// 		// 2. rdp_id -> find first rt_dst_id that is_see_doctor in wts_base_route_time
			// 		$this->load->model('wts/m_wts_base_route_time');
			// 		$rt_dst_id = $this->m_wts_base_route_time->get_route_time_see_doctor_by_rdp_id($base_route_department->rdp_id)->row();
			// 		if(!empty($rt_dst_id->dst_id))
			// 			$this->m_wts_notifications_department->ntdp_dst_id = $rt_dst_id->dst_id; // พบแพทย์ ของเส้นทางนั้น
			// 		else
			// 			$this->m_wts_notifications_department->ntdp_dst_id = 3; // พบแพทย์ ของ Default
			// 	}
			// }

			// // get wts_base_disease_time data
			// $this->load->model('wts/m_wts_base_disease_time');
			// $this->m_wts_base_disease_time->dst_id = $this->m_wts_notifications_department->ntdp_dst_id; // พบแพทย์
			// $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

			// $start_date = new DateTime();
			// $start_date->modify("+1 minutes"); // ทำเพื่อไม่ให้เวลากระชั้นชิดมากเกินไป
			// $end_date = clone $start_date;
			// $end_date->modify("+$base_disease_time->dst_minute minutes");

			// $this->m_wts_notifications_department->ntdp_date_start = $start_date->format('Y-m-d');
			// $this->m_wts_notifications_department->ntdp_time_start = $start_date->format('H:i:00');
			// $this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
			// $this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:00');

			// $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
			// $this->m_wts_notifications_department->insert();
			
			// [AMS] go to noti result
			// $noti_result_url = base_url() . 'index.php/ams/Notification_result/update_form_from_que/' . $apm_id;
      // echo $apm_id; die;
			$noti_result_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . encrypt_id($apm_id);

		} else {
			$noti_result_url = '';
		}
		
		$response = [
			'status_response' => $this->config->item('status_response_success'),
			'returnUrl' => $noti_result_url,
		];
		echo json_encode($response);
	}

	/*
	* Manage_queue_result_info
	* get ams_notifications_result data of patient for officer process next wts_base_disease_time
	* @input apm_id (que appointment id)
	* $output screen of notification result data of patient
	* @author Areerat Pongurai
	* @Create Date 19/07/2024
	*/
	public function Manage_queue_result_info($is_view, $apm_id) {
    
        $data['actor'] = "officer";
        $data['is_view'] = $is_view; // = 0
		
        $data['apm_id'] = $apm_id;
        $apm_id = decrypt_id($apm_id);
        // echo  $data['is_view']; 
        // echo $apm_id; die;
        // [WTS] get WTS m_que_appointment
		$this->load->model('que/m_que_appointment');
		$this->m_que_appointment->apm_id = $apm_id;
		$que_appointment = $this->m_que_appointment->get_by_key()->row();

		// [AMS] get notification_result from doctor of que
		$this->load->model('ams/M_ams_notification_result');
    $data['detail'] = $this->M_ams_notification_result->get_by_apm_id($apm_id)->row();

		if(empty($data['detail'])) {
			// [AMS] craete new ams_notification_result, and take info from [QUE] que_appointment
			$this->M_ams_notification_result->ntr_apm_id = $apm_id;
			$this->M_ams_notification_result->ntr_pt_id = $que_appointment->apm_pt_id;
			$this->M_ams_notification_result->ntr_ps_id = $que_appointment->apm_ps_id;
			$this->M_ams_notification_result->ntr_ntf_id = $que_appointment->apm_ntf_id;
			$this->M_ams_notification_result->ntr_ast_id = 3; //รอบันทึกผล 
			$this->M_ams_notification_result->ntr_create_user = $this->session->userdata('us_id');
			$this->M_ams_notification_result->ntr_create_date = date('Y-m-d H:i:s');
			$this->M_ams_notification_result->insert();

			$data['detail'] = $this->M_ams_notification_result->get_by_apm_id($apm_id)->row();

			$id = $data['detail']->ntr_id;

			// // [DIM] update exr_ntr_id from exr_ap_id
        	// $this->load->model('dim/m_dim_examination_result');
			// $this->m_dim_examination_result->update_exr_ntr_id_by_apm_id($id, $que_appointment->apm_parent_id);
		
			$data['id'] = encrypt_id($id);
		}

		$id = $data['detail']->ntr_id;
		$data['id'] = encrypt_id($id);

		// [AMS] appointment && [DIM] get draft tools
    $this->load->model('dim/m_dim_examination_result');
		$this->load->model('ams/m_ams_appointment');
		$this->m_ams_appointment->ap_ntr_id = $id;
		$appointment = $this->m_ams_appointment->get_by_ntr_id()->row();
		if(!empty($appointment)) {
            // [DIM] get draft tools
            $this->m_dim_examination_result->exr_ap_id = $appointment->ap_id;
            $exam_results = $this->m_dim_examination_result->get_by_ap_id()->result_array();
            $names = ['exr_id', 'exr_ap_id', 'exr_eqs_id', 'rm_id']; // object name need to encrypt
            $data['ap_tool_drafts'] = encrypt_arr_obj_id($exam_results, $names);

			// condition if ams_appointment is same date with que_appointment 
			// 			 then dont show this ams_appointment but set in screen for input new ams_appointment
			if($appointment->ap_date != $que_appointment->apm_date) {
				// encrypt id
				$names = ['ap_id']; // object name need to encrypt
				$appointment->ap_id = encrypt_id($appointment->ap_id);
				$data['appointment'] = $appointment;
			}
		}
		
		// [DIM] get DIM examination result
		$this->m_dim_examination_result->exr_ntr_id = $id;
		$exam_results = $this->m_dim_examination_result->get_by_ntr_id()->result_array();
		$names = ['exr_id', 'exr_eqs_id', 'rm_id']; // object name need to encrypt
		$data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        // [WTS] get WTS department_disease_tool (as default for select tools)
		$this->load->model('wts/m_wts_department_disease_tool');
		// tool of disease
		$names = ['ddt_id', 'ddt_eqs_id', 'eqs_rm_id']; // object name need to encrypt 
		if(!empty($que_appointment->apm_ds_id)) {
			$params = ['ddt_stde_id' => $que_appointment->apm_stde_id, 'ddt_ds_id' => $que_appointment->apm_ds_id, 'is_null_ddt_ds_id' => false];
			$tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();
			$data['tools'] = encrypt_arr_obj_id($tools, $names);
		} else {
			$data['tools'] = [];
		}
		// tool default of stde
		$params = ['ddt_stde_id' => $que_appointment->apm_stde_id, 'is_null_ddt_ds_id' => true];
		$tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();
		$data['tools_default'] = encrypt_arr_obj_id($tools, $names);
		// $data['tools_default'] = [];

		// current ams_ntr find next ams_ntr
		// next ams_ntr find dim_exr draft (รอ CF อาจจะไม่เอาc8jสถานะ draft vk00tgvkmyh's,f)
		// เอามา show ของที่กำหนดในคิวครั้งหน้า

		// // [WTS] get notifications_department.ntdp_rdp_id for officer select next wts_base_route_department by last row notifications_department
		// $this->load->model('wts/m_wts_notifications_department');
		// $this->m_wts_notifications_department->ntdp_apm_id = $apm_id;
		// $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
		// $data['ntdp_dst_id'] = $last_noti_dept->ntdp_dst_id;

		// // 1 get ddl of wts_base_route_time
		// $this->load->model('wts/m_wts_base_route_time');
		// $route_dsts = $this->m_wts_base_route_time->get_all_route_time_list($last_noti_dept->ntdp_rdp_id)->result_array();
		// // 1.1 Find the object with 'dst_is_see_doctor' and get its 'rt_seq'
		// $seq_to_compare = null;
		// foreach ($route_dsts as $route_dst) {
		// 	if (!empty($route_dst['dst_is_see_doctor']) && $route_dst['dst_is_see_doctor']) {
		// 		$seq_to_compare = $route_dst['rt_seq'];
		// 		break;
		// 	}
		// }
		// // 1.2 If a matching object was found, filter the array to include only objects with 'rt_seq' greater than 'seq_to_compare'
		// if ($seq_to_compare !== null) {
		// 	$route_dsts = array_filter($route_dsts, function($route_dst) use ($seq_to_compare) {
		// 		return $route_dst['rt_seq'] > $seq_to_compare;
		// 	});

		// 	// Re-index the array to reset the keys
		// 	$route_dsts = array_values($route_dsts);
		// }
		// // 1.3 encrypt id ddl
		// $names = ['dst_id']; // object name need to encrypt
		// $data['route_dsts'] = encrypt_arr_obj_id($route_dsts, $names);

		// 2. general ddl
        $this->load->model('eqs/m_eqs_room');
        $order = array('rm_name' => 'ASC');
        $rooms = $this->m_eqs_room->get_rooms_tools($order)->result_array();

        $this->load->model('eqs/m_eqs_equipments');
        $order = array('eqs_name' => 'ASC');
        $equipments = $this->m_eqs_equipments->get_all($order)->result_array();

        // encrypt id ddl
        $names = ['rm_id']; // object name need to encrypt
        $data['rooms'] = encrypt_arr_obj_id($rooms, $names);
        $names = ['eqs_id', 'eqs_rm_id']; // object name need to encrypt
        $data['equipments'] = encrypt_arr_obj_id($equipments, $names);

        // $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        // $data['status_response'] = $this->config->item('status_response_show');
        // $this->output('ams/notification_result/v_notification_result_update_form',$data);   

        $this->load->view('ams/notification_result/v_notification_result_update_form', $data);
  	}
}

?>