<?php
if(isset($_POST['input_barang'])){
	include_once("../lib/admincontroller.php");	
	$inputbarang = new adminControl();
	$data = $inputbarang->inputBarangMasuk($_POST['kode_barang'],$_POST['nama_barang'],$_POST['stn'],$_POST['sst'],$_POST['stn1'],$_POST['sst1']);
}
?>