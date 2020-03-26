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
        include 'users/list.php';
        break;

    case "add":
        include 'users/add.php';
        break;

    default:
        redirect("/users/list");
        exit;
        break;
}
?>
