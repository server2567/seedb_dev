<?php 
/*
* User
* Main controller of User
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 27/05/2024
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class User extends UMS_Controller {
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	/*
	* index
	* Index controller of User
	* @input -
	* $output user list
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function index() {
		// get list
		$this->load->model('ums/m_ums_user');
		$order = array('us_name'=>'ASC');
		$users = $this->m_ums_user->get_all($order)->result_array();

		// encrypt id
		$names = ['us_id']; // object name need to encrypt 
		$data['users'] = encrypt_arr_obj_id($users, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/user/v_user_user_show',$data);
	}

	/*
	* user_edit
	* for show insert/edit screen and user data
	* @input us_id (user id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and user data
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function user_edit($us_id=null) {
		if(!empty($us_id)) {
			$data['us_id'] = $us_id;
			$us_id = decrypt_id($us_id);

			$this->load->model('ums/m_ums_user');
			$this->m_ums_user->us_id = $us_id;
			$result = $this->m_ums_user->get_by_key()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error

			$this->load->model('ums/m_ums_usergroup');
			$this->m_ums_usergroup->ug_us_id = $us_id;
			$data['edit_usergroups'] = $this->m_ums_usergroup->get_by_user_id()->result_array();
		}

		// get select list
		$this->load->model('ums/m_ums_department');
		$order = array('dp_name_th'=>'ASC');
		$departments = $this->m_ums_department->get_all($order)->result_array();
		$this->load->model('ums/m_ums_base_group');
		$order = array('bg_name_th'=>'ASC');
		$base_groups = $this->m_ums_base_group->get_all($order, 1)->result_array();

		// encrypt id
		$names = ['dp_id']; // object name need to encrypt 
		$data['departments'] = encrypt_arr_obj_id($departments, $names);
		$names = ['bg_id']; // object name need to encrypt 
		$data['base_groups'] = encrypt_arr_obj_id($base_groups, $names);

		// get select list (not encrypt)
		$this->load->model('ums/m_ums_system');
		$this->load->model('ums/m_ums_group');
		$data['systems'] = $this->m_ums_system->get_all(array('st_name_th'=>'ASC'), 1)->result_array();
		$data['groups'] = $this->m_ums_group->get_all(array('gp_name_th'=>'ASC'), 1)->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/user/v_user_user_form',$data);
	}

	/*
	* user_insert
	* for insert user data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function user_insert() {
		$us_dp_id = $this->input->post("us_dp_id");
		$us_dp_id = decrypt_id($us_dp_id);
		$us_bg_id = $this->input->post("us_bg_id");
		$us_bg_id = decrypt_id($us_bg_id);

		$this->load->model('ums/m_ums_user');
		$this->m_ums_user->us_name = $this->input->post("us_name");
		$this->m_ums_user->us_dp_id = $us_dp_id;
		$this->m_ums_user->us_bg_id = $us_bg_id;
		$this->m_ums_user->us_psd_id_card_no = $this->input->post("us_psd_id_card_no");
		$this->m_ums_user->us_username = $this->input->post("us_username");
		$this->m_ums_user->us_password = md5("O]O".$this->input->post("us_password")."O[O");
		$this->m_ums_user->us_email = $this->input->post("us_email");
		$this->m_ums_user->us_detail = $this->input->post("us_detail");
		$this->m_ums_user->us_active = $this->input->post("us_active") == 'on' ? 1 : 0;
		$this->m_ums_menu->us_create_user = $this->session->userdata('us_id');
		$this->m_ums_menu->us_update_user = $this->session->userdata('us_id');

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

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case show error from conditions
			// save ums_user
			$this->m_ums_user->insert();
		
			// save ums_usergroup
			$us_id = $this->m_ums_user->last_insert_id;
			$this->load->model('ums/m_ums_usergroup');
			$this->m_ums_usergroup->ug_us_id = $us_id;
			foreach ($gp_ids as $gp_id) {
				$this->m_ums_usergroup->ug_gp_id = $gp_id;
				$this->m_ums_usergroup->insert();
			}

			// save ums_usergroup_history
			$this->load->model('ums/m_ums_group');
			$this->load->model('ums/m_ums_usergroup_history');
			$this->m_ums_usergroup_history->ughi_us_id = $us_id;
			$this->m_ums_usergroup_history->ughi_ip = $_SERVER['REMOTE_ADDR'];
			$this->m_ums_usergroup_history->ughi_agent = $_SERVER['HTTP_USER_AGENT'];
			$this->m_ums_usergroup_history->ughi_create_user = $this->session->userdata('us_id');
			foreach ($gp_ids as $gp_id) {
				// get group name for insert history (add)
				$this->m_ums_group->gp_id = $gp_id;
				$result = $this->m_ums_group->get_by_key()->result_array();
				if ($result) {
					$name = $result[0]['gp_name_th'];
					$this->m_ums_usergroup_history->ughi_changed = "เพิ่มสิทธิ์ ".$name;
					$this->m_ums_usergroup_history->ughi_gp_id = $gp_id;
					$this->m_ums_usergroup_history->insert();
				}
			}
			
			// save log
			$this->m_ums_logs->insert_log("เพิ่มผู้ใช้ ".$this->m_ums_user->us_name);

			$data['returnUrl'] = base_url().'index.php/ums/User';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* user_update
	* for update user data in db
	* @input us_id (user id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function user_update($us_id) {
		$us_id = decrypt_id($us_id);
		$us_dp_id = $this->input->post("us_dp_id");
		$us_dp_id = decrypt_id($us_dp_id);
		$us_ps_id = $this->input->post("us_ps_id");
		$us_ps_id = decrypt_id($us_ps_id);
		$us_bg_id = $this->input->post("us_bg_id");	// case sync from hr
		$us_bg_id = decrypt_id($us_bg_id);

		$this->load->model('ums/m_ums_user');
		$this->m_ums_user->us_id = $us_id;
		$this->m_ums_user->us_name = $this->input->post("us_name");
		$this->m_ums_user->us_dp_id = $us_dp_id;
		$this->m_ums_user->us_ps_id = $us_ps_id;
		$this->m_ums_user->us_bg_id = $us_bg_id;
		$this->m_ums_user->us_psd_id_card_no = $this->input->post("us_psd_id_card_no");
		$this->m_ums_user->us_sync = $this->input->post("us_sync");
		$this->m_ums_user->us_username = $this->input->post("us_username");
		$this->m_ums_user->us_email = $this->input->post("us_email");
		$this->m_ums_user->us_detail = $this->input->post("us_detail");
		$this->m_ums_user->us_active = $this->input->post("us_active") == 'on' ? 1 : 0;
		$this->m_ums_menu->us_update_user = $this->session->userdata('us_id');

		// if change password
		$us_password = $this->input->post("us_password");
		if(!empty($us_password))
			$this->m_ums_user->us_password = md5("O]O".$us_password."O[O");
		else {
			$user = $this->m_ums_user->get_by_key()->result_array();
			if ($user) 
				$user = $user[0];
			$this->m_ums_user->us_password = $user['us_password'];
		}

		$gp_ids_active = [];
		$gp_ids_not_active = [];
		if (!empty($this->input->post("checkbox_id")) && is_array($this->input->post("checkbox_id"))) {
			// Loop through each checkbox value
			foreach ($this->input->post("checkbox_id") as $id => $value) {
				
				$active = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
				$active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

				$gp_id = str_replace("is_active-", '', $value);
				$gp_id = decrypt_id($gp_id);
				
				if($active)
					$gp_ids_active[] = $gp_id;
				else 
					$gp_ids_not_active[] = $gp_id;
			}
		}

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case show error from conditions
			// save ums_user
			$this->m_ums_user->update();

			// save ums_usergroup
			$this->load->model('ums/m_ums_usergroup');
			$this->m_ums_usergroup->ug_us_id = $us_id;
			$old_usergroup = $this->m_ums_usergroup->get_by_user_id()->result_array(); // get for insert ums_usergroup_history (reduce)
			$this->m_ums_usergroup->delete_by_user_id();
			foreach ($gp_ids_active as $gp_id) {
				$this->m_ums_usergroup->ug_gp_id = $gp_id;
				$this->m_ums_usergroup->insert();
			}

			// save ums_usergroup_history
			$this->load->model('ums/m_ums_group');
			$this->load->model('ums/m_ums_usergroup_history');
			$this->m_ums_usergroup_history->ughi_us_id = $us_id;
			$this->m_ums_usergroup_history->ughi_ip = $_SERVER['REMOTE_ADDR'];
			$this->m_ums_usergroup_history->ughi_agent = detect_device_type();
			$this->m_ums_usergroup_history->ughi_create_user = $this->session->userdata('us_id');
			// add
			foreach ($gp_ids_active as $gp_id) {
				// get group name for insert history
				$this->m_ums_group->gp_id = $gp_id;
				$result = $this->m_ums_group->get_by_key()->result_array();
				if ($result) {
					$name = $result[0]['gp_name_th'];
					$this->m_ums_usergroup_history->ughi_changed = "เพิ่มสิทธิ์ ".$name;
					$this->m_ums_usergroup_history->ughi_gp_id = $gp_id;
					$this->m_ums_usergroup_history->insert();
				}
			}
			// reduce
			foreach ($gp_ids_not_active as $gp_id) {
				$is_insert_his = false;
				foreach ($old_usergroup as $obj) {
					if ($obj['ug_gp_id'] == $gp_id)
						$is_insert_his = true;
					if($is_insert_his)
						break;
				}
				if ($is_insert_his) {
					// get group name for insert history (delete)
					$this->m_ums_group->gp_id = $gp_id;
					$result = $this->m_ums_group->get_by_key()->result_array();
					if ($result) {
						$name = $result[0]['gp_name_th'];
						$this->m_ums_usergroup_history->ughi_changed = "ลบสิทธิ์ ".$name;
						$this->m_ums_usergroup_history->ughi_gp_id = $gp_id;
						$this->m_ums_usergroup_history->insert();
					}
				}
			}
			
			// save log
			$this->m_ums_logs->insert_log("แก้ไขผู้ใช้ ".$this->m_ums_user->us_name);

			$data['returnUrl'] = base_url().'index.php/ums/User';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* user_delete
	* for update active = 2 to user data in db
	* @input us_id (user id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function user_delete($us_id)  {
		$us_id = decrypt_id($us_id);

		$this->load->model('ums/m_ums_user');
		$this->m_ums_user->us_id = $us_id;
		$result = $this->m_ums_user->get_by_key()->row_array(); // get data for save log
		$this->m_ums_user->us_update_user = $this->session->userdata('us_id');

		// update delete
		$this->m_ums_user->update_delete();

		// save log
		$this->m_ums_logs->insert_log("ลบผู้ใช้ ".$result['us_name']);

		$data['returnUrl'] = base_url().'index.php/ums/User';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* user_usergroup
	* Screen for show usergroup list of user
	* @input us_id (user id)
	* $output usergroup list of user
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function user_usergroup($us_id) {
		$data['us_id'] = $us_id;
		$us_id = decrypt_id($us_id);

		// get list
		$this->load->model('ums/m_ums_usergroup');
		$this->m_ums_usergroup->ug_us_id = $us_id;
		$order = array('gp_name_th'=>'ASC');
		$usergroups = $this->m_ums_usergroup->get_groups_by_user_id($order)->result_array();

		// encrypt id
		$names = ['ug_gp_id']; // object name need to encrypt 
		$data['usergroups'] = encrypt_arr_obj_id($usergroups, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/user/v_user_usergroup_show', $data);
	}
	
	/*
	* user_usergroup_edit
	* Screen for show menu permission list
	* @input 
			us_id (user id) :: 
			ug_gp_id (group id) :: one of in usergroup of user
	* $output menu permission list
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function user_usergroup_edit($us_id, $ug_gp_id) {
		$data['us_id'] = $us_id;
		$data['gp_id'] = $ug_gp_id; // name $data['gp_id'] cause reuse value for use in view group_permission
		$us_id = decrypt_id($us_id);
		$ug_gp_id = decrypt_id($ug_gp_id);

		// get list menu from ums_group_permission
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_id = $ug_gp_id;
		$result = $this->m_ums_group->get_by_key_with_system()->result_array();
		if ($result) {
			$data['group'] = $result[0];

			$this->load->model('ums/m_ums_menu');
			$this->m_ums_menu->mn_st_id = $data['group']['gp_st_id'];
			$data['menus'] = $this->m_ums_menu->get_menus_by_sys()->result_array();
			
			$this->load->model('ums/m_ums_group_permission');
			$this->m_ums_group_permission->gpn_gp_id = $ug_gp_id;
			$data['group_permissions'] = $this->m_ums_group_permission->get_by_group_id()->result_array();

		} else {
			$data['menus'] = [];
			$data['group_permissions'] = [];
			// error
		}

		// get list ums_permission
		$this->load->model('ums/m_ums_permission');
		$this->m_ums_permission->pm_us_id = $us_id;
		$permissions = $this->m_ums_permission->get_by_user_id()->result_array();
		
		foreach ($permissions as $pm) {
			$found = false;
			foreach ($data['group_permissions'] as &$gpn) {
				if ($gpn['gpn_mn_id'] == $pm['pm_mn_id']) {
					$gpn['gpn_active'] = $pm['pm_active'];
					$found = true;
					break;
				}
			}
		
			if (!$found) {
				$object = [
					'gpn_gp_id' => $ug_gp_id,
					'gpn_mn_id' => $pm['pm_mn_id'],
					'gpn_active' => $pm['pm_active']
				];
				$data['group_permissions'][] = $object;
			}
		}
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_group_permission_form',$data); // reuse file
	}

	/*
	* user_usergroup_update
	* for update menu permission list in db
	* @input us_id (user id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function user_usergroup_update($us_id) {
		// 1. $pm_us_id = $us_id;
		// 2. get all mn_id in ums_system
		// 3. $pm_mn_id = mn_id in ums_group_permission + checkbox is_active
		// 4. go to update ums_permission
		
		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else {
			$us_id = decrypt_id($us_id);
			$this->load->model('ums/m_ums_permission');

			if (!empty($this->input->post("checkbox_id")) && is_array($this->input->post("checkbox_id"))) {
				// Loop through each checkbox value
				foreach ($this->input->post("checkbox_id") as $id => $value) {
					
					$active = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
					$active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

					$mn_id = str_replace("is_active-", '', $value);
					$mn_id = decrypt_id($mn_id);
					
					$this->m_ums_permission->pm_us_id = $us_id;
					$this->m_ums_permission->pm_mn_id = $mn_id;
					$this->m_ums_permission->pm_active = $active;

					// get_id_by_menu_and_user_id($mn_id, $us_id) check - if have data before, then update else insert
					$permission_ids = $this->m_ums_permission->get_id_by_menu_and_user_id()->result_array();
					if(!empty($permission_ids)) {
						$this->m_ums_permission->update();
					}
					else {
						if($active)
							$this->m_ums_permission->insert();
					}
				}
			}

			// save log
			$this->load->model('ums/m_ums_user');
			$this->m_ums_user->us_id = $us_id;
			$result = $this->m_ums_user->get_by_key()->row_array();  // get data for save log
			$this->m_ums_logs->insert_log("กำหนดสิทธิ์ของผู้ใช้ ".$result['us_name']);
			
			$data['returnUrl'] = base_url().'index.php/ums/User/user_usergroup/'.encrypt_id($us_id);
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* user_usergroup_check_group
	* for check group is a member in base group
	* @input 
			gp_id (group id) :: group that need to check
			bg_id (base group id) :: base group that select from user and have multi group mapping
	* $output boolean
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function user_usergroup_check_group() {
		/* 
		1. parameter -> base_group_id
		2. base_group_permission.ugp_gp_id
		 */
		$is_group_in_base_group = false;
		$gp_id = $this->input->post("gp_id");
		$bg_id = $this->input->post("bg_id");

		if(!empty($gp_id) && !empty($bg_id)) {
			$gp_id = str_replace("is_active-", '', $gp_id);
			$gp_id = decrypt_id($gp_id);
			$bg_id = decrypt_id($bg_id);
			
			$this->load->model('ums/m_ums_base_group_permission');
			$this->m_ums_base_group_permission->ugp_gp_id = $gp_id;
			$this->m_ums_base_group_permission->ugp_bg_id = $bg_id;
			$result = $this->m_ums_base_group_permission->get_by_key()->result_array();
			if ($result) $is_group_in_base_group = true;
		}
		
		echo json_encode($is_group_in_base_group);
	}
}
