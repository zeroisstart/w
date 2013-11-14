<?php
if(!defined('IN_SYS')) {
	exit('Access Denied');
}

//配置参数
$_SC = array();
$_SC['dbhost']  		= 'localhost:3306'; //服务器地址
$_SC['dbuser']  		= 'root'; //数据库用户
$_SC['dbpw'] 	 		= ''; //数据库密码
$_SC['dbcharset'] 		= 'utf8'; //字符集
$_SC['pconnect'] 		= 0; //是否持续连接
$_SC['dbname']  		= 'weixiao'; //数据库
$_SC['charset'] 		= 'utf-8'; //页面字符集
$_SC['tablepre']        = 'dz_';    //表头
$_SC['site_name']       = 'You know it';  //站点的名字
$_SC['lang']            = 'zh-cn';
$_SC['notification_email']='notification@sylai.com'; //推送邮箱的地址，目前暂时只支持QQ企业邮箱
$_SC['notification_email_pwd']='';   //推送邮箱的密码
$_SC['site_host']='http://'.$_SERVER['HTTP_HOST'];
$_SC['api_token']='weixiao'; //官方平台开发者模式里的TOKEN
$_SC['api_url']=$_SC['site_host'].'/open/mpwx.php'; 
$_SC['push_api_token']='weixiao';   //内部推送用，官方平台开发者模式里的TOKEN
$_SC['push_api_url']=$_SC['site_host'].'/open/mpwx_push.php';
$_SC['captcha']=false;  //登录是否需要验证码

include_once('version.php');
?>