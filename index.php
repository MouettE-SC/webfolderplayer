<?php

require("config.php");

if ( ! isset($music_root) ) {
	echo "\$music_root not set in configuration !";
	exit;
}

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
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h2>Folders</h2>
      <ol class="breadcrumb" id="folders-bc">
        <li class="active">Home</li>
      </ol>
      <ul class="list-group"></ul>
    </div>
    <div class="col-md-4">
      <h2>Playlist</h2>
    </div>
  </div>
</div>
<script	src="js/jquery.min.js"></script>
<script	src="js/bootstrap.min.js"></script>
<script	src="js/wfp.js"></script>
</body>
</html>