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
include("../../vendor/hprose/HproseHttpServer.php");
class Server
{
	private $objImcUsers;
	public function __construct()
	{
		$this->objImcUsers = M('ImcUsers');
	}

	function setC_S($name)
	{
		setcookie('server_name',$name);
	}
	
	function getC_S()
	{
		return $_COOKIE['server_name'];
		
	}
	/**
	 * 验证通信状态:防止随便调用接口
	 */
	function syslogin_S($params=array())
	{
		extract($params);
		$appInfo = M('imc_app')->where(array('appname'=>$appname))->getOne();
		$str = rc4($code, 'DECODE',$appInfo['appkey']);
		if($str=='action=check_status')
		{
			
			$userInfo = $this->objImcUsers->where(array('password'=>md5($password),'username'=>$username))->getOne();
			if(!empty($userInfo))
			{		
				return $userInfo['username'];
			}
			else
			{
				return ;
			}
		}
		else
		{
			return false;
		}
	}
}
$server = new HproseHttpServer();
$server->setP3PEnabled(true);
$server->setCrossDomainEnabled(true);
$server->addMethod('syslogin_S',new Server());
$server->addMethod('setC_S',new Server());
$server->addMethod('getC_S',new Server());
$server->handle();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    