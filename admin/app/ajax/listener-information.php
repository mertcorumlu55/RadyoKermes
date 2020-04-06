<?php
include("../../../inc/loader.php");
include("../../../inc/class/UserAgentParser.php");
error_reporting(0);

if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/admin/"){
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

if(!@$_GET || !isset($_GET["online"])){
    http_response_code(400);
    exit;
}
    $online = $_GET["online"];

    $serverAdress = "http://".$auth_config->radio_server.":".$auth_config->radio_port."/admin/listclients?mount=".($online? "/live" : "/autodj");

    $auth = base64_encode("admin:{$auth_config->radio_password}");
    $context = stream_context_create([
        "http" => [
            "header" => "Authorization: Basic $auth"
        ]
    ]);
    $listener = file_get_contents($serverAdress, false, $context );

    if(!$listener){
        header("Content-Type: application/json");
        print(json_encode(array("error" => 1, "type" => "no_stream")));
        exit;
    }

    $listenerData = simplexml_load_string($listener)->source->listener;
    $return = array();

    foreach ($listenerData as $d => $data){
        $ip=$data->IP->__toString();
        $useragent=$data->UserAgent->__toString();

        $ipInfo = get_geolocation($ip);
        $browserInfo = parse_user_agent($useragent);
        array_push($return,array(
            "ip" => $ip,
            "country" => $ipInfo["countryCode"],
            "useragent" => $browserInfo["browser"]."/".$browserInfo["platform"],
            "latitude" => $ipInfo["lat"],
            "longitude" => $ipInfo["lon"]
        ));

    }

    header("Content-Type: application/json");
    print(json_encode($return));


function get_geolocation($ip) {

    $url = "http://ip-api.com/json/{$ip}?fields=49346";
    return json_decode(file_get_contents($url), true);
}
