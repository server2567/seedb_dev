<?php
/*
 * Da_hr_leave_approve_group
 * Model for Manage about hr_leave_approve_group Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_approve_group extends Hr_model
{
    // PK is lapg_id

    public $lapg_id;
    public $lapg_name;
    public $lapg_type;
    public $lapg_parent_id;
    public $lapg_stuc_id;
    public $lapg_active;
    public $lapg_desc;
    public $lapg_create_user;
    public $lapg_create_date;
    public $lapg_update_user;
    public $lapg_update_date;
   

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_approve_group 
                (lapg_name, lapg_type, lapg_parent_id, lapg_stuc_id, lapg_active, lapg_desc, lapg_create_user, lapg_create_date)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array($this->lapg_name, $this->lapg_type, $this->lapg_parent_id, $this->lapg_stuc_id, $this->lapg_active, $this->lapg_desc, $this->lapg_create_user, $this->lapg_create_date));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key lapg_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_approve_group
				SET lapg_name=?, lapg_type=?, lapg_parent_id=?, lapg_stuc_id=?, lapg_active=?, lapg_desc=?, lapg_update_user=?, lapg_update_date=?
				WHERE lapg_id=?";
        $this->hr->query($sql, array($this->lapg_name, $this->lapg_type, $this->lapg_parent_id, $this->lapg_stuc_id, $this->lapg_active, $this->lapg_desc, $this->lapg_update_user, $this->lapg_update_date, $this->lapg_id));
    }

    function delete()
    {
        // Delete the record by the primary key lapg_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_approve_group
				WHERE lapg_id=?";
        $this->hr->query($sql, array($this->lapg_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_approve_group
				WHERE lapg_id=?";
        $query = $this->hr->query($sql, array($this->lapg_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_approve_group
