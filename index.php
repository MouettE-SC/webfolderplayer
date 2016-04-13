<?php

require("config.php");

if ( ! isset($music_root) ) {
	echo "\$music_root not set in configuration !";
	exit;
}

if ( ! isset($exclude))
	$exclude = array();

if ( ! is_dir($music_root)) {
	echo "$music_root is not a directory !";
	exit;
}

if ( ! is_readable($music_root)) {
	echo "$music_root is not readeable !";
	exit;
}

require("lib.php");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>WebFolderPlayer</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <!-- <link type="text/css" href="skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" />-->
  <link rel="stylesheet" type="text/css" href="css/wfp.css">
</head>
<body>

  <div id="a-left" class="split split-horizontal">
    <h2>Folders</h2>
    <ol class="breadcrumb" id="folders-bc"></ol>
    <div class="eb-select">
      <ul class="list-group" id="folders-list"></ul>
    </div>
  </div>
  <div id="a-right" class="split split-horizontal">
    <h2>Playlist</h2>
    <div class="eb-select">
      <ul class="list-group" id="playlist"></ul>
    </div>
    <div id="player">
      <p><span id="title"></span> | <span id="currentTime"></span> / <span id="duration"></span></p>
      <button id="play" type="button" class="btn btn-default btn-xs"><span class="fa fa-play" aria-hidden="true"></span></button>
      <button id="pause" type="button" class="btn btn-default btn-xs"><span class="fa fa-pause" aria-hidden="true"></span></button>
      <button id="stop" type="button" class="btn btn-default btn-xs"><span class="fa fa-stop" aria-hidden="true"></span></button>
    </div>
    <div id="jplayer" class="jp-jplayer"></div>
  </div>

<script	src="js/jquery.min.js"></script>
<script	src="js/bootstrap.min.js"></script>
<script src="js/jquery.jplayer.min.js"></script>
<script src="js/split.min.js"></script>
<script	src="js/wfp.js"></script>
</body>
</html>