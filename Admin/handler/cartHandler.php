<?php
require_once("dbHandler.php");
class CartHandler extends DBConnection
{

    function getCartItems($userId)
    {
        $sql = "SELECT cart.*, productcolor.colorName, products.productColorIds, products.productSizeIds, products.productPrice, products.totalQuantity, productsize.size, products.totalQuantity FROM cart JOIN productcolor ON productcolor.id=cart.productColorId JOIN productsize ON productsize.id = cart.productSizeId JOIN products ON products.id = cart.productId WHERE cart.userId=$userId AND cart.status=0 ORDER BY cart.id DESC";
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

    function getCartItemBy($userId, $prdId){
        $sql = "SELECT cart.*, productcolor.colorName, products.productColorIds, products.productSizeIds, products.productPrice, products.totalQuantity, productsize.size, products.totalQuantity FROM cart JOIN productcolor ON productcolor.id=cart.productColorId JOIN productsize ON productsize.id = cart.productSizeId JOIN products ON products.id = cart.productId WHERE cart.userId=$userId AND products.id=$prdId AND cart.status=0 ORDER BY cart.id DESC";
        $result = $this->getConnection()->query($sql);
        $record = [];
        if ($result && $result->num_rows > 0) {
            $record = $result->fetch_assoc();  
        } else {
            $record = [];
        }
        return $record;
    }

    function addToCart($prdId, $userId, $prdName, $colorId, $sizeId, $image, $unitPrize, $quantity, $subTotal){
        $error = "";
        if (!$this->isItemAddedAlready($prdId, $userId)) {
            $sql = "INSERT INTO cart (productId, userId, productName, productColorId, productSizeId, productImage, unitPrize, quantity, subTotal, createdDate) VALUES ($prdId, $userId, '$prdName', $colorId, $sizeId, '$image', $unitPrize, $quantity, $subTotal , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the $sql";
            }
        } else {
            $error = "Already added to cart!!";
        }
        return ["error"=>$error, "cartId"=>$this->getConnection()->insert_id];
    }

    function updateCart($cartId, $colorId, $sizeId, $quantity, $subTotal){
        $error = "";
        $sql = "UPDATE cart SET productColorId=$colorId, productSizeId=$sizeId, quantity=$quantity, subTotal=$subTotal, modifiedDate=now() WHERE id=$cartId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function removeFromCart($cartId){
        $sql = "DELETE FROM cart WHERE id=$cartId";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return "";
        }
        return "Somthing went wrong with the sql";
    }

    function removeCart($userId){
        $sql = "DELETE FROM cart WHERE userId=$userId";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return "";
        }
        return "Somthing went wrong with the sql";
    }

    function isItemAddedAlready($prdId, $userId){
        $sql = "SELECT * FROM cart WHERE productId=$prdId AND userId=$userId AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
