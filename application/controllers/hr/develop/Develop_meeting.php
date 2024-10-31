<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Develop_Controller.php");

class Develop_meeting extends Develop_Controller
{

    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/develop/Develop_meeting";
        $this->load->model($this->model . 'M_hr_person');
        $this->load->model($this->model . 'M_hr_develop');
        $this->load->model($this->model . 'M_hr_develop_heading');
        $this->load->model($this->model . 'base/M_hr_develop_type');
        $this->load->model($this->model . "/base/m_hr_structure_position");
    }

    public function index()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $data['name'] = 'นพ.บรรยง ชินกุลกิจนิวัฒน์';
        $data['position'] = 'ผู้อำนวยการ';
        $data['affiliation'] = 'จักษุแพทย์ รักษาโรคตาทั่วไป';
        $data['special'] = 'เชี่ยวชาญการผ่าตัดต้อกระจก';
        $data['controller_dir'] = 'hr/develop/Develop_meeting/';
        $this->M_hr_person->ps_id =  $this->session->userdata('us_ps_id');
        $data['ps_id'] = $this->session->userdata('us_ps_id');
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['year_filter'] = $this->M_hr_develop->get_develop_year_filter()->result();
        $data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
        $position_department_array = array();
        foreach ($data['person_department_topic'] as $row) {
            $array_tmp = $this->M_hr_person->get_person_position_by_ums_department_detail($this->session->userdata('us_ps_id'), $row->dp_id)->row();
            array_push($position_department_array, $array_tmp);
        }
        foreach ($position_department_array as $key => $value) {
            $stde_info = json_decode($value->stde_name_th_group, true);
            if ($stde_info) {
                foreach ($stde_info as $item) {
                    $id = $item['stdp_po_id'];
                    $name = $item['stde_name_th'];
                    // ถ้ายังไม่มีการจัดกลุ่มสำหรับ stdp_po_id นี้
                    if (!isset($grouped[$id])) {
                        $grouped[$id] = [
                            'stdp_po_id' => $id,
                            'stde_name_th' => []
                        ];
                    }
                    // เพิ่มชื่อเข้าไปในกลุ่ม
                    $grouped[$id]['stde_name_th'][] = $name;
                }
                // เปลี่ยนให้เป็น array ของ associative arrays
                $grouped = array_values($grouped);
                $value->stde_admin_position = $grouped;
            } else {
                $value->stde_admin_position = [];
            }
        }
        $data['person_department_detail'] = $position_department_array;
        $data['row_profile'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
        $data['develop_list'] = $this->M_hr_develop->get_develop_list_by_ps_id('none')->result();
        foreach ($data['develop_list'] as $key => $value) {
            $value->dev_id = encrypt_id($value->dev_id);
        }
        $this->output('hr/develop/v_Develop_meeting_show', $data);
    }
    public function get_Develop_meeting_add()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['person_option'] = $this->M_hr_person->get_all_profile_data(1, 'all', 'all', '1')->result();
        $data['base_country_list'] = $this->M_hr_person->get_hr_base_country_data()->result();
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['base_province_list'] = $this->M_hr_person->get_hr_base_province_data()->result();
        $data['develop_heading'] = $this->M_hr_develop_heading->get_heading_list()->result();
        foreach ($data['develop_heading'] as $key => $devh) {
            $devh->devh_list = json_decode($devh->devh_list, true);
        }
        $data['controller_dir'] = 'hr/develop/Develop_meeting/';
        foreach ($data['person_option'] as $key => $row) {
            $array = array();
            $row->ps_id = encrypt_id($row->ps_id);
            $admin_name = json_decode($row->admin_position, true);
            if ($admin_name) {
                foreach ($admin_name as $value) {
                    if ($value['admin_name']) {
                        $array[] = $value['admin_name'];
                    }
                }
                $row->admin_position = $array;
            } else {
                empty($row->admin_position);
            }
        }
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('hr/develop/v_Develop_meeting_form', $data);
    }
    public function get_Develop_meeting_edit($dev_id = null)
    {
        $dev_id =  decrypt_id($dev_id);
        $data['StID'] = $dev_id;
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $data['base_country_list'] = $this->M_hr_person->get_hr_base_country_data()->result();
        $data['base_province_list'] = $this->M_hr_person->get_hr_base_province_data()->result();
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['develop_heading'] = $this->M_hr_develop_heading->get_heading_list()->result();
        foreach ($data['develop_heading'] as $key => $devh) {
            $devh->devh_list = json_decode($devh->devh_list, true);
        }
        $data['controller_dir'] = 'hr/develop/Develop_meeting/';
        $data['develop_info'] = $this->M_hr_develop->get_develop_info_by_id($dev_id)->row();
        $data['develop_info']->dev_person = json_decode($data['develop_info']->dev_person, true);
        $data['person_option'] = $this->M_hr_person->get_all_profile_data(1, 'all', 'all', '1')->result();
        foreach ($data['person_option'] as $key => $row) {
            $array = array();
            $row->ps_id = encrypt_id($row->ps_id);
            $admin_name = json_decode($row->admin_position, true);
            if ($admin_name) {
                foreach ($admin_name as $value) {
                    if ($value['admin_name']) {
                        $array[] = $value['admin_name'];
                    }
                }
                $row->admin_position = $array;
            } else {
                empty($row->admin_position);
            }
        }
        $this->output('hr/develop/v_Develop_meeting_form', $data);
    }
    public function submit_develop_form()
    {
        $post_data = $this->input->post();
        $this->M_hr_develop->dev_topic = $post_data['dev_topic'];
        $this->M_hr_develop->dev_desc = $post_data['dev_desc'];
        $this->M_hr_develop->dev_start_date = $post_data['dev_start_date'];
        $this->M_hr_develop->dev_end_date = $post_data['dev_end_date'];
        $this->M_hr_develop->dev_end_time = $post_data['dev_end_time'];
        $this->M_hr_develop->dev_hour = $post_data['dev_hour'];
        $this->M_hr_develop->dev_place = $post_data['dev_place'];
        $this->M_hr_develop->dev_country_id = $post_data['dev_country_id'];
        $this->M_hr_develop->dev_pv_id = $post_data['dev_pv_id'];
        $this->M_hr_develop->dev_project = $post_data['dev_project'];
        $this->M_hr_develop->dev_budget = $post_data['dev_budget'];
        $this->M_hr_develop->dev_allowance = $post_data['dev_allowance'];
        $this->M_hr_develop->dev_accommodation = $post_data['dev_accommodation'];
        $this->M_hr_develop->dev_budget_type_other = $post_data['dev_budget_type_other'];
        $this->M_hr_develop->dev_budget_vat = $post_data['dev_budget_vat'];
        $this->M_hr_develop->dev_allowance_vat = $post_data['dev_allowance_vat'];
        $this->M_hr_develop->dev_accommodation_vat = $post_data['dev_accommodation_vat'];
        $this->M_hr_develop->dev_budget_type_other_vat = $post_data['dev_budget_type_other_vat'];
        $this->M_hr_develop->dev_objecttive = $post_data['dev_objecttive'];
        $this->M_hr_develop->dev_short_content = $post_data['dev_short_content'];
        $this->M_hr_develop->dev_benefits = $post_data['dev_benefits'];
        $this->M_hr_develop->dev_type = $post_data['dev_type'];
        $this->M_hr_develop->dev_status = 1;
        $this->M_hr_develop->dev_go_service_type = $post_data['service_type'];
        $this->M_hr_develop->dev_certificate = $post_data['dev_certi'];
        $this->M_hr_develop->dev_create_user = $this->session->userdata('us_id');
        $this->M_hr_develop->dev_organized_type = $post_data['dev_organized'];
        if ($post_data['dev_id'] != 'new') {
            $this->M_hr_develop->dev_id = $post_data['dev_id'];
            $data['dev_id'] = $post_data['dev_id'];
            $this->M_hr_develop->update();
            foreach ($post_data['dev_person_list'] as $key => $value) {
                if ($value['check'] == 'old') {
                    $this->M_hr_develop->update_develop_person($post_data['dev_id'], $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
                } else {
                    $this->M_hr_develop->insert_develop_person($post_data['dev_id'], $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
                }
            }
        } else {
            $this->M_hr_develop->insert();
            $data['dev_id'] = $this->M_hr_develop->last_insert_id;
            foreach ($post_data['dev_person_list'] as $key => $value) {
                $dev_id = $this->M_hr_develop->last_insert_id;
                $this->M_hr_develop->insert_develop_person($dev_id, $value['ps_id'], $value['devps_status'], $this->session->userdata('us_id'));
            }
        }
        $data['status_response'] = $this->config->item('status_response_success');

        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function get_file_list_by_dev_id()
    {
        $dev_id = $this->input->post('dev_id');
        $directoryPath = '/var/www/uploads/hr/develop_file/dev_' . $dev_id; // Your target directory
        $files = [];

        if (is_dir($directoryPath)) {
            $files = array_diff(scandir($directoryPath), array('..', '.')); // Get all files excluding '.' and '..'
        }

        // Prepare an array to hold file details
        $fileDetails = [];
        foreach ($files as $file) {
            $filePath = $directoryPath . '/' . $file;
            if (is_file($filePath)) { // Check if it is a file
                $fileDetails[] = [
                    'name' => $file,
                    'type' => mime_content_type($filePath), // Get file type
                    'size' => filesize($filePath), // Size in KB
                    'path' => $filePath
                ];
            }
        }
        $data['dev_file'] = $fileDetails;
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function upload_file()
    {
        if (isset($_FILES['files'])) {
            $dev_id = $this->input->post('dev_id');
            $uploadDirectory = '/var/www/uploads/hr/develop_file/dev_' . $dev_id;  // Define the directory to store uploaded files

            // Create the directory if it does not exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            } else {
                // Delete all files in the directory before uploading new files
                $files = glob($uploadDirectory . '/*'); // Get all files in the directory
                $now_index = count($files);
            }

            $uploadedFiles = $_FILES['files'];
            $fileCount = count($uploadedFiles['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $fileType = pathinfo($uploadedFiles['name'][$i], PATHINFO_EXTENSION); // Get the file extension
                $newFileName = 'dev_' . $dev_id . '_file_' . (($i + $now_index) + 1) . '.' . $fileType; // Create new file name
                $filePath = $uploadDirectory . '/' . $newFileName;

                if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $filePath)) {
                    // File uploaded successfully
                } else {
                    // Handle upload error
                    echo "File upload failed: " . $uploadedFiles['name'][$i];
                }
            }
        }
    }
    public function delete_devlop_file()
    {
        $file_name = $this->input->post('file_name');
        $dev_id = decrypt_id($this->input->post('dev_id'));
        $uploadDirectory = '/var/www/uploads/hr/develop_file/dev_' . $dev_id;
        $files = glob($uploadDirectory . '/' . $file_name);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete each file
            }
        }
    }
    public function delete_develop_form()
    {
        $this->M_hr_develop->dev_id = $this->input->post('dev_id');
        $this->M_hr_develop->dev_status = 0;
        $this->M_hr_develop->dev_update_user = $this->session->userdata('us_id');
        $this->M_hr_develop->delete_develop_by_id();
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function get_Edit_meeting_form()
    {
        $name = ['นางสาวกัลยารัตน์ อนนท์รัตน์', 'นางวรางคณา อุดมทรัพย์', 'นางสาวกฤษณาพร ทิพย์กาญจนเรขา'];
        $formData = $this->input->post();
        if (isset($formData['uid'])) {
            $data['name'] = $name[$formData['uid'] - 1];
        }
        $json['title']  = 'จัดการข้อมูลผู้เข้าร่วมพัฒนาตนเอง';
        $json['body'] = $this->load->view('hr/develop/v_Develop_edit_meeting_form', $data, true);
        $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary"  data-bs-dismiss="modal">ยกเลิก</button>';
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function get_person_info()
    {
        $this->M_hr_person->ps_id = decrypt_id($this->input->post('ps_id'));
        $data['person'] = $this->M_hr_person->get_profile_detail_data_by_id()->row();
        $data['person']->detail = $this->M_hr_person->get_person_position_by_ums_department_detail(decrypt_id($this->input->post('ps_id')), 1)->row();
        $data['person']->detail->admin_position = json_decode($data['person']->detail->admin_position, true);
        $data['person']->detail->spcl_position = json_decode($data['person']->detail->spcl_position, true);
        $data['person']->detail->stde_name_th_group = json_decode($data['person']->detail->stde_name_th_group, true);
        echo json_encode($data);
    }

    public function check_person()
    {
        $ps_id = decrypt_id($this->input->post('ps_id'));
        $dev_id = $this->input->post('dev_id');
        $result = $this->M_hr_develop->get_develop_person($ps_id, $dev_id)->row();
        if ($result) {
            $data['status_response'] = $this->config->item('status_response_error');
        } else {
            $data['status_response'] = $this->config->item('status_response_success');
        }
        $result = array('data' => $data);
        echo json_encode($result);
    }
    function generateList($data, $position_labels)
    {
        $grouped_data = [];
        // จัดกลุ่มข้อมูลตาม stdp_po_id
        foreach ($data as $item) {
            if ($item->stde_level < 3) {
                $grouped_data[0][] = $item->stde_name_th;
            } else {
                $grouped_data[$item->stdp_po_id][] = $item->stde_name_th;
            }
        }
        ksort($grouped_data);
        // สร้าง HTML สำหรับแสดงผล
        $output = "<ul>";
        foreach ($grouped_data as $position_id => $names) {
            if ($position_id == 0) {
                $output .= "<li> " . implode("<i>", array_unique($names));
            } else {
                if (!empty($position_labels[$position_id])) {

                    $output .= "<li>" . $position_labels[$position_id];

                    // แสดงข้อมูลที่เป็นรายการหน่วยงาน
                    if (!empty($names)) {
                        $output .= "<br>&nbsp;&nbsp; - " . implode("<br>&nbsp;&nbsp; - ", array_unique($names));
                    }

                    $output .= "</li>";
                }
            }
        }
        $output .= "</ul>";

        return $output;
    }
    function filter_dev_list()
    {
        $filter = $this->input->post();
        $result = $this->M_hr_develop->get_develop_list_by_filter($filter)->result();
        if ($result) {
            $data['status_response'] = $this->config->item('status_response_error');
        } else {
            $data['status_response'] = $this->config->item('status_response_success');
        }
        foreach ($result as $key => $value) {
           $value->dev_start_date = fullDateTH3($value->dev_start_date);
           $value->dev_id = encrypt_id($value->dev_id);
        }
        $data['result'] = $result;
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function generate_pdf($dev_id)
    {
        $dev_id = decrypt_id($dev_id);
        require APPPATH . 'third_party/vendor/autoload.php';
        $data['detail'] = "-";
        $html_file_path = APPPATH . 'views/hr/develop/mpdf_develop_form.html'; // Adjust the path to the location of your HTML file
        $header_path = APPPATH . 'views/hr/doc_template/doc_header.html';
        $footer_path = APPPATH . 'views/hr/doc_template/doc_footer.html';
        $base_develop_type_list = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $base_develop_type_list = array_filter($base_develop_type_list, function ($devb) {
            return $devb->devb_active == 1;
        });
        $doc_info = $this->M_hr_develop->get_develop_document_info('hr_develop')->row();
        $doc_detail_info = $this->M_hr_develop->get_develop_info_by_id($dev_id)->row();
        $doc_detail_info->dev_person = json_decode($doc_detail_info->dev_person);
        $html = file_get_contents($html_file_path);
        $header = file_get_contents($header_path);
        $footer = file_get_contents($footer_path);
        $table_rows = '';
        $base_structure_position = $this->m_hr_structure_position->get_all_by_active('asc')->result();
        $position_labels[] = '';
        foreach ($base_structure_position as $key => $base) {
            $position_labels[] = $base->stpo_name;
        }
        foreach ($doc_detail_info->dev_person as $index => $dev_person) {
            if ($dev_person->stde_name_three != NULL) {
                $stde_name = $this->generateList($dev_person->stde_name_three, $position_labels);
            } else {
                $stde_name = '-';
            }
            $table_rows .= '
        <tr>
            <td width="7%" style="text-align: center; vertical-align: top;">' . ($index + 1) . '</td>
            <td style="vertical-align: top;" width="10%">' . $dev_person->pos_ps_code . '</td>
            <td width="25%" style="vertical-align: top;">' . $dev_person->ps_name . '</td>
            <td style="vertical-align: top;">' . $dev_person->hire_name . '</td>
            <td colspan="3" style="vertical-align: top;">' . $stde_name . '</td>
        </tr>';
        }
        // Header and Footer settings

        // Add header-d1 and header-d2 content to display on each page
        $header_d1_d2 = '
<div class="form-container" id="header-d1">
    <table style="padding-bottom:0px;margin-bottom:0px;">
        <tr>
            <td width="13%" style="padding-right:0px;margin-right:0px;"><b>ชื่อหลักสูตร :</b></td>
            <td class="input-line" colspan="5">
                <div>{dev_topic}</div>
            </td>
        </tr>
    </table>
    <table style="padding-bottom:0px;margin-bottom:0px;">
        <tr>
            <td width="11.5%"><b>วันที่ :</b></td>
            <td width="20%" style="border-bottom: 1px solid black;">{dev_start_date}</td>
            <td width="8%"><b>ถึงวันที่ :</b></td>
            <td width="20%" style="border-bottom: 1px solid black;">{dev_end_date}</td>
            <td width="5%"><b>เวลา :</b></td>
            <td width="22%" style="border-bottom: 1px solid black;">{dev_end_time}</td>
        </tr>
    </table>
    <table style="padding-bottom:0px;margin-bottom:0px;">
        <tr>
            <td width="13%"><b>รวม :</b></td>
            <td width="20%" style="border-bottom: 1px solid black;">{dev_hour}</td>
            <td width="8%">ชั่วโมง</td>
            <td width="18%"><b>วิทยากร/ผู้จัดฝึกอบรม :</b></td>
            <td width="41%" style="border-bottom: 1px solid black;">{dev_project}</td>
        </tr>
    </table>
    <table style="padding-bottom:0px;margin-bottom:0px;">
        <tr>
            <td width="15%"><b>สถานที่ :</b></td>
            <td class="input-line" width="85%">
                <div>{dev_place}</div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;padding-top:0px;margin-top:0px;padding-bottom:0px;margin-bottom:0px">
        <tr>
            <td width="13%"><b>การฝึกอบรม :</b></td>
            <td width="15%">{trainIn} อบรมภายใน</td>
            <td width="15%">{trainOut} อบรมภายนอก</td>
            <td width="20%"><b>ประกาศนียบัตร :</b></td>
            <td width="15%">{certiHave} มี</td>
            <td width="15%">{certiNone} ไม่มี</td>
        </tr>
        <tr>
         <td width="5%"><b>ประเภท :</b></td>';
        $count = 0; // ตัวนับสำหรับช่อง
        foreach ($base_develop_type_list as $item) {
            $checkbox = ($doc_detail_info->dev_go_service_type == $item->devb_id) ? '&#9745;' : '&#9744;';

            // เพิ่ม checkbox และชื่อประเภท พร้อมการจัดการข้อความไม่ให้ตกบรรทัด และลดระยะห่าง
            $header_d1_d2 .= '
                <td style="white-space: nowrap; padding: 2px;" width="19%">
                    <span style="font-family: DejaVu Sans; margin-right: 2px;">' . $checkbox . '</span> ' . htmlspecialchars($item->devb_name) . '
                </td>
            ';

            $count++;

            // เมื่อครบ 4 ช่อง ให้ปิดแถวปัจจุบันและเริ่มแถวใหม่ พร้อม `<td>` เปล่าสำหรับคอลัมน์ที่ 5
            if ($count % 4 == 0) {
                $header_d1_d2 .= '<td></td></tr><tr><td></td>'; // ปิดแถวปัจจุบันและเริ่มแถวใหม่พร้อม `<td>` ว่าง
            }
        }

        // ปิดแถวสุดท้ายหากไม่ครบ 4 ช่อง
        if ($count % 4 != 0) {
            // เติมช่องว่างให้ครบแถว และเพิ่ม `<td>` เปล่าสำหรับคอลัมน์ที่ 5
            $remaining_cells = 4 - ($count % 4);
            for ($i = 0; $i < $remaining_cells; $i++) {
                $header_d1_d2 .= '<td></td>';
            }
            $header_d1_d2 .= '<td></td></tr>'; // ปิดแถวสุดท้ายและเพิ่ม `<td>` ว่างสำหรับคอลัมน์ที่ 5
        }
        $header_d2 = '</table>
        </div>
        <div class="form-container" id="header-d2" style="padding-bottom:9px">
            <div>
                <b>วัตถุประสงค์ :</b>
            </div>
            <div>{dev_purpose}</div>
            <div>
                <b>ประโยชน์ที่คาดว่าจะได้รับ :</b>
            </div>
            <div>{dev_benefits}</div>
        </div>';
        function calculate_mt2($header, $header_detatil, $mt)
        {
            // หาความยาวของ string
            $header_length = strlen($header . $header_detatil);
            // pre($header_length);
            // die;
            // กำหนดค่าพื้นฐานสำหรับ $mt
            // กำหนดช่วงเริ่มต้นที่ 3954 และเพิ่มทีละ 618
            $base_length = 3869;
            $increase_step = 990;
            $increase_mt = 6.5;
            // ตรวจสอบว่าความยาวของ string เกินช่วงเริ่มต้นหรือไม่
            if ($header_length > $base_length) {
                // หาความต่างจากช่วงเริ่มต้น
                $extra_length = $header_length - $base_length;
                // หาจำนวนรอบ 618 ที่ต้องเพิ่มค่า mt (ใช้ ceil เพื่อให้ค่าเต็มขั้นถัดไป)
                $increase_steps = ceil($extra_length / $increase_step);
                // pre($header_length);
                // die;
                // คำนวณค่า $mt ตามจำนวนก้าวที่เพิ่มขึ้น
                $mt = $mt - ($increase_steps * $increase_mt);
            }
            // pre($mt);
            // die;
            // ส่งค่า $mt ที่คำนวณแล้วออกมา
            return $mt;
        }
        function calculate_mt($header, $header_d1_d2)
        {
            // หาความยาวของ string
            $header_length = strlen($header . $header_d1_d2);
            // pre($header_length);
            // die;
            // กำหนดค่าพื้นฐานสำหรับ $mt
            $mt = 101.5;

            // กำหนดช่วงเริ่มต้นที่ 3954 และเพิ่มทีละ 618
            $base_length = 4298;
            $increase_step = 145;
            $base_mt = 101.5;
            $increase_mt = 6.5;

            // ตรวจสอบว่าความยาวของ string เกินช่วงเริ่มต้นหรือไม่
            if ($header_length > $base_length) {
                // หาความต่างจากช่วงเริ่มต้น
                $extra_length = $header_length - $base_length;

                // หาจำนวนรอบ 618 ที่ต้องเพิ่มค่า mt (ใช้ ceil เพื่อให้ค่าเต็มขั้นถัดไป)
                $increase_steps = ceil($extra_length / $increase_step);

                // คำนวณค่า $mt ตามจำนวนก้าวที่เพิ่มขึ้น
                $mt = $base_mt + ($increase_steps * $increase_mt);
            }
            // pre($mt);
            // die;
            // ส่งค่า $mt ที่คำนวณแล้วออกมา
            return $mt;
        }
        // Replace dynamic values in headers and footers
        $date = new DateTime($doc_detail_info->dev_start_date);

        // ดึงข้อมูลวันและเดือน
        $day = $date->format('d');  // ดึงข้อมูลวันที่เป็น dd
        $month = $date->format('m');  // ดึงข้อมูลเดือนเป็น mm

        // ดึงข้อมูลปีแล้วแปลงเป็น พ.ศ. และเอาเฉพาะ 2 หลักท้าย
        $year = $date->format('Y'); // ดึงข้อมูลปี ค.ศ.
        $thai_year = ($year + 543) % 100;  // แปลงเป็น พ.ศ. แล้วเอาเฉพาะ 2 หลักท้าย

        // รวมวัน, เดือน และปีในรูปแบบ ddmm และ 2 หลักท้ายของ พ.ศ.
        $formatted_date = $day . $month . $thai_year;

        // ตรวจสอบว่าเป็นรูปแบบภายในหรือภายนอก
        $training_type = isset($develop_info->dev_organized_type) ? $develop_info->dev_organized_type : 1;

        if ($training_type == 1) {
            // ภายในโรงพยาบาล
            $doc_temp = "IN-" . $formatted_date . '-';
        } else if ($training_type == 2) {
            // ภายนอกโรงพยาบาล
            $doc_temp = "OUT-" . $formatted_date . '-';
        }
        $time_object = new DateTime($doc_detail_info->dev_end_time);
        $doc_detail_info->dev_budget_type_other = 0;
        $doc_detail_info->dev_budget_type_other_vat = 0;
        // ดึงเฉพาะชั่วโมงและนาที
        $formatted_time = $time_object->format('H:i') . ' น.';
        $header_d1_d2 = str_replace('{dev_topic}', $doc_temp . $doc_detail_info->dev_topic, $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_start_date}', fullDateTH3($doc_detail_info->dev_start_date), $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_end_date}', fullDateTH3($doc_detail_info->dev_end_date), $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_end_time}', $formatted_time, $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_hour}', $doc_detail_info->dev_hour, $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_project}', $doc_detail_info->dev_project, $header_d1_d2);
        $header_d1_d2 = str_replace('{dev_place}', $doc_detail_info->dev_place, $header_d1_d2);
        $html = str_replace('{dev_budget}',  number_format($doc_detail_info->dev_budget, 2, '.', ','), $html);
        $html = str_replace('{dev_budget_vat}', number_format($doc_detail_info->dev_budget_vat, 2, '.', ','), $html);
        $html = str_replace('{dev_allowance}', number_format($doc_detail_info->dev_allowance, 2, '.', ','), $html);
        $html = str_replace('{dev_allowance_vat}', number_format($doc_detail_info->dev_allowance_vat, 2, '.', ','), $html);
        $html = str_replace('{dev_accommodation}', number_format($doc_detail_info->dev_accommodation, 2, '.', ','), $html);
        $html = str_replace('{dev_accommodation_vat}', number_format($doc_detail_info->dev_accommodation_vat, 2, '.', ','), $html);
        $html = str_replace('{dev_budget_type_other}', number_format($doc_detail_info->dev_budget_type_other, 2, '.', ','), $html);
        $html = str_replace('{dev_budget_type_other_vat}', number_format($doc_detail_info->dev_budget_type_other_vat, 2, '.', ','), $html);
        $summary = floatval($doc_detail_info->dev_budget) +
            floatval($doc_detail_info->dev_allowance) +
            floatval($doc_detail_info->dev_accommodation) +
            floatval($doc_detail_info->dev_budget_type_other);
        $summary_vat = floatval($doc_detail_info->dev_budget_vat) +
            floatval($doc_detail_info->dev_allowance_vat) +
            floatval($doc_detail_info->dev_accommodation_vat) +
            floatval($doc_detail_info->dev_budget_type_other_vat);
        $summary_vat = number_format($summary_vat, 2, '.', ',');
        $summary = number_format($summary, 2, '.', ',');
        $html = str_replace(
            '{dev_summary}',
            $summary,
            $html
        );

        $html = str_replace(
            '{dev_summary_vat}',
            $summary_vat,
            $html
        );
        if ($doc_detail_info->dev_organized_type == 1) {
            $header_d1_d2 = str_replace('{trainIn}', '<span style="font-family: DejaVu Sans;">&#9745;</span>',  $header_d1_d2);
            $header_d1_d2 = str_replace('{trainOut}', '<span style="font-family: DejaVu Sans;">&#9744;</span>',  $header_d1_d2);
        } else {
            $header_d1_d2 = str_replace('{trainIn}', '<span style="font-family: DejaVu Sans;">&#9744;</span>',  $header_d1_d2);
            $header_d1_d2 = str_replace('{trainOut}', '<span style="font-family: DejaVu Sans;">&#9745;</span>',  $header_d1_d2);
        }

        if ($doc_detail_info->dev_certificate == 1) {
            $header_d1_d2 = str_replace('{certiHave}', '<span style="font-family: DejaVu Sans;">&#9745;</span>',  $header_d1_d2);
            $header_d1_d2 = str_replace('{certiNone}', '<span style="font-family: DejaVu Sans;">&#9744;</span>',  $header_d1_d2);
        } else {
            $header_d1_d2 = str_replace('{certiHave}', '<span style="font-family: DejaVu Sans;">&#9744;</span>',  $header_d1_d2);
            $header_d1_d2 = str_replace('{certiNone}', '<span style="font-family: DejaVu Sans;">&#9745;</span>',  $header_d1_d2);
        }
        $header = str_replace('{DOC-NAME}', $doc_info->doc_name_th, $header);
        $footer = str_replace('{DOC-CODE}', $doc_info->doc_code, $footer);
        // Set Header and Footer in mPDF
        // The header-d1 and header-d2 will appear in all pages by including them in the header content
        $purpose = $doc_detail_info->dev_objecttive != null ||  $doc_detail_info->dev_objecttive != '' ? $doc_detail_info->dev_objecttive : '-';
        $benefits = $doc_detail_info->dev_benefits != null ||  $doc_detail_info->dev_benefits != '' ? $doc_detail_info->dev_benefits : '-';
        $header_d2 = str_replace('{dev_purpose}', nl2br($purpose), $header_d2);
        $header_d2 = str_replace('{dev_benefits}', nl2br($benefits), $header_d2);
        // pre(strlen($header.$header_d1_d2));
        // die;
        $stack_header =  $header_d1_d2 . $header_d2;
        // pre(strlen($header.$header_d1_d2));
        // die;
        $mt = calculate_mt($header, $stack_header);
        // $mt = calculate_mt2($header, $header_d1_d2, $mt);
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'sarabun',
            'format' => 'A4',
            'margin_top' => $mt, // เพิ่ม margin top เพื่อรองรับ header-d1 และ header-d2
            'margin_bottom' => 32 // ระยะขอบล่างสำหรับ Footer
        ]);
        $mpdf->SetHTMLHeader($header . $stack_header);
        $mpdf->SetHTMLFooter($footer);

        // Replace dynamic content in the main HTML
        $html = str_replace('{TABLE_ROWS}', $table_rows, $html);

        // Write the content to the PDF
        $mpdf->WriteHTML($html);

        // Display the PDF
        $mpdf->Output('form.pdf', 'I');
    }
}
