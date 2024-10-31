<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_matching_code extends Hr_model
{

    // PK is ps_id

    public $mc_id;
    public $mc_ps_id;
    public $mc_dp_id;
    public $mc_code;
    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // if there is no auto_increment field, please remove it
        $sql = "INSERT INTO " . $this->hr_db . ".hr_timework_matching_code (mc_ps_id, mc_dp_id, mc_code)
				VALUES(?, ?, ?)";
        $this->hr->query($sql, array($this->mc_ps_id, $this->mc_dp_id, $this->mc_code));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // if there is no primary key, please remove WHERE clause.
        $sql = "UPDATE " . $this->hr_db . ".hr_timework_matching_code
				SET	mc_ps_id=?, mc_dp_id=?, mc_code=?
				WHERE mc_id=?";
        $this->hr->query($sql, array($this->mc_ps_id, $this->mc_dp_id, $this->mc_code, $this->mc_id));
    }

    function delete()
    {
        // if there is no primary key, please remove WHERE clause.
        $sql = "DELETE FROM " . $this->hr_db . ".hr_person
				WHERE ps_id=?";
        $this->hr->query($sql, array($this->ps_id));
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
}     //=== end class Da_hr_person
