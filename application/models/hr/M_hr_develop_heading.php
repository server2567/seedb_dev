<?php
/*
 * M_hr_develop_heading
 * Model for Manage about hr_person Table.
 * @Author Jiradat Pomyai
 * @Create Date 09/10/2024
 */
include_once("Da_hr_develop_heading.php");

class M_hr_develop_heading extends Da_hr_develop_heading
{
    function get_develop_list_by_ps_id($status = 1)
    {
        $sql = "SELECT 
                    devh_gp_id,
                    devh_group_name,
                    devh_id,
                    devh_name_th,
                    devh_name_en,
                    devh_seq
                FROM see_hrdb.hr_dev_heading
                WHERE devh_status = $status
                ORDER BY devh_gp_id, devh_seq;";
        $query = $this->hr->query($sql, array($status));
        return $query;
    }
    function get_matching_code()
    {
        $sql = "SELECT mc_code FROM " . $this->hr_db . ".hr_timework_matching_code WHERE mc_code = ?";
        $query = $this->hr->query($sql, array($this->mc_code));
        return $query;
    }
    function get_develop_person($ps_id, $dev_id, $status = 1)
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_dev_developperson WHERE devps_ps_id = ? AND devps_dev_id = ? AND devps_status =?";
        $query = $this->hr->query($sql, array($ps_id, $dev_id, $status));
        return $query;
    }
    function get_develop_heading_by_gp_id($status = 1)
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_dev_heading where devh_gp_id = ? and devh_status = ?";
        $query = $this->hr->query($sql, array($this->devh_gp_id,$status));
        return $query;
    }
    function get_last_group_id()
    {
        $sql = "SELECT MAX(devh_gp_id) as max FROM " . $this->hr_db . ".hr_dev_heading ";
        $query = $this->hr->query($sql);
        return $query;
    }
    function get_heading_list($status = 1){
        $sql = "SELECT 
                devh_gp_id,
                devh_group_name,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'devh_id', devh_id,
                        'devh_name_th', devh_name_th -- ใส่คอลัมน์ที่คุณต้องการได้ที่นี่
                    )
                ) AS devh_list
            FROM 
                hr_dev_heading
            WHERE devh_status = $status
            GROUP BY 
                devh_gp_id, devh_group_name;
                ";
        $query = $this->hr->query($sql, array($status));
        return $query;  
    }
    // function get_order_person_data_by_type($type)
    // {
    // 	$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = '$type'";
    // 	$query = $this->hr->query($sql);
    // 	return $query;
    // }
} // end class M_hr_person
