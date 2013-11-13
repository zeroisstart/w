<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['_SC']['site_name']; ?></title>
<link href="<?php echo $this->_var['template_path']; ?>/css/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->_var['template_path']; ?>/css/form.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->_var['template_path']; ?>/css/jquery_cbox.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->_var['template_path']; ?>/script/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/script/utils.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/script/jquery.colorbox-min.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/script/jquery.upload.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/script/WebCalendar.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/ueditor/ueditor.config.js" type="text/javascript"></script>
<script src="<?php echo $this->_var['template_path']; ?>/ueditor/ueditor.all.min.js" type="text/javascript"></script>
</head>
<body>

<?php echo $this->fetch('lib/page_header.lbi'); ?>
 
<style>
.cover-area {
	margin-left:120px;
    max-width: 297px;
    padding: 0;
    width: 297px;
}
.msg-input, .cover-area, .msg-txta {
    background-color: #FFFFFF;
    border: 1px solid #D3D3D3;
    color: #666666;
    max-width: 280px;
    padding: 2px 8px;
    width: 280px;
}
.cover-hd {
    padding: 2px 8px 3px;
    position: relative;
}
.cover-hd .upload-btn {
    background-position: 0 -251px;
    color: #666666;
    display: inline-block;
    line-height: 28px;
    margin-right: 12px;
}
.oh {
    overflow: hidden;
}


</style>

<div class="container" id="main">
	<div class="containerBox">
		<div class="boxHeader">
			<h2>&nbsp;&nbsp;</h2>
		</div>
		<div class="content">
			<div class="newTips"> <a href=""> <span id="newMsgNum">0</span>条新消息，点击查看 </a> </div>
			<div class="containerBox boxIndex">
				<div class="rn-box check-box" style="display: block;">
					<form id="form-profile">
						<div class="frm">
							<div class="frm-hd">
								<h3 class="frm-t">内容设置</h3>
								<p class="frm-tip"> </p>
								<p></p>
							</div>
							<div class="frm-nav">
								<div id="regKindBody">
									<div class="frm-bd mp-reg-person">
										<div class="frm-section">
											
											<?php $_from = $this->_var['_WZ']['profile']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'p');if (count($_from)):
    foreach ($_from AS $this->_var['p']):
