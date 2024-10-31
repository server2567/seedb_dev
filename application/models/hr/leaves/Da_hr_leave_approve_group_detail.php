<?php
/*
 * Da_hr_leave_approve_group_detail
 * Model for Manage about hr_leave_approve_group_detail Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_approve_group_detail extends Hr_model
{
    // PK is lage_id

    public $lage_id;
    public $lage_lapg_id;
    public $lage_ps_id;
    public $lage_last_id;
    public $lage_desc;
    public $lage_stde_id;
    public $lage_seq;
    public $lage_create_user;
    public $lage_create_date;
    public $lage_update_user;
    public $lage_update_date;
   

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_approve_group_detail 
                (lage_lapg_id, lage_ps_id, lage_last_id, lage_desc, lage_stde_id, lage_seq, lage_create_user, lage_create_date)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array($this->lage_lapg_id, $this->lage_ps_id, $this->lage_last_id, $this->lage_desc, $this->lage_stde_id, $this->lage_seq, $this->lage_create_user, $this->lage_create_date));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key lage_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_approve_group_detail
				SET lage_lapg_id=?, lage_ps_id=?, lage_last_id=?, lage_desc=?, lage_stde_id=?, lage_seq=?, lage_update_user=?, lage_update_date=?
				WHERE lage_id=?";
        $this->hr->query($sql, array($this->lage_lapg_id, $this->lage_ps_id, $this->lage_last_id, $this->lage_desc, $this->lage_stde_id, $this->lage_seq, $this->lage_update_user, $this->lage_update_date, $this->lage_id));
    }

    function delete()
    {
        // Delete the record by the primary key lage_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_approve_group_detail
				WHERE lage_lapg_id=?";
        $this->hr->query($sql, array($this->lage_lapg_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_approve_group_detail
				WHERE lage_id=?";
        $query = $this->hr->query($sql, array($this->lage_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_approve_group_detail
