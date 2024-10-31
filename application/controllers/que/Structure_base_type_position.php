<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class Structure_base_type_position extends UMS_Controller{

	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
	}

	public function index() {
		$data['Menus'] = [
			[
				'MnID' => 45,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "จัดการโครสร้างองค์กร ตำแหน่ง และประเภทบุคลากร"
			],
			[
				'MnID' => 47,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 45,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลพื้นฐานประเภทตำแหน่ง"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_base_type_position_show',$data);
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
				'MnNameT' => "จัดการโครสร้างองค์กร ตำแหน่ง และประเภทบุคลากร"
			],
			[
				'MnID' => 47,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 45,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลพื้นฐานประเภทตำแหน่ง"
			]
		];
		$this->setUrl($data['Menus']);

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_base_type_position_form',$data);
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
				'MnNameT' => "จัดการโครสร้างองค์กร ตำแหน่ง และประเภทบุคลากร"
			],
			[
				'MnID' => 47,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 45,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลพื้นฐานประเภทตำแหน่ง"
			]
		];
		$this->setUrl($data['Menus']);

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_base_type_position_form',$data);
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
