<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/Staff_Controller.php");
class Staff extends Staff_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = $this->set_breadcrumb();
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->header();
		// $this->sidebar();
		// $this->topbar();
		// $this->main($data);
		$this->load->view('staff/v_staff_show', $data);
		// $this->footer();
		// $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('staff/v_staff_show',$data);
	}
}
