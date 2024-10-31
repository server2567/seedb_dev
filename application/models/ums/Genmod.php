<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author Natakorn
 */
class Genmod extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }
  //ดูค่าจากคอลัม
  public function getTableCol($tableName, $selColName, $whereColName, $colValue)
  {
    $q = "SELECT $selColName FROM $tableName WHERE $whereColName = ?";

    $run_q = $this->db->query($q, [$colValue]);

    if ($run_q->num_rows() > 0) {
      foreach ($run_q->result() as $get) {
        return $get->$selColName;
      }
    } else {
      return FALSE;
    }
  }
  //getหลายค่า
  public function getAll($database, $tableName, $getColName = '*', $arrayWhere = '', $order = '', $arrayJoinTable = '', $groupby = '')
  {
    $this->db->db_select($database);

    if ($getColName) {
      $this->db->select($getColName);
    }
    if ($arrayWhere) {
      $this->db->where($arrayWhere);
    }
    if ($order) {
      $this->db->order_by($order);
    }
    if ($groupby) {
      $this->db->group_by($groupby);
    }
    if ($arrayJoinTable) {
      foreach ($arrayJoinTable as $key => $value) {
        $this->db->join($key, $value, 'LEFT');
      }
    }

    $run_q = $this->db->get($tableName);
    if ($run_q->num_rows() > 0) {
      return $run_q->result();
    } else {
      return []; // คืนค่าเป็น array ว่างแทน false
    }
  }
  //getค่าเดียว
  public function getOne($database, $tableName, $getColName = '*', $arrayWhere = '', $order = '', $arrayJoinTable = '', $groupby = '')
  {
    $this->db->db_select($database);

    if ($getColName) {
      $this->db->select($getColName);
    }
    if ($arrayWhere) {
      $this->db->where($arrayWhere);
    }
    if ($order) {
      $this->db->order_by($order);
    }
    if ($arrayJoinTable) {
      foreach ($arrayJoinTable as $key => $value) {
        $this->db->join($key, $value, 'LEFT');
      }
    }
    if ($groupby) {
      $this->db->group_by($groupby);
    }
    $run_q = $this->db->get($tableName);

    if ($run_q->num_rows() > 0) {
      return $run_q->row(0);
    } else {
      return FALSE;
    }
  }

  //เพิ่มข้อมูล
  public function add($database, $table, $arrayData)
  {
    // เลือกฐานข้อมูลย่อย
    $this->db->db_select($database);

    // เพิ่มข้อมูลลงในตาราง
    $this->db->insert($table, $arrayData);

    if ($this->db->affected_rows() > 0) {
      $insert_id = $this->db->insert_id();
      // เพิ่มการล็อก
      // $this->addlog('add', $table, $arrayData);
      // return $insert_id;
    } else {
      return FALSE;
    }
  }
  //อัพเดรตข้อมูล
  public function update($database, $table, $arrayData, $arrayWhere = '')
  {
    $this->db->db_select($database);
    if ($arrayWhere) {
      $this->db->where($arrayWhere);
    }
    $this->db->update($table, $arrayData);
    // $this->addlog('update', $table, $arrayData);
    return TRUE;
  }
  //หาจำนวน
  // public function countAll($table, $arrayWhere = '', $arrayJoinTable = '')
  // {
    
  //   if ($arrayWhere)
  //     $this->db->where($arrayWhere);
  //   if ($arrayJoinTable) {
  //     foreach ($arrayJoinTable as $key => $value) {
  //       $this->db->join($key, $value, 'LEFT');
  //     }
  //   }
  //   $count = $this->db->count_all_results($table);
  //   return $count;
  // }
  public function countAll($tableName, $where = '', $arrayJoinTable = '') {

    $this->db->from($tableName);

    if ($where) {
        $this->db->where($where);
    }

    if ($arrayJoinTable) {
        foreach ($arrayJoinTable as $key => $value) {
            $this->db->join($key, $value, 'LEFT');
        }
    }

    return $this->db->count_all_results();
  }

  //หาผลรวม
  public function sumAll($tableName, $column, $arrayWhere = '')
  {
    if ($arrayWhere)
      $this->db->where($arrayWhere);
    $this->db->select_sum($column, 'sum');
    $run_q =  $this->db->get($tableName);
    if ($run_q->num_rows() > 0) {
      return $run_q->row(0)->sum;
    } else {
      return FALSE;
    }
  }
  // function addlog($action, $table, $jsonData){
  //   $this->db->insert('system_log',array('action'=>$action,'table_name'=>$table,'related_data'=>json_encode($jsonData,JSON_UNESCAPED_UNICODE), 'command'=>$this->db->last_query(), 'user'=>$_SESSION['user_id'] ));
  // }

  // function getCategoryOptions($arrayWhere=''){
  //   $this->db->select('pc_id as value, pc_title as text');
  //   if ($arrayWhere)
  //     $this->db->where($arrayWhere);
  //   $this->db->where_in('inv_status', array('print','pay'));
  //   $this->db->join('invoice_list','invl_inv_id = inv_id');
  //   $this->db->join('products', 'p_id = invl_p_id');
  //   $this->db->join('product_category', 'pc_id = p_category');
  //   $this->db->group_by(array('pc_id', 'pc_title'));
  //   $run_q = $this->db->get('invoice');
  //   if($run_q->num_rows() > 0){
  //     return $run_q->result();
  //   }else{
  //     return FALSE;
  //   }
  // }
  //ลบข้อมูล
  public function delete($database, $tableName, $arrayWhere = '')
  {
    $this->db->db_select($database);
    if ($arrayWhere) {
      $this->db->where($arrayWhere);
    }
    $this->db->delete($tableName);
    // ตรวจสอบว่ามีการลบแถวหรือไม่
    if ($this->db->affected_rows() > 0) {
      return TRUE; // ถ้ามีการลบข้อมูล
    } else {
      return FALSE; // ถ้าไม่มีการลบข้อมูล
    }
  }
  public function getAll_limit($database, $tableName, $getColName = '*', $arrayWhere = '', $order = '', $arrayJoinTable = '', $groupby = '', $start = '', $length = '')
{
    $this->db->db_select($database);

    if($getColName){
        $this->db->select($getColName);
    }
    if($arrayWhere){
        $this->db->where($arrayWhere);
    }
    if($order){
        $this->db->order_by($order);
    }
    if($groupby){
        $this->db->group_by($groupby);
    }
    if($arrayJoinTable){
        foreach ($arrayJoinTable as $key => $value) {
            $this->db->join($key, $value, 'LEFT');
        }
    }
    if ($start !== '' && $length !== '') {
        $this->db->limit($length, $start);
    }

    $run_q = $this->db->get($tableName);
    if($run_q->num_rows() > 0){
        return $run_q->result();
    } else {
        return [];
    }
}
public function getOne_limit($database, $tableName, $getColName = '*', $arrayWhere = '', $order = '', $arrayJoinTable = '', $groupby = '', $start = '', $length = '')
{
    $this->db->db_select($database);

    if ($getColName) {
        $this->db->select($getColName);
    }
    if ($arrayWhere) {
        $this->db->where($arrayWhere);
    }
    if ($order) {
        $this->db->order_by($order);
    }
    if ($arrayJoinTable) {
        foreach ($arrayJoinTable as $key => $value) {
            $this->db->join($key, $value, 'LEFT');
        }
    }
    if ($groupby) {
        $this->db->group_by($groupby);
    }

    if ($start !== '' && $length !== '') {
        $this->db->limit($length, $start);
    }

    $run_q = $this->db->get($tableName);

    if ($run_q->num_rows() > 0) {
        return $run_q->row(0); // คืนค่าแถวแรกที่ตรงกับเงื่อนไข
    } else {
        return FALSE; // ไม่พบข้อมูลตามเงื่อนไข
    }
}


}
