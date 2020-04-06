<?php

$page_name = get("page");
$head = "";
$footer = "";

switch ($page_name){

    //Ordinary Pages
    case "":
        $page_name = "home";
        $head = "<link rel=\"stylesheet\" href=\"/admin/app/css/jquery-jvectormap-2.0.5.css\">
                 <link rel=\"stylesheet\" href=\"/css/chat.css\">
                 <link rel=\"stylesheet\" href=\"/admin/app/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/admin/app/js/dashboard.js\"></script>
<script src=\"/admin/app/js/jquery-jvectormap-2.0.5.min.js\"></script>
<script src=\"/admin/app/js/jquery-jvectormap-world-merc.js\"></script>
<script src=\"/admin/app/js/jquery.fancybox.min.js\"></script>
<script src=\"http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js\"></script>
<script src=\"/js/ws.js\"></script>
<script src=\"/js/chat.js\"></script>";
        break;

    case "posts":
        $head = "<link rel=\"stylesheet\" href=\"/admin/app/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/admin/app/js/popup.js\"></script>
                   <script src=\"/admin/app/js/jquery.fancybox.min.js\"></script>
                   <script src=\"/admin/app/js/ellipsis.js\"></script>";
        break;

    case "users":
        $head = "<link rel=\"stylesheet\" href=\"/admin/app/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/admin/app/js/popup.js\"></script>
                   <script src=\"/admin/app/js/jquery.fancybox.min.js\"></script>";
        break;

    case "settings":
        break;

    //Ordinary Pages

    //Exceptional Pages
    case "login":

        if(!$auth->isLogged()){
            include ("pages/login.php");
        }else{
            redirect("/admin");
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