?> 
											   <?php if ($this->_var['p']['type'] == 'text'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['p']['title']; ?></label>																						    													<div class="frm-controls">
														  <input type="text" class="frm-controlM" placeholder="" name="<?php echo $this->_var['p']['var']; ?>[<?php echo $this->_var['p']['id']; ?>]" value="<?php echo $this->_var['p']['value']; ?>">
														  <span id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_notice" class="desc">&nbsp;</span>
														</div>
												</div>
											   <?php endif; ?>
											   <?php if ($this->_var['p']['type'] == 'pic'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['p']['title']; ?></label>																						    													<div class="cover-area">
                                                              <div class="oh z cover-hd">
                                                                  <a class="icon28C upload-btn cboxElement" data-id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>" href="#inline_content">上传</a>
                                                              </div>
															  <input type="hidden" class="frm-controlM" placeholder="" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>" name="<?php echo $this->_var['p']['var']; ?>[<?php echo $this->_var['p']['id']; ?>]" value="<?php echo $this->_var['p']['value']; ?>">
                                                        </div>
														<span id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_notice" class="desc">&nbsp;</span>
														<div><img id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_img" src="<?php echo $this->_var['p']['value']; ?>" /></div>
														
												</div>
											   <?php endif; ?>
											   
											   <?php if ($this->_var['p']['type'] == 'content'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['p']['title']; ?></label>
													<div class="frm-controls">
														<textarea name="<?php echo $this->_var['p']['var']; ?>[<?php echo $this->_var['p']['id']; ?>]" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>" style="height:300px;"><?php echo $this->_var['p']['value']; ?></textarea>
														<span id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_notice" class="desc">&nbsp;</span> </div>
												</div>
											   <?php endif; ?>
											   
											   <?php if ($this->_var['p']['type'] == 'subbtn'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['p']['title']; ?></label>																				    												<span id="<?php echo $this->_var['p']['var']; ?>_<?php echo $this->_var['p']['id']; ?>_notice" class="desc">&nbsp;</span>
												</div>
												<?php $_from = $this->_var['p']['son']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 's');if (count($_from)):
    foreach ($_from AS $this->_var['s']):
?>
											   <?php if ($this->_var['s']['type'] == 'text'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['s']['title']; ?></label>																						    													<div class="frm-controls">
														  <input type="text" class="frm-controlM" placeholder="" name="<?php echo $this->_var['s']['var']; ?>[<?php echo $this->_var['s']['id']; ?>]" value="<?php echo $this->_var['s']['value']; ?>">
														  <span id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_notice" class="desc">&nbsp;</span>
														</div>
												</div>
											   <?php endif; ?>
											   <?php if ($this->_var['s']['type'] == 'pic'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['s']['title']; ?></label>																						    													<div class="cover-area">
                                                              <div class="oh z cover-hd">
                                                                  <a class="icon28C upload-btn cboxElement" data-id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>" href="#inline_content">上传</a>
                                                              </div>
															  <input type="hidden" class="frm-controlM" placeholder="" id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>" name="<?php echo $this->_var['s']['var']; ?>[<?php echo $this->_var['s']['id']; ?>]" value="<?php echo $this->_var['s']['value']; ?>">
                                                        </div>
														<span id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_notice" class="desc">&nbsp;</span>
														<div><img id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_img" src="<?php echo $this->_var['s']['value']; ?>" /></div>
												</div>
											   <?php endif; ?>
											   
											   <?php if ($this->_var['s']['type'] == 'content'): ?>
												<div class="group frm-control-group extra" id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_group">
													<label select="option" class="frm-control-label" for=""><?php echo $this->_var['s']['title']; ?></label>
													<div class="frm-controls">
														<textarea name="<?php echo $this->_var['s']['var']; ?>[<?php echo $this->_var['s']['id']; ?>]" id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>" style="height:300px;"><?php echo $this->_var['s']['value']; ?></textarea>
														<span id="<?php echo $this->_var['s']['var']; ?>_<?php echo $this->_var['s']['id']; ?>_notice" class="desc">&nbsp;</span> </div>
												</div>
											   <?php endif; ?>
												<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											   <?php endif; ?>
												
												
											<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


												
																								
										</div>
									</div>
								</div>
								<div class="frm-ft">
									<div class="frm-opr"> <a class="btnGreen" id="form-submit" href="javascript:;">内容提交</a>
										<input type="hidden" name="mid" value="<?php echo $this->_var['module']['id']; ?>" />
										<input type="hidden" name="_submit" id="_submit" value="submit" />
										<input type="hidden" name="formhash" value="<?php echo $this->_var['formhash']; ?>" />
										<input type="hidden" name="ac" value="updatecontent" />
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
			<div class="sideBar">
				<div class="catalogList">
					<ul class="shaixuan">
						<li class=""> <a href="wx_weizhan.php">返回</a> </li>
						<!--
						<li class=" subCatalogList "> <a href="">今天</a> </li>
						<li class="  "> <a href="">星标咨询</a> </li>
					    -->
					</ul>
					
				</div>
			</div>
		<div class="clr"></div>
	</div>
</div>


<div style="height:100px"></div>


<?php echo $this->fetch('lib/page_footer.lbi'); ?>


<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
		<p>选择图片:
			<input type="file" id="file1" name="file1" style="width:300" value="">
			<input type="hidden" id="fid" value="" />
		</p>
		<p>
			<input type="button" id="beginupload" name="beginupload" value="开始上传" class="form-button" />
		</p>
		<p id="popdiv_msg"></p>
	</div>
</div>


<script>
var editor= new Array();
$('textarea').each(function(i,n){
	editor[i] = new UE.ui.Editor();
    editor[i].render($(this).attr('id'));
});

$('#form-submit').click(function(){
$('#form-profile').attr('method','post');
$('#form-profile').attr('action','wx_weizhan.php');
$('#form-profile').submit();
});

/*上传图片*/
    $(".upload-btn").colorbox({inline:true, width:"50%",height:"400px"});
	$(".upload-btn").click(function(){
		$('#fid').val($(this).attr('data-id'));
	   
	});

	$('#beginupload').click(function() {
      if($('#file1').val()!=''){									 
      $('#file1').upload('wx_weizhan.php?ac=upload', function(json) {
		   if(json.err==0){
			   $('#'+$('#fid').val()).val(json.filename);			
			 $('#'+$('#fid').val()+'_img').attr('src',json.filename);
			 $("#inline_content").colorbox.close();
		   }else{
			 $('#popdiv_msg').html(json.msg);  
		   }
      }, 'json');
	  }else{
			 $('#popdiv_msg').html('必须选择一个图文件');  
	  }
    });
/*上传图片 end*/


</script>
</body>
</html>