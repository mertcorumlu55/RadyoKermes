<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 11/05/2018
 * Time: 18:20
 */

//INCLUDE THE ACTION OF USERS
switch (get("subpage")){

    case  "list":
        include 'posts/list.php';
        break;

    case "answer":
        include 'posts/answer.php';
        break;

    default:
        redirect("/admin/posts/list");
        exit;
        break;
}
?>
