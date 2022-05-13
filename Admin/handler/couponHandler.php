<?php
require_once("dbHandler.php");

class CouponHandler extends DBConnection
{

    function createCouponInStripe($coupon, $expiry, $requireAmtForApplicable, $totalUsage, $discountAmount, $duration='repeating', $currency='inr'){
        include '../vendor/autoload.php';
        $res = [];
        $stripe = new \Stripe\StripeClient('sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI');
        $res = $stripe->coupons->create([
            'name' => $coupon,
            'amount_off' => $discountAmount*100,
            'duration' => $duration,
            'duration_in_months' => 12,
            'currency' => $currency,
            'metadata' => [
                'expiry' => $expiry,
                'requireAmtForApplicable' => $requireAmtForApplicable
            ],
            'max_redemptions' => $totalUsage
        ]);
        return $res;
    }

    function TotalCoupon($search = '', $sortBy='all')
    {
        $curr_date = date('Y-m-d H:i:s');
        $sortBy_ = 1;
        switch($sortBy){
            case "expired":
                $sortBy_ = "couponExpiry < '$curr_date'";
                break;
            case "notexpired":
                $sortBy_ = "couponExpiry > '$curr_date'";
                break;
        }

        $search_ = ($search == '') ? 1 : "couponCode LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM coupons WHERE $search_ AND $sortBy_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getCoupons($search, $page, $show, $sortBy='all')
    {

        $curr_date = date('Y-m-d H:i:s');
        $sortBy_ = 1;
        switch($sortBy){
            case "expired":
                $sortBy_ = "couponExpiry < '$curr_date'";
                break;
            case "notexpired":
                $sortBy_ = "couponExpiry > '$curr_date'";
                break;
        }

        $search_ = ($search == '') ? 1 : "couponCode LIKE '%" . $search . "%'";
        $sql = "SELECT coupons.* FROM coupons WHERE $search_ AND $sortBy_ AND status=0 ORDER BY coupons.id DESC LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row["isExpired"] = $this->isCouponExpired($row["couponExpiry"]);
                array_push($records, $row);
            }
        } else {
            $records = [];
        }    
        return $records;
    }

    function getCouponById($id){
        $records = [];
        $sql = "SELECT * FROM coupons WHERE id=$id AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records; 
    }

    function getCouponByCode($code){
        $records = [];
        $sql = "SELECT * FROM coupons WHERE couponCode='$code' AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records; 
    }

    function addCoupon($coupon, $expiry, $requireAmtForApplicable, $totalUsage, $discountAmount){
        $error = '';
        $coupon = strtoupper($coupon);
        if(!$this->isCouponAvailable($coupon)){
            $res = $this->createCouponInStripe($coupon, $expiry, $requireAmtForApplicable, $totalUsage, $discountAmount);
            if(count($res) > 0){
                $stripeId = $res->id;
                $sql = "INSERT INTO coupons (stripeId, couponCode, couponExpiry, requireAmountForApplicable, maximumTotalUsage, discountAmount, createdDate) VALUES ('$stripeId','$coupon', '$expiry', $requireAmtForApplicable, $totalUsage, $discountAmount, now())";
                $result = $this->getConnection()->query($sql);
                if(!$result){
                    $error = "Somthing went wrong with the $sql!!";
                }
            }else{
                $error = "Somthing went wrong with the stripeApi";
            }
        }else{
            $error = "Coupon ('$coupon') is already exits!!!";
        }

        return $error;
    }

    function isCouponAvailable($code){
        $sql = "SELECT * FROM coupons WHERE couponCode='$code' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    function isCouponExpired($expiry){
        date_default_timezone_set('Asia/Kolkata');
        $expiry = strtotime(Date($expiry));
        $current = strtotime(Date('Y-m-d H:i:s'));
       // echo $expiry, " ", $current, " ", $expiry < $current, "<br>";
        return ($expiry < $current) ? true : false;
    }


    function updateCoupon($id, $coupon, $expiry, $requireAmountForApplicable, $totalUsage, $discountAmount){
        $error = '';
        $coupon = strtoupper($coupon);
        $sql = "UPDATE coupons SET couponCode='$coupon', couponExpiry='$expiry', requireAmountForApplicable=$requireAmountForApplicable, maximumTotalUsage=$totalUsage, discountAmount=$discountAmount, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if(!$result){
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function deleteCoupon($id)
    {
        $sql = "UPDATE coupons SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
