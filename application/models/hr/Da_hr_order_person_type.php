<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_order_person_type extends Hr_model
{

	// PK is ps_id

	public $ordt_id;
	public $ordt_dp_id;
	public $ordt_name;
	public $ordt_seq;
	public $ordt_active;
	public $ordt_menu_id;
	public $ordt_type_year;
	public $ordt_year;
	public $ordt_create_user;
	public $ordt_create;
	public $ordt_update_user;
	public $ordt_update;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_order_data_type (ordt_name,ordt_dp_id,ordt_menu_id,ordt_type_year,ordt_year,ordt_seq,ordt_active,ordt_create_user,ordt_create,ordt_update_user,ordt_update)
				VALUES(?, ?, ?, ?, ?, ?, ?,?)";
		$this->hr->query($sql, array($this->ordt_name, $this->ordt_dp_id,$this->ordt_menu_id,$this->ordt_type_year,$this->ordt_year, $this->ordt_seq, $this->ordt_active, $this->ordt_create_user, $this->ordt_create, $this->ordt_update_user, $this->ordt_update));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_order_data_type
				SET	ordt_name =?, ordt_seq=?, ordt_menu_id = ?,ordt_type_year = ? ,ordt_year =? ,ordt_active=?, ordt_update_user=? , ordt_update=?
				WHERE ordt_id=?";
		$this->hr->query($sql, array($this->ordt_name, $this->ordt_seq,$this->ordt_menu_id,$this->ordt_type_year,$this->ordt_year, $this->ordt_active, $this->ordt_update_user, $this->ordt_update, $this->ordt_id));
	}

	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_person
				WHERE ps_id=?";
		$this->hr->query($sql, array($this->ps_id));
	}
	function disabled()
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_order_data_type
				SET	ordt_active =?
				WHERE ordt_id=?";
		$this->hr->query($sql, array($this->ordt_active, $this->ordt_id));
	}
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_person
				WHERE ps_id=?";
		$query = $this->hr->query($sql, array($this->ps_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}
}	 //=== end class Da_hr_person
