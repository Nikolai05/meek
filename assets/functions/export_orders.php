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
        $orders_on_store=array_merge($order_batch,$orders_on_store);
        $last_order_exported=$order_batch[(sizeof($order_batch)-1)]['id'];
      }else{
        break;
      }
    }while(sizeof($order_batch!=0));

    //echo $last_order_exported.'<br>';

    $save_last_order_query = "UPDATE store SET LastOrderExported = $last_order_exported WHERE StoreName ="."'".$shop."'";
    $query_result = $conn->query($save_last_order_query);
    if (mysqli_query($conn, $save_last_order_query)){}
      else{
          echo "Error updating record: " . mysqli_error($conn)."<br>";
        }

    return $orders_on_store;
}




$get_lastOrder_query = "SELECT StoreName, LastOrderExported, Token  FROM store";
$query_result = $conn->query($get_lastOrder_query);
$order_test=array();

if ($query_result->num_rows > 0) {
  while($row = $query_result->fetch_assoc()) {
    $order_test=array_merge($order_test,export_order($row["StoreName"],$row["Token"],$row["LastOrderExported"]));
  }
}
  echo '<script>console.log('.json_encode($order_test).')</script>';
  echo sizeof($order_test);
?>
