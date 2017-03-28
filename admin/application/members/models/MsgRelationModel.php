<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MsgRelationModel.php
 *
 * 站内信关系表
 *
 * @author     雷少进<leishaojin@mail.b2b.cn>   2013-01-31 16:14
 * @filename   MsgInboxModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class MsgRelationModel extends Model
{
	public $pk = "id";
	public $tableName = "msg_relation";

	function sendMsgToPerson ($person,$msg_id)
	{
		$userinfo = $_SESSION['userinfo'];//用户登陆信息
        $sql = 'INSERT INTO `'.$this -> trueTableName.'` (`msgid`,`recipients`,`senderid`,`isread`,`isreply`,`recipients_del`,`sender_del`,`created`) VALUES ';
		$info = array();
		foreach ($person as $key => $val )
		{
			$info[] = '('.$msg_id.','.$val['id'].','.$userinfo['id'].',2,2,2,2,'.time().')';
		}

		//分页进行发送
		$page_size = 1000;                   //一次发送多少条
		$count = count($info);
		$pages = ceil($count/$page_size); //分几次发送
		$page = 1;
		$from = ($page-1)*$page_size;
		for ($i=0;$i<$pages;$i++)
		{
			$s_arr = array_slice($info,$from,$page_size,true);
			$page +=1;
			$from = ($page-1)*$page_size;
			$this -> query($sql.implode(',',$s_arr));
			//echo $sql.implode(',',$s_arr);echo '<br />';
		}
		return true;
	}

	function getOutMsg ($search)
	{
		foreach ($search as $key => $val )
			$search[$key] = filterBadStr($val);

		$userinfo = $_SESSION['userinfo'];//用户登陆信息
		$sql = 'SELECT mr.*,m.username,mm.title FROM `'.$this -> trueTableName.'` AS mr LEFT JOIN `'.$this -> tablePrefix.'member` AS m ON mr.recipients = m.id LEFT JOIN `'.$this -> tablePrefix.'msg_message` AS mm ON mr.msgid = mm.id WHERE mr.senderid = \''.$userinfo['id'].'\' AND `sender_del` = 2';
		if($search['title'])
			$sql .= ' AND mm.title LIKE \'%'.$search['title'].'%\' ';
		if($search['start'])
			$sql .= ' AND mr.created >= \''.strtotime($search['start']).'\' ';
		if($search['end'])
			$sql .= ' AND mr.created <= \''.strtotime($search['end']).'\' ';
	  	$sql .= ' ORDER BY mr.created DESC';
		return $this -> getPageList(array('sql'=>$sql,'search'=>$search));
	}

	function getInMsg ($search)
	{
		foreach ($search as $key => $val )
			$search[$key] = filterBadStr($val);

		$userinfo = isset($_SESSION['userinfo']) ? $_SESSION['userinfo'] : array();//用户登陆信息
		if(empty($userinfo))
			return array();
		$sql = 'SELECT mr.*,m.username,mm.title FROM `'.$this -> trueTableName.'` AS mr LEFT JOIN `'.$this -> tablePrefix.'member` AS m ON mr.recipients = m.id LEFT JOIN `'.$this -> tablePrefix.'msg_message` AS mm ON mr.msgid = mm.id WHERE mr.recipients = '.$userinfo['id'].' AND `recipients_del` = 2';
		if($search['title'])
			$sql .= ' AND mm.title LIKE \'%'.$search['title'].'%\' ';
		if($search['start'])
			$sql .= ' AND mr.created >= '.strtotime($search['start']).' ';
		if($search['end'])
			$sql .= ' AND mr.created <= '.strtotime($search['end']).' ';
		if($search['isreply'])
			$sql .= ' AND mr.isreply = '.$search['isreply'].' ';
		if($search['isread'])
			$sql .= ' AND mr.isread = '.$search['isread'].' ';
	 	$sql .= ' ORDER BY mr.created DESC';
		return $this -> getPageList(array('sql'=>$sql,'search'=>$search));
	}

	/**
	 * 随机清理一下站内信垃圾信息。
	 */
	function clearRubbishMsg ()
	{
		//20%的几率清理一下站内信垃圾信息。
		if(percentDoAction(20))
		{
			$this -> query('DELETE FROM `'.$this -> tablePrefix.'msg_message` WHERE `id` NOT IN (SELECT DISTINCT `msgid` FROM `'.$this -> trueTableName.'`)');
		}
	}

	function getOneOutMsg ($id)
	{
		$userinfo = $_SESSION['userinfo'];//用户登陆信息
		$res = $this -> query('SELECT mm.title,m.username,mr.recipients,mm.content,mr.created FROM `'.$this -> trueTableName.'` AS mr LEFT JOIN `'.$this -> tablePrefix.'msg_message` AS mm ON mr.msgid = mm.id LEFT JOIN `'.$this -> tablePrefix.'member` AS m ON m.id = mr.recipients WHERE mr.`id` = '.$id.' AND `sender_del`=2 AND `senderid` = '.$userinfo['id']);
		return isset($res[0]) ? $res[0] : array();
	}

	/**
	 * 根据关系表ID获取站内信息的ID
	 * @param ids or array
	 * @return array()
	 */
	function getMsgIdByRelation ($ids)
	{
		$msg_id = array(0);
		if($ids)
		{
			if(is_array($ids) && !empty($ids)) $ids = implode(',',$ids);
			$tmp = $this -> findAll(array('in'=>array('id'=>$ids)));
			foreach ($tmp as $key => $val )
			{
				$msg_id[] = $val['msgid'];
			}
		}
		return array_unique($msg_id);
	}
}