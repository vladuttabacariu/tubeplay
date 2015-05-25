<?php
require_once('includes/config.php');

$playlist = $_GET['playlist'];
$data = array();
$xmlDoc = simplexml_load_file("usersplaylists/".$_SESSION['user']."/".$playlist.".xml");

foreach($xmlDoc as $xml){
	$data [] = array("videoId"=>$xml->url, "thumbnail" => $xml->thumbnail, "title" => $xml->titlu);
}
echo json_encode($data);
$file = 'people.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= json_encode($data);
// Write the contents back to the file
file_put_contents($file, $current);
?>