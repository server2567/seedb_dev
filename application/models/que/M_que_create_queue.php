<?php 
 /*
 *  M_que_create_queue
 *  Model for Manage about que_create_queue Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 24/07/2024
 */

include_once("Da_que_create_queue.php");

class M_que_create_queue extends Da_que_create_queue {
    function get_all_active ($active="2"){
        $sql = "SELECT 
                    qcq.*,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qcq.cq_create_user) AS create_user_name,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qcq.cq_update_user) AS update_user_name
                FROM "
                    .$this->que_db.".que_create_queue AS qcq
                WHERE 
                    qcq.cq_active != '$active'";
        $query = $this->que->query($sql);
        
        return $query;
    }

    
   function get_all_que_keyword(){
    $sql = " SELECT 
              cq_keyword,cq_value FROM see_quedb.que_create_queue
              ";
    $query = $this->que->query($sql);
    return $query;
   }
    
    function get_by_id($id)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_queue
       WHERE cq_id = ?";
  
      $result = $this->que->query($sql, array($id));
      return $result;
    }
  
    /**
     * get_by_keyword
     * @param $ct_keyword
     * @return mixed
      * @author dechathon
      * @create_date 2024-07-25
     */
    function get_all_by_keyword($ct_keyword)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_queue
      WHERE ct_keyword = ?
      ORDER BY ct_create_date DESC";
  
      $result = $this->que->query($sql, array($ct_keyword));
      return $result;
    }
  
    /**
     * get_by_keyword_active
     * @param $ct_keyword
     * @return mixed
      * @author dechathon
      * @create_date 2024-07-25
     */
    function get_by_keyword_active($ct_keyword)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_queue
      WHERE cq_keyword = ? AND cq_active = '1'
      ORDER BY cq_create_date DESC";
      $result = $this->que->query($sql, array($ct_keyword));
      return $result;
    }
    function update_cq_value() {
      // Construct the SQL query for UPDATE
      $sql = "UPDATE ".$this->que_db.".que_create_queue 
                SET 
                cq_value = ?    
              WHERE
                  cq_id = ?";
        $this->que->query($sql, array(
        $this->cq_value,
        $this->cq_id
      ));
      
    }
    /**
     * insert_by_keyword
     * @param $ct_keyword
     * @param $data_insert
      * @author dechathon
      * @create_date 2024-07-25
     */
    function insert_by_keyword($ct_keyword, $data_insert)
    {
      // update all keyword active = 'N'
      if ($data_insert['ct_active'] == '1') {
        $this->update_all_keyword_active_to_n($ct_keyword);
      }
  
      $data_insert['ct_keyword'] = $ct_keyword;
  
      // insert new keyword
      $this->que->insert($this->que_db . '.que_create_queue', $data_insert);
    }
  
    /**
     * update_by_id
     * @param $id
     * @param $data_insert
      * @author dechathon
      * @create_date 2024-07-25
     */
    function update_by_id($id, $data_insert)
    {
      $this->que->update($this->que_db . '.que_create_queue', $data_insert, array('cq_id' => $id));
    }
  
    /**
     * update_all_keyword_active_to_n
     * @param $keyword
      * @author dechathon
      * @create_date 2024-07-25
     */
    function update_all_keyword_active_to_n($keyword)
    {
      $sql = "UPDATE $this->que_db.que_create_queue SET ct_active = '0' WHERE ct_keyword = ?";
  
      $this->que->query($sql, array($keyword));
    }
  
    /**
     * change_active_to_use_this_id
     * @param $ct_id
      * @author dechathon
      * @create_date 2024-07-25
     */
    function change_active_to_use_this_id($ct_id)
    {
      $this->que->trans_start();
      // get keyword
      $keyword = $this->que->query("SELECT ct_keyword FROM $this->que_db.que_create_queue 
  WHERE ct_id = ?", array($ct_id))->row()->ct_keyword;
  
      // update all keyword active = 'N'
      $this->update_all_keyword_active_to_n($keyword);
      // active this id
      $this->que->query("UPDATE $this->que_db.que_create_queue
  SET ct_active = '1' WHERE ct_id = ?", array($ct_id));
  
      $this->que->trans_complete();
  
    }

    function get_cq_value_by_stde_id($stde_id) {
      $sql = "SELECT que_create_queue.*, que_base_department_queue.dpq_stde_id FROM $this->que_db.que_create_queue
      LEFT JOIN que_base_department_queue
      ON cq_dpq_id = dpq_id
      WHERE que_base_department_queue.dpq_stde_id = ?
      AND cq_active = '1'
      ORDER BY cq_create_date DESC";
      $result = $this->que->query($sql, array($stde_id));
      return $result;

    }



}  

?>