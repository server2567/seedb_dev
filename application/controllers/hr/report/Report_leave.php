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
            $sql .= " WHERE (" . implode(' OR ', $likeConditions) . ")";
        } else {
            $sql .= " WHERE lsum.lsum_year = " . ($filter_year) . " AND lsum.lsum_dp_id = '$filter_depart'"; // เงื่อนไขพื้นฐาน
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
        foreach ($groupedData as $ps_id => $data) {
            // แถวหัวข้อหลัก
            $dataForDataTable[] = [
                'sequence' => '', // ไม่ต้องใส่ลำดับในแถวหัวข้อหลัก
                'ps_name' => "<strong>{$data['ps_name']}</strong>",
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
                    'ps_name' => '', // เว้นว่างไว้เพื่อไม่ต้องแสดงชื่อซ้ำ
                    'leave_name' => $leave['leave_name'],
                    'lsum_per_day' => $leave['lsum_per_day'],
                    'lsum_per_hour' => $leave['lsum_per_hour'],
                    'lsum_per_minute' => $leave['lsum_per_minute'],
                    'lsum_num_day' => $leave['lsum_num_day'],
                    'lsum_num_hour' => $leave['lsum_num_hour'],
                    'lsum_num_minute' => $leave['lsum_num_minute'],
                    'lsum_remain_day' => $leave['lsum_remain_day'],
                    'lsum_remain_hour' => $leave['lsum_remain_hour'],
                    'lsum_remain_minute' => $leave['lsum_remain_minute'],
                    'lsum_leave_old' => $leave['lsum_leave_old']
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
}
