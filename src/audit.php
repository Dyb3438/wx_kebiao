<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;

$connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");

