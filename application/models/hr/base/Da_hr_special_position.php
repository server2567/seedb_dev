<?php
/*
* Da_hr_special_position
* Model for Manage about hr_base_special_position Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_special_position extends Hr_model {

	// PK is pf_id

	public $spcl_id ;
	public $spcl_name;
	public $spcl_name_en;
	public $spcl_name_abbr;
	public $spcl_name_abbr_en;
	public $spcl_active;
	public $spcl_create_user;
	public $spcl_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_special_position (spcl_name, spcl_name_en,spcl_name_abbr,spcl_name_abbr_en,spcl_active,spcl_create_user,spcl_update_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->spcl_name,$this->spcl_name_en,$this->spcl_name_abbr, $this->spcl_name_abbr_en,$this->spcl_active,$this->spcl_create_user,$this->spcL_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_special_position
				SET	spcl_name=?, spcl_name_en=?, spcl_name_abbr=?,spcl_name_abbr_en=?,spcl_active=?,spcl_update_user=?
				WHERE spcl_id=?";
		$this->hr->query($sql, array($this->spcl_name, $this->spcl_name_en,$this->spcl_name_abbr,$this->spcl_name_abbr_en ,$this->spcl_active,$this->spcl_update_user,$this->spcl_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_special_position
				WHERE spcl_id=?";
		$this->hr->query($sql, array($this->spcl_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_special_position
		        SET spcl_active=?
				WHERE spcl_id=?";
				$this->hr->query($sql, array($this->spcl_active,$this->spcl_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_special_position 
        WHERE spcl_active != 2 AND spcl_name = ?" . (!empty($this->spcl_id) ? " AND spcl_id != ?" : "");
		if (!empty($this->spcl_id)) {
			$query = $this->hr->query($sql, array($this->spcl_name, $this->spcl_id));
		} else {
			$query = $this->hr->query($sql, array($this->spcl_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_special_position
				WHERE spcl_id=?";
		$query = $this->hr->query($sql, array($this->spcl_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
