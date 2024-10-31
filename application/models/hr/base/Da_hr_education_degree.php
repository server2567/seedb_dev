<?php
/*
* Da_hr_education_degree
* Model for Manage about hr_base_education_degree Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_education_degree extends Hr_model {

	// PK is pf_id

	public $edudg_id ;
	public $edudg_name;
	public $edudg_abbr;
	public $edudg_name_en;
	public $edudg_abbr_en;
	public $edudg_active;
	public $edudg_create_user;
	public $edudg_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_education_degree (edudg_name, edudg_name_en,edudg_abbr,edudg_abbr_en,edudg_active,edudg_create_user,edudg_update_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->edudg_name, $this->edudg_name_en,$this->edudg_abbr,$this->edudg_abbr_en,$this->edudg_active,$this->edudg_create_user,$this->edudg_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_degree
				SET	edudg_name=?, edudg_name_en=?, edudg_abbr=?,edudg_abbr_en=? ,edudg_active=?,edudg_update_user=?
				WHERE edudg_id=?";
		$this->hr->query($sql, array($this->edudg_name, $this->edudg_name_en, $this->edudg_abbr,$this->edudg_abbr_en,$this->edudg_active,$this->edudg_update_user,$this->edudg_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_education_degree
				WHERE edudg_id=?";
		$this->hr->query($sql, array($this->edudg_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_education_degree
		        SET edudg_active=?
				WHERE edudg_id=?";
				$this->hr->query($sql, array($this->edudg_active,$this->edudg_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_education_degree 
        WHERE edudg_active != 2 AND edudg_name = ?" . (!empty($this->edudg_id) ? " AND edudg_id != ?" : "");
		if (!empty($this->edudg_id)) {
			$query = $this->hr->query($sql, array($this->edudg_name, $this->edudg_id));
		} else {
			$query = $this->hr->query($sql, array($this->edudg_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_education_degree
				WHERE edudg_id=?";
		$query = $this->hr->query($sql, array($this->edudg_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
