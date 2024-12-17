<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class PMS_Controller extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
    $data['arr'] = array();
    $this->output('pms/v_home_pms',$data);   
		// redirect('pms/Base_income_expenses','refresh');
  }
}
?>