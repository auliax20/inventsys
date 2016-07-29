<?php
	include_once("lib/actionf.php");
	$fungsiop = new func();
	$fungsiop->secureURI($_SERVER['REQUEST_URI']);
	if(isset($_POST['tambah'])){
		include_once("lib/actionf.php");
		$sto = new func();
		$sto->getStt(substr($_POST['kobrnbr'],0,11));
		$stt1 = $sto->stt1;
		$stt = $sto->stt;
		$stokakhir = $sto->getStok(substr($_POST['kobrnbr'],0,11));
		$stom = ($_POST['satuanbesar']*$stt)+($_POST['satuankecil']);
		$fsto = $stom+$stokakhir;
		$sto->updateStok(substr($_POST['kobrnbr'],0,11),$fsto);
		$sto->barangMasuk($_POST['nolpb'],substr($_POST['kobrnbr'],0,11),$stom,$fsto,$_POST['ket']);
	}
?>
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
	<h2 class="text-center">INPUT BARANG MASUK</h2>
	<div class="col-md-4">
		<form method="post" action="<?php echo("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
		  	<div class="form-group">
				<label for="exampleInputEmail1">Kode Barang</label>
                <div class="ui-widget">
    				<input class="form-control" id="tags" placeholder="Nama Barang / Kode barang" name="kobrnbr" type="text" autofocus="autofocus" />
                </div>
			</div>
  			<div class="form-group">
   				<label for="stokawal">Stok Awal</label>
   				<input type="text" class="form-control" id="stokawal" placeholder="Stok Awal" name="stokawal" readonly>
                
  			</div>
  			<div class="form-group">
  				<label for="nolpb">Nomor LPB</label>
    			<input type="text" id="nolpb" class="form-control" placeholder="No LPB" name="nolpb" value="<?php 
				if($_POST){
					if(isset($_POST['againlpb'])){
						echo $_POST['nolpb'];
					}else{
						echo"";
					}
				} ?>"/>
                
		  	</div>
            <!--<div class="checkbox"><label><input type="checkbox" id="nolpb" name="againlpb" value="tr">LPB TETAP</label></div>-->
            <div class="form-group">
  				<label for="nolpb">Keterangan</label>
    			<input type="text" id="ket" class="form-control" placeholder="Keterangan" name="ket" value="<?php if($_POST){if(isset($_POST['againketl'])){echo $_POST['ket'];}else{echo"";}} ?>"/>
		  	</div>
            <!--<div class="checkbox"><label><input type="checkbox" id="nolpb" name="againketl" value="tr">KET TETAP</label></div>-->
            <div class="form-group">
  				<label for="jmlmasuk">Jumlah Masuk</label>
    			<input type="text" id="jmlmasuk" class="form-control" placeholder="Satuan Besar" name="satuanbesar">
                <input type="text" id="jmlmasuk" class="form-control" placeholder="Satuan Kecil" name="satuankecil">
                
		  	</div>
  			<input type="submit" class="btn btn-default" name="tambah" value="TAMBAH" />
		</form>
	</div>
  	<div class="col-md-8">
    	<table class="table table-bordered table-hover">
        	<tr>
            	<th>Kode + Nama</th>
                <th>Nomor LPB</th>
                <th>Jumlah Masuk</th>
                <th>Tanggal Masuk</th>
            </tr>
        	<?php
				include_once("lib/actionf.php");
				$view = new func();
				$data = $view->viewBarangMasuk($_SESSION['type']);
				$jdata = count($data);
				for($i=0;$i<$jdata;$i++){
					echo("<tr>");
					echo("<td>".$data[$i][0]."</td>");
					echo("<td>".$data[$i][1]."</td>");
					echo("<td>".$dus = $view->converterk(substr($data[$i][0],0,11),$data[$i][2])."</td>");
					echo("<td>".$data[$i][3]."</td>");
					echo("</tr>");
				}
			?>
        </table>
    </div>
</div>