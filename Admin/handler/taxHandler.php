<?php
require_once("dbHandler.php");
class TaxHandler extends DBConnection
{

    
    function createTaxInStripe($tax, $stateId, $countryId){
        $res = [];
        $detailes = $this->getDetailesBy($stateId, $countryId);
        if(count($detailes) > 0 && ($tax <= 100 && $tax >= 1)){
            include '../vendor/autoload.php';
            $stripe = new \Stripe\StripeClient('sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI');
            $res = $stripe->taxRates->create([
                'display_name' => $detailes['state'],
                'description' => $detailes['state']. ' '. $detailes['country'],
                'percentage' => $tax,
                'inclusive' => false,
                'metadata' => [
                    'country'=>$detailes['country'],
                    'state'=>$detailes['state']
                ]
              ]);
        }
        return $res;
    }

    function deleteTaxAPI($taxStripeId){
        include '../vendor/autoload.php';
        $stripe = new \Stripe\StripeClient('sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI');
        $stripe->taxRates->update(
          $taxStripeId,
          [
              'active' => false,
            ]
        );
    }

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
        $tax = [];
        $sql = "SELECT servicetax.*, countries.country, states.state FROM servicetax JOIN countries ON countries.id=servicetax.countryId JOIN states ON states.id=servicetax.stateId WHERE servicetax.stateId=$stateId AND servicetax.countryId=$countryId AND servicetax.status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $tax = $result->fetch_assoc();
        }
        return $tax;
    }

    function getDetailesBy($stateId, $countryId){
        $record = [];
        $sql = "SELECT countries.country, states.state FROM countries JOIN states ON states.countryId=countries.id WHERE countries.id=$countryId AND states.id=$stateId";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $record = $result->fetch_assoc();
        }
        return $record;
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

    function getTaxById($id, $status=0)
    {
        $records = [];
        $taxid = (int) $id;
        $sql = "SELECT servicetax.*, countries.country, states.state FROM servicetax JOIN countries ON countries.id=servicetax.countryId JOIN states ON states.id=servicetax.stateId WHERE servicetax.id=$taxid AND servicetax.status = $status";
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
            $res = $this->createTaxInStripe($tax, $stateId, $countryId);
            if(count($res) > 0){
                $stripeId = $res->id;
                $sql = "INSERT INTO servicetax (stripeId, tax, countryId, stateId, createdDate) VALUES ('$stripeId', $tax, $countryId, $stateId , now())";
                $result = $this->getConnection()->query($sql);
                if (!$result) {
                    $error = "Somthing went wrong with the sql";
                }
            }else{
                $error = "Somthing went wrong with the stripeApi";
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
        }else{
            $taxData = $this->getTaxById($taxId);
            if(count($taxData) > 0){
                //$this->updateTaxAPI($tax, $taxData["stripeId"], $taxData["country"], $taxData["state"]);
            }
        }
        return $error;
    }

    function getTaxRegistredCountry(){
        $sql = "SELECT countries.* FROM countries JOIN servicetax ON servicetax.countryId=countries.id WHERE servicetax.status=0 AND countries.status = 0 GROUP BY servicetax.countryId ORDER BY countries.id DESC";
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

    function getTaxRegistredStateByCoutry($id){
        $sql = "SELECT states.* FROM states JOIN servicetax ON servicetax.stateId=states.id WHERE states.countryId=$id AND servicetax.status=0 AND states.status = 0 GROUP BY servicetax.stateId";
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

    function deleteTaxRecords($id)
    {
        $sql = "UPDATE servicetax SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            $taxData = $this->getTaxById($id, 1);
            if(count($taxData) > 0){
                $this->deleteTaxAPI($taxData["stripeId"]);
            }
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
