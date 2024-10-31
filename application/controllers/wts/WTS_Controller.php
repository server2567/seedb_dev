<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../ums/UMS_Controller.php");

class WTS_Controller extends UMS_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index(){

      $redirect_urls = [
        'wts_user_admin' => 'wts/Dashboard_waiting',
        'wts_user_oph' => 'wts/Manage_queue',
        'wts_user_ent' => 'wts/Manage_queue',
        'wts_user_den' => 'wts/Manage_queue',
        'wts_user_rad' => 'wts/Manage_queue',
        'wts_user_lcc' => 'wts/Manage_queue',
    ];
    
    foreach ($this->session->userdata('us_groups') as $gp) {
        foreach ($redirect_urls as $config_item => $url) {
            if ($this->config->item($config_item) == $gp['gp_id']) {
                $this->session->set_userdata('gp_id', $gp['gp_id']);
                $this->session->set_userdata('gp_name_th', $gp['gp_name_th']);
                redirect($url, 'refresh');
                break 2;
            }
        }
    }

		
  	}
	
}
?>