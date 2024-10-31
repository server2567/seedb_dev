<?php 
/*
* System
* Main controller of System
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 16/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class System extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of System
	* @input -
	* $output system list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function index() {
		// get list
		$this->load->model('ums/m_ums_system');
		$order = array('st_name_th'=>'ASC');
		$systems = $this->m_ums_system->get_all($order)->result_array();

		// get base group count
		$i = 0;
		foreach($systems as $st) {
			$amount = $this->m_ums_system->get_amount_bg_by_st($st['st_id'])->row();
			if (!empty($amount)) 
				$systems[$i]['bg_count'] = $amount->bg_count;
			else 
				$systems[$i]['bg_count'] = 0; // Or set to a default value if no amount found
			$i++;
		}

		// encrypt id
		$names = ['st_id']; // object name need to encrypt 
		$data['systems'] = encrypt_arr_obj_id($systems, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_system_show',$data);
	}

	/*
	* system_get_bg
	* get list of base group by system
	* @input -
	* $output modal screen of base group list
	* @author Areerat Pongurai
	* @Create Date 08/08/2024
	*/
	public function system_get_bg() {
		// decrypt
		$st_id = $this->input->post("st_id");
		$data['st_id'] = $st_id;
		$st_id = decrypt_id($st_id);

		// get system data
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_id = $st_id;
		$data['system'] = $this->m_ums_system->get_by_key_sys()->row();

		// get list
		$this->load->model('ums/m_ums_system');
		$order = array('bg.bg_name_th'=>'ASC');
		$base_groups = $this->m_ums_system->get_bg_by_st($st_id, $order)->result_array();
		
		// encrypt id
		$names = ['bg_id']; // object name need to encrypt 
		$data['base_groups'] = encrypt_arr_obj_id($base_groups, $names);

        $this->load->view('ums/system/v_system_system_base_group_modal_show', $data);
	}

	/*
	* system_edit
	* for show insert/edit screen and system data
	* @input st_id (system id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and system data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_edit($st_id=null) {
		if(!empty($st_id)) {
			$data['st_id'] = $st_id;
			$st_id = decrypt_id($st_id);

			$this->load->model('ums/m_ums_system');
			$this->m_ums_system->st_id = $st_id;
			$result = $this->m_ums_system->get_by_key_sys()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error
		}

		// get select list
		$this->load->model('ums/m_ums_icon');
		$this->m_ums_icon->ic_type = "system";
		$icons = $this->m_ums_icon->get_by_type()->result_array();
		// encrypt id
		$names = ['ic_id']; // object name need to encrypt 
		$data['icons'] = encrypt_arr_obj_id($icons, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_system_form',$data);
	}

	/*
	* system_insert
	* for insert system data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_insert() {
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_name_th = $this->input->post("st_name_th");
		$this->m_ums_system->st_name_en = $this->input->post("st_name_en");
		$this->m_ums_system->st_name_abbr_th = $this->input->post("st_name_abbr_th");
		$this->m_ums_system->st_name_abbr_en = $this->input->post("st_name_abbr_en");
		$this->m_ums_system->st_detail = $this->input->post("st_detail");
		$this->m_ums_system->st_url = $this->input->post("st_url");
		$this->m_ums_system->st_icon = $this->input->post("st_icon");
		$this->m_ums_system->st_seq = $this->input->post("st_seq");
		$this->m_ums_system->st_active = $this->input->post("st_active") == 'on' ? 1 : 0;

		// case error by condition check duplication in db
		if(!empty($this->input->post("st_name_th")) && $this->m_ums_system->get_unique_th()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'st_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("st_name_en")) && $this->m_ums_system->get_unique_en()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'st_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			// insert
			$this->m_ums_system->insert();

			// save log
			$this->m_ums_logs->insert_log("เพิ่มระบบ ".$this->m_ums_system->st_name_th);

			$data['returnUrl'] = base_url().'index.php/ums/System';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_update
	* for update system data in db
	* @input st_id (system id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_update($st_id) {
		$st_id = decrypt_id($st_id);
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_id = $st_id;
		$this->m_ums_system->st_name_th = $this->input->post("st_name_th");
		$this->m_ums_system->st_name_en = $this->input->post("st_name_en");
		$this->m_ums_system->st_name_abbr_th = $this->input->post("st_name_abbr_th");
		$this->m_ums_system->st_name_abbr_en = $this->input->post("st_name_abbr_en");
		$this->m_ums_system->st_detail = $this->input->post("st_detail");
		$this->m_ums_system->st_url = $this->input->post("st_url");
		$this->m_ums_system->st_icon = $this->input->post("st_icon");
		$this->m_ums_system->st_seq = $this->input->post("st_seq");
		$this->m_ums_system->st_active = $this->input->post("st_active") == 'on' ? 1 : 0;

		// case error by condition check duplication in db
		if(!empty($this->input->post("st_name_th")) && $this->m_ums_system->get_unique_th_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'st_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("st_name_en")) && $this->m_ums_system->get_unique_en_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'st_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			// update
			$this->m_ums_system->update();
			
			// save log
			$this->m_ums_logs->insert_log("แก้ไขระบบ ".$this->m_ums_system->st_name_th);
			
			$data['returnUrl'] = base_url().'index.php/ums/System';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_delete
	* for update active = 2 to system data in db
	* @input st_id (system id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_delete($st_id) {
		$st_id = decrypt_id($st_id);

		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_id = $st_id;
		$result = $this->m_ums_system->get_by_key()->row_array(); // get data for save log

		// update delete
		$this->m_ums_system->update_delete();

		// save log
		$this->m_ums_logs->insert_log("ลบระบบ ".$result['st_name_th']);

		$data['returnUrl'] = base_url().'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}
	
	/*
	* system_menu
	* Screen for show menu list of system
	* @input st_id (system id)
	* $output menu list of system
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu($st_id) {
		$data['st_id'] = $st_id;
		$st_id = decrypt_id($st_id);

		// get list
		$this->load->model('ums/m_ums_menu');
		$this->m_ums_menu->mn_st_id = $st_id;
		$data['menus'] = $this->m_ums_menu->get_menus_by_sys()->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_system_manage_menu_form',$data);
	}

	/*
	* system_menu_edit
	* for show insert/edit screen and menu data
	* @input 
			mn_st_id (system id) :: system of menu
			mn_parent_mn_id (menu id) :: ==null >>> level=0 || <>null >>> level>0 and have menu parent id
			mn_id (menu id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and menu data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu_edit($mn_st_id, $mn_parent_mn_id=null, $mn_id=null) {
		$data['mn_st_id'] = $mn_st_id;
		$mn_st_id = decrypt_id($mn_st_id);
		
		if(empty($mn_parent_mn_id) || $mn_parent_mn_id == 0) 
			$mn_parent_mn_id = null;
		$data['mn_parent_mn_id'] = $mn_parent_mn_id;
		$mn_parent_mn_id = decrypt_id($mn_parent_mn_id);
		// $this->m_ums_menu->mn_st_id = $mn_st_id;

		if(!empty($mn_id)) {
			$data['mn_id'] = $mn_id;
			$mn_id = decrypt_id($mn_id);

			// Update into umgroup
			// $this->m_umicon->IcType= 'menu';
			// $data['showicon']=$this->m_umicon->get_by_type();

			// Update into umgroup
			$this->load->model('ums/m_ums_menu');
			$this->m_ums_menu->mn_id = $mn_id;
			$result = $this->m_ums_menu->get_by_key()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error
		}

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/system/v_system_system_manage_menu_menu_form',$data);
	}

	/*
	* system_menu_insert
	* for insert menu data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu_insert() {
		$this->load->model('ums/m_ums_menu');

		$mn_st_id = $this->input->post("mn_st_id");
		$mn_st_id = decrypt_id($mn_st_id);
		$mn_parent_mn_id = $this->input->post("mn_parent_mn_id");
		$mn_parent_mn_id = decrypt_id($mn_parent_mn_id);
		
		// set mn_level
		$mn_level = $this->input->post("mn_level");
		if (empty($mn_level)) {
			if (!empty($mn_parent_mn_id)) {
				$this->m_ums_menu->mn_id = $mn_parent_mn_id;
				$result = $this->m_ums_menu->get_by_key()->result_array();
				if ($result) 
				{
					$result = $result[0];
					$mn_level = $result['mn_level'] + 1;
				}
			} else {
				$mn_level = 0;
			}
		}

		$this->m_ums_menu->mn_id = null;
		$this->m_ums_menu->mn_st_id = $mn_st_id;
		$this->m_ums_menu->mn_parent_mn_id = $mn_parent_mn_id;
		$this->m_ums_menu->mn_level = $mn_level;
		$this->m_ums_menu->mn_name_th = $this->input->post("mn_name_th");
		$this->m_ums_menu->mn_name_en = $this->input->post("mn_name_en");
		$this->m_ums_menu->mn_detail = $this->input->post("mn_detail");
		$this->m_ums_menu->mn_url = $this->input->post("mn_url");
		$this->m_ums_menu->mn_icon = $this->input->post("mn_icon");
		$max_mn_seq = $this->m_ums_menu->get_max_menu_seq_by_sys()->result_array();
		$this->m_ums_menu->mn_seq = !empty($max_mn_seq) && isset($max_mn_seq[0]['max_mn_seq']) ? $max_mn_seq[0]['max_mn_seq'] + 1 : 0 ;
		$this->m_ums_menu->mn_active = $this->input->post("mn_active") == 'on' ? 1 : 0;
		$this->m_ums_menu->mn_create_user = $this->session->userdata('us_id');
		$this->m_ums_menu->mn_update_user = $this->session->userdata('us_id');

		// case error by condition check duplication in db
		if(!empty($this->input->post("mn_name_th")) && $this->m_ums_menu->get_unique_th()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'mn_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("mn_name_en")) && $this->m_ums_menu->get_unique_en()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'mn_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			// insert
			$this->m_ums_menu->insert();

			// save log
			$this->m_ums_logs->insert_log("เพิ่มเมนู ".$this->m_ums_menu->mn_name_th);

			$data['status_response'] = $this->config->item('status_response_success');
			$data['returnUrl'] = base_url().'index.php/ums/System/system_menu/'.encrypt_id($mn_st_id);
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_menu_update
	* for update menu data in db
	* @input mn_id (menu id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu_update($mn_id) {
		$this->load->model('ums/m_ums_menu');

		$mn_id = decrypt_id($mn_id);
		$mn_st_id = $this->input->post("mn_st_id");
		$mn_st_id = decrypt_id($mn_st_id);
		$mn_parent_mn_id = $this->input->post("mn_parent_mn_id");
		$mn_parent_mn_id = decrypt_id($mn_parent_mn_id);

		// set mn_level
		$mn_level = $this->input->post("mn_level");
		if (empty($mn_level)) {
			if (!empty($mn_parent_mn_id)) {
				$this->m_ums_menu->mn_id = $mn_parent_mn_id;
				$result = $this->m_ums_menu->get_by_key()->result_array();
				if ($result) 
				{
					$result = $result[0];
					$mn_level = $result['mn_level'] + 1;
				}
			} else {
				$mn_level = 0;
			}
		}

		$this->m_ums_menu->mn_st_id = $mn_st_id;
		$this->m_ums_menu->mn_parent_mn_id = $mn_parent_mn_id;
		$this->m_ums_menu->mn_level = $mn_level;
		$this->m_ums_menu->mn_id = $mn_id;
		$this->m_ums_menu->mn_name_th = $this->input->post("mn_name_th");
		$this->m_ums_menu->mn_name_en = $this->input->post("mn_name_en");
		$this->m_ums_menu->mn_detail = $this->input->post("mn_detail");
		$this->m_ums_menu->mn_url = $this->input->post("mn_url");
		$this->m_ums_menu->mn_icon = $this->input->post("mn_icon");
		$this->m_ums_menu->mn_seq = $this->input->post("mn_seq");
		$this->m_ums_menu->mn_active = $this->input->post("mn_active") == 'on' ? 1 : 0;
		$this->m_ums_menu->mn_update_user = $this->session->userdata('us_id');

		// case error by condition check duplication in db
		if(!empty($this->input->post("mn_name_th")) && $this->m_ums_menu->get_unique_th_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'mn_name_th', 'error' => $this->config->item('text_invalid_duplicate')];
		if(!empty($this->input->post("mn_name_en")) && $this->m_ums_menu->get_unique_en_with_id()->row_array() <> NULL)
			$data['error_inputs'][] = (object) ['name' => 'mn_name_en', 'error' => $this->config->item('text_invalid_duplicate')];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) {// case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			// update
			$this->m_ums_menu->update();

			// save log
			$this->m_ums_logs->insert_log("แก้ไขเมนู ".$this->m_ums_menu->mn_name_th);

			$data['status_response'] = $this->config->item('status_response_success');
			$data['returnUrl'] = base_url().'index.php/ums/System/system_menu/'.encrypt_id($mn_st_id);
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_menu_check_delete
	* check this menu need to delete(update active = 2 to menu data in db) is using by user or group
	* @input st_id (system id), mn_id (menu id)
	* $output 
	* @author Areerat Pongurai
	* @Create Date 15/08/2024
	*/
	public function system_menu_check_delete($mn_id) {
		$mn_id = decrypt_id($mn_id);

		$is_have = false;

		$this->load->model('ums/m_ums_group_permission');
		$this->m_ums_group_permission->gpn_mn_id = $mn_id;
		$groups = $this->m_ums_group_permission->get_group_by_menu_id()->result_array();
		if(empty($groups)) {
			$this->load->model('ums/m_ums_permission');
			$this->m_ums_permission->pm_mn_id = $mn_id;
			$permisssions = $this->m_ums_permission->get_user_by_menu_id()->result_array();
			if(!empty($permisssions)) $is_have = true;
		} else $is_have = true;
		
		$data['is_have'] = $is_have;
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_menu_delete
	* for update active = 2 to menu data in db
	* @input st_id (system id), mn_id (menu id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu_delete($st_id, $mn_id) {
		$mn_id = decrypt_id($mn_id);
		$st_id = decrypt_id($st_id);

		$this->load->model('ums/m_ums_menu');
		$this->m_ums_menu->mn_id = $mn_id;
		$this->m_ums_menu->mn_update_user = $this->session->userdata('us_id');
		$result = $this->m_ums_menu->get_by_key()->row_array(); // get data for save log
		
		// update delete
		$this->m_ums_menu->update_delete();

		// save log
		$this->m_ums_logs->insert_log("ลบเมนู ".$result['mn_name_th']);
		
		$data['returnUrl'] = base_url().'index.php/ums/System';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* system_menu_update_seq
	* for update all menu sequence data of system in db
	* @input st_id (system id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function system_menu_update_seq($st_id) {
		$this->load->model('ums/m_ums_menu');
		$mn_seqs = $this->input->post("mn_seq");
		$i=1;
		foreach( $mn_seqs as $id ) {
			$this->m_ums_menu->mn_id = decrypt_id($id);
			$this->m_ums_menu->mn_seq = $i;
			$this->m_ums_menu->update_mn_seq();
			$i++;
		}

		// save log
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_id = decrypt_id($st_id);
		$result = $this->m_ums_system->get_by_key()->row_array(); // get data for save log
		$this->m_ums_logs->insert_log("แก้ไขลำดับเมนูของระบบ ".$result['st_name_th']);
		
		$data['returnUrl'] = base_url().'index.php/ums/System/system_menu/'.$st_id;
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}


//   public $ums;
//   public $ums_db;
//   public function update_passwords() {
//     $this->ums = $this->load->database('ums', TRUE);
//     $this->ums_db = $this->ums->database;
//     // ดึงข้อมูลผู้ใช้ที่ us_password_confirm ไม่เป็น NULL
//     $query = $this->ums->query("SELECT us_id,us_username, us_password_confirm FROM ums_user WHERE us_password_confirm IS NOT NULL");
//     $users = $query->result();

//     // วนลูปผู้ใช้แต่ละคนแล้วทำการอัปเดตรหัสผ่าน
//     foreach ($users as $user) {
//         // $password_confirm = str_replace(' ', '', $user->us_password_confirm);
//         $password_confirm = str_replace(array(" ", "\n", "\r"), '', $user->us_password_confirm);
//         // เข้ารหัสรหัสผ่านใหม่ด้วย md5 และ salt
//         $new_password = md5("O]O".$password_confirm."O[O");

//         // อัปเดตรหัสผ่านใหม่ในฐานข้อมูล
//         $this->ums->set('us_password', $new_password);
//         $this->ums->where('us_id', $user->us_id);
//         $this->ums->update('ums_user');
//     }

//     echo "Password updated successfully for users with non-null us_password_confirm!";
// }

}
?>