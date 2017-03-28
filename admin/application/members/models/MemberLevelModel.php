<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberLevelModel.php
 * 
 * 会员分组级别Model类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-5 下午2:38:49
 * @filename   MemberLevelModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class MemberLevelModel extends Model
{
	public $pk = "id";
	public $tableName = "member_level";
	
	/**
	 * 获取会员分组级别缓存列表(开启的)
	 * @return array:$list
	 */
	public function  getLevelCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,levelname";
		$options['where'] = array('status'=>1);
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['levelname'];
		}
		set_cache('memberlevel', $list,'common');
		return $list;
	}
	
	/**
	 * 获取会员分组所有级别缓存列表（所有）
	 * @return array:$list
	 */
	public function  getAllLevelCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,levelname";
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['levelname'];
		}
		set_cache('allmemberlevel', $list,'common');
		return $list;
	}
	
	
	/**
	 * 获取会员分组-级别缓存列表
	 * @return array:$list
	 */
	public function  getGroupLevelCacheList()
	{
		$list = array();
		$options  = array();
		
		$objGroup = D("MemberGroup");
		$allgroup = get_cache('allmembergroup','common');
		if (!$allgroup)
		{
			$allgroup = $objGroup->getAllGroupCacheList();
		}
		$options['field'] = "id,groupid,levelname";
		$options['order'] = "groupid";
		$result = $this->select($options);
		
		foreach ($allgroup as $key=>$val)
		{
			foreach ($result as $row)
			{
				if ($key==$row['groupid'])
				{
					$list[$key][$row['id']]=$row['levelname'];
				}
			}
		}
		set_cache('grouplevel', $list,'common');
		return $list;
	}
	
	/**
	 * 通过会员分组id获取级别列表
	 * @param string $groupid
	 * @return array:
	 */
	public function getLevelListByGroupId($groupid)
	{
		$result = array();
		if ($groupid)
		{
		    $result = $this->findAll(array('groupid'=>$groupid));
		}
		
		return $result;
	}
	
	
	
	
}