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
		$fsto = $stokakhir-$stom;
		$sto->updateStok(substr($_POST['kobrnbr'],0,11),$fsto);
		$sto->barangKeluar($_POST['nodo'],substr($_POST['kobrnbr'],0,11),$stom,$fsto,$_POST['ket']);
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
	<h2 class="text-center">INPUT BARANG KELUAR</h2>
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
  				<label for="nolpb">Nomor DO</label>
    			<input type="text" id="nolpb" class="form-control" placeholder="No DO" name="nodo" value="<?php if($_POST){if(isset($_POST['againlpb'])){echo $_POST['nodo'];}else{echo"";}} ?>"/>
		  	</div>
            <!--<div class="checkbox"><label><input type="checkbox" id="nolpb" name="againdo" value="tr">DO TETAP</label></div>-->
            <div class="form-group">
  				<label for="nolpb">Keterangan</label>
    			<input type="text" id="ket" class="form-control" placeholder="Keterangan" name="ket" value="<?php if($_POST){if(isset($_POST['againketl'])){echo $_POST['ket'];}else{echo"";}} ?>"/>
		  	</div>
            <!--<div class="checkbox"><label><input type="checkbox" id="nolpb" name="againketd" value="tr">KET TETAP</label></div>-->
            <div class="form-group">
  				<label for="jmlmasuk">Jumlah Keluar</label>
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
                <th>Nomor DO</th>
                <th>Jumlah Keluar</th>
                <th>Tanggal Keluar</th>
            </tr>
        	<?php
				include_once("lib/actionf.php");
				$view = new func();
				$data = $view->viewBarangKeluar($_SESSION['type']);
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