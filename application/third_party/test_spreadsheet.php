<?php
// เปิดการรายงานข้อผิดพลาดเพื่อดูข้อผิดพลาดทั้งหมด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// โหลด autoload ของ Composer
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('B1', 'ทดสอบข้อความภาษาไทย !');

$directory = '/var/www/uploads/';
$filePath = $directory . 'test_output.xlsx';

try {
    // ตรวจสอบว่าไดเรกทอรีมีสิทธิ์การเขียน
    if (!is_writable($directory)) {
        die('Directory is not writable: ' . $directory);
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);
    echo 'File saved successfully at: ' . $filePath;

    // ตรวจสอบขนาดไฟล์หลังจากบันทึก
    clearstatcache(); // ล้าง cache เพื่อให้ได้ขนาดไฟล์ล่าสุด
    if (filesize($filePath) === 0) {
        die('File was created but has a size of 0 bytes: ' . $filePath);
    } else {
        echo ' - File size: ' . filesize($filePath) . ' bytes';
    }

} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    echo 'Error saving file: ' . $e->getMessage();
} catch (\Exception $e) {
    echo 'General error: ' . $e->getMessage();
}

