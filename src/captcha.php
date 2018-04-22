<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
function curl($url,$cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
$cookie = tempnam('./temp', 'cookie');
$img = curl("http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/CheckCode.aspx",$cookie);
$img = base64_encode($img);
$picture="data:image/gif;base64,".$img;
echo json_encode(array("picture"=>$picture,"cookie"=>$cookie));
