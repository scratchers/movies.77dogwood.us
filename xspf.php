<?php
$xspf = '<?xml version="1.0" encoding="UTF-8"?>
<playlist xmlns="http://xspf.org/ns/0/" xmlns:vlc="http://www.videolan.org/vlc/playlist/ns/0/" version="1">
	<title>Playlist</title>
	<trackList>
		<track>
			<location>https://'
			  . $_SERVER["SERVER_NAME"] . '/popshare/Movies/' . str_replace(' ','%20',$_GET["fpath"]) .
			'</location>
			<extension application="http://www.videolan.org/vlc/playlist/0">
				<vlc:id>0</vlc:id>
				<vlc:option>network-caching=1000</vlc:option>
			</extension>
		</track>
	</trackList>
	<extension application="http://www.videolan.org/vlc/playlist/0">
			<vlc:item tid="0"/>
	</extension>
</playlist>';

Header('Content-type: text/xspf');
header('Content-Disposition: attachment; filename="movie.xspf"');
echo $xspf;
?>
