<script>
  $(function() {
    var availableTags = [
    <?php
		include_once("../lib/admincontroller.php");
		$funct = new adminControl();
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
<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>UBAH KARTU STOK
	</div>
    <div class="panel-body">
    	<div class="row">        
        	<div class="col-lg-12">
            	<div class="panel panel-warning">
					<div class="panel-heading">
						<i class="fa fa-fw"></i>UBAH KARTU STOK
					</div>
                    <div class="panel-body">
                    	<ul>
                    		<li>Data harus diubah dengan hati - hati</li>
                        	<li>Semua yang terhapus / terubah tidak dapat dikembalikan</li>
                        	<li>Semua yang terhapus / terubah tercatat pada history</li>
                        	<li>Semua kesalahan penghapusan / perubahan tanggung jawab admin yang bersangkutan</li>
                        </ul>
                    </div>
                 </div>

            	<form role="form" action="" method="post">
					<div class="form-group">
						<label>Kode Barang</label>
						<input class="form-control" name="kode_barang" id="tags">
					</div>
                    <div class="form-group">
						<label>Tanggal Awal</label>
						<input class="form-control" name="tanggal1" id="tanggal1">
					</div>
                    <div class="form-group">
						<label>Tanggal Akhir</label>
						<input class="form-control" name="tanggal2" id="tanggal2">
					</div>
                    <div class="form-group">
						<button type="submit" class="btn btn-primary" name="mstok">Search</button>
					</div>                        
                </form>
                <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive">
                	<table class="table table-striped table-bordered">
                    	<thead>
                        	<tr>
                            	<th>TANGGAL</th>
                                <th>NO BUKTI</th>
                                <th>KETERANGAN</th>
                                <th>MASUK</th>
                                <th>KELUAR</th>
                                <th>SISA STOK</th>
                                <th>OPERATION</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td>kkkkkkkkkkk</td>
                            	<td>11111111111</td>
                            	<td>111111111111111</td>
                            	<td>11111111111111</td>
                            	<td>1111111111111</td>
                            	<td>111111111111111111</td>
                            	<td><a><button class="btn btn-danger btn-sm">DELETE</button></a> <a><button class="btn btn-warning btn-sm">EDIT</button></a></td>
                            </tr>
                            <?php
								if(isset($_POST['mstok'])){
									include_once("../lib/admincontroller.php");	
									$dstok = new adminControl();
									$vstok = $dstok->kartuStok(substr($_POST['kode_barang'],0,11),$_POST['tanggal1'],$_POST['tanggal2']);
									$tanggal = array();
									foreach($vstok as $key => $row){
										$tanggal[$key] = $row['tanggal'];
									}
									array_multisort($tanggal,SORT_DESC,$vstok);
									$jdata = count($vstok);
									for($i=0;$i<$jdata;$i++){
											echo("<tr>");
												echo("<td>".$vstok[$i]['tanggal']."</td>");
												echo("<td>".$vstok[$i]['nobukti']."</td>");
												echo("<td>".$vstok[$i]['keterangan']."</td>");
												if($vstok[$i]['jenis']=="masuk"){
													echo("<td>".$dstok->converterk(substr($_POST['kode_barang'],0,11),$vstok[$i]['jumlah'])."</td>");
													echo("<td></td>");
												}else if($vstok[$i]['jenis']=="keluar"){
													echo("<td></td>");
													echo("<td>".$dstok->converterk(substr($_POST['kode_barang'],0,11),$vstok[$i]['jumlah'])."</td>");	
												}
												echo("<td>".$dstok->converterk(substr($_POST['kode_barang'],0,11),$vstok[$i]['stoks'])."</td>");
												echo("<td><a href=\"index.php?modul=delete&act=kartu-stok&kode=".substr($_POST['kode_barang'],0,11)."&tanggal=".$vstok[$i]['tanggal']."&type=".$vstok[$i]['jenis']."\"><button class=\"btn btn-danger btn-sm\">DELETE</button></a>
												<a href=\"index.php?modul=edit&act=kartu-stok&kode=".substr($_POST['kode_barang'],0,11)."&tanggal=".$vstok[$i]['tanggal']."&type=".$vstok[$i]['jenis']."\"><button class=\"btn btn-warning btn-sm\">EDIT</button></a>"."</td>");
												echo("</tr>");			
									}	
								}
							?>
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>