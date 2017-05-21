<?php
//validate if the current order is made passed 12 hours
function validate_order($date_param){
	date_default_timezone_set('Europe/Vienna');
	$timezone = date_default_timezone_get();
	$date_now = date('Y-m-d H:i', time());
	$date_order_created='';
	$date_order_created=substr($date_param,0,10);
	$time_order_created=substr($date_param,11,5);
	$date_order_created=$date_order_created.' '.$time_order_created;
	$seconds = strtotime($date_now) - strtotime($date_order_created);
	$days    = floor($seconds / 86400);
	$hours   = floor(($seconds - ($days * 86400)) / 3600);
	if($hours>12||$days>0){
		return true;
	}else{
		return false;
	}
}

?>
