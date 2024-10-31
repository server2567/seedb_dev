<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_UMS_Controller.php");
class Ums_dashboard extends SEEDB_UMS_Controller
{
	protected $depId = 1; //ums_department Default
	protected $startDate 	= "";//วัน-เดือน-ปี ที่เริ่ม
	protected $endDate 	= "";//วัน-เดือน-ปี สิ้นสุด
	protected $year 	= "";//ปฏิทิน

	public function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person', "hrp");
		$this->load->model($this->model . 'Ums_dashboard_model', "dbums");

	}

	function convertThaiDateToGregorian($thaiDate){
		if ($thaiDate == "") return "";
		$thaiMonths = [
			'มกราคม' => '01', 'กุมภาพันธ์' => '02', 'มีนาคม' => '03', 'เมษายน' => '04',
			'พฤษภาคม' => '05', 'มิถุนายน' => '06', 'กรกฎาคม' => '07', 'สิงหาคม' => '08',
			'กันยายน' => '09', 'ตุลาคม' => '10', 'พฤศจิกายน' => '11', 'ธันวาคม' => '12'
		];

		$dateParts = explode(' ', $thaiDate);
    
		if (count($dateParts) === 3) {
			$day = $dateParts[0];
			$month = $dateParts[1];
			$year = $dateParts[2];
			
			if (isset($thaiMonths[$month])) {
				$monthNumber = $thaiMonths[$month];
				
				$yearNumber = $year - 543;
				
				$gregorianDate = sprintf('%04d-%02d-%02d', $yearNumber, $monthNumber, $day);
				return $gregorianDate;
			}
		}
		
		return $thaiDate;

	}

	function formatPhoneNumber($number) {
		if ($number == "" || $number == NULL) return $number;
		$number = preg_replace('/\D/', '', $number);

		if (strlen($number) === 10) {
			return preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1-$2-$3', $number);
		}

		return $number;
	}

	function formatIdCard($number){
		if ($number == "" || $number == NULL) return $number;
		$number = preg_replace('/\D/', '', $number);

		if (strlen($number) === 13) {
			return preg_replace('/(\d{1})(\d{3})(\d{5})(\d{2})(\d{1})/', '$1-$2-$3-$4-$5', $number);
		}

		return $number;
	}


	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['ums_department_list'] = $this->hrp->get_ums_department_data()->result();


		$currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543;
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;

		$data['tabs'] = [
			'all' 	=> 'ทั้งหมด',
			'M' 	=> 'สายการแพทย์',
			'N' 	=> 'สายการพยาบาล',
			'SM' 	=> 'สายสนับสนุนทางการแพทย์',
			'T' 	=> 'สายเทคนิคและบริการ',
			'A' 	=> 'สายบริหาร'
		];

		$system = $this->dbums->getUmsSystemDetail()->result_array();

		$arrSys = array();
		$arrSys['all'] = 'ทั้งหมด';
		foreach($system as $row){
			$arrSys[$row['st_id']] = $row['st_name_abbr_en'];
		}
		$data['system'] = $arrSys;

		$this->output($this->view . 'v_seedb_ums', $data);
	} 


	function getUmsCountData(){
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate = $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   = $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   = $this->input->post('year') ?? "";


		$data['countPatient'] 	= number_format($this->dbums->countPatientRegistered($this->startDate, $this->endDate, $this->year)->row()->count ?? 0 );
		$data['countUser'] 		= number_format($this->dbums->countUserAdmin($this->depId, $this->startDate, $this->endDate, $this->year)->row()->count ?? 0);
		$data['countNews'] 		= number_format($this->dbums->countNews($this->startDate, $this->endDate, $this->year)->row()->count ?? 0);
		$data['countSystem'] 	= number_format($this->dbums->countSystem()->row()->count ?? 0);
		
		echo json_encode($data);
	}

	function getUmsPatientDetail(){

		$request = $this->input->post();
		
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";
		$selectedLetters   	 =  json_decode($this->input->post('selectedLetters'), true) ?? [];

		$privacyType = "";
		$temp = $this->input->post('privacyType');
		if (isset($temp)) {
			$privacyType = $temp;
		}


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " CONVERT(pt_fname USING tis620) ASC ,";
			$orderDirection = " CONVERT(pt_lname USING tis620) ASC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " CONVERT(pt_fname USING tis620) ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];

			}
		}

		
		$totalRecords = $this->dbums->getTotalPatientRecords($selectedLetters,  $privacyType , $this->startDate, $this->endDate, $this->year );
		$patients = $this->dbums->getUmsPatientDetail( $searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters, $privacyType , $this->startDate, $this->endDate, $this->year );
		
		foreach($patients->result() as $row){
			$row->pt_tel_format = $this->formatPhoneNumber($row->pt_tel);
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, // Change this if you apply any filtering
			"data" => $patients->result_array()
		);

		echo json_encode($response);


	}

	function getUmsUsersDetail(){
		$request = $this->input->post();
		
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";
		$hireIsMedical  	 =  $this->input->post('hireIsMedical') ?? "";
		$selectedLetters   	 =  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " CONVERT(ps_fname USING tis620) ASC ,";
			$orderDirection = " CONVERT(ps_lname USING tis620) ASC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " CONVERT(ps_fname USING tis620) ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];

			}
		}


		$totalRecords = $this->dbums->getTotalUmsUserRecords($selectedLetters,  $hireIsMedical  ,$this->depId , $this->startDate, $this->endDate, $this->year );
		$umsUsers = $this->dbums->getUmsUsersDetail( $searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters, $hireIsMedical  ,$this->depId , $this->startDate, $this->endDate, $this->year );

		foreach($umsUsers->result() as $row){
			$row->psd_id_card_no_format = $this->formatIdCard($row->psd_id_card_no);
			$row->token = encrypt_id($row->ps_id);
			$row->count_system =  $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->num_rows();
			$row->count_login  =  $this->dbums->getCountLoginSystemhereIn($row->multiple_us_id, $this->startDate, $this->endDate, $this->year)->num_rows();
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, // Change this if you apply any filtering
			"data" => $umsUsers->result_array()
		);

		echo json_encode($response);
	}



	function getUmsNewsDetail() {
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";


		$data = $this->dbums->getUmsNewsDetail($this->startDate, $this->endDate, $this->year)->result();

		echo json_encode($data);
	}

	function getUmsSystemDetail() {

		$data = $this->dbums->getUmsSystemDetail()->result();
		echo json_encode($data);
	}

	function getRegistrationSummary() {

		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";

		$data['countPatient'] 	= number_format($this->dbums->countPatientRegistered($this->startDate, $this->endDate, $this->year)->row()->count ?? 0 );
		$data['consent'] 		= number_format($this->dbums->getRegistrationSummary('Y' , $this->startDate, $this->endDate, $this->year)->num_rows() );
		$data['notConsent'] 	= number_format($this->dbums->getRegistrationSummary( 'N' , $this->startDate, $this->endDate, $this->year)->num_rows() );
		echo json_encode($data);


	}

	function getStaffResponsibleSystemSummary() {
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";

		$system = $this->dbums->getUmsSystemDetail()->result_array();
		$arrSys = array();
		$arrSysId = array();
		foreach($system as $row){
			array_push($arrSys, $row['st_name_abbr_en']);
			array_push($arrSysId, $row['st_id']);
		}
		$data['system'] = $arrSys;


		$line = [
			'M' 	=> 'สายการแพทย์',
			'N' 	=> 'สายการพยาบาล',
			'SM' 	=> 'สายสนับสนุนทางการแพทย์',
			'T' 	=> 'สายเทคนิคและบริการ',
			'A' 	=> 'สายบริหาร'
		];


		$lineIndexed = array_values($line);
		$data['line'] = $lineIndexed;

		$colors = [
			'M'  => '#FF5733', // สีสำหรับสายการแพทย์
			'N'  => '#33FF57', // สีสำหรับสายการพยาบาล
			'SM' => '#3357FF', // สีสำหรับสายสนับสนุนทางการแพทย์
			'T'  => '#4e0484', // สีสำหรับสายเทคนิคและบริการ
			'A'  => '#FFC300'  // สีสำหรับสายบริหาร
		];

		$data['series'] = array();

		foreach($line as $key => $row) {

			$numUsersOfSys = [];

			foreach ($arrSysId as $index => $sys) {
				$numUsersOfSys[$index] = intval( $this->dbums->getCountUsersInSystemByType($key, $sys, $this->depId )->row()->count );

			}
			$dataArr = array(
				'name'  => $row,
				'data'  => $numUsersOfSys,
				'color' => $colors[$key]
			);

			array_push($data['series'], $dataArr );
		}

		echo json_encode($data);
	}

	function getStaffOfSystem(){ 

		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";
		$sysId  	 	 =  $this->input->post('stId') ?? "";
		$selectedLetters =  json_decode($this->input->post('selectedLetters'), true) ?? [];
		
		$data['staff'] = $this->dbums->getStaffOfSystem($this->depId,  "", "", "", $sysId , $selectedLetters )->result();
		foreach($data['staff'] as $row){
			$row->psd_id_card_no_format = $this->formatIdCard($row->psd_id_card_no);
			$row->mySystem 				= $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->result();
			$row->token 				= encrypt_id($row->ps_id);
			$row->count_system =  $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->num_rows();
			$row->count_login  =  $this->dbums->getCountLoginSystemhereIn($row->multiple_us_id, $this->startDate, $this->endDate, $this->year)->num_rows();
		}
		echo json_encode($data);

	}

	function getStaffOfLine() {

		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";
		$hireIsMedical  	 =  $this->input->post('hireType') ?? "";
		$selectedLetters   	 =  json_decode($this->input->post('selectedLetters'), true) ?? [];

		
		$data['staff'] = $this->dbums->getUsersOfSystemByLine($this->depId,  $hireIsMedical , $selectedLetters )->result();
		foreach($data['staff'] as $row){
			$row->psd_id_card_no_format = $this->formatIdCard($row->psd_id_card_no);
			$row->mySystem 				= $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->result();
			$row->token 				= encrypt_id($row->ps_id);
			$row->count_system =  $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->num_rows();
			$row->count_login  =  $this->dbums->getCountLoginSystemhereIn($row->multiple_us_id, $this->startDate, $this->endDate, $this->year)->num_rows();
		}
		echo json_encode($data);
		
	}


	function getUserActivitySystemTimeline() {
		$this->depId 	 =  $this->input->post('department')?? 1;
		$this->startDate =  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   =  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 =  $this->input->post('year') ?? "";


		$currentYear = date('Y');
		$data['datePeriod'] = [];
	
		$sqlMonth = []; // ตัวแปรเก็บหมายเลขเดือน
		$sqlDate = []; // ตัวแปรเก็บข้อมูลวันที่ในรูปแบบ Y-m-d
		$sqlYear = NULL; // ตัวแปรเก็บข้อมูลวันที่ในรูปแบบ Y-m-d

		if ((intval($this->year) == intval($currentYear)) && ($this->year != "") ) { //ปีที่เลือกเท่ากับปีปัจจุบัน
			for ($i = 0; $i < 14; $i++) {
				$date = date('Y-m-d', strtotime("-$i days"));
				$sqlDate[] = $date; // เก็บในรูปแบบ Y-m-d

				$yearBuddhist = date('Y', strtotime($date)) + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
				$dateBuddhist = date("d-m-", strtotime($date)) . $yearBuddhist; // ใช้ d-m- เพื่อคงรูปแบบวันที่และเดือน
				$data['datePeriod'][] = $dateBuddhist;
			}
			sort($data['datePeriod']);

			$sqlYear = $this->year;
			
		} else if ((intval($this->year) < intval($currentYear)) && ($this->year != "") ) { // ปีที่เลือกน้อยกว่าปีปัจจุบัน

			$tempYear = $this->year + 543; 
			$thaiMonths = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

			foreach ($thaiMonths as $month) {
				$data['datePeriod'][] = $month . ' ' . $tempYear;
			}

			$thaiMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // หมายเลขเดือน
			foreach ($thaiMonths as $month) {
				$sqlMonth[] = $month; // เก็บหมายเลขเดือน
			}

			$sqlYear = $this->year;


		}else { //ไม่เลือกปี
			
			//ถ้าวันที่เริ่ม วันที่สิ้นสุดว่าง
			if ($this->startDate == "" && $this->endDate == "") { 
				$endDate = date('Y-m-d');
				$startDate = date('Y-m-d', strtotime('-13 days'));
				
				$currentDate = $startDate;
				while (strtotime($currentDate) <= strtotime($endDate)) {
					$sqlDate[] = $currentDate; // เก็บในรูปแบบ Y-m-d
					$yearBuddhist = date('Y', strtotime($currentDate)) + 543;
					$dateBuddhist = date("d-m-", strtotime($currentDate)) . $yearBuddhist; 
					$data['datePeriod'][] = $dateBuddhist;
					
					$currentDate = date('Y-m-d', strtotime("$currentDate +1 day"));
				}
				sort($data['datePeriod']);

			} else if ($this->startDate != "" && $this->endDate == "") { //ถ้าวันที่เริ่มไม่ว่าง วันที่สิ้นสุดว่าง

				$startDate = $this->startDate;
				$endDate = date('Y-m-d'); 

				$currentDate = $startDate;
				while (strtotime($currentDate) <= strtotime($endDate)) {
					$sqlDate[] = $currentDate; // เก็บในรูปแบบ Y-m-d
					$yearBuddhist = date('Y', strtotime($currentDate)) + 543; 
					$dateBuddhist = date("d-m-", strtotime($currentDate)) . $yearBuddhist; 
					$data['datePeriod'][] = $dateBuddhist;
					
					$currentDate = date('Y-m-d', strtotime("$currentDate +1 day"));
				}
				sort($data['datePeriod']);

			} else if ($this->startDate == "" && $this->endDate != "") { // ถ้าวันที่เริ่มว่าง วันที่สิ้นสุดไม่ว่าง

				$endDate = $this->endDate;
				$startDate = date('Y-m-d', strtotime('-13 days', strtotime($endDate))); // 

				$currentDate = $startDate;
				while (strtotime($currentDate) <= strtotime($endDate)) {
					$sqlDate[] = $currentDate; // เก็บในรูปแบบ Y-m-d
					$yearBuddhist = date('Y', strtotime($currentDate)) + 543; // 
					$dateBuddhist = date("d-m-", strtotime($currentDate)) . $yearBuddhist; //
					$data['datePeriod'][] = $dateBuddhist;
					
					$currentDate = date('Y-m-d', strtotime("$currentDate +1 day"));
				}
				sort($data['datePeriod']);
				
			} else if ($this->startDate != "" && $this->endDate != "") { //
				$startDate = $this->startDate;
				$endDate = $this->endDate;

				$currentDate = $startDate;
				while (strtotime($currentDate) <= strtotime($endDate)) {
					$sqlDate[] = $currentDate; // เก็บในรูปแบบ Y-m-d
					$yearBuddhist = date('Y', strtotime($currentDate)) + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
					$dateBuddhist = date("d-m-", strtotime($currentDate)) . $yearBuddhist; // ใช้ d-m- เพื่อคงรูปแบบวันที่และเดือน
					$data['datePeriod'][] = $dateBuddhist;
					
					$currentDate = date('Y-m-d', strtotime("$currentDate +1 day"));
				}
				sort($data['datePeriod']);
			}
			
		}


		$colors = [
			'#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
			'#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf',
			'#ff9999', '#66b3ff', '#99ff99', '#ffcc99', '#c2c2f0',
			'#ffb3e6', '#c2f0c2', '#ffb366', '#c2c2c2', '#ff6666',
			'#c2f0ff', '#ff99cc', '#99c2ff', '#ff6666', '#ffcc66',
			'#c2c2ff', '#ffb366', '#66ff99', '#b3b3b3', '#99ffcc',
			'#ffccff', '#c2ff99', '#ff6666', '#b3b3ff', '#c2ffcc',
			'#ffb3cc', '#99ccff', '#cc99ff', '#ff99cc', '#ff99ff',
			'#c2ccff', '#ccffcc', '#ff6666', '#66ccff'
		];

		$dashStyles = [
			'Solid',       // เส้นแบบเต็ม
			'ShortDash',   // เส้นขีดสั้น
			'ShortDot',    // เส้นจุดสั้น
			'ShortDashDot',// เส้นขีดสั้นจุด
			'ShortDashDotDot', // เส้นขีดสั้นจุดจุด
			'Dot',         // เส้นจุด
			'Dash',        // เส้นขีด
			'DashDot',     // เส้นขีดจุด
			'LongDash',    // เส้นขีดยาว
			'LongDashDot', // เส้นขีดยาวจุด
			'LongDashDotDot' // เส้นขีดยาวจุดจุด
		];



		$data['sMonth'] = $sqlMonth;
		$data['sDate'] = $sqlDate;
		$data['sYear'] = $sqlYear;
		sort($data['sDate']);

		$data['series'] = array();
		$system = $this->dbums->getUmsSystemDetail()->result();
		$index = 0;
		$index2 = 0;
		foreach($system as  $row){
			
			if (!isset($dashStyles[$index])) {
				$index = 0; 
			}
			if (!isset($colors[$index2])) {
				$index2 = 0; 
			}
			
			$tempValue = [];

			if ( !empty($data['sDate'])){
				foreach ( $data['sDate'] as $i => $date) {
					$tempValue[$i] = intval($this->dbums->getCountUsersActiveSystem($this->depId, $row->st_id ,$date, "" , "")->row()->count);
				}

			}else {
				foreach ($data['sMonth'] as $i => $m) {
					$tempValue[$i] = intval($this->dbums->getCountUsersActiveSystem($this->depId, $row->st_id ,"", $m , $sqlYear)->row()->count);
				}
			}

			if (count(array_filter($tempValue, fn($value) => $value != "0")) > 0) {

				$dataArr = array(
					'name'  => $row->st_name_abbr_en,
					'data'  => $tempValue,
					'dashStyle' => $dashStyles[$index],
					'color' => $colors[$index2]
				);
		
				array_push($data['series'], $dataArr );
	
				$index ++;
				$index2 ++;
			}

		
		}

		echo json_encode($data);
		
	}

	function getUsersActivitySystemHistory() {
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$stId  	 			=  $this->input->post('stId') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];

		$sDate     = json_decode($this->input->post('sDate') , true);
		$sMonth    = json_decode($this->input->post('sMonth') , true);
		$sYear     = $this->input->post('sYear');

		$this->year  = $sYear ?? "";
		$this->startDate = reset($sDate) ?? "";  
		$this->endDate = end($sDate) ?? "";   

		$startMonth = reset($sMonth) ?? "";
		$endMonth   = end($sMonth) ?? "";
 
		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " ml_date DESC, CONVERT(ps_fname USING tis620) ASC ,";
			$orderDirection = " CONVERT(ps_lname USING tis620) ASC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = "ml_date DESC ,  CONVERT(ps_fname USING tis620) ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}




		$totalRecords = $this->dbums->getTotalUsersActiveSystemRecords($selectedLetters , $stId , $this->depId , $this->startDate , $this->endDate , $this->year, $sDate , $startMonth, $endMonth );
		$userActiveSystem = $this->dbums->getUsersActiveSystemRecords( $searchValue, $orderColumn, $orderDirection, $start, $length, $selectedLetters, $stId  ,$this->depId , $this->startDate, $this->endDate, $this->year, $sDate , $startMonth, $endMonth );
		foreach($userActiveSystem->result() as $row){
			$row->psd_id_card_no_format = $this->formatIdCard($row->psd_id_card_no);
			$row->token = encrypt_id($row->ps_id);
			$row->multiple_us_id = $this->dbums->getMultipleUsId($row->ps_id)->row()->multiple_us_id;
			$row->count_system =  $this->dbums->getResponsibleSystemWhereIn($row->multiple_us_id)->num_rows();
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, 
			"data" =>  $userActiveSystem->result_array()
		);

		echo json_encode($response);
	}

}
