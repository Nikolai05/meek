<?php
set_time_limit(300);
// Get our helper functions
require_once("validate_url.php");

// Set variables for our request
$shop = "mymobile-gear";
$token = "dec9d5a17c8bcbb34512d30400ef9f9d";
$query = array(
	"Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);


$order_list=array();
$last_order_exported=5552065044;
$end_yet=1;
while($end_yet<=3){
	$endpoint="/admin/orders.json?since_id=".$last_order_exported."&status=any&limit=250";
	$orders = shopify_call($token, $shop, $endpoint, array(), 'GET');
	$orders = json_decode($orders['response'], TRUE);
	$order_batch = $orders['orders'];
	$order_list=array_merge($order_list,$order_batch);
	echo '<script>console.log('.json_encode($order_list).')</script>';
	//echo $last_order_exported.'<br>';
	$last_order_exported=$order_list[(sizeof($order_list)-1)]['id'];
	$end_yet++;
}

for($x=0;$x<sizeof($order_list);$x++){
	echo $order_list[$x]['order_number']." ".$order_list[$x]['shipping_address']['name'].'<br>';
}
echo $last_order_exported;

?>
