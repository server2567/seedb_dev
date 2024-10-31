<?php
/*
* Develop_Controller
* Controller หลักของ  Develop
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 10/06/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../HR_Controller.php");
class Develop_Controller extends HR_Controller {
	
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('hr_dir').$this->config->item('hr_develop_dir');
		$this->model = $this->config->item('hr_dir');
		$this->controller = $this->config->item('hr_dir').$this->config->item('hr_develop_dir');
		
    }
}
?>