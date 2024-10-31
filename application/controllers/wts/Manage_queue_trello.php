<?php
/*
* Manage_queue_trello
* Controller หลักของจัดการคิว
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 19/08/2024
dev
*/

if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Manage_queue_trello extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
		$this->view_dir = 'wts/manage/trello/';
		// ini_set('memory_limit', '10000M');
		// ini_set('max_execution_time', 600);
	}

	/*
	* index
	* Index controller of Manage_queue_trello
	* @input -
	* $output screen of queues each doctor
	* @author Areerat Pongurai
	* @Create Date 19/08/2024
	*/
	public function index()
	{
		$this->load->model('que/m_que_appointment');
		$wts_stde_id = $this->session->userdata('wts_stde_id');
		$ps_id = $this->session->userdata('us_ps_id');
		$stdes = $this->m_que_appointment->get_stde_id_by_ps_id($ps_id);
		if (empty($wts_stde_id)) {
			if (!empty($stdes) && count($stdes) == 1) {
				$data['wts_stde_id'] = $stdes[0]['stde_id'];
				$this->session->set_userdata('wts_stde_id', $stdes[0]['stde_id']);
			} else {
				$data['wts_stde_id'] = null;
			}
		} else {
			$data['wts_stde_id'] = $wts_stde_id;
		}

		$data['view_dir'] = $this->view_dir;

		if (!empty($stdes)) {
			$stde_ids = array_column($stdes, 'stde_id');
			// $doctors = $this->m_que_appointment->get_doctors_by_departments_array($stde_ids)->result_array();
			$doctors = [];
			foreach ($stde_ids as $item) {
				$doctors = array_merge($doctors, $this->m_que_appointment->get_doctors_by_department($item)->result_array());
			}
		} else {
			$doctors = $this->m_que_appointment->get_doctors_by_department()->result_array();
		}
		// Step 1: Extract the specific key values from the array
		$doctor_ids = array_column($doctors, 'ps_id');
		// Step 2: Use array_unique to remove duplicate values
		$unique_ids = array_unique($doctor_ids);
		// Step 3: Filter the original array to only include unique doctor entries
		$unique_doctors = array_filter($doctors, function ($doctor) use ($unique_ids) {
			static $used_ids = []; // keep track of used ids
			if (in_array($doctor['ps_id'], $unique_ids) && !in_array($doctor['ps_id'], $used_ids)) {
				$used_ids[] = $doctor['ps_id'];
				return true;
			}
			return false;
		});

		// Step 4: Reindex the array
		$unique_doctors = array_values($unique_doctors);

		// [HR] get qus_psrm_id from hr_person_room
		$this->load->model('hr/m_hr_person_room');
		$date = date('Y-m-d');
		foreach ($unique_doctors as  $key => $doc) {
			$params = ['date' => $date, 'ps_id' => $doc['ps_id'],];
			$psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
			if (!empty($psrm)) {
				$unique_doctors[$key]['psrm_id'] = $psrm[0]['psrm_id'];
				$unique_doctors[$key]['rm_id'] = $psrm[0]['rm_id'];
				$unique_doctors[$key]['rm_name'] = $psrm[0]['rm_name'];
			} else {
				$unique_doctors[$key]['psrm_id'] = null;
				$unique_doctors[$key]['rm_id'] = null;
				$unique_doctors[$key]['rm_name'] = 'เลือกห้องตรวจ';
			}
		}

		$this->load->model('eqs/m_eqs_room');
		$data['rooms'] = $this->m_eqs_room->get_all_by_rm_bdtype_id(2)->result_array(); // 2 = ห้องทำงาน

		$data['get_doctors'] = $unique_doctors; // for gen card doctors

		// encrypt id ddl
		$names = ['stde_id']; // object name need to encrypt
		$data['stdes'] = encrypt_arr_obj_id($stdes, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/manage/trello/v_manage_trello_show', $data);
	}

	/*
	* floor
	* screen of manage queue group by floor
	* @input -
	* $output screen of queues each doctor in floor
	* @author Areerat Pongurai
	* @Create Date 09/09/2024

	  Condition
	  1. นำชั้นมาเช็คว่าแต่ละห้องเป็นของแผนกอะไรบ้าง
	  2. นำแผนกทั้งหมดที่ได้ไปหาแพทย์ของแต่ละแผนก
	  3. นำแพทย์ทั้งหมดที่ได้ไปหา que_appointment ของแต่ละแพทย์
	*/
	public function floor()
	{
    
		$data['view_dir'] = $this->view_dir;

		$wts_floor_of_manage_queue = $this->session->userdata('wts_floor_of_manage_queue');

		if (empty($wts_floor_of_manage_queue)) {
			$floor = null;
		} else {
			$floor = $wts_floor_of_manage_queue;
		}
		$data['floor'] = $floor;

		// Retrieve departments from session
		// pre($this->session->userdata()); die;
		$selected_departments = $this->session->userdata('selected_departments'); // This is an array of department IDs
		$data['departments'] = !empty($selected_departments) ? $selected_departments : [];

    if($data['departments'][0] == 63){
      echo 'dddss'; die;
    } else if($data['departments'][0] == 77){
      echo '12234'; die;
    }




		$this->load->model('eqs/m_eqs_room');
		$rooms = $this->m_eqs_room->get_all_by_rm_bdtype_id(2)->result_array();

		$filtered_rooms = array_filter($rooms, function ($room) {
			return !empty($room['rm_stde_id']);
		});
		$data['rooms'] = $filtered_rooms = array_values($filtered_rooms);

		// Get all doctors for create cards
		$this->load->model('que/m_que_appointment');
		$doctors = $this->m_que_appointment->get_doctors_by_department_que('66')->result_array();
		// pre($doctors); die;
		$data['dep'] = $this->m_que_appointment->get_department_que_appointment()->result_array();
		// pre($data['dep']);
		// Step 1: Extract the specific key values from the array
		$doctor_ids = array_column($doctors, 'ps_id');
		// Step 2: Use array_unique to remove duplicate values
		$unique_ids = array_unique($doctor_ids);
		// Step 3: Filter the original array to only include unique doctor entries กรองแพทย์ที่ไม่ซ้ำกัน
		$unique_doctors = array_filter($doctors, function ($doctor) use ($unique_ids) {
			static $used_ids = []; // keep track of used ids
			if (in_array($doctor['ps_id'], $unique_ids) && !in_array($doctor['ps_id'], $used_ids)) {
				$used_ids[] = $doctor['ps_id'];
				return true;
			}
			return false;
		});

		// Step 4: Reindex the array
		$unique_doctors = array_values($unique_doctors);
		// pre($unique_doctors); die;
		// [HR] get qus_psrm_id from hr_person_room
		$this->load->model('hr/m_hr_person_room');
		$this->load->model('wts/m_wts_queue_seq');
		$date = date('Y-m-d');
		foreach ($unique_doctors as  $key => $doc) {
			$params = ['date' => $date, 'ps_id' => $doc['ps_id'],];
			$psrm = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
			if (!empty($psrm)) {
				$unique_doctors[$key]['psrm_id'] = $psrm[0]['psrm_id'];
				$unique_doctors[$key]['rm_id'] = $psrm[0]['rm_id'];
				$unique_doctors[$key]['rm_name'] = $psrm[0]['rm_name'];
			} else {
				$unique_doctors[$key]['psrm_id'] = null;
				$unique_doctors[$key]['rm_id'] = null;
				$unique_doctors[$key]['rm_name'] = 'เลือกห้องตรวจ';
			}
		}

		$data['get_doctors'] = $unique_doctors; // for gen card doctors
		usort($data['get_doctors'], function($a, $b) {
			return $a['rm_id'] <=> $b['rm_id']; // เรียงจากน้อยไปมาก
		});
		// pre($data['departments']); die;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/manage/trello/v_manage_trello_floor_show', $data);
	}
	/*
	* Manage_queue_trello_set_wts_stde_id
	* set wts_stde_id in session
	* @input wts_stde_id
	* $output response
	* @author Areerat Pongurai
	* @Create Date 31/08/2024
	*/
	public function Manage_queue_trello_set_wts_stde_id()
	{
		$this->session->set_userdata('wts_stde_id', $this->input->post('wts_stde_id'));

		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* Manage_queue_trello_set_wts_floor_of_manage_queue
	* set wts_stde_id in session
	* @input wts_stde_id
	* $output response
	* @author Areerat Pongurai
	* @Create Date 31/08/2024
	*/
	public function Manage_queue_trello_set_wts_floor_of_manage_queue()
	{
		// Get the selected floor and departments from the POST request
		$wts_floor_of_manage_queue = $this->input->post('wts_floor_of_manage_queue');
		$departments = $this->input->post('departments');

		// Store floor and departments in session
		$this->session->set_userdata('wts_floor_of_manage_queue', $wts_floor_of_manage_queue);
		$this->session->set_userdata('selected_departments', $departments); // Store departments array

		// Set response data
		$data['status_response'] = $this->config->item('status_response_success');

		echo json_encode(array('data' => $data));
	}


	/*
	* Manage_queue_trello_get_doctors
	* get doctors by [QUE] que_appointments
	* @input filter data
	* $output doctor list
	* @author Areerat Pongurai
	* @Create Date 30/08/2024
	*/
	public function Manage_queue_trello_get_doctors()
	{
		// $department = decrypt_id(trim($this->input->post('department')));

		$date = $this->input->post('date');
		if (empty($date)) {
			$date = date('Y-m-d');
			$thai_year = (int)date('Y') + 543;
			$date = date('d/m/') . $thai_year;
		}
		// หน้าจอ sta = 1 คือรอดำเนินการ(นัดหมายสำเร็จ) แต่หน้าจอนี้ รอดำเนินการ = 4 ออกหมายเลขคิว
		// $sta_id = $this->input->post('sta_id');
		// if($sta_id == 1) $sta_id = 4;
		$sta_id = null; // บังคับ null เพราะต้องการรายชื่อแพทย์ของ apm ทุกสถานะ

		// แผนก multiple
		$department = $this->input->post('department');
		$stde = null;
		$stdes = [];
		if (is_array($department)) {
			foreach ($department as $stde_id) {
				$stdes[] = decrypt_id(trim($stde_id));
			}
		} else {
			$stde = decrypt_id(trim($department));
		}

		$params = [
			'month' => $this->input->post('month'),
			'date' => $date,
			'floor' => $this->input->post('floor'),
			'department' => $stde,
			'departments' => $stdes,
			'doctor' => $this->input->post('doctor'),
			'is_get_doctors' => true,
			'patientId' => $this->input->post('patientId'),
			'visitId' => $this->input->post('visitId'),
			'patientName' => $this->input->post('patientName'),
			'sta_id' => $sta_id,
			// 'search' => $search
		];

		$this->load->model('que/m_que_appointment');
		$doctors = $this->m_que_appointment->get_doctors_trello_wts($params);

		$response = [
			'doctors' => $doctors,
			// 'unique_stdes' => $unique_stdes,
		];
		echo json_encode($response);
	}

	/*
	* Manage_queue_trello_get_doctors_select
	* get doctors by stde_id for create select
	* @input list of stde_id / once stde_id
	* $output doctor list
	* @author Areerat Pongurai
	* @Create Date 31/08/2024
	*/
	public function Manage_queue_trello_get_doctors_select()
	{
		$this->load->model('que/m_que_appointment');

		// 0 get parameters
		$department = $this->input->post('department');
		$date = $this->input->post('date');
		if (empty($date)) {
			$date = date('Y-m-d');
			$thai_year = (int)date('Y') + 543;
			$date = date('d/m/') . $thai_year;
		}
		$department = $this->input->post('department');
		$stde = null;
		$stdes = [];
		if (is_array($department)) { // multiple stde_id
			foreach ($department as $stde_id) {
				$stdes[] = decrypt_id(trim($stde_id));
			}
		} else {
			$stde = decrypt_id(trim($department));
		}

		// 1 get doctors by only list of stde_id / once stde_id in hr_structure_person
		if (empty($stdes) && empty($stdes)) {
			$doctors_select = [];
		} else {
			if (!empty($stdes)) { // multiple
				$doctors_select = [];
				foreach ($stdes as $stde_id) {
					$doctors_select = array_merge($doctors_select, $this->m_que_appointment->get_doctors_by_department($stde_id)->result_array());
				}
			} else if (!empty($stde)) { // once
				$doctors_select = $this->m_que_appointment->get_doctors_by_department($stde)->result_array();
			}
		}

		// 2 get doctors by que_appointment with list of stde_id / once stde_id
		$params = [
			// 'month' => $this->input->post('month'),
			'date' => $date,
			'floor' => $this->input->post('floor'),
			'department' => $stde,
			'departments' => $stdes,
			// 'doctor' => $this->input->post('doctor'),
			'is_get_doctors' => true,
			'sta_id' => null,
		];

		$doctors = $this->m_que_appointment->get_doctors_trello_wts($params);

		// 3 Merge $doctors into $doctors_select, but avoid duplicates based on ps_id
		foreach ($doctors as $doctor) {
			$duplicate = false;
			foreach ($doctors_select as $selected_doctor) {
				if ($doctor['ps_id'] == $selected_doctor['ps_id']) {
					$duplicate = true;
					break;
				}
			}
			if (!$duplicate) {
				$doctors_select[] = $doctor;
			}
		}

		// 4 Sort $doctors_select by 'ps_name'
		usort($doctors_select, function ($a, $b) {
			return strcmp($a['ps_name'], $b['ps_name']);
		});

		$response = [
			'doctors_select' => $doctors_select,
			// 'unique_stdes' => $unique_stdes,
		];
		echo json_encode($response);
	}

	/*
	* Manage_queue_trello_get_stdes_select
	* get stde(แผนก) by floor for create select
	* @input floor
	* $output stde(แผนก) list
	* @author Areerat Pongurai
	* @Create Date 10/09/2024
	*/
	public function Manage_queue_trello_get_stdes_select()
	{
		$floor = $this->input->post('floor');

		$this->load->model('eqs/m_eqs_room');
		$rooms = $this->m_eqs_room->get_room_by_floor($floor)->result_array();
		$filtered_rooms = array_filter($rooms, function ($room) {
			return $room['rm_bdtype_id'] == 2 && !empty($room['rm_stde_id']);
		});

		$rm_stde_ids = array_column($filtered_rooms, 'rm_stde_id');
		$rm_stde_ids = array_unique($rm_stde_ids);

		$stdes_select = array_filter($filtered_rooms, function ($doctor) use ($rm_stde_ids) {
			static $used_ids = []; // keep track of used ids
			if (in_array($doctor['rm_stde_id'], $rm_stde_ids) && !in_array($doctor['rm_stde_id'], $used_ids)) {
				$used_ids[] = $doctor['rm_stde_id'];
				return true;
			}
			return false;
		});
		$stdes_select = array_values($stdes_select);

		// encrypt id ddl
		$names = ['rm_stde_id']; // object name need to encrypt
		$stdes_select = encrypt_arr_obj_id($stdes_select, $names);

		$response = [
			'stdes_select' => $stdes_select,
			// 'unique_stdes' => $unique_stdes,
		];
		echo json_encode($response);
	}

	/*
	* Manage_queue_trello_get_ques
	* get [QUE] que_appointments by doctor
	* @input filter data
	* $output [QUE] que_appointment list by doctor
	* @author Areerat Pongurai
	* @Create Date 20/08/2024
	*/
	public function Manage_queue_trello_get_ques_old()
	{
		$date = $this->input->post('date');
		if (empty($date)) {
			$date = date('Y-m-d');
			$thai_year = (int)date('Y') + 543;
			$date = date('d/m/') . $thai_year;
		}

		// หน้าจอ sta = 1 คือรอดำเนินการ(นัดหมายสำเร็จ) แต่หน้าจอนี้ รอดำเนินการ = 4 ออกหมายเลขคิว
		$sta_id = $this->input->post('sta_id');
		if ($sta_id == 1) $sta_id = 4;

		// แผนก multiple
		$department = $this->input->post('department');
		$stde = null;
		$stdes = [];
		if (is_array($department)) {
			foreach ($department as $stde_id) {
				$stdes[] = decrypt_id(trim($stde_id));
			}
		} else {
			$stde = decrypt_id(trim($department));
		}
		$doctor_base = $this->get_doctor_by_stde_select($stdes);
		// $doctor_base = $this->get_doctor_by_stde_select();
		$params = [
			'month' => $this->input->post('month'),
			'date' => $date,
			'floor' => $this->input->post('floor'),
			'department' => $stde,
			'departments' => $stdes,
			'doctor' => $this->input->post('doctor'),
			'is_null_ps_id' => filter_var($this->input->post('is_null_ps_id'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
			'is_process' => filter_var($this->input->post('is_process'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
			'patientId' => $this->input->post('patientId'),
			'visitId' => $this->input->post('visitId'),
			'patientName' => $this->input->post('patientName'),
			'sta_id' => $sta_id,
			// 'search' => $search
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

		$this->load->model('que/m_que_appointment');
		$this->load->model('wts/m_wts_queue_seq');
		$result = $this->m_que_appointment->get_appointment_trello_wts_old($params);
		// $note = $this->m_wts_queue_seq->get_announce_trello_wts($params);
		// pre($note);		
		// Create an array to hold task data
		$tasks = [];
		$announce = [];
		$list = [];
		foreach ($result as $key => $task) {
			// pre($task);
			$encrypted_id = encrypt_id($task['apm_id']);
			$is_have_ps_id = isset($task['apm_ps_id']) && !empty($task['apm_ps_id']) ? true : false;

			$status_text = "รอดำเนินการ";
			$status_class = "text-warning";
			$btn_url = site_url('wts/Manage_queue/form_info/') . '/' . $encrypted_id;
			$btn_noti_result_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
             
			$encrypted_visit = encrypt_id($task['apm_visit']);
			$btn_apm_url = site_url('wts/Manage_queue_trello/Manage_queue_trello_apm_info') . '/' . $encrypted_id;
			// $btn_apm_url = site_url('que/Appointment/add_appointment_step2') . '/' . $encrypted_id;

			// $btn = '<button class="btn btn-info" title="ข้อมูลการนัดหมาย" onclick="navigateToAddAppointmentStep2(\'' . $encrypted_id . '\')"><i class="bi-clipboard-check"></i></button>';

			// $btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $$btn_apm_url . '\')"><i class="bi-search"></i></button>'
			// 		. '<button class="btn btn-warning swal-status" title="สถานะคิว" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '"><i class="bi bi-calendar2"></i></button>';

			$apm_sta_id = $task['apm_sta_id'];
			
			// echo $apm_sta_id; die;
			// [AMS] url to next page
			if($task['apm_ps_id'] == null || $task['apm_ps_id'] == ''){
				$btn = '<button class="btn btn-success ms-1 tooltips" onclick ="finished_process('."'".$encrypted_id."'".')"  title="สิ้นสุดการพบแพทย์" onclick=""><i class="bi bi-bookmark-check"> </i> </button>';
				$btn .= '<button class="btn btn-primary ms-1" onclick="select_doctor('."'".$encrypted_id."'".')"><i class="bi bi-person"> </i></button>';
				$btn .= '<button class="btn btn-info tooltips ms-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			}else{
				$btn = '<button class="btn btn-success ms-1 tooltips" onclick ="finished_process('."'".$encrypted_id."'".')"  title="สิ้นสุดการพบแพทย์" onclick=""><i class="bi bi-bookmark-check"> </i> </button>';
				// $btn .= '<button class="btn btn-primary ms-1" onclick="select_doctor()"><i class="bi bi-person"> </i></button>';
				$btn .= '<button class="btn btn-info tooltips ms-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			}
			if ($is_have_ps_id) {
				$btn .= '<button class="btn btn-primary btn-see-doctor ms-1 tooltips" title="เข้าพบแพทย์" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_noti_result_url . '\')"><i class="bi-pencil-square"></i></button>';
				// . '<button class="btn btn-warning ms-1 swal-status" title="สถานะคิว" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '"><i class="bi bi-calendar2"></i></button>';
			}
			if ($apm_sta_id == 2) {
				$status_text = "กำลังพบแพทย์";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-success btn-see-doctor ms-1 tooltips p-0 ps-2 pe-2" title="พบแพทย์เสร็จสิ้น" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue_trello/Manage_queue_trello_success/' . $encrypted_id . '\', 10)"><i class="bi-person-fill-check font-20"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
				// $btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 11) {
				$status_text = "กำลังตรวจในห้องปฏิบัติการ";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-success btn-see-doctor ms-1 tooltips p-0 ps-2 pe-2" title="พบแพทย์เสร็จสิ้น" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue_trello/Manage_queue_trello_success/' . $encrypted_id . '\', 10)"><i class="bi-person-fill-check font-20"></i></button>'.'<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
			} elseif ($apm_sta_id == 12) {
				$status_text = "ตรวจในห้องปฏิบัติการเสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-primary btn-see-doctor ms-1 tooltips" title="เข้าพบแพทย์" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>'
					. '<button class="btn btn-success btn-see-doctor ms-1 tooltips p-0 ps-2 pe-2" title="พบแพทย์เสร็จสิ้น" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue_trello/Manage_queue_trello_success/' . $encrypted_id . '\', 10)"><i class="bi-person-fill-check font-20"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
				//  . '<button class="btn btn-success btn-see-doctor ms-1" title="เข้าพบแพทย์"><i class="bi-megaphone-fill"></i></button>';
			} elseif ($apm_sta_id == 3) {
				$status_text = "ไม่พบผู้ป่วย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info ms-1 tooltips" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 9) {
				$status_text = "ยกเลิกนัดหมาย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info ms-1 tooltips" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif (in_array($apm_sta_id, [5, 10])) {
				$status_text = "พบแพทย์เสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/1') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-outline-info ms-1 tooltips" title="ดูรายละเอียด" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 13) {
				$status_text = "คัดกรองผู้ป่วย";
				$status_class = "text-info";
			} elseif ($apm_sta_id == 14) {
				$status_text = "ตรวจสอบสิทธิ์การรักษา(จุดประกัน)";
				$status_class = "text-info";
			}

			$tasks[] = [
				'apm_id' => $encrypted_id,
				'apm_ps_id' => $task['apm_ps_id'],
				'apm_visit' => $task['apm_visit'],
				'apm_ql_code' => $task['apm_ql_code'],
				'apm_sta_id' => $apm_sta_id,
				'status_text' => $status_text,
				'status_class' => $status_class,
				'pt_member' =>$task['pt_member'],
				'apm_patient_type' => $task['apm_patient_type'],
				'ntdp_date_start' => $task['ntdp_date_start'],
				'ntdp_time_start' => $task['ntdp_time_start'],
				'apm_time' => $task['apm_time'],
				'apm_pri_id' => $task['apm_pri_id'],
				'pri_color' => $task['pri_color'],
				'pri_name' => $task['pri_name'],
				'apm_app_walk' => $task['apm_app_walk'],
				'qus_app_walk' => $task['qus_app_walk'],
				'pt_name' => $task['pt_name'],
				'btn' => $btn,
				'announce_id' => $task['qus_announce_id'],
				'announce' => $task['qus_announce'],
				'announce_time_start' => $task['qus_time_start'],
				'announce_time_end' => $task['qus_time_end']
				// Include any other fields you need to pass to the frontend
			];
		}

		// pre($tasks);
		// foreach ($note as $index => $ann) {
		// 	$announce[] = [
		// 		'psrm_ps_id' => $ann['psrm_ps_id'],
		// 		'announce_id' => $ann['qus_announce_id'],
		// 		'announce_text' => $ann['qus_announce'],
		// 		'announce_stime' => $ann['qus_time_start'],
		// 		'announce_etime' => $ann['qus_time_end']
		// 	];
		// }
		// pre($tasks);
		// $last_announce = $this->m_wts_queue_seq->get_lastest_announce_id()->result_array();

		// $announce_count = $last_announce[0]['qus_announce_id'];
		// pre($last_announce[0]['qus_announce_id']);
		$response = [
			// 'announce_count' => $announce_count,
			'tasks' => $tasks,
			'badge' => $badge,
			'doctor_list'=>$doctor_base
			// 'announce' => $announce
		];
		echo json_encode($response);
	}
	public function Manage_queue_trello_get_ques()
	{
		$date = $this->input->post('date');
		if (empty($date)) {
			$date = date('Y-m-d');
			$thai_year = (int)date('Y') + 543;
			$date = date('d/m/') . $thai_year;
		}
	
		// ตรวจสอบสถานะที่ส่งเข้ามา ถ้าเป็น sta_id = 1 จะถือว่าเป็น 4 (ออกหมายเลขคิว)
		$sta_id = $this->input->post('sta_id');
		if ($sta_id == 1) $sta_id = 4;
	
		// แผนกหลายค่า
		$department = $this->input->post('department');
		$stde = null;
		$stdes = [];
		if (is_array($department)) {
			foreach ($department as $stde_id) {
				$stdes[] = decrypt_id(trim($stde_id));
			}
		} else {
			$stde = decrypt_id(trim($department));
		}
		$doctor_base = $this->get_doctor_by_stde_select($stdes);
	
		$params = [
			'month' => $this->input->post('month'),
			'date' => $date,
			'floor' => $this->input->post('floor'),
			'department' => $stde,
			'departments' => $stdes,
			'doctor' => $this->input->post('doctor'),
			'is_null_ps_id' => filter_var($this->input->post('is_null_ps_id'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
			'is_process' => filter_var($this->input->post('is_process'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
			'patientId' => $this->input->post('patientId'),
			'visitId' => $this->input->post('visitId'),
			'patientName' => $this->input->post('patientName'),
			'sta_id' => $sta_id,
		];
	
		// ตั้งค่าข้อความ badge
		$badge = '';
		if (!empty($date)) {
			$badge = "ประจำวันที่ " . formatShortDateThai(str_replace('/', '-', $date), false);
		} else {
			if (!empty($this->input->post('month'))) {
				$badge = "ประจำเดือน " . getLongMonthThai($this->input->post('month'));
			} else {
				$badge = "ประจำวันที่ " . formatShortDateThai((new DateTime())->format('Y-m-d 00:00:00'));
			}
		}
	
		// ดึงข้อมูลการนัดหมาย
		$this->load->model('que/m_que_appointment');
		$result = $this->m_que_appointment->get_appointment_trello_wts($params);
		// ประกาศ array สำหรับ task
		$tasks = [];
		foreach ($result as $task) {
			$encrypted_id = encrypt_id($task['apm_id']);
			$is_have_ps_id = isset($task['apm_ps_id']) && !empty($task['apm_ps_id']);
	
			// ตรวจสอบสถานะและตั้งค่า status_text และ status_class
			$status_text = "รอดำเนินการ";
			$status_class = "text-warning";
			$btn_url = site_url('wts/Manage_queue/form_info/') . '/' . $encrypted_id;
			$btn_noti_result_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
			$apm_sta_id = $task['apm_sta_id'];
			$encrypted_visit = encrypt_id($task['apm_visit']);
			$btn_apm_url = site_url('wts/Manage_queue_trello/Manage_queue_trello_apm_info') . '/' . $encrypted_id;
			$btn = '<button class="btn btn-info tooltips" title="ข้อมูลการนัดหมาย"><i class="bi-search"></i></button>';
			if($task['apm_ps_id'] == null || $task['apm_ps_id'] == ''){
				$btn = '<button class="btn btn-success ms-1 tooltips" onclick ="finished_process('."'".$encrypted_id."'".')"  title="สิ้นสุดการพบแพทย์" onclick=""><i class="bi bi-bookmark-check"> </i> </button>';
				$btn .= '<button class="btn btn-primary ms-1" onclick="select_doctor('."'".$encrypted_id."'".')"><i class="bi bi-person"> </i></button>';
				$btn .= '<button class="btn btn-info tooltips ms-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			}else{
				$btn = '<button class="btn btn-success ms-1 tooltips" onclick ="finished_process('."'".$encrypted_id."'".')"  title="สิ้นสุดการพบแพทย์" onclick=""><i class="bi bi-bookmark-check"> </i> </button>';
				// $btn .= '<button class="btn btn-primary ms-1" onclick="select_doctor()"><i class="bi bi-person"> </i></button>';
				$btn .= '<button class="btn btn-info tooltips ms-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			}
			if ($is_have_ps_id) {
				$btn .= '<button class="btn btn-primary btn-see-doctor ms-1 tooltips" title="เข้าพบแพทย์" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_noti_result_url . '\')"><i class="bi-pencil-square"></i></button>';
				// . '<button class="btn btn-warning ms-1 swal-status" title="สถานะคิว" data-url="' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '"><i class="bi bi-calendar2"></i></button>';
			}
			if ($apm_sta_id == 2) {
				$status_text = "กำลังพบแพทย์";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-success btn-see-doctor ms-1 tooltips p-0 ps-2 pe-2" title="พบแพทย์เสร็จสิ้น" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue_trello/Manage_queue_trello_success/' . $encrypted_id . '\', 10)"><i class="bi-person-fill-check font-20"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
				// $btn = '<button class="btn btn-info me-1" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 11) {
				$status_text = "กำลังตรวจในห้องปฏิบัติการ";
				$status_class = "text-info";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
			} elseif ($apm_sta_id == 12) {
				$status_text = "ตรวจในห้องปฏิบัติการเสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/0') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-primary btn-see-doctor ms-1 tooltips" title="เข้าพบแพทย์" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue/assign_status/' . $encrypted_id . '\')"><i class="bi-megaphone-fill"></i></button>'
					. '<button class="btn btn-success btn-see-doctor ms-1 tooltips p-0 ps-2 pe-2" title="พบแพทย์เสร็จสิ้น" onclick="goto_see_doctor(\'' . base_url() . 'index.php/wts/Manage_queue_trello/Manage_queue_trello_success/' . $encrypted_id . '\', 10)"><i class="bi-person-fill-check font-20"></i></button>'
					. '<button class="btn btn-warning ms-1 tooltips" title="แก้ไขเครื่องมือหัตถการ" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-pencil-square"></i></button>';
				//  . '<button class="btn btn-success btn-see-doctor ms-1" title="เข้าพบแพทย์"><i class="bi-megaphone-fill"></i></button>';
			} elseif ($apm_sta_id == 3) {
				$status_text = "ไม่พบผู้ป่วย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info ms-1 tooltips" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 9) {
				$status_text = "ยกเลิกนัดหมาย";
				$status_class = "text-danger";
				$btn = '<button class="btn btn-info ms-1 tooltips" title="ข้อมูลการนัดหมาย" onclick="showModalApm(\'' . $btn_apm_url . '\')"><i class="bi-search"></i></button>';
			} elseif (in_array($apm_sta_id, [5, 10])) {
				$status_text = "พบแพทย์เสร็จแล้ว";
				$status_class = "text-success";
				$btn_url = site_url('wts/Manage_queue/Manage_queue_result_info/1') . '/' . $encrypted_id;
				$btn = '<button class="btn btn-outline-info ms-1 tooltips" title="ดูรายละเอียด" onclick="showModalNtr(\'' . $btn_url . '\')"><i class="bi-search"></i></button>';
			} elseif ($apm_sta_id == 13) {
				$status_text = "คัดกรองผู้ป่วย";
				$status_class = "text-info";
			} elseif ($apm_sta_id == 14) {
				$status_text = "ตรวจสอบสิทธิ์การรักษา(จุดประกัน)";
				$status_class = "text-info";
			}
	
			// จัดเก็บข้อมูล task
			$tasks[] = [
				'apm_id' => $encrypted_id,
				 'apm_anounce_id' => $task['apm_id'],
				'apm_ps_id' => $task['apm_ps_id'],
				'apm_visit' => $task['apm_visit'],
				'apm_ql_code' => $task['apm_ql_code'],
				'apm_sta_id' => $task['apm_sta_id'],
				'status_text' => $status_text,
				'status_class' => $status_class,
				'pt_member' => $task['pt_member'],
				'apm_patient_type' => $task['apm_patient_type'],
				'ntdp_date_start' => $task['ntdp_date_start'],
				'ntdp_time_start' => $task['ntdp_time_start'],
				'apm_time' => $task['apm_time'],
				'apm_pri_id' => $task['apm_pri_id'],
				'pri_color' => $task['pri_color'],
				'pri_name' => $task['pri_name'],
				'apm_app_walk' => $task['apm_app_walk'],
				'qus_app_walk' => $task['qus_app_walk'],
				'pt_name' => $task['pt_name'],
				'btn' => $btn,
				'announce_id' => $task['qus_announce_id'],
				'announce' => $task['qus_announce'],
				'announce_time_start' => $task['qus_time_start'],
				'announce_time_end' => $task['qus_time_end']
			];
		}
		// ส่งผลลัพธ์กลับไปยัง JavaScript
		$response = [
			'tasks' => $tasks,
			'badge' => $badge,
			'doctor_list' => $doctor_base,
		];
		echo json_encode($response);
	}
	/*
	* Manage_queue_trello_edit
	* อัปเดตลำดับของคิวและการเปลี่ยนแพทย์
	* @input [QUE] que_appointments that sorting and change doctor from form
	* $output response
	* @author Areerat Pongurai
	* @Create Date 21/08/2024
	*/
  public function ram_boom() {
		// ตรวจสอบการใช้หน่วยความจำปัจจุบัน
		$current_memory = memory_get_usage();

		// ตรวจสอบการใช้หน่วยความจำสูงสุด
		$peak_memory = memory_get_peak_usage();

		// ตรวจสอบขีดจำกัดหน่วยความจำ
		$memory_limit = ini_get('memory_limit');

		echo "Current Memory Usage: " . $this->formatBytes($current_memory) . "<br>";
		echo "Peak Memory Usage: " . $this->formatBytes($peak_memory) . "<br>";
		echo "Memory Limit: " . $memory_limit . "<br>";
    
	}


private function formatBytes($size, $precision = 2) {
		$base = log($size, 1024);
		$suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');

		return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
	}

	public function Manage_queue_trello_edit()
	{

		$this->load->model('wts/m_wts_queue_seq');
		$this->load->model('que/m_que_appointment');
		$this->load->model('hr/m_hr_person_room');
		$this->load->model('eqs/m_eqs_room');
		$this->load->model('wts/m_wts_notifications_department');

		$doctor_patient_ques = $this->input->post('doctor_patient_ques');
		// die(pre($doctor_patient_ques));
		// $stde_id = decrypt_id(trim($this->input->post('stde_id')));
		$date = $this->input->post('date');
		if (empty($date)) {
			$date = date('Y-m-d'); // date('Y-m-d');
		} else {
			list($day, $month, $year) = explode('/', $date);
			$gregorianYear = $year - 543;
			$date = DateTime::createFromFormat('d/m/Y', "$day/$month/$gregorianYear");
			$date = $date->format('Y-m-d');
		}

		/*  condition
			✅ 1 wait -> doctor		=> เป็นการระบุแพทย์
			❌ 2 wait -> success		=> 🟡 แจ้งเตือน "ไม่สามารถปรับสถานะ "พบแพทย์เสร็จสิ้น" ให้กับคิวที่ยังไม่ระบุแพทย์ได้" // ❌ แจ้งเตือน "ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นพบแพทย์เสร็จสิ้นหรือไม่" ถ้าใช่ ก็ null ps_id + ปรับ sta_id = 10 (พบแพทย์เสร็จสิ้น)
			✅ 3 doctor -> wait		=> 🟡 แจ้งเตือน "ต้องการไม่ระบุแพทย์หรือไม่" ถ้าใช่ ก็ null ps_id + ปรับ sta_id = 4 (ออกหมายเลขคิว - เพื่อรอดำเนิการ)
			✅ 4 doctor -> success	=> ปรับ sta_id = 10 (พบแพทย์เสร็จสิ้น)
			✅ 5 success -> wait		=> 🟡 แจ้งเตือน "ต้องการไม่ระบุแพทย์ และปรับสถานะเป็นรอระบุแพทย์หรือไม่" ถ้าใช่ ก็ null ps_id + ปรับ sta_id = 4 (ออกหมายเลขคิว - เพื่อรอดำเนิการ)
			✅ 6 success -> doctor	=> ปรับ sta_id = 4 (ออกหมายเลขคิว - เพื่อรอดำเนิการ)
			✅ 7 doctor -> doctor	=> เปลี่ยนแพทย์

			✅ 8 wait -> cancel		=> 🟡 แจ้งเตือน "ต้องการยกเลิกการจองคิว ใช่หรือไม่" ถ้าใช่ ก็ปรับ sta_id = 9 (ยกเลิกการจองคิว)
			✅ 9 doctor -> cancel	=> 🟡 แจ้งเตือน "ต้องการยกเลิกการจองคิว ใช่หรือไม่" ถ้าใช่ ก็ปรับ sta_id = 9 (ยกเลิกการจองคิว)
			✅ 10 success -> cancel	=> 🟡 แจ้งเตือน "ต้องการยกเลิกการจองคิว ใช่หรือไม่" ถ้าใช่ ก็ปรับ sta_id = 9 (ยกเลิกการจองคิว)
			

			Normal case => wait -> doctor -> success

			[WTS] wts_notifications_department สำหรับ insert log timeline กรณีย้าย apm ไปการ์ด wait, success
			wait 	- insert location 6 เข้าแผนก		   => อารมณ์เหมือนกลับไปแผนกอีกรอบ
			success - insert location 8 พบแพทย์ (สิ้นสุด)	=> ไม่ว่าตอนนี้กำลังทำอะไรอยู่ หรือก่อนหน้ามาจาก location ไหน ก็จะบันทึกว่าพบแพทย์เสร็จสิ้นแล้ว
			doctor  - ❌ ไม่ insert log timeline เพราะเป็นการเปลี่ยนแพทย์และเปลี่ยนลำดับคิว
		*/

		foreach ($doctor_patient_ques as $doctor) {
			$card = explode("tasks-", $doctor['card']);

			if (isset($doctor['patient_ques']) && !empty($card)) {
				$ps_id = $doctor['ps_id'];
				// pre(explode("-", $card[1]));
				// pre(explode("-", $card[1])[0] == 'appointment' ? 'A' : 'W');
				$patient_ques = $doctor['patient_ques'];
				foreach ($patient_ques as $que) {
					// pre($que);
					// [QUE] get que_appointment 
					// $apm = $this->m_que_appointment->get_appointment_by_code($date, $que['apm_ql_code'], $stde_id)->row();
					if (empty($que['apm_id'])) {

						$params = ['date' => $date, 'ps_id' => $ps_id,];
						$qus = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
						if (!empty($qus))
						$announce_id = $que['announce_id'];
						$this->m_wts_queue_seq->qus_psrm_id = $qus[0]['psrm_id'];
						// pre($qus[0]['psrm_id']);
						$psrm_id =  $qus[0]['psrm_id'];
						// pre($announce_id);pre($psrm_id);

						$stde = $this->m_eqs_room->get_stde_room_by_psrm_id($psrm_id)->result();

						// $stde_id = $stde->rm_stde_id;
						// [WTS] search
						$ann = $this->m_wts_queue_seq->search_by_announce_id($announce_id, $psrm_id)->result_array();
						// pre($ann);
						// $this->m_wts_queue_seq->update_seq();

						if (!empty($ann)) {
							$apm = $this->m_que_appointment->get_by_key()->row();
							$this->m_que_appointment->apm_id = $ann[0]['qus_apm_id'];
							$this->m_que_appointment->apm_ps_id = $ps_id;
							$this->m_que_appointment->apm_stde_id = $stde[0]->rm_stde_id;
							$this->m_que_appointment->apm_date = $date;
							$this->m_que_appointment->apm_time = $que['an_time_start'];

                              
							$this->m_wts_queue_seq->qus_announce_id = $que['announce_id'];
							$this->m_wts_queue_seq->qus_seq = $que['seq'];
							$this->m_wts_queue_seq->qus_announce = $que['announce'];
							$this->m_wts_queue_seq->qus_time_start = $que['an_time_start'];
							$this->m_wts_queue_seq->qus_time_end = $que['an_time_end'];
							//$this->m_wts_queue_seq->qus_app_walk = explode("-", $card[1])[0] == 'appointment' ? 'A' : 'W';
							$this->m_que_appointment->update_announce();
							$this->m_wts_queue_seq->update_seq_by_announce_id();
						} else {
							$this->m_que_appointment->apm_ps_id = $ps_id;
							$this->m_que_appointment->apm_stde_id = $stde[0]->rm_stde_id;
							$this->m_que_appointment->apm_date = $date;
							$this->m_que_appointment->apm_time = $que['an_time_start'];

							$this->m_que_appointment->insert_announce();
							$apm_id = $this->m_que_appointment->last_insert_id;
							// pre($apm_id);
							$this->m_wts_queue_seq->qus_apm_id = $apm_id;
							// $queue = $this->m_wts_queue_seq->search_by_apm_id()->result_array();
							$this->m_wts_queue_seq->qus_announce_id = $que['announce_id'];
							// [WTS] insert / update seq in wts_queue_seq 
							$this->m_wts_queue_seq->qus_seq = $que['seq'];
							// $this->m_wts_queue_seq->qus_app_walk = explode("-", $card[1])[0] == 'appointment' ? 'A' : 'W';
							$this->m_wts_queue_seq->qus_announce = $que['announce'];
							$this->m_wts_queue_seq->qus_time_start = $que['an_time_start'];
							$this->m_wts_queue_seq->qus_time_end = $que['an_time_end'];

							$this->m_wts_queue_seq->insert();
						}
						break;

						// $this->m_wts_queue_seq->insert();
					} else {
						$params = ['date' => $date, 'ps_id' => $ps_id,];
						$qus = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
						if (!empty($qus))
							$this->m_wts_queue_seq->qus_psrm_id = $qus[0]['psrm_id'];
						$this->m_que_appointment->apm_id = decrypt_id(trim($que['apm_id']));
						$apm = $this->m_que_appointment->get_by_key()->row();

						// case 'wait' && case 'success' ไม่บันทึก m_wts_queue_seq
						switch ($card[1]) {
							case 'wait': // ยังไม่ได้ระบุแพทย์
								// 3 doctor -> wait && 5 success -> wait
								$this->m_que_appointment->apm_id = $apm->apm_id;
								$this->m_que_appointment->apm_ps_id = null;
								$this->m_que_appointment->update_pt_id();
								$this->m_que_appointment->apm_sta_id = 4; // (ออกหมายเลขคิว - เพื่อรอดำเนิการ)
								$this->m_que_appointment->update_status();

								// [WTS] insert log timeline in wts_notifications_department
								// location 6 เข้าแผนก
								// $this->m_wts_notifications_department->ntdp_apm_id = $apm->apm_id;
								// $this->m_wts_notifications_department->ntdp_loc_id = 6; // เข้าแผนก
								// $this->m_wts_notifications_department->ntdp_seq = 6; // ตาม ntdp_loc_Id
								// $this->m_wts_notifications_department->ntdp_date_start = date('Y-m-d');
								// $this->m_wts_notifications_department->ntdp_time_start = date('H:i:s');
								// $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
								// $this->m_wts_notifications_department->ntdp_in_out = 0;
                // $this->m_wts_notifications_department->ntdp_function = 'Manage_queue_trello_edit_6';
								// $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
								// if (!empty($last_noti_dept)) {
								// 	$this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
								// }
								// $this->m_wts_notifications_department->insert();

								break;
							case 'success': // พบแพทย์เสร็จสิ้น
								// // 2 wait -> success
								// if(empty($apm->apm_ps_id)) {
								// 	$this->m_que_appointment->apm_id = $apm->apm_id;
								// 	$this->m_que_appointment->apm_ps_id = null;
								// 	$this->m_que_appointment->update_pt_id();
								// 	$this->m_que_appointment->apm_sta_id = 10; // (พบแพทย์เสร็จสิ้น)
								// 	$this->m_que_appointment->update_status();
								// }

								// 4 doctor -> success
								if ($ps_id != 'wait') {
									$this->m_que_appointment->apm_id = $apm->apm_id;
									$this->m_que_appointment->apm_sta_id = 10; // (พบแพทย์เสร็จสิ้น)
									$this->m_que_appointment->apm_sta_id = 15; // (พบแพทย์เสร็จสิ้น)
									$this->m_que_appointment->update_status();
								}

								// [WTS] insert log timeline in wts_notifications_department
								// location 8 พบแพทย์ (สิ้นสุด)
								$date = new DateTime();
								$this->m_wts_notifications_department->ntdp_apm_id = $apm->apm_id;
								$this->m_wts_notifications_department->ntdp_loc_id = 8; // พบแพทย์ (สิ้นสุด)
								$this->m_wts_notifications_department->ntdp_seq = 8; // ตาม ntdp_loc_Id
								$this->m_wts_notifications_department->ntdp_date_start = $date->format('Y-m-d');
								$this->m_wts_notifications_department->ntdp_time_start = $date->format('H:i:s');
								$this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
								$this->m_wts_notifications_department->ntdp_in_out = 0;
                $this->m_wts_notifications_department->ntdp_function = 'Manage_queue_trello_edit_8';
								$last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
								if (!empty($last_noti_dept)) {
									$this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
								}
								$this->m_wts_notifications_department->insert();

								// [WTS] update finish date/time last_noti_dept in wts_notifications_department
								if (!empty($last_noti_dept)) {
									// Format both DateTime objects to 'Y-m-d H:i' (excluding seconds)
									if (!empty($last_noti_dept->ntdp_date_end) && !empty($last_noti_dept->ntdp_time_end)) {
										$date_formatted = $date->format('Y-m-d H:i');
										$end_date_formatted = (new DateTime($last_noti_dept->ntdp_date_end . ' ' . $last_noti_dept->ntdp_time_end))->format('Y-m-d H:i');

										if ($date_formatted > $end_date_formatted) {
											$this->m_wts_notifications_department->ntdp_sta_id = 4; // F - เลยระยะเวลา
										} else {
											$this->m_wts_notifications_department->ntdp_sta_id = 2; // Y - แจ้งเตือนแล้ว
										}

										$this->m_wts_notifications_department->ntdp_id = $last_noti_dept->ntdp_id;
										$this->m_wts_notifications_department->ntdp_date_finish = $date->format('Y-m-d');
										$this->m_wts_notifications_department->ntdp_time_finish = $date->format('H:i:s');
										$this->m_wts_notifications_department->update_finish_see_doctor_by_key();
									}
								}

								break;
							case 'cancel': // ยกเลิกการจองคิว
								// 8 wait -> cancel && 9 doctor -> cancel && 10 success -> cancel
								$this->m_que_appointment->apm_id = $apm->apm_id;
								$this->m_que_appointment->apm_sta_id = 9; // (ยกเลิกการจองคิว)
								$this->m_que_appointment->update_status();
								break;
							default: // กำลังดำเนินการอยู่ในแผนก
								if (!empty($ps_id)) {
									// $ps_id = ; // dont decrypt

									// 6 success -> doctor
									// if ($apm->apm_sta_id == 10) {
									// 	$this->m_que_appointment->apm_id = $apm->apm_id;
									// 	$this->m_que_appointment->apm_sta_id = 4; // (ออกหมายเลขคิว - เพื่อรอดำเนิการ)
									// 	$this->m_que_appointment->update_status();
									// }

									// 1 wait -> doctor && 7 doctor -> doctor
									// if change doctor then update in [QUE] que_appointment
									// ถ้าใน wait ทำด้วย ค่อยทำ function process แยก
									if ($apm->apm_ps_id != $ps_id) {
										$this->m_que_appointment->apm_id = $apm->apm_id;
										$this->m_que_appointment->apm_ps_id = $ps_id;
										$this->m_que_appointment->update_pt_id();
									}

									// update order number of queue each doctor (m_wts_queue_seq->qus_seq)
									// [HR] get qus_psrm_id from hr_person_room
									$params = ['date' => $date, 'ps_id' => $ps_id,];
									$qus = $this->m_hr_person_room->get_by_date_and_ps_id($params)->result_array();
									if (!empty($qus))
										$this->m_wts_queue_seq->qus_psrm_id = $qus[0]['psrm_id'];

									// [WTS] search
									$this->m_wts_queue_seq->qus_apm_id = $apm->apm_id;
									$queue = $this->m_wts_queue_seq->search_by_apm_id()->result_array();

									// [WTS] insert / update seq in wts_queue_seq 
									$this->m_wts_queue_seq->qus_app_walk = explode("-", $card[1])[0] == 'appointment' ? 'A' : 'W';
									$this->m_wts_queue_seq->qus_seq = $que['seq'];
									$this->m_wts_queue_seq->qus_announce_id = null;

									$this->m_wts_queue_seq->qus_announce = null;
									$this->m_wts_queue_seq->qus_time_start = null;
									$this->m_wts_queue_seq->qus_time_end = null;
									if (!empty($queue))
										$this->m_wts_queue_seq->update_seq();
									else
										$this->m_wts_queue_seq->insert();
									break;
								}
						}
					}
				}
			}
		}
		$response = [
			'status_response' => $this->config->item('status_response_success'),
			'returnUrl' => site_url('wts/Manage_queue_trello/floor'),
		];
		echo json_encode($response);
	}

	public function delete_card()
	{
		$this->load->model('wts/m_wts_queue_seq');
		$this->load->model('que/m_que_appointment');

		$id = $this->input->post('id');
		$apm_id = $this->m_wts_queue_seq->search_apm_id_by_announce_id($id)->result_array();

		// Check if the query returned results and if 'qus_apm_id' exists
		if (!empty($apm_id) && isset($apm_id[0]['qus_apm_id'])) {
			$qus_apm_id = $apm_id[0]['qus_apm_id'];

			// Proceed with deleting the record using $qus_apm_id
			$this->m_wts_queue_seq->delete_by_apm_id($qus_apm_id);
			$result = $this->m_que_appointment->delete_appointment($qus_apm_id);

			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Card deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to delete card.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Appointment ID not found.']);
		}
	}
	/*
	* Manage_queue_trello_update_room
	* อัปเดตห้องประจำการของแพทย์ ณ วันนั้น
	* @input data for save hr_person_room
	* $output response and psrm_id
	* @author Areerat Pongurai
	* @Create Date 21/08/2024
	*/
	public function Manage_queue_trello_update_room()
	{
		$psrm_id = $this->input->post('psrm_id');
		$psrm_rm_id = $this->input->post('psrm_rm_id');

		$this->load->model('hr/m_hr_person_room');
		$this->m_hr_person_room->psrm_rm_id = $psrm_rm_id;

		if (!empty($psrm_id)) {
			$this->m_hr_person_room->psrm_id = $psrm_id;
			$this->m_hr_person_room->update_rm_id();
		} else {
			$psrm_ps_id = $this->input->post('psrm_ps_id');

			$psrm_date = $this->input->post('psrm_date');
			if (empty($psrm_date)) {
				$psrm_date = date('Y-m-d');
			} else {
				// convert format date dd/mm/yyyy(+543) to Y-m-d
				$apm_date = $psrm_date;
				$dateParts = explode('/', $psrm_date);
				$day = $dateParts[0];
				$month = $dateParts[1];
				$buddhistYear = $dateParts[2];
				$gregorianYear = (int)$buddhistYear - 543;
				$psrm_date = $gregorianYear . '-' . $month . '-' . $day;
			}

			$this->m_hr_person_room->psrm_date = $psrm_date;
			$this->m_hr_person_room->psrm_ps_id = $psrm_ps_id;
			$this->m_hr_person_room->insert();
			$psrm_id = $this->m_hr_person_room->last_insert_id;

			// update [WTS] wts_queue_seq.qus_psrm_id by multiple qus_apm_ids
			// 1 กรณีเคยมีการจัดลำดับให้คิวแล้ว => อัปเดต wts_queue_seq.qus_psrm_id
			// 2 กรณีไม่เคยมีการจัดลำดับให้คิว  => insert wts_queue_seq โดย qus_seq ตามจำนวนคิวของแพทย์คนนั้นๆ
			$params = [
				'date' => $apm_date,
				// 'department' => decrypt_id(trim($this->input->post('department'))),
				'doctor' => $psrm_ps_id,
				'is_null_ps_id' => false,
			];

			$this->load->model('wts/m_wts_queue_seq');
			$this->load->model('que/m_que_appointment');
			$result = $this->m_que_appointment->get_appointment_trello_wts($params);
			foreach ($result as $index => $apm) {
				$this->m_wts_queue_seq->qus_psrm_id = $psrm_id;
				$this->m_wts_queue_seq->qus_apm_id = $apm['apm_id'];
				$queue_seq = $this->m_wts_queue_seq->search_by_apm_id()->result_array();
				if (!empty($queue_seq)) { // 1 กรณีเคยมีการจัดลำดับให้คิวแล้ว
					$this->m_wts_queue_seq->update_psrm_id_by_apm_id();
				} else { // 2 กรณีไม่เคยมีการจัดลำดับให้คิว
					$this->m_wts_queue_seq->qus_seq = $index + 1;
					$this->m_wts_queue_seq->insert();
				}
			}
		}

		$response = [
			'status_response' => $this->config->item('status_response_success'),
			'psrm_id' => $psrm_id
		];
		echo json_encode($response);
	}

	/*
	* Manage_queue_trello_apm_info
	* ดูรายละเอียดข้อมูลการลงทะเบียน
	* @input apm_id
	* $output que_appointment
	* @author Areerat Pongurai
	* @Create Date 21/08/2024
	*/
	public function Manage_queue_trello_apm_info($appointment_id)
	{
		$this->load->model('que/m_que_appointment');
		if ($appointment_id) {
			$appointment_id = decrypt_id($appointment_id);

			$data['get_base_noti'] = $this->m_que_appointment->get_base_noti()->result_array();
			$data['get_appointment'] = $this->m_que_appointment->get_appointment_by_id($appointment_id)->row_array();
			$data['get_appointment_by_visit'] = $this->m_que_appointment->get_appointment_by_visit($data['get_appointment']['apm_visit'])->result_array();
			$notificationName = '-';

			// Iterate through get_base_noti to find a matching ntf_id
			foreach ($data['get_base_noti'] as $notification) {
				if ($data['get_appointment']['apm_ntf_id'] == $notification['ntf_id']) {
					$notificationName = $notification['ntf_name'];
					break; // Exit loop once a match is found
				}
			}
			$data['notification_name'] = $notificationName;
			if (isset($data['get_appointment']['apm_id'])) {
				$data['get_appointment']['apm_id'] = encrypt_id($data['get_appointment']['apm_id']);
			}
		}

		// $this->output('que/appointment/v_appointment_form_step2', $data);
		$this->load->view('que/appointment/v_appointment_form_step2', $data);
	}

	/*
	* Manage_queue_trello_success
	* ปรับสถานะพบแพทย์เสร็จสิ้น และบันทึก log
	* @input apm_id (que_appointment id): ไอดีคิว
	* $output response
	* @author Areerat Pongurai
	* @Create Date 12/09/2024
	*/
	public function Manage_queue_trello_success($apm_id)
	{
		$apm_id = decrypt_id($apm_id);
		// pre($apm_id); die;
		$apm_sta_id = !empty($this->input->post('sta_id')) ? $this->input->post('sta_id') : 10; // 10 - 'F' พบแพทย์เสร็จแล้ว

		// [QUE] Update original que_appointment is finished seeing the doctor.
		$this->load->model('que/m_que_appointment');
		$this->m_que_appointment->apm_id = $apm_id;
		$this->m_que_appointment->apm_sta_id = $apm_sta_id; // 10 - 'F' พบแพทย์เสร็จแล้ว
		$this->m_que_appointment->update_status();

		$appointment = $this->m_que_appointment->get_by_key()->row();

		// [AMS] get notification_result from doctor of que
		$this->load->model('ams/M_ams_notification_result');
		$noti_result = $this->M_ams_notification_result->get_by_apm_id($apm_id)->row();

		$this->M_ams_notification_result->ntr_id = $noti_result->ntr_id;
		$this->M_ams_notification_result->ntr_ast_id = 4; // บันทึกผลแจ้งเตือนแล้ว
		$this->M_ams_notification_result->ntr_update_user = $this->session->userdata('us_id');
		$this->M_ams_notification_result->ntr_update_date = date('Y-m-d H:i:s');
		$this->M_ams_notification_result->update();

		// [WTS] insert log timeline in wts_notifications_department
		$date = new DateTime();
		$this->load->model('wts/m_wts_notifications_department');
		$this->m_wts_notifications_department->ntdp_apm_id = $apm_id;
		$this->m_wts_notifications_department->ntdp_loc_id = 9; // พบแพทย์ (สิ้นสุด)
		$this->m_wts_notifications_department->ntdp_seq = 9; // ตาม ntdp_loc_Id
		$this->m_wts_notifications_department->ntdp_date_start = $date->format('Y-m-d');
		$this->m_wts_notifications_department->ntdp_time_start = $date->format('H:i:s');
		$this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
		$this->m_wts_notifications_department->ntdp_in_out = 0;
    $this->m_wts_notifications_department->ntdp_function = 'Manage_queue_trello_success';
		$last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
		if (!empty($last_noti_dept)) {
			$this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
		}

		$loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "9"');
		$loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
		$current_date = new DateTime();
		$ntdp_time_end = clone $current_date; // สำเนา object $current_date เพื่อใช้งานในส่วนอื่น
		$ntdp_time_end->modify('+' . $loc_time . ' minutes');
		$this->m_wts_notifications_department->ntdp_date_end = $ntdp_time_end->format('Y-m-d');
		$this->m_wts_notifications_department->ntdp_time_end = $ntdp_time_end->format('H:i:s');

		$appointment_dep = $this->m_que_appointment->get_appointment_by_id($apm_id)->result_array();
		// $sql_room = $this->m_que_appointment->get_room($apm_id)->result_array();
		switch ($appointment_dep[0]['stde_name_th']) {
			case 'ภาคจักษุวิทยา (EYE)':
				$doctor_room = '5';
				break;
			case 'ภาคโสต ศอ นาสิก (ENT)':
			case 'จิตแพทย์':
				$doctor_room = '7';
				break;
			case 'ภาคทันตกรรม (DEN)':
				$doctor_room = '10';
				break;
			case 'แผนกศูนย์เคลียร์เลสิค':
				$doctor_room = '28';
				break;
			case 'ภาครังสีวิทยา (RAD)':
				$doctor_room = '8';
				break;
			case 'แผนกเทคนิคการแพทย์':
				$doctor_room = '14';
				break;
			default:
				$sending_location_room = '0'; // Default room, ensure you handle unexpected cases
				break;
		}

		$this->m_wts_notifications_department->ntdp_loc_ft_Id = $doctor_room;
		$this->m_wts_notifications_department->insert();

		// [WTS] update finish date/time last_noti_dept in wts_notifications_department
		if (!empty($last_noti_dept)) {
			// Format both DateTime objects to 'Y-m-d H:i' (excluding seconds)
			if (!empty($last_noti_dept->ntdp_date_end) && !empty($last_noti_dept->ntdp_time_end)) {
				$date_formatted = $date->format('Y-m-d H:i');
				$end_date_formatted = (new DateTime($last_noti_dept->ntdp_date_end . ' ' . $last_noti_dept->ntdp_time_end))->format('Y-m-d H:i');

				if ($date_formatted > $end_date_formatted) {
					$this->m_wts_notifications_department->ntdp_sta_id = 4; // F - เลยระยะเวลา
				} else {
					$this->m_wts_notifications_department->ntdp_sta_id = 2; // Y - แจ้งเตือนแล้ว
				}


				$this->m_wts_notifications_department->ntdp_id = $last_noti_dept->ntdp_id;
				$this->m_wts_notifications_department->ntdp_date_finish = $date->format('Y-m-d');
				$this->m_wts_notifications_department->ntdp_time_finish = $date->format('H:i:s');

				$this->m_wts_notifications_department->update_finish_see_doctor_by_key();
			}
		}



		// sboom
		// $sql_user = $this->m_que_appointment->get_user($this->session->userdata('us_ps_id'))->result_array();
		// // $sql_room = $this->m_que_appointment->get_room($apm_id)->result_array();
		// $appointment_dep = $this->m_que_appointment->get_appointment_by_id($apm_id)->result_array();
		// $pdo = $this->connect_his_database();
		// $sql = "INSERT INTO tabDoctorRoom (visit, sender_name, sender_last_name, sending_location_room, datetime_sent, doctor_room, location) 
		// VALUES (:visit, :sender_name, :sender_last_name, :sending_location_room, :datetime_sent, :doctor_room, :location)";
		// $stmt = $pdo->prepare($sql);
		// // if ($pdo && !empty($sql_user) && !empty($sql_room)) { // Check if PDO and data are valid
		//   // Binding Parameters
		//   $sql_room = $this->m_que_appointment->get_room($apm_id)->result_array();
		//   switch ($appointment_dep[0]['stde_name_th']) {
		//     case 'แผนกผู้ป่วยนอกจักษุ':
		//         $sending_location_room = $this->config->item('wts_room_ood');
		//         $doctor_room = '5';
		//         break;
		//     case 'แผนกผู้ป่วยนอกหู/คอ/จมูก':
		//     case 'แผนกผู้ป่วยนอกสูตินรีเวช':
		//     case 'แผนกผู้ป่วยนอกอายุรกรรม':
		//     case 'จิตแพทย์':
		//         $sending_location_room = $this->config->item('wts_room_floor2');
		//         $doctor_room = '7';
		//         break;
		//     case 'แผนกทันตกรรม':
		//         $sending_location_room = $this->config->item('wts_room_dd');
		//         $doctor_room = '10';
		//         break;
		//     case 'แผนกศูนย์เคลียร์เลสิค':
		//         $sending_location_room = $this->config->item('wts_room_rel');
		//         $doctor_room = '28';
		//         break;
		//     case 'แผนกรังสีวิทยา':
		//         $sending_location_room = '8';
		//         $doctor_room = '8';
		//         break;
		//     case 'แผนกเทคนิคการแพทย์':
		//       $sending_location_room = '14';
		//       $doctor_room = '14';
		//       break;
		//     default:
		//         $sending_location_room = '0'; // Default room, ensure you handle unexpected cases
		//         break;
		//   }
		//   $datetime_sent = (new DateTime())->format('Y-m-d H:i:s');
		//   $location = $this->session->userdata('us_dp_id');  

		//   $stmt->bindParam(':visit', $appointment_dep[0]['apm_visit']);
		//   $stmt->bindParam(':sender_name', $sql_user[0]['ps_fname']);
		//   $stmt->bindParam(':sender_last_name', $sql_user[0]['ps_lname']);
		//   $stmt->bindParam(':sending_location_room', $sql_room[0]['rm_his_id']);
		//   $stmt->bindParam(':datetime_sent', $datetime_sent);
		//   $stmt->bindParam(':doctor_room', $doctor_room );
		//   $stmt->bindParam(':location', $location);

		//   // Execute the query
		//     try {
		//       $stmt->execute();
		//     } catch (PDOException $e) {
		//       // Handle exception if needed
		//       echo "Error: " . $e->getMessage();
		//   }
		// eboom

		$response = [
			'status_response' => $this->config->item('status_response_success'),
			'returnUrl' => base_url() . 'index.php/wts/Manage_queue_trello/floor',
			'appointment' => $appointment
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
	public function get_new_patient_que_old()
	{
		$this->load->model('que/m_que_appointment');
		$date = $this->input->post('date');
		list($day, $month, $year_th) = explode('/', $date);
		// แปลงปีจาก พ.ศ. เป็น ค.ศ.
		$year = $year_th - 543;
		// สร้างสตริงวันที่ในรูปแบบที่ต้องการ
		$date_format = sprintf('%04d-%02d-%02d', $year, $month, $day);
		$number_que = $this->m_que_appointment->get_patient_no_que_old($date_format);
		// pre($number_que);
		$response = ['num_row' => count($number_que)];
		echo json_encode($response);
	}
	public function get_new_patient_que()
	{
		$this->load->model('que/m_que_appointment');
		$date = $this->input->post('date');
		$wait_que = $this->input->post('wait_que');
		list($day, $month, $year_th) = explode('/', $date);
		// แปลงปีจาก พ.ศ. เป็น ค.ศ.
		$year = $year_th - 543;
		// สร้างสตริงวันที่ในรูปแบบที่ต้องการ
		$date_format = sprintf('%04d-%02d-%02d', $year, $month, $day);
		$this->m_que_appointment->reset_report($date_format);
		$number_que = $this->m_que_appointment->get_patient_no_que($date_format,$wait_que);
		// pre($number_que);
		$response = ['num_row' => count($number_que)];
		echo json_encode($response);
	}
	public function update_finished_process(){
		$this->load->model('que/m_que_appointment');
		$this->m_que_appointment->apm_id = decrypt_id($this->input->post('apm_id'));
		$this->m_que_appointment->apm_sta_id = 10;
		$this->m_que_appointment->update_sta_by_id();

    $ntdp_update = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "'.decrypt_id($this->input->post('apm_id')).'" GROUP BY ntdp_seq ORDER BY ntdp_seq DESC LIMIT 1');

    // ตรวจสอบว่ามีผลลัพธ์จากการค้นหา
        if ($ntdp_update->num_rows() > 0) {
          $ntdp_data = $ntdp_update->row(); // ดึงแถวข้อมูล

          // เตรียมข้อมูลสำหรับการอัปเดต
          $update_data = array(
              'ntdp_date_finish' => date('Y-m-d'),
              'ntdp_time_finish' => date('H:i:s'),
              'ntdp_in_out' => 1,
              'ntdp_function' => 'update_finished_process'
          );

          // ทำการอัปเดตข้อมูลโดยใช้ ntdp_id ที่ได้จากการ Query
          $this->db->where('ntdp_id', $ntdp_data->ntdp_id);
          $this->db->update('see_wtsdb.wts_notifications_department', $update_data);

          echo "Update successful.";
      } else {
          echo "No record found for update.";
      }

	}
	public function get_doctor_by_stde_select($stde = null){
		$this->load->model('hr/structure/m_hr_structure_person');
		$doctor_list = [];
		$seen_ps_ids = []; // อาร์เรย์สำหรับเก็บ ps_id ที่เจอแล้ว
		foreach ($stde as $key => $value) {
			$result = $this->m_hr_structure_person->get_by_stde_id($value)->result();
			foreach ($result as $doctor) {
				// เช็คว่ามี ps_id นี้ใน $seen_ps_ids หรือยัง
				if (!in_array($doctor->ps_id, $seen_ps_ids)) {
					$doctor_list[] = $doctor; // ถ้ายังไม่เคยเจอ ps_id นี้ ให้เพิ่มเข้า $doctor_list
					$seen_ps_ids[] = $doctor->ps_id; // บันทึก ps_id ไว้ใน seen_ps_ids
				}
			}
		}
		return $doctor_list;
	}
	public function update_doctor_apm(){
		$this->load->model('que/m_que_appointment');
		$this->m_que_appointment->apm_id = decrypt_id($this->input->post('apm_id'));
		$this->m_que_appointment->apm_ps_id = $this->input->post('ps_id');
		// pre($this->m_que_appointment->apm_ps_id);
		// pre($this->m_que_appointment->apm_id);
		$this->m_que_appointment->update_doctor_by_id();
	}
}
