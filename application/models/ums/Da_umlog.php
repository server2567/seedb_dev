<?php
include_once("ums_model.php");
class Da_umlog extends ums_model{
	//PK is ul_id
	public $ul_id;
	public $ul_date;
	public $ul_ip;
	public $ul_us_id;
	public $ul_changed;
	public $ul_agent;
	
	public $last_insert_id;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert(){
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
    $this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	function delete(){
		$sql = " DELETE FROM ums_user_logs_login
				WHERE ul_id=?";
		
		 
		$this->ums->query($sql, array($this->ul_id));
	}
	// Get By User ID
	function get_by_ID(){
		$sql = "SELECT * 
				FROM umlog 
				WHERE ul_us_id= ?
                ORDER BY (ul_date) DESC";
		$query = $this->ums->query($sql, array($this->session->userdata('us_id')));
		return $query ;
	}
	// Get By Using Time 
	// This Function is not complete yet because when search by time 
	// it want 2 variable time-start and time-end
	function get_by_Time(){
		$sql = "SELECT * 
				FROM umlog 
				WHERE ul_date=?";
		$query = $this->ums->query($sql, array($this->ul_date));
		return $query ;
	}
	// Get By Using IP Address
	function get_by_IP(){
		$sql = "SELECT * 
				FROM umlog 
				WHERE ul_ip=?";
		$query = $this->ums->query($sql, array($this->ul_ip));
		return $query ;
	}

	function login(){
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		$this->ul_changed = "เข้าสู่ระบบ สำเร็จ";
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
    $this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}

  function wrongpass(){
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		 
		$this->ul_changed = "ไม่สามารถเข้าสู่ระบบ รหัสผ่านผิด";
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array(null,$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}

	function loginfailed(){
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		 
		$this->ul_changed = "ไม่สามารถเข้าสู่ระบบ ไม่มีผู้ใช้นี้";
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array(null,$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	function logout(){
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";

    $this->ul_changed = "ออกจากระบบ สำเร็จ";
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}


  
	function getgear($GpName,$SysName)
	{
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		 
		$this->ul_changed = "เข้าใช้สิทธิ์ ".$GpName." ใน ".$SysName;
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();

	}
	function adddata($table,$HtID)
	{
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		
		 
		$this->ul_changed = "เพิ่มข้อมูลลงในตาราง ".$table;
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed.' ID :'.$HtID,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	function updatedata($table,$HtID)
	{
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		
		 
		$this->ul_changed = "แก้ไขข้อมูลลงในตาราง ".$table;
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed.' ID :'.$HtID,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	function deletedata($table,$HtID)
	{
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		
		$this->ul_changed = "ลบข้อมูลลงในตาราง ".$table;
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);

		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed.' ID :'.$HtID,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
	}
	function changepermission($GpID)
	{
		$sql = " INSERT INTO ums_user_logs_login (ul_us_id,ul_date,ul_changed,ul_ip,ul_agent)
				 VALUES(?,CURRENT_TIMESTAMP,?,?,?);";
		
		 
		$this->ul_changed = "เปลี่ยนสิทธิ์การใช้ ".$GpID;
    $user_agent = $this->input->user_agent();
    $device_type = $this->detect_device_type($user_agent);
    
		$this->ums->query($sql,array($this->session->userdata('us_id'),$this->ul_changed,$this->input->ip_address(),$device_type));
		$this->last_insert_id = $this->ums->insert_id();
		
	}
    // Function to detect device type based on user agent string
  function detect_device_type($user_agent) {
    // Define patterns for different types of devices
    $mobile_patterns = '/mobile|android|iphone|ipod|blackberry|iemobile|opera mini|windows phone/i';
    $tablet_patterns = '/ipad|tablet|kindle|playbook|silk/i';
    $desktop_patterns = '/windows|macintosh|linux|cros/i';

    // Check for tablet devices first
    if (preg_match($tablet_patterns, $user_agent)) {
        return 'tablet';
    }
    // Check for mobile devices
    elseif (preg_match($mobile_patterns, $user_agent)) {
        return 'mobile';
    }
    // Check for desktop devices
    elseif (preg_match($desktop_patterns, $user_agent)) {
        return 'computer';
    }
    // Default to computer if none of the patterns match
    else {
        return 'computer';
    }
  }
}
?>
