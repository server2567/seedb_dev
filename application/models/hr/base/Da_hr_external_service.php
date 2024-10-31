<?php
/*
* Da_hr_external_service
* Model for Manage about hr_base_external_service Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 19/09/2024
*/
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_external_service extends Hr_model {

	// PK is exts_id

	public $exts_id;
	public $exts_name_th;
	public $exts_name_en;
	public $exts_active;
	public $exts_create_user;
	public $exts_update_user;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->hr_db.".hr_base_external_service (exts_name_th, exts_name_en ,exts_active, exts_create_user, exts_update_user)
				VALUES(?, ?, ?, ?, ?)";
		$this->hr->query($sql, array($this->exts_name_th, $this->exts_name_en, $this->exts_active, $this->exts_create_user, $this->exts_update_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_external_service
				SET	exts_name_th=?, exts_name_en=?, exts_active=? ,exts_update_user=?
				WHERE exts_id=?";
		$this->hr->query($sql, array($this->exts_name_th, $this->exts_name_en, $this->exts_active, $this->exts_update_user, $this->exts_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->hr_db.".hr_base_external_service
				WHERE exts_id=?";
		$this->hr->query($sql, array($this->exts_id));
	}
	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->hr_db.".hr_base_external_service
		        SET exts_active=?
				WHERE exts_id=?";
				$this->hr->query($sql, array($this->exts_active,$this->exts_id));
	}
	function finding()
	{
		$sql = "SELECT * 
        FROM " . $this->hr_db . ".hr_base_external_service 
        WHERE exts_active != 2 AND exts_name_th = ?" . (!empty($this->exts_id) ? " AND exts_id != ?" : "");
		if (!empty($this->exts_id)) {
			$query = $this->hr->query($sql, array($this->exts_name_th, $this->exts_id));
		} else {
			$query = $this->hr->query($sql, array($this->exts_name_th));
		}
		return $query;
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_external_service
				WHERE exts_id=?";
		$query = $this->hr->query($sql, array($this->exts_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

}	 //=== end class Da_hr_prefix
?>
