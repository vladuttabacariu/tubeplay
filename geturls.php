<?php

echo $_GET['artist'];
echo $_GET['song'];
echo $_GET['numberOfResults'];
$artist = $_GET['artist'];
$song = $_GET['song'];
$numberOfResults = $_GET['numberOfResults'];
$search = $artist;
$search .= ' ';
$search .= $song;
echo $search;
$url ="https://www.googleapis.com/youtube/v3/search?q={$search}&order=viewCount&maxResults=$numberOfResults&key=AIzaSyAxRlTtPHXCqRW4y_4XpqOfUknYqnI0esc&part=snippet";
$xml = file_get_contents($url);
echo $xml;			  

?>