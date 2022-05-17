<?php
require_once("dbHandler.php");
class OrderHandler extends DBConnection
{


    function updateOrderSession($orderId, $session){
        $error = '';
        $sql = "UPDATE orders SET checkoutId='$session' WHERE id=$orderId";
        $res = $this->getConnection()->query($sql);
        if(!$res){
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function createOrder($orderList, $userId, $subTotal, $taxId, $couponId, $total, $payment=0, $orderStatus=0){
        $error = ""; 
        $orderId = 0;
        $this->getConnection()->autocommit(false);
        $sql = "INSERT INTO orders (userId, taxStripeId, couponStripeId, subTotal, total, payment, orderStatus, createdDate) VALUES ($userId, '$taxId', '$couponId', $subTotal, $total, $payment, $orderStatus, now())";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }else{
            $orderId = $this->getConnection()->insert_id;
            if($this->setOrderAddressBy($userId, $orderId, 0)=='' && $this->setOrderAddressBy($userId, $orderId, 1)==''){
                foreach($orderList as $list){
                    $list = (array)$list;
                    $error = $this->createOrderList($orderId, $list["productId"], $list["productStripeId"], $list["productName"], $list["productImage"], $list["size"], $list["colorName"], $list["colorCode"], $list["productPrice"], $list["quantity"], $list["subTotal"]);
                    if($error!=''){
                        break;
                    }
                }
            }else{
                $error = "Somthing went wrong while set adddress!!!";
            }
        }
        if($error == ''){
            if(!$this->getConnection()->commit()){
                $error = "Somthing went wrong with the sql!!!";
            }
        }
        $this->getConnection()->autocommit(true);
        return ["error"=>$error, "orderId"=>$orderId];
    }

    function setOrderAddressBy($userId, $orderId, $addType){
        $error = "";
        $sql = "INSERT INTO orderaddress (orderId, addressType, streetName, cityId, countryId, stateId, createdDate) SELECT $orderId, addressType, streetname, cityId, countryId, stateId, now() FROM useraddress WHERE userId=$userId AND addressType=$addType";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function createOrderList($orderId, $productId, $productStripeId, $productName, $productImage, $productSize, $productColor, $productColorCode, $unitPrice, $quantity, $subTotal){
        $error = "";
        $sql = "INSERT INTO orderlist (orderId, productId, productStripeId, productName, productImage, productSize, productColor, productColorCode, unitPrice, quantity, subTotal, createdDate) VALUES ($orderId, $productId, '$productStripeId', '$productName', '$productImage' , '$productSize', '$productColor', '$productColorCode', $unitPrice, $quantity, $subTotal, now())";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function removeDataFromCart($userId){
        $error = '';
        $sql = "DELETE FROM cart WHERE userId=$userId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function getAllOrdersBy($userId){
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country, servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.userId=$userId AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getAllOrders($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country,servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getRecentOrders($limit)
    {
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country, servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $limit";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getPendingOrders($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country, servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 AND orders.orderStatus=0 ORDER BY orders.id DESC LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getOrdersHistoryBy($userId){
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country, servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.userId=$userId AND orders.orderStatus IN (1,2) AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getOrdersHistory($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country, servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.orderStatus IN (1,2) AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function setOrderPayment($userId, $ordId, $couponData){
        $error = "";
        $sql = "UPDATE orders SET payment=1, modifiedDate=now() WHERE id=$ordId AND userId=$userId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }else{
            $cartItems = $this->getCartItems($userId);
            if(count($cartItems) < 1){
                $error = "Cart Items not found!!!";
            }else{
                $error = $this->updateAllProductAfterOrdered($cartItems);
                if($error=='' && $couponData!=''){
                    $error = $this->updateCouponData($couponData);
                }
            }
        }
        return $error;
    }

    function getCartItems($userId)
    {
        $sql = "SELECT cart.*, productcolor.colorName, productcolor.colorCode, products.productColorIds, products.productSizeIds, products.stripeId AS productStripeId, products.stripePriceId AS priceStripeId, products.productPrice, products.totalQuantity, productsize.size, products.totalQuantity FROM cart JOIN productcolor ON productcolor.id=cart.productColorId JOIN productsize ON productsize.id = cart.productSizeId JOIN products ON products.id = cart.productId WHERE cart.userId=$userId AND cart.status=0 ORDER BY cart.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function updateCouponData($couponData){
        $error = '';
        $couponData = (array) $couponData;
        $couponId = $couponData['id'];
        $sql = "UPDATE coupons SET maximumTotalUsage = maximumTotalUsage - 1 WHERE maximumTotalUsage >= 1 AND id=$couponId";
        $res = $this->getConnection()->query($sql);
        if(!$res){
            $error = 'Somthing went wrong with the $sql';
        }
        return $error;
    }

    function updateAllProductAfterOrdered($cartItems){
        $error = '';
        $this->getConnection()->autocommit(false);
        foreach($cartItems as $item){
            $item = (array) $item;
            $qty = $item['quantity'];
            $prdId = $item['productId'];
            $sql = "UPDATE products SET totalQuantity = totalQuantity - $qty WHERE totalQuantity >= $qty AND id=$prdId";
            $res = $this->getConnection()->query($sql);
            if(!$res){
                $error = "Somthing went wrong with the $sql";
                break;
            }
        }
        if(!$this->getConnection()->commit()){
            $error = "Somthing went wrong with the conn";
        }
        $this->getConnection()->autocommit(true);
        return $error;
    }

    function removeOrderIf($userId, $orderId, $ifpayment){
        $error = "";
        $error = $this->removeOrderItemBy($orderId);
        if($error==''){
            $error = $this->removeOrderAddresses($orderId);
            if($error==''){
                $sql = "DELETE FROM orders WHERE id=$orderId AND userId=$userId AND payment=$ifpayment";
                $result = $this->getConnection()->query($sql);
                if (!$result) {
                    $error = "Somthing went wrong with the $sql";
                }
            }
        }
        return $error;
    }

    function removeOrderAddresses($orderId){
        $error = "";
        $sql = "DELETE FROM orderaddress WHERE orderId=$orderId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function removeOrderItemBy($orderId){
        $error = "";
        $sql = "DELETE FROM orderlist WHERE orderId=$orderId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function getOrderById($id)
    {
        $records = [];
        $ordid = (int) $id;
        $sql = "SELECT orders.*, users.username, users.mobile, oa.streetName, cities.city, states.state, countries.country,servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 AND orders.id=$ordid";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getOrderByIds($userId, $ordId)
    {
        $records = [];
        $ordid = (int) $ordId;
        $userId = (int) $userId;
        $sql = "SELECT orders.*, users.username, users.mobile, oa.streetName, cities.city, states.state, countries.country,servicetax.tax , coupons.discountAmount FROM orders JOIN servicetax ON servicetax.stripeId=orders.taxStripeId LEFT JOIN coupons ON coupons.stripeId = orders.couponStripeId JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 AND orders.id=$ordid AND orders.userId=$userId";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getOrderListByOrderId($id)
    {
        $records = [];
        $ordid = (int) $id;
        $sql = "SELECT * FROM orderlist WHERE orderId=$ordid AND status=0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function updateStatus($status, $id)
    {
        $error = "";
        $sql = "UPDATE orders SET orderStatus=$status, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function TotalOrders($search = '')
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT count(*) AS total FROM orders JOIN users ON users.id=orders.userId WHERE $search_ AND orders.status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalOrderHistory($search = '')
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.orderStatus IN (1,2) AND orders.status=0 AND users.status=0 AND oa.status=0 AND oa.addressType=1 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalPending($search = '')
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT count(*) AS total FROM orders JOIN users ON users.id=orders.userId WHERE $search_ AND orders.orderStatus=0 AND orders.status=0 AND users.status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalCompleted($search = '')
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT count(*) AS total FROM orders JOIN users ON users.id=orders.userId WHERE $search_ AND orders.orderStatus=1 AND orders.status=0 AND users.status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }
    
    function TotalCancelled($search = '')
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT count(*) AS total FROM orders JOIN users ON users.id=orders.userId WHERE $search_ AND orders.orderStatus=2 AND orders.status=0 AND users.status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }
}
