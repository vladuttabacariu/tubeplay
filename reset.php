<?php include("/includes/head.php"); ?>
<?php require('includes/config.php'); 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

//if form has been submitted process it
if(isset($_POST['submit'])){

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is not on recognised.';
		}
			
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
			$subject = "Password Reset";
			$body = "Someone requested that the password be reset. \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address: ".DIR."resetPassword.php?key=$token";
			$additionalheaders = "From: <".SITEEMAIL.">\r\n";
			$additionalheaders .= "Reply-To: $".SITEEMAIL."";
			mail($to, $subject, $body, $additionalheaders);

			//redirect to index page
			header('Location: login.php?action=reset');
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
        	<h1>Reset Password</h1>   
            <p><a href='login.php'>Back to login page</a></p>
            <hr>       	  
            <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="errorr">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='success'>Please check your inbox for a reset link.</h2>";
							break;
					}
				}
				?>
             <form class="sign_in_new" action="" method="post" >

                 <div class="input_cont">
                        <input class="input_text" type="email" placeholder="Email" name="email" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="1"></input>
                 </div>
                 <div class="input_Cont">
                 	<input type="submit" name="submit" value="Sent Reset Link" class="button register" tabindex="2">
                 </div>
             </form>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>