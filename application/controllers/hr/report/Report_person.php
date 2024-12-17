<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Report_Controller.php");
require APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Report_person extends Report_Controller
{

    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/report/report_person";
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
        $data['controller_dir'] = 'hr/report/Report_person/';
        $this->M_hr_person->ps_id =  $this->session->userdata('us_ps_id');
        $data['ps_id'] = $this->session->userdata('us_ps_id');
        $this->ums_db = $this->load->database('ums', TRUE);
        $sql = "SELECT * FROM see_umsdb.ums_department";
        $query = $this->ums_db->query($sql);
        $data['department_list'] = $query->result_array();
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['base_admin_position_list'] = $this->M_hr_person->get_hr_base_admin_position_data()->result();
        $data['base_hire_list'] = $this->M_hr_hire->get_all_by_active()->result();
        $hire_data = $this->session->userdata('hr_hire_is_medical');
        $hire_name = ['N' => 'สายพยาบาล', 'SM' => 'สายสนับสนุนทางการแพทย์',  'A' => 'สายบริหาร','M'=>'สายบริหาร'];
        $hire_arr = [];
        foreach ($hire_data as $key => $hire) {
            if(isset($hire_name[$hire['type']])){
                $hire_arr[$hire['type']] = $hire_name[$hire['type']];
            }
        }
        foreach ($data['base_hire_list'] as $key => $value) {
            if ($hire_arr[$value->hire_is_medical]) {
                $value->hire_name .= ' ' . $hire_arr[$value->hire_is_medical];
            }
        }
        $data['base_adline_list'] = $this->M_hr_adline_position->get_all_by_active()->result();
        $data['year_filter'] = $this->M_hr_develop->get_develop_year_filter()->result();
        $this->output('hr/report/v_report_overview_person_info', $data);
    }
    public function get_person_develop_report_list()
    {
        $data['result'] = $this->M_hr_develop->get_report_develop_person_list()->result();
        foreach ($data['result']  as $key => $value) {
            $value->dev_start_date = fullDateTH3($value->dev_start_date);
            $value->dev_end_date = fullDateTH3($value->dev_end_date);
        }
        $result = array('data' => $data);
        echo json_encode($result);
    }
    public function get_overview_person_info()
    {
        // ข้อมูลคงที่ (Fixed Data)
        $fitiler_depart = $this->input->post('filter_depart');
        $filter_year = $this->input->post('filter_year') - 543;
        $fitiler_hire = $this->input->post('filter_hire');
        $fitiler_admin = $this->input->post('filter_admin');
        $fitiler_adline = $this->input->post('filter_adline');
        $filter_status = $this->input->post('filter_status');
        $start = $this->input->post('start') == 'NaN' ? 0 : $this->input->post('start');   // เริ่มต้นแถว
        $length = $this->input->post('length'); // จำนวนแถวต่อหน้า
        $draw = $this->input->post('draw');     // รอบการวาดของ DataTables
        $searchValue = $this->input->post('search')['value']; // ค่าค้นหา

        // SQL Query พื้นฐาน
        $sql = "
      SELECT 
    hips.hips_ps_id, 
    hips.hips_ps_pf_id, 
    pf.pf_name, pf.pf_name_en, pf.pf_name_abbr, pf.pf_name_abbr_en, 
    hips.hips_ps_fname, hips.hips_ps_lname, hips.hips_ps_fname_en, hips.hips_ps_lname_en, 
    hips.hips_ps_nickname, hips.hips_ps_nickname_en, 
    psd.psd_id_card_no, psd.psd_picture, psd.psd_blood_id, psd.psd_reli_id, psd.psd_nation_id, 
    psd.psd_race_id, psd.psd_psst_id, psd.psd_birthdate, psd.psd_gd_id, psd.psd_desc, 
    psd.psd_facebook, psd.psd_line, psd.psd_email, psd.psd_cellphone, psd.psd_phone, 
    psd.psd_ex_phone, psd.psd_work_phone, psd.psd_addcur_no, psd.psd_addcur_pv_id, 
    psd.psd_addcur_amph_id, psd.psd_addcur_dist_id, psd.psd_addcur_zipcode, psd.psd_addhome_no, 
    psd.psd_addhome_pv_id, psd.psd_addhome_amph_id, psd.psd_addhome_dist_id, psd.psd_addhome_zipcode, 
    hipos.hipos_pos_ps_code, gd.gd_name, race.race_name, reli.reli_name, blood.blood_name, 
    country.country_name, psst.psst_name, dist.dist_name, pv.pv_name, amph.amph_name, 
    dp.dp_name_th AS department, hire.hire_name, alp.alp_name, hipos.hipos_start_date, hipos.hipos_id,
    admin.admin_name,

    -- JSON Array สำหรับข้อมูลการศึกษา
    JSON_ARRAYAGG(
        JSON_OBJECT(
            'edu_id', edu.edu_id,
            'degree', edudg.edudg_name,
            'level', edulv.edulv_name,
            'major', edumj.edumj_name,
            'place_name', place.place_name
        )
        ORDER BY 
            CASE 
                WHEN edu.edu_highest = 'Y' THEN 1
                WHEN edu.edu_highest = 'N' THEN 2
                ELSE 3
            END
    ) AS education_info

FROM see_hrdb.hr_person_detail AS psd
LEFT JOIN (
    SELECT hips1.*
    FROM see_hrdb.hr_person_history AS hips1
    INNER JOIN (
        SELECT hips_ps_id, MAX(hips_start_date) AS max_start_date
        FROM see_hrdb.hr_person_history
        WHERE YEAR(hips_start_date) = '$filter_year'
        GROUP BY hips_ps_id
    ) AS max_hips 
    ON hips1.hips_ps_id = max_hips.hips_ps_id 
    AND hips1.hips_start_date = max_hips.max_start_date
) AS hips ON hips.hips_ps_id = psd.psd_ps_id

LEFT JOIN see_hrdb.hr_base_prefix AS pf ON hips.hips_ps_pf_id = pf.pf_id

LEFT JOIN (
    SELECT hipos1.*
    FROM see_hrdb.hr_person_position_history AS hipos1
    INNER JOIN (
        SELECT hipos_ps_id, MAX(hipos_start_date) AS max_start_date
        FROM see_hrdb.hr_person_position_history
        WHERE YEAR(hipos_start_date) = '$filter_year'
        GROUP BY hipos_ps_id
    ) AS max_hipos 
    ON hipos1.hipos_ps_id = max_hipos.hipos_ps_id 
    AND hipos1.hipos_start_date = max_hipos.max_start_date
) AS hipos ON hipos.hipos_ps_id = hips.hips_ps_id

LEFT JOIN see_umsdb.ums_department AS dp ON dp.dp_id = hipos.hipos_pos_dp_id
LEFT JOIN see_hrdb.hr_base_gender AS gd ON gd.gd_id = psd.psd_gd_id
LEFT JOIN see_hrdb.hr_base_blood AS blood ON blood.blood_id = psd.psd_blood_id
LEFT JOIN see_hrdb.hr_base_religion AS reli ON reli.reli_id = psd.psd_reli_id
LEFT JOIN see_hrdb.hr_base_race AS race ON race.race_id = psd.psd_race_id
LEFT JOIN see_hrdb.hr_base_country AS country ON country.country_id = psd.psd_nation_id
LEFT JOIN see_hrdb.hr_base_person_status AS psst ON psst.psst_id = psd.psd_psst_id
LEFT JOIN see_hrdb.hr_base_district AS dist ON dist.dist_id = psd.psd_addhome_dist_id
LEFT JOIN see_hrdb.hr_base_province AS pv ON pv.pv_id = psd.psd_addhome_pv_id
LEFT JOIN see_hrdb.hr_base_amphur AS amph ON amph.amph_id = psd.psd_addhome_amph_id

-- เข้าร่วมกับข้อมูลการศึกษา
LEFT JOIN see_hrdb.hr_person_education AS edu ON edu.edu_ps_id = hips.hips_ps_id
LEFT JOIN see_hrdb.hr_base_education_degree AS edudg ON edudg.edudg_id = edu.edu_edudg_id
LEFT JOIN see_hrdb.hr_base_education_level AS edulv ON edulv.edulv_id = edu.edu_edulv_id
LEFT JOIN see_hrdb.hr_base_education_major AS edumj ON edumj.edumj_id = edu.edu_edumj_id
LEFT JOIN see_hrdb.hr_base_place AS place ON place.place_id = edu.edu_place_id
LEFT JOIN see_hrdb.hr_base_hire AS hire ON hire.hire_id = hipos.hipos_pos_hire_id
LEFT JOIN see_hrdb.hr_base_adline_position AS alp ON alp.alp_id = hipos.hipos_pos_alp_id
 LEFT JOIN see_hrdb.hr_base_admin_position AS admin ON admin.admin_id = hipos.hipos_pos_admin_id
        ";
        $searchableColumns = [
            'psd_id_card_no',
            'pf.pf_name',
            'hips.hips_ps_fname',
            'hips.hips_ps_lname',
            'pf.pf_name_en',
            'hips.hips_ps_fname_en',
            'hips.hips_ps_lname_en',
            'gd.gd_name',
            'admin.admin_name',
            'race.race_name',
            'country.country_name',
            'reli.reli_name',
            'psst.psst_name',
            'psd.psd_birthdate',
            'pv.pv_name',
            'psd.psd_addhome_no',
            'amph.amph_name',
            'dist.dist_name',
            'psd.psd_addhome_zipcode',
            'edudg.edudg_name',
            'edulv.edulv_name',
            'edumj.edumj_name'
        ];
        // เพิ่มเงื่อนไข LIKE ถ้ามีการค้นหา
        if (!empty($searchValue)) {
            $likeConditions = [];
            foreach ($searchableColumns as $column) {
                $likeConditions[] = "$column LIKE '%" . $this->db->escape_like_str($searchValue) . "%'";
            }
            $sql .= " WHERE (" . implode(' OR ', $likeConditions) . " ) AND hipos.hipos_pos_dp_id = '$fitiler_depart'"; // รวมเงื่อนไขด้วย OR
        } else {
            $sql .= " WHERE hipos.hipos_pos_dp_id = '$fitiler_depart'";
        }
        if ($fitiler_hire != 'all') {
            $sql .= " AND hipos.hipos_pos_hire_id = '$fitiler_hire'";
        }
        if ($fitiler_adline != 'all') {
            $sql .= " AND hipos.hipos_pos_alp_id = '$fitiler_adline'";
        }
        if ($fitiler_admin != 'all') {
            $sql .= " AND hipos.hipos_pos_admin_id = '$fitiler_admin'";
        }
        $sql .= " AND hipos.hipos_pos_status = '$filter_status' GROUP BY hips.hips_ps_id ";
        $this->hr = $this->load->database('hr', TRUE);
        // เพิ่ม LIMIT สำหรับการแบ่งหน้า
        $sql .= "ORDER BY hipos.hipos_ps_id ";
        if ($length != 0) {
            $sql .= "LIMIT " . (int)$start . ", " . (int)$length;
        }
        // รัน Query
        $query = $this->hr->query($sql);
        $result = $query->result_array();
        $dataWithSequence = [];
        foreach ($result as $index => $item) {
            $education = json_decode($item['education_info'], true);
            $item['education'] = '';
            foreach ($education as $key => $edu) {
                $item['education'] .= $edu['level'] . ' ' . $edu['major'] . ' ' . $edu['degree'] . '<br>';
            }
            $item['sequence'] = $start + $index + 1; // คำนวณลำดับ (start + index + 1)
            $item['division'] = '';
            $item['house_id'] = '';
            $item['psd_birthdate'] = fullDateth3($item['psd_birthdate']);
            foreach ($item as $key => $value) {
                if (is_null($value) || $value === '' || $value === "  <br>") {
                    $item[$key] = '-';
                }
            }
            $dataWithSequence[] = $item;
        }
        // นับจำนวนแถวทั้งหมด (ไม่สนใจการค้นหา)
        $totalRows = $this->hr->count_all('hr_person');

        // นับจำนวนแถวที่ตรงกับการค้นหา
        $totalFiltered = $query->num_rows();

        // สร้าง JSON Response สำหรับ DataTables
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRows,
            "recordsFiltered" => $totalFiltered,
            "data" => $dataWithSequence
        ];

        // กำหนด Header ให้เป็น JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
    /*
	* export_excel_develop_person
	* ส่งออกข้อมูลรายการพัฒนาบุคลากรตาม filter แบบ excel
	* @input filter,g_id
	* $output -
	* @author JIRADAT POMYAI
	* @Create Date 18/10/2024
	*/
    public function export_excel_develop_person($filter)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        // ดึงข้อมูล
        $sql = "
             SELECT 
                hips.hips_ps_id, 
                hips.hips_ps_pf_id, 
                pf.pf_name, pf.pf_name_en, pf.pf_name_abbr, pf.pf_name_abbr_en, 
                hips.hips_ps_fname, hips.hips_ps_lname, hips.hips_ps_fname_en, hips.hips_ps_lname_en, 
                hips.hips_ps_nickname, hips.hips_ps_nickname_en, 
                psd.psd_id_card_no, psd.psd_picture, psd.psd_blood_id, psd.psd_reli_id, psd.psd_nation_id, 
                psd.psd_race_id, psd.psd_psst_id, psd.psd_birthdate, psd.psd_gd_id, psd.psd_desc, 
                psd.psd_facebook, psd.psd_line, psd.psd_email, psd.psd_cellphone, psd.psd_phone, 
                psd.psd_ex_phone, psd.psd_work_phone, psd.psd_addcur_no, psd.psd_addcur_pv_id, 
                psd.psd_addcur_amph_id, psd.psd_addcur_dist_id, psd.psd_addcur_zipcode, psd.psd_addhome_no, 
                psd.psd_addhome_pv_id, psd.psd_addhome_amph_id, psd.psd_addhome_dist_id, psd.psd_addhome_zipcode, 
                hipos.hipos_pos_ps_code, gd.gd_name, race.race_name, reli.reli_name, blood.blood_name, 
                country.country_name, psst.psst_name, dist.dist_name, pv.pv_name, amph.amph_name, 
                dp.dp_name_th AS department, hire.hire_name, alp.alp_name, hipos.hipos_start_date, hipos.hipos_id,
                admin.admin_name,

                -- JSON Array สำหรับข้อมูลการศึกษา
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'edu_id', edu.edu_id,
                        'degree', edudg.edudg_name,
                        'level', edulv.edulv_name,
                        'major', edumj.edumj_name,
                        'place_name', place.place_name
                    )
                    ORDER BY 
                        CASE 
                            WHEN edu.edu_highest = 'Y' THEN 1
                            WHEN edu.edu_highest = 'N' THEN 2
                            ELSE 3
                        END
                ) AS education_info

            FROM see_hrdb.hr_person_detail AS psd
            LEFT JOIN (
                SELECT hips1.*
                FROM see_hrdb.hr_person_history AS hips1
                INNER JOIN (
                    SELECT hips_ps_id, MAX(hips_start_date) AS max_start_date
                    FROM see_hrdb.hr_person_history
                    WHERE YEAR(hips_start_date) = " . ($filterString['filter_year'] - 543) . "
                    GROUP BY hips_ps_id
                ) AS max_hips 
                ON hips1.hips_ps_id = max_hips.hips_ps_id 
                AND hips1.hips_start_date = max_hips.max_start_date
            ) AS hips ON hips.hips_ps_id = psd.psd_ps_id

            LEFT JOIN see_hrdb.hr_base_prefix AS pf ON hips.hips_ps_pf_id = pf.pf_id

            LEFT JOIN (
                SELECT hipos1.*
                FROM see_hrdb.hr_person_position_history AS hipos1
                INNER JOIN (
                    SELECT hipos_ps_id, MAX(hipos_start_date) AS max_start_date
                    FROM see_hrdb.hr_person_position_history
                    WHERE YEAR(hipos_start_date) = " . ($filterString['filter_year'] - 543) . "
                    GROUP BY hipos_ps_id
                ) AS max_hipos 
                ON hipos1.hipos_ps_id = max_hipos.hipos_ps_id 
                AND hipos1.hipos_start_date = max_hipos.max_start_date
            ) AS hipos ON hipos.hipos_ps_id = hips.hips_ps_id

            LEFT JOIN see_umsdb.ums_department AS dp ON dp.dp_id = hipos.hipos_pos_dp_id
            LEFT JOIN see_hrdb.hr_base_gender AS gd ON gd.gd_id = psd.psd_gd_id
            LEFT JOIN see_hrdb.hr_base_blood AS blood ON blood.blood_id = psd.psd_blood_id
            LEFT JOIN see_hrdb.hr_base_religion AS reli ON reli.reli_id = psd.psd_reli_id
            LEFT JOIN see_hrdb.hr_base_race AS race ON race.race_id = psd.psd_race_id
            LEFT JOIN see_hrdb.hr_base_country AS country ON country.country_id = psd.psd_nation_id
            LEFT JOIN see_hrdb.hr_base_person_status AS psst ON psst.psst_id = psd.psd_psst_id
            LEFT JOIN see_hrdb.hr_base_district AS dist ON dist.dist_id = psd.psd_addhome_dist_id
            LEFT JOIN see_hrdb.hr_base_province AS pv ON pv.pv_id = psd.psd_addhome_pv_id
            LEFT JOIN see_hrdb.hr_base_amphur AS amph ON amph.amph_id = psd.psd_addhome_amph_id
            LEFT JOIN see_hrdb.hr_base_admin_position AS admin ON admin.admin_id = hipos.hipos_pos_admin_id
            -- เข้าร่วมกับข้อมูลการศึกษา
            LEFT JOIN see_hrdb.hr_person_education AS edu ON edu.edu_ps_id = hips.hips_ps_id
            LEFT JOIN see_hrdb.hr_base_education_degree AS edudg ON edudg.edudg_id = edu.edu_edudg_id
            LEFT JOIN see_hrdb.hr_base_education_level AS edulv ON edulv.edulv_id = edu.edu_edulv_id
            LEFT JOIN see_hrdb.hr_base_education_major AS edumj ON edumj.edumj_id = edu.edu_edumj_id
            LEFT JOIN see_hrdb.hr_base_place AS place ON place.place_id = edu.edu_place_id
            LEFT JOIN see_hrdb.hr_base_hire AS hire ON hire.hire_id = hipos.hipos_pos_hire_id
            LEFT JOIN see_hrdb.hr_base_adline_position AS alp ON alp.alp_id = hipos.hipos_pos_alp_id
                    WHERE hipos.hipos_pos_dp_id = " . $filterString['filter_depart'] . " AND hipos.hipos_pos_status = " . $filterString['filter_status'];
        // เพิ่มเงื่อนไข LIKE ถ้ามีการค้นหา
        if ($filterString['filter_hire'] != 'all') {
            $sql .= " AND hipos.hipos_pos_hire_id = " . $filterString['filter_hire'];
        }
        if ($filterString['filter_adline'] != 'all') {
            $sql .= " AND hipos.hipos_pos_alp_id = " . $filterString['filter_adline'];
        }
        $sql .= " GROUP BY hips.hips_ps_id ORDER BY hipos.hipos_ps_id";
        $this->hr = $this->load->database('hr', TRUE);
        // เพิ่ม LIMIT สำหรับการแบ่งหน้า
        // รัน Query
        $query = $this->hr->query($sql);
        $result = $query->result_array();
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($result)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }
        // สร้าง Excel Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ตั้งค่าหัวข้อของแผ่นงาน
        $sheet->setTitle('ข้อมูลบุคลากร');

        // กำหนด Header ที่มีการ Merge Cell
        $sheet->mergeCells('A1:AB2')->setCellValue('A1', 'ข้อมูลบุคลากร ประจำปี 2567');
        // กำหนดขนาดฟอนต์
        $sheet->getStyle('A1')->getFont()->setSize(22)->setBold(true);
        // จัดตำแหน่งข้อความให้อยู่กึ่งกลางทั้งแนวนอนและแนวตั้ง
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A3', 'ที่');
        $sheet->mergeCells('B3:C3')->setCellValue('B3', 'หน่วยงานต้นสังกัด'); // Merge B1:C1
        $sheet->mergeCells('D3:Q3')->setCellValue('D3', 'ข้อมูลพื้นฐานบุคคล');
        $sheet->mergeCells('R3:W3')->setCellValue('R3', 'ข้อมูลที่อยู่ของบุคลากร (ตามสำเนาทะเบียนบ้าน)');
        $sheet->mergeCells('X3:AB3')->setCellValue('X3', 'ข้อมูลการศึกษา');
        $headers = [
            'หน่วยงานต้นสังกัด',
            'ประเภทบุคลกร',
            'ประเภทสายงาน',
            'ตำแหน่งในการบริหารงาน',
            'รหัสประจำตัวประชาชน',
            'ตำแหน่ง/ยศ',
            'ชื่อ (ภาษาไทย)',
            'นามสกุล (ภาษาไทย)',
            'ตำแหน่ง/ยศ (ภาษาอังกฤษ)',
            'ชื่อ (ภาษาอังกฤษ)',
            'นามสกุล (ภาษาอังกฤษ)',
            'เพศ',
            'เชื้อชาติ',
            'สัญชาติ',
            'ศาสนา',
            'วันเดือนปีเกิด (DD-MM-YYYY)',
            'สถานภาพ (โสด/สมรส)',
            'ภูมิสำเนา (จังหวัด)',
            'รหัสประจำบ้าน',
            'ที่อยู่',
            'ตำบล',
            'อำเภอ',
            'จังหวัด',
            'รหัสไปรษณีย์',
            'ระดับการศึกษา',
            'วุฒิการศึกษา',
            'สาขาวิชาเอก'
        ];

        // เริ่มต้นที่คอลัมน์ B2
        $column = 'B';

        // วนลูปใส่ค่าหัวตาราง
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header); // กำหนดค่าให้กับแต่ละคอลัมน์
            $sheet->getColumnDimension($column)->setWidth(20); // ตั้งค่าความกว้างของคอลัมน์
            $column++;
        }

        // จัดตำแหน่งข้อความในหัวตารางให้อยู่ตรงกลาง
        $sheet->getStyle('B4:' . $column . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B4:' . $column . '4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // กำหนดค่าหัวข้อในเซลล์อื่น ๆ
        $sheet->setCellValue('A4', 'ลำดับ');
        $sheet->mergeCells('A3:A4'); // รวมเซลล์ A1:A2 (สำหรับลำดับ)

        // ตั้งค่าความกว้างของคอลัมน์ให้เหมาะสม
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);

        // จัดให้ข้อความอยู่กึ่งกลางทั้งแนวตั้งและแนวนอน
        $sheet->getStyle('A3:AB4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:AB4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // กำหนดเส้นขอบให้กับ Header
        $row = 5; // เริ่มที่แถวที่ 4
        $sequence = 1;
        $lineBreak = "\n";
        foreach ($result as $data) {
            $education = json_decode($data['education_info'], true);
            $data['education'] = '';
            foreach ($education as $key => $edu) {
                if ($key > 0) {
                    $data['education'] .= $lineBreak;
                }
                $data['education'] .= '- ' . $edu['level'] . ' ' . $edu['major'] . ' ' . $edu['degree'];
            }
            $sheet->setCellValue('A' . $row, $sequence++); // ลำดับ
            $sheet->setCellValue('B' . $row, $data['department'] == null ? '-' : $data['department']); // หน่วยงาน
            $sheet->setCellValue('C' . $row, $data['hire_name'] == null ? '-' : $data['hire_name']);
            $sheet->setCellValue('D' . $row, $data['alp_name'] == null ? '-' : $data['alp_name']);
            $sheet->setCellValue('E' . $row, $data['admin_name'] == null ? '-' : $data['admin_name']); // กลุ่มงาน
            $sheet->setCellValue('F' . $row, $data['psd_id_card_no'] == null ? '-' : $data['psd_id_card_no']); // เลขบัตรประชาชน
            $sheet->setCellValue('G' . $row, $data['pf_name'] == null ? '-' : $data['pf_name']); // คำนำหน้า (ไทย)
            $sheet->setCellValue('H' . $row, $data['hips_ps_fname'] == null ? '-' : $data['hips_ps_fname']); // ชื่อ (ไทย)
            $sheet->setCellValue('I' . $row, $data['hips_ps_lname'] == null ? '-' : $data['hips_ps_lname']); // นามสกุล (ไทย)
            $sheet->setCellValue('J' . $row, $data['pf_name_en'] == null ? '-' : $data['pf_name_en']); // คำนำหน้า (อังกฤษ)
            $sheet->setCellValue('K' . $row, $data['hips_ps_fname_en'] == null ? '-' : $data['hips_ps_fname_en']); // ชื่อ (อังกฤษ)
            $sheet->setCellValue('L' . $row, $data['hips_ps_lname_en'] == null ? '-' : $data['hips_ps_lname_en']); // นามสกุล (อังกฤษ)
            $sheet->setCellValue('M' . $row, $data['gd_name'] == null ? '-' : $data['gd_name']); // เพศ
            $sheet->setCellValue('N' . $row, $data['race_name'] == null ? '-' : $data['race_name']); // เชื้อชาติ
            $sheet->setCellValue('O' . $row, $data['country_name'] == null ? '-' : $data['country_name']); // สัญชาติ
            $sheet->setCellValue('P' . $row, $data['reli_name'] == null ? '-' : $data['reli_name']); // ศาสนา
            $sheet->setCellValue('Q' . $row, fullDateth3($data['psd_birthdate'])); // วันเกิด
            $sheet->setCellValue('R' . $row, $data['psst_name'] == null ? '-' : $data['psst_name']); // สถานะการทำงาน
            $sheet->setCellValue('S' . $row, $data['pv_name'] == null ? '-' : $data['pv_name']); // จังหวัด
            $sheet->setCellValue('T' . $row, ''); // รหัสบ้าน
            $sheet->setCellValue('U' . $row, $data['psd_addhome_no'] == null ? '-' : $data['psd_addhome_no']); // ที่อยู่
            $sheet->setCellValue('V' . $row, $data['dist_name'] == null ? '-' : $data['dist_name']); // ตำบล
            $sheet->setCellValue('W' . $row, $data['amph_name'] == null ? '-' : $data['amph_name']); // อำเภอ
            $sheet->setCellValue('X' . $row, $data['pv_name'] == null ? '-' : $data['pv_name']); // จังหวัด (ซ้ำ)
            $sheet->setCellValue('Y' . $row, $data['psd_addhome_zipcode'] == null ? '-' : $data['psd_addhome_zipcode']); // รหัสไปรษณีย์
            $sheet->mergeCells('Z' . $row . ':' . 'AB' . $row)->setCellValue('Z' . $row, $data['education'] == '  ' ? '-' : $data['education']);
            $sheet->getStyle('Z' . $row)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($row)->setRowHeight(-1);
            // $sheet->getStyle('Z' . $row)->getAlignment()->setWrapText(true);
            // $sheet->mergeCells('Z' . $row . ':AB' . $row)->setCellValue('Z' . $row, '');
            $row++; // ขยับไปยังแถวถัดไป
        }
        foreach (range('A', 'Z') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getStyle('A1:AB' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        // สร้างไฟล์ Excel และส่งออก
        $writer = new Xlsx($spreadsheet);
        $fileName = 'รายงานการพัฒนาบุคลากร';
        ob_clean();
        // กำหนด Headers สำหรับการดาวน์โหลดไฟล์
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
