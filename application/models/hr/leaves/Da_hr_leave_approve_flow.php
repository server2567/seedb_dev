<?php
/*
 * Da_hr_leave_approve_flow
 * Model for Manage about hr_leave_approve_flow Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_approve_flow extends Hr_model
{
    // PK is lafw_id

    public $lafw_id;
    public $lafw_seq;
    public $lafw_ps_id;
    public $lafw_laps_id;
    public $lafw_lapg_id;
    public $lafw_lhis_id;
    public $lafw_last_id;
    public $lafw_status;
    public $lafw_comment;
    public $lafw_update_user;
    public $lafw_update_date;
   

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_approve_flow 
                (lafw_seq, lafw_ps_id, lafw_laps_id, lafw_lapg_id, lafw_lhis_id, lafw_last_id, lafw_status, lafw_comment, lafw_update_user, lafw_update_date)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array($this->lafw_seq, $this->lafw_ps_id, $this->lafw_laps_id, $this->lafw_lapg_id, $this->lafw_lhis_id, $this->lafw_last_id, $this->lafw_status, $this->lafw_comment, $this->lafw_update_user, $this->lafw_update_date));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key lafw_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_approve_flow
				SET lafw_seq=?, lafw_ps_id=?, lafw_laps_id=?, lafw_lapg_id=?, lafw_lhis_id=?, lafw_status=?, lafw_last_id=?, lafw_comment=?, lafw_update_user=?, lafw_update_date=?
				WHERE lafw_id=?";
        $this->hr->query($sql, array($this->lafw_seq, $this->lafw_ps_id, $this->lafw_laps_id, $this->lafw_lapg_id, $this->lafw_lhis_id, $this->lafw_status, $this->lafw_last_id, $this->lafw_comment, $this->lafw_update_user, $this->lafw_update_date, $this->lafw_id));
    }

    function delete()
    {
        // Delete the record by the primary key lafw_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_approve_flow
				WHERE lafw_id=?";
        $this->hr->query($sql, array($this->lafw_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_approve_flow
				WHERE lafw_id=?";
        $query = $this->hr->query($sql, array($this->lafw_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_approve_flow
