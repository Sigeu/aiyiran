<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberDealModel.php
 * 
 * 会员注册协议Model类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-5 下午2:38:49
 * @filename   MemberDealModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class MemberDealModel extends Model
{
	public $pk = "id";
	public $tableName = "registdeal";
	
	/**
	 * 获取会员注册协议缓存列表(开启状态的缓存，用于添加、修改会员分组注册协议下拉列表)
	 * @return array:$list  array(id=>name)
	 */
	public function  getMemberDealCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,name";
		$options['where'] = array('iseffect'=>1);
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['name'];
		}
		set_cache('memberdeal', $list,'common');
		return $list;
	}
	
}