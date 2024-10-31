<?php
/*
* Structure_Controller
* Controller หลักของ  Structure
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 13/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../HR_Controller.php");
class Structure_Controller extends HR_Controller {
	
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('hr_dir').$this->config->item('hr_structure_dir');
		$this->model = $this->config->item('hr_dir').$this->config->item('hr_structure_dir');
		$this->controller = $this->config->item('hr_dir').$this->config->item('hr_structure_dir');
		
    }
}
?>