<?php
/*
 * M_hr_leave_summary
 * Model for Manage about hr_leave_summary Table.
 * @Author Patcharapol Sirimaneechot
 * @Create Date 07/10/2024
 */
include_once('Da_hr_leave_summary.php');

class M_hr_leave_summary extends Da_hr_leave_summary
{
	/*
	* get_all_leave_type
	* ดึงข้อมูลชนิดการลาทั้งหมด
	* @input -
	* @output leave_type all
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	// function delete_leave_control($id) {
	// 	try {
	// 		$query = $this->hr->query("DELETE FROM hr_leave_control WHERE ctrl_id = ?", array($id));
	// 		return $query;
	// 	} catch (e) {
	// 		return false;
	// 	}
	// }

    public $temp_hr_hire_is_medical_A = '
        CREATE TEMPORARY TABLE `temp_hr_hire_is_medical` (
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `code` varchar(255) NOT NULL,
        `detail` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci';

    public $temp_hr_hire_is_medical_B = '
        INSERT INTO `temp_hr_hire_is_medical` (`id`, `code`, `detail`) VALUES
        (1, "M", "สายการแพทย์"),
        (2, "N", "สายพยาบาล"),
        (4, "SM", "สายสนับสนุนทางการแพทย์"),
        (6, "A", "สายบริหาร"),
        (7, "T", "สายเทคนิคและบริการ")
        ';

    /*
	* get_all_user_leave_summary
	* ดึงข้อมูลสิทธิ์ลารายบุคคลตามปีเป้าหมายออกมาทั้งหมด 
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_all_user_leave_summary($carlendar_year) {  // function get_all_user_leave_summary($carlendar_year = "0000") {
		try {
			$sql = '
            -- v1.3.1.1
            -- (t1 use group by, t2 non use group by, with where lsum_year)
                        SELECT
                            IF(
                                l_sum_match_hr_person != "IS_NULL" AND T2.lsum_year = '.$this->db->escape_str($carlendar_year).',
                                "YES",
                                "NO"
                            ) AS final_found,

                            IF(
                                    T2.pos_work_start_date != "IS_NULL",
                                    "YES",
                                    "NO"
                                ) AS found_pos_work_start_date,

                            (
                                    CASE WHEN T2.lsum_date_cal_type = "custom_year" THEN DATEDIFF(
                                        DATE(T2.lsum_end_date_cal),
                                        DATE(T2.pos_work_start_date)
                                    ) WHEN T2.lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
                                        DATE(CONCAT('.$this->db->escape_str($carlendar_year).', "-01-1")),
                                        DATE(T2.pos_work_start_date)
                                    ) ELSE 0
                                END
                            ) AS work_experience_days,

							pf_name,
							pf_name_abbr,

                            T1.ps_fname,
                            T1.ps_lname,
                            T1.hire_abbr,
                            T1.detail,
                            T1.code,
                            T1.hire_type,
                            T1.pos_status,

                            T1.l_sum_match_hr_person,

                            T1.pos_ps_id "T1.pos_ps_id",
                            T2.pos_ps_id "T2.pos_ps_id",
                            T1.pos_dp_id "T1.pos_dp_id",
                            T2.pos_dp_id,
                            T1.pos_work_start_date "T1.pos_work_start_date",
                            T2.pos_work_start_date,
                            T1.pos_work_end_date "T1.pos_work_end_date",
                            T2.pos_work_end_date "T2.pos_work_end_date",
                            dp_id_is_match_for_get_work_start_date,
                            -- work_experience_days,
                            T1.lsum_id "T1.lsum_id",
                            T2.lsum_id,
                            T1.lsum_ps_id "T1.lsum_ps_id",
                            T2.lsum_ps_id "T2.lsum_ps_id",
                            T1.lsum_leave_id "T1.lsum_leave_id",
                            T2.lsum_leave_id,
                            T1.lsum_year "T1.lsum_year",
                            T2.lsum_year,
                            T1.lsum_work_age "T1.lsum_work_age",
                            T2.lsum_work_age "T2.lsum_work_age",
                            T1.lsum_per_day "T1.lsum_per_day",
                            T2.lsum_per_day "T2.lsum_per_day",
                            T1.lsum_per_hour "T1.lsum_per_hour",
                            T2.lsum_per_hour "T2.lsum_per_hour",
                            T1.lsum_per_minute "T1.lsum_per_minute",
                            T2.lsum_per_minute "T2.lsum_per_minute",
                            T1.lsum_num_day "T1.lsum_num_day",
                            T2.lsum_num_day "T2.lsum_num_day",
                            T1.lsum_num_hour "T1.lsum_num_hour",
                            T2.lsum_num_hour "T2.lsum_num_hour",
                            T1.lsum_num_minute "T1.lsum_num_minute",
                            T2.lsum_num_minute "T2.lsum_num_minute",
                            T1.lsum_remain_day "T1.lsum_remain_day",
                            T2.lsum_remain_day "T2.lsum_remain_day",
                            T1.lsum_remain_hour "T1.lsum_remain_hour",
                            T2.lsum_remain_hour "T2.lsum_remain_hour",
                            T1.lsum_remain_minute "T1.lsum_remain_minute",
                            T2.lsum_remain_minute "T2.lsum_remain_minute",
                            T1.lsum_leave_old "T1.lsum_leave_old",
                            T2.lsum_leave_old "T2.lsum_leave_old",
                            T1.lsum_date_cal_type "T1.lsum_date_cal_type",
                            T2.lsum_date_cal_type,
                            T1.lsum_dp_id "T1.lsum_dp_id",
                            T2.lsum_dp_id,
                            T1.lsum_start_date_cal "T1.lsum_start_date_cal",
                            T2.lsum_start_date_cal "T2.lsum_start_date_cal",
                            T1.lsum_end_date_cal "T1.lsum_end_date_cal",
                            T2.lsum_end_date_cal,
                            T1.lsum_update_date "T1.lsum_update_date",
                            T2.lsum_update_date "T2.lsum_update_date",
                            T1.lsum_update_user "T1.lsum_update_user",
                            T2.lsum_update_user "T2.lsum_update_user"
                        FROM
                            (
                            SELECT
                                *,
                        -- 		(
                        -- 			CASE WHEN lsum_date_cal_type = "custom_year" THEN DATEDIFF(
                        -- 				DATE(lsum_end_date_cal),
                        -- 				DATE(pos_work_start_date)
                        -- 			) WHEN lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
                        -- 				DATE(CONCAT("2023", "-01-1")),
                        -- 				DATE(pos_work_start_date)
                        -- 			) ELSE 0
                        -- 		END
                        -- ) AS work_experience_days,
                        IFNULL(
                            hr_leave_summary.lsum_ps_id,
                            "IS_NULL"
                        ) AS l_sum_match_hr_person
                        FROM
                            hr_person
                        LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                        LEFT JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id
                        LEFT JOIN hr_hire_is_medical ON hr_base_hire.hire_is_medical = hr_hire_is_medical.code
                        LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                        GROUP BY
                            hr_person.ps_id
                        ORDER BY
                            hr_person.ps_id
                        ) AS T1
                        LEFT JOIN(
                            SELECT DISTINCT
                                lsum_year,
                                ps_id,
                                ps_pf_id,
                                ps_fname,
                                ps_lname,
                                ps_fname_en,
                                ps_lname_en,
                                ps_nickname,
                                ps_nickname_en,
                                ps_status,
                                ps_create_user,
                                ps_create_date,
                                ps_update_user,
                                ps_update_date,
                                pos_id,
                                pos_ps_id,
                                pos_dp_id,
                                pos_ps_code,
                                pos_hire_id,
                                pos_trial_day,
                                pos_admin_id,
                                pos_alp_id,
                                pos_spcl_id,
                                pos_retire_id,
                                pos_status,
                                pos_out_desc,
                                pos_attach_file,
                                pos_work_start_date,
                                pos_work_end_date,
                                pos_desc,
                                pos_count_work,
                                pos_active,
                                pos_create_user,
                                pos_create_date,
                                pos_update_user,
                                pos_update_date,
                                lsum_id,
                                lsum_ps_id,
                                lsum_leave_id,
                                lsum_work_age,
                                lsum_per_day,
                                lsum_per_hour,
                                lsum_per_minute,
                                lsum_num_day,
                                lsum_num_hour,
                                lsum_num_minute,
                                lsum_remain_day,
                                lsum_remain_hour,
                                lsum_remain_minute,
                                lsum_leave_old,
                                lsum_date_cal_type,
                                lsum_dp_id,
                                lsum_start_date_cal,
                                lsum_end_date_cal,
                                lsum_update_date,
                                lsum_update_user,
                                IF(
                                    pos_dp_id = lsum_dp_id,
                                    "YES",
                                    "NO"
                                ) AS dp_id_is_match_for_get_work_start_date
                            FROM
                                `hr_person`
                            LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                            LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                            WHERE
                                pos_dp_id = lsum_dp_id AND lsum_ps_id IS NOT NULL AND
                                (ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
                            GROUP BY
                                lsum_ps_id
                                -- T2A
                            UNION ALL
                        SELECT DISTINCT
                            lsum_year,
                            ps_id,
                            ps_pf_id,
                            ps_fname,
                            ps_lname,
                            ps_fname_en,
                            ps_lname_en,
                            ps_nickname,
                            ps_nickname_en,
                            ps_status,
                            ps_create_user,
                            ps_create_date,
                            ps_update_user,
                            ps_update_date,
                            pos_id,
                            pos_ps_id,
                            pos_dp_id,
                            pos_ps_code,
                            pos_hire_id,
                            pos_trial_day,
                            pos_admin_id,
                            pos_alp_id,
                            pos_spcl_id,
                            pos_retire_id,
                            pos_status,
                            pos_out_desc,
                            pos_attach_file,
                            pos_work_start_date,
                            pos_work_end_date,
                            pos_desc,
                            pos_count_work,
                            pos_active,
                            pos_create_user,
                            pos_create_date,
                            pos_update_user,
                            pos_update_date,
                            lsum_id,
                            lsum_ps_id,
                            lsum_leave_id,
                            lsum_work_age,
                            lsum_per_day,
                            lsum_per_hour,
                            lsum_per_minute,
                            lsum_num_day,
                            lsum_num_hour,
                            lsum_num_minute,
                            lsum_remain_day,
                            lsum_remain_hour,
                            lsum_remain_minute,
                            lsum_leave_old,
                            lsum_date_cal_type,
                            lsum_dp_id,
                            lsum_start_date_cal,
                            lsum_end_date_cal,
                            lsum_update_date,
                            lsum_update_user,
                            IF(
                                pos_dp_id = lsum_dp_id,
                                "YES",
                                "NO"
                            ) AS dp_id_is_match_for_get_work_start_date
                        FROM
                            `hr_person`
                        LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                        LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                        WHERE
                            pos_dp_id = lsum_dp_id AND ISNULL(hr_leave_summary.lsum_ps_id) AND 
                        (ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
                            -- T2B
                        ) AS T2
                        ON
                            T1.ps_id = T2.ps_id

						LEFT JOIN hr_base_prefix
			    			ON T1.ps_pf_id = hr_base_prefix.pf_id
			';
            /* 
                need to use these fields name:
			        T2.pos_work_start_date , T2.pos_dp_id, T2.lsum_id, T2.lsum_year, T2.lsum_leave_id, T2.lsum_date_cal_type, T2.lsum_dp_id, T2.lsum_end_date_cal
			*/

