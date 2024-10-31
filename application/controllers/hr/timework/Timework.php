<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Timework_Controller.php');

class Timework_person extends Timework_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_user', $data);
	}
  public function get_format()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_format_show', $data);
	}
  public function get_add_format()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('hr/timework/v_timework_format_form', $data);
	}
  public function get_edit_format()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('hr/timework/v_timework_format_form', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
	public function get_timework_branch_add()
	{
		$data['status_response'] = $this->config->item('status_response_show');
		$data['Menus'] = [
			[
				'MnID' => 61,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "สาขาวิชา"
			],
			[
				'MnID' => 63,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 61,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "สาขาวิชา"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = $this->config->item('status_response_show');;
		// $this->header();
		// $this->sidebar();
		// $this->topbar();
		// $this->main($data);
		// $this->load->view('hr/timework/v_person_list_show',$data);
		$this->output('hr/timework/v_Profille_branch_form', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
	public function get_timework_branch_edit($StID=null)
	{
		$data['StID'] = $StID;
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['Menus'] = [
			[
				'MnID' => 61,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "สาขาวิชา"
			],
			[
				'MnID' => 63,
				'MnStID' => 1,
				'MnLevel' => 1,
				'MnParentMnID' => 61,
				'MnUrl' => "ums/Title",
				'MnUrlText' => null,
				'MnNameT' => "สาขาวิชา"
			]
		];
		$this->setUrl($data['Menus']);
		$data['status_response'] = $this->config->item('status_response_show');;
		// $this->header();
		// $this->sidebar();
		// $this->topbar();
		// $this->main($data);
		// $this->load->view('hr/timework/v_person_list_show',$data);
		$this->output('hr/timework/v_Profille_branch_form', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
}
