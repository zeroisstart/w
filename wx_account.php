<?php
include_once('./common.php');
$url =  "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if($_SGLOBAL['login']==false){
gourl('index.php?backurl='.urlencode($url));
exit();
}

$datearr=array( "天 ", "一 ", "二 ", "三 ", "四 ", "五 ", "六 ");                
$ac=$_REQUEST["ac"];
switch ($ac)
{
case "upload":
$url =  "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if($_SGLOBAL['login']==false){
gourl('index.php?backurl='.urlencode($url));
exit();
}

	
	if($_FILES['file1']['name'] != ""){
		//包含上传文件类
		require_once ('upload.php');
		//设置文件上传目录
		$savePath = "uploads/msgs/";
		//允许的文件类型
		$fileFormat = array('gif','jpg','jpeg','png','bmp');
		//文件大小限制，单位: Byte，1KB = 1000 Byte
		//0 表示无限制，但受php.ini中upload_max_filesize设置影响
		$maxSize = 0;
		//覆盖原有文件吗？ 0 不允许  1 允许 
		$overwrite = 1;
		//初始化上传类
		$f = new Upload( $savePath, $fileFormat, $maxSize, $overwrite);
		//如果想生成缩略图，则调用成员函数 $f->setThumb();
		//参数列表: setThumb($thumb, $thumbWidth = 0,$thumbHeight = 0)
		//$thumb=1 表示要生成缩略图，不调用时，其值为 0
		//$thumbWidth  缩略图宽，单位是像素(px)，留空则使用默认值 130
		//$thumbHeight 缩略图高，单位是像素(px)，留空则使用默认值 130
		//$f->setThumb(1);
		
		//参数中的uploadinput是表单中上传文件输入框input的名字
		//后面的0表示不更改文件名，若为1，则由系统生成随机文件名
		if (!$f->run('file1',1)){
			//通过$f->errmsg()只能得到最后一个出错的信息，
			//详细的信息在$f->getInfo()中可以得到。
			$jsondata ="{";
		    $jsondata = $jsondata . chr(34)."err".chr(34).":1,"; 
            $jsondata = $jsondata . chr(34)."msg".chr(34).":".chr(34).$f->errmsg().chr(34);
			$jsondata = $jsondata . "}";
		}else{
		//上传结果保存在数组returnArray中。
        $path=$f->saveName;
        $jsondata = $jsondata . "{";
        $jsondata = $jsondata . chr(34)."err".chr(34).":0,"; 
        $jsondata = $jsondata . chr(34)."filename".chr(34).":".chr(34).$_SC['site_host'].'/uploads/msgs/'.$path.chr(34).",";
        $jsondata = $jsondata . chr(34)."msg".chr(34).":".chr(34)."文件上传成功!请不要修改生成的链接地址！".chr(34); 
        $jsondata = $jsondata . "}";
		}//end if
		echo $jsondata;
	}
