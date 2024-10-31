<?php 
/*
* System
* Main controller of Dashboard
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 01/07/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class Dashboard extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of Dashboard
	* @input -
	* $output screen of logs each systems per month and per year
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	public function index($startDate="", $endDate="") {
		$this->load->model('ums/m_ums_user_logs_menu');
		$logs_systems_by_month = $this->m_ums_user_logs_menu->get_logs_all_system('per_month', date("Y"))->result_array();
		$logs_systems_by_year = $this->m_ums_user_logs_menu->get_logs_all_system('per_year', date("Y"))->result_array();
		
		$logs_systems_by_month = $this->Dashboard_set_logs_systems_by_month($logs_systems_by_month);
		
		$this->load->model('ums/m_ums_user');
		$data['rpt_count_users'] = $this->m_ums_user->get_count_all_user_active()->row()->count_us_id;

		$this->load->model('ums/m_ums_usergroup');
		$rpt_users_systems = $this->m_ums_usergroup->get_users_each_group()->result_array();

		// encrypt id
		$names = ['st_id']; // object name need to encrypt 
		$data['logs_systems_by_month'] = encrypt_arr_obj_id($logs_systems_by_month, $names);
		$data['logs_systems_by_year'] = encrypt_arr_obj_id($logs_systems_by_year, $names);
		$data['rpt_users_systems'] = encrypt_arr_obj_id($rpt_users_systems, $names);

		$data['year'] = date("Y");

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/dashboard/v_dashboard_dashboard',$data);
	}

	/*
	* Dashboard_detail_logs_system
	* for get detail of logs in system that select from client, so, show detail per month and per year
	* @input st_id(system id)
	* $output screen of detail of logs in system per month and per year
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	public function Dashboard_detail_logs_system($year, $st_id) {
		$data['year'] = $year;
		$data['st_id'] = $st_id;
		$st_id = decrypt_id($st_id);

		$this->load->model('ums/m_ums_user_logs_menu');
		$logs_systems_by_month = $this->m_ums_user_logs_menu->get_logs_all_system('per_month', $year, $st_id)->result_array();
		$logs_systems_by_year = $this->m_ums_user_logs_menu->get_logs_all_system('per_year', $year, $st_id)->result_array();
		$logs_detail_by_year = $this->m_ums_user_logs_menu->get_logs_detail_system($year, $st_id)->result_array();

		$logs_systems_by_month = $this->Dashboard_set_logs_systems_by_month($logs_systems_by_month);

		// encrypt id
		$names = ['st_id']; // object name need to encrypt 
		$data['logs_systems_by_month'] = encrypt_arr_obj_id($logs_systems_by_month, $names);
		$data['logs_systems_by_year'] = encrypt_arr_obj_id($logs_systems_by_year, $names);
		$data['logs_detail_by_year'] = encrypt_arr_obj_id($logs_detail_by_year, $names);
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/dashboard/v_dashboard_detail_logs_system_dashboard',$data);
	}

	/*
	* Dashboard_detail_group_system
	* detail about users each group in system
	* @input st_id(system id)
	* $output screen of detail about users each group in system
	* @author Areerat Pongurai
	* @Create Date 02/07/2024
	*/
	public function Dashboard_detail_group_system($st_id) {
		$data['st_id'] = $st_id;
		$st_id = decrypt_id($st_id);

		$this->load->model('ums/m_ums_usergroup');
		$data['rpt_users_groups_system'] = $this->m_ums_usergroup->get_users_each_group_detail($st_id)->result_array();
		
		// Extract the 'gp_id' values from the array of objects
		$gp_ids = array_map(function($obj) { return $obj['gp_id']; }, $data['rpt_users_groups_system']);

		// Get the unique 'gp_id' values
		$unique_gp_ids = array_unique($gp_ids);

		// Filter the original array to include only unique objects based on 'gp_id'
		$unique_objects = [];
		foreach ($unique_gp_ids as $gp_id) {
			foreach ($data['rpt_users_groups_system'] as $obj) {
				if ($obj['gp_id'] == $gp_id) {
					$unique_objects[] = $obj;
					break; // Break to ensure only the first occurrence is taken
				}
			}
		}
		$data['unique_groups'] = $unique_objects;

		// // encrypt id
		// $names = ['st_id']; // object name need to encrypt 
		// $data['rpt_users_groups_system'] = encrypt_arr_obj_id($rpt_users_groups_system, $names);
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/dashboard/v_dashboard_detail_user_group_dashboard',$data);
	}

	/*
	* Dashboard_get_data_logs_systems
	* for get logs each systems per month and per year by year that select from client
	* @input year
	* $output logs each systems per month and per year
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	public function Dashboard_get_data_logs_systems() {
		$year = $this->input->post('year');
		$st_id = $this->input->post('st_id');
		$st_id = decrypt_id($st_id);

		$this->load->model('ums/m_ums_user_logs_menu');
		$logs_systems_by_month = $this->m_ums_user_logs_menu->get_logs_all_system('per_month', $year, $st_id)->result_array();
		$logs_systems_by_year = $this->m_ums_user_logs_menu->get_logs_all_system('per_year', $year, $st_id)->result_array();

		$logs_systems_by_month = $this->Dashboard_set_logs_systems_by_month($logs_systems_by_month);
		
		// encrypt id
		$names = ['st_id']; // object name need to encrypt 
		$data['logs_systems_by_month'] = encrypt_arr_obj_id($logs_systems_by_month, $names);
		$data['logs_systems_by_year'] = encrypt_arr_obj_id($logs_systems_by_year, $names);

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* Dashboard_set_logs_systems_by_month
	* for set logs in system(from query) for series show in chart
	* @input logs_systems_by_month
	* $output data series show in chart
	* @author Areerat Pongurai
	* @Create Date 01/07/2024
	*/
	private function Dashboard_set_logs_systems_by_month($data) {
		$series = [];
		if (!empty($data) && count($data) > 0) {
			// Get unique st_id values
			$unique_st_ids = array_unique(array_column($data, 'st_id'));
		
			foreach ($unique_st_ids as $st) {
				// Get all months and count by st_id
				$count_per_month_and_st_arr = [];
				foreach ($data as $item) {
					if ($st == $item['st_id']) {
						$count_per_month_and_st_arr[] = [
							'month' => intval($item['log_month']),
							'count' => intval($item['ums_log_count'])
						];
					}
				}
		
				// Initialize an array to hold counts for each month
				$count_per_month_arr = array_fill(0, 12, null);
		
				// Loop through all months in 1 year
				for ($i = 1; $i <= 12; $i++) {
					$count = null;
					foreach ($count_per_month_and_st_arr as $monthData) {
						if ($monthData['month'] === $i) {
							$count = $monthData['count'];
							break;
						}
					}
					$count_per_month_arr[$i - 1] = $count;
				}
		
				// Assuming system object can be derived from st_id or fetched from data
				foreach ($data as $item) {
					if ($item['st_id'] === $st) {
						$system = $item;
						break;
					}
				}
		
				$series[] = [
					'name' => $system['st_name_th'],
					'data' => $count_per_month_arr,
					'visible' => true
				];
			}
		} else {
			// If data is null or empty, provide a default series
			$series[] = [
				'name' => '',
				'data' => array_fill(0, 12, null), // 12 months with no data
				'visible' => true,
				'showInLegend' => false // Hide this series in the legend
			];
		}
		return $series;
	}
}
?>
