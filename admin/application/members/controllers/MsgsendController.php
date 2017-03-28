<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 会员管理 站内信 发送站内信
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-4 15:27 创建此文件
 * <br>雷少进  2013-02-1 15:27 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   MsgsendController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class MsgsendController extends AdminController
{
	/*
	 * 发送站内信
	 *
	 */
	public function indexAction ()
	{
		$levelid = isset($_GET['levelid']) ? intval($_GET['levelid']) : 0 ;
		$member_list = array();
		if($levelid)
			$member_list = $this -> getMemberModel() -> findAll(array('levelid'=>$levelid),false,'id,username');

		$group = $this -> getMemberGroupModel() -> getGroupCacheList();
		$temp = array();
		foreach ($group as $key => $val )
		{
			$temp[] = array('id'=>$key,'name'=>$val,'level'=>$this -> getMemberLevelModel()->getLevelListByGroupId($key));
		}

		$this -> assign('group',$temp);
		$this -> assign('act',isset($_GET['act']) ? $_GET['act'] : '');
		$this -> assign('member_list',$member_list);
		$this -> assign('levelid',$this -> get('levelid',0));
		$this -> display('members/msg/members_msgsend_index');
	}

	/**
	 * 发送站内信
	 */
	public function sendAction ()
	{
		//接参数
		$userinfo = $_SESSION['userinfo'];        //用户登陆信息
		$title    = $this -> post('title','');    //主题
		$sendtype = $this -> post('sendtype',''); //发送方式
		$group    = isset($_POST['group']) ? $_POST['group'] : array() ; //群组ID
		$member   = $this -> post('members','');  //会员名
		$content  = $this -> post('content');     //发送内容
		if(empty($title)) $this -> dialog('/members/msgsend/index','error','主题不能为空');
		//if(empty($content)) $this -> dialog('/members/msgsend/index','error','内容不能为空');

		//查询收信人
		$member_list = array();
        if($sendtype == 'group')
		{
			if(empty($group)) $this -> dialog('/members/msgsend/index','error','请选择会员组');
			$member_list = $this ->getMemberModel() -> getMemberByGroupOrLevel($group);
		}
		else if ($sendtype == 'member')
		{
			if(empty($member)) $this -> dialog('/members/msgsend/index','error','请指定会员名');
			$member_list = $this ->getMemberModel() -> getMemberByNames($member);
		}

		if(!empty($member_list))
		{
			//站内信入库
			$msg_id = $this -> getMsgMessageModel() -> create(array('title'=>$title,'content'=>$content,'created'=>time()));
			//分发到个人
			$this -> getMsgRelationModel() -> sendMsgToPerson($member_list,$msg_id);
		}
		else
		{
			$this -> dialog('/members/msgsend/index','info','发送失败，没有符合条件的会员');
		}
		$this -> dialog('/members/msgoutbox/index');
	}

	/**
	 * 再次发送站内信
	 */
	public function againsendAction ()
	{
		$userinfo = $_SESSION['userinfo'];//用户登陆信息
		$recipients = $this -> post('recipients');//收件人ID
		$title = $this -> post('title');
		$content = $this -> post('content');
		$msg_id = $this -> getMsgMessageModel() -> create(array('title'=>$title,'content'=>$content,'created'=>time()));
		$this -> getMsgRelationModel() -> create(array(
			'msgid'         =>$msg_id,
			'recipients'    =>$recipients,
			'senderid'      =>$userinfo['id'],
			'isread'        =>2,
			'isreply'       =>2,
			'recipients_del'=>2,
			'sender_del'    =>2,
			'created'       =>time(),
		));
		$this -> dialog('/members/msgoutbox/index');
	}

	/**
	 * 会员分组model
	 */
	public function getMemberGroupModel ()
	{
		return D('MemberGroupModel');
	}
	/**
	 * 会员级别表model
	 */
	public function getMemberLevelModel ()
	{
		return D('MemberLevelModel');
	}

	/**
	 * 站内信  信息表 model
	 */
	public function getMsgMessageModel ()
	{
		return D('MsgMessageModel');
	}

	/**
	 * 会员表model
	 */
	public function getMemberModel ()
	{
		return D('MemberModel');
	}

	/**
	 * 站内信关系对照model
	 */
	public function getMsgRelationModel ()
	{
		return D('MsgRelationModel');
	}
}