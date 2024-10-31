<?php
/*
 * Da_ums_usergroup
 * Model for Manage about ums_usergroup Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_usergroup extends ums_model {		
	
	// PK is ug_id
	
	public $ug_id;
	public $ug_gp_id;
	public $ug_us_id;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_usergroup (ug_id, ug_gp_id, ug_us_id)
				VALUES(?, ?, ?)";
		 
		$this->ums->query($sql, array($this->ug_id, $this->ug_gp_id, $this->ug_us_id));
		$this->last_insert_id = $this->ums->insert_id();
		
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_usergroup 
				SET	ug_gp_id=?, ug_us_id=?
				WHERE ug_gp_id=? AND ug_us_id=?";	
		 
		$this->ums->query($sql, array($this->ug_gp_id, $this->ug_us_id, $this->ug_gp_id, $this->ug_us_id));		
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_usergroup
				WHERE ug_gp_id=? AND ug_us_id=?";
		 
		$this->ums->query($sql, array($this->ug_gp_id, $this->ug_us_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_usergroup 
				WHERE ug_gp_id=? AND ug_us_id=?";
		$query = $this->ums->query($sql, array($this->ug_gp_id, $this->ug_us_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_ums_usergroup
?>
