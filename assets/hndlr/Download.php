<?php

if (isset($_POST["q"]) && isset($_POST["x"])) {
    // Get parameters
   $file = urldecode($_POST["q"]); // Decode URL-encoded string
    if ($_REQUEST["x"] == "records") {
        $filepath = "../../files/records/" . $file;
    }

    // Process download
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
    }
}
