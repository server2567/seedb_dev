<?php
/*
 * Da_hr_leave_history_detail
 * Model for Manage about hr_leave_history_detail Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 24/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_history_detail extends Hr_model
{
    // PK is lhde_id

    public $lhde_id;
    public $lhde_lhis_id;
    public $lhde_clnd_id;
    public $lhde_date;
    public $lhde_start_time;
    public $lhde_end_time;
    public $lhde_num_hour;
    public $lhde_num_minute;
    public $lhde_sum_minutes;
    public $lhde_type_day;
    public $lhde_seq;


    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_history_detail 
                (lhde_lhis_id, lhde_clnd_id, lhde_date, lhde_start_time, lhde_end_time, lhde_num_hour, lhde_num_minute, lhde_sum_minutes, lhde_type_day, lhde_seq)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array($this->lhde_lhis_id, $this->lhde_clnd_id, $this->lhde_date, $this->lhde_start_time, $this->lhde_end_time, $this->lhde_num_hour, $this->lhde_num_minute, $this->lhde_sum_minutes, $this->lhde_type_day, $this->lhde_seq));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key lhde_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_history_detail
				SET lhde_lhis_id=?, lhde_clnd_id=?, lhde_date=?, lhde_start_time=?, lhde_end_time=?, lhde_num_hour=?, lhde_num_minute=?, lhde_sum_minutes=?, lhde_type_day=?, lhde_seq=?
				WHERE lhde_id=?";
        $this->hr->query($sql, array($this->lhde_lhis_id, $this->lhde_clnd_id, $this->lhde_date, $this->lhde_start_time, $this->lhde_end_time, $this->lhde_num_hour, $this->lhde_num_minute, $this->lhde_sum_minutes, $this->lhde_type_day, $this->lhde_seq, $this->lhde_id));
    }

    function delete()
    {
        // Delete the record by the primary key lhde_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_history_detail
				WHERE lhde_id=?";
        $this->hr->query($sql, array($this->lhde_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_history_detail
				WHERE lhde_lhis_id=?";
        $query = $this->hr->query($sql, array($this->lhde_lhis_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_history_detail
