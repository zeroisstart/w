<?php
session_write_close ();

ini_set ( 'session.auto_start', 0 ); // 关闭session自动启动

ini_set ( 'session.cookie_lifetime', 0 ); // 设置session在浏览器关闭时失效

ini_set ( 'session.gc_maxlifetime', 3600 ); // session在浏览器未关闭时的持续存活时间

@define ( 'IN_SYS', TRUE );
define ( 'D_BUG', '0' );

D_BUG ? error_reporting ( 7 ) : error_reporting ( 0 );
$_SGLOBAL = $_SCONFIG = $_SBLOCK = $_TPL = $_SCOOKIE = $_SN = $space = array ();

// 程序目录
define ( 'S_ROOT', dirname ( __FILE__ ) . DIRECTORY_SEPARATOR );

// 基本文件
include_once (S_ROOT . './config.php');

// 通用函数
include_once (S_ROOT . './source/function_common.php');

// 时间
$mtime = explode ( ' ', microtime () );
$_SGLOBAL ['timestamp'] = $mtime [1];
$_SGLOBAL ['supe_starttime'] = $_SGLOBAL ['timestamp'] + $mtime [0];

// 本站URL
if (empty ( $_SC ['siteurl'] ))
	$_SC ['siteurl'] = getsiteurl ();
	
	// 链接数据库
dbconnect ();

// 缓存文件
if (! @include_once (S_ROOT . './data/data_config.php')) {
	include_once (S_ROOT . './source/function_cache.php');
	config_cache ();
	include_once (S_ROOT . './data/data_config.php');
}
$sitekey = trim ( $_SCONFIG ['sitekey'] );
if (empty ( $sitekey )) {
	$sitekey = mksitekey ();
	$_SGLOBAL ['db']->query ( "REPLACE INTO " . tname ( 'config' ) . " (var, datavalue) VALUES ('sitekey', '$sitekey')" );
	include_once (S_ROOT . './source/function_cache.php');
	config_cache ( false );
}

$_SC ['ua'] ['is_ipad'] = strripos ( $_SERVER ["HTTP_USER_AGENT"], 'ipad' ); // 判断是否包含ipad关键字
$_SC ['ua'] ['is_iphone'] = strripos ( $_SERVER ["HTTP_USER_AGENT"], 'iphone' ); // 判断是否包含iphone关键字
$_SC ['ua'] ['is_android'] = strripos ( $_SERVER ['HTTP_USER_AGENT'], 'Android' ); // 判断是否Android;
$_SC ['ua'] ['is_pc'] = strripos ( $_SERVER ["HTTP_USER_AGENT"], 'windows nt' ); // 判断是否为(pc)电脑
$_SC ['ua'] ['is_ucweb'] = strripos ( $_SERVER ["HTTP_USER_AGENT"], 'UCWEB' ); // 判断是否为UC极速模式
$_SC ['ua'] ['is_weixin'] = strripos ( $_SERVER ["HTTP_USER_AGENT"], 'MicroMessenger' ); // 判断是否为微信浏览器

$wxid = getstr ( $_GET ["wxid"] ); // 微信用户的wxid
$token = getstr ( $_GET ["token"] ); // 临时密钥
$mid = intval ( $_GET ["mid"] ) ? intval ( $_GET ["mid"] ) : 0; // 微站模块id

if (! $wxid || $mid == 0) {
	$arr ['err'] = 1;
	exit ();
}

$query = $_SGLOBAL ['db']->query ( 'select * from ' . tname ( 'wz_module' ) . ' where id=' . $mid );
$module = $_SGLOBAL ['db']->fetch_array ( $query );
if (! $module ['id']) {
	$arr ['err'] = 2;
	exit ();
}

$op_wxid = $_SGLOBAL ['db']->getone ( 'select op_wxid from ' . tname ( 'weixin_member' ) . ' where wxid="' . $wxid . '"' );
if (! $op_wxid) {
	$arr ['err'] = 3;
	exit ();
}
$op_uid = $_SGLOBAL ['db']->getone ( 'select op_uid from ' . tname ( 'open_member_weixin' ) . ' where id=' . $op_wxid );
if (! $op_uid) {
	$arr ['err'] = 4;
	exit ();
}

/*
 * test $wxid='adsfasdfasdfasfdsafasfds'; $token='adfafasfdsafasfdasf'; $mid=2;
 * $op_uid=1;
 */

