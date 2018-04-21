<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
function curl($url,$cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function login_curl($url,$cookie,$post=null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, 'http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/default2.aspx');
    if($post!=null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function restore($class,$key){
    switch ($class[2][$key])
    {
        case "一":
            $class[2][$key]="1";
            break;
        case "二":
            $class[2][$key]="2";
            break;
        case "三":
            $class[2][$key]="3";
            break;
        case "四":
            $class[2][$key]="4";
            break;
        case "五":
            $class[2][$key]="5";
            break;
        case "六":
            $class[2][$key]="6";
            break;
        case "日":
            $class[2][$key]="7";
            break;
    }
    switch($class[6][$key])
    {
        case "单":
            $class[6][$key]="1";
            break;
        case "双":
            $class[6][$key]="2";
            break;
        default:
            $class[6][$key]="0";
            break;
    }
    $class[4][$key]="[".$class[4][$key]."]";
    return $class;
}

if($_POST==null) {
    session_start();
    $id=session_id();
    $_SESSION['id']=$id;
    $cookie = tempnam('./cookie', 'cookie');
    $img = curl("http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/CheckCode.aspx",$cookie);
    $img = base64_encode($img);
    echo "<form action='' method='post'><br>";
    echo "<input type='text' placeholder='学号' name='xh' value=''><br>";
    echo "<input type='password' placeholder='密码' name='pw' value=''><br>";
    echo "<img src='data:image/gif;base64,$img'><br>";
    echo "<input type='text' placeholder='验证码' name='txtSecretCode' value=''><br>";
    echo "<input type='hidden'name='cookie' value='$cookie'>";
    echo "<input type='submit' value='登录'>";
    echo "</form>";
}else {
    session_start();
    $id = session_id();
    $_SESSION['id'] = $id;
    $_SESSION['xh'] = $_POST['xh'];
    $xh = $_POST['xh'];
    //header("Content-type: text/html; charset=gb2312");
    $cookie = $_POST['cookie'];
    $default2 = login_curl("http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/default2.aspx", $cookie);
    $hidden_pattern = '/<input type="hidden" name="__VIEWSTATE" value="([^"]+)" \/>/';
    preg_match_all($hidden_pattern, $default2, $hidden_output);
    $__VIEWSTATE = $hidden_output[1][0];
    $post = array(
        "__VIEWSTATE" => $__VIEWSTATE,
        "txtUserName" => $xh,
        "TextBox2" => $_POST['pw'],
        "txtSecretCode" => $_POST['txtSecretCode'],
        "RadioButtonList1" => iconv('utf-8', 'gb2312', '学生'),
        "Button1" => iconv('utf-8', 'gb2312', '登录'),
        'lbLanguage' => "",
        "hidPdrs" => "",
        "hidsc" => ""
    );
    $index = login_curl("http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/default2.aspx", $cookie, $post);

    $alert_error = "/alert\('([^']+)'\)/";
    preg_match_all($alert_error, $index, $error);
    if ($error[1] != null) {
        $error[1][0] = iconv('gb2312', 'utf-8', $error[1][0]);
        echo $error[1][0];
    }

    $xm_pattern = '/<span id="xhxm">([^<]+)<\/span>/';
    preg_match_all($xm_pattern, $index, $xm);
    if (isset($xm[1][0])) {
        $xm = substr($xm[1][0], 0, -4);
        $kebiao = login_curl("http://110.65.10.240/(zujcvqfvef0yq545wpdmw3fr)/xskbcx.aspx?xh=$xh&xm=$xm&gnmkdm=N121603", $cookie);
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
                        $output = restore($output, $key);
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
        print_r($class_list);
        // echo json_encode($content);
    }
}
