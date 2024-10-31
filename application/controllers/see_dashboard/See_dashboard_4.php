<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/See_dashboard_Controller.php");

class See_dashboard_4 extends See_dashboard_Controller{

	// Create __construct for load model use in this controller
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$data['status_response'] = $this->config->item('status_response_show');;

        // $this->header();
        // $this->sidebar();
        // $this->topbar();
        // $this->main($data);
        $this->load->view('see_dashboard/v_see_dashboard_4_show',$data);
        // $this->footer();
        // $this->javascript(isset($data['Menus']) ? $data['Menus'] : array());

		// $this->output('personal_dashboard/v_personal_dashboard_show',$data);
	}
}
?>
