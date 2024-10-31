<?php
/*
* Import_examination_result
* Main controller of Import_examination_result
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 07/06/2024
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('DIM_Controller.php');

class Import_examination_result extends DIM_Controller
{

  // Create __construct for load model use in this controller
  public function __construct()
  {
    parent::__construct();
  }

  /*
	* index
	* Index controller of Import_examination_result
	* @input -
	* $output examination result list that owner is session
	* @author Areerat Pongurai
	* @Create Date 07/06/2024
	*/
  public function index()
  {
    $eqs_rm_id = $this->session->userdata('eqs_rm_id');
    $data['eqs_rm_id'] = (!empty($eqs_rm_id)) ? $eqs_rm_id : null;

    // get ddl
    $thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $months = [];
    foreach ($thaiMonths as $index => $month) {
      $months[] = [
        'index' => $index + 1,  // Optional: if you want to include the month index (1-12)
        'name_th' => $month
      ];
    }
    $data['months'] = $months;

    // get ddl
    $this->load->model('eqs/m_eqs_room');
    $order = array('rm_name' => 'ASC');
    $rooms = $this->m_eqs_room->get_rooms_tools($order)->result_array();

    // encrypt id ddl
    $names = ['rm_id']; // object name need to encrypt
    $data['rooms'] = encrypt_arr_obj_id($rooms, $names);

    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('dim/import_examination_result/v_import_examination_result_show', $data);
  }

  /*
	* Import_examination_result_set_eqs_rm_id
	* set eqs_rm_id in session
	* @input eqs_rm_id
	* $output response
	* @author Areerat Pongurai
	* @Create Date 05/08/2024
	*/
  public function Import_examination_result_set_eqs_rm_id()
  {
    $this->session->set_userdata('eqs_rm_id', $this->input->post('eqs_rm_id'));

    $data['status_response'] = $this->config->item('status_response_success');
    $result = array('data' => $data);
    echo json_encode($result);
  }

  /*
	* Import_examination_result_get_list
	* get examination_result from dim_examination_result
	* @input search form data, config from datatable
	* $output list of examination_result
	* @author Areerat Pongurai
	* @Create Date 30/07/2024
	*/
  public function Import_examination_result_get_list() {
    $draw = intval($this->input->post('draw'));
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $order = $this->input->post('order');
    $order_column = !empty($order) ? $order[0]['column'] : 'exr_inspection_time';
    $order_dir = !empty($order) ? $order[0]['dir'] : 'DESC';
    
    $search = $this->input->post('search')['value'] ?? NULL;

    $date = $this->input->post('date');
    if (!empty($date)) {
        $date = convertToEngYearForDB($date);
    } elseif (empty($this->input->post('month'))) {
        $date = (new DateTime())->format('Y-m-d 00:00:00');
    }

    $params = [
        'month' => $this->input->post('month'),
        'date' => $date,
        'pt_member' => $this->input->post('pt_member'),
        'pt_name' => $this->input->post('pt_name'),
        'eqs_rm_id' => decrypt_id($this->input->post('rm_id')),
        'eqs_id' => decrypt_id($this->input->post('eqs_id')),
        'search' => $search
    ];

    $badge = '';
    if (!empty($date)) {
        $badge = "ประจำวันที่ " . formatShortDateThai($date);
    } elseif (!empty($this->input->post('month'))) {
        $badge = "ประจำเดือน " . getLongMonthThai($this->input->post('month'));
    }

    $this->load->model('dim/m_dim_examination_result');
    $this->m_dim_examination_result->exr_update_user = $this->session->userdata('us_id');

    switch ($this->input->post('tb_index')) {
        case 1:
            $result = $this->m_dim_examination_result->get_all_with_detail_server(['W'], $start, $length, $order_column, $order_dir, $params);
            break;
        case 2:
            $result = $this->m_dim_examination_result->get_all_with_detail_server(['Y', 'C'], $start, $length, $order_column, $order_dir, $params);
            break;
    }
    $list = $result['query']->result_array();
    $total_records = $result['total_records'];
    // pre($list);
    $data = [];
    foreach ($list as $row) {
        $exr_id = encrypt_id($row['exr_id']);
        $class = "text-warning";
        $btn = '';

        switch ($row['exr_status']) {
            case 'W':
                $btn_url = base_url().'index.php/dim/Import_examination_result/Import_examination_result_edit/0/'.$exr_id;
                $btn = '<button class="btn btn-warning" onclick="window.location.href=\''.$btn_url.'\'"><i class="bi-pencil-square"></i></button>';
                break;
            case 'Y':
                $class = "text-success";
                $btn_url = base_url().'index.php/dim/Import_examination_result/Import_examination_result_edit/1/'.$exr_id;
                $btn = '<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\''.$btn_url.'\'"><i class="bi-search"></i></button>';
                $btn_url = base_url().'index.php/dim/Import_examination_result/Import_examination_result_edit/0/'.$exr_id;
                $btn .= '<button class="btn btn-warning ms-1" onclick="window.location.href=\''.$btn_url.'\'"><i class="bi-pencil-square"></i></button>';
                break;
            case 'C':
                $class = "text-danger";
                $btn_url = base_url().'index.php/dim/Import_examination_result/Import_examination_result_edit/1/'.$exr_id;
                $btn = '<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\''.$btn_url.'\'"><i class="bi-search"></i></button>';
                break;
        }

        $data[] = [
            'exr_inspection_time' => convertToThaiYear($row['exr_inspection_time'], true),
            'apm_visit' => '<div class="text-center">'.$row['apm_visit'].'</div>',
            'apm_ql_code' => '<div class="text-center">'.$row['apm_ql_code'].'</div>',
            'pt_member' => '<div class="text-center">'.$row['pt_member'].'</div>',
            'pt_full_name' => $row['pt_full_name'],
            'ps_full_name' => $row['ps_full_name'],
            'dp_stde_name_th' => $row['dp_stde_name_th'],
            'rm_eqs_name' => $row['rm_eqs_name'],
					  'status_text' => '<div class="text-center"> <i class="bi-circle-fill ' . $class . '"></i> ' . $row['exr_status_text']."</div>",
            'actions' => '<div class="text-center">'.$btn.'</div>',
            'status_class' => $class,
        ];
    }

    $response = [
        'draw' => $draw,
        'recordsTotal' => $total_records,
        'recordsFiltered' => $total_records,
        'data' => $data,
        'badge' => $badge
    ];

    echo json_encode($response);
  }

  /*
	* Import_examination_result_edit
	* for show insert/edit screen and examination result data
	* @input exr_id (examination result id) :: ==null >>> insert || <>null >>> edit
	* $output insert/edit screen and examination result data
	* @author Areerat Pongurai
	* @Create Date 07/06/2024
	*/
  public function Import_examination_result_edit($is_detail, $exr_id = null)
  {
    $data['actor'] = 'officer'; // fix actor for reuse view

    if (!empty($exr_id)) {
      $data['is_detail'] = $is_detail; // fix is view
      $data['exr_id'] = $exr_id;
      $exr_id = decrypt_id($exr_id);

      $this->load->model('dim/m_dim_examination_result');
      $this->m_dim_examination_result->exr_id = $exr_id;
      $result = $this->m_dim_examination_result->get_detail_by_id()->result_array();
      if ($result)
        $data['edit'] = $result[0];
      // else
      // 	log error

      // check if examination result owner != session
      if ($data['edit']['exr_status'] != 'W' && $data['edit']['exr_update_user'] != $this->session->userdata('us_id'))
        redirect('dim/Import_examination_result', 'refresh');

      // check if exr_status = C (Cancel) then cant edit, only view
      if ($data['edit']['exr_status'] == 'C')
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
            if (is_readable($path)) {
              $pathdownload = base_url() . "index.php/dim/Getpreview?path=" . bin2hex($path);;
              $fileDetails = $this->Import_examination_result_get_file_details($path);
              
              $exrdId = null;
              $found = array_filter($examination_result_docs, function ($obj) use ($file) {
                return $obj['exrd_file_name'] === $file;
              });

              $is_not_delete = false;
              if (!empty($found)) {
                // Get the first element from the filtered results
                $firstMatch = reset($found);
                // Extract the 'exrd_id' from the first matching element
                $exrdId = $firstMatch['exrd_id'];
                if (!empty($firstMatch['exrd_status']))
                  $is_not_delete = true;
              } else {
                $is_not_delete = true;
              }

              if ($is_not_delete) {
                $files[] = array(
                  'file' => $fileDetails,
                  'name' => $file,
                  'url' => $pathdownload,
                  'exrdId' => $exrdId,
                );
              }
            }
          }
        } else {
          die("Could not open directory.");
        }
      } else {
        die("Nas target directory does not exist: $nas_target_folder");
      }

      if (!empty($files))
        $data['files'] = $files;

      if (!$data['is_detail'])
        $data['exr_inspection_time'] = !empty($data['edit']['exr_inspection_time']) ? $data['edit']['exr_inspection_time'] : date("Y-m-d H:i:s");
      else {
        $data['exr_inspection_time'] = !empty($data['edit']['exr_inspection_time']) ? $data['edit']['exr_inspection_time'] : null;
      }

      // get next dim_examination_result
      $this->m_dim_examination_result->exr_ntr_id = $data['edit']['exr_ntr_id'];
      $exam_results = $this->m_dim_examination_result->get_by_ntr_id()->result_array();
      if(!empty($exam_results)) {
        $is_have_next_exr_id = false;
        foreach ($exam_results as $exr) {
          if($exr['exr_status'] == 'W') {
            $next_exr_id = encrypt_id($exr['exr_id']);
            $data['next_exr_id'] = $next_exr_id;
            $is_have_next_exr_id = true;
          }
          if($is_have_next_exr_id) break;
        }
      }
    } else {
      $data['exr_inspection_time'] = date("Y-m-d H:i:s");
      $data['exr_round'] = 1;
    }

    // person data
    $this->load->model('hr/m_hr_person');
    $this->m_hr_person->ps_id = $this->session->userdata('us_ps_id');
    $data['person'] = $this->m_hr_person->get_personal_dashboard_profile_detail_data_by_id()->row();

    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');
    $this->output('dim/import_examination_result/v_import_examination_result_form', $data);
  }

  /*
	* Import_examination_result_update
	* for insert examination result data in db
	* @input examination result from  and id
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/

  public function connect_his_database()
  {
      $host = $this->config->item('his_host');
      $dbname = $this->config->item('his_dbname_tab');
      $username = $this->config->item('his_username');
      $password = $this->config->item('his_password');
      try {
          // สร้างการเชื่อมต่อฐานข้อมูลด้วย PDO
          $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
          // ตั้งค่า PDO ให้แสดงข้อผิดพลาดเป็น Exception
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $pdo;
      } catch (PDOException $e) {
          // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
          // echo "เกิดข้อผิดพลาด: " . $e->getMessage();
          return null;
      }
  }

  public function Import_examination_result_update($exr_id)
  {
    // decrypt id
    $exr_id = decrypt_id($exr_id);
    $this->load->model('dim/m_dim_examination_result');
    $this->m_dim_examination_result->exr_id = $exr_id;
    $exam_re_data = $this->m_dim_examination_result->get_detail_by_id()->row();
    // ถ้าไม่มี folder ไว้เก็บไฟล์ ให้แจ้งเตือน error
    if(empty($exam_re_data->exr_directory)) {
      $data['status_response'] = $this->config->item('status_response_error');
      $data['message_dialog'] = "เครื่องมือหัตถการนี้ไม่มีการเชื่อมต่อกับโฟลเดอร์ใน NAS";
      $result = array('data' => $data);
      echo json_encode($result);
      return;
    }

    // $next_exr_id = $this->input->post("next_exr_id");
    $this->m_dim_examination_result->exr_inspection_time = $this->input->post("exr_inspection_time");
    $this->m_dim_examination_result->exr_status = 'Y';
    $this->m_dim_examination_result->exr_ip_internet = $_SERVER['REMOTE_ADDR'];
    $this->m_dim_examination_result->exr_ip_computer = detect_device_type();
    $this->m_dim_examination_result->exr_update_user = $this->session->userdata('us_id');

    // value another case
    $exrd_ids = $this->input->post("exrd_ids");

    // get equipment data
    $this->load->model('eqs/m_eqs_equipments');
    $this->m_eqs_equipments->eqs_id = $exam_re_data->exr_eqs_id;
    $result = $this->m_eqs_equipments->get_by_key()->result_array();
    if ($result)
      $equipment = $result[0];

    // setting config to upload and check
    $pathuploads = $this->config->item('dim_nas_path');
    $path_folder_patient = $exam_re_data->exr_directory;
    $path = $pathuploads . $path_folder_patient;
    $nas_target_folder = $this->config->item('dim_nas_share_path') . $path_folder_patient;

    // // [ForTest] delete
    // $this->Import_examination_result_delete_folder($pathuploads . $folder_tool);
    // // [ForTest] Check if the folder exists
    // if (is_dir($path)) {
    // 	if (!$this->Import_examination_result_delete_folder($path)) {
    //         // echo "Folder deleted and recreated successfully: " . $path;
    //     }
    // }
    // Check if the folder exists
    if (!is_dir($path)) {
      // Try to create the folder
      if (mkdir($path, 0777, true)) {
        // echo "Folder created successfully: " . $path;
      } else {
        // echo "Failed to create folder: " . $path;
      }
    }
    $config['upload_path'] =  $path;
    $config['allowed_types'] = '*';

    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    $filenames = [];
    $old_filenames = [];
    $file_patient = date("Ymd_Hi");
    if (isset($_FILES['files'])) {
      // // get index max+1 file in directory
      // $count_doc = 1;
      // $nums = [];
      // $files_nas = @scandir($path);
      // if (is_array($files_nas)) {
      //   $files_nas = array_diff($files_nas, array('.', '..')); // Remove '.' and '..'

      //   foreach ($files_nas as $file) {
      //     if (is_file($path . '/' . $file)) { // Split filename by '_'
      //       $parts = explode('_', $file);
      //       $num = $parts[count($parts) - 1];
      //       $nums[] = explode('.', $num)[0];
      //     }
      //   }
      // }
      // $max = !empty($nums) ? max($nums) : 0;
      // $count_doc = $max + 1;

      // count files in form
      $files = $_FILES['files'];
      $fileCount = count($files['name']);

      for ($i = 0; $i < $fileCount; $i++) {
        // if file is new file that insert from client, not file that saved
        if (empty($exrd_ids[$i]) || (!empty($exrd_ids[$i]) && $exrd_ids[$i] == 'undefined')) {
          // new file name
          $file_extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
          // $name = $file_patient;
          // $name = $file_patient . '_' . $count_doc . "." . $file_extension;

          // if have files NAS before not from SeeDB then rename and save file names in SeeDB
          if (file_exists($nas_target_folder . '/' . $files['name'][$i])) {
            // $old_name = $nas_target_folder . '/' . $files['name'][$i];
            // $new_name = $nas_target_folder . '/' . $name;
            // // if (!rename($old_name, $new_name)) {
            // // 	die( "Error renaming file.");
            // // }
            // $rename_command = "sudo mv \"$old_name\" \"$new_name\"";
            // exec($rename_command, $output, $return_var);
            // if ($return_var !== 0) {
            //   die("Failed to rename: " . implode("\n", $output));
            // }
            // 20240906 Areerat - หากที่ folder นั้นมีไฟล์ผลตรวจที่ไม่ได้มาจากการ manual upload ให้ไม่ต้องเปลี่ยนชื่อก่อน (filename = oldfilename)
            // $filenames[] = $name;
            $filenames[] = $files['name'][$i];
            $old_filenames[] = $files['name'][$i];
          } else { // else then normal upload
            // 20240906 Areerat - หากที่ folder นั้นมีไฟล์ผลตรวจที่ไม่ได้มาจากการ manual upload ให้ไม่ต้องเปลี่ยนชื่อก่อน (filename = oldfilename)
            // $config['file_name'] = $name;
            $config['file_name'] = $files['name'][$i];
            $old_filenames[] = $files['name'][$i];
            // $_FILES['files']['name'] = $name;
            $_FILES['files']['name'] = $files['name'][$i];
            $_FILES['files']['type'] = $files['type'][$i];
            $_FILES['files']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['files']['error'] = $files['error'][$i];
            $_FILES['files']['size'] = $files['size'][$i];

            // condition check of upload file
            if (!$this->upload->do_upload('files')) {
              $data['error_inputs'][] = (object) ['name' => 'files', 'error' => "ไม่สามารถอัพโหลดไฟล์ดังกล่าวได้ เนื่องจากไฟล์อาจมีขนาดใหญ่เกินไปหรือเป็นชนิดของไฟล์ที่ไม่ถูกต้อง"];
            } else {
              $upload_data = array('upload_data' => $this->upload->data());
              $filenames[] = $upload_data['upload_data']['file_name'];
            }
          }
          // $count_doc++;
        }
      }
    }

    if (isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
      $data['status_response'] = $this->config->item('status_response_error');
      $data['message_dialog'] = $this->config->item('text_invalid_inputs');
    } else { // case success
      // $this->m_dim_examination_result->update();
      $this->m_dim_examination_result->update_exr();

      // m_dim_examination_result_doc
      $this->load->model('dim/m_dim_examination_result_doc');
      $this->m_dim_examination_result_doc->exrd_exr_id = $exr_id;

      // -- in future can update ex. file_name by check $this->input->post("exrd_ids")
      // 1. update exrd_status = 0 files that delete from client and have id (saved)
      if (!empty($exrd_ids)) {
        $exclude_ids = [];
        for ($i = 0; $i < count($exrd_ids); $i++) {
          if ($exrd_ids[$i] != 'undefined') {
            $id = decrypt_id($exrd_ids[$i]);
            if (!empty($id)) {
              $exclude_ids[] = $id;
            }
          }
        }
        if (!empty($exclude_ids)) {
          $exclude_ids_string = implode(',', $exclude_ids);
          $this->m_dim_examination_result_doc->update_delete_exclude_files($exclude_ids_string);
        }
      }

      // 2. insert to in dim_examination_result_doc_bin wait for delete (30 days)
      $files_delete = $this->m_dim_examination_result_doc->get_delete_files()->result_array();
      $this->load->model('dim/m_dim_examination_result_doc_bin');
      foreach ($files_delete as $file) {
        $this->m_dim_examination_result_doc_bin->exrdb_exrd_id = $file['exrd_id'];
        $this->m_dim_examination_result_doc_bin->exrdb_status = 0;

        // check have row in dim_examination_result_doc_bin before?
        $result = $this->m_dim_examination_result_doc_bin->get_by_key()->result_array();
        if (!$result) {
          $this->m_dim_examination_result_doc_bin->exrdb_expiration_date = (new DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
          $this->m_dim_examination_result_doc_bin->insert();
        }
        // else {
        // 	$this->m_dim_examination_result_doc_bin->update();
        // }
      }

      // 3. save new m_dim_examination_result_doc
      if (!empty($filenames) && !empty($old_filenames)) {
        $fileCount = count($filenames);
        for ($i = 0; $i < $fileCount; $i++) {
          $this->m_dim_examination_result_doc->exrd_file_name = $filenames[$i];
          $this->m_dim_examination_result_doc->exrd_old_file_name = $old_filenames[$i];
          $this->m_dim_examination_result_doc->exrd_status = 1;
          $this->m_dim_examination_result_doc->insert();
        }
      }

      // 4 AP 20240827 extra - if have files NAS before not from SeeDB but delete before save in db then save file with original names in SeeDB
      if ($handle = opendir($nas_target_folder)) {
        $nas_files = scandir($nas_target_folder);
        $nas_files = array_diff($nas_files, array('.', '..'));
        $docs = $this->m_dim_examination_result_doc->get_by_examination_result_id()->result_array();
        $docs_names = array_column($docs, 'exrd_file_name');
        $docs_old_names = array_column($docs, 'exrd_old_file_name');
        foreach ($nas_files as $file) {
          $path = $nas_target_folder . '/' . $file;
          if (file_exists($path)) {
            if(!in_array($file, $docs_old_names) && !in_array($file, $docs_names)) {
              $this->m_dim_examination_result_doc->exrd_file_name = $file;
              $this->m_dim_examination_result_doc->exrd_old_file_name = $file;
              $this->m_dim_examination_result_doc->exrd_status = 0;
              $this->m_dim_examination_result_doc->insert();
              // $exclude_ids[] = $this->m_dim_examination_result_doc->last_insert_id;
              
              $this->m_dim_examination_result_doc_bin->exrdb_exrd_id = $this->m_dim_examination_result_doc->last_insert_id;
              $this->m_dim_examination_result_doc_bin->exrdb_status = 0;
              $this->m_dim_examination_result_doc_bin->exrdb_expiration_date = (new DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
              $this->m_dim_examination_result_doc_bin->insert();
            }
          }
        }
      }

      /* Upload files to NAS 
			** Concept: copy file from SeeDB to NAS. now, dont unlink files from SeeDB
			*/

      // 0. Define variables
      $nas_server_ip = $this->config->item('dim_nas_ip');
      $nas_port = $this->config->item('dim_nas_port');
      $folder_tool = $equipment['eqs_folder'];
      $local_mount_point = $this->config->item('dim_nas_share_path') . $folder_tool; // must to have folder $local_mount_point before and runned command mount yet.

      // 1. Check if the NAS server is reachable
      $ping_command = "ping -c 1 $nas_server_ip";
      exec($ping_command, $output, $return_var);
      if ($return_var !== 0) {
        die("Failed to reach NAS server, code: $return_var, output: " . implode("\n", $output));
      }

      // 2. Check if local mount point directory exists
      if (!is_dir($local_mount_point)) {
        die("Local mount point directory does not exist: $local_mount_point");
      }

      // 3. Check if the target folder exists
      $destination_folder = $this->config->item('dim_nas_share_path') . $path_folder_patient;
      if (!is_dir($destination_folder)) {
        // 3.0 If the path contains spaces, wrap the path in double quotes for mkdir
        $destination_folder = '"' . $destination_folder . '"';
        // 3.1 Create the target folder if it doesn't exist
        $create_folder_command = "sudo mkdir -p \"$destination_folder\"";
        exec($create_folder_command, $output, $return_var);
        if ($return_var !== 0) {
          die("Failed to create folder: " . implode("\n", $output));
        }
        // else echo "Success create folder<br>";
      }
      // else echo "No have to create folder<br>";

      // 4. Loop files that uploaded for copy to nas
      if (!empty($filenames)) {
        for ($i = 0; $i < $fileCount; $i++) {
          // 4.1 Get each path source file
          $localFile = $pathuploads . $path_folder_patient . '/' . $filenames[$i];

          // 4.2 Check if localFile exists
          if (!file_exists($localFile)) {
            // [AP] 20240731 if have files from NAS before not from SeeDB then copy from NAS to SeeDB
            $nas_file_before_path = $destination_folder . '/' . $filenames[$i];
            if (file_exists($nas_file_before_path)) {
              $localPath = $pathuploads . $path_folder_patient;
              $cp_file_command = "sudo cp \"$nas_file_before_path\" \"$localPath\"";
              exec($cp_file_command, $output, $return_var);
              if ($return_var !== 0) {
                die("Failed to copy folder: " . implode("\n", $output));
              }
            } else {
              die("localFile does not exist: $localFile");
            }
          } else {
            $cp_file_command = "sudo cp \"$localFile\" \"$destination_folder\"";
            exec($cp_file_command, $output, $return_var);
            // if ($return_var !== 0) {
            //   die("Failed to copy folder: " . implode("\n", $output));
            // }
            // else echo "Success copy folder<br>";
          }
        }
      }
      // End connect NAS

      // [AMS] Update ams_notification_results.ntr_ast_id = 3
      // [QUE] Update que_appointment.apm_sta_id = 12
      if (!empty($exam_re_data->exr_ntr_id)) {
        // check if all examination results are success (no have some row exr_status= W) then update status of [AMS] and [WTS]
        $this->m_dim_examination_result->exr_ntr_id = $exam_re_data->exr_ntr_id;
        $amount_exr = $this->m_dim_examination_result->check_amount_by_ntr_id('W')->row();
        if ($amount_exr->amount_exr == 0) {
          $this->m_dim_examination_result->update_ams_ntr_ast_id();
          $this->m_dim_examination_result->update_wts_apm_sta_id();
        }
      }

      // [WTS] insert log timeline in wts_notifications_department
      $this->load->model('ams/m_ams_notification_result');
      $noti_result = $this->m_ams_notification_result->get_by_id($exam_re_data->exr_ntr_id)->row();
      if(!empty($noti_result)) {

        $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "7"');
        $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        $current_date = new DateTime();
        $ntdp_time_end = clone $current_date; // สำเนา object $current_date เพื่อใช้งานในส่วนอื่น
        $ntdp_time_end->modify('+' . $loc_time . ' minutes');

        $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "'.$noti_result->ntr_apm_id.'" ORDER BY ntdp_id DESC LIMIT 1');
        $ntdp_desc = $ntdp->row()->ntdp_apm_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        $ntdp_desc_id = $ntdp->row()->ntdp_id; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
        $ntdp_desc_seq = $ntdp->row()->ntdp_seq; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที

        // อัปเดตข้อมูลสำหรับ seq 1 ในตาราง wts_notifications_department 
        $ntdp_apm_id_1 = $ntdp_desc;  // ใช้ apm_id ที่ค้นพบได้
        $ntdp_seq_1 = $ntdp_desc_seq;
        $ntdp_date_end_1 =  date('Y-m-d');
        $ntdp_time_end_1 = date('H:i:s');
        $ntdp_sta_id_1 = '2';

        $wts_update_data = array(
          'ntdp_date_finish' => $ntdp_date_end_1,
          'ntdp_time_finish' => $ntdp_time_end_1,
          'ntdp_sta_id' => $ntdp_sta_id_1
        );

        $this->wts = $this->load->database('wts', TRUE);
        $this->wts_db = $this->wts->database;

        // ค้นหา ntdp_seq ที่มากที่สุดของ ntdp_apm_id ที่ตรงกัน
        $this->wts->select('ntdp_seq')
          ->from('wts_notifications_department')
          ->where('ntdp_apm_id', $ntdp_apm_id_1)
          ->order_by('ntdp_seq', 'DESC')
          ->limit(1);

          $query = $this->wts->get();

          if ($query->num_rows() > 0) {
            $latest_seq = $query->row()->ntdp_seq;
        
            // อัปเดตข้อมูลในแถวที่มี ntdp_apm_id และ ntdp_seq ล่าสุด
            $this->wts->where('ntdp_apm_id', $ntdp_apm_id_1);
            $this->wts->where('ntdp_seq', $latest_seq);
            $this->wts->update('wts_notifications_department', $wts_update_data);
            echo "Update successful.";
          } else {
              echo "No matching record found.";
          }
        $this->load->model('que/m_que_appointment');
        $appointment_dep_ft_id = $this->m_que_appointment->get_appointment_by_id($noti_result->ntr_apm_id)->result_array();
        // Update ข้อมูลในตาราง wts_notifications_department ที่มี seq = 1 และ apm_id ที่ตรงกัน
        switch ($appointment_dep_ft_id[0]['stde_name_th']) {
          case 'ภาคจักษุวิทยา (EYE)':
              $sending_location_room = $this->config->item('wts_room_ood');
              // $sending_location_room = 5;
              break;
          case 'ภาคโสต ศอ นาสิก (ENT)':
          // case 'แผนกผู้ป่วยนอกสูตินรีเวช':
          // case 'แผนกผู้ป่วยนอกอายุรกรรม':
          case 'จิตแพทย์':
              $sending_location_room = $this->config->item('wts_room_floor2');
              // $sending_location_room = 7;
              break;
          case 'ภาคทันตกรรม (DEN)':
              $sending_location_room = $this->config->item('wts_room_dd');
              // $sending_location_room = 10;
              break;
          case 'แผนกศูนย์เคลียร์เลสิค':
              $sending_location_room = $this->config->item('wts_room_rel');
              // $sending_location_room = 28;
              break;
          case 'ภาครังสีวิทยา (RAD)':
              $sending_location_room = '8';
              break;
          case 'แผนกเทคนิคการแพทย์':
            $sending_location_room = '14';
            break;
          default:
              $sending_location_room = '0'; // Default room, ensure you handle unexpected cases
              break;
        }

        $this->load->model('wts/m_wts_notifications_department');
        $this->m_wts_notifications_department->ntdp_apm_id = $noti_result->ntr_apm_id;
        $this->m_wts_notifications_department->ntdp_loc_id = 7; // ตรวจเครื่องมือ (สิ้นสุด)
        $this->m_wts_notifications_department->ntdp_seq = 7; // ตาม ntdp_loc_Id
        $this->m_wts_notifications_department->ntdp_date_start = date('Y-m-d');
        $this->m_wts_notifications_department->ntdp_time_start = date('H:i:s');
        $this->m_wts_notifications_department->ntdp_date_end = $ntdp_time_end->format('Y-m-d');
        $this->m_wts_notifications_department->ntdp_time_end = $ntdp_time_end->format('H:i:s');
        $this->m_wts_notifications_department->ntdp_sta_id = 2; // รอแจ้งเตือน
        $this->m_wts_notifications_department->ntdp_in_out = 0;
        $this->m_wts_notifications_department->ntdp_loc_ft_Id = $sending_location_room;
        $this->m_wts_notifications_department->ntdp_function = 'Import_examination_result_update';
        $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
        if(!empty($last_noti_dept)) {
            $this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
        } 
        $this->m_wts_notifications_department->insert();
      }
      
      $this->load->model('que/m_que_appointment');
      $sql_user = $this->m_que_appointment->get_user($this->session->userdata('us_ps_id'))->result_array();
      $appointment_dep = $this->m_que_appointment->get_appointment_by_id($noti_result->ntr_apm_id)->result_array();
      $pdo = $this->connect_his_database();
      
      // ตรวจสอบว่ามีข้อมูล visit อยู่ใน tabDoctorRoom หรือไม่
      $sql = "SELECT * FROM tabDoctorRoom WHERE visit = :visit";
      $check_visit = $pdo->prepare($sql);
      $check_visit->bindParam(':visit', $appointment_dep[0]['apm_visit']);
      $check_visit->execute();
      // echo $appointment_dep[0]['apm_visit']
      // pre($check_visit);
      // ถ้าไม่พบข้อมูล visit
      if ($check_visit->rowCount() == 0) {
        // Prepare SQL query outside the loop
        $sql = "INSERT INTO tabDoctorRoom (visit, sender_name, sender_last_name, sending_location_room, datetime_sent, doctor_room,location) 
        VALUES (:visit, :sender_name, :sender_last_name, :sending_location_room, :datetime_sent, :doctor_room, :location)";
        $stmt = $pdo->prepare($sql);
        
        // Get room data for the current room
        $location_room = $this->m_que_appointment->get_room_dep($exam_re_data->rm_id)->result_array();
        // $sql_room = $this->m_que_appointment->get_room_dep(decrypt_id($rm))->result_array();
      
        if (!empty($location_room)) {
            $datetime_sent = (new DateTime())->format('Y-m-d H:i:s');
            switch ($appointment_dep[0]['stde_name_th']) {
              case 'ภาคจักษุวิทยา (EYE)':
                  $sending_location_room = $this->config->item('wts_room_ood');
                  // $sending_location_room = 5;
                  break;
              case 'ภาคโสต ศอ นาสิก (ENT)':
              // case 'แผนกผู้ป่วยนอกสูตินรีเวช':
              // case 'แผนกผู้ป่วยนอกอายุรกรรม':
              case 'จิตแพทย์':
                  $sending_location_room = $this->config->item('wts_room_floor2');
                  // $sending_location_room = 7;
                  break;
              case 'ภาคทันตกรรม (DEN)':
                  $sending_location_room = $this->config->item('wts_room_dd');
                  // $sending_location_room = 10;
                  break;
              case 'แผนกศูนย์เคลียร์เลสิค':
                  $sending_location_room = $this->config->item('wts_room_rel');
                  // $sending_location_room = 28;
                  break;
              case 'ภาครังสีวิทยา (RAD)':
                  $sending_location_room = '8';
                  break;
              case 'แผนกเทคนิคการแพทย์':
                $sending_location_room = '14';
                break;
              default:
                  $sending_location_room = '0'; // Default room, ensure you handle unexpected cases
                  break;
            }

            // Binding parameters for each room
            $location = $this->session->userdata('us_dp_id');  
            $doctor_location_room = '26'; // ห้องเครื่องมือพิเศษ  
            $stmt->bindParam(':visit', $appointment_dep[0]['apm_visit']);
            $stmt->bindParam(':sender_name', $sql_user[0]['ps_fname']);
            $stmt->bindParam(':sender_last_name', $sql_user[0]['ps_lname']);
            $stmt->bindParam(':sending_location_room', $doctor_location_room);
            $stmt->bindParam(':datetime_sent', $datetime_sent);
            $stmt->bindParam(':doctor_room', $sending_location_room);
            $stmt->bindParam(':location', $location);
            
            // Execute the query for each room
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                // Handle exception if needed
                echo "Error: " . $e->getMessage();
            }
        }
      }
  




      // // Save Log

      $data['returnUrl'] = base_url() . 'index.php/dim/Import_examination_result';
      $data['status_response'] = $this->config->item('status_response_success');
    }

    $result = array('data' => $data);
    echo json_encode($result);
  }

  /*
	* Import_examination_result_cancel
	* for change status = cancel at examination result
	* @input exr_id (examination result id)
	* $output status response
	* @author Areerat Pongurai
	* @Create Date 11/06/2024
	*/
  public function Import_examination_result_cancel($exr_id)
  {
    $exr_id = decrypt_id($exr_id);
    
    $this->load->model('dim/m_dim_examination_result');
    $this->m_dim_examination_result->exr_id = $exr_id;
    $this->m_dim_examination_result->exr_status = 'C';
    $this->m_dim_examination_result->exr_update_user = $this->session->userdata('us_id');
    $this->m_dim_examination_result->update_status();

    if ($this->session->userdata('st_name_abbr_en') == 'WTS') {
        $response = [
          'status_response' => $this->config->item('status_response_success'),
        ];
        echo json_encode($response);
    } else {
      $data['returnUrl'] = base_url() . 'index.php/dim/Import_examination_result';
      $data['status_response'] = $this->config->item('status_response_success');

      $result = array('data' => $data);
      echo json_encode($result);
    }
    // $data['returnUrl'] = base_url() . 'index.php/dim/Import_examination_result';
    // $data['status_response'] = $this->config->item('status_response_success');

    // $result = array('data' => $data);
    // echo json_encode($result);
  }

  /*
	* Import_examination_result_get_structure_details
	* for get options structure details
	* @input department id: ไอดีหน่วยงาน
	* $output options structure details by department id
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
  public function Import_examination_result_get_structure_details()
  {
    $dp_id = $this->input->post('dp_id');
    $dp_id = decrypt_id($dp_id);

    $this->load->model('hr/structure/m_hr_structure_detail');
    $structure_details = $this->m_hr_structure_detail->get_all_by_level_from_dp_stuc($dp_id)->result_array();

    $names = ['stde_id']; // object name need to encrypt
    $structure_details = encrypt_arr_obj_id($structure_details, $names);

    if (!empty($structure_details) && count($structure_details) > 0) {
      echo "<option value=''>-----เลือก-----</option>";
      foreach ($structure_details as $key => $row) {
        echo "<option value='" . $row['stde_id'] . "'>" . $row['stde_name_th'] . "</option>";
      }
    }
  }

  /*
	* Import_examination_result_get_persons
	* for get options persons
	* @input structure details id: ไอดีฝ่าย/แผนก
	* $output options persons by structure details id
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
  public function Import_examination_result_get_persons()
  {
    // for exr_ps_id
    $stde_id = $this->input->post('exr_stde_id');
    $stde_id = decrypt_id($stde_id);

    $this->load->model('dim/m_dim_examination_result');
    $persons = $this->m_dim_examination_result->get_persons_by_structure($stde_id)->result_array();

    $names = ['ps_id']; // object name need to encrypt
    $persons = encrypt_arr_obj_id($persons, $names);

    if (!empty($persons) && count($persons) > 0) {
      echo "<option value=''>-----เลือก-----</option>";
      foreach ($persons as $key => $row) {
        echo "<option value='" . $row['ps_id'] . "'>" . $row['alp_name_abbr'] . $row['full_name'] . "</option>";
      }
    }
  }

  /*
	* Import_examination_result_get_equipments
	* for get options equipments
	* @input room id: ไอดีห้อง
	* $output options equipments by room id
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
  public function Import_examination_result_get_equipments()
  {
    $rm_id = $this->input->post('rm_id');

    $rm_id = decrypt_id($rm_id);

    $this->load->model('eqs/m_eqs_equipments');
    $order = array('eqs_name' => 'ASC');
    $this->m_eqs_equipments->eqs_rm_id = $rm_id;
    $equipments = $this->m_eqs_equipments->get_tools_by_room_id($order)->result_array();

    $names = ['eqs_id']; // object name need to encrypt
    $equipments = encrypt_arr_obj_id($equipments, $names);

    if (!empty($equipments) && count($equipments) > 0) {
      echo "<option value=''>-----เลือก-----</option>";
      foreach ($equipments as $key => $row) {
        echo "<option value='" . $row['eqs_id'] . "'>" . $row['eqs_name'] . "</option>";
      }
    }
  }

  /*
	* Import_examination_result_check_round
	* for check last round of patient that come in hospital
	* @input 
		exr_pt_id (patient id): ไอดีผู้ป่วย
	* $output last round of patient that come in hospital
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	* @Update Date 15/07/2024 Areerat Pongurai - Not use, will delete
	*/
  public function Import_examination_result_check_round()
  {
    $exr_pt_id = $this->input->post('exr_pt_id');

    $exr_pt_id = decrypt_id($exr_pt_id);

    $this->load->model('dim/m_dim_examination_result');
    $this->m_dim_examination_result->exr_pt_id = $exr_pt_id;
    $this->m_dim_examination_result->exr_inspection_time = $this->input->post('exr_inspection_time');
    $max_exr_round = $this->m_dim_examination_result->get_check_round_by_patient_id()->result_array();

    if (!empty($max_exr_round) && count($max_exr_round) == 1)
      echo $max_exr_round[0]['max_round'];
  }

  // ------------------ For File in Saerver ------------------

  /*
	* Import_examination_result_get_file_details
	* get file details
	* @input file path
	* $output details of file
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
  private function Import_examination_result_get_file_details($filePath)
  {
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

  /*
	* Import_examination_result_delete_folder
	* delete folder by path
	* @input directory path
	* $output boolean status
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
  private function Import_examination_result_delete_folder($dir)
  {
    if (!file_exists($dir)) {
      return true;
    }

    if (!is_dir($dir)) {
      return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') {
        continue;
      }

      if (!$this->Import_examination_result_delete_folder($dir . DIRECTORY_SEPARATOR . $item)) {
        return false;
      }
    }

    return rmdir($dir);
  }
}
