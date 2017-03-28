<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * RolePermissionModel.php
 * 
 * 角色权限对照关系Model类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-17 下午2:14:30
 * @filename   RolePermissionModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 error_reporting(1);
class RolePermissionModel extends Model
{
	public $pk = "id"; 
	public $tableName = "role_permission";
	
	/**
	 * 
	 * 添加角色-权限对应关系（多条记录）
	 * @param unknown_type $rows
	 */
	public function addRolePermission($rows=array())
	{
		$this->addAll($rows);		
	}
	
	/**
	 * 
	 * 删除角色-权限对应关系
	 * @param  $conditions
	 */
	public function delRolePermission($conditions='')
	{
		$this->delete($conditions);
	}
	
	/**
	 * 
	 * 查询角色-权限对应关系
	 * @param  $conditions
	 */
	public function getRolePermissionList($conditions='',$sort='',$field='',$limit='')
	{
		$result = $this->findAll($conditions,$sort,$field,$limit);
		return $result;
	}

	/**
	 * 
	 * 角色对应的权限
	 */
	public function getPermissionByRoleId($roleid=1)
	{
		$result = $this->findAll("roleid='{$roleid}'");
		return $result;
		
	}

	/**
	 * 
	 * 角色对应的权限信息(所有信息)
	 */
	public function getPermissionInfoByRoleId($roleid=1)
	{
		$result = $this->where("roleid={$roleid}")
		               ->join("left join __PERMISSION__ on __ROLE_PERMISSION__.permissionid = __PERMISSION__.id")
					   ->select();
		return $result;
	}
}