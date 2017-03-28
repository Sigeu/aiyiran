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
include("db.php");
include("../../vendor/hprose/HproseHttpClient.php");
include("../../vendor/hprose/HproseHttpServer.php");
HproseHttpClient::keepSession();
HproseHttpClient::hproseKeepCookieInSession();
class Server
{
	private $objImcUsers;
	public function __construct()
	{
		$this->client =  new HproseHttpClient("http://www.cms.loc/imc/api/imc_server_common.php");
		$this->objImcUsers = M('ImcUsers');
	}

	function setC($name)
	{
		return $this->client->setC_S($name);//setcookie('server_name',$name,time()+3600*24);
	}
	

	function getC()
	{
		return $this->client->getC_S();//return $_COOKIE['server_name'];
	}

	/**
	 * 验证通信状态:防止随便调用接口
	 */
	function syslogin($params=array())
	{
		return $this->client->syslogin_S($params);
	}

	/**
	 * 验证通信状态:防止随便调用接口
	 */
	

	
}
$server = new HproseHttpServer();
$server->setP3PEnabled(true);
//$server->setCrossDomainEnabled(true);
$server->addMethod('syslogin',new Server());
$server->addMethod('setC',new Server());
$server->addMethod('getC',new Server());


$server->handle();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    