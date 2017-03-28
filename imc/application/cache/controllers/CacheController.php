<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 缓存更新
 *  
 * 文件修改记录：
 * <br>周立峰  2013-3-14 下午3:41:00 创建此文件 
 * 
 * @author     周立峰 <zhoulifeng@mainone.cn>  2013-3-14 下午3:41:00
 * @filename   CacheController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: CacheController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    
 * @since      1.0.0
 */
class CacheController extends AdminController {
	
	public function init()
	{
		parent::islogin_imc();
		parent::init();
	}
	/**
	 * 缓存更新
	 *
	 * @access public
	 * @return string
	 */
	public function indexAction() {
	
		$this->assign('title', '缓存更新');
		$this->display('cache/cache_index');
	
	}
	
	/**
	 * 更新操作
	 *
	 * @access public
	 * @return string
	 */
	public function updateAction() {
	
		imc_log("缓存更新","缓存成功更新");
//		echo $_SESSION["userinfo_imc"]["username"]."用户对缓存成功更新";
		$this->assign('title', '缓存更新');
		$this->assign('param.type', 'success');
		$this->assign('param.url', '/cache/cache/index');
		$this->dialog('/cache/cache/index');
	}
	
}
