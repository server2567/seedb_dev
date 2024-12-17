<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Tanadon Tangjaimongkhon
* @Create Date 2567-05-13
*/
include_once('Leaves_Controller.php');

class Control_leaves extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->view .= $this->config->item('leaves_dir');
		$this->model .= $this->config->item('leaves_dir');
		$this->controller .= $this->config->item('leaves_dir');

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/leaves/control_leaves";

		// [20241007 Patcharapol Sirimaneechot]
		// $this->controller .= "Profile_official/";
		// $this->load->model('hr/M_hr_leave_control');
		$this->load->model($this->model.'M_hr_leave_control');
	}

	/*
	* index
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;

		// [20241007 Patcharapol Sirimaneechot]
		$data['controller_dir'] = $this->controller;

		$data['leave_control'] = $this->M_hr_leave_control->get_all_leave_control();

		$data['leave'] = $this->M_hr_leave_control->get_all_leave();

		$this->output($this->view.'v_control_leave_list', $data);


	}

	// function get_leave_control_by_condition($hire_is_medical_id, $leave_id) {
	function get_leave_control_by_condition() {
		$hire_is_medical_id = $this->input->post('select_hire_is_medical');
		$leave_id = $this->input->post('select_leave');
		$hire_type = $this->input->post('select_hire_type');

		$data['hire_is_medical_id'] = $hire_is_medical_id;
		$data['leave_id'] = $leave_id;
		
		$result = $this->M_hr_leave_control->get_leave_control_by_condition($hire_is_medical_id, $leave_id, $hire_type);

		foreach($result as $key=>$row){
			$result[$key]['ctrl_id'] = encrypt_id($row['ctrl_id']);
		}
		
		$data['result'] = $result;
		echo json_encode($data);
	}

	/*
	* leaves_type
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	// function leaves_type()
	// {
	// 	$data['session_mn_active_id'] = 300043; // set session_mn_active_id / breadcrumb
	// 	$data['status_response'] = $this->config->item('status_response_show');;
	// 	$data['view'] = $this->view;
	// 	$data['controller'] = $this->controller;
	// 	// $this->load->model($this->model . 'm_leave', 'l');
	// 	// $l = $this->l;
	// 	// $personId = ($this->input->post('personId')) ? $this->input->post('personId') : $this->session->userdata('UsPsCode'); // ทำลาแทน post personId
	// 	// $this->data['personId'] = $personId;
	// 	// $this->data['admin'] = ($this->input->post('admin')) ? $this->input->post('admin') : '';
	// 	// /// หาปีงบประมาณปัจจุบัน
	// 	// $l->lsum_ps_id = $personId;
	// 	// $l->lsum_budget_year = (getCurBudgetYear() - 543);
	// 	// /// END ปีงบประมาณ
	// 	// $this->data['rs_l'] = $l->get_by_person_ids();
	// 	$this->output($this->view.'v_leaves_type_list', $data);
	// }//end leaves_type

	/*
	* leaves_input
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	// function control_leave_edit($leave_type_id)
	// {
	// 	$data['session_mn_active_id'] = 300045; // set session_mn_active_id / breadcrumb
	// 	$data['status_response'] = $this->config->item('status_response_show');;
	// 	$data['view'] = $this->view;
	// 	$data['controller'] = $this->controller;
	// 	$data['action'] = "แก้ไขข้อมูลควบคุมวันลา";
	// 	$data['leave_type'] = $this->M_hr_leave_control->get_all_leave_type();

	// 	$this->output($this->view.'v_control_leave_form', $data);
	// }//end leaves_input

	/*
	* control_leave_delete
	* ลบข้อมูลควบคุมวันลา
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function control_leave_delete($id)
	{
		$data['session_mn_active_id'] = 300045; // set session_mn_active_id / breadcrumb
		$id = decrypt_id($id);
		$result = $this->M_hr_leave_control->delete_leave_control($id);
		
		if ($result) {
			echo true;
		} else {
			echo false;
		}
	}//end control_leave_add

	// function control_leave_delete($id)
	// {
	// 	$data['session_mn_active_id'] = 300045; // set session_mn_active_id / breadcrumb
		
	// 	$result = $this->M_hr_leave_control->delete_leave_control($id);
		
	// 	if ($result) {
	// 		redirect(site_url() . "/" . $this->controller . "control_leaves");
	// 	} else {
	// 		die('Delete Error');
	// 	}
	// }//end control_leave_add

	/*
	* control_leave_add
	* หน้าจอเพิ่มข้อมูลควบคุมวันลา
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function control_leave_add()
	{
		$data['session_mn_active_id'] = 300045; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$data['controller_dir'] = $this->controller;
		$data['action'] = "เพิ่มข้อมูลควบคุมวันลา";
		$data['action_code'] = "add";
		$data['leave'] = $this->M_hr_leave_control->get_all_leave();
		// $data['hire_is_medical'] = $this->M_hr_leave_control->get_all_hire_is_medical();

		// $this->output($this->view.'v_control_leave_form', $data);
		$this->output($this->view.'v_control_leave_form_common', $data);
	}//end control_leave_add


	/*
	* get_data_for_edit_page
	* รับข้อมูลพื้นฐานที่ใช้สำหรับหน้าแก้ไขข้อมูลสิทธิ์ลารายบุคคลของบุคลากรเป้าหมาย
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-25
	*/
	function get_data_for_edit_page() {
		$budget_year = $this->input->post('budget_year');
		$user_id = $this->input->post('user_id');

		$start_date_cal = $this->input->post('start_date_cal');
		$end_date_cal = $this->input->post('end_date_cal');

		// // die("$budget_year, $user_id");

		$data['target_user_leave_summary'] = $this->M_hr_leave_summary->get_target_user_leave_summary($budget_year, $user_id);

		$data['base_info'] = $this->M_hr_leave_summary->get_base_info_for_cal_work_age($budget_year, $user_id);
	
		// $data['budget_year'] = $budget_year;
		// $data['user_id'] = $user_id;

		// return json_encode($data);

		// echo "HI";
		echo json_encode($data);
	}


	/*
	* control_leave_update
	* หน้าจอแก้ไขข้อมูลควบคุมวันลา
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function control_leave_update($id)
	{
		$data['session_mn_active_id'] = 300045; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$data['controller_dir'] = $this->controller;
		$data['action'] = "แก้ไขข้อมูลควบคุมวันลา";
		$data['action_code'] = "update";
		$data['leave'] = $this->M_hr_leave_control->get_all_leave();
		$data['leave_control'] = $this->M_hr_leave_control->get_leave_control(decrypt_id($id));
		// $data['hire_is_medical'] = $this->M_hr_leave_control->get_all_hire_is_medical();

		//substring ctrl_start_age
		$data['leave_control'][0]['ctrl_start_age_y'] = substr($data['leave_control'][0]['ctrl_start_age'], 0, 2);
		$data['leave_control'][0]['ctrl_start_age_m'] = substr($data['leave_control'][0]['ctrl_start_age'], 3, 2);
		$data['leave_control'][0]['ctrl_start_age_d'] = substr($data['leave_control'][0]['ctrl_start_age'], 6, 2);

		//substring ctrl_end_age
		$data['leave_control'][0]['ctrl_end_age_y'] = substr($data['leave_control'][0]['ctrl_end_age'], 0, 2);
		$data['leave_control'][0]['ctrl_end_age_m'] = substr($data['leave_control'][0]['ctrl_end_age'], 3, 2);
		$data['leave_control'][0]['ctrl_end_age_d'] = substr($data['leave_control'][0]['ctrl_end_age'], 6, 2);

		// $this->output($this->view.'v_control_leave_edit_form', $data);
		$this->output($this->view.'v_control_leave_form_common', $data);
	}//end leave_add

	/*
	* control_leave_store
	* จัดเก็บข้อมูลควบคุมวันลา
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function control_leave_store()
	{
		// make 2 digit number
		function reFormatTwoDigit($data) {
			$length = strlen($data);
			$intValue = (int)$data;

			if ($length < 1) { // empty string
				return "00";
			} else if ($length == 1) { // 0, 1, 9
				if ($intValue < 1) {
					return "00";
				} else {
					return "0" . $data;
				} 
			} else if ($length == 2) { // -1, 00, 01, 10
				if ($intValue < 1) {
					return "0" . $data[1];
				} else {
					return $data;
				}
			} else { // -99, 000, 099, 999	// (length >= 3)
				return substr($data, strlen($data)-2, 2);			// 99, 00, 99, 99	
			}
		}

		$data = array();
		$data['ctrl_hire_id'] = $this->input->post('ctrl_hire_id');
		$data['ctrl_leave_id'] = $this->input->post('ctrl_leave_id');
		
		$data['ctrl_start_age'] = reFormatTwoDigit($this->input->post('ctrl_start_age_y'))."-".reFormatTwoDigit($this->input->post('ctrl_start_age_m'))."-".reFormatTwoDigit($this->input->post('ctrl_start_age_d'));
		$data['ctrl_end_age'] = reFormatTwoDigit($this->input->post('ctrl_end_age_y'))."-".reFormatTwoDigit($this->input->post('ctrl_end_age_m'))."-".reFormatTwoDigit($this->input->post('ctrl_end_age_d'));
		
		$data['ctrl_time_per_year'] = $this->input->post('ctrl_time_per_year');
		$data['ctrl_day_per_year'] = $this->input->post('ctrl_day_per_year');
		$data['ctrl_hour_per_year'] = $this->input->post('ctrl_hour_per_year');
		$data['ctrl_minute_per_year'] = $this->input->post('ctrl_minute_per_year');
		$data['ctrl_date_per_time'] = $this->input->post('ctrl_date_per_time');
		$data['ctrl_pack_per_year'] = $this->input->post('ctrl_pack_per_year');
		$data['ctrl_money'] = $this->input->post('ctrl_money');
		$data['ctrl_day_before'] = $this->input->post('ctrl_day_before');
		$data['ctrl_day_after'] = $this->input->post('ctrl_day_after');
		$data['ctrl_gd_id'] = $this->input->post('ctrl_gd_id');
		$data['ctrl_hire_type'] = $this->input->post('ctrl_hire_type');

		// check unlimited day
		if(strlen($data['ctrl_time_per_year']) == 0) {$data['ctrl_time_per_year'] = -99; }
		if(strlen($data['ctrl_day_per_year']) == 0) {$data['ctrl_day_per_year'] = -99; }
		if(strlen($data['ctrl_hour_per_year']) == 0) {$data['ctrl_hour_per_year'] = -99; }
		if(strlen($data['ctrl_minute_per_year']) == 0) {$data['ctrl_minute_per_year'] = -99; }
		if(strlen($data['ctrl_date_per_time']) == 0) {$data['ctrl_date_per_time'] = -99; }
		if(strlen($data['ctrl_day_before']) == 0) {$data['ctrl_day_before'] = -99; }
		if(strlen($data['ctrl_day_after']) == 0) {$data['ctrl_day_after'] = -99; }

		$result = $this->M_hr_leave_control->store_leave_control($data, $this->session->userdata('us_id'));
		// echo $result;

		if ($result) {
			redirect(site_url() . "/" . $this->controller . "control_leaves");
		} else {
			die('Insert Error');
		}
		
		// print_r($data);
	}//end leaves_add


	/*
	* control_leave_store
	* จัดเก็บข้อมูลควบคุมวันลา
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function control_leave_update_store($id)
	{
		// make 2 digit number
		function reFormatTwoDigit($data) {
			$length = strlen($data);
			$intValue = (int)$data;

			if ($length < 1) { // empty string
				return "00";
			} else if ($length == 1) { // 0, 1, 9
				if ($intValue < 1) {
					return "00";
				} else {
					return "0" . $data;
				} 
			} else if ($length == 2) { // -1, 00, 01, 10
				if ($intValue < 1) {
					return "0" . $data[1];
				} else {
					return $data;
				}
			} else { // -99, 000, 099, 999	// (length >= 3)
				return substr($data, strlen($data)-2, 2);			// 99, 00, 99, 99	
			}
		}

		$data = array();
		$data['ctrl_hire_id'] = $this->input->post('ctrl_hire_id');
		$data['ctrl_leave_id'] = $this->input->post('ctrl_leave_id');
		
		$data['ctrl_start_age'] = reFormatTwoDigit($this->input->post('ctrl_start_age_y'))."-".reFormatTwoDigit($this->input->post('ctrl_start_age_m'))."-".reFormatTwoDigit($this->input->post('ctrl_start_age_d'));
		$data['ctrl_end_age'] = reFormatTwoDigit($this->input->post('ctrl_end_age_y'))."-".reFormatTwoDigit($this->input->post('ctrl_end_age_m'))."-".reFormatTwoDigit($this->input->post('ctrl_end_age_d'));
		
		$data['ctrl_time_per_year'] = $this->input->post('ctrl_time_per_year');
		$data['ctrl_day_per_year'] = $this->input->post('ctrl_day_per_year');
		$data['ctrl_hour_per_year'] = $this->input->post('ctrl_hour_per_year');
		$data['ctrl_minute_per_year'] = $this->input->post('ctrl_minute_per_year');
		$data['ctrl_date_per_time'] = $this->input->post('ctrl_date_per_time');
		$data['ctrl_pack_per_year'] = $this->input->post('ctrl_pack_per_year');
		$data['ctrl_money'] = $this->input->post('ctrl_money');
		$data['ctrl_day_before'] = $this->input->post('ctrl_day_before');
		$data['ctrl_day_after'] = $this->input->post('ctrl_day_after');
		$data['ctrl_gd_id'] = $this->input->post('ctrl_gd_id');
		$data['ctrl_hire_type'] = $this->input->post('ctrl_hire_type');

		// check unlimited day
		if(strlen($data['ctrl_time_per_year']) == 0) {$data['ctrl_time_per_year'] = -99; }
		if(strlen($data['ctrl_day_per_year']) == 0) {$data['ctrl_day_per_year'] = -99; }
		if(strlen($data['ctrl_hour_per_year']) == 0) {$data['ctrl_hour_per_year'] = -99; }
		if(strlen($data['ctrl_minute_per_year']) == 0) {$data['ctrl_minute_per_year'] = -99; }
		if(strlen($data['ctrl_date_per_time']) == 0) {$data['ctrl_date_per_time'] = -99; }
		if(strlen($data['ctrl_day_before']) == 0) {$data['ctrl_day_before'] = -99; }
		if(strlen($data['ctrl_day_after']) == 0) {$data['ctrl_day_after'] = -99; }
		$id = decrypt_id($id);
		$result = $this->M_hr_leave_control->store_updated_leave_control($id, $data, $this->session->userdata('us_id'));
		// echo $result;

		if ($result) {
			redirect(site_url() . "/" . $this->controller . "control_leaves");
		} else {
			die('Insert Error');
		}
		
		// print_r($data);
	}//end leaves_add


	/*
	* leaves_save
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	// public function leaves_save()
	// {

	// 	$location = $this->input->post('leaves_location_create');
	// 	$create_date = $this->input->post('leaves_create_date');
	// 	$from = $this->input->post('leaves_from');
	// 	$detail = $this->input->post('leaves_detail');
	// 	$start_date = $this->input->post('leaves_start_date');
	// 	$end_date = $this->input->post('leaves_end_date');
	// 	$address = $this->input->post('leaves_address');

    //     // Now you can use these variables in your controller logic
    //     // For example, you can perform database operations, validation, etc.
    //     // Here's a simple example of echoing the received data:
    //     echo "Received data:\n";
    //     echo "Location: " . $location . "\n";
    //     echo "Create Date: " . $create_date . "\n";
    //     echo "From: " . $from . "\n";
    //     echo "Detail: " . $detail . "\n";
    //     echo "Start Date: " . $start_date . "\n";
    //     echo "Address: " . $address . "\n";
	// }//end leaves_save





}//end Leaves_form
?>