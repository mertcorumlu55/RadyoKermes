<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:49
 */
function filterUrl($a){
    return htmlspecialchars(trim($a));
}

function get($name){
    if(isset($_GET[$name])){

        if (is_array($_GET[$name])){
            return array_map(function($item){
                return filterUrl($item);
            }, $_GET[$name]);
        }

        return filterUrl($_GET[$name]);

    }
    return false;
}

function post($name){
    if(isset($_POST[$name])){

        if (is_array($_POST[$name])){
            return array_map(function($item){
                return filterUrl($item);
            }, $_POST[$name]);
        }

        return filterUrl($_POST[$name]);

    }
    return false;
}

function permalink($str, $options = array())
{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function return_error($return){
    header("Content-Type: application/json");
    echo json_encode($return);
    exit;
}

function check_login($auth){

    if(!$auth->isLogged()){
        redirect("/admin/login",true);
    }
}

function is_authorized($auth_level,$authorized_levels = array()){

    if(in_array($auth_level,$authorized_levels)){
        return true;
    }

    return false;
}

function redirect($url,$exit = false){
    echo "<script>location.href = '{$url}';</script>";
    if($exit){
        exit;
    }
}

function Redirect_Header($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

function random_string($a){
    $string = "abcdefghij0123456789klmnoprstuvwyzxwABCDE0123456789FGHIJKLMNOPRSTUWYZX0123456789";
    $return_string="";

    for($i=0;$i<$a;$i++){

        $return_string .= $string[rand(0,strlen($string)-1)];

    }

    return $return_string;
}

function percentage($pay,$payda){

    return @sprintf( "%01.2f",($pay / $payda)*100);

}

function sanitizeFileName($dangerousFilename, $platform = 'Linux')
{
    if (in_array(strtolower($platform), array('unix', 'linux'))) {
        // our list of "dangerous characters", add/remove
        // characters if necessary
        $dangerousCharacters = array(" ", '"', "'", "&", "/", "\\", "?", "#");
    } else {
        // no OS matched? return the original filename then...
        return $dangerousFilename;
    }

    // every forbidden character is replace by an underscore
    return tr_converter(str_replace($dangerousCharacters, '_', $dangerousFilename));
}

function tr_converter($uri) {
    $uri = str_replace ("ç","c",$uri);
    $uri = str_replace ("ğ","g",$uri);
    $uri = str_replace ("İ","I",$uri);
    $uri = str_replace ("ı","i",$uri);
    $uri = str_replace ("ş","s",$uri);
    $uri = str_replace ("ö","o",$uri);
    $uri = str_replace ("ü","u",$uri);
    $uri = str_replace ("Ü","U",$uri);
    $uri = str_replace ("Ç","c",$uri);
    $uri = str_replace ("Ğ","g",$uri);
    $uri = str_replace ("Ş","S",$uri);
    $uri = str_replace ("Ö","O",$uri);
    $uri = str_replace ("ç","c",$uri);
    return $uri;
}

function sendMail($auth_config,$sendEmail,$sendName,$subject,$body){
    $return = array(
        "error" => true,
        "message" => ""
    );

    try{


    $phpMailer = new PHPMailer;
    $phpMailer->CharSet = "UTF-8";

    if($auth_config->smtp){
        $phpMailer->SMTPDebug = $auth_config->smtp_debug;
        $phpMailer->isSMTP();
        $phpMailer->Host = $auth_config->smtp_host;
        $phpMailer->SMTPAuth = (int) $auth_config->smtp_auth;
        $phpMailer->Username = $auth_config->smtp_username;
        $phpMailer->Password = $auth_config->smtp_password;
        $phpMailer->Port = $auth_config->smtp_port;
        $phpMailer->SMTPSecure = $auth_config->smtp_security;
    }

    $phpMailer->From = $auth_config->site_email;
    $phpMailer->FromName = $auth_config->site_name;
    $phpMailer->addAddress($sendEmail,$sendName);
    $phpMailer->addReplyTo($auth_config->site_reply_email);
    $phpMailer->isHTML(true);

    $phpMailer->Subject = $subject;
    $phpMailer->Body = $body;
    $phpMailer->AltBody = strip_tags($body);

    if( !$phpMailer->send() ){
        $return["error"] = true;
        $return["message"] = "An Error Occured While Sending Email.";
        return $return;
    }


    //SUCCESFULL
    $return["error"] = false;
    $return["message"] = "Mail succesfully sent.";
    return $return;

    }catch (\PHPMailer\PHPMailer\Exception $e){
        $return["error"] = true;
        $return["message"] = $e->errorMessage();
        return $return;
    }

}



