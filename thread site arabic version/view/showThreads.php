<!-- تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)-->
<div class="multi container p-5 mr-auto my-lg-5 bg-white text-right rounded-lg">
		 <h1 class="text-center">المواضيع</h1>
<?php
(isset($_GET["page"]) && is_numeric($_GET['page']))? $page = $_GET["page"] : $page=1;
$resut_page = 10;
$from = ($page-1) * $resut_page;
$res = controller::selectAll("thread.tit,thread.date,accounts.showname,thread.ID as mkm,COALESCE((SELECT MAX(date) from replays where thread.ID = replays.thread_id),thread.date)","thread,accounts","where accounts.ID = thread.user_id order by (SELECT GREATEST(COALESCE(MAX(replays.date),0),(select thread.date from thread where thread.ID = mkm)) from replays,thread where thread.ID = replays.thread_id) DESC limit $from,$resut_page");
if(!empty($res[0])){
foreach($res as $kk){
echo("<hr><a href = 'showThread?th=".$kk[3]."'>".$kk[0]."</a>
<span class='float-left'>".date("Y-m-d h:i:s A",strtotime($kk[1]))."</span><br>
<span class='float-left'> اخر مشاركة بتاريخ : ".date("Y-m-d h:i:s A",strtotime($kk[4]))."</span><span>بواسطة :".$kk[2]."</span>");
}
echo("</div>");
$numres =  controller::selectAll("count(ID) as total","thread");
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
}else{
	echo('<hr><h1 class="text-center">لا يوجد اي مواضيع</h1>');
}
?>