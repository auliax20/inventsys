<?php
session_start();
if(isset($_GET['token'])){
	include_once("../lib/admincontroller.php");
	$check = new adminControl();
	$check->checkToken($_GET['token']);
}elseif(isset($_SESSION['username'])){
	include_once("../lib/admincontroller.php");
	$check = new adminControl();
	$check->checkUser($_SESSION['username'],$_SESSION['token']);	
	include_once("home.php");
}
else{
	header("Location: ../404.php");
}
?>