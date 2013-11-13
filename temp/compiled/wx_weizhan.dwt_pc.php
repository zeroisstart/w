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
				<h2>微站管理</h2>
			</div>
			<div class="content">
				<div class="newTips"> <a href=""> <span id="newMsgNum">0</span>条新消息，点击查看 </a> </div>
				<div class="cLine">
					<h3 class="left" id="msg_title">  </h3>
					<div class="searchbar right">
					</div>
					<div class="clr"></div>
				</div>
				
			<?php if ($this->_var['total'] > 0): ?>
				<div class="msgWrap">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="ListProduct">
              <thead>
                <tr>
                  <th>微站名称</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <tr></tr>
                
     <?php $_from = $this->_var['weizhan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'wz');if (count($_from)):
    foreach ($_from AS $this->_var['wz']):
?> 
                <tr>
			  <td><?php echo $this->_var['wz']['module_name']; ?></td>
                  <td class="norightborder">&#12288;<a href="wx_weizhan.php?ac=content&mid=<?php echo $this->_var['wz']['id']; ?>">内容管理</a></td>
                </tr>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                               

              </tbody>
            </table>
          </div>
		  <?php endif; ?>
								
			</div>
			<div class="sideBar">
				<div class="catalogList">
					<ul class="shaixuan">
						<li class="selected"> <a href="wx_weizhan.php">微站管理</a> </li>
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

</body></html>