<?php
set_time_limit(9000);
// Get our helper functions
require_once("validate_url.php");
require_once("validate_order.php");
require_once("export_app_call.php");
require_once("db_connect.php");


$get_lastOrder_query = "SELECT StoreName, LastOrderExported, Token  FROM store";
$query_result = $conn->query($get_lastOrder_query);
$order_list=array();

if ($query_result->num_rows > 0) {
    while($row = $query_result->fetch_assoc()) {
				  $order_list=array_merge($order_list,export_orders($row["StoreName"],$row["Token"],$row["LastOrderExported"]));
          if($order_list!=NULL){
            $last_order = $order_list[(sizeof($order_list)-1)]['id'];
            $save_last_order_query = "UPDATE store SET LastOrderExported = $last_order WHERE StoreName ="."'".$row["StoreName"]."'";
            if (mysqli_query($conn, $save_last_order_query)){}
              else{
                  echo "Error updating record: " . mysqli_error($conn)."<br>";
                }
            }
    }
}



/*

$query = "SELECT *
FROM customer,lineitems, product, store, batch
WHERE customer.OrderID = lineitems.OrderID AND product.Sku = lineitems.Sku AND customer.StoreName=store.StoreName AND lineitems.BatchID = batch.BatchID";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["OrderNumber"]." ".$row["CustName"]." ".$row["Sku"]." ".$row["Qty"]." ".$row["ProductName"]."<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
*/
echo '<script>console.log('.json_encode($order_list).')</script>';
?>
