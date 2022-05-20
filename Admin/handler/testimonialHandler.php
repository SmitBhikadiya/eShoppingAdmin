<?php
require_once("dbHandler.php");

class TestimonialHandler extends DBConnection
{

    function getAllTestimonial()
    {
        $sql = "SELECT testimonials.* FROM testimonials WHERE testimonials.status=0 ORDER BY testimonials.id DESC";
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

    function TotalTestimonial($search)
    {
        $search_ = ($search == '') ? 1 : "reviewerName LIKE '%" . $search . "%'";
        $sql = "SELECT COUNT(*) AS total FROM testimonials WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function getTestimonials($search, $page, $show)
    {
        $search_ = ($search == '') ? 1 : "reviewerName LIKE '%" . $search . "%'";
        $sql = "SELECT * FROM testimonials WHERE $search_ AND status=0 ORDER BY id DESC LIMIT $page, $show";
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

    function getTestimonialById($id)
    {
        $records = [];
        $testId = (int) $id;
        $sql = "SELECT * FROM testimonials WHERE id=$testId AND status = 0";
        $result = $this->getConnection()->query($sql);
        $records = [];
        if ($result && $result->num_rows > 0) {
            $records = $result->fetch_assoc();
        } else {
            $records = [];
        }
        return $records;
    }

    function addTestimonial($reviewerName, $reviewerProfession, $reviewerImage, $review)
    {
        $error = "";
        $review = mysqli_real_escape_string($this->getConnection(),trim($review));
        $reviewerProfession = mysqli_real_escape_string($this->getConnection(),$reviewerProfession);
        $reviewerName = mysqli_real_escape_string($this->getConnection(),$reviewerName);
        $sql = "INSERT INTO testimonials (reviewerName, reviewerProfession, reviewerImage, review, createdDate) VALUES ('$reviewerName', '$reviewerProfession', '$reviewerImage', '$review' , now())";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the $sql";
        }
        return $error;
    }

    function updateTestimonial($id, $reviewerName, $reviewerProfession, $reviewerImage, $review)
    {
        $error = "";
        $review = mysqli_real_escape_string($this->getConnection(),trim($review));
        $reviewerProfession = mysqli_real_escape_string($this->getConnection(),$reviewerProfession);
        $reviewerName = mysqli_real_escape_string($this->getConnection(),$reviewerName);
        $sql = "UPDATE testimonials SET reviewerName='$reviewerName', reviewerProfession='$reviewerProfession', reviewerImage='$reviewerImage', review='$review', modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if (!$result) {
            $error = "Somthing went wrong with the sql";
        }
        return $error;
    }

    function deleteTestimonial($id)
    {
        $sql = "UPDATE testimonials SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
