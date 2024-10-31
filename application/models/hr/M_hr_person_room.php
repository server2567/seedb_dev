<?php
/*
 * M_hr_person_room
 * Model for Manage about hr_person_room Table.
 * @Author Areerat Pongurai
 * @Create Date 22/08/2024
 */
 
include_once("Da_hr_person_room.php");
class M_hr_person_room extends Da_hr_person_room{
	
    /*
	* get_by_date_and_ps_id
	* ดึงข้อมูลห้องที่แพทย์ประจำการ ณ วันนั้นๆ
	* @input params vvv
		date, 
		ps_id: กรณีต้องดูห้องประจำการของแพทย์นั้นๆ
	* $output Room where the doctor is on duty data
	* @Author Areerat Pongurai
	* @Create Date 22/08/2024
	*/
	function get_by_date_and_ps_id($params){
		$where = "";
        if (!empty($params['date'])) {
			if(empty($where)) $where = " WHERE ";
			else $where .= " AND ";
			$val = $params['date'];
			$where .= " DATE(psrm.psrm_date) = '{$val}'";
        } else {
			if(empty($where)) $where = " WHERE ";
			else $where .= " AND ";
            $sql .= " DATE(psrm.psrm_date) = CURDATE() ";
        }

        if (!empty($params['ps_id'])) {
			if(empty($where)) $where = " WHERE ";
			else $where .= " AND ";
			$val = $params['ps_id'];
			$where .= " psrm.psrm_ps_id = '{$val}'";
        } 

        $sql = "SELECT *
                FROM hr_person_room psrm
				LEFT JOIN ".$this->eqs_db.".eqs_room rm ON psrm.psrm_rm_id = rm.rm_id
				$where ";
		 
		 $query = $this->hr->query($sql);
		 return $query;
	}
	
    /*
	* update_rm_id
	* อัปเดตห้องของแพทย์ ณ วันนั้น
	* @input psrm_id, rm_id
	* $output -
	* @Author Areerat Pongurai
	* @Create Date 22/08/2024
	*/
	function update_rm_id(){
        $sql = "UPDATE hr_person_room 
                SET psrm_rm_id={$this->psrm_rm_id}
                WHERE psrm_id={$this->psrm_id}";
        $query = $this->hr->query($sql, array($this->psrm_rm_id, $this->psrm_id));
        return $query;
	}

	function get_doctor_announce() {
		$sql = "SELECT *
                FROM hr_person_room psrm
				LEFT JOIN ".$this->eqs_db.".eqs_room rm ON psrm.psrm_rm_id = rm.rm_id
		";
	}
	// get_by_date_and_ps_id
}	 //=== end class M_hr_person_room
?>