<?php
/*
 * Da_ums_icon
 * Model for Manage about ums_icon Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("ums_model.php");

class Da_ums_icon extends ums_model {		
	
	// PK is ic_name
	
	public $ic_id;
	public $ic_name;
	public $ic_type;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ums_icon (ic_id, ic_name, ic_type)
				VALUES(?, ?, ?)";
		 
		$this->ums->query($sql, array($this->ic_id, $this->ic_name, $this->ic_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_icon 
				SET	ic_name=?, ic_type=? 
				WHERE ic_id=?";	
		 
		$this->ums->query($sql, array($this->ic_name, $this->ic_type, $this->ic_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ums_icon
				WHERE ic_id=?";
		 
		$this->ums->query($sql, array($this->ic_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_icon 
				WHERE ic_id=?";
		$query = $this->ums->query($sql, array($this->ic_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_ums_icon
?>
