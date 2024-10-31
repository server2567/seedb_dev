<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_QUE_Controller.php");
class Que_dashboard extends SEEDB_QUE_Controller
{
	public function __construct()
	{
		parent::__construct();
    // load model
		$this->load->model($this->config->item('hr_dir').'M_hr_person');
		$this->load->model($this->model.'Que_dashboard_model');
	}

	public function index() {
    $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$data['view_dir'] = $this->view;
	$data['controller_dir'] = $this->controller;
    $data['ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
	$activities = $this->Que_dashboard_model->get_last_activity(8)->result_array();
    // Loop through the activity data and calculate the time difference
    foreach ($activities as &$activity) {
        if (!empty($activity['ntdp_time_start'])) {
            $ntdp_time_start = new DateTime($activity['ntdp_time_start']);
            $current_time = new DateTime();
            $interval = $current_time->diff($ntdp_time_start);

            // Calculate total minutes and hours
            $total_minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
            $total_hours = floor($total_minutes / 60);

            // Determine how to display the time difference
            if ($total_hours >= 1) {
                $activity['time_difference'] = $total_hours . ' ชั่วโมง';
            } else {
                $activity['time_difference'] = $total_minutes . ' นาที';
            }
        } else {
            $activity['time_difference'] = 'No Start Time';
        }
    }
	

    // Assign the modified activities to the data array
    $data['activity'] = $activities;
	$data['count_all_que'] = $this->Que_dashboard_model->count_all_que()->row_array();
	$data['count_all_que_old'] = $this->Que_dashboard_model->count_all_que(null,'old')->row_array();
	$data['count_all_que_new'] = $this->Que_dashboard_model->count_all_que(null,'new')->row_array();
	$data['count_all_que_A'] = $this->Que_dashboard_model->count_all_que('A')->row_array();
	$data['count_all_que_A_old'] = $this->Que_dashboard_model->count_all_que('A','old')->row_array();
	$data['count_all_que_A_new'] = $this->Que_dashboard_model->count_all_que('A','new')->row_array();
	$data['count_all_que_W'] = $this->Que_dashboard_model->count_all_que('W')->row_array();
	$data['count_all_que_W_old'] = $this->Que_dashboard_model->count_all_que('W','old')->row_array();
	$data['count_all_que_W_new'] = $this->Que_dashboard_model->count_all_que('W','new')->row_array();
	
		$currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543;
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;
    
    $this->output($this->view.'v_seedb_que',$data);
  }

}
