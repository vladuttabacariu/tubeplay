// JavaScript Document
var addVideoId;
var addTitle;
var addThumbnail;

document.getElementById('button_search_video').addEventListener('click',function(){getVids(15);if(document.getElementById('search_input').value){document.getElementById('button_show_results_15').style.color = '#FF1010';document.getElementById('button_show_results_30').style.color = '#444';document.getElementById('button_show_results_45').style.color = '#444';}});
document.getElementById('button_show_results_15').addEventListener('click',function() {getVids(15);if(document.getElementById('search_input').value){document.getElementById('button_show_results_15').style.color = '#FF1010';document.getElementById('button_show_results_30').style.color = '#444';document.getElementById('button_show_results_45').style.color = '#444';}});
document.getElementById('button_show_results_30').addEventListener('click',function() {getVids(30);if(document.getElementById('search_input').value){document.getElementById('button_show_results_15').style.color = '#444';document.getElementById('button_show_results_30').style.color = '#FF1010';document.getElementById('button_show_results_45').style.color = '#444';}});
document.getElementById('button_show_results_45').addEventListener('click',function() {getVids(45);if(document.getElementById('search_input').value){document.getElementById('button_show_results_15').style.color = '#444';document.getElementById('button_show_results_30').style.color = '#444';document.getElementById('button_show_results_45').style.color = '#FF1010';}});
document.getElementById('add_video_button').addEventListener('click',function(){addVideo();});
document.getElementById('create_playlist_button').addEventListener('click',function(){createPlaylist('create');});
function showResults(numberOfResults){
	var artist = document.getElementById('artist_input').value;
	var song = document.getElementById('song_input').value;
	if(artist == '' || song == ''){
		alert('Complete artist or song');
	}
	else{
		if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
		} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
				alert(response);					
			}
		}
		xmlhttp.open("GET","geturls.php?artist="+artist+"&song="+song+"&numberOfResults="+numberOfResults,true);
		xmlhttp.send();
	}
}

function getVids(numberOfResults){
	var searchInput = document.getElementById('search_input').value;
	
	$.get(
	"https://www.googleapis.com/youtube/v3/search",{
		q: searchInput,
		part: 'snippet',
		maxResults: numberOfResults,
		order: 'viewCount',
		type: 'video',
		key: 'AIzaSyAxRlTtPHXCqRW4y_4XpqOfUknYqnI0esc'},
		function(data){
			var output;
			document.getElementById('loaded_videos_ul').innerHTML= '';
			$.each(data.items, function(i, item){
				var videoId = item.id.videoId;
				var title = item.snippet.title.replace(/["']/g, "");
				var thumbnail = item.snippet.thumbnails.default.url;
				output = '<li><a class="video_thumbnails" href="javascript:PlayMySong(\''+videoId+'\',\''+title+'\',\''+thumbnail+'\')" > <img src="'+thumbnail+'"></a><button type="button" class="add_button" onclick="addVideo2(\''+videoId+'\',\''+title+'\',\''+thumbnail+'\')"> + </button><span class="video_title" >'+title+'</span></li>';
				$('#loaded_videos_ul').append(output);				
			})		
		}
	);
}
function addVideo(){
	ok = 0;
	var nodes = document.getElementById('your_videos_ul').childNodes;
	for (var i = 1; i < nodes.length && ok == 0; i++){
		var nodeli = nodes[i];
		if(nodeli.getAttribute("id") == addVideoId)
			ok = 1;

	}
	if(ok == 0){
		var output = '<li id="'+addVideoId+'"><a class="video_thumbnails" href="javascript:removeVideo(\''+addVideoId+'\')" > <img src="'+addThumbnail+'"></a><button type="button" class="add_button" onclick="removeVideo(\''+addVideoId+'\')"> - </button><span class="video_title" >'+addTitle+'</span></li>';
		$('#your_videos_ul').append(output);
		document.getElementById('your_videos').style.display = 'inline';
	}
	
}

function addVideo2(videoId,title,thumbnail){
	var ok = 0;
	var nodes = document.getElementById('your_videos_ul').childNodes;
	for (var i = 1; i < nodes.length && ok == 0; i++){
		var nodeli = nodes[i];
		if(nodeli.getAttribute("id") == videoId)
			ok = 1;
	}
	if(ok == 0){
		var output = '<li id="'+videoId+'"><a class="video_thumbnails" href="javascript:PlayMySong(\''+videoId+'\',\''+title+'\',\''+thumbnail+'\')" > <img src="'+thumbnail+'"></a><button type="button" class="add_button" onclick="removeVideo(\''+videoId+'\')"> - </button><span class="video_title" >'+title+'</span></li>';
		$('#your_videos_ul').append(output);
		document.getElementById('your_videos').style.display = 'inline';
	}
	
}

function removeVideo(videoId){
	var element = document.getElementById(videoId);
	element.parentNode.removeChild(element);
	if(document.getElementById('your_videos_ul').childNodes.length == 0)
	document.getElementById('your_videos').style.display = 'none';
}

function createPlaylist(code){
	var videoIds = [];
	var titles = [];
	var thumbnails = [];
	var playlistTitle = document.getElementById('play_list_title').value;
	var nodes = document.getElementById('your_videos_ul').childNodes;
	for (var i = 1; i < nodes.length; i++){
		var nodeli = nodes[i];
		var nodea = nodeli.firstChild;
		if(nodea != null) {
			var node = nodea.childNodes;
			videoIds.push(nodeli.getAttribute("id"));	
			thumbnails.push(node[1].getAttribute("src"));
			titles.push(nodeli.lastChild.textContent);
	}
}	
	
	var jsonVideoIds = JSON.stringify(videoIds);
	var jsonTitles = JSON.stringify(titles);
	var jsonThumbnails = JSON.stringify(thumbnails);
	var response;
	$.ajax({
		type: "POST",
		url: "createplaylist.php",
		data: {videoIds: jsonVideoIds, titles: jsonTitles, thumbnails: jsonThumbnails, playlistTitle: playlistTitle, code: code }, 
		cache: false,
	
		success: function(text){
			if(text){
				alert(text);
			}
			else{
				setTimeout(function(){ window.location.assign("playlists.php"); }, 1000);
			}
		}
	});
}

function cancelPlaylist(){
	window.location.assign("playlists.php");
	alert('');
}

$( "body" ).keyup(function(event) {
  		if(event.which == '13'){
			getVids(15);
			if(document.getElementById('search_input').value){document.getElementById('button_show_results_15').style.color = '#FF1010';document.getElementById('button_show_results_30').style.color = '#444';document.getElementById('button_show_results_45').style.color = '#444';}
		}
});
