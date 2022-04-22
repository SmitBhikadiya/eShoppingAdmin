<?php
require_once("dbHandler.php");

class CustomerHandler extends DBConnection
{

    function TotalCustomers($search = '')
    {
        $search_ = ($search == '') ? 1 : "username LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM users WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function userLogin($username, $password){
        $sql = "SELECT * FROM users WHERE username='$username' AND status=0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if($result && $result->num_rows>0){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row["password"])){
                array_push($records, $row);
            }
        }
        return $records;
    }

    function userRegister($username, $password, $firstname, $lastname, $gender, $mobile, $phone, $email){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, firstname, lastname, gender, mobile, phone, createdDate) VALUES ('$username', '$email', '$password', '$firstname', '$lastname', $gender, '$mobile', '$phone', now())";
        $result = $this->getConnection()->query($sql);
        if($result){
            return [
                    'id' => mysqli_insert_id($this->getConnection()),
                    'username' => $username,
                    'error' => ''
            ];
        }
        return [
            'error' => ''
        ];
    }

    function getUserByEmail($email){
        $records = [];
        $sql = "SELECT * FROM users WHERE email='$email' AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records; 
    }
    function getUserByUsername($username){
        $records = [];
        $sql = "SELECT * FROM users WHERE username='$username' AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getCustomers($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "username LIKE '%" . $search . "%'";
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

    function getCustomerById($id)
    {
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

    function deleteCustomer($id)
    {
        $sql = "UPDATE users SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
