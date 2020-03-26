<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 01:30
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$auth_config->site_title." | ".ucfirst($page_name)?></title>

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />

    <link rel="stylesheet" href="/admin/css/bootstrap.css">
    <link rel="stylesheet" href="/admin/css/bootstrap-formhelpers.css">

    <link rel="stylesheet" href="/admin/css/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/admin/css/Responsive-2.2.1/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="/admin/css/stylesheet.css"/>

    <script src="/admin/app/js/jquery-3.3.1.min.js"></script>
    <script src="/admin/app/js/bootstrap.bundle.min.js"></script>

    <?=$head."\n"?>
</head>
<?php
include("header.php");
?>
