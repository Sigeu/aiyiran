<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  栏目分类标签
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>  2013-07-11
 * @filename   column.lib.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.izhancms.com)
 * @license    http://www.izhancms.com   izhanCms 1.0
 * @version    izhanCms 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.izhancms.com
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class column extends BaseTag
{
	public  $defaultParam = array(
		'id'     => '0',              //栏目id ，id=0 或者空 表示取全部分类
		'level'  => '0',              //取到第几级
		'return' => 'data',           //返回标志
		'type'   => 'all',            //此参数在id!=0时才有效 son(当id不等于0时 只取子集) all(当id不等于0时 也包含自己)
		'struct' => 'norelation'      //返回结果的数据结构形式 等于relation就是父子级关系的数据结构，目前只能显示3层
	);

	/**
	 * 获取商品无限分类信息
	 * @param 标签参数
	 * @return 二维array()
	 */
	function lib_column($datas)
	{
		//设置获取深度
		$param    = $this -> mergeDefaultParam($datas);
		$level = $param['level'];
		if($param['id'] && $param['type'] == 'all')
		{
			$level = $param['level'] - 1;
		}

		//递归获取某个栏目下的子栏目，当id不等于0时获取的只是子集，不包括本省，反之获取全部
		$_column_tree = array();
		$this -> getColumnByPid($param['id'],$_column_tree,-1,$level);

		//判断是否需要获取本身的信息
		if($param['id'] && $param['type'] == 'all')
		{
			$sort = $this -> getCategoryById($param['id']);
			$sort['level'] = 0;
			array_unshift($_column_tree,$sort);
			foreach ($_column_tree as $key => $val ) $_column_tree[$key]['level'] += 1;
		}

		//把键值置为自己的ID
		$tmp = array();
		foreach ($_column_tree as $key => $val ) $tmp[$val['id']] = $val;

		//格式化数据格式
		if($param['struct'] == 'relation')
			$tmp = $this ->formateParentChild($tmp);

		return array($param['return']=>$tmp);
    }

	/**
	 * 格式化成子父级关系的数据结构
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
				if($val2['id'] == $val3['pid'])
				{
					$first[$key2]['child'][$key3] = $val3;

					foreach($data as $key4 => $val4)
					{
						if($val4['pid'] == $first[$key2]['child'][$key3]['id'])
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
	 * 获取栏目无限极分类
	 * @param pid
	 * @param
	 * @param 查取深度
	 * @return 二维array()
	 */
	function getColumnByPid ($pid,&$sort_temp,$t=-1,$level='0')
	{
		$pid = abs(intval($pid));
		$level = abs(intval($level));
		$t++;
		if($level && ($t == $level))
			return $sort_temp;
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'category` WHERE (`pid` = '.$pid.') ORDER BY ordernum ASC,created DESC';
		$data = $this -> query($sql);
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['level'] = $t+1;
				$sort_temp[] = $val;
				$this -> getColumnByPid($val['id'],$sort_temp,$t,$level);
			}
		}
	}
}