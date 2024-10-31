<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class Policy extends UMS_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
		$this->load->model('ums/Genmod', 'genmod');
	}

	public function index()
	{
		$data['get'] = $this->genmod->getAll('see_umsdb', 'ums_policy', '*', array('policy_status !=' => 2));
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/policy/v_policy_policy_show', $data);
	}

	// For show page
	public function add()
	{
		$policyName = $this->input->post('PolicyNameT');
		$policyDetail = $this->input->post('PolicyDetail');
		$policyFileId = $this->input->post('PolicyFileId');
		$policyActive = $this->input->post('PolicyActive');
		$status = 0;
		$uploadedFileName = 'policy_' . date('Y-m-d_H-i-s');
		$fileExtension = '';
		if (!empty($_FILES['PolicyFileId']['name'])) {
			$uploadDir  = $this->config->item('ums_uploads_Policy');
			$fileExtension = pathinfo($_FILES['PolicyFileId']['name'], PATHINFO_EXTENSION); // Get file extension
			$uploadedFilePath = $uploadDir . $uploadedFileName . '.' . $fileExtension; // Append file extension to file name
			$uploadedFileName = $uploadedFileName . '.' . $fileExtension;
			if (move_uploaded_file($_FILES['PolicyFileId']['tmp_name'], $uploadedFilePath)) {
				$status = 1;
				$data = array(
					'policy_name' => $policyName,
					'policy_text' => $policyDetail,
					'policy_status' => $policyActive, // ใส่สถานะตามที่คุณต้องการ
					'policy_namefile' => $uploadedFileName // เก็บทั้งชื่อและนามสกุลของไฟล์ที่อัพโหลด
				);
			} else {
				$status = 0;
			}
		} else {
			$status = 1;
			$data = array(
				'policy_name' => $policyName,
				'policy_text' => $policyDetail,
				'policy_status' => $policyActive, // ใส่สถานะตามที่คุณต้องการ
			);
		}
		$this->genmod->add('see_umsdb', 'ums_policy', $data);
		echo json_encode($status);
	}
	public function edit($PolicyID = "")
	{
		// $data['controller']=$this->controller;
		$data['PolicyID'] = $PolicyID;
		$data['edit'] = $this->genmod->getOne('see_umsdb', 'ums_policy', '*', array('policy_status !=' => 2, 'policy_id' => $PolicyID));
		$policyDetailsArray = [];
		// แยก string เป็น array ตาม comma
		$entries = explode(", ", $data['edit']->policy_text);
		foreach ($entries as $entry) {
			// ใช้ preg_match เพื่อแยก index และค่า
			if (preg_match('/(\d+): (.+)/', $entry, $matches)) {
				$index = $matches[1];
				$value = $matches[2];
				$policyDetailsArray[$index] = $value;
			}
		}
		$data['DetailsArray'] = $policyDetailsArray; // แสดง array ที่แปลงกลับมา
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/policy/v_policy_policy_form', $data);
	}
	public function show_add()
	{

		// $data['controller']=$this->controller;
		// $data['PolicyID'] = $PolicyID;
		// $data['edit'] = $this->genmod->getOne('see_umsdb', 'ums_policy', '*', array('policy_status !=' => 2, 'policy_id' => $PolicyID));
		// $policyDetailsArray = [];
		// // แยก string เป็น array ตาม comma
		// $entries = explode(", ", $data['edit']->policy_text);
		// foreach ($entries as $entry) {
		//     // ใช้ preg_match เพื่อแยก index และค่า
		//     if (preg_match('/(\d+): (.+)/', $entry, $matches)) {
		//         $index = $matches[1];
		//         $value = $matches[2];
		//         $policyDetailsArray[$index] = $value;
		//     }
		// }
		// $data['DetailsArray']=$policyDetailsArray; // แสดง array ที่แปลงกลับมา
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$this->output('ums/policy/v_policy_policy_form', $data);
	}

	public function update()
	{
		$policy_id = $this->input->post('id');
		$policyName = $this->input->post('PolicyNameT');
		$policyDetail = $this->input->post('PolicyDetail');
		$policyFileId = $this->input->post('PolicyFileId');
		$policyActive = $this->input->post('PolicyActive');
		$status = 0;
		$uploadedFileName = 'policy_' . date('Y-m-d_H-i-s');
		$fileExtension = '';
		$old_file = $this->genmod->getOne('see_umsdb', 'ums_policy', 'policy_namefile', array('policy_status !=' => 2, 'policy_id' => $policy_id));
		if (!empty($_FILES['PolicyFileId']['name'])) {
			$uploadDir  = $this->config->item('ums_uploads_Policy');
			$fileExtension = pathinfo($_FILES['PolicyFileId']['name'], PATHINFO_EXTENSION); // Get file extension
			$uploadedFilePath = $uploadDir . $uploadedFileName . '.' . $fileExtension; // Append file extension to file name
			$old_Path = $uploadDir . $old_file->policy_namefile;
			unlink($old_Path);
			$uploadedFileName = $uploadedFileName . '.' . $fileExtension;
			if (move_uploaded_file($_FILES['PolicyFileId']['tmp_name'], $uploadedFilePath)) {
				$status = 1;
				$data = array(
					'policy_name' => $policyName,
					'policy_text' => $policyDetail,
					'policy_status' => $policyActive, // ใส่สถานะตามที่คุณต้องการ
					'policy_namefile' => $uploadedFileName // เก็บทั้งชื่อและนามสกุลของไฟล์ที่อัพโหลด
				);
			} else {
				$status = 0;
			}
		} else {
			$status = 1;
			$data = array(
				'policy_name' => $policyName,
				'policy_text' => $policyDetail,
				'policy_status' => $policyActive, // ใส่สถานะตามที่คุณต้องการ
			);
		}

		$this->genmod->update('see_umsdb', 'ums_policy', $data, array('policy_id' => $policy_id));
		echo json_encode($status);
	}

	public function delete($StID)
	{
		// $data['returnUrl'] = base_url().'index.php/ums/Policy';

		$ck = $this->genmod->update('see_umsdb', 'ums_policy', array('policy_status' => 2), array('policy_id' => $StID));
		if ($ck == true) {
			$data['status_response'] = $this->config->item('status_response_success');
		} else {
			$data['status_response'] = $this->config->item('status_response_error');
		}
		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function consenters()
	{

		$data['session_mn_active_url'] = uri_string(); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/policy/v_policy_consenters_show', $data);
	}

	public function check_status()
	{
		$data['ck'] = $this->genmod->getOne('see_umsdb', 'ums_policy', 'policy_id', array('policy_status =' => 1));
		if ($data['ck']!=false) {
			$data['status_response'] = 1;
		} else {
			$data['status_response'] = 0;
		}
		echo json_encode($data);
	}
	public function update_status()
	{
		$id = $this->input->post();
		$ck = $this->genmod->update('see_umsdb', 'ums_policy', array('policy_status' => 0), array('policy_id' => $id['id']));
		if (isset($data['ck'])) {
			$data['status_response'] = $this->config->item('status_response_success');
		} else {
			$data['status_response'] = $this->config->item('status_response_error');
		}
		echo json_encode($data);
	}
}
