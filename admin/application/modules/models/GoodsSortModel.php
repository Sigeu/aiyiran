<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 商品分类
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-14 11:30 创建此文件
 * <br>雷少进  2013-01-14 11:31 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsSortModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class GoodsSortModel extends Model
{
	public $pk = "sortid";//主键
	public $tableName = "goods_sort";//表名

	/**
	 * 添加和修改时获取的分类树
	 * @param int $parentid
	 * @param int $t
	 * @return array()
	 */
	public function getGoodsSortTree($pid=0,$t=-1)
	{
		$t++;
		static $sort_temp;
		$data = $this -> findAll(array('pid'=>$pid),'isdefault ASC,ordernum ASC,created DESC','sortid,pid,sortname,isdefault,ordernum');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['sortname'] = str_repeat('&nbsp;',$t*3).'├'.$val['sortname'];
				$val['level'] = $t+1;
				$sort_temp[] = $val;
				$this -> getGoodsSortTree($val['sortid'],$t);
			}
		}
		return $sort_temp;
	}

	/**
	 * 根据无限分类查出的数组找出每项的子集包括子集的子集
	 * @param array() $parentid
	 * @return array()
	 */
	public function countChildNodeByArray($array)
	{
		$t1 = $array;
		foreach ($t1 as $key1 => $val1 )
		{
			$t3 = array_slice($t1,$key1+1);
			foreach ($t3 as $key3 => $val3 )
			{
				if(($val1['level'] == $val3['level']) || ($val1['level'] > $val3['level']) )
					break;
				else
					$t1[$key1]['child_id'][] = $val3['sortid'];
			}
			isset($t1[$key1]['child_id']) ? ($t1[$key1]['child_count'] = count($t1[$key1]['child_id'])) : ($t1[$key1]['child_count'] = 0);

			//$t1[$key1]['sortname'] = ltrim($t1[$key1]['sortname'],'&nbsp;*├');
			$t1[$key1]['sortname'] = ltrim(substr($t1[$key1]['sortname'],strpos($t1[$key1]['sortname'],'├')),'├');
			$t1[$key1]['margin_left'] = 35*($t1[$key1]['level']-1);
			$t1[$key1]['class'] = $t1[$key1]['pid'] ? 'level2' : 'level1';
			$t1[$key1]['flag'] = $t1[$key1]['child_count'] ? 'clos' : (!$t1[$key1]['pid'] ? 'open' : 'no');
			$t1[$key1]['show_hide'] = !$t1[$key1]['pid'] ? 'true' : 'none';
		}
		return $t1;
	}

	/**
	 * 获取子id
	 * @param int $parentid
	 * @return array()
	 */
	public function getChildidByPid($pid)
	{
		$id_arr = $this -> getGoodsSortTree($pid);
		$tmp = array();
		if(!$id_arr)
			return $tmp;
		foreach ($id_arr as $key => $val )
		{
			$tmp[] = $val['sortid'];
		}
		return $tmp;
	}

	/**
	 * 分类列表树
	 * @param int $parentid
	 * @param int $t
	 * @return array()
	 */
	public function getGoodsSortLevel($pid=0,$t=-1)
	{
		$t++;
		static $level_temp;
		static $_tmp1;
		static $_tmp2;
		$data = $this -> findAll(array('pid'=>$pid),null,'sortid,pid,sortname');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$level = $t+1;
				$_tmp1[] = $val['sortid'];//ID
				$_tmp2[] = $level;//级别深度

				$val['level'] = $level;
				$val['margin_left'] = max(($t-1)*35,0);
				$val['flag'] = 'open';
				$val['class'] = $val['pid'] ? 'level2' : 'level1';
				$level_temp[$val['sortid']] = $val;

				if(count($_tmp2) >1 && $val['pid'] != 0)
				{
					$end = end($_tmp2);//数组的组最后一个值  3
					$prev = prev($_tmp2);//上一个   3

					end($_tmp1);  //8
					$prev_id = prev($_tmp1);  //7

					$level_temp[$prev_id]['flag'] = $end == $prev ? 'no' : 'open';
				}
				$this -> getGoodsSortLevel($val['sortid'],$t);
			}
		}
		return $level_temp;
	}

	/**
	 * 把要删除商品分类下的商品移动到默认分类下
	 * @param $sortid  string  商品分类ID ,example: 1,3,4
	 */
	public function moveGoodsToDefault ($sortid)
	{
		$sql = 'UPDATE `'.$this -> tablePrefix.'goods` SET `sortid` = (SELECT `sortid` FROM `'.$this -> tablePrefix.'goods_sort` WHERE `isdefault` = 1  LIMIT 1)  WHERE `sortid` IN ('.$sortid.')';
		return $this -> query($sql);
	}
}