<?php
    require_once("../handler/customerHandler.php");
    require_once("verifyToken.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $obj = new CustomerHandler();
        $request = (array)json_decode($postdata);
        if(isset($request['oldpassword']) && isset($request['userId']) && isset($request['newpassword']) && isset($request['repassword'])){
            $oldpassword = $request['oldpassword'];
            $newpassword = $request['newpassword'];
            $repassword = $request['repassword'];
            $userId = $request['userId'];
            $error = $obj->checkUserCred($userId, $oldpassword);
            if($error==''){
                if(trim($newpassword)==trim($repassword)){
                    $error = $obj->changePassword($userId, $newpassword);
                }
            }
            echo json_encode(['error'=>$error]);
            exit();
        }else if(isset($request['forgotPassword'])){
            $email = $request['forgotPassword'];
            $otp = rand(100000, 999999);
            $res = $obj->updateUserOTP($email, $otp);
            if($res['error']==''){
                $res['error'] = sendEmail($email, $otp, $res['expiry']);
            }
            echo json_encode($res);
            exit();
        }else if(isset($request['verifyotp']) && isset($request['email'])){
            $otp = $request['verifyotp'];
            $email = $request['email'];
            $res = $obj->verifyOTP($otp, $email);
            echo json_encode($res);
            exit();
        }else if(isset($request["otp"]) && isset($request["email"]) && isset($request["newpassword"]) && isset($request["repassword"])){
            $otp = $request["otp"];
            $email =$request["email"];
            $newpassword = $request["newpassword"];
            $repassword = $request["repassword"];
            $error = $obj->updatePasswordByOTP($otp, $email, $newpassword, $repassword);
            echo json_encode(['error'=>$error]);
            exit();
        }
    }

    function sendEmail($email, $otp, $expiry){
        require("../phpmailer/PHPMailerAutoload.php");
        require("../phpmailer/config.php");
        require_once("../phpmailer/mail.php");
        $error = '';

        $body = "
        <div style='margin:5px'>
            <h1>Reset Your Password With OTP</h1><br>
            <strong><h2 style='letter-spacing:3px'>$otp</h2></strong><br>
            <h4 style='color:red'><i>OTP valid till $expiry </i></h4>
        </div>
        ";

        $res = sendmail($email, 'Reset Password', $body);

        if($res['isError']){
            $error = $res['message'];
        }
        return $error;
    }
?>