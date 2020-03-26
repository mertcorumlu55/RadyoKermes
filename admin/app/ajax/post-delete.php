<?php
include("../../../inc/loader.php");

if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/admin/posts/list"){
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

if(!$_POST || empty(post("post_id")) ) {
    http_response_code(400);
    exit;
}

//DO SQL JOBS
$return = array(
    "error" => true,
    "message" => ""
);

$post_id = post("post_id");


try {

    $sql->beginTransaction();
    $sql->query("DELETE FROM `posts` WHERE `post_id` = '{$post_id}' ");


    //NO ERROR HANDLED, SUCCESFULL
    $sql->commit();
    $return = array(
        "error" => false,
        "message" => $auth->__lang("post_deleted")
    );
    return_error($return);


} catch (PDOException $e) {
    $return["message"] = $e->errorInfo[2];
    $sql->rollBack();
    return_error($return);
}


exit;

