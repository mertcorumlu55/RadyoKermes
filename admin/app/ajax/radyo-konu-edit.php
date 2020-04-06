<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */
include("../../../inc/loader.php");

if(!$_POST || !isset($_POST["radyo_konu"])){
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

        if(strlen(post("radyo_konu")) != 0){
            $query = $sql->prepare("UPDATE `phpauth_config` SET `value` = :value WHERE `setting` = 'radyo_konu' ");
            $query->execute(array(
                "value" => post("radyo_konu")
            ));
        }else{
            http_response_code(403);
            exit;
        }



    //NO ERROR HANDLED, SUCCESFULL
    $sql->commit();
    $return = array(
        "error" => false
    );
    return_error($return);


} catch (PDOException $e) {
    $return["message"] = $e->errorInfo[2];
    $sql->rollBack();
    return_error($return);
}
