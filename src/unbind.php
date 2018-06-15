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
    $select_openid = $connection->select('*')->from('users')->where('openid=:openid')->bindValues(array('openid' => $openid))->query();
    if ($select_openid === null) {
        $result="0";
        $msg="请先绑定";
    }else{
        $unbind_openid = $connection->delete('users')->where('openid=:openid')->bindValues(array('openid'=>$openid))->query();
        if($select_openid[0]['xh']!=null) {
            preg_match_all("/^(\w{4})/", $select_openid[0]['xh'], $year);
            $connection = new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_".$year[1][0]."kebiao");
            $xh=$select_openid[0]['xh'];
            $school=$select_openid[0]['college'];
        }else{
            $connection = new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_otherkebiao");
            $xh=$openid;
            $school=$select_openid[0]['college'];
        }
        $delete_monday=$connection->delete('monday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_tuesday=$connection->delete('tuesday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_wednesday=$connection->delete('wednesday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_thursday=$connection->delete('thursday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_friday=$connection->delete('friday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_saturday=$connection->delete('saturday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_sunday=$connection->delete('sunday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        if($unbind_openid){
            $result="1";
        }else{
            $result="0";
            $msg="数据库异常";
        }
    }
}
echo json_encode(array("result"=>$result,"msg"=>isset($msg)?$msg:""));