<?php

include_once("dim_model.php");

class Da_dim_examination_result_doc extends dim_model {		

	// PK is exrd_id
	public $exrd_id;
	public $exrd_exr_id;
	public $exrd_file_name;
	public $exrd_old_file_name;
	public $exrd_status;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO dim_examination_result_doc (exrd_id, exrd_exr_id, exrd_file_name, exrd_old_file_name, exrd_status)
				VALUES(?, ?, ?, ?, ?)";
		 
		$this->dim->query($sql, array($this->exrd_id, $this->exrd_exr_id, $this->exrd_file_name, $this->exrd_old_file_name, $this->exrd_status));
		$this->last_insert_id = $this->dim->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result_doc 
				SET	exrd_exr_id=?, exrd_file_name=?, exrd_status=?, exrd_old_file_name=?
				WHERE exrd_id=? ";	
		 
		$this->dim->query($sql, array($this->exrd_exr_id, $this->exrd_file_name, $this->exrd_old_file_name, $this->exrd_status, $this->exrd_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM dim_examination_result_doc
				WHERE exrd_id=?";
		 
		$this->dim->query($sql, array($this->exrd_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM dim_examination_result_doc
				WHERE exrd_id=?";
		$query = $this->dim->query($sql, array($this->exrd_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_dim_examination_result_doc
?>
