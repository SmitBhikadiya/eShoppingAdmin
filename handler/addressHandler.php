<?php
    require_once("dbHandler.php");
    
    class AddressHandler extends DBConnection{
        
        function getCities(){
            $sql = "SELECT cities.*, states.state, countries.country FROM cities JOIN states ON cities.stateId=states.id JOIN countries ON countries.id=cities.countryId ORDER BY cities.id DESC";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getStates(){
            $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getCountries(){
            $sql = "SELECT * FROM countries";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getStatesByCountryId($countryid){
            $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId WHERE states.countryId=$countryid";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }

        function addCity($countryid, $stateid, $city){
            $error = "";
            if(!$this->isCityExits($countryid, $stateid, $city)){
                $sql = "INSERT INTO cities (city, stateId, countryId, createdDate) VALUES ('$city', $stateid, $countryid, now())";
                $result = $this->getConnection()->query($sql);
                if(!$result){
                    $error = "Somthing went wrong with the sql";
                }
            }else{
                $error = "Entered City already exits!!";
            }
            return $error;
        }
        function addState(){}
        function addCountry(){}

        function updateCity(){}
        function updateState(){}
        function updateCountry(){}

        function isCityExits($countryid, $stateid, $city){
            $sql = "SELECT * FROM cities WHERE countryId=$countryid AND stateId=$stateid AND city='$city'";
            $result = $this->getConnection()->query($sql);
            if($result->num_rows > 0){
                return true;
            }
            return false;
        }
    }
?>