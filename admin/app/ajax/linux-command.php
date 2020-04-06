<?php
include("../../../inc/loader.php");


    if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/admin/"){
        http_response_code(400);
        exit;
    }

    if(!@$_GET || !isset($_GET["action"])){
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

    $sh = "";
    switch(get("action")){

        case "radio_server_start":
            $sh = "radio_server start";
            break;

        case "radio_server_stop":
            $sh = "radio_server stop";
            break;

        case "radio_server_restart":
            $sh = "radio_server restart";
            break;

        case "autodj_start":
            $sh = "autodj start";
            break;

        case "autodj_stop":
            $sh = "autodj stop";
            break;

        case "autodj_restart":
            $sh = "autodj restart";
            break;

        case "chat_server_start":
            $sh = "php_chatserver start";
            break;

        case "chat_server_stop":
            $sh = "php_chatserver stop";
            break;

        case "chat_server_restart":
            $sh = "php_chatserver restart";
            break;

        case "check_radio_server":
            $sh = "check_server radio_server";
            break;

        case "check_autodj":
            $sh = "check_autodj";
            break;

        case "check_servers":
            header("Content-Type: application/json");
            $radio = shell_exec("sudo check_server radio_server");
            $autodj = shell_exec("sudo check_server autodj");
            $chat_server = shell_exec("sudo check_server chat_server");
            print(json_encode(array(
                "radio_server" => json_decode($radio),
                "autodj" => json_decode($autodj),
                "chat_server" => json_decode($chat_server)
            )));
            exit;
            break;

        default:
            http_response_code(400);
            exit;
            break;
    }


    header("Content-Type: application/json");
    print(shell_exec("sudo ".$sh));




