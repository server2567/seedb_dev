<?php 
/*
* Develop_dashboard
* Controller หลักของ SEEDB HRD
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 16/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/SEEDB_HR_Controller.php");
class Develop_dashboard extends SEEDB_HR_Controller
{

	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Personal_dashboard/";
		$this->mn_active_url = uri_string();

		// load model
		$this->load->model($this->config->item('hr_dir').'M_hr_person');
		$this->load->model($this->model.'Develop_dashboard_model');
	}

	/*
	* index
	* index หลักของ SEEDB HRD
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/08/2024
	*/
	public function index()
	{
       
    }
	// index



}
