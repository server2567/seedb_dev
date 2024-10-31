<?php

class ums_model extends CI_Model {

	public $ums;
	public $ums_db;

	public $hr;
	public $hr_db;

	public $que;
	public $que_db;

	public $ams;
	public $ams_db;  

  public $wts;
	public $wts_db;  
	function __construct() {
		parent::__construct();
		$this->ums = $this->load->database('ums', TRUE);
		$this->hr =$this->load->database('hr', TRUE);
		$this->que =$this->load->database('que', TRUE);
		$this->ams =$this->load->database('ams', TRUE);
		$this->wts =$this->load->database('wts', TRUE);
	
		$this->hr_db = 	$this->hr->database;
		$this->ums_db = $this->ums->database;
		$this->que_db = $this->que->database;
		$this->ams_db = $this->ams->database;
		$this->wts_db = $this->wts->database;
	}

	function row2attribute($rw) {
		foreach ($rw as $key => $value) {
			if ( is_null($value) ) 
				eval("\$this->$key = NULL;");
			else
				eval("\$this->$key = '$value';");
		}
	}


}

?>