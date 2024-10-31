<?php
include_once("Da_ums_user.php");

class M_ums_user extends Da_ums_user {

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($aOrderBy="", $is_active=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "CONVERT($key USING tis620) $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$where = "";
		if ( !empty($is_active) ) {
			$where = " AND us_active = " . $is_active;
		}
		$sql = "SELECT * ,ums_user.us_id as us_ums_id
			FROM ums_user 
			inner join ums_department on ums_department.dp_id = ums_user.us_dp_id 
			WHERE us_active <> 2 " . " $where
			$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}

	// function get_all_with_dp(){
	// 	$sql = "SELECT *
	// 			FROM umuser inner join umdepartment on umdepartment.dpID=umuser.UsDpID
	// 			WHERE UsDpID=?";
	// 	$query = $this->ums->query($sql,array($this->session->userdata('UsDpID')));
	// 	return $query;
	// }

	// function get_all_with_user(){
	// 	$sql = "SELECT UsID,UsName, UsLogin, umuser.UsDpID FROM umuser inner join umdepartment on umdepartment.dpID=umuser.UsDpID
	// 			";
	// 	$query = $this->ums->query($sql,array($this->session->userdata('UsDpID')));
	// 	return $query;
	// }
	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----àÅ×Í¡-----' by default.
	 * if you do not need the first list of select list is '-----àÅ×Í¡-----', please pass $optional parameter to other values.
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----àÅ×Í¡-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}

	// add your functions here
	function update_delete()
	{
		$sql = "UPDATE ums_user 
				SET	us_active=2, us_update_user=?, us_update_date=NOW()
				WHERE us_id=?";	
			
		$this->ums->query($sql, array($this->us_update_user, $this->us_id));
	}
	
	function check_login($username,$passwd)
	{
		$sql="SELECT * FROM ums_user inner join ums_department on ums_user.us_dp_id = ums_department.dp_id WHERE us_username=? and us_password=? and us_active=1";
		$query = $this->ums->query($sql,array($username,$passwd));
    // echo $this->ums->last_query();
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	function check_login_his($us_his_id)
	{
		$sql="SELECT * FROM ums_user inner join ums_department on ums_user.us_dp_id = ums_department.dp_id WHERE us_his_id=? and us_active=1";
		$query = $this->ums->query($sql,array($us_his_id));
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	function get_count_by_base_group($withSetAttributeValue=FALSE) {	
		$sql = "SELECT COUNT(us_id) count_us_id
				FROM ums_user 
				WHERE us_bg_id=?";
		$query = $this->ums->query($sql, array($this->us_bg_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_by_base_group_ids($us_bg_ids, $name=""){
		$where = "";
		if ( is_array($us_bg_ids) ) {
			$where.= " AND us.us_bg_id in ("; 
			foreach ($us_bg_ids as $key => $value) {
				$where.= "$value, ";
			}
			$where = substr($where, 0, strlen($where)-2);
			$where.= ")"; 
		}
		if ( !empty($name) ) {
			$where.= " AND us.us_name LIKE '%$name%'"; 
		}

		$sql = "SELECT us.*,  bg.*
			FROM ums_user us
			LEFT JOIN ums_base_group bg ON bg.bg_id = us.us_bg_id
			WHERE us.us_active <> 2 $where
			ORDER BY us.us_name ASC";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	// function getuserinfo($UsID)
	// {
	// 	$sql="SELECT UsID,UsName,UsLogin,WgNameT,UsEmail FROM umuser inner join umdepartment on umuser.UsDpID = umdepartment.dpID WHERE UsLogin=? ";
	// 	$query = $this->ums->query($sql,array($UsID));

	// 	if($query->num_rows()>0)
	// 	{
	// 		return $query;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	function check_user($username)
	{
		$sql="SELECT * FROM ums_user inner join ums_department on ums_user.us_dp_id = ums_department.dp_id WHERE us_username='$username' and us_active=1";
		$query = $this->ums->query($sql);

		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

  function get_data_for_redirect_um2dash($us_id)
  {
      $sql = "SELECT *
        FROM ums_usergroup
          LEFT JOIN ums_user ON ug_us_id = us_id
          LEFT JOIN ums_group ON ug_gp_id = gp_id
        WHERE ug_us_id = {$us_id} AND gp_st_id = 10";
      $query = $this->ums->query($sql);
     
      return $query;
  }

  function get_data_check_more_umusergroup($us_id)
  {
      $sql = "SELECT *  
                FROM ums_user
                  LEFT JOIN ums_usergroup ON ug_us_id = us_id
                WHERE us_id = {$us_id}";

      $query = $this->ums->query($sql);

      if ($query->num_rows() > 1) {
          return true;
      } else {
          return false;
      }
  }

  function update_sync_user()
  {
	$sql = "UPDATE ums_user 
			SET	us_name=?, us_email=?, us_ps_id=?, us_sync=?, us_update_user=?, us_update_date=NOW()
			WHERE us_id=?";	
		
	$this->ums->query($sql, array($this->us_name, $this->us_email, $this->us_ps_id, $this->us_sync, $this->us_update_user, $this->us_id));
  }

  function get_count_all_user_active() {	
	$sql = "SELECT COUNT(DISTINCT us_id) count_us_id
			FROM ums_user 
			WHERE us_active = 1";
	$query = $this->ums->query($sql);
	return $query ;
  }

// 	function check_pass($pass)
// 	{

// 		$sql="SELECT * FROM umuser WHERE UsID=? and UsPassword=? ";
// 		$passwd=md5("O]O".$pass."O[O");
// 		$query = $this->ums->query($sql,array($this->session->userdata('UsID'),$passwd));

// 		if($query->num_rows()>0)
// 		{
// 			return true;
// 		}
// 		else
// 		{
// 			return false;
// 		}

// 	}
// 	function forgotpassword() {
// 		$this->load->view('template/header');
// 		$this->load->view('template/topbar');
// 		$this->load->view('template/toolbar');
// 		$this->load->view('UMS/v_forgotpassword',$data);
// 		$this->load->view('template/footer');
// 		}

// 	function senntoemail($name,$email){
// 		$strSQL = "SELECT * FROM sentEmail WHERE username = '".trim($name)."'
// 		OR email = '".trim($email)."' ";
// 		$query = $this->ums->query($strSQL);
// 		$objRow = $query->num_rows();
// 		$objResult = $query->result_array();

// 		if($objRow==0)
// 		{
// 			return 0;
// 				 //echo "Not Found Username or Email!";
// 		}
// 		else
// 		{
// 				// "Your password send successful.<br>Send to mail : ".$objResult[0]["email"];

// 				 $strTo = $objResult[0]["email"];
// 				 $strSubject = "Your Account information username and password.";
// 				 $strHeader = "Content-type: text/html; charset=windows-874\n"; // or UTF-8 //
// 				 $strHeader .= "From: se.buu.ac.th;\nReply-To: se.buu.ac.th";
// 				 $strMessage = "";
// 				 $strMessage .= "Welcome : ".$objResult[0]["username"]."<br>";
// 				 $strMessage .= "Username : ".$objResult[0]["username"]."<br>";
// 				 $strMessage .= "Password : ".$objResult[0]["password"]."<br>";
// 				 $strMessage .= "=================================";
// 				ini_set("sendmail_from",$strTo);
// 				$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);
// 			return 1;
// 		}
// }

// 	function get_ID_by_name()
// 	{
// 		$sql = "SELECT UsID
// 				FROM umuser
// 				WHERE UsName = ?";
// 		$query = $this->ums->query($sql,array($this->UsName));
// 		if ( $withSetAttributeValue ) {
// 			$this->row2attribute( $query->row() );
// 		} else {
// 			return $query ;
// 		}

// 	}
// 	function get_by_dp()
// 	{
// 		$sql = "SELECT *
// 				FROM umuser inner join umdepartment on umdepartment.dpID=umuser.UsDpID
// 				WHERE UsDpID = ?";
// 		$query = $this->ums->query($sql,array($this->UsDpID));
// 		if ( $withSetAttributeValue ) {
// 			$this->row2attribute( $query->row() );
// 		} else {
// 			return $query ;
// 		}

// 	}

// 	function  show($data){
// 		$this->load->view('template/header');
// 		$this->load->view('template/topbar');
// 		$this->load->view('template/toolbar');
// 		$this->load->view('UMS/v_senttoemail',$data);
// 		$this->load->view('template/footer');
// 	}
	
// 	public function search() {


// 		if($strSearch=="Y"){
// 			$sql="select * from umuser Where ".$Search2." like '%".$Search."%' "; // à¸„à¸³à¸ªà¸±à¹ˆà¸‡à¸„à¹‰à¸™à¸«à¸²
// 				}else{
// 					$sql="select * from umuser";
// 				}
// 					$Qtotal = mysql_query($sql);
// 	}
	
// 	function checkUserByPsId ($ps_id) {
// 		$sql = "select * from umuser where UsPsCode =?";
// 		$result = $this->ums->query($sql, array($ps_id));
// 		if ($result->num_rows() <> 0) {
// 			return $result->row_array();
// 		} else {
// 			return false;
// 		}
// 	}

// 	function qryUmUserByUsPsCode($usPsCode){
// 		$sql = "select * from umuser where UsPsCode =?";
// 		$query = $this->ums->query($sql, array($usPsCode));
// 		return $query;
// 	}
	
// 	function check_username($username)
// 	{
// 	  $sql = "SELECT count(UsLogin) as num
// 			  FROM umuser
// 			  WHERE UsLogin = ?";
// 	  $query = $this->ums->query($sql, array($username));
// 	  return $query->row()->num;
// 	}
	
// 	function get_lastid()
// 	{
// 		$sql = "SELECT MAX(UsID) AS id FROM umuser";
// 		$query = $this->ums->query($sql);
// 		if($query->num_rows())
// 		{
// 			$row = $query->row();
// 			return $row->id;
// 		}
// 		else
// 		{
// 			return '0';
// 		}
// 	}
	
// 	function insert_ps() {
// 		$sql = "INSERT INTO umuser (UsID, UsName, UsLogin, UsPassword, UsPsCode, UsWgID, UsQsID, UsAnswer, UsEmail, UsActive, UsAdmin, UsDesc, UsPwdExpDt, UsUpdDt, UsUpdUsID, UsSessionID,UsDpID)
// 					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

// 			$this->ums->query($sql, array($this->UsID, $this->UsName, $this->UsLogin, $this->UsPassword, $this->UsPsCode, $this->UsWgID, $this->UsQsID, $this->UsAnswer, $this->UsEmail, $this->UsActive, $this->UsAdmin, $this->UsDesc, $this->UsPwdExpDt, $this->UsUpdDt, $this->UsUpdUsID, $this->UsSessionID, $this->UsDpID));
// 			$this->last_insert_id = $this->ums->insert_id();

// 		$sql = "INSERT INTO umusergroup (UgID,UgGpID, UgUsID)
// 				VALUES(?,?, ?)";
// 		$this->ums->query($sql, array(($this->last_id_umu()+1),$this->config->item('eoff_group_ps'), $this->last_insert_id));

// 	}

// 	function select_from_UsID ($usid) {
// 		$sql = "select * from umuser where UsID =?";
// 		$result = $this->ums->query($sql, array($usid));
// 		if ($result->num_rows() <> 0) {
// 			return $result->row_array();
// 		} else {
// 			return false;
// 		}
// 	}

	function check_password() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "SELECT count(*) AS count_data
			FROM ums_user 
			WHERE us_password=? AND us_id=?";
		$query = $this->ums->query($sql, array($this->us_password, $this->us_id));
		return $query;
	}

	function resetpassword() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE ums_user
              SET us_password=?, us_password_confirm=?
              WHERE us_id=?";
    $this->ums->query($sql, array($this->us_password,$this->us_password_confirm, $this->us_id));
	}

// 	function getAllForJSON($sWhere, $sOrder, $sLimit, $aColumns){
// 		$set_df=" ";
// 		// echo $sWhere;
// 		if($sWhere==" "){
// 			 $set_df=" ";
// 		 }else{
// 			$sWhere = " WHERE ".$sWhere; 
// 		}
// 		$sql = "SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
// 				FROM umuser inner join umdepartment on umdepartment.dpID=umuser.UsDpID
// 				$set_df $sWhere $sOrder	$sLimit";
// 		$query = $this->ums->query($sql);
// 		// echo $this->ums->last_query();die();
// 		return $query ;
// 	}

// 	function getFound(){
// 		$sql="SELECT FOUND_ROWS() as found";
// 		$query = $this->ums->query($sql);
// 		return $query;
// 	}

// 	function getRowAll($primaryKey,$table,$sWhere){
// 		$set_df=" ";
// 		if($sWhere==" "){
// 			$set_df =" WHERE 1 ";
// 		}else{
// 			$sWhere = " WHERE ".$sWhere; 
// 		}
// 		$sql = "SELECT COUNT(".$primaryKey.") as countall
// 				FROM   ".$table." $set_df $sWhere";
// 		$query = $this->ums->query($sql);
// 		return $query;
// 	}
	
// 	function get_permission_by_UsID($UsID){
// 		$sql = "SELECT  *
// 				FROM  umusergroup 
// 				LEFT JOIN umgroup ON UgGpID = GpID
// 				LEFT JOIN umsystem ON GpStID = StID
// 				WHERE UgUsID = ?";
// 		$query = $this->ums->query($sql,array($UsID));
// 		return $query;
// 	}
	
// 	function get_permission_by_StID($StID){
// 		$sql="SELECT GpID,GpNameT,UsName FROM  umgroup 
// 				LEFT JOIN umusergroup ON GpID = UgGpID
// 				INNER JOIN umuser ON UgUSID = UsID
// 				WHERE USWgID NOT IN (1,14,15,16) and GpStID =? ";
// 		$query = $this->ums->query($sql,array($StID));
// 		return $query;		
// 	}
	
// 	function get_all_no_admin(){
// 		$sql = "SELECT UsID,UsName, UsLogin, umuser.UsDpID 
// 				FROM umuser 
// 				LEFT JOIN umdepartment ON umdepartment.dpID=umuser.UsDpID
// 				WHERE UsWgID NOT IN (1,14,15,16)";
// 		$query = $this->ums->query($sql,array($this->session->userdata('UsDpID')));
// 		return $query;
// 	}
	
// 	function select_by_email($email){
// 		$sql="SELECT * FROM umuser WHERE UsEmail='$email'";
// 		$query = $this->ums->query($sql);

// 		if($query->num_rows()>0){
// 			return $query->row();
// 		}else{
// 			return false;
// 		}
// 	}
	
	// //########################################################
	// 	/*--------------------------------------
	// 		Function Name : getuserByWgIDANFStID
	// 		Creator : Nutchapon Lohitrut 
	// 		Last Edit By : Nutchapon Lohitrut
	// 		Last Update : 21/06/2561
	// 		Role : -
	// 		References : -
	// 		Variable : -
	// 		Paramiter : UsWgID
	// 	---------------------------------------*/ 
	// function getuserByWgIDANFStID($UsWgID){
	// 	$sql = "SELECT UsID,UsName,UsWgID,UsDpID,StID,StNameT,StNameE,WgNameT  
	// 			FROM umuser 
	// 				LEFT JOIN umusergroup ON UsID =  UgUsID
	// 				LEFT JOIN umgroup ON UgGpID = GpID
	// 				LEFT JOIN umsystem ON GpStID = StID
	// 				LEFT JOIN umwgroup ON UsWgID = WgID
	// 			WHERE UsWgID IN ? 
	// 			GROUP BY UsID 
	// 			ORDER BY `WgID` ASC";
	// 	$query = $this->ums->query($sql,array($UsWgID));
	// 	return $query;	
	// }
}
 // end class M_umuser
?>
