<?php
include_once("../lib/admincontroller.php");
$new = new adminControl();
if(isset($_GET['mod'])){
	if($_GET['mod']=="login"){
		include_once("login.php");
	}
}else{
	include_once("handler.php");
	include_once("mainpage.php");	
}
?>