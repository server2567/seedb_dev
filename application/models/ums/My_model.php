<?php

class My_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->ums = $this->load->database('ums', TRUE);
		
		//$this->umsold = $this->load->database('umsold', TRUE);
	}
	
	function row2attribute($rw) {
		foreach ($rw as $key => $value) {
			if ( is_null($value) ) 
				eval("\$this->$key = NULL;");
			else
				eval("\$this->$key = '$value';");
		}
	}

}

?>