<?php
set_time_limit(9000);
require_once("validate_url.php");
require_once("db_connect.php");


function export_order($shop,$token,$last_order_exported){
  global $conn;
  $query = array(
    "Content-type" => "application/json" // Tell Shopify that we're expecting an array response in JSON format
  );

    $orders_on_store=array();
    do{
      $order_batch=array();//array that will hold order batch results
      $endpoint="/admin/orders.json?since_id=".$last_order_exported."&status=any&limit=250";
      $orders = shopify_call($token, $shop, $endpoint, array(), 'GET');
      $orders = json_decode($orders['response'], TRUE);
      $order_batch=$orders['orders'];
      if(sizeof($order_batch)!=0){
        $orders_on_store=array_merge($orders_on_store,$order_batch);
        $last_order_exported=$order_batch[(sizeof($order_batch)-1)]['id'];
      }else{
        break;
      }
    }while(sizeof($order_batch!=0));

    //echo $last_order_exported.'<br>';
/* //saves last order number on database
    $save_last_order_query = "UPDATE store SET LastOrderExported = $last_order_exported WHERE StoreName ="."'".$shop."'";
    $query_result = $conn->query($save_last_order_query);
    if (mysqli_query($conn, $save_last_order_query)){}
      else{
          echo "Error updating last order: " . mysqli_error($conn)."<br>";
        }
*/

    for($i=0;$i<sizeof($orders_on_store);$i++){
      $orders_on_store[$i]['store']=$shop;
    }
    return $orders_on_store;
}

function in_multiarray($line_item_id, $status_array)
{
    while (current($status_array) !== false) {
        if (current($status_array) == $line_item_id) {
            return true;
        } elseif (is_array(current($status_array))) {
            if (in_multiarray($line_item_id, current($status_array))) {
                return true;
            }
        }
        next($status_array);
    }
    return false;
}


function check_status($line_item_id, $status_array) {
     if(in_array($line_item_id, $status_array)) {
          return "true";
     }
     foreach($status_array as $element) {
          if(is_array($element) && check_status($line_item_id, $element))
               return "true";
     }
   return "false";
}


//main
$get_lastOrder_query = "SELECT StoreName, LastOrderExported, Token  FROM store";
$query_result = $conn->query($get_lastOrder_query);
$order_test=array();

if ($query_result->num_rows > 0) {
  while($row = $query_result->fetch_assoc()) {
    $order_test=array_merge($order_test,export_order($row["StoreName"],$row["Token"],$row["LastOrderExported"]));
  }
}


for($i=0;$i<sizeof($order_test);$i++){
  for($ii=0;$ii<sizeof($order_test[$i]['line_items']);$ii++){
    $OrderID=$order_test[$i]['id'];
    $orderLineID=$order_test[$i]['line_items'][$ii]['id'];
    $qty=$order_test[$i]['line_items'][$ii]['quantity'];
    $sku=$order_test[$i]['line_items'][$ii]['sku'];
    $lineStatus = "Unfulfilled";

    if(sizeof($order_test[$i]['fulfillments'])!=0){
        if(in_multiarray($order_test[$i]['line_items'][$ii]['id'],$order_test[$i]['fulfillments'])==true){
          $lineStatus="fulfilled";
        }
      }

/*
    $save_orders_query = "INSERT INTO lineitems (OrderID, OrderLineID, Qty, Sku, FulfillmentStatus, BatchID, Mark)
    VALUES ($OrderID,$orderLineID,$qty,'$sku','$fulfillmentStatus','$batchID','$mark')";
    if (mysqli_query($conn, $save_orders_query)) {}
      else {
      echo "Error: " . $save_orders_query . "<br>" . mysqli_error($conn);
      }
*/

      echo $order_test[$i]['order_number'] ." ".$order_test[$i]['line_items'][$ii]['name'] ." ". $order_test[$i]['store'] . " ". $lineStatus. "<br>";
  }


}




  echo '<script>console.log('.json_encode($order_test).')</script>';
  //echo sizeof($order_test);
?>
