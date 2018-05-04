<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;
class entry
{
    public $connection;
    function entry_kebiao($class,$xh,$school,$openid){
        if($xh!=null) {
            preg_match_all("/^\w{4}/", $xh, $year);
            $year = $year[0][0];
            $this->check_db($year);
        }else{
            $this->connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_otherkebiao");
            $xh=$openid;
        }
        $delete_monday=$this->connection->delete('monday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_tuesday=$this->connection->delete('tuesday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_wednesday=$this->connection->delete('wednesday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_thursday=$this->connection->delete('thursday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_friday=$this->connection->delete('friday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_saturday=$this->connection->delete('saturday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        $delete_sunday=$this->connection->delete('sunday')->where('xh=:xh and school=:school')->bindValues(array("xh"=>$xh,"school"=>$school))->query();
        foreach ($class as $key =>$value){
            switch ($value['day']){
                case "1":
                    $insert_monday=$this->connection->insert('monday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "2":
                    $insert_tuesday=$this->connection->insert('tuesday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "3":
                    $insert_wednesday=$this->connection->insert('wednesday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "4":
                    $insert_thursday=$this->connection->insert('thursday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "5":
                    $insert_friday=$this->connection->insert('friday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "6":
                    $insert_saturday=$this->connection->insert('saturday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
                case "7":
                    $insert_sunday=$this->connection->insert('sunday')->cols(array('xh'=>$xh,'class'=>implode(",", $value['class']),'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>implode(",", $value['long']),"school"=>$school))->query();
                    break;
            }
        }
    }
    function entry_information($xh,$name,$classroom,$major,$school,$college,$openid)
    {
            $this->connection = new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");
            $select_openid = $this->connection->select('xh')->from('users')->where('openid=:openid')->bindValues(array("openid" => $openid))->query();
            if ($select_openid != null && $select_openid[0]['xh'] != null) {
                $result = "0";
                $msg = "此微信账号已绑定学号，请取消绑定后重试";
            } else {
                $select_xh = $this->connection->select('xh')->from('users')->where('xh=:xh and college=:college')->bindValues(array("xh" => $xh, "college" => $college))->query();
                if ($select_xh != null) {
                    $result = "0";
                    $msg = "此学号已经绑定微信账号，请取消绑定后重试";
                } elseif ($select_openid == null) {
                    $insert_openid = $this->connection->insert('users')->cols(array(
                        'openid' => $openid,
                        'xh' => $xh,
                        'name' => $name,
                        'classroom' => $classroom,
                        'major' => $major,
                        'school' => $school,
                        'college' => $college
                    ))->query();
                    if ($insert_openid) {
                        $result = "1";
                    } else {
                        $result = "0";
                        $msg = "录入出错啦";
                    }
                } else {
                    $update_openid = $this->connection->update('users')->cols(array(
                        'xh' => $xh,
                        'name' => $name,
                        'classroom' => $classroom,
                        'major' => $major,
                        'school' => $school,
                        'college' => $college
                    ))->where('openid=:openid')->bindValues(array("openid" => $openid))->query();
                    if ($update_openid) {
                        $result = "1";
                    } else {
                        $result = "0";
                        $msg = "录入出错啦";
                    }
                }
            }
        return array("result"=>$result,"msg"=>isset($msg)?$msg:"");
    }
    function check_db($year){
        $this->connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "mysql");
        $this->connection->query("CREATE DATABASE IF NOT EXISTS wx_".$year."kebiao");
        $this->connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_".$year."kebiao");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `monday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `tuesday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `wednesday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `thursday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `friday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `saturday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `sunday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  `school` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }
}