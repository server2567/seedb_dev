<?php
/*
 * Da_ums_sync
 * Model for Manage about ums_sync Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_sync extends ums_model {		
	
	// PK is sync_id
	
	public $sync_id;
	public $sync_file_name;
	public $sync_us_id;
	public $sync_date;

	public $hr_db;

	public $last_insert_id;

	function __construct() {
		parent::__construct();

		$this->hr_db = $this->load->database('hr', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_sync (sync_id, sync_file_name, sync_us_id, sync_date)
				VALUES(?, ?, ?, NOW())";
		 
		$this->ums->query($sql, array($this->sync_id, $this->sync_file_name, $this->sync_us_id));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_sync 
				SET	sync_file_name=?, sync_us_id=?, sync_date=NOW()
				WHERE sync_id=? ";	
		 
		$this->ums->query($sql, array($this->sync_file_name, $this->sync_us_id, $this->sync_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_sync
				WHERE sync_id=?";
		 
		$this->ums->query($sql, array($this->sync_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_sync 
				WHERE sync_id=?";
		$query = $this->ums->query($sql, array($this->sync_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_sync
?>
