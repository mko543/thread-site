<?php
class routing {
	public static $validrouting;
	public $l = true;
	public static function set($route,$function){
		self::$validrouting[] = array($route,$function);
}
public static function get($route){
	for($i=0; $i != sizeof(self::$validrouting);$i++){
		if(self::$validrouting[$i][0] == $route){
			$route = self::$validrouting[$i];
			$route[1]->__invoke();
			$l = true;
		break;
		}else{
			$l = false;
		}
	}
	if($l == false){
		echo ("no page found");
	}
}
}
?>