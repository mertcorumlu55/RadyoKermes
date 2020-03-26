<?php

$page_name = get("page");
$head = "";
$footer = "";

switch ($page_name){

    //Ordinary Pages
    case "":
        $page_name = "home";
        break;

    case "posts":
        $head = "<link rel=\"stylesheet\" href=\"/app/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/app/js/popup.js\"></script>
                   <script src=\"/app/js/jquery.fancybox.min.js\"></script>
                   <script src=\"/app/js/ellipsis.js\"></script>";
        break;

    case "users":
        $head = "<link rel=\"stylesheet\" href=\"/app/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/app/js/popup.js\"></script>
                   <script src=\"/app/js/jquery.fancybox.min.js\"></script>";
        break;

    case "settings":
        break;

    //Ordinary Pages

    //Exceptional Pages
    case "login":

        if(!$auth->isLogged()){
            include ("pages/login.php");
        }else{
            redirect("/");
        }

        exit;

    default:
        include ("pages/404.php");
        exit;
}

check_login($auth);
//RETRIEVE USER INFO
$userInfo = $auth->getCurrentUser();
if(!is_authorized($userInfo["authority"], array("Admin", "Moderator"))){
    include ("pages/403.php");
    exit;
}

include("pages/static/head.php");

include("pages/{$page_name}.php");

include("pages/static/footer.php");