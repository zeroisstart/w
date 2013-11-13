<?php



$ac=getstr($_GET['ac']);
    switch($ac){
		case 'pic1':
          $smarty->display('pic1.dwt');
		break;
		case 'pic2':
          $smarty->display('pic2.dwt');
		break;
		case 'pic3':
          $smarty->display('pic3.dwt');
		break;
		case 'pic4':
          $smarty->display('pic4.dwt');
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