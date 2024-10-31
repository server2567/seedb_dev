<?php
include(dirname(__FILE__) . "/config.php");
$config['que_dir'] = 'que/';
$config['que_frontend_path'] = 'que/frontend';

$config['que_uploads_dir'] = $config['uploads_dir'].$config['que_dir'] ; 



$config['que_gpid_admin'] = '10023'; // สิทธิ์ผู้ดูแลระบบ QUE
$config['que_gpid_staff'] = '10036'; // เจ้าหน้าที่แผนก ระบบจัดการคิว

?> 