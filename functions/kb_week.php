<?php
namespace dyb;

error_reporting(E_ALL^E_NOTICE^E_WARNING);

require_once __DIR__ . "/../vendor/autoload.php";

use dyb\curl;

class kb_week
{
    function get_week()
    {
        $curl = new curl();

        $week_url = "http://jwc.scuteo.com/jiaowuchu/cms/index.do?nsukey=R0FxJzx1c7pwEivb3qOtEC07FbRo6lZo1VM7LTrRlG8%2BA0OAHJipBY61yRvJ4zO%2FE1RNfZu0d3XHF1p81zVRHNjzXe8MYQFZyJ0EM1uFPS74iOtrtaiVsfencpcO0dRTRIHEIhdrECemCYlfRQnh83jDOM3afMgJFPproyJ6fbrTJw6uMxPK7wN9IqEJvB7D";
        $html = $curl->curl($week_url);
        if (preg_match('/当前为第(\w+)教学周/', $html, $week)) {
            return $week[1];
        } else {
            throw new \Exception("failed to fetch week");
        }
    }
}

