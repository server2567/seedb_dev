<?php

include_once(dirname(__FILE__)."/que_model.php");

/**
 * Class M_tk_create_tracking
 * @author Jirayus Arbking
 * @create_date 2020-08-24
 */
class M_que_code_history extends que_model
{
	function get_by_track_code($code)
	{
		$sql = "SELECT * FROM $this->que_db.que_code_history WHERE ch_cl_code = ? ORDER BY ch_create_user DESC";

		$result = $this->que->query($sql, array($code));
		return $result;
	}

	function insert_history($data_insert)
	{
		$this->que->insert($this->que_db . '.que_code_history', $data_insert);
	}

	function get_by_track_code_keyword($code, $keyword){
		$sql = "SELECT * FROM $this->que_db.que_code_history 
				WHERE ch_cl_code = ? AND ch_dpk_keyword = ? 
				ORDER BY ch_create_user  DESC";

		$result = $this->que->query($sql, array($code, $keyword));
		return $result;
	}
}