			$query = $this->hr->query($sql, array())->result_array();
			
			
			return $query;
		} catch (e) {
			return false;
		}
	}

    /*
	* get_filter_options
	* ดึงข้อมูลที่ใช้เป็นตัวเลือกสำหรับการกรองข้อมูลในหน้าแรก
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_filter_options() {
		try {
			$min_lsum_year = $this->hr->query("SELECT pos_work_start_date FROM `hr_person_position` WHERE pos_work_start_date IS NOT NULL AND pos_work_start_date != '' AND pos_work_start_date = ( SELECT MIN(pos_work_start_date) FROM hr_person_position ) ORDER BY pos_work_start_date asc")->result_array();
			
			$query["lsum_year"] = array();
			
			array_push($query["lsum_year"], substr($min_lsum_year[0]["pos_work_start_date"], 0, 4));

			$currentYear = date("Y");
			for ($i = (int)($query["lsum_year"][0]) + 1; $i <= $currentYear; $i++) {
					array_unshift($query["lsum_year"], $i);
				}
			
			$query["hire_is_medical"] = $this->hr->query("SELECT * FROM hr_hire_is_medical")->result_array();

			//  hr_base_hire.hire_type “ข้อมูลพื้นฐานประเภทบุคลากร” //  	ประเภทพนักงาน(1=เต็มเวลา,2= บางเวลา) 
			//  hr_person_position.pos_status  					// 		สถานะปัจจุบัน 1=> ปฏิบัติงานอยู่, 2=> ลาออกแล้ว 
			return $query;
		} catch (e) {
			return false;
		}
	}

    /*
	* get_leave_summary_by_condition
	* ดึงข้อมูลสิทธิ์ลารายบุคคลตามปีเป้าหมาย โดยมีการกรองเงื่อนไขออกมา
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_leave_summary_by_condition($carlendar_year, $hire_is_medical_id, $hire_type, $work_status) {
		// -99 mean that param not recieved
		// -99 mean get all data (no need to use that param for write condition in sql statement)

		/*** edit query string ***/ 
		
		$main_statement = '
        -- v1.3.1.1
        -- (t1 use group by, t2 non use group by, with where lsum_year)
			SELECT
                IF(
					l_sum_match_hr_person != "IS_NULL" AND T2.lsum_year = '.$this->db->escape_str($carlendar_year).',
					"YES",
					"NO"
				) AS final_found,

                IF(
						T2.pos_work_start_date != "IS_NULL",
						"YES",
						"NO"
					) AS found_pos_work_start_date,

                (
                        CASE WHEN T2.lsum_date_cal_type = "custom_year" THEN DATEDIFF(
                            DATE(T2.lsum_end_date_cal),
                            DATE(T2.pos_work_start_date)
                        ) WHEN T2.lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
                            DATE(CONCAT('.$this->db->escape_str($carlendar_year).', "-01-1")),
                            DATE(T2.pos_work_start_date)
                        ) ELSE 0
                    END
                ) AS work_experience_days,

				pf_name,
				pf_name_abbr,

				T1.ps_fname,
				T1.ps_lname,
				T1.hire_abbr,
				T1.detail,
				T1.code,
				T1.hire_type,
				T1.pos_status,

				T1.l_sum_match_hr_person,

				T1.pos_ps_id "T1.pos_ps_id",
				T2.pos_ps_id "T2.pos_ps_id",
				T1.pos_dp_id "T1.pos_dp_id",
				T2.pos_dp_id,
				T1.pos_work_start_date "T1.pos_work_start_date",
				T2.pos_work_start_date,
				T1.pos_work_end_date "T1.pos_work_end_date",
				T2.pos_work_end_date "T2.pos_work_end_date",
				dp_id_is_match_for_get_work_start_date,
				-- work_experience_days,
				T1.lsum_id "T1.lsum_id",
				T2.lsum_id,
				T1.lsum_ps_id "T1.lsum_ps_id",
				T2.lsum_ps_id "T2.lsum_ps_id",
				T1.lsum_leave_id "T1.lsum_leave_id",
				T2.lsum_leave_id,
				T1.lsum_year "T1.lsum_year",
				T2.lsum_year,
				T1.lsum_work_age "T1.lsum_work_age",
				T2.lsum_work_age "T2.lsum_work_age",
				T1.lsum_per_day "T1.lsum_per_day",
				T2.lsum_per_day "T2.lsum_per_day",
				T1.lsum_per_hour "T1.lsum_per_hour",
				T2.lsum_per_hour "T2.lsum_per_hour",
				T1.lsum_per_minute "T1.lsum_per_minute",
				T2.lsum_per_minute "T2.lsum_per_minute",
				T1.lsum_num_day "T1.lsum_num_day",
				T2.lsum_num_day "T2.lsum_num_day",
				T1.lsum_num_hour "T1.lsum_num_hour",
				T2.lsum_num_hour "T2.lsum_num_hour",
				T1.lsum_num_minute "T1.lsum_num_minute",
				T2.lsum_num_minute "T2.lsum_num_minute",
				T1.lsum_remain_day "T1.lsum_remain_day",
				T2.lsum_remain_day "T2.lsum_remain_day",
				T1.lsum_remain_hour "T1.lsum_remain_hour",
				T2.lsum_remain_hour "T2.lsum_remain_hour",
				T1.lsum_remain_minute "T1.lsum_remain_minute",
				T2.lsum_remain_minute "T2.lsum_remain_minute",
				T1.lsum_leave_old "T1.lsum_leave_old",
				T2.lsum_leave_old "T2.lsum_leave_old",
				T1.lsum_date_cal_type "T1.lsum_date_cal_type",
				T2.lsum_date_cal_type,
				T1.lsum_dp_id "T1.lsum_dp_id",
				T2.lsum_dp_id,
				T1.lsum_start_date_cal "T1.lsum_start_date_cal",
				T2.lsum_start_date_cal "T2.lsum_start_date_cal",
				T1.lsum_end_date_cal "T1.lsum_end_date_cal",
				T2.lsum_end_date_cal,
				T1.lsum_update_date "T1.lsum_update_date",
				T2.lsum_update_date "T2.lsum_update_date",
				T1.lsum_update_user "T1.lsum_update_user",
				T2.lsum_update_user "T2.lsum_update_user"
			FROM
				(
				SELECT
					*,
			-- 		(
			-- 			CASE WHEN lsum_date_cal_type = "custom_year" THEN DATEDIFF(
			-- 				DATE(lsum_end_date_cal),
			-- 				DATE(pos_work_start_date)
			-- 			) WHEN lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
			-- 				DATE(CONCAT("2023", "-01-1")),
			-- 				DATE(pos_work_start_date)
			-- 			) ELSE 0
			-- 		END
			-- ) AS work_experience_days,
			IFNULL(
				hr_leave_summary.lsum_ps_id,
				"IS_NULL"
			) AS l_sum_match_hr_person
			FROM
				hr_person
			LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
			LEFT JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id
			LEFT JOIN hr_hire_is_medical ON hr_base_hire.hire_is_medical = hr_hire_is_medical.code
			LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
			GROUP BY
				hr_person.ps_id
			ORDER BY
				hr_person.ps_id
			) AS T1
			LEFT JOIN(
				SELECT DISTINCT
					lsum_year,
					ps_id,
					ps_pf_id,
					ps_fname,
					ps_lname,
					ps_fname_en,
					ps_lname_en,
					ps_nickname,
					ps_nickname_en,
					ps_status,
					ps_create_user,
					ps_create_date,
					ps_update_user,
					ps_update_date,
					pos_id,
					pos_ps_id,
					pos_dp_id,
					pos_ps_code,
					pos_hire_id,
					pos_trial_day,
					pos_admin_id,
					pos_alp_id,
					pos_spcl_id,
					pos_retire_id,
					pos_status,
					pos_out_desc,
					pos_attach_file,
					pos_work_start_date,
					pos_work_end_date,
					pos_desc,
					pos_count_work,
					pos_active,
					pos_create_user,
					pos_create_date,
					pos_update_user,
					pos_update_date,
					lsum_id,
					lsum_ps_id,
					lsum_leave_id,
					lsum_work_age,
					lsum_per_day,
					lsum_per_hour,
					lsum_per_minute,
					lsum_num_day,
					lsum_num_hour,
					lsum_num_minute,
					lsum_remain_day,
					lsum_remain_hour,
					lsum_remain_minute,
					lsum_leave_old,
					lsum_date_cal_type,
					lsum_dp_id,
					lsum_start_date_cal,
					lsum_end_date_cal,
					lsum_update_date,
					lsum_update_user,
					IF(
						pos_dp_id = lsum_dp_id,
						"YES",
						"NO"
					) AS dp_id_is_match_for_get_work_start_date
				FROM
					`hr_person`
				LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
				LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
				WHERE
					pos_dp_id = lsum_dp_id AND lsum_ps_id IS NOT NULL AND
					(ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
				GROUP BY
					lsum_ps_id
					-- T2A
				UNION ALL
			SELECT DISTINCT
				lsum_year,
				ps_id,
				ps_pf_id,
				ps_fname,
				ps_lname,
				ps_fname_en,
				ps_lname_en,
				ps_nickname,
				ps_nickname_en,
				ps_status,
				ps_create_user,
				ps_create_date,
				ps_update_user,
				ps_update_date,
				pos_id,
				pos_ps_id,
				pos_dp_id,
				pos_ps_code,
				pos_hire_id,
				pos_trial_day,
				pos_admin_id,
				pos_alp_id,
				pos_spcl_id,
				pos_retire_id,
				pos_status,
				pos_out_desc,
				pos_attach_file,
				pos_work_start_date,
				pos_work_end_date,
				pos_desc,
				pos_count_work,
				pos_active,
				pos_create_user,
				pos_create_date,
				pos_update_user,
				pos_update_date,
				lsum_id,
				lsum_ps_id,
				lsum_leave_id,
				lsum_work_age,
				lsum_per_day,
				lsum_per_hour,
				lsum_per_minute,
				lsum_num_day,
				lsum_num_hour,
				lsum_num_minute,
				lsum_remain_day,
				lsum_remain_hour,
				lsum_remain_minute,
				lsum_leave_old,
				lsum_date_cal_type,
				lsum_dp_id,
				lsum_start_date_cal,
				lsum_end_date_cal,
				lsum_update_date,
				lsum_update_user,
				IF(
					pos_dp_id = lsum_dp_id,
					"YES",
					"NO"
				) AS dp_id_is_match_for_get_work_start_date
			FROM
				`hr_person`
			LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
			LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
			WHERE
				pos_dp_id = lsum_dp_id AND ISNULL(hr_leave_summary.lsum_ps_id) AND 
			(ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
				-- T2B
			) AS T2
			ON
				T1.ps_id = T2.ps_id

			LEFT JOIN hr_base_prefix
			    ON T1.ps_pf_id = hr_base_prefix.pf_id
		';
    
    $main_statement .= " WHERE ";

		$and = " AND ";
		
		// filter by condition
		$hire_is_medical_id_condition = "code = ?";
		$hire_type_condition = "hire_type = ?";
		$work_status_condition = "T1.pos_status = ?";

		$myArray = array();

		if ($hire_is_medical_id == "-99" && $hire_type == "-99" && $work_status == "-99") {
			return $this->get_all_user_leave_summary($carlendar_year);
		} else {

			if($hire_is_medical_id != "-99") {
				$main_statement .= $hire_is_medical_id_condition;
				$main_statement .= $and;
				array_push($myArray, $hire_is_medical_id);
			}

			if($hire_type != "-99") {
				$main_statement .= $hire_type_condition;
				$main_statement .= $and;
				array_push($myArray, $hire_type);
			}

			if($work_status != "-99") {
				$main_statement .= $work_status_condition;
				array_push($myArray, $work_status);
			} else {
				// remove the " AND " string 	if last param not recieved (last param == "-99").
				$main_statement = substr($main_statement, 0, strlen($main_statement)-5); 
			}
		}

		$data = $this->hr->query($main_statement, $myArray);
		$data = $data->result_array();
		return $data;
	}

	// function get_all_leave_summary() {
	// 	try {
	// 		$query = $this->hr->query("SELECT * FROM hr_leave_summary")->result_array(); 
	// 		return $query;
	// 	} catch (e) {
	// 		return false;
	// 	}
	// }

	// function get_leave_summary_by_budget_year($year) {
	// 	try {
	// 		$query = $this->hr->query("SELECT * FROM `hr_leave_summary` WHERE lsum_year = ?", array($year))->result_array(); 
	// 		return $query;
	// 	} catch (e) {
	// 		return false;
	// 	}
	// }


    /*
	* get_base_info_for_cal_work_age
	* ดึงข้อมูลพื้นฐานที่ใช้สำหรับการคำนวณอายุงานของบุคลากรเป้าหมาย
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_base_info_for_cal_work_age($carlendar_year, $user_id) {
        /* Read Data

        // hire_abbr
        // detail

        // list all dp_id of target person

        // pos_work_start_date of target person (filter by selected dp_id)
            (send all pos_work_start_date of target person to client and process at client)

        // lsum_date_cal_type of target person and year

        // lsum_dp_id of target person and year (get current selected lsum_dp_id)

        // lsum_end_date_cal of target person and year
        
            - update lsum_end_date_cal with lastest setting (when user set new setting)

            - get lsum_end_date_cal from first l_sum data, 
              because the lsum_end_date_cal value of all l_sum data of target year and person is be same

    */
        try {
            $data['pos_work_start_date_with_dp_id'] = $this->hr->query($this->temp_hr_hire_is_medical_A);
            $data['pos_work_start_date_with_dp_id'] = $this->hr->query($this->temp_hr_hire_is_medical_B);

            // pos_work_start_date_with_dp_id
            $sql1 = '
                SELECT pos_dp_id, dp_name_th, pos_work_start_date, hire_name, hire_abbr, hire_type, hire_is_medical, detail 
                FROM '. $this->hr_db .'.hr_person_position 
                INNER JOIN '. $this->ums_db .'.ums_department ON pos_dp_id = dp_id 
                INNER JOIN '. $this->hr_db .'.hr_base_hire ON pos_hire_id = hire_id 
                INNER JOIN temp_hr_hire_is_medical ON hire_is_medical = code
                WHERE pos_ps_id = '.$this->db->escape_str($user_id);

            $data['pos_work_start_date_with_dp_id'] = $this->hr->query($sql1)->result_array();

            // get_current_selected_base_info
            // $sql2 = "
            //     SELECT lsum_date_cal_type, lsum_dp_id, lsum_end_date_cal FROM `hr_leave_summary` WHERE lsum_ps_id = ".$this->db->escape_str($user_id)." AND lsum_year = '".$this->db->escape_str($carlendar_year)."'";
            
            $sql2 = "
                SELECT DISTINCT lsum_date_cal_type, lsum_dp_id, lsum_end_date_cal FROM `hr_leave_summary` WHERE lsum_ps_id = ".$this->db->escape_str($user_id)." AND lsum_year = '".$this->db->escape_str($carlendar_year)."' ORDER BY lsum_id ASC";

            $data['get_current_selected_base_info'] = $this->hr->query($sql2)->result_array();

            return $data;
		}   catch (e) {
			return false;
		}
	}

    /* Read Data
        
        // l_sum data of target person and year

    */

    /* Update Data
        // lsum_work_age

        // lsum_dp_id

        // lsum_date_cal_type

        // lsum_start

        // lsum_end_date

            - update lsum_end_date with lastest setting (when user set new setting)


    */

	/*
	* get_target_user_leave_summary
	* ดึงข้อมูลสิทธิ์ลารายบุคคลตามปีเป้าหมายของบุคลากรเป้าหมาย
	* @input -
	* @output -
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/
	function get_target_user_leave_summary($carlendar_year, $user_id) {  // function get_all_user_leave_summary($carlendar_year = "0000") {
		try {
			$sql = '
            -- v1.3.1.1
            -- (t1 use group by, t2 non use group by, with where lsum_year)
                        SELECT
                            IF(
                                l_sum_match_hr_person != "IS_NULL" AND T2.lsum_year = '.$this->db->escape_str($carlendar_year).',
                                "YES",
                                "NO"
                            ) AS final_found,

                            IF(
                                    T2.pos_work_start_date != "IS_NULL",
                                    "YES",
                                    "NO"
                                ) AS found_pos_work_start_date,

                            (
                                    CASE WHEN T2.lsum_date_cal_type = "custom_year" THEN DATEDIFF(
                                        DATE(T2.lsum_end_date_cal),
                                        DATE(T2.pos_work_start_date)
                                    ) WHEN T2.lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
                                        DATE(CONCAT('.$this->db->escape_str($carlendar_year).', "-01-1")),
                                        DATE(T2.pos_work_start_date)
                                    ) ELSE 0
                                END
                            ) AS work_experience_days,

							pf_name,
							pf_name_abbr,

                            T1.ps_fname,
                            T1.ps_lname,
                            T1.hire_abbr,
                            T1.detail,
                            T1.code,
                            T1.hire_type,
                            T1.pos_status,

                            T1.l_sum_match_hr_person,

                            T1.pos_ps_id "T1.pos_ps_id",
                            T2.pos_ps_id "T2.pos_ps_id",
                            T1.pos_dp_id "T1.pos_dp_id",
                            T2.pos_dp_id,
                            T1.pos_work_start_date "T1.pos_work_start_date",
                            T2.pos_work_start_date,
                            T1.pos_work_end_date "T1.pos_work_end_date",
                            T2.pos_work_end_date "T2.pos_work_end_date",
                            dp_id_is_match_for_get_work_start_date,
                            -- work_experience_days,
                            T1.lsum_id "T1.lsum_id",
                            T2.lsum_id,
                            T1.lsum_ps_id "T1.lsum_ps_id",
                            T2.lsum_ps_id "T2.lsum_ps_id",
                            T1.lsum_leave_id "T1.lsum_leave_id",
                            T2.lsum_leave_id,
                            T1.lsum_year "T1.lsum_year",
                            T2.lsum_year,
                            T1.lsum_work_age "T1.lsum_work_age",
                            T2.lsum_work_age "T2.lsum_work_age",
                            T1.lsum_per_day "T1.lsum_per_day",
                            T2.lsum_per_day "T2.lsum_per_day",
                            T1.lsum_per_hour "T1.lsum_per_hour",
                            T2.lsum_per_hour "T2.lsum_per_hour",
                            T1.lsum_per_minute "T1.lsum_per_minute",
                            T2.lsum_per_minute "T2.lsum_per_minute",
                            T1.lsum_num_day "T1.lsum_num_day",
                            T2.lsum_num_day "T2.lsum_num_day",
                            T1.lsum_num_hour "T1.lsum_num_hour",
                            T2.lsum_num_hour "T2.lsum_num_hour",
                            T1.lsum_num_minute "T1.lsum_num_minute",
                            T2.lsum_num_minute "T2.lsum_num_minute",
                            T1.lsum_remain_day "T1.lsum_remain_day",
                            T2.lsum_remain_day "T2.lsum_remain_day",
                            T1.lsum_remain_hour "T1.lsum_remain_hour",
                            T2.lsum_remain_hour "T2.lsum_remain_hour",
                            T1.lsum_remain_minute "T1.lsum_remain_minute",
                            T2.lsum_remain_minute "T2.lsum_remain_minute",
                            T1.lsum_leave_old "T1.lsum_leave_old",
                            T2.lsum_leave_old "T2.lsum_leave_old",
                            T1.lsum_date_cal_type "T1.lsum_date_cal_type",
                            T2.lsum_date_cal_type,
                            T1.lsum_dp_id "T1.lsum_dp_id",
                            T2.lsum_dp_id,
                            T1.lsum_start_date_cal "T1.lsum_start_date_cal",
                            T2.lsum_start_date_cal "T2.lsum_start_date_cal",
                            T1.lsum_end_date_cal "T1.lsum_end_date_cal",
                            T2.lsum_end_date_cal,
                            T1.lsum_update_date "T1.lsum_update_date",
                            T2.lsum_update_date "T2.lsum_update_date",
                            T1.lsum_update_user "T1.lsum_update_user",
                            T2.lsum_update_user "T2.lsum_update_user"
                        FROM
                            (
                            SELECT
                                *,
                        -- 		(
                        -- 			CASE WHEN lsum_date_cal_type = "custom_year" THEN DATEDIFF(
                        -- 				DATE(lsum_end_date_cal),
                        -- 				DATE(pos_work_start_date)
                        -- 			) WHEN lsum_date_cal_type = "carlendar_year" THEN DATEDIFF(
                        -- 				DATE(CONCAT("2023", "-01-1")),
                        -- 				DATE(pos_work_start_date)
                        -- 			) ELSE 0
                        -- 		END
                        -- ) AS work_experience_days,
                        IFNULL(
                            hr_leave_summary.lsum_ps_id,
                            "IS_NULL"
                        ) AS l_sum_match_hr_person
                        FROM
                            hr_person
                        LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                        LEFT JOIN hr_base_hire ON hr_person_position.pos_hire_id = hr_base_hire.hire_id
                        LEFT JOIN hr_hire_is_medical ON hr_base_hire.hire_is_medical = hr_hire_is_medical.code
                        LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                        GROUP BY
                            hr_person.ps_id
                        ORDER BY
                            hr_person.ps_id
                        ) AS T1
                        LEFT JOIN(
                            SELECT DISTINCT
                                lsum_year,
                                ps_id,
                                ps_pf_id,
                                ps_fname,
                                ps_lname,
                                ps_fname_en,
                                ps_lname_en,
                                ps_nickname,
                                ps_nickname_en,
                                ps_status,
                                ps_create_user,
                                ps_create_date,
                                ps_update_user,
                                ps_update_date,
                                pos_id,
                                pos_ps_id,
                                pos_dp_id,
                                pos_ps_code,
                                pos_hire_id,
                                pos_trial_day,
                                pos_admin_id,
                                pos_alp_id,
                                pos_spcl_id,
                                pos_retire_id,
                                pos_status,
                                pos_out_desc,
                                pos_attach_file,
                                pos_work_start_date,
                                pos_work_end_date,
                                pos_desc,
                                pos_count_work,
                                pos_active,
                                pos_create_user,
                                pos_create_date,
                                pos_update_user,
                                pos_update_date,
                                lsum_id,
                                lsum_ps_id,
                                lsum_leave_id,
                                lsum_work_age,
                                lsum_per_day,
                                lsum_per_hour,
                                lsum_per_minute,
                                lsum_num_day,
                                lsum_num_hour,
                                lsum_num_minute,
                                lsum_remain_day,
                                lsum_remain_hour,
                                lsum_remain_minute,
                                lsum_leave_old,
                                lsum_date_cal_type,
                                lsum_dp_id,
                                lsum_start_date_cal,
                                lsum_end_date_cal,
                                lsum_update_date,
                                lsum_update_user,
                                IF(
                                    pos_dp_id = lsum_dp_id,
                                    "YES",
                                    "NO"
                                ) AS dp_id_is_match_for_get_work_start_date
                            FROM
                                `hr_person`
                            LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                            LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                            WHERE
                                pos_dp_id = lsum_dp_id AND lsum_ps_id IS NOT NULL AND
                                (ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
                            GROUP BY
                                lsum_ps_id
                                -- T2A
                            UNION ALL
                        SELECT DISTINCT
                            lsum_year,
                            ps_id,
                            ps_pf_id,
                            ps_fname,
                            ps_lname,
                            ps_fname_en,
                            ps_lname_en,
                            ps_nickname,
                            ps_nickname_en,
                            ps_status,
                            ps_create_user,
                            ps_create_date,
                            ps_update_user,
                            ps_update_date,
                            pos_id,
                            pos_ps_id,
                            pos_dp_id,
                            pos_ps_code,
                            pos_hire_id,
                            pos_trial_day,
                            pos_admin_id,
                            pos_alp_id,
                            pos_spcl_id,
                            pos_retire_id,
                            pos_status,
                            pos_out_desc,
                            pos_attach_file,
                            pos_work_start_date,
                            pos_work_end_date,
                            pos_desc,
                            pos_count_work,
                            pos_active,
                            pos_create_user,
                            pos_create_date,
                            pos_update_user,
                            pos_update_date,
                            lsum_id,
                            lsum_ps_id,
                            lsum_leave_id,
                            lsum_work_age,
                            lsum_per_day,
                            lsum_per_hour,
                            lsum_per_minute,
                            lsum_num_day,
                            lsum_num_hour,
                            lsum_num_minute,
                            lsum_remain_day,
                            lsum_remain_hour,
                            lsum_remain_minute,
                            lsum_leave_old,
                            lsum_date_cal_type,
                            lsum_dp_id,
                            lsum_start_date_cal,
                            lsum_end_date_cal,
                            lsum_update_date,
                            lsum_update_user,
                            IF(
                                pos_dp_id = lsum_dp_id,
                                "YES",
                                "NO"
                            ) AS dp_id_is_match_for_get_work_start_date
                        FROM
                            `hr_person`
                        LEFT JOIN hr_person_position ON hr_person.ps_id = hr_person_position.pos_ps_id
                        LEFT JOIN hr_leave_summary ON hr_person.ps_id = hr_leave_summary.lsum_ps_id
                        WHERE
                            pos_dp_id = lsum_dp_id AND ISNULL(hr_leave_summary.lsum_ps_id) AND 
                        (ISNULL(lsum_year) OR(lsum_year = '.$this->db->escape_str($carlendar_year).'))
                            -- T2B
                        ) AS T2
                        ON
                            T1.ps_id = T2.ps_id 

						LEFT JOIN hr_base_prefix
						ON T1.ps_pf_id = hr_base_prefix.pf_id

						WHERE T1.pos_ps_id = '.$this->db->escape_str($user_id).'
			';
            /* 
                update usage fields name:
			        T1.pos_ps_id,

			*/

			$query = $this->hr->query($sql, array())->result_array();
			
			return $query;
		} catch (e) {
			return false;
		}
	}

}