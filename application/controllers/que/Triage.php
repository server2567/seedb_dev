<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Triage extends QUE_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('encryption');
  }

  function index()
  {
    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
    $data['status_response'] = $this->config->item('status_response_show');;
    $this->load->model('que/M_que_appointment');
    $appointments = $this->M_que_appointment->get_appointment()->result_array();
    foreach ($appointments as &$apm) {
      $apm['apm_id'] = encrypt_id($apm['apm_id']);
    }

    $data['get_apm'] = $appointments;
    $data['count_apm'] = $this->M_que_appointment->get_appointment_count(NULL);
    $data['get_structure_detail'] = $this->M_que_appointment->get_structure_detail()->result_array();
    $data['get_patient'] = $this->M_que_appointment->get_patient()->result_array();
    $data['get_doctors'] = $this->M_que_appointment->get_doctors_by_department()->result_array();

    $this->output('que/triage/v_triage_show', $data);
  }
  public function structure_list_and_priority_list()
  {
    $this->load->model('que/M_que_appointment');
    $structure = $this->M_que_appointment->get_structure_detail()->result_array();
    $priority = $this->M_que_appointment->get_all_priority()->result_array();

    $response = [
      'status' => 'success',
      'structure' => $structure,
      'priority' => $priority
    ];
    echo json_encode($response);
  }
  public function get_appointment_by_id($apm_id)
  {
    $apm_id = decrypt_id($apm_id);
    $this->load->model('que/M_que_appointment');
    $apm_stde_id = $this->M_que_appointment->get_stde_id_by_apm_id($apm_id)->result_array();
    $apm_stde_id[0]['apm_date'] = $this->convertToThaiDate_($apm_stde_id[0]['apm_date']);
    $response = [
      'status' => 'success',
      'appointmentData' => $apm_stde_id

    ];
    echo json_encode($response);
  }
  public function get_patient()
  {
    try {
      $draw = intval($this->input->post('draw'));
      $start = intval($this->input->post('start'));
      $length = intval($this->input->post('length'));
      if (empty($this->input->post('patientName'))) {
        $length = 0;
      }


      $search = $this->input->post('search')['value'];
      $patientName = $this->input->post('patientName'); // Get the patientName from DataTable's ajax data

      if (empty($search)) {
        $search = NULL;
      }

      $order_column_index = isset($this->input->post('order')[0]['column']) ? $this->input->post('order')[0]['column'] : 0;
      $order_dir = isset($this->input->post('order')[0]['dir']) ? $this->input->post('order')[0]['dir'] : 'asc';

      $columns = array(
        "row_number",
        "pt_prefix",
        "pt_fname",
        "pt_lname",
        "pt_id"
      );

      $order_column = isset($columns[$order_column_index]) ? $columns[$order_column_index] : 'pt_id';

      $this->load->model('que/M_que_appointment');

      $searchParams = array(
        'patientName' => $patientName,
        'search' => $search,
      );

      $appointments = $this->M_que_appointment->get_patient_paginated($start, $length, $order_column, $order_dir, $searchParams);
      $total_appointments_result = $this->M_que_appointment->get_patient_count($searchParams);
      $total_appointments = $total_appointments_result->appointment_count;
      if (empty($this->input->post('patientName'))) {
        $total_appointments = 0;
      }
      $data = array();
      foreach ($appointments as $key => $apm) {
        $identification = '';
        if (!empty($apm['pt_identification'])) {
            $identification = $apm['pt_identification'];
        } elseif (!empty($apm['pt_passport'])) {
            $identification = $apm['pt_passport'];
        } elseif (!empty($apm['pt_peregrine'])) {
            $identification = $apm['pt_peregrine'];
        }

        $data[] = array(
          "row_number" => intval($start) + intval($key) + 1,
          "pt_identification" => $identification,
          "pt_prefix" => $apm['pt_prefix'],
          "pt_fname" => $apm['pt_fname'],
          "pt_lname" => $apm['pt_lname'],
          "pt_tel" => $apm['pt_tel'],
          "pt_email" => $apm['pt_email'],
          "pt_id" => encrypt_id($apm['pt_id']) // Assuming you need to encrypt ID for your view
        );
      }

      $response = array(
        "draw" => $draw,
        "recordsTotal" => intval($total_appointments),
        "recordsFiltered" => intval($total_appointments),
        "data" => $data
      );

      echo json_encode($response);
    } catch (Exception $e) {
      // Log the exception and return a generic error message
      log_message('error', $e->getMessage());
      echo json_encode(array("error" => "An error occurred"));
    }
  }
  public function get_appointments()
  {
    try {
      $draw = intval($this->input->post('draw'));
      $start = intval($this->input->post('start'));
      $length = intval($this->input->post('length'));
      $search = $this->input->post('search')['value'];
      if (empty($search)) {
        $search = NULL;
      }
      $order_column_index = isset($this->input->post('order')[0]['column']) ? $this->input->post('order')[0]['column'] : 0;
      $order_dir = isset($this->input->post('order')[0]['dir']) ? $this->input->post('order')[0]['dir'] : 'asc';

      $columns = array(
        "row_number",
        "pt_member",
        "apm_visit",
        "apm_ql_code",
        "pt_name",
        "stde_name_th",
        "ps_name",
        "apm_create_date",
        "apm_id"
      );

      $order_column = isset($columns[$order_column_index]) ? $columns[$order_column_index] : 'row_number';

      $this->load->model('que/M_que_appointment');

      $searchParams = array(
        'date' => $this->input->post('date'),
        'month' => $this->input->post('month'),
        'department' => $this->input->post('department'),
        'doctor' => $this->input->post('doctor'),
        'patientId' => $this->input->post('patientId'),
        'patientName' => $this->input->post('patientName'),
        'search' => $search,
        'update_date' => $this->input->post('update_date')
      );

      $appointments = $this->M_que_appointment->get_appointments_paginated_triage($start, $length, $order_column, $order_dir, $searchParams);
      $total_appointments_result = $this->M_que_appointment->get_appointment_count_triage($searchParams);
      $total_appointments = $total_appointments_result->appointment_count;

      $data = array();
      foreach ($appointments as $key => $apm) {
        $data[] = array(
          "row_number" => $start + $key + 1,
          "pt_member" => $apm['pt_member'],
          "apm_visit" => $apm['apm_visit'],
          "apm_ql_code" => $apm['apm_ql_code'],
          "stde_name_th" => $apm['stde_name_th'],
          "pt_name" => $apm['pt_name'],
          // "apm_date" => convertToThaiYear($apm['apm_date'], false), //abbreDate2($apm['apm_date'])
          // "apm_time" => $apm['apm_time'],
          "ps_name" => $apm['ps_name'],
          "apm_create_date" => convertToThaiYear($apm['apm_create_date']),
          "apm_update_date" => convertToThaiYear($apm['apm_update_date']), //
          "apm_id" => encrypt_id($apm['apm_id']),
          "apm_pri_id" => $apm['apm_pri_id'],
          "apm_patient_type" => $apm['apm_patient_type'],
          "apm_app_walk" => $apm['apm_app_walk']
        );
      }

      $response = array(
        "draw" => $draw,
        "recordsTotal" => intval($total_appointments),
        "recordsFiltered" => intval($total_appointments),
        "data" => $data,
        "totalAppointments" => intval($total_appointments)
      );

      echo json_encode($response);
    } catch (Exception $e) {
      // Log the exception and return a generic error message
      log_message('error', $e->getMessage());
      echo json_encode(array("error" => "An error occurred"));
    }
  }
  public function search()
  {
    $this->load->model('que/M_que_appointment');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $searchParams = array(
      'date' => $data['date'] ?? '',
      'month' => $data['month'] ?? '',
      'department' => $data['department'] ?? '',
      'doctor' => $data['doctor'] ?? '',
      'patientId' => $data['patientId'] ?? '',
      'patientName' => $data['patientName'] ?? '',
    );
    $result = $this->M_que_appointment->search_appointments($searchParams, $this->session->userdata('us_ps_id'));
    foreach ($result as &$apm) {
      $apm['apm_id'] = encrypt_id($apm['apm_id']);
    }

    echo json_encode(array('appointments' => $result));
  }
  public function add_appointment($appointment_id = '')
  {
    // $decoded_data = $this->jwthandler->decode($appointment_id);
    $data['appointment_id'] = $appointment_id;
    $appointment_id = decrypt_id($appointment_id);
    $this->load->model('hr/base/M_hr_prefix');
    $this->load->model('wts/M_wts_base_disease');
    $this->load->model('que/M_que_appointment');
    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb

    $data['get_base_noti'] = $this->M_que_appointment->get_base_noti()->result_array();
    $data['get_prefix'] = $this->M_hr_prefix->get_prefix_all()->result_array();
    $data['get_department'] = $this->M_que_appointment->get_department()->result_array();
    $data['get_disease'] = $this->M_wts_base_disease->get_all_disease_name_type()->result_array();
    $data['get_structure_detail'] = $this->M_que_appointment->get_structure_detail()->result_array();
    $data['get_person_med'] = $this->M_que_appointment->get_person_med()->result_array();

    if ($appointment_id) {
      $get_appointment = $data['get_appointment'] = $this->M_que_appointment->get_appointment_by_id($appointment_id)->row_array();
      $data['get_doctors'] = $this->M_que_appointment->get_doctors_by_department($get_appointment['apm_stde_id'])->result_array();
      $data['get_disease_dp'] = $this->M_que_appointment->get_diseases_by_department($get_appointment['apm_stde_id']);

      // pre($data['get_doctors'] ); die;
    }
    $this->output('que/triage/v_triage_form', $data);
  }
  public function send_que_to_patient_by_api($apm_id)
  {
    
    $api_url = 'https://dev-seedb.aos.in.th/index.php/email/Sendemail/send_que_to_patient';
    // $headers = array(
    //   "Authorization: Bearer $jwt",
    //   "Content-Type: application/json",
    // );

    $data = array(
      'ap_id' => $apm_id
      // Add more key-value pairs as needed
    );
    // Convert the data array to JSON
    $json_data = json_encode($data);
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'cURL Error: ' . curl_error($ch);
    } else {
      // Print or handle the response
      // echo 'Response: ' . $response;
    }
    curl_close($ch);
  }
  public function add_appointment_step2($appointment_id = '')
  {
    $this->load->model('que/M_que_appointment');
    $json = file_get_contents('php://input');
    $post_data = json_decode($json, true);
    if ($post_data) {
      $check =  $post_data[0]['check'];
    }
    if ($appointment_id) {
      $appointment_id = decrypt_id($appointment_id);
      if (isset($check)) {
        $api_url = 'https://dev-seedb.aos.in.th/index.php/email/Sendemail/send_que_to_patient';
        // $headers = array(
        //   "Authorization: Bearer $jwt",
        //   "Content-Type: application/json",
        // );

        $ap_data = array(
          'ap_id' => $appointment_id
          // Add more key-value pairs as needed
        );
        // Convert the data array to JSON
        $json_data = json_encode($ap_data);
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response_mail = curl_exec($ch);

        if (curl_errno($ch)) {
          echo 'cURL Error: ' . curl_error($ch);
        } else {
          // Print or handle the response
          // echo 'Response: ' . $response;
        }
        curl_close($ch);
      }
      $data['get_base_noti'] = $this->M_que_appointment->get_base_noti()->result_array();
      $data['get_appointment'] = $this->M_que_appointment->get_appointment_by_id($appointment_id)->row_array();
      $data['get_appointment_by_visit'] = $this->M_que_appointment->get_appointment_by_visit($data['get_appointment']['apm_visit'])->result_array();

      $notificationName = '-';


      // Iterate through get_base_noti to find a matching ntf_id
      foreach ($data['get_base_noti'] as $notification) {
        if ($data['get_appointment']['apm_ntf_id'] == $notification['ntf_id']) {
          $notificationName = $notification['ntf_name'];
          break; // Exit loop once a match is found
        }
      }
      
      $data['notification_name'] = $notificationName;
      if (isset($data['get_appointment']['apm_id'])) {
        $data['get_appointment']['apm_id'] = encrypt_id($data['get_appointment']['apm_id']);
      }
    }

    $this->output('que/appointment/v_appointment_form_step2', $data);
  }
  private function roundToNearest30Minutes($time)
  {
    $timestamp = strtotime($time);
    $minutes = date('i', $timestamp);

    if ($minutes < 30) {
      $rounded_time = date('H:00', $timestamp);
    } elseif ($minutes <= 59) {
      $rounded_time = date('H:30', $timestamp);
    } else {
      $rounded_time = date('H:00', $timestamp);
    }

    return $rounded_time;
  }
  public function convertToThaiDate($buddhist_date)
  {
    // Convert from dd/mm/yyyy (Buddhist year) to Y-m-d (Gregorian year)
    list($day, $month, $buddhist_year) = explode('/', $buddhist_date);
    $gregorian_year = $buddhist_year - 543;
    return $gregorian_year . '-' . $month . '-' . $day;
  }
  public function convertToThaiDate_($buddhist_date)
  {
    $months = [
      "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม",
      "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน",
      "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน",
      "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"
    ];

    list($buddhist_year, $month, $day) = explode('-', $buddhist_date);
    $thai_year = $buddhist_year + 543;
    $thai_month = $months[$month];

    return $day . ' ' . $thai_month . ' ' . $thai_year;
  }
  public function check_time_dpid()
  {
    $this->load->model('que/M_que_appointment');
    $dp_id = $this->input->post('dp_id');
    $day_name = $this->input->post('day_name');
    $apm_date = $this->input->post('apm_date');
    $apm_date = $this->convertToThaiDate($apm_date);
    $times = $this->M_que_appointment->get_department_times($dp_id, $day_name);

    // pre($times);
    if ($times !== false) {
      $current_date = date('Y-m-d');
      $current_time = date('H:i');
      if ($apm_date == $current_date) {
        foreach ($times as &$time) {
          $rounded_time = $this->roundToNearest30Minutes($current_time);
          $time['dpt_time_start_1'] = $rounded_time;
          $time['dpt_time_start_2'] = $rounded_time;
        }
      }
      echo json_encode(['times' => $times]);
    } else {
      echo json_encode(['error' => 'ไม่มีเวลานัดหมายสำหรับวันนี้']);
    }
  }

  public function get_doctors()
  {
    $this->load->model('que/M_que_appointment');
    if ($this->input->is_ajax_request()) {
      $stde_id = $this->input->post('stde_id');
      $show_all = $this->input->post('show_all') == 'true';
      $doctors = $this->M_que_appointment->get_doctors_by_department($stde_id, $show_all)->result_array();
      
      echo json_encode($doctors);
    } else {
      echo json_encode(['error' => 'ไม่มีตารางออกตรวจแพทย์']);
    }
  }

  public function insert_appointment_api()
  {

    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');


    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    // $idCard = $data['idCard'];
    $idCard = $data['idCard'];
    // echo $idCard; die;
    $prefix = $data['prefix'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $phoneNumber = $data['phoneNumber'];
    $email = isset($data['email']) ? $data['email'] : '';
    // $password = password_hash("O]O" . $phoneNumber . "O[O", PASSWORD_BCRYPT);
    // $password_confirm = password_hash("O]O" . $phoneNumber . "O[O", PASSWORD_BCRYPT);
    // pre($idCard); die;

    // $existingPatient = $this->M_que_appointment->check_patient_by_identification($idCard)->row_array();

    // if (empty($existingPatient)) {
    //   $insertId = $this->M_que_appointment->insert_patient($idCard, $password, $password_confirm, $prefix, $firstName, $lastName, $phoneNumber, $email);
      
    //   $patiet = $this->M_que_appointment->get_patient_by_id($insertId)->row_array();
    //   $response = array('message' => 'Data saved successfully', 'insert_id' => $insertId);
    // } else {
      $existingPatientArray = $this->M_que_appointment->check_patient_by_identification_array($idCard)->row_array();
      $patiet = $this->M_que_appointment->get_patient_by_id($existingPatientArray['pt_id'])->row_array();
      // $this->M_que_appointment->update_patient($idCard, $prefix, $firstName, $lastName, $phoneNumber, $email, $patiet);
      $response = array('message' => 'Data already exists in database', 'insert_id' => $existingPatientArray['pt_id']);
    // }

    $patiet = $patiet['pt_id'];
    $apm_patient_type = $data['gridRadios'];
    $apm_dp_id = $data['apm_dp_id'];
    $apm_date = $data['apm_date'];
    $apm_ntf_id = isset($data['notification']) ? $data['notification'] : 1;
    $apm_date = splitDateForm1($apm_date);

    $apm_time = $data['apm_time'];
    list($start_time, $end_time) = explode(" - ", $data['apm_time']);

    // Convert date and times to DateTime objects
    $appointment_start = DateTime::createFromFormat('Y-m-d H:i', $apm_date . ' ' . $start_time);
    $appointment_end = DateTime::createFromFormat('Y-m-d H:i', $apm_date . ' ' . $end_time);
    $current_date_time = new DateTime();
    // Check if the current date matches the appointment date
    if ($appointment_start && $appointment_end) {
      // Check if the current date matches the appointment date
      if ($current_date_time->format('Y-m-d') === $appointment_start->format('Y-m-d')) {
        // Compare current time with the appointment time range
        if ($current_date_time >= $appointment_start && $current_date_time <= $appointment_end) {
          $apm_pri_id = 5;
        } else {
          $apm_pri_id = 4;
        }
      } else {
        $apm_pri_id = 4;
      }
    } else {
      echo "Failed to create DateTime objects. Please check the date and time formats.";
    }

    $apm_ds_id = $data['apm_ds_id'];
    $apm_stde_id = $data['apm_stde_id'];
    $apm_cause = $data['apm_cause'];
    // $apm_need = $data['apm_need'];
    $apm_need = '';
    $apm_ps_id = $data['apm_ps_id'];
    $apm_create_user = $this->session->userdata('us_id');
    // pre($data['appointment_id']);
    // if (isset($data['appointment_id']) && !empty($data['appointment_id'])) {
      // Update existing appointment

      $tracking_department = $this->M_que_appointment->get_tracking_department($apm_stde_id)->row_array();
      $tracking = request_number($tracking_department['dpk_keyword']);

      $cl_id = $this->M_que_code_list->get_by_track_code($tracking)->row_array();
      $apm_cl_id = $cl_id['cl_id'];
      $apm_cl_code = $tracking;

      $appointmentId = decrypt_id($data['appointment_id']);
      $Log = $this->M_wts_base_route_department->get_rdp_id_and_rt_dst_id($apm_ds_id)->row_array();
      $ntdp_id = $this->M_wts_notifications_department->get_ntdp_id($appointmentId)->row_array();

      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_rdp_id = $Log['rdp_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_rdp_id = NULL;
      }

      if ($apm_ds_id == 0) {
        $this->M_wts_notifications_department->ntdp_ds_id = NULL;
      } else {
        $this->M_wts_notifications_department->ntdp_ds_id = $apm_ds_id;
      }
      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_dst_id = $Log['rt_dst_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_dst_id =  NULL;
      }
      $this->M_wts_notifications_department->ntdp_apm_id = $appointmentId;
      $this->M_wts_notifications_department->ntdp_seq = 1;
      $this->M_wts_notifications_department->ntdp_date_start = $apm_date;
      $this->M_wts_notifications_department->ntdp_time_start = $apm_time;
      $this->M_wts_notifications_department->ntdp_sta_id = 1;
      $this->M_wts_notifications_department->ntdp_id = $ntdp_id;
      $this->M_wts_notifications_department->insert();
      $this->M_que_appointment->update_patient($idCard, $prefix, $firstName, $lastName, $phoneNumber, $email, $patiet);
      $this->M_que_appointment->update_appointment_api($appointmentId, $apm_cl_id, $apm_ntf_id, $apm_cl_code, $apm_pri_id, $patiet, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user,$apm_sta_id = 2);
      $apm_id = escapeshellarg($appointmentId);
      $command = "php " . FCPATH . "index.php que/Appointment send_que_to_patient_by_api {$apm_id} > /dev/null 2>&1 &";
      exec($command);
      $line_data = array(
        "msst_id" => 1,
        "pt_id" => 208,
        "apm_cl_code" => 50
       );
     
       $url_service_line = site_url()."/".$this->config->item('line_service_dir')."send_message_que_to_patient";
       get_url_line_service($url_service_line, $line_data); // Line helper
      // $this->send_que_to_patient_by_api($appointmentId);
      $response['appointment_id'] = $appointmentId;
      $response['message'] = 'created';
    // } else {
    //   // Insert new appointment
    //   $tracking_department = $this->M_que_appointment->get_tracking_department($apm_stde_id)->row_array();

    //   $tracking = request_number($tracking_department['dpk_keyword']);

    //   $cl_id = $this->M_que_code_list->get_by_track_code($tracking)->row_array();
    //   $apm_cl_id = $cl_id['cl_id'];
    //   $apm_cl_code = $tracking;
    //   $appointmentId = $this->M_que_appointment->insert_appointment($patiet, $apm_cl_id, $apm_ntf_id, $apm_cl_code, $apm_pri_id, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user);
    //   $Log = $this->M_wts_base_route_department->get_rdp_id_and_rt_dst_id($apm_ds_id)->row_array();


    //   if (!empty($Log)) {
    //     $this->M_wts_notifications_department->ntdp_rdp_id = $Log['rdp_id'];
    //   } else {
    //     $this->M_wts_notifications_department->ntdp_rdp_id = NULL;
    //   }

    //   if ($apm_ds_id == 0) {
    //     $this->M_wts_notifications_department->ntdp_ds_id = NULL;
    //   } else {
    //     $this->M_wts_notifications_department->ntdp_ds_id = $apm_ds_id;
    //   }
    //   if (!empty($Log)) {
    //     $this->M_wts_notifications_department->ntdp_dst_id = $Log['rt_dst_id'];
    //   } else {
    //     $this->M_wts_notifications_department->ntdp_dst_id =  NULL;
    //   }
    //   $this->M_wts_notifications_department->ntdp_apm_id = $appointmentId;
    //   $this->M_wts_notifications_department->ntdp_seq = 1;
    //   $this->M_wts_notifications_department->ntdp_date_start = $apm_date;
    //   $this->M_wts_notifications_department->ntdp_time_start = $apm_time;
    //   $this->M_wts_notifications_department->ntdp_sta_id = 1;
    //   $this->M_wts_notifications_department->insert();
    //   $response['appointment_id'] = encrypt_id($appointmentId);
    //   $response['message'] = 'created';
    // }

    // $tracking_department = $this->M_que_appointment->get_tracking_department($apm_stde_id)->result_array();
    // $tracking = request_number($tracking_department[0]['dpk_keyword']);
    // $cl_id = $this->M_que_code_list->get_by_track_code($tracking)->result_array();
    // $apm_cl_id = $cl_id[0]['cl_id']; // เลขนัดหมาย
    // $apm_cl_code = $tracking; // เลขนัดหมาย


    // $appointmentId  = $this->M_que_appointment->insert_appointment($patiet,$apm_cl_id,$apm_cl_code, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user);
    // พรุ่งนี้ทำ check updata

    echo json_encode($response);
  }


  public function insert_appointment() // ปิดการใช้งาน อันนี้ใช้สำหรับการเพิ่มนัดหมายจากระบบ Patiya 12/08/2567
  {

    $this->load->model('que/M_que_appointment');
    $this->load->model('wts/M_wts_notifications_department');
    $this->load->model('que/M_que_code_list');
    $this->load->model('wts/M_wts_base_route_department');


    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    // $idCard = $data['idCard'];
    $idCard = $data['idCard'];
    $prefix = $data['prefix'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $phoneNumber = $data['phoneNumber'];
    $email = isset($data['email']) ? $data['email'] : '';
    $password = password_hash("O]O" . $phoneNumber . "O[O", PASSWORD_BCRYPT);
    $password_confirm = password_hash("O]O" . $phoneNumber . "O[O", PASSWORD_BCRYPT);
    // pre($idCard); die;

    $existingPatient = $this->M_que_appointment->check_patient_by_identification($idCard)->row_array();

    if (empty($existingPatient)) {

      $insertId = $this->M_que_appointment->insert_patient($idCard, $password, $password_confirm, $prefix, $firstName, $lastName, $phoneNumber, $email);
      
      $patiet = $this->M_que_appointment->get_patient_by_id($insertId)->row_array();
      $response = array('message' => 'Data saved successfully', 'insert_id' => $insertId);
    } else {

      $existingPatientArray = $this->M_que_appointment->check_patient_by_identification_array($idCard)->row_array();
      $patiet = $this->M_que_appointment->get_patient_by_id($existingPatientArray['pt_id'])->row_array();
      $this->M_que_appointment->update_patient($idCard, $prefix, $firstName, $lastName, $phoneNumber, $email, $patiet);
      $response = array('message' => 'Data already exists in database', 'insert_id' => $existingPatientArray['pt_id']);
    }

    $patiet = $patiet['pt_id'];
    $apm_patient_type = $data['gridRadios'];
    $apm_dp_id = $data['apm_dp_id'];
    $apm_date = $data['apm_date'];
    $apm_ntf_id = isset($data['notification']) ? $data['notification'] : 1;
    $apm_date = splitDateForm1($apm_date);

    $apm_time = $data['apm_time'];
    list($start_time, $end_time) = explode(" - ", $data['apm_time']);

    // Convert date and times to DateTime objects
    $appointment_start = DateTime::createFromFormat('Y-m-d H:i', $apm_date . ' ' . $start_time);
    $appointment_end = DateTime::createFromFormat('Y-m-d H:i', $apm_date . ' ' . $end_time);
    $current_date_time = new DateTime();
    // Check if the current date matches the appointment date
    if ($appointment_start && $appointment_end) {
      // Check if the current date matches the appointment date
      if ($current_date_time->format('Y-m-d') === $appointment_start->format('Y-m-d')) {
        // Compare current time with the appointment time range
        if ($current_date_time >= $appointment_start && $current_date_time <= $appointment_end) {
          $apm_pri_id = 1;
          $apm_app_walk = 'W';
        } else {
          $apm_pri_id = 1;
          $apm_app_walk = 'A';
        }
      } else {
        $apm_pri_id = 1;
        $apm_app_walk = 'A';
      }
    } else {
      echo "Failed to create DateTime objects. Please check the date and time formats.";
    }

    $apm_ds_id = $data['apm_ds_id'];
    $apm_stde_id = $data['apm_stde_id'];
    $apm_cause = $data['apm_cause'];
    // $apm_need = $data['apm_need'];
    $apm_need = '';
    $apm_ps_id = $data['apm_ps_id'];
    $apm_create_user = $this->session->userdata('us_id');
    if (isset($data['appointment_id']) && !empty($data['appointment_id'])) {
      // Update existing appointment
      
      
      $appointmentId = decrypt_id($data['appointment_id']);
      $apm_app_walk = $this->M_que_appointment->get_app_walk($appointmentId);
      $Log = $this->M_wts_base_route_department->get_rdp_id_and_rt_dst_id($apm_ds_id)->row_array();
      $ntdp_id = $this->M_wts_notifications_department->get_ntdp_id($appointmentId)->row_array();

      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_rdp_id = $Log['rdp_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_rdp_id = NULL;
      }

      if ($apm_ds_id == 0) {
        $this->M_wts_notifications_department->ntdp_ds_id = NULL;
      } else {
        $this->M_wts_notifications_department->ntdp_ds_id = $apm_ds_id;
      }
      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_dst_id = $Log['rt_dst_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_dst_id =  NULL;
      }
      $this->M_wts_notifications_department->ntdp_apm_id = $appointmentId;
      $this->M_wts_notifications_department->ntdp_seq = 1;
      $this->M_wts_notifications_department->ntdp_date_start = $apm_date;
      $this->M_wts_notifications_department->ntdp_time_start = $apm_time;
      $this->M_wts_notifications_department->ntdp_sta_id = 1;
      $this->M_wts_notifications_department->ntdp_id = $ntdp_id;
      $this->M_wts_notifications_department->update();
      $this->M_que_appointment->update_patient($idCard, $prefix, $firstName, $lastName, $phoneNumber, $email, $patiet);
      $this->M_que_appointment->update_appointment($appointmentId,$apm_app_walk, $apm_ntf_id, $apm_pri_id, $patiet, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user,$apm_sta_id = 2);
      $apm_id = escapeshellarg($appointmentId);
      $command = "php " . FCPATH . "index.php que/Appointment send_que_to_patient_by_api {$apm_id} > /dev/null 2>&1 &";
      exec($command);
      $line_data = array(
        "msst_id" => 1,
        "pt_id" => 208,
        "apm_cl_code" => 50
       );
     
       $url_service_line = site_url()."/".$this->config->item('line_service_dir')."send_message_que_to_patient";
       get_url_line_service($url_service_line, $line_data); // Line helper
      $response['appointment_id'] = $appointmentId;
      $response['message'] = 'updated';
    } else {
      // Insert new appointment
      $tracking_department = $this->M_que_appointment->get_tracking_department($apm_stde_id)->row_array();

      $tracking = request_number($tracking_department['dpk_keyword']);

      $cl_id = $this->M_que_code_list->get_by_track_code($tracking)->row_array();
      $apm_cl_id = $cl_id['cl_id'];
      $apm_cl_code = $tracking;
      $appointmentId = $this->M_que_appointment->insert_appointment($patiet,$apm_app_walk, $apm_cl_id, $apm_ntf_id, $apm_cl_code, $apm_pri_id, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user);
      $Log = $this->M_wts_base_route_department->get_rdp_id_and_rt_dst_id($apm_ds_id)->row_array();


      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_rdp_id = $Log['rdp_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_rdp_id = NULL;
      }

      if ($apm_ds_id == 0) {
        $this->M_wts_notifications_department->ntdp_ds_id = NULL;
      } else {
        $this->M_wts_notifications_department->ntdp_ds_id = $apm_ds_id;
      }
      if (!empty($Log)) {
        $this->M_wts_notifications_department->ntdp_dst_id = $Log['rt_dst_id'];
      } else {
        $this->M_wts_notifications_department->ntdp_dst_id =  NULL;
      }
      $this->M_wts_notifications_department->ntdp_apm_id = $appointmentId;
      $this->M_wts_notifications_department->ntdp_seq = 1;
      $this->M_wts_notifications_department->ntdp_date_start = $apm_date;
      $this->M_wts_notifications_department->ntdp_time_start = $apm_time;
      $this->M_wts_notifications_department->ntdp_sta_id = 1;
      $this->M_wts_notifications_department->insert();
      $apm_id = escapeshellarg($appointmentId);
      $command = "php " . FCPATH . "index.php que/Appointment send_que_to_patient_by_api {$apm_id} > /dev/null 2>&1 &";
      exec($command);
      $line_data = array(
        "msst_id" => 1,
        "pt_id" => 208,
        "apm_cl_code" => 50
       );
     
       $url_service_line = site_url()."/".$this->config->item('line_service_dir')."send_message_que_to_patient";
       get_url_line_service($url_service_line, $line_data); // Line helper
      $response['appointment_id'] = encrypt_id($appointmentId);
      $response['message'] = 'created';
    }

    // $tracking_department = $this->M_que_appointment->get_tracking_department($apm_stde_id)->result_array();
    // $tracking = request_number($tracking_department[0]['dpk_keyword']);
    // $cl_id = $this->M_que_code_list->get_by_track_code($tracking)->result_array();
    // $apm_cl_id = $cl_id[0]['cl_id']; // เลขนัดหมาย
    // $apm_cl_code = $tracking; // เลขนัดหมาย


    // $appointmentId  = $this->M_que_appointment->insert_appointment($patiet,$apm_cl_id,$apm_cl_code, $apm_date, $apm_time, $apm_ps_id, $apm_stde_id, $apm_ds_id, $apm_patient_type, $apm_cause, $apm_need, $apm_dp_id, $apm_create_user);
    // พรุ่งนี้ทำ check updata

    echo json_encode($response);
  }

  public function Referral($appointment_id)
  {
    $this->load->model('que/M_que_appointment');
    $this->load->model('que/M_que_queue_list');
    $appointment_id = decrypt_id($appointment_id);
    $input = $this->input->post();

    $this->M_que_appointment->update_appointment_stde_id($appointment_id, $input['stde_id']);

    $get_appointment = $this->M_que_appointment->get_appointment_by_id($appointment_id)->row_array();

    if (!empty($input['pri_id'])) {
      $pri_id = $input['pri_id'];
    } else {
      $pri_id = $get_appointment['apm_pri_id'];
    }


    if (!empty($input['ps_id'])) {
      $ps_id = $input['ps_id'];
    } else {
      $ps_id = $get_appointment['ps_id'];
    }

    $tracking_department = $this->M_que_appointment->get_queue_department($get_appointment['apm_stde_id'])->row_array();

    $tracking = request_queue($tracking_department['dpq_keyword']);
    $ql_id = $this->M_que_queue_list->get_by_track_code($tracking)->row_array();

    $apm_ql_id = $ql_id['ql_id'];
    $apm_ql_code = $tracking;

    $apm_update_user = $this->session->userdata('us_id');
    $this->M_que_appointment->update_appointment_que_code($appointment_id, $pri_id, $ps_id, $apm_ql_code, $apm_ql_id, $apm_update_user);
    $appointment = $this->M_que_appointment->get_appointment_by_id($appointment_id)->row_array();
    $response['status_response'] = $this->config->item('status_response_success');
    $response['ql_code'] = $tracking;
    $response['ps_name'] = $appointment['ps_name'];
    $response['pt_name'] = $appointment['pt_name'];
    $response['apm_time'] = $appointment['apm_time'];
    $response['apm_date'] = $this->convertToThaiDate_($appointment['apm_date']);
    $response['stde_name_th'] = $appointment['stde_name_th'];
    echo json_encode($response);
  }


  public function update_appointment()
  {
    $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
    $data['status_response'] = $this->config->item('status_response_show');;
    $this->output('que/appointment/v_appointment_update_form', $data);
  }

  public function add()
  {
    $data['returnUrl'] = base_url() . 'index.php/que/appointment';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);


    $jsonResult = json_encode($result);
    echo $jsonResult;
  }

  public function update()
  {
    $data['returnUrl'] = base_url() . 'index.php/que/appointment';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);


    $jsonResult = json_encode($result);
    echo $jsonResult;
  }
  public function delete()
  {
    $data['returnUrl'] = base_url() . 'index.php/que/appointment';
    $data['status_response'] = $this->config->item('status_response_success');

    $result = array('data' => $data);


    $jsonResult = json_encode($result);
    echo $jsonResult;
  }
  public function check_patient()
  {
    $this->load->model('que/M_que_appointment');
    $pt_id = decrypt_id($this->input->post('pt_id'));

    $check_id = $this->M_que_appointment->check_patient_by_id($pt_id);

    if ($check_id->num_rows() > 0) {
      $row = $check_id->row();
      if (!empty($row->pt_identification)) {
        $idCard = $row->pt_identification;
      } elseif (!empty($row->pt_passport)) {
        $idCard = $row->pt_passport;
      } elseif (!empty($row->pt_peregrine)) {
        $idCard = $row->pt_peregrine;
      } else {
        $idCard = null;
      }
      $response = array(
        'exists' => true,
        'name' => 'เลขที่บัตร : ' . $idCard . '<br>' . 'HN : ' . $row->pt_member . '<br>' . $row->pt_prefix . '' . $row->pt_fname . ' ' . $row->pt_lname,
        'idCard' => $idCard,
        'prefix' => $row->pt_prefix,
        'first_name' => $row->pt_fname,
        'last_name' => $row->pt_lname,
        'phone_number' => $row->pt_tel,
        'email' => $row->pt_email,
        'ptd_img_code' => $row->ptd_img_code,
        'ptd_img_type' => $row->ptd_img_type
      );
    } else {
      $response = array('exists' => false);
    }

    echo json_encode($response);
  }
  public function check_identification()
  {
    $this->load->model('que/M_que_appointment');
    $identification_id = $this->input->post('identification_id');

    $check_id = $this->M_que_appointment->check_identification($identification_id);

    if ($check_id->num_rows() > 0) {
      $row = $check_id->row();
      if (!empty($row->pt_identification)) {
        $idCard = $row->pt_identification;
      } elseif (!empty($row->pt_passport)) {
        $idCard = $row->pt_passport;
      } elseif (!empty($row->pt_peregrine)) {
        $idCard = $row->pt_peregrine;
      } else {
        $idCard = null;
      }
      $response = array(
        'exists' => true,
        'name' => 'เลขที่บัตร : ' . $idCard . '<br>' . 'HN : ' . $row->pt_member . '<br>' . $row->pt_prefix . '' . $row->pt_fname . ' ' . $row->pt_lname,
        'idCard' => $idCard,
        'prefix' => $row->pt_prefix,
        'first_name' => $row->pt_fname,
        'last_name' => $row->pt_lname,
        'phone_number' => $row->pt_tel,
        'email' => $row->pt_email,
        'ptd_img_code' => $row->ptd_img_code,
        'ptd_img_type' => $row->ptd_img_type
      );
    } else {
      $response = array('exists' => false);
    }

    echo json_encode($response);
  }

  public function check_member()
  {
    $this->load->model('que/M_que_appointment');
    $member_id = $this->input->post('member_id');
    $check_member = $this->M_que_appointment->check_member($member_id);


    if ($check_member->num_rows() > 0) {
      $row = $check_member->row();
      $response_member = array(
        'exists' => true,
        'name' => 'เลขบัตรประจำตัวประชาชน : ' . $row->pt_identification . '<br>' . 'HN : ' . $row->pt_member . '<br>' . $row->pt_prefix . '' . $row->pt_fname . ' ' . $row->pt_lname,
        'idCard' => $row->pt_identification,
        'prefix' => $row->pt_prefix,
        'first_name' => $row->pt_fname,
        'last_name' => $row->pt_lname,
        'phone_number' => $row->pt_tel,
        'email' => $row->pt_email,
        'ptd_img_code' => $row->ptd_img_code,
        'ptd_img_type' => $row->ptd_img_type
      );
    } else {
      $response_member = array('exists' => false);
    }

    echo json_encode($response_member);
  }

  public function get_diseases()
  {
    $department_id = $this->input->post('stde_id');

    // Validate department_id
    if (!$department_id) {
      echo json_encode([]);
      return;
    }

    // Fetch diseases based on department ID
    $this->load->model('que/M_que_appointment');
    $diseases = $this->M_que_appointment->get_diseases_by_department($department_id);

    echo json_encode($diseases);
  }
  public function get_app_walk($apm_id) {
    // Prepare the query
    $this->que->select('apm_app_walk');
    $this->que->from(''.$this->que_db.'.que_appointment');
    $this->que->where('apm_id', $apm_id);

    // Execute the query and retrieve the result
    $query = $this->que->get();
    
    // Check if the result has a row and return the `apm_app_walk` value
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->apm_app_walk;
    } else {
        return null; // Or handle the case when the appointment ID doesn't exist
    }
}
  private function isThaiCharacter($char)
  {
    $thai_pattern = '/[\x{0E00}-\x{0E7F}]/u';
    return preg_match($thai_pattern, $char);
  }
  public function Daily_queue_reset()
  {
    $this->load->model('que/M_que_queue_list');
    $this->load->model('que/M_que_create_queue');
    $keyword = $this->M_que_create_queue->get_all_que_keyword()->result_array();

    $que = $this->M_que_queue_list->Check_last_que($keyword);

    $currentDate = new DateTime();
    foreach ($que as $q) {
      $queDate = new DateTime($q['ql_date']);

      if ($queDate->format('Y-m-d') != $currentDate->format('Y-m-d')) {
        $create_queue = $this->M_que_create_queue->get_by_keyword_active($q['ql_dpq_keyword'])->row();
        $queue_values = json_decode($create_queue->cq_value);
        pre($queue_values);
        foreach ($queue_values as $value) {
          if ($value->char_type == 'rn') {
            $char_type_value = $value->char_type_value;
            if (ctype_digit($char_type_value)) {
              $value->char_type_value = '1';
            } elseif (ctype_lower($char_type_value)) {
              $value->char_type_value = 'a';
            } elseif (ctype_upper($char_type_value)) {
              $value->char_type_value = 'A';
            } elseif ($this->isThaiCharacter($char_type_value)) {
              $value->char_type_value = 'ก';
            }
          }
        }
        $this->M_que_create_queue->cq_value = json_encode($queue_values);
        $this->M_que_create_queue->cq_id = $create_queue->cq_id;
        $this->M_que_create_queue->update_cq_value();
      } else {
        echo "The date in the queue is today: " . $q['ql_date'];
      }
    }
  }
}
