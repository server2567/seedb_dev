<?php 
/*
* System_base_group
* Main controller of System_base_group
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 16/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class System_base_group extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of System_base_group
	* @input -
	* $output base group list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function index() {
		// get list
		$this->load->model('ums/m_ums_base_group');
		$order = array('bg_name_th'=>'ASC');
		$base_groups = $this->m_ums_base_group->get_all($order)->result_array();

		// encrypt id
		$names = ['bg_id']; // object name need to encrypt 
		$data['base_groups'] = encrypt_arr_obj_id($base_groups, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_base_group_show',$data);
	}

	/*
	* base_group_edit
	* for show insert/edit screen and base group data
	* @input bg_id (base group id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and base group data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function base_group_edit($bg_id=null) {
		if(!empty($bg_id)) {
			$data['bg_id'] = $bg_id;
			$bg_id = decrypt_id($bg_id);

			$this->load->model('ums/m_ums_base_group');
			$this->m_ums_base_group->bg_id = $bg_id;
			$result = $this->m_ums_base_group->get_by_key()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error

			$this->load->model('ums/m_ums_base_group_permission');
			$this->m_ums_base_group_permission->ugp_bg_id = $bg_id;
			$data['edit_bg_permissions'] = $this->m_ums_base_group_permission->get_by_base_group()->result_array();
		}
		
		// get select list
		$this->load->model('ums/m_ums_system');
		$this->load->model('ums/m_ums_group');
		$data['systems'] = $this->m_ums_system->get_all(array('st_name_th'=>'ASC'), 1)->result_array();
		$data['groups'] = $this->m_ums_group->get_all(array('gp_name_th'=>'ASC'), 1)->result_array();
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_base_group_form',$data);
	}
	
	/*
	* base_group_insert
	* for insert base group data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function base_group_insert() {
		$this->load->model('ums/m_ums_base_group');
		$this->m_ums_base_group->bg_name_th = $this->input->post("bg_name_th");
		$this->m_ums_base_group->bg_name_en = $this->input->post("bg_name_en");
		$this->m_ums_base_group->bg_active = filter_var($this->input->post("bg_active"), FILTER_VALIDATE_BOOLEAN);

		$gp_ids = [];
		if (!empty($this->input->post("checkbox_id")) && is_array($this->input->post("checkbox_id"))) {
			// Loop through each checkbox value
			foreach ($this->input->post("checkbox_id") as $id => $value) {
				
				$active = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
				$active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

				$gp_id = str_replace("is_active-", '', $value);
				$gp_id = decrypt_id($gp_id);
				
				if($active)
					$gp_ids[] = $gp_id;
			}
		}

		// case error by condition check value from client
		if(count($gp_ids) == 0)
			$data['error_inputs'][] = (object) ['name' => 'user_group_permission', 'error' => "กรุณาเลือกสิทธิ์การใช้อย่างน้อย 1 สิทธิ์"];

		// case error by condition check duplication in db
		if(!empty($this->input->post("bg_name_th")) && $this->m_ums_base_group->get_unique_th()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'bg_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("bg_name_en")) && $this->m_ums_base_group->get_unique_en()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'bg_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case show error from conditions
			// insert
			$this->m_ums_base_group->insert();
		
			// insert ums_base_group_permission
			$bg_id = $this->m_ums_base_group->last_insert_id;
			$this->load->model('ums/m_ums_base_group_permission');
			$this->m_ums_base_group_permission->ugp_bg_id = $bg_id;
			foreach ($gp_ids as $gp_id) {
				$this->m_ums_base_group_permission->ugp_gp_id = $gp_id;
				$this->m_ums_base_group_permission->insert();
			}

			// save log
			$this->m_ums_logs->insert_log("เพิ่มกลุ่มผู้ใช้ ".$this->m_ums_base_group->bg_name_th);

			$data['returnUrl'] = base_url().'index.php/ums/System_base_group';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
	
	/*
	* base_group_update
	* for update base group data in db
	* @input bg_id (base group id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function base_group_update($bg_id) {
		$bg_id = decrypt_id($bg_id);
		$this->load->model('ums/m_ums_base_group');
		$this->m_ums_base_group->bg_id = $bg_id;
		$this->m_ums_base_group->bg_name_th = $this->input->post("bg_name_th");
		$this->m_ums_base_group->bg_name_en = $this->input->post("bg_name_en");
		$this->m_ums_base_group->bg_active = filter_var($this->input->post("bg_active"), FILTER_VALIDATE_BOOLEAN);
		
		$gp_ids = [];
		if (!empty($this->input->post("checkbox_id")) && is_array($this->input->post("checkbox_id"))) {
			// Loop through each checkbox value
			foreach ($this->input->post("checkbox_id") as $id => $value) {
				
				$active = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
				$active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

				$gp_id = str_replace("is_active-", '', $value);
				$gp_id = decrypt_id($gp_id);
				
				if($active)
					$gp_ids[] = $gp_id;
			}
		}

		// case error by condition check value from client
		if(count($gp_ids) == 0)
			$data['error_inputs'][] = (object) ['name' => 'user_group_permission', 'error' => "กรุณาเลือกสิทธิ์การใช้อย่างน้อย 1 สิทธิ์"];

		// case error by condition check duplication in db
		if(!empty($this->input->post("bg_name_th")) && $this->m_ums_base_group->get_unique_th_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'bg_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("bg_name_en")) && $this->m_ums_base_group->get_unique_en_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'bg_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case show error from conditions
			// update
			$this->m_ums_base_group->update();

			// update ums_base_group_permission
			$this->load->model('ums/m_ums_base_group_permission');
			// delete all old gp_id with bg_id in m_ums_base_group_permission and new save
			$this->m_ums_base_group_permission->ugp_bg_id = $bg_id;
			$this->m_ums_base_group_permission->delete_by_base_group();

			foreach ($gp_ids as $gp_id) {
				$this->m_ums_base_group_permission->ugp_gp_id = $gp_id;
				$this->m_ums_base_group_permission->insert();
			}

			// save log
			$this->m_ums_logs->insert_log("แก้ไขกลุ่มผู้ใช้ ".$this->m_ums_base_group->bg_name_th);

			$data['returnUrl'] = base_url().'index.php/ums/System_base_group';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* base_group_delete
	* for update active = 2 to base group data in db
	* @input bg_id (base group id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function base_group_delete($bg_id) {
		$bg_id = decrypt_id($bg_id);
		
		// // Save Backup Data
		
		// Check if ums_group is being used or not.
		$this->load->model('ums/m_ums_user');
		$this->m_ums_user->bg_id = $bg_id;
		$count_user = $this->m_ums_user->get_count_by_base_group()->result_array();
		if(!empty($count_user) && $count_user[0]['count_us_id'] > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_toast_delete_error_body');
		}
		else {
			// delete from ums_group_permission
			$this->load->model('ums/m_ums_base_group_permission');
			$this->m_ums_base_group_permission->ugp_bg_id = $bg_id;
			$this->m_ums_base_group_permission->delete_by_base_group();
	
			$this->load->model('ums/m_ums_base_group');
			$this->m_ums_base_group->bg_id = $bg_id;
			$result = $this->m_ums_base_group->get_by_key()->row_array(); // get data for save log

			// update delete
			$this->m_ums_base_group->update_delete();

			// save log
			$this->m_ums_logs->insert_log("ลบกลุ่มผู้ใช้ ".$result['bg_name_th']);
	
			$data['returnUrl'] = base_url().'index.php/ums/System';
			$data['status_response'] = $this->config->item('status_response_success');
		}


		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
