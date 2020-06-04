<?php
// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
if(file_exists("config.php")){
require_once("config.php");
}
try{
	$con = new PDO("mysql:host=".host.";dbname=".dbname,sqluser,sqlpass);
	$l = true;
	} catch(PDOException $e){
		$l=false;
	}
if($l == false){
?>
<form method="post" id="createAccount" class="multi container p-5 my-lg-5 text-center rounded-lg" enctype="multipart/form-data">
<div class="form-group">
<label for="host" class="text-white float-right">عنوان المستضيف</label>
		 <input class="form-control" placeholder="عنووان المستضيف" type="text" name="host" value="<?php echo host ?>" required>
</div>
<div class="form-group">
<label for="sqlUser" class="text-white float-right">اسم المستخدم لقاعدة البيانات</label>
		 <input class="form-control" placeholder="اسم المستخدم لقاعدة البيانات" type="text" name="sqlUser" value="<?php echo sqluser ?>" required>
</div>
<div class="form-group">
<label for="sqlPass" class="text-white float-right">كلمة مرور قاعدة البيانات</label>
		 <input class="form-control" placeholder="كلمة مرور قاعدة البيانات" type="password" name="sqlPass" value="<?php echo sqlpass ?>" required>
</div>
<div class="form-group">
<label for="db" class="text-white float-right">اسم قاعدة البيانات</label>
		 <input class="form-control" placeholder="اسم قاعدة البيانات" type="text" name="db" value="<?php echo dbname ?>" required>
</div>
<div class="form-group">
<label for="siteName" class="text-white float-right">اسم الموقع</label>
		 <input class="form-control" placeholder="اسم الموقع" type="text" name="siteName" value="<?php echo siteName ?>" required>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-block" name="sendData" value="send">تأكيد</button>
</div>
<?php
if(isset($_POST['sendData']) && controller::checkPost() == 1){
    $host = $_POST['host'];
    $sqluser = $_POST['sqlUser'];
    $sqlpass = $_POST['sqlPass'];
    $dbName = $_POST['db'];
    $sitename = $_POST['siteName'];
    $files = fopen("config.php","w");
    fwrite($files,'<?php
    define("host","'.$host.'");
    define("sqluser","'.$sqluser.'");
    define("sqlpass","'.$sqlpass.'");
    define("dbname","'.$dbName.'");
    define("siteName","'.$sitename.'");
    ?>');
    try{
    $con = new PDO("mysql:host=".host,sqluser,sqlpass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("CREATE DATABASE IF NOT EXISTS `$dbName`");
    $con->query("use `$dbName`");
    $con->query("
    SET NAMES utf8mb4;
    SET FOREIGN_KEY_CHECKS = 0;
    
    -- ----------------------------
    -- Table structure for accounts
    -- ----------------------------
    DROP TABLE IF EXISTS `accounts`;
    CREATE TABLE `accounts`  (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `showname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `register_date` datetime NULL DEFAULT NULL,
      `login_date` datetime NULL DEFAULT NULL,
      `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `reg_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `last_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      PRIMARY KEY (`ID`) USING BTREE,
      UNIQUE INDEX `unique`(`showname`) USING BTREE,
      UNIQUE INDEX `unique2`(`username`) USING BTREE,
      UNIQUE INDEX `unique3`(`email`) USING BTREE
    ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
    -- ----------------------------
    -- Table structure for replays
    -- ----------------------------
    DROP TABLE IF EXISTS `replays`;
    CREATE TABLE `replays`  (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `thread_id` int(11) NULL DEFAULT NULL,
      `replay` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `date` datetime NULL DEFAULT NULL,
      `user_id` int(11) NULL DEFAULT NULL,
      PRIMARY KEY (`ID`) USING BTREE
    ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
    -- ----------------------------
    -- Table structure for thread
    -- ----------------------------
    DROP TABLE IF EXISTS `thread`;
    CREATE TABLE `thread`  (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `tit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `thread` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `date` datetime NULL DEFAULT NULL,
      `user_id` int(11) NULL DEFAULT NULL,
      PRIMARY KEY (`ID`) USING BTREE
    ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
    SET FOREIGN_KEY_CHECKS = 1;");
    }catch(PDOException $e){
        echo(controller::errormsg("لا يمكن الأتصال بالسيرفر نرجو التأكد من البيانات والتأكد من وجود mysql"));
    }
}
}else{
    header("Location:home");
}
?>
</form>