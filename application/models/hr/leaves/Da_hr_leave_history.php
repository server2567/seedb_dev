<?php
/*
 * Da_hr_leave_history
 * Model for Manage about hr_leave_history Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 24/10/2024
 */
include_once(dirname(__FILE__)."/../hr_model.php");

class Da_hr_leave_history extends Hr_model
{
    // PK is lhis_id

    public $lhis_id;
    public $lhis_ps_id;
    public $lhis_leave_id;
    public $lhis_start_date;
    public $lhis_end_date;
    public $lhis_num_day;
    public $lhis_num_hour;
    public $lhis_num_minute;
    public $lhis_sum_minutes;
    public $lhis_year;
    public $lhis_topic;
    public $lhis_address;
    public $lhis_write_place;
    public $lhis_write_date;
    public $lhis_replace_id;
    public $lhis_status;
    public $lhis_attach_file;
    public $lhis_tell;
    public $lhis_create_user;
    public $lhis_create_date;

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // Insert all the relevant fields into the database
        $sql = "INSERT INTO " . $this->hr_db . ".hr_leave_history 
                (lhis_ps_id, lhis_leave_id, lhis_start_date, lhis_end_date, lhis_num_day, lhis_num_hour, lhis_num_minute, lhis_sum_minutes, lhis_year, lhis_topic, lhis_address, lhis_write_place, lhis_write_date, lhis_replace_id, lhis_status, lhis_attach_file, lhis_tell, lhis_create_user, lhis_create_date)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array($this->lhis_ps_id, $this->lhis_leave_id, $this->lhis_start_date, $this->lhis_end_date, $this->lhis_num_day, $this->lhis_num_hour, $this->lhis_num_minute, $this->lhis_sum_minutes, $this->lhis_year, $this->lhis_topic, $this->lhis_address, $this->lhis_write_place, $this->lhis_write_date, $this->lhis_replace_id, $this->lhis_status, $this->lhis_attach_file, $this->lhis_tell, $this->lhis_create_user, $this->lhis_create_date));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // Update all relevant fields based on the primary key lhis_id
        $sql = "UPDATE " . $this->hr_db . ".hr_leave_history
				SET lhis_ps_id=?, lhis_leave_id=?, lhis_start_date=?, lhis_end_date=?, lhis_num_day=?, lhis_num_hour=?, lhis_num_minute=?, lhis_sum_minutes=?, lhis_year=?, lhis_topic=?, lhis_address=?, lhis_write_place=?, lhis_write_date=?, lhis_replace_id=?, lhis_status=?, lhis_attach_file=?, lhis_tell=?, lhis_create_user=?, lhis_create_date=?
				WHERE lhis_id=?";
        $this->hr->query($sql, array($this->lhis_ps_id, $this->lhis_leave_id, $this->lhis_start_date, $this->lhis_end_date, $this->lhis_num_day, $this->lhis_num_hour, $this->lhis_num_minute, $this->lhis_sum_minutes, $this->lhis_year, $this->lhis_topic, $this->lhis_address, $this->lhis_write_place, $this->lhis_write_date, $this->lhis_replace_id, $this->lhis_status, $this->lhis_attach_file, $this->lhis_tell, $this->lhis_create_user, $this->lhis_create_date, $this->lhis_id));
    }

    function delete()
    {
        // Delete the record by the primary key lhis_id
        $sql = "DELETE FROM " . $this->hr_db . ".hr_leave_history
				WHERE lhis_id=?";
        $this->hr->query($sql, array($this->lhis_id));
    }

    /*
	 * You have to assign primary key value before calling this function.
	 */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_leave_history
				WHERE lhis_id=?";
        $query = $this->hr->query($sql, array($this->lhis_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
}     //=== end class Da_hr_leave_history
