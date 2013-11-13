<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['_SC']['site_name']; ?></title>
<link href="<?php echo $this->_var['template_path']; ?>/css/common.css" rel="stylesheet" type="text/css"> 
<link href="<?php echo $this->_var['template_path']; ?>/css/form.css" rel="stylesheet" type="text/css"> 
<script src="<?php echo $this->_var['template_path']; ?>/script/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/script/utils.min.js" type="text/javascript"></script>
</head>
<body>

<?php echo $this->fetch('lib/page_header.lbi'); ?>



<div class="container" id="main">
   <div class="containerBox boxIndex">
   <div class="rn-box check-box" style="display: block;">
        <form id="form-editprofile">      
        <div class="frm">
             <div class="frm-hd">
              <h3 class="frm-t">设置您的帐号资料</h3>
                <p class="frm-tip">  </p>
                  <p></p>
              </div>
              <div class="frm-nav">

                
                <div id="regKindBody"> <div class="frm-bd mp-reg-person">   
                <div class="frm-section">     <div class="section-bd">
                
                <div class="group frm-control-group extra" id="name_group">         
                <label select="option" class="frm-control-label" for="">姓名</label>
                     <div class="frm-controls">
                     <input type="text" class="frm-controlM" placeholder="" id="fullname" name="fullname" value="<?php echo $this->_var['_SGLOBAL']['fullname']; ?>">
                     <span id="fullname_notice" class="desc">如果名字包含分隔号“·”，请勿省略。</span>
                     </div>
                </div>

                <div class="group frm-control-group extra" id="mobile_group">         
                <label select="option" class="frm-control-label" for="">手机号</label>
                     <div class="frm-controls">
                     <input type="text" class="frm-controlM" placeholder="" id="mobile" name="mobile" value="<?php echo $this->_var['_SGLOBAL']['mobile']; ?>">
                     <span id="mobile_notice" class="desc">&nbsp;</span>
                     </div>
                </div>


                <div class="group frm-control-group extra" id="pass1_group">         
                <label select="option" class="frm-control-label" for="">新密码</label>
                     <div class="frm-controls">
                     <input type="password" class="frm-controlM" placeholder="" id="pass1" name="pass1" value="">
                     <span id="pass1_notice" class="desc">不修改请留空</span>
                     </div>
                </div>


                
                     </div>   </div> </div> </div>
                     <div class="frm-ft">
                         <div class="frm-opr">
                             <a class="btnGreen" id="form-submit" href="javascript:;">继续</a>
                             <input type="hidden" name="backurl" value="<?php echo $this->_var['backurl']; ?>" />
                             <input type="hidden" name="_submit" id="_submit" value="submit" />
                             <input type="hidden" name="formhash" value="<?php echo $this->_var['formhash']; ?>" />
                             <input type="hidden" name="ac" value="editprofile" />
                         </div>
                     </div>
              </div></div>  
             </form>    
   </div>
</div>
</div>


<div style="height:100px"></div>


<?php echo $this->fetch('lib/page_footer.lbi'); ?>



<script>
$('#form-submit').click(function(){
if(check_submit()){
$('#form-editprofile').attr('method','post');
$('#form-editprofile').attr('action','profile.php');
$('#form-editprofile').submit();
}
});

function check_submit()
{
    var submit_disabled = false;

	if(!check_fullname()){
	  submit_disabled = true;
	}

	if(!check_mobile()){
	  submit_disabled = true;
	}
	
    if ( submit_disabled )
    {
        return false;
    }
	else{
        return true;
	}	
}

function check_fullname(){
  fullname=$('#fullname').val();
  if ( fullname.length < 2)
  {
        $('#fullname_notice').html('姓名不能少于2个字');
		$('#fullname').focus();
		return false;
  }else if(fullname.length>15 )
  {
        $('#fullname_notice').html('姓名不能多于15个字');
		$('#fullname').focus();
		return false;
  }
  else
  {
      $('#fullname_notice').html('OK');
      return true;
  }
}

function check_mobile(){
  mobile=$('#mobile').val();
  if (mobile == '')
  {
    $('#mobile_notice').html("手机号不能为空");
    $('#mobile').focus();
    return false;
  }
  else if (!Utils.isMobile(mobile))
  {
    $('#mobile_notice').html("请按手机格式填写");
    $('#mobile').focus();
    return false;
  }
  else
  {
      $('#mobile_notice').html('OK');
      return true;
  }
}
</script>
</body></html>