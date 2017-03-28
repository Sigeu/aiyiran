<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * user.php
 *
 * 用户接口类（服务器端）
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-3-20 上午11:40:24
 * @filename   user.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
define('ROOT', dirname(__FILE__) .'../..'. DIRECTORY_SEPARATOR);
include(ROOT."/../vendor/hprose/HproseHttpClient.php");
HproseHttpClient::keepSession(); //保持回话，防止下个回话后丢失问题
HproseHttpClient::hproseKeepCookieInSession();

class Client
{
	private $code;
	private $client;
	private $appname;

	public function __construct()
	{
		$this->client = new HproseHttpClient($this->get_config('imc','app_url')."/imc/api/imc_server.php");
		$this->client->setKeepAlive = true;
		$this->code = $this->rc4('action=check_status', 'ENCODE',$this->get_config('imc','key'));
		$this->appname = $this->get_config('imc','appname');

	}

	/**
	 * 同步登陆接口
	 */
	function syslogin($params)
	{
		$params['code'] = $this->code;
		$params['appname'] = $this->appname;
		$username = $this->client-> syslogin($params);
		if($username)
		{
			$this->client->setCC($username);
			$server_username = $this->client->getCC();
		}
		return $server_username;

	}

	/*获取用户名*/
	function getCC()
	{
		return $this->client->getCC();
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























