<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";

use dyb\entry;
use dyb\db_information;
$entry=new entry();
$db_information=new db_information();

$class_list=json_decode($_POST['class_list'],true);

session_start();
$openid=$_SESSION['openid'];
if($openid!=null) {
    $information = $db_information->get_information($openid);
    $entry->entry_kebiao($class_list, $information[0]['xh'], $information[0]['school'], $openid);
    echo json_encode(array("result"=>"1","msg"=>""));
}else{
    echo json_encode(array("result"=>"0","msg"=>"请先微信授权"));
}
