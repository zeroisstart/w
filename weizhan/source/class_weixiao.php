<?php
if(!defined('IN_SYS')) {
	exit('Access Denied');
}

class WeixiaoAPI{
    protected $appkey;
	protected $appsecret;
	protected $wxapi_uri;
    protected $access_token;
    /** 
     * 构造 
     */  
    public function __construct($appkey,$appsecret,$wxapi_uri) {
		$this->appkey =$appkey;
		$this->appsecret = $appsecret;
		$this->wxapi_uri = $wxapi_uri;
		$this->get_access_token();	
    }
	
    protected function get_access_token(){
        $url=$this->wxapi_uri.'?appkey='.$this->appkey.'&appsecret='.$this->appsecret;
		$ch = curl_init($url);
 	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec($ch);
        curl_close ($ch);
		$this->access_token=$result;
	}

	
	public function apply_api($api_name){
        $url=$this->wxapi_uri.'?response_type=code&appkey='.$this->appkey.'&access_token='.$this->access_token.'&api_name='.$api_name;
		$ch = curl_init($url);
 	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec($ch);
		return $result;
	}
	
}
?>