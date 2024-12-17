<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');
require APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Timework_calendar extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Timework_calendar/";
		$this->view .= "timework_calendar/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_timework_person_plan');
		$this->load->model($this->model . 'M_hr_timework_setting');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของจัดการลงเวลาการทำงาน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	public function calendar_list($actor_type = "")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['actor_type'] = $actor_type;
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$timework_setting_data = $this->M_hr_timework_setting->get_timework_setting_status_now()->row();

		if (isset($actor_type) && !empty($actor_type)) {
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

			if ($actor_type == "approver") {
				// $data['base_adline_position_list'] = $this->M_hr_person->get_hr_base_adline_position_data()->result();
				// $data['base_hire_list'] = $this->M_hr_person->get_hr_base_hire_data()->result();
				// $data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();

				$data['twpp_status'] = "A";
				$year = $timework_setting_data->twst_year - 543; // Convert Buddhist year to Gregorian
				$month = str_pad($timework_setting_data->twst_month, 2, "0", STR_PAD_LEFT); // Pad the month to 2 digits
				$day = "01"; // Set the day to the 1st day of the month

				$data['timework_date_open'] = $year . "-" . $month . "-" . $day;

				$data['timework_setting_data'] = $this->M_hr_timework_setting->get_timework_setting_status_now()->row();

				$timework_setting_start = $timework_setting_data->twst_start_date . ' ' . $timework_setting_data->twst_start_time;
				$timework_setting_end = $timework_setting_data->twst_end_date . ' ' . $timework_setting_data->twst_end_time;
				// Compare the current date with timework_setting_start_date
				if (date('Y-m-d H:i:s') < $timework_setting_start && date('Y-m-d H:i:s') > $timework_setting_end) {
					$this->M_hr_timework_person_plan->update_status_to_approver($timework_setting_data->twst_month);
				}

				$this->output($this->view . 'v_timework_calendar_approver_list', $data);
			} else if ($actor_type == "medical") {
				$data['twpp_status'] = "A";

				$data['timework_date_open'] = date("Y-m-01", strtotime("first day of next month"));

				$this->output($this->view . 'v_timework_calendar_medical_list', $data);
			} else {
				$data['twpp_status'] = "W";
				$year = $timework_setting_data->twst_year - 543; // Convert Buddhist year to Gregorian
				$month = str_pad($timework_setting_data->twst_month, 2, "0", STR_PAD_LEFT); // Pad the month to 2 digits
				$day = "01"; // Set the day to the 1st day of the month

				$data['timework_date_open'] = $year . "-" . $month . "-" . $day;
				
				$data['timework_setting_data'] = $this->M_hr_timework_setting->get_timework_setting_status_now()->row();
				// head_structure
				$this->output($this->view . 'v_timework_calendar_head_structure_list', $data);
			}
		} else {
			redirect($this->config->item('hr_dir') . $this->config->item('hr_timework_dir'), 'refresh');
		}
	}
	// calendar_list

	/*
	* get_profile_user_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	public function get_profile_user_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		if ($this->input->get('actor_type') == "approver") {
			// $result = $this->M_hr_timework_person_plan->get_all_profile_data($this->input->get('dp_id'), $this->input->get('hire_id'), $this->input->get('admin_id'), $this->input->get('status_id'))->result();
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('hire_is_medical'), $this->input->get('hire_type_id'), $this->input->get('status_id'))->result();
		}
		else if($this->input->get('actor_type') == "medical") {
			// $result = $this->M_hr_timework_person_plan->get_all_profile_data($this->input->get('dp_id'), $this->input->get('hire_id'), $this->input->get('admin_id'), $this->input->get('status_id'))->result();
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), 0, $this->input->get('hire_is_medical'), $this->input->get('hire_type_id'), $this->input->get('status_id'))->result();
		} else {
			// $result = $this->M_hr_timework_person_plan->get_all_profile_data_by_stucture($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('twpp_is_medical'), $this->input->get('status_id'))->result();
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('hire_is_medical'), $this->input->get('hire_type_id'))->result();
		}


		foreach ($result as $key => $row) {
			$row->ps_id_encrypt = encrypt_id($row->ps_id);
		}
		echo json_encode($result);
	}
	// get_profile_user_list

	/*
	* get_timework_plan_person_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	public function get_timework_plan_person_list()
	{

		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$result = [];
		if ($this->input->get('actor_type') == "approver" || $this->input->get('actor_type') == "medical") {
			// $result = $this->M_hr_timework_person_plan->get_all_profile_data($this->input->get('dp_id'), $this->input->get('hire_id'), $this->input->get('admin_id'), $this->input->get('status_id'))->result();
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), 0, $this->input->get('hire_is_medical'), $this->input->get('hire_type_id'), $this->input->get('status_id'))->result();
		} else {
			if (!empty($this->input->get('stde_id'))) {
				// $result = $this->M_hr_timework_person_plan->get_all_profile_data_by_stucture($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('twpp_is_medical'), $this->input->get('status_id'))->result();
				$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('hire_is_medical'), $this->input->get('hire_type_id'))->result();
			}
		}

		$timework_plan_list = array();

		foreach ($result as $key => $row) {
			$timework_plan_list[] = $this->M_hr_timework_person_plan->get_all_timework_data_by_person_id($row->ps_id, $this->input->get('dp_id'), $this->input->get('twpp_status'), $this->input->get('isPublic'), $this->input->get('timework_date_open'), $this->input->get('actor_type'))->result();
		}

		echo json_encode($timework_plan_list);
	}
	// get_timework_plan_person_list

	/*
	* get_timework_plan_person_id
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	public function get_timework_plan_person_id()
	{
		$timework_plan_list = array();

		$timework_plan_list[] = $this->M_hr_timework_person_plan->get_all_timework_data_by_person_id(decrypt_id($this->input->get('ps_id')), $this->input->get('dp_id'), $this->input->get('twpp_status'), $this->input->get('isPublic'),  $this->input->get('timework_date_open'), $this->input->get('actor_type'))->result();
		echo json_encode($timework_plan_list);
	}
	// get_timework_plan_person_id

	/*
	* get_structure_detail_by_dpid_psid
	* ดึงข้อมูลโครงสร้างองค์กรตาม ps_id
	* @input dp_id, us_ps_id
	* $output structure detail by dp_id ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_structure_detail_by_dpid_psid()
	{
		if ($this->input->get('actor_type') == "approver" || $this->input->get('actor_type') == "medical") {
			$result = $this->M_hr_person->get_structure_detail_by_dp_level($this->input->get('dp_id'), 3)->result();
		} else {
			$result = $this->M_hr_person->get_structure_detail_by_dpid_psid($this->input->get('dp_id'), $this->session->userdata('us_ps_id'))->result();
		}
		echo json_encode($result);
	}
	// get_structure_detail_by_dpid_psid

	/*
	* get_eqs_building_list
	* ดึงข้อมูลข้อมูลสิ่งก่อสร้าง/อาคาร
	* @input -
	* $output eqs building data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_eqs_building_list()
	{
		$result = $this->M_hr_timework_person_plan->get_eqs_building_data($this->input->get('dp_id'))->result();
		echo json_encode($result);
	}
	// get_eqs_building_list

	/*
	* get_eqs_room_list
	* ดึงข้อมูลสิ่งก่อสร้าง/อาคาร
	* @input bd_id
	* $output eqs room data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_eqs_room_list()
	{
		$bd_id = $this->input->get('bd_id');
		$result['rooms'] = $this->M_hr_timework_person_plan->get_eqs_room_data($bd_id)->result();
		$result['building_type'] = $this->M_hr_timework_person_plan->get_eqs_building_type_data()->result();
		echo json_encode($result);
	}
	// get_eqs_room_list

	/*
	* get_timework_attendance_config_list
	* ดึงข้อมูลรูปแบบการลงเวลาทำงาน
	* @input ps_id, dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_timework_attendance_config_list()
	{
		$this->load->model($this->model . 'M_hr_timework_attendance_config');
		$ps_id = $this->input->get('ps_id');
		$dp_id = $this->input->get('dp_id');

		$result = $this->M_hr_timework_attendance_config->get_attendance_config_person_data($ps_id, $dp_id)->result();
		echo json_encode($result);
	}
	// get_timework_attendance_config_list

	/*
	* get_all_structure_list
	* ดึงข้อมูลโครงสร้างองค์กร
	* @input dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 09/10/2024
	*/
	function get_all_structure_list()
	{
		$dp_id = $this->input->get('dp_id');
		$result = $this->M_hr_person->get_all_structure_had_confirm($dp_id)->result();

		foreach ($result as $key => $row) {
			$row->stuc_confirm_date = fullDateTH3($row->stuc_confirm_date);
		}
		echo json_encode($result);
	}
	// get_all_structure_list

	/*
	* get_structure_detail_by_stuc_id
	* ดึงข้อมูลรายละเอียดโครงสร้างองค์กร
	* @input stuc_id, dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 09/10/2024
	*/
	function get_structure_detail_by_stuc_id()
	{
		$result = [];
		
		if (!empty($this->input->get('stuc_id')) || $this->input->get('stuc_id') != "") {
			if ($this->input->get('actor_type') == "approver" || $this->input->get('actor_type') == "medical") {
				$result = $this->M_hr_person->get_structure_detail_by_param($this->input->get('stuc_id'), $this->input->get('dp_id'), 3)->result();
			} else {
				$stuc_id = ($this->input->get('stuc_id') == 'all' ? "" : $this->input->get('stuc_id'));
				$result = $this->M_hr_person->get_structure_detail_by_dpid_psid($this->input->get('dp_id'), $this->session->userdata('us_ps_id'), $stuc_id)->result();
			}
		}
		

		
		echo json_encode($result);
	}
	// get_structure_detail_by_stuc_id




	/*
	* get_timework_user
	* ข้อมูลรายเอียดลงเวลาทำงานของบุคลากรรายคน
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	public function get_timework_user($ps_id, $dp_id, $twpp_status, $actor_type)
	{
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
		$this->load->model($this->config->item('ums_dir') . 'M_ums_department');

		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$ps_id = decrypt_id($ps_id);
		$data['ps_id'] = $ps_id;
		$data['encrypt_ps_id'] = encrypt_id($ps_id);
		$data['view_dir'] = $this->view;
		$data['twpp_status'] = $twpp_status;
		$data['actor_type'] = $actor_type;
		$data['dp_id'] = $dp_id;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();

		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$data['base_structure_position'] = $this->M_hr_structure_position->get_all_by_active('asc')->result();
		$timework_setting_data = $this->M_hr_timework_setting->get_timework_setting_status_now()->row();
		$position_department_array = array();
		foreach ($data['person_department_topic'] as $row) {
			$array_tmp = $this->M_hr_person->get_person_position_by_ums_department_detail($data['ps_id'], $row->dp_id)->row();
			array_push($position_department_array, $array_tmp);
		}

		foreach ($position_department_array as $key => $value) {
			$stde_info = json_decode($value->stde_name_th_group, true);
			if ($stde_info) {
				foreach ($stde_info as $item) {
					$id = $item['stdp_po_id'];
					$name = $item['stde_name_th'];

					// ถ้ายังไม่มีการจัดกลุ่มสำหรับ stdp_po_id นี้
					if (!isset($grouped[$id])) {
						$grouped[$id] = [
							'stdp_po_id' => $id,
							'stde_name_th' => []
						];
					}

					// เพิ่มชื่อเข้าไปในกลุ่ม
					$grouped[$id]['stde_name_th'][] = $name;
				}
				// เปลี่ยนให้เป็น array ของ associative arrays
				$grouped = array_values($grouped);
				$value->stde_admin_position = $grouped;
			} else {
				$value->stde_admin_position = [];
			}
		}
		$data['person_department_detail'] = $position_department_array;

		if ($actor_type == "approver" || $actor_type == "head_structure") {
			$year = $timework_setting_data->twst_year - 543; // Convert Buddhist year to Gregorian
			$month = str_pad($timework_setting_data->twst_month, 2, "0", STR_PAD_LEFT); // Pad the month to 2 digits
			$day = "01"; // Set the day to the 1st day of the month

			$data['timework_date_open'] = $year . "-" . $month . "-" . $day;
			
			$data['timework_setting_data'] = $this->M_hr_timework_setting->get_timework_setting_status_now()->row();
			$this->output($this->view . 'v_timework_calendar_approver_person', $data);
			
		} else {
			$data['timework_date_open'] = date("Y-m-01", strtotime("first day of next month"));
			$this->output($this->view . 'v_timework_calendar_medical_person', $data);
		} 
	}
	// get_timework_user

	/*
	* timework_calendar_save
	* บันทึกหรือแก้ไขข้อมูลลงเวลาทำงานของบุคลากรรายคน
	* @input form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/09/2024
	*/
	public function timework_calendar_save()
	{

		$twpp_ps_id = $this->input->post('twpp_ps_id');
		$twpp_id = $this->input->post('twpp_id');

		// แยกวันที่และเวลาของ start
		list($start_date, $start_time) = explode(' ', $this->input->post('twpp_start_date'));

		// แยกวันที่และเวลาของ end
		list($end_date, $end_time) = explode(' ', $this->input->post('twpp_end_date'));

		// ตั้งค่าโมเดล M_hr_timework_person_plan
		$this->M_hr_timework_person_plan->twpp_ps_id = $twpp_ps_id;
		$this->M_hr_timework_person_plan->twpp_twac_id = $this->input->post('twpp_twac_id');
		$this->M_hr_timework_person_plan->twpp_dp_id = $this->input->post('twpp_dp_id');
		$this->M_hr_timework_person_plan->twpp_start_date = $start_date;
		$this->M_hr_timework_person_plan->twpp_end_date = $end_date;
		$this->M_hr_timework_person_plan->twpp_start_time = $start_time;
		$this->M_hr_timework_person_plan->twpp_end_time = $end_time;
		$this->M_hr_timework_person_plan->twpp_rm_id = $this->input->post('twpp_rm_id');
		$this->M_hr_timework_person_plan->twpp_desc = $this->input->post('twpp_desc');
		$this->M_hr_timework_person_plan->twpp_is_public = $this->input->post('twpp_is_public');
		$this->M_hr_timework_person_plan->twpp_is_holiday = $this->input->post('twpp_is_holiday');
		$this->M_hr_timework_person_plan->twpp_status = ($this->input->post('twpp_status') == 'S' ? 'S' : $this->input->post('twpp_status'));

		// ตรวจสอบว่ามีการแก้ไขหรือสร้างใหม่
		if (isset($twpp_id) && !empty($twpp_id)) {
			$this->M_hr_timework_person_plan->twpp_id = $twpp_id;
			$this->M_hr_timework_person_plan->twpp_update_user = $this->session->userdata('us_id');
			$this->M_hr_timework_person_plan->twpp_update_date = date('Y-m-d H:i:s');
			$this->M_hr_timework_person_plan->update();
		} else {
			$this->M_hr_timework_person_plan->twpp_create_user = $this->session->userdata('us_id');
			$this->M_hr_timework_person_plan->twpp_create_date = date('Y-m-d H:i:s');
			$this->M_hr_timework_person_plan->insert();
			$result['last_insert_twpp_id'] = $this->M_hr_timework_person_plan->last_insert_id;
		}

		// echo $this->M_hr_timework_person_plan->hr->last_query();
		// ส่งสถานะการตอบกลับ
		$result['status_response'] = $this->config->item('status_response_success');
		$result['message_dialog'] = $this->config->item('text_toast_default_success_body');

		// ส่งข้อมูลกลับในรูปแบบ JSON
		echo json_encode($result);
	}


	/*
	* timework_calendar_delete
	* ลบข้อมูลลงเวลาทำงานของบุคลากรรายคน
	* @input twpp_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/09/2024
	*/
	public function timework_calendar_delete()
	{

		$this->M_hr_timework_person_plan->twpp_id = $this->input->post('twpp_id');
		$this->M_hr_timework_person_plan->delete();

		$result['status_response'] = $this->config->item('status_response_success');
		$result['message_dialog'] = $this->config->item('text_toast_default_success_body');

		echo json_encode($result);
	}
	// timework_calendar_delete

	/*
	* get_timework_setting_list
	* ดึงข้อมูลกำหนดการลงเวลาทำงานทั้งหมด
	* @input twpp_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/09/2024
	*/
	public function get_timework_setting_list()
	{
		$result = $this->M_hr_timework_setting->get_all_timework_setting_by_param()->result();

		foreach ($result as $key => $row) {
			$row->twst_id = encrypt_id($row->twst_id);
			$row->start_date_text = abbreDate2($row->twst_start_date) . " " . $row->twst_start_time;
			$row->end_date_text = abbreDate2($row->twst_end_date) . " " . $row->twst_end_time;
			$row->month_text = getNowMonthTh($row->twst_month);
		}
		echo json_encode($result);
	}
	// get_timework_setting_list

	/*
	* get_timework_setting_by_id
	* ดึงข้อมูลกำหนดการลงเวลาทำงานตามไอดี
	* @input twst_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/09/2024
	*/
	public function get_timework_setting_by_id()
	{
		$twst_id = decrypt_id($this->input->post('twst_id'));
		$this->M_hr_timework_setting->twst_id = $twst_id;
		$result = $this->M_hr_timework_setting->get_by_key()->result();

		foreach ($result as $key => $row) {
			$row->twst_id = encrypt_id($row->twst_id);
			$row->start_date_text = abbreDate2($row->twst_start_date) . " " . $row->twst_start_time;
			$row->end_date_text = abbreDate2($row->twst_end_date) . " " . $row->twst_end_time;
		}
		
		echo json_encode($result[0]);
	}
	// get_timework_setting_by_id

	/*
	* timework_setting_save
	* บันทึกข้อมูลกำหนดการลงเวลาทำงาน
	* @input twpp_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/09/2024
	*/
	public function timework_setting_save()
	{

		// รับค่าจาก POST
		$form_attendance_setting = $this->input->post();

		$twst_id = decrypt_id($form_attendance_setting['twst_id']);

		// ตั้งค่าข้อมูลที่รับมาจากฟอร์ม
		$this->M_hr_timework_setting->twst_month = $form_attendance_setting['twst_month'];
		$this->M_hr_timework_setting->twst_year = $form_attendance_setting['twst_year'];
		$this->M_hr_timework_setting->twst_start_date = splitDateForm1($form_attendance_setting['twst_start_date']);
		$this->M_hr_timework_setting->twst_end_date = splitDateForm1($form_attendance_setting['twst_end_date']);
		$this->M_hr_timework_setting->twst_start_time = $form_attendance_setting['twst_start_time'];
		$this->M_hr_timework_setting->twst_end_time = $form_attendance_setting['twst_end_time'];
		

		$this->M_hr_timework_setting->twst_update_user = $this->session->userdata('us_id');
		$this->M_hr_timework_setting->twst_update_date = date('Y-m-d H:i:s');

		$check_duplicate_data = $this->M_hr_timework_setting->get_timework_setting_duplicate();

		if(empty($twst_id) && $check_duplicate_data->num_rows() > 0){
			$result['status_response'] = $this->config->item('status_response_error');
			$result['message_dialog'] = $this->config->item('text_invalid_duplicate');
		}
		else{
			// ตรวจสอบว่าเป็นการเพิ่มใหม่หรือแก้ไข
			if (empty($twst_id)) {
				// เพิ่มข้อมูลใหม่
				$this->M_hr_timework_setting->twst_status = "N";
				$this->M_hr_timework_setting->twst_create_user = $this->session->userdata('us_id');
				$this->M_hr_timework_setting->twst_create_date = date('Y-m-d H:i:s');
				$this->M_hr_timework_setting->insert();
			} else {
				// แก้ไขข้อมูลเดิม
				$this->M_hr_timework_setting->twst_status = $form_attendance_setting['twst_status'];
				$this->M_hr_timework_setting->twst_id = $twst_id;
				$this->M_hr_timework_setting->update();
			}
			$result['status_response'] = $this->config->item('status_response_success');
			$result['message_dialog'] = $this->config->item('text_toast_default_success_body');
		}

		echo json_encode($result);
	}
	// timework_setting_save

	/*
	* change_status_timework_setting
	* ยืนยันสถานะกำหนดเวลาการลงเวลาทำงาน
	* @input event_calendar
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 09/10/2024
	*/
	function change_status_timework_setting()
	{
		$twst_id = decrypt_id($this->input->post('twst_id'));

		$this->M_hr_timework_setting->twst_id = $twst_id;
		$this->M_hr_timework_setting->update_all_status();

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	// change_status_timework_setting


	/*
	* timework_calendar_confirm
	* ยืนยันข้อมูลการลงข้อมูลการทำงาน
	* @input event_calendar
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 09/10/2024
	*/
	function timework_calendar_confirm()
	{
		$event_calendar = $this->input->post("event_calendar");
		$event_status = $this->input->post("event_status");

		// สมมติว่าคุณต้องการอัปเดตข้อมูลสำหรับแต่ละ event
		if (!empty($event_calendar)) {
			foreach ($event_calendar as $event_id) {
				// อัปเดตข้อมูลของแต่ละ event โดยใช้ ID
				$this->M_hr_timework_person_plan->twpp_id = $event_id;
				$this->M_hr_timework_person_plan->twpp_status = $event_status;
				$this->M_hr_timework_person_plan->twpp_update_user = $this->session->userdata('us_id');
				$this->M_hr_timework_person_plan->twpp_update_date = date('Y-m-d H:i:s');
				$this->M_hr_timework_person_plan->update_status();
			}
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	// timework_calendar_confirm

	/**
	 * export_print_timework_calendar
	 * พิมพ์รายงานตารางการลงเวลาทำงานในรูปแบบ HTML
	 * @input ps_id, isPublic
	 * @output HTML สำหรับพิมพ์
	 * @author Tanadon Tangjaimongkhon
	 * @Create Date 07/10/2024
	 */
	function export_print_timework_calendar($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date)
	{
		// ดึงข้อมูล
		$data['timework_data'] = $this->get_timework_plan_person_report($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date);

		// ตรวจสอบว่ามีข้อมูลหรือไม่
		if (empty($data['timework_data'])) {
			show_error('ไม่พบข้อมูลการลงเวลาทำงาน', 404);
			return;
		}

		// ใช้ substr() เพื่อตัดเอาเฉพาะปีและเดือนออกมา
		$start_year = substr($filter_start_date, 0, 4);  // ตัดปีจากตำแหน่งที่ 0 ถึง 4
		$start_month = substr($filter_start_date, 5, 2); // ตัดเดือนจากตำแหน่งที่ 5 ถึง 7

		$data['filter_start_date'] = $filter_start_date;
		$data['filter_end_date'] = $filter_end_date;
		$data['actor_type'] = $actor_type;
		$data['ps_full_name'] = $data['timework_data'][0]->pf_name_abbr . $data['timework_data'][0]->ps_fname . ' ' . $data['timework_data'][0]->ps_lname;

		// ดึง HTML จาก view
		$html = $this->load->view($this->view . 'v_pdf_timework_calendar', $data, true);

		// โหลดไลบรารี mPDF
		require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

		// สร้างอินสแตนซ์ของ mPDF พร้อมตั้งค่ากระดาษเป็นแนวนอน (landscape)
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4-L', // กำหนดรูปแบบกระดาษเป็น A4 และแนวนอน
			'default_font_size' => 16,
			'default_font' => 'sarabun', // ฟอนต์ Sarabun รองรับภาษาไทย
			'margin_top' => 5,    // ปรับขอบบน
			'margin_bottom' => 5, // ปรับขอบล่าง
			'margin_left' => 5,   // ปรับขอบซ้าย
			'margin_right' => 5,  // ปรับขอบขวา
		]);

		// ตั้งค่าให้ใช้ฟอนต์ Sarabun ที่ถูกต้อง
		$mpdf->fontdata['sarabun'] = [
			'R' => "THSarabunNew.ttf",         // ฟอนต์ปกติ
			'B' => "THSarabunNew-Bold.ttf",    // ฟอนต์หนา
			'I' => "THSarabunNew-Italic.ttf",  // ฟอนต์เอียง
		];

		// ส่ง HTML ที่โหลดจาก view เข้าไปใน mPDF
		$mpdf->WriteHTML($html);

		// ส่งออกเป็นไฟล์ PDF
		$mpdf->Output($data['title_report'] . '.pdf', 'I'); // 'I' = แสดงผลในเบราว์เซอร์
		exit;
	}
	// export_print_timework_calendar


	/**
	 * export_pdf_timework_calendar
	 * ส่งออกตารางการลงเวลาทำงานเป็นไฟล์ PDF
	 * @input ps_id, isPublic
	 * @output ไฟล์ PDF
	 * @author Tanadon Tangjaimongkhon
	 * @Create Date 07/10/2024
	 */
	function export_pdf_timework_calendar($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date)
	{
		// ดึงข้อมูล
		$data['timework_data'] = $this->get_timework_plan_person_report($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date);

		// ตรวจสอบว่ามีข้อมูลหรือไม่
		if (empty($data['timework_data'])) {
			show_error('ไม่พบข้อมูลการลงเวลาทำงาน', 404);
			return;
		}

		// ใช้ substr() เพื่อตัดเอาเฉพาะปีและเดือนออกมา
		$start_year = substr($filter_start_date, 0, 4);  // ตัดปีจากตำแหน่งที่ 0 ถึง 4
		$start_month = substr($filter_start_date, 5, 2); // ตัดเดือนจากตำแหน่งที่ 5 ถึง 7

		$data['filter_start_date'] = $filter_start_date;
		$data['filter_end_date'] = $filter_end_date;
		$data['actor_type'] = $actor_type;
		$data['ps_full_name'] = $data['timework_data'][0]->pf_name_abbr . $data['timework_data'][0]->ps_fname . ' ' . $data['timework_data'][0]->ps_lname;

		if ($actor_type == "medical") {
			$data['title_report'] = "ตารางแพทย์ออกตรวจ " . $ps_full_name . " ประจำเดือน" . getMonthTh($start_month) . " พ.ศ." . ($start_year + 543);
		} else {
			$data['title_report'] = "ตารางปฏิทินการทำงาน " . $ps_full_name . " ประจำเดือน" . getMonthTh($start_month) . " พ.ศ." . ($start_year + 543);
		}

		// ดึง HTML จาก view
		$html = $this->load->view($this->view . 'v_pdf_timework_calendar', $data, true);

		// โหลดไลบรารี mPDF
		require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

		// สร้างอินสแตนซ์ของ mPDF พร้อมตั้งค่ากระดาษเป็นแนวนอน (landscape)
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4-L', // กำหนดรูปแบบกระดาษเป็น A4 และแนวนอน
			'default_font_size' => 16,
			'default_font' => 'sarabun', // ฟอนต์ Sarabun รองรับภาษาไทย
			'margin_top' => 5,    // ปรับขอบบน
			'margin_bottom' => 5, // ปรับขอบล่าง
			'margin_left' => 5,   // ปรับขอบซ้าย
			'margin_right' => 5,  // ปรับขอบขวา
		]);

		// ตั้งค่าให้ใช้ฟอนต์ Sarabun ที่ถูกต้อง
		$mpdf->fontdata['sarabun'] = [
			'R' => "THSarabunNew.ttf",         // ฟอนต์ปกติ
			'B' => "THSarabunNew-Bold.ttf",    // ฟอนต์หนา
			'I' => "THSarabunNew-Italic.ttf",  // ฟอนต์เอียง
		];

		// ส่ง HTML ที่โหลดจาก view เข้าไปใน mPDF
		$mpdf->WriteHTML($html);

		// ส่งออกเป็นไฟล์ PDF
		$mpdf->Output($data['title_report'] . '.pdf', 'D'); // 'I' = แสดงผลในเบราว์เซอร์
		exit;
	}
	// export_pdf_timework_calendar



	public function export_excel_timework_calendar($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date)
	{
		ini_set('memory_limit', '512M'); // เพิ่ม memory limit
		// ดึงข้อมูล
		$timework_data = $this->get_timework_plan_person_report($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date);

		// ตรวจสอบว่ามีข้อมูลหรือไม่
		if (empty($timework_data)) {
			show_error('ไม่พบข้อมูลการลงเวลาทำงาน', 404);
			return;
		}

		// สร้าง Excel Spreadsheet
		$spreadsheet = new Spreadsheet();

		// ตั้งค่า font ทั่วไปเป็น Sarabun New ขนาด 14
		$spreadsheet->getDefaultStyle()->getFont()->setName('TH Sarabun New')->setSize(14);

		// แปลงวันที่เริ่มต้นและสิ้นสุด
		$start_date = new DateTime($filter_start_date);
		$end_date = new DateTime($filter_end_date);

		// กลุ่มข้อมูลตามวันที่
		$grouped_timework = $this->group_by_date($timework_data);

		// วนลูปสร้างแท็บสำหรับแต่ละเดือนในช่วงวันที่
		while ($start_date <= $end_date) {
			$year = $start_date->format('Y');
			$month = $start_date->format('m');
			$sheetTitle = $start_date->format('F Y'); // ชื่อแท็บเป็นเดือนและปี

			// สร้าง Sheet ใหม่สำหรับแต่ละเดือน
			$sheet = $spreadsheet->createSheet();
			$sheet->setTitle($sheetTitle);

			// ตั้งค่าความกว้างของคอลัมน์
			$columns = range('A', 'N'); // เพิ่มจำนวนคอลัมน์ให้เพียงพอสำหรับชื่อและเวลา
			foreach ($columns as $column) {
				$sheet->getColumnDimension($column)->setWidth(20);
			}

			// เพิ่มหัวข้อปฏิทิน และ merge cell
			$sheet->setCellValue('A1', $start_date->format('F Y')); // ใส่หัวข้อปฏิทิน
			$sheet->mergeCells('A1:N1'); // รวมเซลล์ตั้งแต่ A1 ถึง N1
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16); // ตั้งค่าตัวหนาและขนาดตัวอักษร
			$sheet->getRowDimension('1')->setRowHeight(30); // ปรับความสูงของแถว
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // จัดกลาง

			// เพิ่มหัวข้อสำหรับวันในสัปดาห์และ merge cell วัน พร้อมกับพื้นหลังสีเทาเข้ม
			$daysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
			$col = 1;

			// วนลูปเพื่อสร้างหัวข้อวันและทำการ merge cell พร้อมตั้งค่าพื้นหลัง
			foreach ($daysOfWeek as $day) {
				$dayCellStart = $columns[$col - 1] . '2'; // คอลัมน์แรกของแต่ละวัน
				$dayCellEnd = $columns[$col] . '2'; // คอลัมน์ที่สองของแต่ละวัน
				$sheet->mergeCells($dayCellStart . ':' . $dayCellEnd); // Merge คอลัมน์ของวัน
				$sheet->setCellValue($dayCellStart, $day); // ใส่ชื่อวัน
				$sheet->getStyle($dayCellStart)->getFont()->setBold(true); // ตั้งค่าตัวหนาสำหรับวัน
				$sheet->getStyle($dayCellStart)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // จัดกึ่งกลาง

				// เพิ่มพื้นหลังสีเทาเข้ม
				$sheet->getStyle($dayCellStart . ':' . $dayCellEnd)->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'color' => ['argb' => 'FF808080'] // สีเทาเข้ม
					]
				]);

				// ขยับไปยังชุดคอลัมน์ต่อไป
				$col += 2;
			}

			// หาจำนวนวันในเดือน
			$days_in_month = $start_date->format('t');
			$start_day_of_week = (new DateTime("$year-$month-01"))->format('w');

			// เริ่มที่แถวที่ 3 สำหรับปฏิทิน
			$row = 3;
			$col = $start_day_of_week * 2 + 1; // ขยับตำแหน่งสำหรับวันแรก

			// วนลูปแสดงวันที่ในเดือน
			for ($day = 1; $day <= $days_in_month; $day++) {
				$current_date = sprintf('%s-%s-%02d', $year, $month, $day);
				$date_cell_start = $columns[$col - 1] . $row; // ตำแหน่งเซลล์สำหรับวัน (ช่องแรก)
				$date_cell_end = $columns[$col] . $row; // ตำแหน่งเซลล์สำหรับวัน (ช่องที่สอง)

				// ทำการ merge เซลล์วันและเลขวัน
				$sheet->mergeCells($date_cell_start . ':' . $date_cell_end);
				$sheet->setCellValue($date_cell_start, $day); // แสดงเลขวันที่ในเซลล์ที่ merge

				// ปรับเส้นกรอบสีดำรอบช่องหมายเลขวัน
				$sheet->getStyle($date_cell_start . ':' . $date_cell_end)->applyFromArray([
					'borders' => [
						'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']], // เส้นกรอบซ้ายสีดำ
						'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']], // เส้นกรอบขวาสีดำ
						'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']],   // เส้นกรอบบนสีดำ
						'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']], // เส้นกรอบล่างสีดำ
					]
				]);

				// ตรวจสอบว่ามีข้อมูลการทำงานในวันนี้หรือไม่
				if (isset($grouped_timework[$current_date])) {
					foreach ($grouped_timework[$current_date] as $index => $work) {
						// ตำแหน่งเซลล์สำหรับชื่อบุคคล
						$name_cell = $columns[$col - 1] . ($row + ($index * 2) + 1);
						// ตำแหน่งเซลล์สำหรับเวลา
						$time_cell = $columns[$col] . ($row + ($index * 2) + 1);

						// แสดงชื่อบุคคลในคอลัมน์แรก
						$sheet->setCellValue($name_cell, $work->pf_name_abbr . ' ' . $work->ps_fname);

						// แสดงเวลาทำงานในคอลัมน์ถัดไป
						$sheet->setCellValue($time_cell, substr($work->twpp_start_time, 0, 5) . '-' . substr($work->twpp_end_time, 0, 5));

						// กำหนดเส้นกรอบเฉพาะเส้นขวาของช่องชื่อบุคลากรเป็นสีเทา
						$sheet->getStyle($name_cell)->applyFromArray([
							'borders' => [
								'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB0B0B0']], // เส้นกรอบขวาสีเทา
							]
						]);
					}
				} else {
					// หากไม่มีข้อมูลการทำงาน ให้เว้นว่าง
					$sheet->setCellValue($columns[$col - 1] . ($row + 1), ''); // ชื่อว่าง
					$sheet->setCellValue($columns[$col] . ($row + 1), ''); // เวลา ว่าง

					// กำหนดเส้นกรอบเฉพาะเส้นขวาของช่องชื่อบุคลากรเป็นสีเทา
					$sheet->getStyle($columns[$col - 1] . ($row + 1))->applyFromArray([
						'borders' => [
							'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB0B0B0']],
						]
					]);
				}

				// เลื่อนตำแหน่งคอลัมน์
				if ($col == 13) { // ขยับจากคอลัมน์ G และ N ที่สุดท้ายของแถว
					$col = 1;
					$row += 8; // เลื่อนแถวลง 4 แถว เพื่อรองรับข้อมูล
				} else {
					$col += 2; // ขยับไปอีก 2 คอลัมน์ (ชื่อและเวลา)
				}
			}

			// เพิ่มกรอบของเซลล์ในทุกช่อง
			$styleArray = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => 'FF000000'],
					],
				],
			];

			// ตั้งค่ากรอบของเซลล์ตั้งแต่ A2 ถึง N(สุดท้าย)
			$sheet->getStyle('A2:N' . ($row))->applyFromArray($styleArray);

			// เลื่อนไปยังเดือนถัดไป
			$start_date->modify('first day of next month');
		}

		// ตั้งค่าหน้ากระดาษเป็น A4 แนวนอน
		foreach ($spreadsheet->getAllSheets() as $sheet) {
			$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
		}

		// ตั้งค่าให้แผ่นแรกเป็นแอคทีฟ
		$spreadsheet->setActiveSheetIndex(0);

		$ps_full_name = $timework_data[0]->pf_name_abbr . $timework_data[0]->ps_fname . ' ' . $timework_data[0]->ps_lname;
		$title_report = "ปฏิทินการทำงาน_" . $ps_full_name . "_" . $filter_start_date . "_ถึง_" . $filter_end_date;

		// ส่งออกเป็นไฟล์ Excel
		$writer = new Xlsx($spreadsheet);
		ob_clean(); // ทำความสะอาด output buffer
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $title_report . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit;
	}





	// ฟังก์ชันจัดกลุ่มข้อมูลตามวันที่
	private function group_by_date($data) {
		$grouped = [];
		foreach ($data as $item) {
			$start_date = strtotime($item->twpp_start_date);
			$end_date = strtotime($item->twpp_end_date);
			for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
				$date_key = date('Y-m-d', $current_date);
				$grouped[$date_key][] = $item;
			}
		}
		return $grouped;
	}





	/*
	* get_timework_plan_person_report
	* ข้อมูลรายการบุคลากรตาม filter
	* @input ps_id, isPublic
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/10/2024
	*/
	public function get_timework_plan_person_report($ps_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date)
	{
		$ps_id = decrypt_id($ps_id);
		$result = $this->M_hr_timework_person_plan->get_all_timework_param_data_by_person_id($ps_id, $isPublic, $dp_id, $filter_start_date, $filter_end_date)->result();

		return $result;
	}
	// get_timework_plan_person_report

	/*
	* get_timework_plan_person_report
	* ข้อมูลรายการบุคลากรตาม filter
	* @input ps_id, isPublic
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/10/2024
	*/
	public function get_timework_plan_person_preview_report_list()
	{
		$result = [];
		// pre($this->input->get());
		if (!empty($this->input->get('stde_id'))) {
			// $result = $this->M_hr_timework_person_plan->get_all_profile_person_preview_report($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('hire_is_medical'), $this->input->get('hire_type'), $this->input->get('status_id'), $start_date, $end_date, $this->input->get('public'))->result();
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), $this->input->get('stde_id'), $this->input->get('hire_is_medical'), $this->input->get('hire_type'), $this->input->get('status_id'))->result();
		} else {
			$result = $this->M_hr_timework_person_plan->get_all_profile_data_by_param($this->input->get('dp_id'), 0, $this->input->get('hire_is_medical'), $this->input->get('hire_type'), $this->input->get('status_id'))->result();
		}

		$timework_plan_list = array();

		foreach ($result as $key => $row) {
			$list = $this->M_hr_timework_person_plan->get_all_timework_preview_report_list($row->ps_id, $this->input->get('public'), $this->input->get('dp_id'), $this->input->get('start_date'), $this->input->get('end_date'));
			$row->ps_id = encrypt_id($row->ps_id);
			if (!empty($list)) {
				foreach ($list as $i => $twpp) {
					$twpp->twpp_start_date_text = abbreDate2($twpp->twpp_display_date);
					// $twpp->twpp_end_date_text = abbreDate2($twpp->twpp_end_date);
					$twpp->twpp_start_time_text = substr($twpp->twpp_start_time, 0, 5);
					$twpp->twpp_end_time_text = substr($twpp->twpp_end_time, 0, 5);
					if ($row->hire_is_medical == "M") {
						$twpp->actor_type = "medical";
					} else {
						$twpp->actor_type = "approver";
					}
					$twpp->twpp_ps_id = $row->ps_id;
				}
				// pre( $list);
				$timework_plan_list = array_merge($timework_plan_list, $list);
			}
		}
		// pre($timework_plan_list);
		echo json_encode($timework_plan_list);
	}
	// get_timework_plan_person_preview_report_list

	/*
	* preview_timework_calendar_person
	* หน้าจอรายงานภาพรวมการลงเวล่าทำงานรายคน
	* @input $ps_id, $isPublic, $stuc_id, $stde_id, $dp_id, $start_date, $end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 11/10/2024
	*/
	function preview_timework_calendar_person($ps_id, $isPublic, $dp_id, $start_date, $end_date)
	{
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
		$this->load->model($this->config->item('ums_dir') . 'M_ums_department');

		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$ps_id = decrypt_id($ps_id);
		$data['ps_id'] = $ps_id;
		$data['encrypt_ps_id'] = encrypt_id($ps_id);
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$data['base_structure_position'] = $this->M_hr_structure_position->get_all_by_active('asc')->result();
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		// $data['filter_start_date'] = $start_date;
		// $data['filter_end_date'] = $end_date;
		$position_department_array = array();
		foreach ($data['person_department_topic'] as $row) {
			$array_tmp = $this->M_hr_person->get_person_position_by_ums_department_detail($data['ps_id'], $row->dp_id)->row();
			array_push($position_department_array, $array_tmp);
		}
		$data['ps_is_medical'] = "M";
		$data['actor_type'] = "medical";
		foreach ($position_department_array as $key => $value) {
			$stde_info = json_decode($value->stde_name_th_group, true);
			if ($value->hire_is_medical != "M") {
				$data['ps_is_medical'] = $value->hire_is_medical;
				$data['actor_type'] = "approver";
			}
			if ($stde_info) {
				foreach ($stde_info as $item) {
					$id = $item['stdp_po_id'];
					$name = $item['stde_name_th'];

					// ถ้ายังไม่มีการจัดกลุ่มสำหรับ stdp_po_id นี้
					if (!isset($grouped[$id])) {
						$grouped[$id] = [
							'stdp_po_id' => $id,
							'stde_name_th' => []
						];
					}

					// เพิ่มชื่อเข้าไปในกลุ่ม
					$grouped[$id]['stde_name_th'][] = $name;
				}
				// เปลี่ยนให้เป็น array ของ associative arrays
				$grouped = array_values($grouped);
				$value->stde_admin_position = $grouped;
			} else {
				$value->stde_admin_position = [];
			}
		}
		$data['person_department_detail'] = $position_department_array;

		$this->output($this->view . 'v_timework_calendar_preview_person', $data);
	}
	// preview_timework_calendar_person

	/*
	* get_timework_plan_preview_report_by_ps_id
	* ข้อมูลรายการบุคลากรตาม filter
	* @input ps_id, isPublic
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/10/2024
	*/
	public function get_timework_plan_preview_report_by_ps_id()
	{
		$ps_id = decrypt_id($this->input->get('ps_id'));

		$list = $this->M_hr_timework_person_plan->get_all_timework_preview_report_list($ps_id, $this->input->get('public'), $this->input->get('dp_id'), $this->input->get('start_date'), $this->input->get('end_date'));
		$timework_plan_list = array();
		if (!empty($list)) {
			foreach ($list as $i => $twpp) {
				$twpp->twpp_start_date_text = abbreDate2($twpp->twpp_display_date);
				// $twpp->twpp_end_date_text = abbreDate2($twpp->twpp_end_date);
				$twpp->twpp_start_time_text = substr($twpp->twpp_start_time, 0, 5);
				$twpp->twpp_end_time_text = substr($twpp->twpp_end_time, 0, 5);
				// if($row->hire_is_medical == "M"){
				// 	$twpp->actor_type = "medical";
				// } 
				// else {
				// 	$twpp->actor_type = "approver";
				// }
				$twpp->actor_type = "medical";
				$twpp->twpp_ps_id = $ps_id;
			}
			// pre( $list);
			$timework_plan_list = array_merge($timework_plan_list, $list);
		}

		echo json_encode($timework_plan_list);
	}
	// get_timework_plan_preview_report_by_ps_id

	/*
	* encrypt_stuc_id
	* encrypt รหัสโครงสร้างองค์กร
	* @input stde_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/11/2024
	*/
	function encrypt_stuc_id(){
		echo json_encode(encrypt_id($this->input->post('stuc_id')));
	}
	// encrypt_stuc_id


	/*
	* export_pdf_timework_calendar_by_structure
	* ส่งออก pdf ตารางการทำงานตามแผนก
	* @input $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/11/2024
	*/
	function export_pdf_timework_calendar_by_structure($stuc_id, $isPublic, $actor_type, $dp_id, $filter_start_date, $filter_end_date){
		$this->load->model($this->config->item('ums_dir') . 'M_ums_department');

		$stuc_id = decrypt_id($stuc_id);

		$rs_stuc = $this->M_hr_timework_person_plan->get_structure_detail_by_group_person($stuc_id);
		$this->M_ums_department->dp_id = $dp_id;
		$this->M_ums_department->get_by_key(true);
		$arr = array(); // อาร์เรย์สำหรับเก็บผลลัพธ์ที่จัดรูปแบบ
		$index = 0;

		foreach ($rs_stuc->result() as $i => $stde) {
			// ดึงข้อมูล "format_time" ตาม stde_id
			$stde->format_time = $this->M_hr_timework_person_plan->get_all_timework_param_data_by_stde_id(
				$stde->stde_id,
				$isPublic,
				$actor_type,
				$dp_id,
				$filter_start_date,
				$filter_end_date,
				"format"
			);

			// ตรวจสอบว่ามีข้อมูลใน format_time หรือไม่
			if ($stde->format_time->num_rows() > 0) {
				$arr[$index]['stde_id'] = $stde->stde_id; // ใส่ stde_id
				$arr[$index]['stde_name_th'] = $stde->stde_name_th; // ใส่ชื่อแผนก

				foreach ($stde->format_time->result() as $j => $format) {
					// ดึงข้อมูล format_time
					$arr[$index]["format_time"][$j]['twac_id'] = $format->twac_id;
					$arr[$index]["format_time"][$j]['twac_name_th'] = $format->twac_name_th;
					$arr[$index]["format_time"][$j]['twac_name_abbr_th'] = $format->twac_name_abbr_th;
					$arr[$index]["format_time"][$j]['twac_start_time'] = $format->twac_start_time;
					$arr[$index]["format_time"][$j]['twac_end_time'] = $format->twac_end_time;

					// ดึงข้อมูลวันที่ (twac_date) ตาม twac_id
					$twac_dates = $this->M_hr_timework_person_plan->get_all_timework_date_by_twac_id(
						$format->twac_id,
						$isPublic,
						$actor_type,
						$dp_id,
						$filter_start_date,
						$filter_end_date,
						"format"
					);

					// ตรวจสอบว่ามีข้อมูลใน twac_date หรือไม่
					$arr[$index]["format_time"][$j]['twac_date'] = array();
					foreach ($twac_dates as $k => $twac_date) {
						$arr[$index]["format_time"][$j]['twac_date'][$k] = array(
							'pf_name_abbr' => $twac_date->pf_name_abbr,
							'ps_fname' => $twac_date->ps_fname,
							'ps_lname' => $twac_date->ps_lname,
							'twpp_ps_id' => $twac_date->twpp_ps_id,
							'twpp_start_date' => $twac_date->twpp_start_date,
							'twpp_end_date' => $twac_date->twpp_end_date,
							'twpp_start_time' => $twac_date->twpp_start_time,
							'twpp_end_time' => $twac_date->twpp_end_time,
							'rm_name' => $twac_date->rm_name,
							'twpp_desc' => $twac_date->twpp_desc,
							'twpp_display_date' => $twac_date->twpp_display_date
						);
					}
				}
				$index++;
			}
		}

		// จัดเก็บผลลัพธ์ในตัวแปร $data เพื่อใช้ในมุมมอง
		$data['rs_stuc'] = $arr;

		// pre($data['rs_stuc']);
		// $this->load->view($this->view . 'v_pdf_timework_calendar_by_structure', $data);

		// ดึง HTML จาก view
		$html = $this->load->view($this->view . 'v_pdf_timework_calendar_by_structure', $data, true);

		// โหลดไลบรารี mPDF
		require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

		// สร้างอินสแตนซ์ของ mPDF พร้อมตั้งค่ากระดาษเป็นแนวนอน (landscape)
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4', // กำหนดรูปแบบกระดาษเป็น A4 และแนวนอน
			'default_font_size' => 12,
			'default_font' => 'sarabun', // ฟอนต์ Sarabun รองรับภาษาไทย
			'margin_top' => 30,    // ปรับขอบบน (เพิ่มพื้นที่ให้ Header)
			'margin_bottom' => 15, // ปรับขอบล่าง (เพิ่มพื้นที่ให้ Footer)
			'margin_left' => 5,   // ปรับขอบซ้าย
			'margin_right' => 5,  // ปรับขอบขวา
		]);

		// ตั้งค่าให้ใช้ฟอนต์ Sarabun ที่ถูกต้อง
		$mpdf->fontdata['sarabun'] = [
			'R' => "THSarabunNew.ttf",         // ฟอนต์ปกติ
			'B' => "THSarabunNew-Bold.ttf",    // ฟอนต์หนา
			'I' => "THSarabunNew-Italic.ttf",  // ฟอนต์เอียง
		];

		// กำหนด Header ให้แสดงโลโก้ในทุกหน้า
		$mpdf->SetHTMLHeader('
			<div style="text-align: center;">
				<img src="' . base_url("assets/" . $this->config->item("site_logo")) . '" alt="Logo" width="120">
			</div>
		');

		// กำหนด Footer ให้แสดงวันที่อัปเดตข้อมูลและหน่วยงาน
		$mpdf->SetHTMLFooter('
			<div style="width: 100%; font-size: 10pt; color: #555;">
				<div style="float: left; text-align: left; width: 50%;">
					' . htmlspecialchars($this->M_ums_department->dp_name_th) . '
				</div>
				<div style="float: right; text-align: right; width: 50%;">
					ข้อมูลอัปเดตเมื่อวันที่: ' . abbreDate2(date("Y/m/d")) . '
				</div>
			</div>
		');


		// ส่ง HTML ที่โหลดจาก view เข้าไปใน mPDF
		$mpdf->WriteHTML($html);

		// ส่งออกเป็นไฟล์ PDF
		$mpdf->Output("ตารางการทำงาน" . '.pdf', 'I'); // 'I' = แสดงผลในเบราว์เซอร์
		exit;

	}
	// export_pdf_timework_calendar_by_structure


}
