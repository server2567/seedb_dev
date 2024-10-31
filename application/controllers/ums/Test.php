<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once('UMS_Controller.php');
// require_once(APPPATH . 'third_party/vendor/autoload.php'); // ปรับเส้นทางให้ถูกต้อง
require APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Collection\MemoryFactory;



class Test extends UMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ums/Genmod', 'genmod');
        $this->load->helper('url'); // โหลด helper สำหรับ URLs
    }

    // ฟังก์ชันแสดง view พร้อมปุ่มดาวน์โหลด
    public function index()
    {
        $this->load->view('ums/test_view');
    }
    public function createExcel()
    {

            $filename  = "applicant-result-ผู้ผ่านการคัดเลือก ";

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();


    
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(10);
            $sheet->getColumnDimension('L')->setWidth(10);
            $sheet->getColumnDimension('M')->setWidth(10);
            $sheet->getColumnDimension('N')->setWidth(10);
            $sheet->getColumnDimension('O')->setWidth(10);
            $sheet->getColumnDimension('P')->setWidth(10);
            $sheet->getColumnDimension('Q')->setWidth(30);
            
            $sheet->setCellValue('A1', 'university_id');
            $sheet->setCellValue('B1', 'program_id');
            $sheet->setCellValue('C1', 'major_id');
            $sheet->setCellValue('D1', 'project_id');
            $sheet->setCellValue('E1', 'type');
            $sheet->setCellValue('F1', 'citizen_id');
            $sheet->setCellValue('G1', 'title');
            $sheet->setCellValue('H1', 'first_name_th');
            $sheet->setCellValue('I1', 'last_name_th');
            $sheet->setCellValue('J1', 'first_name_en');
            $sheet->setCellValue('K1', 'last_name_en');
            $sheet->setCellValue('L1', 'priority');
            $sheet->setCellValue('M1', 'ranking');
            $sheet->setCellValue('N1', 'score');
            $sheet->setCellValue('O1', 'tcas_status');
            $sheet->setCellValue('P1', 'applicant_status');
            $sheet->setCellValue('Q1', 'interview_reason');
            $sheet->setCellValue('R1', 'สถานศึกษา');
            $sheet->setCellValue('S1', 'หลักสูตร');
            $sheet->setCellValue('T1', 'โครงการ');


            $sheet->setCellValue('A' . 1, 999);
            $sheet->setCellValue('B' . 1, 0);
            $sheet->setCellValue('C' . 1, 0);
            $sheet->setCellValue('D' . 1, 0);
            $sheet->setCellValue('E' . 1, 'test');
            $sheet->setCellValue('F' . 1, 'test');
            $sheet->setCellValue('G' . 1, 'test');
            $sheet->setCellValue('H' . 1, 'test');
            $sheet->setCellValue('I' . 1, 'test');
            $sheet->setCellValue('J' . 1, 'test');
            $sheet->setCellValue('K' . 1, 'test');
            $sheet->setCellValue('L' . 1, 'test');
            $sheet->setCellValue('M' . 1, 'test');
            $sheet->setCellValue('N' . 1, 0);
            $sheet->setCellValue('O' . 1, 'test');
            $sheet->setCellValue('P' . 1, 2);
            $sheet->setCellValue('Q' . 1, 0);

            $sheet->setCellValue('R' . 1, 'test');
            $sheet->setCellValue('S' . 1, 'test');
            $sheet->setCellValue('T' . 1, 'test');
        
            $writer = new Xlsx($spreadsheet);
            ob_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            //  echo sys_get_temp_dir();
            //  die;
            $writer->save('php://output'); // download file 
            // $writer->save('/tmp/'.$filename);
    }
    // ฟังก์ชันสำหรับดาวน์โหลดไฟล์ Excel
    public function download_excel($fileName = 'ทดสอบ.xlsx')
    {
        // ตรวจสอบรูปแบบชื่อไฟล์เพื่อป้องกันการโจมตี directory traversal
        if (!preg_match('/^[a-zA-Z0-9_\-ก-ฮ]+\.xlsx$/u', $fileName)) {
            show_404(); // ชื่อไฟล์ไม่ถูกต้อง
            return;
        }

        $directory = '/var/www/uploads/';
        $filePath = $directory . $fileName;

        // ตรวจสอบสิทธิ์การเข้าถึงไดเรกทอรี
        if (!is_writable($directory)) {
            log_message('error', 'Directory is not writable: ' . $directory);
            show_error('Directory is not writable.');
            return;
        }

        // สร้าง Spreadsheet และบันทึกไฟล์ถ้ายังไม่มีอยู่
        if (!file_exists($filePath)) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Hello World !'); // กำหนดค่าใน cell A1
            $sheet->setCellValue('B1', 'ทดสอบข้อความภาษาไทย !'); // กำหนดค่าใน cell B1
            $writer = new Xlsx($spreadsheet);

            try {
                // บันทึกไฟล์ในไดเรกทอรีชั่วคราวก่อน
                $tempFilePath = '/tmp/test_output.xlsx';
                $writer->save($tempFilePath);
                log_message('debug', 'Temporary file created successfully: ' . $tempFilePath);

                // ตรวจสอบว่าไฟล์ถูกสร้างขึ้นในไดเรกทอรีชั่วคราว
                if (file_exists($tempFilePath)) {
                    $fileSize = filesize($tempFilePath);
                    log_message('debug', 'Temporary file exists with size: ' . $fileSize . ' bytes');

                    if ($fileSize > 0) {
                        // ย้ายไฟล์จากไดเรกทอรีชั่วคราวไปยังไดเรกทอรีปลายทาง
                        if (rename($tempFilePath, $filePath)) {
                            log_message('debug', 'File moved successfully to: ' . $filePath);
                        } else {
                            log_message('error', 'Failed to move file from ' . $tempFilePath . ' to ' . $filePath);
                            show_error('Failed to move file to destination.');
                            return;
                        }
                    } else {
                        log_message('error', 'File was created but has 0 bytes in /tmp directory.');
                        show_error('File was created but has a size of 0 bytes.');
                        return;
                    }
                } else {
                    log_message('error', 'Temporary file not found at: ' . $tempFilePath);
                    show_error('Temporary file not found after save attempt.');
                    return;
                }
            } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
                log_message('error', 'Spreadsheet Writer error: ' . $e->getMessage());
                show_error('Spreadsheet Writer error: ' . $e->getMessage());
                return;
            } catch (\Exception $e) {
                log_message('error', 'General error: ' . $e->getMessage());
                show_error('General error: ' . $e->getMessage());
                return;
            }
        } else {
            log_message('debug', 'File already exists: ' . $filePath);
        }

        // ตรวจสอบขนาดไฟล์หลังจากบันทึก
        clearstatcache(); // ล้าง cache เพื่อให้ได้ขนาดไฟล์ล่าสุด
        if (filesize($filePath) === 0) {
            log_message('error', 'File size is 0 bytes: ' . $filePath);
            show_error('File was created but has a size of 0 bytes.');
            return;
        }

        // ตรวจสอบว่าไฟล์มีอยู่และดาวน์โหลดไฟล์
        if (file_exists($filePath)) {
            // ล้าง output buffer เพื่อให้แน่ใจว่าไม่มีข้อมูลอื่นใน buffer
            if (ob_get_contents()) ob_end_clean();
            flush();

            // ตั้งค่า headers สำหรับดาวน์โหลดไฟล์
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
            header('Content-Length: ' . filesize($filePath));

            // อ่านไฟล์และส่งออกไปที่เบราว์เซอร์
            readfile($filePath);
            exit;
        } else {
            log_message('error', 'File not found: ' . $filePath);
            show_404(); // ถ้าไฟล์ไม่พบ ให้แสดง 404 error
        }
    }
}
