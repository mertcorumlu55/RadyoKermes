<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 12/05/2018
 * Time: 11:36
 */

include("../../../../inc/loader.php");
$auth->logout(@$_COOKIE[$auth->config->cookie_name]);
setcookie($auth->config->cookie_name,"",-1,$auth->config->cookie_path );
redirect("/login");