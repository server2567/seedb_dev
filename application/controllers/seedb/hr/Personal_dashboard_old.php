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
		$data['status_response'] = $this->config->item('status_response_show');;
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

        // $this->output($this->view.'v_personal_dashboard',$data);
		$this->output($this->view.'v_seedb_hr',$data);
    }
	// index

	/*
	* get_HRM_card
	* ดึงข้อมูลการ์ด HRM
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_card(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');

		// Modify the query based on card type to fetch detailed data
		$result = $this->Personal_dashboard_model->get_HRM_card($dp_id, $year_type, $year)->result();
		
		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_card

	/*
	* get_HRM_card_details
	* ดึงข้อมูลการ์ด HRM detail
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_card_details() {
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
		$card_type = $this->input->get('card_type');
	
		// Modify the query based on card type to fetch detailed data
		$result = $this->Personal_dashboard_model->get_HRM_card_person_detail($dp_id, $year_type, $year, $card_type)->result();
		foreach ($result as $key => $row) {
			if($card_type == "out"){
				$row->ps_work_end_date = abbreDate2($row->ps_work_end_date);
			}

		}

		// Return the result as JSON
		echo json_encode($result);
	}

	/*
 * get_HRM_chart_G1
 * ดึงข้อมูลกราฟ SEE-HRM-G1
 * @input -
 * $output -
 * @Create Date 08/07/2024
 */
