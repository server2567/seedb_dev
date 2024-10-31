<?php 
/*
* Icon
* Main controller of Icon
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 16/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class Icon extends UMS_Controller {
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of Icon
	* @input -
	* $output icon list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function index() {
		// get list
		$this->load->model('ums/m_ums_icon');
		$icons = $this->m_ums_icon->get_all()->result_array();

		// encrypt id
		$names = ['ic_id']; // object name need to encrypt 
		$data['icons'] = encrypt_arr_obj_id($icons, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/icon/v_icon_icon_show',$data);
	}

	/*
	* icon_edit
	* for show insert/edit screen and icon data
	* @input ic_id (icon id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and icon data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function icon_edit($ic_id=null) {
		if(!empty($ic_id)) {
			$data['ic_id'] = $ic_id;
			$ic_id = decrypt_id($ic_id);

			$this->load->model('ums/m_ums_icon');
			$this->m_ums_icon->ic_id = $ic_id;
			$result = $this->m_ums_icon->get_by_key()->result_array();
			if ($result) 
				$data['edit'] = $result[0];
			// else 
			// 	log error
			$data['image'] = $data['edit']['ic_name'];
			$ic_name = explode(".", $data['edit']['ic_name']);
			$data['edit']['ic_name'] = $ic_name[0];
		}

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/icon/v_icon_icon_form',$data);
	}

	/*
	* icon_insert
	* for insert icon data in db
	* @input data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function icon_insert() {
		$ic_name = $this->input->post("ic_name");
		$ic_type = $this->input->post("ic_type");

		// setting config to upload and check
		$pathuploads = $this->config->item('ums_uploads_dir');
		$path = $pathuploads . $ic_type;
		$config['file_name'] = $ic_name;
		$config['upload_path'] =  $path;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		$this->load->model('ums/m_ums_icon');
		$this->m_ums_icon->ic_id = null;
		$this->m_ums_icon->ic_type = $ic_type;
		$this->m_ums_icon->ic_name = $ic_name . $this->upload->get_extension($_FILES['ic_file_id']['name']);
		
		// case error by condition check duplication in db
		$is_duplicate = false;
		if($this->m_ums_icon->get_unique()->row_array() <> NULL) {
			$data['error_inputs'][] = (object) ['name' => 'ic_name', 'error' => "ชื่อไอคอนและประเภทไอคอนนี้มีอยู่แล้วในระบบ กรุณาระบุใหม่"];
			$data['error_inputs'][] = (object) ['name' => 'ic_type', 'error' => "ชื่อไอคอนและประเภทไอคอนนี้มีอยู่แล้วในระบบ กรุณาระบุใหม่"];
			$is_duplicate = true;
		}
		
		// condition check of upload file
		if (!$is_duplicate) {
			if (!$this->upload->do_upload('ic_file_id')) {
				$data['error_inputs'][] = (object) ['name' => 'ic_file_id', 'error' => "ไม่สามารถอัพโหลดไฟล์ดังกล่าวได้ เนื่องจากไฟล์อาจมีขนาดใหญ่เกินไปหรือเป็นชนิดของไฟล์ที่ไม่ถูกต้อง"];
			}
		}

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case not show error
			$upload_data = array('upload_data' => $this->upload->data());
			$this->m_ums_icon->ic_name = $upload_data['upload_data']['file_name'];
			$this->m_ums_icon->insert();

			// save log
			$this->m_ums_logs->insert_log("เพิ่มไอคอน ".$this->m_ums_icon->ic_name);

			$data['returnUrl'] = base_url().'index.php/ums/Icon';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* icon_update
	* for update icon data in db
	* @input ic_id (icon id) and data from form
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function icon_update($ic_id) {
		$ic_id = decrypt_id($ic_id);
		$ic_name = $this->input->post("ic_name");
		$ic_type = $this->input->post("ic_type");

		// setting config to upload and check
		$pathuploads = $this->config->item('ums_uploads_dir');
		$path = $pathuploads . $ic_type;
		$config['file_name'] = $ic_name;
		$config['upload_path'] =  $path;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		$this->load->model('ums/m_ums_icon');
		$this->m_ums_icon->ic_id = $ic_id;
		$this->m_ums_icon->ic_type = $ic_type;
		$this->m_ums_icon->ic_name = $ic_name . $this->upload->get_extension($_FILES['ic_file_id']['name']);
		
		// case error by condition check duplication in db
		$is_duplicate = false;
		if($this->m_ums_icon->get_unique_with_id()->row_array() <> NULL) {
			$data['error_inputs'][] = (object) ['name' => 'ic_name', 'error' => "ชื่อไอคอนและประเภทไอคอนนี้มีอยู่แล้วในระบบ กรุณาระบุใหม่"];
			$data['error_inputs'][] = (object) ['name' => 'ic_type', 'error' => "ชื่อไอคอนและประเภทไอคอนนี้มีอยู่แล้วในระบบ กรุณาระบุใหม่"];
			$is_duplicate = true;
		}
		
		// condition check of upload file
		if (!$is_duplicate) {
			// 1. get old file
			$icons = $this->m_ums_icon->get_by_key()->result_array();
			if ($icons) 
				$icon = $icons[0];
			$path = $pathuploads.$icon['ic_type']."/";
			$old_file = $path.$icon['ic_name'];

			// 2.1 if have old file
			if (file_exists($old_file)) {
				// 3. temp old file by rename old file
				$temp_old_file = $path."___".$icon['ic_name'];
				rename($old_file, $temp_old_file);

				// 4.1 if can upload new file from update >>> delete old file that temp
				if ($this->upload->do_upload('ic_file_id')) {
					$deletefile = unlink($temp_old_file);
				} else { // 4.1 else can't upload new file from update >>> rename temp old file to original name old file
					rename($temp_old_file, $old_file);
					$data['error_inputs'][] = (object) ['name' => 'ic_file_id', 'error' => "ไม่สามารถอัพโหลดไฟล์ดังกล่าวได้ เนื่องจากไฟล์อาจมีขนาดใหญ่เกินไปหรือเป็นชนิดของไฟล์ที่ไม่ถูกต้อง"];
				}
			} else { // 2.2 else no have old file >>> then check and upload
				if (!$this->upload->do_upload('ic_file_id')) {
					$data['error_inputs'][] = (object) ['name' => 'ic_file_id', 'error' => "ไม่สามารถอัพโหลดไฟล์ดังกล่าวได้ เนื่องจากไฟล์อาจมีขนาดใหญ่เกินไปหรือเป็นชนิดของไฟล์ที่ไม่ถูกต้อง"];
				}
			}
		}

		if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_invalid_inputs');
		} else { // case not show error
			$upload_data = array('upload_data' => $this->upload->data());
			$this->m_ums_icon->ic_name = $upload_data['upload_data']['file_name'];
			$this->m_ums_icon->update();

			// save log
			$this->m_ums_logs->insert_log("แก้ไขไอคอน ".$this->m_ums_icon->ic_name);

			$data['returnUrl'] = base_url().'index.php/ums/Icon';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}

	/*
	* base_group_delete
	* for delete icon data in db
	* @input ic_id (icon id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	public function icon_delete($ic_id) {
		$ic_id = decrypt_id($ic_id);

		$this->load->model('ums/m_ums_icon');
		$this->m_ums_icon->ic_id = $ic_id;
		$icons = $this->m_ums_icon->get_by_key()->result_array();
		if ($icons) 
			$icon = $icons[0];

		// check ic_id is currently being used.
		$this->load->model('ums/m_ums_system');
		$this->m_ums_system->st_icon = $icon['ic_name'];
		$count_system = $this->m_ums_system->get_count_by_icon()->result_array();
		if(!empty($count_system) && $count_system[0]['count_st_id'] > 0) {
			$data['status_response'] = $this->config->item('status_response_error');
			$data['message_dialog'] = $this->config->item('text_toast_delete_error_body');
		} else {
			$deletedb = $this->m_ums_icon->delete();
			if($deletedb = 1){
				$pathuploads = $this->config->item('ums_uploads_dir');
				$path = $pathuploads.$icon['ic_type']."/";
				$deletefile = unlink($path.$icon['ic_name']);
			}

			// save log
			$this->m_ums_logs->insert_log("ลบไอคอน ".$icons['ic_name']);
		
			$data['returnUrl'] = base_url().'index.php/ums/Icon';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
