<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("Report_Controller.php");
require APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Report_develop extends Report_Controller
{

    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

        // [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
        $this->mn_active_url = "hr/report/report_develop";
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
        $data['controller_dir'] = 'hr/report/Report_develop/';
        $this->M_hr_person->ps_id =  $this->session->userdata('us_ps_id');
        $data['ps_id'] = $this->session->userdata('us_ps_id');
        $data['base_develop_type_list'] = $this->M_hr_develop_type->get_all_by_active('asc')->result();
        $data['base_hire_list'] = $this->M_hr_hire->get_all_by_active()->result();
        $data['base_adline_list'] = $this->M_hr_adline_position->get_all_by_active()->result();
        $data['year_filter'] = $this->M_hr_develop->get_develop_year_filter()->result();
        $this->output('hr/report/v_report_overview_meeting', $data);
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
    /*
	* export_excel_develop_person
	* ส่งออกข้อมูลรายการพัฒนาบุคลากรตาม filter แบบ excel
	* @input filter,g_id
	* $output -
	* @author JIRADAT POMYAI
	* @Create Date 18/10/2024
	*/
    public function export_excel_develop_person($filter, $ps_id = null)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $filterString['ps_id'] = $ps_id;
        // ดึงข้อมูล
        $result = $this->M_hr_develop->get_export_develop_list_by_filter($filterString)->result();
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($result)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }

        // สร้าง Excel Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ตั้งค่าหัวข้อของแผ่นงาน
        $sheet->setCellValue('A1', 'รายงานการพัฒนาบุคลากร');
        $sheet->mergeCells('A1:G1'); // รวมเซลล์จากคอลัมน์ A ถึง G
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // ตั้งค่าหัวตาราง
        $headers = ['#', 'เรื่องไปอบรม', 'วันที่เริ่มอบรม', 'ประเภทการไปอบรม', 'สถานที่', 'จำนวนชั่วโมง'];
        $sheet->fromArray($headers, NULL, 'A2');

        // เริ่มต้นเขียนข้อมูลที่แถวที่ 3
        $row = 3;

        foreach ($result as $person) {
            // เขียนชื่อบุคคลและรวมเซลล์ (colspan)
            $sheet->setCellValue('A' . $row, $person->person_name);
            $sheet->mergeCells("A{$row}:F{$row}"); // รวมเซลล์จากคอลัมน์ A ถึง F
            $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true);

            $row++; // ขยับไปยังแถวถัดไป

            // เขียนข้อมูลการอบรมของแต่ละบุคคล
            $index = 1;
            foreach (json_decode($person->devps_data_array) as $dev) {
                $sheet->setCellValue('A' . $row, $index++);
                $sheet->setCellValue('B' . $row, $dev->dev_name);
                $sheet->setCellValue('C' . $row, fullDateTH3($dev->dev_start_date) . ' ถึง ' . fullDateTH3($dev->dev_end_date));
                $sheet->setCellValue('D' . $row, $dev->devb_name);
                $sheet->setCellValue('E' . $row, $dev->dev_place);
                $sheet->setCellValue('F' . $row, $dev->dev_hour);
                $row++;
            }

            // เพิ่มแถวรวมจำนวนชั่วโมง
            $sheet->setCellValue('A' . $row, 'รวมทั้งหมด: ' . $person->sum_hour . ' ชั่วโมง');
            $sheet->mergeCells("A{$row}:F{$row}"); // รวมเซลล์จากคอลัมน์ A ถึง F
            $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true); // ทำตัวหนา
            $sheet->getStyle("A{$row}:F{$row}")
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $row++;
        }

        // ปรับความกว้างอัตโนมัติ
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // สร้างไฟล์ Excel และส่งออก
        $writer = new Xlsx($spreadsheet);
        $fileName = 'รายงานการพัฒนาบุคลากร';
        ob_clean(); // ทำความสะอาด output buffer
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    /*
	* export_pdf_develop_person
	* ส่งออกข้อมูลรายการพัฒนาบุคลากรตาม filter แบบ excel
	* @input filter,g_id
	* $output -
	* @author JIRADAT POMYAI
	* @Create Date 18/10/2024
	*/
    public function export_pdf_develop_person($filter, $ps_id = null)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $filterString['ps_id'] = $ps_id;

        // ดึงข้อมูล
        $result = $this->M_hr_develop->get_export_develop_list_by_filter($filterString)->result();

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($result)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }

        // โหลด autoload ของ mPDF
        require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

        // สร้างอินสแตนซ์ของ mPDF พร้อมตั้งค่ากระดาษเป็นแนวนอน (landscape)
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L', // กระดาษ A4 แนวนอน
            'default_font_size' => 16,
            'default_font' => 'sarabun', // ฟอนต์ Sarabun สำหรับภาษาไทย
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
        ]);

        // สร้าง HTML สำหรับ PDF
        $html = '<h2 style="text-align: center;">รายงานการพัฒนาบุคลากร</h2>';

        foreach ($result as $person) {
            $html .= '<h4>' . $person->person_name . '</h4>';
            $html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">';
            $html .= '
            <thead>
                <tr>
                    <th>#</th>
                    <th>เรื่องไปอบรม</th>
                    <th>วันที่เริ่มอบรม</th>
                    <th>ประเภทการไปอบรม</th>
                    <th>สถานที่</th>
                    <th>จำนวนชั่วโมง</th>
                </tr>
            </thead>
            <tbody>';

            // ข้อมูลการอบรม
            $index = 1;
            foreach (json_decode($person->devps_data_array) as $dev) {
                $html .= '
                <tr>
                    <td>' . $index++ . '</td>
                    <td>' . $dev->dev_name . '</td>
                    <td>' . fullDateTH3($dev->dev_start_date) . ' ถึง ' . fullDateTH3($dev->dev_end_date) . '</td>
                    <td>' . $dev->devb_name . '</td>
                    <td>' . $dev->dev_place . '</td>
                    <td style="text-align: right;">' . $dev->dev_hour . '</td>
                </tr>';
            }

            // แสดงผลรวมชั่วโมง
            $html .= '
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">รวมทั้งหมด:</td>
                <td style="text-align: right; font-weight: bold;">' . $person->sum_hour . ' ชั่วโมง</td>
            </tr>';
            $html .= '</tbody></table><br>';
        }

        // เพิ่ม HTML ลงใน PDF
        $mpdf->WriteHTML($html);

        // ส่งออก PDF
        $fileName = 'รายงานการพัฒนาบุคลากร.pdf';
        $mpdf->Output($fileName, \Mpdf\Output\Destination::DOWNLOAD);
    }
    public function export_print_develop_person($filter, $ps_id = null)
    {
        ini_set('memory_limit', '512M'); // เพิ่ม memory limit
        $filterString = [];
        $decodedFilterString = urldecode($filter);
        parse_str($decodedFilterString, $filterString);
        $filterString['ps_id'] = $ps_id;

        // ดึงข้อมูล
        $result = $this->M_hr_develop->get_export_develop_list_by_filter($filterString)->result();

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($result)) {
            show_error('ไม่พบข้อมูล', 404);
            return;
        }

        // โหลด autoload ของ mPDF
        require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

        // สร้างอินสแตนซ์ของ mPDF พร้อมตั้งค่ากระดาษเป็นแนวนอน (landscape)
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L', // กระดาษ A4 แนวนอน
            'default_font_size' => 16,
            'default_font' => 'sarabun', // ฟอนต์ Sarabun สำหรับภาษาไทย
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
        ]);

        // สร้าง HTML สำหรับ PDF
        $html = '<h2 style="text-align: center;">รายงานการพัฒนาบุคลากร</h2>';

        foreach ($result as $person) {
            $html .= '<h4>' . $person->person_name . '</h4>';
            $html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">';
            $html .= '
            <thead>
                <tr>
                    <th>#</th>
                    <th>เรื่องไปอบรม</th>
                    <th>วันที่เริ่มอบรม</th>
                    <th>ประเภทการไปอบรม</th>
                    <th>สถานที่</th>
                    <th>จำนวนชั่วโมง</th>
                </tr>
            </thead>
            <tbody>';

            // ข้อมูลการอบรม
            $index = 1;
            foreach (json_decode($person->devps_data_array) as $dev) {
                $html .= '
                <tr>
                    <td>' . $index++ . '</td>
                    <td>' . $dev->dev_name . '</td>
                    <td>' . fullDateTH3($dev->dev_start_date) . ' ถึง ' . fullDateTH3($dev->dev_end_date) . '</td>
                    <td>' . $dev->devb_name . '</td>
                    <td>' . $dev->dev_place . '</td>
                    <td style="text-align: right;">' . $dev->dev_hour . '</td>
                </tr>';
            }

            // แสดงผลรวมชั่วโมง
            $html .= '
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">รวมทั้งหมด:</td>
                <td style="text-align: right; font-weight: bold;">' . $person->sum_hour . ' ชั่วโมง</td>
            </tr>';
            $html .= '</tbody></table><br>';
        }

        // เพิ่ม HTML ลงใน PDF
        $mpdf->WriteHTML($html);

        $mpdf->Output('รายงานการพัฒนาบุคลากร'. '.pdf', 'I'); // 'I' = แสดงผลในเบราว์เซอร์
		exit;
    }
}
