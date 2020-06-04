<?php
// تم انشاء هذه الصفحات بواسطة mostafa mahmoud (mko)
routing::set("register",function (){
	controller::CreateView("createAccount");
});
routing::set("createThread",function (){
	controller::CreateView("createThread");
});
routing::set("Mko23login",function (){
	controller::CreateView("login");
});
routing::set("home",function(){
	controller::CreateView("showThreads");
});
routing::set("showThread",function(){
	controller::CreateView("thread");
});
routing::set("install",function(){
	controller::CreateView("setup");
});
?>