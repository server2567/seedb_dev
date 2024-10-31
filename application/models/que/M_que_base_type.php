<?php 
 /*
 *  M_que_base_type
 *  Model for Manage about que_base_type Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 31/05/2024
 */

    include_once("Da_que_base_type.php");
class M_que_base_type extends Da_que_base_type {
    function get_all_active ($active="2"){
        $sql = "SELECT 
                    qbt.*,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qbt.type_create_user) AS create_user_name,
                    (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = qbt.type_update_user) AS update_user_name
                FROM "
                    .$this->que_db.".que_base_type AS qbt
                WHERE 
                    qbt.type_active != '$active'";
        $query = $this->que->query($sql);

        return $query;
    }

    function get_by_id($id) {
        $sql = "SELECT *
                FROM ".$this->que_db.".que_base_type
                WHERE type_id = '$id' ";
        $query = $this->que->query($sql);

        return $query;
    }
    






}  

?>