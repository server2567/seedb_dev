<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');

class Drawing extends AMS_Controller
{ 

	public function __construct()
	{
		parent::__construct();
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
	}

	function index(){
    $data['ddd'] = array();
		$this->output_frontend_public('ams/drawing/v_drawing',$data);   
  }
}
?>