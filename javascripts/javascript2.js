// JavaScript Document
document.getElementById('back_create_playlist').addEventListener('click',goBackCreatePlaylist);
document.getElementById('save').addEventListener('click',savePlaylist);
document.getElementById('edit').addEventListener('click',editPlaylist);
document.getElementById('load').addEventListener('change',loadPlaylist,false);
document.getElementById('delete').addEventListener('click',deletePlaylist);
document.getElementById('auto_scroll').addEventListener('click',autoScroll);
document.getElementById('scroll').addEventListener('click',scrolll);
var loaded_playlist;
var loaded_playlist_id;
var lyric = [];
function loadTracks(playlistName,id){
	loaded_playlist = playlistName;
	loaded_playlist_id = id;
	$("#select").val(playlistName);
	document.getElementById('player').style.display = 'none';
	resetVisibility();
	player.stopVideo();
	for(var i = 0; i <  document.getElementById('ul_playlist_lists').childNodes.length-2; i++){
		if(i == id){
			document.getElementById(i).childNodes[0].style.backgroundColor = '#FF5219';				
		}
		else{
			document.getElementById(i).childNodes[0].style.backgroundColor = '#1B8DBD';
		}
	}
	document.getElementById('loaded_videos').style.display= 'block';
	var nod = document.getElementById('loaded_videos_ul');
	if(nod) nod.parentNode.removeChild(nod);
	document.getElementById('loaded_videos_list').innerHTML = '<ul class="your_videos_ul" id="loaded_videos_ul"></ul>';
	document.getElementById('h2_playlist').innerHTML = 'Your video playlist - '+playlistName;
	
	
	$.getJSON('loadplaylist.php',{playlist: playlistName}, function(data) {
		/* data will hold the php array as a javascript object */
		$.each(data, function(key, val) {
			$('#loaded_videos_ul').append('<li><a class="video_thumbnails" href="javascript:loadLyric(\''+val.title[0]+'\'),PlayMySong(\''+val.videoId[0]+'\');" > <img src="'+val.thumbnail[0]+'"> <br/> <div class="video_title">'+val.title[0]+'</div></a></li>');
				//$('ul').append('<li id="' + key + '">' + val.first_name + ' ' + val.last_name + ' ' + val.email + ' ' + val.age + '</li>');
		});
	});
}

function savePlaylist(){
	 if(loaded_playlist){
		 //var aux = loaded_playlist.replace(/\s/g,'+');
		 window.location.assign("downloadfile.php?filename="+loaded_playlist+".xml");
	 }
	 else{
		 alert("Choose a playlist");
	 }
}

function goBackCreatePlaylist(){
	window.location.assign("memberpage.php");
}

function deletePlaylist(){
	if(loaded_playlist){	
	 if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
		} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			
			var tbl = document.getElementById(loaded_playlist_id);
			if(tbl) tbl.parentNode.removeChild(tbl);
			alert(xmlhttp.responseText); 
			window.location.assign("playlists.php");
			
		}
	 }
	 
	 document.getElementById('loaded_videos').style.display= 'none';
	 xmlhttp.open("GET","deleteplaylist.php?filename="+loaded_playlist+".xml",true);
	 xmlhttp.send();
	 
	 }
	 else{
		alert("Choose a playlist");
	 }
	 
}

function loadPlaylist(event){
	var f = event.target.files[0];
	var contents;
	var r;
	if (f) {
		r = new FileReader();
		r.onload = function(e) { 
			contents = e.target.result;
			saveFileToServer(f.name,contents);
		}
		r.readAsText(f);
	} else { 
		 alert("Failed to load file");
	}
}

function saveFileToServer(filename,content){
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var data = xmlhttp.responseText
			if(data == "exists"){
				alert("Another file with the same name already exists!");
			}
			else{
				if(data == "invalidfiletype"){
					alert("File type invalid");
				}
				else{
					if(data == "validated")
					{
					alert("XML Document is valid");
					var cell;
					var noPlayLists = document.getElementById('ul_playlist_lists').childNodes.length-2;
					
					var aux = filename.replace(/.xml/g,'');
					cell=document.createElement('li');
					cell.id = noPlayLists;
					cell.innerHTML = '<a class="playlist" href="javascript:loadTracks(\''+aux+'\','+noPlayLists+');">'+aux+'</a>';
					
					document.getElementById('ul_playlist_lists').appendChild(cell);
					}
					else{
						
						alert("XMLD Document is not valid");
					}
					
				}
				
			}
		}
	}
			
	xmlhttp.open("GET","loadfile.php?filename="+filename+"&filecontent="+content);
	xmlhttp.send();
}

