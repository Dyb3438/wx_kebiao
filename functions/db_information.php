<?php
namespace dyb;

require_once __DIR__."/../config/wx.php";
require_once __DIR__."/../vendor/autoload.php";

use Workerman\MySQL\Connection;

class db_information
{
    function get_information($openid){
        $connection = new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");
        $information=$connection->select('*')->from("users")->where("openid=:openid")->bindValues(array("openid"=>$openid))->query();
        return $information;
    }
}