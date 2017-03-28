<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberModel.php
 *
 * 会员表model
 *
 * @author     雷少进<leishaojin@mail.b2b.cn>   2013-01-31 15:06
 * @filename   MemberModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class MemberModel extends Model
{
	public $pk = "id";
	public $tableName = "member";

	/**
	 * @param array()  array(1,2,3,4);
	 * 通过会员组ID数组，查询正常的（激活的，未删除的）会员ID数组
	 * 返回值形式
	 *  Array
		(
			[0] => Array
				(
					[id] => 17
				)

			[1] => Array
				(
					[id] => 18
				)
		)

		    [3] => 3
            [4] => Array
                (
                    [0] => 15
                )

            [5] => 5
            [6] => 6
            [7] => 7
            [8] => 8
            [10] => Array
                (
                    [0] => 12
                    [1] => 13
                    [2] => 14
                )

            [11] => Array
                (
                    [0] => 3
                    [1] => 4
                    [2] => 5
                )

            [12] => Array
                (
                    [0] => 1
                    [1] => 6
                    [2] => 7
                )

            [13] => Array
                (
                    [0] => 2
                    [1] => 8
                )



	 */
	function getMemberByGroup ($groupid)
	{
		if(!is_array($groupid) || empty($groupid)) return array();
		return $this -> findAll(array('in'=>array('groupid'=>implode(',',$groupid)),'status'=>1,'isdel'=>0),false,'id');
	}

	function getMemberByGroupOrLevel ($gl)
	{
		if(!is_array($gl) || empty($gl)) return array();
		$tmp = array();
		$where = '';
		foreach ($gl as $key => $val )
		{
			if(is_array($val) && !empty($val))
				$where .=  '(groupid='.$key.' AND levelid IN ('.implode(',',$val).')) OR ';
			else
			{
				$where .= ' (groupid='.$key.') OR ';
			}

		}
		$where = '('.$where.' 0 )';
		$where .= ' AND status=1 AND isdel=0';
		return $this ->findAll($where,false,'id');
	}

	/**
	 * @param string 以逗号分隔的会员名  张山,lishi,12312
	 * 返回会员ID数组
	 *  Array
		(
			[0] => Array
				(
					[id] => 17
				)

			[1] => Array
				(
					[id] => 18
				)
		)
	 */
	function getMemberByNames ($names)
	{
		if(empty($names)) return array();
		$names = explode(',',$names);
		foreach ($names as $key => $val )
		{
			$name = filterBadStr(trim($val));
			if(empty($name))
				unset($names[$key]);
			else
				$names[$key] = $name;
		}
		return $this -> findAll(array('in'=>array('username'=>'\''.implode('\',\'',$names).'\''),'status'=>1,'isdel'=>0),false,'id');
	}

	/**
	 * 获取 会员数量
	 * @param array $condition 条件
	 */
	function getCount($condition=array())
	{
		return $this->findCount($condition);
	}

}