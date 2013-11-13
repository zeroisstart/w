<!DOCTYPE html>
<html>
        <head>
<meta name="Generator" content="APPNAME VERSION" />
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/photo.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/photoswipe.css" media="all">
        <script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/jquery_imagesloaded.js"></script>
        <script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/jquery_wookmark_min.js"></script>
        <title>微相册</title>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
        <meta content="no-cache" http-equiv="pragma">
        <meta content="0" http-equiv="expires">
        <meta content="telephone=no, address=no" name="format-detection">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="apple-mobile-web-app-capable" content="yes">
        
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        
        <style>
img {
	width: 100%!important;
}
</style>
        </head>
        <body id="photo" onselectstart="return true;" ondragstart="return false;">
<style>
	#Gallery li{
		display:block;
		width:inherit;
		margin:5px;
	}
.album li p>span, .album1 li p>span, .album2 li p>span {
float: right;
color: #aaa;
position: absolute;
right: 5px;
background: #fff;
padding-left: 5px;
}
#Gallery li p {
display: inline-block;
max-width: 100%;
}
</style>
<div class="body">
			<div class="qiandaobanner"> <a href="#"> <img src="<?php echo $this->_var['template_path']; ?>/img/albums_head_url.jpg" alt="" style="max-height:200px;"> </a> </div>
			<div id="main" role="main" class="album">
		<ul id="Gallery" class="gallery">
					<li style=""> <a href="<?php echo $this->_var['INDEX']; ?>&ac=pic1"> <img src="<?php echo $this->_var['template_path']; ?>/img/upload/20130920155245_19935.jpg" alt="">
						<p>蛋糕诱惑<span>(33张)</span></p>
						</a> </li>
					<li style=""> <a href="<?php echo $this->_var['INDEX']; ?>&ac=pic2"> <img src="<?php echo $this->_var['template_path']; ?>/img/upload/20130920010932_21337.jpg" alt="车型介绍的详细说明">
						<p>车型介绍<span>(26张)</span></p>
						</a> </li>
					<li style=""> <a href="<?php echo $this->_var['INDEX']; ?>&ac=pic3"> <img src="<?php echo $this->_var['template_path']; ?>/img/upload/20130920004625_35594.jpg" alt="">
						<p>婚纱影集<span>(11张)</span></p>
						</a> </li>
					<li style=""> <a href="<?php echo $this->_var['INDEX']; ?>&ac=pic4"> <img src="<?php echo $this->_var['template_path']; ?>/img/upload/20130920000158_14323.jpg" alt="">
						<p>相册展示<span>(12张)</span></p>
						</a> </li>
				</ul>
	</div>
		</div>
<div mark="stat_code" style="width:0px; height:0px; display:none;"> </div>
</body>
</html>