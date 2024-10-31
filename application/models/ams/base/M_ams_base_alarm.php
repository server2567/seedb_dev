<?php 
 /*
 *  M_ams_base_alarm
 *  Model for Manage about ams_base_alarm Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 19/06/2024
 */

include_once("Da_ams_base_alarm.php");
class M_ams_base_alarm extends Da_ams_base_alarm {
    function get_all_active($active = "2") {
        $sql = "SELECT 
                aba.*,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = aba.al_create_user) AS create_user_name,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = aba.al_update_user) AS update_user_name,
                (SELECT ntf_name FROM see_amsdb.ams_base_notify WHERE ntf_id = aba.al_ntf_id ) AS notify_name
            FROM 
                ".$this->ams_db.".ams_base_alarm AS aba
            WHERE 
                aba.al_active != ?";
        
        $query = $this->ams->query($sql, array($active));
    
        return $query;
    }
   
    function get_notify_unique (){
        $sql = "SELECT ntf.ntf_id , ntf.ntf_name
        FROM see_amsdb.ams_base_notify AS ntf
        LEFT JOIN see_amsdb.ams_base_alarm AS al
        ON al.al_active != '2' AND ntf.ntf_id = al.al_ntf_id
        WHERE al.al_ntf_id IS NULL AND ntf.ntf_active = '1'";
        
        $query = $this->ams->query($sql);
        return $query;
    }

    function get_by_id($id)
    {
      $sql = "SELECT aba.* ,
	            (SELECT ntf_name FROM see_amsdb.ams_base_notify WHERE ntf_id = aba.al_ntf_id ) AS notify_name
            FROM see_amsdb.ams_base_alarm AS aba 
            WHERE al_id = ?";
  
      $result = $this->ams->query($sql, array($id));
      return $result;
    }
  
    





}  

?>