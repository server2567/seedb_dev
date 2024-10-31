<?php
/*
* Da_hr_adline_position
* Model for Manage about hr_base_adline_position Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_education_place extends Hr_model {

	// PK is pf_id

	public $place_id ;
	public $place_name;
	public $place_name_en;
	public $place_active;
	public $place_create_user;
	public $place_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_place (place_name, place_name_en,place_abbr,place_abbr_en,place_active,place_create_user,place_update_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->place_name, $this->place_name_en,$this->place_abbr,$this->place_abbr_en,$this->place_active,$this->place_create_user,$this->place_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_place
				SET	place_name=?, place_name_en=?, place_abbr=?, place_abbr_en=?, place_active=? , place_update_user=?
				WHERE place_id=?";
		$this->hr->query($sql, array($this->place_name, $this->place_name_en, $this->place_abbr, $this->place_abbr_en, $this->place_active,$this->place_update_user,$this->place_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_place
				WHERE place_id=?";
		$this->hr->query($sql, array($this->place_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_place
		        SET place_active=?
				WHERE place_id=?";
				$this->hr->query($sql, array($this->place_active,$this->place_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_place 
        WHERE place_active != 2 AND place_name = ?" . (!empty($this->place_id) ? " AND place_id != ?" : "");
		if (!empty($this->place_id)) {
			$query = $this->hr->query($sql, array($this->place_name, $this->place_id));
		} else {
			$query = $this->hr->query($sql, array($this->place_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_place
				WHERE place_id=?";
		$query = $this->hr->query($sql, array($this->place_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
