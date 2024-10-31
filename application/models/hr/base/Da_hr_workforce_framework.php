<?php
/*
* Da_hr_workforce_framework
* Model for Manage about hr_base_workforce_framework Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 10/09/2024
*/
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_workforce_framework extends Hr_model {

    // PK is bwfw_id

    public $bwfw_id;
    public $bwfw_name_th;
    public $bwfw_name_en;
    public $bwfw_is_medical;
    public $bwfw_type;
    public $bwfw_hour;
    public $bwfw_active;
    public $bwfw_create_user;
    public $bwfw_create_date;
    public $bwfw_update_user;
    public $bwfw_update_date;
    public $last_insert_id;

    function __construct() {
        parent::__construct();
    }

    // Insert new record
    function insert() {
        $sql = "INSERT INTO " . $this->hr_db . ".hr_base_workforce_framework (bwfw_name_th, bwfw_name_en, bwfw_is_medical, bwfw_type, bwfw_hour, bwfw_active, bwfw_create_user, bwfw_create_date)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $this->hr->query($sql, array(
            $this->bwfw_name_th,
            $this->bwfw_name_en,
            $this->bwfw_is_medical,
            $this->bwfw_type,
            $this->bwfw_hour,
            $this->bwfw_active,
            $this->bwfw_create_user,
            $this->bwfw_create_date
        ));
        $this->last_insert_id = $this->hr->insert_id();
    }

    // Update record
    function update() {
        $sql = "UPDATE " . $this->hr_db . ".hr_base_workforce_framework
                SET bwfw_name_th=?, bwfw_name_en=?, bwfw_is_medical=?, bwfw_type=?, bwfw_hour=?, bwfw_active=?, bwfw_update_user=?, bwfw_update_date=?
                WHERE bwfw_id=?";
        $this->hr->query($sql, array(
            $this->bwfw_name_th,
            $this->bwfw_name_en,
            $this->bwfw_is_medical,
            $this->bwfw_type,
            $this->bwfw_hour,
            $this->bwfw_active,
            $this->bwfw_update_user,
            $this->bwfw_update_date,
            $this->bwfw_id
        ));
    }

    // Delete record
    function delete() {
        $sql = "DELETE FROM " . $this->hr_db . ".hr_base_workforce_framework
                WHERE bwfw_id=?";
        $this->hr->query($sql, array($this->bwfw_id));
    }

    // Get by primary key
    function get_by_key($withSetAttributeValue = FALSE) {
        $sql = "SELECT *
                FROM " . $this->hr_db . ".hr_base_workforce_framework
                WHERE bwfw_id=?";
        $query = $this->hr->query($sql, array($this->bwfw_id));
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }

    // Disable (soft delete) the record
    function disabled() {
        $sql = "UPDATE " . $this->hr_db . ".hr_base_workforce_framework
                SET bwfw_active=?
                WHERE bwfw_id=?";
        $this->hr->query($sql, array($this->bwfw_active, $this->bwfw_id));
    }

    // Find record by name with additional conditions
    function finding() {
        $sql = "SELECT * 
                FROM " . $this->hr_db . ".hr_base_workforce_framework
                WHERE bwfw_active != 'N' AND bwfw_name_th = ?" . (!empty($this->bwfw_id) ? " AND bwfw_id != ?" : "");
        if (!empty($this->bwfw_id)) {
            $query = $this->hr->query($sql, array($this->bwfw_name_th, $this->bwfw_id));
        } else {
            $query = $this->hr->query($sql, array($this->bwfw_name_th));
        }
        return $query;
    }

} //=== end class Da_hr_workforce_framework
?>
