<?php
include(dirname(__FILE__)."/../../config/ams_config.php");

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $path = $config['ams_uploads_dir'] . $name;

    if (is_readable($path)) {
        // Get the MIME type of the file
        $mime = mime_content_type($path);
        $filesize = filesize($path);

        // Set headers to serve the file
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Content-Length: ' . $filesize);
        header("Content-Range: 0-" . ($filesize - 1) . "/" . $filesize);

        // Output the file content
        readfile($path);
        exit();
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "File not found";
        exit();
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Missing 'name' parameter";
    exit();
}
?>
