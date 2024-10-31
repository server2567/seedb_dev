<?php
/*
* Profile_official
* Controller หลักของจัดการข้อมูลการทำงาน
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 04/06/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Profile_Controller.php');

class Profile_official extends Profile_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Profile_official/";
		$this->load->model($this->model . 'M_hr_person');
		$this->load->model($this->model . 'm_hr_order_person');
		$this->load->model($this->model . 'M_hr_person_position');
		$this->load->model($this->model . 'structure/m_hr_structure_detail');
		$this->load->model($this->model . 'structure/m_hr_structure_person');
		$this->load->model($this->model . 'base/m_hr_structure_position');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* index หลักของจัดการข้อมูลการทำงาน
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
		// pre($this->session->all_userdata()); die;
		$this->output($this->view . 'v_profile_official_list', $data);
	}
	// index

	/*
	* get_profile_official
	* หน้าจอแก้ไขข้อมูลการทำงาน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 04/06/2024
	*/
	public function get_profile_official($ps_id = "")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_id'));
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$this->M_hr_person_position->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person_position->get_person_ums_department_by_ps_id()->result();

		$position_department_array = array();
		foreach ($data['person_department_topic'] as $row) {
			$array_tmp = $this->M_hr_person_position->get_person_position_by_ums_department_detail($data['ps_id'], $row->dp_id)->row();
			$data['stuc_info'][$row->dp_id] = $this->get_profile_structure_detail_list($data['ps_id'], $row->dp_id);
			if (count($data['stuc_info'][$row->dp_id]) < 1) {
				$data['stuc_info'][$row->dp_id] = $this->M_hr_person->get_current_stucture_by_department($row->dp_id)->result();
			}
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
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
		$this->output($this->view . 'v_profile_official_form', $data);
	}
	// get_profile_official

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
		$data['status_response'] = $this->config->item('status_response_show');
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

	/*
	* profile_official_update
	* อัพเดทข้อมูลการทำงานลงฐานข้อมูล
	* @input profile_official_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 05/06/2024
	*/
	function profile_official_update()
	{
		$profile_official_form = $this->input->post();
		foreach (json_decode($profile_official_form['dataArray'], true) as $key => $value) {
			if ($value['check'] == 'new') {
				$get_seq = $this->m_hr_structure_detail->get_max_seq($value['stde'])->row();
				$this->m_hr_structure_person->stdp_stde_id = $value['stde'];
				$this->m_hr_structure_person->stdp_ps_id = decrypt_id($profile_official_form["ps_id"]);
				$this->m_hr_structure_person->stdp_po_id = $value['pos'];
				$this->m_hr_structure_person->stdp_active = 1;
				$this->m_hr_structure_person->stdp_seq = ($get_seq->max_seq + 1);
				$this->m_hr_structure_person->stdp_create_user = $this->session->userdata('us_id');
				$this->m_hr_structure_person->insert();
			} else if ($value['check'] == 'old') {
				$this->m_hr_structure_person->stdp_id = $value['stdp_id'];
				$this->m_hr_structure_person->stdp_po_id = $value['pos'];
				$this->m_hr_structure_person->stdp_active = $value['status'];
				$this->m_hr_structure_person->stdp_update_user = $this->session->userdata('us_id');
				$this->m_hr_structure_person->update_position();
			}
		}
		$profile_official_form["ps_id"] = $ps_id = decrypt_id($profile_official_form["ps_id"]);
		$profile_official_form["dp_id"] = $dp_id = decrypt_id($profile_official_form["dp_id"]);
		$profile_official_form["pos_id"] = $pos_id = decrypt_id($profile_official_form["pos_id"]);
		$spcl_gp = $this->M_hr_person_position->get_max_group_position('special_position', 'pssp_pos_id')->result()[0]->gp;
		$admin_gp = $this->M_hr_person_position->get_max_group_position('admin_position', 'psap_pos_id')->result()[0]->gp;
		$spcl_gp = $spcl_gp == NULL ? 0 : $spcl_gp;
		$admin_gp = $admin_gp == NULL ? 0 : $admin_gp;
		$pos_admin_id = json_decode($profile_official_form['pos_admin_id_' . $dp_id], true);
		$pos_spcl_id = json_decode($profile_official_form['pos_spcl_id_' . $dp_id], true);
		if ($profile_official_form['check_type1'] == 'True') {
			if (count($pos_admin_id) > 0) {
				foreach ($pos_admin_id as $key => $value) {
					$this->M_hr_person_position->insert_admin_position(($admin_gp + 1), $value);
				}
				$this->M_hr_person_position->pos_admin_id = $admin_gp + 1;
			} else {
				$this->M_hr_person_position->pos_admin_id = NULL;
			}
		} else {
			$position = $this->M_hr_person_position->get_person_group_position_by_id($ps_id)->result();
			if (count($pos_admin_id) > 0) {
				$this->M_hr_person_position->pos_admin_id = $position[0]->pos_admin_id;
			} else {
				$this->M_hr_person_position->pos_admin_id = NULL;
			}
		}
		if ($profile_official_form['check_type2'] == 'True') {
			if (count($pos_spcl_id) > 0) {
				foreach ($pos_spcl_id  as $key => $value2) {
					$this->M_hr_person_position->insert_spcl_position(($spcl_gp + 1), $value2, $this->session->userdata('us_id'));
				}
				$this->M_hr_person_position->pos_spcl_id = $spcl_gp + 1;
			} else { //ตำแหน่งในการบริหาร 
				$this->M_hr_person_position->pos_spcl_id = NULL;
			}
		} else {
			$position = $this->M_hr_person_position->get_person_group_position_by_id($ps_id)->result();
			if (count($pos_spcl_id) > 0) {
				$this->M_hr_person_position->pos_spcl_id = $position[0]->pos_spcl_id;
			} else {
				$this->M_hr_person_position->pos_spcl_id = NULL;
			}
		}
		list($pos_retire_id, $pos_status) = explode(",", $profile_official_form["pos_status_" . $dp_id]);
		// update data in hr_person_position table
		$this->M_hr_person_position->pos_id = $pos_id;	//รหัสตำแหน่งงาน PK
		$this->M_hr_person_position->pos_ps_id = $ps_id;	//รหัสบุคลากร 
		$this->M_hr_person_position->pos_dp_id = $dp_id;	//รหัสหน่วยงาน
		$this->M_hr_person_position->pos_ps_code = $profile_official_form["pos_ps_code_" . $dp_id];	//รหัสประจำตัวบุคลากร
		$this->M_hr_person_position->pos_hire_id = $profile_official_form["pos_hire_id_" . $dp_id];	//ประเภทบุคลากร 
		$this->M_hr_person_position->pos_trial_day = $profile_official_form["pos_trial_day_" . $dp_id];
		$this->M_hr_person_position->pos_alp_id = $profile_official_form["pos_alp_id_" . $dp_id];	//ตำแหน่งปฏิบัติงาน 
		$this->M_hr_person_position->pos_retire_id = $pos_retire_id;	//สถานะการทำงาน 
		if (isset($profile_official_form["pos_active_" . $dp_id]) && $profile_official_form["pos_active_" . $dp_id] == "on") {
			$this->M_hr_person_position->pos_active = "Y";		//สถานะการใช้งานข้อมูล [เปิด]
		} else {
			$this->M_hr_person_position->pos_active = "N";		//สถานะการใช้งานข้อมูล [ปิด]
			$this->update_seq_order_data($ps_id, $dp_id); // อัพเดทลำดับการแสดงผล
		}

		$this->M_hr_person_position->pos_status = $pos_status;	//สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว	
		$this->M_hr_person_position->pos_work_start_date = splitDateForm1($profile_official_form["pos_work_start_date_" . $dp_id]);	//วันที่เริ่มปฏิบัติงาน 

		if ($pos_status == 2) {
			$this->M_hr_person_position->pos_work_end_date = splitDateForm1($profile_official_form["pos_work_end_date_" . $dp_id]); // วันที่ออกปฏิบัติงาน 
			$this->M_hr_person_position->pos_out_desc = $profile_official_form["pos_out_desc_" . $dp_id];

			// ตรวจสอบการดำเนินการที่ผู้ใช้ทำ (ลบไฟล์, อัปโหลดไฟล์ใหม่, หรือย้อนกลับไฟล์)
			$file_action = isset($profile_official_form["file_action_" . $dp_id]) ? $profile_official_form["file_action_" . $dp_id] : 'none';

			if ($file_action === 'remove') {
				// หากผู้ใช้เลือกที่จะลบไฟล์
				$old_file_path = $this->config->item('hr_upload_profile_official') . $this->M_hr_person_position->pos_attach_file;
				if (file_exists($old_file_path) && is_file($old_file_path)) {
					unlink($old_file_path);
				}
				// ล้างข้อมูลชื่อไฟล์ในโมเดล
				$this->M_hr_person_position->pos_attach_file = null;
			} else if ($file_action === 'new' && isset($_FILES['pos_attach_file_' . $dp_id]) && $_FILES['pos_attach_file_' . $dp_id]['error'] === UPLOAD_ERR_OK) {
				// หากผู้ใช้เลือกที่จะอัปโหลดไฟล์ใหม่
				$file_tmp = $_FILES['pos_attach_file_' . $dp_id]['tmp_name'];
				// $file_mime_type = mime_content_type($file_tmp);
				$file_mime_type = $_FILES['pos_attach_file_' . $dp_id]['type'];

				$file_extension = '';
				switch ($file_mime_type) {
					case 'image/jpeg':
						$file_extension = 'jpg';
						break;
					case 'image/png':
						$file_extension = 'png';
						break;
					case 'application/pdf':
						$file_extension = 'pdf';
						break;
					default:
						$data['status_response'] = $this->config->item('status_response_error');
						throw new Exception('Unsupported file type');
						break;
				}

				$file_new_name = "out_" . $profile_official_form["ps_id"] . "_" . date("dmy") . date("His") . "." . $file_extension;
				$full_destination_path = $this->config->item('hr_upload_profile_official') . $file_new_name;

				$old_file_path = $this->config->item('hr_upload_profile_official') . $this->M_hr_person_position->pos_attach_file;
				if (file_exists($old_file_path) && is_file($old_file_path)) {
					unlink($old_file_path);
				}

				if (move_uploaded_file($file_tmp, $full_destination_path)) {
					$this->M_hr_person_position->pos_attach_file = $file_new_name; // แนบไฟล์เอกสารหลักฐาน 
				}
			} else if ($file_action === 'undo' || $file_action === 'none') {
				// หากผู้ใช้เลือกที่จะย้อนกลับไฟล์ ไม่ต้องทำอะไร เพราะไฟล์เก่าถูกเก็บไว้เหมือนเดิม
				$this->M_hr_person_position->pos_attach_file = $profile_official_form["file_name_" . $dp_id]; // ชื่อไฟล์เดิม
			}
		}

		$max_count_work = $this->M_hr_person_position->get_person_position_count_work_now()->row()->max_count_work;
		$count_work_return = $this->M_hr_person_position->get_person_position_status_work($max_count_work)->row()->count_work;

		if ($count_work_return == 1) {
			$max_count_work += 1;
		}
		$this->M_hr_person_position->pos_count_work = $max_count_work;	//จำนวนครั้งที่ทำงาน	

		$this->M_hr_person_position->pos_desc = $profile_official_form["pos_desc_" . $dp_id];	//หมายเหตุ 
		$this->M_hr_person_position->pos_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
		$this->M_hr_person_position->pos_update_date = get_datetime_db();	//วันที่แก้ไข

		$this->M_hr_person_position->update();
		$data['pos_ps_list'] = $this->M_hr_person_position->get_position_by_ps_id($ps_id)->result();

		$default_status = false;
		$ps_status = 2; // ตั้งค่าเริ่มต้นเป็น 2 เพราะต้องการตรวจสอบว่าทั้งหมดเป็น 2 หรือไม่

		foreach ($data['pos_ps_list'] as $key => $row) {
			if ($row->pos_status == 1) {
				$default_status = true;
				$ps_status = 1; // ถ้าพบ pos_status ที่มีค่าเป็น 1 ให้ตั้งค่า ps_status เป็น 1
				break; // ออกจาก loop ทันทีเมื่อเจอค่า pos_status เป็น 1
			}
		}

		$final_status = $ps_status;

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		if ($this->M_hr_person->ps_status != $final_status) {
			$this->M_hr_person->ps_status = $final_status; //สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว	
			$this->M_hr_person->update();
		}

		// delete history for triggers
		$this->M_hr_person_position->manage_triggers_position_history();
		$this->M_hr_person_position->manage_triggers_person_history();

		$data['ps_position'] = $this->M_hr_person_position->get_position_by_key()->row();

		$this->M_hr_logs->insert_log("แก้ไขข้อมูลการทำงานของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_official/" . encrypt_id($ps_id));

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_official_update


	/*
	* get_all_ums_department
	* ดึงข้อมูลหน่วยงานหลักจากฐานข้อมูล UMS ที่ยังไม่ได้ถูกเลือก
	* @input ps_id
	* $output department all list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	public function get_all_ums_department()
	{
		$ps_id =  decrypt_id($this->input->post('ps_id'));
		$result = $this->M_hr_person_position->get_department_not_in_by_ps_id($ps_id)->result();
		echo json_encode($result);
	}
	// get_all_ums_department

	/*
	* insert_person_position
	* บันทึกตำแหน่งงานของบุคลากรตามหน่วยงานที่เลือก
	* @input ps_id, dp_id
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	public function insert_person_position()
	{
		$ps_id =  decrypt_id($this->input->post('ps_id'));
		$dp_id =  $this->input->post('dp_id');

		$this->M_hr_person_position->pos_ps_id = $ps_id;	//รหัสบุคลากร 
		$this->M_hr_person_position->pos_dp_id = $dp_id;	//รหัสหน่วยงาน

		$ps_position = $this->M_hr_person_position->get_position_by_key();

		if ($ps_position->num_rows() == 0) {
			$this->M_hr_person_position->pos_active = 'Y';	//สถานะการใช้งาน
			$this->M_hr_person_position->pos_work_start_date = date("Y-m-d");	//วันที่เริ่มปฏิบัติงาน
			$this->M_hr_person_position->pos_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_position->pos_create_date = get_datetime_db();	//วันที่สร้าง
			$this->M_hr_person_position->insert_person_position();
			// insert order person data in hr_order_data table
			$this->m_hr_order_person->ord_ps_id = $ps_id;
			$this->m_hr_order_person->ord_active = 1;
			$this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
			$this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
			$this->m_hr_order_person->update_order_data_after_insert_person($dp_id);
			$pos_id = $this->M_hr_person_position->last_insert_id;
		} else {
			$this->M_hr_person_position->get_position_by_key(true);
			$pos_id = $this->M_hr_person_position->pos_id;
			$this->M_hr_person_position->pos_work_start_date = date("Y-m-d");	//วันที่เริ่มปฏิบัติงาน
			$this->M_hr_person_position->pos_active = 'Y';
			$this->M_hr_person_position->pos_create_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_position->pos_create_date = get_datetime_db();	//วันที่แก้ไข
			// insert order person data in hr_order_data table
			$this->m_hr_order_person->ord_ps_id = $ps_id;
			$this->m_hr_order_person->ord_active = 1;
			$this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
			$this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
			$this->m_hr_order_person->update_order_data_after_insert_person($dp_id);
			$this->M_hr_person_position->update_pos_active();
		}

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("แก้ไขข้อมูลการทำงานของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		// $data['pos_id'] = $pos_id;
		// $data['dp_id'] = $dp_id;
		// $data['ps_id'] = $ps_id;
		// $data['v_profile_official_detail'] = $this->load->view($this->view.'v_profile_official_detail', $data, true);

		// delete history for triggers
		$this->M_hr_person_position->manage_triggers_position_history();

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	// insert_person_position

	// update seq for order data after profile official update
	public function update_seq_order_data($ps_id, $dp_id)
	{
		$ps_data = $this->m_hr_order_person->get_all_order_type_by_person($ps_id, $dp_id)->result();
		$ordt_info = [];
		foreach ($ps_data as $key => $item) {
			$ord_ordt_id = $item->ord_ordt_id;
			if (!in_array($ord_ordt_id, $ordt_info)) {
				$ordt_info[] = $ord_ordt_id;
			}
		}
		$ordt_id_groups = [];
		foreach ($ps_data as $item) {
			$ordt_id = $item->ord_ordt_id;
			if (!isset($ordt_id_groups[$ordt_id])) {
				$ordt_id_groups[$ordt_id] = [];
			}
			$ordt_id_groups[$ordt_id][] = $item;
		}
		// ปรับ ord_seq ใหม่ในแต่ละกลุ่ม ord_ordt_id
		foreach ($ordt_id_groups as &$group) {
			// เรียงลำดับโดย ord_seq
			usort($group, function ($a, $b) {
				return $a->ord_seq - $b->ord_seq;
			});

			// กำหนด ord_seq ใหม่ตามลำดับ
			$new_ord_seq = 1;
			foreach ($group as &$item) {
				$item->ord_seq = $new_ord_seq;
				$new_ord_seq++;
			}
		}

		foreach ($ordt_info as $key => $value) {
			$this->m_hr_order_person->ord_ordt_id = $value;
			$this->m_hr_order_person->delete_before_insert();
			$ordt_id_groups[$value];
			foreach ($ordt_id_groups[$value] as $key => $person) {
				$this->m_hr_order_person->ord_ps_id = $person->ord_ps_id;
				$this->m_hr_order_person->ord_ordt_id = $person->ord_ordt_id;
				$this->m_hr_order_person->ord_seq = $person->ord_seq;
				$this->m_hr_order_person->ord_active = $person->ord_active;
				$this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
				$this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
				$this->m_hr_order_person->insert();
			}
		}
	}

	function get_position_history()
	{
		$ps_id =  decrypt_id($this->input->get('ps_id'));

		$this->M_hr_person_position->pos_ps_id = $ps_id;
		$result = $this->M_hr_person_position->get_person_position_ums_department_history()->result();

		foreach ($result as $key => $row) {
			$row->history_detail = $this->M_hr_person_position->get_person_position_history_by_ps_id($ps_id, $row->dp_id)->result();
			foreach ($row->history_detail as $i => $ps) {
				$ps->hipos_pos_work_start_date = ($ps->hipos_pos_work_start_date ? abbreDate2($ps->hipos_pos_work_start_date) : "-");
				$ps->hipos_pos_work_end_date = ($ps->hipos_pos_work_end_date ? abbreDate2($ps->hipos_pos_work_end_date) : "-");
				$ps->hipos_start_date = abbreDate2($ps->hipos_start_date);
				$ps->hipos_end_date = ($ps->hipos_end_date != "9999-12-31" ? abbreDate2($ps->hipos_end_date) : abbreDate2(getNowDate()) . " (ปัจจุบัน)");
				$ps->hipos_update_date = abbreDate4($ps->hipos_update_date);

				$ps->hipos_pos_attach_file = '<a class="btn btn-link" data-file-name="' . $ps->hipos_pos_attach_file . '" 
					href="' . site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_official') . '&doc=' . $ps->hipos_pos_attach_file . '&rename=' . $ps->hipos_pos_attach_file) . '" 
					data-preview-path="' . site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_profile_official') . '&doc=' . $ps->hipos_pos_attach_file) . '" 
					data-download-path="' . site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_official') . '&doc=' . $ps->hipos_pos_attach_file) . '" 
					data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">' . $ps->hipos_pos_attach_file . '</a>';
			}
		}

		$keysToCheck = [
			"hipos_pos_ps_code",
			"hipos_pos_hire_id",
			"ps_admin_name",
			"ps_alp_name",
			"ps_hire_name",
			"ps_retire_name",
			"ps_spcl_name",
			"hipos_pos_retire_id",
			"hipos_pos_work_start_date",
			"hipos_pos_work_end_date",
			"hipos_pos_out_desc",
			"hipos_pos_attach_file"

		];
		function compareValues($value1, $value2)
		{
			return $value1 !== $value2;
		}

		// สร้างอาร์เรย์เก็บข้อมูลตาม hipos_id
		$combinedResults = [];

		// เก็บข้อมูลที่แตกต่างกันในแต่ละเดือน
		foreach ($result as $monthData) {
			$dp_id['dp_id'][] = $monthData->dp_id; // เข้าถึง dp_id จากออบเจ็กต์
			$dp_id['dp_name_th'][] =  $monthData->dp_name_th;
			$datasets = $monthData->history_detail; // เข้าถึง history_detail จากออบเจ็กต์
			$numberOfObjects = count($datasets); // นับจำนวนออบเจ็กต์ใน history_detail

			// เปลี่ยนลำดับข้อมูลเพื่อให้ข้อมูลใหม่อยู่ก่อน
			for ($i = $numberOfObjects - 1; $i >= 0; $i--) {
				$dataset = $datasets[$i];
				$hipos_id = $dataset->hipos_id;

				// สร้างอาร์เรย์สำหรับ hipos_id นี้ถ้ายังไม่มี
				if (!isset($combinedResults[$monthData->dp_id])) {
					$combinedResults[$monthData->dp_id] = [];
				}

				if (!isset($combinedResults[$monthData->dp_id][$hipos_id])) {
					$combinedResults[$monthData->dp_id][$hipos_id] = [
						'hipos_id' => $hipos_id
					];
				}

				// ตรวจสอบค่าปัจจุบัน
				foreach ($keysToCheck as $key) {
					if (isset($dataset->$key)) {
						// ถ้าชุดข้อมูลนี้มีการเปลี่ยนแปลงจากค่าก่อนหน้า หรือไม่มีค่าก่อนหน้า
						if ($i < $numberOfObjects - 1 && isset($datasets[$i + 1]->$key)) {
							// เปรียบเทียบกับค่าถัดไป (ซึ่งใหม่กว่า)
							if (compareValues($dataset->$key, $datasets[$i + 1]->$key)) {
								$combinedResults[$monthData->dp_id][$hipos_id][$key] = $dataset->$key;
							}
						} else {
							// เก็บข้อมูลตัวแปรทั้งหมดในชุดข้อมูลล่าสุด
							$combinedResults[$monthData->dp_id][$hipos_id][$key] = $dataset->$key;
						}
					}
				}
				$combinedResults[$monthData->dp_id][$hipos_id]['hipos_start_date'] = $datasets[$i]->hipos_start_date;
				$combinedResults[$monthData->dp_id][$hipos_id]['hipos_end_date'] = $datasets[$i]->hipos_end_date;
				$combinedResults[$monthData->dp_id][$hipos_id]['ps_update_user'] = $datasets[$i]->ps_update_user;
				$combinedResults[$monthData->dp_id][$hipos_id]['hipos_update_date'] = $datasets[$i]->hipos_update_date;
			}
		}
		// ผลลัพธ์สุดท้าย
		$results = [];
		$index = 0;
		foreach ($combinedResults as $month => $data) {

			$results[$month] = [
				'dp_id' => $dp_id['dp_id'][$index],
				'dp_name_th' => $dp_id['dp_name_th'][$index++],
				'value' => array_values($data) // แปลงอาร์เรย์ตาม hipos_id เป็นค่า
			];
		}
		$index = 0;
		foreach ($results as $key => $obj) {
			$obj['value'] = array_reverse($obj['value']);
			$fina_result[] = $obj;
		}
		echo json_encode($fina_result);
	}
	function get_structure_detail_by_stuc_id()
	{
		$dp_id = $this->input->post('dp_id');
		$result = $this->M_hr_person->get_structure_detail_by_confirm(null,$dp_id)->result();
		echo json_encode($result);
	}
	function get_profile_structure_detail_list($ps_id, $dp_id)
	{
		$result = $this->M_hr_person->get_structure_detail_list($ps_id, $dp_id)->result();
		return $result;
	}
}
