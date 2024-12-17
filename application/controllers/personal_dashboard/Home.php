<?php

use Mpdf\Tag\Div;

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require_once dirname(__FILE__) . "/Personal_dashboard_Controller.php";
class Home extends Personal_dashboard_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Home/";
		$this->load->model('ums/Genmod', 'genmod');
	}

	public function index()
	{
		$this->load->model($this->config->item('hr_dir') . 'base/m_hr_structure_position');
		$this->load->model($this->config->item('hr_dir') . 'm_hr_develop');
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_develop_type');
		if ($this->session->userdata('us_ps_id') != "") {
			$data['status_response'] = $this->config->item('status_response_show');;
			$data['ps_id'] = $this->session->userdata('us_ps_id');
			$data['profile_person'] = $this->get_profile_person($data['ps_id']);
			$data['devlop_list_person'] = $this->m_hr_develop->get_develop_list_by_ps_id($data['ps_id'])->result();
			$base_develop = $this->M_hr_develop_type->get_all('asc')->result();
			$dev_sum_hour = 0;
			foreach ($data['devlop_list_person'] as $key => $dev) {
				$dev_sum_hour += $dev->dev_hour;
				$filtered_develop = array_filter($base_develop, function ($develop) use ($dev) {
					return $develop->devb_id == $dev->dev_go_service_type;
				});
				// ดึงชื่อจากอาร์เรย์ที่กรองแล้ว
				$dev->dev_server_type_name = !empty($filtered_develop) ? array_values($filtered_develop)[0]->devb_name : '';
			}
			$data['dev_sum_hour'] = $dev_sum_hour;
			$data['view_dir'] = $this->view;
			$data['controller_dir'] = $this->controller;
			$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
			$currentYear = date("Y"); // Get the current year
			$adjustedYears = []; // Initialize an array to store adjusted years
			for ($i = 0; $i <= 4; $i++) {
				$adjustedYear = ($currentYear - $i) + 543;
				$adjustedYears[] = $adjustedYear; // Add the adjusted year to the array
			}
			$data['default_year_list'] = $adjustedYears;

			// pre($data['systems']); die;
			$data['user'] = $this->genmod->getOne(
				'see_hrdb',                                                     // ชื่อฐานข้อมูล
				'hr_person_position',                                           // ชื่อตาราง
				'hr.hire_is_medical',                                           // คอลัมน์ที่ต้องการเลือก
				array('hr_person_position.pos_ps_id' => $data['ps_id']),        // เงื่อนไขค้นหาข้อมูล
				'',                                                             // เรียงลำดับข้อมูล
				array('hr_base_hire as hr' => 'hr_person_position.pos_hire_id = hr.hire_id'),  // JOIN กับตาราง hr_base_hire
				'hr.hire_is_medical'                                            // 
			);
			$rol = 0;
			if ($data['user']->hire_is_medical) {
				if ($data['user']->hire_is_medical == "M") {
					$rol = 1;
				} else if ($data['user']->hire_is_medical == "N") {
					$rol = 2;
				} else if ($data['user']->hire_is_medical == "S") {
					$rol = 3;
				} else {
					$rol = 4;
				}
			}
			$data['rol'] = $rol;

			$current_datetime = date('Y-m-d H:i:s');
			$data['news_d'] = $this->genmod->getAll(
				'see_umsdb',
				'ums_news',
				'*',
				array(
					'news_active !=' => 2,
					'news_type' => 2,
					'news_bg_id LIKE' => "%$rol%",
					'news_start_date <= ' => $current_datetime,
					'news_stop_date >= ' => $current_datetime
				)
			);
			$data['news_n'] = $this->genmod->getAll(
				'see_umsdb',
				'ums_news',
				'*',
				array(
					'news_active !=' => 2,
					'news_type' => 1,
					'news_bg_id LIKE' => "%$rol%",
					'news_start_date <= ' => $current_datetime,
					'news_stop_date >= ' => $current_datetime
				)
			);


			$data['notification_person'] = $this->get_notification_system_person($data['ps_id']);

			$this->load->view($this->config->item('pd_dir') . 'v_home_header', $data);
			$this->load->view('template/javascript', true);
			$this->load->view($this->config->item('pd_dir') . 'v_home_body', $data);
			$this->load->view('template/footer', true);

			// $this->sidebar();
			// $this->header();

			// $this->topbar();
			// $this->main($data);

			// $this->footer();
			// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

			// $this->output($this->config->item('pd_dir').'v_home_show',$data);
		} else {
			redirect('gear', 'refresh');
		}
	}

	/*
     * get_notification_system_person
     * get ข้อมูลแจ้งเตือนทุกระบบ
     * @input ps_id from see_hrdb.hr_person.ps_id
     * $output ข้อมูลแจ้งเตือนต่าง ๆ ตามระบบ
     * @author Tanadon Tangjaimongkhon
     * @Create Date 11/07/2024
     */
	public function get_notification_system_person($ps_id)
	{
		$this->load->model('ums/m_ums_system');
		$this->load->model($this->config->item('que_dir') . 'M_que_appointment');
		$this->load->model($this->config->item('ams_dir') . 'M_ams_notification_result');
		$this->load->model($this->config->item('dim_dir') . 'M_dim_examination_result');

		// 20240830 Areerat แก้ วิธีดึงข้อมูลของแต่ละระบบ
		// [QUE] ดึงข้อมูล ผู้ป่วยที่ทะเบียน, อยู่จุดคัดกรอง, ตรวจสอบสิทธิ์การรักษา
		$search_que = array(
			// 'date' => $this->input->post('date'),
			// 'month' => $this->input->post('month'),
			// 'department' => $this->input->post('department'),
			// 'doctor' => $ps_id,
			// 'patientId' => $this->input->post('patientId'),
			// 'patientName' => $this->input->post('patientName'),
			// 'search' => $search,
			// 'update_date' => $this->input->post('update_date')
		);
		$data['que_system']['tab_1'] = $this->M_que_appointment->get_appointments_paginated(null, null, null, null, $search_que);
		$data['que_system']['tab_2'] = $this->M_que_appointment->get_appointments_paginated_triage(null, null, null, null, $search_que);
		$data['que_system']['tab_3'] = $this->M_que_appointment->get_appointments_paginated_health_right(null, null, null, null, $search_que);

		// [AMS] ขอคอมเม้นไว้ก่อน
		// $data['ams_system']['tab_1'] = $this->M_ams_notification_result->get_ams_notification_by_status($ps_id, '3')->result();
		// $data['ams_system']['tab_2'] = $this->M_ams_notification_result->get_ams_notification_by_status($ps_id, '5,10')->result();
		$data['ams_system']['tab_1'] = [];
		$data['ams_system']['tab_2'] = [];

		// [DIM] ดึงข้อมูล ผู้ป่วยที่รอตรวจเครื่องมือ // ไม่เจาะจงว่าผู้ป่วยของใคร เพราะเจ้าที่เครื่องมือมีสิทธิ์เข้าระบบนี้ แทบคนเดียว
		// $this->M_dim_examination_result->exr_ps_id = $ps_id;
		// $data['dim_system'] = $this->M_dim_examination_result->get_all_with_detail_by_filter('Y', [])->result();
		$examination_results = $this->M_dim_examination_result->get_all_with_detail_server(['W'], null, null, null, null, null);
		$data['dim_system'] = $examination_results['query']->result();

		$data['count_noti_system'] = 0;

		// get systems of user's permission
		$data['systems'] = $this->m_ums_system->get_sys_by_user_id($this->session->userdata('us_id'))->result_array();

		foreach ($data['systems'] as $key => $row) {
			// Set default notification count
			$data['systems'][$key]['st_count_noti'] = 0;
			$count = 0;

			// Handle specific case for QUE system
			if ($row['st_id'] == 2) {
				$count = count($data['dim_system']);	//DIM
			} else if ($row['st_id'] == 5) {
				$count = count($data['ams_system']['tab_1']) + count($data['ams_system']['tab_2']);	//AMS
			} else if ($row['st_id'] == 7) {
				$count = count($data['que_system']['tab_1']) + count($data['que_system']['tab_2']) + count($data['que_system']['tab_3']);	//QUE
			}
			$data['systems'][$key]['st_count_noti'] = $count;
			$data['count_noti_system'] += $count;
		}
		return $data;
	}
	// get_notification_system_person
	/*
     * get_calendar_person
     * get calendar by person
     * @input ps_id, start_date, end_date
     * $output ข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 20/06/2567
     */

	public function get_home_content_by_element_id()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data['targetId'])) {
			$targetId = $data['targetId'];
			if ($targetId == 'dashboard-calendar') {
				$this->load->view($this->config->item('pd_dir') . 'v_home_partial_calendar');
			} else if ($targetId == 'dashboard-profile') {
				$this->load->view($this->config->item('pd_dir') . 'v_home_partial_profile');
			} else if ($targetId == 'dashboard-dashboard') {
				$this->load->view($this->config->item('pd_dir') . 'v_home_partial_dashboard');
			} else if ($targetId == 'dashboard-new') {
				$this->load->view($this->config->item('pd_dir') . 'v_home_partial_news');
			}
		}
	}
	/*
     * get_calendar_person
     * get calendar by person
     * @input ps_id, start_date, end_date
     * $output ข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 20/06/2567
     */
	public function get_calendar_person()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$ps_id = $this->session->userdata('us_ps_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$result['data'] = $this->M_ums_calendar->get_calendar_person_date($start_date, $end_date, $ps_id)->result();
		foreach ($result['data'] as $key => $row) {
			$row->count_parent = $this->M_ums_calendar->get_count_parent_calendar_id($row->clnd_id)->row()->count_parent;
		}
		$result['category'] = $this->M_ums_calendar->get_group_calendar_type_person_date($start_date, $end_date)->result();

		echo json_encode($result);
	}
	// get_calendar_person

	/*
     * get_parent_ums_calendar_by_id
     * get parent ums calendar by id
     * @input clnd_id, isView
     * $output ข้อมูลปฏิทินของผู้เข้าร่วมกิจกรรม
     * @author Tanadon Tangjaimongkhon
     * @Create Date 20/06/2567
     */
	public function get_parent_ums_calendar_by_id()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$clnd_id = $this->input->get('clnd_id');
		$isView = $this->input->get('isView');
		$ps_id = $this->session->userdata('us_ps_id');
		$result['data'] = $this->M_ums_calendar->get_person_all_by_ums_calendar_id($clnd_id, $ps_id, $isView)->result();
		echo json_encode($result);
	}
	// get_parent_ums_calendar_by_id

	/*
     * insert_calendar_person
     * insert calendar by person
     * @input ps_id, start_date, end_date
     * $output บันทึกข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 20/06/2567
     */
	public function insert_calendar_person()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$ps_id = $this->session->userdata('us_ps_id');
		$clnd_topic = $this->input->post('clnd_topic');
		$clnd_detail = $this->input->post('clnd_detail');
		$start_date = $this->input->post('clnd_start_date');
		$end_date = $this->input->post('clnd_end_date');
		$start_time = $this->input->post('clnd_start_time');
		$end_time = $this->input->post('clnd_end_time');
		$check_all_day = $this->input->post('check_all_day');
		$category = $this->input->post('category');
		$isShare = $this->input->post('isShare');
		$person_list = $this->input->post('person_list');

		$this->M_ums_calendar->clnd_ps_id = $ps_id;
		$this->M_ums_calendar->clnd_topic = $clnd_topic;
		$this->M_ums_calendar->clnd_detail = $clnd_detail;
		$this->M_ums_calendar->clnd_clt_id = 1;
		$this->M_ums_calendar->clnd_start_date = splitDateForm1($start_date);
		$this->M_ums_calendar->clnd_end_date = splitDateForm1($end_date);
		$this->M_ums_calendar->clnd_start_time = $start_time;
		$this->M_ums_calendar->clnd_end_time = $end_time;
		$this->M_ums_calendar->clnd_parent_id = null;
		$this->M_ums_calendar->clnd_create_user = $this->session->userdata('us_id'); //รหัสผู้สร้าง (USID)
		$this->M_ums_calendar->clnd_create_date = get_datetime_db(); //วันที่สร้าง

		$this->M_ums_calendar->insert();
		$clnd_id = $this->M_ums_calendar->last_insert_id;

		if ($isShare == "Y") {
			// Sort person_list by keys
			ksort($person_list);
			foreach ($person_list as $key => $person) {
				$this->M_ums_calendar->clnd_ps_id = $person['id'];
				$this->M_ums_calendar->clnd_parent_id = $clnd_id;
				$this->M_ums_calendar->insert();
			}
		}

		$data['clnd_id'] = $clnd_id;
		$data['clnd_ps_id'] = $ps_id;
		$data['clnd_topic'] = $clnd_topic;
		$data['clnd_detail'] = $clnd_detail;
		$data['clnd_start_date'] = $start_date;
		$data['clnd_end_date'] = $end_date;
		$data['clnd_start_time'] = $start_time;
		$data['clnd_end_time'] = $end_time;
		$data['check_all_day'] = $check_all_day;
		$data['category'] = $category;
		$data['clnd_parent_id'] = null;
		$data['count_parent'] = $this->M_ums_calendar->get_count_parent_calendar_id($clnd_id)->row()->count_parent;

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	// insert_calendar_person

	/*
     * update_calendar_person
     * update calendar by person
     * @input clnd_id, ps_id, start_date, end_date
     * $output แก้ไขข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 21/06/2567
     */
	public function update_calendar_person()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$ps_id = $this->session->userdata('us_ps_id');
		$clnd_id = $this->input->post('clnd_id');
		$clnd_topic = $this->input->post('clnd_topic');
		$clnd_detail = $this->input->post('clnd_detail');
		$start_date = $this->input->post('clnd_start_date');
		$end_date = $this->input->post('clnd_end_date');
		$start_time = $this->input->post('clnd_start_time');
		$end_time = $this->input->post('clnd_end_time');
		$check_all_day = $this->input->post('check_all_day');
		$category = $this->input->post('category');
		$isShare = $this->input->post('isShare');
		$person_list = $this->input->post('person_list');

		// pre($this->input->post()); die;

		$this->M_ums_calendar->clnd_id = $clnd_id;
		$this->M_ums_calendar->get_by_key(true);
		$this->M_ums_calendar->clnd_ps_id = $ps_id;
		$this->M_ums_calendar->clnd_topic = $clnd_topic;
		$this->M_ums_calendar->clnd_detail = $clnd_detail;
		$this->M_ums_calendar->clnd_clt_id = 1;
		$this->M_ums_calendar->clnd_start_date = splitDateForm1($start_date);
		$this->M_ums_calendar->clnd_end_date = splitDateForm1($end_date);
		$this->M_ums_calendar->clnd_start_time = $start_time;
		$this->M_ums_calendar->clnd_end_time = $end_time;
		$this->M_ums_calendar->clnd_update_user = $this->session->userdata('us_id'); //รหัสผู้แก้ไข (USID)
		$this->M_ums_calendar->clnd_update_date = get_datetime_db(); //วันที่แก้ไข

		$this->M_ums_calendar->update();

		// delete parent
		$this->M_ums_calendar->clnd_parent_id = $clnd_id;
		$this->M_ums_calendar->delete_by_parent();

		if ($isShare == "Y") {
			foreach ($person_list as $key => $person) {
				$this->M_ums_calendar->clnd_ps_id = $person['id'];
				$this->M_ums_calendar->clnd_parent_id = $clnd_id;
				$this->M_ums_calendar->clnd_create_user = $this->session->userdata('us_id'); //รหัสผู้สร้าง (USID)
				$this->M_ums_calendar->clnd_create_date = get_datetime_db(); //วันที่สร้าง
				$this->M_ums_calendar->insert();
			}
		}
		$data['clnd_id'] = $clnd_id;
		$data['clnd_ps_id'] = $ps_id;
		$data['clnd_topic'] = $clnd_topic;
		$data['clnd_detail'] = $clnd_detail;
		$data['clnd_start_date'] = $start_date;
		$data['clnd_end_date'] = $end_date;
		$data['clnd_start_time'] = $start_time;
		$data['clnd_end_time'] = $end_time;
		$data['check_all_day'] = $check_all_day;
		$data['category'] = $category;
		$data['clnd_parent_id'] = null;
		$data['count_parent'] = $this->M_ums_calendar->get_count_parent_calendar_id($clnd_id)->row()->count_parent;
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	// update_calendar_person

	/*
     * delete_calendar_person
     * delete calendar by person
     * @input clnd_id, ps_id, start_date, end_date
     * $output ลบข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 21/06/2567
     */
	public function delete_calendar_person()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$clnd_id = $this->input->post('clnd_id');

		$this->M_ums_calendar->clnd_id = $clnd_id;
		$this->M_ums_calendar->delete();

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_delete_success_body');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_calendar_person

	/*
     * get_all_ums_department
     * get all ums department
     * @input
     * $output ข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 24/06/2567
     */
	public function get_all_ums_department()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$result = $this->M_ums_calendar->get_all_ums_department()->result();
		echo json_encode($result);
	}
	// get_all_ums_department

	/*
     * get_person_all_by_ums_department
     * get person all by ums department
     * @input dp_id
     * $output ข้อมูลปฏิทินของบุคลากร
     * @author Tanadon Tangjaimongkhon
     * @Create Date 24/06/2567
     */
	public function get_person_all_by_ums_department()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_calendar');
		$dp_id = $this->input->get('dp_id');
		$ps_id = $this->session->userdata('us_ps_id');
		$result = $this->M_ums_calendar->get_person_all_by_ums_department($dp_id, $ps_id)->result();
		echo json_encode($result);
	}
	// get_person_all_by_ums_department

	/*
     * get_weekly_ums_dashboard
     * get ums log 7 days before
     * @input ps_id
     * $output ประวัติการเข้าใช้งานระบบ (UMS LOG) 7 วันย้อนหลัง
     * @author Tanadon Tangjaimongkhon
     * @Create Date 17/06/2567
     */
	public function get_weekly_ums_dashboard()
	{
		$this->load->model($this->config->item('ums_dir') . 'M_ums_user_logs_menu');
		$isAction = $this->input->post('isAction');
		$type = $this->input->post('type');
		$system_log_id = $this->input->post('system_log_id');
		if ($type == 'monthly') {
			$month = $this->input->post('month');
			$year = $this->input->post('year');
		} else {
			$month = date('m');
			$year = date('Y');
		}

		if ($isAction == 'detail') {
			// for dashboard
			if ($system_log_id == "") {
				$result['log_ums_type_db'] = $this->M_ums_user_logs_menu->get_ums_log_card($this->session->userdata('us_id'))->result();
				$result['log_ums_type_card'] = $this->M_ums_user_logs_menu->get_ums_log_card_detail($this->session->userdata('us_id'), 0, $type, $month, $year)->result();
				foreach ($result['log_ums_type_card'] as $key => $row) {
					$row->log_date = abbreDate4(splitDateDb6($row->log_date));
				}
			} else { //for card
				$result['log_ums_type_card'] = $this->M_ums_user_logs_menu->get_ums_log_card_detail($this->session->userdata('us_id'), $system_log_id, $type, $month, $year)->result();
				foreach ($result['log_ums_type_card'] as $key => $row) {
					$row->log_date = abbreDate4(splitDateDb6($row->log_date));
				}
			}
		} else {
			$result['weekly_log_ums_card'] = $this->M_ums_user_logs_menu->get_ums_log_card($this->session->userdata('us_id'))->result();
			$result['weekly_log_ums_dashboard'] = $this->M_ums_user_logs_menu->get_ums_log_dashboard($this->session->userdata('us_id'))->result();

			foreach ($result['weekly_log_ums_dashboard'] as $key => $row) {
				if (mb_strlen($row->ums_log_name, 'UTF-8') > 40) {
					$row->ums_log_name = mb_substr($row->ums_log_name, 0, 40, 'UTF-8') . "...";
				}
			}

			foreach ($result['weekly_log_ums_dashboard'] as $key => $row) {
				$row->log_date = abbreDate2($row->log_date);
			}
		}

		echo json_encode($result);
	}
	// get_weekly_ums_dashboard

	/*
     * get_monthly_que_dashboard
     * get สถิติการนัดหมายผู้ป่วย ประจำเดือน
     * @input ps_id
     * $output สถิติการนัดหมายผู้ป่วย ประจำเดือน
     * @author Tanadon Tangjaimongkhon
     * @Create Date 12/06/2567
     */
	public function get_monthly_que_dashboard()
	{
		$this->load->model($this->config->item('que_dir') . 'M_que_appointment');

		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$isAction = $this->input->post('isAction');
		$que_type = $this->input->post('que_type');

		if ($isAction == 'detail') {
			$result['que_table_list'] = $this->M_que_appointment->get_all_by_param($this->session->userdata('us_ps_id'), $month, $year, $que_type, $isAction)->result();

			foreach ($result['que_table_list'] as $key => $row) {
				$row->apm_date = fullDateTH3($row->apm_date) . " เวลา " . $row->apm_time . " น.";
				$row->apm_cause = ($row->apm_cause != "" ? $row->apm_cause : "");
				$row->apm_patient_type = ($row->apm_patient_type == "old" ? "ผู้ป่วยเก่า" : "ผู้ป่วยใหม่");
			}
			$result['que_week_table_list'] = array(
				0 => array("name" => "ผู้ป่วยเก่า"),
				1 => array("name" => "ผู้ป่วยใหม่"),
			);

			$que_day_week = array(
				'0' => array("name" => "วันอาทิตย์"),
				'1' => array("name" => "วันจันทร์"),
				'2' => array("name" => "วันอังคาร"),
				'3' => array("name" => "วันพุธ"),
				'4' => array("name" => "วันพฤหัสบดี"),
				'5' => array("name" => "วันศุกร์"),
				'6' => array("name" => "วันเสาร์"),
			);

			$que_day_count_new = $this->M_que_appointment->get_count_que_day_by_param($this->session->userdata('us_ps_id'), $month, $year, 'new', $isAction)->result();

			$que_day_count_old = $this->M_que_appointment->get_count_que_day_by_param($this->session->userdata('us_ps_id'), $month, $year, 'old', $isAction)->result();

			foreach ($que_day_count_old as $key => $row) {
				$row->apm_date = fullDateTH3($row->apm_date) . " เวลา " . $row->apm_time . " น.";
				$row->apm_cause = ($row->apm_cause != "" ? $row->apm_cause : "");
				$row->apm_patient_type = ($row->apm_patient_type == "old" ? "ผู้ป่วยเก่า" : "ผู้ป่วยใหม่");
			}

			foreach ($que_day_count_new as $key => $row) {
				$row->apm_date = fullDateTH3($row->apm_date) . " เวลา " . $row->apm_time . " น.";
				$row->apm_cause = ($row->apm_cause != "" ? $row->apm_cause : "");
				$row->apm_patient_type = ($row->apm_patient_type == "old" ? "ผู้ป่วยเก่า" : "ผู้ป่วยใหม่");
			}

			// สร้างตัวแปรเพื่อเก็บ index ของแต่ละวัน
			$dayIndexes = array();

			// วนลูปผ่านรายการนัดหมาย
			foreach ($que_day_count_new as $index => $new) {
				// ดึงวันที่ของนัดหมาย
				$date = $new->day_name;

				// เก็บ index ของวันนั้นๆ
				if (!isset($dayIndexes[$date])) {
					$dayIndexes[$date] = array();
				}
				$dayIndexes[$date][] = $new;
			}
			$que_day_count_new = $dayIndexes;

			// สร้างตัวแปรเพื่อเก็บ index ของแต่ละวัน
			$dayIndexes = array();

			// วนลูปผ่านรายการนัดหมาย
			foreach ($que_day_count_old as $index => $old) {
				// ดึงวันที่ของนัดหมาย
				$date = $old->day_name;

				// เก็บ index ของวันนั้นๆ
				if (!isset($dayIndexes[$date])) {
					$dayIndexes[$date] = array();
				}
				$dayIndexes[$date][] = $old;
			}
			$que_day_count_old = $dayIndexes;

			$result['que_week_table_list'][0]['week_detail'] = $que_day_count_old;
			$result['que_week_table_list'][1]['week_detail'] = $que_day_count_new;
		}

		if ($isAction == 'filter') {
			$result['que_count_all'] = $this->M_que_appointment->get_all_by_param($this->session->userdata('us_ps_id'), $month, $year, '', $isAction)->row()->count_que;
			$result['que_count_new'] = $this->M_que_appointment->get_all_by_param($this->session->userdata('us_ps_id'), $month, $year, 'new', $isAction)->row()->count_que;
			$result['que_count_old'] = $this->M_que_appointment->get_all_by_param($this->session->userdata('us_ps_id'), $month, $year, 'old', $isAction)->row()->count_que;

			if ($result['que_count_all'] > 0) {
				$result['new_percentage'] = ($result['que_count_new'] * 100) / $result['que_count_all'];
				$result['old_percentage'] = ($result['que_count_old'] * 100) / $result['que_count_all'];

				$result['new_percentage'] = number_format($result['new_percentage'], 2);
				$result['old_percentage'] = number_format($result['old_percentage'], 2);
			} else {
				$result['new_percentage'] = number_format(0, 2);
				$result['old_percentage'] = number_format(0, 2);
			}

			$result['que_day_count_new'] = $this->M_que_appointment->get_count_que_day_by_param($this->session->userdata('us_ps_id'), $month, $year, 'new', $isAction)->result();
			$result['que_day_count_old'] = $this->M_que_appointment->get_count_que_day_by_param($this->session->userdata('us_ps_id'), $month, $year, 'old', $isAction)->result();
		}

		$result['month_text'] = getNowMonthTh($month);

		echo json_encode($result);
	}
	// get_monthly_que_dashboard

	/*
     * get_profile_person
     * get ข้อมูลของบุคลากร
     * @input ps_id from see_hrdb.hr_person.ps_id
     * $output ข้อมูลของบุคลากร เช่น ข้อมูลทั่วไป, ข้อมูลการปฏิบัติงาน
     * @author Tanadon Tangjaimongkhon
     * @Create Date 31/05/2024
     */
	public function get_profile_person($ps_id)
	{
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_detail');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_education');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_license');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_work_history');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_expert');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_external_service');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_reward');

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person_detail->psd_ps_id = $ps_id;
		$this->M_hr_person_position->pos_ps_id = $ps_id;
		$this->M_hr_person_education->edu_ps_id = $ps_id;
		$this->M_hr_person_license->licn_ps_id = $ps_id;
		$this->M_hr_person_work_history->wohr_ps_id = $ps_id;
		$this->M_hr_person_expert->expt_ps_id = $ps_id;
		$this->M_hr_person_reward->rewd_ps_id = $ps_id;

		// person detail
		$data['person_detail'] = $this->M_hr_person->get_personal_dashboard_profile_detail_data_by_id()->row();

		// person position by department
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$position_department_array = array();
		foreach ($data['person_department_topic'] as $row) {
			$array_tmp = $this->M_hr_person->get_person_position_by_ums_department_detail($ps_id, $row->dp_id)->row();
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
		// person education
		$data['person_education_list'] = $this->M_hr_person_education->get_all_person_education_data($ps_id)->result();
		foreach ($data['person_education_list'] as $key => $row) {
			$row->edu_start_date = ($row->edu_start_date == "0000-00-00" ? ($row->edu_start_year) : abbreDate2($row->edu_start_date));
			$row->edu_end_date = ($row->edu_end_date == "0000-00-00" ? ($row->edu_end_year) : abbreDate2($row->edu_end_date));
		}

		// person license
		$data['person_license_list'] = $this->M_hr_person_license->get_person_license_data($ps_id)->result();
		// foreach ($data['person_license_list'] as $key => $row) {
		// 	$row->licn_start_date = abbreDate2($row->licn_start_date);
		// 	$row->licn_end_date = ($row->licn_end_date == "9999-12-31" ? "ตลอดชีพ" : abbreDate2($row->licn_end_date));
		// }

		// person work history
		$data['person_work_history_list'] = $this->M_hr_person_work_history->get_all_person_work_history_data($ps_id)->result();
		foreach ($data['person_work_history_list'] as $key => $row) {
			$row->wohr_start_date = $this->format_date($row->wohr_start_date);
			if ($row->wohr_end_date == "9999-12-31") {
				$row->wohr_end_date = "ปัจจุบัน";
			} else {
				$row->wohr_end_date = $this->format_date($row->wohr_end_date);
			}
		}

		// person expert
		$data['person_expert_list'] = $this->M_hr_person_expert->get_all_person_expert_data($ps_id)->result();
		foreach ($data['person_expert_list'] as $key => $row) {
			$row->expt_id = encrypt_id($row->expt_id);
		}

		// person external service
		$data['person_external_service_list'] = $this->M_hr_person_external_service->get_all_external_service_data($ps_id)->result();
		foreach ($data['person_external_service_list'] as $key => $row) {
			$row->pexs_id = encrypt_id($row->pexs_id);
			
			if($row->pexs_date != "0000-00-00"){
				$row->pexs_date = abbreDate2($row->pexs_date);
			}
			else{
				$row->pexs_date = "ไม่ระบุ";
			}
		}

		// person reward
		$data['person_reward_list'] = $this->M_hr_person_reward->get_all_person_reward_data($ps_id)->result();
		$data['person_reward_list'] = $this->M_hr_person_reward->get_year_reward($ps_id)->result();

		foreach ($data['person_reward_list'] as $key => $row) {
			$row->reward_detail = $this->M_hr_person_reward->get_reward_by_year($ps_id, $row->rewd_year);
			$row->rewd_year = ($row->rewd_year != 0 ? $row->rewd_year : "ไม่ระบุ");
			if ($row->reward_detail->num_rows() > 0) {
				foreach ($row->reward_detail->result() as $rewd) {
					$rewd->rewd_date = ($rewd->rewd_date == "0000-00-00" ? date('d/m/Y', strtotime($rewd->rewd_end_date . ' +543 years')) : date('d/m/Y', strtotime($rewd->rewd_date . ' +543 years')));
				}
			}
			$row->reward_detail = $row->reward_detail->result();
		}

		return $data;
	}
	// get_profile_person

	/*
     * format_date
     * return format date by condition
     * @input $date
     * $output format date by condition
     * @author Tanadon Tangjaimongkhon
     * @Create Date 06/08/2024
     */
	function format_date($date)
	{

		$thaiMonthsAbbr = array(
			'ม.ค.',
			'ก.พ.',
			'มี.ค.',
			'เม.ย.',
			'พ.ค.',
			'มิ.ย.',
			'ก.ค.',
			'ส.ค.',
			'ก.ย.',
			'ต.ค.',
			'พ.ย.',
			'ธ.ค.'
		);
		// Regular expression to match the date pattern
		$pattern = '/(\d{4})-(\d{2})-(\d{2})/';

		// Match the pattern and extract year, month, and day
		if (preg_match($pattern, $date, $matches)) {
			$year = $matches[1];
			$monthIndex = (int)$matches[2] - 1; // Adjust for zero-based array
			$day = $matches[3];

			// If the day is "00", format as "Month Year" in Thai
			if ($day === "00") {
				return $thaiMonthsAbbr[$monthIndex] . " " . ($year + 543);
			} else {
				// Otherwise, use the abbreDate2 function for the full date
				return abbreDate2($date);
			}
		}

		// Return an error message if the date format is invalid
		return "Invalid date";
	}
	// format_date

	public function generate_CV()
	{
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->autoLangToFont = true;
		$mpdf->autoScriptToLang = true;
		// $htmlContent = $this->load->view($this->config->item('pd_dir').'test', '', TRUE);
		$file_path = __DIR__ . '/v_resume.php';
		// Check if the file exists
		$content = '<h1> Hello World </>';
		if (file_exists($file_path)) {
			$content = file_get_contents($file_path);
			$mpdf->WriteHTML($content);
			$mpdf->Output();
		} else {
			echo "File not found";
		}
	}
	public function getEditForm()
	{
		$id = $this->input->post();
		$data['news'] = $this->genmod->getOne('see_umsdb', 'ums_news', '*', array('news_active !=' => 2, 'news_id' => $id['id']));
		// var_dump($data['news']);
		$json['title'] = "รายละเอียดข่าวสาร (ประกาศเมื่อ วันที่ " . abbreDate4($data['news']->news_start_date) . ")";
		$json['body'] = $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_News_detail_show', $data, true);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function view_detail()
	{
		$id = $this->input->post();
		$data['news'] = $this->genmod->getOne('see_umsdb', 'ums_news', '*', array('news_active !=' => 2, 'news_id' => $id['id']));
		// var_dump($data['news']);

		$json['title'] = "รายละเอียดข่าวสาร (ประกาศเมื่อ วันที่ " . abbreDate4($data['news']->news_start_date) . ")";
		if ($id['ck'] == 1) {
			$json['footer'] = '<div class="d-flex justify-content-end">
			<button class="btn btn-info" onclick="view()">ย้อนกลับ</button>
			</div>';
		}
		$json['body'] = $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_News_detail_show', $data, true);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function getmodal()
	{
		$data['ps_id'] = $this->session->userdata('us_ps_id');
		$id = $this->input->post();
		$data['user'] = $this->genmod->getOne(
			'see_hrdb',                                                     // ชื่อฐานข้อมูล
			'hr_person_position',                                           // ชื่อตาราง
			'hr.hire_is_medical',                                           // คอลัมน์ที่ต้องการเลือก
			array('hr_person_position.pos_ps_id' => $data['ps_id']),        // เงื่อนไขค้นหาข้อมูล
			'',                                                             // เรียงลำดับข้อมูล
			array('hr_base_hire as hr' => 'hr_person_position.pos_hire_id = hr.hire_id'),  // JOIN กับตาราง hr_base_hire
			'hr.hire_is_medical'                                            // 
		);
		$rol = 0;
		if ($data['user']->hire_is_medical) {
			if ($data['user']->hire_is_medical == "M") {
				$rol = 1;
			} else if ($data['user']->hire_is_medical == "N") {
				$rol = 2;
			} else if ($data['user']->hire_is_medical == "S") {
				$rol = 3;
			} else {
				$rol = 4;
			}
		}
		$current_datetime = date('Y-m-d H:i:s');
		$data['news'] = $this->genmod->getAll(
			'see_umsdb',
			'ums_news',
			'*',
			array(
				'news_active !=' => 2,
				'news_type' => 2,
				// 'news_bg_id LIKE' => "%$rol%",
				'news_start_date <= ' => $current_datetime,
				'news_stop_date >= ' => $current_datetime
			)
		);

		// var_dump($data['news']);
		// $json['title'] = "ข่าวด่วน !!(ประกาศเมื่อ วันที่ " . abbreDate4($data['news']->news_start_date) . ")";
		date_default_timezone_set('Asia/Bangkok');
		$date = date('Y-m-d H:i:s');
		$json['status'] = 1;
		$formattedDateTime = date('Y/m/d H:i', strtotime($date));
		$formattedDateTime = abbreDate4($formattedDateTime);
		$json['title'] = "<h2 class=\"text-danger\">ข่าวด่วน !!</h2>ประจำวันที่ $formattedDateTime";
		$json['body'] = $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_News_detail_notify', $data, true);
		$json['footer'] = '
		<div class="d-flex justify-content-end">
				 <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">ปิด</button>
		</div>';
		if (empty($data['news'])) {
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function setuser()
	{
		$id = $this->input->post();
		$date_today = date('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ Y-m-d
		$data = $this->genmod->getOne('see_umsdb', 'ums_news_log', '*', array('news_log_date' => $date_today));
		$ps_id = $this->session->userdata('us_ps_id');
		if (isset($data->news_log_user)) {
			$data->news_log_user = $data->news_log_user . "," . $ps_id;
			$data->news_log_date = $date_today;
			$data = $this->genmod->update('see_umsdb', 'ums_news_log', $data, array('news_log_id' => 1));
		} else {
			$data = [];
			$data['news_log_user'] = $ps_id;
			$data['news_log_date'] = $date_today;
			$data = $this->genmod->update('see_umsdb', 'ums_news_log', $data, array('news_log_id' => 1));
		}
		$status = 1;
		echo json_encode($status);
	}
	public function get_develop_list_person_by_filter_year()
	{
		$this->load->model($this->config->item('hr_dir') . 'm_hr_develop');
		$year = $this->input->post('year');
		$year = (intval($year) - 543);
		$ps_id = $this->session->userdata('us_ps_id');
		$data['filter_data'] = $this->m_hr_develop->get_develop_person_by_year_filter($ps_id, $year)->result();
		$data['ft_sum_hour'] = 0;
		foreach ($data['filter_data'] as $key => $value) {
			$data['ft_sum_hour'] += $value->dev_hour;
		}
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function checkuser()
	{
		$id = $this->input->post();
		$date_today = date('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ Y-m-d
		$data = $this->genmod->getOne('see_umsdb', 'ums_news_log', '*', array('news_log_date' => $date_today));
		$ps_id = $this->session->userdata('us_ps_id');
		if (isset($data->news_log_user)) {
			$user = explode(",", $data->news_log_user);
			foreach ($user as $key => $value) {
				if ($value == $ps_id) {
					$status = 1;
					break;
				} else {
					$status = 0;
				}
			}
		} else {
			$status = 0;
		}
		echo json_encode($status);
	}
}
