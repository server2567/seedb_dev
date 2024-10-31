<?php
/*
 *  M_ams_base_alarm
 *  Model for Manage about ams_base_alarm Table
 *  @Auther Dechathon Prajit 
 *  @Crreate Date 19/06/2024
 */

include_once("Da_ams_notification_result.php");
class M_ams_notification_result extends Da_ams_notification_result
{
    public function check_apm_id_exists($apm_id) {
        $sql = "SELECT ntr_apm_id FROM see_amsdb.ams_notification_results WHERE ntr_apm_id = ?";
        $query = $this->ams->query($sql,array($apm_id));
        return $query->num_rows() > 0;
    }
    function update_if_apm_id_exists() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->ams_db.".ams_notification_results 
                SET 
                    ntr_pt_id = ?, 
                    ntr_ps_id = ?,
					ntr_ntf_id = ?,
					ntr_ast_id = ?,
                	ntr_update_user = ?, 
                    ntr_update_date = ?
                WHERE
                    ntr_apm_id = ?";
		$this->ams->query($sql, array(
			$this->ntr_pt_id,
			$this->ntr_ps_id,
			$this->ntr_ntf_id,
            $this->ntr_ast_id,
			$this->ntr_update_user,
			$this->ntr_update_date,
			$this->ntr_apm_id
		));
		
	}
    function get_all()
    {
        $sql = "SELECT 
                ntr.*,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = ntr.ntr_create_user) AS create_user_name,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = ntr.ntr_update_user) AS update_user_name
                FROM 
                " . $this->ams_db . ".ams_notification_results AS ntr";

        $query = $this->ams->query($sql);

        return $query;
    }

    /*
	* get_show_notification_server
	* get all noti results(exclude_ntr_ast_id = R, TW, TS) by doctor has owner
	* @input 
            include_ntr_ast_id, 
            ps_id(person id): id of doctor that owner patients, datatable params
            datatable info
	* @output list of ams notification result, total amount
	* @author Areerat Pongurai
	* @Create Date 30/07/2024
	*/
    function get_show_notification_server($include_ntr_ast_id, $ps_id, $start, $length, $order_column, $order_dir, $params) {
        $where_in = '';
        if (!empty($include_ntr_ast_id)) {
            if (empty($where_in)) $where_in .= " WHERE ";
            else $where_in .= " AND ";
            $include_ntr_ast_id_string = implode(", ", array_map(function($item) {
                return "'$item'";
            }, $include_ntr_ast_id));
            $where_in .= " ntr_ast_id IN (SELECT DISTINCT ast_id FROM ams_base_status WHERE ast_character IN ({$include_ntr_ast_id_string})) ";
        }
        if (!empty($ps_id)) {
            if (empty($where_in)) $where_in .= " WHERE ";
            else $where_in .= " AND ";
            $where_in .= " ntr_ps_id = {$ps_id} ";
        }
        $where = '';
        if(!empty($params)) {
            if (!empty($params['month'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['month'];
                $where .= " (MONTH(ntr_update_date) = '{$val}')";
            }

            if (!empty($params['date'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['date'];
		        $val = date('Y-m-d', strtotime($val));
                $where .= " (DATE(ntr_update_date) = '{$val}')";
            }

            if (!empty($params['pt_member'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['pt_member'];
                $where .= " (pt_member LIKE '%{$val}%')";
            }

            if (!empty($params['pt_name'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['pt_name'];
                $where .= " (pt_name LIKE '%{$val}%')";
            }

            if (!empty($params['ast_id'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['ast_id'];
                $where .= " (ntr_ast_id = {$val})";
            }

            if (!empty($params['search'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['search'];
                $where .= " (
                        (pt_name LIKE '%{$val}%') OR (ps_name LIKE '%{$val}%') OR 
                        (pt_member LIKE '%{$val}%') OR (ast_name LIKE '%{$val}%') OR 
                        (update_user_name LIKE '%{$val}%')
                      ) ";
            }
        }

        $sql_in = " SELECT 
                        ntr.ntr_id, 
                        ntr.ntr_ast_id, 
                        patient_data.pt_member,
                        CONCAT(patient_data.pt_prefix, ' ', patient_data.pt_fname, ' ', patient_data.pt_lname) AS pt_name,
                        CONCAT(prefix_data.pf_name_abbr, ' ', hr_data.ps_fname, ' ', hr_data.ps_lname) AS ps_name,
                        ntr.ntr_apm_id, 
                        CASE WHEN ntr.ntr_update_date IS NOT NULL THEN ntr.ntr_update_date ELSE ntr.ntr_create_date END AS ntr_update_date,
                        (SELECT us_name FROM " . $this->ums_db . ".ums_user WHERE us_id = (
                            CASE WHEN ntr.ntr_update_user IS NOT NULL THEN ntr.ntr_update_user ELSE ntr.ntr_create_user END)
                            ) AS update_user_name, 
                        ast.ast_name, 
                        ast.ast_color,
                        apm_visit,
                        stde_name_th
                    FROM see_amsdb.ams_notification_results AS ntr
                    LEFT JOIN (SELECT ast_id, ast_name, ast_color 
                                FROM ams_base_status) AS ast 
                        ON ast.ast_id = ntr.ntr_ast_id 
                    LEFT JOIN (SELECT pt_id, pt_member, pt_prefix, pt_fname, pt_lname
                                FROM see_umsdb.ums_patient ) AS patient_data
                        ON ntr.ntr_pt_id = patient_data.pt_id
                    LEFT JOIN (SELECT ps_id,ps_pf_id,ps_fname, ps_lname
                                FROM see_hrdb.hr_person ) AS hr_data
                        ON ntr.ntr_ps_id = hr_data.ps_id
                    LEFT JOIN (SELECT pf_id, pf_name_abbr 
                                FROM see_hrdb.hr_base_prefix ) AS prefix_data
                        ON hr_data.ps_pf_id = prefix_data.pf_id 
                    LEFT JOIN (SELECT apm_id, apm_visit, apm_stde_id FROM " . $this->que_db . ".que_appointment) AS apm ON ntr.ntr_apm_id = apm.apm_id
                    LEFT JOIN (SELECT stde_id, stde_name_th FROM " . $this->hr_db . ".hr_structure_detail) AS stde ON apm.apm_stde_id = stde.stde_id
                    {$where_in} ";
        
        // get total amount
        $count_sql = "SELECT COUNT(*) as total FROM ( " . $sql_in . ") AS a {$where} ";
        $count_query = $this->ams->query($count_sql);
        $total_records = $count_query->row()->total;

        // get data limit
        $sql = "SELECT * FROM ( " . $sql_in . ") AS a {$where} ";
        if (!empty($order_column) && !empty($order_dir))
            $sql .= " ORDER BY $order_column $order_dir";
        $sql .= " LIMIT ".(int)$start.",  ".(int)$length;
        $query = $this->ams->query($sql);

        return ['query' => $query, 'total_records' => $total_records];
    }

    function get_by_id($id) {
        $sql = "SELECT
                ntr.*,	
                patient_data.pt_prefix,
                patient_data.pt_fname,
                patient_data.pt_lname,
                patient_data.pt_member,
                patient_detail_data.ptd_img_type,
                patient_detail_data.ptd_img,
                patient_detail_data.ptd_img_code,
                appointment_data.apm_patient_type,
                appointment_data.apm_create_date,
                appointment_data.apm_visit,
                appointment_data.apm_ps_id, 
                appointment_data.apm_pt_id, 
                appointment_data.apm_stde_id, 
                appointment_data.apm_ds_id, 
                ds_data.ds_name_disease
            FROM
                see_amsdb.ams_notification_results AS ntr
            LEFT JOIN 
                (SELECT
                    pt_id,
                    pt_prefix,
                    pt_fname,
                    pt_lname,
                    pt_member
                FROM
                    see_umsdb.ums_patient
                ) AS patient_data
            ON ntr.ntr_pt_id = patient_data.pt_id
            LEFT JOIN 
                (SELECT
                    ptd_img_type,
                    ptd_img,
                    ptd_img_code,
                    ptd_pt_id
                FROM
                    see_umsdb.ums_patient_detail
                ) AS patient_detail_data
            ON ntr.ntr_pt_id = patient_detail_data.ptd_pt_id
            LEFT JOIN 
                (SELECT
                    apm_id,
                    apm_patient_type,
                    apm_create_date,
                    apm_ds_id,
                    apm_visit,
                    apm_ps_id, 
                    apm_pt_id, 
                    apm_stde_id
                FROM see_quedb.que_appointment
                ) AS appointment_data
            ON ntr.ntr_apm_id = appointment_data.apm_id
            LEFT JOIN
                (SELECT
                    ds_name_disease,
                    ds_id
                FROM see_wtsdb.wts_base_disease
                ) AS ds_data
            ON appointment_data.apm_ds_id = ds_data.ds_id
            WHERE ntr.ntr_id = ?";

                $query = $this->ams->query($sql, array($id));
                return $query;
            }

            function get_file_by_id($id)
            {
                $sql = "SELECT
            upload_data.ntup_path,
            upload_data.ntup_name_file
        FROM 
            see_amsdb.ams_notification_results AS ntr
        LEFT JOIN 
            (SELECT
                ntup_path,
                ntup_name_file,
                ntup_ntr_id
            FROM
                see_amsdb.ams_notification_upload 
                ) AS upload_data
            ON  ntr.ntr_id = upload_data.ntup_ntr_id

            WHERE ntr.ntr_id = ?";

            // LEFT JOIN 
            // (SELECT
            //     apm_pt_id,
            //     apm_patient_type,
            //     apm_create_date,
            //     apm_ds_id
            // FROM see_quedb.que_appointment
            // WHERE (apm_pt_id, apm_create_date) IN (
            //     SELECT
            //         apm_pt_id,
            //         MAX(apm_create_date) AS apm_create_date
            //     FROM see_quedb.que_appointment
            //     GROUP BY apm_pt_id
            // )
            // ) AS appointment_data
            // ON ntr.ntr_pt_id = appointment_data.apm_pt_id


        $query = $this->ams->query($sql, array($id));
        return $query;
    }

    /*
	* change_noti
	* change ntr_ast_id
	* @input 
            ntr_ast_id: status to change
            ntr_id: ams_notification_results id to change
	* @output -
	* @author Areerat Pongurai
	* @Create Date 25/07/2024f
	*/
    function change_noti() {
        $sql = "UPDATE 
                see_amsdb.ams_notification_results
            SET 
	            ntr_ast_id = ?
            WHERE 
                ntr_id = ? ";
        $query = $this->ams->query($sql, array(
            $this->ntr_ast_id,
            $this->ntr_id
        ));
    }

    /*
	* get_que_appointment_and_noti_wait_by_doctor_server
	* get all noti results(ntr_ast_id = 3, 5) and que appointment(apm_sta_id = 2) that wait for process by doctor 
	* @input ps_id(person id): id of doctor that owner patients, datatable params
	* @output list of que appointment wait for process
	* @author Areerat Pongurai
	* @Create Date 25/07/2024f
	*/
    function get_que_appointment_and_noti_wait_by_doctor_server($ps_id, $start, $length, $order_column, $order_dir, $params) {
        $where = '';
        if(!empty($params)) {
            if (!empty($params['month'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['month'];
                $where .= " (MONTH(ntr_update_date) = '{$val}')";
            }

            if (!empty($params['date'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['date'];
		        $val = date('Y-m-d', strtotime($val));
                $where .= " (DATE(ntr_update_date) = '{$val}')";
            }

            if (!empty($params['pt_member'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['pt_member'];
                $where .= " (pt_member LIKE '%{$val}%')";
            }

            if (!empty($params['pt_name'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['pt_name'];
                $where .= " (pt_name LIKE '%{$val}%')";
            }

            if (!empty($params['ast_id'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['ast_id'];
                $where .= " (ntr_ast_id = {$val})";
            }

            if (!empty($params['search'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['search'];
                $where .= " (
                        (pt_name LIKE '%{$val}%') OR (ps_name LIKE '%{$val}%') OR 
                        (pt_member LIKE '%{$val}%') OR (ast_name LIKE '%{$val}%') OR 
                        (update_user_name LIKE '%{$val}%')
                      ) ";
            }
        }

        // 20240809 ตัด ams_notification_results.ntr_ast_id = 'R' และ union ออก เพราะแพทย์จะไม่เห็นสถานะเหล่านี้แล้ว
        $sql_in = " SELECT 
                        ntr.ntr_id, 
                        ntr.ntr_ast_id, 
                        patient_data.pt_member,
                        CONCAT(patient_data.pt_prefix, ' ', patient_data.pt_fname, ' ', patient_data.pt_lname) AS pt_name,
                        CONCAT(prefix_data.pf_name_abbr, ' ', hr_data.ps_fname, ' ', hr_data.ps_lname) AS ps_name,
                        ntr.ntr_apm_id, 
                        CASE WHEN ntr.ntr_update_date IS NOT NULL THEN ntr.ntr_update_date ELSE ntr.ntr_create_date END AS ntr_update_date,
                        (SELECT us_name FROM " . $this->ums_db . ".ums_user WHERE us_id = (
                            CASE WHEN ntr.ntr_update_user IS NOT NULL THEN ntr.ntr_update_user ELSE ntr.ntr_create_user END)
                            ) AS update_user_name, 
                        ast.ast_name, 
                        ast.ast_color,
                        apm.apm_visit,
                        stde.stde_name_th
                    FROM 
                        ams_notification_results AS ntr 
                        LEFT JOIN (SELECT ast_id, ast_name, ast_color FROM ams_base_status) AS ast ON ast.ast_id = ntr.ntr_ast_id 
                        LEFT JOIN (SELECT pt_id, pt_member, pt_prefix, pt_fname, pt_lname FROM " . $this->ums_db . ".ums_patient) AS patient_data ON ntr.ntr_pt_id = patient_data.pt_id 
                        LEFT JOIN (SELECT ps_id, ps_pf_id, ps_fname, ps_lname FROM " . $this->hr_db . ".hr_person) AS hr_data ON ntr.ntr_ps_id = hr_data.ps_id 
                        LEFT JOIN (SELECT pf_id, pf_name_abbr FROM " . $this->hr_db . ".hr_base_prefix) AS prefix_data ON hr_data.ps_pf_id = prefix_data.pf_id 
                        LEFT JOIN (SELECT apm_id, apm_visit, apm_stde_id FROM " . $this->que_db . ".que_appointment) AS apm ON ntr.ntr_apm_id = apm.apm_id
                        LEFT JOIN (SELECT stde_id, stde_name_th FROM " . $this->hr_db . ".hr_structure_detail) AS stde ON apm.apm_stde_id = stde.stde_id
                    WHERE 
                        ntr.ntr_ast_id IN (SELECT DISTINCT ast_id FROM ams_base_status WHERE ast_character IN ('TW', 'TS')) 
                        AND ntr.ntr_ps_id = {$ps_id}  ";
                    // UNION 
                    // SELECT 
                    //     null AS ntr_id, 
                    //     3 AS ntr_ast_id, 
                    //     patient_data.pt_member, 
                    //     CONCAT(patient_data.pt_prefix, ' ', patient_data.pt_fname, ' ', patient_data.pt_lname) AS pt_name,
                    //     CONCAT(prefix_data.pf_name_abbr, ' ', hr_data.ps_fname, ' ', hr_data.ps_lname) AS ps_name,
                    //     apm.apm_id AS ntr_apm_id, 
                    //     CASE WHEN apm.apm_update_date IS NOT NULL THEN apm.apm_update_date ELSE apm.apm_create_date END AS ntr_update_date,
                    //     (SELECT us_name FROM " . $this->ums_db . ".ums_user WHERE us_id = (
                    //         CASE WHEN apm.apm_update_user IS NOT NULL THEN apm.apm_update_user ELSE apm.apm_create_user END)
                    //         ) AS update_user_name, 
                    //     ast.ast_name, 
                    //     ast.ast_color
                    // FROM 
                    //     " . $this->que_db . ".que_appointment apm 
                    //     LEFT JOIN (SELECT ast_id, ast_name, ast_color FROM ams_base_status) AS ast ON ast.ast_id = 3 
                    //     LEFT JOIN (SELECT pt_id, pt_member, pt_prefix, pt_fname, pt_lname FROM " . $this->ums_db . ".ums_patient) AS patient_data ON apm.apm_pt_id = patient_data.pt_id 
                    //     LEFT JOIN (SELECT ps_id, ps_pf_id, ps_fname, ps_lname FROM " . $this->hr_db . ".hr_person) AS hr_data ON apm.apm_ps_id = hr_data.ps_id 
                    //     LEFT JOIN (SELECT pf_id, pf_name_abbr FROM " . $this->hr_db . ".hr_base_prefix) AS prefix_data ON hr_data.ps_pf_id = prefix_data.pf_id 
                    // WHERE 
                    //     apm.apm_ps_id = {$ps_id}  
                    //     AND apm.apm_sta_id = 2 
                    //     AND apm.apm_id NOT IN (SELECT DISTINCT ntr_apm_id FROM ams_notification_results) ";
                        
        // get total amount
        $count_sql = "SELECT COUNT(*) as total FROM ( " . $sql_in . ") AS a {$where} ";
        $count_query = $this->ams->query($count_sql);
        $total_records = $count_query->row()->total;

        // get data limit
        $sql = "SELECT * FROM ( " . $sql_in . ") AS a {$where} ";
        if (!empty($order_column) && !empty($order_dir))
            $sql .= " ORDER BY $order_column $order_dir";
        $sql .= " LIMIT ".(int)$start.",  ".(int)$length;
        $query = $this->ams->query($sql);

        return ['query' => $query, 'total_records' => $total_records];
    }
 
    /*
	* get_by_apm_id
	* get noti results data by apm_id
	* @input apm_id(que_apponitment id): id of que_apponitment
	* @output noti results data
	* @author Areerat Pongurai
	* @Create Date 12/07/2024f
	*/   
    function get_by_apm_id($apm_id) {
        $sql = "SELECT
                ntr.*,	
                patient_data.pt_prefix,
                patient_data.pt_fname,
                patient_data.pt_lname,
                patient_data.pt_member,
                patient_detail_data.ptd_img_type,
                patient_detail_data.ptd_img_code,
                patient_detail_data.ptd_img,
                appointment_data.apm_patient_type,
                appointment_data.apm_create_date,
                appointment_data.apm_visit,
                ds_data.ds_name_disease
            FROM
                see_amsdb.ams_notification_results AS ntr
            LEFT JOIN 
                (SELECT
                    pt_id,
                    pt_prefix,
                    pt_fname,
                    pt_lname,
                    pt_member
                FROM
                    see_umsdb.ums_patient
                ) AS patient_data
            ON ntr.ntr_pt_id = patient_data.pt_id
            LEFT JOIN 
                (SELECT
                    ptd_img_type,
                    ptd_img_code,
                    ptd_img,
                    ptd_pt_id
                FROM
                    see_umsdb.ums_patient_detail
                ) AS patient_detail_data
            ON ntr.ntr_pt_id = patient_detail_data.ptd_pt_id
            LEFT JOIN 
                (SELECT
                    apm_id,
                    apm_patient_type,
                    apm_create_date,
                    apm_ds_id,
                    apm_visit
                FROM " . $this->que_db . ".que_appointment
                ) AS appointment_data
            ON ntr.ntr_apm_id = appointment_data.apm_id
            LEFT JOIN
                (SELECT
                    ds_name_disease,
                    ds_id
                FROM see_wtsdb.wts_base_disease
                ) AS ds_data
            ON appointment_data.apm_ds_id = ds_data.ds_id
            WHERE ntr.ntr_apm_id = ?";

        //     LEFT JOIN 
        //     (SELECT
        //         apm_pt_id,
        //         apm_patient_type,
        //         apm_create_date,
        //         apm_ds_id
        //     FROM " . $this->que_db . ".que_appointment
        //     WHERE (apm_pt_id, apm_create_date) IN (
        //         SELECT
        //             apm_pt_id,
        //             MAX(apm_create_date) AS apm_create_date
        //         FROM " . $this->que_db . ".que_appointment
        //         GROUP BY apm_pt_id
        //     )
        //     ) AS appointment_data
        // ON ntr.ntr_pt_id = appointment_data.apm_pt_id


        $query = $this->ams->query($sql, array($apm_id));
        return $query;
    }

    /*
	* get_ams_notification_by_status
	* get noti results data by status
	* @input status
	* @output noti results data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 15/07/2024
	*/   
    function get_ams_notification_by_status($ps_id, $status) {
        $sql = "SELECT 
				*
			FROM ".$this->ams_db.".ams_appointment AS ap
			LEFT JOIN ".$this->ams_db.".ams_notification_results AS ntr ON ntr.ntr_id = ap.ap_ntr_id
            LEFT JOIN ".$this->ams_db.".ams_base_status AS ast ON ast.ast_id = ntr.ntr_ast_id
            LEFT JOIN ".$this->ams_db.".ams_base_notify AS ntf ON ntf.ntf_id = ntr.ntr_ntf_id
			LEFT JOIN ".$this->hr_db.".hr_person ON ntr.ntr_ps_id = ps_id
			LEFT JOIN ".$this->hr_db.".hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN ".$this->que_db.".que_appointment AS que ON que.apm_id = ntr.ntr_apm_id
			LEFT JOIN ".$this->que_db.".que_code_list AS cl ON cl.cl_id = que.apm_cl_id
			LEFT JOIN ".$this->que_db.".que_base_department_keyword AS dpk ON dpk.dpk_keyword = cl.cl_dpk_keyword
			LEFT JOIN ".$this->ums_db.".ums_patient AS pt ON que.apm_pt_id = pt.pt_id
            LEFT JOIN ".$this->dim_db.".dim_examination_result AS exr ON exr.exr_ntr_id = ntr.ntr_id
            LEFT JOIN ".$this->eqs_db.".eqs_equipments AS eqs ON eqs.eqs_id = exr.exr_eqs_id 
            LEFT JOIN ".$this->eqs_db.".eqs_room AS rm ON rm.rm_id = eqs.eqs_rm_id
			WHERE ntr.ntr_ast_id IN ($status)				
            AND ntr.ntr_ps_id = {$ps_id}
            ORDER BY ap.ap_date ASC
        ";

        $query = $this->ams->query($sql);
        // echo  $this->ams->last_query();
        return $query;
    }

    /*
	* get_base_alarm
	* get noti results data by ntf_id
	* @input ntf_id
	* @output base_alarm_info
	* @author Jiradat Pomyai
	* @Create Date 26/07/2024
	*/   
    function get_ams_base_alarm($ntf_id)
    {
        $sql = "SELECT 
				*
			FROM ".$this->ams_db.".ams_base_alarm AS al
			WHERE al.al_ntf_id = $ntf_id
        ";
        $query = $this->ams->query($sql);
        // echo  $this->ams->last_query();
        return $query;
    }
    
    /*
	* get_ams_base_statuses
	* get all ams_base_status
	* @input exclude_ast_id
	* @output list of ams_base_statuses
	* @author Areerat Pongurai
	* @Create Date 30/07/2024
	*/   
    function get_ams_base_statuses($exclude_ast_id = []) {
        $where = '';
        if (!empty($exclude_ast_id)) {
            if (empty($where)) $where .= " WHERE ";
            else $where .= " AND ";
            $exclude_ast_id_string = implode(", ", array_map(function($item) {
                return "'$item'";
            }, $exclude_ast_id));
            $where .= " ast_character NOT IN ({$exclude_ast_id_string}) ";
        }
        $sql = "SELECT * FROM ".$this->ams_db.".ams_base_status {$where} ";
        $query = $this->ams->query($sql);
        return $query;
    }

    /*
	* get_ntr_by_apm_id
	* get noti results data by apm_id
	* @input apm_id(que_apponitment id): id of que_apponitment
	* @output noti results data
	* @author Areerat Pongurai
	* @Create Date 09/08/2024f
	*/   
    function get_ntr_by_apm_id($apm_id) {
        $sql = "SELECT *
                FROM ams_notification_results
                WHERE ntr_apm_id = ?";

        $query = $this->ams->query($sql, array($apm_id));
        return $query;
    }
    
    /*
	* get_all_exr_doc_of_patient
	* get noti results data by apm_id
	* @input 
            apm_id(que_apponitment id): id of que_apponitment
	* @output noti results data
	* @author Areerat Pongurai
	* @Create Date 09/08/2024f
	*/   
    // function get_all_exr_doc_of_patient($exr_eqs_id, $apm_ps_id) {
    //     $sql = "SELECT *
    //             FROM ams_notification_results
    //             WHERE ntr_apm_id = ?";

    //     $query = $this->ams->query($sql, array($apm_id));
    //     return $query;
    // }
}
