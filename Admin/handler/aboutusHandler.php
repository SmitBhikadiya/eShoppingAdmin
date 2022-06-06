<?php
require_once("dbHandler.php");
class AboutusHandler extends DBConnection
{

    function getContent(){
        $content = [];
        $sql = 'SELECT * FROM aboutus WHERE status=0';
        $result = $this->getConnection()->query($sql);
        if($result && $result->num_rows > 0){
            $content = $result->fetch_assoc();
        }
        return $content;
    }

    function addContent($content){
        $error = '';
        $content = mysqli_real_escape_string($this->getConnection(), $content);
        $sql = "INSERT INTO aboutus (content, createdDate) VALUES ('$content', now())";
        $res = $this->getConnection()->query($sql);
        if(!$res){
            $error = 'Somthing went wrong with the sql';
        }
        return $error;
    }

    function updateContent($id, $content){
        $error = '';
        $content = mysqli_real_escape_string($this->getConnection(), $content);
        $sql = "UPDATE aboutus SET content='$content', modifiedDate=now() WHERE id=$id AND status=0";
        $res = $this->getConnection()->query($sql);
        if(!$res){
            $error = 'Somthing went wrong with the sql';
        }
        return $error;
    }

    function getContentBy($id){
        $content = [];
        $sql = 'SELECT * FROM aboutus WHERE id=$id AND status=0';
        $result = $this->getConnection()->query($sql);
        if($result && $result->num_rows > 0){
            $content = $result->fetch_assoc();
        }
        return $content;
    }


}
