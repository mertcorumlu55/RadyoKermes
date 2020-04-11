<?php
include("../../../inc/loader.php");

if(!$_FILES) {
    http_response_code(400);
    exit;
}


    $return = array(
        "error" => true,
        "message" => ""
    );

    try{
        $sql->beginTransaction();
        $file = $_FILES["file"];
        $upload_dir = $_SERVER["DOCUMENT_ROOT"].$auth_config->chat_images_path;
        $img_name = pathinfo($file["name"], PATHINFO_FILENAME);
        $img_ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        if ($file["size"] > 5 * 1024 * 1024) {
            $sql->rollBack();
            $return["message"] = "Dosya boyutu çok yüksek";
            return_error($return);
        }

        if($img_ext != "jpg" && $img_ext != "png" && $img_ext != "jpeg") {
            $sql->rollBack();
            $return["message"] = "Dosya tipi desteklenmiyor";
            return_error($return);
        }

        if(!is_dir($upload_dir) && !is_writable($upload_dir)){
            $sql->rollBack();
            $return["message"] = "Yükleme dizini bulunamadı";
            return_error($return);
        }

        $img_uniqid = uniqid();
        $img_name = $img_uniqid."-".permalink($img_name).".".$img_ext;


        if(!move_uploaded_file($file["tmp_name"], $upload_dir."/".$img_name )){
            $sql->rollBack();
            $return["message"] = $file["error"];
            return_error($return);
        }

        $exec = $sql->prepare("INSERT INTO `chat_images` (`uniqid`, `name`) VALUES (:uniqid, :name)");
        $exec->execute(array(
            "uniqid" => $img_uniqid,
            "name" => $img_name
        ));


        $return["error"] = false;
        $return["message"] = "Başarıyla yüklendi";
        $return["file_path"] = $auth_config->chat_images_path."/".$img_name;
        $return["file_id"] = $sql->lastInsertId();
        $sql->commit();
        return_error($return);

    }catch(PDOException $e){
        $return["message"] = $e->getMessage();
        $sql->rollBack();
        return_error($return);
    }


