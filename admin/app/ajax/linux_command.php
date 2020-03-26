<?php
include("../../../inc/loader.php");

    /*if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/admin/"){
        http_response_code(400);
        exit;
    }*/

    /*if(!@$_GET || !isset($_GET["action"])){
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
    }*/

    $sh = "";
    switch(get("action")){

        case "server_start":
            $sh = "sh /root/shoutcast start";
            break;

        case "server_stop":
            $sh = "sh /root/shoutcast stop";
            break;

        case "server_restart":
            $sh = "sh /root/shoutcast restart";
            break;

        default:
            http_response_code(400);
            exit;
            break;
    }


    header("Content-Type: application/json");
    print(shell_exec("sudo ".$sh));




