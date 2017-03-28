<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  商品类别
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class igoodssort extends BaseTag
{
	public  $defaultParam = array(
		'id'     => '0',              //分类id ，id=0 或者空 表示取全部分类
		'level'  => '0',              //取到第几级
		'return' => 'data',           //返回标志
		'type'   => 'all',            //此参数在id!=0时才有效 son(当id不等于0时 只取子集) all(当id不等于0时 也包含自己)
		'struct' => 'relation'        //返回结果的数据结构形式 等于relation就是父子级关系的数据结构，但是只能显示3层
	);

	/**
	 * 获取商品无限分类信息
	 * @param 标签参数
	 * @return 二维array()
	 */
	function lib_igoodssort($datas)
	{
		$param    = $this -> mergeDefaultParam($datas);
		$level = $param['level'];
		if($param['id'] && $param['type'] == 'all')
		{
			$level = $param['level'] - 1;
		}
		$tree = $this -> getGoodsSortByPid($param['id'],-1,$level);
		if($param['id'] && $param['type'] == 'all')
		{
			$sort = $this -> getGoodsSortById($param['id']);
			$sort['level'] = 0;
			array_unshift($tree,$sort);
			foreach ($tree as $key => $val ) $tree[$key]['level'] += 1;
		}
		$tmp = array();
		foreach ($tree as $key => $val ) $tmp[$val['sortid']] = $val;

		if($param['struct'] == 'relation')
			$tmp = $this ->formateParentChild($tmp);

		return array($param['return']=>$tmp);
    }

	/**
	 *格式化成子父级关系的数据结构
	 * @param递归出来的分类信息
	 * @return array()父子级关系的N维数组
	 */
	function formateParentChild($data)
	{
		if(empty($data))
			return array();
		$first = array();
		foreach($data as $key1 => $val1)
		{
			if($val1['level'] == 1)
				$first[] = $val1;
		}

		foreach($first as $key2 => $val2)
		{
			foreach($data as $key3 => $val3)
			{
				if($val2['sortid'] == $val3['pid'])
				{
					$first[$key2]['child'][$key3] = $val3;

					foreach($data as $key4 => $val4)
					{
						if($val4['pid'] == $first[$key2]['child'][$key3]['sortid'])
						{
							$first[$key2]['child'][$key3]['child'][$key4] = $val4;
						}
					}
					!isset($first[$key2]['child'][$key3]['child']) && ($first[$key2]['child'][$key3]['child'] = array());
				}
			}
			!isset($first[$key2]['child']) && ($first[$key2]['child'] = array());
		}
		return $first;
	}

	/**
	 * 获取商品无限极分类
	 * @param pid
	 * @param
	 * @param 查取深度
	 * @return 二维array()
	 */
	function getGoodsSortByPid ($pid,$t=-1,$level='0')
	{
		$pid = abs(intval($pid));
		$level = abs(intval($level));
		$t++;
		static $sort_temp;
		if($level && ($t == $level))
			return $sort_temp;
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'goods_sort` WHERE (`pid` = '.$pid.') AND (`isdefault` = 2) ORDER BY ordernum ASC,created DESC';
		$data = $this -> query($sql);
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['level'] = $t+1;
				$sort_temp[] = $val;
				$this -> getGoodsSortByPid($val['sortid'],$t,$level);
			}
		}
		return $sort_temp;
	}

	/**
	 * 通过分类ID获取该条信息
	 * @param sortiid
	 * @return 一维array()
	 */
	function getGoodsSortById ($id)
	{
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'goods_sort` WHERE `sortid` = '.$id.'';
		$res = $this -> query($sql);
		return !empty($res) ? array_pop($res) : array();
	}
}