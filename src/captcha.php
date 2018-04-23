<?php
namespace dyb;

error_reporting(E_ALL^E_NOTICE^E_WARNING);

require_once __DIR__ . "/../vendor/autoload.php";

use dyb\curl;

$curl=new curl();

$root = $curl->curl("http://110.65.10.240");
//取教务网与验证码绑定的随机数
preg_match("/<a href='\/(.*)\/default2.aspx'>/", $root, $arr);
$img=$curl->login_curl("http://110.65.10.240/$arr[1]/CheckCode.aspx",$arr[1]);
$img = base64_encode($img);
$picture="data:image/gif;base64,".$img;
echo json_encode(array("picture"=>$picture,"rnd"=>$arr[1]));
