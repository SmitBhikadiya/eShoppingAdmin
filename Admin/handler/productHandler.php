<?php
require_once("dbHandler.php");

class ProductHandler extends DBConnection
{

    function addOnStripe($name, $desc, $catid, $subcatid, $price, $qty, $colors, $sizes, $imagesArr, $trending, $sku){
        include '../vendor/autoload.php';
        $stripe = new \Stripe\StripeClient('sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI');
        $res = $stripe->products->create([
            'name' => $name,
            'active' => true,
            'images' => array_map(function($img){ return "http://127.0.0.1/eShoppingAdmin/Admin/images/product/".$img; }, $imagesArr),
            'default_price_data' => [
                'currency'=>'inr',
                'unit_amount_decimal'=>$price*100,
            ],
            'metadata' => [
                'catId' => $catid,
                'subCatId' => $subcatid,
                'quantity' => $qty,
                'colors' => $colors,
                'sizes' => $sizes,
                'sku' => $sku
            ],
            'description' => $desc,
        ]);
        return $res;
    }

    // function updateOnStripe($name, $prdid, $imagesArr, $price, $desc){
    //     include '../vendor/autoload.php';
    //     $stripe = new \Stripe\StripeClient('sk_test_51KwIFNSH3d6vW3Ey12LxVuoYreQZgsLcOsLCUqtOttx6XZxqStyLyUw8fytC7yZixdd9ST8oZRG2hFMJxMCcY32r00OIDPZLYI');
    //     $res = $stripe->products->update([
    //         'id' => $prdid,
    //         'name' => $name,
    //         'active' => true,
    //         'images' => array_map(function($img){ return "http://127.0.0.1/eShoppingAdmin/Admin/images/product/".$img; }, $imagesArr),
    //         'default_price_data' => [
    //             'currency'=>'inr',
    //             'unit_amount_decimal'=>$price*100,
    //         ],
    //         'description' => $desc,
    //     ]);
    //     return $res;
    // }

