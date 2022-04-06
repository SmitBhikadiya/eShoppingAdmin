<?php
    class DBConnection{
        private $hostname = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "eshopping";
        private $conn;

        function __construct(){
            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
            if($this->conn->connect_error){
                die("Connection Failed: ".$this->conn->connect_error);
            }
        }

        function getConnection(){
            return $this->conn;
        }
    }
