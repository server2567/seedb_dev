<?php
include(dirname(__FILE__)."/../../config/ums_config.php"); // Make sure you include your configuration file

/*
* getContentType
* @input extension
* @output mimeTypes
* @author Tanadon Tangjaimongkhon
* @Create Date 2567-01-22
*/
function getContentType($extension) {
    // Define content types for different file extensions
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        // Add more MIME types as needed
    ];

    return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
}
//getContentType


/*
* Getpreview
* @input path, doc
* @output doc data
* @author Tanadon Tangjaimongkhon
* @Create Date 2567-01-22
*/
if (isset($_GET['path']) && isset($_GET['doc'])) {
    // Sanitize input parameters
    $path = filter_input(INPUT_GET, 'path', FILTER_SANITIZE_URL);
    $doc = filter_input(INPUT_GET, 'doc', FILTER_SANITIZE_URL);

    // Construct the file path
    $filename = $path . basename(urldecode($doc));
    // Check if file exists
    if (file_exists($filename)) {
        // Determine file content type
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        $contentType = getContentType($fileExtension);

        // Set content type header
        header('Content-Type: ' . $contentType);
		
        // Output the file
        readfile($filename);
    } else {
        // Handle file not found
        http_response_code(404);
        echo "File not found.";
    }
    exit;
} else {
    // If required parameters are not set, handle it here
    http_response_code(400);
    echo "Invalid request.";
}


?>

