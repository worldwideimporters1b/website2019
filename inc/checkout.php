<?php

function pay($amount, $orderid, $customerid ){

    $paymentresult = 0;

    // render ideal stuff on website in iframe

    $idealresult = renderIdeal($amount,$shopid,$orderid);

    // check payment

    if($idealresult == 0){
        $paymentresult; = 0;
    }
    if($idealresult == 1){
        $paymentresult = 1;
    }

    // return payment results

    return $paymentresult;

}



renderIdeal($amount,$shopid,$orderid){
$idealresult = 0;
}
// do something

return $idealresult;
}

if($idealresult == 0){
    $paymentresult = 0;
}
if($idealresult == 1){
    $paymentresult = 1;
}


?>