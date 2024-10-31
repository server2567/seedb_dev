<?php
/*
* Examination_result
* Main controller of Examination_result
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 12/06/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('DIM_Controller.php');

class Examination_result extends DIM_Controller{

	// Create __construct for load model use in this controller
	public function __construct(){
		parent::__construct();
	}
	
	/*
	* index
	* Index controller of Examination_result
	* @input -
	* $output examination result list
	* @author Areerat Pongurai
	* @Create Date 12/06/2024
	* @Update Date 15/07/2024 Areerat Pongurai - Not use, will delete
	*/
	public function index()
	{
		// get filter from form client
		$end_date = $this->input->post("end_date");
		$end_time = $this->input->post("end_time");
		$eqs_id = $this->input->post("eqs_id");
		$pt_id = $this->input->post("pt_id");
		$pt_name = $this->input->post("pt_name");
		$start_date = $this->input->post("start_date");
		$start_time = $this->input->post("start_time");
		$stde_id = $this->input->post("stde_id");
		
		$eqs_id = decrypt_id($eqs_id);
		$stde_id = decrypt_id($stde_id);

		// get list
		$this->load->model('dim/m_dim_examination_result');
		$this->m_dim_examination_result->exr_ps_id = $this->session->userdata('us_ps_id'); // get only examination result that owner is session
		
		// set filter
		$filter = [];
		if (!empty($eqs_id)) {
			$filter['eqs_id'] = $eqs_id;
			$data['search']['eqs_id'] = $eqs_id;
		}
		if (!empty($pt_id)) {
			$filter['pt_id'] = $pt_id;
			$data['search']['pt_id'] = $pt_id;
		}
		if (!empty($pt_name)) {
			$filter['pt_name'] = $pt_name;
			$data['search']['pt_name'] = $pt_name;
		}
		if (!empty($stde_id))  {
			$filter['stde_id'] = $stde_id;
			$data['search']['stde_id'] = $stde_id;
		}
		
		if (empty($start_date)) {
			$start_date = (new DateTime())->format('Y-m-d 00:00:00');
			$start_time = '00:00:00';
		} else {
			if(empty($start_time))
				$start_time = '00:00:00';
			$start_date = explode("/",$start_date);
			$year = $start_date[count($start_date) - 1] - 543;
			$start_string = $start_date[0] . '-' . $start_date[1] . '-' . $year . ' ' . $start_time;
			$start_date = (new DateTime($start_string))->format('Y-m-d H:i:s');
		} 
		$filter['start_date'] = $start_date;
		$data['search']['start_date'] = $start_date;
		$data['search']['start_time'] = $start_time;
		
		if (empty($end_date)) {
			$end_date = (new DateTime())->format('Y-m-d 23:59:59');
			$end_time = '23:59:59';
		} else {
			if(empty($end_time))
				$end_time = '23:59:59';
			$end_date = explode("/",$end_date);
			$year = $end_date[count($end_date) - 1] - 543;
			$end_string = $end_date[0] . '-' . $end_date[1] . '-' . $year . ' ' . $end_time;
			$end_date = (new DateTime($end_string))->format('Y-m-d H:i:s');
		} 
		$filter['end_date'] = $end_date;
		$data['search']['end_date'] = $end_date;
		$data['search']['end_time'] = $end_time;

		$examination_results = $this->m_dim_examination_result->get_all_with_detail_by_filter('Y', $filter)->result_array();

		// encrypt id
		$names = ['exr_id']; // object name need to encrypt
		$data['examination_results'] = encrypt_arr_obj_id($examination_results, $names);

		// get ddl
		$this->load->model('ums/m_ums_department');
		$order = array('dp_name_th'=>'ASC');
		$data['departments'] = $this->m_ums_department->get_all($order)->result_array();

		$structure_details = [];
		if(!empty($data['departments'])) {
			$this->load->model('hr/structure/m_hr_structure_detail');
			// $order = array('stde_name_th'=>'ASC');
			foreach($data['departments'] as $key1 => $row) {
				$result = $this->m_hr_structure_detail->get_all_by_level_from_dp_stuc($row['dp_id'])->result_array();
				if($result) {
					foreach($result as $key2 => $res) {
						$structure_details[] = $res;
					}
				}
			}
		}

		$this->load->model('eqs/m_eqs_room');
		$order = array('rm_name'=>'ASC');
		$data['rooms'] = $this->m_eqs_room->get_all($order)->result_array();

		$equipments = [];
		if(!empty($data['rooms'])) {
			$this->load->model('eqs/m_eqs_equipments');
			$order = array('eqs_name'=>'ASC');
			foreach($data['rooms'] as $key1 => $row) {
				$this->m_eqs_equipments->eqs_rm_id = $row['rm_id'];
				$result = $this->m_eqs_equipments->get_tools_by_room_id($order)->result_array();
				if($result) {
					foreach($result as $key2 => $res) {
						$equipments[] = $res;
					}
				}
			}
		}

		// encrypt id ddl
		$names = ['stde_id']; // object name need to encrypt
		$data['structure_details'] = encrypt_arr_obj_id($structure_details, $names);
		$names = ['eqs_id']; // object name need to encrypt
		$data['equipments'] = encrypt_arr_obj_id($equipments, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('dim/examination_result/v_examination_result_show',$data);
	}

	/*
	* Examination_result_detail
	* view examination result data
	* @input exr_id(examination result id): ไอดีของผลตรวจ
	* $output examination result data
	* @author Areerat Pongurai
	* @Create Date 14/06/2024
	*/
	public function Examination_result_detail($exr_id) {
		$data['actor'] = 'doctor'; // fix actor for reuse view
		
		$data['is_detail'] = 1; // fix is view
		$data['exr_id'] = $exr_id;
		$exr_id = decrypt_id($exr_id);

		$this->load->model('dim/m_dim_examination_result');
		$this->m_dim_examination_result->exr_id = $exr_id;
		$result = $this->m_dim_examination_result->get_detail_by_id()->result_array();
		if ($result)
			$data['edit'] = $result[0];
		// else
		// 	log error

		// check if examination result doctor owner != session
		if($data['edit']['exr_ps_id'] != $this->session->userdata('us_ps_id'))
			redirect('dim/Examination_result', 'refresh');

		// check if exr_status = C (Cancel) then cant edit, only view
		if($data['edit']['exr_status'] == 'C')
			$data['is_detail'] = 1;

		// get id files from dim_examination_result_doc
		$this->load->model('dim/m_dim_examination_result_doc');
		$this->m_dim_examination_result_doc->exrd_exr_id = $exr_id;
		$examination_result_docs = $this->m_dim_examination_result_doc->get_by_examination_result_id()->result_array();
		$names = ['exrd_id']; // object name need to encrypt
		$examination_result_docs = encrypt_arr_obj_id($examination_result_docs, $names);

		// Connect with NAS for get file data
		// 0. Define variables
		$nas_server_ip = $this->config->item('dim_nas_ip');
		$nas_port = $this->config->item('dim_nas_port');
		$nas_target_folder = $this->config->item('dim_nas_share_path') . $data['edit']['exr_directory'];

		// 1. Check if the NAS server is reachable
		$ping_command = "ping -c 1 $nas_server_ip";
		exec($ping_command, $output, $return_var);
		if ($return_var !== 0) {
			die("Failed to reach NAS server, code: $return_var, output: " . implode("\n", $output));
		}

		// 2. Check if nas target directory exists
		$files = array();
		if (is_dir($nas_target_folder)) {
			if ($handle = opendir($nas_target_folder)) {
				$nas_files = scandir($nas_target_folder);
				$nas_files = array_diff($nas_files, array('.', '..'));

				foreach ($nas_files as $file) {
					$path = $nas_target_folder . '/' . $file;
					if (file_exists($path)) {
                        $pathdownload = base_url()."index.php/dim/Getpreview?path=".bin2hex($path);;
						$fileDetails = $this->Examination_result_get_file_details($path);

						$exrdId = null;
						if(!empty($examination_result_docs)) {
							$found = array_filter($examination_result_docs, function($obj) use ($file) {
								return $obj['exrd_file_name'] === $file;
							});
							
							if (!empty($found)) 
								$exrdId = $found;
						}

						$files[] = array(
							'file' => $fileDetails,
							'name' => $file,
							'url' => $pathdownload,
							'exrdId' => $exrdId,
						);
					}
				}
			} else {
				die("Could not open directory.");
			}
		} else {
			die("Nas target directory does not exist: $nas_target_folder");
		}
		
		if(!empty($files))
			$data['files'] = $files;

		$data['exr_inspection_time'] = !empty($data['edit']['exr_inspection_time']) ? $data['edit']['exr_inspection_time'] : null;

		// person data
		$this->load->model('hr/m_hr_person');
		$this->m_hr_person->ps_id = $data['edit']['update_us_ps_id'];
		$data['person'] = $this->m_hr_person->get_personal_dashboard_profile_detail_data_by_id()->row();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('dim/import_examination_result/v_import_examination_result_form',$data);
	}
	
	/*
	* Examination_result_get_file
	* for get file
	* @input exrd_id (dim_examination_result_doc id): ไอดีไฟล์ผลตรวจ
	* $output redirect to show file
	* @author Areerat Pongurai
	* @Create Date 13/06/2024
	* @Update Date 15/07/2024 Areerat Pongurai - Not use, will delete
	*/
	public function Examination_result_get_file($exrd_id) {
		if (!empty($exrd_id)) {
			$exrd_id = decrypt_id($exrd_id);
			
			$this->load->model('dim/m_dim_examination_result_doc');
			$this->m_dim_examination_result_doc->exrd_id = $exrd_id;
			$result = $this->m_dim_examination_result_doc->get_path_files()->result_array();

			if ($result) {
				$path_file = $result[0]['path_file'];

				if (!empty($path_file)) {
				$path = $this->config->item('dim_nas_share_path') . $path_file;

					if (is_readable($path)) {
						redirect('dim/Getpreview?path='.bin2hex($path));
					}
				} else {
					// Handle file not found
					http_response_code(404);
					// echo "File not found.";
				}
			}
		}
	}

	// ------------------ For File in Server ------------------

	/*
	* Examination_result_get_file_details
	* get file details
	* @input file path
	* $output details of file
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
	private function Examination_result_get_file_details($filePath) {
		$fileInfo = array();

		if (file_exists($filePath)) {
			$fileInfo['lastModified'] = filemtime($filePath) * 1000; // Get the last modified timestamp in milliseconds
			$fileInfo['lastModifiedDate'] = date('D M d Y H:i:s O', filemtime($filePath)); // Get the formatted last modified date
			$fileInfo['name'] = basename($filePath); // Get the file name
			$fileInfo['size'] = filesize($filePath); // Get the file size in bytes
			$fileInfo['type'] = mime_content_type($filePath); // Get the MIME type of the file
			$fileInfo['webkitRelativePath'] = ""; // Empty because this is typically used in the browser
		}

		return $fileInfo;
	}
}
?>
