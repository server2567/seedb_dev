<?php

include_once("dim_model.php");

class Da_dim_examination_result_doc_bin extends dim_model {		

	// PK is exrdb_exrd_id
	public $exrdb_exrd_id;
	public $exrdb_expiration_date;
	public $exrdb_recover_date;
	public $exrdb_status;

	public $ums_db;
	public $hr_db;
	public $eqs_db;
	public $que_db;
	public $ams_db;

	// public $last_insert_id;

	function __construct() {
		parent::__construct();
		$this->ums_db = $this->load->database('ums', TRUE)->database;
		$this->hr_db = $this->load->database('hr', TRUE)->database;
		$this->eqs_db = $this->load->database('eqs', TRUE)->database;
		$this->que_db = $this->load->database('que', TRUE)->database;
		$this->ams_db = $this->load->database('ams', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO dim_examination_result_doc_bin (exrdb_exrd_id, exrdb_expiration_date, exrdb_recover_date, exrdb_status)
				VALUES(?, ?, ?, ?)";
		 
		$this->dim->query($sql, array($this->exrdb_exrd_id, $this->exrdb_expiration_date, $this->exrdb_recover_date, $this->exrdb_status));
		// $this->last_insert_id = $this->dim->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result_doc_bin 
				SET	exrdb_expiration_date=?, exrdb_recover_date=?, exrdb_status=?
				WHERE exrdb_exrd_id=? ";	
		 
		$this->dim->query($sql, array($this->exrdb_expiration_date, $this->exrdb_recover_date, $this->exrdb_status, $this->exrdb_exrd_id));
	}
	
	// function delete() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "DELETE FROM dim_examination_result_doc_bin
	// 			WHERE exrdb_exrd_id=?";
		 
	// 	$this->dim->query($sql, array($this->exrdb_exrd_id));
	// }
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM dim_examination_result_doc_bin
				WHERE exrdb_exrd_id=?";
		$query = $this->dim->query($sql, array($this->exrdb_exrd_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_dim_examination_result_doc_bin
?>
