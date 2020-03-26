<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */
include("../../../inc/loader.php");
if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/admin/settings"){
    http_response_code(400);
    include "../pages/404.php";
    exit;
}

if(!$_POST){

    http_response_code(400);
    exit;

}

if (!$auth->isLogged()) {
    http_response_code(403);
    exit;
}

$userInfo = $auth->getCurrentUser();
if(!is_authorized($userInfo["authority"], array("Admin"))){
    http_response_code(403);
    exit;
}


    $return = array(
        "error" => true,
        "message" => ""
    );


    try {

        $sql->beginTransaction();

        $updateArray = array();

        $updateArray["site_url"] = post("site_url");
        $updateArray["site_name"] = post("site_name");
        $updateArray["site_title"] = post("site_title");
        $updateArray["site_email"] = post("site_email");
        $updateArray["site_reply_email"] = post("site_reply_email");
        $updateArray["smtp_status"] = !empty(post("smtp_status")) ? 1 : 0;
        $updateArray["smtp_debug"] = post("smtp_debug");
        $updateArray["smtp_host"] = post("smtp_host");
        $updateArray["smtp_port"] = post("smtp_port");
        $updateArray["smtp_security"] = post("smtp_security");
        $updateArray["smtp_auth"] = !empty(post("smtp_status"))  ? (!empty(post("smtp_auth")) ? 1 : 0)  : "";
        $updateArray["smtp_username"] = post("smtp_username");
        $updateArray["smtp_password"] = post("smtp_password");
        $updateArray["recaptcha_enabled"] = !empty(post("recaptcha_enabled")) ? 1 : 0;
        $updateArray["recaptcha_site_key"] = post("recaptcha_site_key");
        $updateArray["recaptcha_secret_key"] = post("recaptcha_secret_key");
        $updateArray["fb_app_id"] = post("fb_app_id");
        $updateArray["fb_app_secret"] = post("fb_app_secret");
        $updateArray["radio_server"] = post("radio_server");
        $updateArray["radio_port"] = post("radio_port");
        $updateArray["radio_passwordr"] = post("radio_password");
        $updateArray["ipgeolocation_apikey"] = post("ipgeolocation_apikey");



        foreach ( $updateArray as $key => $value) {

            if(strlen($value) != 0){
                $query = $sql->prepare("UPDATE `phpauth_config` SET `value` = :value WHERE `setting` = :setting ");
                $query->execute(array(
                    "setting" => $key,
                    "value" => $value
                ));

            }

        }

        //NO ERROR HANDLED, SUCCESFULL
        $sql->commit();
        $return = array(
            "error" => false,
            "message" => $auth->__lang("edit_settings_success")
        );
        return_error($return);


    } catch (PDOException $e) {
        $return["message"] = $e->errorInfo[2];
        $sql->rollBack();
        return_error($return);
    }
