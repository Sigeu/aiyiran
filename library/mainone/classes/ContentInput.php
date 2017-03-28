<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentInput.php
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-6 上午10:56:44
 * @filename   ContentInput.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class ContentInput {
	var $modelid;
	var $fields;
	var $categoryid;
	function __construct($modelid=1,$categoryid = 0) {
		if($categoryid)
		{
			$result = M('category')->field('model')->where(array('id'=>$categoryid))->getOne();
			$modelid = isset($result['model']) ? $result['model'] : 1;
		}
		$this->categoryid = $categoryid;
		$this->modelid = $modelid;
		$this->fields = M('field')->field('modelid,fieldtype,field')->where(array('modelid'=>$modelid,'flag'=>1))->order('sortid')->select();
	}
	
	/**
	 * @param array $data  修改的时候所用到的默认值
	 */
	public function get($data=array())
	{		
		$info = array();
        if (empty($data)) {
            return $info;
        }
		foreach($data as $key=>$value)
		{	
			
		    foreach($this->fields as $k=>$v)
			{
				if($v['field'] == $key)
				{
					$fieldtype = $v['fieldtype'];
					break;
				}
			}		
			if(!isset($fieldtype)) 
			{
				$info[$key] = $value;
			}
			else
			{
				if(!method_exists($this, $fieldtype)) continue;
				$newValue = $this->$fieldtype($value);
				if($newValue !== false) {
					$info[$key] = $newValue;
				}
			}
			
		}
		return $info;
	}
	
	
	
	/**
	 * 单文本文框
	* @param string $value     字段值
	 */
	public function text($value)
	{
		return $value;
	}
	/**
	 * 整形
	* @param string $value     字段值
	*/
	public function int($value)
	{
		return trim(intval($value));
	}
	/**
	 * 小数型
	 * @param string $value     字段值
	 */
	public function float($value)
	{
		return trim($value);
	}
	/**
	 * 多行文本
	 * @param string $value   
	 */
	public function textarea($value)
	{
		return trim($value);
	}

	/**
	 * 单选项
	 * @param string $value     字段值
	 */
	public function radio($value)
	{
		return trim($value);
	}
	/**
	 * 下拉框
	 * @param string $value     字段值
	 */
	public function select($value)
	{
		return $value;
	}
	/**
	 * 多选框
	 * @param string $value     字段值
	 */
	public function checkbox($value)
	{
		if($value) $value = explode(';',$value);
		return $value;
	}
	/**
	 * HTML文本（编辑器）
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function editor($value)
	{
		return $value;
	}
	/**
	 * 单图片
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function image($value=array())
	{ 
	    if($value&&strval($value)) 
		{
			$value = object_to_array(json_decode(htmlspecialchars_decode(strval($value))));
		}
        
        if (empty($value)) {
            $value = array(
                'savename' => '',
                'filename' => '',
                'size' => '',
                'src' => '',
                'alt' => '',
            );
        }
        
		return $value;
	}
	/**
	 * 单文件
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function file($value=array())
	{
		if($value&&strval($value)) 
		{
			$value = object_to_array(json_decode(htmlspecialchars_decode(strval($value))));
		}
		return $value;
	}
	/**
	 * 多图上传
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function images($value=array())
	{	
		$newvalue = array();
	    if($value) 
		{
			
			$newvalue = json_decode(htmlspecialchars_decode($value));
			foreach($newvalue as $k=>$v)
			{
			    $newvalue[$k] = object_to_array($v);
			}
		}
		return $newvalue;
	}
	/**
	 * 多附件
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function files($value)
	{
	    $newvalue = array();
	    if($value) 
		{
			$newvalue = json_decode(htmlspecialchars_decode($value));
			foreach($newvalue as $k=>$v)
			{
			    $newvalue[$k] = object_to_array($v);
			}
		}
		return $newvalue;
	}
	/**
	 * 时间
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function datetime($value)
	{
		return $value;
	}
	/**
	 * 联动菜单
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function linkage($value)
	{
		return $value;
	}
	/**
	 * 栏目
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function categoryid($value)
	{
		return intval($value);
	}
	/**
	 * 标题
	 */
	public function title($value)
	{
		return $value;
	}
	/**
	 * 关键字
	 */
	public function keywords($value)
	{
		return $value;
	}
	/**
	 * 描述
	 */
	public function  description($value)
	{
		return $value;
	}
	/**
	 * 排序选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function sorttype($value)
	{
		return intval($value);
	}
	/**
	 * 选择模板
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function template($value)
	{
		return trim($value);
	}
	/**
	 * 阅读权限
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function readpower($value)
	{
		if($value) $value = explode(';',$value);
		return $value;
	}
	/**
	 * 评论选项
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function allowcomment($value)
	{
		return intval($value);
	}
	/**
	 * 发布选项
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function publishopt($value)
	{
		return intval($value);
	}
	
	
}