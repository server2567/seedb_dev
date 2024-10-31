<?php
/*
 * M_line_patient
 * Model for Manage about hr_person Table.
 * @Author Tanadon
 * @Create Date 2567-07-17
 */
include_once("Da_line_patient.php");

class M_line_patient extends Da_line_patient
{

   /*
    * get_all_by_status
    * @input -
    * @output person data line by status
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function get_all_by_status(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_status = 'Y' ";
      $query = $this->line->query($sql);
      return $query;
    }

    /*
    * get_by_person_id
    * @input lpt_pt_id
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-06-14
    */
    function get_by_person_id(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_pt_id = ?";
      $query = $this->line->query($sql,array($this->lpt_pt_id));
      return $query;
    }

    /*
    * get_person_by_send_message
    * @input lpt_pt_id
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-11-30
    */
    function get_person_by_send_message(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_pt_id = ? AND lpt_status = 'Y' ";
      $query = $this->line->query($sql,array($this->lpt_pt_id));
      return $query;
    }
    
    /*
    * get_by_person_line_id
    * @input lpt_user_line_id
    * @output person data by line id
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function get_by_person_line_id(){
        $sql = "SELECT *
            FROM ".$this->line_db.".line_patient
            WHERE lpt_user_line_id = ?";
        $query = $this->line->query($sql,array($this->lpt_user_line_id));
        return $query;
    }

       /*
    * get_by_person_line_id_pt_id
    * @input lpt_user_line_id
    * @output person data by line id
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function get_by_person_line_id_pt_id(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_user_line_id = ? AND lpt_pt_id = ?";
      $query = $this->line->query($sql,array($this->lpt_user_line_id, $this->lpt_pt_id));
      return $query;
  }

    /*
    * get_by_person_line_id_login
    * @input lpt_user_line_id
    * @output person data by line id
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function get_by_person_line_id_login(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_user_line_id = ? AND lpt_status = 'Y' ";
      $query = $this->line->query($sql,array($this->lpt_user_line_id));
      return $query;
    }

     /*
    * get_detail_person_id
    * @input lpt_pt_id
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-06-14
    */
    function get_detail_person_id(){
      $sql = "SELECT pt_id, pt_member, pt_save, pt_identification, pt_passport, pt_peregrine, pt_prefix, pt_fname, pt_lname, pt_tel, pt_email, pt_privacy
          FROM ".$this->line_db.".line_patient
          LEFT JOIN " . $this->ums_db . ".ums_patient ON pt_id = lpt_pt_id
          WHERE lpt_pt_id = ? AND pt_sta_id = 1";
      $query = $this->line->query($sql,array($this->lpt_pt_id));
      return $query;
    }

     /*
    * get_detail_person_line_id
    * @input lpt_pt_id
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-06-14
    */
    function get_detail_person_line_id(){
      $sql = "SELECT UsID, UsPsCode
          FROM ".$this->line_db.".line_patient
          LEFT JOIN " . $this->ums_db . ".umuser ON UsPsCode = lpt_pt_id
          WHERE lpt_user_line_id = ? AND lpt_status = 'Y'";
      $query = $this->line->query($sql,array($this->lpt_user_line_id));
      return $query;
    }

   /*
    * get_gear_person_id
    * @input lpt_pt_id
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-09-23
    */
    function get_gear_person_id(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          LEFT JOIN " . $this->hr_db . ".hr_person ON ps_id = lpt_pt_id
          LEFT JOIN " . $this->hr_db . ".hr_major_type ON mjt_id = ps_mjt_id
          WHERE lpt_pt_id = ? AND lpt_status = 'Y'";
      $query = $this->line->query($sql,array($this->lpt_pt_id));
      return $query;
   }

    /*
    * update_status
    * @input lpt_user_line_id
    * @output update status login and logout
    * @author Tanadon
    * @Create Date 2567-06-14
    */
    function update_status() {
      $sql = "UPDATE ".$this->line_db.".line_patient
          SET	lpt_status=?
          WHERE lpt_user_line_id=?";
      $this->line->query($sql, array($this->lpt_status, $this->lpt_user_line_id));
	  } // end update_status

     /*
    * update_status
    * @input update_person_line_id
    * @output update lind id of person
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function update_person_line_id() {
      $sql = "UPDATE ".$this->line_db.".line_patient
          SET	lpt_user_line_id=?
          WHERE lpt_pt_id=?";
      $this->line->query($sql, array($this->lpt_user_line_id, $this->lpt_pt_id));
	  } // end update_status


    /*
    * update_for_login
    * @input 
    * @output update for login 
    * @author Tanadon
    * @Create Date 2567-06-15
    */
    function update_for_login() {
      $sql = "UPDATE ".$this->line_db.".line_patient
          SET	lpt_status=?, lpt_update_user=?, lpt_update_date=?
          WHERE lpt_id=?";
      $this->line->query($sql, array($this->lpt_status, $this->lpt_update_user, $this->lpt_update_date, $this->lpt_id));
	  } // end update_status


     /*
    * get_count_person_line
    * @input -
    * @output person data by id
    * @author Tanadon
    * @Create Date 2567-06-14
    */
    function get_count_person_line(){
      $sql = "SELECT *
          FROM ".$this->line_db.".line_patient
          WHERE lpt_status = 'Y' ";
      $query = $this->line->query($sql);
      return $query;
    }

  

}