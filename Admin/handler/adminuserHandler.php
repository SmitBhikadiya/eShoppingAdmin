<?php
require_once("dbHandler.php");
class AdminUser extends DBConnection
{
    public $error = '';
    function signIn($email, $pass)
    {
        $sql = "SELECT * FROM adminuser WHERE email='$email' AND status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($pass, $user["password"])) {
                if (isset($_POST["remember"])) {
                    $this->setUserCookie($email, $pass);
                } else {
                    $this->unsetUserCookie();
                }
                $_SESSION["adminlogin"] = $user;
            } else {
                $this->error = "Invalid password!!!";
            }
        } else {
            $this->error = "User is not exits!!!";
        }
        return $this->error;
    }

    function getAdminEmails(){
        $emails = [];
        $sql = "SELECT email FROM adminuser WHERE status=0";
        $res = $this->getConnection()->query($sql);
        if($res && $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                array_push($emails, $row['email']);
            }
        }
        return $emails;
    }

    function setUserCookie($email, $pass)
    {
        setcookie('email', $email, time() + 3600, '/');
        setcookie('password', $pass, time() + 3600, '/');
        setcookie('remember', true, time() + 3600, '/');
    }

    function unsetUserCookie()
    {
        setcookie('email', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        setcookie('remember', false, time() - 3600, '/');
    }
}
