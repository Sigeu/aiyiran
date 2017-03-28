<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * NoticeteController.php
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   NoticeController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class NoticeController extends AdminController
{
    public $SystemModel;
	public function init ()
	{
		$this->SystemModel = D('SystemModel');
	}

    //提醒设置
    public function indexAction()
    {
        $parameter = $this->SystemModel->getSystemParameterSet(8);
        $this->assign('parameter', $parameter);
        $this->display('webset/others/notice_index');
    }
    /* 修改设置 */
    public function correctAction()
    {
        $arr['mo_notice_type']     = empty($_POST['mo_notice_type']) ? '' : $_POST['mo_notice_type'];
        $arr['mo_notice_login']    = empty($_POST['mo_notice_login']) ? '' : $_POST['mo_notice_login'];
        $arr['mo_notice_update']   = empty($_POST['mo_notice_update']) ? '' : $_POST['mo_notice_update'];
        $arr['mo_notice_password'] = empty($_POST['mo_notice_password']) ? '' : $_POST['mo_notice_password'];
        $arr['mo_notice_deadline'] = empty($_POST['mo_notice_deadline']) ? '' : $_POST['mo_notice_deadline'];

        $this->SystemModel->updateParameter($arr);
        $this->dialog('/webset/notice/index','success','操作成功！');
    }

    /* 提醒内容模板 */
    public function noticeTemplateAction()
    {
        $this->display('webset/others/notice_template');
    }


}