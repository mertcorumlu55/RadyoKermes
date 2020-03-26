<?php
include("../../../inc/loader.php");
include("../../../inc/class/UserAgentParser.php");


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


    $serverAdress = "http://".$auth_config->radio_server.":".$auth_config->radio_port."/admin.cgi?sid=1&mode=viewjson&page=3";


    $auth = base64_encode("admin:admin@123");
    $context = stream_context_create([
        "http" => [
            "header" => "Authorization: Basic $auth"
        ]
    ]);
    $listenerData = json_decode(file_get_contents($serverAdress, false, $context ), true);

    $return = array();
    foreach ($listenerData as $data){

        $ipInfo = get_geolocation($auth_config->ipgeolocation_apikey,$data["hostname"]);
        $browserInfo = parse_user_agent($data["useragent"]);
        array_push($return,array(
            "ip" => $data["hostname"],
            "country" => $ipInfo["countryCode"],
            "useragent" => $browserInfo["browser"]."/".$browserInfo["platform"],
            "latitude" => $ipInfo["lat"],
            "longitude" => $ipInfo["lon"]
        ));

    }

    header("Content-Type: application/json");
    print(json_encode($return));


function get_geolocation($apiKey, $ip) {
    //$url = "http://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip;
    $url = "http://ip-api.com/json/{$ip}?fields=49346";
    return json_decode(file_get_contents($url), true);
}
