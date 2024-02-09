<?php

//Stop Direct Access to the File

//Works only in PHP 5.0 and Up

if (get_included_files()[0] == __FILE__) {
    http_response_code(403);

    die('Forbidden');
}

//Stop Including This File Twice

if (defined(strtoupper(basename(__FILE__, '.php')) . '_PHP')) {
    return true;
}

define(strtoupper(basename(__FILE__, '.php')) . '_PHP', true);

include_once 'main.php';

$weburl = "https://$socketurl";

$SecretKey = 'S0r3n@DEV';

//Send POST Data to web url

//Data will contain event name and event data

//Also send Header Secret Key to verify that the request is from the server

function sendUser($userId, $event, $data)
{
    global $SecretKey;

    global $weburl;

    $weburl = 'http://147.135.254.149:3000';

    $data = json_encode(['event' => $event, 'data' => $data]);

    $ch = curl_init("$weburl/send/$userId");

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',

        'SecretKey: ' . $SecretKey,
    ]);

    $result = curl_exec($ch);

    curl_close($ch);

    return json_decode($result, true);
}

function sendAll($event, $data)
{
    sendUser('all', $event, $data);
}

function sendChatMessage(
    $userId,
    $senderName,
    $message,
    $senderRank = 0,
    $thumbnail = null,
    $senderId = 0
) {
    if (strtoupper($senderName) == 'SERVER') {
        $senderId = null;

        $thumbnail = null;

        $senderName = 'SERVER';

        $senderRank = 3;
    }

    if (!$thumbnail) {
        $thumbnail = 'https://i.postimg.cc/Y90d6cqk/temp-Imageb-NTLrh.jpg';
    }

    if (!$senderId) {
        $senderId = 0;
    }

    if (!$senderRank) {
        $senderRank = 0;
    }

    sendUser($userId, 'chat message', [
        'userid' => $senderId,
        'rank' => $senderRank,
        'displayname' => $senderName,
        'thumbnail' => $thumbnail,
        'message' => $message,
    ]);
}

?>