break;	
case "add":
$smarty->display('wx_account_add.dwt');
break;
case "addprofile":
include_once('./source/class_weixin.php');
$ro = new WX_Remote_Opera();
$token=$ro->init(getstr($_POST['username']),getstr($_POST['password']));
if($token!=''){
$info=$ro->get_account_info();	
$setarr=array(
'op_uid'=>$_SGLOBAL['uid'],
'ghid'=>$info['ghid'],
'weixin_name'=>$info['nickname'],
'username'=>getstr($_POST['username']),
'password'=>getstr($_POST['password']),
'signature'=>$info['signature'],
'country'=>$info['country'],
'province'=>$info['province'],
'city'=>$info['city'],
'verifyInfo'=>$info['verifyInfo'],
'bindUserName'=>$info['bindUserName'],
'account'=>$info['account'],
'fakeid'=>$info['fakeid'],
'public'=>intval($_POST['public'])?intval($_POST['public']):0,
'state'=>1,
'appid'=>getstr($_POST['appid']),
'appsecret'=>getstr($_POST['appsecret']),
'addtime'=>$_SGLOBAL['timestamp'],
);
$id=inserttable(tname('open_member_weixin'),$setarr,1);

//备份自定义菜单
if(getstr($_POST['appid'])){
$arr=$ro->get_menu(getstr($_POST['appid']),getstr($_POST['appsecret']));
if(!$arr['errcode']){
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_custommenu').' where wxid='.$id);
foreach($arr['menu']['button'] as $k=>$v){
	$parent_id=inserttable(tname('open_member_weixin_custommenu'),array(
	'wxid'=>$id,
	'sort_order'=>$k,
	'btn_type'=>$v['type']=='view'?2:1,
	'btn_name'=>$v['name']?$v['name']:'',
	'keyword'=>$v['key']?$v['key']:'',
	'url'=>$v['url']?$v['url']:'',
	'addtime'=>$_SGLOBAL['timestamp']
	),1);
	if($v['sub_button']){
      foreach($arr['menu']['button'][$k]['sub_button'] as $key=>$value){
		  inserttable(tname('open_member_weixin_custommenu'),array(
	         'wxid'=>$id,
			 'parent_id'=>$parent_id,
	         'sort_order'=>$key,
	         'btn_type'=>$value['type']=='view'?2:1,
	         'btn_name'=>$value['name']?$value['name']:'',
	         'keyword'=>$value['key']?$value['key']:'',
	         'url'=>$value['url']?$value['url']:'',
	         'addtime'=>$_SGLOBAL['timestamp']
	      ));
	  }
	}
}
}	
}

$ro->getheadimg($info['fakeid']);
$ro->quick_set_api($_SC['api_token'],$_SC['api_url']);
if(!$arr['errcode']){
$ro->create_menu(getstr($_POST['appid']),getstr($_POST['appsecret']),urldecode(json_encode($arr['menu'])));
}
}else{
$setarr=array(
'op_uid'=>$_SGLOBAL['uid'],
'username'=>getstr($_POST['username']),
'password'=>getstr($_POST['password']),
'public'=>intval($_POST['public'])?intval($_POST['public']):0,
'state'=>0,
'addtime'=>$_SGLOBAL['timestamp'],
);
inserttable(tname('open_member_weixin'),$setarr);
}
gourl('wx_account.php');
exit;	
break;							   
case "edit":	
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);

$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
	   $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';

   $smarty->assign('account',$account);
}
$smarty->display('wx_account_edit.dwt');
break;
case "editprofile":
$id=intval($_POST['id'])?intval($_POST['id']):0;
check_role($id);

include_once('./source/class_weixin.php');
$ro = new WX_Remote_Opera();
$token=$ro->init(getstr($_POST['username']),getstr($_POST['password']));
if($token!=''){
$info=$ro->get_account_info();	
$setarr=array(
'ghid'=>$info['ghid'],
'weixin_name'=>$info['nickname'],
'username'=>getstr($_POST['username']),
'password'=>getstr($_POST['password']),
'signature'=>$info['signature'],
'country'=>$info['country'],
'province'=>$info['province'],
'city'=>$info['city'],
'verifyInfo'=>$info['verifyInfo'],
'bindUserName'=>$info['bindUserName'],
'account'=>$info['account'],
'fakeid'=>$info['fakeid'],
'public'=>intval($_POST['public'])?intval($_POST['public']):0,
'state'=>1,
'appid'=>getstr($_POST['appid']),
'appsecret'=>getstr($_POST['appsecret']),

);
updatetable(tname('open_member_weixin'),$setarr,array('op_uid'=>$_SGLOBAL['uid'],'id'=>$id));


//备份自定义菜单
if(getstr($_POST['appid'])){
$arr=$ro->get_menu(getstr($_POST['appid']),getstr($_POST['appsecret']));
if(!$arr['errcode']){
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_custommenu').' where wxid='.$id);
foreach($arr['menu']['button'] as $k=>$v){
	$parent_id=inserttable(tname('open_member_weixin_custommenu'),array(
	'wxid'=>$id,
	'sort_order'=>$k,
	'btn_type'=>$v['type']=='view'?2:1,
	'btn_name'=>$v['name']?$v['name']:'',
	'keyword'=>$v['key']?$v['key']:'',
	'url'=>$v['url']?$v['url']:'',
	'addtime'=>$_SGLOBAL['timestamp']
	),1);
	if($v['sub_button']){
      foreach($arr['menu']['button'][$k]['sub_button'] as $key=>$value){
		  inserttable(tname('open_member_weixin_custommenu'),array(
	         'wxid'=>$id,
			 'parent_id'=>$parent_id,
	         'sort_order'=>$key,
	         'btn_type'=>$value['type']=='view'?2:1,
	         'btn_name'=>$value['name']?$value['name']:'',
	         'keyword'=>$value['key']?$value['key']:'',
	         'url'=>$value['url']?$value['url']:'',
	         'addtime'=>$_SGLOBAL['timestamp']
	      ));
	  }
	}
}
}	
}

$ro->getheadimg($info['fakeid']);
$ro->quick_set_api($_SC['api_token'],$_SC['api_url']);
if(!$arr['errcode']){
  $ro->create_menu(getstr($_POST['appid']),getstr($_POST['appsecret']),urldecode(json_encode($arr['menu'])));
}
}else{
$setarr=array(
'username'=>getstr($_POST['username']),
'password'=>getstr($_POST['password']),
'public'=>intval($_POST['public'])?intval($_POST['public']):0,
'state'=>0,
);
updatetable(tname('open_member_weixin'),$setarr,array('op_uid'=>$_SGLOBAL['uid'],'id'=>$id));
}

