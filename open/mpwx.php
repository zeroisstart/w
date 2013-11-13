<?php
include_once('../common.php');
include_once('../source/class_weixin.php');
include_once('../source/class_weixin_ext.php');

//define your token
define("TOKEN", $_SC['api_token']);
$wechatObj = new wechat_main_class();
if($wechatObj->valid()){	
  $wechatObj->responseMsg();
}
?>