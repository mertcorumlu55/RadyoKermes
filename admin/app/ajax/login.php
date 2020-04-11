<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:56
 */

//LOAD APP
include("../../../inc/loader.php");

//SET RETURN ARRAY
$return=array(
    "error"=>true,
    "message"=>""
);

//CHECK IF USER IS ALREADY LOGGED IN
if($auth->isLogged()){
    $return["message"]="User Already Logged In.";
    return_error($return);
}

//CHECK REQUEST PARAMETERS
if(post("user_email")=="" || post("user_password")=="" ){
    $return["message"]="Email Or Password Cannot Be Empty";
    return_error($return);
}

//CHECK CAPTCHA
if($auth->isBlocked() == "verify"){
    if(empty(post("g-recaptcha-response"))){
        $return["message"]=$auth->__lang('user_verify_failed');
        return_error($return);
    }
}

//MAKE LOGIN WITH PHPAUTH
$return = $auth->login(post("user_email"),post("user_password"),(bool) (post("remember_me") == "1" ? 1 : 0),  post("g-recaptcha-response"));

//SEND JS CAPTCHA STATUS
$return["captcha"] = $auth->isBlocked();

//HANDLE LOGIN ERRORS
if($return["error"]==true){
    return_error($return);
}

//IF EVERYTHING WENT RIGHT,INFORM USER
//JUST HIDE UNNECESSARY INFORMATION
unset($return["hash"]);
unset($return["expire"]);
unset($return["cookie_name"]);
return_error($return);





