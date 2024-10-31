<?php
/*
 * da_hr_person_education
 * Model for managing the hr_person_education table.
 * Copyright (c) 2559. Information System Engineering Research Laboratory.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 2567-05-27
 */
include_once("hr_model.php");

class Da_hr_person_education extends Hr_model
{

    // Class properties
    public $edu_id;
    public $edu_ps_id;
    public $edu_edulv_id;
    public $edu_edudg_id;
    public $edu_edumj_id;
    public $edu_place_id;
    public $edu_country_id;
    public $edu_start_date;
    public $edu_end_date;
    public $edu_start_year;
    public $edu_end_year;
    public $edu_highest;
    public $edu_admid;
    public $edu_edumjt_id;
    public $edu_hon_id;
    public $edu_attach_file;
    public $edu_create_user;
    public $edu_create_date;
    public $edu_update_user;
    public $edu_update_date;
    public $edu_seq;
    public $last_insert_id;

    function __construct()
    {
        parent::__construct();
    }


    function insert()
    {
        $sql = "INSERT INTO " . $this->hr_db . ".hr_person_education" . " 
                (edu_ps_id, edu_edulv_id, edu_edudg_id, edu_edumj_id, edu_place_id, edu_country_id, 
                edu_start_date, edu_end_date, edu_start_year, edu_end_year, edu_highest, edu_admid, 
                edu_edumjt_id, edu_hon_id, edu_attach_file, edu_create_user, edu_create_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $this->edu_ps_id,
            $this->edu_edulv_id,
            $this->edu_edudg_id,
            $this->edu_edumj_id,
            $this->edu_place_id,
            $this->edu_country_id,
            $this->edu_start_date,
            $this->edu_end_date,
            $this->edu_start_year,
            $this->edu_end_year,
            $this->edu_highest,
            $this->edu_admid,
            $this->edu_edumjt_id,
            $this->edu_hon_id,
            $this->edu_attach_file,
            $this->edu_create_user,
            $this->edu_create_date
        ];
        $this->hr->query($sql, $params);
        $this->last_insert_id = $this->hr->insert_id();
        // Step 2: Update edu_seq for the given edu_ps_id
        $maxSeqSql = "
        SELECT MAX(edu_seq) AS max_seq
        FROM " . $this->hr_db . ".hr_person_education
        WHERE edu_ps_id = ?
        ";
        $result = $this->hr->query($maxSeqSql, [$this->last_insert_id]);
        $max_seq = $result->row();
        if($max_seq){
            $seq = $max_seq->max_seq == null ? 1: $max_seq->max_seq+ 1;
        }
        // Step 2: Update sequences based on the fetched maximum sequence
        $updateSeqSql = "
                UPDATE " . $this->hr_db . ".hr_person_education
                 SET edu_seq=?  WHERE edu_id=?
            ";
        $this->hr->query($updateSeqSql, [$seq, $this->last_insert_id]);
    }

    function update()
    {
        $sql = "UPDATE " . $this->hr_db . ".hr_person_education" . " 
                SET edu_ps_id=?, edu_edulv_id=?, edu_edudg_id=?, edu_edumj_id=?, edu_place_id=?, edu_country_id=?, 
                edu_start_date=?, edu_end_date=?, edu_start_year=?, edu_end_year=?, edu_highest=?, edu_admid=?, 
                edu_edumjt_id=?, edu_hon_id=?, edu_attach_file=?, edu_create_user=?, edu_create_date=?, 
                edu_update_user=?, edu_update_date=?
                WHERE edu_id=?";
        $params = [
            $this->edu_ps_id,
            $this->edu_edulv_id,
            $this->edu_edudg_id,
            $this->edu_edumj_id,
            $this->edu_place_id,
            $this->edu_country_id,
            $this->edu_start_date,
            $this->edu_end_date,
            $this->edu_start_year,
            $this->edu_end_year,
            $this->edu_highest,
            $this->edu_admid,
            $this->edu_edumjt_id,
            $this->edu_hon_id,
            $this->edu_attach_file,
            $this->edu_create_user,
            $this->edu_create_date,
            $this->edu_update_user,
            $this->edu_update_date,
            $this->edu_id
        ];
        $this->hr->query($sql, $params);
    }
    function update_seq()
    {
        $sql = "UPDATE " . $this->hr_db . ".hr_person_education" . " 
                SET edu_seq=?
                WHERE edu_id=?";
        $params = [
            $this->edu_seq,
            $this->edu_id
        ];
        $this->hr->query($sql, $params);
    }
    function delete()
    {
        $sql = "DELETE FROM " . $this->hr_db . ".hr_person_education" . " WHERE edu_id=?";
        $this->hr->query($sql, [$this->edu_id]);
    }

    function get_by_key($withSetAttributeValue = FALSE)
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_person_education" . " WHERE edu_id=?";
        $query = $this->hr->query($sql, [$this->edu_id]);
        if ($withSetAttributeValue) {
            $this->row2attribute($query->row());
        } else {
            return $query;
        }
    }
} // End class Da_hr_person_education
