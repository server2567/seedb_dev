<?php
/**
 * Helper for Line Services
 * User: Tanadon
 * Date: 2024-07-17
 */


function get_url_line_service($url, $data){
    $data_string = json_encode($data);
    $curl = curl_init($url); 

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
    );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $result = curl_exec($curl);
    curl_close($curl);
    
    // return json_decode(curl_exec($curl));	
    echo $result;
}  



?>