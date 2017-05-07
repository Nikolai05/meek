<?php
set_time_limit(3000);
// Get our helper functions
require_once("validate_url.php");
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
//	echo '<br><br>';
//	echo $date_now.' '.$days.' day(s) has passed'.'<br>';
//	echo $date_order_created.' '.$hours.' hours(s) has passed'.'<br>';
	if($hours>12||$days>0){
		return true;
	}else{
		return false;
	}
}


// Set variables for our request
$shop = "mymobile-gear";
$token = "dec9d5a17c8bcbb34512d30400ef9f9d";
$query = array(
	"Content-type" => "application/json" // Tell Shopify that we're expecting an array response in JSON format
);
$order_list=array(); //array that will hold all order results
$last_order_exported=5571251796; //this variable must be saved to database
$order_list=array();
$end_time=true;

do{
	$endpoint="/admin/orders.json?since_id=".$last_order_exported."&status=any&limit=1";
	$orders = shopify_call($token, $shop, $endpoint, array(), 'GET');
	$orders = json_decode($orders['response'], TRUE);
	$end_time=validate_order($orders['orders'][0]['created_at']);

			if($end_time==false){
				break;
			}else{
				$order_list=array_merge($order_list,$orders['orders']);
				$last_order_exported=$order_list[(sizeof($order_list)-1)]['id'];
			}
}while($end_time==true);


for($count=0;$count<(sizeof($order_list));$count++){
	if($order_list[$count]['financial_status']=='refunded'){
		unset($order_list[$count]);
	}
}
$order_list=array_values($order_list);
echo '<br>';

for($count=0;$count<(sizeof($order_list));$count++){
		echo $order_list[$count]['order_number']."     ".$order_list[$count]['shipping_address']['name']." ".$order_list[$count]['financial_status'].'<br>';
}

echo $last_order_exported;
echo '<script>console.log('.json_encode($order_list).')</script>';
?>
