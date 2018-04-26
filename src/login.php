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
$openid=$arr['openid'];
$find_openid=$connection->select('*')->from("users")->where("openid=:openid")->bindValues(array("openid"=>$openid))->query();
if($find_openid==null){
    $add_openid=$connection->insert('users')->cols(array(
        'openid'=>$openid
    ))->query;
}
//session会话中存放openid、session_key和学号
session_start();
$_SESSION['openid']=$arr['openid'];
$_SESSION['session_key']=$arr['session_key'];
$_SESSION['xh']=isset($find_openid[0]['xh'])?$find_openid:"";

$return=array(
    "xuehao"=>isset($find_openid[0]['xh'])?$find_openid[0]['xh']:"",
    "name"=>isset($find_openid[0]['name'])?$find_openid[0]['name']:"",
    "classroom"=>isset($find_openid[0]['classroom'])?$find_openid[0]['classroom']:"",
    "major"=>isset($find_openid[0]['major'])?$find_openid[0]['major']:"",
    "school"=>isset($find_openid[0]['school'])?$find_openid[0]['school']:"",
    "college"=>isset($find_openid[0]['college'])?$find_openid[0]['college']:""
        );
echo json_encode(array("sessionid"=>session_id(),"information"=>$return));
