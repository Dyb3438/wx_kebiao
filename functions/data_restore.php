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
        $class[4][$key] = "[" . $class[4][$key] . "]";
        return $class;
    }
}