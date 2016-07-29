<?php
	include_once("lib/actionf.php");
	$fungsiop = new func();
	$fungsiop->secureURI($_SERVER['REQUEST_URI']);
?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
    	<div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">W I S</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="index.php?mod=barang">Lihat Barang</a></li>
              <li><a href="index.php?mod=barang-masuk">Barang Masuk</a></li>
              <li><a href="index.php?mod=barang-keluar">Barang Keluar</a></li>
              <li><a href="index.php?mod=kartustok">Kartu Stok</a></li>
              <li><a href="index.php?mod=laporanstok">Laporan Stok</a></li>
              <li><a href="index.php?mod=laporanbulanan">Laporan Bulanan</a></li>
              <li><a href="index.php?mod=viewlaporan">View Laporan</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="index.php?mod=logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
</nav>