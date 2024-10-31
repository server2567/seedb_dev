<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
// include_once(dirname(__FILE__)."/../seedb_model.php");
// class TestChartController extends seedb_model
// include_once(dirname(__FILE__)."/seedb_model.php");
// class TestChartController
class TestChartController extends UMS_Controller
{
	protected $view;
	protected $model;
	protected $controller; 

	public $hr;
	public $hr_db;

	public function __construct()
	{
        parent::__construct();
		$this->controller .= "Personal_dashboard/";
		$this->mn_active_url = uri_string();

		// $this->view = $this->config->item('seedb_dir');
		// $this->model = $this->config->item('seedb_dir');

		// load model
		$this->load->model($this->config->item('hr_dir').'M_hr_person');
		// $this->load->model($this->model.'Personal_dashboard_model');
		$this->load->model('seedb/hr/Personal_dashboard_model');
		// $this->load->model($this->model.'/hr/Personal_dashboard_model');


		// $this->load->model('seedb/seedb_model');
		$this->hr = $this->load->database('hr', TRUE);
		$this->hr_db = $this->hr->database;
		
    }

	function index() {
		echo $this->model.'Personal_dashboard_model';
	}

	function testchart() {
		// echo "x";
		// $this->load->view('v_testchart.php');
		
		
		// $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		// $data['status_response'] = $this->config->item('status_response_show');
		// $data['view_dir'] = $this->view;
		// $data['controller_dir'] = $this->controller;
		$data['ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();

		$currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543; 	
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;

		$this->output('testchart/main', $data);
	}

	function getChart1API() {
		$dp_id = $this->input->get('dp_id');
		$year = $this->input->get('year');

		// $result = new stdClass();

		// $result->dp_id = $dp_id;
		// $result->year = $year;

		// echo json_encode($result);

		$startDate = "$year-01-01";
		$endDate = "$year-12-31";

		$dateFilter = "AND (
			(history.hipos_start_date <= '$endDate' AND (history.hipos_end_date >= '$startDate' OR history.hipos_end_date IS NULL OR history.hipos_end_date = '9999-12-31'))
		)";

		// $result = $this->hr->query("SELECT *, COUNT(DISTINCT edu_ps_id) FROM hr_person_education WHERE edu_highest = 'Y' GROUP BY edu_edulv_id"); 
		// $result = $this->hr->query("SELECT *, COUNT(DISTINCT edu_ps_id) FROM hr_person_education INNER JOIN hr_person_position WHERE edu_highest = 'Y' AND pos_dp_id = ? GROUP BY edu_edulv_id", array($dp_id)); 
		// $result = $this->hr->query("SELECT *, COUNT(DISTINCT edu_ps_id) FROM hr_person_education INNER JOIN hr_person_position ON hr_person_education.edu_ps_id = hr_person_position.pos_ps_id INNER JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id WHERE edu_highest = 'Y' AND pos_dp_id = ? GROUP BY hire_is_medical, edu_edulv_id;", array($dp_id)); 
		// $result = $this->hr->query("SELECT *, COUNT(DISTINCT edu_ps_id) FROM hr_person_education INNER JOIN hr_person_position ON hr_person_education.edu_ps_id = hr_person_position.pos_ps_id INNER JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id INNER JOIN hr_person_position_history ON hr_person_education.edu_ps_id = hr_person_position_history.hipos_ps_id WHERE edu_highest = 'Y' AND pos_dp_id = 1 AND (
		// 	(history.hipos_start_date <= ? AND (history.hipos_end_date >= ? OR history.hipos_end_date IS NULL OR history.hipos_end_date = '9999-12-31'))
		// ) GROUP BY hire_is_medical, edu_edulv_id", array($startDate, $endDate)); 
		$result = $this->hr->query("SELECT *, COUNT(DISTINCT edu_ps_id) FROM hr_person_education INNER JOIN hr_person_position ON hr_person_education.edu_ps_id = hr_person_position.pos_ps_id INNER JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id INNER JOIN hr_person_position_history ON hr_person_education.edu_ps_id = hr_person_position_history.hipos_ps_id WHERE edu_highest = 'Y' AND pos_dp_id = 1 AND ( (hr_person_position_history.hipos_start_date <= '2024-01-01' AND (hr_person_position_history.hipos_end_date >= ? OR hr_person_position_history.hipos_end_date IS NULL OR hr_person_position_history.hipos_end_date = ?)) ) GROUP BY hire_is_medical, edu_edulv_id; ", array($startDate, $endDate)); 
		
		$result = $result->result_array();

		// $countUngratuatedBachelor = 0;
		// $countGratuatedBachelor = 0;

		// foreach ($result as $r) {
		// 	if ((int)($r['edu_edulv_id']) >= 11) {
		// 		$countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
		// 	} else {
		// 		$countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
		// 	}
		// }

		$medicalDataArray = ["M"=> "สายการแพทย์", "N"=> "สายพยาบาล", "S"=> "สายสนับสนุน", "SM"=> "สายสนับสนุนทางการแพทย์", "T"=> "สายเทคนิคและบริการ", "A"=> "สายบริหาร" ];

		$countPerson = new stdClass();
		$M = new stdClass();
		$N = new stdClass();
		$S = new stdClass();
		$SM = new stdClass();
		$T = new stdClass();
		$A = new stdClass();

		$M->countGratuatedBachelor = 0;
		$M->countUngratuatedBachelor = 0;
		
		$N->countGratuatedBachelor = 0;
		$N->countUngratuatedBachelor = 0;
		
		$S->countGratuatedBachelor = 0;
		$S->countUngratuatedBachelor = 0;
		
		$SM->countGratuatedBachelor = 0;
		$SM->countUngratuatedBachelor = 0;
		
		$T->countGratuatedBachelor = 0;
		$T->countUngratuatedBachelor = 0;
		
		$A->countGratuatedBachelor = 0;
		$A->countUngratuatedBachelor = 0;

		$countPerson->M = $M;
		$countPerson->N = $N ;
		$countPerson->S = $S ;
		$countPerson->SM = $SM;
		$countPerson->T = $T ;
		$countPerson->A = $A ;
		
		// echo json_encode($result->row());


		foreach ($result as $r) {
			if ((int)($r['edu_edulv_id']) >= 11) {

				if ($r['hire_is_medical'] == 'M') {
					$countPerson->M->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'N') {
					$countPerson->N->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'S') {
					$countPerson->S->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				
				} else if ($r['hire_is_medical'] == 'SM') {
					$countPerson->SM->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				
				} else if ($r['hire_is_medical'] == 'T') {
					$countPerson->T->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'A') {
					$countPerson->A->countGratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				}

			} else {

				if ($r['hire_is_medical'] == 'M') {
					$countPerson->M->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'N') {
					$countPerson->N->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'S') {
					$countPerson->S->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				
				} else if ($r['hire_is_medical'] == 'SM') {
					$countPerson->SM->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				
				} else if ($r['hire_is_medical'] == 'T') {
					$countPerson->T->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);

				} else if ($r['hire_is_medical'] == 'A') {
					$countPerson->A->countUngratuatedBachelor += (int)($r['COUNT(DISTINCT edu_ps_id)']);
				}
			}
		}
		
		// print_r($result);
		// echo $result;
		// echo json_encode($result);
		// echo json_encode(array($countGratuatedBachelor, $countUngratuatedBachelor));

		$finalResult = array($medicalDataArray, $countPerson);
		echo json_encode($finalResult);

		
	}

}
?>    