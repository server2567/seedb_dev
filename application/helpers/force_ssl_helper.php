<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('force_ssl'))
{
    function force_ssl()
    {
       if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        redirect($url);
        exit;
    }
    }   
}
?>
