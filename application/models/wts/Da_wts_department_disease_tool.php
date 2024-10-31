<?php
/*
* Da_wts_department_disease_tool
* Model for Manage about wts_department_disease_tool Table.
* @input -
* $output -
* @author Areeat Pongurai
* @Create Date 05/08/2024
*/
include_once("wts_model.php");

class Da_wts_department_disease_tool extends wts_model {		
	
	// PK is ddt_id
	public $ddt_id;
	public $ddt_stde_id;
	public $ddt_ds_id;
	public $ddt_eqs_id;
	public $ddt_seq;
	public $ddt_create_user;
	public $ddt_create_date;
	public $ddt_update_user;
	public $ddt_update_date;

	public $hr_db;
	public $eqs_db;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
		
		$this->hr_db = $this->load->database('hr', TRUE)->database;
		$this->eqs_db = $this->load->database('eqs', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_department_disease_tool (ddt_id, ddt_stde_id, ddt_ds_id, ddt_eqs_id, ddt_seq, ddt_create_user, ddt_create_date)
				VALUES(?, ?, ?, ?, ?, ?, NOW())";
		 
		$this->wts->query($sql, array($this->ddt_id, $this->ddt_stde_id, $this->ddt_ds_id, $this->ddt_eqs_id, $this->ddt_seq, $this->ddt_create_user));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_department_disease_tool
				SET	ddt_stde_id=?, ddt_ds_id=?, ddt_eqs_id=?, ddt_seq=?, ddt_update_user=?, ddt_update_date=NOW()
				WHERE ddt_id=?";	
		 
		$this->wts->query($sql, array($this->ddt_stde_id, $this->ddt_ds_id, $this->ddt_eqs_id, $this->ddt_seq, $this->ddt_update_user, $this->ddt_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM wts_department_disease_tool
				WHERE ddt_id=?";
		 
		$this->wts->query($sql, array($this->ddt_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM wts_department_disease_tool
				WHERE ddt_id=?";
		$query = $this->wts->query($sql, array($this->ddt_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
}	 //=== end class Da_umsystem
?>
