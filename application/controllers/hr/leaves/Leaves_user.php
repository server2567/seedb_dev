<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Tanadon Tangjaimongkhon
* @Create Date 2567-05-13
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
	}

	/*
	* index
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		$this->output($this->view.'v_leaves_user_list', $data);
	}

	/*
	* leaves_type
	* แสดงชนิดการลาที่สามารถลาได้
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	function leaves_type()
	{
		$data['session_mn_active_id'] = 300043; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;
		// $this->load->model($this->model . 'm_leave', 'l');
		// $l = $this->l;
		// $personId = ($this->input->post('personId')) ? $this->input->post('personId') : $this->session->userdata('UsPsCode'); // ทำลาแทน post personId
		// $this->data['personId'] = $personId;
		// $this->data['admin'] = ($this->input->post('admin')) ? $this->input->post('admin') : '';
		// /// หาปีงบประมาณปัจจุบัน
		// $l->lsum_ps_id = $personId;
		// $l->lsum_budget_year = (getCurBudgetYear() - 543);
		// /// END ปีงบประมาณ
		// $this->data['rs_l'] = $l->get_by_person_ids();
		$this->output($this->view.'v_leaves_type_list', $data);
	}//end leaves_type

	/*
	* leaves_input
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	function leaves_user_edit($leave_type_id)
	{
		$data['session_mn_active_id'] = 300046; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view'] = $this->view;
		$data['controller'] = $this->controller;

		$this->output($this->view.'v_leaves_user_form', $data);
	}//end leaves_input

	/*
	* leaves_save
	* แสดงหน้าจอทำเรื่องการลาตามประเภทที่เลือก
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-13
	*/
	public function leaves_save()
	{

		$location = $this->input->post('leaves_location_create');
		$create_date = $this->input->post('leaves_create_date');
		$from = $this->input->post('leaves_from');
		$detail = $this->input->post('leaves_detail');
		$start_date = $this->input->post('leaves_start_date');
		$end_date = $this->input->post('leaves_end_date');
		$address = $this->input->post('leaves_address');

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





}//end Leaves_form
?>