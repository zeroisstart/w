<?php
include_once('./common.php');
//update_db v0.1.3
updatetable(tname('open_navmenu'),array('title'=>'客服管理'),array('id'=>5));
updatetable(tname('open_navmenu'),array('sort'=>'6'),array('id'=>4));
inserttable(tname('open_navmenu'),array('title'=>'微站管理','url'=>'wx_weizhan.php','sort'=>'5'));



$_SGLOBAL['db']->query("ALTER TABLE ".tname('open_member_weixin_autoreply_info')." ADD wz_mid MEDIUMINT( 8 ) NOT NULL DEFAULT '0' AFTER url");
$_SGLOBAL['db']->query("ALTER TABLE ".tname('open_member_weixin_focusreply_info')." ADD wz_mid MEDIUMINT( 8 ) NOT NULL DEFAULT '0' AFTER url");
$_SGLOBAL['db']->query("ALTER TABLE ".tname('open_member_weixin_msgreply_info')." ADD wz_mid MEDIUMINT( 8 ) NOT NULL DEFAULT '0' AFTER url");



$_SGLOBAL['db']->query("CREATE TABLE ".tname('wz_module')." (
id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
module_name VARCHAR( 255 ) NOT NULL ,
module_dir VARCHAR( 255 ) NOT NULL ,
module_default_template VARCHAR( 255 ) NOT NULL ,
addtime INT( 10 ) NOT NULL
) TYPE = MYISAM");

$_SGLOBAL['db']->query("CREATE TABLE ".tname('wz_module_profile')." (
id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
op_uid MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
module_id MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
parent_id MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
var VARCHAR( 255 ) NOT NULL ,
type VARCHAR( 255 ) NOT NULL ,
title VARCHAR( 255 ) NOT NULL ,
value VARCHAR( 255 ) NOT NULL ,
sort MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
addtime INT( 10 ) NOT NULL
) TYPE = MYISAM");

$_SGLOBAL['db']->query("CREATE TABLE ".tname('wz_record')." (
id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
token_id MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
query TEXT NOT NULL ,
ip VARCHAR( 15 ) NOT NULL ,
user_agent VARCHAR( 255 ) NOT NULL ,
wxid VARCHAR( 255 ) NOT NULL ,
token VARCHAR( 255 ) NOT NULL ,
mid MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
addtime INT( 10 ) NOT NULL
) TYPE = MYISAM");

$_SGLOBAL['db']->query("CREATE TABLE ".tname('wz_session')." (
token_id MEDIUMINT( 8 ) NOT NULL PRIMARY KEY ,
wxid VARCHAR( 255 ) NOT NULL ,
password VARCHAR( 255 ) NOT NULL ,
lastactivity INT( 10 ) NOT NULL ,
ip VARCHAR( 15 ) NOT NULL 
) TYPE = MYISAM");

$_SGLOBAL['db']->query("CREATE TABLE ".tname('wz_token')." (
id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
wxid VARCHAR( 255 ) NOT NULL ,
mid MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
token VARCHAR( 255 ) NOT NULL ,
state TINYINT( 1 ) NOT NULL DEFAULT '0',
expires_in MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
addtime INT( 10 ) NOT NULL
) TYPE = MYISAM");

inserttable(tname('wz_module'),array('id'=>1,'module_name'=>'微官网','module_dir'=>'weiguanwang','module_default_template'=>'mobile'));

inserttable(tname('wz_module'),array('id'=>2,'module_name'=>'微相册','module_dir'=>'weixiangce','module_default_template'=>'mobile'));

/*//update_db  v0.1.2.5
$_SGLOBAL['db']->query('DROP TABLE '.tname('open_member_weixin_custommenu'));
$_SGLOBAL['db']->query("CREATE TABLE dz_open_member_weixin_custommenu (
id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
wxid MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
parent_id MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
sort_order MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
btn_type MEDIUMINT( 8 ) NOT NULL DEFAULT '1',
btn_name VARCHAR( 255 ) NOT NULL ,
keyword VARCHAR( 255 ) NOT NULL ,`url` VARCHAR( 255 ) NOT NULL ,
addtime INT( 10 ) NOT NULL
) TYPE = MYISAM");

//update_db  v0.1.2.4
$_SGLOBAL['db']->query('ALTER TABLE '.tname('open_member_pushweixin').' ADD signature VARCHAR( 255 ) NOT NULL AFTER password ,
ADD country VARCHAR( 50 ) NOT NULL AFTER signature ,
ADD province VARCHAR( 50 ) NOT NULL AFTER country ,
ADD city VARCHAR( 50 ) NOT NULL AFTER province ,
ADD verifyInfo TEXT NOT NULL AFTER city ,
ADD bindUserName VARCHAR( 255 ) NOT NULL AFTER verifyInfo ,
ADD account VARCHAR( 100 ) NOT NULL AFTER bindUserName ,
ADD fakeid VARCHAR( 100 ) NOT NULL AFTER account');


$_SGLOBAL['db']->query('ALTER TABLE '.tname('open_member_weixin').' ADD signature VARCHAR( 255 ) NOT NULL AFTER password ,
ADD country VARCHAR( 50 ) NOT NULL AFTER signature ,
ADD province VARCHAR( 50 ) NOT NULL AFTER country ,
ADD city VARCHAR( 50 ) NOT NULL AFTER province ,
ADD verifyInfo TEXT NOT NULL AFTER city ,
ADD bindUserName VARCHAR( 255 ) NOT NULL AFTER verifyInfo ,
ADD account VARCHAR( 100 ) NOT NULL AFTER bindUserName ,
ADD fakeid VARCHAR( 100 ) NOT NULL AFTER account');

//update_db  v0.1.2.3
$_SGLOBAL['db']->query('ALTER TABLE '.tname('open_member_user').' ADD username VARCHAR( 50 ) NOT NULL AFTER uid,
 ADD password VARCHAR( 50 ) NOT NULL AFTER username ,
 ADD salt CHAR( 6 ) NOT NULL AFTER password ,
 ADD email_valid TINYINT( 1 ) NOT NULL AFTER salt
 ');
*/
?>