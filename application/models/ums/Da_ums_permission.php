<?php
/*
 * Da_ums_permission
 * Model for Manage about ums_permission Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_permission extends ums_model {		
	
	// PK is pm_id
	
	public $pm_id;
	public $pm_us_id;
	public $pm_mn_id;
	public $pm_active;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_permission (pm_id, pm_us_id, pm_mn_id, pm_active)
				VALUES(?, ?, ?, ?)";
		 
		$this->ums->query($sql, array($this->pm_id, $this->pm_us_id, $this->pm_mn_id, $this->pm_active));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_permission 
				SET	pm_active=?
				WHERE pm_us_id=? and pm_mn_id=?";	
		 
		$this->ums->query($sql, array($this->pm_active, $this->pm_us_id, $this->pm_mn_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_permission
				WHERE pm_us_id=? and pm_mn_id=?";
		
		$this->ums->query($sql, array($this->pm_us_id, $this->pm_mn_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_permission 
				WHERE pm_us_id=?, pm_mn_id=?";
		$query = $this->ums->query($sql, array($this->pm_us_id, $this->pm_mn_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_ums_permission
?>
