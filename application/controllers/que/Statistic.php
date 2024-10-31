<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');


class Statistic extends QUE_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('hr/M_hr_person');
	}

	function index(){
        $currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543;
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;
		$data['ums_department_list'] = $this->M_hr_person->get_ums_department_data()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('que/statistic/v_statistic_department_show',$data);   
  }

  public function get_appointments() {
    $draw = intval($this->input->post('draw'));
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $search = $this->input->post('search')['value'];
    if(empty($search)){
      $search = NULL;
    }
    $order_column_index = $this->input->post('order')[0]['column'];
    $order_dir = $this->input->post('order')[0]['dir'];

    $columns = array(
        "row_number",
        "pt_member",
        "apm_cl_code",
        "stde_name_th",
        "pt_name",
        "apm_date",
        "apm_time",
        "ps_name",
        "apm_create_date",
        "apm_id"
    );

    $order_column = $columns[$order_column_index];

    $this->load->model('que/M_que_appointment');

    $searchParams = array(
        'date' => $this->input->post('date'),
        'month' => $this->input->post('month'),
        'department' => $this->input->post('department'),
        'doctor' => $this->input->post('doctor'),
        'patientId' => $this->input->post('patientId'),
        'patientName' => $this->input->post('patientName'),
        'search' => $search
    );

    $appointments = $this->M_que_appointment->get_appointments_paginated($start, $length, $order_column, $order_dir, $searchParams);
    $total_appointments_result = $this->M_que_appointment->get_appointment_count($searchParams);
    $total_appointments = $total_appointments_result->appointment_count; // Correctly accessing the count

    $data = array();
    foreach ($appointments as $key => $apm) {
        $data[] = array(
            "row_number" => $start + $key + 1,
            "pt_member" => $apm['pt_member'],
            "apm_cl_code" => $apm['apm_cl_code'],
            "stde_name_th" => $apm['stde_name_th'],
            "pt_name" => $apm['pt_name'],
            "apm_date" => abbreDate2($apm['apm_date']),
            "apm_time" => $apm['apm_time'],
            "ps_name" => $apm['ps_name'],
            "apm_create_date" => abbreDate4($apm['apm_create_date']),
            "apm_id" => encrypt_id($apm['apm_id'])
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
}

}
?>