function editPlaylist(){
	if(loaded_playlist)
		window.location.assign("memberpage.php?playlist="+loaded_playlist);
	else
		alert("Choose a playlist");
}
var lyricContainer;
var lyricContainerScroll;
var lyricsSplit;
var lyricsLength;
function loadLyric(title){
	resetVisibility();
	$.get("searchlyric.php",{title: title},
		function(data){
			if(data){
				lyricStyle = Math.floor(Math.random() * 4);
				document.getElementById('lyricOptions').style.display = 'block';
				var lyrics = data;
				lyricsSplit = lyrics.split("\n");
				lyricsLength = lyricsSplit.length;
				lyricContainer = document.getElementById('lyricContainer');
				lyricContainerScroll = document.getElementById('lyricContainerScroll');
				var ol = document.createElement('ol');
				fragment = document.createDocumentFragment();
				lyricContainer.innerHTML = '';
				lyricContainerScroll.innerHTML = '';
				lyricContainer.style.top = 130;
				for(var i = 0; i < lyricsSplit.length; i++){
					var line = document.createElement('p');
					var li = document.createElement('li');
					li.id = 'line-' +i ;
					line.id = 'line-' + i;
					li.textContent = lyricsSplit[i];
					line.textContent = lyricsSplit[i];
					ol.appendChild(li);
					fragment.appendChild(line);
				}
				
				
				lyricContainerScroll.appendChild(ol);
				lyricContainer.appendChild(fragment);
			}
			else{
				document.getElementById('lyricOptions').style.display = 'none';
			}
		}
	);
}
var lyricStyle ;
function onPlayerStateChange(event){
	
	if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.BUFFERING ){
		
		lyric[lyricsLength] = player.getDuration()-20;
		lyric[0] = 15;
		var jump = (player.getDuration()-35)/(lyricsLength-2);
		var aux = jump;
		for(var i = 1; i < lyricsLength-1; i++){
					lyric[i] = lyric[i-1] + jump;
		}
		for(var i = 0; i < lyricsLength; i++){
			console.log(lyric[i]);
		}
		setInterval(function(){	
						if (!lyric) return;	
						for(var i = 0; i < lyricsLength; i++){	
							if(player.getCurrentTime() > lyric[i] - 0.50){
								var line = document.getElementById('line-' + i),
								prevLine = document.getElementById('line-' + (i > 0 ? i - 1 : i));
								prevLine.className = '';
							//randomize the color of the current line of the lyric
								line.className = 'current-line-'+lyricStyle;;
								lyricContainer.style.top = 130 - line.offsetTop + 'px';
							}
						}
					},100);
		
	}
}

var changer = 0;
var changer2 = 0;
function autoScroll(){
	changer = 1 - changer;
	if(changer == 1){
		document.getElementById('lyricContainer').style.display = 'block';
		document.getElementById('auto_scroll').textContent = '-';
		document.getElementById('scroll').textContent = '+'
		document.getElementById('lyricContainerScroll').style.display = 'none';
		changer2 = 0;
	}
	else{
		document.getElementById('auto_scroll').textContent = '+'
		document.getElementById('lyricContainer').style.display = 'none';
	}
}

function scrolll(){
	changer2 = 1 - changer2;
	if(changer2 == 1){
		document.getElementById('scroll').textContent = '-'
		document.getElementById('lyricContainerScroll').style.display = 'block';
		document.getElementById('auto_scroll').textContent = '+'
		document.getElementById('lyricContainer').style.display = 'none';
		changer = 0;
	}
	else{
		document.getElementById('scroll').textContent = '+'
		document.getElementById('lyricContainerScroll').style.display = 'none';
		
	}
}

$('#search_track').keydown(function(){
	var searchField = $('#search_track').val();
	var myExp = new RegExp(searchField, "i");
	document.getElementById('loaded_videos_ul').innerHTML = '';
	$.getJSON('loadplaylist.php',{playlist: loaded_playlist}, function(data) {
		$.each(data, function(key, val) {
			if(val.title[0].search(myExp) != -1){
			$('#loaded_videos_ul').append('<li><a class="video_thumbnails" href="javascript:loadLyric(\''+val.title[0]+'\'),PlayMySong(\''+val.videoId[0]+'\');" > <img src="'+val.thumbnail[0]+'"> <br/> <div class="video_title">'+val.title[0]+'</div></a></li>');}
		});
	});
	
});

function resetVisibility(){	
	document.getElementById('lyricOptions').style.display = 'none';
	document.getElementById('lyricContainer').style.display = 'none';
	document.getElementById('lyricContainerScroll').style.display = 'none';
	document.getElementById('auto_scroll').textContent = '+';
	document.getElementById('scroll').textContent = '+';
	changer = 0;
	changer2 = 0;
}

$('#select').change(function() {
	if(($('#select  option:selected').index()-1) == -1)
	window.location.assign("playlists.php");
	else
	loadTracks($(this).val(),($('#select  option:selected').index()-1));
});