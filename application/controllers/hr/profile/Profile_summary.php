<?php
/*
* Profile_summary
* Controller หลักของประวัติข้อมูลบุคลากร
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 04/06/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Profile_Controller.php');

class Profile_summary extends Profile_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Profile_summary/";
		$this->load->model($this->model . 'M_hr_person');
		$this->load->model($this->model . 'm_hr_order_person');
		$this->load->model($this->model . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_person_work_history');
		$this->load->model($this->model . 'M_hr_person_reward');
		$this->load->model($this->model . 'M_hr_person_external_service');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของประวัติข้อมูลบุคลากร
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 04/06/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
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

		$this->output($this->view . 'v_profile_summary_list', $data);
	}
	// index

	/*
	* get_profile_summary
	* หน้าจอประวัติข้อมูลบุคลากร
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 04/06/2024
	*/
	public function get_profile_summary($ps_id = "")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;

		$this->M_hr_person->ps_id = $data['ps_id'];
		$this->M_hr_person_position->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person_position->get_person_ums_department_by_ps_id()->result();
		$addr = $this->M_hr_person->get_addhome_addr($data['row_profile']->psd_addhome_pv_id, $data['row_profile']->psd_addhome_amph_id, $data['row_profile']->psd_addhome_dist_id)->row();
		$data['row_profile']->home_pv_name = isset($addr) ? $addr->pv_name : null;
		$data['row_profile']->ps_id = encrypt_id($data['row_profile']->ps_id);
		$data['row_profile']->home_amph_name = isset($addr) ? $addr->amph_name : null;
		$data['row_profile']->home_dist_name = isset($addr) ? $addr->dist_name : null;
		$position_department_array = array();
		foreach ($data['person_department_topic'] as $row) {
			$array_tmp = $this->M_hr_person_position->get_person_position_by_ums_department_detail($data['ps_id'], $row->dp_id)->row();
			$position_department_array[$row->dp_id] = $array_tmp;
		}

		$data['base_adline_position_list'] = $this->M_hr_person->get_hr_base_adline_position_data()->result();
		$data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();
		$data['base_special_position_list'] = $this->M_hr_person->get_hr_base_special_position_data()->result();
		$data['base_hire_list'] = $this->M_hr_person->get_hr_base_hire_type_data()->result();
		$data['base_retire_list'] = $this->M_hr_person->get_hr_base_retire_data()->result();

		$data['add_department_list'] = $this->M_hr_person_position->get_department_not_in_by_ps_id($data['ps_id']);

		$data['person_department_detail'] = $position_department_array;
		foreach ($data['person_department_detail'] as $key => $value) {
			$value->admin_po = $this->M_hr_person_position->get_admin_position_by_group($value->pos_admin_id)->result();
			$value->spcl_po = $this->M_hr_person_position->get_special_position_by_group($value->pos_spcl_id)->result();
		}
		$data['person_work_history_list'] = $this->M_hr_person_work_history->get_all_person_work_history_data($data['ps_id'])->result();
		foreach ($data['person_work_history_list'] as $key => $row) {
			$row->wohr_start_date = $this->format_date($row->wohr_start_date);
			if ($row->wohr_end_date == "9999-12-31") {
				$row->wohr_end_date = "ปัจจุบัน";
			} else {
				$row->wohr_end_date = $this->format_date($row->wohr_end_date);
			}
		}
		$data['person_external_service_list'] = $this->M_hr_person_external_service->get_all_external_service_data($ps_id)->result();
		foreach ($data['person_external_service_list'] as $key => $row) {
			$row->pexs_id = encrypt_id($row->pexs_id);
			$row->pexs_date = abbreDate2($row->pexs_date);
		}
		$data['person_reward_list'] = $this->M_hr_person_reward->get_year_reward($ps_id)->result();
		foreach ($data['person_reward_list'] as $key => $row) {
			$row->reward_detail = $this->M_hr_person_reward->get_reward_by_year($ps_id, $row->rewd_year);
			if ($row->reward_detail->num_rows() > 0) {
				foreach ($row->reward_detail->result() as $rewd) {
					$rewd->rewd_date = ($rewd->rewd_date == "0000-00-00" ? date('d/m/Y', strtotime($rewd->rewd_end_date . ' +543 years')) : date('d/m/Y', strtotime($rewd->rewd_date . ' +543 years')));
				}
			}
			$row->reward_detail = $row->reward_detail->result();
		}
		foreach ($data['person_department_topic'] as $key => $dp_info) {
			$data['person_position_info'][$dp_info->dp_id] = $this->M_hr_person_position->get_person_position_by_ums_department_detail($ps_id, $dp_info->dp_id)->row();
			foreach ($data['person_position_info'] as $key => $po_info) {
				if ($po_info->pos_admin_id != null) {
					$po_info->admin_po = $this->M_hr_person_position->get_admin_position_by_group($po_info->pos_admin_id)->result();
				} else {
					$po_info->admin_po = [];
				}
				if ($po_info->pos_spcl_id != null) {
					$po_info->spcl_po = $this->M_hr_person_position->get_special_position_by_group($po_info->pos_spcl_id)->result();
				} else {
					$po_info->pos_spcl_id = [];
				}
			}
		}
		$data['person_education_info'] = $this->M_hr_person->get_person_education_by_id()->result();
		// pre($data);
		$this->output($this->view . 'v_profile_summary_form', $data);
	}
	// get_profile_summary
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
		// pre($this->session->userdata('hr_hire_is_medical'));
		$admin_id = $this->input->get('admin_id');
		$hire_id = $this->input->get('hire_id');
		$status_id = $this->input->get('status_id');
		$result = $this->M_hr_person->get_all_profile_data($dp_id, $admin_id, $hire_id, $status_id)->result();
		foreach ($result as $key => $row) {
			$array = array();
			$row->ps_id = encrypt_id($row->ps_id);
			$admin_name = json_decode($row->admin_position, true);
			if ($admin_name) {
				foreach ($admin_name as $value) {
					if(is_string($value)){$value = json_decode($value,true);}
					if ($value['admin_name']) {
						$array[] = $value['admin_name'];
					}
				}
				$row->admin_position = $array;
			} else {
				empty($row->admin_position);
			}
		}
		echo json_encode($result);
	}
	// get_profile_user_list


}
