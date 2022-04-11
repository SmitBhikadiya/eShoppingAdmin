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
        $sql = "SELECT subcategory.*, category.CatName FROM subcategory JOIN category ON category.id=subcategory.categoryId WHERE category.status=0 AND subcategory.status=0 ORDER BY subcategory.id DESC";
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
}
