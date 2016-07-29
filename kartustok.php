<script>
  $(function() {
    var availableTags = [
    <?php
		include_once("lib/actionf.php");
		$funct = new func();
		$data = $funct->viewKode("all");
		$jdata = count($data);
		for($i=1;$i<=$jdata;$i++){
			$datadd = $i-1;
			if($i<$jdata){
				printf("\"".$data[$datadd][0]." - ".str_ireplace("\"","\\\"",$data[$datadd][1])."\"".","."\n");
			}else{
				printf("\"".$data[$datadd][0]." - ".str_ireplace("\"","\\\"",$data[$datadd][1])."\""."\n");
			}
		}
	?>
    ];
    $("#tags").autocomplete({
      source: availableTags
    });
  });
</script>
<div class="row">
<form class="form-inline" method="post" action="<?php echo("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
  <div class="form-group">
    <label for="tags">KODE BARANG</label>
    <input type="text" class="form-control" id="tags" placeholder="KODE / NAMA BARANG" name="kobr">
  </div>
  <div class="form-group">
    <label for="tanggal1">DARI</label>
    <input type="text" class="form-control" id="tanggal1" placeholder="TANGGAL AWAL" name="tgl1">
  </div>
  <div class="form-group">
    <label for="tanggal2">SAMPAI</label>
    <input type="text" class="form-control" id="tanggal2" placeholder="TANGGAL AKHIR" name="tgl2">
  </div>
  <button type="submit" class="btn btn-primary">LIHAT KARTU STOK</button>
</form>
<h2 class="text-center">Kartu Stok</h2>
<?php
if(isset($_POST['kobr'])){
	echo("<h3>Kode Barang:".substr($_POST['kobr'],0,11)."</h3>");	
	echo("<h3>Nama Barang:".substr($_POST['kobr'],14,100)."</h3>");	
}
?>
<table class="table table-bordered table-striped">
	<tr>
    	<th>TANGGAL</th>
        <th>NOMOR BUKTI</th>
        <th>KETERANGAN</th>
        <th>MASUK</th>
        <th>KELUAR</th>
        <th>SISA STOK</th>
    </tr>
    <?php
	if(isset($_POST['kobr'])){
		include_once("lib/actionf.php");
		$db = new func();
		$inventory = $db->kartuStok(substr($_POST['kobr'],0,11),str_replace("/","-",$_POST['tgl1']),str_replace("/","-",$_POST['tgl2']));
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
				echo("<td>".$inventory[$i]['keterangan']."</td>");
				if($inventory[$i]['jenis']=="masuk"){
					echo("<td>".$db->converterk(substr($_POST['kobr'],0,11),$inventory[$i]['jumlah'])."</td>");
					echo("<td></td>");
				}else if($inventory[$i]['jenis']=="keluar"){
					echo("<td></td>");
					echo("<td>".$db->converterk(substr($_POST['kobr'],0,11),$inventory[$i]['jumlah'])."</td>");	
				}
				echo("<td>".$db->converterk(substr($_POST['kobr'],0,11),$inventory[$i]['stoks'])."</td>");
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
<?php
	if(isset($_POST['kobr'])){
	echo("<a href=\"http://".$_SERVER['HTTP_HOST']."/printkartustok.php?kobr=".$_POST['kobr']."&tgl1=".str_replace("/","-",$_POST['tgl1'])."&tgl2=".str_replace("/","-",$_POST['tgl2'])."\"><button class=\"btn btn-primary\">PRINT KARTU STOK<button></a>");
	}
?>
</div>