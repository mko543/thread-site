<?php
// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
require_once("config.php");
class controller {
	public static function checkPost(){
		$myPost = array_values($_POST);
		$l = 0;
	for($i=0; sizeof($myPost) != $i ;$i++){
		if(!empty($myPost[$i])){
			$l = 1;
		}else{
			$l = 0;
		break;
		}
	}
	return $l;
	}
	public static function CreateView($ViewName){
		include("./view/".$ViewName.".php");
	}
	private static function print_var_name($var) {
		foreach($GLOBALS as $var_name => $value) {
			if ($value === $var) {
				return $var_name;
			}
		}
	
		return false;
	}
	public static function errormsg($msg){
		return "<p id='res' class='p-3 text-danger text-sm-center font-weight-bolder'>".$msg."</p>";

	}
	public static function alert($msg){
		return "<script>alert(".$msg.")</script>";

	}
	public static function regexEG($mkmk=array()){
		for($i=0;$i != sizeof($mkmk); $i++){
		if(!preg_match("/^[a-zA-Z0-9-@._-]{4,50}$/",$mkmk[$i])){
			return false;
			break;
		}else{
			return true;
		}
		}
	}
	public static function regexArEG($mkmk=array()){
		for($i=0;$i != sizeof($mkmk); $i++){
		if(!preg_match("/^[\p{Arabic}a-zA-Z0-9-@._ -]{2,50}+$/u",$mkmk[$i])){
			return false;
			break;
		}else{
			return true;
		}
	    }
	}
	// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
	public static function regexBan($mkmk=array()){
		for($i=0;$i != sizeof($mkmk); $i++){
		if(!preg_match("/([\"\$#\*']+)/",$mkmk[$i])){
			return true;
		}else{
			return false;
		break;
		}
	    }
	}
	public static function update($cloumCH,$searchBy,$newval,$cloum,$Tablename){
		$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
		$q = $con->prepare("update $Tablename set $cloumCH = '$newval' where $cloum = '$searchBy'");
		if($q->execute()){
			return true;
		}else{
			return $q->errorInfo();
		}
	}
	public static function deleteTR($cloum,$val,$Tablename,$imgFile){
		$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
		$q = $con->prepare("delete from $Tablename WHERE $cloum = $val");
		if($q->execute() && unlink($imgFile)){
			
			return true;
		}else{
			return $q->errorInfo();
		}
	}
	public static function login($username,$password,$Tablename){
		$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
		$q = $con->prepare("select * from $Tablename where username = '$username' and password = '$password'");
		if(self::regexEG(array($username,$password)) != true ){
			return self::errormsg("لا يجب ان يحتوى اي من الحقول على احرف غير مسموح بها ويجب ان يكون الحقل اكثر من 4 حروف");
		}else{
			$q->execute();
			if ($q->rowCount() == 0){
				return self::errormsg("اسم المستخدم او كلمة المرور خطاء");
			}else{
				$value = $q->fetch();
			return $value;
			}
		}
		return "nothing";
	}
	public static function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}	
	public static function Register($cloumName,$value,$Tablename){
		$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
		
			$q = $con->prepare("INSERT INTO `$Tablename` ($cloumName) VALUES $value");
			if($q->execute()){
				return "<p id='res' class='p-3 text-success text-sm-center font-weight-bolder'>تم التسجيل بنجاح</p>";
			}else{
				//return self::errormsg("حدث خطاء بالتسجيل او انك قد ادخلت هذه البيانات مسبقاً");
				return $q->errorInfo();
			}
	}
	
	public static function selectAll($cloumName,$Tablename,$query = "kk"){
		$ff= array();
		$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
		if($query == "kk"){
		$q = $con->prepare("select $cloumName from $Tablename");
		$q->execute();
		while($ss = $q->fetch()){
			$ff[] = $ss;
		}
	}else{
		$q = $con->prepare("select $cloumName from $Tablename $query");
		$q->execute();
		while($ss = $q->fetch()){
			$ff[] = $ss;
		}
	}
		return $ff;
	}
	public static function uploadimg($filevar,$location,$filename){
		$oldname = $_FILES[$filevar]['name'];
		$tempext = explode(".",$oldname);
		$uploadok = 1;
		$imgext = array("jpeg","jpg","png","gif");
		if(!in_array(strtolower(end($tempext)), $imgext)){
			$uploadok = 0;
		}
		if($uploadok == 0){
			return 1;
		}else{
			$Newfilename = $filename.".".end($tempext);
			$look = $location."/".$Newfilename;
			if(move_uploaded_file($_FILES[$filevar]['tmp_name'],$look)){
				return $look;
			}else{
				return 1;
			}
		}
	}

}
?>