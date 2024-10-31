<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Attendance_config extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "attendance_config/";
		$this->view .= "attendance_config/";
		$this->load->model($this->model . 'M_hr_timework_attendance_config');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* หน้าหลักรูปแบบการลงเวลาทำงาน
	* @input 
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;

		$hire_is_medical = '';
		$hire_data = $this->session->userdata('hr_hire_is_medical');
		$count = count($hire_data);

		if ($count < 5) {
			$hire_is_medical = 'ของ';
			
			foreach ($hire_data as $key => $value) {
				if ($key == $count - 1 && $count > 1) {
					$hire_is_medical .= 'และ ';
				} elseif ($key != 0) {
					$hire_is_medical .= ' ';
				}
				
				switch ($value['type']) {
					case 'M':
						$hire_is_medical .= 'สายการแพทย์';
						break;
					case 'N':
						$hire_is_medical .= 'สายการพยาบาล';
						break;
					case 'SM':
						$hire_is_medical .= 'สายสนับสนุนทางการแพทย์';
						break;
					case 'A':
						$hire_is_medical .= 'สายบริหาร';
						break;
					case 'T':
						$hire_is_medical .= 'สายเทคนิคและบริการ';
						break;
				}
			}
		}

		$data['hire_is_medical'] = $hire_is_medical;
		
		$this->output($this->view.'v_attendance_config_list', $data);
	}
	// index

	/*
	* attendance_config_list
	* ข้อมูลรายการรูปแบบการลงเวลาทำงานตาม filter
	* @input twac_type, twac_is_medical, twac_active
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_list()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$twac_type = $this->input->get('twac_type');
		$twac_is_medical = $this->input->get('twac_is_medical');
		$twac_active = $this->input->get('twac_active');
		$result = $this->M_hr_timework_attendance_config->get_all_attendance_config_data($twac_type, $twac_is_medical, $twac_active)->result();

		foreach ($result as $key => $row) {
			$row->twac_id = encrypt_id($row->twac_id);
		}
		
		echo json_encode($result);
	}
	// attendance_config_list

	/*
	* attendance_config_form
	* แบบฟอร์มรูปแบบการลงเวลาทำงาน
	* @input twac_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_form($twac_id="")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$twac_id = ($twac_id != "" ? decrypt_id($twac_id) : 0);
		$data['row_twac'] = $this->M_hr_timework_attendance_config->get_by_primary_key($twac_id);

		$hire_is_medical = '';
		$hire_data = $this->session->userdata('hr_hire_is_medical');
		$count = count($hire_data);

		if ($count < 5) {
			$hire_is_medical = 'ของ';
			
			foreach ($hire_data as $key => $value) {
				if ($key == $count - 1 && $count > 1) {
					$hire_is_medical .= 'และ ';
				} elseif ($key != 0) {
					$hire_is_medical .= ' ';
				}
				
				switch ($value['type']) {
					case 'M':
						$hire_is_medical .= 'สายการแพทย์';
						break;
					case 'N':
						$hire_is_medical .= 'สายการพยาบาล';
						break;
					case 'SM':
						$hire_is_medical .= 'สายสนับสนุนทางการแพทย์';
						break;
					case 'A':
						$hire_is_medical .= 'สายบริหาร';
						break;
					case 'T':
						$hire_is_medical .= 'สายเทคนิคและบริการ';
						break;
				}
			}
		}

		$data['hire_is_medical'] = $hire_is_medical;

		$this->output($this->view.'v_attendance_config_form', $data);
	}
	// attendance_config_form

	/*
	* attendance_config_save
	* บันทึกข้อมูลแบบฟอร์มรูปแบบการลงเวลาทำงาน
	* @input twac_id, ข้อมูลฟอร์มทั้งหมด
	* @output JSON response
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_save() {
		// รับค่าจาก POST
		$form_attendance_config = $this->input->post();

		$twac_id = decrypt_id($form_attendance_config['twac_id']);
		
		// ตั้งค่าข้อมูลที่รับมาจากฟอร์ม
		$this->M_hr_timework_attendance_config->twac_name_th = $form_attendance_config['twac_name_th'];
		$this->M_hr_timework_attendance_config->twac_name_abbr_th = $form_attendance_config['twac_name_abbr_th'];
		$this->M_hr_timework_attendance_config->twac_start_time = $form_attendance_config['twac_start_time'];
		$this->M_hr_timework_attendance_config->twac_end_time = $form_attendance_config['twac_end_time'];
		$this->M_hr_timework_attendance_config->twac_late_time = $form_attendance_config['twac_late_time'];
		$this->M_hr_timework_attendance_config->twac_is_medical = $form_attendance_config['option_twac_is_medical'];
		$this->M_hr_timework_attendance_config->twac_type = $form_attendance_config['option_twac_type'];
		$this->M_hr_timework_attendance_config->twac_color = $form_attendance_config['twac_color'];

		$this->M_hr_timework_attendance_config->twac_update_user = $this->session->userdata('us_id');
		$this->M_hr_timework_attendance_config->twac_update_date = date('Y-m-d H:i:s');

		// ตรวจสอบว่าเป็นการเพิ่มใหม่หรือแก้ไข
		if (empty($twac_id)) {
			// เพิ่มข้อมูลใหม่
			$this->M_hr_timework_attendance_config->twac_active = 1;
			$this->M_hr_timework_attendance_config->twac_create_user = $this->session->userdata('us_id');
			$this->M_hr_timework_attendance_config->twac_create_date = date('Y-m-d H:i:s');
			$this->M_hr_timework_attendance_config->insert();
			
		} else {
			// แก้ไขข้อมูลเดิม
			$this->M_hr_timework_attendance_config->twac_active = (isset($form_attendance_config['twac_active']) ? 1 : 0);
			$this->M_hr_timework_attendance_config->twac_id = $twac_id;
			$this->M_hr_timework_attendance_config->update();
		}

		// กำหนดค่าการตอบกลับหลังจากบันทึกข้อมูลเสร็จ
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller); // URL กลับไปหน้าที่ต้องการ

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}

	/*
	* attendance_config_delete
	* เปลี่ยนสถานะรูปแบบการลงเวลาทำงานเป็น 2 (แทนการลบ)
	* @input twac_id
	* @output JSON data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 12/09/2024
	*/
	public function attendance_config_delete() {
		// รับค่าจาก POST
		$twac_id = decrypt_id($this->input->post('twac_id'));

		// ตรวจสอบว่าได้ค่า twac_id หรือไม่
		if (!empty($twac_id)) {
			// กำหนดค่า twac_id และเปลี่ยนสถานะ twac_active ให้เป็น 2
			$this->M_hr_timework_attendance_config->twac_id = $twac_id;
			$this->M_hr_timework_attendance_config->twac_active = 2;

			// เรียกฟังก์ชัน update ในโมเดลเพื่อเปลี่ยนสถานะเป็น 2
			$this->M_hr_timework_attendance_config->update_status();
			$data = array(
				'status_response' => $this->config->item('status_response_success'),
				'message_dialog' => $this->config->item('text_toast_delete_success_body'),
				'return_url' => site_url($this->controller)
			);
		} else {
			// ถ้าไม่ได้รับ twac_id
			$data = array(
				'status_response' => $this->config->item('status_response_error'),
				'message_dialog' => 'ไม่พบข้อมูลสำหรับการลบข้อมูล'
			);
		}

		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	// attendance_config_delete



	
}
