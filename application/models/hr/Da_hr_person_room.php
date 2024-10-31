<?php
/*
 * Da_hr_person_room
 * Model for Manage hr_person_room Table.
 * @Author Areerat Pongurai
 * @Create Date 22/08/2024
 */
include_once("hr_model.php");

class Da_hr_person_room extends Hr_model {

    public $psrm_id;              // Primary key
    public $psrm_ps_id;
    public $psrm_rm_id;
    public $psrm_date;
    
    public $eqs_db;

    public $last_insert_id;

    function __construct() {
        parent::__construct();
        $this->eqs_db = $this->load->database('eqs', TRUE)->database;
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_room 
                (psrm_ps_id, psrm_rm_id, psrm_date) 
                VALUES (?, ?, ?)";
        $query = $this->hr->query($sql, array($this->psrm_ps_id, $this->psrm_rm_id, $this->psrm_date));
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
       
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_room 
                SET psrm_ps_id=?, psrm_rm_id=?, psrm_date=?
                WHERE psrm_id=?";
        $query = $this->hr->query($sql, array($this->psrm_ps_id, $this->psrm_rm_id, $this->psrm_date, $this->psrm_id));
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_room
                WHERE psrm_id=?";
        $query = $this->hr->query($sql, array($this->expt_id));
        return $query;
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_person_room 
                WHERE psrm_id=?";
        $query = $this->hr->query($sql, array($this->expt_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_room
?>
