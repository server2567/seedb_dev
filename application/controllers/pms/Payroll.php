<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('PMS_Controller.php');

class Payroll extends PMS_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
    $data['arr'] = array();
		$this->output('pms/v_payroll', $data);
	}
}
?>