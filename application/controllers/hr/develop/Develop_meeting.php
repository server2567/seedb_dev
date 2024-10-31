<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Develop_Controller.php");

class Develop_meeting extends Develop_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/develop/Develop_meeting";
	}

	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['name'] = 'นพ.บรรยง ชินกุลกิจนิวัฒน์';
		$data['position'] = 'ผู้อำนวยการ';
		$data['affiliation'] = 'จักษุแพทย์ รักษาโรคตาทั่วไป';
		$data['special'] = 'เชี่ยวชาญการผ่าตัดต้อกระจก';
		$this->output('hr/develop/v_Develop_meeting_show', $data);
	}
	public function get_Develop_meeting_add()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['name'] = ['นางสาวกัลยารัตน์ อนนท์รัตน์', 'นางวรางคณา อุดมทรัพย์', 'นางสาวกฤษณาพร ทิพย์กาญจนเรขา'];
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/develop/v_Develop_meeting_form', $data);
	}
	public function get_Develop_meeting_edit($StID = null)
	{
		$data['StID'] = $StID;
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/develop/v_Develop_meeting_form', $data);
	}
	public function get_Edit_meeting_form()
	{
		$name = ['นางสาวกัลยารัตน์ อนนท์รัตน์', 'นางวรางคณา อุดมทรัพย์', 'นางสาวกฤษณาพร ทิพย์กาญจนเรขา'];
		$formData = $this->input->post();
		if (isset($formData['uid'])) {
			$data['name'] = $name[$formData['uid'] - 1];
		}
		$json['title']  = 'จัดการข้อมูลผู้เข้าร่วมพัฒนาตนเอง';
		$json['body'] = $this->load->view('hr/develop/v_Develop_edit_meeting_form', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary"  data-bs-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function get_person_name(){
		$name = ['-- เลือก --','นางสาวกัลยารัตน์ อนนท์รัตน์', 'นางวรางคณา อุดมทรัพย์', 'นางสาวกฤษณาพร ทิพย์กาญจนเรขา'];
		$json['name'] = $name;
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function filter_dev_list(){
        pre($this->input->post());
    }
}
