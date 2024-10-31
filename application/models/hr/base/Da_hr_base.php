<?php
/*
* Da_hr_amphur
* Model for Manage about hr_base_amphur Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_base extends Hr_model {

	// PK is pf_id

	public $amph_id ;
	public $amph_name;
	public $amph_name_en;
	public $amph_pv_id;
	public $amph_active;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	// function insert() {
	// 	// if there is no auto_increment field, please remove it
	// 	$sql = "INSERT INTO ".$this->hr_db.".hr_base_amphur (amph_name, amph_name_en,amph_pv_id,amph_active)
	// 			VALUES( ?, ?,?, ?)";
	// 	$this->hr->query($sql, array($this->amph_name, $this->amph_name_en,$this->amph_pv_id,$this->amph_active));
	// 	$this->last_insert_id = $this->hr->insert_id();
	// }

	// function update() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "UPDATE ".$this->hr_db.".hr_base_amphur
	// 			SET amph_pv_id=?,amph_name=?, amph_name_en=?, amph_active=?
	// 			WHERE amph_id=?";
	// 	$this->hr->query($sql, array($this->amph_pv_id,$this->amph_name, $this->amph_name_en, $this->amph_active,$this->amph_id));
	// }

	// function delete() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "DELETE FROM ".$this->hr_db.".hr_base_amphur
	// 			WHERE amph_id=?";
	// 	$this->hr->query($sql, array($this->amph_id));
	// }
	// function disabled() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "UPDATE ".$this->hr_db.".hr_base_amphur
	// 	        SET amph_active=?
	// 			WHERE amph_id=?";
	// 			$this->hr->query($sql, array($this->amph_active,$this->amph_id));
	// }
	// function finding()
	// {
	// 	$sql = "SELECT * 
    //     FROM " . $this->hr_db . ".hr_base_amphur 
    //     WHERE amph_active != 2 AND amph_name = ?" . (!empty($this->amph_id) ? " AND amph_id != ?" : "");
	// 	if (!empty($this->amph_id)) {
	// 		$query = $this->hr->query($sql, array($this->amph_name, $this->amph_id));
	// 	} else {
	// 		$query = $this->hr->query($sql, array($this->amph_name));
	// 	}
	// 	return $query;
	// }
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_amphur
				WHERE amph_id=?";
		$query = $this->hr->query($sql, array($this->amph_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
