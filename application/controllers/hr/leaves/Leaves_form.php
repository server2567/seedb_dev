<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Tanadon Tangjaimongkhon
* @Create Date 24/10/2567
*/
include_once('Leaves_Controller.php');

class Leaves_form extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Leaves_form/";
		$this->view .= "leaves_form/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_leave_history');
		$this->load->model($this->model . 'M_hr_leave_history_detail');
		$this->load->model($this->model . 'M_hr_leave_approve_flow');
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
		$this->mn_active_url = uri_string();
	}

	/*
	* get_leaves_person_list
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	public function get_leaves_person_list($ps_id = "")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		if($ps_id == ""){
			$this->session->unset_userdata('leaves_by_pass');
		}

		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));

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

		$this->output($this->view.'v_leaves_person_list', $data);
	}

	/*
	* get_leaves_list_by_param
	* แสดงรายการประวัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function get_leaves_list_by_param(){
		$ps_id = decrypt_id($this->input->post('ps_id'));
		$start_date = splitDateForm1($this->input->post('start_date'));
		$end_date = splitDateForm1($this->input->post('end_date'));
		$result = $this->M_hr_leave_history->get_leave_all_by_ps_id($ps_id, $this->input->post('leave_id'), $this->input->post('status'), $start_date, $end_date)->result();
		
		foreach($result as $key=>$row){
			$row->lhis_id = encrypt_id($row->lhis_id);
			$row->lhis_ps_id = encrypt_id($row->lhis_ps_id);
			$row->lhis_start_date = abbreDate2($row->lhis_start_date);
			$row->lhis_end_date = abbreDate2($row->lhis_end_date);
		}

		echo json_encode($result);
		
		
	}
	// get_leaves_list_by_param

	/*
	* select_leaves_person_list
	* แสดงรายชื่อการลาแทนบุคคลอื่น
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function select_leaves_person_list(){
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

		$this->session->set_userdata('leaves_by_pass','show');

		// pre($this->session->all_userdata()); die;
		$this->output($this->view . 'v_leaves_select_person_list', $data);
	}
	// select_leaves_person_list

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
		$hire_id = $this->input->get('hire_id');
		$hire_type = $this->input->get('hire_type');
		$status_id = $this->input->get('status_id');

		$result = $this->M_hr_person->get_all_profile_data_by_param($dp_id, $hire_id, $hire_type, $status_id)->result();
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

	/*
	* leaves_type
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function leaves_type($ps_id)
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$data['ps_id'] = $ps_id;
		$ps_id = decrypt_id($ps_id);
		$data['leave_type_list'] = $this->M_hr_leave_history->get_leave_type_by_person($ps_id)->result();
		if (date("n") == 12) {
			$year = date('Y')+1;
			$data['leave_type_list_nextYear'] = $this->M_hr_leave_history->get_leave_type_by_person($ps_id,"",$year)->result();
			// pre($data['leave_type_list_nextYear']);
		}
		$this->output($this->view . 'v_leaves_type_list', $data);
	} //end leaves_type

	/*
	* leaves_input
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function leaves_input($lhis_leave_id, $ps_id, $year)
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$data['lhis_leave_id'] = $lhis_leave_id;

		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));
		$data['year'] = decrypt_id($year);

		$data['view_dir'] = $this->view;

		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();

        $stde_group = '';
        $department = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
        foreach ($department as $key => $value) {
            if ($key == 0) {
                $stuc_person = $this->M_hr_person->get_person_position_by_ums_department_detail($ps_id, $value->dp_id)->row();
                if ($stuc_person->stde_name_th_group !== null) {
                    $stde_name_th_group = json_decode($stuc_person->stde_name_th_group, true);
                    $stde_group .= '<b>สังกัด</b>' . $value->dp_name_th . ' <b>ตำแหน่ง</b> ' . $stuc_person->alp_name . '<br><b>ตำแหน่งในโครงสร้าง</b> ';
                    foreach ($stde_name_th_group as $stde_key => $stde_name) {
                        if ($stde_key > 0) {
                            $stde_group .= ',';
                        }
                        $stde_group .= ' ' . $stde_name['stde_name_th'];
                    }
                } else {
                    $stde_group .= '<b>สังกัด</b> ' . $value->dp_name_th . ' <b>ตำแหน่ง<b> ' . $stuc_person->alp_name . ' กลุ่มงาน -';
                }
                break;
            }
        }
		$data['stde_group'] = $stde_group;

		$data['lastest_leave_id'] = $this->M_hr_leave_history->get_lastest_lhis_leave_id_by_ps_id($ps_id, $lhis_leave_id)->row();
		$data['person_replace_list'] = $this->M_hr_leave_history->get_person_replace_list()->result();
		$data['leave_type_list'] = $this->M_hr_leave_history->get_leave_type_by_person($ps_id, $lhis_leave_id, $data['year'])->result();
		
		$this->output($this->view . 'v_leaves_form_input_' . $lhis_leave_id, $data);
	} //end leaves_input

	/*
	* leaves_save
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	public function leaves_save()
	{
		$lhis_ps_id = $this->input->post('lhis_ps_id'); // รับค่า ID พนักงานที่ขอการลา
		$lhis_leave_id = $this->input->post('lhis_leave_id'); // รับค่า ID ประเภทการลา เช่น ลาป่วย ลากิจ ฯลฯ
		$lhis_start_date = $this->input->post('leaves_start_date'); // รับวันที่เริ่มต้นการลา
		$lhis_end_date = $this->input->post('leaves_end_date'); // รับวันที่สิ้นสุดการลา
		list($lhis_num_day, $lhis_num_hour, $lhis_num_minute) = explode("-", $this->input->post('leaves_summary_value')); // รับจำนวนวัน ชั่วโมง และนาทีที่ลาจากอินพุตที่ส่งมา โดยแยกข้อมูลตามเครื่องหมาย "-"
		$lhis_year = $this->input->post('lhis_year'); // ดึงปีปัจจุบันสำหรับการบันทึกข้อมูล
		$lhis_topic = $this->input->post('leaves_detail'); // รับหัวข้อรายละเอียดของการลา เช่น เหตุผลที่ลา
		$lhis_address = $this->input->post('leaves_address'); // รับที่อยู่ขณะลางาน
		$lhis_write_place = $this->input->post('leaves_location_create'); // รับสถานที่เขียนใบลาหรือสถานที่สร้างคำขอลา
		$lhis_write_date = $this->input->post('leaves_create_date'); // รับวันที่สร้างคำขอลา
		$lhis_replace_id = $this->input->post('leaves_replace_id'); // รับ ID ของผู้ที่รับผิดชอบงานแทนในกรณีที่มีคนทำงานแทน
		$lhis_tell = $this->input->post('leaves_from'); // รับเบอร์โทรศัพท์สำหรับการติดต่อในระหว่างที่ลางาน

		// pre($this->input->post()); die;

		// ตรวจสอบว่าผู้ใช้งานเลือกตัวเลือก "ข้ามการอนุมัติ" หรือไม่
		$by_pass_leave_post = $this->input->post('by_pass_leave');
		$by_pass_leave = isset($by_pass_leave_post) ? "show" : "";

		// ตรวจสอบว่าผู้ใช้งานมีสิทธิการลาเพียงพอหรือไม่
		$is_check_leave_balance = $this->check_leave_balance_data(
			encrypt_id($lhis_ps_id), 
			$lhis_year, 
			$lhis_leave_id, 
			$lhis_num_day, 
			$lhis_num_hour, 
			$lhis_num_minute
		);

		// ถ้าสิทธิการลาไม่เพียงพอ
		if ($is_check_leave_balance['status'] == 0) {
			// ส่งสถานะผิดพลาดกลับไปพร้อมข้อความแจ้งเตือน
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $is_check_leave_balance['message'];
		} else {
			// ตรวจสอบว่ามีการอัพโหลดไฟล์หรือไม่
			if (isset($_FILES['leaves_upload_file']) && $_FILES['leaves_upload_file']['error'] === UPLOAD_ERR_OK) {
				// ดึงข้อมูลไฟล์ที่อัพโหลด
				$file_tmp = $_FILES['leaves_upload_file']['tmp_name'];
				$file_mime_type = $_FILES['leaves_upload_file']['type'];
				$original_file_name = pathinfo($_FILES['leaves_upload_file']['name'], PATHINFO_FILENAME);

				// ตรวจสอบประเภทไฟล์ว่าเป็นชนิดที่รองรับหรือไม่
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

				// สร้างชื่อไฟล์ใหม่โดยรวมวันที่ เวลา และรหัสเฉพาะ
				$file_new_name = date("dmYHis") . '_' . uniqid() . '.' . $file_extension;
				$full_destination_path = $this->config->item('hr_upload_leaves') . $file_new_name;

				// ย้ายไฟล์ที่อัพโหลดไปยังโฟลเดอร์ปลายทาง
				if (move_uploaded_file($file_tmp, $full_destination_path)) {
					// บันทึกชื่อไฟล์ในฐานข้อมูล
					$this->M_hr_leave_history->lhis_attach_file = $file_new_name;
				} else {
					// แจ้งข้อผิดพลาดหากไฟล์ไม่สามารถอัพโหลดได้
					$data['status_response'] = $this->config->item('status_response_error');
					$data['message_dialog'] = "ไม่สามารถอัพโหลดไฟล์เอกสารได้";
				}
			}

			// คำนวณเวลาการลาในหน่วยนาทีทั้งหมด
			$lhis_sum_minutes = ($lhis_num_day * 8 * 60) + ($lhis_num_hour * 60) + $lhis_num_minute;

			// เตรียมข้อมูลสำหรับบันทึกลงในฐานข้อมูล
			$this->M_hr_leave_history->lhis_ps_id = $lhis_ps_id;
			$this->M_hr_leave_history->lhis_leave_id = $lhis_leave_id;
			$this->M_hr_leave_history->lhis_start_date = splitDateForm1($lhis_start_date);
			$this->M_hr_leave_history->lhis_end_date = splitDateForm1($lhis_end_date);
			$this->M_hr_leave_history->lhis_num_day = $lhis_num_day;
			$this->M_hr_leave_history->lhis_num_hour = $lhis_num_hour;
			$this->M_hr_leave_history->lhis_num_minute = $lhis_num_minute;
			$this->M_hr_leave_history->lhis_sum_minutes = $lhis_sum_minutes;
			$this->M_hr_leave_history->lhis_year = $lhis_year;
			$this->M_hr_leave_history->lhis_topic = $lhis_topic;
			$this->M_hr_leave_history->lhis_address = $lhis_address;
			$this->M_hr_leave_history->lhis_write_place = $lhis_write_place;
			$this->M_hr_leave_history->lhis_write_date = splitDateForm1($lhis_write_date);
			$this->M_hr_leave_history->lhis_replace_id = $lhis_replace_id;

			// ตรวจสอบเส้นทางการอนุมัติ
			$leaves_approve_group = $this->M_hr_leave_history->check_leaves_approve_group_by_ps_id($lhis_ps_id);

			if ($leaves_approve_group->num_rows() == 0) {
				// ถ้าไม่มีเส้นทางการอนุมัติ ให้ปรับสถานะเป็น "อนุมัติแล้ว"
				$lhis_status = "Y";
				$this->update_leave_summary_data(
					encrypt_id($lhis_ps_id), 
					$lhis_year, 
					$lhis_leave_id, 
					$lhis_num_day, 
					$lhis_num_hour, 
					$lhis_num_minute
				);
			} else if($leaves_approve_group->num_rows() == 1){
				$row_laps = $leaves_approve_group->row();
				$lhis_status = 1;
			} else {
				// ถ้ามีเส้นทางการอนุมัติ ให้ตั้งสถานะเริ่มต้นเป็น "รออนุมัติ"
				$row_laps = $leaves_approve_group->result()[0];
				$lhis_status = 1;
			}

			// ถ้าผู้ใช้งานเลือกข้ามการอนุมัติ ให้ปรับสถานะเป็น "อนุมัติแล้ว"
			if ($by_pass_leave == "show") {
				$lhis_status = "Y";
			}

			// บันทึกสถานะการลา
			$this->M_hr_leave_history->lhis_status = $lhis_status;
			$this->M_hr_leave_history->lhis_tell = $lhis_tell;
			$this->M_hr_leave_history->lhis_create_user = $this->session->userdata('us_id');
			$this->M_hr_leave_history->lhis_create_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_history->insert();

			// ดึง ID ล่าสุดที่ถูกเพิ่มในตารางประวัติการลา
			$lhis_last_insert_id = $this->M_hr_leave_history->last_insert_id;

			// เข้ารหัส ID ล่าสุดสำหรับการใช้งานในลักษณะปลอดภัย
			$lhis_previwe_id = encrypt_id($this->M_hr_leave_history->last_insert_id);

			if($lhis_status != "Y"){
				// ดึงข้อมูลรายละเอียดกลุ่มผู้อนุมัติสำหรับการลานี้ตาม ID กลุ่มการอนุมัติ
				$leaves_approve_group_detail = $this->M_hr_leave_history
				->check_leaves_approve_group_detail_by_lapg_id($row_laps->laps_lapg_id)
				->result();

				// วนลูปข้อมูลผู้อนุมัติในกลุ่ม เพื่อบันทึกแต่ละรายการในตารางการอนุมัติ
				foreach ($leaves_approve_group_detail as $key => $row) {
					$this->M_hr_leave_approve_flow->lafw_seq = $row->lage_seq; // ลำดับการอนุมัติ
					$this->M_hr_leave_approve_flow->lafw_ps_id = $row->lage_ps_id; // ID ของผู้ที่มีสิทธิ์อนุมัติในลำดับนี้
					$this->M_hr_leave_approve_flow->lafw_laps_id = $row->lage_last_id; // ID การอนุมัติปัจจุบันในระบบ
					$this->M_hr_leave_approve_flow->lafw_lapg_id = $row->lage_lapg_id; // ID กลุ่มการอนุมัติ
					$this->M_hr_leave_approve_flow->lafw_last_id = $row->lage_last_id; // ID การอนุมัติสุดท้ายในกลุ่มนี้
					$this->M_hr_leave_approve_flow->lafw_lhis_id = $lhis_last_insert_id; // เชื่อมโยงกับ ID ประวัติการลาที่สร้างขึ้น
					$this->M_hr_leave_approve_flow->lafw_status = "W"; // ตั้งสถานะเริ่มต้นเป็น "รออนุมัติ (W)"
					$this->M_hr_leave_approve_flow->lafw_comment = ""; // ตั้งค่าความคิดเห็นเริ่มต้นเป็นค่าว่าง
					$this->M_hr_leave_approve_flow->lafw_update_user = ""; // ตั้งค่าผู้ที่แก้ไขเป็นค่าว่าง (ยังไม่มีผู้แก้ไข)
					$this->M_hr_leave_approve_flow->lafw_update_date = ""; // ตั้งค่าวันที่แก้ไขเป็นค่าว่าง (ยังไม่มีการแก้ไข)
					$this->M_hr_leave_approve_flow->insert(); // บันทึกข้อมูลการอนุมัติลงในตารางฐานข้อมูล
				}
			}

			$leaves_count_select = $this->input->post("leaves_count_select"); // รับจำนวนรายการการลาที่ถูกเลือก


			$lhde_seq = 0; // กำหนดตัวแปรลำดับรายการเริ่มต้น
			for ($i = 0; $i < $leaves_count_select; $i++) {
				$lhde_seq++; // เพิ่มลำดับของแต่ละรายการ

				// รับวันที่ลาของแต่ละรายการ
				$leaves_date = splitDateForm1($this->input->post("leaves_date_" . $i));
				$this->M_hr_leave_history_detail->lhde_date = $leaves_date;
				$this->M_hr_leave_history_detail->lhde_lhis_id = $lhis_last_insert_id; // เชื่อมโยงกับประวัติการลาหลัก

				// ตรวจสอบว่าการลานี้เป็นการลาหยุดตามประเพณีหรือไม่
				if ($lhis_leave_id == 2) {
					$leaves_clnd_id = $this->input->post('leaves_clnd_id');
					$this->M_hr_leave_history_detail->lhde_clnd_id = $leaves_clnd_id[$i];
					
				} else {
					$this->M_hr_leave_history_detail->lhde_clnd_id = ""; // ไม่มีการลาหยุดตามประเพณี
				}

				// รับประเภทการลาว่าเป็นทั้งวัน (Full Day) หรือครึ่งวัน (Half Day)
				$leaves_time_type = $this->input->post("leaves_time_type_" . $i);

				if ($leaves_time_type == 1) {
					// ถ้าเป็นทั้งวัน
					$this->M_hr_leave_history_detail->lhde_start_time = "00:00:00"; // เวลาเริ่มต้น
					$this->M_hr_leave_history_detail->lhde_end_time = "00:00:00";   // เวลาสิ้นสุด
					$this->M_hr_leave_history_detail->lhde_type_day = "D";          // ระบุว่าเป็น "ทั้งวัน"
					$this->M_hr_leave_history_detail->lhde_num_hour = 8;           // ชั่วโมงที่ใช้ = 8 ชั่วโมง
					$this->M_hr_leave_history_detail->lhde_num_minute = 0;         // นาทีที่ใช้ = 0 นาที
					$this->M_hr_leave_history_detail->lhde_sum_minutes = 480;     // เวลารวมเป็นนาที = 480 นาที
				} else {
					// ถ้าเป็นครึ่งวัน

					$this->M_hr_leave_history_detail->lhde_start_time = $this->input->post("leaves_start_time_" . $i); // เวลาเริ่มต้นที่กำหนด
					$this->M_hr_leave_history_detail->lhde_end_time = $this->input->post("leaves_end_time_" . $i);     // เวลาสิ้นสุดที่กำหนด
					$this->M_hr_leave_history_detail->lhde_type_day = "H";                                           // ระบุว่าเป็น "ครึ่งวัน"
					$this->M_hr_leave_history_detail->lhde_num_hour = $this->input->post("leaves_summary_hour_" . $i); // จำนวนชั่วโมง
					$this->M_hr_leave_history_detail->lhde_num_minute = $this->input->post("leaves_summary_minute_" . $i); // จำนวนนาที
					$this->M_hr_leave_history_detail->lhde_sum_minutes = ($this->M_hr_leave_history_detail->lhde_num_hour * 60) + $this->M_hr_leave_history_detail->lhde_num_minute; // เวลารวมเป็นนาที
				}

				// บันทึกรายละเอียดการลา
				$this->M_hr_leave_history_detail->lhde_seq = $lhde_seq; // ลำดับของแต่ละรายการ
				$this->M_hr_leave_history_detail->insert(); // บันทึกข้อมูลลงฐานข้อมูล
			}

			if ($this->session->userdata('leaves_by_pass') == "show") {
				$data['return_url'] = site_url($this->controller."get_leaves_person_list/".$lhis_ps_id); // URL กลับไปหน้าที่ต้องการ
			}
			else{
				$data['return_url'] = site_url($this->controller."get_leaves_person_list"); // URL กลับไปหน้าที่ต้องการ
			}
	
			// กำหนดค่าการตอบกลับหลังจากบันทึกข้อมูลเสร็จ
			$data['status_response'] = $this->config->item('status_response_success');
			$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
			$data['lhis_last_insert_id'] = $lhis_previwe_id;
			
		}

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);

	}//end leaves_save

	
	/*
	* get_leave_flow_by_lhis_id
	* ดึงข้อมูลเส้นทางการลาของไอดีใบลา
	* @input lhis_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/10/2567
	*/
	function get_leave_flow_by_lhis_id(){
		$lhis_id = $this->input->post('lhis_id');

		$this->M_hr_leave_history->lhis_id = $lhis_id;
		$this->M_hr_leave_history_detail->lhde_lhis_id = $lhis_id;
		$result['leave_topic'] = $this->M_hr_leave_history->get_by_key()->result();
		$result['leave_detail'] = $this->M_hr_leave_history_detail->get_by_key()->result();
		$result['leave_flow'] = $this->M_hr_leave_approve_flow->get_leave_flow_all_by_lhis_id($lhis_id)->result();
		echo json_encode($result);
	}
	// get_leave_flow_by_lhis_id

	/*
	* check_timework_plan_for_leave
	* ตรวจสอบเวลาการทำงาน
	* @input start_date, end_date
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/10/2567
	*/
	function check_timework_plan_for_leave(){
		// $this->load->model($this->config->item('hr_dir').$this->config->item('hr_timework_dir') . 'M_hr_timework_person_plan');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$ps_id = decrypt_id($this->input->post('ps_id'));
		
		$result = $this->M_hr_leave_history->get_all_timework_data_by_date($ps_id, $start_date, $end_date);



		echo json_encode($result);
	}
	// check_timework_plan_for_leave

	/*
	* get_base_calendar_for_leave
	* ดึงข้อมูลวันหยุดตามประเพณีจากปฏิทิน
	* @input year_now, start_date, end_date, ps_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/10/2567
	*/
	function get_base_calendar_for_leave(){
		// $this->load->model($this->config->item('hr_dir').$this->config->item('hr_timework_dir') . 'M_hr_timework_person_plan');
		$year_now = (new DateTime())->format("Y"); // ดึงปีปัจจุบัน

		$start_date = splitDateForm1($this->input->post('start_date'));
		$end_date = splitDateForm1($this->input->post('end_date'));
		$ps_id = decrypt_id($this->input->post('ps_id'));
		
		$result = $this->M_hr_leave_history->get_base_calendar_for_leave($year_now, $ps_id, $start_date, $end_date)->result();

		foreach ($result as $key => $row) {
			// กำหนดค่าตัวแปร start_date และ end_date ก่อนแปลง
			$start_date = $row->clnd_start_date;
			$end_date = $row->clnd_end_date;
		
			// ตรวจสอบเงื่อนไข หากวันที่เริ่มต้นเท่ากับวันที่สิ้นสุด
			if ($start_date === $end_date) {
				$row->clnd_name .= " (" . abbreDate2($start_date) . ")"; // เพิ่มเฉพาะวันที่เริ่มต้น
			} else {
				$row->clnd_name .= " (" . abbreDate2($start_date) . " - " . abbreDate2($end_date) . ")"; // เพิ่มช่วงวันที่
			}
		}		

		echo json_encode($result);
	}
	// get_base_calendar_for_leave




	/*
	* leaves_approve_flow
	* แสดงเส้นทางอนุมัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function leaves_approve_flow($lhis_id)
	{
		$lhis_id = decrypt_id($lhis_id);
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$this->M_hr_leave_history_detail->lhde_lhis_id = $lhis_id;
		$this->load->model($this->config->item('hr_dir'). 'M_hr_person');
		$data['leave_topic'] = $this->M_hr_leave_history->get_leave_history_by_lhis_id($lhis_id)->row();
		$data['leave_detail'] = $this->M_hr_leave_history_detail->get_by_key()->result();
		$data['leave_flow'] = $this->M_hr_leave_approve_flow->get_leave_flow_all_by_lhis_id($lhis_id)->result();
		foreach($data['leave_flow'] as $key=>$row){
			if($row->lafw_ps_id == $row->lafw_update_user){
				$row->text_approver = $row->pf_name.$row->ps_fname." ".$row->ps_lname;
			}
			else if($row->lafw_ps_id != $row->lafw_update_user && $row->lafw_update_user != 0){
				$this->M_hr_person->ps_id = $row->lafw_update_user;
				$appv = $this->M_hr_person->get_profile_detail_data_by_id()->row();
				$row->text_approver = $appv->pf_name.$appv->ps_fname." ".$appv->ps_lname . " <b><u>ดำเนินการแทน</u></b> ". $row->pf_name.$row->ps_fname." ".$row->ps_lname;
			}
			else{
				$row->text_approver = $row->pf_name.$row->ps_fname." ".$row->ps_lname;
			}
		}
		
		$this->load->view($this->view.'v_leaves_modal_approve_flow', $data);
	}//end leaves_approve_flow

}//end Leaves_form
?>