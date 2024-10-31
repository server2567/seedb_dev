<?php
/*
* Base_Controller
* Controller หลักของ  base
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 13/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../HR_Controller.php");
class Base_Controller extends HR_Controller {
	
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('hr_dir').$this->config->item('hr_base_dir');
		$this->model = $this->config->item('hr_dir').$this->config->item('hr_base_dir');
		$this->controller = $this->config->item('hr_dir').$this->config->item('hr_base_dir');
		
    }
}
?>