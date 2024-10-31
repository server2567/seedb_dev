<?php
/*
 * Line_model
 * Model for Manage about open Line_model.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
*/
class Line_model extends CI_Model {
	
	public $line;
	public $line_db;

	public $ums;
	public $ums_db;

	function __construct() {
		parent::__construct();

	    $this->line =$this->load->database('line', TRUE);
		$this->ums = $this->load->database('ums', TRUE);
		
		$this->line_db = 	$this->line->database;
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