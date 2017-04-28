<?php

// Get our helper functions
require_once("functions/validate_url.php");

// Set variables for our request
$shop = "mymobile-gear";
$token = "dec9d5a17c8bcbb34512d30400ef9f9d";
$query = array(
	"Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);

// Run API call to get orders
$orders = shopify_call($token, $shop, "/admin/orders.json?limit=250", array(), 'GET');
// Convert order JSON information into an array
$orders = json_decode($orders['response'], TRUE);

$orders2 = shopify_call($token, $shop, "/admin/orders.json?page=2&limit=250", array(), 'GET');
// Convert order JSON information into an array
$orders2 = json_decode($orders2['response'], TRUE);

$final = array_merge($orders['orders'],$orders2['orders']);

echo '<script>console.log('.json_encode($final).')</script>';

for($count=0;$count<sizeof($final);$count++){
	echo json_encode($final[$count]['order_number'])."  ".json_encode($final[$count]['shipping_address']['name']).'<br>';
}

/*
for ($order_counter=0;$order_counter<=sizeof($final);$order_counter++){
	$order_line_qty=sizeof($final[$order_counter]['line_items']);
	for($order_line_count=0;$order_line_count<$order_line_qty;$order_line_count++){
		$order_id=$final[$order_counter]['number'];
		$order_qty=$final[$order_counter]['line_items'][$order_line_count]['quantity'];
		$order_sku=$final[$order_counter]['line_items'][$order_line_count]['sku'];
		$order_name=$final[$order_counter]['shipping_address']['name'];
		$order_country=$final[$order_counter]['shipping_address']['country'];
		$order_address1=$final[$order_counter]['shipping_address']['address1'];
		$order_address2=$final[$order_counter]['shipping_address']['address2'];
		$order_city=$final[$order_counter]['shipping_address']['city'];
		$order_province=$final[$order_counter]['shipping_address']['province'];
		$order_zip=$final[$order_counter]['shipping_address']['zip'];
		$order_phone=$final[$order_counter]['shipping_address']['phone'];
		$order_item=$final[$order_counter]['line_items'][$order_line_count]['name'];
		echo '<p style="font-family: sans-serif; font-size: 12px;">'.$order_id." ".$order_qty." ".$order_sku." ".$order_name." ".$order_country." ".$order_address1." ".$order_address2." ".$order_city." ".$order_province." ".$order_zip." ".$order_phone." ".$order_item.'</p>';
	}
}
*/
?>