gourl('wx_account.php');
exit;	
break;
case "pushedit":
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_pushweixin').' where op_uid='.$_SGLOBAL['uid']);
if($account=$_SGLOBAL['db']->fetch_array($query)){	
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_pushedit.dwt');
break;
case "pusheditprofile":
include_once('./source/class_weixin.php');
$ro = new WX_Remote_Opera();
$token=$ro->init(getstr($_POST['username']),getstr($_POST['password']));
if($token!=''){
$info=$ro->get_account_info();
$setarr=array(
'ghid'=>$info['ghid'],
'weixin_name'=>$info['nickname'],
'username'=>getstr($_POST['username']),
'password'=>getstr($_POST['password']),
'signature'=>$info['signature'],
'country'=>$info['country'],
'province'=>$info['province'],
'city'=>$info['city'],
'verifyInfo'=>$info['verifyInfo'],
'bindUserName'=>$info['bindUserName'],
'account'=>$info['account'],
'fakeid'=>$info['fakeid'],
'state'=>1,
);
if($_SGLOBAL['db']->getone('select id from '.tname('open_member_pushweixin').' where op_uid='.$_SGLOBAL['uid'])){
  updatetable(tname('open_member_pushweixin'),$setarr,array('op_uid'=>$_SGLOBAL['uid'])); 
}else{
  $setarr['op_uid']=$_SGLOBAL['uid'];	
  $Setarr['addtime']=$_SGLOBAL['timestamp'];
  inserttable(tname('open_member_pushweixin'),$setarr);	
}
updatetable(tname('open_member_user'),array('weixin_state'=>0),array('op_uid'=>$_SGLOBAL['uid']));

$ro->getheadimg($info['fakeid']);
$ro->quick_set_api($_SC['push_api_token'],$_SC['push_api_url']);
}else{
   echo '微信用户名或密码错误，或者此微信已被设置';
   exit;	
}
gourl('wx_account.php?ac=pushedit');
exit;	
break;
case "manage":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
   $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_manage.dwt');
break;
case "del":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin').' where id='.$id);
$autoreply_id=$_SGLOBAL['db']->getone('select id from '.tname('open_member_weixin_autoreply').' where wxid='.$id);
if($autoreply_id) $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply_info').' where autoreply_id='.$autoreply_id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply').' where wxid='.$id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_focusreply_info').' where wxid='.$id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_msgreply_info').' where wxid='.$id);
gourl('wx_account.php');
break;
case "update_focusreply":
$id=intval($_POST['id'])?intval($_POST['id']):0;
check_role($id);
$autoreply_type_id=intval($_POST['autoreply_type_id'])?intval($_POST['autoreply_type_id']):1;

if($autoreply_type_id==1){
  $content=getstr($_POST['content']);
  updatetable(tname('open_member_weixin'),array('afteradd_autoreply_type_id'=>$autoreply_type_id,'afteradd'=>$content),array('id'=>$id));
}

