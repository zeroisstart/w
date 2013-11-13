<!DOCTYPE html>
<html><head>
<meta name="Generator" content="APPNAME VERSION" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商展通</title>
    <meta name="keywords" content="<?php echo $this->_var['corp']['corpname']; ?>">
    <meta name="description" content="<?php echo $this->_var['corp']['corpname']; ?>">
    
    
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-itunes-app" content="app-id=">

    
    <meta name="csrf-param" content="authenticity_token">
    <meta name="csrf-token" content="U/dleDQyH0ryL/fsE3nhaybtLoqaXqmZZGdpJGhSiTI=">
    
    
    <link href="<?php echo $this->_var['template_path']; ?>/css/public.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_var['template_path']; ?>/css/common.css" rel="stylesheet" type="text/css">

    
    <script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/script/zepto.modify.min.js"></script>
    <script type="text/javascript" async src="<?php echo $this->_var['template_path']; ?>/script/device.js"></script>
  </head>


  
  <body id="body" class="safari ratio1 android  home">

    
    <header>
      <div class="left">
      <h1 style="margin-top:10px; font-family:'Adobe 黑体 Std R'; color:#006;margin-left:10px;"><?php echo $this->_var['corp']['corpname']; ?></h1>
      </div>
      <div class="right icons">
      <h1 style="margin-top:10px; font-family:'Adobe 黑体 Std R';"></h1>
      </div>
    </header> 





<div class="back_top">
  <a href=""></a>
  <script type="text/javascript">
    (function(){
      var $back_top = $('.back_top'), height = 300;
      window.onscroll = function(e){
        $back_top.toggleClass('hide', window.scrollY < height);
      }

      $('.back_top').bind('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        window.scrollTo(0, 0);
      })
    })();
  </script>
</div>



<ul class="nav_list m_bg">
  <div class="wrap">
    <div style="width:50%;margin:0 auto;">
      <li>
        <a href=""><div>首页</div></a>
      </li>
      <li>
        <a href="c.php?id=<?php echo $this->_var['corp']['id']; ?>&dwt=product_list"><div>商品</div></a>
      </li>
      <div style="clear:both;"></div>
    </div>
  </div>
</ul>  



<div class="slide_bar m_bg">
  <div class="slide_width slide_height scroll_box" style="overflow-x: hidden; overflow-y: hidden; ">
    <div class="img_wrap slide_scroll_width slide_height" style="-webkit-transition-property: -webkit-transform; -webkit-transform-origin-x: 0px; -webkit-transform-origin-y: 0px; -webkit-transition-duration: 0ms; -webkit-transform: translate(0px, 0px) scale(1) translateZ(0px); ">
      <a class="slide_a slide_width slide_height" data-href="">
        <img class="slide_width slide_height" src="<?php echo $this->_var['template_path']; ?>/images/1.png">
      </a>
      <a class="slide_a slide_width slide_height" data-href="">
        <img class="slide_width slide_height" src="<?php echo $this->_var['template_path']; ?>/images/2.png">
      </a>
      <a class="slide_a slide_width slide_height" data-href="">
        <img class="slide_width slide_height" src="<?php echo $this->_var['template_path']; ?>/images/3.png">
      </a>
      
      <div class="bar left"></div>
      <div class="bar right"></div>
    </div>
    <div class="left arrow hide"><a></a></div>
    <div class="right arrow"><a></a></div>
    
    <div class="slide margin5">
      <li class="active"></li>
      <li class=""></li>
      <li class=""></li>
    </div>
    <div style="clear:both;"></div>
  </div>  
</div>

<div style="margin: 0 2px; " class="m_bg">

<table cellspacing="4" cellpadding="0" border="0" class="" style="margin-top:8px;">
  <tbody>
  <tr><td class="brands" colspan="2"><a href=""><span>关于我们</span>About us</a></td></tr>
  <tr>

    <td class="label brand" colspan="2">
       <div style="font-size:12px; font-family:'微软雅黑'; font-weight:normal;">
        <p><?php echo $this->_var['corp']['corp_intro']; ?></p>
       </div>
    </td>
  </tr>

  <tr><td class="brands" colspan="2"><a href=""><span>联系我们</span>Contact us</a></td></tr>
  <tr>  
    <td class="label brand" colspan="2">
    <div style="font-size:12px; font-family:'微软雅黑'; font-weight:normal;">
    <p><b><?php echo $this->_var['corp']['corpname']; ?></b></p>
    <p>地址：<?php echo $this->_var['corp']['corp_address']; ?></p>
    <p>电话：<?php echo $this->_var['corp']['corp_phone']; ?></p>
    <p><?php echo $this->_var['corp']['corp_contact']; ?></p>
    <p><div class="contact_buttons"><a href="tel:<?php echo $this->_var['corp']['corp_phone']; ?>">立刻拨通电话！</a></div></p>
</div>
    </td>
  </tr>    
  
</tbody></table>
</div>
  


<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/script/iscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_var['template_path']; ?>/script/fast_button.min.js"></script>
<script type="text/javascript">
  (function(){

    var
      $wrapper = $('.scroll_box'),
      $slide = $wrapper.children('.slide'),
      $left = $('.left.arrow'),
      $right = $('.right.arrow'),
      auto_slide,
      $body = $('body'),
      direction = 'landscape',

      scroll = new iScroll($wrapper[0], {
        snap: true,
        momentum: false,
        vScroll: false,
        hScrollbar: false,
        onBeforeScrollStart: function(){},
        onBeforeScrollMove: function(){
          if(direction == 'portrait'){
            this._unbind('touchmove', window);
            this._unbind('touchend', window);
            this._unbind('touchcancel', window);
            return;
          }
        },
        onScrollMove: function(e){if(this.dirY == 0) e.preventDefault();},
        onScrollEnd: function() {
          indicator_update(this.currPageX + 1);
        }
      });

    $body.bind('touchstart', function(e){
      var point = e.touches[0],
        startPageX = point.pageX,
        startPageY = point.pageY;
      $body.bind('touchmove', function(e){
        var point = e.touches[0],
          movePageX = point.pageX,
          movePageY = point.pageY;
        if(Math.abs(movePageX - startPageX) < Math.abs(movePageY - startPageY)){
          direction = 'portrait';
        }else{
          direction = 'landscape';
        }
        $body.unbind('touchmove');
      });
    });

    //幻灯提示点同步
    function indicator_update(x){
      $slide.children('.active').removeClass('active');
      $slide.find('li:nth-child(' + x + ')').addClass('active');
      $left.toggleClass('hide', x == 1);
      $right.toggleClass('hide', x == 3);
    };

    function scroll_to(x){
      var pageX = scroll.currPageX + x;
      scroll.scrollToPage(pageX, 0, 500);
    };

    $left.bind('itap', function(){
      scroll_to(-1);
    });

    $right.bind('itap', function(){
      scroll_to(1);
    });

    $wrapper.bind('touchstart', function(){
      if(auto_slide) clearInterval(auto_slide);
    });

    $wrapper.bind('touchend', function(){
      interval();
    });

    $('.slide_a').bind('itap', function(e){
      var $this = $(this);
      window.location.href = $this.data('href');
    });

    function interval(){
      if(auto_slide) clearInterval(auto_slide);
      auto_slide = setInterval(function(){
        scroll.scrollToPage((scroll.currPageX + 1) % 3, 0 , 500)
      }, 5000);
    };
    interval();
  })();
</script>





    
    <footer>
      <p><a href="http://sylai.fasoso.com">此页面是由商展通生成</a></p>
    </footer> 


</body></html>