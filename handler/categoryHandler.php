<?php
require_once("dbHandler.php");
class CategoryHandler extends DBConnection
{
    function getCategory(){
        $sql = "SELECT * FROM category WHERE status=0 ORDER BY id DESC";
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
    function getSubCategory(){
        $sql = "SELECT subcategory.*, category.catName FROM subcategory JOIN category ON category.id=subcategory.categoryId WHERE category.status=0 AND subcategory.status=0 ORDER BY subcategory.id DESC";
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
    function getCatById($id){
        $records = [];
        $catid = (int) $id;
        $sql = "SELECT * FROM category WHERE id=$catid AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }
    function getSubCatById($id){
        $records = [];
        $catid = (int) $id;
        $sql = "SELECT * FROM subcategory WHERE id=$catid AND subcategory.status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function addCategory($catname, $catdesc){
        $error = "";
        if (!$this->isCategoryExits($catname)) {
            $sql = "INSERT INTO category (catName, catDesc, createdDate) VALUES ('$catname', '$catdesc' , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Entered Category already exits!!";
        }
        return $error;
    }
    function addSubCategory($catname, $catdesc, $catid){
        $error = "";
        if (!$this->isSubCategoryExits($catname, $catid)) {
            $sql = "INSERT INTO subcategory (categoryId, subCatName, subCatDesc, createdDate) VALUES ($catid ,'$catname', '$catdesc' , now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
        } else {
            $error = "Entered Sub Category already exits in Category!!";
        }
        return $error;
    }

    function updateCategory($id, $name, $desc){
        $error = "";
        $sql = "UPDATE category SET catName='$name', catDesc='$desc', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }
    function updateSubCategory($id, $name, $desc, $catid){
        $error = "";
        $sql = "UPDATE subcategory SET subCatName='$name', subCatDesc='$desc', categoryId=$catid, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteCategory($id){
        $sql = "UPDATE category SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
    function deleteSubCategory($id){
        $sql = "UPDATE subcategory SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function isCategoryExits($catname){
        $sql = "SELECT * FROM category WHERE catName='$catname' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function isSubCategoryExits($catname, $catid){
        $sql = "SELECT * FROM subcategory WHERE categoryId=$catid AND subCatName='$catname' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
