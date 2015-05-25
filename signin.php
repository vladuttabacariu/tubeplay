<?php include("/includes/head.php"); ?>
<?php require('includes/config.php'); 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
			
	}

	if (preg_match("/\\s/", $_POST['username'])) {
   		$error[] = 'Username contains white spaces!';
	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['confirm_password']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['confirm_password']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
			
	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "Thank you for registering at tubeplay site.\n\n To activate your account, please click on this link:\n\n ".DIR."activate.php?x=$id&y=$activasion\n\n Regards Site Admin \n\n";
			$additionalheaders = "From: <".SITEEMAIL.">\r\n";
			$additionalheaders .= "Reply-To: $".SITEEMAIL."";
			mail($to, $subject, $body, $additionalheaders);

			//redirect to index page
			header('Location: signin.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Sign In';

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
        	<h1>Sign in to continue</h1>   
            <p>Already a member? <a href='login.php'>Login</a></p>
            <hr>       	  
            <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="errorr">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>
             <form class="sign_in_new" action="" method="post" >
                 <div class="input_cont">
                 		<input class="input_text" type="text" placeholder="Username" name="username"  value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1"></input>
                        
                 </div>
                 <div class="input_cont">
                        <input class="input_text" type="email" placeholder="Email" name="email" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2"></input>
                 </div>
                 <div class="input_cont">
                        <input class="input_text" type="password" autocomplete="off" placeholder="Password" name="password" tabindex="3"></input>
                        <input class="input_text" type="password" autocomplete="off" placeholder="Confirm Password" name="confirm_password" tabindex="4"></input>                     
                 </div> 
                 
                 <div class="input_Cont">
                 	<input type="submit" name="submit" value="Register" class="button register" tabindex="5">
                 </div>
             </form>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>