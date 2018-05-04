<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;

$connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");

$xh=$_POST['xh'];
$college=$_POST['college'];

session_start();
$openid=$_SESSION['openid'];
if($openid!=null) {
    if($college!="华南理工大学"&&$college!="华工") {
        $select_openid = $connection->select('*')->from('users')->where('openid=:openid')->bindValues(array("openid" => $openid))->query();
        if ($select_openid != null) {
            $result = "0";
            $msg = "此微信账号已绑定学号，请取消绑定后重试";
        } else {
            if ($xh != null) {
                $select_xh = $connection->select('xh')->from('users')->where('xh=:xh and college=:college')->bindValues(array("xh" => $xh, "college" => $college))->query();
                if ($select_xh != null) {
                    $result = "0";
                    $msg = "此学号已经绑定微信账号，请取消绑定后重试";
                } elseif ($select_openid == null) {
                    $insert_openid = $connection->insert('users')->cols(array(
                        'openid' => $openid,
                        'xh' => $xh,
                        'college' => $college
                    ))->query();
                    if ($insert_openid) {
                        $result = "1";
                    } else {
                        $result = "0";
                        $msg = "录入出错啦";
                    }
                }
            } else {
                $insert_openid = $connection->insert('users')->cols(array(
                    'openid' => $openid,
                    'college' => $college
                ))->query();
                if ($insert_openid) {
                    $result = "1";
                } else {
                    $result = "0";
                    $msg = "录入出错啦";
                }
            }
        }
    }else{
        $result="0";
        $msg="华工学生请用教务绑定";
    }
}else{
    $result="0";
    $msg="请先微信授权";
}
echo json_encode(array("result"=>$result,"msg"=>$msg));

