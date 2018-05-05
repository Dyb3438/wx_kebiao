<?php
require 'vendor/autoload.php';

use Tamce\Router;

Router::route('/wx_kebiao/login',function(){
    require __DIR__."/src/login.php";
});

Router::route('/wx_kebiao/captcha',function(){
    require __DIR__."/src/captcha.php";
});

Router::route('/wx_kebiao/kebiao/loading',function(){
    require __DIR__."/src/scut_kebiao.php";
});

Router::route('/wx_kebiao/kebiao/manualmodify',function(){
    require __DIR__."/src/manual_kebiao.php";
});

Router::route('/wx_kebiao/information/unbind',function(){
    require __DIR__."/src/unbind.php";
});

Router::route('/wx_kebiao/information/bind',function(){
    require __DIR__."/src/bind.php";
});

Router::route('/wx_kebiao/information/manualchange',function(){
    require __DIR__."/src/manual_information.php";
});
