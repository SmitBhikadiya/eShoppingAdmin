<?php
    // if(isset($_FILES['upload']['name'])){
    //     $file = $_FILES['upload']['tmp_name'];
    //     $file_name = $_FILES['upload']['name'];
    //     $file_name_array = explode(".", $file_name);
    //     $extension = $file_name_array[1];
    //     //print_r($file_name_array);
    //     $new_image_name = rand(). '.'. $extension;
    //     $target_dir = 'http://localhost/eShoppingAdmin/admin/images/application/';
    //     $allowed_extension = array('jpg', 'gif', 'png');
    //     if(in_array($extension, $allowed_extension)){
    //        if(move_uploaded_file($file, '../images/application/'.$new_image_name)){
    //            //$function_number = $_GET['CKEditorFuncNum'];
    //            $url = $target_dir.$new_image_name;
    //            $message = '';
    //        }else{
    //            $message = 'Failed To Upload File';
    //        }
    //     }else{
    //         $message = 'Invalid Extension!!';
    //     }
    // }else{
    //     $message = 'Invalid Request!!';
    // }

    // if($message=='' && isset($url) && !empty($url)){
    //     echo json_encode(['uploaded'=>true, 'url'=>$url]);
    // }else{
    //     echo json_encode(["uploaded"=>false, 'error'=>['message'=>$message]]);
    // }
?>