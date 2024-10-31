
<?php 
/*
* User_user_group_multi
* Main controller of User_user_group_multi
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 27/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class User_user_group_multi extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
	}

	/*
	* index
	* Index controller of User_user_group_multi
	* @input -
	* $output screen for update usergroup
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function index() {
		// get select list
		$this->load->model('ums/m_ums_base_group');
		$order = array('bg_name_th'=>'ASC');
		$base_groups = $this->m_ums_base_group->get_all($order, 1)->result_array();
		$this->load->model('ums/m_ums_system');
		$order = array('st_name_th'=>'ASC');
		$systems = $this->m_ums_system->get_all($order, 1)->result_array();

		// encrypt id
		$names = ['bg_id']; // object name need to encrypt 
		$data['base_groups'] = encrypt_arr_obj_id($base_groups, $names);
		$names = ['st_id']; // object name need to encrypt 
		$data['systems'] = encrypt_arr_obj_id($systems, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/user/v_user_user_group_multi_show',$data);
	}

	/*
	* User_user_group_multi_get_groups
	* for get groups dropdown list
	* @input st_id
	* $output html option of groups
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function User_user_group_multi_get_groups() {
		$st_id = $this->input->post('st_id');

		// get select list
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_st_id = decrypt_id($st_id);
		$order = array('gp_name_th'=>'ASC');
		$groups = $this->m_ums_group->get_by_system_id($order)->result_array();

		// encrypt id
		$names = ['gp_id']; // object name need to encrypt 
		$groups = encrypt_arr_obj_id($groups, $names);
		echo "<option value=''>-----เลือก-----</option>";
		foreach($groups as $key => $row) {
			echo "<option value='".$row['gp_id']."'>".$row['gp_name_th']."</option>";
		}
	}
	
	/*
	* User_user_group_multi_get_users
	* for get users that have same base groups
	* @input value from search form
	* $output html row of users 
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function User_user_group_multi_get_users() {
		$bg_ids = $this->input->post('bg_ids');
		$st_id = $this->input->post('st_id');
		$gp_id = $this->input->post('gp_id');
		$ug_gp_id = $this->input->post('gp_id'); // ug_gp_id encrypt from gp_id
		$name = $this->input->post('name'); // name from input search name

		if(is_array($bg_ids)) {
			foreach($bg_ids as $key => $row){
				$bg_ids[$key] = decrypt_id($row);
			}
		}
		$st_id = decrypt_id($st_id);
		$gp_id = decrypt_id($gp_id);

		// get users by bg_ids (user.us_bg_id)
		$this->load->model('ums/m_ums_user');
		$users = $this->m_ums_user->get_by_base_group_ids($bg_ids, $name)->result_array();

		// set st_id
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_id = $st_id;
		$result = $this->m_ums_system->get_by_key()->result_array();
		if ($result) $system = $result[0];
		
		// set gp_id
		$this->load->model('ums/m_ums_group');
		$this->m_ums_group->gp_id = $gp_id;
		$result = $this->m_ums_group->get_by_key()->result_array();
		if ($result) $group = $result[0];

		if($system && $group) {
			foreach($users as $key => $row) {
				$us_id = encrypt_id($row['us_id']);
				
				echo "<tr>";
				// echo "<td width='5%'>
				// 		<input class='form-check-input' type='checkbox' name='is_check".$us_id."'>
				// 		<input type='hidden' name='checkbox_id' value='is_check".$us_id."'>
				// 		<input type='hidden' name='ug_gp_id' value='".$ug_gp_id."'>
				// 	  </td>";
				echo "<td width='5%'>
						<input class='form-check-input' type='checkbox' name='is_check".$us_id."'>
						<input type='hidden' name='ug_us_id[]' value='is_check".$us_id."'>
						<input type='hidden' name='ug_gp_id[]' value='".$ug_gp_id."'>
						<input type='hidden' name='bg_name_th[]' value='".$row['bg_name_th']."'>
						<input type='hidden' name='gp_name_th[]' value='".$group['gp_name_th']."'>
					</td>";
				echo "<td width='25%'>".$row['bg_name_th']."</td>";
				echo "<td width='25%'>".$row['us_name']."</td>";
				echo "<td width='25%'>".$system['st_name_th']."</td>";
				echo "<td width='20%'>".$group['gp_name_th']."</td>";
				echo "</tr>";
			}
		}
	}
	
	/*
	* User_user_group_multi_update
	* for update usergroup for user in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function User_user_group_multi_update() {
		// save in usergroup
		$ug_us_id = $this->input->post('ug_us_id');
		$ug_gp_id = $this->input->post('ug_gp_id');
		$bg_name_th = $this->input->post('bg_name_th');
		$gp_name_th = $this->input->post('gp_name_th');
		$action = $this->input->post('action');

		// case error by condition check value from client
		if(!isset($ug_us_id) || empty($ug_us_id) || !is_array($ug_us_id) || count($ug_us_id) == 0)
			$data['error_inputs'][] = (object) ['name' => 'message_error', 'error' => "ต้องมีรายชื่อผู้ใช้งานอย่างน้อย 1 คน"];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			$this->load->model('ums/m_ums_usergroup');
			$bg_name_ths = [];
			$gp_name = "";
			foreach($ug_us_id as $key => $value) {
				$check = !empty($this->input->post($value)) ? $this->input->post($value) : 'off';
				$check = filter_var($check, FILTER_VALIDATE_BOOLEAN);

				if($check) {
					$us_id = str_replace("is_check", '', $value);
					$us_id = decrypt_id($us_id);
					
					$this->m_ums_usergroup->ug_us_id = $us_id;
					$this->m_ums_usergroup->ug_gp_id = decrypt_id($ug_gp_id[$key]);

					$result = $this->m_ums_usergroup->get_by_key()->result_array(); // check user have group that want to edit

					if($gp_name <> $gp_name_th[$key]) // get group name for save log
						$gp_name = $gp_name_th[$key];
					if(!in_array($bg_name_th[$key], $bg_name_ths)) // get base group name for save log
						$bg_name_ths[] = $bg_name_th[$key];

					if($action == 'add')
						$this->m_ums_usergroup->ug_active = 1;
					else if($action == 'cancel')
						$this->m_ums_usergroup->ug_active = 0;

					if ($result)
						$this->m_ums_usergroup->update();
					else
						$this->m_ums_usergroup->insert();
				}
			}

			// save log
			$text = $action == 'cancel' ? 'ยกเลิกสิทธิ์ ' : 'เพิ่มสิทธิ์ ';
			$text .= !empty($gp_name) ? $gp_name : "";
			$text .= " ให้กลุ่มผู้ใช้ ";
			for($i = 0; $i<count($bg_name_ths); $i++) {
				if($i <> (count($bg_name_ths)) && ($i <> 0))
					$text .= ", ";
				$text .= $bg_name_ths[$i];
			}
			$this->m_ums_logs->insert_log($text);

			$data['returnUrl'] = base_url().'index.php/ums/User_user_group_multi';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
