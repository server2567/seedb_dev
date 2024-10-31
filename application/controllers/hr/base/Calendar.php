<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class calendar extends Base_Controller
{
    // Create __construct for load model use in this controller
    public function __construct()
    {
        parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/calendar";
    }
    /*
	* index
	* สำหรับการเรียกหน้า view รายการข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function index()
    {
        $this->load->model($this->model . "m_hr_calendar");
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $data['clnd_year'] = $this->m_hr_calendar->get_filter_year()->result();
        $this->output('hr/base/v_base_holiday_show', $data);
    }
    /*
	* get_calendar_add
	* สำหรับการเรียกหน้า view สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function get_calendar_add()
    {
        $this->load->model($this->model . "m_hr_calendar");
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $data['controller']  = $this->controller;
        $data['lct_info'] = $this->m_hr_calendar->get_calendar_type()->result();
        $this->output('hr/base/v_base_holiday_form', $data);
    }
    /*
	* get_calendar_edit
	* สำหรับการเรียกหน้า view สำหรับการแก้ไขข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function get_calendar_edit($ClID = null)
    {
        $this->load->model($this->model . "m_hr_calendar");
        $this->m_hr_calendar->clnd_id = $ClID;
        $data['controller']  = $this->controller;
        $clnd_info = $this->m_hr_calendar->get_by_key()->result();
        $data['lct_info'] = $this->m_hr_calendar->get_calendar_type()->result();
        if ($clnd_info != null) {
            foreach ($clnd_info as $item) {
                $data['clnd_info'] = $item;
            }
        }
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');;
        $this->output('hr/base/v_base_holiday_form', $data);
    }
    /*
	* calendar_insert
	* สำหรับการเพิ่มข้อมูล*
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function calendar_insert()
    {
        $this->load->model($this->model . "m_hr_calendar");
        $this->m_hr_calendar->clnd_name =  $this->input->post('clnd_name');
        $this->m_hr_calendar->clnd_type_date =  $this->input->post('clnd_type_date');
        $this->m_hr_calendar->clnd_start_date =  splitDateForm1($this->input->post('clnd_start_date'));
        $this->m_hr_calendar->clnd_end_date =  splitDateForm1($this->input->post('clnd_end_date'));
        $this->m_hr_calendar->clnd_diff_date =  (floor((strtotime($this->input->post('clnd_end_date')) - strtotime($this->input->post('clnd_start_date'))) / (60 * 60 * 24)))+1;
        $this->m_hr_calendar->clnd_year =   date('Y', strtotime($this->input->post('clnd_start_date'))) - 543;
        $this->m_hr_calendar->clnd_active = "1";
        $this->m_hr_calendar->clnd_create_user = $this->session->userdata('us_id');
		$this->m_hr_calendar->clnd_update_user = $this->session->userdata('us_id');
        $this->m_hr_calendar->insert();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/calendar';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    /*
	* delete_calendar
	* สำหรับการลบข้อมูลตาม id (เปลี่ยนแปลง active ให้เป็น 2 ซึ่งข้อมูลจะไม่แสดงในระบบ) *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function delete_calendar($ClID = null)
    {
        $this->load->model($this->model . "m_hr_calendar");
        $this->m_hr_calendar->clnd_id = $ClID;
        $this->m_hr_calendar->clnd_active = '2';
        $this->m_hr_calendar->disabled();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/calendar';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    /*
	* calendar_update
	* สำหรับการ อัพเดท หรือเปลี่ยนแปลงค่าข้อมูล *
	* $input -
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function calendar_update()
    {
        $this->load->model($this->model . "m_hr_calendar");
        $this->m_hr_calendar->clnd_name =  $this->input->post('clnd_name');
        $this->m_hr_calendar->clnd_type_date =  $this->input->post('clnd_type_date');
        $this->m_hr_calendar->clnd_start_date =  splitDateForm1($this->input->post('clnd_start_date'));
        $this->m_hr_calendar->clnd_end_date =  splitDateForm1($this->input->post('clnd_end_date'));
        $this->m_hr_calendar->clnd_diff_date =  (floor((strtotime($this->input->post('clnd_end_date')) - strtotime($this->input->post('clnd_start_date'))) / (60 * 60 * 24)))+1;
        $this->m_hr_calendar->clnd_year =   date('Y', strtotime($this->input->post('clnd_start_date'))) - 543;
        $this->m_hr_calendar->clnd_active = $this->input->post('clnd_active');
        $this->m_hr_calendar->clnd_id = $this->input->post('clnd_id');
        $this->m_hr_calendar->update();
        $data['returnUrl'] = base_url() . 'index.php/hr/base/calendar';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
    }
    /*
	* checkValue
	* นำเข้าข้อมูลใหม่มาตรวจสอบข้อมูลในฐานข้อมูลว่าซ้ำกันหรือไม่ ก่อนการบันทึก*
	* $input ตัวแปลที่ต้องการเช็ค
	* $output ผลลัพธ์ของการตรวจสอบ
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    public function checkValue()
	{
		$this->load->model($this->model . "m_hr_calendar");
		$formdata = $this->input->post();
        foreach($formdata as $key =>$value){
			$this->m_hr_calendar->$key = $value;
		}
		$query = $this->m_hr_calendar->finding()->result();
		if (count($query) > 0) {
			$data['status_response'] = '1';
		} else {
			$data['status_response'] = '0';
		}
		echo json_encode($data);
	}
    /*
	* formatDateToThaiShort
	* สำหรับการแปลงFormat วันเดือนปี*
	* $input ใส่ข้อมูลวันที่ในรูปแบบ YYYY-MM-DD
	* $output ผลลัพธ์ของการตรวจสอบ
	* @author Jiradat Pomyai
	* @Create Date 30/05/2024
	*/
    function formatDateToThaiShort($dateString)
    {
        // กำหนดชื่อย่อเดือนเป็นภาษาไทย
        $thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];

        // แปลงวันที่จากรูปแบบ YYYY-MM-DD เป็น timestamp
        $dateParts = explode("-", $dateString);
        $year = intval($dateParts[0]);
        $month = intval($dateParts[1]);
        $day = intval($dateParts[2]);

        // สร้างออบเจ็กต์ DateTime จากค่าปี เดือน วัน
        $date = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");

        // แปลงวันที่เป็นรูปแบบ วัน เดือนย่อ ปีพ.ศ.
        $thaiYear = $date->format('Y') + 543;
        $thaiMonth = $thaiMonths[$date->format('n') - 1];
        $thaiDay = $date->format('j');
        return  "$thaiDay $thaiMonth $thaiYear";
    }
    function getDayOfWeek($dateString) {
        // สร้างออบเจ็กต์ DateTime จากวันที่ที่กำหนด
        $date = new DateTime($dateString);
    
        // หาวันของสัปดาห์ในรูปแบบภาษาไทย
        $daysOfWeek = [
            'Sunday' => 'อาทิตย์',
            'Monday' => 'จันทร์',
            'Tuesday' => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday' => 'พฤหัสบดี',
            'Friday' => 'ศุกร์',
            'Saturday' => 'เสาร์'
        ];
    
        // หาวันของสัปดาห์ในภาษาอังกฤษ
        $dayOfWeek = $date->format('l');
    
        // คืนค่าเป็นชื่อวันภาษาไทย
        return $daysOfWeek[$dayOfWeek];
    }
    public function filter_year()
	{
		$this->load->model($this->model . "m_hr_calendar");
		$result = $this->m_hr_calendar->get_all_by_year($this->input->post('clnd_year'))->result();
        foreach($result as $value){
            if($value->clnd_diff_date > 1){
               $value->date = $this->formatDateToThaiShort($value->clnd_start_date).' - '.$this->formatDateToThaiShort($value->clnd_end_date);
            }else{
              $value->date = $this->formatDateToThaiShort($value->clnd_start_date);
            }
            $value->dayofweek = $this->getDayOfWeek($value->clnd_start_date);
          }
		echo json_encode($result);
	}
}
