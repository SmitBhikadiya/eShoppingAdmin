<?php
require_once("dbHandler.php");
class AddressHandler extends DBConnection
{

    function getCities()
    {
        $sql = "SELECT cities.*, states.state, countries.country FROM cities JOIN states ON cities.stateId=states.id JOIN countries ON countries.id=cities.countryId WHERE cities.status=0 AND countries.status=0 AND states.status=0 ORDER BY cities.id DESC";
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
    function getStates()
    {
        $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId WHERE states.status=0 AND countries.status=0";
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
    function getCountries()
    {
        $sql = "SELECT * FROM countries WHERE countries.status = 0";
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
    function getCityById($id)
    {
        $records = [];
        $cityid = (int) $id;
        $sql = "SELECT cities.*, states.state FROM cities JOIN states ON states.id = cities.stateId WHERE cities.id = $cityid AND cities.status = 0 AND states.status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getStateById($id){
        $records = [];
        $stateid = (int) $id;
        $sql = "SELECT * FROM states WHERE id = $stateid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getCountryById($id){
        $records = [];
        $countryid = (int) $id;
        $sql = "SELECT * FROM countries WHERE id=$countryid AND countries.status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getStatesByCountryId($countryid)
    {
        $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId WHERE states.countryId=$countryid AND states.status = 0 AND countries.status = 0";
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

    function addCity($countryid, $stateid, $city)
    {
        $error = "";
        if (!$this->isCityExits($countryid, $stateid, $city)) {
            $sql = "INSERT INTO cities (city, stateId, countryId, createdDate) VALUES ('$city', $stateid, $countryid, now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Entered City already exits!!";
        }
        return $error;
    }
    function addState($countryid, $state)
    {
        $error = "";
        if (!$this->isStateExits($countryid, $state)) {
            $sql = "INSERT INTO states (state, countryId, createdDate) VALUES ('$state', $countryid, now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Entered State already exits!!";
        }
        return $error;
    }
    function addCountry($country)
    {
        $error = "";
        if (!$this->isCountryExits($country)) {
            $sql = "INSERT INTO countries (country, createdDate) VALUES ('$country', now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Entered Country already exits!!";
        }
        return $error;
    }

    function updateCity($countryid, $stateid, $cityid, $city)
    {
        $error = "";
        $sql = "UPDATE cities SET city='$city', stateId=$stateid, countryId=$countryid, modifiedDate=now() WHERE id=$cityid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }
    function updateState($countryid, $stateid, $state)
    {
        $error = "";
        $sql = "UPDATE states SET state='$state', countryId=$countryid, modifiedDate=now() WHERE id=$stateid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }
    function updateCountry($countryid, $country){
        $error = "";
        $sql = "UPDATE countries SET country='$country', modifiedDate=now() WHERE id=$countryid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function deleteCity($id){
        $sql = "UPDATE cities SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
    function deleteState($id){
        $sql = "UPDATE states SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
    function deleteCountry($id){
        $sql = "UPDATE countries SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function isCityExits($countryid, $stateid, $city)
    {
        $sql = "SELECT * FROM cities WHERE countryId=$countryid AND stateId=$stateid AND city='$city' AND cities.status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function isStateExits($countryid, $state)
    {
        $sql = "SELECT * FROM states WHERE countryId=$countryid AND state='$state' AND states.status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function isCountryExits($country)
    {
        $sql = "SELECT * FROM countries WHERE country='$country' AND countries.status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
