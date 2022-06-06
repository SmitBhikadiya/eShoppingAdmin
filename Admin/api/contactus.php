<?php
    require_once("../handler/contactusHandler.php");
    require_once("../handler/adminuserHandler.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $objH =new ContactUsHandler();
        $request = json_decode($postdata);
        if(isset($request->contactus) && isset($request->name) && isset($request->email) && isset($request->subject) && isset($request->message)){
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $message = $request->message;
            $error = $objH->addContactUs($name, $email, $subject, $message);
            if($error==''){
                $adminH = new AdminUser();
                $admin_emails = $adminH->getAdminEmails();
                $error = sendEmailsToAdmin($admin_emails, $name, $email, $subject, $message);
            }
            echo json_encode(["error"=>$error]);
            exit();
        }else{
            http_response_code(404);
        }
    }

    function sendEmailsToAdmin($adminemails, $name, $email, $subject, $message){
        require("../phpmailer/PHPMailerAutoload.php");
        require("../phpmailer/config.php");
        require_once("../phpmailer/mail.php");
        $error = '';
    
        $body = "
           <div style='padding:10px; max-width: 55%; min-height: 200px;'>
                <div style='background-color:#f62626;padding: 6px;border-radius: 2px;color: white;'>
                    <h2 style='text-align:center; margin:0px; font-weight:200'>$subject &nbsp; <span style='font-size:0.9rem'>($name)</span></h2>
                </div>
                <div style='padding-top:5px;padding-bottom:5px; border-bottom:2px solid #f62626'>
                    <h4>
                        <p>
                            $message
                        </p>
                    </h4>
                </div>
           </div>
        ";
    
        $res = sendmail($adminemails, 'ContactUs: '.$subject, $body);
    
        if($res['isError']){
            $error = $res['message'];
        }
        return $error;
    }

?>

