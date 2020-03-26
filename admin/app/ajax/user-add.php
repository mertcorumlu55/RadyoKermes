<?php

include("../../../../inc/loader.php");

    if(!$_POST){

    http_response_code(400);
    exit;

    }

    if(!$auth->isLogged()){
        http_response_code(403);
        exit;
    }

    $userInfo = $auth->getCurrentUser();
    if(!is_authorized($userInfo["authority"], array("Admin", "Moderator"))){
    http_response_code(403);
    exit;
}

    $return = array(
    "error" => true,
    "message" => ""
    );



    try{

        $sql->beginTransaction();

        $insertArray = array();

        $insertArray["full_name"] = post("user_full_name");
        $insertArray["telephone"] = post("user_telephone");
        $insertArray["authority"] = post("user_authority");
        $password = null;
        $sendActivationMail = null;
        $sendPasswordMail = false;

        if( empty(post("user_password")) ){
            $password = random_string(8);
            $sendActivationMail = 0;
            $sendPasswordMail = 1;
            //send mail here with activation
        }else{
            $password = post("user_password");

            if(post("user_send_mail") == 1){
                $sendActivationMail = 0;
                $sendPasswordMail = 1;
            }else{
                $sendActivationMail = 1;
            }

        }

        $return = $auth->register(post("user_email"), $password, $password, $insertArray, null, $sendActivationMail);

        //HANDLE REGISTER ERRORS
        if($return["error"]==true){
            $sql->rollback();
            return_error($return);
        }



        //SEND PASSWORD MAIL
        if($sendPasswordMail){

            $check = sendMail(
                $auth_config,
                post("user_email"),
                post("user_full_name"),
                $auth_config->password_mail_subject,
                    sprintf(
                        file_get_contents("../pages/static/PasswordMail.html"),
                        $auth_config->site_url,
                        $auth_config->site_url,
                        post("user_email"),
                        $password,
                        $auth_config->site_url,
                        $auth_config->site_reply_email,
                        $auth_config->site_reply_email

                    )

                );


            //IF MAIL NOT SENT
            if($check["error"] == true){
                $sql->rollback();
                $return = $check;
                return_error($return);
            }

        }



        //NO ERROR HANDLED, SUCCESFULL
        $sql->commit();
        $return = array(
            "error" => false,
            "message" => $auth->__lang("register_success")
        );
        return_error($return);


    }catch (PDOException $e){
        $return["message"] = $e->errorInfo[2];
        $sql->rollBack();
        return_error($return);
    }
