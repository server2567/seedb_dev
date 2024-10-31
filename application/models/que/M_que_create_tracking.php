<?php 
 /*
 *  M_que_create_tracking
 *  Model for Manage about que_create_tracking Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 31/05/2024
 */

include_once("Da_que_create_tracking.php");

class M_que_create_tracking extends Da_que_create_tracking {
    function get_all_active ($active="2"){
        $sql = "SELECT 
                    qct.*,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_create_user) AS create_user_name,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_update_user) AS update_user_name
                FROM "
                    .$this->que_db.".que_create_tracking AS qct
                WHERE 
                    qct.ct_active != '$active'";
        $query = $this->que->query($sql);
        
        return $query;
    }

    /*
    * get_all_by_active_and_person
    * ข้อมูลเลขนัดหมายทั้งหมดตามขอบเขตของ person_id เรียงตามชื่อ
    * @input 
        ps_id: hr_person id for scope to get some structure detail
        active: exclude active
    * @output all que create trackings according to the scope of the ps_id
    * @author Areerat Pongurai
    * @Create Date 2567-07-05
    */
    function get_all_by_active_and_person ($ps_id=null, $active="2"){
        $sql = "SELECT qct.ct_id, qct.ct_name, qct.ct_keyword, qct.ct_value_demo, ct_create_user, ct_update_user, qct.ct_create_date, qct.ct_update_date, qct.ct_active,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_create_user) AS create_user_name,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_update_user) AS update_user_name
                FROM ".$this->que_db.".que_create_tracking qct
                LEFT JOIN ".$this->que_db.".que_base_department_keyword dpk ON qct.ct_dpk_id = dpk.dpk_id
					      LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_stde_id = dpk.dpk_stde_id
                WHERE qct.ct_active != '$active' AND stdp.stdp_ps_id = {$ps_id}
                GROUP BY qct.ct_id, qct.ct_name, qct.ct_keyword, qct.ct_value_demo, ct_create_user, ct_update_user, qct.ct_create_date, qct.ct_update_date, qct.ct_active,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_create_user),
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qct.ct_update_user)
                ORDER BY qct.ct_name";
        $query = $this->que->query($sql);
        return $query;
    }
   
    
    function get_by_id($id)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_tracking
       WHERE ct_id = ?";
  
      $result = $this->que->query($sql, array($id));
      return $result;
    }
  
    /**
     * get_by_keyword
     * @param $ct_keyword
     * @return mixed
      * @author patiya
      * @create_date 2024-06-12
     */
    function get_all_by_keyword($ct_keyword)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_tracking
      WHERE ct_keyword = ?
      ORDER BY ct_create_date DESC";
  
      $result = $this->que->query($sql, array($ct_keyword));
      return $result;
    }
  
    /**
     * get_by_keyword_active
     * @param $ct_keyword
     * @return mixed
      * @author patiya
      * @create_date 2024-06-12
     */
    function get_by_keyword_active($ct_keyword)
    {
      $sql = "SELECT * FROM $this->que_db.que_create_tracking
      WHERE ct_keyword = ? AND ct_active = '1'
      ORDER BY ct_create_date DESC";
      $result = $this->que->query($sql, array($ct_keyword));
      return $result;
    }
  
    /**
     * insert_by_keyword
     * @param $ct_keyword
     * @param $data_insert
      * @author patiya
      * @create_date 2024-06-12
     */
    function insert_by_keyword($ct_keyword, $data_insert)
    {
      // update all keyword active = 'N'
      if ($data_insert['ct_active'] == '1') {
        $this->update_all_keyword_active_to_n($ct_keyword);
      }
  
      $data_insert['ct_keyword'] = $ct_keyword;
  
      // insert new keyword
      $this->que->insert($this->que_db . '.que_create_tracking', $data_insert);
    }
  
    /**
     * update_by_id
     * @param $id
     * @param $data_insert
      * @author patiya
      * @create_date 2024-06-12
     */
    function update_by_id($id, $data_insert)
    {
      $this->que->update($this->que_db . '.que_create_tracking', $data_insert, array('ct_id' => $id));
    }
  
    /**
     * update_all_keyword_active_to_n
     * @param $keyword
      * @author patiya
      * @create_date 2024-06-12
     */
    function update_all_keyword_active_to_n($keyword)
    {
      $sql = "UPDATE $this->que_db.que_create_tracking SET ct_active = '0' WHERE ct_keyword = ?";
  
      $this->que->query($sql, array($keyword));
    }
  
    /**
     * change_active_to_use_this_id
     * @param $ct_id
      * @author patiya
      * @create_date 2024-06-12
     */
    function change_active_to_use_this_id($ct_id)
    {
      $this->que->trans_start();
      // get keyword
      $keyword = $this->que->query("SELECT ct_keyword FROM $this->que_db.que_create_tracking 
  WHERE ct_id = ?", array($ct_id))->row()->ct_keyword;
  
      // update all keyword active = 'N'
      $this->update_all_keyword_active_to_n($keyword);
      // active this id
      $this->que->query("UPDATE $this->que_db.que_create_tracking
  SET ct_active = '1' WHERE ct_id = ?", array($ct_id));
  
      $this->que->trans_complete();
  
    }





}  

?>