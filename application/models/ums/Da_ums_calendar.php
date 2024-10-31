<?php
/*
* Da_ums_manage_calendar
* Model for Manage about ums_manage_calendar Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 20/06/2024
*/
include_once("ums_model.php");

class Da_ums_calendar extends ums_model {

	// PK is clnd_id
	public $clnd_id;
	public $clnd_ps_id;
	public $clnd_topic;
	public $clnd_detail;
	public $clnd_clt_id;
	public $clnd_start_date;
	public $clnd_end_date;
	public $clnd_start_time;
	public $clnd_end_time;
	public $clnd_parent_id;
	public $clnd_create_user;
	public $clnd_create_date;
	public $clnd_update_user;
	public $clnd_update_date;
	public $last_insert_id;

	function __construct() {
		parent::__construct();
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->ums_db.".ums_calendar (clnd_ps_id,clnd_topic,clnd_detail,clnd_clt_id,clnd_start_date,clnd_end_date,clnd_start_time,clnd_end_time,clnd_parent_id,clnd_create_date,clnd_create_user)
				VALUES(?, ?, ?, ?,?,?,?,?,?,?,?)";
		$this->hr->query($sql, array($this->clnd_ps_id,$this->clnd_topic,$this->clnd_detail,$this->clnd_clt_id,$this->clnd_start_date,$this->clnd_end_date,$this->clnd_start_time,$this->clnd_end_time,$this->clnd_parent_id,$this->clnd_create_date,$this->clnd_create_user));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->ums_db.".ums_calendar
				SET	clnd_ps_id=?, clnd_topic=?, clnd_detail=?, clnd_clt_id = ?,clnd_start_date=?,clnd_end_date=?,clnd_start_time=?,clnd_end_time=?,clnd_parent_id=?,clnd_update_user=?,clnd_update_date=?
				WHERE clnd_id=?";
		$this->hr->query($sql, array($this->clnd_ps_id, $this->clnd_topic, $this->clnd_detail,$this->clnd_clt_id,$this->clnd_start_date,$this->clnd_end_date,$this->clnd_start_time,$this->clnd_end_time,$this->clnd_parent_id,$this->clnd_update_user,$this->clnd_update_date,$this->clnd_id));
	}

	function update_by_parent() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->ums_db.".ums_calendar
				SET	clnd_topic=?, clnd_detail=?, clnd_clt_id = ?,clnd_start_date=?,clnd_end_date=?,clnd_start_time=?,clnd_end_time=?,clnd_update_user=?,clnd_update_date=?
				WHERE clnd_ps_id=?, clnd_parent_id=?";
		$this->hr->query($sql, array($this->clnd_topic, $this->clnd_detail,$this->clnd_clt_id,$this->clnd_start_date,$this->clnd_end_date,$this->clnd_start_time,$this->clnd_end_time,$this->clnd_update_user,$this->clnd_update_date,$this->clnd_ps_id,$this->clnd_parent_id));
	}

	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->ums_db.".ums_calendar
				WHERE clnd_id=?";
		$this->hr->query($sql, array($this->clnd_id));
	}

	function delete_by_parent() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM ".$this->ums_db.".ums_calendar
				WHERE clnd_parent_id=?";
		$this->hr->query($sql, array($this->clnd_parent_id));
	}

	function disabled() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ".$this->ums_db.".ums_calendar
		        SET clnd_end_time=?
				WHERE clnd_id=?";
				$this->hr->query($sql, array($this->clnd_end_time,$this->clnd_id));
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->ums_db.".ums_calendar
				WHERE clnd_id=?";
		$query = $this->hr->query($sql, array($this->clnd_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

		/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_parent_key($withSetAttributeValue=FALSE) {
		$sql = "SELECT *
				FROM ".$this->ums_db.".ums_calendar
				WHERE clnd_ps_id=?, clnd_parent_id=?";
		$query = $this->hr->query($sql, array($this->clnd_ps_id, $this->clnd_parent_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_all_by_parent() {
		$sql = "SELECT *
				FROM ".$this->ums_db.".ums_calendar
				WHERE clnd_parent_id=?";
		$query = $this->hr->query($sql, array($this->clnd_parent_id));
		
		return $query;
		
	}

}	 //=== end class Da_ums_calendar
?>
