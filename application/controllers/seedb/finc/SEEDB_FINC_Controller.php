<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../SEEDB_Controller.php"); //Include file มาเพื่อ extend
class SEEDB_FINC_Controller extends SEEDB_Controller
{
	public function __construct()
	{
        parent::__construct();
		$this->view .= "finc/";
		$this->model .= "finc/";
		$this->controller .= "finc/";
		
    }

	function index()
	{
		$this->session->set_userdata('is_have_menus_sidebar', true);
		$this->set_menu_sidebar(); // Do once when login system
		redirect($this->config->item('seedb_dir')."finc/Finc_dashboard/",'refresh');
	}
}
?>