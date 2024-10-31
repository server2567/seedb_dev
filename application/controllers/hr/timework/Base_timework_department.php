<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Base_timework_department extends Timework_Controller{
	private $mn_active_id = 300032;
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
	}

	public function index() {
		$data['Menus'] = [
			[
				'MnID' => 68,
				'MnStID'=> 0,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลโครงสร้างและกรอบอัตรากำลัง"
			],
		];
		$this->setUrl($data['Menus']);
		$data['session_mn_active_id'] = $this->mn_active_id;
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_department_show',$data);
	}
	public function view($StID=null) {
		$data['Menus'] = [
			[
				'MnID' => 45,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลโครงสร้างและกรอบอัตรากำลัง"
			],
			[
				'MnID' => 46,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 45,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการโครงสร้างหน่วยงาน"
			]
		];
		$this->setUrl($data['Menus']);

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_timework_department_show',$data);
	}
	
	// For show page
	public function edit($StID=null) {
		$data['StID'] = $StID;
		$data['Menus'] = [
			[
				'MnID' => 45,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลโครงสร้างและกรอบอัตรากำลัง"
			],
			[
				'MnID' => 46,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 45,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการโครงสร้างหน่วยงาน"
			]
		];
		$this->setUrl($data['Menus']);

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_org_form_edit',$data);
	}
	
	public function add() {
		//// case success
        $data['returnUrl'] = base_url().'index.php/ums/Base_title';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function update() {
		//// case success
        $data['returnUrl'] = base_url().'index.php/ums/Base_title';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function delete($StID) {
        // $data['returnUrl'] = base_url().'index.php/ums/Base_title';
        $data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('HR_Controller.php');

class Time_complie extends HR_Controller{

	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
	}

	public function index() {
		$data['Menus'] = [
			[
				'MnID' => 61,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลการลงเวลาทำงาน"
			],
			[
				'MnID' => 67,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 61,
				'MnUrl' => "hr/Time_matching_code",
				'MnUrlText' => null,
				'MnNameT' => "ประมวลผลการลงเวลาทำงาน"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_complie_show',$data);
	}
	// For show page
	public function edit($StID=null) {
		$data['StID'] = $StID;
		$data['Menus'] = [
			[
				'MnID' => 61,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลการลงเวลาทำงาน"
			],
			[
				'MnID' => 67,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 61,
				'MnUrl' => "hr/Time_matching_code",
				'MnUrlText' => null,
				'MnNameT' => "ประมวลผลการลงเวลาทำงาน"
			]
		];
		$this->setUrl($data['Menus']);

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_matching_code_form',$data);
	}
	
	public function add() {
		//// case success
        $data['returnUrl'] = base_url().'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function update() {
		//// case success
        $data['returnUrl'] = base_url().'index.php/hr/Time_matching_code';
		$data['status_response'] = $this->config->item('status_response_success');

		//// case error about server db
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";

		//// case error some condition of input
		// $data['status_response'] = $this->config->item('status_response_error');
		// $data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		// if(strlen($this->input->post("StNameT")) != null && strlen($this->input->post("StNameT")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameT', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];
		// if(strlen($this->input->post("StNameE")) != null && strlen($this->input->post("StNameE")) <= 10)
		// 	$data['error_inputs'][] = (object) ['Name' => 'StNameE', 'Error' => "ชื่อต้องยาวมากกว่า 10 ตัวอักษร"];

		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function delete($StID) {
        // $data['returnUrl'] = base_url().'index.php/ums/Base_title';
        $data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
