<?php
require '../vendor/autoload.php';
require '../handler/productHandler.php';
require '../handler/taxHandler.php';
require '../handler/couponHandler.php';
require '../handler/orderHandler.php';

header('Content-Type: application/json');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
  $taxErrors = [];
  $couponErrors = [];
  $cartErrors = [];
  $errors = [];
  $tax = 0;
  $taxPercentage = 1;
  $discount = 0;
  $session = [];
  $couponStripeId = '';
  $taxStripeId = '';
  $domain = 'http://localhost:4200/cart';
  $request = json_decode($postdata);
  if(isset($request->cartDetailes)){
    $stripe = new \Stripe\StripeClient(
      'sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI'
    );
    if(isset($request->cartDetailes->cartData)){
      $cartData = (array) $request->cartDetailes->cartData;
      $cartErrors = checkItemAvailablity($cartData);
      if(count($errors) < 1){
        if(isset($request->cartDetailes->taxData)){
          $taxData =(array) $request->cartDetailes->taxData;
          $taxErrors = checkTax($taxData);
          if(count($taxErrors) < 1){
            $taxPercentage = $taxData["tax"];
            $taxStripeId = $taxData["stripeId"];
          }
        }else{
          $taxErrors = ["tax"=>"Tax is not applied!!!"];
        }

        if(isset($request->cartDetailes->couponData)){
          $couponData = (array) $request->cartDetailes->couponData;
          $couponErrors = checkCoupon($couponData);
          if(count($couponErrors) < 1){
            $discount = $couponData["discountAmount"];
            $couponStripeId = $couponData["stripeId"];
          }
        }
      }
    }
    if(count($cartErrors) > 0 || count($taxErrors) > 0 || count($taxErrors) > 0){
      $errors = [
        'cartErrors' => $cartErrors,
        'taxErrors' => $taxErrors,
        'taxErrors' => $taxErrors
      ];
    }else if(isset($request->cartDetailes->userId)){
      $userId = $request->cartDetailes->userId;
      $currency = 'INR';
      $subTotal = countSubTotal($cartData);
      $tax = ($subTotal - $discount) * ($taxPercentage/100);
      $total = $subTotal + $tax - $discount;

      $orderH = new OrderHandler();
      $res = $orderH->createOrder($cartData, $userId, $subTotal, $taxStripeId, $couponStripeId, $total, 0, 0);

      if($res['error']==''){
        $orderId = $res["orderId"];
        try{
          $session = getCheckoutSession($stripe, $cartData, $subTotal, $total, $userId, $currency, $domain, $couponStripeId, $taxStripeId, $orderId );
          $err = $orderH->updateOrderSession($orderId, $session['id']);
          // echo json_encode([$session, $err]);
          // exit();
          if($err!=''){
            $errors["orderErrors"] = ["order"=>$err];
          }
        }catch(Exception $e){
          $errors["sessionErrors"] = ["checkout"=>$e->getMessage()];
        }
      }else{
        $errors["orderErrors"] = ["order"=>$res["error"]];
      }
    }else{
      $errors['extraErrors'] = ['userId' => 'User Id not found!!!'];
    }
  }

  echo json_encode(["session"=>$session,"errors"=>$errors]);
  exit();
}

function countSubTotal($cartItems){
  $subTotal = 0;
  $cartItems = (array) $cartItems;
  foreach($cartItems as $item){
    $item = (array) $item;
    $subTotal+=$item["subTotal"];
  }
  return $subTotal;
}

function checkCoupon($couponData){
  $errors = [];
  $couponObj = new CouponHandler();
  $couponData = (array) $couponData;
  $coupon = $couponObj->getCouponById($couponData["id"]);
  if(count($coupon) < 1){
    $errors["coupon"] = "No Coupon Found In Database!!!";
  }else{
    if($couponObj->isCouponExpired($couponData["couponExpiry"])){
      $errors["coupon"] = "Coupon has been expired!!!";
    }else{
      if($couponData["maximumTotalUsage"] <= 0){
        $errors["coupon"] = "No More reedemption available!!!";
      }
    }
  }
  return $errors;
}

function checkTax($taxData){
  $errors = [];
  $taxObj = new TaxHandler();
  $taxData = (array) $taxData;
  $tax = $taxObj->getTaxById($taxData["id"]);
  if(count($tax) < 1){
    $errors["tax"] = "No Tax Found In Database!!!";
  }
  return $errors;
}

function checkItemAvailablity($cartItems){
  $errors = [];
  $proObj = new ProductHandler();
  $cartItems = (array) $cartItems;
  foreach($cartItems as $item){
    $item = (array) $item;
    $prdId = $item["productId"];
    $product = $proObj->getProductById($prdId);
    if(count($product) > 0){
      if($product["totalQuantity"] < $item["quantity"]){
        $errors[$product["productName"]] = $product["productName"]." is out of stock";
      }
    }else{
      $errors[$prdId] ="Product is no more available where PRDID is ".$prdId;
    }
  }
  return $errors;
}

function getLineItems($cartItems, $taxStripeId){
  $arr = [];
  $cartItems = (array) $cartItems;
  foreach($cartItems as $item){
    $item = (array) $item;
    $priceId = $item["priceStripeId"];
    $qty = $item["quantity"];
    array_push($arr, [
      'price' => $priceId,
      'quantity' => $qty,
      'tax_rates' => [$taxStripeId]
    ]);
  }
  return $arr;
}

function getCheckoutSession($stripe, $cartItems, $subTotal, $total, $customerId, $currency, $domain, $couponStripeId, $taxStripeId, $orderId){
  $config = [
    'success_url' => $domain . "/success/" . $orderId,
    'cancel_url' => $domain . "/cancelled/" . $orderId,
    'line_items' => getLineItems($cartItems, $taxStripeId),
    'mode' => 'payment',
    'metadata' => [
      'amount_subtotal' => $subTotal,
      'amount_total' => $total,
      'currency' => $currency,
      'orderId' => $orderId
    ],
    'client_reference_id' => $customerId,
    'mode' => 'payment',
  ];

  if($couponStripeId!=''){
    $config['discounts'] =  [['coupon' => $couponStripeId]];
  }

  return $stripe->checkout->sessions->create($config);
}


?>