<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('PMS_Controller.php');

class Payroll_show extends PMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
    $data['arr'] = array();
		$this->output('pms/v_payroll_show', $data);
	}
}
?>