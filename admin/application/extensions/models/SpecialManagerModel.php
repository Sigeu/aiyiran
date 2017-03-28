<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 管理员-专题 权限表
 *
 * @author     黄利科 <huanglike@mail.b2b.cn>
 * @filename   SpecialManagerModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class SpecialManagerModel extends Model
{
	public function getManagerPermissionById($sid)
	{
		$sid = !is_array($sid) ? (array)$sid : array();
		$result = array();
		$tmp = array();
		if(!empty($sid))
			$result = $this -> findAll(array('IN'=>array('specialid'=>implode(',',$sid))));
		if(!empty($result))
		{
			foreach ($result as $key => $val )
				$tmp[$val['specialid']][$val['roleid']][] = $val['permissionid'];
		}
		return $tmp;
	}
}