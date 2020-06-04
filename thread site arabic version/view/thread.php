<?php
if(is_numeric($_REQUEST["th"])){
$th = $_REQUEST["th"];
$res = controller::selectAll("thread.tit,thread.date,accounts.showname,accounts.image,thread.thread,thread.user_id","`thread`,accounts","where accounts.ID = thread.user_id and thread.ID = '$th'");
if(!empty($res[0])){
    foreach($res as $kk){
    }
    echo("<div id='thbo' class='multi container mr-auto my-lg-5 bg-primary text-right rounded-lg'>
        <h5><span>".$kk[0]."</span><span class = 'float-left'>".date("Y-m-d h:i:s A",strtotime($kk[1]))."</span></h5>
        <hr><div id='userblock'>
        <img id='accimg' src='".(($kk[3] == 1) ? "style/noimg.png":$kk[3])."'><br><h5 class='text-center'>".$kk[2]."</h5>
        </div><br><div id='thread'>".nl2br(htmlentities($kk[4])).
        (($kk[5] == $_SESSION['ID'] && (time() - strtotime($kk[1]) < 60*60)) ? "<br><br><button data-toggle='modal' data-target='#editThread' style='position: relative;' type='button' class='float-left btn btn-light'>تعديل</button>":" ")."</div></div>");
        ?>
        <form method="post" class="modal fade" id="editThread">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" style="margin: 0 auto;" id="exampleModalLabel">تعديل الموضوع</h5>
                <button type="button" class="close float-left position-absolute" data-dismiss="modal" aria-label="Close">
                  <span class="float-left position-absolute" aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-right">
              <label for="thread-body">عنوان الموضوع: <?php echo $kk[0] ?></label>
            <textarea id="thread-body" class="form-control" name="editTh" rows="15"><?php echo $kk[4] ?></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلق</button>
                <button type="submit" name = "SETh" value = "SETh" class="btn btn-primary">حفظ</button>
              </div>
            </div>
          </div>
          <?php
          if(isset($_POST['SETh']) && controller::checkPost() == 1){
            if($kk[5] == $_SESSION['ID'] && (time() - strtotime($kk[1]) < 60*60)){
            $Thedited = $_POST['editTh'];
            if(controller::regexBan(array($Thedited)) == true){
            if(strlen($Thedited) < 50000  && strlen($rep) > 10){
            $Thup = controller::update("thread",$th,$Thedited,"ID","thread");
            if($Thup == true){ echo('<meta http-equiv="refresh" content="0">');} else {print_r ($Thup);}
            }else{
                echo(controller::errormsg("لا يمكن ادخال اكثر من 50 الف حرف ولا اقل من 10 احرف"));
            }
            }else{
                echo(controller::errormsg("لا يمكنك ادخال رموز غريبه"));
            }
    
        }
    }
          ?>
        </form>
        <?php
    (isset($_GET["page"]) && is_numeric($_GET['page']))? $page = $_GET["page"] : $page=1;
    $resut_page = 5;
    $from = ($page-1) * $resut_page;
    $repres = controller::selectAll("replays.date,accounts.showname,accounts.image,replays.replay,replays.user_id,replays.ID","replays,accounts","where accounts.ID = replays.user_id and replays.thread_id = '$th' order by replays.date limit $from,$resut_page");
if(!empty($repres[0])){
    foreach($repres as $kk){
        echo("<br><div id='thbo' class='multi container mr-auto my-lg-5 bg-white text-right rounded-lg'>
        <h5><span class = 'float-left'>".date("Y-m-d h:i:s A",strtotime($kk[0]))."</span></h5>
        <br><hr><div id='userblock'>
        <img id='accimg' src='".(($kk[2] == 1) ? "style/noimg.png":$kk[2])."'><br>
        <h5 class='text-center'>".$kk[1]."</h5></div><br><div id='thread'>".nl2br(htmlspecialchars($kk[3])));
        if($kk[4] == $_SESSION['ID']){ 
            ?>
            <br><br><a style='position: relative;' href="?rep=<?php echo $kk[5]; ?>" class='float-left btn btn-primary'>تعديل</a>
            <?php
        }
        echo("</div></div>");
    }
    $numres =  controller::selectAll("count(date) as total","replays","where replays.thread_id = '$th'");
    //echo ("<script>alert('".$numres[0]['total']."')</script>");
    $maxpages = ceil($numres[0]['total']/$resut_page);
    $l = 0;
    $pagesBefore = 5;
    for(($maxpages > 1 && ($page -$pagesBefore) >= 1)? $i = ($page- $pagesBefore) : $i=1; $maxpages > ($i-1); $i++){
        if($l != 10){
            $l++;
        echo("<a id='pagenum' class='page-".$i."' href ='?page=".$i."'>".$i."</a>");
        }
    }
    echo("<br>");
}
if(!empty($_SESSION['user']) && !empty($_SESSION['ID'])){
    ?>
    <form action="" id="createTh" method="post" class="multi container p-5 my-lg-5 text-right rounded-lg">
    <div class="form-group">
        <label for="thread-body">الرد :</label>
        <textarea id="thread-body" class="form-control" name="replay" rows="15"></textarea>
    </div>
    <button style="width : 150px;" type="submit" name="Creplay" value="reg" class="btn btn-dark">تــأكـــيد</button>
    <?php
    if( isset($_POST['Creplay']) && controller::checkPost() == 1){
    $replay = $_POST['replay'];
    $date = date("Y-m-d H:i:s");
    $id = $_SESSION['ID'];
    if(controller::regexBan(array($replay)) == true){
        if(strlen($rep) < 50000  && strlen($rep) > 10){
    $regres = controller::Register("thread_id,replay,date,user_id","('$th','$replay','$date','$id')","replays");
    if($regres == "<p id='res' class='p-3 text-success text-sm-center font-weight-bolder'>تم التسجيل بنجاح</p>"){
        echo('<meta http-equiv="refresh" content="0">');
    }else{
        echo($regres);
    }
}else{
    echo(controller::errormsg("لا يمكن ادخال اكثر من 50 الف حرف ولا اقل من 10 احرف"));
}
    }else{
        echo(controller::errormsg("لا يمكنك ادخال رموز غريبه"));
    }
}
    echo("</form>");

    }
}
}
if(preg_match("/^[0-9]{1,15}$/",$_REQUEST["rep"])){
    if(!empty($_SESSION['ID'])){
        $userID = $_SESSION['ID'];
        $repid =$_REQUEST['rep'];
    $reres = controller::selectAll("replays.replay,replays.ID,thread.tit,replays.thread_id","thread,replays","where replays.user_id = '$userID' and replays.ID = '$repid' and replays.thread_id = thread.ID");
    if(!empty($reres[0])){
    ?>
    <form action="" id="createTh" method="post" class="multi container p-5 my-lg-5 text-right rounded-lg">
<div class="form-group">
<label for="thread-body">الرد على: <?php echo $reres[0]['tit'] ?></label>
<textarea id="thread-body" class="form-control" name="upreply" rows="15"><?php echo $reres[0]['replay'] ?></textarea>
</div>
<button style="width : 150px;" type="submit" name="updreply" value="reg" class="btn btn-dark">تــأكـــيد</button>
    <?php
    // تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
    if(isset($_POST['updreply']) && controller::checkPost() == 1){
        $rep = $_POST['upreply'];
        if(controller::regexBan(array($rep)) == true){
        if(strlen($rep) < 50000 && strlen($rep) > 10){
        $repupdate = controller::update("replay",$repid,$rep,"ID","replays");
        if($repupdate == true){ header("Location:?th=".$reres[0]['thread_id']."");} else {print_r ($repupdate);}
        }else{
            echo(controller::errormsg("لا يمكن ادخال اكثر من 50 الف حرف ولا اقل من 10 احرف"));
        }
        }else{
            echo(controller::errormsg("لا يمكنك ادخال رموز غريبه"));
        }

    }
}
}
}
?>
</form>