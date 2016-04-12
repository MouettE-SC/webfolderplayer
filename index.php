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
  <link type="text/css" href="skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/wfp.css">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h2>Folders</h2>
      <ol class="breadcrumb" id="folders-bc"></ol>
      <ul class="list-group" id="folders-list"></ul>
    </div>
    <div class="col-md-4">
      <h2>Playlist</h2>
    </div>
  </div>

<div class="row">
  <div class="col-md-12">
    <div id="jplayer" class="jp-jplayer"></div>
    <div id="jplayer_container" class="jp-audio" role="application" aria-label="media player">
      <div class="jp-type-single">
        <div class="jp-gui jp-interface">
          <div class="jp-controls">
            <button class="jp-play" role="button" tabindex="0">play</button>
            <button class="jp-stop" role="button" tabindex="0">stop</button>
          </div>
          <div class="jp-progress">
            <div class="jp-seek-bar">
              <div class="jp-play-bar"></div>
            </div>
          </div>
          <div class="jp-volume-controls">
            <button class="jp-mute" role="button" tabindex="0">mute</button>
            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
            <div class="jp-volume-bar">
              <div class="jp-volume-bar-value"></div>
            </div>
          </div>
          <div class="jp-time-holder">
            <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
            <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
            <div class="jp-toggles">
              <button class="jp-repeat" role="button" tabindex="0">repeat</button>
            </div>
          </div>
        </div>
        <div class="jp-details">
          <div class="jp-title" aria-label="title">&nbsp;</div>
        </div>
        <div class="jp-no-solution">
          <span>Update Required</span>
          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
      </div>
    </div>
  </div>
</div>

</div>

<script	src="js/jquery.min.js"></script>
<script	src="js/bootstrap.min.js"></script>
<script	src="js/jquery.jplayer.min.js"></script>
<script	src="js/wfp.js"></script>
</body>
</html>