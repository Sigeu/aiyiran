<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentValue.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-6 下午4:10:41
 * @filename   ContentValue.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class ContentValue {
	var $modelid;
	var $fields;
	var $obj;
	function __construct($modelid,$obj,$field='') {
		$modelid = $modelid ? $modelid : 1;
		$this->modelid = $modelid;
		if(!empty($field))
		{
			$this->fields = $field;
		}else{
			$this->fields = M('field')->where(array('modelid'=>$modelid,'flag'=>1))->order('sortid')->select();
		    $this->obj = $obj;
		}
	}

	/**
	 * @param array $data  修改的时候所用到的默认值
	 */
	public function get($data=array())
	{
	    $info = array();
		foreach($this->fields as $k=>$v)
		{

			$minlength = $v['minlength'];
			$maxlength = $v['maxlength'];
			$pattern = $v['pattern'];
			$errortips = $v['errortips'];
			$fieldtype = $v['fieldtype'];
			$key = $v['field'] ? $v['field'] : $v['dataname'];
			$name = $v['name'];
			if(!method_exists($this, $fieldtype)) continue;
			if(isset($data[$key])&&$data[$key])
			{
				$newValue = $this->$fieldtype($data[$key],$minlength,$maxlength,$pattern,$errortips,$name);
				if($newValue !== false) {
					$info[$key] = $newValue;
				}
			}
			else
			{
				$info[$key] = '';
			}
		
	
		}	
		return $info;
	}
	/**
	 * 最小长度判断
	 * @param unknown_type $minlength
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	function ismin($minlength,$value,$name)
	{
		if(strlen($value)<$minlength)
		{
			$this->obj->dialog('','error',$name.'不能长度不能小于'.$minlength);
		}
	}

	/**
	 * 最大长度判断
	 * @param unknown_type $minlength
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	function ismax($maxlength,$value,$name)
	{
		if(abslength($value)>$maxlength)
		{
			$this->obj->dialog('','error',$name.'不能长度不能大于'.$maxlength);
		}
		return true;

	}
	/**
	 * 长度判断
	 */
	function len($minlength,$maxlength,$value,$name)
	{
		if($minlength&& $value) $this->ismin($minlength, $value, $name);
		if($maxlength&& $value) $this->ismax($maxlength, $value, $name);
		return true;
	}
	/**
	 * 格式判断
	 */
	function ispar($pattern,$value,$name,$errortips)
	{
		/*$pattern =
		if($pattern && !preg_match($pattern, $value) && $value)
		{
			$errortips = $errortips ? $errortips : $name.'格式不正确';
			$this->obj->dialog('','error',$errortips);
		}*/
		return true;
	}

	/**
	 * 单文本文框
	* @param string $value     字段值
	 */
	public function text($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		$this->len($minlength, $maxlength, $value, $name);
		//$this->ispar($pattern, $value, $name, $errortips);
		return $value;
	}
	/**
	 * 整形
	* @param string $value     字段值
	*/
	public function int($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		$this->ispar('/^[0-9.-]+$/', $value, $name, $errortips);
		return trim($value);
	}
	/**
	 * 小数型
	 * @param string $value     字段值
	 */
	public function float($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return trim($value);
	}
	/**
	 * 多行文本
	 * @param string $value
	 */
	public function textarea($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return trim($value);
	}

	/**
	 * 单选项
	 * @param string $value     字段值
	 */
	public function radio($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return trim($value);
	}
	/**
	 * 下拉框
	 * @param string $value     字段值
	 */
	public function select($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 多选框
	 * @param string $value     字段值
	 */
	public function checkbox($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		if($value) $value = implode(';',$value);
		return $value;
	}
	/**
	 * HTML文本（编辑器）
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function editor($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 单图片
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function image($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		$tempvalue = '';
	    if(!empty($value))
		{				
			
			if(isset($value['show'])) unset($value['show']);		
			if(isset($value[1]['oldfile'])) 
			{		
				$tem = end($value);
				$tem['oldfile']=$value[1]['oldfile'];
				$value[1] = $tem;
			}
			$value = reset($value);	
			if(isset($value['oldfile']) && isset($value['src']))
			{
				if($value['oldfile'] && $value['oldfile'] != $value['src'])
				{
					$uploadValue = mouploadAccessory(array('file'=>array($value),'folder'=>'content'));
					@unlink(DIR_UPLOADFILE.$value['oldfile']);
					$newvalue = array(
						'savename' => $uploadValue[0]['selfname'],
						'filename' => $uploadValue[0]['filename'],
						'size' => $uploadValue[0]['size'],
						'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
						'alt' => $uploadValue[0]['alt'],   //图片ALT注释 20130905添加
					);
				}
				else
				{
					$newvalue = array(
						'savename' => $value['selfname'],
						'filename' => $value['filename'],
						'size' => $value['size'],
						'src' => $value['src'],
						'alt' => $value['alt'],          //图片ALT注释 20130905添加
					);
				}	
				
			}
			else
			{
				$newvalue = array();
				if(isset($value['selfname'])&&$value['selfname'])
				{		
					$uploadValue = mouploadAccessory(array('file'=>array($value),'folder'=>'content'));
					$newvalue = array(
							'savename' => $uploadValue[0]['selfname'],
							'filename' => $uploadValue[0]['filename'],
							'size' => $uploadValue[0]['size'],
							'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
						    'alt' => $uploadValue[0]['alt'],   //图片ALT注释 20130905添加
					);						
			
				}
			}			
		    if(!empty($newvalue))
			{
				$tempvalue = json_encode($newvalue);
			}
					
		}		
		return $tempvalue;
	}
	/**
	 * 单文件
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function file($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
        $tempvalue = '';
	    if(!empty($value))
		{				
			
			if(isset($value['show'])) unset($value['show']);		
			if(isset($value[1]['oldfile'])) 
			{		
				$tem = end($value);
				$tem['oldfile']=$value[1]['oldfile'];   
				$value[1] = $tem;
			}  //保证取到最后一次上传的图片
			$value = reset($value);	
			if(isset($value['oldfile']) && isset($value['src']))
			{
				if($value['oldfile'] && $value['oldfile'] != $value['src'])
				{
					$uploadValue = mouploadAccessory(array('file'=>array($value),'folder'=>'content'));
					@unlink(DIR_UPLOADFILE.$value['oldfile']);
					$newvalue = array(
						'savename' => $uploadValue[0]['selfname'],
						'filename' => $uploadValue[0]['filename'],
						'size' => $uploadValue[0]['size'],
						'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
					);
				}
				else
				{
					$newvalue = array(
						'savename' => $value['selfname'],
						'filename' => $value['filename'],
						'size' => $value['size'],
						'src' => $value['src'],
					);
				}	
				
			}
			else
			{
				$newvalue = array();
				if(isset($value['selfname'])&&$value['selfname'])
				{		
					$uploadValue = mouploadAccessory(array('file'=>array($value),'folder'=>'content'));
					$newvalue = array(
							'savename' => $uploadValue[0]['selfname'],
							'filename' => $uploadValue[0]['filename'],
							'size' => $uploadValue[0]['size'],
							'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
					);						
			
				}
			}			
		    if(!empty($newvalue))
			{
				$tempvalue = json_encode($newvalue);
			}
					
		}		
		return $tempvalue;
	}
	/**
	 * 多附件
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function files($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
	   $tmpvalue = '';
		$newvalue = array();
	    if(!empty($value))
		{
			foreach($value as $key=>$val)
			{
				if(isset($val['oldfile']))
			    {
			    	if(!isset($val['src']))
					{
						@unlink(DIR_UPLOADFILE.$val['oldfile']);
					}
					else
					{
						$newvalue[] = array(
							'savename' => $val['selfname'],
							'filename' => $val['filename'],
							'size' => $val['size'],
							'src' => $val['src'],
						);
					}
				}
				else
				{
					if(isset($val['selfname'])&&$val['selfname'])
					{					
						$uploadValue = mouploadAccessory(array('file'=>array($val),'folder'=>'content'));
						$newvalue[] = array(
								'savename' => $uploadValue[0]['selfname'],
								'filename' => $uploadValue[0]['filename'],
								'size' => $uploadValue[0]['size'],
								'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
						);
					}
				}
			}	

			if(!empty($newvalue))
			{
				$tmpvalue = json_encode($newvalue);
			}
		}
		return $tmpvalue;
	}
	/**
	 * 多图
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function images($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
	   $tmpvalue = '';
		$newvalue = array();
	    if(!empty($value))
		{
			foreach($value as $key=>$val)
			{
				if(isset($val['oldfile']))
			    {
			    	if(!isset($val['src']))
					{
						@unlink(DIR_UPLOADFILE.$val['oldfile']);
					}
					else
					{
						$newvalue[] = array(
							'savename' => $val['selfname'],
							'filename' => $val['filename'],
							'size' => $val['size'],
							'src' => $val['src'],
							'alt' => $val['alt'],
						);
					}
				}
				else
				{
					if(isset($val['selfname'])&&$val['selfname'])
					{					
						$uploadValue = mouploadAccessory(array('file'=>array($val),'folder'=>'content'));
						$newvalue[] = array(
								'savename' => $uploadValue[0]['selfname'],
								'filename' => $uploadValue[0]['filename'],
								'size' => $uploadValue[0]['size'],
								'src' => $uploadValue[0]['folder'].'/'.$uploadValue[0]['path'],
								'alt' => $uploadValue[0]['alt'],
						);
					}
				}
			}	

			if(!empty($newvalue))
			{
				$tmpvalue = json_encode($newvalue);
			}
		}
		return $tmpvalue;
	}
	/**
	 * 时间
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function datetime($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		$value = $value ? strtotime($value) : time();
		return $value;
	}
	/**
	 * 联动菜单
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function linkage($value)
	{
		$value = !empty($value) ? implode(';',array_filter($value)) : '';
		return $value;
	}
	/**
	 * 栏目
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function categoryid($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return intval($value);
	}
	/**
	 * 标题
	 */
	public function title($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 标题
	 */
	public function keywords($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 标题
	 */
	public function description($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 标题-seo-meta
	 */
	public function seotitle($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 关键词-seo-meta
	 */
	public function seokeywords($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 描述-seo-meta
	 */
	public function seodescription($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return $value;
	}
	/**
	 * 排序选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function sorttype($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return intval($value);
	}
	/**
	 * 选择模板
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function template($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return trim($value);
	}
	/**
	 * 阅读权限
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function readpower($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		if($value) $value = implode(';',$value);
		return $value;
	}
	/**
	 * 评论选项
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function allowcomment($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return intval($value);
	}
	/**
	 * 发布选项
	 * @param string $value     字段值，没有的话取默认值
	 */
	public function publishopt($value,$minlength,$maxlength,$pattern,$errortips,$name)
	{
		return intval($value);
	}


}