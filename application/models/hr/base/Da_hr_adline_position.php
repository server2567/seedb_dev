<?php
/*
* Da_hr_adline_position
* Model for Manage about hr_base_adline_position Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_adline_position extends Hr_model {

	// PK is pf_id

	public $alp_id ;
	public $alp_name;
	public $alp_name_en;
	public $alp_name_abbr;
	public $alp_name_abbr_en;
	public $alp_active;
	public $alp_create_user;
	public $alp_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_adline_position (alp_name, alp_name_en,alp_name_abbr,alp_name_abbr_en,alp_active,alp_create_user,alp_update_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->alp_name,$this->alp_name_en,$this->alp_name_abbr, $this->alp_name_abbr_en,$this->alp_active,$this->alp_create_user,$this->alp_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_adline_position
				SET	alp_name=?, alp_name_en=?, alp_name_abbr=?,alp_name_abbr_en=?,alp_active=?,alp_update_user=?
				WHERE alp_id=?";
		$this->hr->query($sql, array($this->alp_name, $this->alp_name_en,$this->alp_name_abbr,$this->alp_name_abbr_en ,$this->alp_active,$this->alp_update_id,$this->alp_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_adline_position
				WHERE alp_id=?";
		$this->hr->query($sql, array($this->alp_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_adline_position
		        SET alp_active=?
				WHERE alp_id=?";
				$this->hr->query($sql, array($this->alp_active,$this->alp_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_adline_position 
        WHERE alp_active != 2 AND alp_name = ?" . (!empty($this->alp_id) ? " AND alp_id != ?" : "");
		if (!empty($this->alp_id)) {
			$query = $this->hr->query($sql, array($this->alp_name, $this->alp_id));
		} else {
			$query = $this->hr->query($sql, array($this->alp_name));
		}
		return $query;
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_adline_position
				WHERE alp_id=?";
		$query = $this->hr->query($sql, array($this->alp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
