<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberGroupModel.php
 * 
 * 会员分组Model类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-5 下午2:38:49
 * @filename   MemberGroupModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class MemberGroupModel extends Model
{
	public $pk = "id";
	public $tableName = "member_group";
	
	/**
	 * 获取会员分组缓存列表（开启的会员组）
	 * @return array:$list
	 */
	public function  getGroupCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,groupname";
		$options['where'] = array('status'=>1);
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['groupname'];
		}
		set_cache('membergroup', $list,'common');
		return $list;
	}
	
	/**
	 * 获取会员分组缓存列表（所有会员组）
	 * @return array:$list
	 */
	public function  getAllGroupCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,groupname";
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['groupname'];
		}
		set_cache('allmembergroup', $list,'common');
		return $list;
	}
	
}