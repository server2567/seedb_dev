<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');
require 'vendor/autoload.php';

use TADPHP\TADFactory;
use TADPHP\TAD;

class Attendance_config extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "attendance_config/";
		$this->view .= "attendance_config/";
		$this->load->model($this->model . 'M_hr_timework_attendance_config');
		$this->load->model($this->model . '../structure/M_hr_structure_detail');
		$this->load->model($this->model . '../M_hr_person');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* หน้าหลักรูปแบบการลงเวลาทำงาน
	* @input 
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$hire_is_medical = '';
		$hire_data = $this->session->userdata('hr_hire_is_medical');
		$count = count($hire_data);

		if ($count < 5) {
			$hire_is_medical = 'ของ';

			foreach ($hire_data as $key => $value) {
				if ($key == $count - 1 && $count > 1) {
					$hire_is_medical .= 'และ ';
				} elseif ($key != 0) {
					$hire_is_medical .= ' ';
				}

				switch ($value['type']) {
					case 'M':
						$hire_is_medical .= 'สายการแพทย์';
						break;
					case 'N':
						$hire_is_medical .= 'สายการพยาบาล';
						break;
					case 'SM':
						$hire_is_medical .= 'สายสนับสนุนทางการแพทย์';
						break;
					case 'A':
						$hire_is_medical .= 'สายบริหาร';
						break;
					case 'T':
						$hire_is_medical .= 'สายเทคนิคและบริการ';
						break;
				}
			}
		}

		$data['hire_is_medical'] = $hire_is_medical;

		$this->output($this->view . 'v_attendance_config_list', $data);
	}
	// index

	/*
	* attendance_config_list
	* ข้อมูลรายการรูปแบบการลงเวลาทำงานตาม filter
	* @input twac_type, twac_is_medical, twac_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$twag_type = $this->input->get('twag_type');
		$twag_is_medical = $this->input->get('twag_is_medical');
		$twag_active = $this->input->get('twag_active');
		$sql = 'SELECT * FROM see_hrdb.hr_timework_attendance_config_group WHERE twag_active != 2';
		if ($twag_active != 'all') {
			$sql .= ' AND twag_active = ' . $twag_active;
		}
		if ($twag_type != 'all') {
			$sql .= ' AND twag_type = ' . $twag_type;
		}
		if ($twag_is_medical != 'all') {
			$sql .= " AND twag_is_medical = '" . $twag_is_medical . "'";
		}
		$this->hr = $this->load->database('hr', TRUE);
		$query = $this->hr->query($sql);
		$result = $query->result();

		foreach ($result as $key => $row) {
			$row->twag_twac_data  =  $this->M_hr_timework_attendance_config->get_by_primary_key(null, $row->twag_id);
			$row->twag_id = encrypt_id($row->twag_id);
		}
		echo json_encode($result);
	}
	// attendance_config_list

	/*
	* attendance_config_form
	* แบบฟอร์มรูปแบบการลงเวลาทำงาน
	* @input twac_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_form($twag_id = "")
	{
		$data['session_mn_active_url'] = 'hr/timework/Attendance_config'; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$twag_id = ($twag_id != "" ? decrypt_id($twag_id) : 0);
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$data['row_twac'] = $this->M_hr_timework_attendance_config->get_by_primary_key(null, $twag_id);
		if ($data['row_twac'] != null) {
			foreach ($data['row_twac'] as $key => $value) {
				$value->twac_id = encrypt_id($value->twac_id);
				if ($value->twac_person  != null) {
					$value->twac_person = json_decode($value->twac_person, true);
					$value->twac_person = array_filter($value->twac_person, function ($obj) {
						// แปลง JSON string เป็น array
						if (is_string($obj)) {
							$decoded_obj = json_decode($obj, true);
						} else {
							$decoded_obj = $obj;
						}

						// ตรวจสอบว่าแปลงสำเร็จและคีย์ ps_id ไม่ใช่ null
						return $decoded_obj && $decoded_obj['ps_id'] !== null;
					});
					$filtered_twac_person = [];
					foreach ($value->twac_person as $person) {
						if (is_string($person)) {
							$person = json_decode($person, true);
						}
						$ps_id = $person['ps_id'];
						if (!isset($filtered_twac_person[$ps_id]) || $person['pos_dp_id'] < $filtered_twac_person[$ps_id]['pos_dp_id']) {
							$filtered_twac_person[$ps_id] = $person;
						}
					}
					$value->twac_person = array_values($filtered_twac_person);
				}
			}

			// เปลี่ยน array จาก associative array กลับไปเป็น indexed array
		}
		// pre($data['row_twac']);
		// die;
		$hire_is_medical = '';
		$sql = "SELECT * FROM see_hrdb.hr_timework_attendance_config_group WHERE twag_id = ?";
		$this->hr = $this->load->database('hr', TRUE);
		$query = $this->hr->query($sql, array(
			$twag_id
		));
		$data['twag_data'] = $query->row();
		$hire_data = $this->session->userdata('hr_hire_is_medical');
		$count = count($hire_data);
		if ($count < 5) {
			$hire_is_medical = 'ของ';

			foreach ($hire_data as $key => $value) {
				if ($key == $count - 1 && $count > 1) {
					$hire_is_medical .= 'และ ';
				} elseif ($key != 0) {
					$hire_is_medical .= ' ';
				}

				switch ($value['type']) {
					case 'M':
						$hire_is_medical .= 'สายการแพทย์';
						break;
					case 'N':
						$hire_is_medical .= 'สายการพยาบาล';
						break;
					case 'SM':
						$hire_is_medical .= 'สายสนับสนุนทางการแพทย์';
						break;
					case 'A':
						$hire_is_medical .= 'สายบริหาร';
						break;
				}
			}
		}
		$data['person_option'] = $this->M_hr_person->get_all_profile_data(1, 'all', 'all', '1')->result();
		foreach ($data['person_option'] as $key => $row) {
			$array = array();
			$row->ps_id = encrypt_id($row->ps_id);
			$admin_name = json_decode($row->admin_position, true);
			if ($admin_name) {
				foreach ($admin_name as $value) {
					if (is_string($value)) {
						$value = json_decode($value, true);
					}
					if ($value['admin_name']) {
						$array[] = $value['admin_name'];
					}
				}
				$row->admin_position = $array;
			} else {
				empty($row->admin_position);
			}
		}
		$data['hire_is_medical'] = $hire_is_medical;

		$this->output($this->view . 'v_attendance_config_form', $data);
	}
	// attendance_config_form

	/*
	* attendance_config_save
	* บันทึกข้อมูลแบบฟอร์มรูปแบบการลงเวลาทำงาน
	* @input twac_id, ข้อมูลฟอร์มทั้งหมด
	* @output JSON response
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_save()
	{
		// รับค่าจาก POST
		$form_attendance_config = $this->input->post();
		// pre($form_attendance_config);
		// die;
		if (empty($form_attendance_config['twag_id'])) {
			$sql = "INSERT INTO see_hrdb.hr_timework_attendance_config_group 
			(twag_name_th, twag_name_abbr_th,twag_is_medical, twag_type, twag_active, twag_create_user)
			VALUES(?, ?, ?, ?, ?,?)";
			$this->hr = $this->load->database('hr', TRUE);
			$this->hr->query($sql, array(
				$form_attendance_config['twag_name_th'],
				$form_attendance_config['twag_name_abbr_th'],
				$form_attendance_config['option_twag_is_medical'],
				$form_attendance_config['option_twag_type'],
				1,
				$this->session->userdata('us_id')

			));
			$twag_id = $this->hr->insert_id();
		} else {
			$twag_id = decrypt_id($form_attendance_config['twag_id']);
			$sql = "UPDATE see_hrdb.hr_timework_attendance_config_group 
			SET twag_name_th = ?, 
				twag_name_abbr_th = ?, 
				twag_is_medical = ?, 
				twag_type = ?, 
				twag_active = ?, 
				twag_create_user = ?
			WHERE twag_id = ?"; // กำหนดเงื่อนไข WHERE
			$this->hr = $this->load->database('hr', TRUE);
			$this->hr->query($sql, array(
				$form_attendance_config['twag_name_th'],
				$form_attendance_config['twag_name_abbr_th'],
				$form_attendance_config['option_twag_is_medical'],
				$form_attendance_config['option_twag_type'],
				1, // ค่า twag_active
				$this->session->userdata('us_id'), // ค่า twag_create_user
				$twag_id // ค่าที่ใช้ในเงื่อนไข WHERE
			));
		}
		// $twap_list = json_decode($form_attendance_config['twac_person'], true);
		// $twac_id = decrypt_id($form_attendance_config['twac_id']);
		// ตั้งค่าข้อมูลที่รับมาจากฟอร์ม
		foreach ($form_attendance_config['twac_data'] as $key => $twac_data) {
			# code...
			$twac_id = decrypt_id($twac_data['twac_id']);
			if (is_string($twac_data['twap_data'])) {
				$twac_data['twap_data'] = json_decode($twac_data['twap_data'], true);
			}
			$this->M_hr_timework_attendance_config->twac_twag_id = $twag_id;
			$this->M_hr_timework_attendance_config->twac_name_th = $twac_data['twac_name_th'];
			$this->M_hr_timework_attendance_config->twac_name_abbr_th = $twac_data['twac_name_abbr_th'];
			$this->M_hr_timework_attendance_config->twac_start_time = $twac_data['twac_start_time'];
			$this->M_hr_timework_attendance_config->twac_end_time = $twac_data['twac_end_time'];
			$this->M_hr_timework_attendance_config->twac_late_time = $twac_data['twac_late_time'];
			$this->M_hr_timework_attendance_config->twac_is_medical = $form_attendance_config['option_twag_is_medical'];
			$this->M_hr_timework_attendance_config->twac_type = $form_attendance_config['option_twag_type'];
			$this->M_hr_timework_attendance_config->twac_color = $twac_data['twac_color'];

			$this->M_hr_timework_attendance_config->twac_update_user = $this->session->userdata('us_id');
			$this->M_hr_timework_attendance_config->twac_update_date = date('Y-m-d H:i:s');

			// ตรวจสอบว่าเป็นการเพิ่มใหม่หรือแก้ไข
			if (empty($twac_id)) {
				// เพิ่มข้อมูลใหม่
				$this->M_hr_timework_attendance_config->twac_active = 1;
				$this->M_hr_timework_attendance_config->twac_is_ot = (isset($twac_data['twac_is_ot']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_break = (isset($twac_data['twac_is_break']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_pre_cal = (isset($twac_data['twac_is_pre_cal']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_ot = (isset($twac_data['twac_is_ot']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_create_user = $this->session->userdata('us_id');
				$this->M_hr_timework_attendance_config->twac_create_date = date('Y-m-d H:i:s');
				$this->M_hr_timework_attendance_config->insert();
				if ($twac_data['twap_data']) {
					foreach ($twac_data['twap_data'] as $key => $value) {
						$this->M_hr_timework_attendance_config->insert_develop_person($this->M_hr_timework_attendance_config->last_insert_id, $value['ps_id'], $value['pos_dp_id'], $this->session->userdata('us_id'));
					}
				}
			} else {
				// แก้ไขข้อมูลเดิม
				$this->M_hr_timework_attendance_config->twac_active = (isset($twac_data['twac_active']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_ot = (isset($twac_data['twac_is_ot']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_break = (isset($twac_data['twac_is_break']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_is_pre_cal = (isset($twac_data['twac_is_pre_cal']) ? 1 : 0);
				$this->M_hr_timework_attendance_config->twac_id = $twac_id;
				if ($twac_data['twap_data']) {
					foreach ($twac_data['twap_data'] as $key => $value) {
						if ($value['check'] == 'old') {
							// pre($value['twap_status']);
							$this->M_hr_timework_attendance_config->update_develop_person($twac_id, $value['ps_id'], $value['twap_status'], $this->session->userdata('us_id'));
							// pre('เก่า');
						} else {
							$this->M_hr_timework_attendance_config->insert_develop_person($twac_id, $value['ps_id'], $value['pos_dp_id'], $this->session->userdata('us_id'));
						}
					}
				}
				$this->M_hr_timework_attendance_config->update();
			}
		}
		// กำหนดค่าการตอบกลับหลังจากบันทึกข้อมูลเสร็จ
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller); // URL กลับไปหน้าที่ต้องการ

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	/*
	* attendance_config_group_delete
	* เปลี่ยนสถานะกลุ่มรูปแบบการลงเวลาทำงานเป็น 2 (แทนการลบ)
	* @input twag_id
	* @output JSON data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_group_delete()
	{
		// รับค่าจาก POST
		$twag_id = decrypt_id($this->input->post('twag_id'));

		// ตรวจสอบว่าได้ค่า twac_id หรือไม่
		if (!empty($twag_id)) {
			// กำหนดค่า twac_id และเปลี่ยนสถานะ twac_active ให้เป็น 2
			$sql = "UPDATE see_hrdb.hr_timework_attendance_config_group 
			SET twag_active = ?
			WHERE twag_id = ?"; // กำหนดเงื่อนไข WHERE
			$this->hr = $this->load->database('hr', TRUE);
			$this->hr->query($sql, array(2, $twag_id));
			$data = array(
				'status_response' => $this->config->item('status_response_success'),
				'message_dialog' => $this->config->item('text_toast_delete_success_body'),
				'return_url' => site_url($this->controller)
			);
		} else {
			// ถ้าไม่ได้รับ twac_id
			$data = array(
				'status_response' => $this->config->item('status_response_error'),
				'message_dialog' => 'ไม่พบข้อมูลสำหรับการลบข้อมูล'
			);
		}

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	/*
	* attendance_config_delete
	* เปลี่ยนสถานะรูปแบบการลงเวลาทำงานเป็น 2 (แทนการลบ)
	* @input twac_id
	* @output JSON data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_delete()
	{
		// รับค่าจาก POST
		$twac_id = decrypt_id($this->input->post('twac_id'));

		// ตรวจสอบว่าได้ค่า twac_id หรือไม่
		if (!empty($twac_id)) {
			// กำหนดค่า twac_id และเปลี่ยนสถานะ twac_active ให้เป็น 2
			$this->M_hr_timework_attendance_config->twac_id = $twac_id;
			$this->M_hr_timework_attendance_config->twac_active = 2;

			// เรียกฟังก์ชัน update ในโมเดลเพื่อเปลี่ยนสถานะเป็น 2
			$this->M_hr_timework_attendance_config->update_status();
			$data = array(
				'status_response' => $this->config->item('status_response_success'),
				'message_dialog' => $this->config->item('text_toast_delete_success_body'),
				'return_url' => site_url($this->controller)
			);
		} else {
			// ถ้าไม่ได้รับ twac_id
			$data = array(
				'status_response' => $this->config->item('status_response_error'),
				'message_dialog' => 'ไม่พบข้อมูลสำหรับการลบข้อมูล'
			);
		}

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	// attendance_config_delete

	public function get_person_info()
	{
		$this->M_hr_person->ps_id = decrypt_id($this->input->post('ps_id'));
		$data['person'] = $this->M_hr_person->get_profile_detail_data_by_id($this->input->post('dp_id'))->row();
		$data['person']->detail = $this->M_hr_person->get_person_position_by_ums_department_detail(decrypt_id($this->input->post('ps_id')), $this->input->post('dp_id'))->row();
		$data['person']->detail->admin_position = json_decode($data['person']->detail->admin_position, true);
		$data['person']->detail->spcl_position = json_decode($data['person']->detail->spcl_position, true);
		$data['person']->detail->stde_name_th_group = json_decode($data['person']->detail->stde_name_th_group, true);
		echo json_encode($data);
	}
	public function get_person_list_dp_id()
	{
		$data['person_option'] = $this->M_hr_person->get_person_list_by_dp_id($this->input->post('dp_id'), $this->input->post('hire_type'), $this->input->post('hire_is_medical'), $this->input->post('stde_id'))->result();
		$data['name_stde_th'] = $this->M_hr_structure_detail->get_name_th_by_dp_id($this->input->post('dp_id'), $this->input->post('hire_is_medical'))->result();
		foreach ($data['person_option'] as $key => $value) {
			$value->person_id = $value->ps_id;
			$value->ps_id = encrypt_id($value->ps_id);
		}

		echo json_encode($data);
	}
	public function check_person()
	{
		$ps_id = decrypt_id($this->input->post('ps_id'));
		$twac_id = decrypt_id($this->input->post('twac_id'));
		$result = $this->M_hr_timework_attendance_config->get_attendance_person($ps_id, $twac_id)->row();
		if ($result) {
			$data['status_response'] = $this->config->item('status_response_error');
		} else {
			$data['status_response'] = $this->config->item('status_response_success');
		}
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function get_logs()
	{
		$host = '172.16.22.200'; // IP Address ของเครื่องสแกน
		$count = 4;
		$output = shell_exec("ping -c $count $host");

		// หรือสำหรับ Windows
		// $output = shell_exec("ping -n $count $host");

		if (strpos($output, 'time=') !== false || strpos($output, 'TTL=') !== false) {
			echo "Ping สำเร็จ: \n" . $output;
		} else {
			echo "Ping ไม่สำเร็จหรือไม่สามารถเชื่อมต่อได้!";
		}
		// $port = 5005;          // Port ที่เครื่องใช้

		// $zk = new ZKLibrary($ip, $port);
		// $zk->setTimeout(10); // ตั้งค่า Timeout เป็น 10 วินาที
		// pre('เข้า');
		// // $ret = $zk->connect();

		// if ($ret) {
		// 	echo "เชื่อมต่อสำเร็จ!<br>";
		// 	$attendance = $zk->getAttendance(); // ดึงข้อมูลการสแกน

		// 	foreach ($attendance as $att) {
		// 		echo "User ID: " . $att['id'] . " - Timestamp: " . $att['timestamp'] . "<br>";
		// 	}

		// 	$zk->disconnect();
		// } else {
		// 	echo "เชื่อมต่อไม่สำเร็จ!";
		// }
	}
	public function get_attendance_config_report_list()
	{
		$result = $this->M_hr_timework_attendance_config->get_attendance_report($this->input->post())->result();
		$attendance_report = [];
		foreach ($result as $key => $value) {
			$attendance_report[$key]['ps_name'] = $value->ps_name;
			$value->worktime_normal = json_decode($value->worktime_normal, true);
			$value->worktime_ot = json_decode($value->worktime_ot, true);
			$attendance_report[$key]['worktime_normal'] = '';
			$attendance_report[$key]['worktime_ot'] = '';

			// จัดกลุ่ม worktime_normal ตาม twac_twag_id
			$grouped_worktime_normal = [];
			foreach ($value->worktime_normal as $wtn => $value2) {
				if ($value2 != null) {
					$grouped_worktime_normal[$value2['twac_twag_id']][] = $value2;
				}
			}

			// ต่อ string worktime_normal โดยจัดกลุ่ม
			foreach ($grouped_worktime_normal as $twag_id => $items) {
				$attendance_report[$key]['worktime_normal'] .= '<b>' . $items[0]['twag_name'] . '</b><br>';
				$index = 1;
				foreach ($items as $item) {
					$attendance_report[$key]['worktime_normal'] .= '&nbsp;&nbsp;' . ($index++) . '. ' . $item['twac_name_th'] . '<br>';
				}
			}

			// จัดกลุ่ม worktime_ot ตาม twac_twag_id
			$grouped_worktime_ot = [];
			foreach ($value->worktime_ot as $wto => $value3) {
				if ($value3 != null) {
					$grouped_worktime_ot[$value3['twac_twag_id']][] = $value3;
				}
			}

			// ต่อ string worktime_ot โดยจัดกลุ่ม
			foreach ($grouped_worktime_ot as $twag_id => $items) {
				$attendance_report[$key]['worktime_ot'] .= '<b>' . $items[0]['twag_name'] . '</b><br>';
				$index = 1;
				foreach ($items as $item) {
					$attendance_report[$key]['worktime_ot'] .= '&nbsp;&nbsp;' . ($index++) . '. ' . $item['twac_name_th'] . '<br>';
				}
			}

			// ตรวจสอบค่าที่ว่าง
			if (empty($attendance_report[$key]['worktime_normal'])) {
				$attendance_report[$key]['worktime_normal'] = '-';
			}
			if (empty($attendance_report[$key]['worktime_ot'])) {
				$attendance_report[$key]['worktime_ot'] = '-';
			}
		}

		echo json_encode($attendance_report);
	}
}
