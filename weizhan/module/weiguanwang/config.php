<?php

$_WZ=array();


/*
在这里用数组的方式设置微网站用到的数据
type  目前支持:text,pic,content,subbtn（二级分类）
*/

$_WZ['profile']=array(
array(
  'var'=>'sitename',
  'type'=>'text',
  'title'=>'微官网名称',
  'sort'=>1,
  ),
array(
  'var'=>'banner',
  'type'=>'pic',
  'title'=>'首页轮播图片',
  'sort'=>1,
),
array(
  'var'=>'banner',
  'type'=>'pic',
  'title'=>'首页轮播图片',
  'sort'=>2,
),
array(
  'var'=>'banner',
  'type'=>'pic',
  'title'=>'首页轮播图片',
  'sort'=>3,
),
array(
  'var'=>'phonecall',
  'type'=>'text',
  'title'=>'联系电话',
  'sort'=>1,
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>1,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>2,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>3,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>4,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>5,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
array(
  'var'=>'button',
  'type'=>'subbtn',
  'title'=>'按钮',
  'sort'=>6,
  'son'=>array(
               array(
	             'var'=>'title',
	             'type'=>'text',
	             'title'=>'标题',
                 'sort'=>1,
	           ),
               array(
                 'var'=>'content',
	             'type'=>'content',
	             'title'=>'内容',
                 'sort'=>1,
	           ),
          ),
),
);

?>