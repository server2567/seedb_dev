<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Patcharapol Sirimaneechot
* @Create Date 2567-10-07
*/
include_once('Leaves_Controller.php');

class Leaves_user extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->view .= $this->config->item('leaves_dir');
		$this->model .= $this->config->item('leaves_dir');
		$this->controller .= $this->config->item('leaves_dir');

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = $this->controller."Leaves_user";

		// [20241016 Patcharapol Sirimaneechot]
		$this->load->model($this->model . 'M_hr_leave_summary');

		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');

	}

	/*
	* index
	* ประมวลผลข้อมูลสิทธิ์ลารายบุคคล (สามารถเลือกข้อมูลตามปีได้)
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	public function index()
	{
		
		
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;

		$data['filter_options'] = $this->M_hr_leave_summary->get_filter_options();
		// $data['leave_summary'] = $this->M_hr_leave_summary->get_all_leave_summary();

		$latest_budget_year = $data['filter_options']["lsum_year"][0]; // lastest budget year
		$data['all_user_leave_summary'] = $this->M_hr_leave_summary->get_all_user_leave_summary($latest_budget_year);
		// $data['all_user_leave_summary'] = $this->M_hr_leave_summary->get_all_user_leave_summary(2024);

		$data['controller_dir'] = $this->controller;
		$this->output($this->view.'v_leaves_user_list', $data);
	}

	/*
	* get_leave_summary_datatable
	* ดึงข้อมูลสิทธิ์วันลาทั้งหมดของบุคลากรเป้าหมาย
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-12
	*/
	// public function get_leave_summary_datatable()
	// {
	// 	$lsum_ps_id = $this->input->post('lsum_ps_id');
	// 	$lsum_year = $this->input->post('lsum_year');

	// 	$result = $this->M_hr_leave_summary->get_leave_summary_datatable($lsum_ps_id, $lsum_year);
	// 	echo json_encode($result);
	// }

	/*
	* get_leave_summary_by_condition
	* ประมวลผลข้อมูลสิทธิ์ลารายบุคคล (สามารถเลือกข้อมูลตามปี และใส่เงื่อนไขเพื่อเลือกข้อมูลได้)
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_leave_summary_by_condition() {
		$budget_year = $this->input->post('select_budget_year');
		$hire_is_medical_id = $this->input->post('select_hire_is_medical');
		$hire_type = $this->input->post('select_hire_type');
		$work_status = $this->input->post('select_work_status');

		// $data['hire_is_medical_id'] = $hire_is_medical_id;
		// $data['leave_id'] = $leave_id;
		
		$data['controller_dir'] = $this->controller;
		$result = $this->M_hr_leave_summary->get_leave_summary_by_condition($budget_year, $hire_is_medical_id, $hire_type, $work_status);
		
		foreach($result as $key=>$row){
			$result[$key]['T1.pos_ps_id'] = encrypt_id($row['T1.pos_ps_id']);
    		$result[$key]['T2.pos_ps_id'] = encrypt_id($row['T2.pos_ps_id']);
		}

		$data['result'] = $result;
		echo json_encode($data);
		// echo json_encode($budget_year);
	}

	/*
	* leaves_user_edit
	* ประมวลผลแบบฟอร์มแก้ไขข้อมูลสิทธิ์ลารายบุคคลของบุคลากรเป้าหมาย
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-25
	*/
	function leaves_user_edit($ps_id, $year) {
		/*	data for user profile section */
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		// if($ps_id == ""){
		// 	$this->session->unset_userdata('leaves_by_pass');
		// }

		// $data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));
		$data['ps_id'] = decrypt_id($ps_id);

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();

		$data['base_structure_position'] = $this->M_hr_structure_position->get_all_by_active('asc')->result();
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
		
		/** */

		$budget_year =  $year;
		$user_id =  $data['ps_id'];

		$data["budget_year"] = $budget_year;
		$data["user_id"] = $user_id;

		$data['target_user_leave_summary'] = $this->M_hr_leave_summary->get_target_user_leave_summary($budget_year, $user_id);
		
		$data['base_info'] = $this->M_hr_leave_summary->get_base_info_for_cal_work_age($budget_year, $user_id);
		// $data['base_info'] = $this->get_base_info_for_edit($budget_year, $user_id);
		
		// die(print_r($data['base_info']));
		$data['us_id'] = $this->session->userdata('us_id');// table ums_user


		// print_r($data);
		$data['controller_dir'] = $this->controller;
		$this->output($this->view.'v_leaves_user_form', $data);
		// $this->output($this->view.'v_leaves_user_form', json_encode($data));
	}


	function get_refreshed_date_cal_result() {
		$start_date_cal = $this->input->post('start_date_cal');
		$end_date_cal = $this->input->post('end_date_cal');
		// die("start_date_cal: $start_date_cal" . ", " . "end_date_cal: " . $end_date_cal . ", " . "is_null($start_date_cal): " . is_null($start_date_cal) . ", " . "is_null($end_date_cal): " . is_null($end_date_cal) );
		// echo ("start_date_cal: $start_date_cal" . ", " . "end_date_cal: " . $end_date_cal . ", " . "is_null($start_date_cal): " . is_null($start_date_cal) . ", " . "is_null($end_date_cal): " . is_null($end_date_cal) );
		// echo ("start_date_cal: $start_date_cal" . ", " . "end_date_cal: " . $end_date_cal . ", " . "strlen($start_date_cal): " . strlen($start_date_cal) . ", " . "strlen($end_date_cal): " . strlen($end_date_cal) );
	
		echo json_encode($this->M_hr_leave_summary->get_work_experience_days($start_date_cal, $end_date_cal));
	}

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
	* get_l_control_pre_list_of_target_person
	* ดึงรายการข้อมูลเบื้องต้นของบุคลากรเป้าหมายจากตาราง hr_leave_control (กำหนดเงื่อนไขตามข้อมูลเพศ และ สายงาน)
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-07
	*/
	// function get_l_control_pre_list_of_target_person($ps_id) {
	// 	// $work_age_days = $this->input->post('work_age_days');
	// 	$pre_list = $this->M_hr_leave_summary->get_l_control_pre_list_of_target_person($ps_id);
	// 	// die(print_r($pre_list));
	// 	return $pre_list;
	// }

	/*
	* leave_control_work_age_match_checker
	* ฟังก์ชั่นตรวจสอบการผ่านเงื่อนไขระหว่างอายุงานของบุคลากรเป้าหมายกับช่วงอายุงานที่กำหนดไว้ข้อมูลจากตาราง leave_summary
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-06
	*/
	function leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d) {
		if ($y >= $start_y && $y <= $end_y) {
			if ($y == $start_y) {
				if ($m >= $start_m && $m <= 12) {
					if ($m == $start_m) {
						if ($d >= $start_d && $d <= 29) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					return false;
				}
			}
			else if ($y == $end_y){
				if ($m >= 1 && $m <= $end_m) {
					if ($m == $end_m) {
						if ($d >= 1 && $d <= $end_d) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					return false;
				}
			}
			else {
				// y is between start_y and end_y
				return true;
			}
		
		} else {
			return false;
		}
	}

	function leave_summary_insertor_updator_enginex() {
		// echo json_encode(var_dump($this->input->post('leave_summary_usage_data')));
		// echo (var_dump($this->input->post('leave_summary_usage_data')));

		$x = $this->input->post('leave_summary_usage_data');
		$s = "";

		// foreach ($x as $xKey => $xValue) {
		// 	$s .= $xKey . "<br>";
		// }

		foreach ($x as $xKey => $xValue) {
			$s .= $xValue["lsum_id"] . "<br>";
		}

		// foreach ($x as $x1) {
		// 	$s .= $x1[0];
		// }

		// echo $s;
		
		// echo json_encode("xxx");

		echo json_encode($s);
		// echo json_encode(var_dump($this->input->post('leave_summary_usage_data')));

		

	}
	
	/*
	* leave_summary_insertor_updator_engine
	* ทำการ insert หรือ update ข้อมูลของบุคลากรเป้าหมายเข้าไปยังตาราง hr_leave_summary
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-02
	*/
	function leave_summary_insertor_updator_engine() {
		// print_r($this->input->post('leave_summary_usage_data'));

		$operation_status = null;
		$operation_status_text = null;

		$data['lsum_ps_id'] = $this->input->post('lsum_ps_id');

		$data['mode'] = $this->input->post('mode'); // value of this can be insert or update

		// // if mode is update delete existing data then re-insert
		// // if mode is insert not delete existing data, just insert only
		// $data['mode'] = $this->input->post('mode'); // value of this can be insert or update
		// if ($data['mode'] == "update") {
		// 	$this->M_hr_leave_summary->delete_leave_summary($data['lsum_ps_id']);
		// } 
		   
        
        $data['work_age'] = $this->input->post('work_age');
        $data['budget_year'] = $this->input->post('budget_year');
        $data['date_cal_type'] = $this->input->post('date_cal_type');
        $data['dp_id'] = $this->input->post('dp_id');
        $data['selected_start_date_by_dp_id'] = $this->input->post('selected_start_date_by_dp_id');
        $data['selected_end_date_cal'] = $this->input->post('selected_end_date_cal');
		// die(print_r($data));
		// $this->get_l_control_pre_list_of_target_person($data['lsum_ps_id']);
		$pre_list = $this->M_hr_leave_summary->get_l_control_pre_list_of_target_person($data['lsum_ps_id']);

		// die(print_r($pre_list[0]['ps_id']));
		// die(print_r($pre_list[0]['ctrl_start_age']));

		// die(print_r($pre_list[0]));
		// die(print_r($pre_list['ctrl_start_age']));

		// die(print_r($data['work_age']));

		$result = array();
		
		
		if (count($pre_list) > 0) { // if have some row of target person in original data from leave_control table
			
			$y = $data['work_age'][0];
			$m = $data['work_age'][1];
			$d = $data['work_age'][2];	

			// $test = array();

			$checkResult = array();
			$filtered_pre_list = array();
			for ($i = 0; $i < count($pre_list); $i++) {
				
					$start_y = substr($pre_list[$i]['ctrl_start_age'], 0, 2);
					$start_m = substr($pre_list[$i]['ctrl_start_age'], 3, 2);
					$start_d = substr($pre_list[$i]['ctrl_start_age'], 6, 2);

					$end_y = substr($pre_list[$i]['ctrl_end_age'], 0, 2);
					$end_m = substr($pre_list[$i]['ctrl_end_age'], 3, 2);
					$end_d = substr($pre_list[$i]['ctrl_end_age'], 6, 2);
			
					// array_push($checkResult, $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d));
					// $check = var_export($this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d), true);
					$check = $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
					// array_push($checkResult, "$check, start: $start_y-$start_m-$start_d , end: $end_y-$end_m-$end_d, y-m-d: $y-$m-$d");
					array_push($checkResult, array("check_result"=> $check, "pre_list_index_array"=> $i, "description"=> "start: $start_y-$start_m-$start_d , end: $end_y-$end_m-$end_d, y-m-d(targetPersonWorkAge): $y-$m-$d, selected_start_date_by_dp_id: ".$data['selected_start_date_by_dp_id'].", selected_end_date_cal: ".$data['selected_end_date_cal'].", ctrl_id: ".$pre_list[$i]['ctrl_id'].", ctrl_leave_id: ".$pre_list[$i]['ctrl_leave_id']));
			
					if ($check) {
						array_push($filtered_pre_list, $pre_list[$i]);
					}
				}
			

			// 	$checkResult = $this->leave_control_work_age_match_checker($start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
			// 	array_push($test, $checkResult);
			// }

			// $checkResult = $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
			// array_push($result, $checkResult);

			
			// array_push($result, $pre_list);
			// array_push($result, $checkResult);
			// array_push($result, $filtered_pre_list);
			$result = array("pre_list" => $pre_list, "checkResult" => $checkResult, "filtered_pre_list" => $filtered_pre_list);

			// prepare lsum_work_age

			$prepared_lsum_work_age = "";
			if (strlen($y) == 1) {
				$prepared_lsum_work_age .= "0$y";
			} else {
				$prepared_lsum_work_age .= "$y";
			}

			$prepared_lsum_work_age .= "-";

			if (strlen($m) == 1) {
				$prepared_lsum_work_age .= "0$m";
			} else {
				$prepared_lsum_work_age .= "$m";
			}

			$prepared_lsum_work_age .= "-";

			if (strlen($d) == 1) {
				$prepared_lsum_work_age .= "0$d";
			} else {
				$prepared_lsum_work_age .= "$d";
			}


			if (count($filtered_pre_list) > 0) { // if have some row of target person in filtered data from leave_control table (filtered for keep only matched condition)

				// if mode is update delete existing data then re-insert
				// if mode is insert not delete existing data, just insert only

				if ($data['mode'] == "update") {
					$this->M_hr_leave_summary->delete_leave_summary($data['lsum_ps_id']);

					//
				} 
				
				// insert part
				foreach ($filtered_pre_list as $f) {

					$lsum_count_limit = "N";
					if ($f['ctrl_day_per_year'] == "-99" || $f['ctrl_hour_per_year'] == "-99" || $f['ctrl_minute_per_year'] == "-99") {
						$lsum_count_limit = "Y";
					}
					 

					$this->M_hr_leave_summary->insert_leave_summary($f['pos_ps_id'],
					$f['ctrl_leave_id'],
					$data['budget_year'],
					$prepared_lsum_work_age, 
					($lsum_count_limit == "Y") ? (-99) : ($f['ctrl_day_per_year']),
					($lsum_count_limit == "Y") ? (-99) : ($f['ctrl_hour_per_year']),
					($lsum_count_limit == "Y") ? (-99) : ($f['ctrl_minute_per_year']),
					$lsum_count_limit,
					// 0,
					$data['date_cal_type'],
					$data['dp_id'],
					$data['selected_start_date_by_dp_id'], 
					$data['selected_end_date_cal'], 
					$this->session->userdata('us_id'));
					// echo "$key : $value <br>";
				}

				//update leave usage data of target person
				if ($data['mode'] == "update") {
					$data['leave_summary_usage_data'] = $this->input->post('leave_summary_usage_data');


					foreach($data['leave_summary_usage_data'] as $uKey => $u) {
						$this->M_hr_leave_summary->update_leave_summary_usage_data($data['lsum_ps_id'],
						$u['leave_id'],
						$u['input_lsum_per_day'],
						$u['input_lsum_per_hour'],
						$u['input_lsum_per_minute'],
						$u['lsum_num_day'],
						$u['lsum_num_hour'],
						$u['lsum_num_minute'],
						$u['text_input_lsum_remain_day'],
						$u['text_input_lsum_remain_hour'],
						$u['text_input_lsum_remain_minute'],
						$u['set_unlimited_leave']);

					}

					

					//
				}
				
				

				if ($data['mode'] == "insert") {
					$operation_status = "10";
					$operation_status_text = "requestMode: insert, response: inserted, filtered_pre_list.length: is >= 1";
				} else if ($data['mode'] == "update") { 
					$operation_status = "11";
					$operation_status_text = "requestMode: update, response: deletedAndInserted, filtered_pre_list.length: is >= 1";
				}

			} else { // if not have any row of target person in filtered data from leave_control table (filtered for keep only matched condition)
					 // count($filtered_pre_list) <= 0
				
				if ($data['mode'] == "insert") {
					$operation_status = "00";
					$operation_status_text = "requestMode: insert, response: notInserted, filtered_pre_list.length: 0";
				} else if ($data['mode'] == "update") { 
					$operation_status = "01";
					$operation_status_text = "requestMode: update, response: notDeletedAndNotInserted, filtered_pre_list.length: 0";
				}
			}
			// die(print_r($test));
			
		} else { // if not have any row of target person in original data from leave_control table
				// count($pre_list) <= 0
			if ($data['mode'] == "insert") {
				$operation_status = "00";
				$operation_status_text = "requestMode: insert, response: notInserted, pre_list.length: 0";
			} else if ($data['mode'] == "update") { 
				$operation_status = "01";
				$operation_status_text = "requestMode: update, response: notDeletedAndNotInserted, pre_list.length: 0";
			}
		}

		// if ($data['mode'] == "update") {
		// 	$operation_status .= " (updated)";
		// }
		// $result['pre_list'] = $pre_list;



		// $result['result'] = $result;

		

		$result["operation_status"] = $operation_status;
		$result["operation_status_text"] = $operation_status_text;
		echo json_encode($result);

	}

	
	/*
	* get_leave_summary_datatable_legacy
	* ดึงข้อมูลของบุคลากรเป้าหมายที่ผ่านเกณท์เงื่อนไขที่กำหนด (ดึงจากตาราง hr_leave_summary) (เงื่อนไขที่กำหนดได้แก่: เพศ, อายุงาน, สายงาน, ประเภทการปฏิบัติงาน)
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-18
	*/
	function get_leave_summary_datatable_legacy() {
		$lsum_ps_id = $this->input->post('lsum_ps_id');
        $work_age = $this->input->post('work_age');
        $budget_year = $this->input->post('budget_year');
        $date_cal_type = $this->input->post('date_cal_type');
        $dp_id = $this->input->post('dp_id');
        $selected_start_date_by_dp_id = $this->input->post('selected_start_date_by_dp_id');
        $selected_end_date_cal = $this->input->post('selected_end_date_cal');

		$filtered_pre_list_data = $this->get_leave_summary_filtered_pre_list($lsum_ps_id, $work_age, $budget_year, $date_cal_type, $dp_id, $selected_start_date_by_dp_id, $selected_end_date_cal);

		// prepare $lsum_leave_id_set (this var keep string)
		$filtered_pre_list = $filtered_pre_list_data['filtered_pre_list'];
		$lsum_leave_id_set = '';

		foreach ($filtered_pre_list as $f) {
			$lsum_leave_id_set .= $f['ctrl_leave_id'] . ', ';
		}

		$len = strlen($lsum_leave_id_set);
		$lsum_leave_id_set = substr($lsum_leave_id_set, 0, $len - 2);

		// // get data for render datatable
		$leave_summary_datatable = $this->M_hr_leave_summary->get_leave_summary_datatable($lsum_ps_id, $budget_year, $lsum_leave_id_set);

		

		$result['lsum_leave_id_set'] = $lsum_leave_id_set;
		$result['leave_summary_datatable'] = $leave_summary_datatable;
		echo json_encode($result);
		// echo json_encode($lsum_leave_id_set);
	}

	/*
	* existing_in_hr_person_position_checker
	* ตรวจสอบว่ามีข้อมูลของบุคลากรเป้าหมายอยู่ในตาราง hr_person_position หรือไม่
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-22
	*/
	function existing_in_hr_person_position_checker($ps_id) {
		$result = $this->M_hr_leave_summary->existing_in_hr_person_position_checker($ps_id);
		if (count($result) < 1) {
			return json_encode(false);
		} else {
			return json_encode(true);
		}
    }
	
	/*
	* get_leave_summary_datatable
	* ดึงข้อมูลของบุคลากรเป้าหมายที่ได้บันทึกไว้ในตาราง hr_leave_summary
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-20
	*/
	function get_leave_summary_datatable() {
		$lsum_ps_id = $this->input->post('lsum_ps_id');
        $budget_year = $this->input->post('budget_year');
        
		// // get data for render datatable
		$leave_summary_datatable = $this->M_hr_leave_summary->get_leave_summary_datatable($lsum_ps_id, $budget_year);

		// map array
		foreach ($leave_summary_datatable as $index => $l) {
			$get_sum_minutes_result = $this->M_hr_leave_summary->get_sum_minutes($lsum_ps_id, $budget_year, $l['lsum_leave_id']); 
			// $l['sum_minute'] = $get_sum_minutes_result[0]["sum_minutes"];
			$leave_summary_datatable[$index]["sum_minutes"] = $get_sum_minutes_result[0]["sum_minutes"];
			// $l['sum_minute'] = true;
			// $l['leave_id'] = true;

			// $leave_summary_datatable[$index]["leave_id"] = $get_sum_minutes_result["sum_minutes"];

			// $leave_summary_datatable[$index]["leave_id"] = "true";
			// $leave_summary_datatable[$index]["leave_id"] = $get_sum_minutes_result[0]["sum_minutes"];

			// $leave_summary_datatable[$index]["sum_minutes"] = $get_sum_minutes_result["sum_minutes"];
			// array_push($leave_summary_datatable[$index]["sum_minutes"], $get_sum_minutes_result["sum_minutes"]);
			// $leave_summary_datatable[$index]["sum_minutes"] = $get_sum_minutes_result["sum_minutes"];
			
			// $leave_summary_datatable[$index] = array_merge($leave_summary_datatable[$index], array("sum_minutes" => $get_sum_minutes_result["sum_minutes"]));
		}

		$result['leave_summary_datatable'] = $leave_summary_datatable;
		echo json_encode($result);
		// echo json_encode(print_r($result));
		// echo $result;
	}
	
	/*
	* get_leave_summary_filtered_pre_list
	* ดึงข้อมูลของบุคลากรเป้าหมายที่ผ่านเกณท์เงื่อนไขที่กำหนด (ดึงจากตาราง hr_leave_control)
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-18
	*/
	function get_leave_summary_filtered_pre_list($lsum_ps_id, $work_age, $budget_year, $date_cal_type, $dp_id, $selected_start_date_by_dp_id, $selected_end_date_cal) {
		$operation_status_text = null;

		$data['lsum_ps_id'] = $lsum_ps_id;
        $data['work_age'] = $work_age;
        $data['budget_year'] = $budget_year;
        $data['date_cal_type'] = $date_cal_type;
        $data['dp_id'] = $dp_id;
        $data['selected_start_date_by_dp_id'] = $selected_start_date_by_dp_id;
        $data['selected_end_date_cal'] = $selected_end_date_cal;

		// $data['lsum_ps_id'] = $this->input->post('lsum_ps_id');
        // $data['work_age'] = $this->input->post('work_age');
        // $data['budget_year'] = $this->input->post('budget_year');
        // $data['date_cal_type'] = $this->input->post('date_cal_type');
        // $data['dp_id'] = $this->input->post('dp_id');
        // $data['selected_start_date_by_dp_id'] = $this->input->post('selected_start_date_by_dp_id');
        // $data['selected_end_date_cal'] = $this->input->post('selected_end_date_cal');

		$pre_list = $this->M_hr_leave_summary->get_l_control_pre_list_of_target_person($data['lsum_ps_id']);

		$result = array();
		$checkResult = array();
		$filtered_pre_list = array();
		
		if (count($pre_list) > 0) { // if have some row of target person in original data from leave_control table
			
			$y = $data['work_age'][0];
			$m = $data['work_age'][1];
			$d = $data['work_age'][2];	
			
			for ($i = 0; $i < count($pre_list); $i++) {
				
					$start_y = substr($pre_list[$i]['ctrl_start_age'], 0, 2);
					$start_m = substr($pre_list[$i]['ctrl_start_age'], 3, 2);
					$start_d = substr($pre_list[$i]['ctrl_start_age'], 6, 2);

					$end_y = substr($pre_list[$i]['ctrl_end_age'], 0, 2);
					$end_m = substr($pre_list[$i]['ctrl_end_age'], 3, 2);
					$end_d = substr($pre_list[$i]['ctrl_end_age'], 6, 2);
			
					$check = $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
					array_push($checkResult, array("check_result"=> $check, "pre_list_index_array"=> $i, "description"=> "start: $start_y-$start_m-$start_d , end: $end_y-$end_m-$end_d, y-m-d: $y-$m-$d"));
			
					if ($check) {
						array_push($filtered_pre_list, $pre_list[$i]);
					}
				}
			
			$result = array("pre_list" => $pre_list, "checkResult" => $checkResult, "filtered_pre_list" => $filtered_pre_list);

			// prepare lsum_work_age

			// $prepared_lsum_work_age = "";
			// if (strlen($y) == 1) {
			// 	$prepared_lsum_work_age .= "0$y";
			// } else {
			// 	$prepared_lsum_work_age .= "$y";
			// }

			// $prepared_lsum_work_age .= "-";

			// if (strlen($m) == 1) {
			// 	$prepared_lsum_work_age .= "0$m";
			// } else {
			// 	$prepared_lsum_work_age .= "$m";
			// }

			// $prepared_lsum_work_age .= "-";

			// if (strlen($d) == 1) {
			// 	$prepared_lsum_work_age .= "0$d";
			// } else {
			// 	$prepared_lsum_work_age .= "$d";
			// }

			if (count($filtered_pre_list) > 0) { // if have some row of target person in filtered data from leave_control table (filtered for keep only matched condition)
				$operation_status_text = "filtered_pre_list.length: is >= 1";

			} else { // if not have any row of target person in filtered data from leave_control table (filtered for keep only matched condition)
					 // count($filtered_pre_list) <= 0
				
				$operation_status_text = "filtered_pre_list.length: 0";
			}
			
		} else { // if not have any row of target person in original data from leave_control table
				// count($pre_list) <= 0
			$operation_status_text = "pre_list.length: 0";

			$result = array("pre_list" => $pre_list, "checkResult" => $checkResult, "filtered_pre_list" => $filtered_pre_list);
		}

		$result["operation_status_text"] = $operation_status_text;
		// echo json_encode($result);
		return $result;

	}

	// /*
	// * insert_leave_summary
	// * ทำการ insert ข้อมูลของบุคลากรเป้าหมายเข้าไปยังตาราง hr_leave_summary
	// * @input -
	// * @output -
	// * @author Patcharapol Sirimaneechot
	// * @Create Date 2567-11-02
	// */
	// function insert_leave_summary() {

    //     $data['lsum_ps_id'] = $this->input->post('lsum_ps_id');
    //     $data['work_age'] = $this->input->post('work_age');
    //     $data['budget_year'] = $this->input->post('budget_year');
    //     $data['date_cal_type'] = $this->input->post('date_cal_type');
    //     $data['dp_id'] = $this->input->post('dp_id');
    //     $data['selected_start_date_by_dp_id'] = $this->input->post('selected_start_date_by_dp_id');
    //     $data['selected_end_date_cal'] = $this->input->post('selected_end_date_cal');
	// 	// die(print_r($data));
	// 	// $this->get_l_control_pre_list_of_target_person($data['lsum_ps_id']);
	// 	$pre_list = $this->M_hr_leave_summary->get_l_control_pre_list_of_target_person($data['lsum_ps_id']);

	// 	// die(print_r($pre_list[0]['ps_id']));
	// 	// die(print_r($pre_list[0]['ctrl_start_age']));

	// 	// die(print_r($pre_list[0]));
	// 	// die(print_r($pre_list['ctrl_start_age']));

	// 	// die(print_r($data['work_age']));

	// 	$result = array();
	// 	$operation_status = null;
		
	// 	if (count($pre_list) > 0) { // if have some row of target person in original data from leave_control table
			
	// 		$y = $data['work_age'][0];
	// 		$m = $data['work_age'][1];
	// 		$d = $data['work_age'][2];	

	// 		// $test = array();

	// 		$checkResult = array();
	// 		$filtered_pre_list = array();
	// 		for ($i = 0; $i < count($pre_list); $i++) {
				
	// 				$start_y = substr($pre_list[$i]['ctrl_start_age'], 0, 2);
	// 				$start_m = substr($pre_list[$i]['ctrl_start_age'], 3, 2);
	// 				$start_d = substr($pre_list[$i]['ctrl_start_age'], 6, 2);

	// 				$end_y = substr($pre_list[$i]['ctrl_end_age'], 0, 2);
	// 				$end_m = substr($pre_list[$i]['ctrl_end_age'], 3, 2);
	// 				$end_d = substr($pre_list[$i]['ctrl_end_age'], 6, 2);
			
	// 				// array_push($checkResult, $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d));
	// 				// $check = var_export($this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d), true);
	// 				$check = $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
	// 				// array_push($checkResult, "$check, start: $start_y-$start_m-$start_d , end: $end_y-$end_m-$end_d, y-m-d: $y-$m-$d");
	// 				array_push($checkResult, array("check_result"=> $check, "pre_list_index_array"=> $i, "description"=> "start: $start_y-$start_m-$start_d , end: $end_y-$end_m-$end_d, y-m-d: $y-$m-$d"));
			
	// 				if ($check) {
	// 					array_push($filtered_pre_list, $pre_list[$i]);
	// 				}
	// 			}
			

	// 		// 	$checkResult = $this->leave_control_work_age_match_checker($start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
	// 		// 	array_push($test, $checkResult);
	// 		// }

	// 		// $checkResult = $this->leave_control_work_age_match_checker($y, $m, $d, $start_y, $start_m, $start_d, $end_y, $end_m, $end_d);
	// 		// array_push($result, $checkResult);

			
	// 		// array_push($result, $pre_list);
	// 		// array_push($result, $checkResult);
	// 		// array_push($result, $filtered_pre_list);
	// 		$result = array("pre_list" => $pre_list, "checkResult" => $checkResult, "filtered_pre_list" => $filtered_pre_list);

	// 		// prepare lsum_work_age

	// 		$prepared_lsum_work_age = "";
	// 		if (strlen($y) == 1) {
	// 			$prepared_lsum_work_age .= "0$y";
	// 		} else {
	// 			$prepared_lsum_work_age .= "$y";
	// 		}

	// 		$prepared_lsum_work_age .= "-";

	// 		if (strlen($m) == 1) {
	// 			$prepared_lsum_work_age .= "0$m";
	// 		} else {
	// 			$prepared_lsum_work_age .= "$m";
	// 		}

	// 		$prepared_lsum_work_age .= "-";

	// 		if (strlen($d) == 1) {
	// 			$prepared_lsum_work_age .= "0$d";
	// 		} else {
	// 			$prepared_lsum_work_age .= "$d";
	// 		}


	// 		if (count($filtered_pre_list) > 0) { // if have some row of target person in filtered data from leave_control table (filtered for keep only matched condition)

	// 			// insert part
	// 			foreach ($filtered_pre_list as $f) {

	// 				$this->M_hr_leave_summary->insert_leave_summary($f['pos_ps_id'],
	// 				$f['ctrl_leave_id'],
	// 				$data['budget_year'],
	// 				$prepared_lsum_work_age, 
	// 				$f['ctrl_day_per_year'],
	// 				$f['ctrl_hour_per_year'],
	// 				0,
	// 				$data['date_cal_type'],
	// 				$data['dp_id'],
	// 				$data['selected_start_date_by_dp_id'], 
	// 				$data['selected_end_date_cal'], 
	// 				$this->session->userdata('us_id'));
	// 				// echo "$key : $value <br>";
	// 			}
	// 			$operation_status = "inserted";

	// 		} else { // if not have any row of target person in filtered data from leave_control table (filtered for keep only matched condition)
	// 			$operation_status = "not inserted";
	// 		}
	// 		// die(print_r($test));
			
	// 	} else { // if not have any row of target person in original data from leave_control table
	// 		$operation_status = "not inserted";
	// 	}

	// 	$result["operation_status"] = $operation_status;
	// 	echo json_encode($result);

	// }


	

	/*
	* insert_leave_summary
	* ทำการ insert ข้อมูลของบุคลากรเป้าหมายเข้าไปยังตาราง hr_leave_summary
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-11-02
	*/
	/*
	function insert_leave_summary() {

		// $data['lsum_id'] = $this->input->post('lsum_id'); 
        $data['lsum_ps_id'] = $this->input->post('lsum_ps_id');
        $data['lsum_leave_id'] = $this->input->post('lsum_leave_id');
        $data['lsum_year'] = $this->input->post('lsum_year');

        $data['lsum_date_cal_type'] = $this->input->post('lsum_date_cal_type');
        $data['lsum_dp_id'] = $this->input->post('lsum_dp_id');
        $data['lsum_start_date_cal'] = $this->input->post('lsum_start_date_cal');
        $data['lsum_end_date_cal'] = $this->input->post('lsum_end_date_cal');
        $data['lsum_update_date'] = $this->input->post('lsum_update_date');
        $data['lsum_update_user'] = $this->input->post('lsum_update_user');
        $data['lsum_work_age'] = $this->input->post('lsum_work_age');

		$data['latest_inserted_id'] = $this->M_hr_leave_summary->insert_leave_summary($data);


		// return json_encode($data);

		// echo "HI";
		echo json_encode($data);
	}
	*/
}
?>