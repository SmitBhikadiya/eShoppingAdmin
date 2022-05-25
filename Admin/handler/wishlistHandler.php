<?php
require_once("dbHandler.php");
class WishlistHandler extends DBConnection
{

    function getAllWishList()
    {
        $sql = "SELECT wishlist.*, products.* 
                FROM wishlist 
                JOIN products ON products.id = wishlist.productId 
                WHERE products.status=0 AND wishlist.status=0 
                ORDER BY wishlist.id DESC";
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

    function getWishById($id)
    {
        $records = [];
        $wishId = (int) $id;
        $sql = "SELECT * FROM wishlist WHERE id=$wishId AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getProductById($productId){
        $records = [];
        $productId = (int) $productId;
        $sql = "SELECT * FROM products WHERE id=$productId AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getAllWishListBy($userId){
        $sql = "SELECT wishlist.*, products.productName, products.productPrice, products.productImages 
                FROM wishlist 
                JOIN products ON products.id = wishlist.productId 
                WHERE products.status=0 AND wishlist.status=0 AND wishlist.userId = $userId 
                ORDER BY wishlist.id DESC";
        $result = $this->getConnection()->query($sql);
        $wishlist = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = $this->getProductById($row['productId']);
                array_push($wishlist, [$row, $product]);
            }
        } else {
            $wishlist = [];
        }
        return $wishlist;
    }

    function addWish($userId, $productId)
    {
        $error = "";
        if (!$this->isWishExits($userId, $productId)) {
            $sql = "INSERT INTO wishlist (userId, productId, createdDate) VALUES ('$userId', '$productId' , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql!!";
            }
        } else {
            $error = "Your wish is already added!!";
        }
        return $error;
    }

    function deleteWish($id)
    {
        $error = '';
        $sql = "UPDATE wishlist SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = 'Somthing went wrong with sql!!!';
        }
        return $error;
    }

    function isWishExits($userId, $productId)
    {
        $sql = "SELECT * FROM wishlist WHERE userId='$userId' AND productId='$productId' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

}
