<?php
require_once("dbHandler.php");
class TaxHandler extends DBConnection
{

    function TotalTaxRecords($search)
    {
        $search_ = ($search == '') ? 1 : "(states.state LIKE '%" . $search . "%' OR countries.country LIKE '%" .$search. "%')";
        $sql = "SELECT COUNT(*) AS total FROM servicetax JOIN states ON states.id=servicetax.stateId JOIN countries ON countries.id=servicetax.countryId WHERE $search_ AND servicetax.status=0 ORDER BY servicetax.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getTaxByState($stateId, $countryId){
        $tax = 0;
        $sql = "SELECT * FROM servicetax WHERE stateId=$stateId AND countryId=$countryId AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $tax = $result->fetch_assoc()["tax"];
        }
        return $tax;
    }

    function getTaxRecords($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "(states.state LIKE '%" . $search . "%' OR countries.country LIKE '%" .$search. "%')";
        $sql = "SELECT servicetax.*, countries.country, states.state FROM servicetax JOIN countries ON countries.id=servicetax.countryId JOIN states ON states.id=servicetax.stateId WHERE $search_ AND servicetax.status=0 ORDER BY servicetax.id DESC LIMIT $page, $show";
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

    function getTaxById($id)
    {
        $records = [];
        $taxid = (int) $id;
        $sql = "SELECT * FROM servicetax WHERE id=$taxid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }


    function addTax($tax, $stateId, $countryId)
    {
        $error = "";
        if (!$this->isTaxAlreadyExits($stateId, $countryId)) {
            $sql = "INSERT INTO servicetax (tax, countryId, stateId, createdDate) VALUES ($tax, $countryId, $stateId , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Tax for stateId $stateId is already exits!!";
        }
        return $error;
    }

    function updateTax($taxId, $tax, $stateId, $countryId)
    {
        $error = "";
        $sql = "UPDATE servicetax SET tax=$tax, countryId=$countryId, stateId=$stateId, modifiedDate=now() WHERE id=$taxId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteTaxRecords($id)
    {
        $sql = "DELETE FROM servicetax WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function isTaxAlreadyExits($stateId, $countryId)
    {
        $sql = "SELECT * FROM servicetax WHERE countryId=$countryId AND stateId=$stateId AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
