<?php include("/includes/head.php"); ?>
<?php require('includes/config.php'); 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $_GET['key']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if no token from db then kill the page
if(empty($row['resetToken'])){
	$stop = 'Invalid token provided, please use the link provided in the reset email.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Your password has already been changed!';
}

//if form has been submitted process it
if(isset($_POST['submit'])){

	//basic validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {

			$stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));

			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Reset Account';

?>


<div class="signin_container">
    <header  id="header" >
        <nav id="navigation_header">
            <div id="logo">
                <a href="../index.php"> <img src="../images/logo.png" alt="logo" height="50" width="170"></a>
            </div>
        </nav>	
    </header>
    
    <div id="home_top_line"></div>
    
    <div class="signin">
        <div class="signin_content">
        	<h1>Change Password</h1>      
            <hr>       	  
            <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="errorr">'.$error.'</p>';
					}
				}

				//check the action
				
					
					?>
             <form class="sign_in_new" action="" method="post" >
                 <div class="input_cont">
                        <input class="input_text" type="password" autocomplete="off" placeholder="Password" name="password" tabindex="1"></input>
                        <input class="input_text" type="password" autocomplete="off" placeholder="Confirm Password" name="passwordConfirm" tabindex="2"></input>                     
                 </div> 
                 
                 <div class="input_Cont">
                 	<input type="submit" name="submit" value="Change Password" class="button register" tabindex="3">
                 </div>
             </form>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>