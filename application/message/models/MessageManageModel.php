<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MessageManageModel.php
 *
 * 前台留言模型
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>  2013-07-15 16:30
 * @filename   MessageManageModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.izhancms.com)
 * @license    http://www.izhancms.com
 * @version    izhanCMS 1.0
 *-------------------------------------------------------------------------------------
 */
class MessageManageModel extends Model
{
	public $tableName = 'message_manage';

	/**
	 * 获取留言回复信息
	 * @param 扩展表的表ID即 typeid
	 * @param 扩展表信息的主键ID
	 * @return 一维array 留言信息
	 */
	function getMessageMainInfoById ($typeid,$msg_id)
	{
		$sql = 'SELECT * FROM `'.$this -> tablePrefix.'message_manage` WHERE (`typeid`='.$typeid.') AND (`message_id` = '.$msg_id.')';
		$info = $this ->query($sql);
		if(!empty($info) && is_array($info))
		{
			$info = current($info);
			$replyer = $this ->getReplyerInfoById($info['replymember']);
			$info['replyer'] =isset($replyer['username']) ? $replyer['username'] : '';
		}
		else
		{
			$info = array();
		}
		return  $info;
	}

	/**
	 * 获取后台用户的信息
	 * @param主键ID
	 * @return array()
	 */
	function  getReplyerInfoById ($id)
	{
		$sql = 'SELECT * FROM `'.$this -> tablePrefix.'admin` WHERE id = '.$id.'';
		$info = $this ->query($sql);
		return !empty($info) && is_array($info) ? current($info) : array();
	}

	/**
	 * 获取留言扩展表信息
	 * @param 扩展表的表ID即 typeid
	 * @param 扩展表信息的主键ID
	 * @return array()
	 */
	function getMessageExtInfo ($typeid,$msg_id)
	{
		$table = $this -> tablePrefix.'message_'.$typeid;//扩展表 表名
		$sql = 'SELECT * FROM `'.$table.'` WHERE `id`='.$msg_id.'';
		$info = $this ->query($sql);
		return !empty($info) && is_array($info) ? current($info) : array();
	}
}