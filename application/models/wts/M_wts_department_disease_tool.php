<?php
/*
* M_wts_department_disease_tool
* Model for Manage about wts_department_disease_tool Table.
* @input -
* $output -
* @author Areeat Pongurai
* @Create Date 05/08/2024
*/
include_once("Da_wts_department_disease_tool.php");

class M_wts_department_disease_tool extends Da_wts_department_disease_tool {
	
	/*
	* get_all_group_stde_disease
	* get stde(structure_detail [HR]) list that group by in wts_base_disease table
	* @input -
	* $output stde list
	* @author Areeat Pongurai
	* @Create Date 05/08/2024
	*/
	function get_all_group_stde_disease() {
		$sql = " SELECT ds_stde_id, stde_name_th, COUNT(ds_id) AS ds_amount
				 FROM wts_base_disease
				 LEFT JOIN ".$this->hr_db.".hr_structure_detail ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
				 WHERE ds_active != 2
				 GROUP BY ds_stde_id, stde_name_th ";
		$query = $this->wts->query($sql);

		return $query;		
	}
	
	/*
	* get_tools_disease_by_params
	* get tools that group in stde_id / ds_id
	* @input params
	* $output tool list
	* @author Areeat Pongurai
	* @Create Date 05/08/2024
	*/
	function get_tools_disease_by_params($params) {
        $where = 'WHERE eqs.eqs_active = 1 ';
        if(!empty($params)) {
            if (!empty($params['ddt_stde_id'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['ddt_stde_id'];
                $where .= " (ddt_stde_id = '{$val}') ";
            }
            if (!empty($params['ddt_ds_id'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $val = $params['ddt_ds_id'];
                $where .= " (ddt_ds_id = '{$val}') ";
            } 
			if (!empty($params['is_null_ddt_ds_id']) && empty($params['ddt_ds_id'])) {
                if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
                $where .= " (ddt_ds_id IS NULL) ";
			}
		}

		$sql = " SELECT ddt.*, eqs.eqs_rm_id
				 FROM wts_department_disease_tool ddt
				 LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = ddt.ddt_eqs_id
				 {$where}
				 ORDER BY ddt_stde_id, ddt_ds_id, ddt_seq ";

		$query = $this->wts->query($sql);
		return $query;
	}
	
	/*
	* get_diseases_by_stde
	* get diseases that group in stde_id
	* @input ddt_stde_id: structure_detail id [HR]
	* $output disease list
	* @author Areeat Pongurai
	* @Create Date 05/08/2024
	*/
	function get_diseases_by_stde() {
		$sql = " SELECT ds_id, ds_name_disease
				 FROM wts_base_disease
				 WHERE ds_stde_id = ?
				 ORDER BY ds_name_disease ";
		$query = $this->wts->query($sql, array($this->ddt_stde_id));

		return $query;
	}
	
	/*
	* delete_tools
	* delect exclude ddt_id
	* @input exclude_ids_string: wts_department_disease_tool id [WTS]
	* $output -
	* @author Areeat Pongurai
	* @Create Date 05/08/2024
	*/
	// function delete_tools($exclude_ids_string) {
	// 	if(!empty($exclude_ids_string)) {
	// 		$sql = "DELETE FROM wts_department_disease_tool
	// 				WHERE ddt_id NOT IN ({$exclude_ids_string})";

	// 		$this->wts->query($sql);
	// 	}
	// }

	/*
	* delete_tools_by_ds_stde
	* delete all row that where ddt_stde_id and ddt_ds_id
	* @input params
	* $output -
	* @author Areeat Pongurai
	* @Create Date 05/08/2024
	*/
	function delete_tools_by_ds_stde() {
        $where = '';
		if (!empty($this->ddt_stde_id)) {
			if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
			$val = $this->ddt_stde_id;
			$where .= " (ddt_stde_id = '{$val}') ";
		}
		if (!empty($this->ddt_ds_id)) {
			if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
			$val = $this->ddt_ds_id;
			$where .= " (ddt_ds_id = '{$val}') ";
		} else if(!empty($this->ddt_stde_id) && empty($this->ddt_ds_id)) {
			if (empty($where)) $where .= "WHERE "; else $where .= " AND ";
			$where .= " (ddt_ds_id IS NULL) ";
		}

		if(!empty($where)) {
			$sql = "DELETE FROM wts_department_disease_tool
					{$where}";

			$this->wts->query($sql);
		}
		 
	}
} // end class M_wts_department_disease_tool
?>
