<?php
require_once('includes/config.php');
$file = $_GET['filename'];
$filePath = "usersplaylists/".$_SESSION['user']."/".$file;
unlink($filePath);
echo "Playlist Deleted!";
?>