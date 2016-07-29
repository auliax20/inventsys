<?php
	include_once("lib/actionf.php");
	$lapst = new func();
	$sec = $lapst->secureURI($_SERVER['REQUEST_URI']); 
	$datalap = $lapst->laporanStok();
?>
<div class="row">
	<h2 class="text-center">LAPORAN STOK BARANG</h2>
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
        	<tr>
            	<td>NO</td>
                <td>KODE BARANG</td>
                <td>NAMA BARANG</td>
                <td>STOK AKHIR</td>
            </tr>
            <?php
				$jdt = count($datalap);
				$no = 0;
				for($i=0;$i<$jdt;$i++){
					$no = $i+1;
					echo("<tr>");
					echo("<td>".$no."</td>");
					$jda = count($datalap[$i]);
					for($j=0;$j<$jda;$j++){
						if($j==2){
							echo("<td>".$lapst->converterk($datalap[$i][0],$datalap[$i][$j])."</td>");	
						}else{
							echo("<td>".$datalap[$i][$j]."</td>");	
						}	
					}
					echo("</tr>");
				}
			?>
        </table>
    </div>
</div>