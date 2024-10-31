<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_WTS_Controller.php");
class Wts_dashboard extends SEEDB_WTS_Controller
{
	protected $depId = 1; //ums_department Default
	protected $startDate 	= ""; //วัน-เดือน-ปี ที่เริ่ม
	protected $endDate 	= ""; //วัน-เดือน-ปี สิ้นสุด
	protected $year 	= "";//ปฏิทิน
	public function __construct()
	{ 
		parent::__construct();
		// load model
		$this->load->model($this->config->item('hr_dir') . 'M_hr_person', 'hrp');
		$this->load->model($this->model . 'Wts_dashboard_model','dbwts');
	}


	function convertThaiDateToGregorian($thaiDate)
	{
		if ($thaiDate == "") return "";
		$thaiMonths = [
			'มกราคม' => '01',
			'กุมภาพันธ์' => '02',
			'มีนาคม' => '03',
			'เมษายน' => '04',
			'พฤษภาคม' => '05',
			'มิถุนายน' => '06',
			'กรกฎาคม' => '07',
			'สิงหาคม' => '08',
			'กันยายน' => '09',
			'ตุลาคม' => '10',
			'พฤศจิกายน' => '11',
			'ธันวาคม' => '12'
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

	function formatPhoneNumber($number)
	{
		if ($number == "" || $number == NULL) return $number;
		$number = preg_replace('/\D/', '', $number);

		if (strlen($number) === 10) {
			return preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1-$2-$3', $number);
		}

		return $number;
	}

	function formatIdCard($number)
	{
		if ($number == "" || $number == NULL) return $number;
		$number = preg_replace('/\D/', '', $number);

		if (strlen($number) === 13) {
			return preg_replace('/(\d{1})(\d{3})(\d{5})(\d{2})(\d{1})/', '$1-$2-$3-$4-$5', $number);
		}

		return $number;
	}


	function convertDateToThai($date, $fullMonth = true)
	{
		$monthsFull = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
		$monthsShort = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

		$dateObj = new DateTime($date);
		$day = $dateObj->format('j'); 
		$month = (int)$dateObj->format('n') - 1; 
		$year = (int)$dateObj->format('Y') + 543; 

		$monthName = $fullMonth ? $monthsFull[$month] : $monthsShort[$month];

		return "$day $monthName $year";
	}
	
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
		$data['department_list'] = $this->hrp->get_ums_department_data()->result();
		


		$currentYear = date("Y");
		$adjustedYears = [];
		for ($i = 0; $i <= 4; $i++) {
			$adjustedYear = ($currentYear - $i) + 543;
			$adjustedYears[] = $adjustedYear;
		}
		$data['default_year_list'] = $adjustedYears;

		$this->output($this->view . 'v_seedb_wts', $data);
	}

	function getWtsCountData() {

		$this->depId 	 =  $this->input->post('department') ?? 1;
		$this->startDate = $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   = $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   = $this->input->post('year') ?? "";

		if ($this->year != "") {
			if ($this->year == date('Y')){
				$res['DateText'] = "วันที่: " . $this->convertDateToThai(date('Y-m-d'));
			}else {
				$res['DateText'] = "ปี " . ($this->year + 543);
			}
		} else {
			if ($this->startDate != "" && $this->endDate == "") {
				$res['DateText'] = "วันที่: " . $this->convertDateToThai($this->startDate);
			} else if ($this->startDate == "" && $this->endDate != "") {
				$res['DateText'] = "ก่อนวันที่: " . $this->convertDateToThai($this->endDate);
			} else if ($this->startDate != "" && $this->endDate != "") {
				if ($this->startDate == $this->endDate){
					$res['DateText'] = "วันที่: " . $this->convertDateToThai($this->startDate);
				}else {
					$res['DateText'] = "วันที่: " . $this->convertDateToThai($this->startDate, false) . " - " . $this->convertDateToThai($this->endDate, false);

				}
			}
		}

		//QUE-C1
		$CountWaitingTypeOld = intval($this->dbwts->getWaitingPatientsByType('old', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows());
		$CountWaitingTypeNew = intval($this->dbwts->getWaitingPatientsByType('new', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows());
		$res['totalWaiting'] = number_format( $CountWaitingTypeOld + $CountWaitingTypeNew );
		$res['CountWaitingTypeOld']  = number_format($CountWaitingTypeOld);
		$res['CountWaitingTypeNew']  = number_format($CountWaitingTypeNew);
		$data['waiting'] = (object) $res;

		//QUE-C2
		$countBeingServedOld = $this->dbwts->getPatientsBeingServedByType('old', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows();
		$countBeingServedNew = $this->dbwts->getPatientsBeingServedByType('new', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows();
		$res2['totalBeingServed'] = number_format($countBeingServedOld + $countBeingServedNew);
		$res2['countBeingServedOld']  = number_format($countBeingServedOld);
		$res2['countBeingServedNew']  = number_format($countBeingServedNew);
		$data['beingServed'] = (object) $res2;

		//QUE-C3
		$countDoneOld = $this->dbwts->getPatientsDoneByType('old', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows();
		$countDoneNew = $this->dbwts->getPatientsDoneByType('new', $this->depId, $this->startDate, $this->endDate, $this->year)->num_rows();
		$res3['totalDone'] = number_format($countDoneOld + $countDoneNew);
		$res3['countDoneOld']  = number_format($countDoneOld);
		$res3['countDoneNew']  = number_format($countDoneNew);
		$data['done'] = (object) $res3;

		echo json_encode($data);

	}

	function getDepartmentTreatment() { 
		
		$this->depId 	 =  $this->input->post('department') ?? 1;
		$this->startDate = $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   = $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   = $this->input->post('year') ?? "";
		
		$arrStde = array();
		$structureDetail  = $this->dbwts->getStructureDetaulIsMedical($this->depId, $this->startDate, $this->endDate, $this->year)->result();
		// pre($structureDetail );die;
		foreach($structureDetail  as $row) {
				if ($row->stde_abbr){
					array_push($arrStde, $row->stde_abbr);
				}else{
					array_push($arrStde, $row->stde_name_th);
				}
		}

		$data['departments'] = $structureDetail ;
		
		array_push($arrStde, 'แผนกอื่นๆ ');
		$data['categories'] = $arrStde;

		$data['series'] = array();
		$data['type'] = [
			'รอคิว',
			'เข้ารับการรักษา',
			'เสร็จสิ้น'
		];

		$colors = [
			'#29a3db',
			'#c7903e',
			'#40b780'
		];

		foreach($data['type'] as $key => $row) {
			
			$num = [];
			foreach ($structureDetail as $index => $stde){
				
				$count = 0;
				switch ($row) {
					case 'รอคิว':
						$count = intval($this->dbwts->getWaitingPatientsByType('', $this->depId, $this->startDate, $this->endDate, $this->year, $stde->stde_id)->num_rows());
						break;
					case 'เข้ารับการรักษา':
						$count = intval($this->dbwts->getPatientsBeingServedByType('', $this->depId, $this->startDate, $this->endDate, $this->year, $stde->stde_id)->num_rows());
						break;
					case 'เสร็จสิ้น':
						$count = intval($this->dbwts->getPatientsDoneByType('', $this->depId, $this->startDate, $this->endDate, $this->year, $stde->stde_id)->num_rows());
						break;
					default:
						break;
				}
				$num[$index] = $count;
			}

			$count2 = 0;
			switch ($row) {
				case 'รอคิว':
					$count2 = intval($this->dbwts->getWaitingPatientsByType('', $this->depId, $this->startDate, $this->endDate, $this->year, "NULL")->num_rows());
					break;
				case 'เข้ารับการรักษา':
					$count2 = intval($this->dbwts->getPatientsBeingServedByType('', $this->depId, $this->startDate, $this->endDate, $this->year, "NULL")->num_rows());
					break;
				case 'เสร็จสิ้น':
					$count2 = intval($this->dbwts->getPatientsDoneByType('', $this->depId, $this->startDate, $this->endDate, $this->year, "NULL")->num_rows());
					break;
				default:
					break;
			}
			//etc.
			$num[] = $count2;
			
			$dataArr = array(
				'name'  => $row,
				'data'  => $num,
				'color' => $colors[$key]
			);

			array_push($data['series'], $dataArr );
		}

		echo json_enCode($data);
	}


	function getWaitingDetail() {
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " apm_date DESC ,";
			$orderDirection = " apm_time DESC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " apm_date DESC, apm_time DESC ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}


		$totalRecords = $this->dbwts->getTotalWaitingPatientsRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		$result 	  = $this->dbwts->getWaitingPatientsDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		foreach($result->result() as $row){
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}
		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, // Change this if you apply any filtering
			"data" => $result->result_array()
		);

		echo json_encode($response);
	}

	function getBeingServedDetail() {
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " ntdp_date_start DESC, ";
			$orderDirection = " ntdp_time_start DESC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " ntdp_date_start DESC, ntdp_time_start DESC ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}


		$totalRecords = $this->dbwts->getTotalBeingServedRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		$result 	  = $this->dbwts->getBeingServedDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		foreach($result->result() as $row){
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}
		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, 
			"data" => $result->result_array()
		); 

		echo json_encode($response);

	}

	function getProcessIsDoneDetail(){
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];

		if (!isset($request['order'])){
			$orderColumn = " ntdp_date_finish DESC, ";
			$orderDirection = " ntdp_time_finish DESC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " ntdp_date_finish DESC, ntdp_time_finish DESC ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}


		
		$totalRecords = $this->dbwts->getTotalPatientsDoneRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		$result 	  = $this->dbwts->getPatientsDonDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
		foreach($result->result() as $row){
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, 
			"data" => $result->result_array()
		); 

		echo json_encode($response);


	}

	function getDepartmentTreatmentDetail() {
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$depId  	 		=  $this->input->post('depId') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];



		if ($type == 'W') {
			if (!isset($request['order'])){
				$orderColumn = " apm_date DESC ,";
				$orderDirection = " apm_time DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " apm_date DESC, apm_time DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];	
				
				}	
			}

