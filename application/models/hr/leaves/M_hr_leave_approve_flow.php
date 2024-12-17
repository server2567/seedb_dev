<?php
/*
 * hr_leave_approve_flow
 * Model for Manage about hr_leave_approve_flow Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once("Da_hr_leave_approve_flow.php");

class M_hr_leave_approve_flow extends Da_hr_leave_approve_flow
{

    /*
	* get_leave_flow_all_by_lhis_id
	* ข้อมูลเส้นทางใบลา
	* @input $lhis_id
	* @output leave flow data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/10/2567
	*/
    function get_leave_flow_all_by_lhis_id($lhis_id)
    {
        $sql = "
			SELECT 
                lafw_id,
                lafw_seq,
                lafw_ps_id,
                lafw_laps_id,
                lafw_lapg_id,
                lafw_lhis_id,
                lafw_status,
                lafw_comment,
                lafw_update_user,
                lafw_update_date,
                last_name,
                last_mean,
                last_yes,
                last_no,
                lapg_name,
                lapg_type,
                ps_id,
                pf_name,
                ps_fname,
                ps_lname,
                pos_status,
                hire_name,
                alp_name,
                CONCAT('<ul>',
                    GROUP_CONCAT(
                        DISTINCT CONCAT('<li>', admin_name, '</li>')
                        SEPARATOR ''
                    ),
                    '</ul>'
                ) AS admin_position, 
                CASE 
                    WHEN hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire_is_medical = 'N' THEN 'สายพยาบาล'
                    WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE '(ไม่ระบุ)'
                END AS hire_is_medical_label
			
			FROM " . $this->hr_db . ".hr_leave_approve_flow 
            LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group ON lafw_lapg_id = lapg_id
            LEFT JOIN " . $this->hr_db . ".hr_base_leave_approve_status ON lafw_last_id = last_id
			LEFT JOIN " . $this->hr_db . ".hr_person ON lafw_ps_id = ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix ON ps_pf_id = pf_id
            LEFT JOIN " . $this->hr_db . ".hr_person_position ON pos_ps_id = ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_hire ON pos_hire_id = hire_id
            LEFT JOIN " . $this->hr_db . ".hr_person_admin_position ON pos_admin_id = psap_pos_id
            LEFT JOIN " . $this->hr_db . ".hr_base_adline_position ON pos_alp_id = alp_id
            LEFT JOIN " . $this->hr_db . ".hr_base_admin_position ON psap_admin_id = admin_id
			
			WHERE 
				lafw_lhis_id = {$lhis_id}
			GROUP BY lafw_id
			ORDER BY lafw_seq ASC";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_leave_flow_all_by_lhis_id

    function get_leave_for_approve_list_by_param($ps_id, $leave_id, $status, $start_date, $end_date)
    {
        $cond = "";

        if ($leave_id != "all") {
            $cond .= " AND lhis_leave_id = {$leave_id}";
        }

        if ($status != "all") {
            $cond .= " AND lafw_status = '{$status}'";
        }

        $sql = "
        SELECT 
           *
           
        FROM " . $this->hr_db . ".hr_leave_approve_flow
        LEFT JOIN " . $this->hr_db . ".hr_leave_history
            ON lafw_lhis_id = lhis_id 
		LEFT JOIN " . $this->hr_db . ".hr_leave
			ON lhis_leave_id = leave_id
        LEFT JOIN " . $this->hr_db . ".hr_person 
            ON lhis_ps_id = ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix 
            ON ps_pf_id = pf_id
        
        WHERE 
            lafw_ps_id = {$ps_id} 
			AND lhis_start_date >= '{$start_date}'
			AND lhis_end_date <= '{$end_date}'
			{$cond}
		GROUP BY lhis_id
        ORDER BY lhis_start_date DESC";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }

    function get_leave_approve_flow_by_param($lhis_id, $seq)
    {
        $cond = "";

        if ($seq != "") {
            $cond = " AND lafw_seq = {$seq}";
        }

        $sql = "
        SELECT 
           *
           
        FROM " . $this->hr_db . ".hr_leave_approve_flow
        LEFT JOIN " . $this->hr_db . ".hr_leave_history
            ON lafw_lhis_id = lhis_id 
		LEFT JOIN " . $this->hr_db . ".hr_leave
			ON lhis_leave_id = leave_id
        
        
        WHERE 
            lafw_lhis_id = {$lhis_id} 
            {$cond}";

        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    function get_leave_flow_by_id($lafw_id, $lafw_ps_id = '',$status = 'W')
    {
        $cond = "";

        if ($lafw_id) {
            $cond .= "lafw_lhis_id = {$lafw_id}";
        }

        if ($lafw_ps_id != '') {
            $cond .= " AND lafw_ps_id = '{$lafw_ps_id}'";
        }
        if ($status != '') {
            $cond .= " AND lafw_status = '{$status}'";
        }

        $sql = 'SELECT *  FROM ' . $this->hr_db . ".hr_leave_approve_flow WHERE {$cond} ";
        $query = $this->hr->query($sql);
        echo $this->hr->last_query();
        return $query;
    }
} // end class hr_leave_approve_flow
