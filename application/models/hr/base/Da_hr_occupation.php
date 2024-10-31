<?php
/*
 * da_hr_prefix
 * Model for Manage about hr_prefix Table.
 * Copyright (c) 2559. Information System Engineering Research Laboratory.
 * @Author Chain_Chaiwat
 * @Create Date 2559-07-01
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_occupation extends Hr_model {

	// PK is pf_id

	public $pf_id ;
	public $pf_name;
	public $pf_name_en;
	public $pf_name_abbr;
	public $pf_name_abbr_en;
	public $pf_gd_id;
	public $pf_seq_no;
	public $pf_active;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_prefix (pf_name, pf_name_en,pf_gd_id,pf_active)
				VALUES( ?, ?, ?, ?)";
		$this->hr->query($sql, array($this->pf_name, $this->pf_name_en,$this->pf_gd_id,$this->pf_active));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		var_dump($this->pf_name_abbr_en);
		$sql = "UPDATE ".$this->hr_db.".hr_base_prefix
				SET	pf_name=?, pf_name_en=?, pf_gd_id=?,pf_name_abbr=?,pf_name_abbr_en=?
				WHERE pf_id=?";
		$this->hr->query($sql, array($this->pf_name, $this->pf_name_en, $this->pf_gd_id, $this->pf_name_abbr, $this->pf_name_abbr_en,$this->pf_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_prefix
				WHERE pf_id=?";
		$this->hr->query($sql, array($this->pf_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_prefix
				WHERE pf_id=?";
		$query = $this->hr->query($sql, array($this->pf_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
