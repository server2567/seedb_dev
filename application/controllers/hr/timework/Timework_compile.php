<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_compile extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Timework_compile/";
		$this->view .= "timework_compile/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_timework_person_compile');

		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของประมวลผลการลงเวลาทำงาน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->load->model('ums/M_ums_department');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['dp_info'] = $this->M_ums_department->get_all()->result(); // ดึงข้อมูลแผนกทั้งหมด
		
		$this->output($this->view.'v_timework_compile_list', $data);
		
	}
	// index

	/*
	* get_timework_compile_list
	* ข้อมูลรายการเวลาเข้างานบุคลากรตาม filter
	* @input dp_id, hire_is_medical, hire_type_id, pos_status, start_date, end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	public function get_timework_compile_list()
	{
		$dp_id = $this->input->post('dp_id');
		$hire_is_medical = $this->input->post('hire_is_medical');
		$hire_type = $this->input->post('hire_type');
		$status_id = $this->input->post('status_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');

		// ดึงข้อมูลสถานะจาก Model
		$statuses = $this->M_hr_timework_person_compile->get_timework_status_by_group_and_parent($dp_id, $hire_is_medical, $hire_type, $status_id, $month, $year);

		
		
		// ดึงข้อมูลบุคลากรตามฟิลเตอร์
		$person_data = $this->M_hr_timework_person_compile->get_all_timework_compile_data_by_param(
			$dp_id, $hire_is_medical, $hire_type, $status_id
		);

		foreach($person_data->result() as $key=>$row){
			$this->M_hr_timework_person_compile->insert_missing_timework($row->ps_id, $month, $year);
		}

		// ดึงข้อมูลบุคลากรตามฟิลเตอร์
		$person_data = $this->M_hr_timework_person_compile->get_all_profile_data_by_param(
			$dp_id, $hire_is_medical, $hire_type, $status_id, $month, $year
		);

		// เริ่มต้นค่า $ps_id_temp เป็นค่าว่าง
		$ps_id_temp = "";
		$ps_id_encrypted = "";
		foreach ($person_data->result() as $key => $row) {
			// ตรวจสอบว่า ps_id ซ้ำกับ ps_id ก่อนหน้านี้หรือไม่
			if ($row->ps_id != $ps_id_temp) {
				$ps_id_temp = $row->ps_id;
				// ถ้าไม่ซ้ำ ให้ทำการเข้ารหัสใหม่ และบันทึก ps_id เข้ารหัสไว้ในตัวแปรชั่วคราว
				$ps_id_encrypted = encrypt_id($row->ps_id);
			}

			// ใช้ ps_id ที่เข้ารหัสไว้แล้ว (ไม่ต้องเข้ารหัสใหม่ในกรณีที่ ps_id ซ้ำ)
			$row->ps_id = $ps_id_encrypted;
		}

		echo json_encode([
			'statuses' => $statuses,
			'data' => $person_data->result()
		]);
	}
	// get_timework_compile_list

	/*
	* get_timework_compile_list
	* ประมวลผลการทำงานรายบุคคล
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/10/2024
	*/
	function get_timework_compile_user($ps_id){
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
		$this->load->model($this->config->item('ums_dir') . 'M_ums_department');

		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$ps_id = decrypt_id($ps_id);
		$data['ps_id'] = $ps_id;
		$data['encrypt_ps_id'] = encrypt_id($ps_id);
		$data['view_dir'] = $this->view;
		
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['row_education'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
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

		$this->output($this->view . 'v_timework_compile_person', $data);
	}


	
	
}
