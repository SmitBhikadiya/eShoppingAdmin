<?php
    require_once("dbHandler.php");
    class NewsletterHandler extends DBConnection{

        function TotalNewsLetter($search){
            $search_ = ($search == '') ? 1 : "(title LIKE '%" . $search . "%')";
            $sql = "SELECT COUNT(*) AS total FROM newsletter WHERE $search_ AND status=0 ORDER BY newsletter.id DESC";
            $result = $this->getConnection()->query($sql);
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc()["total"];
            }
            return 0;
        }

        function getNewsLetter($search, $page, $show)
        {
            $search_ = ($search == '') ? 1 : "(title LIKE '%" . $search . "%')";
            $sql = "SELECT * FROM newsletter WHERE $search_ AND status=0 ORDER BY newsletter.id DESC LIMIT $page, $show";
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

        function TotalNewsLetterSubscriber($search){
            $search_ = ($search == '') ? 1 : "(email LIKE '%" . $search . "%')";
            $sql = "SELECT COUNT(*) AS total FROM newslettersubscriber WHERE $search_ AND status=0 ORDER BY newslettersubscriber.id DESC";
            $result = $this->getConnection()->query($sql);
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc()["total"];
            }
            return 0;
        }

        function getNewsLetterSubscriber($search, $page, $show)
        {
            $search_ = ($search == '') ? 1 : "(email LIKE '%" . $search . "%')";
            $sql = "SELECT * FROM newslettersubscriber WHERE $search_ AND status=0 ORDER BY newslettersubscriber.id DESC LIMIT $page, $show";
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

        function getNewsLetterById($id){
            $sql = "SELECT * FROM newsletter WHERE id=$id AND status=0";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if ($result->num_rows > 0) {
                $records = $result->fetch_assoc();
            } else {
                $records = [];
            }
            return $records;
        }
        
        function newsletterSubscribe($email){
            $error = '';
            $records = $this->getSubscriberBy($email);
            if(count($records) == 0){
                $sql = "INSERT INTO newslettersubscriber (email, isSubscribe, createdDate) VALUES ('$email', 1, now())";
                $res = $this->getConnection()->query($sql);
                if(!$res){
                    $error = "Somthing went wrong with sql!!";
                }
            }else{
                $error = "You are already subscribed!!";
            }
            return $error;
        }  

        function getSubscriberBy($email){
            $records = [];
            $sql = "SELECT * FROM newslettersubscriber WHERE email='$email' AND status=0";
            $res = $this->getConnection()->query($sql);
            if($res && $res->num_rows > 0){
               array_push($records,$res->fetch_assoc());
            }
            return $records;
        }

        function getAllSubscriberEmail(){
            $emails = [];
            $sql = "SELECT email FROM newslettersubscriber WHERE isSubscribe=1 AND status=0";
            $res = $this->getConnection()->query($sql);
            if($res && $res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    array_push($emails,$row['email']);
                }
            }
            return $emails;
        }

        function AddNewsletter($title, $desc){
            $error = "";
            $description = mysqli_real_escape_string($this->getConnection(), $desc);
            $sql = "INSERT INTO newsletter (title, description, createdDate) VALUES ('$title', '$description', now())";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the sql";
            }
            return $error;
        }

        function UpdateNewsletter($id, $title, $desc){
            $error = "";
            $description = mysqli_real_escape_string($this->getConnection(), $desc);
            $sql = "UPDATE newsletter SET title='$title', description='$description', modifiedDate=now() WHERE id=$id";
            $result = $this->getConnection()->query($sql);
            if (!$result) {
                $error = "Somthing went wrong with the $sql";
            }
            return $error;
        }

        function deleteNewsletter($id){
            $sql = "UPDATE newsletter SET status=1, modifiedDate=now() WHERE id=$id";
            $result = $this->getConnection()->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }

        function deleteSubscriber($id){
            $sql = "UPDATE newslettersubscriber SET status=1, modifiedDate=now() WHERE id=$id";
            $result = $this->getConnection()->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }
    }
?>