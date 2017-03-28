<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * RoleModel.php
 * 
 * 系统角色Model类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-5 下午2:38:49
 * @filename   RoleModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class RoleModel extends Model
{
	public $pk = "id";
	public $tableName = "admin_role";
	
	/**
	 * 获取角色缓存列表
	 * @return array:rolelist
	 */
	public function  getRoleCacheList()
	{
		$rolelist = array();
		$options  = array();
		$options['field'] = "id,rolename";
		$options['where'] = array('status'=>1);
		$options['order'] = "id ASC";
		$list = $this->select($options);
		foreach ($list as $row)
		{
			$rolelist[$row['id']] = $row['rolename'];
		}
		set_cache('role', $rolelist,'common');
		return $rolelist;
	}
	
}