<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 会员组-专题 权限表
 *
 * @author     黄利科 <huanglike@mail.b2b.cn>
 * @filename   SpecialMemberModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class SpecialMemberModel extends Model
{
	public function getMemberPermissionById($sid)
	{
		$sid = !is_array($sid) ? (array)$sid : array();
		$result = array();
		$tmp = array();
		if(!empty($sid))
			$result = $this -> findAll(array('IN'=>array('specialid'=>implode(',',$sid))));
		if(!empty($result))
		{
			foreach ($result as $key => $val )
				$tmp[$val['specialid']][$val['groupid']][] = $val['permissionid'];
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
			$list[$val['specialid']][] = $val['permissionid'];
		}
		return $list;

	}



























}