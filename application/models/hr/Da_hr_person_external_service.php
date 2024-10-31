<?php
/*
 * Da_hr_person_external_service
 * Model for managing the hr_person_external_service Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 29/05/2024
 */
include_once("hr_model.php");

class Da_hr_person_external_service extends Hr_model {

    // Public properties corresponding to table columns
    public $pexs_id;              // Primary key
    public $pexs_name_th;         // Thai name of the service
    public $pexs_exts_id;         // External service ID
    public $pexs_date;            // Date of the service
    public $pexs_place_id;        // Place ID
    public $pexs_attach_file;     // Attached file name
    public $pexs_create_user;     // User who created the record
    public $pexs_create_date;     // Date when the record was created
    public $pexs_update_user;     // User who last updated the record
    public $pexs_update_date;     // Timestamp of the last update
    public $pexs_ps_id;           // Person ID associated with the external service (New Column)

    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    function insert() {
        $sql = "INSERT INTO ".$this->hr_db.".hr_person_external_service 
                (pexs_name_th, pexs_exts_id, pexs_date, pexs_place_id, pexs_attach_file, pexs_create_user, pexs_create_date, pexs_ps_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->hr->query($sql, array($this->pexs_name_th, $this->pexs_exts_id, $this->pexs_date, $this->pexs_place_id, $this->pexs_attach_file, $this->pexs_create_user, $this->pexs_create_date, $this->pexs_ps_id));
        $this->last_insert_id = $this->hr->insert_id();
        return $query;
    }

    function update() {
        $sql = "UPDATE ".$this->hr_db.".hr_person_external_service 
                SET pexs_name_th=?, pexs_exts_id=?, pexs_date=?, pexs_place_id=?, pexs_attach_file=?, pexs_update_user=?, pexs_update_date=?, pexs_ps_id=?
                WHERE pexs_id=?";
        $query = $this->hr->query($sql, array($this->pexs_name_th, $this->pexs_exts_id, $this->pexs_date, $this->pexs_place_id, $this->pexs_attach_file, $this->pexs_update_user, $this->pexs_update_date, $this->pexs_ps_id, $this->pexs_id));
        return $query;
    }

    function delete() {
        $sql = "DELETE FROM ".$this->hr_db.".hr_person_external_service
                WHERE pexs_id=?";
        $query = $this->hr->query($sql, array($this->pexs_id));
        return $query;
    }

    function get_by_key($withSetAttributeValue = FALSE) {    
        $sql = "SELECT * 
                FROM ".$this->hr_db.".hr_person_external_service 
                WHERE pexs_id=?";
        $query = $this->hr->query($sql, array($this->pexs_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

}   // End class Da_hr_person_external_service
?>
