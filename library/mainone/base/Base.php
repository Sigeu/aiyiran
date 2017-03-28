<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 基类
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-12 下午3:17:53 创建此文件
 * <br>雷少进  2013-07-02 下午14:26:10 修改此文件
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-12 下午3:17:53
 * @filename   Base.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: Base.php 11 2013-08-09 07:40:20Z zhoulifeng $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('Deny access');
abstract class Base extends stdClass
{
    /**
     * 自动变量设置
     *
     * 程序运行时自动完成类中作用域为protected及private的变量的赋值 。
     *
     * @access public
     * @param string $name 属性名
     * @param string $value 属性值
     * @return void
     */
    public function __set($name, $value)
	{
        if (property_exists($this, $name))
		{
             $this->$name = $value;
        }
     }

     /**
      * 自动变量获取
      *
      * 程序运行时自动完成类中作用域为protected及private的变量的获取。
      *
      * @access public
      * @param string $name 属性名
      * @return mixed
      */
	public function __get($name)
	{
		return isset($this->$name) ? $this->$name : false;
	}

	/**
	 * 函数: __call()
	 *
	 * 用于处理类外调用本类不存在的方法时的信息提示
	 *
	 * @access public
	 * @param string $method 方法名称
	 * @param string $args   参数名称
	 * @return string
	 */
	public function __call($method, array $args)
	{
		echo 'Method:'.$method.'() is not exists in Class:'.get_class($this).'!<br/>The args is:<br/>';
		foreach ($args as $value)
		{
			echo $value, '<br/>';
		}
	}

	/**
	 * 返回类信息
	 *
	 * @access public
	 * @return string
	 */
	public function __toString()
	{
		return (string)'This is '.get_class($this).' Class!';
	}
}