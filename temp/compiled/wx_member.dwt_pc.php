<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['_SC']['site_name']; ?></title>
<link href="<?php echo $this->_var['template_path']; ?>/css/common.css" rel="stylesheet" type="text/css"> 
<link href="<?php echo $this->_var['template_path']; ?>/css/table.css" rel="stylesheet" type="text/css"> 
<script src="<?php echo $this->_var['template_path']; ?>/script/jquery-1.8.2.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/script/utils.min.js"></script>
</head>
<body>


<?php echo $this->fetch('lib/page_header.lbi'); ?>




<div class="container-wrapper">
	<div class="container" id="main">
		<div class="containerBox">
			<div class="boxHeader">
				<h2>会员管理</h2>
			</div>
			<div class="content">
				<div class="newTips"> <a href=""> <span id="newMsgNum">0</span>条新消息，点击查看 </a> </div>
				<div class="cLine">
					<h3 class="left" id="msg_title">  </h3>
					<div class="searchbar right">
					<!--
						<select id="search_field" class="txt left" style="height:29px;">
						<option value="province" selected>地区</option>
						<option value="content">内容</option>
						<option value="nickname">会员</option>
						</select>
						<input type="text" id="msgSearchInput" class="txt left" value="" placeholder="输入内容搜索">
						<button id="msgSearchBtn" href="javascript:;" class="btnGrayS left" title="搜索" type="button">搜索</button>					
					-->
					</div>
					<div class="clr"></div>
				</div>
			
			
				<div class="cLine">
					<div class="pageNavigator right"> <span> <a class="prePage" href="wx_member.php?page=<?php echo $this->_var['members']['prepage']; ?>"> 上一页 </a> </span> <span class="pageNum"><?php echo $this->_var['members']['page']; ?> / <?php echo $this->_var['members']['pagenum']; ?></span> <span> <a class="nextPage" href="wx_member.php?page=<?php echo $this->_var['members']['nextpage']; ?>"> 下一页 </a> </span> </div>
				</div>
	
			<?php if ($this->_var['members']['total'] > 0): ?>
				<div class="msgWrap">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="ListProduct">
              <thead>
                <tr>
				  <th><input type="checkbox"  class="checkall"/></th>
                  <th>会员名字</th>
                </tr>
              </thead>
              <tbody>
                <tr></tr>
                
     <?php $_from = $this->_var['members']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'm');if (count($_from)):
    foreach ($_from AS $this->_var['m']):
?> 
                <tr>
				<td style="text-align:center"><input type="checkbox" name="check[]" value="<?php echo $this->_var['m']['uid']; ?>" /></td>
			  <td><p><a target="_blank" href="wx_singlemsg.php?wxid=<?php echo $this->_var['m']['wxid']; ?>"><img width="40" height="40" src="<?php echo $this->_var['m']['headimg']; ?>" onerror="this.src='<?php echo $this->_var['_SC']['siteurl']; ?>themes/pc/mpres/htmledition/images/default_avator.png'"></a></p><p><?php echo $this->_var['m']['fullname']; ?></p><p>(所属公众号:<?php echo $this->_var['m']['weixin_name']; ?>)</p></td>
                </tr>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                               

              </tbody>
            </table>
          </div>
		  <?php endif; ?>
				
				<div class="cLine">
					<div class="pageNavigator right"> <span> <a class="prePage" href="wx_member.php?page=<?php echo $this->_var['members']['prepage']; ?>"> 上一页 </a> </span> <span class="pageNum"><?php echo $this->_var['members']['page']; ?> / <?php echo $this->_var['members']['pagenum']; ?></span> <span> <a class="nextPage" href="wx_member.php?page=<?php echo $this->_var['members']['nextpage']; ?>"> 下一页 </a> </span> </div>
				</div>

				
			</div>
			<div class="sideBar">
				<div class="catalogList">
					<ul class="shaixuan">
						<li <?php if ($this->_var['members']['op_wxid'] == 0): ?> class="selected" <?php endif; ?>> <a href="wx_member.php">全部会员</a> </li>
						<?php $_from = $this->_var['account']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'acc');if (count($_from)):
    foreach ($_from AS $this->_var['acc']):
?>
						<li <?php if ($this->_var['members']['op_wxid'] == $this->_var['acc']['id']): ?> class="selected" <?php endif; ?>> <a href="wx_member.php?op_wxid=<?php echo $this->_var['acc']['id']; ?>"><?php echo $this->_var['acc']['weixin_name']; ?></a> </li>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
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
	 
</div>










 

<?php echo $this->fetch('lib/page_footer.lbi'); ?>


<script>
$(function(){
				   $('.checkall').click(function(){
						 if($(this).attr("checked")=='checked'){
                           $('.msgWrap input[type=checkbox]').attr("checked", true);
						 }else{
                           $('.msgWrap input[type=checkbox]').attr("checked", false);
						 }
					});
});
</script>
</body></html>