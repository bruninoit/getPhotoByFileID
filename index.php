<?php
function rip($msg)
{
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    echo $msg;
    die;
}
$gz = false;
$de = false;

/*
if (preg_match("|googlebot|telegrambot|i", $_SERVER["HTTP_USER_AGENT"])) {
    $de = true;
} else
*/
if (preg_match("|deflate|i", $_SERVER["HTTP_ACCEPT_ENCODING"])) {
    $de = true;
} elseif (preg_match("|deflate|i", $_SERVER["HTTP_ACCEPT_ENCODING"])) {
    $gz = true;
}

if(!empty($_GET["file_id"])) {
    $fileid = $_GET["file_id"];
} else {
    http_response_code(500);
    rip("<html><body><h1>NO FILE ID</h1></body></html>");
}

if (file_exists("token.php")) {
    require "token.php";
} elseif (!empty($_GET["api"])) {
    $api = $_GET["api"];
} else {
    http_response_code(500);
    rip("<html><body><h1>NO BOT TOKEN</h1></body></html>");
}

$rr = file_get_contents("https://api.telegram.org/$api/getfile?file_id=$fileid");
$ar = json_decode($rr, true);
unset($rr);
if (!$ar["ok"]) {
    http_response_code(502);
    rip("<html><body><h1>BOTAPI ERROR</h1><br><p>".$ar["description"]."</p></body></html>");
}
$filepath = $ar["result"]["file_path"];
unset($ar);
if (!preg_match("#photos#i", $filepath)) {
    http_response_code(405);
    rip("<html><body><h1>NOT ALLOWED</h1><br><p>ONLY IMAGES FILE</p></body></html>");
}

$url = "http://api.telegram.org/file/$api/$filepath";
$imgstring = file_get_contents($url);

$imginfo = getimagesizefromstring($imgstring);
header("Content-type: {$imginfo['mime']}");
header("Cache-Control: max-age=31536000");
if ($de) {
    error_log("DEFLATE");
    header("Content-Encoding: deflate");
    echo gzdeflate($imgstring);
} elseif ($gz) {
    error_log("GZIP");
    header("Content-Encoding: gzip");
    echo gzencode($imgstring);
} else {
    echo $imgstring;
}
