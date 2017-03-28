<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * imc_client.php
 *
 * 用户接口类（客户端）
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-20 上午11:40:24
 * @filename   imc_client.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
define('ROOT', dirname(__FILE__) .'../..'. DIRECTORY_SEPARATOR);
class Client
{

	/**
	 * 同步登陆接口
	 @url 来源地址
	 @username 用户
	 @password 密码
	 @params 参数
	 */
	function syslogin($url,$username,$password,$paramstr='')
	{
		$server_url = $this->get_config('imc','server_url');  //服务端地址
		$postArr = array(
			'username'=>$username,
			'password'=>$password
		);

		$username = $this->rc4($username,'ENCODE',$this->get_config('imc','key'));//传递用户名密码
		$password = $this->rc4($password,'ENCODE',$this->get_config('imc','key'));//传递用户名密码
		$ip = base64_encode($this->get_client_ip());//传递用户名密码
        $appname = $this->get_config('imc','appname');//应用名
		$loginstr = $this->imc_post($server_url.'/imc/server/Server/login'.$paramstr.'?appname='.$appname,5000,"&username=$username&password=$password&ip=".$ip);
		return $loginstr;
	}

   /**
	 * 同步退出接口
	 @url 来源地址
	 @username 用户
	 @password 密码
	 @params 参数
	 */
	function sysloginout()
	{
		$server_url = $this->get_config('imc','server_url');  //服务端地址
		$appname = get_config('imc','appname');
		$code = $this->rc4('action=loginout', 'ENCODE',$this->get_config('imc','key'),3);
		$loginstr = $this->imc_post($server_url.'/imc/server/Server/loginout?appname='.$appname,5000,"&code=$code");
		return $loginstr;
	}

	function imc_post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true) {
			$return = '';
			$matches = parse_url($url);
			$host = $matches['host'];
			$path = (isset($matches['path']) && $matches['path']) ? $matches['path'].((isset($matches['query']) && $matches['query']) ? '?'.$matches['query'] : '') : '/';
			$port = !empty($matches['port']) ? $matches['port'] : 80;
			if($post) {
				$out = "POST $path HTTP/1.1\r\n";
				$out .= "Accept: */*\r\n";
				$out .= "Referer: ".$url."\r\n";
				$out .= "Accept-Language: zh-cn\r\n";
				$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
				$out .= "Host: $host\r\n" ;
				$out .= 'Content-Length: '.strlen($post)."\r\n" ;
				$out .= "Connection: Close\r\n" ;
				$out .= "Cache-Control: no-cache\r\n" ;
				$out .= "Cookie: $cookie\r\n\r\n" ;
				$out .= $post ;
			} else {
				$out = "GET $path HTTP/1.1\r\n";
				$out .= "Accept: */*\r\n";
				$out .= "Referer: ".$url."\r\n";
				$out .= "Accept-Language: zh-cn\r\n";
				$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
				$out .= "Host: $host\r\n";
				$out .= "Connection: Close\r\n";
				$out .= "Cookie: $cookie\r\n\r\n";
			}
			$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
			if(!$fp) return '';

			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);

			if($status['timed_out']) return '';
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
			@fclose($fp);

			//部分虚拟主机返回数值有误，暂不确定原因，过滤返回数据格式
			$return_arr = explode("\n", $return);
			if(isset($return_arr[1])) {
				$return = trim($return_arr[1]);
			}
			unset($return_arr);

			return $return;
		}

		/*获取客户端IP*/
		function get_client_ip()
		{
			static $ip = NULL;
			if ($ip !== NULL)
			{
				return $ip;
			}
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				$pos =  array_search('unknown',$arr);
				if(false !== $pos) unset($arr[$pos]);
				$ip   =  trim($arr[0]);
			}elseif (isset($_SERVER['HTTP_CLIENT_IP']))
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}elseif (isset($_SERVER['REMOTE_ADDR']))
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			// IP地址合法验证
			$ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
			return $ip;
		}
     /**
	 * 获取配置
	 */
	function get_config($filename,$item='')
	{
		$_config = array();
		if (!$filename)
		{
		  return false;
		}

		$filePath = dirname(__FILE__) . '/../application/config/' . $filename . '.ini.php';
		if (!is_file($filePath))
		{
		  return false;
		}
		$_config[$filename] = include $filePath;
		if (isset($_config[$filename][$item]))
		{
		  $value = $_config[$filename][$item];
		}
		else
		{
		  $value = $_config[$filename];
		}
		return $value;
	}

	/**
	* 字符串加密、解密函数
	*
	*
	* @param	string	$txt		字符串
	* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
	* @param	string	$key		密钥：数字、字母、下划线
	* @param	string	$expiry		过期时间
	* @return	string
	*/
	function rc4($string, $operation = 'ENCODE', $key = '', $expiry = 0)
	{
		$key_length = 4;
		$key = md5($key != '' ? $key : get_config('imc', 'key'));
		$fixedkey = hash('md5', $key);
		$egiskeys = md5(substr($fixedkey, 16, 16));
		$runtokey = $key_length ? ($operation == 'ENCODE' ? substr(hash('md5', microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';
		$keys = hash('md5', substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
		$string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

		$i = 0; $result = '';
		$string_length = strlen($string);
		for ($i = 0; $i < $string_length; $i++){
			$result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
		}
		if($operation == 'ENCODE') {
			return $runtokey . str_replace('=', '', base64_encode($result));
		} else {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		}
    }
}























