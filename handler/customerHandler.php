<?php
require_once("dbHandler.php");

class CustomerHandler extends DBConnection
{

    function TotalCustomers($search=''){
        $search_ = ($search=='') ? 1 : "username LIKE '%".$search."%'";
        $sql = "SELECT COUNT(*) AS total FROM users WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if($result && $result->num_rows > 0){
            return $result->fetch_assoc()["total"];
        } 
        return 0;
    }

    function getCustomers($search, $page, $show)
    {
        $search_ = ($search=='') ? 1 : "username LIKE '%".$search."%'";
        $sql = "SELECT * FROM users WHERE $search_ AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getCustomerById($id){
        $records = [];
        $custid = (int) $id;
        $sql = "SELECT * FROM users WHERE id=$custid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function deleteCustomer($id){
        $sql = "UPDATE users SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
