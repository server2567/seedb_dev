<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class System_qr_code extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->helper('url');
        $this->load->helper('file');
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('wts/m_wts_base_route_time');
		$this->load->model('wts/m_wts_base_qrcode');
		$this->load->model('wts/m_wts_qrcode_scan_patient');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');
	}

	function index(){
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['qr_code'] = $this->m_wts_base_qrcode->get_all()->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/system/v_system_qr_code',$data);
  	}

	  public function qr_add($qr_id=null) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		// $data['last_id'] = $this->m_wts_base_qrcode->get_qr_last_id()->result();
		// die;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/system/v_system_qr_code_form.php',$data);
	}

	public function qr_insert() {
		$data['last_id'] = $this->m_wts_base_qrcode->get_qr_last_id();
		// pre($data['last_id']);		
		// $data['last_id'] = $this->m_wts_base_qrcode->get_qr_last_id()->result();
		// pre($data['last_id']); die;
		$qr_form_data = $this->input->post();
		$qr_img_url = $qr_form_data['qr_img_url'];
		// $qr_img_name = $qr_form_data['qr_img_name'] . '5' . '.png';
		$qr_img_name = $qr_form_data['qr_img_name'] . ($data['last_id']+1) . '.png';
		// pre($qr_img_name);
		// pre($qr_img_name); die;

		// $last_qr_insert_id = $this->m_wts_base_qrcode->last_insert_id;
		// // Decode the base64 image data
		// list($type, $qr_img_url) = explode(';', $qr_img_url);
		// list(, $qr_img_url) = explode(',', $qr_img_url);
		// $qr_img_data = $qr_img_url;
	
		 // Download the file from $qr_img_url and save it to /tmp
		
		 $temp_file_path = '/var/tmp/' . $qr_img_name;
		//  pre($temp_file_path);

		//  $qr_img_url = $this->config->item('wts_uploads_dir') . 'Qrcode/' . $qr_img_name;
		//  pre($qr_img_url);

		 $upload_dir = '/var/www/uploads/wts/Qrcode/';
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777, true); // สร้างไดเรกทอรีและตั้งสิทธิ์เป็น 0777
		}
		//  $temp_file_path = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
		 $qr_img_data = @file_get_contents($qr_img_url);// Write the downloaded data to the temporary file
		//  pre($qr_img_data);
		 if ($qr_img_data === FALSE) {
			die("Error: Unable to access file at $qr_img_url");
		}
		//  pre($qr_img_data); die;
		 file_put_contents($temp_file_path, $qr_img_data);
	
		// Define the upload directory
		$upload_dir = '/var/www/uploads/wts/Qrcode/';
		// if (!is_dir($upload_dir)) {
		// 	mkdir($upload_dir, 0755, TRUE);
		// }
	
		// Load the file upload library
		$this->load->library('upload');
	
		// Set upload configuration
		$config['upload_path'] = $upload_dir;
		$config['allowed_types'] = '*';
		$config['file_name'] = $qr_img_name;
		$config['overwrite'] = TRUE;
	
		$this->upload->initialize($config);
	
		// Simulate file upload for CodeIgniter's upload library
		$_FILES['qr_img_file'] = array(
			'name' => basename($temp_file_path),
			'type' => 'image/png',
			'tmp_name' => $temp_file_path,
			'error' => UPLOAD_ERR_OK,
			'size' => filesize($temp_file_path)
		);
	// pre($_FILES['qr_img_file']); 
		// Check if the upload is successful
		if ($this->upload->do_upload('qr_img_file')) {
			$upload_data = $this->upload->data();
			$image_path = $upload_dir . $upload_data['file_name'];

			// Save the data to the database
			$this->m_wts_base_qrcode->qr_stde_id = $qr_form_data['qr_stde_id'];
			$this->m_wts_base_qrcode->qr_img_name = $qr_img_name;
			$this->m_wts_base_qrcode->qr_img_path = $image_path;
			$this->m_wts_base_qrcode->qr_link = base_url() . 'index.php/wts/GetFile?type=Qrcode&image=' . $qr_img_name;
			// pre($this->m_wts_base_qrcode->qr_link); die;
			$this->m_wts_base_qrcode->qr_deatile = $qr_form_data['qr_deatile'];
			$this->m_wts_base_qrcode->qr_create_user = 1;
			$this->m_wts_base_qrcode->qr_create_date = date('Y-m-d H:i:s');
			$this->m_wts_base_qrcode->qr_update_user = 1;
			$this->m_wts_base_qrcode->qr_update_date = date('Y-m-d H:i:s');
			
			$this->m_wts_base_qrcode->insert();
	
			$response = array( 
				'status' => 'success',
				'header' => 'ดำเนินการเสร็จสิ้น',
				'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
				'returnUrl' => base_url().'index.php/wts/System_qr_code',
			);
		} else {
			$response = array(
				'status' => 'error',
				'header' => 'Error',
				'body' => $this->upload->display_errors(),
			);
		}
	
		// Clean up the temporary file
		unlink($temp_file_path);
	
		echo json_encode($response);
	}
		
	public function qr_edit($qr_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['qr_code'] = $this->m_wts_base_qrcode->get_qr_list($qr_id)->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/system/v_system_qr_code_form.php',$data);
	}

	public function qr_update() {
		$qr_form_data = $this->input->post();
		$qr_img_name = $qr_form_data['qr_img_name'] . '.png';
	
		$temp_file_path = '/var/tmp/' . $qr_img_name;
		$qr_img_url = $this->config->item('wts_uploads_dir') . 'Qrcode/' . $qr_img_name;
	
		// Log the URL being used to fetch the image
		log_message('debug', 'QR image URL: ' . $qr_img_url);
	
		// Fetch image content
		$qr_img_data = file_get_contents($qr_form_data['qr_img_url']);
		if ($qr_img_data === FALSE) {
			log_message('error', 'Failed to download image from URL: ' . $qr_form_data['qr_img_url']);
			$response = array(
				'status' => 'error',
				'header' => 'Error',
				'body' => 'Failed to download image from URL.',
			);
			echo json_encode($response);
			return;
		}
	
		// Store image temporarily
		if (file_put_contents($temp_file_path, $qr_img_data) === FALSE) {
			log_message('error', 'Failed to write image to temporary path: ' . $temp_file_path);
			$response = array(
				'status' => 'error',
				'header' => 'Error',
				'body' => 'Failed to write image to temporary path.',
			);
			echo json_encode($response);
			return;
		}
	
		// Log the temporary file path
		log_message('debug', 'Temporary file path: ' . $temp_file_path);
	
		// Define the upload directory
		$upload_dir = '/var/www/uploads/wts/Qrcode/';
	
		// Ensure the upload directory exists
		if (!is_dir($upload_dir)) {
			if (!mkdir($upload_dir, 0755, TRUE)) {
				log_message('error', 'Failed to create upload directory: ' . $upload_dir);
				$response = array(
					'status' => 'error',
					'header' => 'Error',
					'body' => 'Failed to create upload directory.',
				);
				echo json_encode($response);
				return;
			}
		}
	
		// Load the file upload library
		$this->load->library('upload');
	
		// Set upload configuration
		$config['upload_path'] = $upload_dir;
		$config['allowed_types'] = '*';
		$config['file_name'] = $qr_img_name;
		$config['overwrite'] = TRUE;
	
		$this->upload->initialize($config);
	
		// Simulate file upload for CodeIgniter's upload library
		$_FILES['qr_img_file'] = array(
			'name' => basename($temp_file_path),
			'type' => 'image/png',
			'tmp_name' => $temp_file_path,
			'error' => UPLOAD_ERR_OK,
			'size' => filesize($temp_file_path)
		);
	
		// Log the simulated file upload data
		log_message('debug', 'Simulated file upload data: ' . print_r($_FILES['qr_img_file'], TRUE));
	
		// Check if the upload is successful
		if ($this->upload->do_upload('qr_img_file')) {
			$upload_data = $this->upload->data();
			$image_path = $upload_dir . $upload_data['file_name'];
	
			log_message('debug', 'Upload successful. Image path: ' . $image_path);
	
			$this->m_wts_base_qrcode->qr_id = $qr_form_data['qr_id'];
			$this->m_wts_base_qrcode->qr_stde_id = $qr_form_data['qr_stde_id'];
			$this->m_wts_base_qrcode->qr_img_name = $qr_img_name;
			$this->m_wts_base_qrcode->qr_img_path = $image_path; // Ensure the image path is updated here
			$this->m_wts_base_qrcode->qr_link = base_url() . 'index.php/wts/GetFile?type=Qrcode&image=' . $qr_img_name;
			$this->m_wts_base_qrcode->qr_deatile = $qr_form_data['qr_deatile'];
			$this->m_wts_base_qrcode->qr_update_user = 1;
			$this->m_wts_base_qrcode->qr_update_date = date('Y-m-d H:i:s');
	
			$this->m_wts_base_qrcode->update();
	
			$response = array(
				'status' => 'success',
				'header' => 'ดำเนินการเสร็จสิ้น',
				'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
				'returnUrl' => base_url().'index.php/wts/System_qr_code',
			);
		} else {
			log_message('error', 'Upload failed: ' . $this->upload->display_errors());
			$response = array(
				'status' => 'error',
				'header' => 'Error',
				'body' => $this->upload->display_errors(),
			);
		}
	
		// Clean up the temporary file
		if (file_exists($temp_file_path)) {
			unlink($temp_file_path);
		}
	
		echo json_encode($response);
	}
	
	public function qr_delete_data($qr_id) {
		//// case success
		$this->m_wts_base_qrcode->qr_id = $qr_id;
		$this->m_wts_base_qrcode->delete();

		$data['returnUrl'] = base_url().'index.php/wts/System_qr_code';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function qr_show($qr_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['qr_code'] = $this->m_wts_base_qrcode->get_qr_list($qr_id)->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/system/v_system_qr_code_info.php',$data);
	}

	// public function download_qr_code($qr_id) {
    //     // ตรวจสอบว่ามี QR Code นี้อยู่หรือไม่
    //     $data['qr_code'] = $this->m_wts_base_qrcode->get_qr_code_by_id($qr_id)->result_array();
	// 	// pre($data['qr_code']); die;
    //     if (!$data['qr_code']) {
    //         show_404(); // หากไม่มีข้อมูล QR Code จะแสดงหน้า 404
    //     }

    //     $path = 'assets/img/wts/' . $data['qr_code'][0]['qr_img_name'];
	// 	pre($path); die; // กำหนดเส้นทางไปยังไฟล์ QR Code
    //     if (file_exists($path)) {
    //         $this->load->helper('download');
    //         force_download($path, NULL); // ดาวน์โหลดไฟล์โดยใช้ helper ของ CodeIgniter
    //     } else {
    //         show_404(); // หากไฟล์ไม่พบ จะแสดงหน้า 404
    //     }
    // }
	// public function scan() {
	// 	// แทรกข้อมูลใหม่เข้าไปในตาราง 'scans' ในฐานข้อมูล
	// 	$this->db->insert('wts_qrcode_scan_patient', array('qrsp_date_time' => date('Y-m-d H:i:s')));
	
	// 	// ส่งข้อความตอบกลับ
	// 	echo 'QR Code scanned and recorded';
	// }
}
?>
