<?php
class koneksi{
	private $host = "localhost";	
	private $username = "root";
	private $password = "kimcil123";
	private $db = "projgudang";
	private $konek;
	function __construct(){
		$this->konek = mysql_connect($this->host,$this->username,$this->password);
		$this->conn = mysql_select_db($this->db,$this->konek);
	}
	
}
?>