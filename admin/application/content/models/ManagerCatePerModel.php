<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 管理员栏目权限表
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-5 15:03 创建此文件
 * <br>雷少进  2013-01-5 15:03 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   ManagerCatePerModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class ManagerCatePerModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "manager_cate_per";//表名

	/**
	 * 管理员栏目权限ID
	 * @param int or array() $cateid
	 * @return array()
	 * 返回一个三维数组 ，第一维数组的键是栏目ID，第二维数组的键角色ID，第三维数组的值具体的操作权限
	 *	Array
	 *	(
	 *		[1] => Array
	 *		(
	 *			[1] => Array
	 *			(
	 *				[0] => 1
 	 *				[1] => 2
	 *				[2] => 5
 	 *				[3] => 6
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
				$tmp[$val['categoryid']][$val['roleid']][] = $val['permissionid'];
		}
		return $tmp;
	}
}