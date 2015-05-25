<?php
require_once('includes/config.php');
$videoIds = json_decode(stripslashes($_POST['videoIds']));
$titles = json_decode(stripslashes($_POST['titles']));
$thumbnails = json_decode(stripslashes($_POST['thumbnails']));
$playlistTitle = $_POST['playlistTitle'];
$code = $_POST['code'];
$savefile = "usersplaylists/".$_SESSION['user']."/".$playlistTitle.".xml";
//create the xml document
$xmlDoc = new DOMDocument();
	
	if(file_exists($savefile) && $code == 'create'){
		echo "Another playlist with the same name already exists! Choose a different name!";
	}
	else {
		if(file_exists($savefile) && $code == 'save'){
			unlink($savefile);
			$root = $xmlDoc->appendChild($xmlDoc->createElement("Playlist"));
			  $root->appendChild(
						$xmlDoc->createAttribute("id"))->appendChild(
							$xmlDoc->createTextNode($playlistTitle));
			
			for($i = 0; $i < count($videoIds); $i++)
			{ 
				
			 
			  //create a tutorial element
			  $tutTag = $root->appendChild(
						  $xmlDoc->createElement("track"));
			
			  //create the track attribute
			  $tutTag->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
				  $xmlDoc->createTextNode($videoIds[$i]));
			
			  //create the url element
			  $tutTag->appendChild(
				$xmlDoc->createElement("url", $videoIds[$i]));
			
			  //create the thumnbail element
			  $tutTag->appendChild(
				$xmlDoc->createElement("thumbnail", $thumbnails[$i]));
			  
			  //create  titlu elemnt
			  $tutTag->appendChild(
				$xmlDoc->createElement("titlu", $titles[$i]));
			}
			
			//make the output pretty
			$xmlDoc->formatOutput = true;
			
			$xmlDoc->save($savefile);
		}
		else{
			//create the root element
			
			 $root = $xmlDoc->appendChild($xmlDoc->createElement("Playlist"));
			  $root->appendChild(
						$xmlDoc->createAttribute("id"))->appendChild(
							$xmlDoc->createTextNode($playlistTitle));
			
			for($i = 0; $i < count($videoIds); $i++)
			{ 
				
			 
			  //create a tutorial element
			  $tutTag = $root->appendChild(
						  $xmlDoc->createElement("track"));
			
			  //create the track attribute
			  $tutTag->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
				  $xmlDoc->createTextNode($videoIds[$i]));
			
			  //create the url element
			  $tutTag->appendChild(
				$xmlDoc->createElement("url", $videoIds[$i]));
			
			  //create the thumnbail element
			  $tutTag->appendChild(
				$xmlDoc->createElement("thumbnail", $thumbnails[$i]));
			  
			  //create  titlu elemnt
			  $tutTag->appendChild(
				$xmlDoc->createElement("titlu", $titles[$i]));
			}
			
			//make the output pretty
			$xmlDoc->formatOutput = true;
			
			$xmlDoc->save($savefile);
		}
	}
?>