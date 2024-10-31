<?php
/*
 * Da_hr_leave_approve_person
 * Model for Manage about hr_leave_approve_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_approve_person extends Hr_model
{
    // PK is laps_id

    public $laps_id;
    public $laps_lapg_id;
    public $laps_ps_id;
    public $laps_create_user;
    public $laps_create_date;
    public $laps_update_user;
    public $laps_update_date;
   

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_approve_person 
                (laps_lapg_id, laps_ps_id, laps_create_user, laps_create_date)
				VALUES (?, ?, ?, ?)";
        $this->hr->query($sql, array($this->laps_lapg_id, $this->laps_ps_id, $this->laps_create_user, $this->laps_create_date));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key laps_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_approve_person
				SET laps_lapg_id=?, laps_ps_id=?, laps_update_user=?, laps_update_date=?
				WHERE laps_id=?";
        $this->hr->query($sql, array($this->laps_lapg_id, $this->laps_ps_id, $this->laps_update_user, $this->laps_update_date, $this->laps_id));
    }

    function delete()
    {
        // Delete the record by the primary key laps_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_approve_person
				WHERE laps_lapg_id=?";
        $this->hr->query($sql, array($this->laps_lapg_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_approve_person
				WHERE laps_ps_id=?";
        $query = $this->hr->query($sql, array($this->laps_ps_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_approve_person
