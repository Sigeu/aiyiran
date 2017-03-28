<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 栏目管理
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-5 15:03 创建此文件
 * <br>雷少进  2013-01-5 15:03 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class CategoryModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "category";//表名

	/**
	 * 添加和修改时获取的分类树
	 * @param int $parentid
	 * @param int $t
	 * @return array()
	 */
	public function getCategoryTree($pid=0,$t=-1)
	{
		$t++;
		static $cat_temp;
		$data = $this -> findAll(array('pid'=>$pid),'ordernum ASC,created DESC','id,pid,model,catname,ordernum,seo_title,seo_keywords,seo_description');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['catname'] = str_repeat('&nbsp;',$t*3).'├'.$val['catname'];
				$val['level'] = $t+1;
				$cat_temp[] = $val;
				$this -> getCategoryTree($val['id'],$t);
			}
		}
		return $cat_temp;
	}

    //发布设置中ajax模型动态调取栏目用
    public function modelCategory($mod, $pid=0, $t=-1)
	{
		$t++;
		static $cat_temp;
		$data = $this -> findAll(array('pid'=>$pid,'model'=>$mod),'ordernum ASC,created DESC','id,pid,model,catname,ordernum');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['catname'] = str_repeat('&nbsp;',$t*3).'├'.$val['catname'];
				$val['level'] = $t+1;
				$cat_temp[] = $val;
				$this -> modelCategory($mod, $val['id'], $t);
			}
		}
		return $cat_temp;
	}


	/**
	 * 根据无限分类查出的数组找出每项的子集包括子集的子集
	 * @param array() $parentid
	 * @return array()
	 */
	public function countChildNodeByArray($array)
	{
		if(empty($array))
			return array();
		$t1 = $array;
		foreach ($t1 as $key1 => $val1 )
		{
			$t3 = array_slice($t1,$key1+1);
			foreach ($t3 as $key3 => $val3 )
			{
				if(($val1['level'] == $val3['level']) || ($val1['level'] > $val3['level']) )
					break;
				else
					$t1[$key1]['child_id'][] = $val3['id'];
			}
			isset($t1[$key1]['child_id']) ? ($t1[$key1]['child_count'] = count($t1[$key1]['child_id'])) : ($t1[$key1]['child_count'] = 0);

			//$t1[$key1]['catname'] = ltrim($t1[$key1]['catname'],'&nbsp;*├');
			$t1[$key1]['catname'] = ltrim(substr($t1[$key1]['catname'],strpos($t1[$key1]['catname'],'├')),'├');
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
		$id_arr = $this -> getCategoryTree($pid);
		$tmp = array();
		if(!$id_arr)
			return $tmp;
		foreach ($id_arr as $key => $val )
		{
			$tmp[] = $val['id'];
		}
		return $tmp;
	}

	/**
	 * 栏目列表树
	 * @param int $parentid
	 * @param int $t
	 * @return array()
	 */
	public function getCategoryLevel($pid=0,$t=-1)
	{
		$t++;
		static $level_temp;
		static $_tmp1;
		static $_tmp2;
		$data = $this -> findAll(array('pid'=>$pid),'ordernum ASC,created DESC','id,pid,model,ordernum,catname');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$level = $t+1;
				$_tmp1[] = $val['id'];//ID
				$_tmp2[] = $level;//级别深度

				$val['level'] = $level;
				$val['margin_left'] = max(($t-1)*35,0);
				$val['flag'] = 'open';
				$val['class'] = $val['pid'] ? 'level2' : 'level1';
				$level_temp[$val['id']] = $val;

				if(count($_tmp2) >1 && $val['pid'] != 0)
				{
					$end = end($_tmp2);//数组的组最后一个值  3
					$prev = prev($_tmp2);//上一个   3

					end($_tmp1);  //8
					$prev_id = prev($_tmp1);  //7

					$level_temp[$prev_id]['flag'] = $end == $prev ? 'no' : 'open';
				}
				$this -> getCategoryLevel($val['id'],$t);
			}
		}
		return $level_temp;
	}

	/**
	 * 获取所有缓存列表
	 * @author wr
	 * @return array:$list
	 */
	public function  getCategoryCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,catname";
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['catname'];
		}
		set_cache('category', $list,'common');
		return $list;
	}

	/**
	 * 删除主表对应附表的所有信息
	 * @param array ()
	 * @return
	 */
	function deleteSecondTableInfo ($param = array('tablename'=>'','categoryid'=>0))
	{
		$sql = 'DELETE FROM `'.$this -> tablePrefix.$param['tablename'].'` WHERE `maintable_id` IN (SELECT `id` FROM `'.$this -> tablePrefix.'maintable` WHERE `categoryid` = "'.$param['categoryid'].'")';
		return $this -> query($sql);
	}

	/**
	 * 更新一下栏目中缺少模型的信息
	 */
	function updateColumnModel ()
	{
		$sql = 'UPDATE `'.$this -> tablePrefix.'category` SET `model` = 1  WHERE `model` NOT IN (SELECT `id` FROM `'.$this -> tablePrefix.'model`)';
		$this -> query($sql);
	}
}