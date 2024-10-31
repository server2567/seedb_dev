<?php
/*
    ams_model 
    for mange see_ams model
    @Author Dechathon Prajit
    @Create Date 27/05/2024
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Ams_model extends CI_Model{

    public $ams;
    public $ams_db;

    function __construct(){

        parent::__construct();
        $this->ams = $this->load->database('ams',true);

        $this->ams_db = $this->ams->database;

        
		
    }
    
}
?>