public function get_HRM_chart_G1()
{
    $dp_id = $this->input->get('dp_id');
    $year_type = $this->input->get('year_type');
    $year = $this->input->get('year');

    // Fetch chart data
    $chart_data = $this->Personal_dashboard_model->get_HRM_chart_G1($dp_id, $year_type, $year)->result();

    // Initialize result array
    $result = [
        'chart' => [],
        'detail' => []
    ];

    // Organize data into the required format
    foreach ($chart_data as $row) {
        if (!isset($result['chart'][$row->stde_id])) {
            $result['chart'][$row->stde_id] = [
                'stde_id' => $row->stde_id,
                'stde_name' => $row->stde_name,
                'hire_list' => [
                    ['hire_is_medical' => 'M', 'hire_person_count' => 0],
                    ['hire_is_medical' => 'N', 'hire_person_count' => 0],
                    ['hire_is_medical' => 'S', 'hire_person_count' => 0]
                ]
            ];
        }

        foreach ($result['chart'][$row->stde_id]['hire_list'] as &$hire_item) {
            if ($hire_item['hire_is_medical'] == $row->hire_is_medical) {
                $hire_item['hire_person_count'] = $row->hire_person_count;
            }
        }
    }

    $result['chart'] = array_values($result['chart']);

    // Fetch person details for each department and add to result['detail']
    foreach ($result['chart'] as $department) {
        $person_details = $this->Personal_dashboard_model->get_HRM_chart_G1_person_detail($dp_id, $year_type, $year, $department['stde_id'])->result();

        $hire_groups = [
            'M' => [],
            'N' => []
        ];

        foreach ($person_details as $person) {
            $hire_groups[$person->hire_is_medical][] = [
                'hipos_ps_id' => $person->hipos_ps_id,
                'full_name' => $person->full_name,
                'ps_hire_name' => $person->ps_hire_name,
                'ps_admin_name' => $person->ps_admin_name,
                'ps_spcl_name' => $person->ps_spcl_name,
                'ps_alp_name' => $person->ps_alp_name,
                'ps_retire_name' => $person->ps_retire_name,
				'ps_stde_name' => $department['stde_name']
            ];
        }

        $result['detail'][] = [
            'stde_id' => $department['stde_id'],
            'stde_name' => $department['stde_name'],
            'hire_groups' => $hire_groups
        ];
    }

    // Return the result as JSON
    echo json_encode($result);
}

	/*
	* get_HRM_chart_G2
	* ดึงข้อมูลกราฟ SEE-HRM-G2
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	public function get_HRM_chart_G2(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// Modify the query based on card type to fetch detailed data
		$result['chart'] = $this->Personal_dashboard_model->get_HRM_chart_G2($dp_id, $year_type, $year)->result();
		$hire_type = $this->Personal_dashboard_model->get_hr_base_hire_group_is_medical_data()->result();

		foreach($hire_type as $key=>$hire){
			$person_list = $this->Personal_dashboard_model->get_HRM_chart_G2_person_detail($dp_id, $year_type, $year, $hire->hire_is_medical)->result();
			$result['detail'][] = [
				"type" => $hire->hire_is_medical,
				"person_list" => $person_list
			];
		}

		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_chart_G2


	/*
	* get_HRM_chart_G3
	* ดึงข้อมูลกราฟ SEE-HRM-G3
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 03/07/2024
	*/
	public function get_HRM_chart_G3(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// Modify the query based on card type to fetch detailed data
		$result['chart'] = $this->Personal_dashboard_model->get_HRM_chart_G3($dp_id, $year_type, $year)->result();
		// $result['detail'] = $this->Personal_dashboard_model->get_HRM_chart_G3_person_detail($dp_id, $year_type, $year)->result();
		$person_detail_data = $this->Personal_dashboard_model->get_HRM_chart_G3_person_detail($dp_id, $year_type, $year)->result();

		// Initialize an empty array to map data
		$mapped_data = [];

		// Prepare the mapped data structure for each chart entry
		foreach ($result['chart'] as $chart) {
			$chart_name = trim(str_replace(['ปฏิบัติงานเต็มเวลา', 'ปฏิบัติงานบางเวลา'], '', $chart->chart_name));
			if (!isset($mapped_data[$chart_name])) {
				$mapped_data[$chart_name] = [
					'hire_name' => $chart_name,
					'hire_detail' => [
						'all' => [],
						'full' => [],
						'part' => []
					]
				];
			}
		}
	 
		// Map detailed personnel data to the appropriate hire_detail
		foreach ($person_detail_data as $detail) {
			$chart_name = trim(str_replace(['ปฏิบัติงานเต็มเวลา', 'ปฏิบัติงานบางเวลา'], '', $detail->ps_hire_name));
			$hire_type_key = strtolower(str_replace('-time', '', $detail->chart_subtype));
			if (!isset($mapped_data[$chart_name])) {
				$mapped_data[$chart_name] = [
					'hire_name' => $chart_name,
					'hire_detail' => [
						'all' => [],
						'full' => [],
						'part' => []
					]
				];
			}
			if(isset($detail->hipos_ps_id) && $detail->hipos_ps_id){
				$person_data = [
					'hipos_ps_id' => $detail->hipos_ps_id,
					'full_name' => $detail->full_name,
					'ps_hire_name' => $detail->ps_hire_name,
					'ps_admin_name' => $detail->ps_admin_name,
					'ps_spcl_name' => $detail->ps_spcl_name,
					'ps_alp_name' => $detail->ps_alp_name,
					'ps_retire_name' => $detail->ps_retire_name,
					'ps_work_end_date' => $detail->ps_work_end_date
				];
				$mapped_data[$chart_name]['hire_detail'][$hire_type_key][] = $person_data;
				$mapped_data[$chart_name]['hire_detail']['all'][] = $person_data;
			}
		}	 
	
		// Flatten the mapped data to the required structure
		$result['detail'] = array_values($mapped_data);
		
		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_chart_G3

	/*
	* get_HRM_chart_G4
	* ดึงข้อมูลกราฟ SEE-HRM-G4
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 04/07/2024
	*/
	public function get_HRM_chart_G4(){
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// Get summary chart data
		$chart_data = $this->Personal_dashboard_model->get_HRM_chart_G4($dp_id, $year_type, $year)->result();
		// Get detailed personnel data
		$person_detail_data = $this->Personal_dashboard_model->get_HRM_chart_G4_detail($dp_id, $year_type, $year)->result();
	
		// Define all possible expiration periods
		$all_periods = [
			'ไม่มีข้อมูล', 
			'หมดอายุแล้ว', 
			'หมดภายใน 3 เดือน',
			'หมดภายใน 6 เดือน',
			'หมดภายใน 9 เดือน',
			'หมดภายใน 1 ปี',
			'หมดภายใน 2 ปี',
			'หมดภายใน 3 ปี',
			'มากกว่า 3 ปี'
		];
	
		// Initialize result structure
		$result['chart'] = [];
		foreach ($all_periods as $period) {
			$result['chart'][$period] = [];
		}
	
		// Fill data with actual query chart_data
		foreach ($chart_data as $row) {
			$result['chart'][$row->expiration_period][] = [
				'vocation_name' => $row->vocation_name,
				'person_count' => $row->person_count
			];
		}
	
		// Ensure every period has entries for each vocation type
		$voc_names = array_unique(array_map(function($item) { return $item->vocation_name; }, $chart_data));
		foreach ($result['chart'] as $period => &$entries) {
			foreach ($voc_names as $voc_name) {
				$found = false;
				foreach ($entries as $entry) {
					if ($entry['vocation_name'] == $voc_name) {
						$found = true;
						break;
					}
				}
				if (!$found) {
					$entries[] = ['vocation_name' => $voc_name, 'person_count' => 0];
				}
			}
			// Sort entries to ensure 'ไม่มีข้อมูล' is last
			usort($entries, function($a, $b) {
				if ($a['vocation_name'] == 'ไม่มีข้อมูล') return 1;
				if ($b['vocation_name'] == 'ไม่มีข้อมูล') return -1;
				return strcmp($a['vocation_name'], $b['vocation_name']);
			});
		}
	
		// Prepare the data in the required format
		$mapped_data = [];
		foreach ($person_detail_data as $row) {
			$period = $row->expiration_period;
			if (!isset($mapped_data[$period])) {
				$mapped_data[$period] = [
					'vocation' => $row->vocation_name,
					'person_list' => []
				];
			}
			if ($row->licn_start_date != null || $row->licn_end_date != null) {
				$row->licn_start_date = abbreDate2($row->licn_start_date);
				$row->licn_end_date = abbreDate2($row->licn_end_date);
			}
			else{
				$row->licn_start_date = "";
				$row->licn_end_date = "";
			}
			$mapped_data[$period]['person_list'][] = $row;
		}
	
		// Attach detailed data to the result
		$result['detail'] = $mapped_data;

		// pre($result['detail']);
	
		// Return the result as JSON
		echo json_encode($result);
	}
	// get_HRM_chart_G4

		/*
	* get_HRM_chart_G5
	* ดึงข้อมูลกราฟ SEE-HRM-G5
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 08/07/2024
	*/
	public function get_HRM_chart_G5() {
		$dp_id = $this->input->get('dp_id');
		$year_type = $this->input->get('year_type');
		$year = $this->input->get('year');
	
		// Fetch chart data
		$result['chart'] = $this->Personal_dashboard_model->get_HRM_chart_G5($dp_id, $year_type, $year)->result();
		
		// Fetch detailed data
		$g5_detail = $this->Personal_dashboard_model->get_HRM_chart_G5_detail($dp_id, $year_type, $year)->result();
	
		// Define age groups and genders
		$age_groups = ["น้อยกว่า 30 ปี", "31 ปี - 40 ปี", "41 ปี - 50 ปี", "51 ปี - 60 ปี", "60 ปีขึ้นไป"];
		$genders = ["ชาย", "หญิง"];
	
		// Initialize result structure
		$group = [];
		foreach ($age_groups as $age_group) {
			$group[$age_group] = [
				'age_group' => $age_group,
				'genders' => []
			];
			foreach ($genders as $gender) {
				$group[$age_group]['genders'][$gender] = [];
			}
		}
	
		// Fill data with actual query result
		foreach ($g5_detail as $row) {
			$age_group = $row->age_group;
			$gender_name = $row->gender_name;
			$row->birthdate = $row->birthdate ? abbreDate2($row->birthdate) : "";
			unset($row->age_group);
			unset($row->gender_name);
			$group[$age_group]['genders'][$gender_name][] = $row;
		}
	
		$result['detail'] = array_values($group);
	
		// Return the result as JSON
		echo json_encode($result);
	}
	
	// get_HRM_chart_G5

}
