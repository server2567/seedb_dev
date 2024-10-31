<?php
/*
 * Da_hr_person_work_history
 * Model for Manage hr_person_work_history Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 29/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_work_history extends Hr_model {

    // Public properties corresponding to table columns
    public $wohr_id;              // Primary key
    public $wohr_ps_id;
    public $wohr_detail_th;
    public $wohr_detail_en;
    public $wohr_start_date;
    public $wohr_end_date;
    public $wohr_admin_id;
    public $wohr_alp_id;
    public $wohr_stuc_id;
    public $wohr_stde_id;
    public $wohr_stde_name_th;
    public $wohr_place_name;
    public $wohr_create_user;
    public $wohr_create_date;
    public $wohr_update_user;
    public $wohr_update_date;

    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_work_history 
                (wohr_ps_id, wohr_detail_th, wohr_detail_en, wohr_start_date, wohr_end_date, 
                wohr_create_user, wohr_create_date, wohr_admin_id, wohr_alp_id, wohr_stuc_id, 
                wohr_stde_id, wohr_stde_name_th, wohr_place_name) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->hr->query($sql, array(
            $this->wohr_ps_id, $this->wohr_detail_th, $this->wohr_detail_en, $this->wohr_start_date,
            $this->wohr_end_date, $this->wohr_create_user, $this->wohr_create_date, $this->wohr_admin_id,
            $this->wohr_alp_id, $this->wohr_stuc_id, $this->wohr_stde_id, $this->wohr_stde_name_th,
            $this->wohr_place_name
        ));
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_work_history 
                SET wohr_ps_id=?, wohr_detail_th=?, wohr_detail_en=?, wohr_start_date=?, wohr_end_date=?, 
                wohr_update_user=?, wohr_update_date=?, wohr_admin_id=?, wohr_alp_id=?, wohr_stuc_id=?, 
                wohr_stde_id=?, wohr_stde_name_th=?, wohr_place_name=?
                WHERE wohr_id=?";
        $query = $this->hr->query($sql, array(
            $this->wohr_ps_id, $this->wohr_detail_th, $this->wohr_detail_en, $this->wohr_start_date,
            $this->wohr_end_date, $this->wohr_update_user, $this->wohr_update_date, $this->wohr_admin_id,
            $this->wohr_alp_id, $this->wohr_stuc_id, $this->wohr_stde_id, $this->wohr_stde_name_th,
            $this->wohr_place_name, $this->wohr_id
        ));
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_work_history
                WHERE wohr_id=?";
        $query = $this->hr->query($sql, array($this->wohr_id));
        return $query;
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_person_work_history 
                WHERE wohr_id=?";
        $query = $this->hr->query($sql, array($this->wohr_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_work_history
?>
