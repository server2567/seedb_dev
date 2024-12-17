<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Report_Controller.php");
require APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Report_leave extends Report_Controller
{
    public function __construct()
    {
        parent::__construct();

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/report/report_leave";
        $this->load->model($this->model . 'M_hr_person');
        $this->load->model($this->model . 'M_hr_develop');
        $this->load->model($this->model . 'M_hr_develop_heading');
        $this->load->model($this->model . 'base/M_hr_develop_type');
        $this->load->model($this->model . 'base/M_hr_hire');
        $this->load->model($this->model . 'base/M_hr_adline_position');
        $this->load->model($this->model . "/base/m_hr_structure_position");
    }
    public function index()
    {
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $data['controller_dir'] = 'hr/report/Report_leave/';
        $this->ums_db = $this->load->database('ums', TRUE);
        $sql = "SELECT * FROM see_umsdb.ums_department";
        $query = $this->ums_db->query($sql);
        $data['department_list'] = $query->result_array();
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();
        $data['base_hire_list'] = $this->M_hr_hire->get_all_by_active()->result();
        $hire_data = $this->session->userdata('hr_hire_is_medical');
        $hire_name = ['N' => 'สายพยาบาล', 'SM' => 'สายสนับสนุนทางการแพทย์',  'A' => 'สายบริหาร', 'M' => 'สายบริหาร'];
        $hire_arr = [];
        foreach ($hire_data as $key => $hire) {
            if (isset($hire_name[$hire['type']])) {
                $hire_arr[$hire['type']] = $hire_name[$hire['type']];
            }
        }
        foreach ($data['base_hire_list'] as $key => $value) {
            if ($hire_arr[$value->hire_is_medical]) {
                $value->hire_name .= ' ' . $hire_arr[$value->hire_is_medical];
            }
        }
        foreach ($data['base_hire_list'] as $key => $value) {
            if ($hire_name[$value->hire_is_medical]) {
                $value->hire_name .= ' ' . $hire_name[$value->hire_is_medical];
            }
        }
        $data['base_adline_list'] = $this->M_hr_adline_position->get_all_by_active()->result();
        $this->output('hr/report/v_report_overview_leave.php', $data);
    }
    public function get_overview_leave_summary()
    {
        // รับค่าตัวกรองจาก POST
        $filter_depart = $this->input->post('filter_depart');
        $filter_year = $this->input->post('filter_year') - 543;
        $filter_hire = $this->input->post('filter_hire');
        $filter_admin = $this->input->post('filter_admin');
        $filter_adline = $this->input->post('filter_adline');
        $filter_status = $this->input->post('filter_status');
        $start = $this->input->post('start') == 'NaN' ? 0 : $this->input->post('start'); // เริ่มต้นแถว
        $length = $this->input->post('length'); // จำนวนแถวต่อหน้า
        $draw = $this->input->post('draw'); // รอบการวาดของ DataTables
        $searchValue = $this->input->post('search')['value']; // ค่าค้นหา

        // SQL query พร้อมการเชื่อมต่อ (join) ตารางต่าง ๆ
        $sql = "
        SELECT 
            lsum.*, 
            lv.leave_name, 
            CONCAT(pf.pf_name, ' ', ps.ps_fname, ' ', ps.ps_lname) AS ps_name, 
            ps.ps_id 
        FROM see_hrdb.hr_leave_summary AS lsum
        LEFT JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lsum.lsum_leave_id
        LEFT JOIN see_hrdb.hr_person AS ps ON ps.ps_id = lsum.lsum_ps_id
        LEFT JOIN see_hrdb.hr_base_prefix AS pf ON pf.pf_id = ps.ps_pf_id
        LEFT JOIN see_hrdb.hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id";

        $searchableColumns = [
            'pf.pf_name',
            'ps.ps_fname',
            'ps.ps_lname'
        ];

        // เพิ่มเงื่อนไขการค้นหาถ้ามีการค้นหา
        if (!empty($searchValue)) {
            $likeConditions = [];
            foreach ($searchableColumns as $column) {
                $likeConditions[] = "$column LIKE '%" . $this->db->escape_like_str($searchValue) . "%'";
            }
            $sql .= " WHERE (" . implode(' OR ', $likeConditions) . ")" . " AND lsum.lsum_year = " . ($filter_year) . " AND lsum.lsum_dp_id = '$filter_depart'" . " AND lsum.lsum_leave_id != 0";
        } else {
            $sql .= " WHERE lsum.lsum_year = " . ($filter_year) . " AND lsum.lsum_dp_id = '$filter_depart'" . " AND lsum.lsum_leave_id != 0"; // เงื่อนไขพื้นฐาน
        }

        // เงื่อนไขการกรองเพิ่มเติม
        if ($filter_hire != 'all') {
            $sql .= " AND pos.pos_hire_id = '$filter_hire'";
        }
        if ($filter_adline != 'all') {
            $sql .= " AND pos.pos_adline_id = '$filter_adline'";
        }
        if ($filter_admin != 'all') {
            $sql .= " AND pos.pos_admin_id = '$filter_admin'";
        }
        if ($filter_status != 'all') {
            $sql .= " AND pos.pos_status = '$filter_status'";
        }

        // การจัดกลุ่มและการเรียงลำดับ
        $sql .= " GROUP BY lsum.lsum_id ORDER BY ps.ps_id";

        // กำหนดจำนวนแถวในการแบ่งหน้า
        if ($length != 0) {
            $sql .= " LIMIT " . (int)$start . ", " . (int)$length;
        }
        // รัน Query
        $this->hr = $this->load->database('hr', TRUE);
        $query = $this->hr->query($sql);
        $result = $query->result_array();
        $uniquePersons = array_unique(array_column($result, 'ps_id'));
        $totalPersons = count($uniquePersons);
        // จัดกลุ่มข้อมูลตาม `ps_id`
        $groupedData = [];
        foreach ($result as $row) {
            $ps_id = $row['ps_id'];
            if (!isset($groupedData[$ps_id])) {
                // สร้างหัวข้อหลักของแต่ละบุคคล
                $groupedData[$ps_id] = [
                    'ps_name' => $row['ps_name'],
                    'leave_summary' => []
                ];
            }
            // เพิ่มข้อมูลการลาลงในกลุ่มของบุคคลนั้น
            $groupedData[$ps_id]['leave_summary'][] = $row;
        }

        // จัดรูปแบบข้อมูลเพื่อแสดงใน DataTables
        $dataForDataTable = [];
        $ps_index = 1;
        foreach ($groupedData as $ps_id => $data) {
            // แถวหัวข้อหลัก
            $dataForDataTable[] = [
                'sequence' => '', // ไม่ต้องใส่ลำดับในแถวหัวข้อหลัก
                'dp_id' => encrypt_id($data['leave_summary'][0]['lsum_dp_id']),
                'ps_id' => encrypt_id($ps_id),
                'ps_name' => "<strong>" . $ps_index++ . ' ' . $data['ps_name'] . "</strong>",
                'leave_name' => '',
                'lsum_per_day' => '',
                'lsum_per_hour' => '',
                'lsum_per_minute' => '',
                'lsum_num_day' => '',
                'lsum_num_hour' => '',
                'lsum_num_minute' => '',
                'lsum_remain_day' => '',
                'lsum_remain_hour' => '',
                'lsum_remain_minute' => '',
                'lsum_leave_old' => ''
            ];

            // ลำดับข้อมูลการลาแต่ละรายการของบุคคล
            $sequence = 1;
            foreach ($data['leave_summary'] as $leave) {
                $dataForDataTable[] = [
                    'sequence' => $sequence++, // ลำดับที่เพิ่มขึ้นในแต่ละรายการของบุคคล
                    'dp_id' => '',
                    'ps_id' => '',
                    'ps_name' => '', // เว้นว่างไว้เพื่อไม่ต้องแสดงชื่อซ้ำ
                    'leave_name' => $leave['leave_name'],
                    'lsum_per_day' => $leave['lsum_count_limit'] == 'N' ? ($leave['lsum_per_day'] == null ? '0' : $leave['lsum_per_day']) : '<i class="bi bi-infinity"></i>',
                    'lsum_per_hour' => $leave['lsum_count_limit'] == 'N' ? ($leave['lsum_per_hour'] == null ? '0' : $leave['lsum_per_hour']) : '<i class="bi bi-infinity"></i>',
                    'lsum_per_minute' => $leave['lsum_per_minute'] == null ? '0' : $leave['lsum_per_minute'],
                    'lsum_num_day' => $leave['lsum_num_day'] == null ? '0' : $leave['lsum_num_day'],
                    'lsum_num_hour' => $leave['lsum_num_hour'] == null ? '0' : $leave['lsum_num_hour'],
                    'lsum_num_minute' => $leave['lsum_num_minute'] == null ? '0' : $leave['lsum_num_minute'],
                    'lsum_remain_day' => $leave['lsum_remain_day'] == null ? '0' : $leave['lsum_remain_day'],
                    'lsum_remain_hour' => $leave['lsum_remain_hour'] == null ? '0' : $leave['lsum_remain_hour'],
                    'lsum_remain_minute' => $leave['lsum_remain_minute'] == null ? '0' : $leave['lsum_remain_minute'],
                    'lsum_leave_old' => $leave['lsum_leave_old'] == null ? '0' :  $leave['lsum_leave_old']
                ];
            }
        }

        // ส่งข้อมูลให้ DataTables ในรูปแบบ JSON
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => count($result),
            "recordsFiltered" => count($result),
            "data" => $dataForDataTable
        ];

        // ตั้งค่า header เป็น JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
    public function export_excel_leave($filter)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $sql = "
        SELECT 
            lsum.*, 
            lv.leave_name, 
            CONCAT(pf.pf_name, ' ', ps.ps_fname, ' ', ps.ps_lname) AS ps_name, 
            ps.ps_id 
        FROM see_hrdb.hr_leave_summary AS lsum
        LEFT JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lsum.lsum_leave_id
        LEFT JOIN see_hrdb.hr_person AS ps ON ps.ps_id = lsum.lsum_ps_id
        LEFT JOIN see_hrdb.hr_base_prefix AS pf ON pf.pf_id = ps.ps_pf_id
        LEFT JOIN see_hrdb.hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        WHERE  lsum.lsum_year = " . ($filterString['filter_year'] - 543) . " AND lsum.lsum_dp_id = " . $filterString['filter_depart'] . " AND pos.pos_status = " . $filterString['filter_status'] . " AND lsum.lsum_leave_id != 0";
        if ($filterString['filter_hire'] != 'all') {
            $sql .= " AND pos.pos_hire_id = " . $filterString['filter_hire'];
        }
        if ($filterString['filter_adline'] != 'all') {
            $sql .= " AND pos.pos_adline_id = " . $filterString['$filter_adline'];
        }
        if ($filterString['filter_admin'] != 'all') {
            $sql .= " AND pos.pos_admin_id = " . $filterString['filter_admin'];
        }
        $sql .= " GROUP BY lsum.lsum_id ORDER BY ps.ps_id ASC";
        $this->hr = $this->load->database('hr', TRUE);
        // เพิ่ม LIMIT สำหรับการแบ่งหน้า
        // รัน Query
        $query = $this->hr->query($sql);
        $result = $query->result_array();
        usort($result, function ($a, $b) {
            return $a['lsum_leave_id'] <=> $b['lsum_leave_id'];
        });
        $groupedData = [];
        foreach ($result as $row) {
            $ps_id = $row['ps_id'];
            $ps_name = $row['ps_name'];

            // ตรวจสอบว่ามีข้อมูลของบุคคลนี้ในกลุ่มแล้วหรือไม่
            if (!isset($groupedData[$ps_id])) {
                $groupedData[$ps_id] = [
                    'ps_name' => $ps_name,
                    'leave_summary' => []
                ];
            }

            // เพิ่มข้อมูลการลาไปยังกลุ่มของบุคคลนี้
            $groupedData[$ps_id]['leave_summary'][] = $row;
        }



        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($result)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }
        // สร้างไฟล์ Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ข้อมูลการลา');

        // กำหนด Header
        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'ลำดับ');
        $sheet->mergeCells('B1:B2')->setCellValue('B1', 'ชื่อบุคคล');
        $sheet->mergeCells('C1:C2')->setCellValue('C1', 'ประเภทการลา');
        $sheet->mergeCells('D1:F1')->setCellValue('D1', 'จำนวนที่ลาได้');
        $sheet->mergeCells('G1:I1')->setCellValue('G1', 'จำนวนลาที่ใช้ไป');
        $sheet->mergeCells('J1:L1')->setCellValue('J1', 'จำนวนวันคงเหลือ');
        $sheet->mergeCells('M1:N2')->setCellValue('M1', 'จำนวนวันที่ยกยอดมา');
        $headers = ['วัน', 'ชั่วโมง', 'นาที', 'วัน', 'ชั่วโมง', 'นาที', 'วัน', 'ชั่วโมง', 'นาที'];
        $column = 'D';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '2', $header);
            $column++;
        }

        // เพิ่มข้อมูลใน Excel
        $rowIndex = 3;
        $num = 1;
        foreach ($groupedData as $group_key => $data) {
            // แสดงชื่อบุคคลในแถวหลัก
            $rowbefore = $rowIndex;
            // เพิ่มข้อมูลการลาแต่ละรายการของบุคคล
            foreach ($data['leave_summary'] as $key => $leave) {
                $sheet->setCellValue("C{$rowIndex}", $leave['leave_name']); // ประเภทการลา
                $sheet->setCellValue("D{$rowIndex}", $leave['lsum_count_limit'] == 'N' ? $leave['lsum_per_day'] : "\u{221E}"); // จำนวนวัน
                $sheet->setCellValue("E{$rowIndex}", $leave['lsum_count_limit'] == 'N' ? $leave['lsum_per_hour'] : "\u{221E}"); // จำนวนชั่วโมง
                $sheet->setCellValue("F{$rowIndex}", $leave['lsum_count_limit'] == 'N' ? $leave['lsum_per_minute'] : "\u{221E}"); // จำนวน นาที
                $sheet->setCellValue("G{$rowIndex}", $leave['lsum_num_day']); // จำนวนวัน
                $sheet->setCellValue("H{$rowIndex}", $leave['lsum_num_hour']); // จำนวนชั่วโมง
                $sheet->setCellValue("I{$rowIndex}", $leave['lsum_num_minute']); // จำนวน นาที
                $sheet->setCellValue("J{$rowIndex}", $leave['lsum_remain_day']); // จำนวนวัน
                $sheet->setCellValue("K{$rowIndex}", $leave['lsum_remain_hour']); // จำนวนชั่วโมง      
                $sheet->setCellValue("L{$rowIndex}", $leave['lsum_remain_minute']); // จำนวนชั่วโมง              
                $sheet->setCellValue("M{$rowIndex}", $leave['lsum_leave_old']); // จำนวน นาที
                $sheet->mergeCells("M{$rowIndex}:N{$rowIndex}");
                $rowIndex++;
            }
            $lastrow = $rowIndex - 1;
            $sheet->setCellValue("A{$rowbefore}", $num);
            $sheet->setCellValue("B{$rowbefore}", $data['ps_name']);
            $sheet->mergeCells("A{$rowbefore}:A{$lastrow}");
            $sheet->mergeCells("B{$rowbefore}:B{$lastrow}");
            $sheet->getStyle("B{$rowbefore}")->getFont()->setBold(true);
            $num++;
        }
        foreach (range('A', 'N') as $columnID) {
            if ($columnID !== 'C') { // ยกเว้นคอลัมน์ C
                $sheet->getStyle("{$columnID}1:{$columnID}{$rowIndex}")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            } else {
                $sheet->getStyle("{$columnID}1:{$columnID}2")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }
        }
        // กำหนดความกว้างของคอลัมน์ให้พอดี
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // บันทึกและส่งออกไฟล์ Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = "รายงานการลา ประจำปี" . $filterString['filter_year'] . ".xlsx";
        ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    public function get_overview_leave_person($ps_id, $dp_id)
    {
        $ps_id  = decrypt_id($ps_id);
        $dp_id = decrypt_id($dp_id);
        $data['ps_id'] = $ps_id;
        $data['dp_id'] = $dp_id;
        $data['person_position'] = $this->M_hr_person->get_person_position_by_ums_department_detail($ps_id, $dp_id)->row();
        $this->M_hr_person->ps_id = $ps_id;
        $data['person'] = $this->M_hr_person->get_profile_detail_data_by_id($dp_id)->row();
        $data['controller_dir'] = 'hr/report/Report_leave/';
        $this->output('hr/report/v_report_overview_leave_person.php', $data);
    }
    public function get_overview_leave_summary_person()
    {
        $filter_year = $this->input->post('filter_year') - 543;
        $ps_id = $this->input->post('ps_id');
        $dp_id = $this->input->post('dp_id');

        $sql = 'SELECT * FROM see_hrdb.hr_leave_history as lhis 
            INNER JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lhis.lhis_leave_id
            WHERE lhis.lhis_ps_id =' . $ps_id . ' AND YEAR(lhis.lhis_end_date) =' . $filter_year . ' 
            ORDER BY lhis.lhis_start_date ASC';

        $this->hr = $this->load->database('hr', TRUE);
        $query = $this->hr->query($sql);
        $data = $query->result_array();

        $result = [];

        // ตัวแปรสำหรับคำนวณผลรวม
        $total_one_per_day = 0;
        $total_one_per_hour = 0;
        $total_one_per_minute = 0;
        $total_two_per_day = 0;
        $total_two_per_hour = 0;
        $total_two_per_minute = 0;
        $total_three_per_day = 0;
        $total_three_per_hour = 0;
        $total_three_per_minute = 0;
        $total_four_per_day = 0;
        $total_four_per_hour = 0;
        $total_four_per_minute = 0;
        $total_five_per_day = 0;
        $total_five_per_hour = 0;
        $total_five_per_minute = 0;
        $total_six_per_day = 0;
        $total_six_per_hour = 0;
        $total_six_per_minute = 0;
        // เพิ่มตัวแปรผลรวมสำหรับประเภท leave_id 3, 4, 5, 6 ตามต้องการ

        foreach ($data as $key => $row) {
            $temp = [
                "sequence" => $key + 1,
                "leave_date" => '<span data-id="' . $row['lhis_id'] . '">' . fullDateTH3($row['lhis_start_date']) . ' - ' . fullDateTH3($row['lhis_end_date']) . '</span>',
                "lsum_one_per_day" => ' ',
                "lsum_one_per_hour" => ' ',
                "lsum_one_per_minute" => ' ',
                "lsum_two_per_day" => ' ',
                "lsum_two_per_hour" => ' ',
                "lsum_two_per_minute" => ' ',
                "lsum_three_per_day" => ' ',
                "lsum_three_per_hour" => ' ',
                "lsum_three_per_minute" => ' ',
                "lsum_four_per_day" => ' ',
                "lsum_four_per_hour" => ' ',
                "lsum_four_per_minute" => ' ',
                "lsum_five_per_day" => ' ',
                "lsum_five_per_hour" => ' ',
                "lsum_five_per_minute" => ' ',
                "lsum_six_per_day" => ' ',
                "lsum_six_per_hour" => ' ',
                "lsum_six_per_minute" => ' '
            ];

            switch ($row['lhis_leave_id']) {
                case 1:
                    $temp['lsum_one_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_one_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_one_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_one_per_day += $row['lhis_num_day'];
                    $total_one_per_hour += $row['lhis_num_hour'];
                    $total_one_per_minute += $row['lhis_num_minute'];
                    break;
                case 2:
                    $temp['lsum_two_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_two_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_two_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_two_per_day += $row['lhis_num_day'];
                    $total_two_per_hour += $row['lhis_num_hour'];
                    $total_two_per_minute += $row['lhis_num_minute'];
                    break;
                    // เพิ่มกรณีสำหรับ leave_id 3, 4, 5, 6 ตามต้องการ
                case 3:
                    $temp['lsum_three_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_three_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_three_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_three_per_day += $row['lhis_num_day'];
                    $total_three_per_hour += $row['lhis_num_hour'];
                    $total_three_per_minute += $row['lhis_num_minute'];
                    break;
                case 4:
                    $temp['lsum_four_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_four_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_four_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_four_per_day += $row['lhis_num_day'];
                    $total_four_per_hour += $row['lhis_num_hour'];
                    $total_four_per_minute += $row['lhis_num_minute'];
                    break;
                case 5:
                    $temp['lsum_five_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_five_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_five_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_five_per_day += $row['lhis_num_day'];
                    $total_five_per_hour += $row['lhis_num_hour'];
                    $total_five_per_minute += $row['lhis_num_minute'];
                    break;
                case 6:
                    $temp['lsum_six_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_six_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_six_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];
                    $total_six_per_day += $row['lhis_num_day'];
                    $total_six_per_hour += $row['lhis_num_hour'];
                    $total_six_per_minute += $row['lhis_num_minute'];
                    break;
                default:
                    break;
            }
            $result[] = $temp;
        }
        // pre($total_six_per_hour);
        // die;
        // คำนวณค่าผลรวมที่ต้องการแสดงใน footer
        $footer = [
            "lsum_one_per_day" => $total_one_per_day == 0 ? ' ' : $total_one_per_day,
            "lsum_one_per_hour" => $total_one_per_hour == 0 ? ' ' : $total_one_per_hour,
            "lsum_one_per_minute" => $total_one_per_minute == 0 ? ' ' : $total_one_per_minute,
            "lsum_two_per_day" => $total_two_per_day == 0 ? ' ' : $total_two_per_day,
            "lsum_two_per_hour" => $total_two_per_hour == 0 ? ' ' : $total_two_per_hour,
            "lsum_two_per_minute" => $total_two_per_minute == 0 ? ' ' : $total_two_per_minute,
            "lsum_three_per_day" => $total_three_per_day == 0 ? ' ' : $total_three_per_day,
            "lsum_three_per_hour" => $total_three_per_hour == 0 ? ' ' : $total_three_per_hour,
            "lsum_three_per_minute" => $total_three_per_minute == 0 ? ' ' : $total_three_per_minute,
            "lsum_four_per_day" => $total_four_per_day == 0 ? ' ' : $total_four_per_day,
            "lsum_four_per_hour" => $total_four_per_hour == 0 ? ' ' : $total_four_per_hour,
            "lsum_four_per_minute" => $total_four_per_minute == 0 ? ' ' : $total_four_per_minute,
            "lsum_five_per_day" => $total_five_per_day == 0 ? ' ' : $total_five_per_day,
            "lsum_five_per_hour" => $total_five_per_hour == 0 ? ' ' : $total_five_per_hour,
            "lsum_five_per_minute" => $total_five_per_minute == 0 ? ' ' : $total_five_per_minute,
            "lsum_six_per_day" => $total_six_per_day == 0 ? ' ' : $total_six_per_day,
            "lsum_six_per_hour" => $total_six_per_hour == 0 ? ' ' : $total_six_per_hour,
            "lsum_six_per_minute" => $total_six_per_minute == 0 ? ' ' : $total_six_per_minute,
            // เพิ่มผลรวมของ leave_id 3, 4, 5, 6 ตามต้องการ
        ];
        //    pre($footer);
        $response = [
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => count($result),
            "recordsFiltered" => count($result),
            "data" => $result,
            "footer" => $footer
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    public function get_overview_leave_detail()
    {
        $leave_id = $this->input->post('leave_id');
        $sql = 'SELECT * FROM see_hrdb.hr_leave_history_detail as lhde 
            INNER JOIN see_hrdb.hr_leave_history as lhis on lhis.lhis_id = lhde.lhde_lhis_id
            INNER JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lhis.lhis_leave_id
            LEFT JOIN see_hrdb.hr_base_calendar as clnd ON clnd.clnd_id = lhde.lhde_clnd_id
            WHERE lhde.lhde_lhis_id =' . $leave_id . ' 
            ORDER BY lhde.lhde_date ASC';
        $this->hr = $this->load->database('hr', TRUE);
        $query = $this->hr->query($sql);
        $data = $query->result_array();
        echo json_encode($data);
    }
    public function export_excel_leave_person($filter)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $sql = 'SELECT * FROM see_hrdb.hr_leave_history as lhis 
        INNER JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lhis.lhis_leave_id
        WHERE lhis.lhis_ps_id =' . $filterString['ps_id'] . ' AND YEAR(lhis.lhis_end_date) =' . $filterString['filter_year'] . ' 
        ORDER BY lhis.lhis_start_date ASC';

        $this->hr = $this->load->database('hr', TRUE);
        $query = $this->hr->query($sql);
        $data = $query->result_array();
        $person_position = $this->M_hr_person->get_person_position_by_ums_department_detail($filterString['ps_id'], $filterString['dp_id'])->row();
        $this->M_hr_person->ps_id = $filterString['ps_id'];
        $person = $this->M_hr_person->get_profile_detail_data_by_id($filterString['dp_id'])->row();
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($data)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }
        // สร้างไฟล์ Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ข้อมูลการลา');

        // กำหนด Header
        $sheet->mergeCells('A1:T2')->setCellValue('A1', 'รายงานการลาของบุคลากร ประจำปี ' . ($filterString['filter_year'] + 543) . ' (1 มกราคม พ.ศ. ' . ($filterString['filter_year'] + 543) . ' - ' . '31 ธันวาคม พ.ศ. ' . ($filterString['filter_year'] + 543) . ') ชื่อ ' . $person->pf_name . ' ' . $person->ps_fname . ' ' . $person->ps_lname . ' หน่วยงาน ' . $person_position->dp_name_th . ' ตำแหน่ง ' . $person_position->alp_name);
        $sheet->mergeCells('A3:A4')->setCellValue('A3', 'ลำดับ');
        $sheet->mergeCells('B3:B4')->setCellValue('B3', 'วัน เดือน ปี ที่ลา');
        $sheet->mergeCells('C3:E3')->setCellValue('C3', 'ลาป่วย');
        $sheet->mergeCells('F3:H3')->setCellValue('F3', 'ลาวันหยุดตามประเพณี');
        $sheet->mergeCells('I3:K3')->setCellValue('I3', 'ลาวันหยุดพักผ่อน');
        $sheet->mergeCells('L3:N3')->setCellValue('L3', 'ลากิจได้รับค่าจ้าง');
        $sheet->mergeCells('O3:Q3')->setCellValue('O3', 'ลากิจไม่ได้รับค่าจ้าง');
        $sheet->mergeCells('R3:T3')->setCellValue('R3', 'ลาคลอดบุตร');
        $headers = ['วัน', 'ชั่วโมง', 'นาที'];
        $column = 'C';
        for ($i = 0; $i < 6; $i++) {
            foreach ($headers as $header) {
                $sheet->setCellValue($column . '4', $header);
                $column++;
            }
        }
        $result = [];

        // ตัวแปรสำหรับคำนวณผลรวม
        $total_one_per_day = 0;
        $total_one_per_hour = 0;
        $total_one_per_minute = 0;
        $total_two_per_day = 0;
        $total_two_per_hour = 0;
        $total_two_per_minute = 0;
        $total_three_per_day = 0;
        $total_three_per_hour = 0;
        $total_three_per_minute = 0;
        $total_four_per_day = 0;
        $total_four_per_hour = 0;
        $total_four_per_minute = 0;
        $total_five_per_day = 0;
        $total_five_per_hour = 0;
        $total_five_per_minute = 0;
        $total_six_per_day = 0;
        $total_six_per_hour = 0;
        $total_six_per_minute = 0;
        foreach ($data as $key => $row) {
            $temp = [
                "sequence" => $key + 1,
                "leave_date" =>  fullDateTH3($row['lhis_start_date']) . ' - ' . fullDateTH3($row['lhis_end_date']),
                "lsum_one_per_day" => ' ',
                "lsum_one_per_hour" => ' ',
                "lsum_one_per_minute" => ' ',
                "lsum_two_per_day" => ' ',
                "lsum_two_per_hour" => ' ',
                "lsum_two_per_minute" => ' ',
                "lsum_three_per_day" => ' ',
                "lsum_three_per_hour" => ' ',
                "lsum_three_per_minute" => ' ',
                "lsum_four_per_day" => ' ',
                "lsum_four_per_hour" => ' ',
                "lsum_four_per_minute" => ' ',
                "lsum_five_per_day" => ' ',
                "lsum_five_per_hour" => ' ',
                "lsum_five_per_minute" => ' ',
                "lsum_six_per_day" => ' ',
                "lsum_six_per_hour" => ' ',
                "lsum_six_per_minute" => ' '
            ];

            switch ($row['lhis_leave_id']) {
                case 1:
                    $temp['lsum_one_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_one_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_one_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_one_per_day += $row['lhis_num_day'];
                    $total_one_per_hour += $row['lhis_num_hour'];
                    $total_one_per_minute += $row['lhis_num_minute'];
                    break;
                case 2:
                    $temp['lsum_two_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_two_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_two_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_two_per_day += $row['lhis_num_day'];
                    $total_two_per_hour += $row['lhis_num_hour'];
                    $total_two_per_minute += $row['lhis_num_minute'];
                    break;
                    // เพิ่มกรณีสำหรับ leave_id 3, 4, 5, 6 ตามต้องการ
                case 3:
                    $temp['lsum_three_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_three_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_three_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_three_per_day += $row['lhis_num_day'];
                    $total_three_per_hour += $row['lhis_num_hour'];
                    $total_three_per_minute += $row['lhis_num_minute'];
                    break;
                case 4:
                    $temp['lsum_four_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_four_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_four_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_four_per_day += $row['lhis_num_day'];
                    $total_four_per_hour += $row['lhis_num_hour'];
                    $total_four_per_minute += $row['lhis_num_minute'];
                    break;
                case 5:
                    $temp['lsum_five_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_five_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_five_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];

                    $total_five_per_day += $row['lhis_num_day'];
                    $total_five_per_hour += $row['lhis_num_hour'];
                    $total_five_per_minute += $row['lhis_num_minute'];
                    break;
                case 6:
                    $temp['lsum_six_per_day'] = $row['lhis_num_day']  == 0 ? ' ' : $row['lhis_num_day'];
                    $temp['lsum_six_per_hour'] = $row['lhis_num_hour']  == 0 ? ' ' : $row['lhis_num_hour'];
                    $temp['lsum_six_per_minute'] = $row['lhis_num_minute']  == 0 ? ' ' : $row['lhis_num_minute'];
                    $total_six_per_day += $row['lhis_num_day'];
                    $total_six_per_hour += $row['lhis_num_hour'];
                    $total_six_per_minute += $row['lhis_num_minute'];
                    break;
                default:
                    break;
            }
            $result[] = $temp;
        }
        $footer = [
            "lsum_one_per_day" => $total_one_per_day == 0 ? ' ' : $total_one_per_day,
            "lsum_one_per_hour" => $total_one_per_hour == 0 ? ' ' : $total_one_per_hour,
            "lsum_one_per_minute" => $total_one_per_minute == 0 ? ' ' : $total_one_per_minute,
            "lsum_two_per_day" => $total_two_per_day == 0 ? ' ' : $total_two_per_day,
            "lsum_two_per_hour" => $total_two_per_hour == 0 ? ' ' : $total_two_per_hour,
            "lsum_two_per_minute" => $total_two_per_minute == 0 ? ' ' : $total_two_per_minute,
            "lsum_three_per_day" => $total_three_per_day == 0 ? ' ' : $total_three_per_day,
            "lsum_three_per_hour" => $total_three_per_hour == 0 ? ' ' : $total_three_per_hour,
            "lsum_three_per_minute" => $total_three_per_minute == 0 ? ' ' : $total_three_per_minute,
            "lsum_four_per_day" => $total_four_per_day == 0 ? ' ' : $total_four_per_day,
            "lsum_four_per_hour" => $total_four_per_hour == 0 ? ' ' : $total_four_per_hour,
            "lsum_four_per_minute" => $total_four_per_minute == 0 ? ' ' : $total_four_per_minute,
            "lsum_five_per_day" => $total_five_per_day == 0 ? ' ' : $total_five_per_day,
            "lsum_five_per_hour" => $total_five_per_hour == 0 ? ' ' : $total_five_per_hour,
            "lsum_five_per_minute" => $total_five_per_minute == 0 ? ' ' : $total_five_per_minute,
            "lsum_six_per_day" => $total_six_per_day == 0 ? ' ' : $total_six_per_day,
            "lsum_six_per_hour" => $total_six_per_hour == 0 ? ' ' : $total_six_per_hour,
            "lsum_six_per_minute" => $total_six_per_minute == 0 ? ' ' : $total_six_per_minute,
            // เพิ่มผลรวมของ leave_id 3, 4, 5, 6 ตามต้องการ
        ];
        // เพิ่มข้อมูลใน Excel
        $rowIndex = 5;
        $num = 1;
        foreach ($result as $group_key => $data) {
            $sheet->setCellValue("A{$rowIndex}", $data['sequence']); // ประเภทการลา
            $sheet->setCellValue("B{$rowIndex}", $data['leave_date']); // ประเภทการลา
            $sheet->setCellValue("C{$rowIndex}", $data['lsum_one_per_day']); // จำนวนวัน
            $sheet->setCellValue("D{$rowIndex}", $data['lsum_one_per_hour']); // จำนวนชั่วโมง
            $sheet->setCellValue("E{$rowIndex}", $data['lsum_one_per_minute']); // จำนวน นาที
            $sheet->setCellValue("F{$rowIndex}", $data['lsum_two_per_day']); // จำนวนวัน
            $sheet->setCellValue("G{$rowIndex}", $data['lsum_two_per_hour']); // จำนวนชั่วโมง
            $sheet->setCellValue("H{$rowIndex}", $data['lsum_two_per_minute']); // จำนวน นาที
            $sheet->setCellValue("I{$rowIndex}", $data['lsum_three_per_day']); // จำนวนวัน
            $sheet->setCellValue("J{$rowIndex}", $data['lsum_three_per_hour']); // จำนวนชั่วโมง      
            $sheet->setCellValue("K{$rowIndex}", $data['lsum_three_per_minute']); // จำนวนชั่วโมง              
            $sheet->setCellValue("L{$rowIndex}", $data['lsum_four_per_day']); // จำนวน นาที
            $sheet->setCellValue("M{$rowIndex}", $data['lsum_four_per_hour']); // จำนวนชั่วโมง      
            $sheet->setCellValue("N{$rowIndex}", $data['lsum_four_per_minute']); // จำนวนชั่วโมง              
            $sheet->setCellValue("O{$rowIndex}", $data['lsum_five_per_day']); // จำนวน นาที
            $sheet->setCellValue("P{$rowIndex}", $data['lsum_five_per_hour']); // จำนวนชั่วโมง      
            $sheet->setCellValue("Q{$rowIndex}", $data['lsum_five_per_minute']); // จำนวนชั่วโมง        
            $sheet->setCellValue("R{$rowIndex}", $data['lsum_six_per_day']); // จำนวน นาที
            $sheet->setCellValue("S{$rowIndex}", $data['lsum_six_per_hour']); // จำนวนชั่วโมง      
            $sheet->setCellValue("T{$rowIndex}", $data['lsum_six_per_minute']); // จำนวนชั่วโมง    
            $rowIndex++;
        }
        $sheet->mergeCells("A{$rowIndex}:B{$rowIndex}")->setCellValue("A{$rowIndex}", 'รวม:');
        $sheet->setCellValue("C{$rowIndex}", $footer['lsum_one_per_day']); // จำนวนวัน
        $sheet->setCellValue("D{$rowIndex}", $footer['lsum_one_per_hour']); // จำนวนชั่วโมง
        $sheet->setCellValue("E{$rowIndex}", $footer['lsum_one_per_minute']); // จำนวน นาที
        $sheet->setCellValue("F{$rowIndex}", $footer['lsum_two_per_day']); // จำนวนวัน
        $sheet->setCellValue("G{$rowIndex}", $footer['lsum_two_per_hour']); // จำนวนชั่วโมง
        $sheet->setCellValue("H{$rowIndex}", $footer['lsum_two_per_minute']); // จำนวน นาที
        $sheet->setCellValue("I{$rowIndex}", $footer['lsum_three_per_day']); // จำนวนวัน
        $sheet->setCellValue("J{$rowIndex}", $footer['lsum_three_per_hour']); // จำนวนชั่วโมง      
        $sheet->setCellValue("K{$rowIndex}", $footer['lsum_three_per_minute']); // จำนวนชั่วโมง              
        $sheet->setCellValue("L{$rowIndex}", $footer['lsum_four_per_day']); // จำนวน นาที
        $sheet->setCellValue("M{$rowIndex}", $footer['lsum_four_per_hour']); // จำนวนชั่วโมง      
        $sheet->setCellValue("N{$rowIndex}", $footer['lsum_four_per_minute']); // จำนวนชั่วโมง              
        $sheet->setCellValue("O{$rowIndex}", $footer['lsum_five_per_day']); // จำนวน นาที
        $sheet->setCellValue("P{$rowIndex}", $footer['lsum_five_per_hour']); // จำนวนชั่วโมง      
        $sheet->setCellValue("Q{$rowIndex}", $footer['lsum_five_per_minute']); // จำนวนชั่วโมง        
        $sheet->setCellValue("R{$rowIndex}", $footer['lsum_six_per_day']); // จำนวน นาที
        $sheet->setCellValue("S{$rowIndex}", $footer['lsum_six_per_hour']); // จำนวนชั่วโมง      
        $sheet->setCellValue("T{$rowIndex}", $footer['lsum_six_per_minute']); // จำนวนชั่วโมง    
        foreach (range('A', 'T') as $columnID) {
            $sheet->getStyle("{$columnID}1:{$columnID}{$rowIndex}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }
        // กำหนดความกว้างของคอลัมน์ให้พอดี
        foreach (range('A', 'T') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // บันทึกและส่งออกไฟล์ Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = "รายงานการลาของ_" . $person->ps_fname . '_' . $person->ps_lname . "_ประจำปี" . ($filterString['filter_year'] + 543) . ".xlsx";
        ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    public function export_excel_leave_detail_person($filter)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $leave_id = $this->input->post('leave_id');
        $sql = 'SELECT * FROM see_hrdb.hr_leave_history_detail as lhde 
            INNER JOIN see_hrdb.hr_leave_history as lhis on lhis.lhis_id = lhde.lhde_lhis_id
            INNER JOIN see_hrdb.hr_leave AS lv ON lv.leave_id = lhis.lhis_leave_id
            LEFT JOIN see_hrdb.hr_base_calendar as clnd ON clnd.clnd_id = lhde.lhde_clnd_id
            WHERE lhde.lhde_lhis_id =' . $filterString['leave_id'] . ' 
            ORDER BY lhde.lhde_date ASC';
        $this->hr = $this->load->database('hr', TRUE);
        $query = $this->hr->query($sql);
        $data = $query->result_array();
        // pre($data);
        // die;
        $person_position = $this->M_hr_person->get_person_position_by_ums_department_detail($filterString['ps_id'], $filterString['dp_id'])->row();
        $this->M_hr_person->ps_id = $filterString['ps_id'];
        $person = $this->M_hr_person->get_profile_detail_data_by_id($filterString['dp_id'])->row();
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($data)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }
        // สร้างไฟล์ Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ข้อมูลการลา');

        // กำหนด Header
        $sheet->mergeCells('A1:E2')->setCellValue('A1', 'รายงานรายละเอียดการลาของบุคลากร' . ' ระหว่าง ' . fullDateTH3($data[0]['lhis_start_date']) . ' - ' . fullDateTH3($data[0]['lhis_end_date']) . ' ชื่อ ' . $person->pf_name . ' ' . $person->ps_fname . ' ' . $person->ps_lname . ' หน่วยงาน ' . $person_position->dp_name_th . ' ตำแหน่ง ' . $person_position->alp_name);
        $sheet->mergeCells('A3:A4')->setCellValue('A3', 'ลำดับ');
        $sheet->mergeCells('B3:B4')->setCellValue('B3', 'วัน เดือน ปี ที่ลา');
        $sheet->mergeCells('C3:D3')->setCellValue('C3', $data[0]['leave_name']);
        $headers = ['ชั่วโมง', 'นาที'];
        $column = 'C';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header);
            $column++;
        }

        // เพิ่มข้อมูลใน Excel
        $rowIndex = 5;
        foreach ($data as $key => $value) {
            $sheet->setCellValue("A{$rowIndex}", $key + 1); // ประเภทการลา
            $sheet->setCellValue("B{$rowIndex}", fullDateTH3($value['lhde_date']) . ($value['clnd_name'] != null ? ' (' . $value['clnd_name'] . ') ' . ($value['clnd_start_date'] != $value['clnd_end_date'] ? $this->formatDateRange($value['clnd_start_date'], $value['clnd_end_date']) : fullDateTH3($value['clnd_start_date'])) : '')); // ประเภทการลา
            $sheet->setCellValue("C{$rowIndex}", $value['lhde_num_hour']); // จำนวนชั่วโมง
            $sheet->setCellValue("D{$rowIndex}", $value['lhde_num_minute']); // จำนวน นาที
            $rowIndex++;
        }
        foreach (range('A', 'D') as $columnID) {
            $sheet->getStyle("{$columnID}1:{$columnID}{$rowIndex}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }
        // กำหนดความกว้างของคอลัมน์ให้พอดี
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // pre($data);
        // die;
        // บันทึกและส่งออกไฟล์ Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = "รายงานรายละเอียดการลาของ_" . $person->ps_fname . '_' . $person->ps_lname . '_' . $this->formatDateRange_excel($data[0]['lhis_start_date'], $data[0]['lhis_end_date']) . ".xlsx";
        ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    function formatDateRange_excel($start_date, $end_date)
    {
        // แมปชื่อเดือนภาษาไทย
        $monthsThai = [
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];
        // แปลงวันที่เป็น DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        // ดึงข้อมูลวันที่
        $start_day = $start->format('j');
        $end_day = $end->format('j');

        // ดึงเดือนและปี
        $month = $monthsThai[$start->format('m')]; // ใช้เดือนจากวันที่เริ่มต้น
        $year = $start->format('Y') + 543; // แปลงปีเป็นพ.ศ.

        // คืนค่าในรูปแบบ "start_day - end_day เดือน ปี (พ.ศ.)"
        return "$start_day" . '_' . "$end_day" . '_' . "$month" . '_' . "$year";
    }
    function formatDateRange($start_date, $end_date)
    {
        // แมปชื่อเดือนภาษาไทย
        $monthsThai = [
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];

        // แปลงวันที่เป็น DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        // ดึงข้อมูลวันที่ เดือน และปี
        $startDay = $start->format('j');
        $startMonth = $monthsThai[$start->format('m')];
        $startYear = $start->format('Y') + 543; // แปลงปีเป็น พ.ศ.

        $endDay = $end->format('j');
        $endMonth = $monthsThai[$end->format('m')];
        $endYear = $end->format('Y') + 543; // แปลงปีเป็น พ.ศ.

        // ตรวจสอบว่าอยู่ในเดือนและปีเดียวกันหรือไม่
        if ($start->format('m') === $end->format('m') && $start->format('Y') === $end->format('Y')) {
            // เดือนเดียวกัน
            return "$startDay-$endDay $startMonth $startYear";
        } else {
            // คนละเดือนหรือคนละปี
            return "$startDay $startMonth $startYear ถึง $endDay $endMonth $endYear";
        }
    }
}
