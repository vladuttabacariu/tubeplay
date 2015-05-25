<?php
require_once('includes/config.php');
ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script
$file = $_GET['filename'];
$path = "usersplaylists/".$_SESSION['user']."/".$file; // change the path to fit your websites document structure
//$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file); // simple file name validation
//$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
$fullPath = $path;
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
        break;
        // add more headers for other content types here
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
exit;
?>