<?php
include(dirname(__FILE__)."/../../config/hr_config.php");

if (isset($_GET['type']) && isset($_GET['image'])) {
    $type = $_GET['type'];
    $image = $_GET['image'];
    $path = "{$config['hr_upload_folder']}{$type}/{$image}";
    
    if (is_readable($path)) {
        $info = getimagesize($path);
        if ($info !== FALSE) {
            // ตั้งค่าแคช (Cache)
            header('Cache-Control: public, max-age=86400'); // แคชรูปภาพไว้ 1 วัน

            if ($info['mime'] == 'image/jpeg') {
                $imageResource = imagecreatefromjpeg($path);
            } elseif ($info['mime'] == 'image/png') {
                $imageResource = imagecreatefrompng($path);
            } else {
                header("HTTP/1.0 415 Unsupported Media Type");
                exit();
            }

            // ตั้งค่าขนาดใหม่
            $newWidth = 500; 
            $newHeight = (int)($info[1] * ($newWidth / $info[0])); 

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            if ($info['mime'] == 'image/png') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
            }

            imagecopyresampled($resizedImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $info[0], $info[1]);

            header("Content-type: {$info['mime']}");

            if ($info['mime'] == 'image/jpeg') {
                imagejpeg($resizedImage, NULL, 50); 
            } elseif ($info['mime'] == 'image/png') {
                imagepng($resizedImage, NULL, 8); 
            }

            imagedestroy($imageResource);
            imagedestroy($resizedImage);

            exit();
        }
    }
}

header("HTTP/1.0 404 Not Found");
exit();
?>
