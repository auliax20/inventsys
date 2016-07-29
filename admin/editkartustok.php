<?php
	include_once("../lib/admincontroller.php");
	$data = new adminControl();
	$val = $data->getDataStokTgl($_GET['kode'],$_GET['tanggal'],$_GET['type']);
	print_r($val);
	$wil = $data->editDataKartuStok($_GET['kode'],$_GET['tanggal'],$val[3],"40",$val['stoks']);
?>