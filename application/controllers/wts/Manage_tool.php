<?php 
/*
* Manage_tool
* Controller หลักของจัดการประเภทโรค
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 05/08/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Manage_tool extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	* index
	* Index controller of Manage_tool
	* @input -
	* $output screen of structure detail group in disease list
	* @author Areerat Pongurai
	* @Create Date 05/08/2024
	*/
	public function index() {
		// get list
		$this->load->model('wts/m_wts_department_disease_tool');
		$stdes = $this->m_wts_department_disease_tool->get_all_group_stde_disease()->result_array();

		// encrypt id
		$names = ['ds_stde_id']; // object name need to encrypt 
		$data['stdes'] = encrypt_arr_obj_id($stdes, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/manage/v_manage_tools_show',$data);
  	}

	/*
	* Manage_tool_edit
	* get disease and tools list
	* @input ddt_stde_id(structure_detail id): แผนก [HRM]
	* $output screen of disease and tools list
	* @author Areerat Pongurai
	* @Create Date 05/08/2024
	*/
	public function Manage_tool_edit($ddt_stde_id) {
		$data['ddt_stde_id'] = $ddt_stde_id;
		$ddt_stde_id = decrypt_id($ddt_stde_id);

		// get structure_detail info
		$this->load->model('hr/structure/m_hr_structure_detail');
		$data['structure_detail'] = $this->m_hr_structure_detail->get_by_id($ddt_stde_id)->row();

		// get list
		$this->load->model('wts/m_wts_department_disease_tool');
        $params = ['ddt_stde_id' => $ddt_stde_id, 'is_null_ddt_ds_id' => false];
		$tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();
		$this->m_wts_department_disease_tool->ddt_stde_id = $ddt_stde_id;
		$diseases = $this->m_wts_department_disease_tool->get_diseases_by_stde()->result_array();

		// encrypt id
		$names = ['ddt_id', 'ddt_ds_id']; // object name need to encrypt 
		$data['tools'] = encrypt_arr_obj_id($tools, $names);
		$names = ['ds_id']; // object name need to encrypt 
		$data['diseases'] = encrypt_arr_obj_id($diseases, $names);
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/manage/v_manage_tools_form',$data);
	}

	/*
	* Manage_tool_get_tools
	* edit tools list of disease
	* @input 
			ddt_ds_id(wts_base_disease id): โรค [WTS]
			ddt_stde_id(structure_detail id): แผนก [HRM]
	* $output screen of modal for edit tools list of disease
	* @author Areerat Pongurai
	* @Create Date 05/08/2024
	*/
	public function Manage_tool_get_tools() {
		$post_data = $this->input->post();
        $data['ddt_stde_id'] = $post_data['ddt_stde_id'];
        $data['ddt_ds_id'] = $post_data['ddt_ds_id'];
		$ddt_stde_id = decrypt_id($post_data['ddt_stde_id']);
		$ddt_ds_id = decrypt_id($post_data['ddt_ds_id']);

		// get list
		$this->load->model('wts/m_wts_department_disease_tool');
        $params = ['ddt_ds_id' => $ddt_ds_id, 'is_null_ddt_ds_id' => true];
		$tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();

		// encrypt id
		$names = ['ddt_id', 'ddt_ds_id', 'ddt_eqs_id', 'eqs_rm_id']; // object name need to encrypt 
		$data['tools'] = encrypt_arr_obj_id($tools, $names);
		
        // get ddl
        $this->load->model('eqs/m_eqs_room');
        $order = array('rm_name' => 'ASC');
        $rooms = $this->m_eqs_room->get_all($order)->result_array();

		$this->load->model('eqs/m_eqs_equipments');
		$order = array('eqs_name' => 'ASC');
		$equipments = $this->m_eqs_equipments->get_all($order)->result_array();

        // encrypt id ddl
        $names = ['rm_id']; // object name need to encrypt
        $data['rooms'] = encrypt_arr_obj_id($rooms, $names);
        $names = ['eqs_id', 'eqs_rm_id']; // object name need to encrypt
        $data['equipments'] = encrypt_arr_obj_id($equipments, $names);

        $this->load->view('wts/manage/v_manage_tools_modal_show', $data);
	}

	/*
	* Manage_tool_update
	* for insert tool of disease/structure_detail
	* @input form data
	* $output response
	* @author Areerat Pongurai
	* @Create Date 05/08/2024
	*/
	public function Manage_tool_update() {
		$post_data = $this->input->post();
		$ddt_stde_id = decrypt_id($post_data['ddt_stde_id']);
		$ddt_ds_id = decrypt_id($post_data['ddt_ds_id']);

		// check validate
		if (isset($post_data['eqs_id']) && !empty($post_data['eqs_id'])) {
            $eqs_ids = $post_data['eqs_id'];
            foreach($eqs_ids as $key => $eqs_id) {
				$id_check = decrypt_id($eqs_id);
                if(empty($id_check))
                    $data['error_inputs'][] = (object) ['name' => $post_data['eqs_id_name'][$key], 'error' => $this->config->item('text_invalid_default')];
            }
        }

        if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
            $data['status_response'] = $this->config->item('status_response_error');
            $data['message_dialog'] = $this->config->item('text_invalid_inputs');
        } else { // case success
			// 1. defined value
			$this->load->model('wts/m_wts_department_disease_tool');
			$this->m_wts_department_disease_tool->ddt_stde_id = $ddt_stde_id;
			$this->m_wts_department_disease_tool->ddt_ds_id = $ddt_ds_id;
			$this->m_wts_department_disease_tool->ddt_create_user = $this->session->userdata('us_id');
			// $this->m_wts_department_disease_tool->ddt_update_user = $ddt_ds_id;

			// 2. delete old data 
			$this->m_wts_department_disease_tool->delete_tools_by_ds_stde();
            // $ddt_ids = $post_data['ddt_id'];
			// $ddt_ids_int = [];
			// foreach($ddt_ids as $id) {
			// 	$id = decrypt_id($id);
			// 	if(!empty($id))
			// 		$ddt_ids_int[] = $id;
			// }
			// if(!empty($ddt_ids_int)) {
			// 	$ddt_ids_string = implode(", ", $ddt_ids_int);
			// 	$this->m_wts_department_disease_tool->delete_tools($ddt_ids_string);
			// }

			// 3. insert new data
            $eqs_ids = $post_data['eqs_id'];
			foreach($eqs_ids as $key => $eqs_id) {
				$this->m_wts_department_disease_tool->ddt_eqs_id = decrypt_id($eqs_id);
				$this->m_wts_department_disease_tool->ddt_seq = ++$key;
				
				// $ddt_id_check = decrypt_id($ddt_ids[$key-1]);
				// if(!empty($ddt_id_check)) { // update
				// 	$this->m_wts_department_disease_tool->ddt_id = $ddt_id_check;
				// 	$this->m_wts_department_disease_tool->update();
				// } else { 
					// insert
					$this->m_wts_department_disease_tool->insert();
				// }
            }

            $data['returnUrl'] = base_url() . 'index.php/wts/Manage_tool/Manage_tool_edit/'.encrypt_id($ddt_stde_id);
            $data['status_response'] = $this->config->item('status_response_success');
        }

		$result = array('data' => $data);
		echo json_encode($result);
	}
}

?>