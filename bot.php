<?php

require "token.php";
function curlRequest($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function sm($chat_id, $text)
{
    global $api;
    $args = [];
    if (empty($chat_id) || empty($text)) {
        return false;
    }
    $args['chat_id'] = $chat_id;
    $args['text'] = $text;
    curlRequest('https://api.telegram.org/'.$api.'/sendMessage', $args);
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);
unset($content);

if ($update['message']['photo']) {
    sm($update['message']['chat']['id'], "$baseUrl?file_id=".$update['message']['photo'][count($update['message']['photo'])-1]['file_id']);
} else {
    sm($update['message']['chat']['id'], "Mandami una foto");
}
