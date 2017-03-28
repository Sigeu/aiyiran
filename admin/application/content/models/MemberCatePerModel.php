<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 会员栏目权限表
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-5 15:03 创建此文件
 * <br>雷少进  2013-01-5 15:03 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   MemberCatePerModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class MemberCatePerModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "member_cate_per";//表名

	/**
	 * 会员栏目权限ID
	 * @param int or array() $cateid
	 * @return array()
	 * 返回一个三维数组 ，第一维数组的键是栏目ID，第二维数组的键是会员分组ID，第三维数组的值具体的操作权限
	 *	Array
	 *	(
	 *		[1] => Array
	 *		(
	 *			[1] => Array
	 *			(
	 *				[0] => 1
 	 *				[1] => 2
	 *			)
	 *
	 */
	public function getPermissionByCatgoryId($cateid)
	{
		$cateid = !is_array($cateid) ? (array)$cateid : array();
		$result = array();
		$tmp = array();
		if(!empty($cateid))
			$result = $this -> findAll(array('IN'=>array('categoryid'=>implode(',',$cateid))));
		if(!empty($result))
		{
			foreach ($result as $key => $val )
				$tmp[$val['categoryid']][$val['groupid']][] = $val['permissionid'];
		}
		return $tmp;
	}
	
	/**
	 * 会员组对应栏目权限
	 * @param unknown_type $groupid
	 * @author wr 2013.1.22
	 * 
	 */
	public function getPrivListByGroupId($groupid)
	{
		$result = array();
		$list   = array();
		
		$result = $this->findAll(array('groupid'=>$groupid));
		foreach ($result as $key=>$val)
		{
			$list[$val['categoryid']][] = $val['permissionid'];
		}
		return $list;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}