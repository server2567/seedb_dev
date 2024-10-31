<?php
/*
 * Da_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("hr_model.php");

class Da_hr_develop extends Hr_model
{

  // PK is ps_id

  public $dev_id;
  public $dev_topic;
  public $dev_desc;
  public $dev_start_date;
  public $dev_date;
  public $dev_end_date;
  public $dev_end_time;
  public $dev_hour;
  public $dev_place;
  public $dev_pv_id;
  public $dev_country_id;
  public $dev_project;
  public $dev_budget;
  public $dev_allowance;
  public $dev_accommodation;
  public $dev_budget_vat;
  public $dev_allowance_vat;
  public $dev_accommodation_vat;
  public $dev_budget_type_other;
  public $dev_budget_type_other_vat;
  public $dev_objecttive;
  public $dev_short_content;
  public $dev_benefits;
  public $dev_certificate;
  public $dev_status;
  public $dev_type;
  public $dev_go_service_type;
  public $dev_organized_type;
  public $dev_attach_file;
  public $dev_create_user;
  public $dev_create_date;
  public $dev_update_user;
  public $dev_update_date;
  public $last_insert_id;

  function __construct()
  {
    parent::__construct();
  }


  // if there is no auto_increment field, please remove it
  function insert()
  {
    // คำสั่ง INSERT INTO เพื่อเพิ่มข้อมูลใหม่ลงในฐานข้อมูล
    $sql = "INSERT INTO " . $this->hr_db . ".hr_dev_develop
            (
                dev_topic,
                dev_desc,
                dev_start_date,
                dev_end_date,
                dev_end_time,
                dev_hour,
                dev_place,
                dev_country_id,
                dev_pv_id,
                dev_project,
                dev_budget,
                dev_allowance,
                dev_accommodation,
                dev_budget_type_other,
                 dev_budget_vat,
                dev_allowance_vat,
                dev_accommodation_vat,
                dev_budget_type_other_vat,
                dev_objecttive,
                dev_short_content,
                dev_benefits,
                dev_status,
                dev_type,
                dev_go_service_type,
                dev_certificate,
                dev_create_user,
                dev_organized_type
            )
            VALUES (?, ?, ?,?, ?,?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // ส่งข้อมูลที่ต้องการเพิ่มลงไปในคำสั่ง INSERT
    $this->hr->query($sql, array(
      $this->dev_topic,
      $this->dev_desc,
      $this->dev_start_date,
      $this->dev_end_date,
      $this->dev_end_time,
      $this->dev_hour,
      $this->dev_place,
      $this->dev_country_id,
      $this->dev_pv_id,
      $this->dev_project,
      $this->dev_budget,
      $this->dev_allowance,
      $this->dev_accommodation,
      $this->dev_budget_type_other,
      $this->dev_budget_vat,
      $this->dev_allowance_vat,
      $this->dev_accommodation_vat,
      $this->dev_budget_type_other_vat,
      $this->dev_objecttive,
      $this->dev_short_content,
      $this->dev_benefits,
      $this->dev_status,
      $this->dev_type,
      $this->dev_go_service_type,
      $this->dev_certificate,
      $this->dev_create_user,
      $this->dev_organized_type
    ));
    $this->last_insert_id = $this->hr->insert_id();
  }


  function update()
  {
    // ตรวจสอบว่าฟิลด์ dev_id เป็น primary key และมีค่าเพื่อตรวจสอบว่าแถวไหนที่ต้องอัปเดต
    $sql = "UPDATE " . $this->hr_db . ".hr_dev_develop
                SET
                    dev_topic = ?,
                    dev_desc = ?,
                    dev_start_date = ?,
                    dev_end_date = ?,
                    dev_end_time = ?,
                    dev_hour = ?,
                    dev_place = ?,
                    dev_country_id = ?,
                    dev_pv_id = ?,
                    dev_project = ?,
                    dev_budget =?,
                dev_allowance=?,
                dev_accommodation=?,
                dev_budget_type_other=?,
                 dev_budget_vat=?,
                dev_allowance_vat=?,
                dev_accommodation_vat=?,
                dev_budget_type_other_vat=?,
                    dev_objecttive = ?,
                    dev_short_content = ?,
                    dev_benefits = ?,
                    dev_type = ?,
                    dev_go_service_type = ?,
                    dev_certificate = ?,
                    dev_create_user = ?,
                    dev_organized_type = ?
                WHERE dev_id = ?";
    // ส่งข้อมูลที่ต้องอัปเดตลงไปใน query
    $this->hr->query($sql, array(
      $this->dev_topic,
      $this->dev_desc,
      $this->dev_start_date,
      $this->dev_end_date,
      $this->dev_end_time,
      $this->dev_hour,
      $this->dev_place,
      $this->dev_country_id,
      $this->dev_pv_id,
      $this->dev_project,
      $this->dev_budget,
      $this->dev_allowance,
      $this->dev_accommodation,
      $this->dev_budget_type_other,
      $this->dev_budget_vat,
      $this->dev_allowance_vat,
      $this->dev_accommodation_vat,
      $this->dev_budget_type_other_vat,
      $this->dev_objecttive,
      $this->dev_short_content,
      $this->dev_benefits,
      $this->dev_type,
      $this->dev_go_service_type,
      $this->dev_certificate,
      $this->dev_create_user,
      $this->dev_organized_type,
      $this->dev_id // ตรวจสอบด้วย dev_id เพื่ออัปเดตแถวที่ตรงกัน
    ));
  }
  public function insert_develop_person($dev_id, $ps_id, $status, $create_user)
  {
    $sql = "INSERT INTO " . $this->hr_db . ".hr_dev_developperson (devps_ps_id,devps_dev_id,devps_status,devps_create_user)
       VALUES(?, ?, ?,?)";
    $this->hr->query($sql, array($ps_id, $dev_id, $status, $create_user));
  }
  public function update_develop_person($dev_id, $ps_id, $status, $user_user)
  {
    $sql = "UPDATE " . $this->hr_db . ".hr_dev_developperson 
        SET devps_status = ? , devps_update_user = ?
        WHERE devps_ps_id = ? AND devps_dev_id = ?";
    $this->hr->query($sql, array($status, $user_user, $ps_id, $dev_id));
  }
  function delete()
  {
    // if there is no primary key, please remove WHERE clause.
    $sql = "DELETE FROM " . $this->hr_db . ".hr_dev_develop
				WHERE dev_id=?";
    $this->hr->query($sql, array($this->ps_id));
  }
  function delete_develop_by_id()
  {
    // if there is no primary key, please remove WHERE clause.
    $sql = "UPDATE " . $this->hr_db . ".hr_dev_develop 
            SET dev_status = ? , dev_update_user = ?
            WHERE dev_id = ?";
    $this->hr->query($sql, array($this->dev_status, $this->dev_update_user, $this->dev_id));
    $sql2 = "UPDATE " . $this->hr_db . ".hr_dev_developperson 
    SET devps_status = ? , devps_update_user = ?
    WHERE devps_dev_id = ?";
    $this->hr->query($sql2, array($this->dev_status, $this->dev_update_user, $this->dev_id));
  }
  /*
	 * You have to assign primary key value before call this function.
	 */
  function get_by_key($withSetAttributeValue = FALSE)
  {
    $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_person
				WHERE ps_id=?";
    $query = $this->hr->query($sql, array($this->ps_id));
    if ($withSetAttributeValue) {
      $this->row2attribute($query->row());
    } else {
      return $query;
    }
  }
}     //=== end class Da_hr_person