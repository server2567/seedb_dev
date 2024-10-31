<?php 
/*
* Personal_dashboard
* Controller หลักของ SEEDB HRM
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 16/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_HR_Controller.php");
class Personal_dashboard extends SEEDB_HR_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Personal_dashboard/";
		$this->mn_active_url = uri_string();

		// load model
		$this->load->model($this->config->item('hr_dir').'M_hr_person');
		$this->load->model($this->model.'Personal_dashboard_model');
	}

	/*
	* index
	* index หลักของ SEEDB HRM
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function index()
	{
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();

		$currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543; 	
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;

		// $line_data = array(
		// 	"msst_id" => 1,
		// 	"pt_id" => 103,
		// 	"apm_cl_code" => 50
		// );

		// $url_service_line = site_url()."/".$this->config->item('line_service_dir')."send_message_que_to_patient";
		// get_url_line_service($url_service_line, $line_data);	// Line helper

        // $this->output($this->view.'v_personal_dashboard',$data);
		// print_r('x');
		$this->output($this->view.'v_seedb_hr',$data);
    }
	// index

	/*
	* get_HRM_1_card
	* ดึงข้อมูลการ์ด HRM
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_1_card(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');

		// Modify the query based on card type to fetch detailed data
		$result = $this->Personal_dashboard_model->get_HRM_1_card($dp_id, $year_type, $year)->result();
		
		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_1_card

	/*
	* get_HRM_1_card_details
	* ดึงข้อมูลการ์ด HRM detail
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_1_card_details() {
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
		$card_type = $this->input->get('card_type');
	
		// Modify the query based on card type to fetch detailed data
		$result = $this->Personal_dashboard_model->get_HRM_1_card_person_detail($dp_id, $year_type, $year, $card_type)->result();
		foreach ($result as $key => $row) {
			if($card_type == "out"){
				$row->ps_work_end_date = abbreDate2($row->ps_work_end_date);
			}

		}

		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_1_card_details

	/*
	* get_HRM_chart_1
	* ดึงข้อมูลกราฟ HRM-1
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_1(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// Modify the query based on card type to fetch detailed data
		$result['chart'] = $this->Personal_dashboard_model->get_HRM_chart_1($dp_id, $year_type, $year)->result();
		$hire_type = $this->Personal_dashboard_model->get_hr_base_hire_group_data()->result();
		
		foreach($hire_type as $key=>$hire){
			$person_list = $this->Personal_dashboard_model->get_HRM_chart_1_person_detail($dp_id, $year_type, $year, $hire->hire_is_medical)->result();
			
			$result['detail'][] = [
				"type" => $hire->hire_is_medical,
				"person_list" => $person_list
			];
		}

		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_chart_1

	/*
	* get_HRM_chart_2
	* ดึงข้อมูลกราฟ HRM-2
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_2(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// ดึงข้อมูลโครงสร้างปัจจุบัน
		$structure = $this->Personal_dashboard_model->get_structure_now_is_confirm($dp_id, $year_type, $year)->row();
		$structure_detail_level_3 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, 3)->result(); // ฝ่าย
	
		foreach($structure_detail_level_3 as $key => $lvl3){
			// ดึงข้อมูลพนักงานระดับ 3
			$structure_person_level_3 = $this->Personal_dashboard_model->get_structure_person_by_stde_id($dp_id, $year_type, $year, $lvl3->stde_id)->result();
	
			// ดึงข้อมูลระดับ 4 ภายใต้ระดับ 3
			$structure_detail_level_4 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, 4, $lvl3->stde_id)->result(); // แผนก
	
			$chart_detail_level_4 = [];
			$total_count_level_4 = 0;
	
			foreach($structure_detail_level_4 as $lvl4) {
				// ดึงข้อมูลพนักงานระดับ 4
				$structure_person_level_4 = $this->Personal_dashboard_model->get_structure_person_by_stde_id($dp_id, $year_type, $year, $lvl4->stde_id)->result();
	
				$chart_detail_level_4[] = [
					"stde_id" => $lvl4->stde_id,
					"chart_id" => $lvl4->stde_id,
					"chart_name" => $lvl4->stde_name_th,
					"chart_level" => 4,
					"chart_count" => count($structure_person_level_4),
					"structure_person" => $structure_person_level_4
				];
	
				// รวมจำนวนคนระดับ 4
				$total_count_level_4 += count($structure_person_level_4);
			}
	
			// รวมจำนวนคนระดับ 3 และ 4
			$total_count = count($structure_person_level_3) + $total_count_level_4;
	
			// Include level 3 data as part of the level 4 chart detail
			$chart_detail_level_3 = [
				"stde_id" => $lvl3->stde_id,
				"chart_id" => $lvl3->stde_id,
				"chart_name" => $lvl3->stde_name_th,
				"chart_level" => 3,
				"chart_count" => count($structure_person_level_3),
				"structure_person" => $structure_person_level_3
			];
	
			$result['chart'][] = [
				"stde_id" => $lvl3->stde_id,
				"chart_id" => $lvl3->stde_id,
				"chart_name" => $lvl3->stde_name_th,
				"chart_level" => 3,
				"chart_count" => $total_count, // level 3 + level 4 count
				"chart_detail" => array_merge([$chart_detail_level_3], $chart_detail_level_4) // รวมข้อมูลระดับ 3 และ 4 เข้าไป
			];
		}
	
		// Return the result as JSON
		echo json_encode($result);
	}

	/*
	* get_HRM_chart_3
	* ดึงข้อมูลกราฟ HRM-3
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_3(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// ดึงข้อมูลโครงสร้างปัจจุบัน
		$structure = $this->Personal_dashboard_model->get_structure_now_is_confirm($dp_id, $year_type, $year)->row();
		$structure_detail_level_3 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, 3)->result(); // ฝ่าย

		foreach($structure_detail_level_3 as $key => $lvl3){
			// ดึงข้อมูลพนักงานระดับ 3
			$structure_person_level_3 = $this->Personal_dashboard_model->get_structure_person_by_stde_id($dp_id, $year_type, $year, $lvl3->stde_id)->result();

			foreach($structure_person_level_3 as $i => $ps3){
				$ps3->hipos_pos_work_start_date_text = abbreDate2($ps3->hipos_pos_work_start_date);

				if($ps3->hipos_pos_work_end_date == "9999-12-31"){
					$ps3->hipos_pos_work_end_date_text = "ปัจจุบัน";
				}
				else{
					if($ps3->hipos_pos_work_end_date != ""){
						$ps3->hipos_pos_work_end_date_text = abbreDate2($ps3->hipos_pos_work_end_date);
					}
					else{
						$ps3->hipos_pos_work_end_date_text = "-";
					}
					
				}
			}
	
			// ดึงข้อมูลระดับ 4 ภายใต้ระดับ 3
			$structure_detail_level_4 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, 4, $lvl3->stde_id)->result(); // แผนก
	
			$chart_detail_level_4 = [];
			$total_count_level_4 = 0;
	
			foreach($structure_detail_level_4 as $lvl4) {
				// ดึงข้อมูลพนักงานระดับ 4
				$structure_person_level_4 = $this->Personal_dashboard_model->get_structure_person_by_stde_id($dp_id, $year_type, $year, $lvl4->stde_id)->result();

				foreach($structure_person_level_4 as $i => $ps4){
					$ps4->hipos_pos_work_start_date_text = abbreDate2($ps4->hipos_pos_work_start_date);
	
					if($ps4->hipos_pos_work_end_date == "9999-12-31"){
						$ps4->hipos_pos_work_end_date_text = "ปัจจุบัน";
					}
					else{
						if($ps4->hipos_pos_work_end_date != ""){
							$ps4->hipos_pos_work_end_date_text = abbreDate2($ps4->hipos_pos_work_end_date);
						}
						else{
							$ps4->hipos_pos_work_end_date_text = "-";
						}
						
					}
				}
	
				$chart_detail_level_4[] = [
					"stde_id" => $lvl4->stde_id,
					"chart_id" => $lvl4->stde_id,
					"chart_name" => $lvl4->stde_name_th,
					"chart_level" => 4,
					"chart_count" => count($structure_person_level_4),
					"structure_person" => $structure_person_level_4
				];
	
				// รวมจำนวนคนระดับ 4
				$total_count_level_4 += count($structure_person_level_4);
			}
	
			// รวมจำนวนคนระดับ 3 และ 4
			$total_count = count($structure_person_level_3) + $total_count_level_4;
	
			// Include level 3 data as part of the level 4 chart detail
			$chart_detail_level_3 = [
				"stde_id" => $lvl3->stde_id,
				"chart_id" => $lvl3->stde_id,
				"chart_name" => $lvl3->stde_name_th,
				"chart_level" => 3,
				"chart_count" => count($structure_person_level_3),
				"structure_person" => $structure_person_level_3
			];
	
			$result['chart'][] = [
				"stde_id" => $lvl3->stde_id,
				"chart_id" => $lvl3->stde_id,
				"chart_name" => $lvl3->stde_name_th,
				"chart_level" => 3,
				"chart_count" => $total_count, // level 3 + level 4 count
				"chart_detail" => array_merge([$chart_detail_level_3], $chart_detail_level_4) // รวมข้อมูลระดับ 3 และ 4 เข้าไป
			];
		}
	
		// Return the result as JSON
		echo json_encode($result);
	}

	/*
	* get_HRM_chart_4
	* ดึงข้อมูลกราฟ HRM-4
	* @input -
	* @output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_4(){

		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');

		// ดึงข้อมูลโครงสร้างปัจจุบัน
		$structure = $this->Personal_dashboard_model->get_structure_now_is_confirm($dp_id, $year_type, $year)->row();
		$structure_detail_level_3 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, 3, '', 'Y')->result(); // ฝ่าย

		$result = [];

		// foreach($structure_detail_level_3 as $key => $lvl3){

			// ดึงข้อมูลระดับ 4 ภายใต้ระดับ 3
			$structure_detail_level_4 = $this->Personal_dashboard_model->get_structure_detail_by_stuc_id($structure->stuc_id, '>2', '', 'Y')->result(); // แผนก

			foreach($structure_detail_level_4 as $lvl4) {
				// ดึงข้อมูลพนักงานระดับ 4
				$structure_person_level_4 = $this->Personal_dashboard_model->get_structure_person_by_stde_id($dp_id, $year_type, $year, $lvl4->stde_id, "'M','N'")->result();

				$result['chart'][] = [
					"stde_id" => $lvl4->stde_id,
					"chart_id" => $lvl4->stde_id,
					"chart_name" => $lvl4->stde_name_th,
					"chart_level" => 4,
					"chart_count" => count($structure_person_level_4),
					"structure_person" => $structure_person_level_4
				];
			}
		// }

		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_chart_4

	/*
	* get_HRM_chart_5
	* ดึงข้อมูลกราฟ HRM-3
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_5() {
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
		$result = [];
		
		$education_levels = $this->Personal_dashboard_model->get_education_level()->result();
		$hire_types = $this->Personal_dashboard_model->get_hr_base_hire_group_data()->result();
	
		// Group education levels by name to avoid duplicates
		$grouped_education_levels = array_reduce($education_levels, function($carry, $item) {
			$carry[$item->edulv_name][] = $item->edulv_id;
			return $carry;
		}, []);
	
		// Prepare unique categories from grouped education levels
		$categories = array_keys($grouped_education_levels);
	
		// Prepare data series and details
		$data = [];
		$details = [];
		
		foreach ($hire_types as $hire) {
			$series_data = [];
			$hire_detail = [];
			
			foreach ($categories as $category) {
				$edulv_ids = $grouped_education_levels[$category];
	
				// Initialize count and person list
				$count = 0;
				$person_list = [];
	
				foreach ($edulv_ids as $edulv_id) {
					// Count the individuals for this hire type and grouped education level
					$count_query = $this->Personal_dashboard_model->get_HRM_chart_5($dp_id, $year_type, $year, $hire->hire_is_medical, $edulv_id);
					$count += $count_query; // Aggregate the counts for all edulv_ids in the group
	
					 // Get detailed information
					$detail_query = $this->Personal_dashboard_model->get_HRM_chart_5_detail($dp_id, $year_type, $year, $hire->hire_is_medical, $edulv_id)->result();
	
					// Filter out null or empty entries and add hire_id and hire_is_medical
					$filtered_details = array_filter($detail_query, function($person) use ($hire) {
						if (!is_null($person->hipos_ps_id) && !empty($person->full_name)) {
							$person->hire_id = $hire->hire_id; // Add hire_id to each person
							$person->hire_is_medical = $hire->hire_is_medical; // Add hire_is_medical to each person
							return true;
						}
						return false;
					});
	
					// Combine the result directly to person_list
					$person_list = array_merge($person_list, $filtered_details);
					
				}
	
				$series_data[] = $count;
				$hire_detail[$category] = [
					'hire_is_medical' => $hire->hire_is_medical,
					'person_list' => $person_list
				];
			}
	
			$data[] = [
				"id" => $hire->hire_is_medical,
				"name" => $hire->hire_is_medical_label,
				"data" => $series_data
			];
	
			$details[$hire->hire_is_medical_label] = $hire_detail;
			
		}
	
		// Prepare the final result
		$result['chart']['categories'] = $categories;
		$result['chart']['series'] = $data;
		$result['detail'] = $details;
	
		// Return the result as JSON
		echo json_encode($result);
	}

	
	
	// get_HRM_chart_5

	

}
