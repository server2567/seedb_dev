<?php
/*
* Da_hr_province
* Model for Manage about hr_base_province Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_province extends Hr_model {

	// PK is pf_id

	public $pv_id ;
	public $pv_name;
	public $pv_name_en;
	public $pv_active;
	public $pv_create_user;
	public $pv_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_province (pv_name, pv_name_en,pv_active,pv_create_user,pv_update_user)
				VALUES( ?, ?, ?,?,?)";
		$this->hr->query($sql, array($this->pv_name, $this->pv_name_en,$this->pv_active,$this->pv_create_user,$this->pv_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_province
				SET	pv_name=?, pv_name_en=?, pv_active=?,pv_update_user = ?
				WHERE pv_id=?";
		$this->hr->query($sql, array($this->pv_name, $this->pv_name_en,$this->pv_active,$this->pv_update_user,$this->pv_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_province
				WHERE pv_id=?";
		$this->hr->query($sql, array($this->pv_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_province
		        SET pv_active=?
				WHERE pv_id=?";
				$this->hr->query($sql, array($this->pv_active,$this->pv_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_province 
        WHERE pv_active != 2 AND pv_name = ?" . (!empty($this->pv_id) ? " AND pv_id != ?" : "");
		if (!empty($this->pv_id)) {
			$query = $this->hr->query($sql, array($this->pv_name, $this->pv_id));
		} else {
			$query = $this->hr->query($sql, array($this->pv_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_province
				WHERE pv_id=?";
		$query = $this->hr->query($sql, array($this->pv_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
