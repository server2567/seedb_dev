<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Structure_Controller.php');

class Structure_org extends Structure_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('ums/m_ummenu');

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/structure/Structure_org";
	}

	public function index()
	{
		$this->load->model($this->model . "m_hr_structure");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['dp_info'] = $this->m_hr_structure->get_department_active()->result();
		$data['stuc_info'] = $this->m_hr_structure->get_all_by_active()->result();
		$data['controller']  = $this->controller;
		foreach ($data['dp_info'] as $key => $value) {
			$value->dp_id = encrypt_id($value->dp_id);
		}
		foreach ($data['stuc_info'] as $key => $value) {
			$value->stuc_dp_id = encrypt_id($value->stuc_dp_id);
			$value->stuc_id = encrypt_id($value->stuc_id);
		}
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_org_show', $data);
	}
	public function view($DpID = null)
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$this->load->model($this->model . "m_hr_structure");
		$this->load->model($this->model . "m_hr_structure_person");
		$this->load->model($this->model . "../base/m_hr_structure_position");
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
		$stuc_info = $this->m_hr_structure->get_stuc_by_id(decrypt_id($DpID))->result();
		$dp_info = $this->m_hr_structure->get_department_by_id($stuc_info[0]->stuc_dp_id)->result();
		$std_info = $this->m_hr_structure->get_stde_detail_by_id(decrypt_id($DpID))->result();
		$data['stdp_info'] = $this->m_hr_structure_person->get_all_by_active()->result();
		$maxReq = max(array_column($std_info, 'stde_level'));
		$seq = null;
		$array1 = [];
		for ($i = $maxReq; $i > 0; $i--) {
			$filter = array_filter($std_info, function ($obj) use ($i) {
				return $obj->stde_level == $i;
			});
			foreach ($filter as $value) {
				$ps_info = $this->m_hr_structure_person->get_all_by_structure(null, $value->stde_id)->result();
				foreach ($ps_info as $person) {

					if ($person->psd_picture != null) {
						$person->img = '<img src="' . site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . $person->psd_picture) . '">';
					} else {
						$person->img = '<img src="' . site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=default.png") . '">';
					}
				}
				$value->personnel = $ps_info;
				$value->department = null;
			}
			if (count($array1) == 0) {
				$array1 = $filter;
			} else {
				foreach ($filter as $parent_obj) {
					$parent_obj->department = array_values(array_filter($array1, function ($obj) use ($parent_obj) {
						return $obj->stde_parent == $parent_obj->stde_id;
					}));
				}
				$array1 = $filter;
			}
		}
		$dp_info[0]->personal = [];
		$dp_info[0]->department = $array1;
		$array1 = array_values($dp_info);
		$data['mt_info'] = $array1;
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/structure/v_structure_org_mt', $data);
	}
	// For show page
	public function stucture_org_add($DpID)
	{
		$this->load->model($this->model . "m_hr_structure");
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$std_info = $this->m_hr_structure->get_department_by_id(decrypt_id($DpID))->result();
		foreach ($std_info as $value) {
			$data['std_info'] = $value;
		}
		$data['process'] = 'add';
		$data['dp_id'] = encrypt_id($DpID);
		$data['controller']  = $this->controller;
		$this->output('hr/structure/v_structure_org_form_edit', $data);
	}
	public function stucture_org_edit($StucID)
	{
		$this->load->model($this->model . "m_hr_structure");
		$StucID = decrypt_id($StucID);
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$stuc_info = $this->m_hr_structure->get_stuc_by_id($StucID)->result();
		foreach ($stuc_info as $value) {
			$value->stuc_id = encrypt_id($value->stuc_id);
			$data['stuc_info'] = $value;
		}
		$std_info = $this->m_hr_structure->get_department_by_id($data['stuc_info']->stuc_dp_id)->result();
		foreach ($std_info as $value) {
			$data['std_info'] = $value;
		}
		$data['process'] = 'edit';
		$data['controller']  = $this->controller;
		$ps_info = $this->m_hr_structure->get_person()->result();
		foreach ($ps_info as $key => $person) {
			$person->ps_id =  encrypt_id($person->ps_id);
		}
		$data['ps_info'] = $ps_info;
		$this->output('hr/structure/v_structure_org_form_edit', $data);
	}
	public function get_person_position()
	{
		$pos_id = decrypt_id($this->input->post('pos_id'));
		$dp_id = $this->input->post('dp_id');
		$this->load->model($this->model . "m_hr_structure");
		$this->load->model($this->model . "../base/m_hr_structure_position");
		$data['psp_info'] = $this->m_hr_structure->get_person_position($pos_id, $dp_id)->result();
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
		if ($data['psp_info']) {
			foreach ($data['psp_info'] as $key => $value) {
				$value->admin_position = json_decode($value->admin_position);
				$value->spcl_position = json_decode($value->spcl_position);
			}
		}
		echo json_encode($data);
	}
	public function edit_person_position()
	{
		$stdp_id = decrypt_id($this->input->post('stdp_ps_id'));
		$this->load->model($this->model . "m_hr_structure_person");
		$this->load->model($this->model . "../base/m_hr_structure_position");
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
		$data['stdp_info']  = $this->m_hr_structure_person->get_by_id($stdp_id)->result();
		foreach ($data['stdp_info'] as $key => $value) {
			$value->stdp_id = encrypt_id($value->stdp_id);
		}
		echo json_encode($data);
	}
	public function get_stucture_detail()
	{
		$id = decrypt_id($this->input->post('id'));
		$this->load->model($this->model . "m_hr_structure");
		$stde_info = $this->m_hr_structure->get_stde_detail_by_id($id)->result();
		foreach ($stde_info as $key => $row) {
			$row->stde_id = encrypt_id($row->stde_id);
		}
		echo json_encode($stde_info);
	}
	public function update_stdp_seq()
	{
		$post_info = $this->input->post('post_info');
		$this->load->model($this->model . "m_hr_structure_person");
		foreach ($post_info as $key => $value) {
			$this->m_hr_structure_person->stdp_id = decrypt_id($value['stdp_id']);
			$this->m_hr_structure_person->stdp_seq = $value['seq'];
			$this->m_hr_structure_person->stdp_update_user = $this->session->userdata('us_id');
			$this->m_hr_structure_person->update_person_seq();
		}
		$data['status_response'] = $this->config->item('status_response_success');
		echo json_encode($data);
	}
	public function get_stucture_detail_by_id()
	{
		$id = decrypt_id($this->input->post('id'));
		$this->load->model($this->model . "m_hr_structure_detail");
		$stde_info = $this->m_hr_structure_detail->get_by_id($id)->result();
		echo json_encode($stde_info);
	}
	public function get_stuc_person_by_detail()
	{
		$info = $this->input->post('id');
		$stuc_id  = decrypt_id($this->input->post('stuc_id'));
		$this->load->model($this->model . "M_hr_structure_person");
		$this->load->model($this->model . "M_hr_structure");
		$this->load->model($this->model . "../base/m_hr_structure_position");
		$data['base_structure_position'] = $this->m_hr_structure_position->get_all_by_active('asc')->result();
		$index = 0;
		foreach ($info as $key => $value) {
			$id = decrypt_id($value['id']);
			$dp_id = $this->M_hr_structure->get_department_id_by_stuc($stuc_id)->result();
			foreach ($dp_id  as $key => $value2) {
				$dp_id = $value2->stuc_dp_id;
			}
			$person_info[$index]['seq'] = $value['seq'];
			$person_info[$index]['person'] = $this->M_hr_structure_person->get_all_by_structure($dp_id, $id)->result();
			if ($person_info[$index]['person']) {
				foreach ($person_info[$index]['person'] as $person) {
					$array_admin = [];
					$array_special = [];
					$admin_position = json_decode($person->admin_position);
					$spcl_position = json_decode($person->spcl_position);
					if ($admin_position) {
						foreach ($admin_position as $key => $value) {
							$array_admin[] = $value->admin_name;
						}
					}
					if ($spcl_position) {
						foreach ($spcl_position as $key => $value2) {
							$array_special[] = $value2->spcl_name;
						}
					}
					$person->admin_position = $array_admin;
					$person->spcl_position = $array_special;
					$person->stdp_id = encrypt_id($person->stdp_id);
				}
				$index++;
			}
		}
		$data['person_info'] = $person_info;
		echo json_encode($data);
	}
	public function change_stuc_status()
	{
		$this->load->model($this->model . "m_hr_structure");
		$this->m_hr_structure->stuc_dp_id = decrypt_id($this->input->post('dp_id'));
		$this->m_hr_structure->stuc_id = decrypt_id($this->input->post('id'));
		$this->m_hr_structure->stuc_confirm_date = $this->input->post('stuc_confirm_date');
		$this->m_hr_structure->stuc_status = 0;
		$this->m_hr_structure->deselect_old_struc();
		$this->m_hr_structure->stuc_status = 1;
		$this->m_hr_structure->select_struc();
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function update()
	{
		//// case success
		$data['returnUrl'] = base_url() . 'index.php/ums/Base_title';
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

	public function delete($StID)
	{
		// $data['returnUrl'] = base_url().'index.php/ums/Base_title';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	function structure_insert()
	{
		$this->load->model($this->model . "m_hr_structure");
		$this->m_hr_structure->stuc_dp_id = decrypt_id($this->input->post('stuc_dp_id'));
		$this->m_hr_structure->stuc_confirm_date =  new DateTime($this->input->post('stuc_confirm_date'));
		$this->m_hr_structure->stuc_confirm_date = $this->m_hr_structure->stuc_confirm_date->format('Y-m-d');
		$this->m_hr_structure->stuc_status = $this->input->post('stuc_status');
		$this->m_hr_structure->stuc_create_user = $this->session->userdata('us_id');
		$this->m_hr_structure->stuc_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure->insert();
		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_id'] = encrypt_id($this->m_hr_structure->last_insert_id);
		$result = array('data' => $data);
		echo json_encode($result);
	}
	function stucture_person_update()
	{
		$this->load->model($this->model . "m_hr_structure_person");
		$this->m_hr_structure_person->stdp_id = decrypt_id($this->input->post('stdp_id'));
		$this->m_hr_structure_person->stdp_po_id = $this->input->post('stdp_po_id');
		$this->m_hr_structure_person->stdp_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure_person->stdp_active = 1;
		$this->m_hr_structure_person->update_position();
		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_id'] = encrypt_id($this->m_hr_structure_person->last_insert_id);
		$result = array('data' => $data);
		echo json_encode($result);
	}
	/**
	 * Increment version string
	 * 
	 * This function takes a version string (e.g., "1.2" or "1.2.1") and increments the last part.
	 * 
	 * @param string $version - The version string to be incremented.
	 * @return string - The incremented version string.
	 * 
	 * @Author  JIRADAT POMYAI
	 */
	function increment_version($version)
	{
		// Split the version string by dots
		$parts = explode('.', $version);

		// Increment the last part of the version
		$parts[count($parts) - 1]++;

		// Join the parts back together with dots
		$new_version = implode('.', $parts);

		return $new_version;
	}
	function structure_detail_insert()
	{
		$this->load->model($this->model . "m_hr_structure_detail");
		$check = $this->m_hr_structure_detail->get_stde_check_by_parent(decrypt_id($this->input->post('stde_parent')))->row();
		if ($check) {
			$seq = $this->increment_version($check->stde_seq);
		} else {
			$seq =  $this->input->post('stde_seq');
		}
		$this->m_hr_structure_detail->stde_stuc_id = decrypt_id($this->input->post('stde_stuc_id'));
		$this->m_hr_structure_detail->stde_name_th = $this->input->post('stde_name_th');
		$this->m_hr_structure_detail->stde_name_en = $this->input->post('stde_name_en');
		$this->m_hr_structure_detail->stde_parent = decrypt_id($this->input->post('stde_parent'));
		$this->m_hr_structure_detail->stde_desc = $this->input->post('stde_desc');
		$this->m_hr_structure_detail->stde_seq = $seq;
		$this->m_hr_structure_detail->stde_level = $this->input->post('stde_level');
		$this->m_hr_structure_detail->stde_create_user = $this->session->userdata('us_id');
		$this->m_hr_structure_detail->stde_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure_detail->stde_is_medical = $this->input->post('stde_is_medical');
		$this->m_hr_structure_detail->insert();
		$data['status_response'] = $this->config->item('status_response_success');
		$data['return_id'] = encrypt_id($this->m_hr_structure_detail->last_insert_id);
		$result = array('data' => $data);
		echo json_encode($result);
	}
	function structure_person_insert()
	{
		$this->load->model($this->model . "m_hr_structure_person");
		$this->load->model($this->model . "m_hr_structure");
		$stde_id = decrypt_id($this->input->post('stdp_stde_id'));
		$ps_id = decrypt_id($this->input->post('stdp_ps_id'));
		$dp_id = $this->input->post('dp_id');
		$finding = $this->m_hr_structure_person->find_structure_person($stde_id, $ps_id)->result();
		if (count($finding) == 0) {
			$this->m_hr_structure_person->stdp_stde_id = $stde_id;
			$this->m_hr_structure_person->stdp_ps_id = $ps_id;
			$this->m_hr_structure_person->stdp_seq = $this->input->post('stdp_seq');
			$this->m_hr_structure_person->stdp_po_id = $this->input->post('stdp_po_id');
			$this->m_hr_structure_person->stdp_active = 1;
			$this->m_hr_structure_person->stdp_create_user = $this->session->userdata('us_id');
			$this->m_hr_structure_person->insert();
			$data['status_response'] = $this->config->item('status_response_success');
		} else {
			$data['status_response'] = $this->config->item('status_response_error');
		}
		$person_po = $this->m_hr_structure->get_person_position($ps_id, $dp_id)->result();
		foreach ($person_po as $key => $value) {
			$value->admin_position = json_decode($value->admin_position);
			$value->spcl_position = json_decode($value->spcl_position);
		}
		$data['position'] = $person_po;
		$data['return_id'] = encrypt_id($this->m_hr_structure_person->last_insert_id);
		$result = array('data' => $data);
		echo json_encode($result);
	}
	function structure_detail_update()
	{
		$this->load->model($this->model . "m_hr_structure_detail");
		$this->m_hr_structure_detail->stde_id = decrypt_id($this->input->post('stde_id'));
		$this->m_hr_structure_detail->stde_stuc_id = $this->input->post('stde_stuc_id');
		$this->m_hr_structure_detail->stde_name_th = $this->input->post('stde_name_th');
		$this->m_hr_structure_detail->stde_name_en = $this->input->post('stde_name_en');
		$this->m_hr_structure_detail->stde_desc = $this->input->post('stde_desc');
		$this->m_hr_structure_detail->stde_level = $this->input->post('stde_level');
		$this->m_hr_structure_detail->stde_is_medical = $this->input->post('stde_is_medical');
		$this->m_hr_structure_detail->stde_update_user = $this->session->userdata('us_id');
		$this->m_hr_structure_detail->update();
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function delete_structure_org($id)
	{
		$this->load->model($this->model . "m_hr_structure");
		$this->m_hr_structure->stuc_id = decrypt_id($id);
		$this->m_hr_structure->stuc_status = '3';
		$this->m_hr_structure->disabled();
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function delete_structure_detail()
	{
		$this->load->model($this->model . "m_hr_structure_detail");
		$this->m_hr_structure_detail->stde_id = decrypt_id($this->input->post('delete_id'));
		$stde_info = $this->m_hr_structure_detail->get_by_id($this->m_hr_structure_detail->stde_id)->result();
		foreach ($stde_info as $key => $value) {
			$check_result = $this->m_hr_structure_detail->get_stde_check($value->stde_stuc_id, $value->stde_seq)->result();
		}
		if (!empty($check_result) && count($check_result) > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
		} else {
			$stdp_info  = $this->m_hr_structure_detail->get_person_by_stde_id($this->m_hr_structure_detail->stde_id)->result();
			if (count($stdp_info) > 0) {
				$data['status_response'] = $this->config->item('status_response_error');
			} else {
				$this->m_hr_structure_detail->disabled();
				$data['status_response'] = $this->config->item('status_response_success');
			}
		};
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function delete_structure_person()
	{
		$this->load->model($this->model . "m_hr_structure_person");
		$this->m_hr_structure_person->stdp_id = decrypt_id($this->input->post('stdp_stde_id'));
		$this->m_hr_structure_person->stdp_active = 2;
		$this->m_hr_structure_person->disabled();
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}
	public function structure_person_update_seq()
	{
		$this->load->model($this->model . "m_hr_structure_person");
		$info = $this->input->post('info');
		foreach ($info as $key => $value) {
			$this->m_hr_structure_person->stdp_id = decrypt_id($value['value']);
			$this->m_hr_structure_person->stdp_seq = $value['index'];
			$this->m_hr_structure_person->update_person_seq();
		}
	}
}
