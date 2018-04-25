<?php
namespace dyb;

require_once __DIR__."/../config/wx.php";
require_once "../vendor/autoload.php";

use Workerman\MySQL\Connection;
$connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");

//获取openid和session_key
$code=$_GET['code'];
$url=LOGIN_ENTER."?appid=".APPID."&secret=".APPSECRET."&js_code=".$code."&grant_type=authorization_code";
$login=file_get_contents($url);
$result=json_decode($login);
$arr=get_object_vars($result);
//通过openid在数据库中寻找对应的xh







//session会话中存放openid、session_key和学号
session_start();
$_SESSION['openid']=$arr['openid'];
$_SESSION['session_key']=$arr['session_key'];
$_SESSION['xh']="";

