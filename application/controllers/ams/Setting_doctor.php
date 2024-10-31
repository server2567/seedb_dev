<?php 
/*
* Setting_doctor
* Controller หลักของการตั้งค่าของแพทย์
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 13/09/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');

class Setting_doctor extends AMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	* index
	* Index controller of Setting_doctor
	* @input -
	* $output screen of setting each doctor
	* @author Areerat Pongurai
	* @Create Date 13/09/2024
	*/
	function index(){
		$this->load->model('ums/m_ums_user_config');
		$order = array('ps_fname'=>'ASC');
		$data['doctors'] = $this->m_ums_user_config->get_all_ref_ps($order)->result_array();
		// die(pre($data['doctors']));

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ams/base/v_base_setting_doctor_show', $data);   
  	}

	/*
	* Setting_doctor_new
	* Screen of insert config page
	* @input us_id(ums_user id)
	* $output screen of insert config page
	* @author Areerat Pongurai
	* @Create Date 13/09/2024
	*/
	function Setting_doctor_new($ps_id){
		$data['usc_ps_id'] = $ps_id;

		$ps_id = decrypt_id($ps_id);

		$this->load->model('ums/m_ums_user_config');
		$this->m_ums_user_config->usc_ps_id = $ps_id;
		$data['person_data'] = $this->m_ums_user_config->get_person_data_by_ps_id()->row();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ams/base/v_base_setting_doctor_form', $data);   
	}

	/*
	* Setting_doctor_edit
	* Screen of edit config page
	* @input usc_id(ums_user_config id)
	* $output screen of edit config page
	* @author Areerat Pongurai
	* @Create Date 13/09/2024
	*/
	function Setting_doctor_edit($usc_id = null){
		$data['usc_id'] = $usc_id;

		$usc_id = decrypt_id($usc_id);

		$this->load->model('ums/m_ums_user_config');
		$this->m_ums_user_config->usc_id = $usc_id;
		$result = $this->m_ums_user_config->get_by_key()->result_array();
		if(!empty($result))
			$data['edit'] = $result[0];

		$data['usc_ps_id'] = encrypt_id($data['edit']['usc_ps_id']);

		$this->m_ums_user_config->usc_ps_id = $data['edit']['usc_ps_id'];
		$data['person_data'] = $this->m_ums_user_config->get_person_data_by_ps_id()->row();
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ams/base/v_base_setting_doctor_form', $data);   
	}

	/*
	* Setting_doctor_update
	* Save data
	* @input usc_id(ums_user_config id) and form data
	* $output response
	* @author Areerat Pongurai
	* @Create Date 13/09/2024
	*/
	function Setting_doctor_update($usc_id = null){
		$usc_id = decrypt_id($usc_id);

		$this->load->model('ums/m_ums_user_config');
		$this->m_ums_user_config->usc_ps_id = decrypt_id($this->input->post("usc_ps_id"));
		// for use at controller/ams/Manage_queue/assign_status -> wts_notifications_department->ntdp_date_end/ntdp_time_end
		// สำหรับกำหนด deadline เวลาในการพบผู้ป่วยของแพทย์
		$this->m_ums_user_config->usc_ams_minute = $this->input->post("usc_ams_minute");
		// for use at view/template/header && controller/ums/UMS_controller
		// สำหรับกำหนดว่าต้องการแจ้งเตือนแพทย์หรือไม่
		$this->m_ums_user_config->usc_wts_is_noti = $this->input->post("usc_wts_is_noti") == 'on' ? 1 : 0;
		// for use at view/template/header
		// สำหรับกำหนดว่าต้องการแจ้งเตือนแพทย์ด้วยเสียงหรือไม่
		$this->m_ums_user_config->usc_wts_is_noti_sound = $this->input->post("usc_wts_is_noti_sound") == 'on' ? 1 : 0;

		// // case error by condition
		// if()
		// 	$data['error_inputs'][] = (object) ['name' => '[input name]', 'error' => '[text show error]'];

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case success
			if(!empty($usc_id)) { // update
				$this->m_ums_user_config->usc_id = $usc_id;
				$this->m_ums_user_config->usc_update_user = $this->session->userdata('us_id');
				$this->m_ums_user_config->update();
			} else { // insert
				$this->m_ums_user_config->usc_create_user = $this->session->userdata('us_id');
				$this->m_ums_user_config->insert();
			}

			// // save log
			// $this->m_ums_logs->insert_log("เพิ่มระบบ ".$this->m_ums_user_config->st_name_th);

			$data['returnUrl'] = base_url().'index.php/ams/Setting_doctor';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>