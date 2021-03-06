<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
class DBConnection
{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eshopping";
    private $conn;
    function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }
    }
    function getConnection()
    {
        return $this->conn;
    }
}
