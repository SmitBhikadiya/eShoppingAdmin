<?php
require_once("dbHandler.php");

class CustomerHandler extends DBConnection
{
    function updatePasswordByOTP($otp, $email, $newpassword, $repassword){
        $error = '';
        $hashPassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$hashPassword', modifiedDate=now() WHERE email='$email' AND otp='$otp' AND status=0";
        if($newpassword == $repassword){
            $res = $this->getConnection() ->query($sql);
            if(!$res){
                $error = "Somthing went wrong: ".$this->getConnection()->error;
            }
        }else{
            $error = "Password and repassword is not matched!!";
        }
        return $error;
    }

    function verifyOTP($otp, $email){
        $userData = $this->getUserByEmailAndOTP($otp, $email);
        $error = '';
        if(count($userData) > 0){
            $current = date('Y-m-d H:i:s');
            $expiry = date($userData[0]['otpexpiry']);
            if(strtotime($current) > strtotime($expiry)){
                $error = 'OTP has been expired!!!';
            }
        }else{
            $error = 'Entered OTP Is Invalid!!';
        }
        return ['error'=>$error, 'user'=>$userData];
    }

    function getUserByEmailAndOTP($otp, $email)
    {
        $records = [];
        $sql = "SELECT * FROM users WHERE otp='$otp' AND email='$email' AND status=0";
        $res = $this->getConnection()->query($sql);
        if($res && $res->num_rows > 0){
            array_push($records, $res->fetch_assoc());
        }
        return $records;
    }

    function updateUserOTP($email, $otp){
        $error = '';
        $expiry = '';
        if($this->isEmailExits($email)){
            $expiry = date('Y-m-d H:i:s', strtotime("+15 min"));
            $sql = "UPDATE users SET otp='$otp', otpexpiry='$expiry' WHERE email='$email' AND status=0";
            $res = $this->getConnection()->query($sql);
            if(!$res){
                $error = "Something went wrong with the sql!!";
            }
        }else{
            $error = "Invalid Email!!";
        }
        return ['error'=>$error, 'expiry'=>$expiry];
    }

    function isEmailExits($email){
        $sql = "SELECT * FROM users WHERE email='$email'";
        $res = $this->getConnection()->query($sql);
        if($res && $res->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function checkUserCred($userId, $oldpassword){
        $error = '';
        $sql = "SELECT password FROM users WHERE id=$userId";
        $res = $this->getConnection()->query($sql);
        if($res && $res->num_rows > 0){
            $user = $res->fetch_assoc();
            if(!password_verify($oldpassword, $user['password'])){
                $error = 'Invalid Old Password';
            }
        }else{
            $error = 'Something went Wrong';
        }
        return $error;
    }

    function changePassword($userId, $newpassword){
        $error = '';
        $hashPassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$hashPassword', modifiedDate=now() WHERE id=$userId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = 'Something went wrong with the $sql';
        }
        return $error;
    }

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

    function TotalUserAddress($search = '', $sortBy="all")
    {
        $sort = '(0,1)';
        switch($sortBy){
            case "billing":
                $sort = '(0)';
                break;
            case "shipping":
                $sort = '(1)';
                break;
        }
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM useraddress JOIN users ON users.id=useraddress.userId JOIN cities ON cities.id=useraddress.cityId JOIN countries ON countries.id=useraddress.countryId JOIN states ON states.id=useraddress.stateId WHERE $search_ AND useraddress.addressType IN $sort AND useraddress.status=0 ORDER BY useraddress.id DESC";
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

    function getUserDetailesByUsername($username){
        $user = $this->getUserByUsername($username);
        return ["user"=>$user, "billing"=>$this->getAddressByType($user["id"], 0), "shipping"=>$this->getAddressByType($user["id"], 1)];
    }

    function getAddressByType($id, $type){
        $records = [];
        $sql = "SELECT useraddress.*, cities.city as cityName, states.state as stateName, countries.country as countryName FROM useraddress JOIN cities ON cities.id=useraddress.cityId JOIN states ON states.id=useraddress.stateId JOIN countries ON countries.id=useraddress.countryId WHERE useraddress.userId=$id AND useraddress.addressType=$type AND cities.status=0 AND states.status=0 AND countries.status=0 AND useraddress.status = 0";
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

    function getUserAddress($search, $page, $show, $sortBy="all")
    {
        $sort = '(0,1)';
        switch($sortBy){
            case "billing":
                $sort = '(0)';
                break;
            case "shipping":
                $sort = '(1)';
                break;
        }
        $search_ = ($search == '') ? 1 : "users.username LIKE '%" . $search . "%'";
        $sql = "SELECT useraddress.*, users.username, cities.city, states.state, countries.country FROM useraddress JOIN users ON users.id=useraddress.userId JOIN cities ON cities.id=useraddress.cityId JOIN countries ON countries.id=useraddress.countryId JOIN states ON states.id=useraddress.stateId WHERE $search_ AND useraddress.addressType IN $sort AND useraddress.status=0 ORDER BY useraddress.id DESC LIMIT $page, $show";
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

    function deleteUserAddress($id){
        $sql = "UPDATE useraddress SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function updateUser($id, $username, $firstname, $lastname, $gender, $mobile, $phone, $email){
        $error = '';
        $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname', email='$email', gender=$gender, mobile='$mobile', phone='$phone', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if(!$result){
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function updateAddress($userid, $type, $street, $country, $state, $city){
        $error = '';
        
        if(count($this->getAddressByType($userid, $type)) > 0){
            $sql = "UPDATE useraddress SET streetname='$street', cityId=$city, stateId=$state, countryId=$country, modifiedDate=now() WHERE userId=$userid AND addressType=$type";
            $result = $this->getConnection()->query($sql);
            if(!$result){
                $error = "Somthing went wrong with the $sql";
            }
        }else{
            $error = $this->addAddress($userid, $type, $street, $country, $state, $city);
        }
        return $error;
    }

    function addAddress($userid, $type, $street, $country, $state, $city){
        $error = '';
        $sql = "INSERT INTO useraddress (userId, addressType, streetname, cityId, stateId, countryId, createdDate) VALUES ($userid, $type, '$street', $city, $state, $country, now())";
        $result = $this->getConnection()->query($sql);
        if(!$result){
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }
}
