<?php
/*
 * Da_hr_person_reward
 * Model for Manage hr_person_reward Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 30/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_reward extends Hr_model {

    // Public properties corresponding to table columns
    public $rewd_id;              // Primary key
    public $rewd_ps_id;
    public $rewd_rwt_id;
    public $rewd_rwlv_id;
    public $rewd_name_th;
    public $rewd_name_en;
    public $rewd_year;
    public $rewd_date;
    public $rewd_org_th;
    public $rewd_org_en;
    public $rewd_reward_file;
    public $rewd_cert_file;
    public $rewd_create_user;
    public $rewd_create_date;
    public $rewd_update_user;
    public $rewd_update_date;

    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_reward 
                (rewd_ps_id, rewd_rwt_id, rewd_rwlv_id, rewd_name_th, rewd_name_en, rewd_year, rewd_date, rewd_org_th, rewd_org_en, rewd_reward_file, rewd_cert_file, rewd_create_user, rewd_create_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->hr->query($sql, array(
            $this->rewd_ps_id, 
            $this->rewd_rwt_id, 
            $this->rewd_rwlv_id, 
            $this->rewd_name_th, 
            $this->rewd_name_en, 
            $this->rewd_year, 
            $this->rewd_date,
            $this->rewd_org_th, 
            $this->rewd_org_en, 
            $this->rewd_reward_file, 
            $this->rewd_cert_file, 
            $this->rewd_create_user, 
            $this->rewd_create_date
        ));
        
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_reward 
                SET rewd_ps_id=?, rewd_rwt_id=?, rewd_rwlv_id=?, rewd_name_th=?, rewd_name_en=?, rewd_year=?, rewd_date=?, rewd_org_th=?, rewd_org_en=?, rewd_reward_file=?, rewd_cert_file=?, rewd_update_user=?, rewd_update_date=?
                WHERE rewd_id=?";
        $query = $this->hr->query($sql, array(
            $this->rewd_ps_id, 
            $this->rewd_rwt_id, 
            $this->rewd_rwlv_id, 
            $this->rewd_name_th, 
            $this->rewd_name_en, 
            $this->rewd_year, 
            $this->rewd_date,
            $this->rewd_org_th, 
            $this->rewd_org_en, 
            $this->rewd_reward_file, 
            $this->rewd_cert_file, 
            $this->rewd_update_user, 
            $this->rewd_update_date, 
            $this->rewd_id
        ));
        
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_reward WHERE rewd_id=?";
        $query = $this->hr->query($sql, array($this->rewd_id));
     
        return $query;
    }

    /*
     * You have to assign primary key value before calling this function.
     */
    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * FROM ".$this->hr_db.".hr_person_reward WHERE rewd_id=?";
        $query = $this->hr->query($sql, array($this->rewd_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_reward
?>
