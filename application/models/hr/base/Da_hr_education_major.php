<?php
/*
* Da_hr_education_major
* Model for Manage about hr_base_education_major Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_education_major extends Hr_model {

	// PK is pf_id

	public $edumj_id ;
	public $edumj_name;
	public $edumj_name_en;
	public $edumj_active;
	public $edumj_create_user;
	public $edumj_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_education_major (edumj_name, edumj_name_en,edumj_active,edumj_create_user,edumj_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->edumj_name, $this->edumj_name_en,$this->edumj_active,$this->edumj_create_user,$this->edumj_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_major
				SET	edumj_name=?, edumj_name_en=?, edumj_active=?, edumj_update_user=?
				WHERE edumj_id=?";
		$this->hr->query($sql, array($this->edumj_name, $this->edumj_name_en, $this->edumj_active,$this->edumj_update_user,$this->edumj_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_education_major
				WHERE edumj_id=?";
		$this->hr->query($sql, array($this->edumj_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_major
		        SET edumj_active=?
				WHERE edumj_id=?";
				$this->hr->query($sql, array($this->edumj_active,$this->edumj_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_education_major 
        WHERE edumj_active != 2 AND edumj_name = ?" . (!empty($this->edumj_id) ? " AND edumj_id != ?" : "");
		if (!empty($this->edumj_id)) {
			$query = $this->hr->query($sql, array($this->edumj_name, $this->edumj_id));
		} else {
			$query = $this->hr->query($sql, array($this->edumj_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_education_major
				WHERE edumj_id=?";
		$query = $this->hr->query($sql, array($this->edumj_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
