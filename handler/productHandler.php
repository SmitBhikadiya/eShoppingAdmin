<?php
require_once("dbHandler.php");
class ProductHandler extends DBConnection
{

    function getColors(){
        $sql = "SELECT * FROM productcolor WHERE status=0 ORDER BY id DESC";
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
    function getSizes(){
        $sql = "SELECT * FROM productsize WHERE status=0 ORDER BY id DESC";
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
    function getProducts(){
        $sql = "SELECT products.*, category.catName FROM products JOIN category ON category.id = products.categoryId WHERE products.status=0 AND category.status=0 ORDER BY products.id DESC";
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
    function getColorById($id){
        $records = [];
        $colorid = (int) $id;
        $sql = "SELECT * FROM productcolor WHERE id=$colorid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getSizeById($id){
        $records = [];
        $sizeid = (int) $id;
        $sql = "SELECT * FROM productsize WHERE id=$sizeid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getProductById($id){
        $records = [];
        $productid = (int) $id;
        $sql = "SELECT * FROM products WHERE id=$productid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function addColor($color, $value){
        $error = "";
        if (!$this->isColorExits($color, $value)) {
            $sql = "INSERT INTO productcolor (colorName, colorCode, createdDate) VALUES ('$color', '$value' , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Color '$color' is already exits!!";
        }
        return $error;
    }
    function addSize($size){
        $error = "";
        if (!$this->isSizeExits($size)) {
            $sql = "INSERT INTO productsize (size, createdDate) VALUES ('$size' , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Size '$size' is already exits!!";
        }
        return $error;
    }
    function addProduct($name, $desc, $catid, $subcatid, $price, $qty, $colors, $sizes, $imagesArr){
        $images = implode(',', $imagesArr);
        $colorIds = implode(',', $colors);
        $sizeIds = implode(',', $sizes);
        $error = "";
        if (!$this->isProductExits($name, $catid, $subcatid)) {
            $sql = "INSERT INTO products (productName, productDesc, productPrice, productSizeIds, productColorIds, productImages, totalQuantity, categoryId, subCategoryId, createdDate) 
                    VALUES ('$name', '$desc', $price, '$sizeIds', '$colorIds', '$images', $qty, $catid, $subcatid , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the $sql";
            }
        } else {
            $error = "'$name' is already exits in the selected category!!";
        }
        return $error;
    }

    function updateColor($id, $color, $value){
        $error = "";
        $sql = "UPDATE productcolor SET colorName='$color', colorCode='$value', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }
    function updateSize($id, $size){
        $error = "";
        $sql = "UPDATE productsize SET size='$size', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteColor($id){
        $sql = "UPDATE productcolor SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
    function deleteSize($id){
        $sql = "UPDATE productsize SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function isColorExits($color, $value){
        $sql = "SELECT * FROM productcolor WHERE colorName='$color' AND colorCode='$value' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function isSizeExits($size){
        $sql = "SELECT * FROM productsize WHERE size='$size' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function isProductExits($name, $catid, $subcatid){
        $sql = "SELECT * FROM products WHERE productName='$name' AND categoryId=$catid AND subCategoryId=$subcatid AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}