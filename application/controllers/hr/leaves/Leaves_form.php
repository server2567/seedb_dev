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
	public function get_leaves_person_list($ps_id="")
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

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
		$this->output($this->view.'v_leaves_type_list', $data);
	}//end leaves_type

	/*
	* leaves_input
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 24/10/2567
	*/
	function leaves_input($lhis_leave_id, $ps_id)
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$data['lhis_leave_id'] = $lhis_leave_id;

		$data['ps_id'] = $ps_id = ($ps_id != "" ? decrypt_id($ps_id) : $this->session->userdata('us_ps_id'));

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$this->M_hr_person->ps_id = $data['ps_id'];
		$data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$data['lastest_leave_id'] = $this->M_hr_leave_history->get_lastest_lhis_leave_id_by_ps_id($ps_id, $lhis_leave_id)->row();
		$data['person_replace_list'] = $this->M_hr_leave_history->get_person_replace_list()->result();

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
		
		$this->output($this->view.'v_leaves_form_input_'.$lhis_leave_id, $data);
	}//end leaves_input

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

		$lhis_ps_id = $this->input->post('lhis_ps_id');
		$lhis_leave_id = $this->input->post('lhis_leave_id');
		$lhis_start_date = $this->input->post('leaves_start_date');
		$lhis_end_date = $this->input->post('leaves_end_date');
		list($lhis_num_day, $lhis_num_hour, $lhis_num_minute) = explode("-", $this->input->post('leaves_summary_value'));
		$lhis_year = (new DateTime())->format("Y");
		$lhis_topic = $this->input->post('leaves_detail');
		$lhis_address = $this->input->post('leaves_address');
		$lhis_write_place = $this->input->post('leaves_location_create');
		$lhis_write_date = $this->input->post('leaves_create_date');
		$lhis_replace_id = $this->input->post('leaves_replace_id');
		$lhis_tell = $this->input->post('leaves_from');
		
		if (isset($_FILES['leaves_upload_file']) && $_FILES['leaves_upload_file']['error'] === UPLOAD_ERR_OK) {
    
			$file_tmp = $_FILES['leaves_upload_file']['tmp_name'];
			$file_mime_type = $_FILES['leaves_upload_file']['type'];
			$original_file_name = pathinfo($_FILES['leaves_upload_file']['name'], PATHINFO_FILENAME);
		
			// Define the file extension based on MIME type
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
		
			// Generate a unique file name with date and time
			$file_new_name = date("dmYHis") . '_' . uniqid() . '.' . $original_file_name;
			$full_destination_path = $this->config->item('hr_upload_leaves') . $file_new_name;
		
			// Move the file to the destination folder
			if (move_uploaded_file($file_tmp, $full_destination_path)) {
				$this->M_hr_leave_history->lhis_attach_file = $file_new_name; // Attach the file name in the database
			} else {
				$data['status_response'] = $this->config->item('status_response_error');
				throw new Exception('File upload failed');
			}
		
		} else {
			// Handle the case where no file was uploaded or an error occurred
			$data['status_response'] = $this->config->item('status_response_error');
			throw new Exception('No file uploaded or file upload error');
		}

		$this->M_hr_leave_history->lhis_ps_id = $lhis_ps_id;
		$this->M_hr_leave_history->lhis_leave_id = $lhis_leave_id;
		$this->M_hr_leave_history->lhis_start_date = splitDateForm1($lhis_start_date);
		$this->M_hr_leave_history->lhis_end_date = splitDateForm1($lhis_end_date);
		$this->M_hr_leave_history->lhis_num_day = $lhis_num_day;
		$this->M_hr_leave_history->lhis_num_hour = $lhis_num_hour;
		$this->M_hr_leave_history->lhis_num_minute = $lhis_num_minute;
		$this->M_hr_leave_history->lhis_year = $lhis_year;
		$this->M_hr_leave_history->lhis_topic = $lhis_topic;
		$this->M_hr_leave_history->lhis_address = $lhis_address;
		$this->M_hr_leave_history->lhis_write_place = $lhis_write_place;
		$this->M_hr_leave_history->lhis_write_date = splitDateForm1($lhis_write_date);
		$this->M_hr_leave_history->lhis_replace_id = $lhis_replace_id;

		$leaves_approve_group = $this->M_hr_leave_history->check_leaves_approve_group_by_ps_id($lhis_ps_id);

		if($leaves_approve_group->num_rows() == 0){
			$lhis_status = "Y";
		}
		else if($leaves_approve_group->num_rows() == 1){
			$row_laps = $leaves_approve_group->row();
			$lhis_status = 1;
		}
		else{
			$row_laps = $leaves_approve_group->result()[0];
			$lhis_status = 1;
		}

		$this->M_hr_leave_history->lhis_status = $lhis_status;
		$this->M_hr_leave_history->lhis_tell = $lhis_tell;   

		$this->M_hr_leave_history->lhis_create_user = $this->session->userdata('us_id');
		$this->M_hr_leave_history->lhis_create_date = date('Y-m-d H:i:s');
		$this->M_hr_leave_history->insert();
		$lhis_last_insert_id = $this->M_hr_leave_history->last_insert_id;
		
		$leaves_approve_group_detail = $this->M_hr_leave_history->check_leaves_approve_group_detail_by_lapg_id($row_laps->laps_lapg_id)->result();
		
		foreach($leaves_approve_group_detail as $key=>$row){
			$this->M_hr_leave_approve_flow->lafw_seq = $row->lage_seq;
			$this->M_hr_leave_approve_flow->lafw_ps_id  = $row->lage_ps_id;
			$this->M_hr_leave_approve_flow->lafw_laps_id = $row->lage_last_id;
			$this->M_hr_leave_approve_flow->lafw_lapg_id  = $row->lage_lapg_id;
			$this->M_hr_leave_approve_flow->lafw_lhis_id  = 42;
			$this->M_hr_leave_approve_flow->lafw_status = "W";
			$this->M_hr_leave_approve_flow->lafw_comment = "";
			$this->M_hr_leave_approve_flow->lafw_update_user = "";
			$this->M_hr_leave_approve_flow->lafw_update_date = "";
			$this->M_hr_leave_approve_flow->insert();
		}
		



		$leaves_count_select = $this->input->post("leaves_count_select");

		$lhde_seq = 0;
		for($i=0 ; $i < $leaves_count_select ; $i++){
			$lhde_seq++;

			$leaves_date = splitDateForm1($this->input->post("leaves_date_".$i));
			$this->hr_leave_history_detail->lhde_date = $leaves_date;
			$this->hr_leave_history_detail->lhde_lhis_id = $lhis_last_insert_id;

			if ($lhis_leave_id == 2 && null !== $this->input->post('leaves_clnd_id')) {	//ลาหยุดตามประเพณี
				$this->hr_leave_history_detail->lhde_clnd_id = $this->input->post('leaves_clnd_id');
			}
			else{
				$this->hr_leave_history_detail->lhde_clnd_id = "";
			}

			$leaves_time_type = $this->input->post("leaves_time_type_".$i);
			if($leaves_time_type == 1){
				$this->hr_leave_history_detail->lhde_start_time = "00:00:00";
				$this->hr_leave_history_detail->lhde_end_time = "00:00:00";
				$this->hr_leave_history_detail->lhde_type_day = "D";
				$this->hr_leave_history_detail->lhde_num_hour = 8;	
				$this->hr_leave_history_detail->lhde_num_minute = 0;
			}
			else{
				$this->hr_leave_history_detail->lhde_start_time = $this->input->post("leaves_start_time_".$i);
				$this->hr_leave_history_detail->lhde_end_time = $this->input->post("leaves_end_time_".$i);
				$this->hr_leave_history_detail->lhde_type_day = "H";
				$this->hr_leave_history_detail->lhde_num_hour = $this->input->post("leaves_summary_hour_".$i);
				$this->hr_leave_history_detail->lhde_num_minute = $this->input->post("leaves_summary_minute_".$i);
			}
			$this->hr_leave_history_detail->lhde_seq = $lhde_seq;
			$this->hr_leave_history_detail->insert();
		}

        // Now you can use these variables in your controller logic
        // For example, you can perform database operations, validation, etc.
        // Here's a simple example of echoing the received data:
        echo "Received data:\n";
        echo "Location: " . $location . "\n";
        echo "Create Date: " . $create_date . "\n";
        echo "From: " . $from . "\n";
        echo "Detail: " . $detail . "\n";
        echo "Start Date: " . $start_date . "\n";
        echo "Address: " . $address . "\n";
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

		$result = $this->M_hr_leave_approve_flow->get_leave_flow_all_by_lhis_id($lhis_id)->result();
		echo json_encode($result);
	}
	// get_leave_flow_by_lhis_id





}//end Leaves_form
?>