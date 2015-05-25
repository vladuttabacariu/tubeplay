<?php
require_once('includes/config.php');
$file = $_GET['filename'];
$content = $_GET['filecontent'];
$filePath = "usersplaylists/".$_SESSION['user']."/".$file;
$file_parts = pathinfo($file);
if($file_parts['extension'] != "xml"){
	echo "invalidfiletype";
}
else{
	if(file_exists($filePath)){
		echo "exists";
	}
	else {
		libxml_use_internal_errors(true);
		file_put_contents($filePath,$content);
		//echo "loaded";
		$xml = new DOMDocument(); 
		$xml->load($filePath);
		libxml_use_internal_errors(true); 
		if (!$xml->schemaValidate('xmlValidator/xmlvalidator.xsd')) { 
			echo "invalid";
			unlink($filePath);
		} 
		else { 
			echo "validated"; 
		} 		
	}
}
?>