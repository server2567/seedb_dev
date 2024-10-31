<?php
include(dirname(__FILE__) . "/config.php");
$config['ams_dir'] = 'ams/';
$config['ams_uploads_dir'] = $config['uploads_dir'].$config['ams_dir'] ;

// IP Address list for access to see Notification result (Notification_result_get_exr)
$config['ams_ip_address_access'] = [
    '172.16.22.6',
    '110.78.42.34', // Wifi: HIS
]; 

?> 