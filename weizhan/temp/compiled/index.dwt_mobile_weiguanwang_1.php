<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="APPNAME VERSION" />
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/common.css?2013-10-15-2" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/reset.css?2013-10-15-2" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/home-16.css?2013-10-15-2" media="all" />
<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/jquery-1.9.0.min.js?2013-10-15-2"></script>
<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/swipe.js?2013-10-15-2"></script>
<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/js/zepto.js?2013-10-15-2"></script>
<title><?php echo $this->_var['site']['sitename']; ?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta name="Keywords" content="" />
<meta name="Description" content="" />

<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="pragma">
<meta content="0" http-equiv="expires">
<meta content="telephone=no, address=no" name="format-detection">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

</head>
<body onselectstart="return true;" ondragstart="return false;">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['template_path']; ?>/style/font-awesome.css?v=2013101613" media="all" />
<script>
    window.addEventListener("DOMContentLoaded", function(){
        btn = document.getElementById("plug-btn");
        btn.onclick = function(){
            var divs = document.getElementById("plug-phone").querySelectorAll("div");
            var className = className=this.checked?"on":"";
            for(i = 0;i<divs.length; i++){
                divs[i].className = className;
            }
            document.getElementById("plug-wrap").style.display = "on" == className? "block":"none";
        }
    }, false);
</script>
<div class="body">
<section>
	<div id="banner_box" class="box_swipe">
		<ul>
        <?php $_from = $this->_var['site']['banner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?> 
			<li> <a href=""> <img src="<?php echo $this->_var['b']; ?>" alt="" style="width:100%;" /> </a> </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<ol>
			<li class="on"></li>
			<li ></li>
			<li ></li>
		</ol>
	</div>
</section>
<section> <a href="tel:<?php echo $this->_var['site']['phonecall']; ?>" class="link_tel icon-phone"><?php echo $this->_var['site']['phonecall']; ?></a> </section>
<section>
<ul class="list_font">
<?php $_from = $this->_var['site']['button']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'btn');if (count($_from)):
    foreach ($_from AS $this->_var['btn']):
?>
<li> <a  href="<?php echo $this->_var['INDEX']; ?>&ac=show&pid=<?php echo $this->_var['btn']['pid']; ?>">
	<div><span class="icon-trophy"></span></div>
	<div>
		<p><?php echo $this->_var['btn']['title']; ?></p>
	</div>
	</a> </li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
</section>
</div>
<script>
    $(function(){
        new Swipe(document.getElementById('banner_box'), {
            speed:500,
            auto:3000,
            callback: function(){
                var lis = $(this.element).next("ol").children();
                lis.removeClass("on").eq(this.index).addClass("on");
            }
        });
    });
</script>
<footer>
	<div class="weimob-copyright"> <a href="">©2013</a> </div>
	<span class="weimob-support" style="display:none;">©</span> </footer>
<div mark="stat_code" style="width:0px; height:0px; display:none;"> 
</body>
</html>