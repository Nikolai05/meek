<?php
function fulfilled_item_check($line_item_id, $fulfillments_array)
{
    for($i=0;$i<sizeof($fulfillments_array);$i++){
      for($ii=0;$ii<sizeof($fulfillments_array[$i]['line_items']);$ii++){
        if(in_array($line_item_id,$fulfillments_array[$i]['line_items'][$ii],true)==true){
          return true;
        }
      }
    }
}


function refunded_item_check($line_item_id, $refund_array)
{
    for($i=0;$i<sizeof($refund_array);$i++){
      for($ii=0;$ii<sizeof($refund_array[$i]['refund_line_items']);$ii++){
        if(in_array($line_item_id,$refund_array[$i]['refund_line_items'][$ii],true)==true){
          return true;
        }
      }
    }
}
?>