			$totalRecords = $this->dbwts->getTotalWaitingPatientsRecords($selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year, $depId );
			$result 	  = $this->dbwts->getWaitingPatientsDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year,  $depId);
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, // Change this if you apply any filtering
				"data" => $result->result_array()
			);
			echo json_encode($response);

		}else if ($type == 'P') {

			if (!isset($request['order'])){
				$orderColumn = " ntdp_date_start DESC, ";
				$orderDirection = " ntdp_time_start DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " ntdp_date_start DESC, ntdp_time_start DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];
					if ($orderColumn  == 'apm_date'){
						$orderColumn =  'ntdp_date_start';
					}else if ($orderColumn  == 'apm_time'){
						$orderColumn =  'ntdp_time_start';
					}

				
				}
			}


			$totalRecords = $this->dbwts->getTotalBeingServedRecords($selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year, $depId  );
			$result 	  = $this->dbwts->getBeingServedDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year, $depId  );
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, 
				"data" => $result->result_array()
			); 

			echo json_encode($response);

		}else if ($type == 'D') {

			if (!isset($request['order'])){
				$orderColumn = " ntdp_date_finish DESC, ";
				$orderDirection = " ntdp_time_finish DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " ntdp_date_finish DESC, ntdp_time_finish DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];
					if ($orderColumn  == 'apm_date'){
						$orderColumn =  'ntdp_date_finish';
					}else if ($orderColumn  == 'apm_time'){
						$orderColumn =  'ntdp_time_finish';
					}

				}
			}

			$totalRecords = $this->dbwts->getTotalPatientsDoneRecords($selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year, $depId   );
			$result 	  = $this->dbwts->getPatientsDonDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , ""  , $this->depId , $this->startDate , $this->endDate , $this->year, $depId   );
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}

			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, 
				"data" => $result->result_array()
			); 

			echo json_encode($response);
		}else {
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => 0,
				"recordsFiltered" => 0, // Change this if you apply any filtering
				"data" => []
			);
			echo json_encode($response);
		}
	}



	function getTotalAllStateDetail() {
		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$state  	 		=  $this->input->post('state') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];

		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];

		if ($state == 'W') {
			if (!isset($request['order'])){
				$orderColumn = " apm_date DESC ,";
				$orderDirection = " apm_time DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " apm_date DESC, apm_time DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];
				}
			}

			$totalRecords = $this->dbwts->getTotalWaitingPatientsRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year);
			$result 	  = $this->dbwts->getWaitingPatientsDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year);
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, // Change this if you apply any filtering
				"data" => $result->result_array()
			);
			echo json_encode($response);

		}else if ($state == 'P') {

			if (!isset($request['order'])){
				$orderColumn = " apm_date DESC, ";
				$orderDirection = " apm_time DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " apm_date DESC, apm_time DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];

					if ($orderColumn  == 'apm_date'){
						$orderColumn =  'ntdp_date_start';
					}else if ($orderColumn  == 'apm_time'){
						$orderColumn =  'ntdp_time_start';
					}
				}
			}


			$totalRecords = $this->dbwts->getTotalBeingServedRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year );
			$result 	  = $this->dbwts->getBeingServedDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year  );
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, 
				"data" => $result->result_array()
			); 

			echo json_encode($response);

		}else if ($state == 'D') {

			if (!isset($request['order'])){
				$orderColumn = " apm_date DESC, ";
				$orderDirection = " apm_time DESC ";
			}else{
				if ($request['order'][0]['column'] == 0){
					$orderColumn = " apm_date DESC, apm_time DESC ";
					$orderDirection =  $request['order'][0]['dir'];
				}else {
					$orderColumnIndex = $request['order'][0]['column'];
					$orderDirection = $request['order'][0]['dir'];
					$orderColumn = $request['columns'][$orderColumnIndex]['data'];


					if ($orderColumn  == 'apm_date'){
						$orderColumn =  'ntdp_date_finish';
					}else if ($orderColumn  == 'apm_time'){
						$orderColumn =  'ntdp_time_finish';
					}
				}
			}

			$totalRecords = $this->dbwts->getTotalPatientsDoneRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year );
			$result 	  = $this->dbwts->getPatientsDonDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year );
			foreach($result->result() as $row){
				$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
			}

			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $totalRecords, 
				"data" => $result->result_array()
			); 

			echo json_encode($response);
		}else {
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => 0,
				"recordsFiltered" => 0, // Change this if you apply any filtering
				"data" => []
			);
			echo json_encode($response);
		}
	}

	function getPatientServiceTimeData() {
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";

		$rsLocation = $this->dbwts->getWtsLocation()->result();
		$arrLocation = array();
		foreach ($rsLocation as $row) {
			$arrLocation[] = $row->loc_name;
		}
		$data['location'] = $arrLocation;
		$data['rsLocation'] = $rsLocation;
		$data['series'] = array();


		$arrOData = [];
		$arrNData = [];
		foreach($rsLocation as $index => $row) {
			$rsCountO = $this->dbwts->getCountPatientService($this->depId , $this->startDate , $this->endDate , $this->year, $row->loc_id , 'O')->num_rows();
			$arrOData[$index] = $rsCountO;

			$rsCountN = $this->dbwts->getCountPatientService($this->depId , $this->startDate , $this->endDate , $this->year, $row->loc_id , 'N')->num_rows();
			$arrNData[$index] = $rsCountN;
		}	

		$dataArr = array(
			'name'  => 'ไม่เกินเวลา',
			'data'  => $arrNData,
			'color' => '#40b780'
		);
		array_push($data['series'], $dataArr );



		$dataArr = array(
			'name'  => 'เกินเวลา',
			'data'  => $arrOData,
			'color' => '#e74c3c'
		);
		array_push($data['series'], $dataArr );

		echo json_encode($data);
	}

	function getPatientServiceTimeDataDetail(){

		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$loc  	 			=  $this->input->post('loc') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];


		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " ntdp_date_start DESC, ";
			$orderDirection = " ntdp_time_start DESC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " ntdp_date_start DESC, ntdp_time_start DESC ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}

		$totalRecords = $this->dbwts->getTotalPatientServiceTimeRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year, $loc  );

		$result 	  = $this->dbwts->getPatientServiceTimeDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year, $loc  );
		foreach($result->result() as $row){
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, 
			"data" => $result->result_array()
		); 

		echo json_encode($response);


	}


	function getPatientServiceTimeByDoctor() {
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";

		$data['rsDoctor'] = $this->dbwts->getDoctorWtsLocationByid($this->depId , $this->startDate , $this->endDate , $this->year, 8)->result();
		
		$arrDoctor = array();
		$data['DoctorImg'] = array();
		foreach($data['rsDoctor'] as $index=>$row){
			$arrDoctor[] = $row->pf_name_abbr_en.' '.$row->ps_fname_en;	
			$data['DoctorImg'][$row->pf_name_abbr_en.' '.$row->ps_fname_en] = site_url() . '/hr/getIcon?type=profile/profile_picture&image=' . $row->psd_picture;
		}

		$data['Doctor'] = $arrDoctor;
		$data['series'] = array();


		$arrOData = [];
		$arrNData = [];
		foreach($data['rsDoctor'] as $index => $row) {
			$rsCountO = $this->dbwts->getCountPatientServiceByDoctor($this->depId , $this->startDate , $this->endDate , $this->year, $row->ps_id , 8 , 'O')->num_rows();
			$arrOData[$index] = $rsCountO;

			$rsCountN = $this->dbwts->getCountPatientServiceByDoctor($this->depId , $this->startDate , $this->endDate , $this->year, $row->ps_id , 8 , 'N')->num_rows();
			$arrNData[$index] = $rsCountN;
		}	

		$dataArr = array(
			'name'  => 'จำนวนผู้ป่วย (ไม่เกินเวลา)',
			'data'  => $arrNData,
			'color' => '#40b780'
		);
		array_push($data['series'], $dataArr );



		$dataArr = array(
			'name'  => 'จำนวนผู้ป่วย (เกินเวลา)',
			'data'  => $arrOData,
			'color' => '#e74c3c'
		);
		array_push($data['series'], $dataArr );

		echo json_encode($data);
	}



	function getPatientServiceTimeByDoctorDetail(){

		$request = $this->input->post();
		
		$this->depId 	 	=  $this->input->post('department')?? 1;
		$this->startDate 	=  $this->convertThaiDateToGregorian($this->input->post('startDate') ?? "");
		$this->endDate   	=  $this->convertThaiDateToGregorian($this->input->post('endDate') ?? "");
		$this->year   	 	=  $this->input->post('year') ?? "";
		$type  	 			=  $this->input->post('type') ?? "";
		$ps_id  	 			=  $this->input->post('ps_id') ?? "";
		$selectedLetters   	=  json_decode($this->input->post('selectedLetters'), true) ?? [];
		$loc = 8;

		$draw = $request['draw'];
		$start = $request['start'];
		$length = $request['length'];
		$searchValue = $request['search']['value'];


		if (!isset($request['order'])){
			$orderColumn = " ntdp_date_start DESC, ";
			$orderDirection = " ntdp_time_start DESC ";
		}else{
			if ($request['order'][0]['column'] == 0){
				$orderColumn = " ntdp_date_start DESC, ntdp_time_start DESC ";
				$orderDirection =  $request['order'][0]['dir'];
			}else {
				$orderColumnIndex = $request['order'][0]['column'];
				$orderDirection = $request['order'][0]['dir'];
				$orderColumn = $request['columns'][$orderColumnIndex]['data'];
			}
		}

		$totalRecords = $this->dbwts->getTotalPatientServiceTimeByDoctorRecords($selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year, $loc, $ps_id  );

		$result 	  = $this->dbwts->getPatientServiceTimeByDoctorDetail($searchValue, $orderColumn, $orderDirection, $start, $length ,$selectedLetters , $type  , $this->depId , $this->startDate , $this->endDate , $this->year, $loc, $ps_id  );
		foreach($result->result() as $row){
			$row->pt_identification_format = $this->formatIdCard($row->pt_identification);
		}

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, 
			"data" => $result->result_array()
		); 

		echo json_encode($response);


	}
}


