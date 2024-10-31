<?php 
 /*
 *  M_ams_base_notify
 *  Model for Manage about ams_base_notify Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 18/06/2024
 */

include_once("Da_ams_base_notify.php");
class M_ams_base_notify extends Da_ams_base_notify {
    function get_all_active($active = "2") {
        $sql = "SELECT 
                abn.*,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = abn.ntf_create_user) AS create_user_name,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = abn.ntf_update_user) AS update_user_name
            FROM 
                ".$this->ams_db.".ams_base_notify AS abn
            WHERE 
                abn.ntf_active != ?";
        
        $query = $this->ams->query($sql, array($active));
    
        return $query;
    }
   
    
    function get_by_id($id)
    {
      $sql = "SELECT * FROM ".$this->ams_db.".ams_base_notify
       WHERE ntf_id = ?";
  
      $result = $this->ams->query($sql, array($id));
      return $result;
    }
  
    





}  

?>