// 获取特定微笑微信用户的模板设置信息
$module ['profile'] = $_SGLOBAL ['db']->getall ( 'select * from ' . tname ( 'wz_module_profile' ) . ' where op_uid=' . $op_uid . ' and module_id=' . $mid );

$module_dir = './module/' . $module ['module_dir'];
$module ['module_template'] = $module ['module_default_template'];

if (! defined ( 'INIT_NO_SMARTY' )) {
	header ( 'Cache-control: private' );
	header ( 'Content-type: text/html; charset=' . $_SC ['charset'] );
	
	/*
	 * 创建 Smarty 对象。
	 */
	require (S_ROOT . './source/cls_template.php');
	$smarty = new cls_template ();
	
	$smarty->cache_lifetime = 1; // $_SCONFIG['cache_time'];
	$smarty->template_dir = $module_dir . '/themes/' . $module ['module_template'];
	$smarty->cache_dir = S_ROOT . './temp/caches';
	$smarty->compile_dir = S_ROOT . './temp/compiled';
	$smarty->compile_id = $module ['module_template'] . '_' . $module ['module_dir'] . '_' . $op_uid;
	
	if ((DEBUG_MODE & 2) == 2) {
		$smarty->direct_output = true;
		$smarty->force_compile = true;
	} else {
		$smarty->direct_output = false;
		$smarty->force_compile = false;
	}
	
	$smarty->assign ( 'lang', $_SC ['lang'] );
	$smarty->assign ( 'charset', $_SC ['charset'] );

}

if (wz_checkauth ( $wxid, $token, $mid )) {
	$_SGLOBAL ['isauth'] = true;
} else {
	$_SGLOBAL ['isauth'] = false;
}
wz_record ( $_GET );

define ( 'INDEX', 'index.php?wxid=' . $wxid . '&token=' . $token . '&mid=' . $mid );
$smarty->assign ( 'INDEX', INDEX );
$smarty->assign ( 'template_path', $module_dir . '/themes/' . $module ['module_template'] );
$smarty->assign ( '_SC', $_SC );
$smarty->assign ( 'formhash', formhash () );
$smarty->assign ( '_SGLOBAL', $_SGLOBAL );
$smarty->assign ( 'rand', random ( 6 ) );
session_save_path ( S_ROOT . "./data/session_tmp" );
session_start ();

function wz_checkauth($wxid, $token, $mid) {
	global $_SGLOBAL, $_SC, $_SCONFIG, $_SCOOKIE, $_SN;
	
	if ($_COOKIE ['site_auth']) {
		@list ( $password, $token_id ) = explode ( " ", authcode ( $_COOKIE ['site_auth'], 'DECODE' ) );
		$_SGLOBAL ['supe_token_id'] = intval ( $token_id );
		if ($password && $_SGLOBAL ['supe_token_id']) {
			$query = $_SGLOBAL ['db']->query ( "SELECT * FROM " . tname ( "wz_session" ) . " WHERE token_id=" . $_SGLOBAL ['supe_token_id'] );
			if ($session = $_SGLOBAL ['db']->fetch_array ( $query )) {
				if ($session ['password'] == $password) {
					$token_mid = $_SGLOBAL ['db']->getone ( 'select mid from ' . tname ( 'wz_token' ) . ' where id=' . $_SGLOBAL ['supe_token_id'] );
					if ($token_mid == $mid) {
						$_SGLOBAL ['supe_wxid'] = addslashes ( $session ['wxid'] );
						wz_insertsession ( $session ); // 更新session
					} else {
						$_SGLOBAL ['supe_token_id'] = 0;
					}
				} else {
					$_SGLOBAL ['supe_token_id'] = 0;
				}
			} else {
				$query = $_SGLOBAL ['db']->query ( "SELECT * FROM " . tname ( "wz_token" ) . " WHERE wxid='" . $wxid . "' and state=0" );
				if ($wz = $_SGLOBAL ['db']->fetch_array ( $query )) {
					if ($wz ['token'] == $token && $wz ['mid'] == $mid) {
						updatetable ( tname ( 'wz_token' ), array ('state' => 1 ), array ('id' => $wz ['id'] ) );
						$_SGLOBAL ['supe_wxid'] = addslashes ( $wz ['wxid'] );
						$session = array ('token_id' => $wz ['id'], 'wxid' => $_SGLOBAL ['supe_wxid'], 'password' => $token );
						wz_insertsession ( $session ); // 登录
						$cookietime = 3600; // 3600 * 24 * 15;
						                  // 设置cookie
						ssetcookie ( 'site_auth', authcode ( $session ["password"] . ' ' . $session ["token_id"], 'ENCODE' ), $cookietime );
					} else {
						$_SGLOBAL ['supe_token_id'] = 0;
					}
				} else {
					$_SGLOBAL ['supe_token_id'] = 0;
				}
			}
		}
	} else {
		$query = $_SGLOBAL ['db']->query ( "SELECT * FROM " . tname ( "wz_token" ) . " WHERE wxid='" . $wxid . "' and state=0" );
		if ($wz = $_SGLOBAL ['db']->fetch_array ( $query )) {
			if ($wz ['token'] == $token && $wz ['mid'] == $mid) {
				updatetable ( tname ( 'wz_token' ), array ('state' => 1 ), array ('id' => $wz ['id'] ) );
				$_SGLOBAL ['supe_wxid'] = addslashes ( $wz ['wxid'] );
				$session = array ('token_id' => $wz ['id'], 'wxid' => $_SGLOBAL ['supe_wxid'], 'password' => $token );
				wz_insertsession ( $session ); // 登录
				$cookietime = 3600; // 3600 * 24 * 15;
				                  // 设置cookie
				ssetcookie ( 'site_auth', authcode ( $session ["password"] . ' ' . $session ["token_id"], 'ENCODE' ), $cookietime );
			} else {
				$_SGLOBAL ['supe_token_id'] = 0;
			}
		} else {
			$_SGLOBAL ['supe_token_id'] = 0;
		}
	}
	
	if (empty ( $_SGLOBAL ['supe_token_id'] )) {
		clearcookie ();
	}
	
	return $_SGLOBAL ['supe_token_id'];
}

