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
		foreach($structureDetail  as $row) {
			array_push($arrStde, $row->stde_abbr);
		}
		
		array_push($arrStde, 'etc.');
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
}


