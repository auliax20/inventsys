<?php
if(isset($_GET['mod'])){
	if($_GET['mod']=="stok"&&$_GET['filter']!=""){
		include_once("lib/actionf.php");
		$stok = new func();
		$vstok = $stok->getStok(substr($_GET['filter'],0,11));
		$dus = $stok->converterk(substr($_GET['filter'],0,11),$vstok);	
		echo $dus;
	}
}
?>