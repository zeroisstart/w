<?php
if(!defined('IN_SYS')) {
	exit('Access Denied');
}

class alipay_service {

    var $gateway ;
    var $param;            //需要签名的参数数组
    var $key ;                      // 签名key，由config数组中独立出来

    /**构造函数
    *从配置文件及入口文件中初始化变量
    *$param 需要签名的参数数组
     */
    function alipay_service($config, $param) {
        $this->gateway          = "https://www.alipay.com/cooperate/gateway.do";
        $this->param      =  array_merge($config, $param) ; // 合并两个数组，相同的键，前者值会被后者覆盖
        $this->key = $this->param['key']; // 获取支付宝的key值，并存入类变量里。 
        unset($this->param['key']) ; // 这里把key键值去掉，因为key不是支付宝能接受的参数，只是用来做签名用。
        //获得签名结果
        $this->alipay_sign();
    }

    // 数字签名
    function alipay_sign() {
        // 1,先排序
        ksort($this->param);
        reset($this->param);
        // 2,过滤数组中的无关参数，这里采用 ===来过滤字符串值为空的项，防止误过滤变量值为 0 的项
        $para = array();
        foreach ( $this->param as $key=>$val ) {
            if($key == "sign" || $key == "sign_type" || $val === '' ) continue;
            $para[$key] = $val ;
        }
    // 3，将数组中的参数链接成一个支付串，并用&分隔。
        $arg  = "";
        foreach ( $para as $key=>$val ) {
            $arg .= "{$key}={$val}&";
        }
        $arg = trim($arg, '&');             //去掉最后一个&字符 ，支付宝官方尽然还用substr函数来去除，真是不怕麻烦。
        // 3,替换签名字符串
        $this->param['sign'] = md5( $arg . $this->key ) ; // 链接上商家的key，支付包给出，生成md5加密后的值
        $this->param['sign_type'] = 'MD5'; // 签名类型为 md5加密
    //到此，类的变量 $this->param包含了全部需要提交给支付宝的参数。下面如果需要，只要遍历出键值，链接成相应的字符串即可
    }
  
    function create_form($method='get') {
        if(!in_array($method, array('get', 'post'))) $method = 'get';
        $action = $this->gateway . ( 'post' == $method ?  '?_input_charset=' . $this->param['_input_charset'] : '' );
        // 这一步，如果是post提交，一定要在参数后面添加上字符串编码类型，否则，支付宝解析错误。    
       $html = '<form id="alipaysubmit" action="' . $action . '" method="'.$method.'">';
        foreach ($this->param as $key=>$val) {
            if($val==='') continue; 
            $html  .= '<input name="'.$key.'" type="hidden" value="'.$val.'" />';
        }
        //submit按钮控件请不要含有name属性
        $html .= '<input type="submit" value="支付宝确认付款" /></form>';
        return $html;
    }

    // 创建链接字符串
    function create_link(){
        $url = '' ;
        foreach( $this->param as $key=>$val){
            if($val==='') continue;
            $url .= "{$key}={$val}&";
        }
        $url =$this->gateway . '?' . trim($url, '&') ;
        return $url ;
    }



    /**
     * HTTPS形式消息验证地址
     */
	var $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
	/**
     * HTTP形式消息验证地址
     */
	var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';



    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyNotify(){
		if(empty($_POST)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->getMysign($_POST);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'true';
			if (! empty($_POST["notify_id"])) {$responseTxt = $this->getResponse($_POST["notify_id"]);}
			
			//写日志记录
			//$log_text = "responseTxt=".$responseTxt."\n notify_url_log:sign=".$_POST["sign"]."&mysign=".$mysign.",";
			//$log_text = $log_text.createLinkString($_POST);
			//logResult($log_text);
			
			//验证
			//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if (preg_match("/true$/i",$responseTxt) && $mysign == $_POST["sign"]) {
				return true;
			} else {
				return false;
			}
		}
	}
	
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyReturn(){
		if(empty($_GET)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->getMysign($_GET);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'true';
			if (! empty($_GET["notify_id"])) {$responseTxt = $this->getResponse($_GET["notify_id"]);}
			
			//写日志记录
			//$log_text = "responseTxt=".$responseTxt."\n notify_url_log:sign=".$_GET["sign"]."&mysign=".$mysign.",";
			//$log_text = $log_text.createLinkString($_GET);
			//logResult($log_text);
			
			//验证
			//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if (preg_match("/true$/i",$responseTxt) && $mysign == $_GET["sign"]) {
				return true;
			} else {
				return false;
			}
		}
	}
	
    /**
     * 根据反馈回来的信息，生成签名结果
     * @param $para_temp 通知返回来的参数数组
     * @return 生成的签名结果
     */
	function getMysign($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);
		
		//对待签名参数数组排序
		$para_sort = argSort($para_filter);
		
		//生成签名结果
		$mysign = buildMysign($para_sort, trim($this->key), strtoupper(trim($this->param['sign_type'])));
		
		return $mysign;
	}

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空 
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
	function getResponse($notify_id) {
		$transport = strtolower(trim($this->param['transport']));
		$partner = trim($this->param['partner']);
		$veryfy_url = '';
		if($transport == 'https') {
			$veryfy_url = $this->https_verify_url;
		}
		else {
			$veryfy_url = $this->http_verify_url;
		}
		$veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
		$responseTxt = getHttpResponse($veryfy_url);
		
		return $responseTxt;
	}




}


