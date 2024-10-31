<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_develop.php");

class M_hr_develop extends Da_hr_develop
{
    function get_develop_list_by_ps_id($ps_id, $status = 1)
    {
        $sql = "SELECT dev.*,devh.devh_name_th FROM " . $this->hr_db . ".hr_dev_developperson as devps 
        INNER JOIN " . $this->hr_db . ".hr_dev_develop as dev on dev.dev_id = devps.devps_dev_id 
         INNER JOIN see_hrdb.hr_dev_heading as devh
           ON devh.devh_id = dev.dev_topic WHERE dev.dev_status = ?";
        if ($ps_id != 'none') {
            $sql .= " AND devps.devps_ps_id = $ps_id ";
        }
        $sql .= ' GROUP BY dev.dev_id';
        $query = $this->hr->query($sql, array($status));
        return $query;
    }
    function get_develop_info_by_id($dev_id, $status = 1)
    {
        $sql = "
        SELECT dev.*, 
               JSON_UNQUOTE(
                   JSON_ARRAYAGG(
                       DISTINCT JSON_OBJECT(
                           'ps_id', pos.pos_ps_id,
                           'devps_status', 1,
                           'check', 'old',
                           'pos_ps_code', pos.pos_ps_code,
                           'ps_name', CONCAT(pf.pf_name_abbr,' ',ps.ps_fname, ' ', ps.ps_lname),
                           'hire_name', hire.hire_abbr,
                           'hire_is_medical', hire.hire_is_medical,
                           'adline_position', adline.alp_name,
                           'stde_name_three', (
                               SELECT JSON_ARRAYAGG(DISTINCT JSON_OBJECT('stde_name_th', stde.stde_name_th, 'stdp_po_id', stdp.stdp_po_id,'stde_level',stde.stde_level))
                               FROM see_hrdb.hr_structure_detail AS stde
                               INNER JOIN see_hrdb.hr_structure_person AS stdp 
                                      ON stde.stde_id = stdp.stdp_stde_id
                               INNER JOIN see_hrdb.hr_structure as stuc
                                      ON stuc.stuc_id = stde.stde_stuc_id
                               WHERE stdp.stdp_ps_id = pos.pos_ps_id AND stdp.stdp_active = 1 AND stuc.stuc_status = 1
                           )
                       )
                   )
               ) AS dev_person
        FROM see_hrdb.hr_dev_develop AS dev
        INNER JOIN see_hrdb.hr_dev_developperson AS devps 
            ON dev.dev_id = devps.devps_dev_id
        INNER JOIN see_hrdb.hr_person AS ps 
            ON ps.ps_id = devps.devps_ps_id
        INNER JOIN see_hrdb.hr_dev_heading as devh
           ON devh.devh_id = dev.dev_topic
        INNER JOIN see_hrdb.hr_person_detail AS psd 
            ON psd.psd_ps_id = ps.ps_id
        INNER JOIN see_hrdb.hr_person_position AS pos 
            ON pos.pos_ps_id = ps.ps_id
        INNER JOIN see_hrdb.hr_base_adline_position AS adline 
            ON pos.pos_alp_id = adline.alp_id
        INNER JOIN see_hrdb.hr_base_prefix AS pf 
            ON pf.pf_id = ps.ps_pf_id
        INNER JOIN see_hrdb.hr_base_hire AS hire 
            ON hire.hire_id = pos.pos_hire_id
        WHERE dev.dev_id = ?
          AND pos.pos_dp_id = ?
          AND devps.devps_status = ?
        GROUP BY dev.dev_id;
    ";

        $query = $this->hr->query($sql, array($dev_id, 1, $status));

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
    function get_develop_document_info($dou_menu_name)
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_base_document where dou_menu_name = ?";
        $query = $this->hr->query($sql, array($dou_menu_name));
        return $query;
    }
    function get_develop_person_by_year_filter($ps_id, $year, $status = 1)
    {
        $sql = "SELECT dev.*,devb.devb_name as dev_server_type_name FROM " . $this->hr_db . ".hr_dev_developperson as devps
        INNER JOIN " . $this->hr_db . ".hr_dev_develop as dev on dev.dev_id = devps.devps_dev_id
        INNER JOIN " . $this->hr_db . ".hr_base_develop_type as devb on devb.devb_id = dev.dev_go_service_type
        WHERE devps.devps_ps_id = ? AND YEAR(dev.dev_start_date) = ? AND dev.dev_status = ?";
        $query = $this->hr->query($sql, array($ps_id, $year, $status));
        return $query;
    }
    function get_develop_year_filter($status = 1)
    {
        $sql = "SELECT YEAR(dev_start_date) as year FROM " . $this->hr_db . ".hr_dev_develop
        WHERE dev_status = ? GROUP BY YEAR(dev_start_date)";
        $query = $this->hr->query($sql, array($status));
        return $query;
    }
    function get_develop_list_by_filter($filter, $status = 1)
    {
        $sql = "SELECT dev.*,devh.devh_name_th FROM " . $this->hr_db . ".hr_dev_developperson as devps 
        INNER JOIN " . $this->hr_db . ".hr_dev_develop as dev on dev.dev_id = devps.devps_dev_id 
         INNER JOIN see_hrdb.hr_dev_heading as devh
           ON devh.devh_id = dev.dev_topic WHERE dev.dev_status = ? AND YEAR(dev.dev_start_date) = ?";
        if ($filter['filter_org_type'] != 'all') {
            $sql .= " AND dev.dev_organized_type = " . $filter['filter_org_type'];
        }
        if ($filter['filter_dev_type'] != 'all') {
            $sql .= " AND dev.dev_type = " . $filter['filter_dev_type'];
        }
        if ($filter['filter_devb_type'] != 'all') {
            $sql .= " AND dev.dev_go_service_type = " . $filter['filter_devb_type'];
        }
        $sql .= ' GROUP BY dev.dev_id';
        $query = $this->hr->query($sql, array($status, ($filter['filter_year'] - 543)));
        return $query;
    }
    function get_export_develop_list_by_filter($filter, $status = 1)
    {
        // สร้าง SQL Query
        $sql = "
            SELECT 
                devps.devps_ps_id,
                CONCAT(pf.pf_name, ' ', ps.ps_fname, ' ', ps.ps_lname) AS person_name,
                SUM(dev.dev_hour) AS sum_hour,  -- คำนวณรวมจำนวนชั่วโมงสำหรับแต่ละบุคคล
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'dev_id', dev.dev_id,
                        'dev_name', devh.devh_name_th,
                        'dev_start_date', dev.dev_start_date,
                        'dev_end_date', dev.dev_end_date,
                        'dev_place', dev.dev_place,
                        'devb_name', devb.devb_name,
                        'dev_hour', dev.dev_hour
                    )
                ) AS devps_data_array
            FROM " . $this->hr_db . ".hr_dev_develop AS dev
            INNER JOIN " . $this->hr_db . ".hr_dev_developperson AS devps 
                ON dev.dev_id = devps.devps_dev_id
            INNER JOIN " . $this->hr_db . ".hr_base_develop_type AS devb 
                ON devb.devb_id = dev.dev_go_service_type
            INNER JOIN " . $this->hr_db . ".hr_person AS ps 
                ON ps.ps_id = devps.devps_ps_id
            INNER JOIN " . $this->hr_db . ".hr_base_prefix AS pf 
                ON ps.ps_pf_id = pf.pf_id
            INNER JOIN " . $this->hr_db . ".hr_dev_heading AS devh 
                ON devh.devh_id = dev.dev_topic
            WHERE 
                devps.devps_status = ? 
                AND YEAR(dev.dev_start_date) = ?
        ";

        // กรองตามเงื่อนไขของ filter
        if ($filter['filter_org_type'] != 'all') {
            $sql .= " AND dev.dev_organized_type = " . $filter['filter_org_type'];
        }
        if ($filter['filter_dev_type'] != 'all') {
            $sql .= " AND dev.dev_type = " . $filter['filter_dev_type'];
        }
        if ($filter['filter_devb_type'] != 'all') {
            $sql .= " AND dev.dev_go_service_type = " . $filter['filter_devb_type'];
        }
        if ($filter['ps_id'] != null) {
            $sql .= " AND devps.devps_ps_id = " . $filter['ps_id'];
        }

        // Group by ตาม ps_id เพื่อให้ผลรวมถูกต้อง
        $sql .= " GROUP BY devps.devps_ps_id";

        // รัน query และส่งค่า filter_year - 543
        $query = $this->hr->query($sql, array($status, ($filter['filter_year'] - 543)));

        // ส่งผลลัพธ์กลับ
        return $query;
    }
    // function get_order_person_data_by_type($type)
    // {
    // 	$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = '$type'";
    // 	$query = $this->hr->query($sql);
    // 	return $query;
    // }
    function get_report_develop_person_list($status = 1)
    {
        $sql = "
            SELECT 
                main.devps_ps_id,
                main.devps_dev_id,
                main.devps_status,
                main.pf_name,
                main.ps_fname,
                main.ps_lname,
                main.devh_name_th,
                main.dev_start_date,
                main.dev_end_date,
                main.dev_hour,
                main.dev_place,
                main.devb_name,
                ROW_NUMBER() OVER (PARTITION BY main.devps_ps_id ORDER BY main.dev_start_date) AS dev_seq,
                totals.total_hours
            FROM (
                SELECT 
                    devps.devps_ps_id,
                    devps.devps_dev_id,
                    devps.devps_status,
                    pf.pf_name,
                    ps.ps_fname,
                    ps.ps_lname,
                    devh.devh_name_th,
                    dev.dev_start_date,
                    dev.dev_end_date,
                    dev.dev_hour,
                    dev.dev_place,
                    devb.devb_name
                FROM 
                    " . $this->hr_db . ".hr_dev_developperson AS devps
                INNER JOIN 
                    " . $this->hr_db . ".hr_dev_develop AS dev ON dev.dev_id = devps.devps_dev_id
                INNER JOIN 
                    " . $this->hr_db . ".hr_person AS ps ON ps.ps_id = devps.devps_ps_id
                INNER JOIN 
                    " . $this->hr_db . ".hr_base_prefix AS pf ON pf.pf_id = ps.ps_pf_id
                INNER JOIN 
                    " . $this->hr_db . ".hr_dev_heading AS devh ON devh.devh_id = dev.dev_topic
                INNER JOIN 
                    " . $this->hr_db . ".hr_base_develop_type AS devb ON devb.devb_id = dev.dev_go_service_type
                WHERE 
                    devps.devps_status = ?
            ) AS main
            INNER JOIN (
                SELECT 
                    devps_ps_id, 
                    SUM(dev.dev_hour) AS total_hours
                FROM 
                    " . $this->hr_db . ".hr_dev_developperson AS devps
                INNER JOIN 
                    " . $this->hr_db . ".hr_dev_develop AS dev ON dev.dev_id = devps.devps_dev_id
                GROUP BY 
                    devps_ps_id
            ) AS totals ON main.devps_ps_id = totals.devps_ps_id
            ORDER BY 
                main.devps_ps_id, dev_seq";

        $query = $this->hr->query($sql, array($status));
        return $query;
    }
} // end class M_hr_person
