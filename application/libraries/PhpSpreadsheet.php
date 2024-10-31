<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class PhpSpreadsheet
{
    public function createSpreadsheet($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // เพิ่มข้อมูลในเซลล์
        $sheet->setCellValue('A1', 'Hello World!');

        // สามารถเพิ่มข้อมูลเพิ่มเติมได้ตามต้องการ
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . ($key + 2), $value);
        }

        // บันทึกไฟล์
        $writer = new Xlsx($spreadsheet);
        $fileName = 'hello_world.xlsx';
        $writer->save($fileName);

        return $fileName;
    }
}
