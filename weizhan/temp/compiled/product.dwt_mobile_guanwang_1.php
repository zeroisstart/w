<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="target-densitydpi=medium-dpi, width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1,user-scalable=no">
<meta name="format-detection" content="telephone=yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title><?php echo $this->_var['product']['corpname']; ?>-<?php echo $this->_var['product']['product_name']; ?></title>
<link rel="stylesheet"  href="<?php echo $this->_var['template_path']; ?>/css/mobile.css" />
<link rel="stylesheet"  href="<?php echo $this->_var['template_path']; ?>/css/goods.css" />

</head>
<body class="ui-mobile-viewport">


<div class="ui-header ui-bar-d">
<a onclick="window.location.href='c.php?id=<?php echo $this->_var['product']['corp_id']; ?>&dwt=product_list';" class="ui-btn-left ui-btn ui-btn-up-d">
<span class="ui-btn-inner">
<span class="ui-btn-text">&lt;返回</span>
</span>
</a>
<h1 class="ui-title" style="margin: 0.6em 0 0.8em;"><?php echo $this->_var['product']['product_name']; ?></h1>
</div>



<div class="content">
<div class="LM-wrapper">
	<div class="LM-scroller">
      <div class="nmain">
      <img src="uploads/products/<?php echo $this->_var['product']['pic']; ?>"  class="nimg" />
      <?php if ($this->_var['product']['product_descr'] != ''): ?>
      <p class="goods-info"><a><span><?php echo $this->_var['product']['product_descr']; ?></span></a></p>
      <?php endif; ?>
      <?php if ($this->_var['product']['corp_address'] != ''): ?> 
      <p class="goods-info"><a><span><?php echo $this->_var['product']['corp_address']; ?></span></a></p>
      <?php endif; ?>
      <?php if ($this->_var['product']['corp_phone'] != ''): ?>
      <p class="goods-info"><a href="tel:<?php echo $this->_var['product']['corp_phone']; ?>" style="text-decoration:none"><span>电话:<?php echo $this->_var['product']['corp_phone']; ?></span></a></p>
      <?php endif; ?>  
      </div>
      
      <p></p>      
</div>

   </div>
</div>


</div> 

<div class="footer">
  <div style="margin:0 auto; text-align:center"><a href="http://sylai.fasoso.com">此页面是由商展通生成</a></div>
</div>
<script>
/*返回上一页*/  
function return_prepage()  
{  
if(window.document.referrer==""||window.document.referrer==window.location.href)  
{  
window.location.href="{dede:type}[field:typelink /]{/dede:type}";  
}else  
{  
window.location.href=window.document.referrer;  
}  
  
}
</script>
</body>
</html>
