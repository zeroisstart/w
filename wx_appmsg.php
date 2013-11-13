<?php
include_once('./common.php');

$msgid=intval($_GET['id'])?intval($_GET['id']):0;
$tp=intval($_GET['tp'])?intval($_GET['tp']):0;
if(!$msgid || !$tp){
 exit;	
}

switch($tp){
case 1:
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_focusreply_info').' where id='.$msgid);
break;
case 2:
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_msgreply_info').' where id='.$msgid);
break;
case 3:
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_autoreply_info').' where id='.$msgid);
break;
default:
exit;	
}


$msg=$_SGLOBAL['db']->fetch_array($query);



if(!$msg){
	exit;
}

$msg['content']=htmlspecialchars_decode($msg['content']);
$msg['addtime']=sgmdate("Y-m-d",$msg['addtime']);     
     
$smarty->assign('msg',$msg);
$smarty->display('wx_appmsg.dwt');
?>