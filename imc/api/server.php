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
	
	/**
	 * 用户添加
	 */
	function adduser($param=array())
	{
		if ($param)
		{
			$param['regdate'] = time();
			$param['regip'] = get_client_ip();
		}
		$newid = $this->objImcUsers->create($param);
		return  $newid;
	}
	
	/**
	 * 用户修改
	 * @param  $param     用户信息(字段要对应，不能有不存在的字段)
	 * @param  $condition 条件
	 * @return boolean
	 */
	function edituser($condition=array(),$param=array())
	{
		if ($param)
		{
			$param['updatedate'] = time();
		}
		
		$result = $this->objImcUsers->update($condition, $param);
		
		return $result;
		
	}
	
	/**
	 * 用户删除
	 * 
	 */
	function deluser($condition=array())
	{
		
		 
	}
	
	/**
	 * 用户名称验证
	 */
	function checkuser($username='')
	{
	    $result = $this->objImcUsers->findAll(array('username'=>$username));
	    return $result;
	}

	/*获取IP*/
	public function getforbidip()
	{
		$mo_forbidip = get_mo_config('mo_forbidip');
		return  $mo_forbidip;
	}
	/*获取allow IP*/
	public function getallowip()
	{
		$allowip = get_mo_config('mo_allowip');
		return  $allowip;
	}
}

    $server = new HproseHttpServer();
    $server->addMethod('adduser',new Server());
    $server->addMethod('edituser',new Server());
    $server->addMethod('checkuser',new Server());
	$server->addMethod('getforbidip',new Server());
	$server->addMethod('getallowip',new Server());
    $server->handle();
    
    
//     $objserver = new Server();
//     $objserver->edituser(array('username'=>'wangrui1'),array('email'=>'wangrui@126.com','status'=>1));
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    