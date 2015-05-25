<?php include("/includes/head.php"); ?>
<?php require('includes/config.php'); 
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 
//define page title
$title = 'CreatePlaylist';
?>
<div class="container">
	<?php include("/includes/header.php");?>
    <div id="home_top_line"></div>
	<div class="main_edit">
	    <div class="container_edit">
        	<div class="panel">     	
				<h2>Playlist title</h2>
                <input id="play_list_title" class="playlist_title" type="text" <?php if(isset($_GET['playlist'])) {echo 'value="'.$_GET['playlist'].'"  disabled';} else{echo 'value="New playlist"';} ?> name="playlist_title" maxlength="255"></input>
                <?php if(isset($_GET['playlist'])){echo '<button id="save_playlist_button" onclick="createPlaylist(\'save\')" class="buttons save" type="button">Save Changes</button><button id="cancel_playlist_button" class="buttons cancel" onclick="cancelPlaylist()">Cancel</button>';}else{ echo '<button id="create_playlist_button" class="buttons create" type="button">Create Playlist</button>';}?> 
                <h2>Add videos</h2>
                <div class="search_panel">
                	<div class="tabs">
                    	<div class="addfromyoutube"><img alt="" src="/images/youtubelogo.png"></img></div>
                     	<div class="search_list" style="display: block;">
                     		<input class="youtube_search" id="search_input" name="SearchQuery" placeholder="Ex: Maroon 5 - Maps" value = "" type="text" maxlength="100"></input>
                        	<button id="button_search_video" class="buttons search" type="button">Search</button>
                     		<span>Search for videos on youtube.com</span>
                     	</div>
                	</div>
                    <div class="video">
                    <div class="video_title">
                   		<div id="player" ></div>
                        <div id="add_video"> <button id="add_video_button" class="buttons add_video" type="button">Add video</button> </div>
                    </div>
                    <?php if(isset($_GET['playlist'])){
						echo '<div id="your_videos" class="your_videos" style="display:inline;">';
					}
					else{
						echo '<div id="your_videos" class="your_videos">';
					}?>
                    <h2>Your video Playlist</h2>
                    
                    <div id="your_videos_list" class="your_videos_list">
                        <ul id="your_videos_ul" class="your_videos_ul">
                            <?php 
                            if(isset($_GET['playlist'])){
                            $xmlDoc = simplexml_load_file("usersplaylists/".$_SESSION['user']."/".$_GET['playlist'].".xml");
                            foreach($xmlDoc as $xml){
                                
                                echo '<li id="'.$xml->url.'"><a class="video_thumbnails" href="javascript:removeVideo(\''.$xml->url.'\')" > <img src="'.$xml->thumbnail.'"> <br/> <div class="video_title">'.$xml->titlu.'</div></a></li>';
                            }
                            }
                            ?>                                           
                        </ul>
                    </div>
                    </div>
                    <div id="results">
                    	<h2>Results</h2>
                         <button id="button_show_results_15" class="results_button" type="button">15</button>
                         <button id="button_show_results_30" class="results_button" type="button">30</button>
                         <button id="button_show_results_45" class="results_button" type="button">45</button>
                    </div>
                    <div id="loaded_videos_list" class="your_videos_list"><ul id="loaded_videos_ul" class="your_videos_ul"></ul></div>           
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="../javascripts/javascript.js"></script> 
<?php include("includes/footer.php"); ?>