<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Patcharapol Sirimaneechot
* @Create Date 2567-10-07
*/
include_once('Leaves_Controller.php');

class Leaves_user extends Leaves_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->view .= $this->config->item('leaves_dir');
		$this->model .= $this->config->item('leaves_dir');
		$this->controller .= $this->config->item('leaves_dir');

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/leaves/Leaves_user";

		// [20241016 Patcharapol Sirimaneechot]
		$this->load->model('hr/leaves/M_hr_leave_summary');

	}

	/*
	* index
	* ประมวลผลข้อมูลสิทธิ์ลารายบุคคล (สามารถเลือกข้อมูลตามปีได้)
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;

		$data['filter_options'] = $this->M_hr_leave_summary->get_filter_options();
		// $data['leave_summary'] = $this->M_hr_leave_summary->get_all_leave_summary();

		$latest_budget_year = $data['filter_options']["lsum_year"][0]; // lastest budget year
		$data['all_user_leave_summary'] = $this->M_hr_leave_summary->get_all_user_leave_summary($latest_budget_year);
		// $data['all_user_leave_summary'] = $this->M_hr_leave_summary->get_all_user_leave_summary(2024);

		$data['controller_dir'] = $this->controller;
		$this->output($this->view.'v_leaves_user_list', $data);
	}

	/*
	* get_leave_summary_by_condition
	* ประมวลผลข้อมูลสิทธิ์ลารายบุคคล (สามารถเลือกข้อมูลตามปี และใส่เงื่อนไขเพื่อเลือกข้อมูลได้)
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_leave_summary_by_condition() {
		$budget_year = $this->input->post('select_budget_year');
		$hire_is_medical_id = $this->input->post('select_hire_is_medical');
		$hire_type = $this->input->post('select_hire_type');
		$work_status = $this->input->post('select_work_status');

		// $data['hire_is_medical_id'] = $hire_is_medical_id;
		// $data['leave_id'] = $leave_id;
		
		$data['controller_dir'] = $this->controller;
		$result = $this->M_hr_leave_summary->get_leave_summary_by_condition($budget_year, $hire_is_medical_id, $hire_type, $work_status);
		
		$data['result'] = $result;
		echo json_encode($data);
		// echo json_encode($budget_year);
	}

	/*
	* leaves_user_edit
	* ประมวลผลแบบฟอร์มแก้ไขข้อมูลสิทธิ์ลารายบุคคลของบุคลากรเป้าหมาย
	* @input -
	* $output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-25
	*/
	function leaves_user_edit() {
		$budget_year =  $this->input->get('select_budget_year');
		$user_id =  $this->input->get('user_id');

		$data["budget_year"] = $budget_year;
		$data["user_id"] = $user_id;

		$data['target_user_leave_summary'] = $this->M_hr_leave_summary->get_target_user_leave_summary($budget_year, $user_id);
		
		$data['base_info'] = $this->M_hr_leave_summary->get_base_info_for_cal_work_age($budget_year, $user_id);
		
		// die(print_r($data['base_info']));

		// print_r($data);
		$this->output($this->view.'v_leaves_user_form', $data);
	}


}
?>