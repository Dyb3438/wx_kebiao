<?php
namespace dyb;

//error_reporting(E_ALL^E_NOTICE^E_WARNING);

require_once __DIR__ . "/../vendor/autoload.php";

use dyb\curl;

$curl=new curl();

$url = $curl->url();
$root=$curl->curl($url);
//取教务网与验证码绑定的随机数
preg_match("/<a href='\/(.*)\/default2.aspx'>/", $root, $arr);
$img=$curl->login_curl("http://$url/$arr[1]/CheckCode.aspx",$url."/".$arr[1]);
$img = base64_encode($img);
$picture="data:image/gif;base64,".$img;
echo json_encode(array("picture"=>$picture,"rnd"=>$url."/".$arr[1]));
