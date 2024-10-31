<?php
/*
    que_model 
    for mange see_que model
    @Author Dechathon Prajit
    @Create Date 27/05/2024
*/
defined('BASEPATH') or exit('No direct script access allowed');

class Que_model extends CI_Model
{

  public $que;
  public $que_db;

  public $hr;
  public $hr_db;

  public $ums;
  public $ums_db;

  public $wts;
  public $wts_db;

  function __construct()
  {

    parent::__construct();
    $this->que = $this->load->database('que', true);
    $this->hr = $this->load->database('hr', TRUE);
    $this->ums = $this->load->database('ums', TRUE);
    $this->wts = $this->load->database('wts', TRUE);

    $this->que_db = $this->que->database;
    $this->hr_db =   $this->hr->database;
    $this->ums_db = $this->ums->database;
    $this->wts_db = $this->wts->database;
  }
}
