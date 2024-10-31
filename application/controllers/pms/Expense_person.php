<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('PMS_Controller.php');

class Expense_person extends  PMS_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); 
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('pms/expense/v_expense_person_show', $data);
	}
	function editExpenses($type = null)
	{
		$formData = $this->input->post();
		$data['status_response'] = array();
		if(isset($formData['copy'] )&& $formData['copy'] == 2){
			$data['copy'] = '3';
			$data['edit'] = '3';
			$data['html'] = $this->load->view('pms/expense/v_expense_person_form', $data, TRUE);
		}else{
			$data['edit'] = $type;
		}
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); 
		$this->output('pms/expense/v_expense_person_form', $data);
	}
	public function getAddForm()
	{
		$formData = $this->input->post();
		$data['type'] = $formData['add'];
		if ($data['type']) {
			$json['title'] = 'เพิ่มรายการรายจ่าย';
		} 
		$json['body'] = $this->load->view('pms/expense/v_expense_person_add', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" onclick="addExpense()" class="btn btn-sm btn-primary">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary"  data-bs-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function getEditForm()
	{
		$formData = $this->input->post();
		$data['type'] = $formData['edit'];
		if ($data['type']) {
			$json['title'] = 'แก้ไขรายการรายจ่าย';
		}
		$json['body'] = $this->load->view('pms/expense/v_expense_person_add', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary"  data-bs-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
