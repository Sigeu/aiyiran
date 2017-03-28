<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * RemindController.php 提醒设置
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>   2013-03-4 11:31
 * @filename   RemindController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class RemindController extends AdminController
{
    /**
	 * 提醒设置
	 *
	 */
    public function indexAction()
    {
		//提交设置更改
		if(!empty($_POST))
		{
			//提醒方式
			$seting['mo_notice_type'] = (isset($_POST['mo_notice_type']) && intval($_POST['mo_notice_type'])) ? intval($_POST['mo_notice_type']) : 2 ;
			$this->getSystemModel()->updateParameter($seting);

			//模板启用状态
			$this -> getRemindModel() -> update(array(),array('remind_type'=>$seting['mo_notice_type'],'status'=>2));
			if(isset($_POST['remind_type']) && !empty($_POST['remind_type']))
			{
				foreach ($_POST['remind_type'] as $key => $val )
				{
					$this -> getRemindModel() -> update(array('id'=>$key),array('status'=>$val));
				}
			}
			admin_log('修改提醒设置', '修改了提醒设置');
			$this->dialog('/webset/remind/index','success','操作成功！');
		}

		$parameter = $this->getSystemModel()->getSystemParameterSet(8);
		$remind_type = array(
			array('name'=>'右下角弹框','value'=>'1'),
            array('name'=>'站内信','value'=>'2'),
			array('name'=>'电子邮件','value'=>'3'),
		);

		$remind_tpl = $this -> getRemindModel() -> findAll();
		$this -> assign('remind_type',$remind_type);
		$this -> assign('parameter', $parameter);
		$this -> assign('remind_tpl', $remind_tpl);
        $this -> display('webset/others/webset_remind_index');
    }

	/**
	 * 提醒内容模板
	 *
	 */
    public function tplAction()
    {
		$remind_tpl = $this -> getRemindModel() -> findAll();
		$this -> assign('remind_tpl', $remind_tpl);
        $this->display('webset/others/webset_remind_tpl');
    }

	/**
	 * 模板修改
	 */
	public function editAction ()
	{
		//提交修改
		if(!empty($_POST))
		{
			$id = isset($_POST['id']) ? $_POST['id'] : 0 ;
			$info['created'] = time() ;
			$this -> getRemindModel() -> update(array('id'=>$id),$info);//跟新基本信息
			MoFile::write(DIR_VIEW.$_POST['tpl_path'],$_POST['content']);//写模板文件

			$tpl = $this -> getRemindModel() -> find(array('id'=>$id));
			admin_log('修改提醒设置的模板', '修改了模板文件:'.$tpl['tpl_name'].'模板');
			exit();
			//$this->dialog('/webset/remind/edit/id/'.$id,'success','修改成功！');
		}

		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : 0 ;
		$info = $this -> getRemindModel() -> find(array('id'=>$id));
		$content = MoFile::read(DIR_VIEW.$info['tpl_path']);
		$this -> assign('info',$info);
		$this -> assign('content',$content);
		$this->display('webset/others/webset_remind_edit');
	}

	/**
	 * 获取系统设置model
	 */
	function getSystemModel ()
	{
		return D('SystemModel');
	}

	/**
	 * 提醒模板model
	 */
	function getRemindModel ()
	{
		return D('RemindModel');
	}

}