<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class PMS_Controller extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->view('pms/v_modal_pms');
	}

	function index()
	{
		redirect('pms/Base_income_expenses','refresh');
  	}
}
?>