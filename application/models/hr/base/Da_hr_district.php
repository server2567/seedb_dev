<?php
/*
* Da_hr_district
* Model for Manage about hr_base_district Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_district extends Hr_model {

	// PK is pf_id

	public $dist_id ;
	public $dist_name;
	public $dist_name_en;
	public $dist_pv_id;
	public $dist_amph_id;
	public $dist_pos_code;
	public $dist_active;
	public $dist_create_user;
	public $dist_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_district (dist_name, dist_name_en,dist_pv_id,dist_amph_id,dist_pos_code,dist_create_user,dist_update_user,dist_active)
				VALUES(?, ?, ?,?,?,?,?,?)";
		$this->hr->query($sql, array($this->dist_name, $this->dist_name_en,$this->dist_pv_id,$this->dist_amph_id,$this->dist_pos_code,$this->dist_create_user,$this->dist_update_user,$this->dist_active));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_district
				SET	dist_name=?, dist_name_en=?, dist_pv_id =?,dist_amph_id=?,dist_pos_code=? ,dist_active=?
				WHERE dist_id=?";
		$this->hr->query($sql, array($this->dist_name, $this->dist_name_en, $this->dist_pv_id,$this->dist_amph_id,$this->dist_pos_code,$this->dist_active,$this->dist_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_district
				WHERE dist_id=?";
		$this->hr->query($sql, array($this->dist_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_district
		       SET dist_active=?
				WHERE dist_id=?";
				$this->hr->query($sql, array($this->dist_active,$this->dist_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_district 
        WHERE dist_amph_id = ? AND dist_pv_id = ? AND dist_active != 2 AND dist_name = ?" . (!empty($this->dist_id) ? " AND dist_id != ?" : "");
		if (!empty($this->dist_id)) {
			$query = $this->hr->query($sql, array($this->dist_amph_id,$this->dist_pv_id,$this->dist_name, $this->dist_id));
		} else {
			$query = $this->hr->query($sql, array($this->dist_amph_id,$this->dist_pv_id,$this->dist_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_district
				WHERE dist_id=?";
		$query = $this->hr->query($sql, array($this->dist_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
