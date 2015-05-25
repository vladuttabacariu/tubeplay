<?php include("../includes/head.php"); ?>
<?php include("../includes/header.php"); ?>
<div id="below_topnav">	
	<div id="content_frame">
<div id="top_menu">



<table>
<tr>
<td><a id="account_menu" href="#"  > HOME </a> </td>
<td><a id="account_menu" href="#"  > Load Playlist </a></td>
<td><a id="account_menu" href="#"  > Create Playlist </a></td>
<td><a id="account_menu" href="#" > About </a></td>
<td><a id="account_menu" href="#" > Contact</a></td>
</tr>
</table> 

<table>
<tr>
	<input id="search_video" type="text" autocomplete="off" name="search_video" value=""/>
	<input type="button"  class="search_button" />
</tr>
</table>


</div>

<div id="videospot">
	<video id="myVideoPlayer" src="#" controls autoplay loop muted preload="auto" poster="images/JukeBox.png" >
 
	</video>

	<h2 id="video_title"> Juke Box title - version BETA 1.001 </h3>

	<div id="comments">

	<p> &nbsp &nbsp Comments : </p>

		<table style="width:100%">
		<tr>
			<td style="width:10%">
				<img src="../images/unknownPerson.jpg" />
			</td>
			<td>
			<input id="comment_input" type="text" autocomplete="off" name="comment" value=""/>
			</td>
		</tr>
		</table>


	</div>


</div>

<div id="sugestedVideos">
<table style="width:100%" >
	<tr>
	<td>
		<video src="#" poster="../images/iceage1.jpg" >
		</video>
	</td>
	<td>
	<p class="clip_title">Ice Age I </p>
	<p class="views"> Views : 4,323,000 </p>
	</td>
	<tr>

	<tr>
	<td>
		<video src="#" poster=".//images/iceage2.jpg" >
		</video>
	</td>
	<td>
	<p class="clip_title">What happened with the ice ? </p>
	<p class="views"> Views : 4,323,000 </p>
	</td>
	<tr>


	<tr>
	<td>
		<video src="#" poster="../images/iceage3.jpg" >
		</video>
	</td>
	<td>
	<p class="clip_title">Ice Age III </p>
	<p class="views"> Views : 4,323,000 </p>
	</td>
	<tr>


	<tr>
	<td>
		<video src="#" poster="../images/iceage1.jpg" >
		</video>
	</td>
	<td>
	<p class="clip_title">Ice Age I </p>
	<p class="views"> Views : 4,323,000 </p>
	</td>
	<tr>


	<tr>
	<td>
		<video src="#" poster="../images/toy1.jpg" >
		</video>
	</td>
	<td>
	<p class="clip_title">Toy Story </p>
	<p class="views"> Views : 4,323,000 </p>
	</td>
	<tr>


</table>


</div>
</div>
</div>
