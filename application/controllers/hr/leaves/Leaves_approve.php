<?php
/*
* Leaves_approve
* อนุมัติการลา
* @input -
* $output อนุมัติการลา 
* @author Tanadon Tangjaimongkhon
* @Create Date 24/10/2567
*/
include_once('Leaves_Controller.php');

class Leaves_approve extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Leaves_approve/";
		$this->view .= "leaves_approve/";
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

		if ($ps_id == "") {
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

		$this->output($this->view . 'v_leaves_person_list', $data);
	}

	/*
	* get_leaves_list_by_param
	* แสดงรายการประวัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function get_leaves_list_by_param()
	{
		$ps_id = decrypt_id($this->input->post('ps_id'));
		// pre($ps_id);
		$start_date = splitDateForm1($this->input->post('start_date'));
		$end_date = splitDateForm1($this->input->post('end_date'));
		$result = $this->M_hr_leave_approve_flow->get_leave_for_approve_list_by_param($ps_id, $this->input->post('leave_id'), $this->input->post('status'), $start_date, $end_date)->result();
        // pre($result);
		foreach ($result as $key => $row) {
			$row->lhis_id = encrypt_id($row->lhis_id);
			$row->lafw_id = encrypt_id($row->lafw_id);
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
	function select_leaves_person_list()
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
	* update_leave_status
	* อัพเดทข้อมูลการอนุมัติการลา
	* @input ids, action, comment
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 16/05/2024
	*/
	function update_leave_status()
	{

		$lhis_id = $this->input->post('ids');
		$action = $this->input->post('action');
		$comments = $this->input->post('comments');
		if (empty($lhis_id) || empty($action)) {
			// เพิ่มการตรวจสอบความถูกต้อง
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_toast_default_error_body');
		}

		for ($i = 0; $i < count($lhis_id); $i++) {
			// ถอดรหัส ID
			$decrypted_id = decrypt_id($lhis_id[$i]);

			// ดึงข้อมูลสถานะปัจจุบัน
			$this->M_hr_leave_approve_flow->lafw_lhis_id = $decrypted_id;
			$this->M_hr_leave_approve_flow->lafw_status = "W";
			$row = $this->M_hr_leave_approve_flow->get_by_key_status()->row();

			if (!$row) {
				continue; // ข้ามการทำงานหากไม่พบข้อมูล
			}

			$next_lafw_seq = $row->lafw_seq + 1;
			$row_next_lafw_seq = $this->M_hr_leave_approve_flow->get_leave_approve_flow_by_param($decrypted_id, $next_lafw_seq);
			
			$status = ($action == "อนุมัติ" ? "Y" : "N"); 

			
			// อัปเดตสถานะใน approve flow
			$this->M_hr_leave_approve_flow->lafw_id = $row->lafw_id;
			$this->M_hr_leave_approve_flow->get_by_key(true);
			$this->M_hr_leave_approve_flow->lafw_status = $status;
			$this->M_hr_leave_approve_flow->lafw_comment = $comments[$i];
			$this->M_hr_leave_approve_flow->lafw_update_user = $this->session->userdata('us_ps_id');
			$this->M_hr_leave_approve_flow->lafw_update_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_approve_flow->update();

			if ($row_next_lafw_seq->num_rows() == 0) {
				// หากไม่มีขั้นตอนต่อไป ให้เปลี่ยนสถานะ leave history
				$this->M_hr_leave_history->lhis_id = $decrypted_id;
				$this->M_hr_leave_history->get_by_key(true);
				$this->M_hr_leave_history->lhis_status = $status;
				$this->M_hr_leave_history->update();

				if($status == "Y"){
					$this->update_leave_summary_data(
						encrypt_id($this->M_hr_leave_history->lhis_ps_id), 
						$this->M_hr_leave_history->lhis_year, 
						$this->M_hr_leave_history->lhis_leave_id, 
						$this->M_hr_leave_history->lhis_num_day, 
						$this->M_hr_leave_history->lhis_num_hour, 
						$this->M_hr_leave_history->lhis_num_minute
					);
				}
			} else {
				// มีขั้นตอนต่อไป อัปเดตตาม sequence
				$this->M_hr_leave_approve_flow->lafw_id = $row_next_lafw_seq->row()->lafw_id;
				$this->M_hr_leave_approve_flow->get_by_key(true);
				$this->M_hr_leave_approve_flow->lafw_status = "W";
				$this->M_hr_leave_approve_flow->update();

				$this->M_hr_leave_history->lhis_id = $decrypted_id;
				$this->M_hr_leave_history->get_by_key(true);
				$this->M_hr_leave_history->lhis_status = ($status == "Y" ? $row_next_lafw_seq->row()->lafw_seq : "N");
				$this->M_hr_leave_history->update();
			}
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		echo json_encode($data);
	}
	// update_leave_status

	/*
	* get_leave_form_detail
	* รายละเอียดแบบฟอร์มการลาเพื่อการอนุมัติ
	* @input lhis_id
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 11/21/2024
	*/
	function get_leave_form_detail($lhis_id)
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$lhis_id = decrypt_id($lhis_id);
		$lafw_result = $this->M_hr_leave_approve_flow->get_leave_flow_by_id($lhis_id)->row();
		$this->M_hr_leave_history->lhis_id = $lhis_id;
		$this->M_hr_leave_history->get_by_key(true);
		$data['comment'] = $lafw_result->lafw_comment;
		$data['lafw_ps_id'] = $lafw_result->lafw_ps_id;
		$data['lhis_id'] = encrypt_id($lhis_id);

		$data['ps_id'] = $this->M_hr_leave_history->lhis_ps_id;

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

		$this->output($this->view . 'v_leaves_form_approve_detail', $data);
	}
	// get_leave_form_detail

} //end Leaves_approve
