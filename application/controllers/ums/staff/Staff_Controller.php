<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class Staff_Controller extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ums/m_ums_menu');
	}

	function index()
	{
		redirect('staff/Staff','refresh');
	}

	function set_breadcrumb()
	{
		// set home url of system for breadcrumb
		$session_st_home_url = $this->session->userdata('st_home_url');
		$data['session_st_home_url'] = isset($session_st_home_url) ? $session_st_home_url : array();

		// set name abbr enlish of home url system for breadcrumb
		$session_st_name_abbr_en = $this->session->userdata('st_name_abbr_en');
		$data['session_st_name_abbr_en'] = isset($session_st_name_abbr_en) ? $session_st_name_abbr_en : array();

		// set menus active for breadcrumb
		if(isset($data['session_mn_active_id']))
		{
			// $session_menus_active = $this->m_ums_menu->get_menus_path($data['session_mn_active_id'])->result_array();
			$session_menus_active = $this->m_ums_menu->get_menus_path_mock($data['session_mn_active_id']);
			$data['session_menus_active'] = isset($session_menus_active) ? $session_menus_active : array();
		}

		return $data;
	}
}
?>