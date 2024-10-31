<?php
/*
* Da_hr_country
* Model for Manage about hr_base_structure_position Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_structure_position extends Hr_model {

	// PK is pf_id

	public $stpo_id ;
	public $stpo_name;
	public $stpo_name_en;
	public $stpo_display;
	public $stpo_active;
	public $stpo_create_user;
	public $stpo_update_user;
	public $last_insert_id;
    public $stpo_used;
	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_structure_position 
				(stpo_name, stpo_name_en, stpo_used, stpo_display, stpo_active, stpo_create_user, stpo_update_user)
				VALUES(?, ?, ?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->stpo_name, 
			$this->stpo_name_en, 
			$this->stpo_used, 
			$this->stpo_display, 
			$this->stpo_active, 
			$this->stpo_create_user, 
			$this->stpo_update_user
		));
		$this->last_insert_id = $this->hr->insert_id();
	}
	

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_structure_position
				SET	stpo_name=?, stpo_name_en=?, stpo_used=?,stpo_display=?,stpo_active=? , stpo_update_user = ?
				WHERE stpo_id=?";
		$this->hr->query($sql, array($this->stpo_name, $this->stpo_name_en, $this->stpo_used,$this->stpo_display,$this->stpo_active,$this->stpo_update_user,$this->stpo_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_structure_position
				WHERE stpo_id=?";
		$this->hr->query($sql, array($this->stpo_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_structure_position
		        SET stpo_active=?
				WHERE stpo_id=?";
				$this->hr->query($sql, array($this->stpo_active,$this->stpo_id));
	}
	function finding()
	{
		$this->stpo_id = decrypt_id($this->stpo_id);
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_structure_position 
        WHERE stpo_active != 2 AND stpo_name = ?" . (!empty($this->stpo_id) ? " AND stpo_id != ?" : "");
		if (!empty($this->stpo_id)) {
			$query = $this->hr->query($sql, array($this->stpo_name, $this->stpo_id));
		} else {
			$query = $this->hr->query($sql, array($this->stpo_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_structure_position
				WHERE stpo_id=?";
		$query = $this->hr->query($sql, array($this->stpo_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
