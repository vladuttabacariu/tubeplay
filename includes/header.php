
<header  id="header" >
	<nav id="navigation_header">
        <div id="logo">
        	<a href="../index.php"> <img src="../images/logo.png" alt="logo" height="50" width="170"></a>
        </div>
        <ul id="navigation_list">
        	
            <?php require_once('includes/config.php'); 
			if( $user->is_logged_in()){
				echo '<li><a href="playlists.php">Hello, ';
				echo $_SESSION['user'].'!</a></li>';
				echo '<li><a href="playlists.php">My Playlists!</a></li>';
				echo '<li><a href="login.php">Build a video playlist</a></li>';
				echo '<li><a href="logout.php">Logout</a></li>';
            }
			else{
				echo '<li><a href="login.php">Build a video playlist</a></li>';
				echo '<li><a href="signin.php">Sign in</a></li>
            <li><a href="login.php">Log in</a></li>';
			}?>
            
        </ul>
	</nav>
	
</header>