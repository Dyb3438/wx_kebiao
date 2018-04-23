微信小程序接口文档
-----
一、抓取课表
-----
1、验证码接口
-----
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
<td>cookie文件名</td>
<td>cookie</td>
<td>String</td>
<td>Y</td>
<td>用于下次提交表单</td>
</tr>
<tr>
<td>教务网地址随机数</td>
<td>rnd</td>
<td>String</td>
<td>Y</td>
<td>用于下次提交表单</td>
</tr>
</table>

2、课表录入接口
-------
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
<td>cookie文件名</td>
<td>cookie</td>
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
<td>1为抓取成功;0为出错</td>
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
<td>出错原因</td>
<td>msg</td>
<td>String</td>
<td>N</td>
<td>当result为0时返回此参数，1时不存在</td>
</tr>
</table>
 课表格式：{<br>
 “classname”=>”微积分1（二）”，<br>
 “day”=>”1”,<br>
 “class”=>”1,2,3”,<br>
 “long“=>”[1-16]”,<br>
 “teacher“=>”温旭辉”,<br>
 “classroom“=>”A2 302”,<br>
 “single_week”=>”1”<br>
 (单周为1，双周2，不分0)<br>
 }<br> 
 学生信息格式：{<br>
 "xuehao"=>"201730293438",<br>
 "xingming"=>"苏永怡",<br>
 "xueyuan"=>"材料科学与工程学院",<br>
 "zhuanye"=>"高分子材料与工程专业",<br>
 "xingzhengban"=>"高分子乙班"<br>
 } <br>