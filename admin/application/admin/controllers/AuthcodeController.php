<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * LoginController.php
 *
 * 后台会员登录、退出、修改密码
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-15 上午11:48:40
 * @filename   LoginController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class AuthcodeController extends AdminController
{
	/**
	 * 用户登录
	 */
	public function indexAction()
	{
		$this -> createAuthCode();
	}
}