<?php
function export_orders($shop,$token,$last_order_exported){
	$query = array(
		"Content-type" => "application/json" // Tell Shopify that we're expecting an array response in JSON format
	);
	$order_batch=array(); //array that will hold all order results
	$end_time=true;

	do{
		$endpoint="/admin/orders.json?since_id=".$last_order_exported."&status=any&limit=1";
		$orders = shopify_call($token, $shop, $endpoint, array(), 'GET');
		$orders = json_decode($orders['response'], TRUE);
		if($orders!=NULL){
			$end_time=validate_order(@$orders['orders'][0]['created_at']);
				if($end_time==false){
					break;
				}else{
						$order_batch=array_merge($order_batch,$orders['orders']);
						$last_order_exported=$order_batch[(sizeof($order_batch)-1)]['id'];
					}
			}else{
				break;
			}
	}while($end_time==true);
	return $order_batch;
}
?>
