<?php
namespace dyb;

require_once "../vendor/autoload.php";

class data_restore
{
    function restore($class, $key)
    {
        switch ($class[2][$key]) {
            case "一":
                $class[2][$key] = "1";
                break;
            case "二":
                $class[2][$key] = "2";
                break;
            case "三":
                $class[2][$key] = "3";
                break;
            case "四":
                $class[2][$key] = "4";
                break;
            case "五":
                $class[2][$key] = "5";
                break;
            case "六":
                $class[2][$key] = "6";
                break;
            case "日":
                $class[2][$key] = "7";
                break;
        }
        switch ($class[6][$key]) {
            case "单":
                $class[6][$key] = "1";
                break;
            case "双":
                $class[6][$key] = "2";
                break;
            default:
                $class[6][$key] = "0";
                break;
        }
        preg_match_all("/([0-9]+)-([0-9]+)/",$class[4][$key],$result_long);
        $class[4][$key]=array($result_long[1][0],$result_long[2][0]);
        preg_match_all("/([0-9]+),/",$class[3][$key].",",$result_class);
        $class[3][$key]=array();
        foreach($result_class[1] as $value){
            array_push($class[3][$key],$value);
        }
        return $class;
    }
    //修复异常的分离
    function combine_class($class)
    {
        $class_result=array();
        foreach($class as $key =>$value)
        {
            $status=0;
            foreach ($class_result as $i => $temp) {
                if ($value['classname'] == $temp['classname'] && $value['day'] == $temp['day'] && $value['teacher'] == $temp['teacher'] && $value['single_week'] == $temp['single_week'] && $value['classroom'] == $temp['classroom']) {
                    $number = count($temp['class']) - 1;
                    if ($value['class']['0'] == ($temp['class'][$number] + 1)) {
                        $class_result[$i]['class'] = array_merge($temp['class'], $value['class']);
                        $status=1;
                    }
                }
            }
            if($status==0){
                array_push($class_result,$value);
            }
        }
        return $class_result;
    }
}