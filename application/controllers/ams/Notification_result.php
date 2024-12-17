<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');
require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

use \Firebase\JWT\JWT;
use Mpdf\Tag\TextArea;
class Notification_result extends AMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ams/M_ams_notification_result');

        $this->session_ps_id = $this->session->userdata('us_ps_id');
    }

    function index()
    {
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

        $base_statuses = $this->M_ams_notification_result->get_ams_base_statuses(['WU', 'WA'])->result_array();

        // encrypt id
        $names = ['ast_id']; // object name need to encrypt
        $data['base_statuses'] = encrypt_arr_obj_id($base_statuses, $names);

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('ams/notification_result/v_notification_result_show', $data);
    }

    /*
	* get_notis_and_ques
	* get notification_result from ams_notification_result and que_appointment
	* @input search form data, config from datatable
	* $output list of notification_result
	* @author Areerat Pongurai
	* @Create Date 25/07/2024
	*/
    public function get_notis_and_ques()
    {
        $draw = intval($this->input->post('draw'));
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');
        if (!empty($order)) {
            $order_column = $order[0]['column'];
            $order_dir = $order[0]['dir'];
        } else { // default
            $order_column = 'ntr_update_date';
            $order_dir = 'DESC';
        }
        $search = $this->input->post('search')['value'];
        if (empty($search))
            $search = NULL;

        $date = $this->input->post('date');
        if (!empty($date))
            $date = convertToEngYearForDB($date);
        else { // default
            if (empty($this->input->post('month'))) // addition condition
                $date = (new DateTime())->format('Y-m-d 00:00:00');
        }

        $params = [
            'month' => $this->input->post('month'),
            'date' => $date,
            'pt_member' => $this->input->post('pt_member'),
            'pt_name' => $this->input->post('pt_name'),
            'ast_id' => decrypt_id($this->input->post('ast_id')),
            'search' => $search
        ];

        // set badge text
        if (!empty($date))
            $badge = "ประจำวันที่ " . formatShortDateThai($date);
        else if (!empty($this->input->post('month')))
            $badge = "ประจำเดือน " . getLongMonthThai($this->input->post('month'));
        else $badge = '';

        // case by tb_index to get datas
        switch ($this->input->post('tb_index')) {
                // get from ams_notification_result that ntr_ast_id = ('R', 'TW', 'TS') and que_appointment that apm_sta_id = 2
            case 1:
                $result = $this->M_ams_notification_result->get_que_appointment_and_noti_wait_by_doctor_server($this->session_ps_id, $start, $length, $order_column, $order_dir, $params);
                $notis = $result['query']->result_array();
                $total_records = $result['total_records'];
                break;
                // get from ams_notification_result that ntr_ast_id != ('R', 'TW', 'TS')
            // case 2:
            //     $result = $this->M_ams_notification_result->get_show_notification_server(['W'], $this->session_ps_id, $start, $length, $order_column, $order_dir, $params);
            //     $notis = $result['query']->result_array();
            //     $total_records = $result['total_records'];
            //     break;
            case 3:
                $result = $this->M_ams_notification_result->get_show_notification_server(['Y'], $this->session_ps_id, $start, $length, $order_column, $order_dir, $params);
                $notis = $result['query']->result_array();
                $total_records = $result['total_records'];
                break;
        }

        $data = [];
        if (!empty($notis)) {
            foreach ($notis as $index => $noti_que) {
                // die(pre($noti_que));
                // encrypt id
                $ntr_id = encrypt_id($noti_que['ntr_id']);
                $ntr_apm_id = encrypt_id($noti_que['ntr_apm_id']);

                if (!empty($noti_que['ntr_id'])) {
                    switch ($noti_que['ntr_ast_id']) {
                        // case 1:
                        //     $btn_url = base_url() . 'index.php/ams/Notification_result/update_form/0/' . $ntr_id;
                        //     $btn = '<button class="btn btn-warning" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-pencil-square"></i></button>';
                        //     $modal_url = base_url() . 'index.php/ams/Notification_result/do_noti/' . $ntr_id;
                        //     $btn .= '<button class="btn btn-info swal-do-noti ms-2" title="ดำเนินการแจ้งเตือน" data-url="' . $btn_url . '"><i class="bi-bell"></i></button>';
                        //     break;
                        // case 3:
                        //     $btn_url = base_url() . 'index.php/ams/Notification_result/update_form/0/' . $ntr_id;
                        //     $btn = '<button class="btn btn-warning" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-pencil-square"></i></button>';
                        //     break;
                        // case 4:
                        //     $btn_url = base_url() . 'index.php/ams/Notification_result/update_form/1/' . $ntr_id;
                        //     $btn = '<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-search"></i></button>';
                        //     $modal_url = base_url() . 'index.php/ams/Notification_result/cancel_noti/' . $ntr_id;
                        //     $btn .= '<button class="btn btn-danger swal-cancel-noti ms-2" title="ยกเลิกการแจ้งเตือน" data-url="' . $btn_url . '"><i class="bi-x-square"></i></button>';
                        //     break;
                        // case 10:
                        //     $btn_url = base_url() . 'index.php/ams/Notification_result/update_form/0/' . $ntr_id;
                        //     $btn = '<button class="btn btn-warning" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-pencil-square"></i></button>';
                        //     break;
                        default:
                            // $btn_url = base_url() . 'index.php/ams/Notification_result/update_form/1/' . $ntr_id;
                            $btn_url = base_url() . 'index.php/ams/Notification_result/Notification_result_get_exr/' . $noti_que['apm_visit'] . '/' . $noti_que['stde_name_th'] . '/1' ;
                            $btn = '<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-search"></i></button>';
                            break;
                    }
                } else {
                    $btn_url = base_url() . 'index.php/ams/Notification_result/update_form_from_que/' . $ntr_apm_id;
                    $btn = '<button class="btn btn-warning" onclick="window.location.href=\'' . $btn_url . '\'"><i class="bi-pencil-square"></i></button>';
                }

                // ast_text
                if ($noti_que['ntr_ast_id'] == 4)
                    $noti_que['ast_name'] = "พบแพทย์เสร็จสิ้น";

                $data[] = [
                    'row_number' => '<div class="text-center">'.($start + $index + 1).'</div>',
                    'apm_visit' => '<div class="text-center">'.$noti_que['apm_visit'].'</div>',
                    'pt_member' => '<div class="text-center">'.$noti_que['pt_member'].'</div>',
                    'pt_name' => $noti_que['pt_name'],
                    'ps_name' => $noti_que['ps_name'],
                    'update_us_name' => $noti_que['update_user_name'],
                    'ntr_update_date' => '<div class="text-center">'.convertToThaiYear($noti_que['ntr_update_date'], true).'</div>',
                    'status_text' => '<div class="text-center"><i class="bi-circle-fill" style="color: ' . $noti_que['ast_color'] . ';"></i> '.$noti_que['ast_name'].'</div>',
                    'actions' => '<div class="text-center option">'.$btn.'</div>'
                ];
            }
        } else {
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
	* update_form
	* for show edit screen and notification_results data
	* @input 
            is_view: bool check view mode screen
            id (notification_results id): ไอดีบันทึกผลตรวจ
	* $output insert/edit screen and notification_results data
	* @author ?
	* @Create Date ?
	* @Update Date Areerat Pongurai 23/07/2024 - get ams_appointment and ddl rooms for select equipments
	*/
    function update_form($is_view, $id)
    {
        $data = $this->Notification_result_get_data($id);
        $data['actor'] = "doctor";
        $data['is_view'] = $is_view;

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('ams/notification_result/v_notification_result_update_form', $data);
    }

    /*
	* update_form_from_que
	* patiant data from QUE.appointment and form for save result 
	* @input apm_id (que appointment id)
	* $output screen of patiant data and form
	* @author Areerat Pongurai
	* @Create Date 08/07/2024
	*/
    function update_form_from_que($apm_id)
    {
        $data['actor'] = "doctor";

        $data['apm_id'] = $apm_id;
        $apm_id = decrypt_id($apm_id);

        $this->load->model('que/m_que_appointment');
        $result = $this->m_que_appointment->get_appointment_by_id($apm_id)->row();
        $detail = new stdClass(); // Initialize as a new object
        $detail->ntr_id = null;
        $detail->ntr_apm_id = $apm_id;
        $detail->ntr_pt_id = $result->apm_pt_id;
        $detail->ntr_ps_id = $result->apm_ps_id;
        $detail->ntr_detail_lab_med = null;
        $detail->ntr_detail_lab = null;
        $detail->ntr_detail_advice = null;
        $detail->ntr_upnr_id = null;
        $detail->ntr_ntf_id = $result->apm_ntf_id;
        // $detail->ntr_al_id = 1; // hard
        // $detail->ntr_ast_id = 3; // รอการบันทึกผล
        // $detail->ntr_create_user = null;
        // $detail->ntr_create_date = null;
        // $detail->ntr_update_user = null;
        // $detail->ntr_update_date = null;

        $detail->pt_prefix = $result->pt_prefix;
        $detail->pt_fname = $result->pt_fname;
        $detail->pt_lname = $result->pt_lname;
        $detail->pt_member = $result->pt_member;
        $detail->apm_patient_type = $result->apm_patient_type;
        $detail->apm_create_date = $result->apm_create_date;
        $detail->ds_name_disease = $result->ds_name_disease;
        $data['detail'] = $detail;
        $data['files'] = [];

        // get ddl
        $this->load->model('eqs/m_eqs_room');
        $order = array('rm_name' => 'ASC');
        $rooms = $this->m_eqs_room->get_rooms_tools($order)->result_array();
        
		$this->load->model('eqs/m_eqs_equipments');
		$order = array('eqs_name' => 'ASC');
		$equipments = $this->m_eqs_equipments->get_all($order)->result_array();

        // encrypt id ddl
        $names = ['rm_id']; // object name need to encrypt
        $data['rooms'] = encrypt_arr_obj_id($rooms, $names);
        $names = ['eqs_id', 'eqs_rm_id']; // object name need to encrypt
        $data['equipments'] = encrypt_arr_obj_id($equipments, $names);

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('ams/notification_result/v_notification_result_update_form', $data);
    }

    /*
	* Notification_result_get_exrs_table
	* get DIM - examination result files by ntr_id
	* @input ntr_id (notification_results id): ไอดีบันทึกผลตรวจ
	* $output tr of examination result files
	* @author Areerat Pongurai
	* @Create Date 07/08/2024
	*/
    function Notification_result_get_exrs_table($ntr_id)
    {
        $ntr_id = decrypt_id($ntr_id);

        $is_view = $this->input->post('is_view');
        $actor = $this->input->post('actor');

        // get DIM examination result
        $this->load->model('dim/M_dim_examination_result');
        $this->M_dim_examination_result->exr_ntr_id = $ntr_id;
        $exam_results = $this->M_dim_examination_result->get_by_ntr_id()->result_array();
        $names = ['exr_id']; // object name need to encrypt
        $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        $i = 1;
        $datatable = [];
        foreach ($data['exam_results'] as $exr) {
            if($exr['exr_status'] != 'D' && $exr['exr_status'] != 'R') {
                $btn = '';
                if(!empty($exr['exr_directory']))
                    $btn = '<button type="button" title="ดูผลตรวจ" class="btn btn-info" onclick="loadModalExrs(\''.$exr['exr_id'].'\')"><i class="bi-search"></i></button>';
                switch($exr['exr_status']) {
                    case 'W': 
                        $exr_status_text = 'รอการตรวจ'; 
                        $exr_status_class = 'text-warning'; 
                        if(empty($is_view) && (!empty($actor) && $actor == 'officer'))
                            $btn = '<button type="button" title="ยกเลิกการตรวจ" class="btn btn-danger ms-1" onclick="alertCancel(\''.$exr['exr_id'].'\')"><i class="bi-x-lg"></i></button>';
                        else $btn = '';
                        break;
                    case 'Y': 
                        $exr_status_text = 'บันทึกสำเร็จ'; 
                        $exr_status_class = 'text-success'; 
                        break;
                    case 'C': 
                        $exr_status_text = 'ยกเลิกการตรวจ'; 
                        $exr_status_class = 'text-danger'; 
                        $btn = '';
                        break;
                    default: 
                        $exr_status_text = 'รอการตรวจ'; 
                        $exr_status_class = 'text-warning'; 
                        if(empty($is_view) && (!empty($actor) && $actor == 'officer'))
                            $btn = '<button type="button" title="ยกเลิกการตรวจ" class="btn btn-danger ms-1" onclick="alertCancel(\''.$exr['exr_id'].'\')"><i class="bi-x-lg"></i></button>';
                        else $btn = '';
                        break;
                }
                $datatable[] = [
                    'order' => '<div class="text-center">'.$i.'</div>',
                    'apm_visit' => '<div class="text-center">'.$exr['apm_visit'].'</div>',
                    'apm_date' => '<div class="text-center">'.(convertToThaiYear($exr['apm_date'], false)).'</div>',
                    'rm_id' => $exr['rm_name'],
                    'eqs_id' => $exr['eqs_name'],
                    'sta_text' => '<div class="text-center '.$exr_status_class.'">'.$exr_status_text.'</div>',
                    'actions' => '<div class="text-center option">'.$btn.'</div>'
                ];
                $i++;
            }
        }

        $draw = intval($this->input->post('draw'));
        $response = [
            'draw' => $draw,
            // 'recordsTotal' => $total_records,
            // 'recordsFiltered' => $total_records,
            'data' => $datatable,
            // 'badge' => $badge
        ];

        echo json_encode($response);
    }

    /*
	* Notification_result_get_docs
	* get DIM - examination result files by exr_id
	* @input exr_id (examination_results id): ไอดีผลตรวจจากเครื่องมือ
	* $output modal screen of examination result files
	* @author Areerat Pongurai
	* @Create Date 06/08/2024
	*/
    function Notification_result_get_docs($exr_id)
    {
        $exr_id = decrypt_id($exr_id);

        // get DIM examination result
        $this->load->model('dim/m_dim_examination_result');
        $this->m_dim_examination_result->exr_id = $exr_id;
        $exam_result = $this->m_dim_examination_result->get_detail_by_id()->result_array();
        if(!empty($exam_result))
            $exr = $exam_result[0];
        $data['exam_result'] = $exr;

        // get id files from dim_examination_result_doc
        $this->load->model('dim/m_dim_examination_result_doc');
        $this->m_dim_examination_result_doc->exrd_exr_id = $exr_id;
        $examination_result_docs = $this->m_dim_examination_result_doc->get_by_examination_result_id()->result_array();
        // $names = ['exrd_id']; // object name need to encrypt
        // $examination_result_docs = encrypt_arr_obj_id($examination_result_docs, $names);

        // $names = ['exr_id']; // object name need to encrypt
        // $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        // // get all DIM examination result for ddl tools
        // $this->load->model('dim/M_dim_examination_result');
        // $this->M_dim_examination_result->exr_ntr_id = $ntr_id;
        // $exam_results = $this->M_dim_examination_result->get_by_ntr_id()->result_array();
        // $names = ['exr_id']; // object name need to encrypt
        // $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        $files = array();
        if (!empty($exr['exr_directory'])) {
            // Connect with NAS for get file data
            // 0. Define variables
            $nas_server_ip = $this->config->item('dim_nas_ip');
            $nas_port = $this->config->item('dim_nas_port');

            $nas_target_folder = $this->config->item('dim_nas_share_path') . $exr['exr_directory'];

            // 1. Check if the NAS server is reachable
            $ping_command = "ping -c 1 $nas_server_ip";
            exec($ping_command, $output, $return_var);
            if ($return_var !== 0) {
                die("Failed to reach NAS server, code: $return_var, output: " . implode("\n", $output));
            }

            // 2. Check if nas target directory exists
            if (is_dir($nas_target_folder)) {
                if ($handle = opendir($nas_target_folder)) {
                    $nas_files = scandir($nas_target_folder);
                    $nas_files = array_diff($nas_files, array('.', '..'));

                    foreach ($nas_files as $file) {
                        $path = $nas_target_folder . '/' . $file;
                        if (file_exists($path)) {
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
                                $pathdownload = base_url() . "index.php/dim/Getpreview?path=" . bin2hex($path);
                                $type = mime_content_type($path);

                                $files[] = array(
                                    'name' => $file,
                                    'url' => $pathdownload,
                                    'type' => $type,
                                    'exr_id' => $exr['exr_id'],
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
        }

        $data['exr_docs'] = [];
        if (!empty($files))
            $data['exr_docs'] = $files;

        // get DIM all examination result by ntr_id for select2
        $this->m_dim_examination_result->exr_ntr_id = $data['exam_result']['exr_ntr_id'];
        $exam_results = $this->m_dim_examination_result->get_by_ntr_id()->result_array();
        // encrypt id
        $names = ['exr_id']; // object name need to encrypt
        $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        $this->load->view('ams/notification_result/v_notification_result_modal_show', $data);
    }

    /*
	* update_draft
	* for insert/update notification_results in db status draft
	* @input id (notification_results id): ไอดีบันทึกผลตรวจ
	* $output response
	* @author ?
	* @Create Date ?
	* @Update Date Areerat Pongurai 23/07/2024 - add save ams_appointment
	*/
    function update_draft($id)
    {
        $id = decrypt_id($id);
        // Fetch POST data
        $post_data = $this->input->post();

        $this->M_ams_notification_result->ntr_id = $id;
        $this->M_ams_notification_result->ntr_apm_id = $post_data['ntr_apm_id'];
        $this->M_ams_notification_result->ntr_pt_id = $post_data['ntr_pt_id'];
        $this->M_ams_notification_result->ntr_ps_id = $post_data['ntr_ps_id'];
        $this->M_ams_notification_result->ntr_ast_id = 8; // D - ฉบับร่าง ผลการตรวจล่วงหน้า
        $this->M_ams_notification_result->ntr_update_user = $this->session->userdata('us_id');
        $this->M_ams_notification_result->ntr_update_date = date('Y-m-d H:i:s');

        $this->M_ams_notification_result->update();

        // 20240901 Areerat - Not save from SEEDB but save with Api_Services before
        // // [AMS] If doctor want to appointment patient next date, then add rows / update in AMS ams_appointment (but status = draft)
        // $ap_id = decrypt_id($post_data['ap_id']);
        // $this->load->model('ams/m_ams_appointment');
        // if (!empty($post_data['is_appointment_checked']) && $post_data['is_appointment_checked'] == 'off') {
        //     if (!empty($ap_id)) {
        //         $this->m_ams_appointment->ap_update_user = $this->session->userdata('us_id');
        //         $this->m_ams_appointment->ap_id = $ap_id;
        //         $this->m_ams_appointment->ap_ast_id = 9; // 'C' ยกเลิกการนัดหมาย
        //         $this->m_ams_appointment->update_ap_ast_id();
        //     }
        // } else {
        //     if (!empty($post_data['ap_date']) && !empty($post_data['ap_time'])) {

        //         $this->m_ams_appointment->ap_pt_id = $post_data['ntr_pt_id'];
        //         $this->m_ams_appointment->ap_ntr_id = $id;
        //         $this->m_ams_appointment->ap_detail_appointment = $post_data['ap_detail_appointment'];
        //         $this->m_ams_appointment->ap_detail_prepare = $post_data['ap_detail_prepare'];
        //         $this->m_ams_appointment->ap_report_type = 1; // hard?

        //         $ap_date = explode("/", $post_data['ap_date']);
        //         $year = $ap_date[count($ap_date) - 1] - 543;
        //         $start_string = $ap_date[0] . '-' . $ap_date[1] . '-' . $year . ' 00:00:00';
        //         $ap_date = (new DateTime($start_string))->format('Y-m-d H:i:s');
        //         $this->m_ams_appointment->ap_date = $ap_date;
        //         $this->m_ams_appointment->ap_time = $post_data['ap_time'];

        //         if (empty($ap_id)) {
        //             $this->m_ams_appointment->ap_ast_id = 7; // 'WA' ฉบับร่าง การแจ้งเตือนนัดหมาย
        //             $this->m_ams_appointment->ap_create_user = $this->session->userdata('us_id');
        //             $this->m_ams_appointment->insert();

        //             // [QUE] not insert/update new que_appointment at draft
        //         } else {
        //             $this->m_ams_appointment->ap_ast_id = $post_data['ap_ast_id'];
        //             $this->m_ams_appointment->ap_update_user = $this->session->userdata('us_id');
        //             $this->m_ams_appointment->ap_id = $ap_id;
        //             $this->m_ams_appointment->update();

        //             // [QUE] not insert/update new que_appointment at draft
        //         }
        //     }
        // }

        $data['returnUrl'] = base_url() . 'index.php/ams/Notification_result';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }

    /*
	* send_email_api
	* for send an email to patient
	* @input id (appointment id): ไอดีของการนัดหมาย
	* $output response
	* @author Jiradat Pomyai
	* @Create Date 31/07/2024
	* @Update Date ?
	*/
    function send_email_api($ap_id)
    {
        $key = "your_secret_key";
        $payload = array(
            "iat" => time(),
            "exp" => time() + (60 * 60),
            "sub" => "cron_job",
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        $api_url = '<?php echo site_url() ?>/email/Sendemail/send_email_appoint_to_patient';
        $headers = array(
            "Authorization: Bearer $jwt",
            "Content-Type: application/json",
        );
        $data = array(
            "ap_id" => $ap_id
        );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }

    /*
	* update_save
	* for insert/update notification_results
	* @input id (notification_results id): ไอดีบันทึกผลตรวจ
	* $output response
	* @author ?
	* @Create Date ?
	* @Update Date Areerat Pongurai 23/07/2024 - add save dim_examination_result, ams_appointment, que_appointment and wts_notifications_department
	*/
    function update_save($id = null)
    {
        $id = decrypt_id($id);
        // Fetch POST data
        $post_data = $this->input->post();

        $this->M_ams_notification_result->ntr_id = $id;
        $this->M_ams_notification_result->ntr_apm_id = $post_data['ntr_apm_id'];
        $this->M_ams_notification_result->ntr_pt_id = $post_data['ntr_pt_id'];
        $this->M_ams_notification_result->ntr_ps_id = $post_data['ntr_ps_id'];
        $this->M_ams_notification_result->ntr_ntf_id = $post_data['ntr_ntf_id'];
        $al_data = $this->M_ams_notification_result->get_ams_base_alarm($post_data['ntr_ntf_id'])->row();

        $is_appointment_checked = !empty($post_data['is_appointment_checked']) && $post_data['is_appointment_checked'] == 'on';
        $is_draft_tools_checked = isset($post_data['is_draft_tools_checked']) && $post_data['is_draft_tools_checked'] == 'on'; 
        $is_have_draft_tools = $is_draft_tools_checked && (isset($post_data['draft_eqs_id']) && !empty($post_data['draft_eqs_id']));

        // If is_appointment_checked then save appointment datetime.
        if ($is_appointment_checked) {
            if(empty($post_data['ap_date']))
			    $data['error_inputs'][] = (object) ['name' => 'ap_date', 'error' => $this->config->item('text_invalid_default')];
            if(empty($post_data['ap_time']))
                $data['error_inputs'][] = (object) ['name' => 'ap_time', 'error' => $this->config->item('text_invalid_default')];
        }
        // If doctor want patient to be examined with medical equipment then input equipment.
        if ($is_have_draft_tools) {
            $eqs_ids = $post_data['draft_eqs_id'];
            foreach($eqs_ids as $key => $eqs_id) {
                if(empty($eqs_id))
                    $data['error_inputs'][] = (object) ['name' => $post_data['draft_eqs_id_name'][$key], 'error' => $this->config->item('text_invalid_default')];
            }
        }

        if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
            $data['status_response'] = $this->config->item('status_response_error');
            $data['message_dialog'] = $this->config->item('text_invalid_inputs');
        } else {
            // // If doctor want patient to be examined with medical equipment (got to DIM).
            // $is_go_to_dim = false;
            // if (!empty($post_data['rm_id']) && !empty($post_data['eqs_id'])) {
            //     $this->M_ams_notification_result->ntr_ast_id = 5; // รอผลตรวจจากเครื่องมือหัตถการ
            //     $is_go_to_dim = true;
            // } else // Else then save noti result.
                $this->M_ams_notification_result->ntr_ast_id = 4; // บันทึกผลแจ้งเตือนแล้ว
            // // will check if checked and no select medical equipment then alert

            // If have data notification result before.
            if (!empty($id)) {
                $this->M_ams_notification_result->ntr_update_user = $this->session->userdata('us_id');
                $this->M_ams_notification_result->ntr_update_date = date('Y-m-d H:i:s');
                $this->M_ams_notification_result->update();
            } else { // Else no have data notification result before but from QUE.appointment.
                $this->M_ams_notification_result->ntr_create_user = $this->session->userdata('us_id');
                $this->M_ams_notification_result->ntr_create_date = date('Y-m-d H:i:s');
                $this->M_ams_notification_result->insert();
                $id = $this->M_ams_notification_result->last_insert_id;
            }

            // 20240901 Areerat - Not save from SEEDB but save with Api_Services before, then just update [QUE] que_appointment = พบแพทย์เสร็จแล้ว
            // // [AMS] If doctor want to appointment patient next date, then add rows / update in AMS ams_appointment
            // $ap_id = decrypt_id($post_data['ap_id']);
            // $this->load->model('ams/m_ams_appointment');
            // // case ยกเลิกนัดหมายล่วงหน้าไว้
            // if (!empty($post_data['is_appointment_checked']) && $post_data['is_appointment_checked'] == 'off') {
            //     if (!empty($ap_id)) { // case เคยนัดหมายล่วงหน้าไว้ (อาจจะฉบับร่าง หรือยังไม่ถึงวัน) แต่ตอนนี้ไม่นัดแล้ว
            //         $this->m_ams_appointment->ap_update_user = $this->session->userdata('us_id');
            //         $this->m_ams_appointment->ap_id = $ap_id;
            //         $this->m_ams_appointment->ap_ast_id = 9; // 'C' ยกเลิกการนัดหมาย
            //         $this->m_ams_appointment->update_ap_ast_id();
            //     }

                // [QUE] Update original que_appointment is finished seeing the doctor.
                $this->load->model('que/m_que_appointment');
                $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
                $this->m_que_appointment->apm_sta_id = 10; // 'F' พบแพทย์เสร็จแล้ว
                $this->m_que_appointment->update_status();

            //     // [DIM] ยกเลิกบันทึกร่างเครื่อง
            // } else { // case นัดหมายล่วงหน้าปกติ
            //     if (!empty($post_data['ap_date']) && !empty($post_data['ap_time']) && $this->M_ams_notification_result->ntr_ast_id == 4) {

            //         $this->m_ams_appointment->ap_pt_id = $post_data['ntr_pt_id'];
            //         $this->m_ams_appointment->ap_ntr_id = $id;
            //         $this->m_ams_appointment->ap_detail_appointment = $post_data['ap_detail_appointment'];
            //         $this->m_ams_appointment->ap_detail_prepare = $post_data['ap_detail_prepare'];
            //         $this->m_ams_appointment->ap_report_type = 1; // hard?

            //         $ap_date = explode("/", $post_data['ap_date']);
            //         $year = $ap_date[count($ap_date) - 1] - 543;
            //         $start_string = $ap_date[0] . '-' . $ap_date[1] . '-' . $year . ' 00:00:00';
            //         $ap_date_obj = new DateTime($start_string);
            //         $ap_date = $ap_date_obj->format('Y-m-d H:i:s');
            //         $ap_rp_date_obj = (clone $ap_date_obj)->modify("-{$al_data->al_day} days");
            //         $ap_rp_date = $ap_rp_date_obj->format('Y-m-d H:i:s');
            //         $this->m_ams_appointment->ap_date = $ap_date;
            //         $this->m_ams_appointment->ap_rp_date = $ap_rp_date;
            //         $this->m_ams_appointment->ap_time = $post_data['ap_time'];
            //         $current_date = new DateTime("now", new DateTimeZone("Asia/Krasnoyarsk"));
            //         if ($ap_rp_date_obj <= $current_date) {
            //             $check = 'now';
            //         } else {
            //             $check = 'later';
            //         }
            //         // case เคยนัดหมายล่วงหน้าไว้ (อาจจะฉบับร่าง หรือยังไม่ถึงวัน) และตอนนี้มีการแก้ไขข้อมูล
            //         if (empty($ap_id)) {
            //             // if later then insert new row at [QUE], [AMS], [DIM] and close task with original row
            //             if ($check != 'now'){
            //                 // [AMS] insert ams_appointment set status
            //                 $this->m_ams_appointment->ap_ast_id = 1; // 'W' รอการแจ้งเตือน

            //                 // [QUE] Update original que_appointment is finished seeing the doctor.
            //                 // 1. Else appointment next date ($check != 'now') - update apm_sta_id = 10 ('F' พบแพทย์เสร็จแล้ว), add new que_appointment
            //                 $this->load->model('que/m_que_appointment');
            //                 $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            //                 $this->m_que_appointment->apm_sta_id = 10; // 'F' พบแพทย์เสร็จแล้ว
            //                 $this->m_que_appointment->update_status();

            //                 // [QUE] insert next que_appointment with this parent (apm_parent_id)
            //                 // 1. gen เลขนัดหมาย for next que_appointment
            //                 // 2. insert next que_appointment
            //                 $this->load->model('que/m_que_appointment');
            //                 $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            //                 $appointment = $this->m_que_appointment->get_by_key()->row();
                            
            //                 $tracking_department = $this->m_que_appointment->get_tracking_department($appointment->apm_stde_id)->row_array();
            //                 $tracking = request_number($tracking_department['dpk_keyword']);
            //                 $this->load->model('que/m_que_code_list');
            //                 $cl_id = $this->m_que_code_list->get_by_track_code($tracking)->row_array();

            //                 // Add 30 minutes at apm_time
            //                 $dateTime = new DateTime($post_data['ap_time']);
            //                 $dateTime->modify('+30 minutes');
            //                 $apm_time = $post_data['ap_time'] . " - " . $dateTime->format('H:i');

            //                 $this->m_que_appointment->apm_parent_id = $appointment->apm_id;
            //                 $this->m_que_appointment->apm_cl_id = $cl_id['cl_id'];
            //                 $this->m_que_appointment->apm_cl_code = $tracking;
            //                 $this->m_que_appointment->apm_date = $ap_date;
            //                 $this->m_que_appointment->apm_time = $apm_time;
            //                 $this->m_que_appointment->apm_sta_id = 1; // 'A' นัดหมายสำเร็จ
            //                 $this->m_que_appointment->apm_pri_id  = $appointment->apm_pri_id ;
            //                 $this->m_que_appointment->apm_patient_type = 'old';
            //                 $this->m_que_appointment->apm_create_user = $this->session->userdata('us_id');;
            //                 $this->m_que_appointment->insert_by_apm_parent_id();
            //                 $next_apm_id = $this->m_que_appointment->last_insert_id;

            //                 // // [AMS] insert next notification_result but not same day
            //                 // $this->M_ams_notification_result->ntr_id = null;
            //                 // $this->M_ams_notification_result->ntr_apm_id = $next_apm_id;
            //                 // $this->M_ams_notification_result->ntr_pt_id = $post_data['ntr_pt_id'];
            //                 // $this->M_ams_notification_result->ntr_ps_id = $post_data['ntr_ps_id'];
            //                 // $this->M_ams_notification_result->ntr_ntf_id = $post_data['ntr_ntf_id'];
            //                 // $this->M_ams_notification_result->ntr_ast_id = 8; // D - ฉบับร่าง ผลการตรวจล่วงหน้า
            //                 // $this->M_ams_notification_result->ntr_create_user = $this->session->userdata('us_id');
            //                 // $this->M_ams_notification_result->ntr_create_date = date('Y-m-d H:i:s');
            //                 // $this->M_ams_notification_result->insert();

            //                 // [DIM] for_ is for insert draft tools
            //                 $for_exr_stde_id = $appointment->apm_stde_id;
            //                 $for_exr_ntr_id = $this->M_ams_notification_result->last_insert_id;
            //             } else {
            //                 // // [AMS] ams_appointment set status
            //                 // $this->m_ams_appointment->ap_ast_id = 2; // 'Y' แจ้งเตือนแล้ว

            //                 // // [QUE] Update original que_appointment is finished seeing the doctor.
            //                 // // 2. If appointment current date ($check == 'now') - update apm_time, apm_date, apm_sta_id = 1
            //                 // $this->load->model('que/m_que_appointment');
            //                 // $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            //                 // $this->m_que_appointment->apm_sta_id = 4; // 'Q' ออกหมายเลขคิว
            //                 // $this->m_que_appointment->apm_time = $post_data['ap_time'];

            //                 // $apm_date = explode("/", $post_data['ap_date']);
            //                 // $year = $apm_date[count($apm_date) - 1] - 543;
            //                 // $start_string = $apm_date[0] . '-' . $apm_date[1] . '-' . $year . ' 00:00:00';
            //                 // $apm_date = (new DateTime($start_string))->format('Y-m-d H:i:s');
            //                 // $this->m_que_appointment->apm_date = $apm_date;

            //                 // $this->m_que_appointment->update_appointment_date();

            //                 // // [AMS] Notification_result original = change status = 3 'R' รอการบันทึกผล
            //                 // $this->M_ams_notification_result->ntr_id = $id;
            //                 // $this->M_ams_notification_result->ntr_ast_id = 3; // 'R' รอการบันทึกผล
            //                 // $this->M_ams_notification_result->change_noti();

            //                 // // [DIM] for_ is for insert draft tools
            //                 // $this->load->model('que/m_que_appointment');
            //                 // $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            //                 // $appointment = $this->m_que_appointment->get_by_key()->row();
            //                 // $for_exr_stde_id = $appointment->apm_stde_id;
            //                 // $for_exr_ntr_id = $id;
            //             }

            //             // [AMS] insert ams_appointment
            //             $this->m_ams_appointment->ap_create_user = $this->session->userdata('us_id');
            //             $this->m_ams_appointment->insert();
            //             $for_exr_ap_id = $this->m_ams_appointment->last_insert_id;

            //             // [AMS] send email
            //             if($check == 'now'){
            //                 $this->send_email_api($this->m_ams_appointment->last_insert_id);
            //             }
            //         } else {
            //             $ap_ast_id = $post_data['ap_ast_id'];

            //             if ($check != 'now'){
            //                 // [AMS] update ams_appointment set status
            //                 // || == 6  'WU' ฉบับร่าง แจ้งเตือนแบบเร่งด่วน
            //                 if ($ap_ast_id == 7) // 'WA' ฉบับร่าง การแจ้งเตือนนัดหมาย
            //                     $ap_ast_id = 1; // 'W' รอการแจ้งเตือน
            //             } else {
            //                 // // [AMS] update ams_appointment set status
            //                 // // || == 6  'WU' ฉบับร่าง แจ้งเตือนแบบเร่งด่วน
            //                 // if ($ap_ast_id == 7) // 'WA' ฉบับร่าง การแจ้งเตือนนัดหมาย
            //                 //     $ap_ast_id = 2; // 'Y' แจ้งเตือนแล้ว
            //             }

            //             // [AMS] update ams_appointment
            //             $this->m_ams_appointment->ap_ast_id = $ap_ast_id;
            //             $this->m_ams_appointment->ap_update_user = $this->session->userdata('us_id');
            //             $this->m_ams_appointment->ap_id = $ap_id;
            //             $this->m_ams_appointment->update();

            //             // [QUE] update next que_appointment (apm_parent_id)
            //             $this->load->model('que/m_que_appointment');
            //             $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            //             $appointment = $this->m_que_appointment->get_by_key()->row();

            //             // Add 30 minutes at apm_time
            //             $dateTime = new DateTime($post_data['ap_time']);
            //             $dateTime->modify('+30 minutes');
            //             $apm_time = $post_data['ap_time'] . " - " . $dateTime->format('H:i');

            //             $this->m_que_appointment->apm_parent_id = $appointment->apm_id;
            //             $this->m_que_appointment->apm_date = $ap_date;
            //             $this->m_que_appointment->apm_time = $apm_time;
            //             $this->m_que_appointment->apm_sta_id = 1; // 'A' นัดหมายสำเร็จ
            //             $this->m_que_appointment->apm_update_user = $this->session->userdata('us_id');;
            //             $this->m_que_appointment->update_by_apm_parent_id();
                        
            //             // // [AMS] update next notification_result statuse = 8 'D' ฉบับร่าง ผลการตรวจล่วงหน้า
            //             // // 1. this apm_id to find child apm_id by apm_id = apm_parent_id   
            //             // // 2. use child_apm.apm_id to find child_ntr
            //             // // 3. change status
            //             // $this->load->model('que/m_que_appointment');
            //             // $this->m_que_appointment->apm_parent_id = $post_data['ntr_apm_id'];
            //             // $child_apm = $this->m_que_appointment->get_by_apm_parent_id()-row();
            //             // $child_ntr = $this->M_ams_notification_result->get_ntr_by_apm_id($child_apm->apm_id);
            //             // $this->M_ams_notification_result->ntr_id = $child_ntr->ntr_id;
            //             // $this->M_ams_notification_result->ntr_ast_id = 8; // 'D' ฉบับร่าง ผลการตรวจล่วงหน้า
            //             // $this->M_ams_notification_result->change_noti();

            //             $for_exr_stde_id = $appointment->apm_stde_id;
            //             $for_exr_ntr_id = $child_ntr->ntr_id;
            //             $for_exr_ap_id = $ap_id;

            //             // [AMS] send email
            //             if($check == 'now'){
            //                 $this->send_email_api($ap_id);
            //             }
            //         }
                    
            //         // 20240901 Areerat - คอมเม้นไปก่อน เพราะ m_ams_appointment บันทึกจาก Api_services มาก่อนแล้ว
            //         // // [DIM] insert/update draft tool rows in DIM dim_examination_result
            //         // if ($is_have_draft_tools) {
            //         //     if(!empty($post_data['draft_eqs_id'])) {
            //         //         $this->load->model('dim/m_dim_examination_result');
            //         //         // $this->m_dim_examination_result->exr_ntr_id = $for_exr_ntr_id;
            //         //         $this->m_dim_examination_result->exr_ap_id = $for_exr_ap_id;
            //         //         $this->m_dim_examination_result->exr_status = 'R'; // ลบออกจากฉบับร่าง

            //         //         // 1. check if remove draft tool then change status = 'R' ลบออกจากฉบับร่าง
            //         //         $draft_exr_ids = $post_data['draft_exr_id'];
            //         //         if (!empty($draft_exr_ids)) {
            //         //             $exclude_ids = [];
            //         //             for ($i = 0; $i < count($draft_exr_ids); $i++) {
            //         //               if ($draft_exr_ids[$i] != 'undefined' && !empty($draft_exr_ids[$i])) {
            //         //                 $id = decrypt_id($draft_exr_ids[$i]);
            //         //                 if (!empty($id)) {
            //         //                   $exclude_ids[] = $id;
            //         //                 }
            //         //               }
            //         //             }
            //         //             if (!empty($exclude_ids)) {
            //         //               $exclude_ids_string = implode(',', $exclude_ids);
            //         //               $this->m_dim_examination_result->update_remove_draft_exclude_id($exclude_ids_string);
            //         //             }
            //         //         }

            //         //         // 2. insert draft
            //         //         // set variable
            //         //         $this->m_dim_examination_result->exr_pt_id = $post_data['ntr_pt_id'];
            //         //         $this->m_dim_examination_result->exr_order = null;
            //         //         $this->m_dim_examination_result->exr_ps_id = $post_data['ntr_ps_id'];
            //         //         $this->m_dim_examination_result->exr_status = 'D'; // บันทึกร่าง
            //         //         $this->m_dim_examination_result->exr_create_user = $this->session->userdata('us_id');
            //         //         // $this->m_dim_examination_result->exr_inspection_time = date("Y-m-d H:i:s");
            //         //         $this->m_dim_examination_result->exr_round = 1;
            //         //         $this->m_dim_examination_result->exr_stde_id = $for_exr_stde_id;

            //         //         $draft_eqs_ids = $post_data['draft_eqs_id'];
            //         //         foreach($eqs_ids as $key => $eqs_id) {
            //         //             // ถ้าเคยบันทึกแล้ว (have exr_id) จะไม่บันทึกซ้ำและไม่อัปเดต
            //         //             // decrypt id
            //         //             $draft_exr_id = decrypt_id($draft_exr_ids[$key]);
            //         //             if(empty($draft_exr_id)) {
            //         //                 // decrypt id
            //         //                 // $rm_id = decrypt_id($post_data['rm_id']);
            //         //                 $eqs_id = decrypt_id($eqs_id);
            //         //                 $this->m_dim_examination_result->exr_eqs_id = $eqs_id;

            //         //                 // save in DIM only
            //         //                 // exr_ip_internet, exr_ip_computer

            //         //                 $this->m_dim_examination_result->insert();
            //         //             }
            //         //         }
            //         //     }
            //         // }
            //     }
            // }

            // [WTS] insert log timeline in wts_notifications_department
		    $date = new DateTime();
            $this->load->model('wts/m_wts_notifications_department');
            $this->m_wts_notifications_department->ntdp_apm_id = $post_data['ntr_apm_id'];
            $this->m_wts_notifications_department->ntdp_loc_id = 8; // พบแพทย์ (สิ้นสุด)
            $this->m_wts_notifications_department->ntdp_seq = 8; // ตาม ntdp_loc_Id
            $this->m_wts_notifications_department->ntdp_date_start = $date->format('Y-m-d');
            $this->m_wts_notifications_department->ntdp_time_start = $date->format('H:i:s');
            $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
            $this->m_wts_notifications_department->ntdp_in_out = 0;
            $this->m_wts_notifications_department->ntdp_function = 'update_save_Noti_result';
            $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
            if(!empty($last_noti_dept)) {
                $this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
            } 
            $this->m_wts_notifications_department->insert();
            
            // [WTS] update finish date/time last_noti_dept in wts_notifications_department
            if(!empty($last_noti_dept)) {
                // Format both DateTime objects to 'Y-m-d H:i' (excluding seconds)
                if(!empty($last_noti_dept->ntdp_date_end) && !empty($last_noti_dept->ntdp_time_end)) {
                    $date_formatted = $date->format('Y-m-d H:i');
                    $end_date_formatted = (new DateTime($last_noti_dept->ntdp_date_end . ' ' . $last_noti_dept->ntdp_time_end))->format('Y-m-d H:i');
    
                    if ($date_formatted > $end_date_formatted) {
                        $this->m_wts_notifications_department->ntdp_sta_id = 4; // F - เลยระยะเวลา
                    } else {
                        $this->m_wts_notifications_department->ntdp_sta_id = 2; // Y - แจ้งเตือนแล้ว
                    }
    
                    $this->m_wts_notifications_department->ntdp_id = $last_noti_dept->ntdp_id;
                    $this->m_wts_notifications_department->ntdp_date_finish = $date->format('Y-m-d');
                    $this->m_wts_notifications_department->ntdp_time_finish = $date->format('H:i:s');
                    $this->m_wts_notifications_department->update_finish_see_doctor_by_key();
                }
            }
            
            // // [WTS] (old) update log timeline in wts_notifications_department
            // $this->load->model('wts/m_wts_notifications_department');
            // $this->m_wts_notifications_department->ntdp_apm_id = $post_data['ntr_apm_id'];
            // $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();

            // if (!empty($last_noti_dept)) { // update
            //     // 1. If next action is not goto DIM, then update finish date/time
            //     // 2. Else if have examination_result before, then update end date/time is plus minutes from wts_base_disease_time
            //     //    ประมาณว่าตรวจครั้งแรกเป็นกำหนดการสิ้นสุดปกติ แต่พอตรวจครั้งสองอาจจะต้องบวกเวลากำหนดการสิ้นสุดเพราะว่ามีการตรวจเพิ่ม
            //     $end_date_time_string = $last_noti_dept->ntdp_date_end . ' ' . $last_noti_dept->ntdp_time_end;
            //     $end_date = new DateTime($end_date_time_string);
            //     // if (!$is_go_to_dim) {
            //         // check status
            //         $finish_date = new DateTime();

            //         // Format both DateTime objects to 'Y-m-d H:i' (excluding seconds)
            //         $finish_date_formatted = $finish_date->format('Y-m-d H:i');
            //         $end_date_formatted = $end_date->format('Y-m-d H:i');

            //         if ($finish_date_formatted > $end_date_formatted) {
            //             $this->m_wts_notifications_department->ntdp_sta_id = 4; // F - เลยระยะเวลา
            //         } else {
            //             $this->m_wts_notifications_department->ntdp_sta_id = 2; // Y - แจ้งเตือนแล้ว
            //         }

            //         $this->m_wts_notifications_department->ntdp_date_finish = $finish_date->format('Y-m-d');
            //         $this->m_wts_notifications_department->ntdp_time_finish = $finish_date->format('H:i:00');
            //         $this->m_wts_notifications_department->update_finish_see_doctor();
            //     // } else {
            //     //     if ($is_have_exr_before) {
            //     //         // get wts_base_disease_time data
            //     //         $this->load->model('wts/m_wts_base_disease_time');
            //     //         $this->m_wts_base_disease_time->dst_id = $last_noti_dept->ntdp_dst_id; // 3 - พบหมอ
            //     //         $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     //         $end_date->modify("+$base_disease_time->dst_minute minutes");

            //     //         $this->load->model('wts/m_wts_notifications_department');
            //     //         $this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
            //     //         $this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:00');

            //     //         $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
            //     //         $this->m_wts_notifications_department->update_end_date_by_doctor();
            //     //     }
            //     // }
            // } else { // insert (worst case)
            //     // get que_appointment data
            //     $appointment = $this->m_que_appointment->get_appointment_by_id($post_data['ntr_apm_id'])->result_array();
            //     $this->m_wts_notifications_department->ntdp_ds_id = $appointment[0]['apm_ds_id'];

            //     // get base_route_department data
            //     $this->load->model('wts/m_wts_base_route_department');
            //     $this->m_wts_base_route_department->rdp_stde_id = $appointment[0]['apm_stde_id'];
            //     $this->m_wts_base_route_department->rdp_ds_id = $appointment[0]['apm_ds_id'];
            //     $base_route_department = $this->m_wts_base_route_department->get_by_stde_and_ds()->row();
            //     $this->m_wts_notifications_department->ntdp_rdp_id = $base_route_department->rdp_id;

            //     // get wts_base_disease_time data
            //     $this->load->model('wts/m_wts_base_disease_time');
            //     $this->m_wts_base_disease_time->dst_id = 3; // พบหมอ
            //     $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     $start_date = new DateTime();
            //     $this->m_wts_notifications_department->ntdp_date_start = $start_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_start = $start_date->format('H:i:00');
            //     $this->m_wts_notifications_department->ntdp_date_end = $start_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_end = $start_date->format('H:i:00');
            //     $this->m_wts_notifications_department->ntdp_dst_id = 3; // พบหมอ

            //     // 1. If next action is not goto DIM then save finish date/time and m_wts_notifications_department.ntdp_sta_id = แจ้งเตือนแล้ว
            //     // 2. Else if have examination_result before, 
            //     //      then dont save finish date/time and m_wts_notifications_department.ntdp_sta_id = รอแจ้งเตือน
            //     //      and save end date/time is plus minutes from wts_base_disease_time
            //     //      ประมาณว่าตรวจครั้งแรกเป็นกำหนดการสิ้นสุดปกติ แต่พอตรวจครั้งสองอาจจะต้องบวกเวลากำหนดการสิ้นสุดเพราะว่ามีการตรวจเพิ่ม
            //     // if (!$is_go_to_dim) {
            //         $this->m_wts_notifications_department->ntdp_date_finish = $start_date->format('Y-m-d');
            //         $this->m_wts_notifications_department->ntdp_time_finish = $start_date->format('H:i:00');
            //         $this->m_wts_notifications_department->ntdp_sta_id = 2; // แจ้งเตือนแล้ว
            //     // } else {
            //     //     if ($is_have_exr_before) {
            //     //         // get wts_base_disease_time data
            //     //         $this->load->model('wts/m_wts_base_disease_time');
            //     //         $this->m_wts_base_disease_time->dst_id = $this->m_wts_notifications_department->ntdp_dst_id; // 3 - พบหมอ
            //     //         $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     //         $end_date = clone $start_date;
            //     //         $end_date->modify("+$base_disease_time->dst_minute minutes");
            //     //         $this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
            //     //         $this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:00');

            //     //         $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
            //     //     }
            //     // }

            //     $this->m_wts_notifications_department->ntdp_seq = 1;
            //     $this->m_wts_notifications_department->insert();
            // }

            // $data['returnUrl'] = base_url() . 'index.php/ams/Notification_result';
            $data['returnUrl'] = base_url() . 'index.php/wts/Manage_queue_trello';
            $data['status_response'] = $this->config->item('status_response_success');
        }

		$result = array('data' => $data);
		echo json_encode($result);
    }

    /*
	* Notification_result_update_tools
	* for insert/update [DIM] examination result
	* @input data form
	* $output response
	* @author Areerat Pongurai
	* @Create Date 07/08/2024
	*/

	// boom 18/9/2567
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

  function Notification_result_update_tools($id = null)
    {
        $id = decrypt_id($id); // ntr_id
        $post_data = $this->input->post();

        $this->M_ams_notification_result->ntr_id = $id;
        $this->M_ams_notification_result->ntr_apm_id = $post_data['ntr_apm_id'];
        $this->M_ams_notification_result->ntr_pt_id = $post_data['ntr_pt_id'];
        $this->M_ams_notification_result->ntr_ps_id = $post_data['ntr_ps_id'];
        $this->M_ams_notification_result->ntr_ntf_id = $post_data['ntr_ntf_id'];
        $al_data = $this->M_ams_notification_result->get_ams_base_alarm($post_data['ntr_ntf_id'])->row();

        // If doctor want patient to be examined with medical equipment then input equipment.
        if (isset($post_data['eqs_id']) && !empty($post_data['eqs_id'])) {
            $eqs_ids = $post_data['eqs_id'];
            foreach($eqs_ids as $key => $eqs_id) {
                if(empty($eqs_id))
                    $data['error_inputs'][] = (object) ['name' => $post_data['eqs_id_name'][$key], 'error' => $this->config->item('text_invalid_default')];
            }
        }

        if(isset($data['error_inputs']) && count($data['error_inputs']) > 0) { // case show error from conditions
            $data['status_response'] = $this->config->item('status_response_error');
            $data['message_dialog'] = $this->config->item('text_invalid_inputs');
        } else {
            // If doctor want patient to be examined with medical equipment (got to DIM).
            $is_go_to_dim = true;
            $this->M_ams_notification_result->ntr_ast_id = 5; // รอผลตรวจจากเครื่องมือหัตถการ
            // will check if checked and no select medical equipment then alert

            // If have data notification result before.
            if (!empty($id)) {
                $this->M_ams_notification_result->ntr_update_user = $this->session->userdata('us_id');
                $this->M_ams_notification_result->ntr_update_date = date('Y-m-d H:i:s');
                $this->M_ams_notification_result->update();
            } else { // Else no have data notification result before but from QUE.appointment.
                $this->M_ams_notification_result->ntr_create_user = $this->session->userdata('us_id');
                $this->M_ams_notification_result->ntr_create_date = date('Y-m-d H:i:s');
                $this->M_ams_notification_result->insert();
                $id = $this->M_ams_notification_result->last_insert_id;
            }

            // [DIM] If doctor want patient to be examined with medical equipment, then add rows in DIM dim_examination_result
            // $is_have_exr_before = false;
            if(isset($post_data['eqs_id'])) {
                // set variable
                $this->load->model('dim/m_dim_examination_result');
                $this->m_dim_examination_result->exr_pt_id = $post_data['ntr_pt_id'];
                $this->m_dim_examination_result->exr_ntr_id = $id;
                $this->m_dim_examination_result->exr_order = null;
                $this->m_dim_examination_result->exr_ps_id = $post_data['ntr_ps_id'];
                $this->m_dim_examination_result->exr_status = 'W';
                $this->m_dim_examination_result->exr_create_user = $this->session->userdata('us_id');
                $this->m_dim_examination_result->exr_update_user = $this->session->userdata('us_id');
                $this->m_dim_examination_result->exr_inspection_time = date("Y-m-d H:i:s");

                // เช็ค max_exr_round โดยจะเอาค่าแค่ครั้งเดียวในการกดสั่งตรวจหนึ่งครั้ง
                $max_exr_round = $this->m_dim_examination_result->get_check_round_by_not_ntr_id()->result_array();
                if (!empty($max_exr_round) && count($max_exr_round) == 1 && !empty($max_exr_round[0]['max_round']))
                    $this->m_dim_examination_result->exr_round = $max_exr_round[0]['max_round'] + 1;
                else $this->m_dim_examination_result->exr_round = 1;

                // set exr_stde_id from que_appointment
                $this->load->model('que/m_que_appointment');
                $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
                $appointment = $this->m_que_appointment->get_by_key()->row();
                $this->m_dim_examination_result->exr_stde_id = $appointment->apm_stde_id;
                    
                // get patient data
                $this->load->model('ums/m_ums_patient');
                $this->m_ums_patient->pt_id = $post_data['ntr_pt_id'];
                $patient = $this->m_ums_patient->get_by_key()->row();

                $eqs_ids = $post_data['eqs_id'];
                $exr_ids = $post_data['exr_id'];
                foreach($eqs_ids as $key => $eqs_id) {
                    // decrypt id
                    // $rm_id = decrypt_id($post_data['rm_id']);
                    $eqs_id = decrypt_id($eqs_id);
                    $this->m_dim_examination_result->exr_eqs_id = $eqs_id;

                    // // check have examination_result before
                    // $exr_ids_check = $this->m_dim_examination_result->get_exr_id_by_ntr_id()->result_array();
                    // if (!empty($exr_ids_check))
                    //     $is_have_exr_before = true;

                    // get equipment data
                    $this->load->model('eqs/m_eqs_equipments');
                    $this->m_eqs_equipments->eqs_id = $eqs_id;
                    $equipment = $this->m_eqs_equipments->get_by_key()->row();

                    // setting exr_directory
                    // format : [HN ของผู้ป่วย]/[ไอดีรอบการเข้าใช้บริการ]_[วันที่]_[เวลา]  =>  $path_folder_hn_visit_date
                    $folder_tool = $equipment->eqs_folder;
                    if(!empty($equipment->eqs_folder)) { // if this tool have directory to save in NAS
                        // $folder_patient = 'HN_' . $patient->pt_member;
    
                        $date = new DateTime($this->m_dim_examination_result->exr_inspection_time);
                        $format_date = $date->format('Ymd_Hi');
                        // $folder_date = $format_date . '_' . $this->m_dim_examination_result->exr_round;
    
                        $path_folder_hn_visit_date = $patient->pt_member . '/' . $appointment->apm_visit . '_' .$format_date; // new path

                        $pathuploads = $this->config->item('dim_nas_path');
                        // $path_folder_patient = $folder_tool . '/' . $folder_patient . '/' . $folder_date;
                        $exr_directory = $folder_tool . '/' . $path_folder_hn_visit_date;
                        $this->m_dim_examination_result->exr_directory = $exr_directory; // save at AMS
    
                        // create directory by exr_directory
                        $path = $pathuploads . $exr_directory;
                        // [SeeDB] Check if the folder exists
                        if (!is_dir($path)) {
                            // Try to create the folder
                            if (mkdir($path, 0777, true)) {
                                // echo "Folder created successfully: " . $path;
                            } else {
                                // echo "Failed to create folder: " . $path;
                            }
                        }
    
                        // 0. [NAS] Define variables
                        $nas_server_ip = $this->config->item('dim_nas_ip');
                        $nas_port = $this->config->item('dim_nas_port');
                        $nas_remote_share = "//$nas_server_ip/$folder_tool";
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
                        $destination_folder = "$local_mount_point/$path_folder_hn_visit_date";
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
                        } else {
    
                        }
                        // else echo "No have to create folder<br>";
    
                        // save in DIM only
                        // exr_ip_internet, exr_ip_computer

                    } else {
                        $this->m_dim_examination_result->exr_directory = null;
                        // $this->m_dim_examination_result->exr_status = 'Y'; // บันทึก
                    }

                    $exr_id_temp = decrypt_id($exr_ids[$key]);
                    if(!empty($exr_id_temp)) {
                        // update status 'D' ฉบับร่างการเลือกเครื่องมือ => 'W' รอตรวจ
                        $this->m_dim_examination_result->exr_id = $exr_id_temp;
                        $this->m_dim_examination_result->update_status_dir();
                    }
                    else
                        $this->m_dim_examination_result->insert();
                }
            }

            // [QUE] Update original que_appointment status is go to [DIM] examination tool.
            $this->load->model('que/m_que_appointment');
            $this->m_que_appointment->apm_id = $post_data['ntr_apm_id'];
            $this->m_que_appointment->apm_sta_id = 11; // 'TW' กำลังตรวจในห้องปฏิบัติการ
            $this->m_que_appointment->update_status();
            
            // คิวรีหาเวลา loc_time จาก wts_location
            $loc_time_query = $this->db->query('SELECT loc_time FROM see_wtsdb.wts_location WHERE loc_seq = "7"');
            $loc_time = $loc_time_query->row()->loc_time; // สมมติว่า loc_time เป็นค่าจำนวนเวลาในหน่วยนาที
            // แปลงเวลาจาก apm_date และ ntdp_time_start
            // กำหนดค่าเริ่มต้นสำหรับเวลาปัจจุบัน
            $current_date = new DateTime();
            $ntdp_time_end = clone $current_date; // สำเนา object $current_date เพื่อใช้งานในส่วนอื่น
            $ntdp_time_end->modify('+' . $loc_time . ' minutes');
            // คำนวณค่า ntdp_time_end และ ntdp_date_end

            $ntdp = $this->db->query('SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = "'.$post_data['ntr_apm_id'].'" ORDER BY ntdp_id DESC LIMIT 1');
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
    
    
            // Update ข้อมูลในตาราง wts_notifications_department ที่มี seq = 1 และ apm_id ที่ตรงกัน
            $this->db->where('ntdp_apm_id', $ntdp_apm_id_1);
            $this->db->where('ntdp_seq', $ntdp_seq_1);
            $this->db->update('see_wtsdb.wts_notifications_department', $wts_update_data);






            $sql_user = $this->m_que_appointment->get_user($this->session->userdata('us_ps_id'))->result_array();
            $appointment_dep = $this->m_que_appointment->get_appointment_by_id($post_data['ntr_apm_id'])->result_array();
            $pdo = $this->connect_his_database();
            
            // Prepare SQL query outside the loop
            $sql = "INSERT INTO tabDoctorRoom (visit, sender_name, sender_last_name, sending_location_room, datetime_sent, doctor_room, location) 
            VALUES (:visit, :sender_name, :sender_last_name, :sending_location_room, :datetime_sent, :doctor_room, :location)";
            $stmt = $pdo->prepare($sql);

            $sql_nd = $this->db->query("SELECT * FROM see_wtsdb.wts_notifications_department WHERE ntdp_apm_id = '".$post_data['ntr_apm_id']."' AND ntdp_loc_Id = '8'");
            
            // if ($sql_nd->num_rows() == 0) { // ถ้าไม่มีค่า // ถ้าแพทย์ตรวจแล้วบอกให้ไปตรวจเครื่องมือ จะแสดงห้องนั้น แต่ปิดไว้ก่อน
              switch ($appointment_dep[0]['stde_name_th']) {
                case 'ภาคจักษุวิทยา (EYE)':
                    // $sending_location_room = $this->config->item('wts_room_ood');
                    $sending_location_room = 5;
                    break;
                case 'ภาคโสต ศอ นาสิก (ENT)':
                // case 'แผนกผู้ป่วยนอกสูตินรีเวช':
                // case 'แผนกผู้ป่วยนอกอายุรกรรม':
                case 'จิตแพทย์':
                    // $sending_location_room = $this->config->item('wts_room_floor2');
                    $sending_location_room = 7;
                    break;
                case 'ภาคทันตกรรม (DEN)':
                    // $sending_location_room = $this->config->item('wts_room_dd');
                    $sending_location_room = 10;
                    break;
                case 'แผนกศูนย์เคลียร์เลสิค':
                    // $sending_location_room = $this->config->item('wts_room_rel');
                    $sending_location_room = 28;
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
            // } else {
            //   $sql_room = $this->m_que_appointment->get_room($post_data['ntr_apm_id'])->result_array();
            //   $sending_location_room = $sql_room[0]['rm_his_id'];
            // }
            $doctor_room = '26'; // ห้องเครื่องมือพิเศษ      
            $location = $this->session->userdata('us_dp_id');  
            $datetime_sent = (new DateTime())->format('Y-m-d H:i:s');
            $stmt->bindParam(':visit', $appointment_dep[0]['apm_visit']);
            $stmt->bindParam(':sender_name', $sql_user[0]['ps_fname']);
            $stmt->bindParam(':sender_last_name', $sql_user[0]['ps_lname']);
            $stmt->bindParam(':sending_location_room', $sending_location_room);
            $stmt->bindParam(':datetime_sent', $datetime_sent);
            $stmt->bindParam(':doctor_room', $doctor_room);
            $stmt->bindParam(':location', $location);
            
            // Execute the query for each room
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                // Handle exception if needed
                echo "Error: " . $e->getMessage();
            }
            // [WTS] insert log timeline in wts_notifications_department
            $this->load->model('wts/m_wts_notifications_department');
            $this->m_wts_notifications_department->ntdp_apm_id = $post_data['ntr_apm_id'];
            $this->m_wts_notifications_department->ntdp_loc_id = 7; // ตรวจเครื่องมือ (เริ่ม)
            $this->m_wts_notifications_department->ntdp_seq = 7; // ตาม ntdp_loc_Id
            $this->m_wts_notifications_department->ntdp_date_start = date('Y-m-d');
            $this->m_wts_notifications_department->ntdp_time_start = date('H:i:s');
            $this->m_wts_notifications_department->ntdp_date_end = $ntdp_time_end->format('Y-m-d');
            $this->m_wts_notifications_department->ntdp_time_end = $ntdp_time_end->format('H:i:s');
            $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
            $this->m_wts_notifications_department->ntdp_in_out = 0;
            $this->m_wts_notifications_department->ntdp_loc_ft_Id = $doctor_room;
            $this->m_wts_notifications_department->ntdp_function = 'Notification_result_update_tools';
            $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
            if(!empty($last_noti_dept)) {
                $this->m_wts_notifications_department->ntdp_loc_cf_id = $last_noti_dept->ntdp_loc_Id; // ก่อนหน้านั้นมาจาก location ไหน
            } 
            $this->m_wts_notifications_department->insert();
            // // [WTS] (old) update log timeline in wts_notifications_department
            // $this->load->model('wts/m_wts_notifications_department');
            // $this->m_wts_notifications_department->ntdp_apm_id = $post_data['ntr_apm_id'];
            // $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();

            // if (!empty($last_noti_dept)) { // update
            //     // 1. If next action is not goto DIM, then update finish date/time
            //     // 2. Else if have examination_result before, then update end date/time is plus minutes from wts_base_disease_time
            //     //    ประมาณว่าตรวจครั้งแรกเป็นกำหนดการสิ้นสุดปกติ แต่พอตรวจครั้งสองอาจจะต้องบวกเวลากำหนดการสิ้นสุดเพราะว่ามีการตรวจเพิ่ม
            //     $end_date_time_string = $last_noti_dept->ntdp_date_end . ' ' . $last_noti_dept->ntdp_time_end;
            //     $end_date = new DateTime($end_date_time_string);
                
            //     // get wts_base_disease_time data
            //     $this->load->model('wts/m_wts_base_disease_time');
            //     $this->m_wts_base_disease_time->dst_id = $last_noti_dept->ntdp_dst_id; // 3 - พบหมอ
            //     $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     $end_date->modify("+$base_disease_time->dst_minute minutes");

            //     $this->load->model('wts/m_wts_notifications_department');
            //     $this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:00');

            //     $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน
            //     $this->m_wts_notifications_department->update_end_date_by_doctor();
            // } else { // insert (worst case)
            //     // get que_appointment data
            //     $appointment = $this->m_que_appointment->get_appointment_by_id($post_data['ntr_apm_id'])->result_array();
            //     $this->m_wts_notifications_department->ntdp_ds_id = $appointment[0]['apm_ds_id'];

            //     // get base_route_department data
            //     $this->load->model('wts/m_wts_base_route_department');
            //     $this->m_wts_base_route_department->rdp_stde_id = $appointment[0]['apm_stde_id'];
            //     $this->m_wts_base_route_department->rdp_ds_id = $appointment[0]['apm_ds_id'];
            //     $base_route_department = $this->m_wts_base_route_department->get_by_stde_and_ds()->row();
            //     $this->m_wts_notifications_department->ntdp_rdp_id = $base_route_department->rdp_id;

            //     // get wts_base_disease_time data
            //     $this->load->model('wts/m_wts_base_disease_time');
            //     $this->m_wts_base_disease_time->dst_id = 3; // พบหมอ
            //     $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     $start_date = new DateTime();
            //     $this->m_wts_notifications_department->ntdp_date_start = $start_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_start = $start_date->format('H:i:00');
            //     $this->m_wts_notifications_department->ntdp_date_end = $start_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_end = $start_date->format('H:i:00');
            //     $this->m_wts_notifications_department->ntdp_dst_id = 3; // พบหมอ

            //     // 1. If next action is not goto DIM then save finish date/time and m_wts_notifications_department.ntdp_sta_id = แจ้งเตือนแล้ว
            //     // 2. Else if have examination_result before, 
            //     //      then dont save finish date/time and m_wts_notifications_department.ntdp_sta_id = รอแจ้งเตือน
            //     //      and save end date/time is plus minutes from wts_base_disease_time
            //     //      ประมาณว่าตรวจครั้งแรกเป็นกำหนดการสิ้นสุดปกติ แต่พอตรวจครั้งสองอาจจะต้องบวกเวลากำหนดการสิ้นสุดเพราะว่ามีการตรวจเพิ่ม
                
            //     // get wts_base_disease_time data
            //     $this->load->model('wts/m_wts_base_disease_time');
            //     $this->m_wts_base_disease_time->dst_id = $this->m_wts_notifications_department->ntdp_dst_id; // 3 - พบหมอ
            //     $base_disease_time = $this->m_wts_base_disease_time->get_by_key()->row();

            //     $end_date = clone $start_date;
            //     $end_date->modify("+$base_disease_time->dst_minute minutes");
            //     $this->m_wts_notifications_department->ntdp_date_end = $end_date->format('Y-m-d');
            //     $this->m_wts_notifications_department->ntdp_time_end = $end_date->format('H:i:00');

            //     $this->m_wts_notifications_department->ntdp_sta_id = 1; // รอแจ้งเตือน

            //     $this->m_wts_notifications_department->ntdp_seq = 1;
            //     $this->m_wts_notifications_department->insert();
            // }

            // $data['returnUrl'] = base_url() . 'index.php/ams/Notification_result';
            $data['status_response'] = $this->config->item('status_response_success');
        }

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function cancel_noti($ntr_id)
    { //id ของหมายเลขติดตาม 
        $this->M_ams_notification_result->ntr_id = $ntr_id; //หากสถานะเป็น 0
        $this->M_ams_notification_result->ntr_ast_id = '1'; //เปลี่ยนสถานะเป็น 2 : ลบ
        $this->M_ams_notification_result->change_noti(); //ลบโดยเปลี่ยนสถานะเป็น 2

        // Prepare the response
        $response = array(
            'status_response' => $this->config->item('status_response_success'),
            'header' => 'ยกเลิกการแจ้งเตือนสำเร็จ',
            'body' => 'การแจ้งเตือนถูกยกเลิกเรียบร้อยแล้ว',
            'returnUrl' => base_url() . 'index.php/ams/Notification_result'
        );

        echo json_encode($response);
    }

    public function do_noti($ntr_id)
    { //id ของหมายเลขติดตาม 
        $this->M_ams_notification_result->ntr_id = $ntr_id; //หากสถานะเป็น 0
        $this->M_ams_notification_result->ntr_ast_id = '4'; //เปลี่ยนสถานะเป็น 2 : ลบ
        $this->M_ams_notification_result->change_noti(); //ลบโดยเปลี่ยนสถานะเป็น 2

        // Prepare the response
        $response = array(
            'status_response' => $this->config->item('status_response_success'),
            'header' => 'แจ้งเตือนสำเร็จ',
            'body' => 'การแจ้งเตือนเรียบร้อยแล้ว',
            'returnUrl' => base_url() . 'index.php/ams/Notification_result'
        );

        echo json_encode($response);
    }

    /*
	* Notification_result_get_exr
	* for redirect to Notification_result/update_form for show examination result
	* @input 
            apm_visit: [QUE] que_appointment visit
            stde_name (structure_detail_name): [HR] ชื่อแผนก
	* $output notification_results data screen
	* @author Areerat Pongurai
	* @Create Date 02/09/2564
	*/
    public function Notification_result_get_exr($apm_visit, $stde_name, $from_ams = '') {
        // 1 check IP access
        if(empty($from_ams)) {
            $allowed_ips = $this->config->item('ams_ip_address_access'); // List of allowed IP addresses
            $visitor_ip = $_SERVER['REMOTE_ADDR']; // Get the visitor's IP address
            if (!in_array($visitor_ip, $allowed_ips)) 
                return $this->error();
        }
        // 2 check แผนก
        $stde_name = urldecode($stde_name);
        $this->load->model('hr/structure/m_hr_structure_detail');
        $result_stde = $this->m_hr_structure_detail->get_stde_id_by_name($stde_name);
        if(empty($result_stde)) // case แผนก not found
            return $this->error();
        
        // 3 check คิว
        $this->load->model('que/m_que_appointment');
        $result_apm = $this->m_que_appointment->check_visit_and_stde_id($apm_visit, $result_stde[0]['stde_id'])->result_array();
        if(empty($result_apm)) // case คิวผู้ป่วย not found
            return $this->error();
        // 4 check examination result
        $this->load->model('ams/m_ams_notification_result');
        $result_ntr = $this->m_ams_notification_result->get_ntr_by_apm_id($result_apm[0]['apm_id'])->result_array();
        if(empty($result_ntr)) // case คิวผู้ป่วย not found
            return $this->error();
        // 5 encrypt ntr_id
        $ntr_id = encrypt_id($result_ntr[0]['ntr_id']);

        // 6 get Notification_result data
        $data = $this->Notification_result_get_data($ntr_id);
        $data['actor'] = "doctor";
        $data['is_view'] = 1;

        // 7 get all Notification_result data // ทุก visit ของผู้ป่วยคนนั้น
        // 7.1 ถ้า visit นั้นมี ds_id   => scope Notification_result datas in que_appoinment.apm_ds_id
        // 7.2 ถ้า visit นั้นไม่มี ds_id => scope Notification_result datas in que_appoinment.apm_stde_id
        $all_apms = $this->m_que_appointment->get_all_tool_exr_of_patient($data['detail']->apm_pt_id, $data['detail']->apm_stde_id, $data['detail']->apm_ds_id)->result_array();
        foreach ($all_apms as $index => $apm) {
            switch($apm['exr_status']) {
                case 'W': 
                    $exr_status_text = 'รอการตรวจ'; 
                    $exr_status_class = 'text-warning'; 
                    break;
                case 'Y': 
                    $exr_status_text = 'บันทึกสำเร็จ'; 
                    $exr_status_class = 'text-success'; 
                    break;
                case 'C': 
                    $exr_status_text = 'ยกเลิกการตรวจ'; 
                    $exr_status_class = 'text-danger'; 
                    break;
                default: 
                    $exr_status_text = 'รอการตรวจ'; 
                    $exr_status_class = 'text-warning'; 
                    break;
            }
            $all_apms[$index]['exr_status_text'] = $exr_status_text;
            $all_apms[$index]['exr_status_class'] = $exr_status_class;
        }
        $data['history_apms'] = $all_apms;


        // menu active อาจจะไม่ต้องระบุชัดเจน เพราะ user เข้าสู่หน้าจอนี้โดยไม่ต้อง login
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');

        // $body = 'ams/notification_result/v_notification_result_update_form';
        $body = 'ams/notification_result/v_notification_result_doctor_form';
        $this->header();
        $this->sidebar();
        // $this->topbar();
        $this->main($data);
        $this->load->view($body,$data);
        $this->footer();
        $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
    }

    /*
	* Notification_result_get_all_tools_patient
	* get Notification_result data
	* @input id = ntr_id(Notification_result id)
	* $output (AMS)Notification_result and (DIM)Examination_result data
	* @author Areerat Pongurai
	* @Create Date 02/09/2024
	*/
    public function Notification_result_get_all_tools_patient($pt_id, $stde_id, $ds_id = null) {
        $draw = intval($this->input->post('draw'));
        // 7 get all Notification_result data // ทุก visit ของผู้ป่วยคนนั้น
        // 7.1 ถ้า visit นั้นมี ds_id   => scope Notification_result datas in que_appoinment.apm_ds_id
        // 7.2 ถ้า visit นั้นไม่มี ds_id => scope Notification_result datas in que_appoinment.apm_stde_id
        $this->load->model('que/m_que_appointment');
        $all_apms = $this->m_que_appointment->get_all_tool_exr_of_patient($pt_id, $stde_id, $ds_id)->result_array();

        $datatable = [];
        if (!empty($all_apms)) {
            foreach ($all_apms as $index => $exr) {
                $encrypt_exr_eqs_id = encrypt_id($exr['exr_eqs_id']);
                $encrypt_apm_pt_id = encrypt_id($exr['apm_pt_id']);
                $encrypt_ds_id = encrypt_id($ds_id);
                switch($exr['exr_status']) {
                    case 'W': 
                        $exr_status_text = 'รอการตรวจ'; 
                        $exr_status_class = 'text-warning'; 
                        break;
                    case 'Y': 
                        $exr_status_text = 'บันทึกสำเร็จ'; 
                        $exr_status_class = 'text-success'; 
                        break;
                    case 'C': 
                        $exr_status_text = 'ยกเลิกการตรวจ'; 
                        $exr_status_class = 'text-danger'; 
                        break;
                    default: 
                        $exr_status_text = 'รอการตรวจ'; 
                        $exr_status_class = 'text-warning'; 
                        break;
                }
                if(!empty($ds_id))
                    $btn = '<button type="button" title="ดูผลตรวจ" class="btn btn-info" onclick="loadModalExrs(\''.$encrypt_exr_eqs_id.'\', \''.$encrypt_apm_pt_id.'\', \''.$encrypt_ds_id.'\')"><i class="bi-search"></i></button>';
                else
                    $btn = '<button type="button" title="ดูผลตรวจ" class="btn btn-info" onclick="loadModalExrs(\''.$encrypt_exr_eqs_id.'\', \''.$encrypt_apm_pt_id.'\')"><i class="bi-search"></i></button>';
                $datatable[] = [
                    'order' => '<div class="text-center">'.($index + 1).'</div>',
                    'rm_id' => $exr['rm_name'],
                    'eqs_id' => $exr['eqs_name'],
                    'apm_date' => '<div class="text-center">'.(convertToThaiYear($exr['apm_date'], false)).'</div>',
                    'sta_text' => '<div class="text-center '.$exr_status_class.'">'.$exr_status_text.'</div>',
                    'actions' => '<div class="text-center option">'.$btn.'</div>'
                ];
            }
        } else {
            // 
        }

        $response = [
            'draw' => $draw,
            'recordsTotal' => count($all_apms),
            'recordsFiltered' => count($all_apms),
            'data' => $datatable,
            // 'badge' => $badge
        ];

        echo json_encode($response);
    }
    

    /*
	* Notification_result_get_all_docs_by_tool
	* get all DIM - examination result files by tool(eqs_id)
	* @input 
            eqs_id (equipments id): ไอดีเครื่องมือ
            ps_id (patient id): ไอดีผู้ป่วย
            ds_id (disease id): ไอดีโรค
	* $output modal screen of all examination result files
	* @author Areerat Pongurai
	* @Create Date 05/09/2024
	*/
    function Notification_result_get_all_docs_by_tool($exr_eqs_id, $apm_pt_id, $apm_stde_id, $apm_ds_id = null)
    {
        $exr_eqs_id = decrypt_id($exr_eqs_id);
        $apm_pt_id = decrypt_id($apm_pt_id);
        $apm_stde_id = decrypt_id($apm_stde_id);
        $apm_ds_id = decrypt_id($apm_ds_id);

        $this->load->model('dim/m_dim_examination_result');
        // get DIM all examination result
        $exrs = $this->m_dim_examination_result->get_exr_by_tool_and_pt_id($exr_eqs_id, $apm_pt_id, $apm_stde_id, $apm_ds_id)->result_array();
        foreach ($exrs as $index => $exr_id) {
            // get DIM each examination result detail
            $this->m_dim_examination_result->exr_id = $exr_id['exr_id'];
            $exam_result = $this->m_dim_examination_result->get_detail_by_id()->result_array();
            if(!empty($exam_result)) {
                $exr = $exam_result[0];
                // $data['exam_result'] = $exr;

                // get id files from dim_examination_result_doc
                $this->load->model('dim/m_dim_examination_result_doc');
                $this->m_dim_examination_result_doc->exrd_exr_id = $exr_id;
                $examination_result_docs = $this->m_dim_examination_result_doc->get_by_examination_result_id()->result_array();
                // $names = ['exrd_id']; // object name need to encrypt
                // $examination_result_docs = encrypt_arr_obj_id($examination_result_docs, $names);

                // $names = ['exr_id']; // object name need to encrypt
                // $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

                // // get all DIM examination result for ddl tools
                // $this->load->model('dim/M_dim_examination_result');
                // $this->M_dim_examination_result->exr_ntr_id = $ntr_id;
                // $exam_results = $this->M_dim_examination_result->get_by_ntr_id()->result_array();
                // $names = ['exr_id']; // object name need to encrypt
                // $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

                $files = array();
                if (!empty($exr['exr_directory'])) {
                    // Connect with NAS for get file data
                    // 0. Define variables
                    $nas_server_ip = $this->config->item('dim_nas_ip');
                    $nas_port = $this->config->item('dim_nas_port');

                    $nas_target_folder = $this->config->item('dim_nas_share_path') . $exr['exr_directory'];

                    // 1. Check if the NAS server is reachable
                    $ping_command = "ping -c 1 $nas_server_ip";
                    exec($ping_command, $output, $return_var);
                    if ($return_var !== 0) {
                        die("Failed to reach NAS server, code: $return_var, output: " . implode("\n", $output));
                    }

                    // 2. Check if nas target directory exists
                    if (is_dir($nas_target_folder)) {
                        if ($handle = opendir($nas_target_folder)) {
                            $nas_files = scandir($nas_target_folder);
                            $nas_files = array_diff($nas_files, array('.', '..'));

                            foreach ($nas_files as $file) {
                                $path = $nas_target_folder . '/' . $file;
                                if (file_exists($path)) {
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
                                        $pathdownload = base_url() . "index.php/dim/Getpreview?path=" . bin2hex($path);
                                        $type = mime_content_type($path);

                                        $files[] = array(
                                            'name' => $file,
                                            'url' => $pathdownload,
                                            'type' => $type,
                                            'exr_id' => $exr['exr_id'],
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
                }

                $exr['exr_docs'] = [];
                if (!empty($files))
                    $exr['exr_docs'] = $files;
                $exrs[$index]['detail'] = $exr;
                // $data['exr_docs'] = [];
                // if (!empty($files))
                //     $data['exr_docs'] = $files;
            }
        }
        $data['exrs'] = $exrs;
        // die(pre($exrs));

        // // get DIM all examination result by ntr_id for select2
        // $this->m_dim_examination_result->exr_ntr_id = $data['exam_result']['exr_ntr_id'];
        // $exam_results = $this->m_dim_examination_result->get_by_ntr_id()->result_array();
        // // encrypt id
        // $names = ['exr_id']; // object name need to encrypt
        // $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        // distinct tools
        $this->load->model('que/m_que_appointment');
        $all_apms = $this->m_que_appointment->get_all_tool_exr_of_patient($apm_pt_id, $apm_stde_id, $apm_ds_id)->result_array();
        $exam_results = [];
        foreach ($all_apms as $index => $exr) {
            $tool['exr_eqs_id'] = $exr['exr_eqs_id'];
            $tool['apm_pt_id'] = $apm_pt_id;
            $tool['apm_stde_id'] = $apm_stde_id;
            $tool['apm_ds_id'] = $apm_ds_id;
            $tool['eqs_name'] = $exr['eqs_name'];
            $tool['rm_name'] = $exr['rm_name'];

            $exam_results[] = $tool;
        }
        // Filter out duplicates by serializing the arrays and then unserializing them
        $exam_results = array_map("unserialize", array_unique(array_map("serialize", $exam_results)));
        // encrypt id
        $names = ['exr_eqs_id', 'apm_pt_id', 'apm_stde_id', 'apm_ds_id']; // object name need to encrypt
        // $names = ['exr_eqs_id']; // object name need to encrypt
        $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        // $data['exam_results'] = [];
        $this->load->view('ams/notification_result/v_notification_result_docs_modal_show', $data);
    }

    /*
	* Notification_result_get_data
	* get Notification_result data
	* @input id = ntr_id(Notification_result id)
	* $output (AMS)Notification_result and (DIM)Examination_result data
	* @author Areerat Pongurai
	* @Create Date 02/09/2024
	*/
    function Notification_result_get_data($id)
    {
        $data['id'] = $id;
        $id = decrypt_id($id);

		// [AMS] get notification_result
        $data['detail'] = $this->M_ams_notification_result->get_by_id($id)->row();
        // [AMS] appointment && [DIM] get draft tools
        $this->load->model('dim/m_dim_examination_result');
        $this->load->model('ams/m_ams_appointment');
        $this->m_ams_appointment->ap_ntr_id = $data['detail']->ntr_id;
        $appointment = $this->m_ams_appointment->get_by_ntr_id()->row();
        if (!empty($appointment)) {
            // [DIM] get draft tools
            $this->m_dim_examination_result->exr_ap_id = $appointment->ap_id;
            $exam_results = $this->m_dim_examination_result->get_by_ap_id()->result_array();
            $names = ['exr_id', 'exr_ap_id', 'exr_eqs_id', 'rm_id']; // object name need to encrypt
            $data['ap_tool_drafts'] = encrypt_arr_obj_id($exam_results, $names);
            
            // encrypt id
            $names = ['ap_id']; // object name need to encrypt
            $appointment->ap_id = encrypt_id($appointment->ap_id);
            $data['appointment'] = $appointment;
        }
        // // [DIM] get DIM examination result amount
        // $this->load->model('dim/M_dim_examination_result');
        // $this->M_dim_examination_result->exr_ntr_id = $data['detail']->ntr_id;
        // $amount_exr = $this->M_dim_examination_result->check_amount_by_ntr_id()->row();
        // $data['amount_exr'] = $amount_exr->amount_exr;

		// [DIM] get DIM examination result
        $this->m_dim_examination_result->exr_ntr_id = $id;
        $exam_results = $this->m_dim_examination_result->get_by_ntr_id()->result_array();
        $names = ['exr_id', 'exr_eqs_id', 'rm_id']; // object name need to encrypt
        $data['exam_results'] = encrypt_arr_obj_id($exam_results, $names);

        // [WTS] get WTS department_disease_tool (as default for select tools)
        $this->load->model('que/m_que_appointment');
        $this->load->model('wts/m_wts_department_disease_tool');
        $this->m_que_appointment->apm_id = $data['detail']->ntr_apm_id;
        $que_appointment = $this->m_que_appointment->get_by_key()->row();
        $is_null_ddt_ds_id = empty($que_appointment->apm_ds_id) ? true : false;
        // tool of disease
        $params = ['ddt_stde_id' => $que_appointment->apm_stde_id, 'ddt_ds_id' => $que_appointment->apm_ds_id, 'is_null_ddt_ds_id' => $is_null_ddt_ds_id];
        $tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();
        $names = ['ddt_id', 'ddt_eqs_id', 'eqs_rm_id']; // object name need to encrypt 
        $data['tools'] = encrypt_arr_obj_id($tools, $names);
        // tool default of stde
        $params = ['ddt_stde_id' => $que_appointment->apm_stde_id, 'is_null_ddt_ds_id' => true];
        $tools = $this->m_wts_department_disease_tool->get_tools_disease_by_params($params)->result_array();
        $data['tools_default'] = encrypt_arr_obj_id($tools, $names);

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

        return $data;
    }
}