if($autoreply_type_id==2){
  $title=getstr($_POST['title']);	
  $desc=getstr($_POST['desc']);	
  $content=getstr($_POST['content']);
  $pic=getstr($_POST['pic']);
  $url=getstr($_POST['url']);
  $wz_mid=intval($_POST['wz'])?intval($_POST['wz']):0;
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_focusreply_info').' where autoreply_type_id=2 and wxid='.$id);
  inserttable(tname('open_member_weixin_focusreply_info'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'title'=>$title,'summary'=>$desc,'content'=>$content,'pic'=>$pic,'url'=>$url,'wz_mid'=>$wz_mid,'sort_order'=>0,'addtime'=>$_SGLOBAL['timestamp']));
  updatetable(tname('open_member_weixin'),array('afteradd_autoreply_type_id'=>$autoreply_type_id),array('id'=>$id));
	
}

if($autoreply_type_id==3){
  $msgitem=json_decode(stripslashes($_POST['msgitem']),true);
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_focusreply_info').' where autoreply_type_id=3 and wxid='.$id);
  foreach($msgitem as $k=>$v){
    inserttable(tname('open_member_weixin_focusreply_info'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'title'=>getstr($v['title']),'content'=>getstr($v['content']),'pic'=>getstr($v['pic']),'url'=>getstr($v['url']),'wz_mid'=>intval($v['wz'])?intval($v['wz']):0,'sort_order'=>($k+1),'addtime'=>$_SGLOBAL['timestamp']));	
  }
  updatetable(tname('open_member_weixin'),array('afteradd_autoreply_type_id'=>$autoreply_type_id),array('id'=>$id));
}
break;
case "focusreply":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);

//获取微站列表
$wz_module=$_SGLOBAL['db']->getall('select * from '.tname('wz_module'));
$smarty->assign('wz_module',$wz_module);


$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
	
   //文本回复
   $account['afteradd']=htmlspecialchars_decode($account['afteradd']);
   $account['afteradd_textarea']=db_to_content(htmlspecialchars_decode($account['afteradd']));
   //单图文回复
   $account['singlenews']=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_focusreply_info').' where wxid='.$account['id'].' and autoreply_type_id=2'));
   if(!$account['singlenews']){
	  $account['singlenews']['title']='标题';   
   }else{
	  $account['singlenews']['content']=htmlspecialchars_decode($account['singlenews']['content']);   
   }
   
   //多图文回复
   $account['multinews_num']=getcount(tname('open_member_weixin_focusreply_info'),array('wxid'=>$account['id'],'autoreply_type_id'=>3));   
   $account['multinews']=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin_focusreply_info').' where wxid='.$account['id'].' and autoreply_type_id=3 order by sort_order');
   foreach($account['multinews'] as $k=>$v){
	  $account['multinews'][$k]['content']=htmlspecialchars_decode($v['content']); 
   }
   $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';      	
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_focusreply.dwt');
break;

case "update_msgreply":
$id=intval($_POST['id'])?intval($_POST['id']):0;
check_role($id);
$autoreply_type_id=intval($_POST['autoreply_type_id'])?intval($_POST['autoreply_type_id']):1;

if($autoreply_type_id==1){
  $content=getstr($_POST['content']);
  updatetable(tname('open_member_weixin'),array('aftermsg_autoreply_type_id'=>$autoreply_type_id,'aftermsg'=>$content),array('id'=>$id));
}

if($autoreply_type_id==2){
  $title=getstr($_POST['title']);	
  $desc=getstr($_POST['desc']);	
  $content=getstr($_POST['content']);
  $pic=getstr($_POST['pic']);
  $url=getstr($_POST['url']);
  $wz_mid=intval($_POST['wz'])?intval($_POST['wz']):0;
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_msgreply_info').' where autoreply_type_id=2 and wxid='.$id);
  inserttable(tname('open_member_weixin_msgreply_info'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'title'=>$title,'summary'=>$desc,'content'=>$content,'pic'=>$pic,'url'=>$url,'wz_mid'=>$wz_mid,'sort_order'=>0,'addtime'=>$_SGLOBAL['timestamp']));
  updatetable(tname('open_member_weixin'),array('aftermsg_autoreply_type_id'=>$autoreply_type_id),array('id'=>$id));
	
}

