<?php
include_once('./common.php');
if($_SGLOBAL['login']==false){
gourl('index.php');
exit();
}

$datearr=array( "天 ", "一 ", "二 ", "三 ", "四 ", "五 ", "六 ");                
$ac=$_REQUEST["ac"];
switch ($ac)
{
case "upload":	
	if($_FILES['file1']['name'] != ""){
		//包含上传文件类
		require_once ('upload.php');
		//设置文件上传目录
		$savePath = "uploads/weizhan/";
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
        $jsondata = $jsondata . chr(34)."filename".chr(34).":".chr(34).$_SC['site_host'].'/uploads/weizhan/'.$path.chr(34).",";
        $jsondata = $jsondata . chr(34)."path".chr(34).":".chr(34).$path.chr(34).",";
        $jsondata = $jsondata . chr(34)."msg".chr(34).":".chr(34)."文件上传成功!请不要修改生成的链接地址！".chr(34); 
        $jsondata = $jsondata . "}";
		}//end if
		echo $jsondata;
	}
break;
case 'updatecontent':
$mid=intval($_POST['mid'])?intval($_POST['mid']):0;
$query=$_SGLOBAL['db']->query('select * from '.tname('wz_module').' where id='.$mid);
$module=$_SGLOBAL['db']->fetch_array($query);
$module['module_template']=$module['module_default_template'];
if(file_exists(S_ROOT.'./weizhan/module/'. $module['module_dir'] . '/config.php')){
   include_once(S_ROOT.'./weizhan/module/'. $module['module_dir'] . '/config.php');	
}
$profile=$_WZ['profile'];
$op_uid=$_SGLOBAL['uid'];
foreach($profile as $k=>$v){

		$id=$_SGLOBAL['db']->getone('select id from '.tname('wz_module_profile').' where sort='.$v['sort'].' and parent_id=0 and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$v['var'].'"');
	    $arr['value']=getstr($_POST[$v['var']][$id]);
		if($id){
			updatetable(tname('wz_module_profile'),$arr,array('id'=>$id));
		}
	if($v['type']=='subbtn'){
		foreach($profile[$k]['son'] as $key=>$value){
		  $sid=$_SGLOBAL['db']->getone('select id from '.tname('wz_module_profile').' where sort='.$value['sort'].' and parent_id='.$id.' and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$value['var'].'"');
		  $arr['value']=getstr($_POST[$value['var']][$sid]);
		  if($sid){
			  updatetable(tname('wz_module_profile'),$arr,array('id'=>$sid));
		  }
		}		
	}
}
showmessage('编辑成功');
gourl('wx_weizhan.php?ac=content&mid='.$mid);
break;	
case 'content':
$mid=intval($_GET['mid'])?intval($_GET['mid']):0;
$query=$_SGLOBAL['db']->query('select * from '.tname('wz_module').' where id='.$mid);
$module=$_SGLOBAL['db']->fetch_array($query);
$module['module_template']=$module['module_default_template'];
if(file_exists(S_ROOT.'./weizhan/module/'. $module['module_dir'] . '/config.php')){
   include_once(S_ROOT.'./weizhan/module/'. $module['module_dir'] . '/config.php');	
}
$op_uid=$_SGLOBAL['uid'];
foreach($_WZ['profile'] as $k=>$v){
	$_WZ['profile'][$k]['id']=$_SGLOBAL['db']->getone('select id from '.tname('wz_module_profile').' where parent_id=0 and sort='.$v['sort'].' and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$v['var'].'"');
	if(!$_WZ['profile'][$k]['id']){
		$arr=array(
		   'op_uid'=>$op_uid,
		   'module_id'=>$mid,
		   'parent_id'=>0,
	       'var'=>$v['var'],
	       'type'=>$v['type'],
	       'title'=>$v['title'],
	       'value'=>'',
	       'sort'=>$v['sort']?$v['sort']:0,
		   'addtime'=>$_SGLOBAL['timestamp'],
		);
		$_WZ['profile'][$k]['id']=inserttable(tname('wz_module_profile'),$arr,1);	
	}
    $_WZ['profile'][$k]['value']=$_SGLOBAL['db']->getone('select value from '.tname('wz_module_profile').' where parent_id=0 and sort='.$v['sort'].' and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$v['var'].'"');

	if($v['type']=='subbtn'){
		foreach($_WZ['profile'][$k]['son'] as $key=>$value){
	         $_WZ['profile'][$k]['son'][$key]['id']=$_SGLOBAL['db']->getone('select id from '.tname('wz_module_profile').' where parent_id='.$_WZ['profile'][$k]['id'].' and sort='.$value['sort'].' and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$value['var'].'"');
			 if(!$_WZ['profile'][$k]['son'][$key]['id']){
		           $arr=array(
		               'op_uid'=>$op_uid,
		               'module_id'=>$mid,
		               'parent_id'=>$_WZ['profile'][$k]['id'],
	                   'var'=>$value['var'],
	                   'type'=>$value['type'],
	                   'title'=>$value['title'],
	                   'value'=>'',
	                   'sort'=>$value['sort']?$value['sort']:0,
		               'addtime'=>$_SGLOBAL['timestamp'],
		            );
				$_WZ['profile'][$k]['son'][$key]['id']= inserttable(tname('wz_module_profile'),$arr,1);
			 }
	         $_WZ['profile'][$k]['son'][$key]['value']=$_SGLOBAL['db']->getone('select value from '.tname('wz_module_profile').' where parent_id='.$_WZ['profile'][$k]['id'].' and sort='.$value['sort'].' and op_uid='.$op_uid.' and module_id='.$mid.' and var="'.$value['var'].'"');
		}		
	}
}
//print_r($_WZ['profile']);
//exit;
$smarty->assign('_WZ',$_WZ);
$smarty->assign('module',$module);
$smarty->display('wx_weizhan_content.dwt');
break;	
default:
$total=getcount(tname('wz_module'));
$smarty->assign('total',$total);
$weizhan=$_SGLOBAL['db']->getall('select * from '.tname('wz_module'));
foreach($weizhan as $k=>$v){	
}
$smarty->assign('weizhan',$weizhan);
$smarty->display('wx_weizhan.dwt');
break;							   
}
?>								
