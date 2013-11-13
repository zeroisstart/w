<?php
include_once('./common.php');
$backurl=empty($_GET['backurl'])?'user.php':$_GET['backurl'];
$smarty->assign('backurl', $backurl);
$ac=$_POST["ac"];
switch ($ac)
{
case "check_email":
$email=getstr($_POST["email"]);
$query= $_SGLOBAL['db']->query("SELECT m.username FROM ".tname("open_member")." as m where m.state=1 and m.email='".$email."'");
$total=$_SGLOBAL['db']->num_rows($query);
include_once('./source/function_user.php');
if(is_email($email) && $total==0){
$arr['err']=0;
}else{
$arr['err']=1;
}
echo json_encode($arr);
break;
case "reg":
$email=getstr($_POST["email"]);
$pass1=getstr($_POST["pass1"]);
$pass2=getstr($_POST["pass2"]);
$invite_code=getstr($_POST["invite_code"]);

if(submitcheck('_submit')) {


       $query= $_SGLOBAL['db']->query("SELECT email FROM ".tname("open_invite_code")." where used=0 and code='".$invite_code."' and email='".$email."'");
       $total=$_SGLOBAL['db']->num_rows($query);
	   if($total!=1){
            showmessage('邀请码错误，请先申请邀请码');
			gourl('invite_code.php');
			exit();		   
	   }
	
       $query= $_SGLOBAL['db']->query("SELECT uid FROM ".tname("open_member")." where state=1 and email='".$email."'");
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
	               "state"=>1,
	               "email_valid"=>0,
                   "regtime"=>$_SGLOBAL['timestamp']
                );
	            $uid=$_SGLOBAL['db']->getone("select uid from ".tname("open_member")." where state=0 and email='$email'");
	            if(!$uid){
                   $uid=inserttable(tname("open_member"), $setarr,1);
	            }else{
                    updatetable(tname("open_member"),$setarr,array("uid"=>$uid));	  
	            }

               //注册成功,关闭邀请码
			   //updatetable(tname("open_invite_code"),array('used'=>1),array("email"=>$email));

			   //生成邮箱验证链接
			   $backurl=$_POST['backurl'];
               $email_reg_url=email_reg($email,$backurl);
			   //end邮箱验证链接

			   //加入验证文字
			   $reg_msg='欢迎注册'.$_SC['site_name'].'。<br />请点击以下链接，完成'.$_SC['site_name'].'的注册：<br /><a href="'.$email_reg_url.'">点此链接</a> <br /> 或者复制以下字符串到浏览器地址栏：<br />'.$email_reg_url.' <br />
如您有任何问题，请发邮件至 service@sylai.com或私信新浪微博账号： <a href="http://weibo.com/sylaicom">@乘亿科技</a> <br /><br /><br /><br /><br /><br />'.date("Y-m-d");
				
			   //发送验证邮件
			   include_once('./source/function_sendmail.php');
			   $email_result=sendmail($email,$_SC['sitename'].'注册确认',$reg_msg);
				
               showmessage('请登录您的邮箱完成注册!');
			   gourl('index.php');	  
			   exit();
      }else{
           showmessage('表单有误，请重新填写!');
	       $arr['err']=2;
	       gourl('register.php');
		   exit();
      }
}
$arr['err']=3;
gourl('register.php');
break;
default:
$smarty->display('register.dwt');
break;
}


function email_reg($email,$backurl=''){
global $_SGLOBAL,$_SC;
				 $email_reg['email']=$email;
				 $email_reg['ip']=getonlineip(1);
			     $email_reg['salt']=random(6);
				 $email_reg['hash']=substr(md5(md5($email).$email_reg['salt']),8,7);
				 $email_reg['addtime']=$_SGLOBAL['timestamp'];
				 $email_reg['used']=0;
				 $email_reg['backurl']=$backurl;
				 $id=inserttable(tname("open_email_reg"),$email_reg,1,1);
				 $h=$email_reg['hash'];
     return $_SC['site_host']."/?r=".$h;
}
?>