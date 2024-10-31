<?php
/*
 * Da_hr_logs
 * Model for Manage about hr_logs Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 11/06/2024
 */
include_once("hr_model.php");

class Da_hr_logs extends Hr_model{

	//PK is log_id
	public $log_id;
	public $log_date;
	public $log_ip;
	public $log_us_id;
	public $log_ps_id;
	public $log_changed;
	public $log_agent;
	
	public $last_insert_id;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert(){
		$sql = " INSERT INTO ".$this->hr_db.".hr_logs (log_ps_id,log_us_id,log_date,log_changed,log_ip,log_agent)
				 VALUES(?,?,CURRENT_TIMESTAMP,?,?,?);";
		$user_agent = $this->input->user_agent();
		$device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_ps_id'),$this->session->userdata('us_id'),$this->log_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}

	function delete(){
		$sql = " DELETE FROM ".$this->hr_db.".hr_logs
				WHERE log_id=?"; 
		$this->ums->query($sql, array($this->log_id));
	}

	function insert_log($text)
	{
		$sql = " INSERT INTO ".$this->hr_db.".hr_logs (log_ps_id,log_us_id,log_date,log_changed,log_ip,log_agent)
				 VALUES(?,?,CURRENT_TIMESTAMP,?,?,?);";
		
		$this->log_changed = $text;
		$user_agent = $this->input->user_agent();
		$device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_ps_id'),$this->session->userdata('us_id'),$this->log_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	// Function to detect device type based on user agent string
	function detect_device_type($user_agent) {
		// Define patterns for different types of devices
		$mobile_patterns = '/mobile|android|iphone|ipod|blackberry|iemobile|opera mini|windows phone/i';
		$tablet_patterns = '/ipad|tablet|kindle|playbook|silk/i';
		$desktop_patterns = '/windows|macintosh|linux|cros/i';

		// Check for tablet devices first
		if (preg_match($tablet_patterns, $user_agent)) {
			return 'tablet';
		}
		// Check for mobile devices
		else if (preg_match($mobile_patterns, $user_agent)) {
			return 'mobile';
		}
		// Check for desktop devices
		else if (preg_match($desktop_patterns, $user_agent)) {
			return 'computer';
		}
		// Default to computer if none of the patterns match
		else {
			return 'computer';
		}
	}
}
?>
