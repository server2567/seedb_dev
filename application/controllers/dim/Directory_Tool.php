<?php
/*
* Directory_Tool
* Main controller of Directory_Tool
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 14/08/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('DIM_Controller.php');

class Directory_Tool extends DIM_Controller{

	// Create __construct for load model use in this controller
	public function __construct(){
		parent::__construct();
	}

	/*
	* index
	* Index controller of Directory_Tool
	* @input -
	* $output screen of room list
	* @author Areerat Pongurai
	* @Create Date 12/06/2024
	*/
	public function index() {
		// get ddl
		$this->load->model('eqs/m_eqs_room');
		$order = array('rm.rm_name' => 'ASC');
		$rooms = $this->m_eqs_room->get_rooms_tools($order)->result_array();
	
		// encrypt id ddl
		$names = ['rm_id']; // object name need to encrypt
		$data['rooms'] = encrypt_arr_obj_id($rooms, $names);
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('dim/directory_tool/v_directory_room_show',$data);
	}

	/*
	* Directory_Tool_get_tools_of_room
	* get_tools_of_room
	* @input $rm_id(eqs_room id): ไอดีห้อง
	* $output screen of tool map with diractory
	* @author Areerat Pongurai
	* @Create Date 12/06/2024
	*/
	public function Directory_Tool_get_tools_of_room($rm_id) {
		$rm_id = decrypt_id($rm_id);

		// get list
		$this->load->model('eqs/m_eqs_equipments');
		$order = array('eqs_name' => 'ASC');
		$this->m_eqs_equipments->eqs_rm_id = $rm_id;
		$equipments = $this->m_eqs_equipments->get_tools_by_room_id($order)->result_array();

		// encrypt id
		$names = ['eqs_id']; // object name need to encrypt
		$data['equipments'] = encrypt_arr_obj_id($equipments, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('dim/directory_tool/v_directory_room_tool_show',$data);
	}

	/*
	* Directory_Tool_update
	* recover file that status delete (exrd.status 0 -> 1)
	* @input exrd_id: examination result doc id
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 13/06/2024
	*/
	// public function Directory_Tool_update($exrdb_status, $exrdb_exrd_id) {
	// 	$exrdb_exrd_id = decrypt_id($exrdb_exrd_id);

	// 	$this->load->model('dim/m_dim_examination_result_doc');
	// 	$this->m_dim_examination_result_doc->exrd_id = $exrdb_exrd_id;
	// 	$this->m_dim_examination_result_doc->exrd_status = $exrdb_status == 2 ? 1 : 0;
	// 	$this->m_dim_examination_result_doc->update_status_files();

	// 	$this->load->model('dim/m_dim_examination_result_doc_bin');
	// 	$this->m_dim_examination_result_doc_bin->exrdb_exrd_id = $exrdb_exrd_id;
	// 	$this->m_dim_examination_result_doc_bin->exrdb_status = $exrdb_status;
	// 	$this->m_dim_examination_result_doc_bin->update_status_files();

	// 	// // [AP] 20240628 Just update status file = delete, not really unlink file
	// 	// // from client, user need to delete file now dont wait for exrdb_expiration_date => delete file on server
	// 	// if ($exrdb_status == 1) {
	// 	// 	$result = $this->m_dim_examination_result_doc->get_path_files()->result_array();
	// 	// 	if ($result) {
	// 	// 		$path_file = $result[0]['path_file'];
	// 	// 		if (!empty($path_file)) {
	// 	// 			$path = $this->config->item('dim_nas_path') . $path_file;
	// 	// 			if (file_exists($path)) {
	// 	// 				// Attempt to delete the file
	// 	// 				if (!unlink($path)) {
	// 	// 					// echo "The file could not be deleted.";
	// 	// 				}
	// 	// 			}
	// 	// 		}
	// 	// 	}
	// 	// }

	// 	$data['returnUrl'] = base_url().'index.php/dim/Directory_Tool';
	// 	$data['status_response'] = $this->config->item('status_response_success');

	// 	$result = array('data' => $data);
	// 	echo json_encode($result);
	// }
}
?>
