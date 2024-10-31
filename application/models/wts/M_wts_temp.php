<?php
/*
 *  M_wts_notifications_department
 *  Model for Manage about wts_notifications_department Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 11/07/2024
 */

include_once("Da_wts_notifications_department.php");
class M_wts_temp extends Da_wts_notifications_department
{

    /*
    * get_current_que_by_stde
    * 
    * @input 
            pre_date: date
            stde_id(structure_detail_id): id แผนก [HR]
    * @output 
    * @author Areerat Pongurai
    * @Create Date 02/08/2024
    */  
    public function get_current_que_by_stde($pre_date, $sta_id, $stde_ids) {
        $where = '';
        if(!empty($stde_ids)) {
            $include_stde_id_string = implode(", ", array_map(function($item) {
                return "'$item'";
            }, $stde_ids));
            $where .= " AND apm.apm_stde_id IN ({$include_stde_id_string}) ";
        }

        $sql = "SELECT ntdp.ntdp_id, rdp.rdp_name, ds.ds_name_disease_type, dst.dst_name_point,  
                    ntdp.ntdp_date_start, ntdp.ntdp_time_start, sta.sta_name, 
                    apm.apm_ql_code, apm.apm_pt_id, pt.pt_prefix, apm.apm_ps_id, 
                    pt.pt_fname, pt.pt_lname, 
                    ps.ps_pf_id, ps.ps_fname, ps.ps_lname
                FROM wts_notifications_department ntdp
                LEFT join see_quedb.que_appointment apm ON ntdp.ntdp_apm_id = apm.apm_id
                LEFT JOIN see_quedb.que_base_status sta ON apm.apm_sta_id = sta.sta_id
                LEFT JOIN wts_base_route_department rdp ON ntdp.ntdp_rdp_id = rdp.rdp_id
                LEFT join wts_base_disease_time dst ON ntdp.ntdp_dst_id = dst.dst_id
                LEFT JOIN wts_base_disease ds ON ntdp.ntdp_ds_id = ds.ds_id
                LEFT JOIN see_umsdb.ums_patient pt ON apm.apm_pt_id = pt.pt_id
                LEFT JOIN see_hrdb.hr_person ps ON apm.apm_ps_id = ps.ps_id
                WHERE ntdp.ntdp_date_start = '$pre_date' AND apm.apm_sta_id = '$sta_id'  
                    {$where}
                ORDER BY apm.apm_ql_id ASC
                LIMIT 1 ";
        // AND ntdp.ntdp_rdp_id = '$ntdp_rdp_id'
        // AND ntdp.ntdp_ds_id = '$ntdp_ds_id'
        // AND ntdp.ntdp_dst_id = '$ntdp_dst_id'
        // AND apm.apm_ps_id = '$ps_id'
        die($sql);
        $query = $this->wts->query($sql);
        return $query; // Return result as array
    }

}
