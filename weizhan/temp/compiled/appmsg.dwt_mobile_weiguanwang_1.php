<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<title><?php echo $this->_var['site']['title']; ?></title>
<meta http-equiv=Content-Type content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/client-page1714ff.css"/>
<style>
#nickname {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	max-width: 90%;
}
ol, ul {
	list-style-position: inside;
}
</style>
<style>
#activity-detail .page-content .text {
	font-size: 16px;
}
</style>
</head>
<body id="activity-detail">
<div class="page-bizinfo">
	<div class="header">
		<h1 id="activity-name"><?php echo $this->_var['site']['title']; ?></h1>
		<p class="activity-info"><span id="post-date" class="activity-meta no-extra"></span><!-- <a href="javascript:;" id="post-user" class="activity-meta"><span class="text-ellipsis"></span><i class="icon_link_arrow"></i></a>--></p>
	</div>
</div>
<div class="page-content">
	<div class="text">
     <?php echo $this->_var['site']['content']; ?>		
	</div>
</div>
</body>
</html>