// 添加wz_session
function wz_insertsession($setarr) {
	global $_SGLOBAL, $_SCONFIG;
	
	$_SGLOBAL ['db']->query ( "DELETE FROM " . tname ( "wz_session" ) . " WHERE token_id='$setarr[token_id]'" );
	
	// 添加在线
	$ip = getonlineip ();
	$setarr ['lastactivity'] = $_SGLOBAL ['timestamp'];
	$setarr ['ip'] = $ip;
	
	inserttable ( tname ( "wz_session" ), $setarr, 0, true, 0 );
	
	$_SGLOBAL ['supe_token_id'] = $setarr ['token_id'];
}

// 添加微站访问记录
function wz_record($get) {
	global $_SGLOBAL, $_SC;
	reset ( $get );
	foreach ( $get as $k => $v ) {
		
		if ($k == 'wxid')
			$wxid = getstr ( $get [$k] );
		if ($k == 'token')
			$token = getstr ( $get [$k] );
		if ($k == 'mid')
			$mid = intval ( $get [$k] ) ? intval ( $get [$k] ) : 0;
		
		if ($k == 'wxid' || $k == 'token' || $k == 'mid') {
			unset ( $get [$k] );
			continue;
		} else {
			$get [$k] = getstr ( $get [$k] );
		}
		$get [$k] = getstr ( $get [$k] );
	}
	$query = json_encode ( $get );
	$arr = array ('token_id' => $_SGLOBAL ['supe_token_id'], 'query' => $query, 'ip' => getonlineip (), 'user_agent' => $_SERVER ["HTTP_USER_AGENT"], 'wxid' => $wxid, 'token' => $token, 'mid' => $mid, 'addtime' => $_SGLOBAL ['timestamp'] );
	$record_id = inserttable ( tname ( 'wz_record' ), $arr, 1 );
	return $record_id;
}

// 获取微站profile
// 返回数组
function get_profile($profile) {
	global $_SGLOBAL;
	foreach ( $profile as $k => $v ) {
		if ($profile [$k] ['parent_id'] == 0) {
			$arr [$v ['var']] [$v ['sort']] = $v ['value'];
		} else {
			$var = $_SGLOBAL ['db']->getone ( 'select var from ' . tname ( 'wz_module_profile' ) . ' where id=' . $v ['parent_id'] );
			$sort = $_SGLOBAL ['db']->getone ( 'select sort from ' . tname ( 'wz_module_profile' ) . ' where id=' . $v ['parent_id'] );
			$arr [$var] [$sort] [$v ['var']] = $v ['value'];
			$arr [$var] [$sort] ['pid'] = $v ['parent_id'];
		}
	}
	foreach ( $arr as $k => $v ) {
		if (count ( $arr [$k] ) == 1) {
			$arr [$k] = reset ( $arr [$k] );
		}
	}
	
	return $arr;
}

?>