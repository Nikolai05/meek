<?php
require_once('validate_url.php');
require_once('status_check.php');



$query = array(
  "Content-type" => "application/json" // Tell Shopify that we're expecting an array response in JSON format
);
$token='dec9d5a17c8bcbb34512d30400ef9f9d';
$shop = 'mymobile-gear';
$endpoint="/admin/orders/5733893652.json";
$orders = shopify_call($token, $shop, $endpoint, array(), 'GET');
$orders = json_decode($orders['response'], TRUE);
$orders = $orders['order'];

for($y=0;$y<sizeof($orders['line_items']);$y++){
  $lineStatus='unfulfilled';

  if($orders['fulfillments']!=NULL){
    if(fulfilled_item_check($orders['line_items'][$y]['id'],$orders['fulfillments'])==true){
      $lineStatus='fulfilled';
    }
  }

  if($orders['refunds']!=NULL){
    if(refunded_item_check($orders['line_items'][$y]['id'],$orders['refunds'])==true || $orders['financial_status']=='refunded'){
      $lineStatus='canceled';
    }
  }


    echo $orders['order_number'] ." ".$orders['line_items'][$y]['name']." ".$orders['line_items'][$y]['id'] ." ". $shop . " ". $lineStatus ."<br>";
}

  echo '<script>console.log('.json_encode($orders).')</script>';

?>
