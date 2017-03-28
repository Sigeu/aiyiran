<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * server.php
 * 
 * cms用户接口类（服务器端） 
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
	private $objAdmin;
	private $objMember;
	public function __construct()
	{
		$this->objAdmin  = M('Admin');
		$this->objMember = M('Member');
	}
	
	/**
	 * 修改/开通/冻结  用户
	 * @param  $param     用户信息(字段要对应，不能有不存在的字段)
	 * @param  $condition 条件
	 * @return boolean
	 */
	function updateUser($conditions=array(),$param=array(),$isadmin=0)
	{
		if ($isadmin)
		{
			$result = $this->objAdmin->update($conditions, $param);
		}else 
		{
    		$result = $this->objMember->update($conditions, $param);
		}
	
		return $result;
	
	}
	/**
	 * 删除  用户
	 * @param  $condition 条件
	 * @return boolean
	 */
	function deleteUser($conditions=array(),$isadmin=0)
	{
		if ($isadmin)
		{
			$result = $this->objAdmin->delete($conditions);
		}else 
		{
    		$result = $this->objMember->delete($conditions);
		}
	
		return $result;
	
	}
	
}

    $server = new HproseHttpServer();
    $server->addMethod('updateUser',new Server());
    $server->addMethod('deleteUser',new Server());
    $server->handle();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    