<?php
/**
 *--------------------------------------------------------------------------------------
 * 爱站CMS内容管理系统
 *
 * 其它内容管理系统模型服务类
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>  2013-07-27 10:52
 * @filename   OthercontentModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.izhancms.com)
 * @license    http://www.izhancms.com/license/
 * @version    izhancms 1.0
 *-------------------------------------------------------------------------------------
 */
class OthercontentModel extends Model
{
	/**
	 * 获取其它模型内容分页列表
	 * @param  搜索条件
	 * @return array()
	 */
	public function getOtherContentPlist ($param=array())
	{
		//其它模型的栏目
		$category = $this ->getCategoryByOtherModel();
		empty($category) && ($category[]=0);

		//查询信息
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'maintable` WHERE (`categoryid` IN ('.implode(',',$category).'))';
		$param['keywords']   && ($sql .= ' AND (`title` LIKE \'%'.$param['keywords'].'%\')');
		$param['categoryid'] && ($sql .= ' AND (`categoryid` = '.$param['categoryid'].')');
		$sql .= ' ORDER BY '.$param['orderfield'].' '.$param['ordertype'].'';

		//分页列表
		$plist = $this -> getPageList(array('sql'=>$sql,'pagesize'=>20));
		return $plist;
	}

	/**
	 * 获取栏目的模型的其它模型的所有栏目，即栏目表中model字段不等于1或者2的所有栏目
	 * @return 栏目栏目ID的一维数组，键和值都是栏目ID array()
	 */
	public function getCategoryByOtherModel ()
	{
		$sql = 'SELECT `id` FROM `'.$this->tablePrefix.'category` WHERE `model` NOT IN (1,2)';
		$list = $this -> query($sql);
		$tmp = array();
		foreach ($list as $key => $val )
		{
			$tmp[$val['id']] = $val['id'];
		}
		return $tmp;
	}

	/**
	 * 递归所有栏目信息
	 * @return array()
	 */
	public function getAllCategoryInfo ($pid=0)
	{
		$category = array();
		$this -> recurseQueryTree($pid,$category,'category',0,'*','id','pid','level');
		foreach ($category as $key => $val )
		{
			$category[$key]['_catname'] = str_repeat('&nbsp;',($val['level']-1)*3).'├'.$val['catname'];
		}
		return $category;
	}

	/**
	 * 格式化内容模型字段
	 * @return array()
	 */
	public function formateModelName ($list=array())
	{
		//获取栏目ID集合
		$categoryid = $this -> getCategoryIdByContentList($list);
		$modelid = $this ->getModelIdByCategory($categoryid);
		$model = $this -> getModelNameByModelIds($modelid);
		$tmp = array();
		foreach ($modelid as $key => $val )
		{
			$tmp[$key] = $model[$val];
		}
		foreach ($list as $key => $val )
		{
			$list[$key]['modelname'] = $tmp[$val['categoryid']];
			$list[$key]['modelid']   = $modelid[$val['categoryid']];
		}
		return $list;
	}

	/**
	 * 格式化栏目名称
	 * @return array()
	 */
	public function formateCategoryName ($list=array())
	{
		//获取栏目ID集合
		$categoryid = $this -> getCategoryIdByContentList($list);
		$catname = $this -> getCategoryNameByIds($categoryid);

		foreach ($list as $key => $val )
		{
			$list[$key]['catname'] = $catname[$val['categoryid']];
		}
		return $list;
	}



	/**
	 * 通过模型id集合获取 模型名称
	 * @param 模型id数组集合
	 * @return 一维数组集合 键是模型ID 值是模型名称
	 */
	function getModelNameByModelIds ($model)
	{
		empty($model) && ($model[] = 0);
		$sql = 'SELECT `id`,`name` FROM `'.$this->tablePrefix.'model` WHERE `id` IN ('.implode(',',$model).')';
		$list = $this -> query($sql);
		$tmp = array();
		foreach ($list as $key => $val )
		{
			$tmp[$val['id']] = $val['name'];
		}
		return $tmp;
	}

	/**
	 * 通过栏目ID集合获取模型
	 * @param 栏目ID的一维数组集合
	 * @return 一维数组集合 键是栏目ID 值是模型ID
	 */
	public function getModelIdByCategory ($category)
	{
		empty($category) && ($category[] = 0);
		$sql = 'SELECT `id`,`model` FROM `'.$this->tablePrefix.'category` WHERE `id` IN ('.implode(',',$category).')';
		$list = $this -> query($sql);
		$tmp = array();
		foreach ($list as $key => $val )
		{
			$tmp[$val['id']] = $val['model'];
		}
		return $tmp;
	}

	/**
	 * 获取栏目ID
	 * @param
	 * @return 一维数组键值对儿 键是内容ID  值是栏目ID
	 */
	public function getCategoryIdByContentList ($list)
	{
		$tmp = array();
		foreach ($list as $key => $val )
		{
			$tmp[$val['id']] = $val['categoryid'];
		}
		return $tmp;
	}

	/**
	 * 获取栏目名称
	 * @param 栏目ID数组集合
	 * @return 一维数组键值对儿 键是栏目ID  值是栏目名称
	 */
	public function getCategoryNameByIds ($category)
	{
		empty($category) && ($category[] = 0);
		$category = array_unique($category);

		$sql = 'SELECT `id`,`catname` FROM `'.$this->tablePrefix.'category` WHERE id IN ('.implode(',',$category).')';
		$list = $this -> query($sql);
		$tmp = array();
		foreach ($list as $key => $val)
		{
			$tmp[$val['id']] = $val['catname'];
		}
		return $tmp;
	}
}