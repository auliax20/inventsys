<?php
	include_once("lib/actionf.php");
	$fungsiop = new func();
	$fungsiop->secureURI($_SERVER['REQUEST_URI']);
?>
<?php
	session_start();
	session_destroy();
	session_regenerate_id();
	header("Location: login.php");
?>