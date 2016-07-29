<?php
class adminControl{
	private $sectoken;
	private $qry;
	private $sqlnum;
	private $row;
	private $uri;
	private $passw,$type;
	private $kode,$nama,$stn,$sst,$stn1,$sst1,$tanggal;
	private $data;
	private $cstok,$cawal,$cakhir,$cbase;
	function __construct(){
		include_once("connectiondev.php");
		$this->konek = new koneksi();
		$this->secureURI();
	}
	function secureURI(){
		$this->uri = $_SERVER['REQUEST_URI'];
		if(strpos(strtolower($this->uri),"home")||strpos(strtolower($this->uri),"index")){
			
		}else{
			header("Location: ../index.php");	
		}
	}
	function checkToken($token){
		$this->sectoken = mysql_escape_string($token);
		$this->qry = mysql_query("SELECT * FROM admin WHERE token='".$this->sectoken."' AND (type='superadmin' OR type='supportadmin')");
		$this->sqlnum = mysql_num_rows($this->qry);
		if($this->sqlnum == 1){
			$this->row = mysql_fetch_array($this->qry);
			$_SESSION['token']=$token;
			header("Location: home.php?mod=login&user=".$this->row['username']);
		}else{
			header("Location: ../404.php");	
		}
	}	
	function checkLogin($user,$password){
		$this->passw = md5(mysql_escape_string($password));
		$this->qry = mysql_query("SELECT * FROM admin WHERE username='".mysql_escape_string($user)."' AND password='".$this->passw."' AND token='".$_SESSION['token']."'");
		$this->sqlnum = mysql_num_rows($this->qry);
		echo($this->sqlnum);
		if($this->sqlnum==1){
			$_SESSION['username'] = $user;
			header("Location: index.php");
		}else{
			session_destroy();
			session_regenerate_id();
			header("Location: ../404.php");	
		}
	}
	function checkUser($user,$token){
		$this->qry = mysql_query("SELECT * FROM admin WHERE username='".mysql_escape_string($user)."' AND token='".mysql_escape_string($_SESSION['token'])."'");
		$this->sqlnum = mysql_num_rows($this->qry);
		if($this->sqlnum!=1){
			session_destroy();
			session_regenerate_id();
			header("Location: ../404.php");	
		}
	}
	function inputBarangMasuk($kode,$nama,$stn,$sst,$stn1,$sst1){
		$this->kode = mysql_escape_string($kode);
		$this->nama = mysql_escape_string($nama);
		$this->stn = mysql_escape_string($stn);
		$this->sst = mysql_escape_string($sst);
		$this->stn1 = mysql_escape_string($stn1);
		$this->sst1 = mysql_escape_string($sst1);
		$this->qry = mysql_query("INSERT INTO barang(kode_barang,nama_barang,stn,sst,stn1,sst1) VALUES('".$this->kode."','".$this->nama."','".$this->stn."','".$this->sst."','".$this->stn1."','".$this->sst1."')");
	}
	function kartuStok($kobr,$tgl1,$tgl2){
		$this->qry = mysql_query("SELECT * FROM barang_masuk WHERE kode_barang='".mysql_escape_string($kobr)."' AND tglmasuk>='".mysql_escape_string($tgl1)."' AND tglmasuk<='".mysql_escape_string($tgl2)."'");
		while($this->row = mysql_fetch_array($this->qry)){
			$this->databarang[]=array("jenis"=>"masuk","nobukti"=>$this->row['no_lpb'],"jumlah"=>$this->row['jumlah_masuk'],"tanggal"=>$this->row['tglmasuk'],"stoks"=>$this->row['stoks'],"keterangan"=>$this->row['keterangan']);
		}
		$this->qry = mysql_query("SELECT * FROM barang_keluar WHERE kode_barang='".mysql_escape_string($kobr)."' AND tanggal_keluar>='".mysql_escape_string($tgl1)."' AND tanggal_keluar<='".mysql_escape_string($tgl2)."'");				
		while($this->row = mysql_fetch_array($this->qry)){
			$this->databarang[]=array("jenis"=>"keluar","nobukti"=>$this->row['no_do'],"jumlah"=>$this->row['jumlah_keluar'],"tanggal"=>$this->row['tanggal_keluar'],"stoks"=>$this->row['stoks'],"keterangan"=>$this->row['keterangan']);
		}
		return $this->databarang;
	}
	function viewKode($limit){
		if($limit==null){
			//UNTUK LIHAT KODE
			$this->qry = mysql_query("SELECT kode_barang,nama_barang,stn,sst,stn1,sst1 FROM barang LIMIT 0,25");
			while($this->row = mysql_fetch_array($this->qry)){
				$this->databarang[] = array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stn'],$this->row['sst'],$this->row['stn1'],$this->row['sst1']);
			}
			return $this->databarang;
		}else if($limit>0){
			$this->start = ($limit-1)*25;
			$this->qry = mysql_query("SELECT kode_barang,nama_barang,stn,sst,stn1,sst1 FROM barang LIMIT ".$this->start.",25");
			while($this->row = mysql_fetch_array($this->qry)){
				$this->databarang[] = array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stn'],$this->row['sst'],$this->row['stn1'],$this->row['sst1']);
			}
			return $this->databarang;	
		}else if($limit=="all"){
			$this->qry = mysql_query("SELECT kode_barang,nama_barang,stn,sst,stn1,sst1 FROM barang ORDER BY nama_barang ASC");
			while($this->row = mysql_fetch_array($this->qry)){
				$this->databarang[] = array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stn'],$this->row['sst'],$this->row['stn1'],$this->row['sst1']);
			}
			return $this->databarang;	
		}
	}
	function converter($kobr,$val){
		$this->qry = mysql_query("SELECT sst,sst1 FROM barang WHERE kode_barang='".mysql_escape_string($kobr)."'");	
		$this->row = mysql_fetch_array($this->qry);
		$this->stt = $this->row['sst'];
		$this->stt1 = $this->row['sst1'];
		$this->fqty = floor($val/$this->stt1).".".fmod($val,$this->stt1);		
		return $this->fqty;
	}
	function converterk($kobr,$val){
		$this->qry = mysql_query("SELECT sst,sst1 FROM barang WHERE kode_barang='".mysql_escape_string($kobr)."'");	
		$this->row = mysql_fetch_array($this->qry);
		$this->stt = $this->row['sst'];
		$this->stt1 = $this->row['sst1'];
		$this->fqty = floor($val/$this->stt).".".fmod($val,$this->stt);		
		return $this->fqty;
	}
	function getStt($kobr){
		$this->qry = mysql_query("SELECT sst,sst1 FROM barang WHERE kode_barang='".mysql_escape_string($kobr)."'");	
		$this->row = mysql_fetch_array($this->qry);
		$this->stt = $this->row['sst'];
		$this->stt1 = $this->row['sst1'];	
	}
	function getDataStokTgl($kobr,$tgl,$type){
		$this->type = mysql_escape_string($type);
		$this->kode = mysql_escape_string($kobr);
		$this->tanggal = mysql_escape_string($tgl);
		if($this->type=="masuk"){
			$this->qry = mysql_query("SELECT * FROM barang_masuk WHERE kode_barang='{$this->kode}' AND tglmasuk='{$this->tanggal}'");
			$this->data = mysql_fetch_array($this->qry);
		}else if($this->type=="keluar"){
			$this->qry = mysql_query("SELECT * FROM barang_keluar WHERE kode_barang='{$this->kode}' AND tanggal_keluar='{$tgl}'");
			$this->data = mysql_fetch_array($this->qry);	
		}else{
			$this->data = NULL;	
		}
		return $this->data;
	}
	function editDataKartuStok($kobr,$tgl,$awal,$akhir,$base,$type){
		$this->cbase = $base;
		$this->cawal = $awal;
		$this->cakhir = $akhir;
		$this->type = $type;
		$this->qry = mysql_query("SELECT * FROM barang_masuk WHERE kode_barang='{$kobr}' AND tglmasuk>='{$tgl}'");	
		$this->row = mysql_fetch_array($this->qry);
		while($this->row = mysql_fetch_array($this->qry)){
			if($this->type == "masuk"){
				echo("");
			}elseif($this->type == "keluar"){
				
			}else{
				exit();	
			}
		}
		$this->qry = mysql_query("SELECT * FROM barang_keluar WHERE kode_barang='{$kobr}' AND tanggal_keluar>='{$tgl}'");
		$this->row = mysql_fetch_array($this->qry);
		while($this->row = mysql_fetch_array($this->qry)){
			//logic here
		}
	}
}
?>