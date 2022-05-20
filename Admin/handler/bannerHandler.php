<?php
require_once("dbHandler.php");
class BannerHandler extends DBConnection
{

    function getAllBanner()
    {
        $sql = "SELECT homebanners.* FROM homebanners WHERE homebanners.status=0 ORDER BY homebanners.id DESC";
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

    function TotalBanner($search)
    {
        $search_ = ($search == '') ? 1 : "bannerName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM homebanners WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getBanners($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "bannerName LIKE '%" . $search . "%'";
        $sql = "SELECT * FROM homebanners WHERE $search_ AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getBannerById($id)
    {
        $records = [];
        $bannerId = (int) $id;
        $sql = "SELECT * FROM homebanners WHERE id=$bannerId AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function addBanner($bannerName, $bannerDesc, $bannerImageURL)
    {
        $error = "";
        
        $sql = "INSERT INTO homebanners (bannerName, bannerDesc, bannerImageURL, createdDate) VALUES ('$bannerName', '$bannerDesc', '$bannerImageURL' , now())";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function updateBanner($id, $bannerName, $bannerDesc, $bannerImageURL)
    {
        $error = "";
        $sql = "UPDATE homebanners SET bannerName='$bannerName', bannerDesc='$bannerDesc', bannerImageURL='$bannerImageURL', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteBanner($id)
    {
        $sql = "UPDATE homebanners SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
