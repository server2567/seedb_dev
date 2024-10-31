<?php
/*
* Da_hr_admin_position
* Model for Manage about hr_base_admin_position Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_admin_position extends Hr_model {

	// PK is pf_id

	public $admin_id ;
	public $admin_name;
	public $admin_name_en;
	public $admin_name_abbr;
	public $admin_name_abbr_en;
	public $admin_active;
	public $admin_create_user;
	public $damin_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_admin_position (admin_name, admin_name_en,admin_name_abbr,admin_name_abbr_en,admin_active,admin_create_user,admin_update_user)
				VALUES( ?, ?, ?,?,?,?,?)";
		$this->hr->query($sql, array($this->admin_name,$this->admin_name_en,$this->admin_name_abbr, $this->admin_name_abbr_en,$this->admin_active,$this->admin_create_user,$this->admin_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_admin_position
				SET	admin_name=?, admin_name_en=?, admin_name_abbr=?,admin_name_abbr_en=?,admin_active=?,admin_update_user =?
				WHERE admin_id=?";
		$this->hr->query($sql, array($this->admin_name, $this->admin_name_en,$this->admin_name_abbr,$this->admin_name_abbr_en ,$this->admin_active,$this->admin_update_user,$this->admin_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_admin_position
				WHERE admin_id=?";
		$this->hr->query($sql, array($this->admin_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_admin_position
		        SET admin_active=?
				WHERE admin_id=?";
				$this->hr->query($sql, array($this->admin_active,$this->admin_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_admin_position 
        WHERE admin_active != 2 AND admin_name = ?" . (!empty($this->admin_id) ? " AND admin_id != ?" : "");
		if (!empty($this->admin_id)) {
			$query = $this->hr->query($sql, array($this->admin_name, $this->admin_id));
		} else {
			$query = $this->hr->query($sql, array($this->admin_name));
		}
		return $query;
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_admin_position
				WHERE admin_id=?";
		$query = $this->hr->query($sql, array($this->admin_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
