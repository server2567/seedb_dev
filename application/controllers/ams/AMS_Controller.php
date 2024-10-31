<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend

class AMS_Controller extends UMS_Controller
{
	protected $view;
	protected $model;
	protected $controller;
	public $ams_dir = "ams/";
	public function __construct()
	{
		parent::__construct();
	}

	function index(){
		redirect('ams/Notification_result','refresh');
  	}
}
?>