    function TotalReview($search = ''){
        $search_ = ($search == '') ? 1 : "(pr.review LIKE '%" . $search . "%' OR products.productName LIKE '%" . $search . "%' OR pr.productRate = '$search' OR pr.productId = '$search')";
        $sql = "SELECT COUNT(*) AS total FROM productreview AS pr JOIN products ON products.id = pr.productId WHERE ($search_) AND pr.status=0 AND products.status=0 ORDER BY pr.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalProducts($search = '')
    {
        $search_ = ($search == '') ? 1 : "productName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM products JOIN category ON category.id = products.categoryId WHERE ($search_) AND products.status=0 AND category.status=0 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalTrendingProducts($search = ''){
        $search_ = ($search == '') ? 1 : "productName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM products JOIN category ON category.id = products.categoryId WHERE ($search_) AND products.status=0 AND category.status=0 AND isTrending=1 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalColors($search = '')
    {
        $search_ = ($search == '') ? 1 : "colorName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM productcolor WHERE ($search_) AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function TotalSizes($search = '')
    {
        $search_ = ($search == '') ? 1 : "size LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM productsize WHERE ($search_) AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getAllReview(){
        $sql = "SELECT pr.*, products.productName FROM productreview AS pr JOIN products ON products.id = pr.productId WHERE pr.status=0 AND products.status=0 ORDER BY pr.id DESC";
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

    function getAllReviewByPrdouctId($prdId){
        $sql = "SELECT pr.*, products.productName FROM productreview AS pr JOIN products ON products.id = pr.productId WHERE productId=$prdId AND pr.status=0 AND products.status=0 ORDER BY pr.id DESC";
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

    function getAllColor($cat = '', $subcat = '')
    {
        $sql = "SELECT productcolor.* FROM productcolor WHERE productcolor.status=0 ORDER BY productcolor.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrd = $this->countPrdByCatAndSubCatId($row["id"], $cat, $subcat);
                $row["totalPrd"] = $totalPrd;
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getAllColorByCat($cat = '')
    {
        $sql = "SELECT productcolor.* FROM productcolor WHERE productcolor.status=0 ORDER BY productcolor.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrd = $this->countPrdByCatId($row["id"], $cat);
                $row["totalPrd"] = $totalPrd;
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getAllSizeByCat($cat = ''){
        $sql = "SELECT productsize.* FROM productsize WHERE productsize.status=0 ORDER BY productsize.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrd = $this->countPrdBySizeId($row["id"], $cat);
                $row["totalPrd"] = $totalPrd;
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getAllSize($cat = '', $subcat = '')
    {
        $sql = "SELECT productsize.* FROM productsize WHERE productsize.status=0 ORDER BY productsize.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrd = $this->countPrdBySizeId($row["id"], $cat, $subcat);
                $row["totalPrd"] = $totalPrd;
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getReviews($search, $page, $show, $sortby){
        $search_ = ($search == '') ? 1 : "(pr.review LIKE '%" . $search . "%' OR products.productName LIKE '%" . $search . "%' OR pr.productRate = '$search' OR pr.productId = '$search')";

        $sortby_ = '';
        switch($sortby){
            case 'productName':
                $sortby_ = 'products.productName';
                break;
            case 'reviewDate':
                $sortby_ = 'pr.createdDate';
                break;
            default:
                $sortby_ = 'pr.id';
        }

        $sql = "SELECT pr.*, products.productName, users.username FROM productreview AS pr JOIN products ON products.id = pr.productId JOIN users ON users.id = pr.userId WHERE ($search_) AND pr.status=0 AND products.status=0 ORDER BY $sortby_ DESC LIMIT $page, $show";
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
        $sql = "SELECT * FROM productcolor WHERE ($search_) AND status=0 ORDER BY id DESC LIMIT $page, $show";
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
        $sql = "SELECT * FROM productsize WHERE ($search_) AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getProducts($search, $page, $show, $colorid = '', $sizeids = '', $subcatids = '', $catids = '', $priceStart = 0, $priceEnd = 12000, $sortby='latest', $trending='0,1')
    {
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $subcatids_ = ($subcatids == '') ? 1 : "products.subCategoryId IN (" . $subcatids . ")";
        $catids_ = ($catids == '') ? 1 : "products.categoryId IN (" . $catids . ")";
        $search_ = ($search == '') ? 1 : "products.productName LIKE '%" . $search . "%' OR category.catName = '$search' OR subcategory.subCatName = '$search'";
        $trending_ = "(".$trending.")";
        
        $sortby_ = 1;
        switch($sortby){
            case 'latest':
                $sortby_ = 'products.id'; break;
            case 'name':
                $sortby_ = 'products.productName'; break;
            case 'price':
                $sortby_ = 'products.productPrice'; break;
            default:
                $sortby_ = 'products.id';
        }

        $sql = "SELECT products.*, category.catName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId 
        WHERE ($search_) AND $colorid_ AND $subcatids_ AND $catids_ AND products.isTrending IN $trending_ AND 
        (products.productPrice>=$priceStart AND products.productPrice<=$priceEnd) AND products.status=0 AND
         category.status=0 AND subcategory.status=0 ORDER BY $sortby_ DESC LIMIT $page, $show";

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

    function getTrendingProducts($search, $page, $show, $colorid = '', $sizeids = '', $subcatids = '', $priceStart = 0, $priceEnd = 12000, $sortby='latest', $trending='0,1')
    {
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $subcatids_ = ($subcatids == '') ? 1 : "products.subCategoryId IN (" . $subcatids . ")";
        $search_ = ($search == '') ? 1 : "products.productName LIKE '%" . $search . "%' OR category.catName = '$search' OR subcategory.subCatName = '$search'";
        $trending_ = "(".$trending.")";
        
        $sortby_ = 1;
        switch($sortby){
            case 'latest':
                $sortby_ = 'products.id'; break;
            case 'name':
                $sortby_ = 'products.productName'; break;
            case 'price':
                $sortby_ = 'products.productPrice'; break;
            default:
                $sortby_ = 'products.id';
        }

        $sql = "SELECT products.*, category.catName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE ($search_) AND $colorid_ AND $subcatids_ AND products.isTrending IN $trending_ AND (products.productPrice>=$priceStart AND products.productPrice<=$priceEnd) AND products.status=0 AND category.status=0 AND subcategory.status=0 AND isTrending=1 ORDER BY $sortby_ DESC LIMIT $page, $show";
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

    function getReviewById($reviewId){
        $records = [];
        $reviewId = (int) $reviewId;
        $sql = "SELECT pr.*, users.username FROM productreview AS pr JOIN users ON users.id = pr.userId WHERE pr.id=$reviewId AND pr.status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function getReviewsByProduct($prdId){
        $records = [];
        $prdId = (int) $prdId;
        $sql = "SELECT pr.*, users.username FROM productreview AS pr JOIN users ON users.id = pr.userId WHERE pr.productId=$prdId AND pr.status = 0 ORDER BY pr.id DESC";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                array_push($records, $row);
            }
        } else {
            $records = [];
        }
        return $records;
    }

    function getReviewByIds($prdId, $userId){
        $records = [];
        $prdId = (int) $prdId;
        $userId = (int) $userId;
        $sql = "SELECT pr.*, users.username FROM productreview AS pr JOIN users ON users.id = pr.userId WHERE pr.productId=$prdId AND pr.userId=$userId AND pr.status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
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

    function getProductBySubCatName($catname, $subcatname, $page, $show, $colorid = '', $sizeids = '', $subcatids = '', $priceStart = 0, $priceEnd = 12000, $sortby='latest', $searchby='')
    {
        $records = [];
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $subcatids_ = ($subcatids == '') ? 1 : "products.subCategoryId IN (" . $subcatids . ")";
        $search_ = ($searchby== '') ? 1 : "products.productName LIKE '%" . $searchby . "%'";

        switch($sortby){
            case 'latest':
                $sortby_ = 'products.id'; break;
            case 'name':
                $sortby_ = 'products.productName'; break;
            case 'price':
                $sortby_ = 'products.productPrice'; break;
            default:
                $sortby_ = 'products.id';
        }

        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE $colorid_ AND $subcatids_ AND ($search_) AND (products.productPrice>=$priceStart AND products.productPrice<=$priceEnd) AND category.catName = '$catname' AND " . (($subcatname == "null") ? 1 : "subcategory.subCatName = '$subcatname'") . " AND products.status=0 AND category.status=0 AND subcategory.status=0 ORDER BY $sortby_ DESC LIMIT $page, $show";
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

    function getProductByCatName($catname, $page, $show, $colorid = '', $sizeids = '', $subcatids = '', $priceStart = 0, $priceEnd = 12000, $sortby='latest', $searchby='')
    {
        $records = [];
        $colorid_ = ($colorid == '') ? 1 : "products.productColorIds LIKE '%" . $colorid . "%'";
        $subcatids_ = ($subcatids == '') ? 1 : "products.subCategoryId IN (" . $subcatids . ")";
        $search_ = ($searchby== '') ? 1 : "products.productName LIKE '%" . $searchby . "%'";
        
        switch($sortby){
            case 'latest':
                $sortby_ = 'products.id'; break;
            case 'name':
                $sortby_ = 'products.productName'; break;
            case 'price':
                $sortby_ = 'products.productPrice'; break;
            default:
                $sortby_ = 'products.id';
        }
        
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE ($search_) AND $colorid_ AND $subcatids_ AND (products.productPrice>=$priceStart AND products.productPrice<=$priceEnd) AND category.catName = '$catname' AND products.status=0 AND category.status=0 AND subcategory.status=0 ORDER BY $sortby_ DESC LIMIT $page, $show";
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

    function getProductByCategory($catid, $search='')
    {
        $records = [];
        $search_ = ($search == '') ? 1 : "products.productName LIKE '%" . $search . "%' OR category.catName = '$search' OR subcategory.subCatName = '$search'";
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE ($search_) AND products.categoryId=$catid AND products.status=0 AND category.status=0 AND subcategory.status=0";
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

    function getProductBySubCategory($subcatid, $search='')
    {
        $records = [];
        $search_ = ($search == '') ? 1 : "products.productName LIKE '%" . $search . "%' OR category.catName = '$search' OR subcategory.subCatName = '$search'";
        $sql = "SELECT products.*, category.catName, subcategory.subCatName FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id=products.subCategoryId WHERE ($search_) AND products.subCategoryId=$subcatid AND products.status=0 AND category.status=0 AND subcategory.status=0";
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

    function getSizeByIds($ids = '()')
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

    function addReview($userId, $productId, $productRate, $review){
        $review = mysqli_real_escape_string($this->getConnection(), $review);
        $error = "";
        $result = [];
        $sql = "INSERT INTO productreview (userId, productId, productRate, review, createdDate) VALUES ($userId, $productId, $productRate, '$review' , now())";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }else{
            $result = $this->getReviewByIds($productId, $userId);
        }
        return ['error'=>$error, 'result'=>$result];
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

    function addProduct($name, $desc, $catid, $subcatid, $price, $qty, $colors, $sizes, $imagesArr, $trending, $sku)
    {
        $name = mysqli_real_escape_string($this->getConnection(), $name);
        $desc = mysqli_real_escape_string($this->getConnection(), $desc);
        $sku = mysqli_real_escape_string($this->getConnection(), $sku);
        $images = implode(',', $imagesArr);
        $colorIds = implode(',', $colors);
        $sizeIds = implode(',', $sizes);
        $error = "";
        if(!$this->isSKUExits($sku)){
            if (!$this->isProductExits($name, $catid, $subcatid)) {
                $res = $this->addOnStripe($name, $desc, $catid, $subcatid, $price, $qty, $colorIds, $sizeIds, $imagesArr, $trending, $sku);
                if(count($res) > 0){
                    $stripeId = $res->id;
                    $priceId = $res->default_price;
                    $sql = "INSERT INTO products (stripeId, stripePriceId, productName, productDesc, productPrice, productSizeIds, productColorIds, productImages, totalQuantity, categoryId, subCategoryId, isTrending, SKU, createdDate) 
                            VALUES ('$stripeId', '$priceId' ,'$name', '$desc', $price, '$sizeIds', '$colorIds', '$images', $qty, $catid, $subcatid , $trending, '$sku', now())";
                    $result = $this->getConnection()->query($sql);
                    if (!$result) {
                        $error = "Somthing went wrong with the $sql";
                    }
                }else{
                    $error = "Somthing went wrong with the StripeAPI!!";
                }
            } else {
                $error = "'$name' is already exits in the selected category!!";
            }
        }else{
            $error = "SKU must be unique!!!";
        }
        
        return $error;
    }

    function countPrdBySubCatId($id)
    {
        $sql = "SELECT COUNT(*) AS total FROM products WHERE subCategoryId=$id AND status=0";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        } else {
            return 0;
        }
    }

    function getSubCategoryByCatName($catname)
    {
        $sql = "SELECT subcategory.* FROM subcategory JOIN category ON category.id=subcategory.categoryId WHERE category.catName='$catname' AND category.status = 0 AND subcategory.status = 0";
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

    function getSubCategoryByName($name){
        $sql = "SELECT subcategory.* FROM subcategory WHERE subCatName=$name subcategory.status = 0";
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

    function countPrdByCatId($id, $cat = '')
    {
        $count = 0;
        $cat_ = (($cat=='') ? 1 : 'category.catName="'.$cat.'"'); // ($subcat=='') ? ( : 'category.catName="'.$cat.'" AND subcategory.subCatName="'.$subcat.'"' ;
        $sql = "SELECT products.productColorIds FROM products JOIN category ON category.id = products.categoryId WHERE $cat_ AND products.status=0 AND category.status=0 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($result && $product = $result->fetch_assoc()) {
                $ids = explode(",", $product["productColorIds"]);
                if (in_array($id, $ids)) {
                    $count++;
                }
            }
        } else {
            $count = 0;
        }
        return $count;
    }

    function countPrdByCatAndSubCatId($id, $cat = '', $subcat = '')
    {
        $count = 0;
        $cat_ = ($subcat=='') ? (($cat=='') ? 1 : 'category.catName="'.$cat.'"') : 'category.catName="'.$cat.'" AND subcategory.subCatName="'.$subcat.'"' ;
        $sql = "SELECT products.productColorIds FROM products JOIN category ON category.id = products.categoryId JOIN subcategory ON subcategory.id = products.subCategoryId WHERE $cat_ AND products.status=0 AND subcategory.status=0 AND category.status=0 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($result && $product = $result->fetch_assoc()) {
                $ids = explode(",", $product["productColorIds"]);
                if (in_array($id, $ids)) {
                    $count++;
                }
            }
        } else {
            $count = 0;
        }
        return $count;
    }

    function countPrdBySizeId($id, $cat = '')
    {
        $count = 0;
        $cat_ = ($cat=='') ? 1 : 'category.catName="'.$cat.'"';
        $sql = "SELECT products.productSizeIds FROM products JOIN category ON category.id = products.categoryId WHERE $cat_ AND products.status=0 AND category.status=0 ORDER BY products.id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($result && $product = $result->fetch_assoc()) {
                $ids = explode(",", $product["productSizeIds"]);
                if (in_array($id, $ids)) {
                    $count++;
                }
            }
        } else {
            $count = 0;
        }
        return $count;
    }

    function updateReview($reviewId, $productRate, $review){

        $error = "";
        $review = mysqli_real_escape_string($this->getConnection(), $review);
        $sql = "UPDATE productreview SET productRate=$productRate, review='$review' WHERE id=$reviewId";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function updateProduct($prdid, $name, $desc, $catid, $subcatid, $price, $qty, $colorsArr, $sizesArr, $imagesArr, $trending, $sku)
    {
        $name = mysqli_real_escape_string($this->getConnection(), $name);
        $desc = mysqli_real_escape_string($this->getConnection(), $desc);
        $images = trim(implode(',', $imagesArr), ",");
        $colorIds = implode(',', $colorsArr);
        $sizeIds = implode(',', $sizesArr);
        $error = "";
        $sql = "UPDATE products SET productName='$name', productDesc='$desc', productPrice=$price, productSizeIds='$sizeIds', productColorIds='$colorIds', productImages='$images', totalQuantity=$qty, categoryId=$catid, subCategoryId=$subcatid, isTrending=$trending, SKU='$sku', modifiedDate=now() 
                WHERE id=$prdid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function updateProductImages($prdid, $images){
        $error = "";
        $sql = "UPDATE products SET productImages='$images', modifiedDate=now() WHERE id=$prdid";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
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

    function deleteReview($reviewId){
        $sql = "UPDATE productreview SET status=1, modifiedDate=now() WHERE id=$reviewId";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
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

    function isReviewGiven($userId, $prdId){
        $sql = "SELECT * FROM productreview WHERE userId=$userId AND productId=$prdId AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
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

    function isSKUExits($sku){
        $sql = "SELECT * FROM products WHERE SKU='$sku' AND status = 0";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
