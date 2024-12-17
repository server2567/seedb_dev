<?php
/*
* Leaves_form
* จัดการการลา
* @input -
* $output จัดการการลา 
* @author Tanadon Tangjaimongkhon
* @Create Date 24/10/2567
*/
include_once('Leaves_Controller.php');

class Leaves_report extends Leaves_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();
        $this->controller .= "Leaves_form/";
        $this->view .= "leaves_form/";
        $this->load->model($this->config->item('hr_dir') . 'M_hr_person');
        $this->load->model($this->config->item('hr_dir') . 'M_hr_person_position');
        $this->load->model($this->model . 'M_hr_leave_history');
        $this->load->model($this->model . 'M_hr_leave_history_detail');
        $this->load->model($this->model . 'M_hr_leave_approve_flow');
        $this->load->model($this->model . 'M_hr_leave_approve_group_detail');
        $this->load->model($this->model . 'M_hr_leave_approve_person');
        $this->load->model($this->config->item('hr_dir') . 'M_hr_develop');
        $this->load->model($this->config->item('hr_dir') . 'base/M_hr_structure_position');
        $this->mn_active_url = uri_string();
    }

    /*
	* generate_report_leaves_one
	* ออกรายงานการลารูปแบบที่ 1
	* @input -
	* $output -
	* @author JIRADAT POMYAI
	* @Create Date 14/11/2567
	*/
    public function generate_report_leaves($lhis_id)
    {
        $lhis_id = decrypt_id($lhis_id);
        $result = $this->M_hr_leave_history->get_leave_history_by_lhis_id($lhis_id)->row();
        $doc_info = $this->M_hr_develop->get_develop_document_info('hr_leaves')->result();
        $doc_template = array_filter($doc_info, function ($obj) use ($result) {
            return ($obj->doc_id - 1) == $result->lhis_leave_id;
        });
        $header_path = APPPATH . 'views/hr/doc_template/doc_header.html';
        $footer_path = APPPATH . 'views/hr/doc_template/doc_footer.html';
        $header = file_get_contents($header_path);
        $footer = file_get_contents($footer_path);
        $leave_remaining = $this->M_hr_leave_history->get_leave_type_by_person($result->lhis_ps_id, $result->lhis_leave_id)->row();
        $this->M_hr_person->ps_id = $result->lhis_ps_id;
        $stde_group = '';
        $department = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
        foreach ($department as $key => $value) {
            if ($key == 0) {
                $stuc_person = $this->M_hr_person->get_person_position_by_ums_department_detail($result->lhis_ps_id, $value->dp_id)->row();
                if ($stuc_person->stde_name_th_group !== null) {
                    $stde_name_th_group = json_decode($stuc_person->stde_name_th_group, true);
                    $stde_group .= 'สังกัด<span class = "dotted-line">' . $value->dp_name_th . '</span> ตำแหน่ง <span class = "dotted-line">' . $stuc_person->alp_name . '</span> ตำแหน่งในโครงสร้าง <span class = "dotted-line">';
                    foreach ($stde_name_th_group as $stde_key => $stde_name) {
                        if ($stde_key > 0) {
                            $stde_group .= ',';
                        }
                        $stde_group .= ' ' . $stde_name['stde_name_th'];
                    }
                    $stde_group .= '<span>';
                } else {
                    $stde_group .= 'สังกัด <span class = "dotted-line">' . $value->dp_name_th . '</span> ตำแหน่ง <span class = "dotted-line">' . $stuc_person->alp_name . '</span> กลุ่มงาน -';
                }
                break;
            }
        }
        $html_file_path = APPPATH . 'views/hr/leaves/leaves_form/report_pdf/mpdf_generate_leave_' . $result->lhis_leave_id . '.html';
        $header_path = APPPATH . 'views/hr/doc_template/doc_header.html';
        $footer_path = APPPATH . 'views/hr/doc_template/doc_footer.html';

        // ตรวจสอบว่าไฟล์มีอยู่หรือไม่
        if (!file_exists($html_file_path)) {
            echo "ไฟล์ไม่พบเอกสารนี้";
            die;
        }
        $html = file_get_contents($html_file_path);
        $html = str_replace('{LEAVE_DATE}', $this->convertToThaiDate(date("Y-m-d")), $html);
        $html = str_replace('{ps_name}', $result->pf_name_abbr . ' ' . $result->ps_fname . ' ' . $result->ps_lname, $html);
        $html = str_replace('{lhis_topic}', $result->lhis_topic, $html);
        $html = str_replace('{lhis_start_date}', abbreDate2($result->lhis_start_date), $html);
        $html = str_replace('{lhis_end_date}', abbreDate2($result->lhis_end_date), $html);
        $html = str_replace('{stucture_detail}', $stde_group, $html);
        // $html = str_replace('adline_position',,$html);
        $html = str_replace('{lhis_num_day}', $result->lhis_num_day != 0 ? '<span class = "dotted-line">&nbsp;&nbsp;' . $result->lhis_num_day . '&nbsp;&nbsp;</span>' . ' วัน' : '', $html);
        $html = str_replace('{lhis_num_hour}', $result->lhis_num_hour != 0 ? '<span class = "dotted-line">&nbsp;&nbsp;' . $result->lhis_num_hour . '&nbsp;&nbsp;</span> ชั่วโมง' : '', $html);
        $html = str_replace('{lhis_num_minutes}', $result->lhis_num_minute != 0 ? '<span class = "dotted-line">&nbsp;&nbsp;' . $result->lhis_num_minute . '&nbsp;&nbsp;</span> นาที' : '', $html);
        $html = str_replace('{lhis_address}', $result->lhis_address ? '<span class = "dotted-line">' . $result->lhis_address . '</span>' : '-', $html);
        $html = str_replace('{write_at}', $result->lhis_write_place ? $result->lhis_write_place : '-', $html);
        $html = str_replace('{for_who}', $result->lhis_tell ? $result->lhis_tell : '-', $html);
        $html = str_replace('{ps_phone}', $result->psd_phone ? '<span class = "dotted-line">' . $result->psd_phone . '</span>' : '-', $html);
        // $html = str_replace('{LEAVE_OLD}', $leave_remaining->lsum_num_day ? $leave_remaining->lsum_num_day . ' วัน' : '-', $html);
        // $html = str_replace('{LEAVE_NEW}', $result->lhis_num_day ? $result->lhis_num_day . ' วัน' : '-', $html);
        // $html = str_replace('{LEAVE_SUM}', ($result->lhis_num_day + $leave_remaining->lsum_num_day) ? ($result->lhis_num_day + $leave_remaining->lsum_num_day) . ' วัน' : '-', $html);
        // $header = str_replace('{DOC-NAME}', 'แบบใบลาป่วย', $header);
        $test = 'เทส';
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'sarabun', // Ensure this matches your font name
            'format' => 'A4',
            'default_font_size' => 14,
            'margin_top' => 38,
            'margin_bottom' => 32,
            'fontDir' => array_merge((new Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
                __DIR__ . '/path_to_fonts/' // Adjust this path to point to your custom fonts directory
            ]),
            'fontdata' => array_merge((new Mpdf\Config\FontVariables())->getDefaults()['fontdata'], [
                'sarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'B' => 'THSarabunNew-Bold.ttf',
                    'I' => 'THSarabunNew-Italic.ttf',
                    'BI' => 'THSarabunNew-BoldItalic.ttf',
                ]
            ]),
        ]);
        $doc_template = array_values($doc_template)[0];
        $header = str_replace('{DOC-NAME}', $doc_template->doc_name_th, $header);
        $footer = str_replace('{DOC-CODE}', $doc_template->doc_code, $footer);
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        // Display the PDF
        $mpdf->Output('form.pdf', 'I');
    }

    function generate_report_views($lhis_id)
    {
        $lhis_id = decrypt_id($lhis_id);
        $result = $this->M_hr_leave_history->get_leave_history_by_lhis_id($lhis_id)->row();
        $doc_info = $this->M_hr_develop->get_develop_document_info('hr_leaves')->result();
        $doc_template = array_filter($doc_info, function ($obj) use ($result) {
            return ($obj->doc_id - 1) == $result->lhis_leave_id;
        });
        $result->stde_name_th = json_decode($result->stde_name_th, true); // Decode JSON into an array

        if (is_array($result->stde_name_th)) {
            // Extract the 'stde_name_th' values if the array contains objects
            $names = array_map(function ($item) {
                return $item['stde_name_th'] ?? ''; // Ensure it handles missing keys
            }, $result->stde_name_th);

            $result->stde_name_th = implode(',', $names); // Convert array to comma-separated string
        } else {
            // Handle cases where decoding fails or result is not an array
            $result->stde_name_th = '';
        }
        $day_used = 0;
        $leave_used = $this->M_hr_leave_history->get_leave_history_in_period($result->lhis_ps_id, $result->lhis_leave_id, $result->lhis_start_date, $result->lhis_year)->result();
        foreach ($leave_used as $key => $value) {
            $day_used  += $value->lhis_num_day;
        }
        $lapg = $this->M_hr_leave_approve_person->get_leaves_approve_person_by_ps_id($result->lhis_ps_id)->row();
        if ($lapg) {
            $flow_group_detail  = $this->M_hr_leave_approve_group_detail->get_leave_approve_detail_stuc_by_lapg_id($lapg->laps_lapg_id)->result();
        } else {
            $flow_group_detail = [];
        }
        $true_array = [];
        $false_array = [];
        $array_merge = [];
        foreach ($flow_group_detail as $key => $value) {
            $check = $this->M_hr_leave_approve_group_detail->find_common_stde($value->lage_ps_id, $result->lhis_ps_id);
            $flow_approve = $this->M_hr_leave_approve_flow->get_leave_flow_by_id($result->lhis_id, $value->lage_ps_id, '')->row();
            if ($flow_approve) {
                $value->lafw_status = $flow_approve->lafw_status;
                $value->lafw_comment = $flow_approve->lafw_comment;
                $value->is_boss = $check;
                if ($check == 'true') {
                    $true_array[] = $value;
                } else {
                    $false_array[] = $value;
                }
                // สร้าง array ใหม่ที่มีการรวม true และ false ตามลำดับ
                $array_merge = array_merge($true_array, $false_array);
            }
        }
        if($array_merge){
            $data['flow_approve'] = $array_merge;
        }else{
            $data['bypass_approve'] = $this->M_hr_leave_history->get_leave_history_bypass_detail($result->lhis_id)->row();
            pre($data['bypass_approve']);
        }
        $result->day_last_used = $leave_used[0]->lhis_end_date;
        $result->day_used = $day_used;
        $data['result'] = $result;
        $data['arr'] = array();
        $this->output('hr/leaves/leaves_report/v_report_leave_views', $data);
    }


    function convertToThaiDate($date)
    {
        // ตรวจสอบรูปแบบวันที่
        if (!$timestamp = strtotime($date)) {
            return "รูปแบบวันที่ไม่ถูกต้อง";
        }

        // รายชื่อเดือนภาษาไทย
        $thai_months = [
            1 => "มกราคม",
            2 => "กุมภาพันธ์",
            3 => "มีนาคม",
            4 => "เมษายน",
            5 => "พฤษภาคม",
            6 => "มิถุนายน",
            7 => "กรกฎาคม",
            8 => "สิงหาคม",
            9 => "กันยายน",
            10 => "ตุลาคม",
            11 => "พฤศจิกายน",
            12 => "ธันวาคม"
        ];

        // ดึงค่าวัน เดือน ปี
        $day = date("j", $timestamp);
        $month = (int)date("n", $timestamp);
        $year = (int)date("Y", $timestamp) + 543;
        return "วันที่ $day เดือน {$thai_months[$month]} พ.ศ. $year";
    }
} //end Leaves_form
