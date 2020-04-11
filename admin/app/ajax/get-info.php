<?php
include("../../../inc/loader.php");

error_reporting(0);
$status="http://{$auth_config->radio_server}:{$auth_config->radio_port}/status-json.xsl";
$mounts_url="http://{$auth_config->radio_server}:{$auth_config->radio_port}/admin/listmounts";
$online = false;
$status_index = 0;

    $fp1=json_decode(file_get_contents($status));
    $fp2=file_get_contents($mounts_url,false,
        stream_context_create([
        "http" => [
            "header" => "Authorization: Basic ".base64_encode("admin:{$auth_config->radio_password}")
        ]
    ]));


    if(!$fp1 || !$fp2){
        $json["status"]="error";
        $json["message"]='Connection to Radio Status Failed: '.$status;
        echo json_encode($json);
        exit;
    }

    $mounts = array();
    $xml = simplexml_load_string($fp2);

    foreach ($xml->source as $mount) {
        foreach ($mount->attributes() as $a => $b) {
            array_push($mounts, $b);
        }
    }

    if(in_array("/live", $mounts)){
        $online = true;
        $status_index = 1;
    }

    $data = null;
    if(count($mounts) == 0){
        header("Content-Type: application/json");
        $json=array();
        $json["online"] = "0";
        $json["title"]= "-";
        $json["listeners"]= "-";
        echo json_encode($json);
        exit;
    }


        if(!is_array($fp1->icestats->source)){
            $data = $fp1->icestats->source;
        }else{
            $data=$fp1->icestats->source[$status_index];
        }



    $json=array();
    $json["online"] = (int) $online;
    $json["listeners"]=$data->listeners;
    $json["bitrate"]=$data->bitrate;
    $json["stream_start"]=$data->stream_start;

    if(!$online){
        $itunes=itunes_search($data->title);
        if($itunes["resultCount"] != 0 || !empty($spotify) ){
            $json["artist"]=$itunes["results"][0]["artistName"];
            $json["track"]=$itunes["results"][0]["trackName"];
            $json["album"]=$itunes["results"][0]["collectionName"];
            $json["album_img"]=$itunes["results"][0]["artworkUrl100"];
            $json["itunes_url"]=$itunes["results"][0]["trackViewUrl"];

        }else{
            $json["track"]=$data->songtitle;
        }
    }else{
        $json["title"] = "#".$auth_config->radyo_konu;
    }


   if(@$_GET["json"] == "1"){
       header("Content-Type: application/json");
       echo json_encode($json);
   }


    function itunes_search($a)
    {
        $term = urlencode($a); // user input 'term' in a form
        $fp1 = file_get_contents('http://itunes.apple.com/search?term=' . $term . '&limit=1');

        if(!$fp1){
            $json["status"]="error";
            $json["message"]="ITunes API Connection Failed.";
            echo json_encode($json);
            exit;
        }
        $array = json_decode($fp1, true);

        return $array;

    }

?>





