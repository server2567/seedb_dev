<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/PMS_Controller.php");
class Base_income_expenses extends PMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['Menus'] = [
			[
				'MnID' => 71,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "ข้อมูลพื้นฐาน"
			],
			[
				'MnID' => 72,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 71,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลพื้นฐานประเภทรายจ่าย"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = array();
		$this->output('' . $this->config->item('pms_base_path') . '/v_base_income_expenses_show', $data);
	}

	function insert()
	{

		$data['status_response'] = array();
		$this->output('' . $this->config->item('pms_base_path') . '/v_base_income_expenses_form', $data);
	}

	function edit($StID = null)
	{

		$data['status_response'] = array();
		$data['StID'] = $StID;
		$this->output('' . $this->config->item('pms_base_path') . '/v_base_income_expenses_form', $data);
	}
	public function Base_budget_show()
	{
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['Menus'] = [
			[
				'MnID' => 71,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "ข้อมูลพื้นฐาน"
			],
			[
				'MnID' => 72,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 71,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "จัดการข้อมูลพื้นฐานสถานะการปฏิบัติงาน"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = $this->config->item('status_response_show');;
		// $this->header();
		// $this->sidebar();
		// $this->topbar();
		// $this->main($data);
		// $this->load->view('hr/Profile/v_person_list_show',$data);
		$this->output('pms/budget/v_base_budget_show', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
}
