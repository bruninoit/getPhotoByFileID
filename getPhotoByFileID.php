<?php

$file_id = "AgADBAADSqsxG6g9wVBn-QzYramyKfvc-RkABLLyAAFPsh2JTN2nAwABAg";  //change the file_id of the photo
$bot_token = "12345678:AAFp327kwmyYj9p1mldYIh4-Y5XweaQlAxs";   //a token of a casual bot

//getting file info with bot api
$getJsonPath = file_get_contents("https://api.telegram.org/bot" . $bot_token . "/getfile?file_id=" . $file_id);
$jsonPathArray = json_decode($getJsonPath, true);
$filePath = $jsonPathArray["result"]["file_path"];

$fileUrl = "http://api.telegram.org/file/bot" . $bot_token . "/" . $filePath;
$fileInfo = getimagesize($fileUrl);

//setting header
header("Content-type: {" . $fileInfo['mime'] . "}");

//show the image
readfile($urlo);

?>
