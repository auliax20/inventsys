<?php
	session_start();
	error_reporting(0);
	if(isset($_SESSION['username'])){
		include_once("lib/actionf.php");
		$ceklogin = new func();
		$ceklogin->cekLogin($_SESSION['username']);
	} else {
		header("Location: login.php");	
	}
?>
<!DOCTYPE html>
<html lang="id-ID">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory System</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/datepicker.css">
<style>
.ui-front{
	z-index:1150;
}
</style>
<script src="js/eventhandler.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#tanggal1').datepicker({
                    format: "yyyy/mm/dd"
                });
				$('#tanggal2').datepicker({
                    format: "yyyy/mm/dd"
                });  
            
            });
        </script>
</head>
<body>
<div id="header">
<?php
	include_once("menu.php");
?>
</div>
<div id="content">
<?php
	if(isset($_GET['mod'])){
		if($_GET['mod']=="logout"){
			include_once("logout.php");
		}else if($_GET['mod']=="barang"){
				include_once("barang.php");
		}else if($_GET['mod']=="barang-masuk"){
				include_once("barangmasuk.php");
		}else if($_GET['mod']=="barang-keluar"){
				include_once("barangkeluar.php");
		}else if($_GET['mod']=="kartustok"){
				include_once("kartustok.php");
		}else if($_GET['mod']=="laporanstok"){
				include_once("laporanstok.php");
		}else if($_GET['mod']=="laporanbulanan"){
				include_once("laporanbulanan.php");
		}else if($_GET['mod']=="viewlaporan"){
				include_once("viewlaporan.php");
		}
	}else{
		include_once("home.php");	
	}
?>

</div>
<div id="footer">
	<p class="text-center">Warehouse Information System, BY W2IT - TEAM &copy <?php $tanggal=getdate(); echo $tanggal['year']; ?> </p>;
</div>
</body>
</html>