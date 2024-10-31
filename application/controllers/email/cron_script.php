<?php
require '/var/www/html/seedb/application/third_party/vendor/autoload.php';
use \Firebase\JWT\JWT;

$key = "your_secret_key";

$payload = array(
    "iat" => time(),
    "exp" => time() + (60*60),
    "sub" => "cron_job",
);

$jwt = JWT::encode($payload, $key,'HS256');

$api_url = 'https://dev-seedb.aos.in.th/index.php/email/Sendemail/send_email_appoint_to_patient';
$headers = array(
    "Authorization: Bearer $jwt",
    "Content-Type: application/json",
);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $response;
?>
