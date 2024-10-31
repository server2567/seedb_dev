<?php 
/*
* System_group
* Main controller of System_group
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 16/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class System_group extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of System_group
	* @input -
	* $output group list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function index() {
		// get list
		$this->load->model('ums/m_ums_group');
		$order = array('gp_name_th'=>'ASC');
		$systems = $this->m_ums_group->get_all_with_system($order)->result_array();

		// encrypt id
		$names = ['gp_id']; // object name need to encrypt 
		$data['groups'] = encrypt_arr_obj_id($systems, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_group_show',$data);
	}

	/*
	* system_group_edit
	* for show insert/edit screen and group data
	* @input gp_id (group id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and group data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_group_edit($gp_id=null) {
		if(!empty($gp_id)) {
			$data['gp_id'] = $gp_id;
			$gp_id = decrypt_id($gp_id);

			$this->load->model('ums/m_ums_group');
			$this->m_ums_group->gp_id = $gp_id;
			$result = $this->m_ums_group->get_by_key()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error
		}

		// get select list
		$this->load->model('ums/m_ums_system');
		$order = array('st_name_th'=>'ASC');
		$systems = $this->m_ums_system->get_all($order, 1)->result_array();
		// encrypt id
		$names = ['st_id']; // object name need to encrypt 
		$data['systems'] = encrypt_arr_obj_id($systems, $names);
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_group_form',$data);
	}

	/*
	* system_group_insert
	* for insert group data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_group_insert() {
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_name_th = $this->input->post("gp_name_th");
		$this->m_ums_group->gp_name_en = $this->input->post("gp_name_en");
		$this->m_ums_group->gp_detail = $this->input->post("gp_detail");
		$this->m_ums_group->gp_st_id = decrypt_id($this->input->post("gp_st_id"));
		$this->m_ums_group->gp_icon = $this->input->post("gp_icon");
		$this->m_ums_group->gp_url = $this->input->post("gp_url");
		$this->m_ums_group->gp_active = $this->input->post("gp_active") == 'on' ? 1 : 0;
		$this->m_ums_group->gp_create_user = $this->session->userdata('us_id');

		// Retrieve selected values of gp_is_medical and convert to comma-separated string
		$gp_is_medical_array = $this->input->post("gp_is_medical");
		$this->m_ums_group->gp_is_medical = is_array($gp_is_medical_array) ? implode(',', $gp_is_medical_array) : '';
		
		// case error by condition check duplication in db
		if(!empty($this->input->post("gp_name_th")) && $this->m_ums_group->get_unique_th()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'gp_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("gp_name_en")) && $this->m_ums_group->get_unique_en()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'gp_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = "ชื่อระบบมีอยู่แล้ว กรุณาสร้างใหม่";
		} else { // case show error from conditions
			// insert
			$this->m_ums_group->insert();

			// save log
			$this->m_ums_logs->insert_log("เพิ่มสิทธิ์ ".$this->m_ums_group->gp_name_th);
				
			$data['status_response'] = $this->config->item('status_response_success');
			$data['returnUrl'] = base_url().'index.php/ums/System_group';
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_group_update
	* for update group data in db
	* @input gp_id (group id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_group_update($gp_id) {
		$gp_id = decrypt_id($gp_id);
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_id = $gp_id;
		$this->m_ums_group->gp_name_th = $this->input->post("gp_name_th");
		$this->m_ums_group->gp_name_en = $this->input->post("gp_name_en");
		$this->m_ums_group->gp_detail = $this->input->post("gp_detail");
		$this->m_ums_group->gp_st_id = decrypt_id($this->input->post("gp_st_id"));
		$this->m_ums_group->gp_icon = $this->input->post("gp_icon");
		$this->m_ums_group->gp_url = $this->input->post("gp_url");
		$this->m_ums_group->gp_active = $this->input->post("gp_active") == 'on' ? 1 : 0;
		$this->m_ums_group->gp_update_user = $this->session->userdata('us_id');
		
		// Retrieve selected values of gp_is_medical and convert to comma-separated string
		$gp_is_medical_array = $this->input->post("gp_is_medical");
		$this->m_ums_group->gp_is_medical = is_array($gp_is_medical_array) ? implode(',', $gp_is_medical_array) : '';
	
		// Case: Check for duplication in the database
		if(!empty($this->input->post("gp_name_th")) && $this->m_ums_group->get_unique_th_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'gp_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("gp_name_en")) && $this->m_ums_group->get_unique_en_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'gp_name_en', 'error' => $this->config->item('text_invalid_duplicate')];
	
		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { 
			// Case: Show error
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else {
			// Case: Success, update the group
			$this->m_ums_group->update();
	
			// Log the update action
			$this->m_ums_logs->insert_log("แก้ไขสิทธิ์ " . $this->m_ums_group->gp_name_th);
	
			$data['status_response'] = $this->config->item('status_response_success');
			$data['returnUrl'] = base_url().'index.php/ums/System_group';
		}
	
		$result = array('data' => $data);
		echo json_encode($result);
	}	

	/*
	* system_group_delete
	* for update active = 2 to group data in db
	* @input gp_id (group id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_group_delete($gp_id) {
		$gp_id = decrypt_id($gp_id);
		
		// set active = 2 from ums_group_permission
		$this->load->model('ums/m_ums_group_permission');
		$this->m_ums_group_permission->gpn_gp_id = $gp_id;
		$this->m_ums_group_permission->update_delete_with_group_id();

		// set active = 2 from ums_group
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_id = $gp_id;
		$this->m_ums_group->gp_update_user = $this->session->userdata('us_id');
		$result = $this->m_ums_group->get_by_key()->row_array(); // get data for save log
		$this->m_ums_group->update_delete();

		// save log
		$this->m_ums_logs->insert_log("ลบสิทธิ์ ".$result['gp_name_th']);

		$data['returnUrl'] = base_url().'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_group_permission
	* for show menu list to set permission (group_permission)
	* @input gp_id (group id)
	* $output menu list of system that group choose (gp_st_id main system)
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function system_group_permission($gp_id) {
		// get ums_group
		$data['gp_id'] = $gp_id;
		$gp_id = decrypt_id($gp_id);
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_id = $gp_id;
		$result = $this->m_ums_group->get_by_key_with_system()->result_array();
		if ($result) 
			$data['group'] = $result[0];
		// else 
		// 	log error
		
		// get ums_menus by system and st_active = 1
		$this->load->model('ums/m_ums_menu');
		$this->m_ums_menu->mn_st_id = $data['group']['gp_st_id'];
		$data['menus'] = $this->m_ums_menu->get_menus_by_sys()->result_array();
		
		// get ums_group_permission by group_id
		$this->load->model('ums/m_ums_group_permission');
		$this->m_ums_group_permission->gpn_gp_id = $gp_id;
		$data['group_permissions'] = $this->m_ums_group_permission->get_by_group_id()->result_array();
 
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_group_permission_form',$data);
	}

	/*
	* system_group_permission_update
	* for update menu permission (group_permission)
	* @input gp_id (group id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function system_group_permission_update($gp_id) {
		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else {
			$gp_id = decrypt_id($gp_id);
			$this->load->model('ums/m_ums_group_permission');

			if (!empty($this->input->post("checkbox_id")) && is_array($this->input->post("checkbox_id"))) {
				// Loop through each checkbox value
				foreach ($this->input->post("checkbox_id") as $id => $value) {
					
					$active = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
					$active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

					$mn_id = str_replace("is_active-", '', $value);
					$mn_id = decrypt_id($mn_id);
					
					$this->m_ums_group_permission->gpn_gp_id = $gp_id;
					$this->m_ums_group_permission->gpn_mn_id = $mn_id;
					$this->m_ums_group_permission->gpn_active = $active;

					// get_id_by_menu_and_group_id($mn_id, $gp_id) check - if have data before, then update else insert
					$group_permission_ids = $this->m_ums_group_permission->get_id_by_menu_and_group_id()->result_array();
					if(!empty($group_permission_ids)) {
						$this->m_ums_group_permission->update();
					}
					else {
						if($active)
							$this->m_ums_group_permission->insert();
					}
				}

				// save log
				$this->load->model('ums/m_ums_group');
				$this->m_ums_group->gp_id = $gp_id;
				$result = $this->m_ums_group->get_by_key()->row_array(); // get data for save log
				$this->m_ums_logs->insert_log("กำหนดสิทธิ์ ".$result['gp_name_th']);
			}

			$data['returnUrl'] = base_url().'index.php/ums/System_group';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
