<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;
$connection = new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");

$name=$_POST['name'];
$classroom=$_POST['classroom'];
$major=$_POST['major'];
$school=$_POST['school'];
session_start();
$openid=$_SESSION['openid'];
if($openid!=null){
    $select_openid=$connection->select('openid')->from('users')->where("openid=:openid")->bindValues(array("openid"=>$openid))->query();
    if($select_openid!=null){
        $update_openid=$connection->update('users')->cols(array("name"=>$name,"classroom"=>$classroom,"major"=>$major,"school"=>$school))->where('openid=:openid')->bindValues(array('openid'=>$openid))->query();
        if($update_openid){
            $result="1";
            $msg="修改成功";
        }else{
            $result="0";
            $msg="修改出错";
        }
    }else{
        $result="0";
        $msg="未绑定学号，请先绑定"
    }
}else{
    $result="0";
    $msg="请先微信授权";
}
echo json_encode(array('result'=>$result,"msg"=>$msg));


