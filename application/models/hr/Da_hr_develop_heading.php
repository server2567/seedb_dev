<?php
/*
 * Da_hr_develop_heading
 * Model for Manage about hr_person Table.
 * @Author Jiradat Pomyai
 * @Create Date 09/10/2024
 */
include_once("hr_model.php");

class Da_hr_develop_heading extends Hr_model
{

  // PK is ps_id

  public $devh_id;
  public $devh_name_th;
  public $devh_name_en;
  public $devh_seq;
  public $devh_gp_id;
  public $devh_group_name;
  public $devh_status;
  public $devh_create_date;
  public $devh_create_user;
  public $devh_update_date;
  public $devh_update_user;
  public $last_insert_id;

  function __construct()
  {
    parent::__construct();
  }


  // if there is no auto_increment field, please remove it
  function insert()
  {
    // คำสั่ง INSERT INTO เพื่อเพิ่มข้อมูลใหม่ลงในฐานข้อมูล
    $sql = "INSERT INTO " . $this->hr_db . ".hr_dev_heading
            (
                devh_name_th,
                devh_name_en,
                devh_seq,
                devh_gp_id,
                devh_group_name,
                devh_status,
                devh_create_user,
                devh_create_date,
                devh_update_date,
                devh_update_user
            )
            VALUES (?, ?, ?,?, ?,?, ?, ?, ?,?)";

    // ส่งข้อมูลที่ต้องการเพิ่มลงไปในคำสั่ง INSERT
    $this->hr->query($sql, array(
      $this->devh_name_th,
      $this->devh_name_en,
      $this->devh_seq,
      $this->devh_gp_id,
      $this->devh_group_name,
      $this->devh_status,
      $this->devh_create_user,
      $this->devh_create_date,
      $this->devh_update_date,
      $this->devh_update_user
    ));
    $this->last_insert_id = $this->hr->insert_id();
  }


  function update()
  {
    // ตรวจสอบว่าฟิลด์ dev_id เป็น primary key และมีค่าเพื่อตรวจสอบว่าแถวไหนที่ต้องอัปเดต
    $sql = "UPDATE " . $this->hr_db . ".hr_dev_heading
                SET
                devh_group_name = ?,
                  devh_name_th = ?,
                  devh_name_en = ?
                WHERE devh_id = ?";
    // ส่งข้อมูลที่ต้องอัปเดตลงไปใน query
    $this->hr->query($sql, array(
      $this->devh_group_name,
      $this->devh_name_th,
      $this->devh_name_en,
      $this->devh_id
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
  function change_staus_to_delete()
  {
    $sql = "UPDATE " . $this->hr_db . ".hr_dev_heading 
    SET devh_status = ? , devh_update_user = ?
    WHERE devh_id = ? ";
    $this->hr->query($sql, array($this->devh_status, $this->devh_update_user, $this->devh_id));
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
