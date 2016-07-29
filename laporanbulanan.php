<div class="row">
<form class="form-inline" method="post" action="<?php echo("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
  <div class="form-group">
    <label for="tanggal1">DARI</label>
    <input type="text" class="form-control" id="tanggal1" placeholder="TANGGAL AWAL" name="tgl1">
  </div>
  <div class="form-group">
    <label for="tanggal2">SAMPAI</label>
    <input type="text" class="form-control" id="tanggal2" placeholder="TANGGAL AKHIR" name="tgl2">
  </div>
  <button type="submit" class="btn btn-primary">PROSES LAPORAN</button>
</form>
<?php
	if(isset($_POST['tgl1'])){
		include_once("lib/actionf.php");
		$db = new func();
		$inventory = $db->createLaporan(str_replace("/","-",$_POST['tgl1']),str_replace("/","-",$_POST['tgl2']));
	}
	?>
</div>