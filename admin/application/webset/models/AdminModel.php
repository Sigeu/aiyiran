<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AdminModel.php
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
 
class AdminModel extends Model
{
	public $pk = "id";
	public $tableName = "admin";
	
	
	/**
	 * 获取管理员数量
	 */
	public function getCount($condition=array())
	{
		return $this->findCount($condition);
	}
	
	
}