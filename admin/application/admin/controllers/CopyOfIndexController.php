<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * IndexController.php  后台首页控制器类
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-21 上午11:19:11
 * @filename   IndexController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class IndexController extends CommonController {

	public function init()
	{
		parent::init();
	}
	public function indexAction() {

	    //parse login status
	    $this->parse_login();


		//display page
		$this->display();
	}

	public function phpinfoAction() {

	    //parse login status
	    $this->parse_login();

		phpinfo();
	}
}