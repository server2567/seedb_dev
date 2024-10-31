<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('AMS_Controller.php');


class Statistics extends AMS_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function index(){
        // $data['Menus'] = [
		// 	[
		// 		'MnID' => 39,
		// 		'MnStID' => 1,
		// 		'MnLevel' => 0,
		// 		'MnParentMnID' => null,
		// 		'MnUrl' => null,
		// 		'MnUrlText' => null,
		// 		'MnNameT' => "ข้อมูลพื้นฐาน"
		// 	],
		// 	[
		// 		'MnID' => 41,
		// 		'MnStID' => 1,
		// 		'MnLevel' => 1,
		// 		'MnParentMnID' => 39,
		// 		'MnUrl' => "ums/Base_position_group",
		// 		'MnUrlText' => null,
		// 		'MnNameT' => "ข้อมูลการเตรียมตัวก่อนวันพบแพทย์"
		// 	]
		// ];
		
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('ams/statistics/v_statistics_show',$data);   
  }

  
  public function show_info($id)
	{   
        $data['id'] = $id;
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$this->output('que/patient/v_patient_info',$data);
	}

	public function show_patient($id)
	{
		$data['id'] = $id;
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$this->output('que/patient/v_patient_show',$data);
	}

}
?>