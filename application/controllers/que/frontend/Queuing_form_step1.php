<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Queuing_form_step1 extends UMS_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index(){

    $data['ddd'] = array();
		$this->output_frontend('que/frontend/v_queuing_form_step1',$data);   
  }

}
?>