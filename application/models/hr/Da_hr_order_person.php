<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_order_person extends Hr_model
{

	// PK is ps_id

	public $ord_id;
	public $ord_ps_id;
	public $ord_ordt_id;
	public $ord_name;
	public $ord_seq;
	public $ord_active;
	public $ord_create_user;
	public $ord_create;
	public $ord_update_user;
	public $ord_update;
	public $last_insert_id;

	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_order_data (ord_ps_id,ord_ordt_id,ord_seq,ord_active,ord_create_user,ord_create,ord_update_user,ord_update)
				VALUES(?, ?, ?, ?, ?, ?, ?,?)";
		$this->hr->query($sql, array($this->ord_ps_id, $this->ord_ordt_id, $this->ord_seq, $this->ord_active, $this->ord_create_user, $this->ord_create, $this->ord_update_user, $this->ord_update));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_order_data_type
				SET	ordt_name =?, ord_seq=?, ordt_active=?, ordt_update_user=? , ordt_update=?
				WHERE ordt_id=?";
		$this->hr->query($sql, array($this->ord_name, $this->ord_seq, $this->ord_active, $this->ord_update_user, $this->ord_update, $this->ord_id));
	}

	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_person
				WHERE ps_id=?";
		$this->hr->query($sql, array($this->ps_id));
	}
	function delete_before_insert()
	{
		$sql = "DELETE FROM " . $this->hr_db . ".hr_order_data
				WHERE ord_ordt_id=?";
		$this->hr->query($sql, array($this->ord_ordt_id));
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
	function update_order_data_after_insert_person($dp_id)
	{
		$sql = "INSERT INTO  " . $this->hr_db . ".hr_order_data (ord_ps_id, ord_seq, ord_active, ord_create_user, ord_update_user, ord_ordt_id)
               SELECT 
                    ? as ord_ps_id,
               COALESCE((SELECT MAX(ord_seq) FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = ordt.ordt_id), 0) + 1 as ord_seq,
               ? as ord_active,
               ? as ord_create_user,
               ? as ord_update_user,
               ordt.ordt_id
            FROM " . $this->hr_db . ".hr_order_data_type as ordt WHERE ordt.ordt_dp_id = '$dp_id';";
		$this->hr->query($sql, array($this->ord_ps_id, $this->ord_active, $this->ord_create_user, $this->ord_update_user));
	}

	function update_order_data_after_delete_department($ps_id, $dp_id)
	{
		$sql1 = "SELECT *  FROM " . $this->hr_db . ".hr_order_data as ord 
			LEFT JOIN " . $this->hr_db . ".hr_order_data_type as ordt
					ON ord.ord_ordt_id = ordt.ordt_id 
		    where ordt.ord_ps_id = '$ps_id' AND ordt.ordt_dp_id = '$dp_id'";
		$this->hr->query($sql1);
	}
}	 //=== end class Da_hr_person
