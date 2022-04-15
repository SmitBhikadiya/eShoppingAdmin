<?php
require_once("dbHandler.php");
class OrderHandler extends DBConnection
{
    function getAllOrders($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $page, $show";
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
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $limit";
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
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 AND orders.orderStatus=0 ORDER BY orders.id DESC LIMIT $page, $show";
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
        $sql = "SELECT orders.*, users.username, oa.streetName, cities.city, states.state, countries.country FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.orderStatus IN (1,2) AND orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC LIMIT $page, $show";
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

    function getOrderById($id)
    {
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
        $sql = "SELECT COUNT(*) AS total FROM orders JOIN users ON users.id=orders.userId JOIN orderaddress as oa ON oa.orderId=orders.id JOIN cities ON oa.cityId=cities.id JOIN states ON oa.stateId=states.id JOIN countries ON countries.id=oa.countryId WHERE $search_ AND orders.orderStatus IN (1,2) AND orders.status=0 AND users.status=0 AND oa.status=0 AND cities.status=0 AND states.status=0 AND countries.status=0 ORDER BY orders.id DESC";
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
