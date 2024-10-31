<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class Personal_dashboard_Controller extends UMS_Controller
{
	protected $view;
	protected $model;
	protected $controller; 

	public function __construct()
	{
        parent::__construct();
		$this->view = $this->config->item('pd_dir');
		$this->model = $this->config->item('pd_dir');
		$this->controller = $this->config->item('pd_dir');
		
    }

	function index()
	{
		redirect($this->config->item('pd_dir').'Home','refresh');
	}
}
?>