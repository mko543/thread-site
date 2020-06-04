<!-- تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)-->
<?php
if(!empty($_SESSION['user']) && !empty($_SESSION['ID'])){
?>
<script>
$(".nav-link").attr("class","nav-link linker");
$("#cth").attr("class","nav-link linker active");
</script>
<form action="" id="createTh" method="post" class="multi container p-5 my-lg-5 text-right rounded-lg">
<label for="thread-tit">العنوان :</label>
<input id="thread-tit" class="form-control" type="text" name="thread-tit"><br>
<div class="form-group">
    <label for="thread-body">الموضوع :</label>
    <textarea id="thread-body" class="form-control" name="thread-body" rows="15"></textarea>
</div>
<button style="width : 150px;" type="submit" name="Cthread" value="reg" class="btn btn-dark">تــأكـــيد</button>
<?php
// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
echo($_SESSION["postToken"]);
    if(controller::checkPost() == 1){
    $tit = $_POST['thread-tit'];
    $thbody = $_POST['thread-body'];
    $date = date("Y-m-d H:i:s");
    $id = $_SESSION['ID'];

    if(controller::regexBan(array($thbody)) == true && controller::regexArEG(array($tit)) == true){
    if(strlen($thbody) < 50000  && strlen($thbody) > 10){
    $res = controller::Register("tit,thread,date,user_id","('$tit','$thbody','$date','$id')","thread");
    echo($res);
    }else{
        echo(controller::errormsg("لا يمكن ادخال اكثر من 50 الف حرف ولا اقل من 10 احرف"));
    }
    }else{
        echo(controller::errormsg("لا يمكنك ادخال اي رموز او احرف غريبه"));
    }
    echo("</form>");
    }
}
?>