<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class DIM_Controller extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		redirect('dim/Examination_result','refresh');
  	}
}
?>