if($autoreply_type_id==3){
  $msgitem=json_decode(stripslashes($_POST['msgitem']),true);
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_msgreply_info').' where autoreply_type_id=3 and wxid='.$id);
  foreach($msgitem as $k=>$v){
    inserttable(tname('open_member_weixin_msgreply_info'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'title'=>getstr($v['title']),'content'=>getstr($v['content']),'pic'=>getstr($v['pic']),'url'=>getstr($v['url']),'wz_mid'=>intval($v['wz'])?intval($v['wz']):0,'sort_order'=>($k+1),'addtime'=>$_SGLOBAL['timestamp']));	
  }
  updatetable(tname('open_member_weixin'),array('aftermsg_autoreply_type_id'=>$autoreply_type_id),array('id'=>$id));
}
break;
case "msgreply":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);

//获取微站列表
$wz_module=$_SGLOBAL['db']->getall('select * from '.tname('wz_module'));
$smarty->assign('wz_module',$wz_module);

$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
   //文本回复
   $account['aftermsg']=htmlspecialchars_decode($account['aftermsg']);
   $account['aftermsg_textarea']=db_to_content(htmlspecialchars_decode($account['aftermsg']));
   //单图文回复
   $account['singlenews']=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_msgreply_info').' where wxid='.$account['id'].' and autoreply_type_id=2'));
   if(!$account['singlenews']){
	  $account['singlenews']['title']='标题';   
   }else{
	  $account['singlenews']['content']=htmlspecialchars_decode($account['singlenews']['content']);   
   }
   
   //多图文回复
   $account['multinews_num']=getcount(tname('open_member_weixin_msgreply_info'),array('wxid'=>$account['id'],'autoreply_type_id'=>3));   
   $account['multinews']=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin_msgreply_info').' where wxid='.$account['id'].' and autoreply_type_id=3 order by sort_order');
   foreach($account['multinews'] as $k=>$v){
	  $account['multinews'][$k]['content']=htmlspecialchars_decode($v['content']);   
   }
   $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';      	
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_msgreply.dwt');
break;


//关键词回复
case "keywordreply":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
      $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';
	
   $account['autoreply_num']=getcount(tname('open_member_weixin_autoreply'),array('wxid'=>$account['id']));   
   $account['autoreply']=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin_autoreply').' where wxid='.$account['id'].' order by addtime');
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_keywordreply.dwt');
break;

case "keywordreply_add":
$id=intval($_GET['id'])?intval($_GET['id']):0;
check_role($id);

//获取微站列表
$wz_module=$_SGLOBAL['db']->getall('select * from '.tname('wz_module'));
$smarty->assign('wz_module',$wz_module);


$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){
      $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';
	
   $account['autoreply_num']=getcount(tname('open_member_weixin_autoreply'),array('wxid'=>$account['id']));   
   $account['autoreply']=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin_autoreply').' where wxid='.$account['id'].' order by addtime');
   $smarty->assign('account',$account);
}
$smarty->display('wx_account_keywordreply_add.dwt');
break;

case "keywordreply_addtodb":
$id=intval($_POST['id'])?intval($_POST['id']):0;
check_role($id);
$autoreply_type_id=intval($_POST['autoreply_type_id'])?intval($_POST['autoreply_type_id']):1;
$keyword=getstr($_POST['keyword']);
$islike=intval($_POST['islike'])?intval($_POST['islike']):0;

if($keyword==''){
 $json=array('err'=>1,'errmsg'=>'关键词不能为空');
 echo json_encode($json);	
 exit;	
}

if($autoreply_type_id==1){
  $content=getstr($_POST['content']);
  inserttable(tname('open_member_weixin_autoreply'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'keyword'=>$keyword,'content'=>$content,'islike'=>$islike,'state'=>1,'addtime'=>$_SGLOBAL['timestamp']));
}

