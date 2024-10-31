<?php
/*
* M_hr_amphur
* Model for Manage about hr_base_amphur Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once("Da_hr_base.php");

class M_hr_base extends Da_hr_base
{

    /*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
    function get_all($aOrderBy = "")
    {
        $orderBy = "";
        if (is_array($aOrderBy)) {
            $orderBy .= "ORDER BY ";
            foreach ($aOrderBy as $key => $value) {
                $orderBy .= "$key $value, ";
            }
            $orderBy = substr($orderBy, 0, strlen($orderBy) - 2);
        }
        $sql = "SELECT *
				FROM " . $this->hr_db . ".hr_prefix
				$orderBy";
        $query = $this->hr->query($sql);
        return $query;
    }

    /*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values.
	 * you can delete this function if it not necessary.
	 */
    function get_options($optional = 'y')
    {
        $qry = $this->get_all();
        if ($optional == 'y') $opt[''] = '-----เลือก-----';
        foreach ($qry->result() as $row) {
            $opt[$row->PK_FIELD] = $row->FIELD_NAME;
        }
        return $opt;
    }
    // add your functions here

    function get_max_pf_seq_no()
    {
        // if there is no auto_increment field, please remove it
        $sql = "SELECT MAX(`pf_seq_no`) AS max FROM " . $this->hr_db . ".hr_prefix";
        $query = $this->hr->query($sql);
        if ($query->row()) {
            return $query->row()->max + 1;
        } else {
            return 1;
        }
    }

    /*
	* update active
	* update pf_active is "N"(not active) in database after form delete 
	* @input pf_id
	* @output -
	* @author Sarun
	* @Create Date 2559-06-22
	*/
    function update_active($active)
    {
        $sql = "UPDATE " . $this->hr_db . ".`hr_base_amphur` 
				SET `amph_active` = '" . $active . "' 
				WHERE `hr_base_amphur`.`amph_id` = ?;";
        $query = $this->hr->query($sql, array($this->amph_id));
    }

    /*
	* get_all_by_active
	* ดึงข้อมูลทั้ง 2 สถานะ เปิดใช้งาน/ปิดใช้งาน
	* @input -
	* @output รายชื่อข้อมูล
	* @author Jiradat Pomyai
	* @Create Date 2567-05-30
	*/
    function get_all_parent($base = "300012")
    {
        $sql = "SELECT * 
				FROM " . $this->ums_db . ".ums_menu 
				WHERE mn_parent_mn_id = '$base'
				";
        $query = $this->hr->query($sql);
        return $query;
    }
    function get_children_by_parent($parent)
    {
        $sql = "SELECT * 
				FROM " . $this->ums_db . ".ums_menu 
				WHERE mn_parent_mn_id = '$parent'
				";
        $query = $this->hr->query($sql);
        return $query;
    }
    function getActiveColumns($table_name)
    {
        $check_table_sql = "SHOW TABLES LIKE '$table_name'";
        $check_result = $this->hr->query($check_table_sql);
        // ถ้าตารางไม่มีอยู่ในฐานข้อมูล
        if ($check_result->num_rows() == 0) {
            return false;
        }
        // Query เพื่อดึงชื่อคอลัมน์จากตารางที่ระบุ
        $sql = "SHOW COLUMNS FROM $table_name";

        // สมมติว่าคุณใช้การเชื่อมต่อฐานข้อมูลผ่าน `$this->db` ใน CodeIgniter
        $result = $this->hr->query($sql);
        $columns = $result->result_array();

        // กรองเฉพาะคอลัมน์ที่มี "_active" ในชื่อ
        $active_columns = [];
        // pre($table_name);
        foreach ($columns as $column) {
            if (strpos($column['Field'], '_active') !== false) {
                $active_columns[] = $column['Field'];
            }
        }
        if (empty($active_columns)) {
            foreach ($columns as $column) {
                if (strpos($column['Field'], '_status') !== false) {
                    $active_columns[] = $column['Field'];
                }
            }
        }

        // ถ้าไม่พบทั้ง "_active" และ "_status" ให้คืนค่า false
        if (empty($active_columns)) {
            return false;
        }
        return $active_columns;  // คืนค่าชื่อคอลัมน์ที่มี "_active"
    }
    function count_data_children($database, $active)
    {
        // $var = [
        //     '300014' => 'pf_active',
        //     '300017' => 'nation_active',
        //     '300018' => 'race_active',
        //     '300019' => 'reli_active',
        //     '300020' => 'psst_active',
        //     '300021' => 'dist_active',
        //     '300022' => 'amph_active',
        //     '300023' => 'pv_active',
        //     '300024' => 'country_active',
        //     '300025' => 'edulv_active',
        //     '300026' => 'edudg_active',
        //     '300027' => 'edumj_active',
        //     '300028' => 'place_active',
        //     '300029' => 'voc_active',
        //     '300030' => '',
        //     '300031' => '',
        //     '300032' => '',
        //     '300033' => 'hire_active',
        //     '300034' => 'admin_active',
        //     '300035' => 'alp_active',
        //     '300036' => 'clnd_active',
        //     '300038' => 'spcl_active',
        //     '300047' => 'rwlv_active',
        //     '300048' => 'rwt_active',
        //     '1000014' => 'retire_active',
        //     '1000057' => 'exts_active',
        //     '1000064' => 'bwfw_active',
        //     '1000067' => 'devb_active',
        //     '1000070' => 'stpo_active'
        // ];
        if ($database == 'hr_base_education_place') {
            $database = 'hr_base_place';
        }
        $at = $this->getActiveColumns($database);
        if ($at != '') {
            $sql = "SELECT * FROM " . $this->hr_db . "." . $database .
                ($active == '300036' ?
                    " INNER JOIN hr_base_calendar_type on hr_base_calendar.clnd_type_date = hr_base_calendar_type.lct_id WHERE $at[0] != 2" :
                    " WHERE $at[0] != '2'");

            $query = $this->hr->query($sql);
        } else {
            $query = null;
        }
        return $query;
    }
    // function get_amphur_by_provice($pv_id)
    // {
    // 	$sql = "SELECT * 
    // 	FROM " . $this->hr_db . ".hr_base_amphur
    // 	WHERE amph_pv_id = '$pv_id'";
    // 	$query = $this->hr->query($sql);
    // 	return $query;
    // }
    /*
	* for json datatable
	* @input pf_active
	* @output prefix data
	* @author Phanuphan
	* @Create Date 2559-10-19
	*/
    function json_prefix($cond = '', $aColumns = '', $sWhere = '', $sOrder = '', $sLimit = '')
    {
        $con = '';
        //if($s_partyId!='') $con .= "AND ps.partyId = ".$s_partyId;
        //if($cond!='') $cond =" AND ".$cond; else $cond =" AND ps.fStatus = 1";
        $sql = "SELECT
					SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
				FROM 
					" . $this->hr_db . ".hr_prefix
				WHERE
					1 $sWhere
				$sOrder $sLimit";
        $query = $this->db->query($sql);
        return $query;
    }

    /*
	* get_prefix_pos
	* @input -
	* @output *
	* @author Ilada Paisarn
	* @Create Date 2559-10-25
	*/
    function get_prefix_pos()
    {
        $sql = "SELECT * FROM " . $this->hr_db . ".hr_prefix
				WHERE pf_name LIKE '%ศาสตราจารย์%' ";
        $query = $this->db->query($sql);
        return $query;
    }
} // end class M_hr_prefix
