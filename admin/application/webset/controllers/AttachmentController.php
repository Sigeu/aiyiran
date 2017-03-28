<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AttachmentController.php
 *
 * 网站管理——附件设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   AttachmentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class AttachmentController extends AdminController
{
    private $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 附件设置
	 */

    public function indexAction()
    {
        $attachment = $this->SystemModel->getSystemParameterSet(3);
        $this->assign('attach', $attachment);
        $this->display('webset/system/attachment');
    }

    //更新附件设置参数
    public function reviseAttachmentAction()
    {
        $row['mo_ddimg_height']   = empty($_POST['mo_ddimg_height']) ? '' : $_POST['mo_ddimg_height'];
        $row['mo_ddimg_width']    = empty($_POST['mo_ddimg_width']) ? '' : $_POST['mo_ddimg_width'];
        $row['mo_picturetype']    = empty($_POST['mo_picturetype']) ? '' : $_POST['mo_picturetype'];
        $row['mo_filetype']       = empty($_POST['mo_filetype']) ? '' : $_POST['mo_filetype'];
        $row['mo_mediatype']      = empty($_POST['mo_mediatype']) ? '' : $_POST['mo_mediatype'];
        $row['mo_addon_num']      = empty($_POST['mo_addon_num']) ? '' : $_POST['mo_addon_num'];
        $row['mo_album_row']      = empty($_POST['mo_album_row']) ? '' : $_POST['mo_album_row'];
        $row['mo_album_col']      = empty($_POST['mo_album_col']) ? '' : $_POST['mo_album_col'];
        $row['mo_album_style']    = empty($_POST['mo_album_style']) ? '' : $_POST['mo_album_style'];
        $row['mo_max_face']       = empty($_POST['mo_max_face']) ? '' : $_POST['mo_max_face'];
        $row['mo_addon_savetype'] = empty($_POST['mo_addon_savetype']) ? '' : $_POST['mo_addon_savetype'];
        $this -> SystemModel -> updateParameter($row);
        admin_log('附件设置', "修改附件参数");  //添加日志
        $this->dialog('/webset/Attachment/index','success','操作成功！');
    }




}