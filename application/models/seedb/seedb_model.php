<?php
/*
 * Seedb_model
 * Model for Manage about open Seedb_model.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 01/07/2024
*/
class Seedb_model extends CI_Model {
	public $hr;
	public $hr_db;
	public $ums;
	public $ums_db;
	public $wts;
	public $wts_db;
	public $que;
	public $que_db;


	function __construct()
	{
		parent::__construct();
		$this->wts = $this->load->database('wts', TRUE);
		$this->hr = $this->load->database('hr', TRUE);
		$this->ums = $this->load->database('ums', TRUE);
		$this->que = $this->load->database('que', true);

		$this->hr_db = 	$this->hr->database;
		$this->ums_db = $this->ums->database;
		$this->wts_db = $this->wts->database;
		$this->que_db = $this->que->database;
	}

	function row2attribute($rw)
	{
		foreach ($rw as $key => $value) {
			if (is_null($value))
				eval("\$this->$key = NULL;");
			else
				eval("\$this->$key = '$value';");
		}
	}
}

?>