<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// โหลด autoload ของ Composer

require_once dirname(__FILE__) . "/Personal_dashboard_Controller.php";

class Test extends Personal_dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->controller .= "Home/";
        $this->load->model('ums/Genmod', 'genmod');
    }

    public function index()
    {
      // $this->load->library('PhpSpreadsheetLibrary');
        // สร้าง Spreadsheet ใหม่
       
    }
}
