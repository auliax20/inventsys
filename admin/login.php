<?php
session_start();
if(isset($_POST['login'])){
	include_once("../lib/admincontroller.php");
	$login = new adminControl();
	$login->checkLogin($_POST['username'],$_POST['password']);
}
?>
<!DOCTYPE html>
<html lang="id-ID">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login System</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/login.css" rel="stylesheet">
</head>
<body>
<div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="../img/avatar_2x.png" />
            <h3>Welcome, Please Login!!</h3>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="inputEmail" class="form-control" placeholder="Username" required name="username" value="<?php echo $_GET['user']?>" readonly>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required autofocus name="password">
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login" value="login">Sign in</button>
            </form><!-- /form -->
            <?php
				if(isset($_GET['res'])){
					if($_GET['res']=="not-login"){
						echo("<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>Username / Password Salah Silahkan Cek Kembali</div>");
					}else if($_GET['res']=="not-active"){
						echo("<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>Username Anda Tidak Aktif Hubungi Administrator</div>");	
					}else{
						echo("<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>Unknown Error Contact Administrator</div>");
					}	
				}
			?>
        </div><!-- /card-container -->
    </div>
</body>
</html>