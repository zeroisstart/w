<?php
if(!defined('IN_SYS')) {
	exit('Access Denied');
}

function sms($smsText,$smsMob)
{
$uid='ortle';
$key='ba3075d1365b99122a19';
$url='http://utf8.sms.webchinese.cn/?Uid='.$uid.'&Key='.$key.'&smsMob='.$smsMob.'&smsText='.$smsText;

if(function_exists('file_get_contents'))
{
$file_contents = file_get_contents($url);
}
else
{
$ch = curl_init();
$timeout = 5;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);
}
return $file_contents;
} 
?>