<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../ums/UMS_Controller.php");

class WTS extends UMS_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index(){
        $data['Menus'] = [
			[
				'MnID' => 1,
				'MnStID' => 1,
				'MnLevel' => 0,
				'MnParentMnID' => null,
				'MnUrl' => null,
				'MnUrlText' => null,
				'MnNameT' => "WTS"
			]
		];

        $data['status_response'] = $this->config->item('status_response_show');;
        $this->output('wts/dashboard/v_dashboard_report_waiting',$data);
  	}
	  public function alertCure() {

		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/dashboard/v_alert_cure_time.php',$data);
	}
}
?>