if($autoreply_type_id==2){
  $title=getstr($_POST['title']);	
  $desc=getstr($_POST['desc']);	
  $content=getstr($_POST['content']);
  $pic=getstr($_POST['pic']);
  $url=getstr($_POST['url']);
  $wz_mid=intval($_POST['wz'])?intval($_POST['wz']):0;
  $autoreply_id=inserttable(tname('open_member_weixin_autoreply'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'keyword'=>$keyword,'content'=>$content,'islike'=>$islike,'state'=>1,'addtime'=>$_SGLOBAL['timestamp']),1);
  inserttable(tname('open_member_weixin_autoreply_info'),array('autoreply_id'=>$autoreply_id,'autoreply_type_id'=>$autoreply_type_id,'title'=>$title,'summary'=>$desc,'content'=>$content,'pic'=>$pic,'url'=>$url,'wz_mid'=>$wz_mid,'sort_order'=>0,'addtime'=>$_SGLOBAL['timestamp']));
}

if($autoreply_type_id==3){
  $autoreply_id=inserttable(tname('open_member_weixin_autoreply'),array('wxid'=>$id,'autoreply_type_id'=>$autoreply_type_id,'keyword'=>$keyword,'content'=>$content,'islike'=>$islike,'state'=>1,'addtime'=>$_SGLOBAL['timestamp']),1);	
  $msgitem=json_decode(stripslashes($_POST['msgitem']),true);
  foreach($msgitem as $k=>$v){
    inserttable(tname('open_member_weixin_autoreply_info'),array('autoreply_id'=>$autoreply_id,'autoreply_type_id'=>$autoreply_type_id,'title'=>getstr($v['title']),'content'=>getstr($v['content']),'pic'=>getstr($v['pic']),'url'=>getstr($v['url']),'wz_mid'=>intval($v['wz'])?intval($v['wz']):0,'sort_order'=>($k+1),'addtime'=>$_SGLOBAL['timestamp']));	
  }
}
 $json=array('err'=>0,'errmsg'=>'添加成功');
 echo json_encode($json);	
break;

case "keywordreply_edit":
$autoreply_id=intval($_GET['autoreply_id'])?intval($_GET['autoreply_id']):0;
$id=$_SGLOBAL['db']->getone('select wxid from '.tname('open_member_weixin_autoreply').' where id='.$autoreply_id);
check_role($id);

//获取微站列表
$wz_module=$_SGLOBAL['db']->getall('select * from '.tname('wz_module'));
$smarty->assign('wz_module',$wz_module);
	
$query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid'].' and id='.$id);
if($account=$_SGLOBAL['db']->fetch_array($query)){	
   $query=$_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_autoreply').' where id='.$autoreply_id);
   if($account['keywordreply']=$_SGLOBAL['db']->fetch_array($query)){
     //文本回复
     $account['keywordreply']['content']=htmlspecialchars_decode($account['keywordreply']['content']);
     $account['keywordreply']['content_textarea']=db_to_content(htmlspecialchars_decode($account['keywordreply']['content']));
     //单图文回复
     $account['keywordreply']['singlenews']=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query('select * from '.tname('open_member_weixin_autoreply_info').' where autoreply_id='.$autoreply_id.' and autoreply_type_id=2'));
     if(!$account['keywordreply']['singlenews']){
	    $account['keywordreply']['singlenews']['title']='标题';   
     }else{
	    $account['keywordreply']['singlenews']['content']=htmlspecialchars_decode($account['keywordreply']['singlenews']['content']);   
     }
	    
     //多图文回复
     $account['keywordreply']['multinews_num']=getcount(tname('open_member_weixin_autoreply_info'),array('autoreply_id'=>$autoreply_id,'autoreply_type_id'=>3));   
     $account['keywordreply']['multinews']=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin_autoreply_info').' where autoreply_id='.$autoreply_id.' and autoreply_type_id=3 order by sort_order');
     foreach($account['keywordreply']['multinews'] as $k=>$v){
	    $account['keywordreply']['multinews'][$k]['content']=htmlspecialchars_decode($v['content']);   
     }
   }
         $account['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$account['fakeid'].'.png';

   $smarty->assign('account',$account);
}
$smarty->display('wx_account_keywordreply_edit.dwt');
break;

case "keywordreply_edittodb":
$autoreply_id=intval($_POST['autoreply_id'])?intval($_POST['autoreply_id']):0;
$id=$_SGLOBAL['db']->getone('select wxid from '.tname('open_member_weixin_autoreply').' where id='.$autoreply_id);
check_role($id);
$autoreply_type_id=intval($_POST['autoreply_type_id'])?intval($_POST['autoreply_type_id']):1;

