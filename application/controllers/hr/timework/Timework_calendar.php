<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_calendar extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Timework_calendar/";
		$this->view .= "schedule_plan/";
		$this->load->model($this->model . 'M_hr_person');
		$this->load->model($this->model . 'M_hr_person_position');
		$this->mn_active_url = uri_string();
	}

	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		// $data['base_adline_position_list'] = $this->M_hr_person->get_hr_base_adline_position_data()->result();
		$data['base_hire_list'] = $this->M_hr_person->get_hr_base_hire_data()->result();
		$data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$hire_is_medical = '';
		$count = count($this->session->userdata('hr_hire_is_medical'));
		if ($count < 6) {
			$hire_is_medical = 'ของ';
			foreach ($this->session->userdata('hr_hire_is_medical') as $key => $value) {
				if ($key == $count - 1 && $count > 1) {
					$hire_is_medical .= ' และ';
				} else {
					if ($key != 0) {
						$hire_is_medical .= ' ';
					}
				}
				if ($value['type'] == 'M') {
					$hire_is_medical .= 'สายการแพทย์';
				}
				if ($value['type'] == 'N') {
					$hire_is_medical .= 'สายการพยาบาล';
				}
				if ($value['type'] == 'SM') {
					$hire_is_medical .= 'สายสนับสนุนทางการแพทย์';
				}
				if ($value['type'] == 'A') {
					$hire_is_medical .= 'สายบริหาร';
				}
				if ($value['type'] == 'T') {
					$hire_is_medical .= 'สายเทคนิคและบริการ';
				}
				if ($value['type'] == 'S') {
					$hire_is_medical .= 'สายสนับสนุน';
				}
			}
		}
		$data['hire_is_medical'] = $hire_is_medical;
		$this->output($this->view.'v_timework_person_calendar', $data);
	}

	/*
	* get_profile_user_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function get_profile_user_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$dp_id = $this->input->get('dp_id');
		$hire_id = $this->input->get('hire_id');
		$admin_id = $this->input->get('admin_id');
		$status_id = $this->input->get('status_id');

		$result = $this->M_hr_person->get_all_profile_data($dp_id, $admin_id, $hire_id, $status_id)->result();
		foreach ($result as $key => $row) {
			$array = array();
			$row->ps_id = encrypt_id($row->ps_id);
			$admin_name = json_decode($row->admin_position, true);
			if ($admin_name) {
				foreach ($admin_name as $value) {
					if ($value['admin_name']) {
						$array[] = $value['admin_name'];
					}
				}
				$row->admin_position = $array;
			} else {
				empty($row->admin_position);
			}

			// $tasks = $this->M_hr_person->get_tasks_by_person_id($row->ps_id);

			// If no tasks found, you can create an empty array
			// $row->tasks = $tasks ? $tasks : [];

			// Optionally, generate tasks data randomly for testing purposes:
			if (empty($row->tasks)) {
				$row->tasks = $this->generate_random_tasks_for_month(); // Function to generate random tasks
			}
		}

		echo json_encode($result);
	}
	// get_profile_user_list

	private function generate_random_tasks_for_month()
{
	$tasks = [];
	$days_in_month = 31; // ปรับตามเดือนจริง
	$task_names = ['อบรม', 'กะเช้า', 'ป่วย', 'กะบ่าย', 'ประชุม', 'ตรวจสุขภาพ', 'ออกบูธ'];
	$colors = [
		'#B2DFDB', // สีเขียวมิ้นท์อ่อน (Mint Green) - ให้ความรู้สึกสะอาดและผ่อนคลาย
		'#AED581', // สีเขียวใบไม้ (Leaf Green) - ให้ความรู้สึกสดชื่นและเจริญเติบโต
		'#FFF176', // สีเหลืองอ่อน (Light Yellow) - แสดงถึงความอบอุ่นและความเป็นมิตร
		'#81D4FA', // สีฟ้าอ่อน (Light Blue) - ให้ความรู้สึกสงบและมั่นคง
		'#4FC3F7', // สีฟ้าสด (Sky Blue) - ให้ความรู้สึกสดชื่นและบริสุทธิ์
		'#9575CD', // สีม่วงอ่อน (Lavender) - ให้ความรู้สึกสงบและปลอดภัย
		'#FF8A65', // สีส้มอ่อน (Soft Orange) - แสดงถึงความอบอุ่นและความเอื้ออาทร
	];
	
	for ($i = 1; $i <= $days_in_month; $i++) {
		$num_tasks = rand(1, 3); // สุ่มจำนวน Task ในแต่ละวัน (1 ถึง 3 Task)

		for ($j = 0; $j < $num_tasks; $j++) {
			$task_index = array_rand($task_names); // สุ่ม Task โดยไม่สนว่าซ้ำหรือไม่
			$start_hour = rand(8, 15); // สุ่มเวลาเริ่ม
			$end_hour = $start_hour + rand(1, 3); // สุ่มเวลาสิ้นสุดโดยต้องมากกว่าเวลาเริ่ม

			// กำหนด start_date เป็นวันที่ปัจจุบัน
			$start_date = '2024-08-' . str_pad($i, 2, '0', STR_PAD_LEFT);
			
			// สุ่มกำหนด end_date โดยกำหนดให้ end_date สามารถครอบคลุมหลายวัน (1-3 วัน)
			$end_offset = rand(0, 2); // สุ่มให้ task สามารถสิ้นสุดได้ในช่วง 0 ถึง 2 วันข้างหน้า
			$end_day = min($i + $end_offset, $days_in_month); // ป้องกันไม่ให้เกินจำนวนวันในเดือน

			$end_date = '2024-08-' . str_pad($end_day, 2, '0', STR_PAD_LEFT);

			$tasks[] = [
				'start_date' => $start_date,
				'end_date' => $end_date,
				'name' => $task_names[$task_index],
				'time' => str_pad($start_hour, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad($end_hour, 2, '0', STR_PAD_LEFT) . ':00',
				'color' => $colors[$task_index]
			];
		}
	}

	return $tasks;
}

	

	/*
	* get_profile_user_list
	* ข้อมูลรายการบุคลากรตาม filter
	* @input admin_id, adline_id, status_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function get_profile_user_detail()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->M_hr_person->ps_id = decrypt_id($this->input->get('ps_id'));
		$result = $this->M_hr_person->get_profile_detail_data_by_id()->row();
	

		echo json_encode($result);
	}
	// get_profile_user_detail
	
}
