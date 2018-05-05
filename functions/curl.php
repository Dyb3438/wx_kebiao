<?php
namespace dyb;

require_once __DIR__."/../vendor/autoload.php";

class curl
{
    function login_curl($url,$rnd,$post=null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://$rnd/default2.aspx");
        if($post!=null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    function url(){
        $url=array(
            "110.65.10.240",
        );
        foreach($url as $key=>$value){
            $result=$this->curl($value);
            $error=iconv("utf-8","gb2312","参数不正确。");
            if($result==$error){
                continue;
            }else{
                return $value;
                break;
            }
        }
    }
}
