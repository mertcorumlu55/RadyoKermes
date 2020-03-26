<?php
error_reporting(0);
$status="http://radyokermes.com:8000/statistics?json=1";

    $fp=json_decode(file_get_contents($status));
    if(!$fp){
        $json["status"]="error";
        $json["message"]='Connection to Radio Status Failed: '.$status;

        echo json_encode($json);
        exit;
    }

    $data=$fp->streams[0];
    $json=array();
    $itunes=itunes_search($data->songtitle);
   // $spotify=spotify_t_search($data->songtitle);

    $json["listeners"]=$data->currentlisteners;
    $json["bitrate"]=$data->bitrate;
    $json["uptime"]=$data->streamuptime;
    $json["activeStreams"]=$fp->activestreams;
   if(!empty($itunes) || !empty($spotify) ){
       $json["artist"]=$itunes[0]["artistName"];
       $json["track"]=$itunes[0]["trackName"];
       $json["album"]=$itunes[0]["collectionName"];
       $json["album_img"]=$itunes[0]["artworkUrl100"];
       $json["itunes_url"]=$itunes[0]["trackViewUrl"];
       //$json["spotify_url"]=$spotify['tracks']['items'][0]['external_urls']['spotify'];

   }else{
       $json["result"]=$data->songtitle;

   }

   if(@$_GET["json"] == "1"){
       header("Content-Type: application/json");
       echo json_encode($json);
   }


    function itunes_search($a)
    {
        $term = urlencode($a); // user input 'term' in a form
        $fp = file_get_contents('http://itunes.apple.com/search?term=' . $term . '&limit=1');

        if(!$fp){
            $json["status"]="error";
            $json["message"]="ITunes API Connection Failed.";
            echo json_encode($json);
            exit;
        }
        $array = json_decode($fp, true);

        return $array["results"];

    }

    function spotify_t_search($a)
    {
	$term=urlencode($a);
    $fp = @file_get_contents('https://api.spotify.com/v1/search?q='.$term.'&type=track&limit=1');
        if(!$fp){
            $json["status"]="error";
            $json["message"]="Spotify API Connection Failed.";
            echo json_encode($json);
            exit;
        }
    $array = json_decode($fp, true);

    return $array;



}

?>





