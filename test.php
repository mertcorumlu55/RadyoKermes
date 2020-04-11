<?php
include "inc/loader.php";
error_reporting(1);
/*try{
    $dbh = $sql->query("SELECT * FROM `chat_log`");
    $msgs = $dbh->fetchAll();
    var_dump($msgs);
}catch(PDOException $e){
    echo $e->getMessage();
}*/

$dbh = $sql;
$sql = null;
try{
    $sql = $dbh->query("SELECT * FROM `chat_log`");
    $msgs = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach($msgs as $key => $value){
        if($value["with_img"] == "1"){
            $sql1 = $dbh->query("SELECT * FROM `chat_images` WHERE message_id=".$value["id"]);
            $imgs = $sql1->fetchAll();
            $images_array = array();
            foreach ( $imgs as $value1){
                array_push($images_array,$value1["name"]);
            }
            $msgs[$key]["images"] = $images_array;
        }
    }
   print_r($msgs);
}catch (PDOException $e){
    return null;
}
