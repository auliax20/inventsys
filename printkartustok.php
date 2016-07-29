<!DOCTYPE html>
<html lang="id-ID">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory System</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/datepicker.css">
</head>
<body>
<div id="content">
<div class="row">
<h2 class="text-center">Kartu Stok</h2>
<?php
	if(isset($_GET['kobr'])){
		echo("<h3>Kode Barang:".substr($_GET['kobr'],0,11)."</h3>");	
		echo("<h3>Nama Barang:".substr($_GET['kobr'],14,100)."</h3>");	
	}
?>
<table class="table table-bordered">
	<tr>
    	<th>TANGGAL</th>
        <th>NOMOR BUKTI</th>
        <th>JENIS</th>
        <th>JUMLAH</th>
        <th>SISA STOK</th>
    </tr>
    <?php
	if(isset($_GET['kobr'])){
		include_once("lib/actionf.php");
		$db = new func();
		$inventory = $db->kartuStok(substr($_GET['kobr'],0,11),str_replace("/","-",$_GET['tgl1']),str_replace("/","-",$_GET['tgl2']));
		if(count($inventory)>=1){
			$tanggal = array();
			foreach($inventory as $key => $row){
				$tanggal[$key] = $row['tanggal'];
			}
			array_multisort($tanggal,SORT_DESC,$inventory);
			$jdata = count($inventory);
			for($i=0;$i<$jdata;$i++){
				echo("<tr>");
				echo("<td>".$inventory[$i]['tanggal']."</td>");
				echo("<td>".$inventory[$i]['nobukti']."</td>");
				echo("<td>".$inventory[$i]['jenis']."</td>");
				echo("<td>".$db->converterk(substr($_GET['kobr'],0,11),$inventory[$i]['jumlah'])."</td>");
				echo("<td>".$db->converterk(substr($_GET['kobr'],0,11),$inventory[$i]['stoks'])."</td>");
				echo("</tr>");			
			}
		}else{
			echo("<tr>");
			echo("<td colspan=\"5\">");
			echo("<p class=\"text-center\">TIDAK ADA DATA</p>");	
			echo("</td>");
			echo("</tr>");	
		}
	}
	?>
</table>
<script>
window.print();
</script>
</div>
</div>
</body>