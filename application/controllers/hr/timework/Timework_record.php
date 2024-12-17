<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_record extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Timework_record/";
		$this->view .= "timework_record/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_timework_person_record');

		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของจัดการลงเวลาการทำงาน
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
		
		$this->output($this->view.'v_timework_record_list', $data);
		
	}
	// index

	/*
	* check_validate_data
	* ตรวจสอบข้อมูลการนำเข้าข้อมูลด้วย excel
	* @input machine_code, pos_ps_code
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	function check_validate_data(){
		$result = $this->M_hr_timework_person_record->get_person_matching_code($this->input->post('machine_code'), $this->input->post('pos_ps_code'))->row()->count_data;
		echo json_encode($result);
	}
	// check_validate_data

	/*
	* timework_record_import_excel_save
	* บันทึกข้อมูลการนำเข้าข้อมูลด้วย excel
	* @input 
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	function timework_record_import_excel_save(){
		$record_data = $this->input->post('record_data');

		if (!empty($record_data)) {

			// วนลูปข้อมูลเพื่อเตรียมบันทึกลงฐานข้อมูล
			foreach ($record_data as $sheet_name => $records) {
				foreach ($records as $key => $record) {

					$this->M_hr_timework_person_record->twpc_mc_code = $record['machineCode'];
					$this->M_hr_timework_person_record->twpc_ps_code = $record['employeeCode'];
					$this->M_hr_timework_person_record->twpc_date = $this->splitDate_excel($record['date']);
					$this->M_hr_timework_person_record->delete();

					// ตรวจสอบว่ามีคีย์ 'times' อยู่ในแต่ละ record หรือไม่
					if (isset($record['times']) && is_array($record['times']) && !empty($record['times'])) {
						// วนลูปข้อมูล times เพื่อเก็บทีละรายการลงฐานข้อมูล
						foreach ($record['times'] as $time) {
							// แปลงเวลาเป็นรูปแบบ 24 ชั่วโมง (H:i)
							$time_24h = date('H:i', strtotime($time));

							// ตรวจสอบว่ามีข้อมูลอยู่ในฐานข้อมูลหรือไม่
							
							$this->M_hr_timework_person_record->twpc_time = $time_24h;
							$this->M_hr_timework_person_record->twpc_create_user = $this->session->userdata('us_id');
							$this->M_hr_timework_person_record->twpc_create_date = date('Y-m-d H:i:s');
							$this->M_hr_timework_person_record->insert();
						}
					} 
				}
			}

			$result['status_response'] = $this->config->item('status_response_success');
			$result['message_dialog'] = $this->config->item('text_toast_default_success_body');
		} else {
			$result['status_response'] = $this->config->item('status_response_error');
			$result['message_dialog'] = $this->config->item('text_toast_default_error_body');
		}

		// ส่งผลลัพธ์กลับเป็น JSON
		echo json_encode($result);
	}
	// timework_record_import_excel_save
	function splitDate_excel($date, $sp = "-")
	{
		list($mm, $dd, $yy) = preg_split("[/|-]", $date);
		return $yy . $sp . $mm . $sp . $dd;
	}

	/*
	* get_timework_record_list
	* ข้อมูลรายการเวลาเข้างานบุคลากรตาม filter
	* @input dp_id, hire_is_medical, hire_type_id, pos_status, start_date, end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	public function get_timework_record_list()
	{
		$result = $this->M_hr_timework_person_record->get_all_profile_data_by_param($this->input->post('dp_id'), $this->input->post('hire_is_medical'), $this->input->post('hire_type'), $this->input->post('status_id'), $this->input->post('start_date'), $this->input->post('end_date'))->result();

		// เริ่มต้นค่า $ps_id_temp เป็นค่าว่าง
		$ps_id_temp = "";
		$ps_id_encrypted = "";
		foreach ($result as $key => $row) {
			// ตรวจสอบว่า ps_id ซ้ำกับ ps_id ก่อนหน้านี้หรือไม่
			if ($row->ps_id != $ps_id_temp) {
				$ps_id_temp = $row->ps_id;
				// ถ้าไม่ซ้ำ ให้ทำการเข้ารหัสใหม่ และบันทึก ps_id เข้ารหัสไว้ในตัวแปรชั่วคราว
				$ps_id_encrypted = encrypt_id($row->ps_id);
			}

			// ใช้ ps_id ที่เข้ารหัสไว้แล้ว (ไม่ต้องเข้ารหัสใหม่ในกรณีที่ ps_id ซ้ำ)
			$row->ps_id = $ps_id_encrypted;

			// เข้ารหัส twpc_id ปกติ
			$row->twpc_id = encrypt_id($row->twpc_id);

			// แปลงวันที่เป็นรูปแบบย่อ
			$row->twpc_date_text = abbreDate2($row->twpc_date);
		}

		
		echo json_encode($result);
	}
	// get_timework_record_list

	/*
	* get_timework_record_by_person_id
	* ข้อมูลรายการเวลาเข้างานบุคลากรตาม filter
	* @input dp_id, hire_is_medical, hire_type_id, pos_status, start_date, end_date, ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	public function get_timework_record_by_person_id()
	{
		$result = $this->M_hr_timework_person_record->get_all_profile_data_by_ps_id(decrypt_id($this->input->post('ps_id')), $this->input->post('start_date'), $this->input->post('end_date'))->result();
		foreach ($result as $key => $row) {
			// เข้ารหัสค่า ps_id และ twpc_id
			$row->ps_id = encrypt_id($row->ps_id);
			$row->twpc_id = encrypt_id($row->twpc_id);
		
			// แปลงวันที่เป็นรูปแบบย่อ
			$row->twpc_date_text = abbreDate2($row->twpc_date);
		}
		
		echo json_encode($result);
	}
	// get_timework_record_by_person_id

	/*
	* preview_timework_record_person
	* หน้าจอรายงานภาพรวมการเข้างานเวลาทำงานรายคน
	* @input $ps_id, $start_date, $end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 18/10/2024
	*/
	function preview_timework_record_person($ps_id,$start_date, $end_date)
	{
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
		// $data['filter_start_date'] = $start_date;
		// $data['filter_end_date'] = $end_date;
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

		$this->output($this->view . 'v_timework_record_preview_person', $data);
	}
	// preview_timework_record_person



	
}
