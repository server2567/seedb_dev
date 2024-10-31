<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class System_qr_scan extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('wts/m_wts_base_disease_time');
		$this->load->model('wts/m_wts_base_route_department');
		$this->load->model('wts/m_wts_qrcode_scan_patient');
		$this->load->model('wts/m_wts_base_route_time');
		$this->load->model('wts/m_wts_base_qrcode');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');
	}

	function index(){
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$qr_code = [];

		foreach ($data['stde'] as $key => $dep) {
    		$qr_code[$dep->stde_id] = $this->m_wts_qrcode_scan_patient->get_count_qr_list_by_stde($dep->stde_id)->result_array();
		}

		$data['qr_code'] = $qr_code;
		$data['disease_time'] = $this->m_wts_base_disease_time->get_all_disease_time()->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$this->output('wts/system/v_system_qr_scan',$data);
  	}

	function qr_scan_show($stde_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['qr_code'] = $this->m_wts_qrcode_scan_patient->get_qr_list($stde_id)->result_array();
		// $data['qrsp_count'] = $this->m_wts_qrcode_scan_patient->get_count_qr_list_by_stde($stde_id)->result_array();
		// pre($data['qr_code']);
		$data['disease_time'] = $this->m_wts_base_disease_time->get_all_disease_time()->result_array();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$this->output('wts/system/v_system_qr_scan_show',$data);

	}

	public function qr_scan_insert() {
		$this->load->model('m_wts_qrcode_scan_patient');
	
		// Retrieve form data
		$data = $this->input->post();
	
		// Validate and process the QR code
		if (!empty($data['qr_code'])) {
			$log_data = [
				'qrsp_pt_id' => $this->session->userdata('user_id'),
				'qrsp_qr_id' => $data['qr_code'],  // Assuming qr_code is the ID
				'qrsp_dst_id' => '1',  // Assuming a default value
				'qrsp_date_time' => date('Y-m-d H:i:s')
			];
	
			// Insert the scanned data into the database
			// $this->m_wts_qrcode_scan_patient->set_qrcode_scan_log($log_data);
	
			$response = [
				'status' => 'success',
				'header' => 'Success',
				'body' => 'QR code processed and stored successfully',
				'returnUrl' => site_url('wts/frontend/User_que_show')
			];
		} else {
			$response = [
				'status' => 'error',
				'header' => 'Error',
				'body' => 'Invalid QR code'
			];
		}
	
		echo json_encode($response);
	}
	
	public function scan() {
		// Insert new data into the 'wts_qrcode_scan_patient' table
		$data = [
			'qrsp_date_time' => date('Y-m-d H:i:s'),
			'qrsp_qr_id' => $this->input->post('qr_code')  // Assuming qr_code is sent in the request
		];
		
		$this->db->insert('wts_qrcode_scan_patient', $data);
	
		// Send response
		echo 'QR Code scanned and recorded';
	}
	}
?>