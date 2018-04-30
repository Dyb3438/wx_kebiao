# 微信小程序接口文档

## 一、微信授权

### 1、授权接口

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://120.79.221.7/wx_kebiao/login</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">GET</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
            <td>请求参数</td>
            <td>参数名</td>
            <td>参数类型</td>
            <td>是否必填</td>
            <td>说明</td>
        </tr>
        <tr>
            <td>code</td>
            <td>code</td>
            <td>String</td>
            <td>Y</td>
            <td></td>
        </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>sessionid</td>
        <td>sessionid</td>
        <td>String</td>
        <td>Y</td>
        <td>储存在本地，用于以后请求作为header</td>
    </tr>
    <tr>
        <td>个人信息</td>
        <td>information</td>
        <td>Array</td>
        <td>Y</td>
        <td>用于下次提交表单</td>
    </tr>
</table>

#### 个人信息格式：

    {
        "xuehao"=>"201730293438",
        "name"=>"xxx",
        "classroom"=>"xxxxxxx班",
        "major"=>"xxxxxxxx专业",
        "school"=>"xxxx学院",
        "college"=>"华南理工大学"
    }

## 二、抓取课表

### 1、验证码接口

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://120.79.221.7/wx_kebiao/captcha</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">GET</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>验证码</td>
        <td>picture</td>
        <td>base64</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>教务网地址随机数</td>
        <td>rnd</td>
        <td>String</td>
        <td>Y</td>
        <td>用于下次提交表单</td>
    </tr>
</table>

### 2、课表录入接口

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://120.79.221.7/wx_kebiao/kebiao/loading</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">POST</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
        <td>请求参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>学号</td>
        <td>xh</td>
        <td>Integer</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>密码</td>
        <td>pw</td>
        <td>String</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>验证码</td>
        <td>txtSecretCode</td>
        <td>String</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>教务网地址随机数</td>
        <td>rnd</td>
        <td>String</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>操作参数</td>
        <td>do</td>
        <td>Integer</td>
        <td>Y</td>
        <td>0: 绑定;1: 爬课表;2: 绑定且爬课表;</td>
    </tr>
    <tr>
        <td colspan="5">返回结果</td>
    </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>结果</td>
        <td>result</td>
        <td>Integer</td>
        <td>Y</td>
        <td>1为进入教务网成功;<br>0为进入教务网失败</td>
    </tr>
    <tr>
        <td>课表内容</td>
        <td>kebiao</td>
        <td>array</td>
        <td>N</td>
        <td>当result为1时返回此参数，0时不存在</td>
    </tr>
    <tr>
        <td>学生信息</td>
        <td>information</td>
        <td>array</td>
        <td>N</td>
        <td>当result为1时返回此参数，0时不存在</td>
    </tr>
    <tr>
        <td>周数</td>
        <td>week</td>
        <td>Integer</td>
        <td>N</td>
        <td>当result为1时返回此参数，0时不存在</td>
    </tr>
    <tr>
        <td>出错原因</td>
        <td>msg</td>
        <td>String</td>
        <td>Y</td>
        <td>当result为1时,此参数是绑定个人信息时出错的信息;没错返回""<br>当result为0时,此参数是进入教务网时密码、验证码错误</td>
    </tr>
</table>

#### 课表格式：

    {
        "classname"=>"微积分1（二）"，
        "day"=>"1",
        "class"=>"[1,2,3]",
        "long"=>"[1,16]”,
        "teacher"=>”温旭辉”,
        "classroom"=>"A2 302",
        "single_week"=>"1"
        (单周为1，双周2，不分0)
    }

#### 学生信息格式：

    {
        "xuehao"=>"201730293438",
        "xingming"=>"xxx",
        "xueyuan"=>"xxxxxxx学院",
        "zhuanye"=>"xxxxxxxx专业",
        "xingzhengban"=>"xxxx班"
    }
    
    
### 3、手动修改课表接口

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://120.79.221.7/kebiao/manualmodify</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">POST</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
            <td>请求参数</td>
            <td>参数名</td>
            <td>参数类型</td>
            <td>是否必填</td>
            <td>说明</td>
        </tr>
        <tr>
            <td>课表信息</td>
            <td>class_list</td>
            <td>Json</td>
            <td>Y</td>
            <td>格式和上面的课表格式一样</td>
        </tr>
        <tr>
             <td colspan="5">返回结果</td>
        </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>结果</td>
        <td>result</td>
        <td>Integer</td>
        <td>Y</td>
        <td>1成功；0失败</td>
    </tr>
    <tr>
        <td>错误信息</td>
        <td>msg</td>
        <td>String</td>
        <td>Y</td>
        <td>result为1时空，result为0时为"请先微信授权"</td>
    </tr>
</table>
    
    
### 4、取消学号绑定接口

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://120.79.221.7/wx_kebiao/unbind</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">GET</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td>结果</td>
        <td>result</td>
        <td>Integer</td>
        <td>Y</td>
        <td>1成功；0失败</td>
    </tr>
    <tr>
        <td>错误信息</td>
        <td>msg</td>
        <td>String</td>
        <td>N</td>
        <td>当result为0时返回：请先绑定</td>
    </tr>
</table>


## 三、课表扩展功能


### 1、空教室查询接口（借用波棒糖）

<table>
    <tr>
        <td>请求地址：</td>
        <td colspan="4">http://apiv2.100steps.net/emptyroom</td>
    </tr>
    <tr>
        <td>请求方式：</td>
        <td colspan="4">GET</td>
    </tr>
    <tr>
        <td>返回值类型：</td>
        <td colspan="4">Json</td>
    </tr>
    <tr>
            <td>请求参数</td>
            <td>参数名</td>
            <td>参数类型</td>
            <td>是否必填</td>
            <td>说明</td>
        </tr>
    <tr>
        <td>日期</td>
        <td>date</td>
        <td>YYYY-MM-DD</td>
        <td>Y</td>
        <td></td>
    </tr>
    <tr>
        <td>时间段</td>
        <td>period</td>
        <td>String</td>
        <td>选填</td>
        <td>0，1，2，3，4分别是12，34，56，78，91011节<br>如果输入1.2表示第一到四小节(以此类推）</td>
    </tr>
    <tr>
        <td>教学楼</td>
        <td>building</td>
        <td>String</td>
        <td>选填</td>
        <td>和period一样可同时寻找多栋楼（如A1.A2.A3)</td>
    </tr>
    <tr>
        <td>校区</td>
        <td>campus</td>
        <td>String</td>
        <td>选填</td>
        <td>N代表北校；S代表南校<br>和period一样可同时寻找多个校区（如N.S)</td>
    </tr>
    <tr>
        <td>返回参数</td>
        <td>参数名</td>
        <td>参数类型</td>
        <td>是否必填</td>
        <td>说明</td>
    </tr>
    <tr>
        <td colspan='5'>返回json格式，具体如下</td>
    </tr>
</table>


#### 空教室查询返回值格式：

    {
    "id"=>"1"(在数据库里对应的序号，不用管),
    "room"=>"教室名字",
    "period"=>"时间段",
    "building"=>"教学楼",
    "campus"=>"校区",
    "date"="日期",
    "timestamp"=>"更新时间"
    }
    {
    ……
    }
    (取有用的就可以了，数据会在每天凌晨三点更新，只能查询从今天开始计，一共三天的空教室，第四天是否可以要看教务的心情)