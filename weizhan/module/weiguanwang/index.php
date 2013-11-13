<?php



$ac=getstr($_GET['ac']);
    switch($ac){
		case 'show':
		$pid=intval($_GET['pid'])?intval($_GET['pid']):0;		
        $query=$_SGLOBAL['db']->query('select * from '.tname('wz_module_profile').' where id='.$pid);
        $profile=$_SGLOBAL['db']->fetch_array($query);
	    if(!$profile) exit;
		$profile['son']=$_SGLOBAL['db']->getall('select * from '.tname('wz_module_profile').' where parent_id='.$pid);
		foreach($profile['son'] as $k=>$v){
			if($v['type']=='content'){
			  $site[$v['var']]=htmlspecialchars_decode($v['value']);
			}else{
			  $site[$v['var']]=$v['value'];
			}
		}
		$smarty->assign('site',$site);		  
		$smarty->assign('profile',$profile);		  
		$smarty->display('appmsg.dwt');
		break;
		default:
		/*
		  if(!$_SGLOBAL['isauth']){
	          echo 'access denied';
	         exit;
          }
		*/
		  		
        $site=get_profile($module['profile']);		  
		 //print_r($site);
		 //exit;
		  $smarty->assign('site',$site);		  
          $smarty->display('index.dwt');
	}
?>