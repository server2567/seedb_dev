<?php
/*
* Recover
* Main controller of Recover
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 12/06/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('DIM_Controller.php');

class Recover extends DIM_Controller{

	// Create __construct for load model use in this controller
	public function __construct(){
		parent::__construct();
	}

	/*
	* index
	* Index controller of Recover
	* @input -
	* $output examination result doc that delete list
	* @author Areerat Pongurai
	* @Create Date 12/06/2024
	*/
	public function index() {
		// get list
		$this->load->model('dim/m_dim_examination_result_doc_bin');
		$doc_bins = $this->m_dim_examination_result_doc_bin->get_all_with_detail($this->session->userdata('us_id'))->result_array(); // get only files that owner is session

		// encrypt id
		$names = ['exr_id', 'exrdb_exrd_id']; // object name need to encrypt
		$data['doc_bins'] = encrypt_arr_obj_id($doc_bins, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('dim/recover/v_recover_show',$data);
	}

	/*
	* Recover_update
	* recover file that status delete (exrd.status 0 -> 1)
	* @input exrd_id: examination result doc id
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 13/06/2024
	*/
	public function Recover_update($exrdb_status, $exrdb_exrd_id) {
		$exrdb_exrd_id = decrypt_id($exrdb_exrd_id);

		$this->load->model('dim/m_dim_examination_result_doc');
		$this->m_dim_examination_result_doc->exrd_id = $exrdb_exrd_id;
		$this->m_dim_examination_result_doc->exrd_status = $exrdb_status == 2 ? 1 : 0;
		$this->m_dim_examination_result_doc->update_status_files();

		$this->load->model('dim/m_dim_examination_result_doc_bin');
		$this->m_dim_examination_result_doc_bin->exrdb_exrd_id = $exrdb_exrd_id;
		$this->m_dim_examination_result_doc_bin->exrdb_status = $exrdb_status;
		$this->m_dim_examination_result_doc_bin->update_status_files();

		// // [AP] 20240628 Just update status file = delete, not really unlink file
		// // from client, user need to delete file now dont wait for exrdb_expiration_date => delete file on server
		// if ($exrdb_status == 1) {
		// 	$result = $this->m_dim_examination_result_doc->get_path_files()->result_array();
		// 	if ($result) {
		// 		$path_file = $result[0]['path_file'];
		// 		if (!empty($path_file)) {
		// 			$path = $this->config->item('dim_nas_path') . $path_file;
		// 			if (file_exists($path)) {
		// 				// Attempt to delete the file
		// 				if (!unlink($path)) {
		// 					// echo "The file could not be deleted.";
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		$data['returnUrl'] = base_url().'index.php/dim/Recover';
		$data['status_response'] = $this->config->item('status_response_success');

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
