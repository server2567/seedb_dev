<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Base_Controller.php');

class Base extends Base_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();

		// [20240730 Areerat Pongurai] Specify 'url' because this location of file is 2+ level folder
		$this->mn_active_url = "hr/base/Base";
	}

	// public function index()
	// {
	// 	$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
	// 	$data['status_response'] = $this->config->item('status_response_show');;
	// 	$this->output($this->view . 'v_base_list_show', $data);
	// }
	public function index()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->load->model($this->model . "m_hr_base");
		$parent = $this->m_hr_base->get_all_parent()->result();
		foreach ($parent as $value) {
			$children = $this->m_hr_base->get_children_by_parent($value->mn_id)->result();
			$value->sum_count = 0;
			foreach ($children as $value2) {
				$parts = explode('/', $value2->mn_url);
				$modelName = 'hr_base_' . strtolower(end($parts));
				if ($this->m_hr_base->count_data_children($modelName, $value2->mn_id) !== null) {
					$value2->data_count = count($this->m_hr_base->count_data_children($modelName, $value2->mn_id)->result());
				    $value->sum_count += $value2->data_count ;
				}
			}
			$value->children = $children;
		}
		$data['parent'] = $parent;
		$this->output($this->view . 'v_base_list_show_new', $data);
	}
}
