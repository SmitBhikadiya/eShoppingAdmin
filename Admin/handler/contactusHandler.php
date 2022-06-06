<?php
require_once("dbHandler.php");
class ContactUsHandler extends DBConnection
{

    function getAllContacts($search, $page, $show)
    {

        $search_ = ($search == '') ? 1 : "title LIKE '%" . $search . "%' OR email LIKE '%".$search."%' OR name LIKE '%".$search."%' ";
        $sql = "SELECT contactus.* FROM contactus WHERE $search_ AND status=0 ORDER BY contactus.id DESC LIMIT $page, $show";
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

    function TotalContact($search){
        $search_ = ($search == '') ? 1 : "title LIKE '%" . $search . "%' OR email LIKE '%".$search."%' OR name LIKE '%".$search."%' ";
        $sql = "SELECT COUNT(*) AS total FROM contactus WHERE $search_ AND status=0 ORDER BY id DESC";
        $result = $this->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()["total"];
        }
        return 0;
    }

    function addContactUs($name, $email, $subject, $message){
        $error = '';
        $message = mysqli_real_escape_string($this->getConnection(), $message);
        $sql = "INSERT INTO contactus (name, email, subject, message, createdDate) VALUES ('$name', '$email', '$subject', '$message', now())";
        $res = $this->getConnection()->query($sql);
        if(!$res){
            $error = 'Somthing went wrong with the sql';
        }
        return $error;
    }

    function deleteContactUs($id){
        $sql = "UPDATE contactus SET status=1, modifiedDate=now() WHERE id=$id";
        $result = $this->getConnection()->query($sql);
        if(!$result){
            return false;
        }
        return true;
    }


}
