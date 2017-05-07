<?php
date_default_timezone_set('Europe/Vienna');
$timezone = date_default_timezone_get();
$date_now = date('Y-m-d H:i', time());
$date_order_created='2017-05-06 07:45';

$seconds = strtotime($date_now) - strtotime($date_order_created);

$days    = floor($seconds / 86400);
$hours   = floor(($seconds - ($days * 86400)) / 3600);

echo $date_now.' '.$days.' day(s) passed'.'<br>';
echo $date_order_created.' '.$hours.' hours(s) passed'.'<br>';
if($hours>12||$days>0){
  echo 'Yes we can';
}else {
  echo 'You cant order these';
}

?>
