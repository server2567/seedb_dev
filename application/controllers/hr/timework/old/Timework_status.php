<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_status extends Timework_Controller
{
	private $mn_active_id = 300031;
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['session_mn_active_id'] = $this->mn_active_id; // set session_mn_active_id / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework__work_status_show', $data);
	}
	public function get_Time__status_add()
	{
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['Menus'] = [
			[
				'MnID' => 39,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "ข้อมูลพื้นฐาน"
			],
			[
				'MnID' => 42,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 39,
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
		$this->output('hr/timework/v_timework_work_status_form', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
	public function get_Time__work_edit($StID=null)
	{
		$data['StID'] = $StID;
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['Menus'] = [
			[
				'MnID' => 39,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "ข้อมูลพื้นฐาน"
			],
			[
				'MnID' => 42,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 39,
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
		$this->output('hr/timework/v_timework_work_shift_form', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
}
