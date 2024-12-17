<?php
/*
 * Da_hr_person_position
 * Model for Managing hr_person_position Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_position extends Hr_model
{

    // PK is pos_id
    public $pos_id;
    public $pos_ps_id;
    public $pos_dp_id;
    public $pos_desc;
    public $pos_ps_code;
    public $pos_hire_id;
    public $pos_trial_day;
    public $pos_admin_id;
    public $pos_alp_id;
    public $pos_spcl_id;
    public $pos_retire_id;
    public $pos_status;
    public $pos_count_work;
    public $pos_out_desc;
    public $pos_attach_file;
    public $pos_work_start_date;
    public $pos_work_end_date;
    public $pos_active;
    public $pos_public_display;
    public $pos_create_user;
    public $pos_create_date;
    public $pos_update_user;
    public $pos_update_date;

    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }

    function insert()
    {
        // if there is no auto_increment field, please remove it
        if($this->pos_count_work == null){
            $this->pos_count_work = 1;
        }
        $sql = "INSERT INTO " . $this->hr_db . ".hr_person_position (
            pos_ps_id, pos_dp_id, pos_desc, pos_ps_code, 
            pos_hire_id, pos_admin_id, pos_alp_id, pos_spcl_id,
            pos_retire_id, pos_status, pos_public_display,pos_count_work, pos_out_desc, pos_attach_file, pos_work_start_date, 
            pos_work_end_date, pos_active, pos_create_user, 
            pos_create_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?)";
        $this->hr->query($sql, array(
            $this->pos_ps_id, $this->pos_dp_id, $this->pos_desc,
            $this->pos_ps_code, $this->pos_hire_id, $this->pos_admin_id,
            $this->pos_alp_id, $this->pos_spcl_id, $this->pos_retire_id, $this->pos_status, $this->pos_public_display,$this->pos_count_work, $this->pos_out_desc, $this->pos_attach_file,
            $this->pos_work_start_date, $this->pos_work_end_date,
            $this->pos_active, $this->pos_create_user,
            $this->pos_create_date
        ));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function update()
    {
        // if there is no primary key, please remove WHERE clause.
        $sql = "UPDATE " . $this->hr_db . ".hr_person_position
                SET pos_desc=?, 
                    pos_ps_code=?, pos_hire_id=?, pos_admin_id=?, 
                    pos_alp_id=?, pos_spcl_id=?, pos_retire_id=?, pos_status=?, pos_public_display=?,pos_count_work=?, pos_out_desc=?, pos_attach_file=?,
                    pos_work_start_date=?, pos_work_end_date=?, 
                    pos_active=?,
                    pos_update_user=?, pos_update_date=?
                WHERE pos_id=? AND pos_ps_id=? AND pos_dp_id=?";
        $this->hr->query($sql, array(
            $this->pos_desc,
            $this->pos_ps_code, $this->pos_hire_id, $this->pos_admin_id,
            $this->pos_alp_id, $this->pos_spcl_id, $this->pos_retire_id, $this->pos_status, $this->pos_public_display,$this->pos_count_work, $this->pos_out_desc, $this->pos_attach_file,
            $this->pos_work_start_date, $this->pos_work_end_date,
            $this->pos_active, $this->pos_update_user,
            $this->pos_update_date, $this->pos_id, $this->pos_ps_id, $this->pos_dp_id
        ));
    }

    function delete()
    {
        // if there is no primary key, please remove WHERE clause.
        $sql = "DELETE FROM " . $this->hr_db . ".hr_person_position
                WHERE pos_id=?";
        $this->hr->query($sql, array($this->pos_id));
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
                FROM " . $this->hr_db . ".hr_person_position
                WHERE pos_id=?";
        $query = $this->hr->query($sql, array($this->pos_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_position_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT *
                FROM " . $this->hr_db . ".hr_person_position
                LEFT JOIN " . $this->ums_db . ".ums_department as dp 
                ON dp.dp_id = pos_dp_id 
                WHERE pos_ps_id=? AND pos_dp_id=?";
        $query = $this->hr->query($sql, array($this->pos_ps_id, $this->pos_dp_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
    function insert_spcl_position($gp, $spcl_id, $us_id)
    {
        $sql = "INSERT INTO " . $this->hr_db . ".hr_person_special_position (pssp_pos_id, pssp_spcl_id,pssp_create_user, pssp_update_user)
				VALUES(?, ?, ?, ?)";
        $this->hr->query($sql, array($gp, $spcl_id, $us_id,$us_id));
        $this->last_insert_id = $this->hr->insert_id();
    }

    function insert_admin_position($gp, $spcl_id)
    {
        $sql = "INSERT INTO " . $this->hr_db . ".hr_person_admin_position (psap_pos_id, psap_admin_id)
		VALUES(?, ?)";
        $this->hr->query($sql, array($gp, $spcl_id));
        $this->last_insert_id = $this->hr->insert_id();
    }
}   //=== end class Da_hr_person_position
