<!-- تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)-->
<script>
$(".nav-link").attr("class","nav-link linker");
$("#reg").attr("class","nav-link linker active");
</script>
<form method="post" id="createAccount" class="multi container p-5 my-lg-5 text-center rounded-lg" enctype="multipart/form-data">
		<div id="itemImg">
			 <label id="up" for="upimg">
				 <p type="button" id="buttonup">+</p>
			 <img id="theimg" src="style/noimg.png">
			 </label>
			 <input type="file" onchange="viewImg(this)" id="upimg" name="upimg">
		</div><br>
	 <div class="form-group">
		 <input id="Name" class="form-control" placeholder="الأســــم" type="text" name="showName" required>
</div>
	 <div class="form-group">
		 <input class="form-control" placeholder="اسم المستخدم" type="text" name="user" required>
</div>
<div class="form-group">
		 <input class="form-control" placeholder = "كلمة المرور" type="password" name="pass" required>
		 </div>
		 <div class="form-group">
		 <input id="PassConf" class="form-control" placeholder = "تأكيد كلمة المرور" type="password" name="PassConf" required>
		 </div>
		 <div class="form-group">
		 <input id="email" class="form-control" placeholder = "البريد الإلكتروني" type="email" name="email" >
		 </div>
		 <div class="form-group">
		 <input id="emailconf" class="form-control" placeholder = "تأكد البريد الإلكتروني" type="email" name="emailconf" required>
		 </div>
		 <div class="form-group">
		 <button id="btnreg" class="btn btn-dark btn-lg btn-lg btn-block font-weight-bold" name="regbtn" type="submit" value="reg">تسجيل</button>
		 </div>
		 <?php
		 // تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
if(isset($_POST['regbtn'])){
	if(controller::checkPost() == 1){
    $name = $_POST['showName'];
    $user = $_POST['user'];
	$pass = $_POST['pass'];
	$md5pass = md5("mkmk".$pass);
	$email = $_POST['email'];
	if(controller::regexArEG(array($name)) == false or controller::regexEG(array($user,$pass,$email)) == false){
		echo(controller::errormsg("لقد ادخلة رموز او احرف غير متاحه في احد الحقول او انها تقل عن عدد 2 احرف"));
	}else{
    $date = date("Y-m-d H:i:s");
	$ip = controller::getUserIpAddr();
	if(isset($_FILES['upimg'])){
		$imgea = controller::uploadimg('upimg',"image",round(microtime(true)));
		}else{
			$imgea = 1;
		}
    if ($pass == $_POST['PassConf'] && $email == $_POST['emailconf']){
    $res = controller::Register("showname,username,email,password,register_date,image,reg_ip,last_ip","('$name','$user','$email','$md5pass','$date','$imgea','$ip','$ip')","accounts");
    print_r($res);
	}
}
}else{
	echo(controller::errormsg("يجب ملئ جميع الحقول"));
}
}
?>
		 </form>