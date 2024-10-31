<?php
/*
* Da_hr_education_level
* Model for Manage about hr_base_education_level Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_education_level extends Hr_model {

	// PK is pf_id

	public $edulv_id ;
	public $edulv_name;
	public $edulv_name_en;
	public $edulv_active;
	public $edulv_create_user;
    public $edulv_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_education_level (edulv_name, edulv_name_en,edulv_active,edulv_create_user,edulv_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->edulv_name, $this->edulv_name_en,$this->edulv_active,$this->edulv_create_user,$this->edulv_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_level
				SET	edulv_name=?, edulv_name_en=?, edulv_active=? ,edulv_update_user = ?
				WHERE edulv_id=?";
		$this->hr->query($sql, array($this->edulv_name, $this->edulv_name_en, $this->edulv_active,$this->edulv_update_user,$this->edulv_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_education_level
				WHERE edulv_id=?";
		$this->hr->query($sql, array($this->edulv_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_level
		        SET edulv_active=?
				WHERE edulv_id=?";
				$this->hr->query($sql, array($this->edulv_active,$this->edulv_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_education_level 
        WHERE edulv_active != 2 AND edulv_name = ?" . (!empty($this->edulv_id) ? " AND edulv_id != ?" : "");
		if (!empty($this->edulv_id)) {
			$query = $this->hr->query($sql, array($this->edulv_name, $this->edulv_id));
		} else {
			$query = $this->hr->query($sql, array($this->edulv_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_education_level
				WHERE edulv_id=?";
		$query = $this->hr->query($sql, array($this->edulv_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
