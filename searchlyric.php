<?php
$title = $_GET['title'];

$title_preg = preg_replace('/[!?#$@%&*(\[]([^)]+)[!?#$@%&*)\]].*/', '', $title);
$explode = explode("-", $title_preg);
$artist = str_replace(' ','+',preg_replace('/^\s+|\s+$/','',$explode[0]));
$song = str_replace(' ','+',preg_replace('/^\s+|\s+$/','',$explode[1]));
//$url = 'http://api.musixmatch.com/ws/1.1/matcher.lyrics.get?q_track='.$song.'&q_artist='.$artist.'&apikey=2ae219a57714db8af4400da118d439e1&format=xml';
$url ='http://api.lyricfind.com/search.do?apikey=780634cb4d1a9277187f7431e2fa0139&reqtype=default&searchtype=track&limit=1&track='.$song.'&artist='.$artist;
$xmlId = simplexml_load_string(file_get_contents($url));
$id = $xmlId->tracks->track['amg'];


$getLyrics ='http://api.lyricfind.com/lyric.do?apikey=ccabb2c8bf7302e1d8c9b87be793bfb0&reqtype=default&trackid=amg:'.$id;

$xmlLyric = simplexml_load_string(file_get_contents($getLyrics));
echo $xmlLyric->track->lyrics;

?>