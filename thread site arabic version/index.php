<!DOCTYPE html>
<html dir = "rtl">
<header>
	<!-- تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)-->
<?php session_start(); require_once("config.php"); ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="style/js/bootstrap.js"></script>
  <script src="js/script.js"></script>
  <link rel="stylesheet" href="style/css/bootstrap.css">
  <link rel="stylesheet" href="style/style.css">
	<title><?php echo siteName ?></title>
</header>
<body>
	<?php
	function autoload($class){
		$ClassPath =  "./classes/".$class.".class.php";
		$controllerPath =  "./controller/".$class.".php";
		if (file_exists($ClassPath)){
		require $ClassPath;
		}elseif(file_exists($controllerPath)){
			require $controllerPath;
		}
	}
	spl_autoload_register("autoload");
	try{
	$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
	$l = true;
	} catch(PDOException $e){
		$l=false;
	}
	if($l == false ){
		if($_GET['url'] !== 'install'){
		header("Location:install");
		}
	}else{
		if($con->query("select 1 from thread,replays,accounts limit 1") !== false){
	?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#"><?php echo siteName ?></a>
	 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	 <span class="navbar-toggler-icon"></span>
	  </button>
	 <div class="navbar-collapse collapse" id="navbarSupportedContent">
	 <ul class="navbar-nav text-right">
	 <li class="nav-item">
	 <a id="home" class="nav-link linker active" href="home"><i class="fa fa-home"></i> الرئيسية</a>
	 </li>
	 <li class="nav-item">
	 <a id="reg" class="nav-link linker" href="register"><i class="fa fa-user-plus"></i> إنشاء حساب</a>
	 </li>
	 <li class="nav-item">
	 <?php if(!empty($_SESSION['user'])){ ?>
	 <a id="cth" class="nav-link linker" href="createThread"><i class="fa fa-pencil-square-o"></i> إنشاء موضوع</a>
	 <?php }?>
	 </li>
	 </ul>
	 </div>
	 <ul class="navbar-nav text-left">
	 <li class="nav-item">
	 <form method="post">
	 <?php if(!empty($_SESSION['user'])){ ?>
	 
	 <img id = "imgprof" class="img-responsive inline-block" src="<?php echo(($_SESSION['img'] != 1) ?  $_SESSION['img'] : "style/noimg.png") ?>"> <span class="text-white"> مرحباً بك يا  <?php echo $_SESSION['name']; ?></span> <button type="submit" name="logout" class="btn btn-outline-light"><i class="fa fa-sign-out"></i> تسجيل خروج</button>
	 <?php }else{ ?>
		<button type="button" name="login" data-toggle="modal" data-target="#LoginForm" class="btn btn-outline-light"><i class="fa fa-sign-in"> </i>   تسجيل الدخول</button>
	 <?php } ?>
	 </form>
	 </li>
	 </ul>
	 </nav>

	 <form id = "LoginForm" method="post" class="modal fade">
	 <div class="modal-dialog">
		 <div class="modal-content p-3">
		 <div class="modal-header">
		 <button type="button" class="close position-absolute" data-dismiss="modal">&times;</button>
		 <h4 class="modal-title" style="margin: 0 auto;">تسجيل الدخول</h4>
		 </div>
	 <div class="form-group">
		 <input id="user" class="form-control" placeholder="اسم المستخدم" type="text" name="username" required>
</div>
	 <div class="form-group">
		 <input id="pass" class="form-control" placeholder="كلمة المرور" type="password" name="password" required>
</div>
<button onclick="loginfunc(this)" class="btn btn-dark btn-lg btn-lg btn-block font-weight-bold" name="loginbtn" type="button"><i class="fa fa-sign-in"> </i>   دخول</button>
</div>
</div>
	 </form>
<?php
// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
	}else{
		if($_GET['url'] !== 'install'){
		header("Location:install");
		}
	}
}
require_once("routing.php");
if(empty($_GET['url'])){
	controller::CreateView("showThreads");
}else{
routing::get($_GET['url']);
}
if(isset($_POST['logout'])){
	session_unset();
	session_destroy();
	echo('<meta http-equiv="refresh" content="0">');
}
?>
<footer class="footer">© 2020 Copyright: moustafa mahmoud (MKO)
	<br><a id = "links" href="https://twitter.com/MkoMostafa" class="fa fa-twitter"></a>
	<a id = "links" href="https://github.com/mko543" class="fa fa-github"></a>
	<a id = "links" href="https://www.facebook.com/moustafa.elshamy.9275" class="fa fa-facebook-square"></a>
	<a id = "links" href="https://khamsat.com/user/mko543" class="khamsat"><img src="data:image/jpeg;base64,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" alt=""></a>
</footer>
</body>
</html>