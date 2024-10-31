<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class News extends UMS_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('ums/m_ummenu');
		$this->load->model('ums/Genmod', 'genmod');
	}

	public function index()
	{
		$data['get'] = $this->genmod->getAll('see_umsdb', 'ums_news', '*', array('news_active !=' => 2));
		// $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		// $data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/news/v_news_news_show', $data);
	}

	// For show page
	// public function add()
	// {
	// 	$news_name  = $this->input->post('StNameT');
	// 	$news_start_date  = $this->input->post('date_start');
	// 	//  = $this->input->post('time_start');
	// 	// $news_stop_date = $this->input->post('date_stop');
	// 	//  = $this->input->post('time_stop');
	// 	$news_text  = $this->input->post('StDetail');
	// 	$StType1 = $this->input->post('FileId');
	// 	$StType1 = $this->input->post('ImageId');
	// 	$StType1 = $this->input->post('gid');
	// 	die;
	// 	// $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	// 	// $data['status_response'] = $this->config->item('status_response_show');;
	// 	$this->output('ums/news/v_news_news_form', $data);
	// }
	public function add()
	{
		$news_name  = $this->input->post('StNameT');
		$news_start_date  = $this->input->post('date_start');
		$time_start = $this->input->post('time_start');
		$news_stop_date = $this->input->post('date_stop');
		$time_stop = $this->input->post('time_stop');
		$StDetail  = $this->input->post('StDetail');
		$StActive  = $this->input->post('StActive');
		$StType  = $this->input->post('StType');
		$gid  = $this->input->post('gid');
		$news_stop_datetime = date('Y-m-d H:i:s', strtotime("$news_stop_date $time_stop"));
		$news_start_datetime = date('Y-m-d H:i:s', strtotime("$news_start_date $time_start"));
		$uploadedFileName = 'News_' . date('Y-m-d_H-i-s');
		$uploadedimgName = 'News_img_' . date('Y-m-d_H-i-s');
		$fileExtension = '';
		if (!empty($_FILES['FileInput']['name']) || !empty($_FILES['ImgInput']['name'])) {
			$uploadDir_F = $this->config->item('ums_uploads_news_file');
			$uploadDir_img = $this->config->item('ums_uploads_news_img');
			// Handle FileInput
			if (!empty($_FILES['FileInput']['name'])) {
				$fileExtension = pathinfo($_FILES['FileInput']['name'], PATHINFO_EXTENSION);
				$uploadedFileName = $uploadedFileName . '.' . $fileExtension;
				$uploadedFilePath = $uploadDir_F . $uploadedFileName;
				if (!move_uploaded_file($_FILES['FileInput']['tmp_name'], $uploadedFilePath)) {
					$status = 0;
					// Handle file upload error
					echo "Error uploading file.";
					exit;
				}
			}

			// Handle ImgInput
			if (!empty($_FILES['ImgInput']['name'])) {
				$fileExtension_img = pathinfo($_FILES['ImgInput']['name'], PATHINFO_EXTENSION);
				$uploadedimgName = $uploadedimgName . '.' . $fileExtension_img;
				$uploadedimgPath = $uploadDir_img . $uploadedimgName;
				if (!move_uploaded_file($_FILES['ImgInput']['tmp_name'], $uploadedimgPath)) {
					$status = 0;
					// Handle image upload error
					echo "Error uploading image.";
					exit;
				}
			}

			$status = 1;
			$data = array(
				'news_name' => $news_name,
				'news_text' => $StDetail,
				'news_active' => $StActive,
				'news_type' => $StType,
				'news_bg_id' => $gid,
				'news_start_date' => $news_start_datetime,
				'news_stop_date' => $news_stop_datetime,
			);

			// Add uploaded file names to data array if files were uploaded
			if (!empty($uploadedFileName)) {
				$data['news_file_name'] = $uploadedFileName;
			}
			if (!empty($uploadedimgName)) {
				$data['news_img_name'] = $uploadedimgName;
			}
		} else {
			$status = 1;
			$data = array(
				'news_name' => $news_name,
				'news_text' => $StDetail,
				'news_active' => $StActive,
				'news_type' => $StType,
				'news_bg_id' => $gid,
				'news_start_date' => $news_start_datetime,
				'news_stop_date' => $news_stop_datetime,
			);
		}

		// Insert or update the data in the database here	
		$this->genmod->add('see_umsdb', 'ums_news', $data);
		echo json_encode($status);
	}


	public function show()
	{
		$data['get'] = $this->genmod->getAll('see_umsdb', 'ums_base_group', '*', array('bg_active  !=' => 2));
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/news/v_news_news_form', $data);
	}

	public function edit($UsID = "")
	{
		$data['get'] = $this->genmod->getAll('see_umsdb', 'ums_base_group', '*', array('bg_active  !=' => 2));
		$data['usID'] = $UsID;
		$data['edit'] = $this->genmod->getOne('see_umsdb', 'ums_news', '*', array('news_active !=' => 2, 'news_id' => $UsID));
		$timestamp1 = strtotime($data['edit']->news_start_date);
		$timestamp2 = strtotime($data['edit']->news_stop_date);
		$data['date_start'] = date("Y-m-d", $timestamp1);
		$data['time_start'] = date("H:i:s", $timestamp1);
		$data['date_stop'] = date("Y-m-d", 	$timestamp2);
		$data['time_stop'] = date("H:i:s", 	$timestamp2);
		$data['bg_id'] = explode(",", $data['edit']->news_bg_id);
		$data['bg_id'] = array_combine($data['bg_id'], $data['bg_id']);
		$data['UsID'] = $UsID;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ums/news/v_news_news_form', $data);
	}

	public function update_news()
	{
		$News_id = $this->input->post('id');
		$news_name  = $this->input->post('StNameT');
		$news_start_date  = $this->input->post('start_date');
		$time_start = $this->input->post('time_start');
		$news_stop_date = $this->input->post('end_date');
		$time_stop = $this->input->post('time_stop');
		$StDetail  = $this->input->post('StDetail');
		$StActive  = $this->input->post('StActive');
		$StType  = $this->input->post('StType');
		$gid  = $this->input->post('gid');
		$old_file = $this->genmod->getOne('see_umsdb', 'ums_news', 'news_file_name ,news_img_name ', array('news_id' => $News_id));
		$news_stop_datetime = date('Y-m-d H:i:s', strtotime("$news_stop_date $time_stop"));
		$news_start_datetime = date('Y-m-d H:i:s', strtotime("$news_start_date $time_start"));
		$uploadedFileName = 'News_' . date('Y-m-d_H-i-s');
		$uploadedimgName = 'News_img_' . date('Y-m-d_H-i-s');
		$fileExtension = '';
		if (!empty($_FILES['FileInput']['name']) || !empty($_FILES['ImgInput']['name'])) {
			$uploadDir_F = $this->config->item('ums_uploads_news_file');
			$uploadDir_img = $this->config->item('ums_uploads_news_img');
			// Handle FileInput
			if (!empty($_FILES['FileInput']['name'])) {
				if (isset($old_file->news_file_name)) {
					$old_Path = $uploadDir_F . $old_file->news_file_name;
					unlink($old_Path);
				}
				$fileExtension = pathinfo($_FILES['FileInput']['name'], PATHINFO_EXTENSION);
				$uploadedFileName = $uploadedFileName . '.' . $fileExtension;
				$uploadedFilePath = $uploadDir_F . $uploadedFileName;
				if (!move_uploaded_file($_FILES['FileInput']['tmp_name'], $uploadedFilePath)) {
					$status = 0;
					// Handle file upload error
					echo "Error uploading file.";
					exit;
				}
			}
			// Handle ImgInput
			if (!empty($_FILES['ImgInput']['name'])) {
				if (isset($old_file->news_img_name)) {
					$old_Path = $uploadDir_img . $old_file->news_img_name;
					unlink($old_Path);
				}
				$fileExtension_img = pathinfo($_FILES['ImgInput']['name'], PATHINFO_EXTENSION);
				$uploadedimgName = $uploadedimgName . '.' . $fileExtension_img;
				$uploadedimgPath = $uploadDir_img . $uploadedimgName;
				if (!move_uploaded_file($_FILES['ImgInput']['tmp_name'], $uploadedimgPath)) {
					$status = 0;
					// Handle image upload error
					echo "Error uploading image.";
					exit;
				}
			}
			$status = 1;
			$data = array(
				'news_name' => $news_name,
				'news_text' => $StDetail,
				'news_active' => $StActive,
				'news_type' => $StType,
				'news_bg_id' => $gid,
				'news_start_date' => $news_start_datetime,
				'news_stop_date' => $news_stop_datetime,
			);
			// Add uploaded file names to data array if files were uploaded
			if (!empty($uploadedFileName)) {
				$data['news_file_name'] = $uploadedFileName;
			}
			if (!empty($uploadedimgName)) {
				$data['news_img_name'] = $uploadedimgName;
			}
		} else {
			$status = 1;
			$data = array(
				'news_name' => $news_name,
				'news_text' => $StDetail,
				'news_active' => $StActive,
				'news_type' => $StType,
				'news_bg_id' => $gid,
				'news_start_date' => $news_start_datetime,
				'news_stop_date' => $news_stop_datetime,
			);
		}

		// Insert or update the data in the database here	
		$this->genmod->update('see_umsdb', 'ums_news', $data, array('news_id' => $News_id));
		echo json_encode($status);
	}

	public function delete($StID)
	{
		$ck = $this->genmod->update('see_umsdb', 'ums_news', array('news_active ' => 2), array('news_id' => $StID));
		if ($ck == true) {
			$data['status_response'] = $this->config->item('status_response_success');
		} else {
			$data['status_response'] = $this->config->item('status_response_error');
		}
		$result = array('data' => $data);
		echo json_encode($result);
	}
}
