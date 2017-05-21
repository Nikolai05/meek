<?php
set_time_limit(9000);
// Get our helper functions
require_once("validate_url.php");
require_once("validate_order.php");
require_once("export_orders.php");


$order_list=array();
$shop = array("gearforyou","mymobile-gear","kittenlovers","4xhome");
$token = array("739b57687f7506165373e69d787bf054","dec9d5a17c8bcbb34512d30400ef9f9d","bbd49e53be300b236bf4bc6335a04d38","82f8ac6f768448a267e4a5464e4c1876");
$last_order_exported=array(5621089351,5607854356,5593152647,5077732804); //this variable must be saved to database, indicates where should we start exporting


for($arraycount=0;$arraycount<sizeof($shop);$arraycount++){
	$order_list=array_merge($order_list,export_orders($shop[$arraycount],$token[$arraycount],$last_order_exported[$arraycount]));
}

for($counter=0;$counter<(sizeof($order_list));$counter++){
	for($line_item_count=0;$line_item_count<sizeof($order_list[$counter]['line_items']);$line_item_count++){
		echo $order_list[$counter]['order_number']." "
				//.$order_list[$counter]['line_items'][$line_item_count]['quantity']." "
			 //.$order_list[$counter]['line_items'][$line_item_count]['sku']." "
				.$order_list[$counter]['shipping_address']['name']." "
			//.$order_list[$counter]['shipping_address']['country']." "
			//.$order_list[$counter]['shipping_address']['address1']." "
			//.$order_list[$counter]['shipping_address']['address2']." "
			//.$order_list[$counter]['shipping_address']['city']." "
			//.$order_list[$counter]['shipping_address']['province']." "
			//.$order_list[$counter]['shipping_address']['zip']." "
			//.$order_list[$counter]['line_items'][$line_item_count]['title']." "
			//.$order_list[$counter]['line_items'][$line_item_count]['vendor']." "
			//.$order_list[$counter]['shipping_address']['phone']." "
				.$order_list[$counter]['financial_status']." "
				.$order_list[$counter]['fulfillment_status']." "
				.'<br>';
	}
}


echo '<script>console.log('.json_encode($order_list).')</script>';
?>
