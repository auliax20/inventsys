<?php
class func{
	private $konek;
	private $qry;
	private $row;
	private $num;
	private $start;
	public $stt;
	public $stt1;
	public $fqty;
	public $spage;
	public $fpage;
	public $databarang;
	public $jumlahbarang;
	public $paget;
	public $lapstok;
	function __construct(){
		include_once("connection.php");
		$this->konek = new koneksi();
	}
	function countBarang(){
		$this->qry = mysql_query("SELECT count(*) FROM barang");
		$this->row = mysql_fetch_array($this->qry);
		$this->jumlahbarang = $this->row[0];
		$this->paget = ceil($this->jumlahbarang/25);
		return $this->jumlahbarang;
		return $this->paget;
		
	}
	function paginationPage($page,$jpage){
		if($page>25){
			if($page>$jpage-25){
				$this->spage = $jpage - 25;
				$this->fpage = $jpage;
			}else{
				$this->spage = $page - 1;
				$this->fpage = $page + 25;
			}
		}else{
			$this->spage = 1;
			$this->fpage = 25;	
		}	
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
	function searchKode($val,$fil){
		if($fil=="kobr"){
			$this->qry = mysql_query("SELECT kode_barang,nama_barang,stn,sst,stn1,sst1 FROM barang WHERE kode_barang LIKE '%".mysql_escape_string($val)."%'");
			while($this->row = mysql_fetch_array($this->qry)){
				$this->databarang[] = array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stn'],$this->row['sst'],$this->row['stn1'],$this->row['sst1']);
			}
			return $this->databarang;
		}else{
			$this->qry = mysql_query("SELECT kode_barang,nama_barang,stn,sst,stn1,sst1 FROM barang WHERE nama_barang LIKE '%".mysql_escape_string($val)."%'");
			while($this->row = mysql_fetch_array($this->qry)){
				$this->databarang[] = array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stn'],$this->row['sst'],$this->row['stn1'],$this->row['sst1']);
			}
			return $this->databarang;	
		}
	}	
	function loginSystem($username,$password){
		//LOGIN SYSTEM 
		//USING PARAMETER USERNAME DAN PASSWORD 
		//ENKRIPSI PASSWORD MD5
		$this->qry = mysql_query("SELECT status,type FROM user WHERE username='"
		.mysql_escape_string($username)."' AND password='".mysql_escape_string(md5($password))."'");
		$this->row = mysql_fetch_array($this->qry);
		$this->num = mysql_num_rows($this->qry);
		if($this->num==1){
			if($this->row['status']=="aktif"){
				$_SESSION['username'] = mysql_escape_string($username);
				$_SESSION['type'] = mysql_escape_string($this->row['type']);
				header("Location: index.php");
			}else{
				header("Location: login.php?res=not-active");	
			}
		}else{
			header("Location: login.php?res=not-login");	
		}		
	}
	function cekLogin($username){
		$this->qry = mysql_query("SELECT status FROM user WHERE username='".mysql_escape_string($username)."'");
		$this->row = mysql_fetch_array($this->qry);
		$this->num = mysql_num_rows($this->qry);
		if($this->num!=1){
			header("Location: login.php?res=not-login");	
		}	
	}
	function secureURI($url){
		$uri = $url;
		$pos = strpos(strtolower($uri),"index");
		if($pos==FALSE){
			header("Location: index.php");
		}
	}
	function getStok($kobr){
		$this->qry = mysql_query("SELECT stok_akhir FROM barang_detail WHERE kode_barang='".mysql_escape_string($kobr)."'");
		$this->row = mysql_fetch_array($this->qry);	
		return $this->row['stok_akhir'];
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
	function updateStok($kobr,$val){
		$this->cekDetailBarang($kobr);
		$this->qry = mysql_query("UPDATE barang_detail SET stok_akhir='".mysql_escape_string($val)."' WHERE kode_barang='".mysql_escape_string($kobr)."'");
		if($this->qry){
			/*echo("<script>alert(\"STOK BERHASIL DITAMBAHKAN\");</script>");	*/
		}
	}
	function barangKeluar($nodo,$kobr,$val,$stoks,$ket){
		$this->qry = mysql_query("INSERT INTO barang_keluar(no_do,kode_barang,jumlah_keluar,stoks,keterangan) VALUES('".mysql_escape_string($nodo)."','".mysql_escape_string($kobr)."','".mysql_escape_string($val)."','".mysql_escape_string($stoks)."','".mysql_escape_string($ket)."')");
		if($this->qry){
			/*echo("<script>alert(\"PENAMBAHAN BARANG KELUAR BERHASIL DISIMPAN\");</script>");	*/
		}	
	}
	function barangMasuk($nodo,$kobr,$val,$stoks,$ket){
		$this->qry = mysql_query("INSERT INTO barang_masuk(no_lpb,kode_barang,jumlah_masuk,stoks,keterangan) VALUES('".mysql_escape_string($nodo)."','".mysql_escape_string($kobr)."','".mysql_escape_string($val)."','".mysql_escape_string($stoks)."','".mysql_escape_string($ket)."')");
		if($this->qry){
			/*echo("<script>alert(\"PENAMBAHAN BARANG MASUK BERHASIL DISIMPAN\");</script>");	*/
		}	
	}
	function viewBarangMasuk($type){
		if($type=="admin"){
			$this->qry = mysql_query("SELECT barang_masuk.*,barang.nama_barang FROM barang_masuk,barang WHERE barang.kode_barang=barang_masuk.kode_barang ORDER BY tglmasuk DESC LIMIT 0,25");
		}else{
			$this->qry = mysql_query("SELECT barang_masuk.*,barang.nama_barang FROM barang_masuk,barang WHERE barang.kode_barang=barang_masuk.kode_barang ORDER BY tglmasuk DESC LIMIT 0,25");	
		}
		while($this->row = mysql_fetch_array($this->qry)){
			$this->databarang[] = array($this->row['kode_barang']." - ".$this->row['nama_barang'],$this->row['no_lpb'],$this->row['jumlah_masuk'],$this->row['tglmasuk'],$this->row['stoks']);	
		}
		return $this->databarang;
		
	}
	function viewBarangKeluar($type){
		if($type=="admin"){
			$this->qry = mysql_query("SELECT barang_keluar.*,barang.nama_barang FROM barang_keluar,barang WHERE barang.kode_barang=barang_keluar.kode_barang ORDER BY tanggal_keluar DESC LIMIT 0,25");
		}else{
			$this->qry = mysql_query("SELECT barang_keluar.*,barang.nama_barang FROM barang_keluar,barang WHERE barang.kode_barang=barang_keluar.kode_barang ORDER BY tanggal_keluar DESC LIMIT 0,25");	
		}
		echo mysql_error();
		while($this->row = mysql_fetch_array($this->qry)){
			$this->databarang[] = array($this->row['kode_barang']." - ".$this->row['nama_barang'],$this->row['no_do'],$this->row['jumlah_keluar'],$this->row['tanggal_keluar'],$this->row['stoks']);	
		}
		return $this->databarang;
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
	function laporanStok(){
		$this->qry = mysql_query("SELECT * FROM barang_detail,barang WHERE barang_detail.stok_awal!='0' AND barang_detail.stok_akhir!='0' AND barang.kode_barang=barang_detail.kode_barang ORDER BY barang_detail.kode_barang ASC");
		while($this->row = mysql_fetch_array($this->qry)){
			$this->lapstok[]=array($this->row['kode_barang'],$this->row['nama_barang'],$this->row['stok_akhir']);
		}
		return $this->lapstok;	
	}
	function cekDetailBarang($kobr){
		$this->qry = mysql_query("SELECT * FROM barang_detail WHERE kode_barang='".mysql_escape_string($kobr)."'");
		$this->num = mysql_num_rows($this->qry);
		if($this->num < 1){
			$this->qry = mysql_query("INSERT INTO barang_detail(kode_barang,stok_awal,stok_akhir) VALUES('".mysql_escape_string($kobr)."','0,'0')");	
		}
	}
}
?>