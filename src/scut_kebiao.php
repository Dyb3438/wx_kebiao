<?php
namespace dyb;

error_reporting(E_ALL^E_NOTICE^E_WARNING);
session_start();

require_once __DIR__ . "/../vendor/autoload.php";

use dyb\data_restore;
use dyb\curl;
use dyb\kb_week;
use dyb\entry;
$data_restore=new data_restore();
$curl=new curl();
$week=new kb_week();
$entry=new entry();
//前端传来的数据
$xh = $_POST['xh'];
$pw=$_POST['pw'];
$code=$_POST['txtSecretCode'];
$rnd=$_POST['rnd'];
$do=$_POST['do'];//0: 绑定;1: 爬课表;2: 绑定且爬课表;

$_SESSION['xh'] =$xh;
//登录前获取隐藏字段
$default2 = $curl->login_curl("http://$rnd/default2.aspx",$rnd);
$hidden_pattern = '/<input type="hidden" name="__VIEWSTATE" value="([^"]+)" \/>/';
preg_match_all($hidden_pattern, $default2, $hidden_output);
$__VIEWSTATE = $hidden_output[1][0];
$post = array(
    "__VIEWSTATE" => $__VIEWSTATE,
    "txtUserName" => $xh,
    "TextBox2" => $pw,
    "txtSecretCode" => $code,
    "RadioButtonList1" => iconv('utf-8', 'gb2312', '学生'),
    "Button1" => iconv('utf-8', 'gb2312', '登录'),
    'lbLanguage' => "",
    "hidPdrs" => "",
    "hidsc" => ""
);
//登录获取正文
$index = $curl->login_curl("http://$rnd/default2.aspx",$rnd, $post);
//找出登录时的错误
$alert_error = "/alert\('([^']+)'\)/";
preg_match_all($alert_error, $index, $error);
if ($error[1] != null) {
    $error[1][0] = iconv('gb2312', 'utf-8', $error[1][0]);
}
//爬去学生名字
$xm_pattern = '/<span id="xhxm">([^<]+)<\/span>/';
preg_match_all($xm_pattern, $index, $xm);
if (isset($xm[1][0])){
    //进入课表页面
    $xm = substr($xm[1][0], 0, -4);
    $kebiao = $curl->login_curl("http://$rnd/xskbcx.aspx?xh=$xh&xm=$xm&gnmkdm=N121603",$rnd);
    if($do=="0"||$do=="2") {
        //取出信息栏
        $information_pattern = "/<span id=\"Label5\">(.+)<\/span>|<span id=\"Label6\">(.+)<\/span>|<span id=\"Label7\">(.+)<\/span>|<span id=\"Label8\">(.+)<\/span>|<span id=\"Label9\">(.+)<\/span>/";
        preg_match_all($information_pattern, $kebiao, $information);
        foreach ($information[0] as $key => $value) {
            $information[0][$key] = iconv("gb2312", "utf-8", $value);
        }
        preg_match_all("/学号：(.+)<\/span>/u", $information[0][0], $xuehao);
        $xuehao = $xuehao[1][0];
        preg_match_all("/姓名：(.+)<\/span>/u", $information[0][1], $xingming);
        $xingming = $xingming[1][0];
        preg_match_all("/学院：(.+)<\/span>/u", $information[0][2], $xueyuan);
        $xueyuan = $xueyuan[1][0];
        preg_match_all("/专业：(.+)<\/span>/u", $information[0][3], $zhuanye);
        $zhuanye = $zhuanye[1][0];
        preg_match_all("/行政班：(.+)<\/span>/u", $information[0][4], $xingzhengban);
        $xingzhengban = $xingzhengban[1][0];
        $information=array("xuehao"=>$xuehao,"xingming"=>$xingming,"xueyuan"=>$xueyuan,"zhuanye"=>$zhuanye,"xingzhengban"=>$xingzhengban);
        session_start();
        $openid=$_SESSION['openid'];
        if($openid==null){
            $result=array('msg'=>"请先微信授权，再绑定身份");
        }else {
            $result = $entry->entry_information($information['xuehao'],$information['xingming'],$information['xingzhengban'],$information['zhuanye'],$information['xueyuan'],"华南理工大学",$openid);
        }
    }
    if($do=="1"||$do=="2") {
        //爬取课表
        $table_pattern = "/<tr>[\s\S]+?<\/tr>/";
        preg_match_all($table_pattern, $kebiao, $table);
        $tbody = $table[0];
        $td_pattern = "/<td( align=\"([^\"]+)\")?( rowspan=\"([^\"]+)\")?( colspan=\"([^\"]+)\")?[^>]*>([\s\S]+?)<\/td>/";
        $content = array();
        foreach ($tbody as $i => $value) {
            preg_match_all($td_pattern, $value, $td);
            foreach ($td[7] as $a => $class) {
                for ($check = 0; isset($content[$i][$check]); $check++) {
                }
                if ($td[6][$a] != null) {
                    for ($c = 0; $c < $td[6][$a]; $c++) {
                        if ($c == 0) {
                            $content[$i][$check] = iconv('gb2312', 'utf-8', $td[7][$a]);
                        } else {
                            $content[$i][$check + $c] = "0";
                        }
                    }
                } elseif ($td[4][$a] != null) {
                    for ($c = 0; $c < $td[4][$a]; $c++) {
                        if ($c == 0) {
                            $content[$i][$check] = iconv('gb2312', 'utf-8', $td[7][$a]);
                        } else {
                            $content[$i + $c][$check] = "0";
                        }
                    }
                } else {
                    $content[$i][$check] = iconv('gb2312', 'utf-8', $td[7][$a]);
                }
            }
        }
        $class_list = array();
        for ($row = 2; $row < count($content); $row++) {
            for ($list = 2; $list < count($content[$row]); $list++) {
                if ($content[$row][$list] != "0" && $content[$row][$list] != "&nbsp;") {
                    $pattern = "/([^>]+)<br>周(.)第([^节]+)节{第([^周]+)周(\|([单|双])周)?}<br>([^<]+)<br>([^<]*)/u";
                    preg_match_all($pattern, $content[$row][$list], $output);
                    foreach ($output[0] as $key => $value) {
                        $output = $data_restore->restore($output, $key);
                        $class = array(
                            "classname" => $output[1][$key],
                            "day" => $output[2][$key],
                            "class" => $output[3][$key],
                            "long" => $output[4][$key],
                            "teacher" => $output[7][$key],
                            "classroom" => $output[8][$key],
                            "single_week" => $output[6][$key]
                        );
                        array_push($class_list, $class);
                    }
                }
            }
        }
        $class_list = $data_restore->combine_class($class_list);
        $entry->entry_kebiao($class_list,$xh,"华南理工大学","");
    }
    echo json_encode(array("result"=>"1","kebiao"=>isset($class_list)?$class_list:"","information"=>isset($information)?$information:"","week"=>$week->get_week(),"msg"=>isset($result['msg'])?$result['msg']:""));
}else{
    echo json_encode(array("result"=>"0","msg"=>$error[1][0]));
}