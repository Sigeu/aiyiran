<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 会员管理 站内信 收件箱
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-4 10:05 创建此文件
 * <br>雷少进  2013-01-4 10:05 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   MsginboxController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class MsginboxController extends AdminController
{
	/*
	 * 收件箱列表
	 *
	 */
	public function indexAction ()
	{
		$search['title'] = isset($_POST['title']) ? $_POST['title'] : (isset($_GET['title']) ? $_GET['title'] : '' );
		$search['start'] = isset($_POST['start']) ? $_POST['start'] : (isset($_GET['start']) ? $_GET['start'] : '' );
		$search['end']   = isset($_POST['end']) ? $_POST['end'] : (isset($_GET['end']) ? $_GET['end'] : '' );
		$search['isreply']   = isset($_POST['isreply']) ? $_POST['isreply'] : (isset($_GET['isreply']) ? $_GET['isreply'] : '' );
		$search['isread']   = isset($_POST['isread']) ? $_POST['isread'] : (isset($_GET['isread']) ? $_GET['isread'] : '' );

		$list = $this -> getMsgRelationModel() -> getInMsg($search);
		$this -> assign('plist',$list);
		$this -> assign('search',$search);
		$this -> display('members/msg/members_msginbox_index');
	}

	/**
	 * 删除收件箱
	 */
	 function delAction ()
	 {
		$userinfo = $_SESSION['userinfo'];//用户登陆信息
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : (isset($_POST['id']) ? implode(',',$_POST['id']) : 0) ;
		$this -> getMsgRelationModel() -> update(array('recipients'=>$userinfo['id'],'in'=>array('id'=>$id)),array('recipients_del'=>1));
		$where = array(
			'in'=>array('id'=>$id),
			'senderid'=>$userinfo['id'],
			'sender_del'=>1,
			'recipients_del'=>1);
		$this -> getMsgRelationModel() -> delete($where);

		$msg_id = $this ->getMsgRelationModel() -> getMsgIdByRelation($id);
		$msg = $this ->getMsgMessageModel()->findAll(array('in'=>array('id'=>implode(',',$msg_id))));
		foreach ($msg as $key => $val)
		{
			admin_log('站内信收件箱', '删除了收件箱站内信:'.$val['title']);
		}

		$this -> getMsgRelationModel() -> clearRubbishMsg();
		$this -> dialog('/members/msginbox/index');
	 }

	/**
	 * 站内信关系对照表 model
	 */
	public function getMsgRelationModel ()
	{
		return D('MsgRelationModel');
	}

	/**
	 * 站内信表 model
	 */
	public function getMsgMessageModel ()
	{
		return D('MsgMessageModel');
	}
}