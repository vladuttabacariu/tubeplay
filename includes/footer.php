<?php
$startYear = 2011;
$thisYear = date('Y');
if ($thisYear > $startYear) {
	$thisYear = date('y');
	$copyright = "$startYear&ndash;$thisYear";
} else {
	$copyright = $startYear;
}
?>	

	<div class="footer" >
		<p id="copyright" class="reset pull_out padding" role="contentinfo"><a href="index.php">© <?php echo $copyright; ?> tubeplay</a></p>			
	</div>


	
	</body>

</html>