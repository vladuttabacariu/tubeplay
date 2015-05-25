<?php require('includes/config.php');?>
<?php include("/includes/head.php");
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 
//define page title
$title = 'Playlists';
?>
<div class="container">
	<?php include("/includes/header.php");?>
    <div id="home_top_line"></div>
	<div class="main_edit">
	    <div class="container_edit">
        	<div class="panel">           	
            	<div class="playlist_buttons">
                    <button id="back_create_playlist" class="options back" type="button">Go back and another playlist</button>
                    
                    <div class="upload">
                    <input  id="load" class="options load" name="upload" type="file" accept="application/xml"></input>
                    </div>
                    
                    <button id="edit" class="options" type="button">Edit </button>
                    <button id="delete" class="options" type="button">Delete </button>
                    <button id="save" class="options" type="button">Save </button>
                </div>
                <div class="playlist_hh"><h2>Your Playlists</h2></div>
            	<div class="playlists_list">
                	<ul id="ul_playlist_lists" class="ul_playlist_lists">
					<?php
					$i = 0;
                    $files = scandir('usersplaylists/'.$_SESSION['user']);
                    foreach ($files as $file){     
                        if($file != '.' && $file != '..'){
                        $file = str_replace('.xml','',$file);
                        echo '<li id='.$i.'><a class="playlist" href="javascript:loadTracks(\''.$file.'\',\''.$i.'\');">'.$file.'</a></li>';
						$i++;
                        }
						
                    }
                    ?>
                	</ul>
                </div>
                <div class="select_playlist">
                <select id="select">
                	<option value="-1">Choose a playlist</option>
                    <?php
					$i = 0;
                    $files = scandir('usersplaylists/'.$_SESSION['user']);
                    foreach ($files as $file){     
                        if($file != '.' && $file != '..'){
                        $file = str_replace('.xml','',$file);
                        echo '<option id='.$i.' value="'.$file.'">'.$file.'</option>';
						$i++;
                        }
						
                    }
                    ?>
                </select> 
                </div>
                <div class="videos_panel">
                <div class="video_title">
                		<div id="video_style">
                   			<div id="player"></div>
                        </div>
                </div>
                <div id="lyricOptions" class="video_title">
                	<p> Lyrics Available --</p><p>AutoScroll Show/Hide </p><button id="auto_scroll" class="add_button" type="button">+</button><p> or </p> <p> Scroll Show/Hide </p><button id= "scroll" class="add_button" type="button">+</button>
                </div>
                <div id="lyricWrapper">
                	<div id="lyricContainer">
                    </div>
                    <div id="lyricContainerScroll">
                    </div> 
                </div>
                <div  id="loaded_videos" class="your_videos">
                	<div id="search"><h2 id="h2_playlist">Your video Playlist</h2><input type="text"  id="search_track"></input><p>Search</p></div>
					<div id ="loaded_videos_list" class="your_videos_list"><ul class="your_videos_ul" id="loaded_videos_ul"></ul></div>
                    </div>
                </div>
        	</div>
    	</div>
    </div> 
</div>
<script type="text/javascript" src="../javascripts/javascript2.js"></script> 
<?php include("includes/footer.php"); ?>