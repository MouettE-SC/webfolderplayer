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

<html>
<head>

</head>
<body>

</body>
</html>