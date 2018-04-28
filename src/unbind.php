<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;

$connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");

session_start();
$openid=$_SESSION['openid'];
if($openid==null){
    $result="0";
    $msg="请先微信授权！";
}else {
    $select_openid = $connection->select('xh')->from('users')->where('openid=:openid')->bindValues(array('openid' => $openid))->query();
    if ($select_openid[0]['xh'] === null) {
        $result="0";
        $msg="请先绑定学号";
    }else{
        $unbind_openid = $connection->query("UPDATE `users` SET `xh`=NULL,`name`=NULL,`classroom`=NULL,`major`=NULL,`school`=NULL,`college`=NULL WHERE `openid`='$openid'");
        if($unbind_openid){
            $result="1";
        }else{
            $result="0";
            $msg="数据库异常";
        }
    }
}
echo json_encode(array("result"=>$result,"msg"=>isset($msg)?$msg:""));