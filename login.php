<?php include("/includes/head.php"); ?>
<?php
//include config
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

//process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($user->login($username,$password)){ 
		
		header('Location: memberpage.php');
		exit;
	
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}

}//end if submit

//define page title
$title = 'Login';

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
        	<h1>Please Login</h1>   
            <p><a href='./'>Back to home page</a></p>
            <hr>
            <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}

				
				?>

             <form class="sign_in_new" action="" method="post" >
                 <div class="input_cont">
                        <input class="input_text" type="text" placeholder="Username" name="username" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1"></input>
                 </div>
                 <div class="input_cont">
                        <input class="input_text" type="password" autocomplete="off" placeholder="Password" name="password" tabindex="2"></input>
                                             
                 </div> 
                  <p><a href='reset.php'>Forgot your Password?</a></p>
                 <div class="input_Cont">
                 	<input type="submit" name="submit" value="LOGIN" class="button register" tabindex="3">
                 </div>
             </form>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>