<?php
require_once("dbHandler.php");
class OrderHandler extends DBConnection
{
    function getOrders(){
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC";
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

    function getOrderById($id){
        $records = [];
        $ordid = (int) $id;
        $sql = "SELECT orders.*, users.username, users.mobile, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 AND orders.id=$ordid";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getOrderListByOrderId($id){
        $records = [];
        $ordid = (int) $id;
        $sql = "SELECT * FROM orderlist WHERE orderId=$ordid AND status=0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function updateStatus($status, $id){
        $error = "";
        $sql = "UPDATE orders SET orderStatus=$status, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }
}
