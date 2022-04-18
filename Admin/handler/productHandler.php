<?php
require_once("dbHandler.php");
class ProductHandler extends DBConnection
{

    function TotalProducts($search = '')
    {
        $search_ = ($search == '') ? 1 : "productName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM products JOIN category ON category.id = products.categoryId WHERE $search_ AND products.status=0 AND category.status=0 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalColors($search = '')
    {
        $search_ = ($search == '') ? 1 : "colorName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM productcolor WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalSizes($search = '')
    {
        $search_ = ($search == '') ? 1 : "size LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM productsize WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getAllProduct()
    {
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

    function getAllColor()
    {
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

    function getAllSize()
    {
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

    function getColors($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "colorName LIKE '%" . $search . "%'";
        $sql = "SELECT * FROM productcolor WHERE $search_ AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getSizes($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "size LIKE '%" . $search . "%'";
        $sql = "SELECT * FROM productsize WHERE $search_ AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getProducts($search, $page, $show, $colorid = '', $sizeids = '')
    {
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $search_ = ($search == '') ? 1 : "products.productName LIKE '%" . $search . "%'";
        $sql = "SELECT products.*, category.catName FROM products JOIN category ON category.id = products.categoryId WHERE $search_ AND $colorid_ AND products.status=0 AND category.status=0 ORDER BY products.id DESC LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($sizeids)) {
                    $sizes = explode(",", $sizeids);
                    $sizeIds = explode(",", $this->getProductById($row["id"])["productSizeIds"]);
                    for ($i = 0; $i < count($sizeIds); $i++) {
                        if (in_array($sizeIds[$i], $sizes)) {
                            array_push($records, $row);
                            break;
                        }
                    }
                    continue;
                }
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getColorById($id)
    {
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

    function getSizeById($id)
    {
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

    function getProductById($id)
    {
        $records = [];
        $productid = (int) $id;
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE products.id=$productid AND products.status=0 AND category.status=0 AND subcategory.status=0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getProductBySubCatName($catname, $subcatname, $page, $show, $colorid = '', $sizeids = '')
    {
        $records = [];
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE $colorid_ AND category.catName = '$catname' AND " . (($subcatname == "null") ? 1 : "subcategory.subCatName = '$subcatname'") . " AND products.status=0 AND category.status=0 AND subcategory.status=0 LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($sizeids)) {
                    $sizes = explode(",", $sizeids);
                    $sizeIds = explode(",", $this->getProductById($row["id"])["productSizeIds"]);
                    for ($i = 0; $i < count($sizeIds); $i++) {
                        if (in_array($sizeIds[$i], $sizes)) {
                            array_push($records, $row);
                            break;
                        }
                    }
                    continue;
                }
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getProductByCatName($catname, $page, $show, $colorid = '', $sizeids = '')
    {
        $records = [];
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE $colorid_ AND category.catName = '$catname' AND products.status=0 AND category.status=0 AND subcategory.status=0 LIMIT $page, $show";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($sizeids)) {
                    $sizes = explode(",", $sizeids);
                    $sizeIds = explode(",", $this->getProductById($row["id"])["productSizeIds"]);
                    for ($i = 0; $i < count($sizeIds); $i++) {
                        if (in_array($sizeIds[$i], $sizes)) {
                            array_push($records, $row);
                            break;
                        }
                    }
                    continue;
                }
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        // echo $sql;
        // echo "<pre>";
        // print_r($records);
        return $records;
    }

    function getProductByCategory($catid)
    {
        $records = [];
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE products.categoryId=$catid AND products.status=0 AND category.status=0 AND subcategory.status=0";
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

    function getProductBySubCategory($subcatid)
    {
        $records = [];
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE products.subCategoryId=$subcatid AND products.status=0 AND category.status=0 AND subcategory.status=0";
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

    function getSizeByIds($ids = [])
    {
        $records = [];
        $sql = "SELECT * FROM productsize WHERE id IN $ids AND status = 0";
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

    function getColorByIds($ids = [])
    {
        $records = [];
        $sql = "SELECT * FROM productcolor WHERE id IN $ids AND status = 0";
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

    function addColor($color, $value)
    {
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

    function addSize($size)
    {
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

    function addProduct($name, $desc, $catid, $subcatid, $price, $qty, $colors, $sizes, $imagesArr)
    {
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

    function updateProduct($prdid, $name, $desc, $catid, $subcatid, $price, $qty, $colorsArr, $sizesArr, $imagesArr)
    {
        $images = implode(',', $imagesArr);
        $colorIds = implode(',', $colorsArr);
        $sizeIds = implode(',', $sizesArr);
        $error = "";
        $sql = "UPDATE products SET productName='$name', productDesc='$desc', productPrice=$price, productSizeIds='$sizeIds', productColorIds='$colorIds', productImages='$images', totalQuantity=$qty, categoryId=$catid, subCategoryId=$subcatid, modifiedDate=now() 
                WHERE id=$prdid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function updateColor($id, $color, $value)
    {
        $error = "";
        $sql = "UPDATE productcolor SET colorName='$color', colorCode='$value', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function updateSize($id, $size)
    {
        $error = "";
        $sql = "UPDATE productsize SET size='$size', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteProduct($id)
    {
        $sql = "UPDATE products SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function deleteColor($id)
    {
        $sql = "UPDATE productcolor SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function deleteSize($id)
    {
        $sql = "UPDATE productsize SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    function isColorExits($color, $value)
    {
        $sql = "SELECT * FROM productcolor WHERE colorName='$color' AND colorCode='$value' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    function isSizeExits($size)
    {
        $sql = "SELECT * FROM productsize WHERE size='$size' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    function isProductExits($name, $catid, $subcatid)
    {
        $sql = "SELECT * FROM products WHERE productName='$name' AND categoryId=$catid AND subCategoryId=$subcatid AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
