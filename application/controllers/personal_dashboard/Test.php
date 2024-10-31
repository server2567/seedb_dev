<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


require_once __DIR__ . '/../../../vendor/autoload.php'; // Adjusted the path correctly

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Test extends UMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ums/Genmod', 'genmod');
        $this->load->helper('download'); // Load helper for downloading
    }

    public function index()
    {
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header values
        $sheet->setCellValue('A1', 'Header Column 1');
        $sheet->setCellValue('B1', 'Header Column 2');
        $sheet->setCellValue('A2', 'Second Row Value 1');
        $sheet->setCellValue('B2', 'Second Row Value 2');

        // Set the filename for download
        $fileName = 'HelloWorld.xlsx';

        // Clear the output buffer
        ob_end_clean();

        // Set headers for the download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Create the writer and output the file to the browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output'); // This sends the file to the browser directly

     
    }
}
