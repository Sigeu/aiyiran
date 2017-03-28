<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  文章列表标签
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

class BaseTag extends Model
{

	/**
	 * 通过栏目ID获取栏目的全部信息
	 * @param 栏目ID
	 * @param 调取的字段 支持数组 和 逗号分隔的形式 不传或则*号表示调取全部
	 * @return
	 */
	protected function getCategoryById ($id,$field='*')
	{
		$sql = 'SELECT '.$this -> getField($field).' FROM `'.$this->tablePrefix.'category` WHERE `id` = '.abs(intval($id));
		$res = $this -> query($sql);
		return !empty($res) ? array_pop($res) : array();
	}

	/**
	 * 通过栏目id获取第一级子集ID
	 * @param 栏目id
	 * @return array 子集ID集合
	 */
	protected function getChildCategoryIds ($id)
	{
		$sql = 'SELECT `id` FROM `'.$this->tablePrefix.'category` WHERE `pid` = '.abs(intval($id));
		$res = $this -> query($sql);
		$tmp = array();
		foreach ($res as $key => $val )
		{
			$tmp[] = $val['id'];
		}
		return $tmp;
	}

	/**
	 * 通过栏目ID数组集合获取主表信息
	 * @param
	 * @return
	 */
	function getMainInfoByCids ($cids)
	{
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'maintable` WHERE `categoryid` IN ('.implode(',',$cids).')';
		$res = $this -> query($sql);
		return $res;
	}

	/**
	 * 通过模型ID找出此模型的信息
	 * @param
	 * @return
	 */
	function getModelById ($id,$field='*')
	{
		$sql = 'SELECT '.$this -> getField($field).' FROM `'.$this->tablePrefix.'model` WHERE `id` = '.abs(intval($id));
		$res = $this -> query($sql);
		return !empty($res) ? array_pop($res) : array();
	}

	/**
	 * 通过表名和信息ID获取该条信息扩展表的内容
	 * @param 扩展表表名
	 * @param 信息ID
	 * @return 扩展信息
	 */
	public function getExtTableInfo ($table,$id)
	{
		$sql = 'SELECT * FROM `'.$this->tablePrefix.$table.'` WHERE `maintable_id` = '.$id.' LIMIT 1';
		$res = $this -> query($sql);
		return !empty($res) ? array_pop($res) : array();
	}

	/**
	 * 批量获取扩展表的信息通过信息ID
	 * @param 扩展表表名
	 * @param 扩展信息ID集合
	 * @return
	 */
	public function getBatchExtTableInfo ($table,$ids)
	{
		$sql = 'SELECT * FROM `'.$this->tablePrefix.$table.'` WHERE `maintable_id` IN ('.$this ->getSqlIDStr($ids).')';
		$res = $this -> query($sql);
		if(!empty($res))
		{
			foreach ($res as $key => $val )
			{
				$res[$val['maintable_id']] = $val;
				unset($res[$key]);
			}
			return $res;
		}
		return array();
	}

	/**
	 * 获取sql语句的in条件字符串
	 * @param ids数字 或者 逗号分隔的字符串
	 * @return string
	 */
	private function getSqlIDStr ($ids)
	{
		is_string($ids) && ($ids = explode(',',$ids));
		foreach ($ids as $key => $val )
			$ids[$key] = intval($val);

		return implode(',',$ids);
	}

	/**
	 * 获取字段
	 * @param
	 * @return
	 */
	private function getField ($param='')
	{
		if($param == '' || $param == '*')
			return '*';
		is_string($param) && ($param = explode(',',$param));
		return implode(',',$param);
	}

	/**
	 * 合并默认参数 过滤无效参数
	 * @param
	 * @return
	 */
	protected function mergeDefaultParam ($param)
	{
		if(isset($this -> defaultParam))
		{
			foreach ($this -> defaultParam as $key => $val )
			{

				isset($param[$key]) && $this -> defaultParam[$key] = $param[$key];
			}
			return $this -> defaultParam;
		}
		else
		{
			return $param;
		}
	}
}
?>
