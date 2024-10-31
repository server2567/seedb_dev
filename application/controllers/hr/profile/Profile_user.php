<?php
/*
* Profile_user
* Controller หลักของจัดการข้อมูลส่วนตัว
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 16/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Profile_Controller.php');

class Profile_user extends Profile_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Profile_user/";
		$this->load->model($this->model . 'M_hr_person');
		$this->load->model($this->model . 'M_hr_person_detail');
		$this->load->model($this->model . 'M_hr_person_position');
		$this->load->model($this->model . 'm_hr_order_person');
		$this->load->model($this->model . 'M_hr_person_education');
		$this->load->model($this->model . 'M_hr_person_license');
		$this->load->model($this->model . 'M_hr_person_work_history');
		$this->load->model($this->model . 'M_hr_person_expert');
		$this->load->model($this->model . 'M_hr_person_external_service');
		$this->load->model($this->model . 'M_hr_person_reward');
		$this->load->model($this->model . 'base/m_hr_structure_position');
		// $this->load->model($this->model . 'structure/');
		$this->mn_active_url = "hr/profile/Profile_user";
	}

	/*
	* index
	* index หลักของจัดการข้อมูลส่วนตัว
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		// $data['base_adline_position_list'] = $this->M_hr_person->get_hr_base_adline_position_data()->result();
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
		$this->output($this->view . 'v_profile_user_list', $data);
	}
	// index

	/*
	* profile_user_insert
	* หน้าจอเพิ่มบุคลากร
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function profile_user_insert()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['base_prefix_list'] = $this->M_hr_person->get_hr_base_prefix_data()->result();
		$data['base_gender_list'] = $this->M_hr_person->get_hr_base_gender_data()->result();
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$data['base_hire_list'] = $this->M_hr_person->get_hr_base_hire_type_data()->result();

		$this->output($this->view . 'v_profile_user_insert_form', $data);
	}
	// profile_user_insert

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
		$hire_id = $this->input->get('hire_id');
		$admin_id = $this->input->get('admin_id');
		$status_id = $this->input->get('status_id');

		$result = $this->M_hr_person->get_all_profile_data($dp_id, $admin_id, $hire_id, $status_id)->result();
		foreach ($result as $key => $row) {
			$array = array();
			$row->ps_id = encrypt_id($row->ps_id);
			$admin_name = json_decode($row->admin_position, true);
			if ($admin_name) {
				foreach ($admin_name as $value) {
					if (is_string($value)) {
						$value = json_decode($value, true);
					}
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
	* profile_insert
	* เพิ่มรายชื่อบุคลากรลงฐานข้อมูล
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function profile_insert()
	{
		$profile_form_data = $this->input->post();
		// insert data in hr_person table
		$this->M_hr_person->ps_pf_id = $profile_form_data["ps_pf_id"];	//คำนำหน้าชื่อ
		$this->M_hr_person->ps_fname = $profile_form_data["ps_fname"];	//ชื่อ (ภาษาไทย)
		$this->M_hr_person->ps_lname = $profile_form_data["ps_lname"];	//นามสกุล (ภาษาไทย)
		$this->M_hr_person->ps_fname_en = $profile_form_data["ps_fname_en"];	//ชื่อ (ภาษาอังกฤษ)
		$this->M_hr_person->ps_lname_en = $profile_form_data["ps_lname_en"];	//นามสกุล (ภาษาอังกฤษ)
		$this->M_hr_person->ps_nickname = $profile_form_data["ps_nickname"];	//ชื่อเล่น (ภาษาไทย)
		$this->M_hr_person->ps_nickname_en = $profile_form_data["ps_nickname_en"];	//ชื่อเล่น (ภาษาอังกฤษ)
		$this->M_hr_person->ps_status = 1;	//สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว	
		$this->M_hr_person->ps_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
		$this->M_hr_person->ps_create_date = get_datetime_db();	//วันที่สร้าง

		// check profile duplicate 
		$data_duplicate = $this->M_hr_person->check_profile_duplicate('insert', $profile_form_data["ps_fname"], $profile_form_data["ps_lname"], preg_replace('/\D/', '', $profile_form_data["psd_id_card_no"]))->row()->count_person;

		if ($data_duplicate > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_duplicate');
		} else {
			$this->M_hr_person->insert();
			$last_ps_insert_id = $this->M_hr_person->last_insert_id;
			// iner order person data in hr_order_data table
			$this->m_hr_order_person->ord_ps_id = $last_ps_insert_id;
			$this->m_hr_order_person->ord_active = 1;
			$this->m_hr_order_person->ord_create_user = $this->session->userdata('us_id');
			$this->m_hr_order_person->ord_update_user = $this->session->userdata('us_id');
			foreach ($profile_form_data["pos_dp_id"] as $value) {
				$this->m_hr_order_person->update_order_data_after_insert_person($value);
			}
			// insert data in hr_person_detail table
			$this->M_hr_person_detail->psd_ps_id = $last_ps_insert_id;	//รหัสบุคลากร (id.hr_person)
			$this->M_hr_person_detail->psd_gd_id = $profile_form_data["psd_gd_id"];	//เพศ
			$this->M_hr_person_detail->psd_id_card_no = preg_replace('/\D/', '', $profile_form_data["psd_id_card_no"]);	//เลขบัตรประชาชน

			if ($profile_form_data["psd_birthdate"]) {
				$this->M_hr_person_detail->psd_birthdate = splitDateForm1($profile_form_data["psd_birthdate"]);	//วันเกิด
			} else {
				$this->M_hr_person_detail->psd_birthdate = NULL;
			}

			$this->M_hr_person_detail->psd_email = $profile_form_data["psd_email"];	//E-mail
			$this->M_hr_person_detail->psd_desc = $profile_form_data["psd_desc"];	//หมายเหตุ
			$this->M_hr_person_detail->psd_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_detail->psd_create_date = get_datetime_db();	//วันที่สร้าง

			if (isset($_FILES['psd_picture']) && $_FILES['psd_picture']['error'] === UPLOAD_ERR_OK) {
				// Assuming $file_tmp is the temporary name of the uploaded file
				$file_tmp = $_FILES['psd_picture']['tmp_name'];
				// Get the real type of the uploaded file
				$real_file_type = exif_imagetype($file_tmp);

				// Determine the file extension based on the file type
				$file_extension = '';
				switch ($real_file_type) {
					case IMAGETYPE_JPEG:
						$file_extension = 'jpg';
						break;
					case IMAGETYPE_PNG:
						$file_extension = 'png';
						break;
					default:
						// Handle unknown file types or throw an error
						break;
				}

				// Rename the uploaded file with the correct extension
				$file_new_name = "profile_picture_" . $last_ps_insert_id . "." . $file_extension;
				$this->M_hr_person_detail->psd_picture = $file_new_name; // Set the file name to the model property

				// Move the uploaded file to the specified directory
				move_uploaded_file($file_tmp, $this->config->item('hr_upload_profile_picture') . $file_new_name);
			}

			$this->M_hr_person_detail->insert();

			// insert data in hr_person_position table
			foreach ($profile_form_data["pos_dp_id"] as $value) {
				$this->M_hr_person_position->pos_ps_id =  $last_ps_insert_id;	//รหัสบุคลากร (id.hr_person)
				$this->M_hr_person_position->pos_dp_id = $value;	//รหัสหน่วยงาน ums_db.umdepartment
				$this->M_hr_person_position->pos_hire_id = $profile_form_data["pos_hire_id"];	//ประเภทบุคลากร hr.base_hire
				$this->M_hr_person_position->pos_status = 1;	//สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว	
				$this->M_hr_person_position->pos_retire_id = 1;	//หมายเหตุสถานะปฏิบัติงาน 
				$this->M_hr_person_position->pos_active = 'Y'; //สถานะการใช้งาน
				$this->M_hr_person_position->pos_work_start_date = date("Y-m-d", strtotime("first day of January this year"));	//วันที่ปฏิบัติงานครั้งแรก
				$this->M_hr_person_position->pos_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
				$this->M_hr_person_position->pos_create_date = get_datetime_db();	//วันที่สร้าง
				$this->M_hr_person_position->insert();
			}

			// delete history for triggers
			$this->M_hr_person->manage_triggers_person_history();

			$this->M_hr_logs->insert_log("เพิ่มรายชื่อบุคลากร " . $profile_form_data["ps_fname"] . " " . $profile_form_data["ps_lname"]);	//insert hr logs

			$data['status_response'] = $this->config->item('status_response_success');
			$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_insert

	/*
	* get_profile_user
	* หลักของจัดการข้อมูลส่วนตัว
	* @input - tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	public function get_profile_user($ps_id = "", $tab_active = 1)
	{
		if ($ps_id != "")
			$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		else
			$data['session_mn_active_url'] = uri_string(); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));
		$data['tab_active'] = $tab_active = (isset($tab_active) || $tab_active != 1 ? $tab_active : 1);

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['row_education'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
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
		//   pre($data['person_department_detail'] );
		$data['base_amphur_list'] = $this->M_hr_person->get_hr_base_amphur_data()->result();
		$data['base_adline_position_list'] = $this->M_hr_person->get_hr_base_adline_position_data()->result();
		$data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();
		$data['base_blood_list'] = $this->M_hr_person->get_hr_base_blood_data()->result();
		$data['base_country_list'] = $this->M_hr_person->get_hr_base_country_data()->result();
		$data['base_district_list'] = $this->M_hr_person->get_hr_base_district_data()->result();
		$data['base_education_degree_list'] = $this->M_hr_person->get_hr_base_education_degree_data()->result();
		$data['base_education_level_list'] = $this->M_hr_person->get_hr_base_education_level_data()->result();
		$data['base_education_major_list'] = $this->M_hr_person->get_hr_base_education_major_data()->result();
		$data['base_gender_list'] = $this->M_hr_person->get_hr_base_gender_data()->result();
		$data['base_nation_list'] = $this->M_hr_person->get_hr_base_nation_data()->result();
		$data['base_person_status_list'] = $this->M_hr_person->get_hr_base_person_status_data()->result();
		$data['base_place_list'] = $this->M_hr_person->get_hr_base_place_data()->result();
		$data['base_province_list'] = $this->M_hr_person->get_hr_base_province_data()->result();
		$data['base_race_list'] = $this->M_hr_person->get_hr_base_race_data()->result();
		$data['base_religion_list'] = $this->M_hr_person->get_hr_base_religion_data()->result();
		$data['base_reward_level_list'] = $this->M_hr_person->get_hr_base_reward_level_data()->result();
		$data['base_reward_type_list'] = $this->M_hr_person->get_hr_base_reward_type_data()->result();
		$data['base_vocation_list'] = $this->M_hr_person->get_hr_base_vocation_data()->result();
		$data['base_external_service_list'] = $this->M_hr_person->get_hr_base_external_service_data()->result();
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$data['structure_detail_list'] = $this->M_hr_person->get_structure_detail_by_confirm()->result();
		$data['structure_list'] = $this->M_hr_person->get_all_structure_had_confirm()->result();
		$this->output($this->view . 'v_profile_user_form', $data);
	}
	// get_profile_user

	/*
	* profile_resume_update
	* อัพเดทข้อมูลส่วนตัวบุคลากรลงฐานข้อมูล
	* @input - profile_resume_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 21/05/2024
	*/
	public function profile_resume_update()
	{
		$profile_resume_form = $this->input->post();
		$profile_resume_form["ps_id"] = decrypt_id($profile_resume_form["ps_id"]);
		// print_r($profile_resume_form); die;

		// update data in hr_person table
		$this->M_hr_person->ps_id = $profile_resume_form["ps_id"];	//PK รหัสบุคลากร
		$this->M_hr_person->ps_pf_id = $profile_resume_form["ps_pf_id"];	//คำนำหน้าชื่อ
		$this->M_hr_person->ps_fname = $profile_resume_form["ps_fname"];	//ชื่อ (ภาษาไทย)
		$this->M_hr_person->ps_lname = $profile_resume_form["ps_lname"];	//นามสกุล (ภาษาไทย)
		$this->M_hr_person->ps_fname_en = $profile_resume_form["ps_fname_en"];	//ชื่อ (ภาษาอังกฤษ)
		$this->M_hr_person->ps_lname_en = $profile_resume_form["ps_lname_en"];	//นามสกุล (ภาษาอังกฤษ)
		$this->M_hr_person->ps_nickname = $profile_resume_form["ps_nickname"];	//ชื่อเล่น (ภาษาไทย)
		$this->M_hr_person->ps_nickname_en = $profile_resume_form["ps_nickname_en"];	//ชื่อเล่น (ภาษาอังกฤษ)
		$this->M_hr_person->ps_status = 1;	//สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว	
		$this->M_hr_person->ps_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
		$this->M_hr_person->ps_update_date = get_datetime_db();	//วันที่แก้ไข

		// // check profile duplicate 
		// $data_duplicate = $this->M_hr_person->check_profile_duplicate('update', $profile_resume_form["ps_fname"], $profile_resume_form["ps_lname"], preg_replace('/\D/', '', $profile_resume_form["psd_id_card_no"]), $profile_resume_form["ps_id"])->row()->count_person;
		// if ($data_duplicate > 0) {
		// 	$data['status_response'] = $this->config->item('status_response_error');
		// 	$data['message_dialog'] = $this->config->item('text_invalid_duplicate');
		// } else {
		$this->M_hr_person->update();

		// update data in hr_person_detail table
		$this->M_hr_person_detail->psd_ps_id = $profile_resume_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_detail->get_by_key(true);
		$this->M_hr_person_detail->psd_gd_id = $profile_resume_form["psd_gd_id"];	//เพศ
		$this->M_hr_person_detail->psd_id_card_no = preg_replace('/\D/', '', $profile_resume_form["psd_id_card_no"]);	//เลขบัตรประชาชน
		if ($profile_resume_form["psd_birthdate"]) {
			$this->M_hr_person_detail->psd_birthdate = splitDateForm1($profile_resume_form["psd_birthdate"]);	//วันเกิด
		} else {
			$this->M_hr_person_detail->psd_birthdate = NULL;
		}

		$this->M_hr_person_detail->psd_blood_id = $profile_resume_form["psd_blood_id"] ?: NULL;  // หมู่เลือด
		$this->M_hr_person_detail->psd_reli_id = $profile_resume_form["psd_reli_id"] ?: NULL;   // ศาสนา
		$this->M_hr_person_detail->psd_race_id = $profile_resume_form["psd_race_id"] ?: NULL;   // เชื้อชาติ
		$this->M_hr_person_detail->psd_psst_id = $profile_resume_form["psd_psst_id"] ?: NULL;   // สถานภาพ
		$this->M_hr_person_detail->psd_nation_id = $profile_resume_form["psd_nation_id"] ?: NULL;  // สัญชาติ
		$this->M_hr_person_detail->psd_facebook = $profile_resume_form["psd_facebook"];	//Facebook
		$this->M_hr_person_detail->psd_line = $profile_resume_form["psd_line"];	//Line ID
		$this->M_hr_person_detail->psd_cellphone = $profile_resume_form["psd_cellphone"];	//เบอร์โทรศัพท์มือถือ
		$this->M_hr_person_detail->psd_phone = $profile_resume_form["psd_phone"];	//เบอร์โทรศัพท์บ้าน
		$this->M_hr_person_detail->psd_ex_phone = $profile_resume_form["psd_ex_phone"];	//เบอร์โทรภายใน
		$this->M_hr_person_detail->psd_work_phone = $profile_resume_form["psd_work_phone"];	//เบอร์โทรศัพท์ที่ทำงาน
		$this->M_hr_person_detail->psd_email = $profile_resume_form["psd_email"];	//E-mail
		$this->M_hr_person_detail->psd_desc = $profile_resume_form["psd_desc"];	//หมายเหตุ
		$this->M_hr_person_detail->psd_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
		$this->M_hr_person_detail->psd_update_date = get_datetime_db();	//วันที่แก้ไข

		if (isset($_FILES['psd_picture']) && $_FILES['psd_picture']['error'] === UPLOAD_ERR_OK) {
			// Assuming $file_tmp is the temporary name of the uploaded file
			$file_tmp = $_FILES['psd_picture']['tmp_name'];

			// Get the real type of the uploaded file
			$real_file_type = exif_imagetype($file_tmp);

			// Determine the file extension based on the file type
			$file_extension = '';
			switch ($real_file_type) {
				case IMAGETYPE_JPEG:
					$file_extension = 'jpg';
					break;
				case IMAGETYPE_PNG:
					$file_extension = 'png';
					break;
				default:
					// Handle unknown file types or throw an error
					break;
			}

			// Generate the new file name with the correct extension
			$file_new_name = "profile_picture_" . $profile_resume_form["ps_id"] . "." . $file_extension;

			// Specify the destination directory where the file should be moved
			$full_destination_path = $this->config->item('hr_upload_profile_picture') . $file_new_name;

			// Check if an old file exists and delete it
			$old_file_path = $this->config->item('hr_upload_profile_picture') . $this->M_hr_person_detail->psd_picture;
			if (file_exists($old_file_path) && is_file($old_file_path)) {
				unlink($old_file_path);
			}

			if (move_uploaded_file($file_tmp, $full_destination_path)) {
				// Update the model property with the new file name after successful upload
				$this->M_hr_person_detail->psd_picture = $file_new_name;
			}
		}

		$this->M_hr_person_detail->update();

		// delete history for triggers
		$this->M_hr_person->manage_triggers_person_history_ps_id();

		$this->M_hr_logs->insert_log("แก้ไขข้อมูลส่วนตัวของ " . $profile_resume_form["ps_fname"] . " " . $profile_resume_form["ps_lname"]);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_resume_form["ps_id"]) . "/" . $profile_resume_form["tab_active"]);
		// }

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_resume_update

	/*
	* check_profile_duplicate
	* ตรวจสอบข้อมูลรายชื่อบุคลากร
	* @input ชื่อจริง-นามสกุล (ไทย) และหมายเลขบัตรประชาชน
	* $output count_data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 20/05/2024
	*/
	public function check_profile_duplicate()
	{
		$field_fname = $this->input->post('field_fname');
		$field_lname = $this->input->post('field_lname');
		$file_psd_id_card_no = $this->input->post('file_psd_id_card_no');

		$data = $this->M_hr_person->check_profile_duplicate('insert', $field_fname, $field_lname, $file_psd_id_card_no)->row()->count_person;
		echo json_encode($data);
	}
	// check_profile_duplicate

	/*
	* profile_address_update
	* อัพเดทข้อมูลที่อยู่ของบุคลากร
	* @input profile_address_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function profile_address_update()
	{
		$profile_address_form = $this->input->post();
		$profile_address_form["ps_id"] = decrypt_id($profile_address_form["ps_id"]);

		$this->M_hr_person_detail->psd_ps_id = $profile_address_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_detail->get_by_key(true);

		// อยู่ตามทะเบียนบ้าน
		$this->M_hr_person_detail->psd_addcur_no = $profile_address_form["psd_addcur_no"];	//ที่อยู่ 
		$this->M_hr_person_detail->psd_addcur_pv_id = $profile_address_form["psd_addcur_pv_id"];	//จังหวัด 
		$this->M_hr_person_detail->psd_addcur_amph_id = $profile_address_form["psd_addcur_amph_id"];	//อำเภอ 
		$this->M_hr_person_detail->psd_addcur_dist_id = $profile_address_form["psd_addcur_dist_id"];	//ตำบล 
		$this->M_hr_person_detail->psd_addcur_zipcode = $profile_address_form["psd_addcur_zipcode"];	//รหัสไปรษณี 

		// ที่อยู่ปัจจุบัน
		$this->M_hr_person_detail->psd_addhome_no = $profile_address_form["psd_addhome_no"];	//ที่อยู่ 
		$this->M_hr_person_detail->psd_addhome_pv_id = $profile_address_form["psd_addhome_pv_id"];	//จังหวัด 
		$this->M_hr_person_detail->psd_addhome_amph_id = $profile_address_form["psd_addhome_amph_id"];	//อำเภอ 
		$this->M_hr_person_detail->psd_addhome_dist_id = $profile_address_form["psd_addhome_dist_id"];	//ตำบล 
		$this->M_hr_person_detail->psd_addhome_zipcode = $profile_address_form["psd_addhome_zipcode"];	//รหัสไปรษณี 

		$this->M_hr_person_detail->psd_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
		$this->M_hr_person_detail->psd_update_date = get_datetime_db();	//วันที่แก้ไข
		$this->M_hr_person_detail->update();

		$this->M_hr_person->ps_id = $profile_address_form["ps_id"];
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("แก้ไขข้อมูลที่อยู่ของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_address_form["ps_id"]) . "/" . $profile_address_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_address_update

	/*
	* profile_education_update
	* อัพเดทข้อมูลการศึกษาของบุคลากร
	* @input profile_education_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 27/05/2024
	*/
	function profile_education_update()
	{
		$profile_education_form = $this->input->post();
		$profile_education_form["ps_id"] = decrypt_id($profile_education_form["ps_id"]);

		if ($profile_education_form["edu_id"] == "" || $profile_education_form["edu_id"] == null) {	//== insert
			$this->M_hr_person_education->edu_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_education->edu_create_date = get_datetime_db();	//วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_education->edu_id = decrypt_id($profile_education_form["edu_id"]);	//PK hr_education 
			$this->M_hr_person_education->get_by_key(true);
			$this->M_hr_person_education->edu_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_education->edu_update_date = get_datetime_db();	//วันที่แก้ไข
		}
		$this->M_hr_person_education->edu_ps_id = $profile_education_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_education->edu_edulv_id = $profile_education_form["edu_edulv_id"];	//ระดับการศึกษา 
		$this->M_hr_person_education->edu_edudg_id = $profile_education_form["edu_edudg_id"];	//วุฒิการศึกษา 
		$this->M_hr_person_education->edu_edumj_id = $profile_education_form["edu_edumj_id"];	//สาขาวิชา 
		$this->M_hr_person_education->edu_place_id = $profile_education_form["edu_place_id"];	//สถานศึกษา 
		$this->M_hr_person_education->edu_country_id = $profile_education_form["edu_country_id"];	//ประเทศ 
		if (isset($profile_education_form["check_edu_start_year"]) && $profile_education_form["check_edu_start_year"] == "on") {
			$this->M_hr_person_education->edu_start_date = "0000-00-00";	//วันที่เริ่มศึกษา 
			$this->M_hr_person_education->edu_start_year = $profile_education_form["edu_start_year"]-543; //ปีที่เริ่มศึกษา 
		} else {
			$this->M_hr_person_education->edu_start_date = splitDateForm1($profile_education_form["edu_start_date"]);	//วันที่เริ่มศึกษา 
			list($day, $month, $year) = explode('/', $profile_education_form["edu_start_date"]);
			$this->M_hr_person_education->edu_start_year = $year - 543; //ปีที่เริ่มศึกษา 
		}

		if (isset($profile_education_form["check_edu_end_year"]) && $profile_education_form["check_edu_end_year"] == "on") {
			$this->M_hr_person_education->edu_end_date = "0000-00-00";	//วันที่จบศึกษา 
			$this->M_hr_person_education->edu_end_year = $profile_education_form["edu_end_year"]-543;	//ปีที่จบศึกษา 
		} else {
			$this->M_hr_person_education->edu_end_date = splitDateForm1($profile_education_form["edu_end_date"]);	//วันที่จบศึกษา 
			list($day, $month, $year) = explode('/', $profile_education_form["edu_end_date"]);
			$this->M_hr_person_education->edu_end_year = $year - 543; //ปีที่จบศึกษา 
		}

		$this->M_hr_person_education->edu_highest = isset($profile_education_form["edu_highest"]) ? "Y" : "N";	//วุฒิสูงสุด 
		$this->M_hr_person_education->edu_admid = isset($profile_education_form["edu_admid"]) ? "Y" : "N";	//วุฒิบรรจุราชการ 
		$this->M_hr_person_education->edu_edumjt_id  = $profile_education_form["edu_edumjt_id"];	//ประเภทสาขา 
		$this->M_hr_person_education->edu_hon_id = $profile_education_form["edu_hon_id"];	//เกียรตินิยม 

		if (isset($_FILES['edu_attach_file']) && $_FILES['edu_attach_file']['error'] === UPLOAD_ERR_OK) {
			// Assuming $file_tmp is the temporary name of the uploaded file
			$file_tmp = $_FILES['edu_attach_file']['tmp_name'];

			// Get the MIME type of the uploaded file
			$file_mime_type = mime_content_type($file_tmp);

			// Determine the file extension based on the MIME type
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
					// Handle unknown file types or throw an error
					$data['status_response'] = $this->config->item('status_response_error');
					throw new Exception('Unsupported file type');
					break;
			}

			// Generate the new file name with the correct extension
			$file_new_name = "edu_" . $profile_education_form["ps_id"] . "_" . date("dmy") . date("His") . "." . $file_extension;

			// Specify the destination directory where the file should be moved
			$full_destination_path = $this->config->item('hr_upload_profile_education') . $file_new_name;

			// Check if an old file exists and delete it
			$old_file_path = $this->config->item('hr_upload_profile_education') . $this->M_hr_person_education->edu_attach_file;
			if (file_exists($old_file_path) && is_file($old_file_path)) {
				unlink($old_file_path);
			}

			if (move_uploaded_file($file_tmp, $full_destination_path)) {
				// Update the model property with the new file name after successful upload
				$this->M_hr_person_education->edu_attach_file = $file_new_name;	//แนบไฟล์เอกสารหลักฐาน 
			}
		}

		$this->M_hr_person->ps_id = $profile_education_form["ps_id"];
		$this->M_hr_person->get_by_key(true);

		if ($profile_education_form["edu_id"] == "" ||$profile_education_form["edu_id"] == null) {	//== insert
			$this->M_hr_person_education->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลประวัติการศึกษาของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		} else {	//== update
			$this->M_hr_person_education->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลประวัติการศึกษาของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_education_form["ps_id"]) . "/" . $profile_education_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_education_update

	/*
	* profile_license_update
	* อัพเดทข้อมูลใบประกอบวิชาชีพของบุคลากร
	* @input profile_license_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function profile_license_update()
	{
		$profile_license_form = $this->input->post();
		$profile_license_form["ps_id"] = decrypt_id($profile_license_form["ps_id"]);

		if ($profile_license_form["licn_id"] == "") {	//== insert
			$this->M_hr_person_license->licn_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_license->licn_create_date = get_datetime_db();	//วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_license->licn_id = decrypt_id($profile_license_form["licn_id"]);	//PK hr_education 
			$this->M_hr_person_license->get_by_key(true);
			$this->M_hr_person_license->licn_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_license->licn_update_date = get_datetime_db();	//วันที่แก้ไข
		}

		$this->M_hr_person_license->licn_ps_id = $profile_license_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_license->licn_voc_id = $profile_license_form["licn_voc_id"];	//ชื่อวิชาชีพ 
		$this->M_hr_person_license->licn_code = $profile_license_form["licn_code"];	//เลขใบประกอบวิชาชีพ 
		$this->M_hr_person_license->licn_start_date = splitDateForm1($profile_license_form["licn_start_date"]);	//วันที่ออกบัตร 

		if (isset($profile_license_form["check_licn_date"]) && $profile_license_form["check_licn_date"] == "on") {
			$this->M_hr_person_license->licn_end_date = "9999-12-31";	//วันหมดอายุ 
		} else {
			$this->M_hr_person_license->licn_end_date = splitDateForm1($profile_license_form["licn_end_date"]);	//วันที่จบศึกษา 
		}

		if (isset($_FILES['licn_attach_file']) && $_FILES['licn_attach_file']['error'] === UPLOAD_ERR_OK) {
			// Assuming $file_tmp is the temporary name of the uploaded file
			$file_tmp = $_FILES['licn_attach_file']['tmp_name'];

			// Get the MIME type of the uploaded file
			$file_mime_type = mime_content_type($file_tmp);

			// Determine the file extension based on the MIME type
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
					// Handle unknown file types or throw an error
					$data['status_response'] = $this->config->item('status_response_error');
					throw new Exception('Unsupported file type');
					break;
			}

			// Generate the new file name with the correct extension
			$file_new_name = "licn_" . $profile_license_form["ps_id"] . "_" . date("dmy") . date("His") . "." . $file_extension;

			// Specify the destination directory where the file should be moved
			$full_destination_path = $this->config->item('hr_upload_profile_license') . $file_new_name;

			// Check if an old file exists and delete it
			$old_file_path = $this->config->item('hr_upload_profile_license') . $this->M_hr_person_license->licn_attach_file;
			if (file_exists($old_file_path) && is_file($old_file_path)) {
				unlink($old_file_path);
			}

			if (move_uploaded_file($file_tmp, $full_destination_path)) {
				// Update the model property with the new file name after successful upload
				$this->M_hr_person_license->licn_attach_file = $file_new_name;	//แนบไฟล์เอกสารหลักฐาน 
			}
		}

		$this->M_hr_person->ps_id = $profile_license_form["ps_id"];
		$this->M_hr_person->get_by_key(true);

		if ($profile_license_form["licn_id"] == "") {	//== insert
			$this->M_hr_person_license->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลใบประกอบวิชาชีพ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		} else {	//== update
			$this->M_hr_person_license->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลใบประกอบวิชาชีพ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs			
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_license_form["ps_id"]) . "/" . $profile_license_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_license_update

	/*
	* profile_work_history_update
	* อัพเดทข้อมูลประสบการณ์ทำงานของบุคลากร
	* @input profile_work_history_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function profile_work_history_update()
	{
		$profile_work_history_form = $this->input->post();
		$profile_work_history_form["ps_id"] = decrypt_id($profile_work_history_form["ps_id"]);


		if ($profile_work_history_form["wohr_id"] == "") {	//== insert
			$this->M_hr_person_work_history->wohr_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_work_history->wohr_create_date = get_datetime_db();	//วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_work_history->wohr_id = decrypt_id($profile_work_history_form["wohr_id"]);	//PK hr_person_work_history 
			$this->M_hr_person_work_history->get_by_key(true);
			$this->M_hr_person_work_history->wohr_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_work_history->wohr_update_date = get_datetime_db();	//วันที่แก้ไข
		}
		if (isset($profile_work_history_form["wohr_stde_id"]) && $profile_work_history_form["wohr_stde_id"] != "" && isset($profile_work_history_form["wohr_dept_id"]) && $profile_work_history_form["wohr_dept_id"]  == 'on') {
			$this->M_hr_person_work_history->wohr_stuc_id = $profile_work_history_form["wohr_stuc_id"];	//รหัสโครงสร้างองค์กร (id.hr_structure)
			$this->M_hr_person_work_history->wohr_stde_id = $profile_work_history_form["wohr_stde_id"];	//หน่วยงานที่สังกัด (id.hr_structure_detail)
			$this->M_hr_person_work_history->wohr_place_name = '';	//หน่วยงานที่สังกัด (name_th.hr_structure_detail)
		} else {
			$this->M_hr_person_work_history->wohr_stuc_id = null;	//รหัสโครงสร้างองค์กร (id.hr_structure)
			$this->M_hr_person_work_history->wohr_stde_id = null;	//หน่วยงานที่สังกัด (id.hr_structure_detail)
			$this->M_hr_person_work_history->wohr_stde_name_th = null;	//หน่วยงานที่สังกัด (name_th.hr_structure_detail)
			$this->M_hr_person_work_history->wohr_place_name = $profile_work_history_form["wohr_place_name"];	//หน่วยงานที่สังกัด (name_th.hr_structure_detail)
		}

		$this->M_hr_person_work_history->wohr_ps_id = $profile_work_history_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_work_history->wohr_admin_id = isset($profile_work_history_form["wohr_admin_id"]) ? $profile_work_history_form["wohr_admin_id"] : NULL;	//ตำแหน่งบริหารงาน (id.base_admin_position)
		$this->M_hr_person_work_history->wohr_alp_id = $profile_work_history_form["wohr_alp_id"];	//รหัสโครงสร้างองค์กร (id.base_adline_position)
		$this->M_hr_person_work_history->wohr_detail_th = $profile_work_history_form["wohr_detail_th"];	//รายละเอียด (ภาษาไทย) 
		$this->M_hr_person_work_history->wohr_detail_en = $profile_work_history_form["wohr_detail_en"];	//รายละเอียด (ภาษาอังกฤษ) 

		// Convert Thai year to Gregorian year for start date
		$startYear = $profile_work_history_form["wohr_date_start_year"] - 543;
		$startDay = $profile_work_history_form["wohr_date_start_day"] == 0 ? 0 : $profile_work_history_form["wohr_date_start_day"];
		$startDate = sprintf(
			"%04d-%02d-%02d",
			$startYear,
			$profile_work_history_form["wohr_date_start_month"],
			$startDay
		);
		$this->M_hr_person_work_history->wohr_start_date = $startDate;

		// Handle end date
		if (isset($profile_work_history_form["wohr_check_date_now"]) && $profile_work_history_form["wohr_check_date_now"] === 'on') {
			$this->M_hr_person_work_history->wohr_end_date = "9999-12-31"; // Current date
		} else {
			$endYear = $profile_work_history_form["wohr_end_date_year"] - 543;
			$endDay = $profile_work_history_form["wohr_end_end_day"] == 0 ? 0 : $profile_work_history_form["wohr_end_end_day"];
			$endDate = sprintf(
				"%04d-%02d-%02d",
				$endYear,
				$profile_work_history_form["wohr_date_end_month"],
				$endDay
			);
			$this->M_hr_person_work_history->wohr_end_date = $endDate;
		}

		// $this->M_hr_person_work_history->wohr_start_date = splitDateForm1($profile_work_history_form["wohr_start_date"]);	//วันที่เริ่มทำงาน
		// $this->M_hr_person_work_history->wohr_end_date = splitDateForm1($profile_work_history_form["wohr_end_date"]);	//วันที่สิ้นสุดทำงาน

		$this->M_hr_person->ps_id = $profile_work_history_form["ps_id"];
		$this->M_hr_person->get_by_key(true);


		if ($profile_work_history_form["wohr_id"] == "") {	//== insert
			$this->M_hr_person_work_history->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลประสบการณ์ทำงานของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		} else {	//== update
			$this->M_hr_person_work_history->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลประสบการณ์ทำงานของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_work_history_form["ps_id"]) . "/" . $profile_work_history_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_work_history_update

	/*
	* profile_expert_update
	* อัพเดทข้อมูลความชำนาญของบุคลากร
	* @input profile_expert_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function profile_expert_update()
	{
		$profile_expert_form = $this->input->post();
		$profile_expert_form["ps_id"] = decrypt_id($profile_expert_form["ps_id"]);

		if ($profile_expert_form["expt_id"] == "") {	//== insert
			$this->M_hr_person_expert->expt_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_expert->expt_create_date = get_datetime_db();	//วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_expert->expt_id = decrypt_id($profile_expert_form["expt_id"]);	//PK hr_education 
			$this->M_hr_person_expert->get_by_key(true);
			$this->M_hr_person_expert->expt_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_expert->expt_update_date = get_datetime_db();	//วันที่แก้ไข
		}

		$this->M_hr_person_expert->expt_ps_id = $profile_expert_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_expert->expt_title_th = $profile_expert_form["expt_title_th"];	//เรื่อง (ภาษาไทย) 
		$this->M_hr_person_expert->expt_title_en = $profile_expert_form["expt_title_en"];	//เรื่อง (ภาษาอังกฤษ) 
		$this->M_hr_person_expert->expt_detail_th = $profile_expert_form["expt_detail_th"];	//รายละเอียด (ภาษาไทย) 
		$this->M_hr_person_expert->expt_detail_en = $profile_expert_form["expt_detail_en"];	//รายละเอียด (ภาษาอังกฤษ) 

		$this->M_hr_person->ps_id = $profile_expert_form["ps_id"];
		$this->M_hr_person->get_by_key(true);

		if ($profile_expert_form["expt_id"] == "") {	//== insert
			$this->M_hr_person_expert->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลความเชี่ยวชาญ/ความชำนาญของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		} else {	//== update
			$this->M_hr_person_expert->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลความเชี่ยวชาญ/ความชำนาญของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_expert_form["ps_id"]) . "/" . $profile_expert_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_expert_update

	/*
	* profile_external_service_update
	* อัพเดทข้อมูลบริการหน่วยงานภายนอกของบุคลากร
	* @input profile_external_service_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function profile_external_service_update()
	{
		$profile_external_service_form = $this->input->post();
		$profile_external_service_form["ps_id"] = decrypt_id($profile_external_service_form["ps_id"]);

		if ($profile_external_service_form["pexs_id"] == "") {	//== insert
			$this->M_hr_person_external_service->pexs_create_user = $this->session->userdata('us_id');	// รหัสผู้สร้าง (USID)
			$this->M_hr_person_external_service->pexs_create_date = get_datetime_db();	// วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_external_service->pexs_id = decrypt_id($profile_external_service_form["pexs_id"]);	// PK hr_person_external_service 
			$this->M_hr_person_external_service->get_by_key(true);
			$this->M_hr_person_external_service->pexs_update_user = $this->session->userdata('us_id');	// รหัสผู้แก้ไข (USID)
			$this->M_hr_person_external_service->pexs_update_date = get_datetime_db();	// วันที่แก้ไข
		}

		$this->M_hr_person_external_service->pexs_ps_id = $profile_external_service_form["ps_id"];	// รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_external_service->pexs_exts_id = $profile_external_service_form["pexs_exts_id"];	// ประเภทบริการหน่วยงานภายนอก
		$this->M_hr_person_external_service->pexs_name_th = $profile_external_service_form["pexs_name_th"];	// เรื่องบริการหน่วยงานภายนอก
		$this->M_hr_person_external_service->pexs_date = splitDateForm1($profile_external_service_form["pexs_date"]);	// วันที่บริการหน่วยงานภายนอก
		$this->M_hr_person_external_service->pexs_place_id = $profile_external_service_form["pexs_place_id"];	// สถานที่/หน่วยงาน

		if (isset($_FILES['pexs_attach_file']) && $_FILES['pexs_attach_file']['error'] === UPLOAD_ERR_OK) {
			// Handling file upload
			$file_tmp = $_FILES['pexs_attach_file']['tmp_name'];
			$file_mime_type = mime_content_type($file_tmp);

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

			$file_new_name = "pexs_" . $profile_external_service_form["ps_id"] . "_" . date("dmy") . date("His") . "." . $file_extension;
			$full_destination_path = $this->config->item('hr_upload_profile_external_service') . $file_new_name;

			$old_file_path = $this->config->item('hr_upload_profile_external_service') . $this->M_hr_person_external_service->pexs_attach_file;
			if (file_exists($old_file_path) && is_file($old_file_path)) {
				unlink($old_file_path);
			}

			if (move_uploaded_file($file_tmp, $full_destination_path)) {
				$this->M_hr_person_external_service->pexs_attach_file = $file_new_name;	// แนบไฟล์เอกสารหลักฐาน 
			}
		}

		$this->M_hr_person->ps_id = $profile_external_service_form["ps_id"];
		$this->M_hr_person->get_by_key(true);

		if ($profile_external_service_form["pexs_id"] == "") {	//== insert
			$this->M_hr_person_external_service->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลบริการหน่วยงานภายนอก " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	// insert hr logs
		} else {	//== update
			$this->M_hr_person_external_service->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลบริการหน่วยงานภายนอก " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	// insert hr logs			
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_external_service_form["ps_id"]) . "/" . $profile_external_service_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_external_service_update


	/*
	* profile_reward_update
	* อัพเดทข้อมูลรางวัล
	* @input profile_reward_form
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 27/05/2024
	*/
	function profile_reward_update()
	{
		$profile_reward_form = $this->input->post();
		$profile_reward_form["ps_id"] = decrypt_id($profile_reward_form["ps_id"]);

		if ($profile_reward_form["rewd_id"] == "") {	//== insert
			$this->M_hr_person_reward->rewd_create_user = $this->session->userdata('us_id');	//รหัสผู้สร้าง (USID)
			$this->M_hr_person_reward->rewd_create_date = get_datetime_db();	//วันที่สร้าง
		} else {	//== update
			$this->M_hr_person_reward->rewd_id = decrypt_id($profile_reward_form["rewd_id"]);	//PK hr_reward 
			$this->M_hr_person_reward->get_by_key(true);
			$this->M_hr_person_reward->rewd_update_user = $this->session->userdata('us_id');	//รหัสผู้แก้ไข (USID)
			$this->M_hr_person_reward->rewd_update_date = get_datetime_db();	//วันที่แก้ไข
		}

		$this->M_hr_person_reward->rewd_ps_id = $profile_reward_form["ps_id"];	//รหัสบุคลากร (id.hr_person)
		$this->M_hr_person_reward->rewd_rwt_id = $profile_reward_form["rewd_rwt_id"];	//ด้านรางวัล 
		$this->M_hr_person_reward->rewd_rwlv_id = $profile_reward_form["rewd_rwlv_id"];	//ระดับรางวัล 
		$this->M_hr_person_reward->rewd_name_th = $profile_reward_form["rewd_name_th"];	//ชื่อรางวัลเชิดชูเกียรติ (ภาษาไทย) 
		$this->M_hr_person_reward->rewd_name_en = $profile_reward_form["rewd_name_en"];	//ชื่อรางวัลเชิดชูเกียรติ (ภาษาอังกฤษ) 
		$this->M_hr_person_reward->rewd_org_th = $profile_reward_form["rewd_org_th"];	//หน่วยงานที่มอบรางวัล (ภาษาอังกฤษ) 
		$this->M_hr_person_reward->rewd_org_en = $profile_reward_form["rewd_org_en"];	//หน่วยงานที่มอบรางวัล (ภาษาไทย)

		$this->M_hr_person_reward->rewd_year = $profile_reward_form["rewd_year"];	//ปีพุทธศักราช (พ.ศ.) ที่เริ่มเผยแพร่


		if ($profile_reward_form["select_reward_date"] == 1) {
			$this->M_hr_person_reward->rewd_date = "0000-00-00";	//วันที่เริ่มศึกษา 
		} else {
			$this->M_hr_person_reward->rewd_date = splitDateForm1($profile_reward_form["rewd_date"]);	//วันที่เริ่มศึกษา 
		}

		foreach (['rewd_reward_file', 'rewd_cert_file'] as $file_input) {
			if (isset($_FILES[$file_input]) && $_FILES[$file_input]['error'] === UPLOAD_ERR_OK) {
				// Assuming $file_tmp is the temporary name of the uploaded file
				$file_tmp = $_FILES[$file_input]['tmp_name'];

				// Get the MIME type of the uploaded file
				$file_mime_type = mime_content_type($file_tmp);

				// Determine the file extension based on the MIME type
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
						// Handle unknown file types or throw an error
						$data['status_response'] = $this->config->item('status_response_error');
						throw new Exception('Unsupported file type');
						break;
				}

				// Determine the prefix based on the file type
				$file_prefix = ($file_input === 'rewd_reward_file') ? 'reward_' : 'cerf_';

				// Generate the new file name with the correct prefix, profile ID, and extension
				$file_new_name = $file_prefix . $profile_reward_form["ps_id"] . "_" . date("dmy") . date("His") . "." . $file_extension;

				// Specify the destination directory where the file should be moved
				$full_destination_path = $this->config->item('hr_upload_profile_reward') . $file_new_name;

				// Check if an old file exists and delete it
				$old_file_path = $this->config->item('hr_upload_profile_reward') . $this->M_hr_person_reward->{$file_input};
				if (file_exists($old_file_path) && is_file($old_file_path)) {
					unlink($old_file_path);
				}

				if (move_uploaded_file($file_tmp, $full_destination_path)) {
					// Update the model property with the new file name after successful upload
					$this->M_hr_person_reward->{$file_input} = $file_new_name;    //แนบไฟล์เอกสารหลักฐาน 
				}
			}
		}

		$this->M_hr_person->ps_id = $profile_reward_form["ps_id"];
		$this->M_hr_person->get_by_key(true);

		if ($profile_reward_form["rewd_id"] == "") {	//== insert
			$this->M_hr_person_reward->insert();
			$this->M_hr_logs->insert_log("เพิ่มข้อมูลรางวัลของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		} else {	//== update
			$this->M_hr_person_reward->update();
			$this->M_hr_logs->insert_log("แก้ไขข้อมูลรางวัลของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($profile_reward_form["ps_id"]) . "/" . $profile_reward_form["tab_active"]);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// profile_reward_update

	/*
	* get_amph_by_pv_id
	* ดึงข้อมูลอำเภอตามไอดีจังหวัด
	* @input pv_id
	* $output amphur list by pv_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_amph_by_pv_id()
	{
		$pv_id = $this->input->post('pv_id');
		$result = $this->M_hr_person->get_amphur_by_province_id($pv_id)->result();
		echo json_encode($result);
	}
	// get_amph_by_pv_id

	/*
	* get_dist_by_amph_id
	* ดึงข้อมูลตำบลตามไอดีอำเภอ
	* @input amph_id
	* $output district list by amph_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_dist_by_amph_id()
	{
		$amph_id = $this->input->post('amph_id');
		$result = $this->M_hr_person->get_district_by_amphur_id($amph_id)->result();
		echo json_encode($result);
	}
	// get_dist_by_amph_id

	/*
	* get_postal_code_by_dist_id
	* ดึงข้อมูลเลขไปรษณีย์ตามไอดีของตำบล
	* @input dist_id
	* $output zipcode list by dist_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	public function get_postal_code_by_dist_id()
	{
		$dist_id = $this->input->post('dist_id');

		$result = $this->M_hr_person->get_zipcode_by_dist_id($dist_id)->row();
		echo json_encode($result);
	}
	// get_postal_code_by_dist_id

	/*
	* get_edudg_by_edulv_id
	* ดึงข้อมูลระดับการศึกษาตามวุฒิการศึกษา
	* @input edulv_id
	* $output education degree list by edulv id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 23/05/2024
	*/
	function get_edudg_by_edulv_id()
	{
		$edulv_id = $this->input->post('edulv_id');
		$result = $this->M_hr_person_education->get_education_degree_by_edulv_id($edulv_id)->result();
		echo json_encode($result);
	}
	// get_edudg_by_edulv_id

	/*
	* get_profile_person_education_list
	* ข้อมูลรายการประวัติการศึกษา
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/05/2024
	*/
	public function get_profile_person_education_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_education->get_all_person_education_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->edu_id = encrypt_id($row->edu_id);
			$row->edu_start_date = ($row->edu_start_date == "0000-00-00" ? ($row->edu_start_year+543) : abbreDate2($row->edu_start_date));
			$row->edu_end_date = ($row->edu_end_date == "0000-00-00" ? ($row->edu_end_year+543) : abbreDate2($row->edu_end_date));
		}

		echo json_encode($result);
	}
	// get_profile_person_education_list
	public function save_new_education_order()
	{
		$data = $this->input->post();
		foreach ($data['order'] as $key => $value) {
			$this->M_hr_person_education->edu_id = decrypt_id($value['edu_id']);
			$this->M_hr_person_education->edu_seq = $value['edu_seq'];
			$this->M_hr_person_education->update_seq();
		}
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/*
	* get_education_detail_by_id
	* ข้อมูลรายการประวัติการศึกษาตามไอดี
	* @input edu_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/05/2024
	*/
	public function get_education_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$edu_id = decrypt_id($this->input->post('edu_id'));
		$result = $this->M_hr_person_education->get_education_detail_by_id($edu_id)->result();

		foreach ($result as $key => $row) {
			$row->edu_id = encrypt_id($row->edu_id);

			$currentDate = date('d/m/Y');
			// แยกส่วนวันที่ เดือน และปี
			list($day, $month, $year) = explode('/', $currentDate);
			// สร้างวันที่ใหม่ในรูปแบบที่ต้องการ
			$currentDateThai = sprintf('%02d/%02d/%d', $day, $month, ($year + 543));

			$row->edu_start_date = ($row->edu_start_date == "0000-00-00" ? $currentDateThai : date('d/m/Y', strtotime($row->edu_start_date . ' +543 years')));
			$row->edu_end_date = ($row->edu_end_date == "0000-00-00" ? $currentDateThai : date('d/m/Y', strtotime($row->edu_end_date . ' +543 years')));

			$row->edu_start_year += 543;
			$row->edu_end_year += 543;
		}

		echo json_encode($result);
	}
	// get_education_detail_by_id


	/*
	* get_profile_person_license_list
	* ข้อมูลรายการใบประกอบวิชาชีพ
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function get_profile_person_license_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_license->get_all_person_license_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->licn_id = encrypt_id($row->licn_id);
			$row->licn_start_date = abbreDate2($row->licn_start_date);
			$row->licn_end_date = ($row->licn_end_date == "9999-12-31" ? "ตลอดชีพ" : abbreDate2($row->licn_end_date));
		}

		echo json_encode($result);
	}
	// get_profile_person_license_list

	/*
	* get_profile_person_external_service_list
	* ข้อมูลรายการบริการหน่วยงานภายนอก
	* @input ps_id
	* @output JSON encoded list of external services
	* @author 
	* @Create Date 29/05/2024
	*/
	public function get_profile_person_external_service_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_external_service->get_all_external_service_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->pexs_id = encrypt_id($row->pexs_id);
			$row->pexs_date = abbreDate2($row->pexs_date);
		}

		echo json_encode($result);
	}
	// get_profile_person_external_service_list


	/*
	* get_license_detail_by_id
	* ข้อมูลรายละเอียดใบประกอบวิชาชีพตามไอดี
	* @input licn_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function get_license_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$licn_id = decrypt_id($this->input->post('licn_id'));
		$result = $this->M_hr_person_license->get_license_detail_by_id($licn_id)->result();

		foreach ($result as $key => $row) {
			$row->licn_id = encrypt_id($row->licn_id);

			$row->licn_start_date = date('d/m/Y', strtotime($row->licn_start_date . ' +543 years'));
			$row->licn_end_date = ($row->licn_end_date == "9999-12-31" ? "" : date('d/m/Y', strtotime($row->licn_end_date . ' +543 years')));
		}

		echo json_encode($result);
	}
	// get_license_detail_by_id

	/*
	* get_external_service_detail_by_id
	* ข้อมูลรายละเอียดบริการหน่วยงานภายนอกตามไอดี
	* @input pexs_id
	* @output -
	* @Author
	* @Create Date 29/05/2024
	*/
	public function get_external_service_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$pexs_id = decrypt_id($this->input->post('pexs_id'));
		$result = $this->M_hr_person_external_service->get_external_service_detail_by_id($pexs_id)->result();

		foreach ($result as $key => $row) {
			$row->pexs_id = encrypt_id($row->pexs_id);

			$row->pexs_date = date('d/m/Y', strtotime($row->pexs_date . ' +543 years'));
		}

		echo json_encode($result);
	}
	// get_external_service_detail_by_id


	/*
	* get_profile_person_work_history_list
	* ข้อมูลรายการประสบการณ์ทำงาน
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function get_profile_person_work_history_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_work_history->get_all_person_work_history_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->wohr_id = encrypt_id($row->wohr_id);
			$row->wohr_start_date = abbreDate2($row->wohr_start_date);
			$row->wohr_end_date = ($row->wohr_end_date == "9999-12-31" ? "ปัจจุบัน" : abbreDate2($row->wohr_end_date));
		}
		echo json_encode($result);
	}
	// get_profile_person_work_history_list
	/*
	* check_date_value
	* เช็คตัวแปรวันว่าได้ระบุวันหรือไม่
	* @input wohr_id
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 05/08/2024
	*/
	public function check_date_value($value)
	{
		// ตรวจสอบว่าค่าที่รับเข้ามาเป็นวันที่ `00`
		// ค่าต้องมีรูปแบบ d/m/Y
		$parts = explode('-', $value);
		// ตรวจสอบว่ามีส่วนของวันเป็น '00'
		if ($parts[2] === '00') {
			// ถ้าส่วนของวันเป็น '00'
			$month = $parts[1] ?? 'mm';
			$year = $parts[0] ?? 'yyyy';

			// เพิ่ม 543 ปีให้กับปีที่ได้รับ
			if (is_numeric($year)) {
				$year = (int)$year + 543;
			}

			// คืนค่าที่จัดรูปแบบแล้ว
			return "00/{$month}/{$year}";
		} else {
			// แปลงวันที่จากรูปแบบ d/m/Y เป็น DateTime
			$date = date('d/m/Y', strtotime($value . ' +543 years'));
			if ($date) {
				return $date;
			}
		}
	}
	/*
	* get_work_history_detail_by_id
	* ข้อมูลรายละเอียดประสบการณ์ทำงานตามไอดี
	* @input wohr_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function get_work_history_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$wohr_id = decrypt_id($this->input->post('wohr_id'));
		$result = $this->M_hr_person_work_history->get_work_history_detail_by_id($wohr_id)->result();
		foreach ($result as $key => $row) {
			$row->wohr_id = encrypt_id($row->wohr_id);
			$row->wohr_start_date = $this->check_date_value($row->wohr_start_date);
			$row->wohr_end_date = ($row->wohr_end_date == "9999-12-31" ? "" : $this->check_date_value($row->wohr_end_date));
		}
		echo json_encode($result);
	}
	// get_work_history_detail_by_id

	/*
	* get_profile_person_expert_list
	* ข้อมูลรายการความชำนาญ
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	public function get_profile_person_expert_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_expert->get_all_person_expert_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->expt_id = encrypt_id($row->expt_id);
		}

		echo json_encode($result);
	}
	// get_profile_person_expert_list

	/*
	* get_expert_detail_by_id
	* ข้อมูลรายละเอียดความชำนาญตามไอดี
	* @input expt_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	public function get_expert_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$expt_id = decrypt_id($this->input->post('expt_id'));
		$result = $this->M_hr_person_expert->get_expert_detail_by_id($expt_id)->result();

		foreach ($result as $key => $row) {
			$row->expt_id = encrypt_id($row->expt_id);
		}

		echo json_encode($result);
	}
	// get_expert_detail_by_id

	/*
	* get_profile_person_reward_list
	* ข้อมูลรายการรางวัล
	* @input ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	public function get_profile_person_reward_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$ps_id = decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person_reward->get_all_person_reward_data($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->rewd_id = encrypt_id($row->rewd_id);
			$row->rewd_date = ($row->rewd_date == "0000-00-00" ? date('d/m/Y', strtotime($row->wohr_end_date . ' +543 years')) : date('d/m/Y', strtotime($row->rewd_date . ' +543 years')));
		}

		echo json_encode($result);
	}
	// get_profile_person_reward_list

	/*
	* get_reward_detail_by_id
	* ข้อมูลรายละเอียดรางวัลตามไอดี
	* @input rewd_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	public function get_reward_detail_by_id()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$rewd_id = decrypt_id($this->input->post('rewd_id'));
		$result = $this->M_hr_person_reward->get_reward_detail_by_id($rewd_id)->result();

		foreach ($result as $key => $row) {
			$row->rewd_id = encrypt_id($row->rewd_id);
			$row->rewd_date = ($row->rewd_date == "0000-00-00" ? $row->rewd_date : abbreDate2($row->rewd_date));
		}

		echo json_encode($result);
	}
	// get_reward_detail_by_id

	/*
	* delete_education_data_by_param
	* ลบข้อมูลประวัติการศึกษา
	* @input delete_id, tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function delete_education_data_by_param()
	{
		$edu_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_education->edu_id = $edu_id;
		$this->M_hr_person_education->get_by_key(true);
		$ps_id = $this->M_hr_person_education->edu_ps_id;

		// Check if an old file exists and delete it
		$old_file_path = $this->config->item('hr_upload_profile_education') . $this->M_hr_person_education->edu_attach_file;
		if (file_exists($old_file_path) && is_file($old_file_path)) {
			unlink($old_file_path);
		}

		$this->M_hr_person_education->delete();

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลประวัติการศึกษาของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_education_data_by_param

	/*
	* delete_license_data_by_param
	* ลบข้อมูลใบประกอบวิชาชีพ
	* @input delete_id, tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function delete_license_data_by_param()
	{
		$licn_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_license->licn_id = $licn_id;
		$this->M_hr_person_license->get_by_key(true);
		$ps_id = $this->M_hr_person_license->licn_ps_id;

		// Check if an old file exists and delete it
		$old_file_path = $this->config->item('hr_upload_profile_license') . $this->M_hr_person_license->licn_attach_file;
		if (file_exists($old_file_path) && is_file($old_file_path)) {
			unlink($old_file_path);
		}

		$this->M_hr_person_license->delete();

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลใบประกอบวิชาชีพของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_license_data_by_param

	/*
	* delete_external_service_data_by_param
	* ลบข้อมูลบริการหน่วยงานภายนอก
	* @input delete_id, tab_active
	* $output -
	* @Author
	* @Create Date 29/05/2024
	*/
	public function delete_external_service_data_by_param()
	{
		$pexs_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_external_service->pexs_id = $pexs_id;
		$this->M_hr_person_external_service->get_by_key(true);
		$ps_id = $this->M_hr_person_external_service->pexs_ps_id;

		// Check if an old file exists and delete it
		$old_file_path = $this->config->item('hr_upload_profile_external_service') . $this->M_hr_person_external_service->pexs_attach_file;
		if (file_exists($old_file_path) && is_file($old_file_path)) {
			unlink($old_file_path);
		}

		$this->M_hr_person_external_service->delete();

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลบริการหน่วยงานภายนอกของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname); // Insert HR logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_external_service_data_by_param


	/*
	* delete_work_history_data_by_param
	* ลบข้อมูลประสบการณ์ทำงาน
	* @input delete_id, tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function delete_work_history_data_by_param()
	{
		$wohr_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_work_history->wohr_id = $wohr_id;
		$this->M_hr_person_work_history->get_by_key(true);
		$ps_id = $this->M_hr_person_work_history->wohr_ps_id;

		$this->M_hr_person_work_history->delete();

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลประสบการณ์ทำงานของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_work_history_data_by_param

	/*
	* delete_expert_data_by_param
	* ลบข้อมูลความชำนาญ
	* @input delete_id, tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function delete_expert_data_by_param()
	{
		$expt_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_expert->expt_id = $expt_id;
		$this->M_hr_person_expert->get_by_key(true);
		$ps_id = $this->M_hr_person_expert->expt_ps_id;

		$this->M_hr_person_expert->delete();

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลความชำนาญของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_expert_data_by_param

	/*
	* delete_reward_data_by_param
	* ลบข้อมูลรางวัล
	* @input delete_id, tab_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	public function delete_reward_data_by_param()
	{
		$rewd_id = decrypt_id($this->input->post('delete_id'));
		$tab_active = $this->input->post('tab_active');

		$this->M_hr_person_reward->rewd_id = $rewd_id;
		$this->M_hr_person_reward->get_by_key(true);
		$ps_id = $this->M_hr_person_reward->rewd_ps_id;

		$this->M_hr_person_reward->delete();

		// Check if an old file exists and delete it
		$old_file_reward_path = $this->config->item('hr_upload_profile_reward') . $this->M_hr_person_reward->rewd_reward_file;
		if (file_exists($old_file_reward_path) && is_file($old_file_reward_path)) {
			unlink($old_file_reward_path);
		}

		// Check if an old file exists and delete it
		$old_file_cerf_path = $this->config->item('hr_upload_profile_reward') . $this->M_hr_person_reward->rewd_cert_file;
		if (file_exists($old_file_cerf_path) && is_file($old_file_cerf_path)) {
			unlink($old_file_cerf_path);
		}

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person->get_by_key(true);
		$this->M_hr_logs->insert_log("ลบข้อมูลรางวัลของ " . $this->M_hr_person->ps_fname . " " . $this->M_hr_person->ps_lname);	//insert hr logs

		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_url'] = site_url($this->controller . "get_profile_user/" . encrypt_id($ps_id) . "/" . $tab_active);

		$result = array('data' => $data);
		echo json_encode($result);
	}
	// delete_reward_data_by_param

	/*
	* get_hr_base_prefix_data
	* ดึงข้อมูลคำนำหน้าชื่อ ตามเพศที่เลือก
	* @input - gd_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/06/2024
	*/
	public function get_hr_base_prefix_data()
	{
		$gd_id = $this->input->post('gd_id');
		$result = $this->M_hr_person->get_hr_base_prefix_data($gd_id)->result();
		echo json_encode($result);
	}
	// get_hr_base_prefix_data

	/*
	* get_hr_base_place_data
	* ดึงข้อมูลสถานที่
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/06/2024
	*/
	public function get_hr_base_place_data()
	{
		$result = $this->M_hr_person->get_hr_base_place_data()->result();
		echo json_encode($result);
	}
	// get_hr_base_place_data

	/*
	* get_person_history
	* ดึงประวัติการเปลี่ยนข้อมูลส่วนตัว
	* @input - ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 15/07/2024
	*/
	function get_person_history()
	{
		$ps_id =  decrypt_id($this->input->get('ps_id'));

		$result = $this->M_hr_person->get_person_history_by_ps_id($ps_id)->result();

		foreach ($result as $key => $row) {
			$row->hips_start_date = abbreDate2($row->hips_start_date);
			$row->hips_end_date = ($row->hips_end_date != "9999-12-31" ? abbreDate2($row->hips_end_date) : abbreDate2(getNowDate()) . " (ปัจจุบัน)");
			$row->hips_update_date = abbreDate4($row->hips_update_date);
		}

		echo json_encode($result);
	}
	// get_person_history
	function get_structure_detail_by_stuc_id()
	{
		$stuc_id = $this->input->post('stuc_id');
		$result = $this->M_hr_person->get_structure_detail_by_confirm($stuc_id)->result();
		echo json_encode($result);
	}
}
