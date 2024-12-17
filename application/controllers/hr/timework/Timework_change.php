<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_change extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Timework_change/";
		$this->view .= "timework_change/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_timework_person_plan');
		$this->load->model($this->model . 'M_hr_timework_request_change');
		$this->load->model($this->model . 'M_hr_timework_request_change_history');


		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของเปลี่ยนตารางวันทำงาน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 05/11/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');

		$data['ps_id'] = $this->session->userdata('us_ps_id');
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
		
		$this->output($this->view.'v_timework_change_list', $data);
		
	}
	// index

	/*
	* get_timework_change_list_by_param
	* แสดงรายการเปลี่ยนตารางวันทำงาน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 05/11/2567
	*/
	function get_timework_change_list_by_param(){
		$ps_id = decrypt_id($this->input->post('ps_id'));
		$start_date = splitDateForm1($this->input->post('start_date'));
		$end_date = splitDateForm1($this->input->post('end_date'));
		$result = $this->M_hr_timework_request_change->get_timework_change_all_by_param($this->session->userdata('us_ps_id'), $this->input->post('twrc_type'), $this->input->post('status'), $start_date, $end_date)->result();
		
		foreach($result as $key=>$row){
			$row->twrc_id = encrypt_id($row->twrc_id);
			$row->twrc_ps_id = encrypt_id($row->twrc_ps_id);
			$row->twpp_start_date = abbreDate2($row->twpp_start_date);
			$row->twpp_end_date = abbreDate2($row->twpp_end_date);
			$row->twrc_start_date = abbreDate2($row->twrc_start_date);
			$row->twrc_end_date = abbreDate2($row->twrc_end_date);
		}

		echo json_encode($result);
	}
	// get_timework_change_list_by_param


	function timework_change_insert($ps_id){
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$data['ps_id'] = decrypt_id($ps_id);
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();

		
		$this->output($this->view.'v_timework_change_insert', $data);
	}

		/*
	* get_eqs_building_list
	* ดึงข้อมูลข้อมูลสิ่งก่อสร้าง/อาคาร
	* @input -
	* $output eqs building data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_eqs_building_list()
	{
		$result = $this->M_hr_timework_person_plan->get_eqs_building_data($this->input->get('dp_id'))->result();
		echo json_encode($result);
	}
	// get_eqs_building_list

	/*
	* get_eqs_room_list
	* ดึงข้อมูลสิ่งก่อสร้าง/อาคาร
	* @input bd_id
	* $output eqs room data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/09/2024
	*/
	function get_eqs_room_list()
	{
		$bd_id = $this->input->get('bd_id');
		$result['rooms'] = $this->M_hr_timework_person_plan->get_eqs_room_data($bd_id)->result();
		$result['building_type'] = $this->M_hr_timework_person_plan->get_eqs_building_type_data()->result();
		echo json_encode($result);
	}
	// get_eqs_room_list

	
}
