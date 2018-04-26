<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/wx.php";

use Workerman\MySQL\Connection;
class entry
{
    public $connection;
    function entry_kebiao($class,$xh){
        preg_match_all("/^\w{4}/",$xh,$year);
        $year=$year[0][0];
        $this->connection==new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_".$year."kebiao");
        $delete_monday=$this->connection->delete('monday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_tuesday=$this->connection->delete('tuesday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_wednesday=$this->connection->delete('wednesday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_thursday=$this->connection->delete('thursday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_friday=$this->connection->delete('friday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_saturday=$this->connection->delete('saturday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        $delete_sunday=$this->connection->delete('sunday')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
        foreach ($class as $key =>$value){
            switch ($value['day']){
                case "1":
                    $insert_monday=$this->insert('monday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "2":
                    $insert_tuesday=$this->insert('tuesday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "3":
                    $insert_wednesday=$this->insert('wednesday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "4":
                    $insert_thursday=$this->insert('thursday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "5":
                    $insert_friday=$this->insert('friday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "6":
                    $insert_saturday=$this->insert('saturday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
                case "7":
                    $insert_sunday=$this->insert('sunday')->cols(array('xh'=>$xh,'class'=>$value['class'],'classname'=>$value['classname'],'teacher'=>$value['teacher'],'classroom'=>$value['classroom'],'single_week'=>$value['single_week'],'weeklong'=>$value['long']))->query();
                    break;
            }
        }
    }
    function entry_information($information,$openid)
    {
        $this->connection=new Connection(DB_HOST, DB_PORT, DB_USER, DB_PW, "wx_user");
        $xh=$information['xuehao'];
        $select_openid=$this->connection->select('xh')->from('users')->where('openid=:openid')->bindValues(array("openid"=>$openid))->query();
        if($select_openid!=null&&$select_openid[0]['xh']!=null){
            $result="0";
            $msg="此微信账号已绑定学号，请取消绑定后重试";
        }else{
            $select_xh=$this->connection->select('xh')->from('users')->where('xh=:xh')->bindValues(array("xh"=>$xh))->query();
            if($select_xh!=null){
                $result="0";
                $msg="此学号已经绑定微信账号，请取消绑定后重试";
            }elseif($select_openid==null){
                $insert_openid=$this->connection->insert('users')->cols(array(
                    'openid'=>$openid,
                    'xh'=>$xh,
                    'name'=>$information['xingming'],
                    'classroom'=>$information['xingzhengban'],
                    'major'=>$information['zhuanye'],
                    'school'=>$information['xueyuan'],
                    'college'=>"华南理工大学"
                ))->query();
                if($insert_openid){
                    $result="1";
                }else{
                    $result="0";
                    $msg="录入出错啦";
                }
            }else{
                $update_openid=$this->connection->update('users')->cols(array(
                    'xh'=>$xh,
                    'name'=>$information['xingming'],
                    'classroom'=>$information['xingzhengban'],
                    'major'=>$information['zhuanye'],
                    'school'=>$information['xueyuan'],
                    'college'=>"华南理工大学"
                ))->where('openid=:openid')->bindValues(array("openid"=>$openid))->query();
                if($update_openid){
                    $result="1";
                }else{
                    $result="0";
                    $msg="录入出错啦";
                }
            }
        }
        return array("result"=>$result,"msg"=>isset($msg)?$msg:"");
    }
}