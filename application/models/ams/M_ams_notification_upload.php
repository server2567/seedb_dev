<?php 
 /*
 *  M_ams_base_alarm
 *  Model for Manage about ams_base_alarm Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 19/06/2024
 */

include_once("Da_ams_notification_upload.php");
class M_ams_notification_upload extends Da_ams_notification_upload {
    
    function get_by_ntup_ntr_id($id)
    {
        $sql = "SELECT * 
                FROM 
                    see_amsdb.ams_notification_upload 
                WHERE ntup_ntr_id = ? ";

$query = $this->ams->query($sql,array($id));
return $query;
}

}  

?>