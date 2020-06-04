<?php
if(controller::checkPost() == 1){
$res = controller::login($_POST['user'],md5("mkmk".$_POST['pass']),"accounts");
if (is_array($res)==0){
    echo("<res>".$res."</res>");
}else{
    $date = date("Y-m-d H:i:s");
    controller::update("login_date",$res['ID'],$date,"ID","accounts");
    $ip = controller::getUserIpAddr();
    controller::update("last_ip",$res['ID'],$ip,"ID","accounts");
    $_SESSION['ID'] = $res['ID'];
    $_SESSION['user'] = $res['username'];
    $_SESSION['name'] = $res['showname'];
    $_SESSION['img'] = $res['image'];
    echo('<res>1</res>');
}
}else{
    echo("<res>لا يجب ترك اي حقول فارغه</res>");
}
?>