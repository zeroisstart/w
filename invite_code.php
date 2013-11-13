<?php
include_once('./common.php');

$ac=$_REQUEST["ac"];
switch ($ac)
{
case "check_email":
$email=getstr($_REQUEST['email']);
$query= $_SGLOBAL['db']->query("SELECT username FROM ".tname("open_member")." where email_valid=1 and email='".$email."'");
$total=$_SGLOBAL['db']->num_rows($query);
include_once('./source/function_user.php');
if(is_email($email) && $total==0){
$arr['err']=0;
}else{
$arr['err']=1;
}
echo json_encode($arr);
break;
case "buildcode":
$arr['email']=getstr($_POST['email']);
$arr['fullname']=getstr($_POST['fullname']);
$arr['corp']=getstr($_POST['corp']);
$arr['mobile']=getstr($_POST['mobile']);
if(submitcheck('_submit')) {
	
$query= $_SGLOBAL['db']->query("SELECT uid FROM ".tname("open_member")." where email_valid=1 and email='".$arr['email']."'");
$total=$_SGLOBAL['db']->num_rows($query);
include_once('./source/function_user.php');
if($total>0){
  showmessage('此邮箱已被注册');
  gourl('register.php');
  exit;	
}
if(!is_email($arr['email']) || $arr['fullname']=='' || $arr['corp']=='' || !is_mobile($arr['mobile'])){
  showmessage('申请信息填写不正确');
  gourl('invite_code.php');
  exit;	
}//end if

$query= $_SGLOBAL['db']->query("SELECT email FROM ".tname("open_invite_code")." where email='".$arr['email']."'");
$total=$_SGLOBAL['db']->num_rows($query);
if($total>0){
  showmessage('此邮箱已申请过邀请码,请等待我们的回复。');
  gourl('register.php');
  exit;	
}

$arr['code']=random(6,1);
$arr['used']=0;
$arr['addtime']=$_SGLOBAL['timestamp'];
inserttable(tname("open_invite_code"), $arr);

//生成申请邮件
$title='['.$_SC['site_name'].']'.$arr['fullname'].'申请邀请码';
$msg='姓名:'.$arr['fullname'].'<br />公司:'.$arr['corp'].'<br />email:'.$arr['email'].'<br />电话:'.$arr['mobile'].'<br />邀请码:'.$arr['code'];
				
//发送验证邮件
include_once('./source/function_sendmail.php');
$email_result=sendmail($arr['email'],$title,$msg);


//预注册
$pass1=random(10);
$pass2=$pass1;	
       $query= $_SGLOBAL['db']->query("SELECT uid FROM ".tname("open_member")." where email='".$email."'");
       $total=$_SGLOBAL['db']->num_rows($query);	   
       include_once('./source/function_user.php');
       if(is_email($email) && $total==0 && $pass1==$pass2 && $pass1!=''){
                $salt=random(6);
	            $passwordmd5=md5($pass1);
	            $password=md5($passwordmd5.$salt);
                $setarr=array(
                   "email"=>$email,
                   "username"=>$email,
	               "password"=>$password,
	               "salt"=>$salt,
	               "state"=>0,
	               "email_valid"=>0,
                   "regtime"=>$_SGLOBAL['timestamp']
                );
				$setarr['fullname']=getstr($_POST['fullname']);
                $setarr['mobile']=getstr($_POST['mobile']);
				$setarr['email']=getstr($_POST['email']);

                $uid=inserttable(tname("open_member"), $setarr,1);
      }else{
           showmessage('表单有误，请重新填写!');
	       $arr['err']=2;
	       gourl('invite_code.php');
		   exit();
      }
//end 预注册

				
showmessage('核实信息后，我们将通过邮箱把邀请码发送给您!');	  
gourl('register.php');
exit();
}
break;
default:
$email=getstr($_GET['email']);
$smarty->assign('email', $email);

$smarty->display('invite_code.dwt');
break;
}
?>