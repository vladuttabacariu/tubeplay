<?php include("head.php"); ?>
<?php include("header.php");?>

<section id="content_frame">
	<form method="POST" action="Register.php" >
		<table id="SimpleTable">
			<tr><td><label> First Name : </label></td><td><input type="text" name="FirstName" value="" > </td></tr>
			<tr><td><label> Last Name : </label></td><td><input type="text" name="LastName" value="" > </td></tr>
			<tr><td><label> Username : </label></td><td><input type="text" name="Username" value="" ></td></tr>
			<tr><td><label> Password : </label></td><td><input type="password" name="Password" value="" ></td></tr>
			<tr><td><label> Conf. Password : </label> </td><td><input type="password" name="ConfirmedPassword" value="" ></td></tr>
			<tr></tr>
			<tr><td><label> E-mail : </label></td><td><input type="text" name="EMail" value="" ></td></tr>
		
	
		</table>
	</form>



</section>


<?php include("footer.php"); ?>