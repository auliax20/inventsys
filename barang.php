<?php
	include_once("lib/actionf.php");
	$fungsiop = new func();
	$fungsiop->secureURI($_SERVER['REQUEST_URI']);
?>
<form class="form-inline" method="post">
  <div class="form-group">
    <label for="exampleInputName2">Value</label>
    <input type="text" class="form-control" id="val" placeholder="Value" name="val">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">Filter</label>
    <select class="form-control" name="filter">
    	<option value="kobr">Kode Barang</option>
    	<option value="nbr">Nama Barang</option>
    </select>
  </div>
  <button type="submit" class="btn btn-default" name="act" value="search">Cari Barang</button>
</form>
<table class="table table-bordered table-hover">
	<tr>
		<th>NO</th>
        <th>KODE BARANG</th>
        <th>NAMA BARANG</th>
        <th>STN KECIL</th>
        <th>SST KECIL</th>
        <th>STN BESAR</th>
        <th>SST BESAR</th>
    </tr>
    <?php
    	include_once("lib/actionf.php");
		$barang = new func();
		if(!isset($_POST['act'])){
			if(!isset($_GET['page'])){
				$data = $barang->viewKode(null);
			}else{
				$data = $barang->viewKode($_GET['page']);	
			}
			$jdata = count($data);
			$no = 0;
			for($i=0;$i<$jdata;$i++){
				$jarr = count($data[$i]);
				$no = $i + 1;
				echo("<tr>");
				echo("<td>".$no."</td>");
				for($k=0;$k<$jarr;$k++){
					echo("<td>".$data[$i][$k]."</td>");
				}
				echo("</tr>");
			}
		}else{
			if($_POST['act']=="search"){
				$data = $barang->searchKode($_POST['val'],$_POST['filter']);	
				$jdata = count($data);
				$no = 0;
				for($i=0;$i<$jdata;$i++){
					$jarr = count($data[$i]);
					$no = $i + 1;
					echo("<tr>");
					echo("<td>".$no."</td>");
					for($k=0;$k<$jarr;$k++){
						echo("<td>".$data[$i][$k]."</td>");
					}
					echo("</tr>");
				}
			}
		}
		$jumb = $barang->countBarang();
	?>	
    <nav>
  		<ul class="pagination">
    		<li 
			<?php 
				if(!isset($_GET['page']) || $_GET['page']==1){
					echo("class=\"disabled\"");} 
			?>><a href="
			<?php 
			$prev = 0;
			$prev = $_GET['page'] - 1;
			if(!isset($_GET['page']) || $_GET['page']==1){
				echo("#");
			}else{
				echo("index.php?mod=barang&page=".$prev);
			} 
			?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php
				$tpage = $barang->paget;
				$cpage = 0;
				if(!isset($_GET['page'])){
					$cpage = 1;	
				}else{
					$cpage = $_GET['page'];
				}
				$pagination = $barang->paginationPage($cpage,$tpage);
				$stpage = $barang->spage;
				$fipage = $barang->fpage;
				for($a=$stpage;$a<=$fipage;$a++){
					echo("<li ");
					if($a==$cpage){
						echo("class=\"active\"");	
					}
					echo(">");
					echo("<a href=\"index.php?mod=barang&page=".$a."\">".$a." <span class=\"sr-only\">(current)</span></a></li>");			
				}
			?>
            <?php
				$next = $cpage + 1;
            	echo("<li ");
				if($cpage>=$tpage){
					echo("class=\"disabled\"");
					echo("><a href=\"#\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>");
				}else{
					echo("><a href=\"index.php?mod=barang&page=");
					echo("".$next."\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>");
				}
			?>
  		</ul>
	</nav>
</table>