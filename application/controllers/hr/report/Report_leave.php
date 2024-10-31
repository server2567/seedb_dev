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
        $this->output('hr/report/v_report_overview_leave.php', $data);
    }
    public function get_overview_leave_summary()
    {
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
        $sql ='
        SELECT lsum.*,leave.leave_name,CONCAT(pf.pf_name," ",ps.ps_fname," ",ps.ps_lname) as ps_name FROM see_hrdb.hr_leave_summary as lsum 
        LEFT JOIN see_hrdb.hr_leave as leave on leave.leave_id = lsum.lsum_leave_id
        LEFT JOIN see_hrdb.hr_person as ps on ps.ps_id = lsum.lsum_ps_id
        LEFT JOIN see_hrdb.hr_base_prefix as pf on pf.pf_id = ps.ps_pf_id ';
    }
}