/* *
 * 支付宝接口公用函数
 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

/**
 * 生成签名结果
 * @param $sort_para 要签名的数组
 * @param $key 支付宝交易安全校验码
 * @param $sign_type 签名类型 默认值：MD5
 * return 签名结果字符串
 */
function buildMysign($sort_para,$key,$sign_type = "MD5") {
	//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	$prestr = createLinkstring($sort_para);
	//把拼接后的字符串再与安全校验码直接连接起来
	$prestr = $prestr.$key;
	//把最终的字符串签名，获得签名结果
	$mysgin = sign($prestr,$sign_type);
	return $mysgin;
}
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key."=".$val."&";
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
}
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringUrlencode($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key."=".urlencode($val)."&";
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
}
/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para) {
	$para_filter = array();
	while (list ($key, $val) = each ($para)) {
		if($key == "sign" || $key == "sign_type" || $val == "")continue;
		else	$para_filter[$key] = $para[$key];
	}
	return $para_filter;
}
/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para) {
	ksort($para);
	reset($para);
	return $para;
}
/**
 * 签名字符串
 * @param $prestr 需要签名的字符串
 * @param $sign_type 签名类型 默认值：MD5
 * return 签名结果
 */
function sign($prestr,$sign_type='MD5') {
	$sign='';
	if($sign_type == 'MD5') {
		$sign = md5($prestr);
	}elseif($sign_type =='DSA') {
		//DSA 签名方法待后续开发
		die("DSA 签名方法待后续开发，请先使用MD5签名方式");
	}else {
		die("支付宝暂不支持".$sign_type."类型的签名方式");
	}
	return $sign;
}
/**
 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
 * 注意：服务器需要开通fopen配置
 * @param $word 要写入日志里的文本内容 默认值：空值
 */
function logResult($word='') {
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

/**
 * 远程获取数据
 * 注意：该函数的功能可以用curl来实现和代替。curl需自行编写。
 * $url 指定URL完整路径地址
 * @param $input_charset 编码格式。默认值：空值
 * @param $time_out 超时时间。默认值：60
 * return 远程输出的数据
 */
function getHttpResponse($url, $input_charset = '', $time_out = "60") {
	$urlarr     = parse_url($url);
	$errno      = "";
	$errstr     = "";
	$transports = "";
	$responseText = "";
	if($urlarr["scheme"] == "https") {
		$transports = "ssl://";
		$urlarr["port"] = "443";
	} else {
		$transports = "tcp://";
		$urlarr["port"] = "80";
	}
	$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
	if(!$fp) {
		die("ERROR: $errno - $errstr<br />\n");
	} else {
		if (trim($input_charset) == '') {
			fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
		}
		else {
			fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.$input_charset." HTTP/1.1\r\n");
		}
		fputs($fp, "Host: ".$urlarr["host"]."\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $urlarr["query"] . "\r\n\r\n");
		while(!feof($fp)) {
			$responseText .= @fgets($fp, 1024);
		}
		fclose($fp);
		$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
		
		return $responseText;
	}
}
/**
 * 实现多种字符编码方式
 * @param $input 需要编码的字符串
 * @param $_output_charset 输出的编码格式
 * @param $_input_charset 输入的编码格式
 * return 编码后的字符串
 */
function charsetEncode($input,$_output_charset ,$_input_charset) {
	$output = "";
	if(!isset($_output_charset) )$_output_charset  = $_input_charset;
	if($_input_charset == $_output_charset || $input ==null ) {
		$output = $input;
	} elseif (function_exists("mb_convert_encoding")) {
		$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
	} elseif(function_exists("iconv")) {
		$output = iconv($_input_charset,$_output_charset,$input);
	} else die("sorry, you have no libs support for charset change.");
	return $output;
}
/**
 * 实现多种字符解码方式
 * @param $input 需要解码的字符串
 * @param $_output_charset 输出的解码格式
 * @param $_input_charset 输入的解码格式
 * return 解码后的字符串
 */
function charsetDecode($input,$_input_charset ,$_output_charset) {
	$output = "";
	if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
	if($_input_charset == $_output_charset || $input ==null ) {
		$output = $input;
	} elseif (function_exists("mb_convert_encoding")) {
		$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
	} elseif(function_exists("iconv")) {
		$output = iconv($_input_charset,$_output_charset,$input);
	} else die("sorry, you have no libs support for charset changes.");
	return $output;
}


?>