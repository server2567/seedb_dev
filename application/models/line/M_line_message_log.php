<?php
/*
 * M_line_message_log
 * Model for Manage about hr_person Table.
 * @Author Tanadon
 * @Create Date 2564-06-14
 */
include_once("Da_line_message_log.php");

class M_line_message_log extends Da_line_message_log
{

  /*
  * get_by_message_sub_type_by_id
  * @input msst_id
  * @output person data by id
  * @author Tanadon
  * @Create Date 2565-06-14
  */
  function get_by_message_sub_type_by_id(){
    $sql = "SELECT *
        FROM ".$this->line_db.".line_message_type
        LEFT JOIN ".$this->line_db.".line_message_sub_type
        ON mst_id = msst_mst_id
        WHERE msst_id = ?";
    $query = $this->line->query($sql,array($this->msst_id));
    return $query;
  }
  // get_by_message_sub_type_by_id



}