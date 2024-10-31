<?php
/*
* Log_Controller
* Controller หลักของ  Log
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 11/06/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../HR_Controller.php");
class Log_Controller extends HR_Controller {
	
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('hr_dir').$this->config->item('hr_log_dir');
		$this->model = $this->config->item('hr_dir');
		$this->controller = $this->config->item('hr_dir').$this->config->item('hr_log_dir');
		
    }
}
?>