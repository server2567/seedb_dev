<?php
/*
 * Da_hr_person_license
 * Model for Manage hr_person_license Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 29/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_license extends Hr_model {

    // Public properties corresponding to table columns
    public $licn_id;              // Primary key
    public $licn_code;
    public $licn_start_date;
    public $licn_end_date;
    public $licn_ps_id;
    public $licn_voc_id;
    public $licn_attach_file;
    public $licn_create_user;
    public $licn_create_date;
    public $licn_update_user;
    public $licn_update_date;

    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_license 
                (licn_code, licn_start_date, licn_end_date, licn_ps_id, licn_voc_id, licn_attach_file, licn_create_user, licn_create_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->hr->query($sql, array($this->licn_code, $this->licn_start_date, $this->licn_end_date, $this->licn_ps_id, $this->licn_voc_id, $this->licn_attach_file, $this->licn_create_user, $this->licn_create_date));
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_license 
                SET licn_code=?, licn_start_date=?, licn_end_date=?, licn_ps_id=?, licn_voc_id=?, licn_attach_file=?, licn_update_user=?, licn_update_date=?
                WHERE licn_id=?";
        $query = $this->hr->query($sql, array($this->licn_code, $this->licn_start_date, $this->licn_end_date, $this->licn_ps_id, $this->licn_voc_id, $this->licn_attach_file, $this->licn_update_user, $this->licn_update_date, $this->licn_id));
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_license
                WHERE licn_id=?";
        $query = $this->hr->query($sql, array($this->licn_id));
        return $query;
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_person_license 
                WHERE licn_id=?";
        $query = $this->hr->query($sql, array($this->licn_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_license
?>
