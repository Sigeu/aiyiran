<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 异常处理
 *  
 * 文件修改记录：
 * <br>周立峰  2012-12-19 下午3:24:46 创建此文件 
 * 
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-19 下午3:24:46
 * @filename   SysException.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: SysException.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */
class SysException extends \Exception {
	//TODO - Insert your code here

	/**
	 * 异常构造函数
	 * 
	 * @param  message 抛出的异常消息内容	
	 * @param  code 异常代码
	 * @param  previous  异常链中的前一个异常
	 */
	public function __construct($message = null, $code = null, $previous = null) {
		parent::__construct($message = null, $code = null, $previous = null);
		//TODO - Insert your code here
	}
	
	/* (non-PHPdoc)
	 * @see Exception::__toString()
	 */public function __toString() {
	    return "exception '".__CLASS__ ."' with message '".$this->getMessage()."' in ".$this->getFile().":".$this->getLine()."\nStack trace:\n".$this->getTraceAsString();
	}

}

