<?php
/*
 * Hr_model
 * Model for Manage about open hr_model.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
*/
class Hr_model extends CI_Model {
	
	public $hr;
	public $hr_db;
	public $ums;
	public $ums_db;

	function __construct() {
		parent::__construct();

	    $this->hr =$this->load->database('hr', TRUE);
		$this->ums = $this->load->database('ums', TRUE);
		
		$this->hr_db = 	$this->hr->database;
		$this->ums_db = $this->ums->database;
	}
	
	function row2attribute($rw) {
		foreach ($rw as $key => $value) {
			if ( is_null($value) ) 
				eval("\$this->$key = NULL;");
			else
				$value = str_replace("'","&apos;",$value);
				eval("\$this->$key = '$value';");
		}
	}
}

?>