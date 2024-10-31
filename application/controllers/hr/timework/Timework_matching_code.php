<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_matching_code extends Timework_Controller
{
	// ฟังก์ชัน __construct สำหรับโหลดโมเดลที่ใช้ใน controller นี้
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ums/M_ums_department');
		$this->load->model('hr/M_hr_order_person');
		$this->load->model('hr/M_hr_matching_code');
		$this->load->model('hr/M_hr_person');
		$this->mn_active_url = "hr/timework/Timework_matching_code";
	}

	// ฟังก์ชัน index สำหรับแสดงผลหน้าแรก
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // ตั้งค่า session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['dp_info'] = $this->M_ums_department->get_all()->result(); // ดึงข้อมูลแผนกทั้งหมด
		$data['controller_dir'] = "hr/timework/Timework_matching_code/";
		$this->output('hr/timework/matching_code/v_timework_matching_code_show', $data);
	}

	// ฟังก์ชันสำหรับดึงรายชื่อบุคคล
	public function get_person_list()
	{

		// $person_info = $this->M_hr_order_person->get_order_person_data_by_option(1, $dp_id, 'Y', $pos_status)->result(); // ดึงข้อมูลบุคคลตามแผนก
		$person_info = $this->M_hr_matching_code->get_all_profile_data_by_param($this->input->post('dp_id'), $this->input->post('hire_is_medical'), $this->input->post('hire_type_id'), $this->input->post('pos_status'))->result();

		foreach ($person_info as $key => $value) {
			// $this->M_hr_matching_code->mc_dp_id = $this->input->post('dp_id');
			// $this->M_hr_matching_code->mc_ps_id = $value->ps_id;
			// $mc_detail = $this->M_hr_matching_code->get_person_matching_code()->row(); // ดึงข้อมูล mc_code
			// if ($mc_detail) {
			// 	$value->mc_code = $mc_detail->mc_code; // หากมีข้อมูล mc_code
			// } else {
			// 	$value->mc_code = null; // หากไม่มีข้อมูล
			// }
			$value->ps_id = encrypt_id($value->ps_id); // เข้ารหัส ps_id
		}
		echo json_encode($person_info); // ส่งข้อมูลกลับเป็น JSON
	}

	// ฟังก์ชันสำหรับแสดงหน้าแก้ไขข้อมูล
	public function edit($ps_id = null, $dp_id = null)
	{
		$ps_id = decrypt_id($ps_id); // ถอดรหัส ps_id
		$this->M_hr_person->ps_id = $ps_id;
		$data['controller_dir'] = 'hr/timework/Timework_matching_code/';
		$data['matching_detail'] = $this->M_hr_person->get_profile_detail_data_by_id()->row(); // ดึงรายละเอียดข้อมูลบุคคล
		$data['mc_code'] = $this->M_hr_person->get_matching_code($ps_id, $dp_id)->row(); // ดึงข้อมูล mc_code
		$data['dp_id'] = $dp_id;
		$data['session_mn_active_url'] = $this->mn_active_url; // ตั้งค่า session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('hr/timework/matching_code/v_timework_matching_code_form', $data); // แสดงผลหน้าแก้ไขข้อมูล
	}

	// ฟังก์ชันตรวจสอบว่า mc_code มีการใช้งานหรือไม่
	public function check_code_already_use()
	{
		$mc_code = $this->input->post('mc_code'); // รับค่า mc_code จากการ post
		$this->M_hr_matching_code->mc_code = $mc_code;
		$check = $this->M_hr_matching_code->get_matching_code()->row(); // ตรวจสอบข้อมูล mc_code
		if ($check)  {
			$data['status_response'] = $this->config->item('status_response_error'); // หากมีการใช้งาน mc_code แล้ว
		} else {
			$data['status_response'] = $this->config->item('status_response_success'); // หากยังไม่มีการใช้งาน mc_code
		}
		$result = array('data' => $data); // ส่งข้อมูลสถานะกลับ
		echo json_encode($result); // ส่งผลลัพธ์เป็น JSON
	}

	// ฟังก์ชันสำหรับเพิ่มข้อมูล mc_code ใหม่
	public function add()
	{
		//// กรณีเพิ่มสำเร็จ
		$data['returnUrl'] = base_url() . 'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// กรณีเกิดข้อผิดพลาดเกี่ยวกับฐานข้อมูล
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// กรณีเกิดข้อผิดพลาดบางเงื่อนไขของ input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data); // ส่งข้อมูลสถานะกลับ
		echo json_encode($result); // ส่งผลลัพธ์เป็น JSON
	}

	// ฟังก์ชันสำหรับส่งข้อมูล mc_code
	public function submitMactingCode()
	{
		$mc_info = $this->input->post(); // รับข้อมูลจากการ post
		if ($mc_info['mc_id'] == null) {
			// เพิ่มข้อมูล mc_code ใหม่
			$this->M_hr_matching_code->mc_ps_id = $mc_info['mc_ps_id'];
			$this->M_hr_matching_code->mc_code = $mc_info['mc_code'];
			$this->M_hr_matching_code->mc_dp_id = $mc_info['mc_dp_id'];
			$this->M_hr_matching_code->insert();
			$data['method'] = 1; // แสดงว่าเป็นการเพิ่มข้อมูล
		} else {
			// อัปเดตข้อมูล mc_code ที่มีอยู่
			$this->M_hr_matching_code->mc_id = $mc_info['mc_id'];
			$this->M_hr_matching_code->mc_ps_id = $mc_info['mc_ps_id'];
			$this->M_hr_matching_code->mc_code = $mc_info['mc_code'];
			$this->M_hr_matching_code->mc_dp_id = $mc_info['mc_dp_id'];
			$this->M_hr_matching_code->update();
			$data['method'] = 2; // แสดงว่าเป็นการแก้ไขข้อมูล
		}
		$data['status_response'] = $this->config->item('status_response_success'); // กำหนดสถานะสำเร็จ
		$result = array('data' => $data); // ส่งข้อมูลสถานะกลับ
		echo json_encode($result); // ส่งผลลัพธ์เป็น JSON
	}

	// ฟังก์ชันสำหรับอัปเดตข้อมูล
	public function update()
	{
		//// กรณีอัปเดตสำเร็จ
		$data['returnUrl'] = base_url() . 'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// กรณีเกิดข้อผิดพลาดเกี่ยวกับฐานข้อมูล
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// กรณีเกิดข้อผิดพลาดบางเงื่อนไขของ input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data); // ส่งข้อมูลสถานะกลับ
		echo json_encode($result); // ส่งผลลัพธ์เป็น JSON
	}

	// ฟังก์ชันสำหรับลบข้อมูล
	public function delete($StID)
	{
		// $data['returnUrl'] = base_url().'index.php/ums/Base_title';
		$data['status_response'] = $this->config->item('status_response_success'); // กำหนดสถานะสำเร็จ
		$result = array('data' => $data); // ส่งข้อมูลสถานะกลับ
		echo json_encode($result); // ส่งผลลัพธ์เป็น JSON
	}
}
