<?php
/*
 * Da_hr_person_expert
 * Model for Manage hr_person_expert Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 30/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_expert extends Hr_model {

    // Public properties corresponding to table columns
    public $expt_id;              // Primary key
    public $expt_ps_id;
    public $expt_detail_th;
    public $expt_detail_en;
    public $expt_title_th;
    public $expt_title_en;
    public $expt_create_user;
    public $expt_create_date;
    public $expt_update_user;
    public $expt_update_date;

    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_expert 
                (expt_ps_id, expt_detail_th, expt_detail_en, expt_title_th, expt_title_en, expt_create_user, expt_create_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->hr->query($sql, array($this->expt_ps_id, $this->expt_detail_th, $this->expt_detail_en, $this->expt_title_th, $this->expt_title_en, $this->expt_create_user, $this->expt_create_date));
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
       
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_expert 
                SET expt_ps_id=?, expt_detail_th=?, expt_detail_en=?, expt_title_th=?, expt_title_en=?, expt_update_user=?, expt_update_date=?
                WHERE expt_id=?";
        $query = $this->hr->query($sql, array($this->expt_ps_id, $this->expt_detail_th, $this->expt_detail_en, $this->expt_title_th, $this->expt_title_en, $this->expt_update_user, $this->expt_update_date, $this->expt_id));
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_expert
                WHERE expt_id=?";
        $query = $this->hr->query($sql, array($this->expt_id));
        return $query;
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_person_expert 
                WHERE expt_id=?";
        $query = $this->hr->query($sql, array($this->expt_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_expert
?>
