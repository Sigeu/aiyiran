<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * PayController.php
 *
 * 系统扩展——支付工具
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   PayController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class PayController extends AdminController
{
    private $PayModel;
	public function init ()
	{
		$this->PayModel = D('PayModel');
	}

    //支付工具
    public function indexAction()
    {
        $list = $this->PayModel->select();
		$this->assign('list',$list);
        $this->display('webset/others/pay');
    }



}