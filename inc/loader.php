<?php
//IMPORT CONFIG
require_once("config.php");

//INIT SQL CONNECTION
try{

    $sql = new PDO("mysql:host=".SQL_Host.";dbname=".SQL_Database.";charset=UTF8", SQL_Username, SQL_Password);
    $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $e){
    http_response_code(503);
    die('<h1>Database Connection Failed<h1/>'.$e->getMessage());
}

/*LOAD CLASSES*/

//PHPMailer
include("class/PHPMailer/src/PHPMailer.php");
include("class/PHPMailer/src/Exception.php");
include("class/PHPMailer/src/SMTP.php");
include("class/PHPMailer/src/OAuth.php");
include("class/PHPMailer/src/POP3.php");

//Zxcvbn
include("class/Zxcvbn/Matchers/MatchInterface.php");
include("class/Zxcvbn/Matchers/Match.php");
include("class/Zxcvbn/Matchers/DigitMatch.php");
include("class/Zxcvbn/Matchers/Bruteforce.php");
include("class/Zxcvbn/Matchers/YearMatch.php");
include("class/Zxcvbn/Matchers/SpatialMatch.php");
include("class/Zxcvbn/Matchers/SequenceMatch.php");
include("class/Zxcvbn/Matchers/RepeatMatch.php");
include("class/Zxcvbn/Matchers/DictionaryMatch.php");
include("class/Zxcvbn/Matchers/L33tMatch.php");
include("class/Zxcvbn/Matchers/DateMatch.php");
include("class/Zxcvbn/Matcher.php");
include("class/Zxcvbn/Searcher.php");
include("class/Zxcvbn/ScorerInterface.php");
include("class/Zxcvbn/Scorer.php");
include("class/Zxcvbn/Zxcvbn.php");

//PHPAuth
include("class/PHPAuth/Config.php");
include("class/PHPAuth/Auth.php");

//INIT PHPAuth
    $auth_config = new PHPAuth\Config($sql, null, "", "tr_TR");
    $auth = new PHPAuth\Auth($sql,$auth_config);


//IMPORT FUCNTIONS
require_once("functions.php");

//SET TIMEZONE
date_default_timezone_set($auth_config->site_timezone);