$keyword=getstr($_POST['keyword']);
$islike=intval($_POST['islike'])?intval($_POST['islike']):0;

if($keyword==''){
 $json=array('err'=>1,'errmsg'=>'关键词不能为空');
 echo json_encode($json);	
 exit;	
}


if($autoreply_type_id==1){
  $content=getstr($_POST['content']);
  updatetable(tname('open_member_weixin_autoreply'),array('autoreply_type_id'=>$autoreply_type_id,'content'=>$content,'keyword'=>$keyword,'islike'=>$islike),array('id'=>$autoreply_id));
}

if($autoreply_type_id==2){
  $title=getstr($_POST['title']);	
  $desc=getstr($_POST['desc']);	
  $content=getstr($_POST['content']);
  $pic=getstr($_POST['pic']);
  $url=getstr($_POST['url']);
  $wz_mid=intval($_POST['wz'])?intval($_POST['wz']):0;
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply_info').' where autoreply_type_id=2 and autoreply_id='.$autoreply_id);
  inserttable(tname('open_member_weixin_autoreply_info'),array('autoreply_id'=>$autoreply_id,'autoreply_type_id'=>$autoreply_type_id,'title'=>$title,'summary'=>$desc,'content'=>$content,'pic'=>$pic,'url'=>$url,'wz_mid'=>$wz_mid,'sort_order'=>0,'addtime'=>$_SGLOBAL['timestamp']));
  updatetable(tname('open_member_weixin_autoreply'),array('autoreply_type_id'=>$autoreply_type_id,'keyword'=>$keyword,'islike'=>$islike),array('id'=>$autoreply_id));
	
}

if($autoreply_type_id==3){
  $msgitem=json_decode(stripslashes($_POST['msgitem']),true);
  $_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply_info').' where autoreply_type_id=3 and autoreply_id='.$autoreply_id);
  foreach($msgitem as $k=>$v){
    inserttable(tname('open_member_weixin_autoreply_info'),array('autoreply_id'=>$autoreply_id,'autoreply_type_id'=>$autoreply_type_id,'title'=>getstr($v['title']),'content'=>getstr($v['content']),'pic'=>getstr($v['pic']),'url'=>getstr($v['url']),'wz_mid'=>intval($v['wz'])?intval($v['wz']):0,'sort_order'=>($k+1),'addtime'=>$_SGLOBAL['timestamp']));	
  }
  updatetable(tname('open_member_weixin_autoreply'),array('autoreply_type_id'=>$autoreply_type_id,'keyword'=>$keyword,'islike'=>$islike),array('id'=>$autoreply_id));
}
 $json=array('err'=>0,'errmsg'=>'修改成功');
 echo json_encode($json);	
break;
case "keywordreply_del":
$autoreply_id=intval($_POST['autoreply_id'])?intval($_POST['autoreply_id']):0;
$id=$_SGLOBAL['db']->getone('select wxid from '.tname('open_member_weixin_autoreply').' where id='.$autoreply_id);
check_role($id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply').' where id='.$autoreply_id);
$_SGLOBAL['db']->query('delete from '.tname('open_member_weixin_autoreply_info').' where autoreply_id='.$autoreply_id);
$json=array('err'=>0,'errmsg'=>'删除成功');
echo json_encode($json);	
break;		
default:
$total=getcount(tname('open_member_weixin'),array('op_uid'=>$_SGLOBAL['uid']));
$smarty->assign('total',$total);
$account=$_SGLOBAL['db']->getall('select * from '.tname('open_member_weixin').' where op_uid='.$_SGLOBAL['uid']);
foreach($account as $k=>$v){
  $account[$k]['headimg']=$_SC['siteurl'].'uploads/weixin_headimg/'.$v['fakeid'].'.png';
}
$smarty->assign('account',$account);
$smarty->display('wx_account.dwt');
break;							   
}

function check_role($id){
 global $_SGLOBAL;
 if(!getcount(tname('open_member_weixin'),array('id'=>$id,'op_uid'=>$_SGLOBAL['uid']))){
	exit(); 
 }
}

?>								
