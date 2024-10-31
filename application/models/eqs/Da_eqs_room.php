<?php

include_once("eqs_model.php");

class Da_eqs_room extends eqs_model {		
	
	// PK is rm_id
	public $rm_id;
	public $rm_name;
	public $rm_no;
	public $rm_floor;
	public $rm_capacity;
	public $rm_area;
	public $rm_fmst_id;
	public $rm_bd_id;
	public $rm_bdtype_id;
	public $rm_dpid;
	public $rm_status_id;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO eqs_room (rm_id, rm_name, rm_no, rm_floor, rm_capacity, rm_area, rm_fmst_id, rm_bd_id, rm_bdtype_id, rm_dpid, rm_status_id)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->eqs->query($sql, array($this->rm_id, $this->rm_name, $this->rm_no, $this->rm_floor, $this->rm_capacity, $this->rm_area, $this->rm_fmst_id, $this->rm_bd_id, $this->rm_bdtype_id, $this->rm_dpid, $this->rm_status_id));
		$this->last_insert_id = $this->eqs->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE eqs_room 
				SET	rm_name=?, rm_no=?, rm_floor=?, rm_capacity=?, rm_area=?, rm_fmst_id=?, rm_bd_id=?, rm_bdtype_id=?, rm_dpid=?, rm_status_id=?
				WHERE rm_id=? ";	
		 
		$this->eqs->query($sql, array($this->rm_name, $this->rm_no, $this->rm_floor, $this->rm_capacity, $this->rm_area, $this->rm_fmst_id, $this->rm_bd_id, $this->rm_bdtype_id, $this->rm_dpid, $this->rm_status_id, $this->rm_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM eqs_room
				WHERE rm_id=?";
		 
		$this->eqs->query($sql, array($this->rm_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM eqs_room 
				WHERE rm_id=?";
		$query = $this->eqs->query($sql, array($this->rm_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_eqs_room
?>
