<?php
/*
* Leaves_approve_group
* จั้ดการเส้นทางการลา
* @author Tanadon Tangjaimongkhon
* @Create Date 26/10/2567
*/
include_once('Leaves_Controller.php');

class Leaves_approve_group extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Leaves_approve_group/";
		$this->view .= "leaves_approve_group/";
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person');
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
		$this->load->model($this->model . 'M_hr_leave_approve_group');
		$this->load->model($this->model . 'M_hr_leave_approve_group_detail');
		$this->load->model($this->model . 'M_hr_leave_approve_person');
		$this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
		$this->mn_active_url = uri_string();
	}

	/*
	* index
	* แสดงกลุ่มเส้นทางอนุมัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		
		$this->output($this->view.'v_leaves_approve_group_list', $data);
	}

	/*
	* get_leaves_approve_group_list_by_param
	* แสดงรายการกลุ่มเส้นทางอนุมัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_list_by_param(){
		$result = [];
		if($this->input->post('lapg_type') == "stuc" && $this->input->post('lapg_stuc_id') != ""){
			$result = $this->M_hr_leave_approve_group->get_leaves_approve_group_all_by_stuc($this->input->post('lapg_type'), $this->input->post('lapg_parent_id'), $this->input->post('lapg_stuc_id'), $this->input->post('lapg_active'))->result();
		}
		else if($this->input->post('lapg_type') == "hire"){
			$result = $this->M_hr_leave_approve_group->get_leaves_approve_group_all_by_hire($this->input->post('lapg_type'), $this->input->post('lapg_parent_id'), $this->input->post('lapg_stuc_id'), $this->input->post('lapg_active'))->result();
		}
		else if($this->input->post('lapg_type') == "ps"){
			$result = $this->M_hr_leave_approve_group->get_leaves_approve_group_all_by_ps($this->input->post('lapg_type'), $this->input->post('lapg_parent_id'), $this->input->post('lapg_stuc_id'), $this->input->post('lapg_active'))->result();
		}

		foreach($result as $key=>$row){
			$row->lapg_id = encrypt_id($row->lapg_id);
		}
		
		echo json_encode($result);
	}
	// get_leaves_approve_group_list_by_param
	

	/*
	* get_leaves_approve_group_list_by_ps_id
	* แสดงรายการเส้นทางอนุมัติการลารายบุคคล
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_list_by_ps_id(){
		$result = $this->M_hr_leave_approve_person->get_leaves_approve_person_all($this->input->post('dp_id'), $this->input->post('hire_is_medical'), $this->input->post('hire_type'), $this->input->post('status_id'))->result();
		echo json_encode($result);
	}
	// get_leaves_approve_group_list_by_ps_id

	/*
	* get_all_structure_list
	* ดึงข้อมูลโครงสร้างองค์กร
	* @input dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2024
	*/
	function get_all_structure_list()
	{
		$dp_id = $this->input->get('dp_id');
		$result = $this->M_hr_person->get_all_structure_had_confirm($dp_id)->result();

		foreach ($result as $key => $row) {
			$row->stuc_confirm_date = fullDateTH3($row->stuc_confirm_date);
		}
		echo json_encode($result);
	}
	// get_all_structure_list

	/*
	* insert_approve_group
	* หน้าจอสำหรับการเพิ่มรายละเอียดของกลุ่มอนุมัติ
	* @input dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 09/10/2024
	*/
	function insert_approve_group(){
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['base_ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		
		$this->output($this->view.'v_leaves_approve_group_insert', $data);
	}
	// insert_approve_group

	/*
	* update_approve_group
	* หน้าจอสำหรับการแก้ไขรายละเอียดของกลุ่มอนุมัติ
	* @input dp_id
	* $output timework attendance config data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/10/2024
	*/
	function update_approve_group($lapg_id){
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['lapg_id'] = $lapg_id;

		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		
		$this->output($this->view.'v_leaves_approve_group_update', $data);
	}
	// update_approve_group

	/*
	* get_leaves_approve_group_by_id
	* แสดงรายการเส้นทางอนุมัติการลารายบุคคล
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 27/10/2567
	*/
	function get_leaves_approve_group_by_id(){
		$lapg_id = decrypt_id($this->input->post('lapg_id'));
		$this->M_hr_leave_approve_group->lapg_id = $lapg_id;
		$this->M_hr_leave_approve_group->get_by_key(true);
		$lapg_type = $this->M_hr_leave_approve_group->lapg_type;
		$lapg_parent_id = $this->M_hr_leave_approve_group->lapg_parent_id;
		$lapg_stuc_id = $this->M_hr_leave_approve_group->lapg_stuc_id;


		$result = [];
		if($lapg_type == "stuc"){
			$result['group'] = $this->M_hr_leave_approve_group->get_leaves_approve_group_id_by_stuc($lapg_id)->result();
			$result['stuc'] = $this->M_hr_leave_approve_group_detail->get_structure_detail_by_stde_id($lapg_parent_id)->row();
			
			$result['stuc']->stuc_confirm_date = fullDateTH3($result['stuc']->stuc_confirm_date);
			
		}
		else if($lapg_type == "hire"){
			$result['group'] = $this->M_hr_leave_approve_group->get_leaves_approve_group_id_by_hire($lapg_id)->result();
		}
		else {
			$result['group'] = $this->M_hr_leave_approve_group->get_leaves_approve_group_id_by_ps($lapg_id)->result();
		}

		

		$result['select_person'] = $this->M_hr_leave_approve_person->get_leaves_approve_person_for_select_approve_group('update')->result();
		$result['select_leave_approve_status'] = $this->M_hr_leave_approve_group_detail->get_base_leave_approve_status()->result();

		foreach($result['group'] as $key=>$row){

			if($lapg_type == "stuc"){
				$result['detail']['stuc'] = $this->M_hr_leave_approve_group_detail->get_structure_detail_all_by_level_desc($row->lapg_stuc_id, $row->lapg_parent_id)->result();
				foreach($result['detail']['stuc'] as $i=>$stde){
					$stde->person_list = $this->M_hr_leave_approve_group_detail->get_leave_approve_detail_stuc_by_lapg_id($row->lapg_id, $stde->stde_id)->result();
				}
			}
			else {
				$result['detail'] = $this->M_hr_leave_approve_group_detail->get_leave_approve_detail_hire_ps_by_lapg_id($row->lapg_id)->result();
			}

			$row->lapg_id = encrypt_id($row->lapg_id);

		}

		$result['group_person'] = $this->M_hr_leave_approve_person->get_leaves_approve_person_by_lapg_id($lapg_id)->result();

		// pre($result);

		echo json_encode($result);
	}
	// get_leaves_approve_group_by_id


	/*
	* get_leaves_approve_group_list_by_ps_id
	* แสดงรายการเส้นทางอนุมัติการลารายบุคคล
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 27/10/2567
	*/
	function get_leaves_approve_person_list(){
		$result = $this->M_hr_leave_approve_person->get_leaves_approve_person_for_select_approve_group()->result();
		echo json_encode($result);
	}
	// get_leaves_approve_group_list_by_ps_id


	/*
	* get_structure_detail_by_stuc_id
	* แสดงโครงสร้างองค์กร ตามรหัสโครงสร้างหน่วยงาน
	* @input stuc_id
	* $output stucture detail list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
	function get_structure_detail_by_stuc_id(){
		$result = $this->M_hr_leave_approve_group_detail->get_structure_detail_by_stuc_id($this->input->post('stuc_id'))->result();
		echo json_encode($result);
	}
	// get_structure_detail_by_stuc_id

	/*
	* get_leaves_approve_group_list_by_ps_id
	* แสดงโครงสร้างองค์กรตามรหัสโครงสร้างหน่วยงาน และรหัสโครงสร้างองค์กรที่เริ่มต้น
	* @input -
	* $output stucture detail list by asd and person list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
	function get_structure_detail_by_level_asc(){

		$result['stuc'] = $this->M_hr_leave_approve_group_detail->get_structure_detail_all_by_level_desc($this->input->post('stuc_id'), $this->input->post('stde_id'))->result();

		foreach($result['stuc'] as $key=>$row){
			$row->person_list = $this->M_hr_leave_approve_group_detail->get_person_list_by_stde_id($row->stde_id)->result();
		}

		$result['select_person'] = $this->M_hr_leave_approve_person->get_leaves_approve_person_for_select_approve_group()->result();

		if($this->input->post("lapg_type") == "stuc"){
			$result['select_person_stuc'] = $this->M_hr_leave_approve_person->get_leaves_approve_person_for_select_approve_group_type_stuc($this->input->post('stde_id'), $this->input->post('dp_id'))->result();
		}
		
		$result['select_leave_approve_status'] = $this->M_hr_leave_approve_group_detail->get_base_leave_approve_status()->result();
		
		echo json_encode($result);
	}
	// get_structure_detail_by_level_asc

	
	/*
	* save_leave_approve_group
	* บันทึกเส้นทางอนุมัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
	function save_leave_approve_group(){
		// Receive form data from POST
		$leave_approve_group_data = $this->input->post('leave_approve_group_form')['approve_group'];
		// pre($this->input->post('leave_approve_group_form')); die;
		// Initialize group data
		$this->M_hr_leave_approve_group->lapg_name = $leave_approve_group_data['name'];
		$this->M_hr_leave_approve_group->lapg_type = $leave_approve_group_data['type'];
		$this->M_hr_leave_approve_group->lapg_desc = $leave_approve_group_data['description'];
	
		// Set type-specific properties
		if($leave_approve_group_data['type'] == "stuc"){
			$this->M_hr_leave_approve_group->lapg_parent_id = $leave_approve_group_data['parent_id'];
			$this->M_hr_leave_approve_group->lapg_stuc_id = $leave_approve_group_data['stuc_id'];
		} else {
			$this->M_hr_leave_approve_group->lapg_parent_id = $leave_approve_group_data['parent_id'];
		}
	
		// Determine update or insert
		if(isset($leave_approve_group_data['id'])){
			// Update
			$lapg_id = decrypt_id($leave_approve_group_data['id']);
			$this->M_hr_leave_approve_group->lapg_id = $lapg_id;
			$this->M_hr_leave_approve_group->lapg_active = $leave_approve_group_data['active'];
			$this->M_hr_leave_approve_group->lapg_update_user = $this->session->userdata('us_id');
			$this->M_hr_leave_approve_group->lapg_update_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_approve_group->update();
	
			// Clear previous details before inserting new ones
			$this->M_hr_leave_approve_group_detail->lage_lapg_id = $lapg_id;
			$this->M_hr_leave_approve_group_detail->delete();
	
		} else {
			// Insert
			$this->M_hr_leave_approve_group->lapg_active = "Y";
			$this->M_hr_leave_approve_group->lapg_create_user = $this->session->userdata('us_id');
			$this->M_hr_leave_approve_group->lapg_create_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_approve_group->insert();
			$lapg_id = $this->M_hr_leave_approve_group->last_insert_id;
		}
	
		// Insert or update group details
		$leave_approve_group_detail_data = $this->input->post('leave_approve_group_form')['details'];
		foreach($leave_approve_group_detail_data as $row){
			$this->M_hr_leave_approve_group_detail->lage_lapg_id = $lapg_id;
			$this->M_hr_leave_approve_group_detail->lage_ps_id = $row['ps_id'];
			$this->M_hr_leave_approve_group_detail->lage_last_id = $row['status'];
			$this->M_hr_leave_approve_group_detail->lage_seq = $row['seq'];
			$this->M_hr_leave_approve_group_detail->lage_stde_id = $row['stde_id'];
			$this->M_hr_leave_approve_group_detail->lage_desc = "";
			$this->M_hr_leave_approve_group_detail->lage_active = "Y";
			$this->M_hr_leave_approve_group_detail->lage_create_user = $this->session->userdata('us_id');
			$this->M_hr_leave_approve_group_detail->lage_create_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_approve_group_detail->insert();
		}
	
		// Update or insert approve group persons
		$leave_approve_person_data = $this->input->post('leave_approve_group_form')['persons'];
		$this->M_hr_leave_approve_person->laps_lapg_id = $lapg_id;
		$this->M_hr_leave_approve_person->delete();
	
		foreach($leave_approve_person_data as $row){
			$this->M_hr_leave_approve_person->laps_ps_id = $row['ps_id'];
			$this->M_hr_leave_approve_person->laps_create_user = $this->session->userdata('us_id');
			$this->M_hr_leave_approve_person->laps_create_date = date('Y-m-d H:i:s');
			$this->M_hr_leave_approve_person->insert();
		}
	
		// Prepare response after saving
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller); 
		echo json_encode($data);
	}	
	// save_leave_approve_group

	/*
	* delete_approve_group
	* บันทึกเส้นทางอนุมัติการลา
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
	function delete_approve_group(){
		$lapg_id = decrypt_id($this->input->post('lapg_id'));

		$this->M_hr_leave_approve_group->lapg_id = $lapg_id;
		$this->M_hr_leave_approve_group->delete();

		$this->M_hr_leave_approve_group_detail->lage_lapg_id = $lapg_id;
		$this->M_hr_leave_approve_group_detail->delete();

		$this->M_hr_leave_approve_person->laps_lapg_id = $lapg_id;
		$this->M_hr_leave_approve_person->delete();

		// กำหนดค่าการตอบกลับหลังจากบันทึกข้อมูลเสร็จ
		$data['status_response'] = $this->config->item('status_response_success');
		$data['message_dialog'] = $this->config->item('text_toast_default_success_body');
		$data['return_url'] = site_url($this->controller); // URL กลับไปหน้าที่ต้องการ
		// ส่งผลลัพธ์กลับในรูปแบบ JSON
		echo json_encode($data);
	}
	// delete_approve_group
	

}//end Leaves_approve_group
?>